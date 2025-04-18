<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\User;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    use UploadImage;
    public function __construct(){
        $this->middleware('can:users');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::when(request()->keyword , function($query){
            $query->where('name' , 'like' , '%'.request()->keyword.'%')
            ->orWhere('email' , 'like' , '%'.request()->keyword.'%');
        })->when(!is_null(request()->status) , function($query){
            return $query->where('status' , request()->status);
        })->orderBy(request('sort_by' , 'id'), request('order_by' , 'asc'))
        ->paginate(request('limit' , 10));
        return view('dashboard.users.index' , compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
        try{
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'image'=> $this->uploadImage($request->image , 'uploads/users' , 'uploads'),
                'status' => $request->status,
                'country' => $request->country,
                'city' => $request->city,
                'phone' => $request->phone,
                'street' => $request->street,
                'email_verified_at' => now(),
            ]);
        } catch (\Exception $e){
            return redirect()->back()->with('error' , $e->getMessage());
        }
        Session::flash('success' , 'User Created Successfully');
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);
        if(!$user){
            return redirect()->back()->with('error' , 'User Not Found');
        }
        return view('dashboard.users.show' , compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::findOrFail($id);
        if($user->image){
            $this->deleteImage($user->image);
        }
        $user->delete();
        Session::flash('success' , 'User Deleted Successfully');
        return redirect()->route('admin.users.index');
    }

    public function updateStatus($id){
        $user = User::findOrFail($id);
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();
        Session::flash('success' , 'User Status Updated Successfully');
        return redirect()->back();
    }
}
