@extends('layouts.app')

@section('title')
    Edit Patient
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
                <a href="javascript:void(0);" onclick="window.location.replace('{{url('/take-patient-to-prescription-page/'.$patient->id)}}')" class="pull-right">Write a prescription</a>
                <span class="pull-right">&nbsp;|&nbsp;</span>
                <a href="{{url('/patient-medical-file/'.$patient->id)}}" class="pull-right">Add Medical document</a>
                <h4 class="card-title">Edit patient - {{$patient->name}}</h4>
                <form action="#" method="post" id="updatePatient" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-4">
                            <center>
                                <div id="image-preview" style="background-image: url({{url($patient->image != null ? $patient->image : "/dashboard/images/image_placeholder.jpg")}})">
                                    <label for="image-upload" id="image-label">Patient photo</label>
                                    <input type="file" name="image" id="image-upload" />
                                </div>
                            </center>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group-custom">
                                <input value="{{$patient->name}}" type="text" name="name" required="required" autofocus/>
                                <label class="control-label">Name &nbsp;<span class="text-danger">*</span></label><i class="bar"></i>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <select name="gender" id="" required="required">
                                            <option {{$patient->gender ==1 ? 'selected' : ''}} value="1">Male</option>
                                            <option {{$patient->gender ==2 ? 'selected' : ''}} value="2">Fe-male</option>
                                            <option {{$patient->gender ==3 ? 'selected' : ''}} value="3">Other</option>
                                        </select>
                                        <label class="control-label">Gender &nbsp;<span class="text-danger">*</span></label><i class="bar"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-custom">
                                        <input value="{{$patient->date_of_birth->format('Y-m-d')}}" type="date" name="date_of_birth" id="datepicker-autoclose" required="required" />
                                        <label class="control-label">Date of birth &nbsp;<span class="text-danger">*</span></label><i class="bar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-custom">
                                <input value="{{$patient->phone}}" type="text" name="phone"  required="required"/>
                                <label class="control-label">Phone &nbsp;<span class="text-danger">*</span></label><i class="bar"></i>
                            </div>
                            <div class="form-group-custom">
                                <input value="{{$patient->email}}" type="text" name="email" />
                                <label class="control-label">Email</label><i class="bar"></i>
                            </div>
                            <div class="form-group-custom">
                                <textarea name="address">{{$patient->address}}</textarea>
                                <label class="control-label">Address &nbsp;</label><i class="bar"></i>
                            </div>

                        </div>
                    </div>

                    <div style="padding-left: 35%;">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit &nbsp; <i id="loading" class="fa fa-refresh fa-spin"></i></button>
                        <button type="reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    @include('user.doctor.patient.modal.success-modal')
@endsection

@section('extra-js')
    <script>
        $(document).ready(function () {
            var patientId = null;

            $.fn.newPatientSetPatientId = function (id) {
                patientId = id;
            };

            $("#modalBtnPrescribeNow").on('click',function () {
                console.log(patientId);
                window.location.replace('/take-patient-to-prescription-page/'+patientId);
            });


            $("#updatePatient").on('submit',function (e) {
                e.preventDefault();
                var data = new FormData(this);
                $(this).speedPost('/update-patient/{{$patient->id}}',data);

            })
        });
    </script>
@endsection