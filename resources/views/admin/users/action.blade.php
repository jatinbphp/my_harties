<div class="btn-group">
    <button type="button" class="btn btn-info btn-sm">Action</button>
    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu" role="menu">
        <a class="dropdown-item" href="{{url('admin/users/'.$row->id.'/edit')}}"><i class="fa fa-edit text-primary pr-2"></i>Edit</a>
        <a class="dropdown-item deleteUser" data-id="{{$row->id}}"  href="javascript:void(0)"><i class="fa fa-trash text-danger pr-2"></i>Delete</a>
    </div>
</div>
