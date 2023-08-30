<div class="tab-pane active" id="drug-strength">
    @include('user.doctor.setting.prescription.tab-body.drug-strength.modal.new')
    @include('user.doctor.setting.prescription.tab-body.drug-strength.modal.edit')


    <button style="float: right" type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#add-drug-strength"><i class="fa fa-plus"></i> New Strength</button>
    <h4>Drug Strength</h4>
    <br>

    <table id="strengthTable" class="table table-striped table-bordered" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Drug Strength</th>
            <th>Status</th>
            <th>Date</th>
            <th width="25px">Actions</th>
        </tr>
        </thead>
    </table>
</div>