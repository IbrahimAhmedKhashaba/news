<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    //
    // public function __construct(){
    //     $this->middleware('can:settings');
    // }
    public function index()
    {
        return view('dashboard.profile.index');
    }

    public function update(ProfileRequest $request)
    {
        DB::beginTransaction();
        try {
            $admin = Admin::find(auth()->user()->id);
            if(Hash::check($request->password , $admin->password)){
                $admin->name = $request->name;
                $admin->username = $request->username;
                $admin->email = $request->email;
                $admin->save();
                Session::flash('success', 'Profile updated successfully');
            } else {
                Session::flash('error', 'Password is incorrect');
            }
            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
