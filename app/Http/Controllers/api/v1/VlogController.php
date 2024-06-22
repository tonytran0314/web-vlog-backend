<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\VlogResource;
use Illuminate\Http\Request;

use App\Models\Vlog;

class VlogController extends Controller
{
    protected $numberOfLatestVlogs = 4;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return VlogResource::collection(Vlog::all());
    }

    public function getLatestVlogs() {
        $latestVlogs = Vlog::latest()
                            ->take($this->numberOfLatestVlogs)
                            ->get();

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
