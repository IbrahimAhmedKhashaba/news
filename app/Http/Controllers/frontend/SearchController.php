<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //

        $validator = $request->validate([
            'search' => 'string|required',
        ]);
        $search = strip_tags($request->search);
        $posts = Post::active()->where('title', 'LIKE', '%'.$search.'%')
        ->orWhere('desc', 'LIKE', '%'.$search.'%')
        ->paginate(9);
        return view('frontend.search' , compact('posts'));
    }
}
