<div id="patientSavedSuccessModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0"> <i class="fa fa-check-circle-o fa-lg" style="color: green;"></i> Patient <span>saved/updated</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <center>
                    <img id="modalPatientImage" src="http://via.placeholder.com/120x120" width="120px"  alt="">
                    <h4 id="modalPatientName">Patient Name</h4>
                    <p id="modalPatientPhone">Phone : 01738070062</p>
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" id="modalBtnMakeAppointment" class="btn btn-success waves-effect waves-light">Make Appointment</button>
                <button type="button" id="modalBtnAddMedicalFile" class="btn btn-success waves-effect waves-light">Add File</button>
                @if(auth()->user()->role == 1)
                <button type="button" id="modalBtnPrescribeNow" class="btn btn-primary waves-effect waves-light">Prescribe now</button>
                @endif
            </div>
        </div>
    </div>
</div><!-- /.modal -->