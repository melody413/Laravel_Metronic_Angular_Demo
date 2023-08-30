@extends('layouts.app')

@section('title')
    New Patient
@endsection

@section('extra-css')

@endsection

@section('content')


    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-user-circle-o fa-2x"></i>
            </div>
            <div class="card-content">
                @include('user.doctor.patient.common.create-patient')
            </div>
        </div>
    </div>
    @include('user.doctor.patient.modal.success-modal')
@endsection

@section('extra-js')
    <script type="text/javascript" src="{{url('/dashboard/plugins/parsleyjs/parsley.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            var patientId = null;

            $.fn.newPatientSetPatientId = function (id) {
                patientId = id;
            };

            $("#modalBtnPrescribeNow").on('click',function () {
//                console.log(patientId);
                window.location.replace('/take-patient-to-prescription-page/'+patientId);
            });

            $("#modalBtnMakeAppointment").on('click',function () {
//                console.log(patientId);
                window.location.replace('/take-patient-to-appointment/'+patientId);
            });

            $("#modalBtnAddMedicalFile").on('click',function () {
               window.location.replace('/patient-medical-file/'+patientId);
            });


            $("#newPatient").on('submit',function (e) {
                e.preventDefault();
                var data = new FormData(this);
                $.ajax({
                    url:'{{url('/save-patient')}}',
                    type:'POST',
                    data:data,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success:function (data) {
                        console.log(data.image);
                        $("#patientSavedSuccessModal").modal('show');
                        $(this).formReset($("#newPatient"));
                        $(this).newPatientSetPatientId(data.id);
                        $("#modalPatientImage").attr('src',data.image != null ? data.image : 'http://via.placeholder.com/120x120');
                        $("#modalPatientName").text(data.name);
                        $("#modalPatientPhone").text(data.phone);
                    },error:function (data) {
                        if(data.status == 422 ){
                            $.each(data.responseJSON,function (key,data) {
                                for(var key in data) {
                                    if(key.length > 2){
                                        $.each(data[key],function (index,data) {
                                            $.Notification.notify('error','top right',data)
                                        })
                                    }
                                }
                            });
                        }else{
                            $.Notification.notify('warning','top right',"Internal server error",
                                "Internal server error" +
                                "Refresh this page and try again" +
                                "Or, contact to your system admin")
                        }
                    }
                });
            })
        });
    </script>
@endsection