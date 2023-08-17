
<div class="btn-group ">
    <a href="{{url('/edit-template/'.$id)}}" class="btn btn-primary waves-effect waves-light"><i class="ti-pencil-alt"></i></a>
    <a href="{{url('/view-template/'.$id)}}" class="btn btn-default waves-effect waves-light"><i class="fa fa-info"></i></a>
    <a href="javascript:void(0)" onclick="$(this).confirmDelete('{{url('/delete-template/'.$id)}}')" class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash-o "></i></a>
</div>
