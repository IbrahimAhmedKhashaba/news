<?php

namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\Contact\ContactResource;
use App\Models\Admin;
use App\Models\Contact;
use App\Notifications\NewContactNotify;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    //
    use ApiResponseTrait;
    public function store(ContactRequest $request){
        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'title' => $request->title,
            'body' => $request->body,
            'ip_address' => $request->ip(),
        ]);
        if(!$contact){
            return $this->apiResponse(null , 'Something is wrong, Try again later' , 401);
        }

        $admins = Admin::whereHas('authorization', function ($query) {
            $query->where('permissions', 'LIKE' , '%contacts%');
        })->get();

        Notification::send($admins, new NewContactNotify($contact));

        return $this->apiResponse(new ContactResource($contact) , 'Message sent successfully' , 201);
    }
}
