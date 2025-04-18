<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(){
        $posts = Post::active()->with(['images' , 'comments'])->orderBy('created_at' , 'desc')->paginate(9);
        $greatest_views_posts = Post::active()->with(['images' , 'comments'])->orderBy('num_of_views' , 'desc')->limit(3)->get();
        $oldest_posts = Post::active()->with(['images' , 'comments'])->oldest()->take(3)->get();


        $categories = Category::active()->get();
        $category_with_posts = $categories->map(function($category){
            $category->posts = $category->posts()->active()->limit(4)->get();
            return $category;
        });
        return view('frontend.index' , compact(['posts' , 'greatest_views_posts' , 'oldest_posts' , 'category_with_posts']));
    }
}
