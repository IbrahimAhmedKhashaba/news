<?php

namespace Tests\Feature\Frontend\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;
    public function test_show_account_settings_page_for_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/account/settings');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.dashboard.setting');
        $response->assertViewHas('user');
        $this->assertEquals($user->id, $response->viewData('user')->id);
    }

    public function test_redirects_guest_user_to_login()
    {
        $response = $this->get('/account/settings');
        $response->assertRedirect('/login');
    }

    public function test_view_contains_user_data()
    {
        $user = User::factory()->create([
            'username' => 'Ibrahim',
            'email' => 'ibrahim@example.com',
            'phone' => '1234567890',
        ]);

        $this->actingAs($user);

        $response = $this->get('/account/settings');

        $response->assertSee('Ibrahim');
        $response->assertSee('ibrahim@example.com');
        $response->assertSee('1234567890');
    }


    public function test_updates_user_data_without_image()
    {
        $user = User::factory()->create([
            'status' => 1
        ]);
        $this->actingAs($user);

        $response = $this->post(route('frontend.dashboard.settings.update'), [
            'name' => 'Updated Name',
            'username' => 'updated_username',
            'email' => 'updated@email.com',
            'phone' => '01234567890',
            'country' => 'Egypt',
            'city' => 'Cairo',
            'street' => '123 Nile St',
        ]);

        $response->assertRedirect(route('frontend.dashboard.settings'));
        $this->assertEquals('Updated Name', $user->fresh()->name);
        $this->assertEquals('updated@email.com', $user->fresh()->email);
        $this->assertEquals('updated_username', $user->fresh()->username);
    }

    public function test_updates_user_data_with_new_image()
    {
        Storage::fake('uploads');

        $user = User::factory()->create(['image' => 'old.png' , 'status' => 1]);
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('new-image.jpg');

        $response = $this->post(route('frontend.dashboard.settings.update'), [
            'name' => 'With Image',
            'username' => 'withimage',
            'email' => 'withimage@example.com',
            'phone' => '01111111111',
            'country' => 'Egypt',
            'city' => 'Giza',
            'street' => 'Pyramids',
            'image' => $file,
        ]);

        $response->assertRedirect(route('frontend.dashboard.settings'));
        $this->assertNotEquals('old.png', $user->fresh()->image);
        Storage::disk('uploads')->assertExists($user->fresh()->image);
    }

    public function test_guest_user_cannot_update_profile()
    {
        $response = $this->post(route('frontend.dashboard.settings.update'), []);
        $response->assertRedirect('/login');
    }

    public function it_sets_flash_success_message_after_update()
    {
        $user = User::factory()->create([
            'status' => 1,
        ]);
        $this->actingAs($user);

        $response = $this->post(route('frontend.dashboard.settings.update'), [
            'name' => 'Flash Test',
            'username' => 'flash_user',
            'email' => 'flash@example.com',
            'phone' => '01000000000',
            'country' => 'FlashLand',
            'city' => 'FlashCity',
            'street' => 'Flash Street',
        ]);

        $response->assertSessionHas('success', 'Profile Data Updated Successfully');
    }
}
