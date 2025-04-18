<?php

namespace App\Http\Controllers\frontend\dashboard;

use App\Models\Post;
use App\Traits\UploadImage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Comment;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    //
    use UploadImage;
    public function index(){
        $posts = auth()->user()->posts()->active()->with('images' , 'user')->latest()->get();
        return view('frontend.dashboard.profile' , compact('posts'));
    }

    public function storePost(StorePostRequest $postRequest){
        DB::beginTransaction();
        try{
            $post = new Post();
            $post->title = $postRequest->title;
            $post->slug = Str::slug($postRequest->title);
            $post->small_desc = $postRequest->small_desc;
            $post->desc = $postRequest->desc;
            $post->category_id = $postRequest->category_id;
            $post->user_id = auth()->user()->id;
            $post->comment_able = $postRequest->comment_able == 'on' ? 1:0;
            $post->save();
            if($postRequest->images){
                foreach($postRequest->images as $image){
                    
                    $post->images()->create([
                        'path'=> $this->uploadImage($image , 'uploads/posts' , 'uploads'),
                    ]);
                }
            }
            Session::flash('success', 'Post created successfully');
            DB::commit();
            Cache::forget('read_more_posts');
            Cache::forget('latest_posts');
            return redirect()->route('frontend.dashboard.profile');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('error', $e->getMessage());
        }
    }

    public function delete(Request $request){
        $request->validate([
            'slug' => 'required|exists:posts,slug'
        ]);
        $post = Post::whereSlug($request->slug)->with('images')->first();
        if($post->images->count() > 0){
            foreach($post->images as $image){
                $this->deleteImage($image->path);
            }
        }
        $post->delete();
        Session::flash('success', 'Post Deleted successfully');
        return redirect()->route('frontend.dashboard.profile');
    }

    public function getComments($id){
        $comments = Comment::with('user')->where('post_id' , $id)->get();
        return response()->json([
            'comments' => $comments
        ]);
    }

    public function edit($slug){
        $post = Post::with('images' , 'category')->whereSlug($slug)->first();
        if(!$post){
            abort(404);
        }
        return view('frontend.dashboard.edit-post', compact('post'));
    }

    public function update(StorePostRequest $request , $slug){
        $post = Post::whereSlug($slug)->first();
        $post->title = $request->title;
        $post->small_desc = $request->small_desc;
        $post->desc = $request->desc;
        $post->category_id = $request->category_id;
        $post->comment_able = $request->comment_able == 'on' ? 1 : 0;
        
        if($request->images){
            if($post->images->count() > 0){
                foreach($post->images as $image){
                    $this->deleteImage($image->path);
                    $image->delete();
                }
            }
            foreach($request->images as $image){
                $post->images()->create([
                    'path'=> $this->uploadImage($image , 'uploads/posts' , 'uploads'),
                ]);
            }
        }
        $post->save();
        Session::flash('success', 'Post Updated successfully');
        return redirect()->route('frontend.dashboard.profile');
    }

    public function deleteAnImage(Request $request){
        $image = Image::find($request->key);
        
        if(!$image){
            return response()->json([
                'message' => 'Image not found',
                'status' => 404,
            ]);
        }
        if( $image->post->images->count() == 1){
            return response()->json([
                'message' => 'You can not delete this image',
                'status' => 403,
            ]);
        }
        $this->deleteImage($image->path);
        $image->delete();
        return response()->json([
            'message' => 'Image deleted successfully',
            'status' => 200,
        ]);
    }
}
