@extends('layouts.frontend.app')
@section('meta_description')
    {{ $post->small_desc }}
@endsection
@section('title')
    Edit-Post
@endsection
@section('body')
    <div class="dashboard container">
        <!-- Sidebar -->
        @include('frontend.dashboard._sidebar' , [
                'profile_active' => 'active'
            ])

        <!-- Main Content -->
        <div class="main-content col-md-9">
            <!-- Show/Edit Post Section -->
            <section id="posts-section" class="posts-section">
                <form action="{{ route('frontend.dashboard.post.update', $post->slug) }}" method="POST"
                    enctype="multipart/form-data">
                    <!-- Add Post Section -->
                    @csrf
                    @method('patch')
                    <section id="add-post" class="add-post-section mb-5">
                        <h2>Edit Post: {{ $post->title }}</h2>
                        <div class="post-form p-3 border rounded">
                            <!-- Post Title -->
                            <input name="title" type="text" id="postTitle" class="form-control mb-2"
                                value="{{ $post->title }}" />
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <!-- Post Content -->
                            <textarea name="small_desc" class="form-control mb-2" rows="3">{{ $post->small_desc }}</textarea>
                            @error('small_desc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <textarea name="desc" id="postContent" class="form-control mb-2" rows="3">{{ $post->desc }}</textarea>
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
                                {{-- <option value="{{ $post->category_id }}" selected>{{ $post->category->name }}</option> --}}
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($category->id == $post->category_id)>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <!-- Enable Comments Checkbox -->
                            <div>
                                <label class="form-check-label mb-2">
                                    Enable Comments <input name="comment_able" type="checkbox" class="form-check-input"
                                        @checked($post->comment_able) />
                                </label><br>
                            </div>
                            @error('comment_able')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <div class="post-actions d-flex justify-content-between">
                                <div class="post-stats">
                                    <!-- View Count -->
                                    <span class="me-3">
                                        <i class="fas fa-eye"></i> {{ $post->num_of_views }}
                                    </span>
                                </div>

                                <div class="post-stats">
                                    <!-- View Count -->
                                    <span class="">
                                        <i class="fas fa-comment"></i> {{ $post->comments->count() }}
                                    </span>
                                </div>

                            </div>

                            <!-- Post Button -->
                            <button type="submit" class="btn btn-primary post-btn">Edit</button>
                        </div>
                    </section>
                </form>
            </section>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $("#postImage").fileinput({
                theme: 'fa5',
                allowedFileTypes: ['image'],
                maxFileCount: 5,
                enableResumableUpload: false,
                showUpload: false,
                initialPreviewAsData: true,
                initialPreview: [
                    @if ($post->images->count() > 0)
                        @foreach ($post->images as $image)
                            "{{ asset($image->path) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewConfig: [
                    @if ($post->images->count() > 0)
                        @foreach ($post->images as $image)
                        {
                                caption: '{{ $image->path }}',
                                width: '120px',
                                url: '{{ route('frontend.dashboard.post.deleteImage', ['_token' => csrf_token()]) }}',
                                key:{{ $image->id }},
                            },
                        @endforeach
                    @endif
                ],
            });
            $("#postContent").summernote({
                height: 300,
            });

        });
    </script>
@endpush
