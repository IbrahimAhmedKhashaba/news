@extends('layouts.frontend.app')
@section('meta_description')
    {{ $MainCategory->small_desc }}
@endsection
@section('title')
    {{ $MainCategory->name }}
@endsection
@push('header')
    <link rel="canonical" href="{{ url()->full() }}">
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>
    <li class="breadcrumb-item active">{{ $MainCategory->name }}</li>
@endsection
@section('body')
    <div class="main-news">
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        @forelse($posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img src="{{ asset($post->images->first()->path) }}" />
                                    <div class="mn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info text-center w-100 m-5"><h4>Category is empty</h4></div>
                        @endforelse
                    </div>
                    {{ $posts->links() }}
                </div>

                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2>Other Categories</h2>
                        <ul>
                            @foreach ($categories as $category)
                                @if ($MainCategory->slug != $category->slug)
                                    <li><a
                                            href="{{ route('frontend.category.posts', $category->slug) }}">{{ $category->name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
