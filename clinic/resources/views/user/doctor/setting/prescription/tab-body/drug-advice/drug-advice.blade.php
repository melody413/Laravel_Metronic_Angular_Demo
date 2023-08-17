<div class="tab-pane active" id="drug-advice">

    @include('user.doctor.setting.prescription.tab-body.drug-advice.modal.new')
    @include('user.doctor.setting.prescription.tab-body.drug-advice.modal.edit')


    <button style="float: right" type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#add-drug-advice"><i class="fa fa-plus"></i> New Drug Advice</button>
    <h4>Drug Advice</h4>
    <br>

    <table id="drugAdviceTable" class="table table-striped table-bordered" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Drug advice</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
</div>