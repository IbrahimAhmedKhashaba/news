<?php

namespace App\Http\Resources\Notificatioin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'username' => $this->data['user_name'],
            'post_title' => $this->data['post_title'],
            'post_slug' => $this->data['post_slug'],
            'comment' => $this->data['comment'],
            'created_at' => $this->created_at->diffForHumans(),
            'read_at' => $this->read_at ? $this->read_at->diffForHumans() : null,
        ];
    }
}
