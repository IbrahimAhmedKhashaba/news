<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(){
        $this->middleware('can:categories');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::withCount('posts')->when(request()->keyword , function($query){
            $query->where('name' , 'like' , '%'.request()->keyword.'%')
            ->orWhere('small_desc' , 'like' , '%'.request()->keyword.'%');
        })->when(!is_null(request()->status) , function($query){
            return $query->where('status' , request()->status);
        })->orderBy(request('sort_by' , 'id'), request('order_by' , 'asc'))
        ->paginate(request('limit' , 10));
        return view('dashboard.categories.index' , compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        try{
            Category::create([
                'name' => $request->name,
                'small_desc' => $request->small_desc,
                'status' => $request->status,
            ]);
        } catch (\Exception $e){
            return redirect()->back()->with('error' , $e->getMessage());
        }
        Session::flash('success' , 'Category Created Successfully');
        return redirect()->route('admin.categories.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, string $id)
    {
        //
        try{
            $category = Category::findOrFail($id);
            $category->update([
                'name' => $request->name,
                'small_desc' => $request->small_desc,
                'status' => $request->status,
            ]);
        } catch (\Exception $e){
            return redirect()->back()->with('error' , $e->getMessage());
        }
        Session::flash('success' , 'Category Updated Successfully');
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = Category::findOrFail($id);
        $category->delete();
        Session::flash('success' , 'Category Deleted Successfully');
        return redirect()->route('admin.categories.index');
    }

    public function updateStatus($id){
        $category = Category::findOrFail($id);
        $category->status = $category->status == 1 ? 0 : 1;
        $category->save();
        Session::flash('success' , 'Category Status Updated Successfully');
        return redirect()->back();
    }
}
