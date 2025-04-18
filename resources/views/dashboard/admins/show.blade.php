@extends('layouts.dashboard.app')
@section('title')
Admins
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="card-body shadow">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Name: {{ $admin->name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Email: {{ $admin->email }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="User Name: {{ $admin->username }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control"
                                value="Status: @if ($admin->status) Active @else Inactive @endif">

                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Phone: {{ $admin->phone }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Country: {{ $admin->country }}">
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="City: {{ $admin->city }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input disabled class="form-control" value="Street: {{ $admin->street }}">
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center text-center">
                    <div class="col-md-4">
                        @can('admins')
                        <a class="btn {{ $admin->status ? 'btn-danger' : 'btn-primary' }} "
                            href="{{ route('admin.admins.updateStatus', $admin->id) }}">{{ $admin->status ? 'Block' : 'Active' }}</a>
                        @endcan
                    <a class="btn btn-info" href="javascript:void(0)"
                        onclick="getElementById('delete-form').submit()">Delete</a>
                    </div>
                </div>
                <form id="delete-form" style="display: none;" action="{{ route('admin.admins.destroy', $admin->id) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
