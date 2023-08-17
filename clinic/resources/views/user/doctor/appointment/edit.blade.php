@extends('layouts.app')

@section('title')
    Edit Appointment
@endsection

@section('extra-css')
    <link rel="stylesheet" href="{{url('/dashboard/plugins/select2/css/select2.min.css')}}">
@endsection

@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-calendar fa-2x"></i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Edit Appointment</h4>
                <form action="#" method="post" id="updateAppointment">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-custom ">
                                <select class="form-control select2" name="patient_id" id="" required="required">
                                    <option></option>
                                    @foreach($patients as $patient)
                                        <option {{$patient->id == $appointment->patient_id ? 'selected' : ''}} value="{{$patient->id}}">{{$patient->name}} | {{$patient->phone}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group-custom">
                                <input type="date" value="{{$appointment->date->format('Y-m-d')}}" name="date" required="required"/>
                                <label class="control-label">Date &nbsp;*</label><i class="bar"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group-custom">
                                <input type="time" value="{{$appointment->time}}" required="required" name="time"/>
                                <label class="control-label">Time</label><i class="bar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <select required="required" class="form-control select3" name="appointment_id" id="">
                                    <option value="">Select Place</option>
                                    @foreach($schedules as $schedule)
                                        <option {{$schedule->id == $appointment->appointment_id ? "selected" : ''}} value="{{$schedule->id}}">{{$schedule->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-custom">
                                <input type="text" value="{{$appointment->payment ? $appointment->payment->payment : null}}" name="payment"/>
                                <label class="control-label">Payment Amount &nbsp;</label><i class="bar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <textarea name="note" >{{$appointment->note}}</textarea>
                        <label class="control-label">Note</label><i class="bar"></i>
                    </div>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit &nbsp; <i id="loading" class="fa fa-refresh fa-spin"></i></button>
                    <button type="reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection
<script>
        $(document).ready(function () {
            $(".select2").select2({
                placeholder: "Please select a patient *",
                width: '100%'
            });
            $(".select3").select2({
                placeholder: "Please select a schedule *",
                width: '100%'
            });

            $("#updateAppointment").on('submit',function (e) {
                e.preventDefault();
                var data = new FormData(this);
                $.ajax({
                    url:'{{url('/update-appointment/'.$appointment->id)}}',
                    type:'POST',
                    data:data,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success:function (data) {
                        $.Notification.notify('success','top right','Appointment updated successfully');
                    },error:function (data) {
                        $.Notification.notify('error','top right','Doctor will not available on that day in selected place')
                    }
                })
            });
        })
    </script>
@endsection