@extends('layouts.app')

@section('title')
    Schedule Report
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
                <h4 class="card-title">Schedule Report</h4>
                <form action="javascript:void(0)" method="post" id="scheduleReportForm">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-custom ">
                                <select class="form-control select2" name="drug_id" id="" >
                                    <option value="0" {{$schedule_id == 0 ? 'selected' : ''}}>All Place</option>
                                    @foreach($schedules as $schedule)
                                        <option value="{{$schedule->id}}" {{$schedule_id == $schedule->id ? 'selected' : ''}}>{{$schedule->name}} </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group-custom">
                                <input type="date" id="start" value="{{$start}}" name="date"/>
                                <label class="control-label">Start Date &nbsp;*</label><i class="bar"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group-custom">
                                <input type="date" id="end" value="{{$end}}"  name="time"/>
                                <label class="control-label">End Date</label><i class="bar"></i>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit &nbsp; <i id="loading" class="fa fa-refresh fa-spin"></i></button>
                </form>
                <br>



                @if($schedule_id == 0)
                    <h4 class="m-t-0 header-title"><b>Schedule Chart by appointment</b></h4>

                    <canvas id="bar" height="100"></canvas>
                @else
                    <h4 class="m-t-0 header-title"><b>Schedule by Month</b></h4>

                    <canvas id="patientAppointment" height="100"></canvas>
                    <br>
                    <?php $i =0; ?>
                    @foreach($patient_appointments as $appointment)
                      <h3 class="">{{$appointment[0]->date->format('M-Y')}}</h3>
                        <table  class="table table-bordered datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Patient</th>
                                <th>Appointment</th>
                                <th>Appointed by</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <?php $i = 1; ?>
                            @foreach($appointment as $a)
                               <tr>
                                   <td>{{$i++}}</td>
                                   <td>{{$a->patient->name}}</td>
                                   <td>{{$a->date->format('d-M-Y')}} | {{\Carbon\Carbon::parse($a->time)->format('h:g a')}}</td>
                                   <td>{{$a->user->name}}</td>
                                   <td>{{$a->status == 1 ? "Appointed " : 'Pending'}}</td>
                                   <td>
                                       @if($a->status ==0)
                                           <div class="btn-group ">
                                               <a href="{{url('/edit-appointment/'.$a->id)}}" class="btn btn-primary"><i class="ti-pencil-alt"></i></a>
                                               <a href="javascript:void(0)" onclick="$(this).confirmDelete('{{url('/delete-appointment/'.$a->id)}}')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                                           </div>
                                       @endif
                                   </td>
                               </tr>
                            @endforeach
                            <tbody>
                            </tbody>
                        </table>
                        <hr>

                    @endforeach
                @endif

            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script src="{{url('/dashboard/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{url('/dashboard/plugins/chartjs/chart.bundle.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $(".select2").select2({
                placeholder: "Select a schedule",
                width: '100%'
            });

            $("#scheduleReportForm").on('submit',function (e) {
               e.preventDefault();
               var scheduleId = $('.select2').val() != '' ? $('.select2').val() : 0;
               var start = $('#start').val() != '' ?  $('#start').val() : '2017-06-05';
               var end = $('#end').val() != '' ? $('#end').val() : '{{\Carbon\Carbon::today()->addDay(1)->toDateString()}}';
               window.location.replace('/schedule-report/schedule='+scheduleId+'/start='+start+'/end='+end);

            });
           @if($schedule_id == 0)
            var barChart = $("#bar");
            var myChart = new Chart(barChart, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($schedules as $schedule)
                            '{{$schedule->name}}',
                        @endforeach
                    ],
                    datasets: [{
                        label: "Total Appointment",
                        data: [
                            @foreach($schedules as $schedule)
                                '{{count(\App\Model\PatientAppointment::where('appointment_id',$schedule->id)->whereBetween('date',[$start,$end])->get())}}',
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach($schedules as $i)
                                '{{'rgba('.rand(200,300).','.rand(1,300).','.rand(700,900).', 1)'}}',
                            @endforeach
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
            @else
            var patientAppointment = $("#patientAppointment");
            var myChart = new Chart(patientAppointment, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($patient_appointments as $appointment)
                            '{{$appointment[0]->date->format('M-Y')}}',
                        @endforeach
                    ],
                    datasets: [{
                        label: "Total  ",
                        data: [
                            @foreach($patient_appointments as $appointment)
                                '{{count($appointment)}}',
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach($patient_appointments as $i)
                                '{{'rgba('.rand(40,120).','.rand(20,70).','.rand(10,200).', 0.6)'}}',
                            @endforeach
                        ],
                        borderColor: [
                            @foreach($patient_appointments as $i)
                                '{{'rgba('.rand(301,400).','.rand(300,700).','.rand(1,50).', 1)'}}',
                            @endforeach
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
            @endif
        })
    </script>
    @if($schedule_id != 0)
    <link rel="stylesheet" href="{{url('/dashboard/plugins/datatables/datatable.min.css')}}">
    <script src="{{url('/dashboard/plugins/datatables/datatable.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.datatable').DataTable();
        })
    </script>
    @endif
@endsection