<div class="tab-pane active" id="duration">
    @include('user.doctor.setting.prescription.tab-body.drug-duration.modal.new')
    @include('user.doctor.setting.prescription.tab-body.drug-duration.modal.edit')


    <button style="float: right" type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#add-drug-duration"><i class="fa fa-plus"></i> New Duration</button>
    <h4>Drug Duration</h4>
    <br>

    <table id="durationTable" class="table table-striped table-bordered" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Duration</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>