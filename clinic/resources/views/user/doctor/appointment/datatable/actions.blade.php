<div class="btn-group ">
    <a href="{{url('/edit-appointment/'.$id)}}" class="btn btn-primary"><i class="ti-pencil-alt"></i></a>
    <a href="javascript:void(0)" onclick="$(this).confirmDelete('{{url('/delete-appointment/'.$id)}}')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
</div>
