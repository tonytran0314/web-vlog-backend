<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\VlogResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\HttpResponses;

use App\Models\Vlog;

class VlogController extends Controller
{
    use HttpResponses;

    protected $vlogsPerFeature = 8;
    protected $vlogsPerPage = 24;
    protected $header = 'Tất cả vlogs';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vlogs = Vlog::paginate($this->vlogsPerPage);

        $currentPage = $vlogs->currentPage();
        $lastPage = $vlogs->lastPage();
        
        $params = [
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
        ]; 
        
        $links = customLinks($params);

        return response()->json([
            'data' => VlogResource::collection($vlogs->items()),
            'header' => $this->header,
            'pagination' => [
                'currentPage' => $currentPage,
                'totalPages' => $lastPage,
                'totalVlogs' => $vlogs->total(),
                'links' => $links
            ]
        ]);
    }

    public function getLatestVlogs() {
        $latestVlogs = Vlog::take($this->vlogsPerFeature)->get();

        return VlogResource::collection($latestVlogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $vlog = Vlog::slug($slug)->firstOrFail();
        return new VlogResource($vlog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function video($filename) {
        $path = storage_path('app/public/'.$filename);
        
        if(!file_exists($path)) {
            abort(404);
        }

        $response = response()->file($path, [
            'Content-Type' => mime_content_type($path),
            'Content-Length' => filesize($path),
            'Accept-Ranges' => 'bytes',
        ]);
        return $response;
    }
}
