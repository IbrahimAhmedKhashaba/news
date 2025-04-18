<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'user_name' => $this->name,
            'status' => $this->status ? 'active' : 'inactive',
            'created_at' => $this->created_at->diffForHumans(),
        ];

        if ($request->is('api/account/user')) {
            $data['username'] = $this->username;
            $data['email'] = $this->email;
            $data['phone'] = $this->phone;
            $data['country'] = $this->country;
            $data['city'] = $this->city;
            $data['street'] = $this->country;
            $data['image'] = asset($this->image);
        }

        return $data;
    }
}
