<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendResetPasswordNotification;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    //
    use ApiResponseTrait;
    public function sendOtp(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::whereEmail($request->email)->first();
        if(!$user){
            return $this->apiResponse(null , 'User not found' , 404);
        }

        $user->notify(new SendResetPasswordNotification());
        return $this->apiResponse(null , 'Check your email for reset password code' , 200);
    }
}
