<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Contact\RegisterRequest;
use App\Models\User;
use App\Notifications\Admin\SendOtpNotify;
use App\Traits\ApiResponseTrait;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    //
    use UploadImage, ApiResponseTrait;
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'image' => $request->image ? $this->uploadImage($request->image, 'uploads/users', 'uploads') : null,
                'status' => 1,
                'country' => $request->country,
                'city' => $request->city,
                'phone' => $request->phone,
                'street' => $request->street,
            ]);
            $user->notify(new SendOtpNotify());
            $token = $user->createToken('user_token', [], now()->addMinutes(60))->plainTextToken;
            DB::commit();
            return $this->apiResponse(['token' => $token], 'User Registered successfully', 200);
        } catch (\Exception $e) {
            return $this->apiResponse(null, 'Something went wrong', 401);
        }
    }
}
