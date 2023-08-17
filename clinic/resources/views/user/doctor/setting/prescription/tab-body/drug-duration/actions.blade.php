<div class="btn-group ">
    <a href="javascript:void(0)" onclick="$(this).getDrugDurationDetails('{{$id}}')" data-toggle="modal" data-target="#edit-drug-duration" class="btn btn-primary"><i class="ti-pencil-alt"></i></a>
    <a href="javascript:void(0)" onclick="$(this).confirmDelete('{{url('/delete-drug-duration/'.$id)}}')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
</div>