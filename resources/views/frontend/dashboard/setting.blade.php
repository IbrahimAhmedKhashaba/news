@extends('layouts.frontend.app')
@section('meta_description')
    settings Page of News website
@endsection
@section('title')
    Settings
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Settings</li>
@endsection
@section('body')
    <div class="dashboard container">
        <!-- Sidebar -->


        <!-- Sidebar Menu -->
        @include('frontend.dashboard._sidebar', [
            'settings_active' => 'active',
        ])


        <!-- Main Content -->
        <div class="main-content">
            <!-- Settings Section -->
            <section id="settings" class="">
                <h2>Settings</h2>
                <form class="settings-form" action="{{ route('frontend.dashboard.settings.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input name="name" type="text" id="name" value="{{ $user->name }}" />
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input name="username" type="text" id="username" value="{{ $user->username }}" />
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input name="email" type="email" id="email" value="{{ $user->email }}" />
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input name="phone" type="text" id="phone" value="{{ $user->phone }}" />
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="profile-image">Profile Image:</label>
                        <input name="image" type="file" id="profile-image" accept="image/*" />
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                      <img id="show-profile-image" src="{{ asset($user->image) }}" class="img-thumbnail" alt="USer Image" width="180px">
                    </div>
                    <div class="form-group">
                        <label for="country">Country:</label>
                        <input name="country" value="{{ $user->country }}" type="text" id="country"
                            placeholder="Enter your country" />
                        @error('country')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input name="city" type="text" id="city" placeholder="Enter your city"
                            value="{{ $user->city }}" />
                        @error('city')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input name="street" type="text" id="street" placeholder="Enter your street"
                            value="{{ $user->street }}" />
                        @error('street')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="save-settings-btn">
                        Save Changes
                    </button>
                </form>

                <!-- Form to change the password -->
                <form class="change-password-form" action="{{ route('frontend.dashboard.settings.changePassword') }}"
                    method="POST">
                    @csrf
                    <h2>Change Password</h2>
                    <div class="form-group">
                        <label for="current-password">Current Password:</label>
                        <input name="currentPassword" type="password" id="current-password"
                            placeholder="Enter Current Password" />
                        @error('currentPassword')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password:</label>
                        <input name="password" type="password" id="new-password" placeholder="Enter New Password" />
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm New Password:</label>
                        <input name="password_confirmation" type="password" id="confirm-password"
                            placeholder="Enter Confirm New " />
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="change-password-btn">
                        Change Password
                    </button>
                </form>
            </section>
        </div>
    </div>
@endsection
@push('js')
    <script>
      $(document).on('change' , '#profile-image' , function(e){
        e.preventDefault();
        var file = this.files[0];
        if(file){
          var reader = new FileReader();
          reader.onload = function(e){
            $('#show-profile-image').attr('src' , e.target.result);
          }
          reader.readAsDataURL(file);
        }
      });
    </script>
@endpush