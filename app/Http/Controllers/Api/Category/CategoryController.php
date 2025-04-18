<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Post\PostCollection;
use App\Models\Category;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    use ApiResponseTrait;
    public function getCategories(){
        $categories = Category::with(['posts'=>function($query){
            $query->active()->latest()->with('images');
        }
        ])->active()->get();
        if(!$categories){
            return $this->apiResponse(null, 'there is no categories', 404);
        }
        return $this->apiResponse(new CategoryCollection($categories), 'categories retrieved successfully', 200);
    }
    public function getCategoryPosts($slug){
        $category = Category::active()->with(['posts' => function($query){
            $query->active()->latest()->with('images');
        }])->whereSlug($slug)->first();
        if(!$category){
            return $this->apiResponse(null, 'there is no categories', 404);
        }
        $posts = $category->posts;
        return $this->apiResponse(new PostCollection($posts), 'posts retrieved successfully', 200);
    }
}
