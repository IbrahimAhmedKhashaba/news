<?php

namespace Tests\Feature\Frontend\Dashboard;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ProfileStorePostTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_create_post_with_images_successfully()
    {
        Storage::fake('uploads');

        $user = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $category = Category::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('frontend.dashboard.post.store'), [
            'title' => 'New Test Post',
            'small_desc' => 'short desc',
            'desc' => 'full content of post',
            'category_id' => $category->id,
            'comment_able' => 'on',
            'images' => [
                UploadedFile::fake()->image('img1.jpg'),
                UploadedFile::fake()->image('img2.jpg')
            ]
        ]);

        $response->assertRedirect(route('frontend.dashboard.profile'));

        $post = Post::where('title', 'New Test Post')->first();
        $this->assertNotNull($post);
        $this->assertCount(2, $post->images);

        Storage::disk('uploads')->assertExists($post->images[0]->path);
    }

    public function test_comment_disabled_is_stored_correctly()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $category = Category::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('frontend.dashboard.post.store'), [
            'title' => 'No Comment Post',
            'small_desc' => '...',
            'desc' => '...',
            'category_id' => $category->id,
            'images' => [
                UploadedFile::fake()->image('img1.jpg'),
                UploadedFile::fake()->image('img2.jpg')
            ]
        ]);

        $post = Post::where('title', 'No Comment Post')->first();
        $this->assertEquals(0, $post->comment_able);
    }

    public function test_guest_cannot_store_post()
    {
        $category = Category::factory()->create();

        $response = $this->post(route('frontend.dashboard.post.store'), [
            'title' => 'Guest Try',
            'small_desc' => '...',
            'desc' => '...',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect('/login');
    }

    public function test_slug_is_created_from_title()
    {
        Storage::fake('uploads');

        $user = User::factory()->create([
            'email_verified_at' => now(),
            'status' => 1,
        ]);
        $category = Category::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('frontend.dashboard.post.store'), [
            'title' => 'slug test title',
            'small_desc' => 'short desc',
            'desc' => 'full content of post',
            'category_id' => $category->id,
            'comment_able' => 'on',
            'images' => [
                UploadedFile::fake()->image('img1.jpg'),
                UploadedFile::fake()->image('img2.jpg')
            ]
        ]);

        $this->assertDatabaseHas('posts', [
            'slug' => 'slug-test-title'
        ]);
    }

    public function test_post_creation_fails_due_to_validation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('frontend.dashboard.post.store'), [
            'title' => '',
            'desc' => '',
            'small_desc' => '',
            'category_id' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title']);
    }
}
