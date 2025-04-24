<?php

namespace Tests\Feature\Frontend\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_with_valid_data()
    {
        Storage::fake('uploads');

        $response = $this->post('/register', [
            'name' => 'Ibrahim Ahmed',
            'email' => 'ibrahim@user.com',
            'username' => 'HemaF4brey74',
            'image' => UploadedFile::fake()->image('article.jpg'),
            'country' => 'Egypt',
            'city' => 'Osayrat',
            'street' => 'El Danan',
            'phone'=> '01124782711',
            'password' => '789789789',
            'password_confirmation' => '789789789',
        ]);

        $response->assertRedirect('/frontend');

        $this->assertDatabaseHas('users', [
            'email' => 'ibrahim@user.com',
        ]);

        $this->assertAuthenticated();
        // Storage::disk('uploads')->assertExists('uploads/article.jpg');
    }

    public function user_cannot_register_with_invalid_data()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertGuest();
    }
}
