<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use ParagonIE\Sodium\Core\Curve25519\H;

class LoginController extends Controller
{
    //
    use ApiResponseTrait;
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|string',
        ]);

        $user = User::whereEmail($request->email)->first();
        if($user && Hash::check($request->password , $user->password)){
            $token = $user->createToken('user_token' , [] , now()->addMinutes(60))->plainTextToken;
            return $this->apiResponse(['token'=>$token] , 'User logged successfully' , 200);
        }
        
        return $this->apiResponse(null , 'Credensials not match' , 401);
    }

    public function logout(){
        $user = Auth::guard('sanctum')->user();
        $user->currentAccessToken()->delete();
        return $this->apiResponse(null , 'User logged out successfully' , 200);
    }
}
