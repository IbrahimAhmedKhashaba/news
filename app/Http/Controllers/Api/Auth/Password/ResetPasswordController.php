<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    //
    use ApiResponseTrait;
    public $otp;
    public function __construct(){
        $this->otp = new Otp();
    }
    public function reset(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required|digits:5'
        ]);

        $user = User::whereEmail($request->email)->first();
        if(!$user){
            return $this->apiResponse(null , 'User not found' , 404);
        }

        $otp2 = $this->otp->validate($user->email , $request->token);
        if($otp2->status == false){
            return $this->apiResponse(null , 'Invalid OTP' , null);
        }

        $user->password = bcrypt($request->password);
        $user->save();
        $token = $user->createToken('user_token', [], now()->addMinutes(60))->plainTextToken;
        return $this->apiResponse(['token' => $token] , 'Password reset successfully' , 200);

    }
}
