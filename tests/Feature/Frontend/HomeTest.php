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

class HomeTest extends TestCase
{
    public function test_loads_home_page_with_expected_data()
    {
        // Arrange

        $user = User::factory()->create();

        $categories = Category::factory()->count(3)->create([
            'status' => 1,
        ]);

        $posts = Post::factory()->count(15)->create([
            'category_id' => $categories->random()->id,
            'user_id' => $user->id,
        ]);

        foreach ($posts as $post) {
            Image::factory()->create([
                'post_id' => $post->id,
                'path' => 'images/fake.jpg',
            ]);
        }

        $response = $this->get('/frontend');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.index');

        $response->assertViewHasAll([
            'posts',
            'greatest_views_posts',
            'oldest_posts',
            'category_with_posts'
        ]);

        // Optional deeper checks:
        $this->assertCount(9, $response->viewData('posts'));
        $this->assertCount(3, $response->viewData('greatest_views_posts'));
        $this->assertCount(3, $response->viewData('oldest_posts'));

        $categories = $response->viewData('category_with_posts');
        foreach ($categories as $category) {
            $this->assertLessThanOrEqual(4, $category->posts->count());
        }
    }
}
