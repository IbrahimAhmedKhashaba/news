@extends('layouts.frontend.app')
@section('meta_description')
    Profile Page of {{ auth()->user()->name }}
@endsection
@section('title')
    Profile
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>
<li class="breadcrumb-item active">Profile</li>
@endsection
@section('body')
    <!-- Profile Start -->
    <div class="dashboard container">
        <!-- Sidebar -->
       
            @include('frontend.dashboard._sidebar' , [
                'profile_active' => 'active'
            ])
        

        <!-- Main Content -->
        <div class="main-content">
            <!-- Profile Section -->
            <section id="profile" class="content-section active">
                <h2>User Profile</h2>
                <div class="user-profile mb-3">
                    <img src="{{ asset(auth()->user()->image) }}" alt="User Image" class="profile-img rounded-circle"
                        style="width: 100px; height: 100px;" />
                    <span class="username">{{ auth()->user()->name }}</span>
                </div>
                <br>

                {{-- @if (session()->has('errors'))
                    @foreach (session('errors')->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif --}}

                <form action="{{ route('frontend.dashboard.post.store') }}" method="POST" enctype="multipart/form-data">
                    <!-- Add Post Section -->
                    @csrf
                    <section id="add-post" class="add-post-section mb-5">
                        <h2>Add Post</h2>
                        <div class="post-form p-3 border rounded">
                            <!-- Post Title -->
                            <input name="title" type="text" id="postTitle" class="form-control mb-2"
                                placeholder="Post Title" />
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <!-- Post Content -->
                            <textarea name="small_desc" class="form-control mb-2" rows="3" placeholder="What's on your mind?"></textarea>
                            @error('small_desc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <textarea name="desc" id="postContent" class="form-control mb-2" rows="3" placeholder="What's on your mind?"></textarea>
                            @error('desc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <!-- Image Upload -->
                            <input name="images[]" type="file" id="postImage" class="form-control mb-2" accept="image/*"
                                multiple />
                            <div class="tn-slider mb-2">
                                <div id="imagePreview" class="slick-slider"></div>
                            </div>
                            @error('images')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <!-- Category Dropdown -->
                            <select name="category_id" id="postCategory" class="form-select mb-2">
                                <option value="" selected>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <!-- Enable Comments Checkbox -->
                            <div>
                                <label class="form-check-label mb-2">
                                    Enable Comments <input name="comment_able" type="checkbox" class="form-check-input" />
                                </label><br>
                            </div>
                            @error('comment_able')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <!-- Post Button -->
                            <button type="submit" class="btn btn-primary post-btn">Post</button>
                        </div>
                    </section>
                </form>

                <!-- Posts Section -->
                <section id="posts" class="posts-section">
                    @if ($posts->count() > 0)
                        <h2>Recent Posts</h2>
                        <div class="post-list">
                            <!-- Post Item -->
                            @foreach ($posts as $post)
                                <div class="post-item mb-4 p-3 border rounded">
                                    <div class="post-header d-flex align-items-center mb-2">
                                        <img src="{{ asset($post->user->image) }}" alt="User Image" class="rounded-circle"
                                            style="width: 50px; height: 50px;" />
                                        <div class="ms-3">
                                            <h5 class="mb-0">{{ $post->user->name ?? $post->admin->name }}</h5>
                                        </div>
                                    </div>
                                    <h4 class="post-title">{{ $post->title }}</h4>
                                    {!! chunk_split($post->desc , 45) !!}

                                    <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                                            <li data-target="#newsCarousel" data-slide-to="1"></li>
                                            <li data-target="#newsCarousel" data-slide-to="2"></li>
                                        </ol>
                                        <div class="carousel-inner">
                                            @foreach($post->images as $image)
                                            <div class="carousel-item @if($loop->index == 0) active @endif">
                                                <img src="{{ asset($image->path) }}" class="d-block w-100" alt="First Slide">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>{{ $post->title }}</h5>
                                                </div>
                                            </div>
                                            @endforeach

                                            <!-- Add more carousel-item blocks for additional slides -->
                                        </div>
                                        <a class="carousel-control-prev" href="#newsCarousel" role="button"
                                            data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#newsCarousel" role="button"
                                            data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>

                                    <div class="post-actions d-flex justify-content-between">
                                        <div class="post-stats">
                                            <!-- View Count -->
                                            <span class="me-3">
                                                <i class="fas fa-eye"></i> {{ $post->num_of_views }} views
                                            </span>
                                        </div>

                                        <div>
                                            <a href="{{ route('frontend.dashboard.post.edit' , $post->slug) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="javascript:void(0)" onclick="document.getElementById('deletePostForm{{ $post->slug }}').submit()" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-thumbs-up"></i> Delete
                                            </a>
                                            @if($post->comment_able) 
                                            <button id="commentsBtn{{ $post->id }}" post-id="{{ $post->id }}" class="btn btn-sm btn-outline-secondary getComments">
                                                <i class="fas fa-comment"></i> Show Comments
                                            </button>
                                            <button id="hideComments{{ $post->id }}" post-id="{{ $post->id }}" class="btn btn-sm btn-outline-secondary hideComments" style="display: none">
                                                <i class="fas fa-comment"></i> Hide Comments
                                            </button>
                                            @endif 
                                            <form id="deletePostForm{{ $post->slug }}" action="{{ route('frontend.dashboard.post.delete') }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="slug" value="{{ $post->slug }}">
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Display Comments -->
                                    <div id="displayComments{{ $post->id }}" class="comments" style="display: none">
                                        
                                        <!-- Add more comments here for demonstration -->
                                    </div>
                                </div>
                            @endforeach

                            <!-- Add more posts here dynamically -->
                        </div>
                    @else
                        <div class="alert alert-info">
                            Add your First Post
                        </div>
                    @endif
                </section>
            </section>
        </div>
    </div>
    <!-- Profile End -->
@endsection

@push('js')
    <script>
        $(function() {
            $("#postImage").fileinput({
                theme: 'fa5',
                allowedFileTypes: ['image'],
                maxFileCount: 5,
                showUpload:false,
                
            });
            $("#postContent").summernote({
                height: 300,
            });
            
        });

        $(document).on('click', '.getComments' , function(e){
            e.preventDefault();
            var post_id = $(this).attr('post-id');
            
            $.ajax({
                url: "{{ route('frontend.dashboard.post.getComments' , ':post_id') }}".replace(':post_id', post_id),
                type: "GET",
                success: function(response) {
                    $('#displayComments'+post_id).empty();
                    $.each(response.comments , function(index, comment){
                        var image = `{{ asset(':image') }}`.replace(':image', comment.user.image);
                        $('#displayComments'+post_id).append(`
                            <div class="comment">
                                <img src="${image}" alt="User Image" class="comment-img" />
                                <div class="comment-content">
                                    <span class="username">${comment.user.name}</span>
                                    <p class="comment-text">${comment.comment}</p>
                                </div>
                            </div>
                        `).show();
                    });
                    
                }
            });
            $(this).hide();
            $('#hideComments'+post_id).show();
        }) 

        $(document).on('click', '.hideComments' , function(e){
            e.preventDefault();
            var post_id = $(this).attr('post-id');
            $('#hideComments'+post_id).hide();
            $('#commentsBtn'+post_id).show();
            $('#displayComments'+post_id).empty();
        })
    </script>
@endpush
