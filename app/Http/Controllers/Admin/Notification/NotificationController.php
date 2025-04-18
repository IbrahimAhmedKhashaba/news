<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('can:notifications');
    }
    public function index(){
        $notifications = auth()->user()->notifications;
        auth()->user()->notifications->markAsRead();
        return view('dashboard.notifications.index',compact('notifications'));
    }

    public function destroy($id){
        $notification = auth()->guard('admin')->user()->notifications->find($id);
        $notification->first()->delete();
        return response()->json([
            'success' => 'Notification deleted successfully',
        ]);
    }

    public function deleteAll(){
        auth()->guard('admin')->user()->notifications->each->delete();
        return response()->json([
            'success' => 'All notifications deleted successfully',
        ]);
    }

}
