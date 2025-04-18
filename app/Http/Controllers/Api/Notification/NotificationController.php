<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notificatioin\NotificationResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    use ApiResponseTrait;

    public function index(){
        $user = auth('sanctum')->user();
        
        return $this->apiResponse(NotificationResource::collection($user->notifications) , 200 , 'Notifications retrieved successfully');
    }

    public function delete(Request $request , $id){
        auth('sanctum')->user()->notifications()->where('id' , $id)->delete();
        return $this->apiResponse(null , 200 , 'Notification deleted successfully');
    }

    public function deleteAll(){
        auth('sanctum')->user()->notifications()->delete();
        return $this->apiResponse(null , 200 , 'Notifications deleted successfully');
    }
    public function markAllAsRead(){
        auth()->user()->notifications->markAsRead();
        return $this->apiResponse(null , 200 , 'All notifications Marked As Read successfully');
    }
}
