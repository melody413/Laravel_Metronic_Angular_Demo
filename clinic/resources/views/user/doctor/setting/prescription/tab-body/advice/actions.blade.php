<div class="btn-group ">
    <a href="javascript:void(0)" onclick="$(this).getAdviceDetails('{{$id}}')" data-toggle="modal" data-target="#edit-advice" class="btn btn-primary"><i class="ti-pencil-alt"></i></a>
    <a href="javascript:void(0)" onclick="$(this).confirmDelete('{{url('/delete-advice/'.$id)}}')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
</div>