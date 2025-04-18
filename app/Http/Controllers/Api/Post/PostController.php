<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\NewCommentNotify;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    use ApiResponseTrait;
    public function showPost($slug)
    {
        $post = Post::with('comments', 'comments.user', 'user', 'category', 'admin', 'images')->whereSlug($slug)->active()->activeUser()->activeCategory()->first();
        if (!$post) {
            return $this->apiResponse(null, 'Post not found', 404,);
        }
        $data = [
            'post' => new PostResource($post),
            'comments' => new CommentCollection($post->comments()->with('user')->active()->take(3)->get()),
        ];
        return $this->apiResponse($data, 'Post get successfully', 200);
    }
    
    public function getAllComments($slug)
    {
        $post = Post::with('comments', 'comments.user', 'user', 'category', 'admin', 'images')->whereSlug($slug)->active()->activeUser()->activeCategory()->first();
        if (!$post) {
            return $this->apiResponse(null, 'Post not found', 404,);
        }
        $data = [
            'post' => new PostResource($post),
            'comments' => new CommentCollection($post->comments()->with('user')->active()->get()),
        ];
        return $this->apiResponse($data, 'Comments get successfully', 200);
    }
    public function storeComment(Request $request, string $slug){
        $user = auth('sanctum')->user();
        $request->validate([
            'comment' => 'required|string',
        ]);
        $post = Post::whereSlug($slug)->first();
        if (!$post) {
            return $this->apiResponse(null, 'Post not found', 404);
        }
        $newComment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => $request->comment,
            'ip_address' => $request->ip(),
        ]);
        $post->user->notify(new NewCommentNotify($newComment , $post));
        return $this->apiResponse($newComment, 'Comment created successfully', 200);
    }
}
