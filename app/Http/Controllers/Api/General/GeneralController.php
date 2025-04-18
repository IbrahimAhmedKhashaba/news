<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\Api\NewCommentNotify;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    use ApiResponseTrait;
    public function home()
    {
        $query = Post::query()
            ->latest()
            ->with(['images'])
            ->activeUser()
            ->activeCategory()
            ->active();
        if(request()->query('keyword')){
            $query->where('title' , 'like' , '%'.request()->query('keyword').'%')
            ->orWhere('desc' , 'like' , '%'.request()->query('keyword').'%');
        }
        $posts = clone $query->paginate(4);

        $latest_posts = $this->latestPosts(clone $query);
        $oldest_posts = $this->oldestPosts(clone $query);

        $popular_posts = $this->popularPosts(clone $query);

        $categories = Category::with('posts')->withCount('posts')->active()->get();
        $categories_with_posts = $this->categoriesWithPosts($categories);

        $most_read_posts = $this->mostReadPosts(clone $query);

        $data = [
            'posts' => (new PostCollection($posts))->response()->getData(true),
            'latest_posts' => new PostCollection($latest_posts),
            'oldest_posts' => new PostCollection($oldest_posts),
            'popular_posts' => new PostCollection($popular_posts),
            'categories_with_posts' => new CategoryCollection($categories_with_posts),
            'most_read_posts' => new PostCollection($most_read_posts),
        ];
        return $this->apiResponse($data, 'Data get successfully', 200);
    }
    public function latestPosts($query)
    {
        return $query->latest()->take(4)->get();
    }

    public function oldestPosts($query)
    {
        return $query->oldest()->take(3)->get();
    }

    public function popularPosts($query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc')->take(3)->get();
    }

    public function categoriesWithPosts($query)
    {
        $category_with_posts = $query->map(function ($category) {
            $category->posts = $category->posts()->active()->activeUser()->activeCategory()->take(4)->get();
            return $category;
        });
        return $category_with_posts;
    }
    public function mostReadPosts($query)
    {
        return $query->orderBy('num_of_views', 'desc')->take(3)->get();
    }
}
