@extends('layouts.dashboard.app')
@section('title')
Admins
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <form action="{{ route('admin.admins.update' , $admin->id) }}" method="post">
                @csrf
                @method('put')
                <div class="card-body shadow">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $admin->name }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                value="{{ $admin->email }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="Adminname"
                                value="{{ $admin->username }}">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="">Select Status</option>
                                    <option @selected($admin->status == 1) value="1">Active</option>
                                    <option @selected($admin->status == 0) value="0">Inactive</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="authorization_id">Role</label>
                                <select name="authorization_id" class="form-control" id="authorization_id">
                                    <option value="">Select Role</option>
                                    @foreach($authorizations as $authorization)
                                        <option @selected($admin->authorization_id == $authorization->id) value="{{ $authorization->id }}">{{ $authorization->role }}</option>
                                    @endforeach
                                </select>
                                @error('authorization_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Keep it empty to keep the old password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="password_confirmation" placeholder="Keep it empty to keep the old password">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>

            </form>

        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
