<?php

namespace Tests\Feature\Frontend;

use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    /** @test */
    public function test_it_returns_category_by_slug_with_9_paginated_posts()
    {
        $category = Category::factory()->create([
            'slug' => 'laravel-news',
            'status' => 1,
        ]);

        $user = User::factory()->create();

        $posts = Post::factory()->count(15)->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        foreach ($posts as $post) {
            Image::factory()->create([
                'post_id' => $post->id,
                'path' => 'images/fake.jpg',
            ]);
        }

        $response = $this->get("/category/laravel-news");

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('frontend.category');
        $response->assertViewHas(['posts', 'MainCategory']);

        $posts = $response->viewData('posts');
        $this->assertEquals(9, $posts->count());
    }
}
