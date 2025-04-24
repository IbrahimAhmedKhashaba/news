<?php

namespace Tests\Feature\Frontend;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SinglePostTest extends TestCase
{
    use RefreshDatabase;
    public function test_show_post_by_slug_successfully()
    {
        $user = User::factory()->create();

        $categories = Category::factory()->count(3)->create([
            'status' => 1,
        ]);

        $post = Post::factory()->create([
            'category_id' => $categories->random()->id,
            'user_id' => $user->id,
            'status' => 1,
            'slug' => 'test-post'
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        $this->assertNotNull($post->images()->first());

        // add 5 comments
        Comment::factory()->count(5)->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        // other posts in the same category
        Post::factory()->count(3)->create([
            'status' => 1,
            'category_id' => $categories->random()->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get("/post/test-post");

        $response->assertStatus(200);
        $response->assertViewIs('frontend.show');
        $response->assertViewHasAll([
            'mainPost',
            'comments',
            'posts_belongs_to_category'
        ]);
    }

    public function test_show_post_not_found_returns_404()
    {
        $response = $this->get("/post/non-existent-slug");
        $response->assertStatus(404);
    }

    public function test_show_post_inactive_returns_404()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'slug' => 'inactive-post',
            'status' => 0,
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get("/post/inactive-post");
        $response->assertStatus(404);
    }

    public function test_show_post_displays_only_3_latest_comments()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create(['slug' => 'test-comments', 'status' => 1, 'user_id' => $user->id, 'category_id' => $category->id]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        Comment::factory()->count(10)->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get("/post/test-comments");

        $comments = $response->viewData('comments');
        $this->assertCount(3, $comments);
    }

    public function test_show_post_increases_view_count()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'slug' => 'view-count',
            'status' => 1,
            'num_of_views' => 10,
            'category_id' => $category->id,
            'user_id' => $user->id
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        $this->get("/post/view-count");

        $this->assertDatabaseHas('posts', [
            'slug' => 'view-count',
            'num_of_views' => 11,
        ]);
    }
}
