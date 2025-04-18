@extends('layouts.frontend.app')
@section('meta_description')
    Search Page of News website
@endsection
@section('title')
    Search-page
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>
<li class="breadcrumb-item active">Search</li>
@endsection
@section('body')
    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @foreach($posts as $post)

                        @endforeach
                        @foreach ($posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img src="{{ asset($post->images->first()->path ) }}" />
                                    <div class="mn-title">
                                        <a href="{{ route('frontend.post.show' , $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End-->
@endsection
