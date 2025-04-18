<?php

namespace App\Http\Controllers\Admin\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\Admin\SendOtpNotify;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ForgetPasswordController extends Controller
{
    //
    public $otp;
    public function __construct(){
        $this->otp = new Otp();
    }
    public function showEmailForm(){
        return view('dashboard.auth.password.email');
    }

    public function sendOtp(Request $request){
        $request->validate(['email' => ['required' , 'email']]);
        $admin = Admin::where('email', $request->email)->first();
        if(!$admin){
            return redirect()->back()->withErrors(['email' => 'Try Again Later!']);
        }
        $admin->notify(new SendOtpNotify());
        return redirect()->route('admin.password.confirm' , ['email' => $admin->email]);
    }

    public function confirm($email){
        return view('dashboard.auth.password.confirm' , compact('email'));
    }

    public function verify(Request $request){
        $request->validate([
            'token' => ['required' , 'digits:5'],
            'email' => ['required' , 'email'],
        ]);

        $otp = $this->otp->validate($request->email , $request->token);
        if($otp->status == false){
            return redirect()->back()->withErrors(['token' => 'Code is not valid']);
        }
        return view('dashboard.auth.password.reset' , [ 'email' => $request->email ]);
    }

    
}
