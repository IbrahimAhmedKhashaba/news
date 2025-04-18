<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Jobs\NewContactJob;
use App\Models\Admin;
use App\Models\Contact;
use App\Notifications\NewContactNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    //
    public function index(){
        return view('frontend.contact');
    }

    public function store(ContactRequest $contactRequest){
        $contact = Contact::create([
            'name' => $contactRequest->name,
            'email' => $contactRequest->email,
            'phone' => $contactRequest->phone,
            'title' => $contactRequest->title,
            'body' => $contactRequest->body,
            'ip_address' => $contactRequest->ip(),
        ]);

        $admins = Admin::whereHas('authorization', function ($query) {
            $query->where('permissions', 'LIKE' , '%contacts%');
        })->get();

        Notification::send($admins, new NewContactNotify($contact));
        // NewContactJob::dispatch($contact);

        if(!$contact){
            Session::flash('error', 'Contact us failed');
        } else{
            Session::flash('success', 'Contact sent successfully');
        }
        return view('frontend.contact');
    }
}
