<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\UserCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_name' => $this->whenLoaded('user', function () {
                return $this->user->name;
            }),
            'user_image' => $this->whenLoaded('user', function () {
                return $this->user->image;
            }),
            'comment' => $this->comment,
        ];
    }
}
