<!-- Button trigger modal -->
<button type="button" class="btn" data-toggle="modal" data-target="#exampleModal{{ $site->id }}">
    <i class="fa fa-pen"></i>
</button>
<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $site->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $site->id }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Related Site</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.related_sites.update' , $site->id) }}" method="post">
                <div class="modal-body">
                    @csrf
                    @method('put')
                    <div class="card-body shadow">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control"
                                        id="name" placeholder="Enter Category Name" value="{{ $site->name }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="url" class="form-control"
                                        id="url" placeholder="Enter Site url" value="{{ $site->url }}">
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>