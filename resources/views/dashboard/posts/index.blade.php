@extends('layouts.dashboard.app')
@section('title')
Posts
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Posts Table</h1>
            
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Posts Management</h6>
                </div>
                {{-- Start Filter Users --}}
                @include('dashboard.posts.filter.filter')
                {{-- End Filter Users --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>title</th>
                                    <th>Views</th>
                                    <th>status</th>
                                    <th>User</th>
                                    <th>Category</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>title</th>
                                    <th>Views</th>
                                    <th>status</th>
                                    <th>User</th>
                                    <th>Category</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->num_of_views }}</td>

                                        <td><span
                                                class="badge badge-{{ $post->status ? 'success' : 'danger' }}">{{ $post->status ? 'Active' : 'Inactive' }}</span>
                                        </td>
                                        <td>{{ $post->user->name ?? $post->admin->name }}</td>
                                        <td>{{ $post->category->name }}</td>
                                        <td>{{ $post->created_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="d-flex">
                                                
                                                <a class="btn" href="{{ route('admin.posts.show', $post->id) }}"><i
                                                        class="fa fa-eye"></i></a>
                                                <a class="btn"
                                                    href="{{ route('admin.posts.updateStatus', $post->id) }}"><i
                                                        class="fa @if ($post->status) {{ 'fa-stop' }} @else{{ 'fa-play' }} @endif"></i></a>
                                                <a class="btn" href="javascript:void(0)"
                                                    onclick="getElementById('delete-form-{{ $post->id }}').submit()"><i
                                                        class="fa fa-trash"></i></a>
                                                        @if ($post->admin_id == auth()->guard('admin')->id())
                                                    <a class="btn" href="{{ route('admin.posts.edit', $post->id) }}"><i
                                                            class="fa fa-pen"></i></a>
                                                @endif
                                            </div>
                                            
                                            <form id="delete-form-{{ $post->id }}" style="display: none;"
                                                action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
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
                        {{ $posts->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
