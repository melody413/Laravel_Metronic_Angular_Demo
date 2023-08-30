<div class="btn-group ">
    <a href="{{url('/edit-patient/'.$id)}}" class="btn btn-primary"><i class="ti-pencil-alt"></i></a>
    <a href="{{url('/view-patient/'.$id)}}" class="btn btn-success"><i class="fa fa-info"></i></a>
    <a href="javascript:void(0)" onclick="$(this).confirmDelete('{{url('/delete-patient/'.$id)}}')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
</div>
