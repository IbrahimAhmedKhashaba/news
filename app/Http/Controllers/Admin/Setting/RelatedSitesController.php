<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RelatedSitesRequest;
use App\Models\RelatedNewsSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RelatedSitesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $related_sites = RelatedNewsSite::all();
        return view('dashboard.related_sites.index', compact('related_sites'));
    }

    public function store(RelatedSitesRequest $request)
    {
        //
        try{
            RelatedNewsSite::create([
                'name' => $request->name,
                'url' => $request->url,
            ]);
        } catch (\Exception $e){
            return redirect()->back()->with('error' , $e->getMessage());
        }
        Session::flash('success' , 'Related Site Created Successfully');
        return redirect()->route('admin.related_sites.index');
    }

    public function update(RelatedSitesRequest $request, string $id)
    {
        //
        try{
            $site = RelatedNewsSite::findOrFail($id);
            $site->update([
                'name' => $request->name,
                'url' => $request->url,
            ]);
        } catch (\Exception $e){
            return redirect()->back()->with('error' , $e->getMessage());
        }
        Session::flash('success' , 'Related Site Updated Successfully');
        return redirect()->route('admin.related_sites.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $site = RelatedNewsSite::findOrFail($id);
        $site->delete();
        Session::flash('success' , 'Related Site Deleted Successfully');
        return redirect()->route('admin.related_sites.index');
    }
}
