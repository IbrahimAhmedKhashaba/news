<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\Admin\SendOtpNotify;
use App\Traits\ApiResponseTrait;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    //
    use ApiResponseTrait;
    public $otp;
    public function __construct(){
        $this->otp = new Otp();
    }
    public function verifyEmail(Request $request){
        $request->validate([
            'token' => ['required' , 'digits:5'],
        ]);
        $user = request()->user();
        $otp2 = $this->otp->validate($user->email , $request->token);
        if($otp2->status == false){
            return $this->apiResponse(null , 'Invalid OTP' , null);
        }
        $user->email_verified_at = now();
        $user->save();
        return $this->apiResponse($user , 'Email verified successfully' , null);
    }

    public function resendEmail(){
        $user = request()->user();
        $user->notify(new SendOtpNotify());
        return $this->apiResponse(null , 'OTP sent successfully' , 200);
    }
}
