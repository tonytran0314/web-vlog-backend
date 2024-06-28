<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\VlogResource;
use Illuminate\Http\Request;

use App\Models\Vlog;

class VlogController extends Controller
{
    protected $numberOfLatestVlogs = 8;
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
            // 'path' => 'api/v1/vlogs'
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
        $latestVlogs = Vlog::take($this->numberOfLatestVlogs)->get();

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
    public function show(string $id)
    {
        //
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
}
