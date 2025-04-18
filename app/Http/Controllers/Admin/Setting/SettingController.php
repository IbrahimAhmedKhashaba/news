<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Models\Setting;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    //
    use UploadImage;

    public function __construct(){
        $this->middleware('can:settings');
    }
    public function index()
    {
        return view('dashboard.settings.index');
    }

    public function update(UpdateSettingRequest $request)
    {
        DB::beginTransaction();
        try {
            $settings = Setting::first();

            if ($request->hasFile('logo')) {
                $this->deleteImage($settings->logo);
                $settings->logo = $this->uploadImage($request->logo, 'uploads/settings', 'uploads');
            }
            if ($request->hasFile('favicon')) {
                $this->deleteImage($settings->favicon);
                $settings->favicon = $this->uploadImage($request->favicon, 'uploads/settings', 'uploads');
            }
            $settings->site_name = $request->site_name;
            $settings->email = $request->email;
            $settings->facebook = $request->facebook;
            $settings->twitter = $request->twitter;
            $settings->instagram = $request->instagram;
            $settings->youtube = $request->youtube;
            $settings->country = $request->country;
            $settings->city = $request->city;
            $settings->street = $request->street;
            $settings->phone =  $request->phone;
            $settings->small_desc = $request->small_desc;
            $settings->save();
            DB::commit();
            Session::flash('success', 'Setting updated successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
