@extends('layouts.dashboard.app')
@section('title')
    Roles
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Roles Table</h1>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-2 pt-2">
                            @include('dashboard.authorizations.create')
                        </div>
                        
                    </div>
                    @error('role')
                            <span class="text-danger">{{ $message }}, </span>
                        @enderror
                        @error('permissions')
                            <span class="text-danger">{{ $message }}, </span>
                        @enderror
                </div>


                {{-- Start Filter Users --}}
                {{-- @include('dashboard.admins.filter.filter') --}}
                {{-- End Filter Users --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>permissions</th>
                                    <th>Admins Count</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Role</th>
                                    <th>permissions</th>
                                    <th>Admins Count</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($authorizations as $authorization)
                                    <tr>
                                        <td>{{ $authorization->role }}</td>
                                        <td>|
                                            @foreach ($authorization->permissions as $permission)
                                                <span class="badge badge-success">{{ $permission }}</span> |
                                            @endforeach
                                        </td>
                                        <td>{{ $authorization->admins_count }}</td>
                                        <td>{{ date_format($authorization->created_at, 'd-m-Y') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                @include('dashboard.authorizations.edit')
                                                @if ($authorization->admins_count == 0)
                                                    <a class="btn" href="javascript:void(0)"
                                                        onclick="getElementById('delete-form-{{ $authorization->id }}').submit()"><i
                                                            class="fa fa-trash"></i></a>
                                                @endif
                                            </div>
                                            <form id="delete-form-{{ $authorization->id }}" style="display: none;"
                                                action="{{ route('admin.authorizations.destroy', $authorization->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
