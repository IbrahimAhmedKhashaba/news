<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function show(){
        return view('dashboard.auth.login');
    }

    public function Login(Request $request){
        $request->validate($this->filterData());

        if(!Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password] , true)) {
            return redirect()->back()->with(['error' => 'credentials not match']);
        }
        $permissions = Auth::guard('admin')->user()->authorization->permissions;
        if(!in_array('home' , $permissions)){
            
            return redirect()->intended('admin/'.$permissions[0]);
        }
        return redirect()->intended(RouteServiceProvider::DASHBOARD);
    }

    public function filterData():array{
        return [
            'email' => ['required' , 'email'],
            'password' => ['required' , 'min:8'],
            'remember' => ['in:on,off'],
        ];
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login.show');
    }
}
