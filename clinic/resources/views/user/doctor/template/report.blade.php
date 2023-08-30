@extends('layouts.app')

@section('title')
    Template Report
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
                <h4 class="card-title">Template Report</h4>
                <form action="#" method="post" id="templateReportForm">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-custom ">
                                <select class="form-control select2" name="drug_id" id="" required="required">
                                    <option value="0" {{$template_id ==0 ? 'selected' : ''}}>All Template</option>
                                    @foreach($templates as $template)
                                        <option value="{{$template->id}}" {{$template_id ==$template->id ? 'selected' : ''}}>{{$template->name}} </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group-custom">
                                <input type="date" id="start" value="{{$start}}" required="required"/>
                                <label class="control-label">Start Date &nbsp;*</label><i class="bar"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group-custom">
                                <input type="date" id="end" required="required" value="{{$end}}" name="time"/>
                                <label class="control-label">End Date</label><i class="bar"></i>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit &nbsp; <i id="loading" class="fa fa-refresh fa-spin"></i></button>
                </form>
                <br>
                @if($template_id == 0)
                <h4 class="m-t-0 header-title"><b>Template Chart</b></h4>
                <canvas id="bar" height="50vh" width="100%"></canvas>
                @else
                <h4 class="m-t-0 header-title"><b>Selected Template Chart</b></h4>
                <canvas id="selectedTemplateChart" height="50vh" width="100%"></canvas>
                   @foreach($stat_template as $template)
                       <h3>{{$template[0]->created_at->format('M-Y')}}</h3>
                        <table class="table table-bordered datatable" >
                            <thead>
                            <tr>
                                <th>Prescription</th>
                                <th>Template Status</th>
                                <th>Patient</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($template as $t)
                                <tr>
                                    <td>{{$t->created_at->format('d-M-Y')}}</td>
                                    <td>{{$t->template->status == 1 ? 'Active' : 'In-Active'}}</td>
                                    <td>{{$t->patient->name}}</td>
                                    <td><a target="_blank" href="{{url('/print-prescription/'.$t->id)}}" ><i class="fa fa-eye"></i> &nbsp; View &nbsp; <i class="fa fa-external-link"></i> </a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

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
                placeholder: "Please select a template ",
                width: '100%'
            });

            $("#templateReportForm").on('submit',function (e) {
               e.preventDefault();
                var templateId = $(".select2").val();
                var start = $('#start').val() != '' ?  $('#start').val() : '2017-06-05';
                var end = $('#end').val() != '' ? $('#end').val() : '{{\Carbon\Carbon::today()->addDay(1)->toDateString()}}';
                window.location.replace('/template-report/template='+templateId+'/start='+start+'/end='+end);
            });
            @if($template_id == 0)
            var barChart = $("#bar");
            var myChart = new Chart(barChart, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($templates as $template)
                            '{{$template->name}}',
                        @endforeach
                    ],
                    datasets: [{
                        label: "Total use",
                        data: [
                            @foreach($templates as $template)
                                '{{count(\App\Model\Prescription::where('prescription_template_id',$template->id)->whereBetween('created_at',array($start,$end))->get())}}',
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach($templates as $i)
                                '{{'rgba('.rand(1,255).','.rand(1,255).','.rand(1,255).', 0.6)'}}',
                            @endforeach
                        ],
                        borderColor: [
                            @foreach($templates as $i)
                                '{{'rgba('.rand(10,150).','.rand(1,70).','.rand(20,120).', 1)'}}',
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
            @else
            var selectedTemplateChart = $("#selectedTemplateChart");
            var myChart = new Chart(selectedTemplateChart, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($stat_template as $template)
                            '{{$template[0]->created_at->format('M-Y')}}',
                        @endforeach
                    ],
                    datasets: [{
                        label: "Total Use",
                        data: [
                            @foreach($stat_template as $template)
                                '{{count($template)}}',
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach($stat_template as $i)
                                '{{'rgba('.rand(200,300).','.rand(1,300).','.rand(700,900).', 1)'}}',
                            @endforeach
                        ],
                        borderColor: [
                            @foreach($stat_template as $i)
                                '{{'rgba('.rand(200,300).','.rand(1,300).','.rand(700,900).', 1)'}}',
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
    @if($template_id != 0)
        <link rel="stylesheet" href="{{url('/dashboard/plugins/datatables/datatable.min.css')}}">
        <script src="{{url('/dashboard/plugins/datatables/datatable.min.js')}}"></script>
        <script>
            $(document).ready(function () {
                $('.datatable').DataTable();
            })
        </script>
    @endif
@endsection