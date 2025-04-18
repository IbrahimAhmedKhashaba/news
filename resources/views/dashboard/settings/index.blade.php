@extends('layouts.dashboard.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet" />
@endpush
@section('title')
    Settings
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body shadow">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="site_name">Site Name:</label>
                                <input value="{{ $settings->site_name }}" type="text" name="site_name"
                                    class="form-control" id="site_name" placeholder="Enter User site_name">
                                @error('site_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input value="{{ $settings->email }}" type="email" name="email" class="form-control"
                                    id="email" placeholder="Enter User Email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="facebook">Facebook:</label>
                                <input value="{{ $settings->facebook }}" type="text" name="facebook" class="form-control"
                                    id="facebook" placeholder="Enter User facebook">
                                @error('facebook')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="twitter">Twitter:</label>
                                <input value="{{ $settings->twitter }}" type="text" name="twitter" class="form-control"
                                    id="twitter" placeholder="Enter User twitter">
                                @error('twitter')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instagram">Instagram:</label>
                                <input value="{{ $settings->instagram }}" type="text" name="instagram"
                                    class="form-control" id="instagram" placeholder="Enter User instagram">
                                @error('instagram')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="youtube">Youtube:</label>
                                <input value="{{ $settings->youtube }}" type="text" name="youtube" class="form-control"
                                    id="youtube" placeholder="Enter User youtube">
                                @error('youtube')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input value="{{ $settings->phone }}" type="text" name="phone" class="form-control"
                                    id="phone" placeholder="Enter User phone">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input value="{{ $settings->country }}" type="text" name="country" class="form-control"
                                    id="country" placeholder="Enter User country">
                                @error('country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input value="{{ $settings->city }}" type="text" name="city" class="form-control"
                                    id="city" placeholder="Enter User city">
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="street">Street</label>
                                <input value="{{ $settings->street }}" type="text" name="street"
                                    class="form-control" id="street" placeholder="Enter User street">
                                @error('street')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input data-default-file="{{ asset($settings->logo) }}" type="file" name="logo" class="form-control" id="logo"
                                    placeholder="Enter User logo">
                                @error('logo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label  for="favicon">Favicon</label>
                                <input data-default-file="{{ asset($settings->favicon) }}" type="file" name="favicon" class="form-control" class="dropify" id="favicon"
                                    placeholder="Enter User favicon">
                                @error('favicon')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="small_desc">Small Desc</label>
                            <textarea type="text" name="small_desc" class="form-control" id="small_desc"
                                placeholder="Enter Site Small Desc">{{ $settings->small_desc }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <button class="btn btn-primary" type="submit">Submit</button>
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
    </script>
@endpush
