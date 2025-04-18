<?php

namespace App\Http\Controllers\Api\Profile;

use App\Models\Post;
use App\Models\User;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\Api\ProfileRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Post\PostCollection;
use App\Http\Requests\ChangePasswordRequest;

class ProfileController extends Controller
{
    //
    use ApiResponseTrait, UploadImage;
    public function getUserData()
    {
        $user = request()->user();
        if (!$user) {
            return $this->apiResponse(null, 'User not found', 404);
        }
        return $this->apiResponse(UserResource::make($user), 'User data retrieved successfully', 200);
    }

    public function update(ProfileRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = request()->user();
            if (!$user) {
                return $this->apiResponse(null, 'User not found', 404);
            }
            if ($request->hasFile('image')) {
                $this->deleteImage($user->image);
                $path = $this->uploadImage($request->image, 'uploads/users', 'uploads');
            }
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $request->phone,
                'country' => $request->country,
                'city' => $request->city,
                'street' => $request->street,
                'image' => $request->image ? $path : $user->image,
            ]);
            DB::commit();
            return $this->apiResponse(UserResource::make($user), 'User data updated successfully', 200);
        } catch (\Exception $e) {
            return $this->apiResponse(null, $e->getMessage(), 500);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::findOrFail(request()->user()->id);
        if (!$user) {
            return $this->apiResponse(null, 'User not found', 404);
        }
        if (!Hash::check($request->currentPassword, $user->password)) {
            return $this->apiResponse(null, 'Current Password Is Not Correct', 500);
        }
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return $this->apiResponse(UserResource::make($user), 'Password changed successfully', 200);
    }

    public function getUserPosts()
    {
        $user = User::find(auth()->guard('sanctum')->user()->id);
        if (!$user) {
            return $this->apiResponse(null, 'User not found', 404);
        }
        $posts = $user->posts()->active()->with(['comments' => function ($query) {
            $query->with(['user' => function ($query) {
                $query->select('id', 'name', 'image');
            }])->limit(3)->get();
        }, 'images'])->get();
        if (!$posts->count() > 0) {
            return $this->apiResponse(null, 'No posts found', 200);
        }
        return $this->apiResponse(new PostCollection($posts), 'User posts', 200);
    }

    public function store(StorePostRequest $postRequest)
    {

        DB::beginTransaction();
        try {
            $user = auth()->guard('sanctum')->user();
            if (!$user) {
                return $this->apiResponse(null, 'User not found', 404);
            }
            $post = new Post();
            $post->title = $postRequest->title;
            $post->small_desc = $postRequest->small_desc;
            $post->desc = $postRequest->desc;
            $post->category_id = $postRequest->category_id;
            $post->user_id = request()->user()->id;
            $post->comment_able = $postRequest->comment_able == 'on' ? 1 : 0;
            $post->save();
            if ($postRequest->images) {
                foreach ($postRequest->images as $image) {

                    $post->images()->create([
                        'path' => $this->uploadImage($image, 'uploads/posts', 'uploads'),
                    ]);
                }
            }
            $post->save();

            Cache::forget('read_more_posts');
            Cache::forget('latest_posts');

            DB::commit();
            return $this->apiResponse($post, 'Post created successfully', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(null, $e->getMessage(), 500);
        }
    }

    public function updatePost(StorePostRequest $postRequest, string $slug){
        try{
            $post = Post::with('images')->whereSlug($slug)->first();
        if (!$post) {
            return $this->apiResponse(null, 'Post not found', 404);
        }
        $post->title = $postRequest->title;
        $post->small_desc = $postRequest->small_desc;
        $post->desc = $postRequest->desc;
        $post->category_id = $postRequest->category_id;
        $post->slug = $postRequest->slug;
        $post->save();
        if($postRequest->images){
            if($post->images->count() > 0){
                foreach($post->images as $image){
                    $this->deleteImage($image->path);
                    $image->delete();
                }
            }
            foreach($postRequest->images as $image){
                $post->images()->create([
                    'path'=> $this->uploadImage($image , 'uploads/posts' , 'uploads'),
                ]);
            }
        }
        $post->save();
        Cache::forget('read_more_posts');
        Cache::forget('latest_posts');
        return $this->apiResponse($post , 'Post updated successfully' , 200);
        } catch(\Exception $e){
            DB::rollBack();
            return $this->apiResponse(null, $e->getMessage(), 500);
        }
    }

    public function destroy(string $slug)
    {
        //
        DB::beginTransaction();
        try {
            $post = Post::with('images')->whereSlug($slug)->first();
            if (!$post) {
                return $this->apiResponse(null, 'Post not found', 404);
            }
            if ($post->images->count() > 0) {
                foreach ($post->images as $image) {
                    $this->deleteImage($image->path);
                }
            }
            $post->delete();
            Cache::forget('read_more_posts');
            Cache::forget('latest_posts');
            DB::commit();
            return $this->apiResponse(null, 'Post deleted successfully', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(null, $e->getMessage(), 500);
        }
    }

    

    // public function deleteComment(Request $request, string $slug, int $commentId){
    //     $user = request()->user();
    //     $post = Post::whereSlug($slug)->first();
    //     if (!$post) {
            
    //     }
    // }
}
