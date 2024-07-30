<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CategoryRequest;
use App\Http\Resources\v1\CategoryResource;
use App\Http\Resources\v1\VlogResource;
use App\Models\Category;
use App\Models\Vlog;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use HttpResponses;

    // find the way to declare once but use many times
    protected $vlogsPerFeature = 8;
    protected $vlogsPerPage = 24;
    protected $categoriesPerPage = 24;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate($this->categoriesPerPage);

        $currentPage = $categories->currentPage();
        $lastPage = $categories->lastPage();
        
        $params = [
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
        ]; 
        
        $links = customLinks($params);

        return response()->json([
            'data' => CategoryResource::collection($categories->items()),
            'pagination' => [
                'currentPage' => $currentPage,
                'totalPages' => $lastPage,
                'totalCategories' => $categories->total(),
                'links' => $links
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validatedCategory = $request->validated();

        $addedCategory = Category::create($validatedCategory);

        return $addedCategory ? 
            $this->success(new CategoryResource($addedCategory), 'Added Category', 200) : 
            $this->error('Failed to add category', 400);
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
    public function update(CategoryRequest $request, string $id)
    {
        $validatedCategory = $request->validated();

        $category = Category::findOrFail($id);

        $updatedCategory = $category->update($validatedCategory);

        return $updatedCategory ? 
            $this->success(null, 'Updated Category', 200) : 
            $this->error('Failed to update category', 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
