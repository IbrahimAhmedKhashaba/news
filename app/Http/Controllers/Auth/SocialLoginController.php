<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;


class SocialLoginController extends Controller
{
    //
    public function redirect($provider)
    {

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $existingUser = User::where('email', $user->getEmail())->first();
        if ($existingUser) {
            Auth::login($existingUser);
            return redirect()->route('frontend.index');
        } else {
            $newUser = User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'username' => $this->generateUsername($user->getNickname()),
                'provider_id' => $user->getId(),
                'image' => $user->avatar,
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(8)),
            ]);
            Auth::login($newUser);
            return redirect()->route('frontend.index');
        }
        
    }

    public function generateUsername($name){
        $username = Str::slug($name);
        $count = 1;
        while(User::where('username', '=', $username)->exists()){
            $username .= $count++;
        }
        return $username;
    }
}
