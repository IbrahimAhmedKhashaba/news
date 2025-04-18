@extends('layouts.dashboard.app')
@section('title')
Posts
@endsection
@section('body')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <form action="{{ route('admin.posts.update', $post->id) }}" method="POST"
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="category" class="form-control" id="category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected($category->id == $post->category_id)>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="status" class="form-control" id="status">
                                        <option value="1" @selected($post->status == 1)>Active</option>
                                        <option value="0" @selected($post->status == 0)>Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <!-- Enable Comments Checkbox -->
                        <div>
                            <label class="form-check-label mb-2">
                                <input name="comment_able" type="checkbox" class="form-check-input"
                                    @checked($post->comment_able) /> Enable Comments
                            </label><br>
                            @error('comment_able')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

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

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Post Button -->
                            <button type="submit" class="btn btn-primary post-btn float-right mt-2">Edit</button>
                            </div>
                        </div>

                        <div>

                        </div>
                    </div>
                </section>
            </form>

        </div>
        <!-- /.container-fluid -->
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
                                url: '{{ route('admin.post.deleteImage', ['_token' => csrf_token()]) }}',
                                key: {{ $image->id }},
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
