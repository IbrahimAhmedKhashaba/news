<div>
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Posts</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Comments</th>
                                <th>Show</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latest_posts as $post)
                                <tr>
                                    <td>{{ substr($post->title, 0, 20) }}</td>
                                    <td>{{ substr($post->category->name, 0, 10) }}</td>
                                    <td>{{ $post->comments_count }}</td>
                                    <td><a class="btn" href="{{ route('admin.posts.show', $post->id) }}"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



        </div>

        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Comments</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Comment</th>
                                <th>User</th>
                                <th>Post</th>
                                <th>Show</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latest_comments as $comment)
                                <tr>
                                    <td>{{ substr($comment->comment, 0, 20) }}...</td>
                                    <td>{{ substr($comment->user->name, 0, 10) }}...</td>
                                    <td>{{ substr($comment->post->title, 0, 10) }}...</td>
                                    <td><a class="btn" href="{{ route('admin.posts.show', $comment->post->id) }}"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



        </div>
    </div>
</div>
