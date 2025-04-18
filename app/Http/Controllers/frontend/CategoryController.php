<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($slug)
    {
        //
        $MainCategory = Category::active()->with('posts')->whereSlug($slug)->first();
        $posts = $MainCategory->posts()->paginate(9);
        return view('frontend.category', compact( 'posts' , 'MainCategory'));
    }
}
