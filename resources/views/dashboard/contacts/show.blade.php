@extends('layouts.dashboard.app')
@section('title')
    Contacts
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="card-body shadow">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Name: {{ $contact->name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Email: {{ $contact->email }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Phone: {{ $contact->phone }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control"
                                value="About: {{ $contact->title }}">

                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea disabled class="form-control">{{ $contact->body }}</textarea>
                        </div>
                    </div>
                    

                </div>
                <div class="row justify-content-center text-center">
                    <div class="col-md-4">
                        <a class="btn btn-primary"
                        href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->title) }}">Reply</a>
                    <a class="btn btn-info" href="javascript:void(0)"
                        onclick="getElementById('delete-form').submit()">Delete</a>
                    </div>
                </div>
                <form id="delete-form" style="display: none;" action="{{ route('admin.contacts.destroy', $contact->id) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
