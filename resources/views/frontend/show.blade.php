@extends('layouts.frontend.app')
@section('meta_description')
    {{ $mainPost->small_desc }}
@endsection
@section('title')
    Show {{ $mainPost->title }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>
    <li class="breadcrumb-item">{{ $mainPost->category->name }}</li>
    <li class="breadcrumb-item active">{{ $mainPost->title }}</li>
@endsection
@section('body')

    <!-- Single News Start-->
    <div class="single-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Carousel -->
                    <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#newsCarousel" data-slide-to="1"></li>
                            <li data-target="#newsCarousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($mainPost->images as $image)
                                <div class="carousel-item @if ($loop->index == 0) active @endif">
                                    <img src="{{ asset($image->path) }}" class="d-block w-100" alt="First Slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $mainPost->title }}</h5>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Add more carousel-item blocks for additional slides -->
                        </div>
                        <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <div class="fs-1 mt-5">
                        <h2>Auther: {{ $mainPost->user->name ?? $mainPost->admin->name }}</h2>
                    </div>
                    <div class="sn-content">
                        {!! $mainPost->desc !!}
                    </div>

                    <!-- Comment Section -->
                    @if ($mainPost->comment_able && auth('web')->user())
                        <div class="comment-section">
                            <!-- Comment Input -->
                            <form id="commentForm">
                                <div class="comment-input">
                                    @csrf
                                    <input id='commentInput' name="comment" type="text" placeholder="Add a comment..." />
                                    <input name="post_id" type="hidden" value="{{ $mainPost->id }}" />
                                    <button type="submit" id="addCommentBtn">Post</button>
                                </div>
                            </form>

                            <div style="display:none" id="errorMsg" class="alert alert-danger">

                            </div>
                            <!-- Display Comments -->
                            <div class="comments">
                                @foreach ($comments as $comment)
                                    <div class="comment">
                                        <img src="{{ asset($comment->user->image) }}" alt="User Image"
                                            class="comment-img" />
                                        <div class="comment-content">
                                            <span class="username">{{ $comment->user->name }}</span>
                                            <p class="comment-text">{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Add more comments here for demonstration -->
                            </div>

                            <!-- Show More Button -->
                            @if ($comments->count() > 2)
                                <button id="showMoreBtn" class="show-more-btn">Show more</button>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-primary text-center">
                            Unable to comment
                        </div>
                    @endif

                    <!-- Related News -->
                    <div class="sn-related">
                        <h2>Related News</h2>
                        <div class="row sn-slider">
                            @foreach ($posts_belongs_to_category as $post)
                                <div class="col-md-4">
                                    <div class="sn-img">
                                        <img src="{{ asset($post->images->first()->path) }}" class="img-fluid"
                                            alt="Related News 1" />
                                        <div class="sn-title">
                                            <a
                                                href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="sidebar-widget">
                            <h2 class="sw-title">In This Category</h2>
                            <div class="news-list">
                                @foreach ($posts_belongs_to_category as $post)
                                    <div class="nl-item">
                                        <div class="nl-img">
                                            <img src="{{ asset($post->images->first()->path) }}" />
                                        </div>
                                        <div class="nl-title">
                                            <a
                                                href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <div class="tab-news">
                                <ul class="nav nav-pills nav-justified">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#featured">Latest News</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#popular">Popular</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="featured" class="container tab-pane active">
                                        @foreach ($latest_posts as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img src="{{ asset($post->images->first()->path) }}" />
                                                </div>
                                                <div class="tn-title">
                                                    <a
                                                        href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div id="popular" class="container tab-pane fade">
                                        @foreach ($greatest_posts_comments as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img src="{{ asset($post->images->first()->path) }}" />
                                                </div>
                                                <div class="tn-title">
                                                    <a
                                                        href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-widget">
                        <h2 class="sw-title">News Category</h2>
                        <div class="category">
                            <ul class="p-0 m-0 ">
                                @foreach ($categories as $category)
                                    @if ($category->id != $mainPost->category->id)
                                        <li class="p-0 m-0 d-flex justify-content-between"><a
                                                href="">{{ $category->name }}</a><span
                                                class="ms-auto">({{ $category->posts->count() }})</span></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Single News End-->
@endsection

@push('js')
    <script>
        $(document).on('click', '#showMoreBtn', function(e) {
            e.preventDefault();
            $.ajax({
                'url': "{{ route('frontend.post.getAllComments', $mainPost->slug) }}",
                'type': 'GET',
                'success': function(data) {
                    $('.comments').empty();
                    $.each(data, function(key, comment) {
                        var image = `{{ asset(':img') }}`.replace(':img', comment.user.image);
                        $('.comments').append(
                            `
                            <div class="comment">
                                    <img width="100px" src="${ image }" alt="User Image" class="comment-img" />
                                    <div class="comment-content">
                                        <span class="username">${ comment.user.name }</span>
                                        <p class="comment-text">${ comment.comment }</p>
                                    </div>
                                </div>
                            `
                        );
                    })
                    $('#showMoreBtn').hide();
                }
            });
        });

        $(document).on('submit', '#commentForm', function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);


            $.ajax({

                'url': "{{ route('frontend.post.comment.store') }}",
                'type': 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#commentInput').val('');
                    $('#errorMsg').hide();
                    var image = `{{ asset(':img') }}`.replace(':img', data.comment.user.image);

                    $('.comments').prepend(
                        `
                            <div class="comment">
                                    <img width="100px" src="${image }" alt="User Image" class="comment-img" />
                                    <div class="comment-content">
                                        <span class="username">${ data.comment.user.name }</span>
                                        <p class="comment-text">${ data.comment.comment }</p>
                                    </div>
                                </div>
                            `
                    );
                },
                error: function(data) {
                    $('#errorMsg').show();
                    var response = $.parseJSON(data.responseText);
                    $('#errorMsg').text(response.errors.comment);
                }
            })
        });
    </script>
@endpush
