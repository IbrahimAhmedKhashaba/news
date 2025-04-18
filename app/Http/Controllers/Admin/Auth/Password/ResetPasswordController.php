<?php

namespace App\Http\Controllers\Admin\Auth\Password;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ResetPasswordController extends Controller
{
    //

    public function updatePassword(Request $request){
        $request->validate([
            'email' => ['required' , 'email'],
            'password' => ['required' , 'confirmed' , 'min:8'],
        ]);

        $admin = Admin::where('email' , $request->email)->first();
        $admin->update(['password' => bcrypt($request->password)]);
        Session::flash('success' , 'Password updated successfully');
        return redirect()->route('admin.login.show');
    }

}
