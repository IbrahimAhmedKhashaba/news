<?php

namespace Tests\Feature\Frontend\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'name' => 'Ibrahim Ahmed',
            'email' => 'ibrahim@user.com',
            'username' => 'HemaF4brey74',
            'image' => 'uploads/posts/1.png',
            'status' => 1,
            'country' => 'Egypt',
            'city' => 'Osayrat',
            'street' => 'El Danan',
            'phone'=> '01124782711',
            'email_verified_at' => now(),
            'password' => Hash::make('789789789'), // password
            'remember_token' => Str::random(10),
        ]);

        $response = $this->post('/login', [
            'email' => 'ibrahim@user.com',
            'password' => '789789789',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest(); 
    }
}
