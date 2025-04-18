<?php

namespace App\Http\Controllers\frontend\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserSettingRequest;
use App\Models\User;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    //
    use UploadImage;
    public function index(){
        $user = auth()->user();
        return view('frontend.dashboard.setting' , compact('user'));
    }

    public function update(UpdateUserSettingRequest $request){
        $user = User::findOrFail(auth()->user()->id);
        
        if($request->hasFile('image')){
            $this->deleteImage($user->image);
            $path = $this->uploadImage($request->image , 'uploads/users' , 'uploads');
        }
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->street = $request->street;
        $user->image = $path ?? $user->image;
        $user->save();
        Session::flash('success', 'Profile Data Updated Successfully');
        return redirect()->route('frontend.dashboard.settings');
    }

    public function changePassword(ChangePasswordRequest $request){
        $user = User::findOrFail(auth()->user()->id);
        if(!Hash::check($request->currentPassword , $user->password)){
            Session::flash('error', 'Current Password Is Not Correct');
            return redirect()->route('frontend.dashboard.settings');
        }
        $user->password = Hash::make($request->password);
        $user->save();
        Session::flash('success', 'Password Changed Successfully');
        return redirect()->route('frontend.dashboard.settings');
        
    }
}
