<?php

namespace Tests\Feature\Frontend;

use App\Models\Admin;
use App\Models\Authorization;
use App\Notifications\NewContactNotify;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ContactTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_contact_page_returns_correct_view()
    {
        
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.contact');
    }

    public function stores_contact_and_sends_notification()
    {
        $this->withoutMiddleware();
        Notification::fake();

        $admin = Admin::create([
            'name' => 'Admin Test',
            'email' => 'testadmin_' . uniqid() . '@example.com',
            'username' => 'admin',
            'authorization_id' => 1,
            'password' => bcrypt('password'),
        ]);

        Authorization::create([
            'admin_id' => $admin->id,
            'permissions' => 'contacts,settings',
        ]);

        $response = $this->post('/contact', [
            'name' => 'Ibrahim',
            'email' => 'ibrahim@example.com',
            'phone' => '0123456789',
            'title' => 'Testing Contact',
            'body' => 'This is a test message.',
        ]);

        $this->assertDatabaseHas('contacts', [
            'email' => 'ibrahim@example.com',
            'title' => 'Testing Contact',
        ]);

        Notification::assertSentTo($admin, NewContactNotify::class);

        $response->assertSessionHas('success', 'Contact sent successfully');

        $response->assertViewIs('frontend.contact');
    }
}
