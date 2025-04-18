<div class="card-body">
    <form action="{{ route('admin.categories.index') }}" method="get">
    <div class="row">
            <div class="col-2">
                <div class="from-group">
                    <select name="sort_by" class="form-control">
                        <option selected value="">Sort By</option>
                        <option value="id">Id</option>
                        <option value="name">Name</option>
                        <option value="created_at">Created_at</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="from-group">
                    <select name="order_by" class="form-control">
                        <option selected value="">Order By</option>
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="from-group">
                    <select name="limit" class="form-control">
                        <option selected value="">Limit</option>
                        <option value="3">3</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="from-group">
                    <select name="status" class="form-control">
                        <option selected value="">Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            
            <div class="col-3">
                <div class="from-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Search"/>
                </div>
            </div>
            <div class="col-1">
                <div class="from-group text-center">
                    <button type="submit" class="btn btn-info" >
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>