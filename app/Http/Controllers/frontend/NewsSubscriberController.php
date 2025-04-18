<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Mail\frontend\NewSubscriberMail;
use App\Models\NewsSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class NewsSubscriberController extends Controller
{
    //
    public function store(Request $request){
        $request->validate([
            'email' => 'required|email|unique:news_subscribers,email'
        ]);
        $subscriber = NewsSubscriber::create([
            'email' => $request->email,
        ]);
        if(!$subscriber){
            Session::flash('error', 'please try again later.');
            return redirect()->back();
        }
        Mail::to($request->email)->send(new NewSubscriberMail());
        Session::flash('success', 'Thank you for subscribing to our newsletter.');
        return redirect()->back();
    }
}
