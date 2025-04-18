<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    //
    public function index(){
        $contacts = Contact::when(request()->keyword , function($query){
            $query->where('title' , 'like' , '%'.request()->keyword.'%')
            ->orWhere('body' , 'like' , '%'.request()->keyword.'%')
            ->orWhere('name' , 'like' , '%'.request()->keyword.'%');
        })->when(!is_null(request()->status) , function($query){
            return $query->where('status' , request()->status);
        })->orderBy(request('sort_by' , 'id'), request('order_by' , 'asc'))
        ->paginate(request('limit' , 10));
        return view('dashboard.contacts.index' , compact('contacts'));
    }

    public function show($id){
        $contact = Contact::findOrFail($id);
        $contact->status = 1;
        $contact->save();
        return view('dashboard.contacts.show' , compact('contact'));
    }

    public function destroy($id){
        $contact = Contact::findOrFail($id);
        $contact->delete();
        Session::flash('success' , 'Contact Deleted Successfully');
        return redirect()->route('admin.contacts.index');
        
    }
}
