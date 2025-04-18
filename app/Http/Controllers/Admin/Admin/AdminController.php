<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Models\Admin;
use App\Models\Authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('can:admins');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $admins = Admin::when(request()->keyword, function ($query) {
            $query->where('name', 'like', '%' . request()->keyword . '%')
                ->orWhere('email', 'like', '%' . request()->keyword . '%');
        })->when(!is_null(request()->status), function ($query) {
            return $query->where('status', request()->status);
        })->orderBy(request('sort_by', 'id'), request('order_by', 'asc'))
            ->paginate(request('limit', 10));
        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $authorizations = Authorization::select('id', 'role')->get();
        return view('dashboard.admins.create', compact('authorizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        //
        try {
            Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'authorization_id' => $request->authorization_id,
                'password' => bcrypt($request->password),
                'status' => $request->status,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        Session::flash('success', 'Admin Created Successfully');
        return redirect()->route('admin.admins.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->back()->with('error', 'Admin Not Found');
        }
        return view('dashboard.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $admin = Admin::find($id);
        $authorizations = Authorization::select('id', 'role')->get();
        return view('dashboard.admins.edit', compact('admin', 'authorizations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $admin = Admin::findOrFail($id);
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->username = $request->username;
            $admin->authorization_id = $request->authorization_id;
            $admin->status = $request->status;
            if($request->password){
                $admin->password = bcrypt($request->password);
            }
            $admin->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        Session::flash('success', 'Admin Updated Successfully');
        return redirect()->route('admin.admins.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $admin = Admin::findOrFail($id);
        $admin->delete();
        Session::flash('success', 'Admin Deleted Successfully');
        return redirect()->route('admin.admins.index');
    }

    public function updateStatus($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->status = $admin->status == 1 ? 0 : 1;
        $admin->save();
        Session::flash('success', 'Admin Status Updated Successfully');
        return redirect()->back();
    }
}
