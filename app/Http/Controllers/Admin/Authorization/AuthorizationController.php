<?php

namespace App\Http\Controllers\Admin\Authorization;

use App\Http\Controllers\Controller;
use App\Models\Authorization;
use App\Models\Authorizations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthorizationController extends Controller
{
    public function __construct(){
        $this->middleware('can:authorizations');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $authorizations = Authorization::withCount('admins')->get();
        $permissions = config('authorization.permissions');
        return view('dashboard.authorizations.index' , compact('authorizations' , 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'role' => 'required|string|max:255',
            'permissions' => 'required|array',
            'permissions.*' => 'string|in:posts,users,admins,categories,settings,contacts,home',
        ]);
        try{
            Authorization::create([
                'role' => $request->role,
                'permissions' => $request->permissions,
            ]);
            Session::flash('success', 'Role created successfully');
        } catch(\Exception $e){
            Session::flash('errors' , $e->getMessage());
        }
        return redirect()->route('admin.authorizations.index');
    }

    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'role' => 'required|string|max:255',
            'permissions' => 'required',
            'permissions.*' => 'string|in:posts,users,admins,categories,settings,contacts',
        ]);
        
        try{
            $authorization = Authorization::find($id);
            $authorization->update([
                'role' => $request->role,
                'permissions' => $request->permissions,
            ]);
        } catch(\Exception $e){
            Session::flash('error' , $e->getMessage());
        }
        
        Session::flash('success', 'Role Updated successfully');
        return redirect()->route('admin.authorizations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $authorization = Authorization::withCount('admins')->findOrFail($id);
        if($authorization->admins_count > 0){
            Session::flash('error' , 'This role is assigned to some admins! Please select a role that is not assigned to any admin');
            return redirect()->route('admin.authorizations.index');
        }
        $authorization->delete();
        Session::flash('success' , 'Authorization Deleted Successfully');
        return redirect()->route('admin.authorizations.index');
    }
}
