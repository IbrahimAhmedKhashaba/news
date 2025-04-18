@extends('layouts.dashboard.app')
@section('title')
Posts
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="card-body shadow">
                <div class="row">
                    <div class="col-md-6">
                        <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#newsCarousel" data-slide-to="1"></li>
                                <li data-target="#newsCarousel" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                @foreach ($post->images as $image)
                                    <div class="carousel-item @if ($loop->index == 0) active @endif">
                                        <img src="{{ asset($image->path) }}" class="d-block w-100" alt="First Slide">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>{{ $post->title }}</h5>
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
                    </div>

                    <div class="col-md-6">
                        <div class="fs-1 mt-5">
                            <h2>Auther: {{ $post->user->name ?? $post->admin->name }}</h2>
                        </div>
                        <div class="my-2 sn-content">
                            Category: {{ $post->category->name }}
                        </div>
                        <div class="my-2 sn-content">
                            Views: {{ $post->num_of_views }}
                        </div>
                        <div class="my-2 sn-content">
                            Comments: {{ $post->comment_able ? 'Available' : 'Not available' }}
                        </div>
                        <div class="my-2 sn-content">
                            Created: {{ $post->created_at->diffForHumans() }}
                        </div>
                        <div class="my-2 sn-content">
                            Small Description: {{ $post->small_desc }}
                        </div>
                        <div class="my-2 sn-content">
                            Description: {!! $post->desc !!}
                        </div>
                        <div class="row justify-content-center text-center">
                            <div class="col-md-6">
                                <a class="btn {{ $post->status ? 'btn-danger' : 'btn-primary' }} "
                                    href="{{ route('admin.posts.updateStatus', $post->id) }}">{{ $post->status ? 'Un active' : 'Active' }}</a>
                                @if ($post->admin_id == auth()->guard('admin')->id())
                                    <a class="btn btn-success " href="{{ route('admin.posts.edit', $post->id) }}">Edit</a>
                                @endif
                                @if ($post->admin_id == auth()->guard('admin')->id())
                                    <a class="btn btn-info" href="javascript:void(0)"
                                        onclick="getElementById('delete-form').submit()">Delete</a>
                                @endif
                            </div>
                        </div>
                        <form id="delete-form" style="display: none;"
                            action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>


                <div class="main-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="mb-4">Comments:</h2>
                            </div>
                        </div>
                        <div class="comments">
                            @forelse($comments as $comment)
                                <div class="notification alert alert-info row">
                                    <div class="col-md-11 d-flex">
                                        <img src="{{ asset($comment->user->image) }}" width="100px" alt="User Image"
                                            class="comment-img rounded-circle me-2" />
                                        <div class="comment-content ms-2">
                                            <span class="username fw-bold">{{ $comment->user->name }}</span>
                                            <p class="comment-text">{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                    <div class="float-right d-flex align-items-center col-md-1">
                                        <form class="mx-2 delete-comment-form"
                                            action="{{ route('admin.post.deleteComment', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="notification alert alert-info text-center">
                                    No comments on this post.
                                </div>
                            @endforelse
                        </div>

                        @if ($post->comments_count > 3)
                            <div class="row justify-content-center">
                                <button id="showMoreBtn" class="show-more-btn btn btn-primary px-4 py-2">Show more</button>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click', '#showMoreBtn', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.posts.getAllComments', $post->id) }}",
                type: 'GET',
                success: function(data) {
                    $('.comments').empty();
                    $.each(data, function(key, comment) {
                        var deleteCommentRoute = `{{ route('admin.post.deleteComment', ':id') }}`.replace(':id', comment.id);
                        //var deleteCommentRoute = `http://127.0.0.1:8000/admin/comment/delete/${comment.id}`;

                        const deleteButton = 
                            `
                                <form class="mx-2 delete-comment-form" action="${deleteCommentRoute}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                                </form>
                              `;
                                var image = `{{ asset(':image')}}`.replace(':image', comment.user.image);
                        $('.comments').append(
                            `
                            <div class="notification alert alert-info row">
                                <div class="col-md-11 d-flex">
                                    <img width="100px" src="${image}" alt="User Image" class="comment-img rounded-circle me-2" />
                                    <div class="comment-content ms-2">
                                        <span class="username">${comment.user.name}</span>
                                        <p class="comment-text">${comment.comment}</p>
                                    </div>
                                </div>
                                <div class="float-right d-flex align-items-center col-md-1">
                                    ${deleteButton}
                                </div>
                            </div>
                            `
                        );
                    });

                    $('#showMoreBtn').hide();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching comments:', error);
                }
            });
        });

        // Handle delete form submission via AJAX
        $(document).on('submit', '.delete-comment-form', function(e) {
            e.preventDefault();

            const form = $(this);
            const url = form.attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        console.log(form.closest('.notification').remove());
                        form.closest('.notification').remove();
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
