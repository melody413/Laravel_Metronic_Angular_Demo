@extends('layouts.app')

@section('title')
    Create new prescription
@endsection

@section('extra-css')
    <link rel="stylesheet" href="{{url('/dashboard/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{url('/dashboard/plugins/jquery-ui/jquery-ui.css')}}">

@endsection

@section('content')

    @if(session('has_patient'))
        <?php $patient = session('has_patient') ?>
        <input type="hidden" value="{{$patient->id}}" id="defaultPatient">
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="ti-write" style="font-size: 30px;"></i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Add new prescription</h4>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group-custom">
                            <textarea required="required" id="cc" rows="3"></textarea>
                            <label class="control-label">Chief Complains</label><i class="bar"></i>
                        </div>
                        <div class="form-group-custom">
                            <textarea required="required" id="oe" rows="3"></textarea>
                            <label class="control-label">On examinations</label><i class="bar"></i>
                        </div>
                        <div class="form-group-custom">
                            <textarea required="required" id="pd" rows="3"></textarea>
                            <label class="control-label">Provisional Diagnosis</label><i class="bar"></i>
                        </div>
                        <div class="form-group-custom">
                            <textarea required="required" id="dd" rows="3"></textarea>
                            <label class="control-label">Differential diagnosis</label><i class="bar"></i>
                        </div>
                        <div class="form-group-custom">
                            <textarea required="required" id="lab_worekup" rows="3"></textarea>
                            <label class="control-label">Lab Workup</label><i class="bar"></i>
                        </div>
                        <div class="form-group-custom">
                            <textarea id="advice" required="required"></textarea>
                            <label class="control-label">Advices</label><i class="bar"></i>
                        </div>
                        <div class="form-group-custom">
                            <input id="next_visit" required="required">
                            <label class="control-label">Next Visit</label><i class="bar"></i>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <h4>Rx</h4>
                        <form action="javascript:void(0)" method="post" id="addDrugToListForm">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group-custom">
                                        <input type="text" id="drug_type" placeholder="Type"/>
                                        <label class="control-label"></label><i class="bar"></i>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control select2" id="drug">
                                        <option></option>
                                        @foreach($drugs as $drug)
                                            <option value="{{$drug->id}}">{{$drug->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-block btn-default waves-effect waves-light"
                                            data-toggle="modal"
                                            data-target="#con-close-modal" id="btnNewDrug">+
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-custom">
                                        <input type="text" id="strength"/>
                                        <label class="control-label">Strength</label><i class="bar"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <input type="text" id="dose"/>
                                        <label class="control-label">Dose</label><i class="bar"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <input type="text" id="duration"/>
                                        <label class="control-label">Duration</label><i class="bar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group-custom">
                                        <input type="text" id="drug_advice"/>
                                        <label class="control-label">Advice</label><i class="bar"></i>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success waves-effect" data-dismiss="modal">Add Drug
                                    in prescription
                                </button>
                            </div>
                        </form>

                        <hr>
                        <ol id="drugListView">

                        </ol>
                    </div>

                    <div class="col-md-3">
                        <select class="form-control" id="selectTemplate">
                            <option></option>
                            @foreach($templates as $template)
                                <option value="{{$template->id}}">{{$template->name}}</option>
                            @endforeach
                        </select>
                        <br>
                        <br>
                        <select class="form-control" id="selectPatient">
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{$patient->id}}">{{$patient->name}} | <span>{{$patient->phone}}</span>
                                </option>
                            @endforeach
                        </select>
                        <br>
                        <br>
                        <center>
                            <img id="_patientImage" src="{{url('/dashboard/images/image_placeholder.jpg')}}" width="80%"
                                 class="rounded-circle img-fluid" alt="">
                            <h4 id="_patientName">No Patient Selected yet</h4>
                            <p id="_patientAge"></p>
                            <p id="_patientGender"></p>
                            {{--<p>Patient phone : <br> 01738070062 <br> Patient email : abc@patient.com</p>--}}
                        </center>
                        <div class="form-group-custom patientPres" style="display: none">
                            <select class="select3" id="_patientPrescriptions">
                                <option value="">Patient prescriptions</option>
                            </select>
                            <label class="control-label">Prescriptions</label><i class="bar"></i>
                        </div>

                        <br>
                        <center>
                            <button class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">
                                Create new patient
                            </button>
                        </center>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <button onclick="$(this).saveTemplate('/save-template',false);"
                            class="btn btn-block btn-lg btn-white waves-effect waves-light">Save as Template
                        <i id="loadingSaveTemplate" class="fa fa-refresh fa-spin"></i>
                    </button>
                </div>
                <div class="col-md-6">
                    <button onclick="$(this).savePrescription();"
                            class="btn btn-block btn-lg btn-inverse waves-effect waves-light">Save & Print
                        <i id="loadingSavePrescription" class="fa fa-refresh fa-spin"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

    @include('user.doctor.prescription.model.new-patient')
    @include('user.doctor.template.modals.new-drug')
    @include('user.doctor.template.modals.edit-drug-from-list')
@endsection

@section('extra-js')
    <script src="{{url('/dashboard/js/jquery.hotkeys-0.7.9.min.js')}}"></script>
    <script src="{{url('/dashboard/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{url('/app_js/prescription-template.js')}}"></script>
    <script src="{{url('/dashboard/plugins/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{url('/app_js/prescription-autocomplete.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#loadingSaveTemplate").hide();
            $("#loadingSavePrescription").hide();

            var defaultPatient = $("#defaultPatient").val();
            if(defaultPatient != '' || defaultPatient != null){
                $(this).getPatientDetails(defaultPatient);
                $("#selectPatient").val(defaultPatient).change();
            }


            // Select template
            $("#selectTemplate").select2({
                placeholder: "Prescription template"
            });

            // Select patient
            $("#selectPatient").select2({
                placeholder: "Patients"
            });

            // Select template
            $("#selectTemplate").on('change', function () {
                var templateId = $("#selectTemplate").val();
                if (templateId != '') {
                    $.get('/api/template-details/' + templateId, function (data) {
                        $(this).setSelectedTemplate(templateId);
                        var _drugs = [];
                        $.each(data.drugs, function (key, data) {
                            var _drug = {
                                drug_id: data.drug.id,
                                drug_name: data.drug.name,
                                drug_type: data.type,
                                strength: data.strength,
                                dose: data.dose,
                                duration: data.duration,
                                drug_advice: data.advice
                            }
                            _drugs.push(_drug);
                        });
                        $(this).setDrugList(_drugs);
                        $(this).renderDrug();
                        $(this).renderPrescriptionLeft(data);
                    });
                }
            });

            // Get patient prescription
            $("#_patientPrescriptions").on('change', function () {
                $(this).setTemplateId(null);
                $(this).getPrescriptionDetails($("#_patientPrescriptions").val());
            });

            // get patient details
            $("#selectPatient").on('change', function () {
                console.log("Change");
                var patientId = $("#selectPatient").val();
                $(this).getPatientDetails(patientId);
            });

            // Create new patient on prescription page
            $("#newPatient").on("submit",function (e) {
               e.preventDefault();
               data = new FormData(this);
               $.ajax({
                   url:'{{url('/save-patient')}}',
                   type:'post',
                   data : data,
                   contentType: false,
                   cache: false,
                   processData:false,
                   success:function (data) {
                       $.Notification.notify('success','top right',"Patient added successfully","Patient has been added successfully");
                       $("#selectPatient").append(
                            $('<option>',{value:data.id,text:data.name + "|" +data.phone}).select2({
                                placeholder: "Select Patient"
                            })
                        );

                       $("#selectPatient").val(data.id).trigger('change');
                       $(".bs-example-modal-lg").modal('hide');
                   },error:function (data) {
                        $(this).showAjaxError(data);
                   }
               });

            });

        });
    </script>
@endsection