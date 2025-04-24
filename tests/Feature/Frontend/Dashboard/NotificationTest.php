<?php

namespace Tests\Feature\Frontend\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    // index method
    public function test_shows_notifications_page_for_authenticated_user()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $this->actingAs($user);

        $response = $this->get('/account/Notifications');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.dashboard.notification');
        $response->assertViewHas('user');
    }

    public function test_marks_unread_notifications_as_read()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $this->actingAs($user);

        DatabaseNotification::create([
            'id' => \Str::uuid(),
            'type' => 'App\Notifications\FakeNotification',
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'data' => ['message' => 'Test notification'],
            'read_at' => null,
        ]);
        $this->assertEquals(1, $user->unreadNotifications()->count());

        $this->get('/account/Notifications');

        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }

    public function test_guest_user_is_redirected_to_login()
    {
        $response = $this->get('/account/Notifications');
        $response->assertRedirect('/login');
    }

    // delete method
    public function test_deletes_notification_belonging_to_authenticated_user()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $this->actingAs($user);

        $notification = DatabaseNotification::create([
            'id' => \Str::uuid(),
            'type' => 'App\Notifications\FakeNotification',
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'data' => ['message' => 'Test notification'],
            'read_at' => null,
        ]);

        $response = $this->delete("/account/Notifications/{$notification->id}/delete");
        $response->assertRedirect();

        $this->assertDatabaseMissing('notifications', ['id' => $notification->id]);
    }

    public function test_does_not_delete_notification_of_another_user()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $otherUser = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);

        $this->actingAs($user);

        $notification = DatabaseNotification::create([
            'id' => \Str::uuid(),
            'type' => 'App\Notifications\FakeNotification',
            'notifiable_id' => $otherUser->id,
            'notifiable_type' => User::class,
            'data' => ['message' => 'Test notification'],
            'read_at' => null,
        ]);

        $response = $this->delete("/account/Notifications/{$notification->id}/delete");

        $this->assertDatabaseHas('notifications', ['id' => $notification->id]);
    }

    public function it_handles_deletion_of_non_existent_notification_gracefully()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $this->actingAs($user);

        $nonExistentId = \Str::uuid();

        $response = $this->delete("/account/Notifications/{$nonExistentId}/delete");

        $response->assertRedirect();
        $this->assertSessionHas('success', 'Notification deleted successfully');
    }

    public function test_deletes_all_notifications_for_authenticated_user()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $this->actingAs($user);

        DatabaseNotification::create([
            'id' => \Str::uuid(),
            'type' => 'App\Notifications\FakeNotification',
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'data' => ['message' => 'one'],
        ]);

        DatabaseNotification::create([
            'id' => \Str::uuid(),
            'type' => 'App\Notifications\FakeNotification',
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'data' => ['message' => 'two'],
        ]);

        $this->assertCount(2, $user->notifications);

        $response = $this->delete('/account/Notifications/deleteAll');

        $response->assertRedirect();
        $this->assertCount(0, $user->fresh()->notifications);
    }

    public function test_handles_deletion_when_no_notifications_exist()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $this->actingAs($user);

        $this->assertCount(0, $user->notifications);

        $response = $this->delete('/account/Notifications/deleteAll');

        $response->assertRedirect();
        $this->assertCount(0, $user->fresh()->notifications);
    }

    public function test_guest_user_cannot_delete_notifications()
    {
        $response = $this->delete('/account/Notifications/deleteAll');
        $response->assertRedirect('/login');
    }

    public function test_marks_all_notifications_as_read_for_authenticated_user()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $this->actingAs($user);

        DatabaseNotification::create([
            'id' => \Str::uuid(),
            'type' => 'App\Notifications\FakeNotification',
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'data' => [],
            'read_at' => null,
        ]);

        DatabaseNotification::create([
            'id' => \Str::uuid(),
            'type' => 'App\Notifications\FakeNotification',
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'data' => [],
            'read_at' => null,
        ]);

        $this->assertEquals(2, $user->unreadNotifications()->count());

        $response = $this->post('/account/Notifications/markAllAsRead');

        $response->assertRedirect();

        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }

    public function test_guest_user_cannot_mark_notifications_as_read()
    {
        $response = $this->post('/account/Notifications/markAllAsRead');
        $response->assertRedirect('/login');
    }

    public function test_handles_no_notifications_gracefully()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $this->actingAs($user);

        $this->assertEquals(0, $user->notifications()->count());

        $response = $this->post('/account/Notifications/markAllAsRead');

        $response->assertRedirect();
    }
}
