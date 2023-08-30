<div class="btn-group ">
    <a href="{{url('/edit-assistant/'.$id)}}" class="btn btn-primary"><i class="ti-pencil-alt"></i></a>
    {{--<a href="#" class="btn btn-success"><i class="fa fa-info"></i></a>--}}
    <a href="javascript:void(0)" onclick="$(this).confirmDelete('{{url('/delete-assistant/'.$id)}}')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
</div>
