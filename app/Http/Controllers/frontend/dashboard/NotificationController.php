<?php

namespace App\Http\Controllers\frontend\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    //
    public function index(){
        $user = User::find(auth()->user()->id);
        $user->unreadNotifications->markAsRead();
        return view('frontend.dashboard.notification' , compact('user'));
    }

    public function delete(Request $request , $id){
        auth()->user()->notifications()->where('id' , $id)->delete();
        Session::flash('success', 'Notification deleted successfully');
        return redirect()->back();
    }

    public function deleteAll(){
        auth()->user()->notifications()->delete();
        Session::flash('success', 'All notifications deleted successfully');
        return redirect()->back();
    }
    public function markAllAsRead(){
        auth()->user()->notifications->markAsRead();
        Session::flash('success', 'All notifications Marked As Read successfully');
        return redirect()->back();
    }
}
