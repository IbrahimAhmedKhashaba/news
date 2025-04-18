<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\NewCommentNotify;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function show($slug)
    {
        $mainPost = Post::active()->with([
            'images',
            'comments' => function ($query) {
                $query->with('user')->latest()->limit(3);
            },
            'category'
        ])->where('slug' , $slug)->firstOrFail();
        $mainPost->num_of_views;
        $mainPost->save();
        $category = $mainPost->category;
        $comments = $mainPost->comments;
        $posts_belongs_to_category = $category->posts()->active()->with('images')->select('id', 'slug', 'title')->limit(5)->get();

        return view('frontend.show', compact(['mainPost', 'posts_belongs_to_category', 'comments']));
    }

    public function getAllComments($slug)
    {
        
        $post = Post::active()->with(['comments' => function ($query) {
            $query->latest()->with('user');
        }])->whereSlug($slug)->first();
        $comments = $post->comments;
        return response()->json($comments);
    }

    public function store(PostRequest $postRequest)
    {

        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $postRequest->post_id,
            'comment' => $postRequest->comment,
            'ip_address' => $postRequest->ip()
        ]);
        if (!$comment) {
            return response()->json([
                'data' => 'comment not created',
                'status' => 403
            ]);
        }

        $post = Post::find($postRequest->post_id);
        if (auth()->user()->id != $post->user_id) {
            $post->user->notify(new NewCommentNotify($comment, $post));
        }

        $comment->load('user');

        return response()->json([
            'msg' => 'comment created successfully',
            'comment' => $comment,
            'status' => 201
        ]);
    }
}
