<div class="tab-pane active" id="drug-type">
    <!-- Responsive modal -->

    @include('user.doctor.setting.prescription.tab-body.drug-types.modal.new-type')
    @include('user.doctor.setting.prescription.tab-body.drug-types.modal.edit-type')


    <button style="float: right" type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#add-drug-type"><i class="fa fa-plus"></i> New Type</button>
    <h4>Drug types</h4>
    <br>

    <table id="typeTable" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Drug Type</th>
            <th>Status</th>
            <th>Date</th>
            <th width="20px">Actions</th>
        </tr>
        </thead>
    </table>

</div>