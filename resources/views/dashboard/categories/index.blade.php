@extends('layouts.dashboard.app')
@section('title')
    Categories
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Categories Table</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    @include('dashboard.categories.create')
                </div>
                {{-- Start Filter Categories --}}
                @include('dashboard.categories.filter.filter')
                {{-- End Filter Categories --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Posts Count</th>
                                    <th>status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Desc</th>
                                    <th>status</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->posts_count }}</td>
                                        <td><span
                                                class="badge badge-{{ $category->status ? 'success' : 'danger' }}">{{ $category->status ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @include('dashboard.categories.edit')
                                                <a class="btn"
                                                    href="{{ route('admin.categories.updateStatus', $category->id) }}"><i
                                                        class="fa @if ($category->status) {{'fa-stop' }} @else{{'fa-play' }} @endif"></i></a>
                                                <a class="btn" href="javascript:void(0)"
                                                    onclick="getElementById('delete-form-{{ $category->id }}').submit()"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                            <form id="delete-form-{{ $category->id }}" style="display: none;"
                                                action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST">
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
                        {{ $categories->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
