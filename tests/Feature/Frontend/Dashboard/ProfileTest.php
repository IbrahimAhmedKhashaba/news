<?php

namespace Tests\Feature\Frontend\Dashboard;

use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    public function test_shows_profile_page_for_authenticated_user_with_their_posts_only()
    {
        $user = User::factory()->create([
            'status' => 1,
        ]);
        $category = Category::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 1,
            'title' => 'Active Post',
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 0,
            'title' => 'Inactive Post',
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        $otherUser = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $otherUser->id,
            'category_id' => $category->id,
            'status' => 1,
            'title' => 'Other User Post',
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        $response = $this->get('/account/profile');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.dashboard.profile');
        $response->assertViewHas('posts');

        $posts = $response->viewData('posts');
        $this->assertCount(1, $posts);
        $this->assertEquals('Active Post', $posts->first()->title);
    }

    public function test_loads_related_images_with_posts()
    {
        $user = User::factory()->create([
            'status' => 1,
        ]);
        $category = Category::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 1,
            'title' => 'Active Post',
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        $response = $this->get('/account/profile');

        $posts = $response->viewData('posts');
        $this->assertTrue($posts->first()->relationLoaded('images'));
        $this->assertEquals('images/fake.jpg', $posts->first()->images->first()->path);
    }

    public function test_guest_user_is_redirected_from_profile_page()
    {
        $response = $this->get('/account/profile');
        $response->assertRedirect('/login');
    }
}
