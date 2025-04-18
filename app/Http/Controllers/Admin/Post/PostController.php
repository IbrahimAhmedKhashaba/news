<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:posts');
    }
    use UploadImage;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Post::with(['user', 'category'])->when(request()->keyword, function ($query) {
            $query->where('title', 'like', '%' . request()->keyword . '%')
                ->orWhere('desc', 'like', '%' . request()->keyword . '%');
        })->when(!is_null(request()->status), function ($query) {
            return $query->where('status', request()->status);
        })->orderBy(request('sort_by', 'id'), request('order_by', 'asc'))
            ->paginate(request('limit', 10));
        return view('dashboard.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $users = User::select('id', 'name')->get();
        return view('dashboard.posts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            $post = new Post();
            $post->title = $request->title;
            $post->small_desc = $request->small_desc;
            $post->desc = $request->desc;
            $post->category_id = $request->category;
            $post->admin_id = Auth::guard('admin')->id();
            $post->comment_able = $request->comment_able == 'on' ? 1 : 0;
            $post->save();
            if ($request->images) {
                foreach ($request->images as $image) {
                    $post->images()->create([
                        'path' => $this->uploadImage($image, 'uploads/posts', 'uploads'),
                    ]);
                }
            }
            Session::flash('success', 'Post created successfully');
            DB::commit();
            Cache::forget('read_more_posts');
            Cache::forget('latest_posts');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $post = Post::with(['category', 'images', 'user'])->withCount('comments')->findOrFail($id);
        $comments = Comment::with('user')->where('post_id', $id)->take(3)->get();
        return view('dashboard.posts.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $post = Post::with('category')->findOrFail($id);
        return view('dashboard.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->small_desc = $request->small_desc;
        $post->desc = $request->desc;
        $post->category_id = $request->category;
        $post->comment_able = $request->comment_able == 'on' ? 1 : 0;

        if ($request->images) {
            if ($post->images->count() > 0) {
                foreach ($post->images as $image) {
                    $this->deleteImage($image->path);
                    $image->delete();
                }
            }
            foreach ($request->images as $image) {
                $post->images()->create([
                    'path' => $this->uploadImage($image, 'uploads/posts', 'uploads'),
                ]);
            }
        }
        $post->save();
        Session::flash('success', 'Post Updated successfully');
        return redirect()->route('admin.posts.edit', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $post = Post::with('images')->findOrFail($id);
        if ($post->images->count() > 0) {
            foreach ($post->images as $image) {
                $this->deleteImage($image->path);
            }
        }
        $post->delete();
        Session::flash('success', 'Post Deleted Successfully');
        return redirect()->route('admin.posts.index');
    }

    public function updateStatus($id)
    {
        $post = Post::findOrFail($id);
        $post->status = $post->status == 1 ? 0 : 1;
        $post->save();
        Session::flash('success', 'Post Status Updated Successfully');
        return redirect()->back();
    }

    public function deleteAnImage(Request $request)
    {
        $image = Image::find($request->key);
        if (!$image) {
            return response()->json([
                'message' => 'Image not found',
                'status' => 404,
            ]);
        }
        $this->deleteImage($image->path);
        $image->delete();
        return response()->json([
            'message' => 'Image deleted successfully',
            'status' => 200,
        ]);
    }



    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Comment not found.',
            ], 404);
        }
        $comment->delete();
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function getAllComments($id)
    {
        $post = Post::active()->with(['comments' => function ($query) {
            $query->with('user');
        }])->where('id', $id)->first();
        if (!$post) {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }

        $comments = $post->comments;

        return response()->json($comments);
    }
}
