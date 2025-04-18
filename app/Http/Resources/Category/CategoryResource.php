<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Post\PostCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status ? 'active' : 'inactive',
            'created_at' => $this->created_at->format('Y-m-d'),
            'posts' => new PostCollection($this->whenLoaded('posts')),
        ];

        return $data;
    }
}
