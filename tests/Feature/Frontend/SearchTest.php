<?php

namespace Tests\Feature\Frontend;

use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_results_when_search_matches_title()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'title' => 'Laravel Tips',
            'status' => 1,
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        $post = Post::factory()->create([
            'title' => 'Vue.js Guide',
            'status' => 1,
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        $response = $this->get('/search?search=Laravel');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.search');

        $posts = $response->viewData('posts');
        $this->assertCount(1, $posts);
        $this->assertEquals('Laravel Tips', $posts->first()->title);
    }

    public function test_returns_empty_results_when_no_match_found()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'title' => 'Laravel Tips',
            'status' => 1,
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        $response = $this->get('/search?search=NoMatchHere');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.search');

        $posts = $response->viewData('posts');
        $this->assertCount(0, $posts);
    }

    public function test_fails_validation_when_search_is_missing()
    {
        $response = $this->get('/search');
        $response->assertStatus(302);

        $response->assertSessionHasErrors('search');
    }

    public function test_strips_html_tags_from_search_query()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'title' => 'Laravel Tips',
            'status' => 1,
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        Image::factory()->create([
            'post_id' => $post->id,
            'path' => 'images/fake.jpg',
        ]);

        $response = $this->get('/search?search=<b>Laravel</b>');
        $response->assertStatus(200);

        $posts = $response->viewData('posts');
        $this->assertCount(1, $posts);
    }

}
