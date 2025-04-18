<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GeneralSearchController extends Controller
{
    public function __construct(){
        $this->middleware('can:search');
    }
    public function __invoke(Request $request)
    {
            $rules = [
                'keyword' => 'required|string',
                'option' => 'required|string',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                Session::flash('error', 'Please fill keyword field');
                return redirect()->back();
            }
            if($request->option == 'user'){
                $users = User::where('name', 'LIKE', '%'.$request->keyword.'%')
                ->orWhere('email', 'LIKE', '%'.$request->keyword.'%')
                ->orWhere('username', 'LIKE', '%'.$request->keyword.'%')
                ->paginate(10);
                return view('dashboard.users.index', compact('users'));
            } elseif($request->option == 'post'){
                $posts = Post::where('title', 'LIKE', '%'.$request->keyword.'%')
                ->orWhere('small_desc', 'LIKE', '%'.$request->keyword.'%')
                ->orWhere('desc', 'LIKE', '%'.$request->keyword)
                ->paginate(10);
                return view('dashboard.posts.index', compact('posts'));
            } elseif($request->option == 'category'){
                $categories = Category::withCount('posts')->where('name', 'LIKE', '%'.$request->keyword.'%')
                ->orWhere('small_desc', 'LIKE', '%'.$request->keyword.'%')
                ->paginate(10);
                return view('dashboard.categories.index', compact('categories'));
            } else {
                $contacts = Contact::where('name', 'LIKE', '%'.$request->keyword.'%')
                ->orWhere('email', 'LIKE', '%'.$request->keyword.'%')
                ->orWhere('title', 'LIKE', '%'.$request->keyword)
                ->orWhere('body', 'LIKE', '%'.$request->keyword)
                ->paginate(10);
                return view('dashboard.contacts.index', compact('contacts'));
            }
        }
}
