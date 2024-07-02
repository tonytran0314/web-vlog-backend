<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CategoryResource;
use App\Http\Resources\v1\VlogResource;
use App\Models\Category;
use App\Models\Vlog;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    // find the way to declare once but use many times
    protected $vlogsPerFeature = 8;
    protected $vlogsPerPage = 24;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Return vlogs by category
     */
    public function show(string $slug)
    {
        $category = Category::slug($slug)->firstOrFail();
        $vlogsByCategory = $category->vlogs()->paginate($this->vlogsPerPage);
        if ($vlogsByCategory->isEmpty()) {
            throw new ModelNotFoundException();
        }
        $currentPage = $vlogsByCategory->currentPage();
        $lastPage = $vlogsByCategory->lastPage();

        $params = [
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
        ]; 
        
        $links = customLinks($params);

        return response()->json([
            'data' => VlogResource::collection($vlogsByCategory),
            'header' => $category->name,
            'pagination' => [
                'currentPage' => $currentPage,
                'totalPages' => $lastPage,
                'totalVlogs' => $vlogsByCategory->total(),
                'links' => $links
            ]
        ]);
    }

    public function getFeaturedVlogsByCategory (string $slug) {
        $category = Category::slug($slug)->firstOrFail();
        $featuredVlogsByCategory = $category->vlogs()->take($this->vlogsPerFeature)->get();

        return VlogResource::collection($featuredVlogsByCategory);
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
