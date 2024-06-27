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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vlogs = Vlog::paginate($this->vlogsPerPage);

        $currentPage = $vlogs->currentPage();
        $lastPage = $vlogs->lastPage();
        
        $links = $this->customLinks($currentPage, $lastPage);

        return response()->json([
            'data' => VlogResource::collection($vlogs->items()),
            'pagination' => [
                'currentPage' => $currentPage,
                'total' => $vlogs->total(),
                'links' => $links
            ]
        ]);
    }

    private function customLinks($currentPage, $lastPage) {
        $links = [];
        $startPage = max(1, $currentPage - 2);
        $endPage = min($lastPage, $currentPage + 2);

        $links[] = [
            'url' => $currentPage > 1 ? route('vlogs.index', ['page' => $currentPage - 1]) : null,
            'label' => 'Trang trước',
            'active' => false,
        ];

        for ($page = $startPage; $page <= $endPage; $page++) {
            $links[] = [
                'url' => route('vlogs.index', ['page' => $page]),
                'label' => $page,
                'active' => $page == $currentPage,
            ];
        }

        $links[] = [
            'url' => $currentPage < $lastPage ? route('vlogs.index', ['page' => $currentPage + 1]) : null,
            'label' => 'Trang sau',
            'active' => false,
        ];

        return $links;
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
