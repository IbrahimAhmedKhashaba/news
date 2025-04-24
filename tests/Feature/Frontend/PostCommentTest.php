<?php

namespace Tests\Feature\Frontend;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewCommentNotify;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PostCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_returns_all_comments_with_user_in_json_format()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'slug' => 'test-post',
            'status' => 1,
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        Comment::factory()->count(2)->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get("/post/comments/test-post");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'comment',
                'user',
            ]
        ]);
    }

    public function test_returns_comments_ordered_by_latest_first()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'slug' => 'test-post',
            'status' => 1,
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'Oldest comment',
            'created_at' => now()->subDays(2),
        ]);

        Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'Newest comment',
            'created_at' => now(),
        ]);

        $response = $this->get("/post/comments/test-post");

        $comments = $response->json();
        $this->assertEquals('Newest comment', $comments[0]['comment']);
        $this->assertEquals('Oldest comment', $comments[1]['comment']);
    }

    public function test_returns_empty_array_if_post_slug_does_not_exist()
    {
        $response = $this->get("/post/comments/non-existing-slug");

        $response->assertStatus(404);
        $response->assertExactJson(['message' => 'post not found']);
    }

    public function test_returns_empty_array_if_post_is_inactive()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'slug' => 'test-post',
            'status' => 0,
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'Oldest comment',
            'created_at' => now()->subDays(2),
        ]);

        Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'Newest comment',
            'created_at' => now(),
        ]);

        $response = $this->get("/post/comments/test-post");

        $response->assertStatus(404);
        $response->assertExactJson(['message' => 'post not found']);
    }

    public function test_store_comment_successfully_and_returns_json()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $postOwner = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $postOwner->id , 'category_id'=>$category->id]);

        $this->actingAs($user);

        $response = $this->postJson(route('frontend.post.comment.store'), [
            'post_id' => $post->id,
            'comment' => 'This is a test comment',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'msg' => 'comment created successfully',
        ]);

        

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'comment' => 'This is a test comment',
            'user_id' => $user->id,
        ]);
    }

    public function test_notifies_post_owner_when_comment_created_by_another_user()
    {
        Notification::fake();

        $user = User::factory()->create();
        $category = Category::factory()->create();
        $postOwner = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $postOwner->id , 'category_id'=>$category->id]);

        $this->actingAs($user);

        $response = $this->postJson(route('frontend.post.comment.store'), [
            'post_id' => $post->id,
            'comment' => 'Notifying owner',
        ]);

        Notification::assertSentTo($postOwner, NewCommentNotify::class);
    }

    public function test_does_not_notify_if_user_comments_on_own_post()
    {
        Notification::fake();

        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id , 'category_id'=>$category->id]);

        $this->actingAs($user);

        $response = $this->postJson(route('frontend.post.comment.store'), [
            'post_id' => $post->id,
            'comment' => 'My own post comment',
        ]);

        Notification::assertNothingSent();
    }

    public function test_fails_validation_when_missing_comment_field()
{
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user);

    $response = $this->postJson(route('frontend.post.comment.store'), [
        'post_id' => $post->id,
        // missing 'comment'
    ] , [
        'Accept' => 'application/json'
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors('comment');
}

    public function test_rejects_guest_users_from_commenting()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id'=>$category->id,
        ]);

        $response = $this->postJson(route('frontend.post.comment.store'), [
            'post_id' => $post->id,
            'comment' => 'guest test',
        ]);

        $response->assertStatus(500);
    }
}
