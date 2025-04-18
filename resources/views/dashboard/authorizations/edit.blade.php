
<!-- Button trigger modal -->
<button type="button" class="btn" data-toggle="modal" data-target="#exampleModal{{ $authorization->id }}">
    <i class="fa fa-edit"></i>
</button>
<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $authorization->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.authorizations.update' , $authorization->id) }}" method="post">
                @csrf
                @method('put')
                <div class="card-body shadow">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="role" class="form-control" id="role"
                                    value="{{ $authorization->role }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                @foreach($permissions as $key => $value)
                                    <div>
                                        <input @checked(in_array($key, $authorization->permissions)) type="checkbox" value="{{ $key }}" name="permissions[]"> {{ $value }}
                                    </div>
                                @endforeach
                                @error('permissions')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
