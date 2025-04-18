@extends('layouts.dashboard.app')
@section('title')
Users
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="card-body shadow">
                <div class="row text-center justify-content-center">
                    <div class="col-md-8 my-3">
                        <img width="50%" src="{{ asset($user->image) }}" alt="User Image">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Name: {{ $user->name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Email: {{ $user->email }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="User Name: {{ $user->username }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control"
                                value="Status: @if ($user->status) Active @else Inactive @endif">

                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Phone: {{ $user->phone }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Country: {{ $user->country }}">
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="City: {{ $user->city }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Street: {{ $user->street }}">
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center text-center">
                    <div class="col-md-4">
                        <a class="btn {{ $user->status ? 'btn-danger' : 'btn-primary' }} "
                        href="{{ route('admin.users.updateStatus', $user->id) }}">{{ $user->status ? 'Block' : 'Active' }}</a>
                    <a class="btn btn-info" href="javascript:void(0)"
                        onclick="getElementById('delete-form').submit()">Delete</a>
                    </div>
                </div>
                <form id="delete-form" style="display: none;" action="{{ route('admin.users.destroy', $user->id) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
