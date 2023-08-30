<div class="tab-pane active" id="drug-dose">

    @include('user.doctor.setting.prescription.tab-body.drug-dose.modal.new')
    @include('user.doctor.setting.prescription.tab-body.drug-dose.modal.edit')


    <button style="float: right" type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#add-drug-dose"><i class="fa fa-plus"></i> New Dose</button>
    <h4>Drug Dose</h4>
    <br>

    <table id="doseTable" class="table table-striped table-bordered" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Drug Dose</th>
            <th>Status</th>
            <th>Dose</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>