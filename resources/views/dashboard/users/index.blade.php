@extends('layouts.dashboard.app')
@section('title')
Users
@endsection

@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Users Table</h1>
            
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Users Management</h6>
                </div>
                {{-- Start Filter Users --}}
                @include('dashboard.users.filter.filter')
                {{-- End Filter Users --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>status</th>
                                    <th>Country</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>status</th>
                                    <th>Country</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><span
                                                class="badge badge-{{ $user->status ? 'success' : 'danger' }}">{{ $user->status ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td>{{ $user->country }}</td>
                                        <td>{{ date_format($user->created_at , 'd-m-Y') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn" href="{{ route('admin.users.show', $user->id) }}"><i class="fa fa-eye"></i></a>
                                            <a class="btn" href="{{ route('admin.users.updateStatus', $user->id) }}"><i class="fa fa-@if($user->status){{ 'stop' }} @else{{ 'play' }} @endif"></i></a>
                                            <a class="btn" href="javascript:void(0)" onclick="getElementById('delete-form-{{ $user->id }}').submit()"><i class="fa fa-trash"></i></a>
                                            </div>
                                            <form id="delete-form-{{ $user->id }}" style="display: none;" action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>

                                    </tr>
                                @empty
                                    <div>No User Found</div>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $users->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
