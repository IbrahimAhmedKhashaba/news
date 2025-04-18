<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Image\ImageCollection;
use App\Http\Resources\Image\ImageResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'num_of_views' => $this->num_of_views,
            'status' => $this->status ? 'active' : 'inactive',
            'images' => new ImageCollection($this->whenLoaded('images')),
        ];
        if($request->is('api/account/user/posts')){
            $data['comments'] = new CommentCollection($this->comments);
        }
        if($request->is('api/posts/show/*')){
            $data['publisher'] = $this->user_id ? UserResource::make($this->user) : 
            AdminResource::make($this->admin);
            $data['category'] = new CategoryResource($this->whenLoaded('category'));
            $data['small_desc'] = $this->small_desc;
            $data['desc'] = $this->desc;
            $data['comments'] = new CommentCollection($this->comments);
            $data['comment_able'] = $this->comment_able ? 'active' : 'inactive';
            $data['created_at'] = $this->created_at->format('y:m:d h:m a');
        }
        return $data;
    }
}
