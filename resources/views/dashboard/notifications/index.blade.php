@extends('layouts.dashboard.app')
@section('title')
Notifications
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Notifications Table</h1>
            
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Notifications Management</h6>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">
                                @if($notifications->count() > 0)
                                <form class="float-right delete-all-notify-form float-right" action="{{ route('admin.notifications.deleteAll') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm m-2">Delete All</button>
                                </form>
                                @endif
                            </div>
                        </div>
                        <div class="notifications">
                            @forelse($notifications as $notify)
                            <div class="notification alert alert-info ">
                                <strong>You have a notification from: {{ $notify->data['user_name'] }}</strong><br/> {{ $notify->created_at->diffForHumans() }}
                                <div class="float-right d-flex h-100">
                                    <a href="{{ route('admin.contacts.show' , $notify->data['contact_id']) }}?notify={{ $notify->id }}" class="btn btn-sm btn-danger"><i class="fas fa-eye"></i></a>
                                    <form class="mx-2 delete-notify-form" action="{{ route('admin.notifications.destroy' , $notify->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                        <div class="notification alert alert-info text-center">
                            You have no notifications
                        </div>
                        
                        @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
@push('js')
    <script>
        

        // Handle delete form submission via AJAX
        $(document).on('submit', '.delete-notify-form', function(e) {
            e.preventDefault();

            const form = $(this);
            const url = form.attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        form.closest('.notification').remove();
                        if ($('.notifications').text().trim() == '') {
    $('.notifications').html(`
        <div class="notification alert alert-info text-center">
            You have no notifications
        </div>
    `);
}
                    } else {
                        alert('Failed to delete the comment.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting comment:', error);
                }
            });
        });

        $(document).on('submit', '.delete-all-notify-form', function(e) {
            e.preventDefault();

            const form = $(this);
            const url = form.attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('.notifications').empty();
                        if ($('.notifications').text().trim() == '') {
    $('.notifications').html(`
        <div class="notification alert alert-info text-center">
            You have no notifications
        </div>
    `);
}
                    } else {
                        alert('Failed to delete the comment.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting comment:', error);
                }
            });
        });
    </script>
@endpush
