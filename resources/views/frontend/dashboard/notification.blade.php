@extends('layouts.frontend.app')
@section('meta_description')
    Notifications Page of News website
@endsection
@section('title')
    Profile
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>
<li class="breadcrumb-item active">Notifications</li>
@endsection
@section('body')
    <!-- Dashboard Start-->
    <div class="dashboard container">
       

            <!-- Sidebar Menu -->
            @include('frontend.dashboard._sidebar' , [
                'notifications_active' => 'active'
            ])


        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="mb-4">Notifications</h2>
                    </div>
                    <div class="col-md-6">
                        <form class="float-right mx-2" action="{{ route('frontend.dashboard.notifications.deleteAll') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete All</button>
                        </form>
                    </div>
                </div>
                @forelse(auth()->user()->notifications as $notify)
                    <div class="notification alert @if(!$notify->read_at) alert-info @endif">
                        <strong>You have a notification from: {{ $notify->data['user_name'] }}</strong> on post: {{ $notify->data['post_title'] }} <br/> {{ $notify->created_at->diffForHumans() }}
                        <div class="float-right d-flex h-100">
                            <a href="{{ route('frontend.post.show' , $notify->data['post_slug']) }}?notify={{ $notify->id }}" class="btn btn-sm btn-danger"><i class="fas fa-eye"></i></a>
                            <form class="mx-2" action="{{ route('frontend.dashboard.notifications.delete' , $notify->id) }}" method="POST">
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
    <!-- Dashboard End-->
@endsection
