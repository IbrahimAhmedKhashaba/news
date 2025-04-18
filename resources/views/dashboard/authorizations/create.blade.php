
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Create Role
</button>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.authorizations.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body shadow">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="role" class="form-control" id="role"
                                    placeholder="Enter Role Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                @foreach($permissions as $key => $value)
                                    <div>
                                        <input type="checkbox" value="{{ $key }}" name="permissions[]"> {{ $value }}
                                    </div>
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
