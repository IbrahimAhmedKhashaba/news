@extends('layouts.dashboard.app')

@section('title')
    Profile
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <form action="{{ route('admin.profile.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body shadow">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input value="{{ auth()->user()->name }}" type="text" name="name"
                                    class="form-control user_data" id="name" placeholder="Enter Name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="username">UserName:</label>
                                <input value="{{ auth()->user()->username }}" type="text" name="username"
                                    class="form-control user_data" id="username" placeholder="Enter userName">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input value="{{ auth()->user()->email }}" type="text" name="email"
                                    class="form-control user_data" id="email" placeholder="Enter email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                
                            </div>
                            @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            @include('dashboard.profile.confirm')
                        </div>

                    </div>
                </div>

            </form>

        </div>
        <!-- /.container-fluid -->
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $('#logo').dropify(
            {
    messages: {
        'default': 'Drop a file here',
        'replace': 'Drop a file here ',
        'remove':  'Remove',
        'error':   'Ooops, something wrong happended.'
    }
}
        );
        $('#favicon').dropify(
            {
    messages: {
        'default': 'Drop a file here',
        'replace': 'Drop a file here',
        'remove':  'Remove',
        'error':   'Ooops, something wrong happended.'
    }
}
        );


        $(document).ready(function () {
    $('.user_data').on('keypress', function (e) {
        if (e.which === 13) { 
            e.preventDefault();
            $('#exampleModal').modal('show');
        }
    });
});
    </script>
@endpush
