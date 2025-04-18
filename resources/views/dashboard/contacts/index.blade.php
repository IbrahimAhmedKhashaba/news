@extends('layouts.dashboard.app')
@section('title')
Contacts
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Contact Table</h1>
            

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Messages Management</h6>
                </div>
                {{-- Start Filter Users --}}
                @include('dashboard.contacts.filter.filter')
                {{-- End Filter Users --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Title</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Title</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse($contacts as $contact)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->title }}</td>
                                        
                                        <td>{{ $contact->phone }}</td>
                                        <td><span
                                            class="badge badge-{{ $contact->status == 0 ? 'success' : 'danger' }}">{{ $contact->status == 0 ? 'Unread' : 'Read' }}</span>
                                    </td>
                                        <td>{{ date_format($contact->created_at , 'd-m-Y') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn" href="{{ route('admin.contacts.show', $contact->id) }}"><i class="fa fa-eye"></i></a>
                                            <a class="btn" href="javascript:void(0)" onclick="getElementById('delete-form-{{ $contact->id }}').submit()"><i class="fa fa-trash"></i></a>
                                            </div>
                                            <form id="delete-form-{{ $contact->id }}" style="display: none;" action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>

                                    </tr>
                                @empty
                                    <div>No Messages Found</div>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $contacts->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
