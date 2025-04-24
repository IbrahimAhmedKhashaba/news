<?php

namespace Tests\Feature\Frontend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_news_subscriber_success(): void
    {
        $this->withoutMiddleware();

        $email = 'test' . uniqid() . '@example.com';

        $response = $this->post('/news-subscriber', [
            'email' => $email,
        ]);

        $this->assertDatabaseHas('news_subscribers', [
            'email' => $email,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Thank you for subscribing to our newsletter.');
    }

    public function test_news_subscriber_fails_when_email_already_exists(): void
    {
        $this->withoutMiddleware();

        $this->post('/news-subscriber', [
            'email' => 'test@example.com',
        ]);
    
        $response = $this->post('/news-subscriber', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(302);

        $response->assertSessionHasErrors('email');
    }

    public function test_news_subscriber_fails_with_invalid_email(): void
    {
        $this->withoutMiddleware();

        $response = $this->post('/news-subscriber', [
            'email' => 'not-an-email',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }
}
