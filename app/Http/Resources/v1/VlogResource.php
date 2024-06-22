<?php

namespace App\Http\Resources\v1;

use App\Models\Vlog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'public' => $this->public,
            'date' => $this->created_at,
            'categories' => CategoryResource::collection(Vlog::find($this->id)->categories)
        ];
    }
}
