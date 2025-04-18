@extends('layouts.dashboard.app')
@section('title')
Admins
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Admins Table</h1>
            

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-2 pt-2">
                            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                                Create Admin
                            </a>
                        </div>
                    </div>
                
                </div>

                
                {{-- Start Filter Users --}}
                @include('dashboard.admins.filter.filter')
                {{-- End Filter Users --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->authorization->role }}</td>
                                        <td><span
                                            class="badge badge-{{ $admin->status ? 'success' : 'danger' }}">{{ $admin->status ? 'Active' : 'Inactive' }}</span>
                                    </td>
                                        <td>{{ date_format($admin->created_at , 'd-m-Y') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn" href="{{ route('admin.admins.show', $admin->id) }}"><i class="fa fa-eye"></i></a>
                                                <a class="btn" href="{{ route('admin.admins.edit', $admin->id) }}"><i class="fa fa-edit"></i></a>
                                                <a class="btn" href="{{ route('admin.admins.updateStatus', $admin->id) }}"><i class="fa fa-@if($admin->status){{ 'stop' }} @else{{ 'play' }} @endif"></i></a>
                                                <a class="btn" href="javascript:void(0)" onclick="getElementById('delete-form-{{ $admin->id }}').submit()"><i class="fa fa-trash"></i></a>
                                            </div>
                                            <form id="delete-form-{{ $admin->id }}" style="display: none;" action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>

                                    </tr>
                                
                                @endforeach
                            </tbody>
                        </table>
                        {{ $admins->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
