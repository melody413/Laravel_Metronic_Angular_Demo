@extends('layouts.app')

@section('title')
    Drug Report
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
                <h4 class="card-title">Drug Report </h4>
                <form action="javascript:void(0)" method="post" id="drugReport">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-custom ">
                                <select class="form-control select2" name="drug_id" id="" required="required">
                                    <option value="0" {{$drug_id ==0 ? 'selected' : ''}}>All Drug</option>
                                    @foreach($drugs as $drug)
                                        <option value="{{$drug->id}}" {{$drug_id ==$drug->id ? 'selected' : ''}}>{{$drug->name}} </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group-custom">
                                <input type="date"  value="{{$start}}" id="start" required="required"/>
                                <label class="control-label">Start Date &nbsp;*</label><i class="bar"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group-custom">
                                <input type="date" required="required" id="end" value="{{$end}}" />
                                <label class="control-label">End Date</label><i class="bar"></i>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit &nbsp; <i id="loading" class="fa fa-refresh fa-spin"></i></button>
                </form>
                <br>
                @if($drug_id == 0)
                    <h4 class="m-t-0 header-title"><b>All Drug Chart</b></h4>

                    <canvas id="allDrug" height="70vh" width="100%"></canvas>
                @else
                    Selected drug chart
                    <canvas id="selectedDrug" height="50vh" width="100%"></canvas>
                    @foreach($drug_stat as $drug)
                        <h1>Date - {{$drug[0]->created_at->format('M-Y')}} </h1>

                            <table class="table table-bordered datatable" >
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($drug as $d)
                                    <tr>
                                        <td>{{$d->created_at->format('d-M-Y')}}</td>
                                        <td><a href="{{url('/print-prescription/'.$d->prescription_id)}}" target="_blank">View on prescription <i class="fa fa-external-link"></i> </a></td>
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

            $('#drugReport').on('submit',function (e) {
                e.preventDefault();
                var drugId = $(".select2").val();
                var start = $('#start').val() != '' ?  $('#start').val() : '2017-06-05';
                var end = $('#end').val() != '' ? $('#end').val() : '{{\Carbon\Carbon::today()->addDay(1)->toDateString()}}';
                window.location.replace('/drug-report/drug='+drugId+'/start='+start+'/end='+end);
            });

            $(".select2").select2({
                placeholder: "Please select a drug *",
                width: '100%'
            });
            @if($drug_id == 0)
            var barChart = $("#allDrug");
            var myChart = new Chart(barChart, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($drugs as $drug)
                            '{{$drug->name}}',
                        @endforeach
                    ],
                    datasets: [{
                        label: "Total Use",
                        data: [
                            @foreach($drugs as $drug)
                                '{{count($drug->prescriptions)}}',
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach($drugs as $i)
                                '{{'rgba('.rand(200,300).','.rand(1,300).','.rand(700,900).', 1)'}}',
                            @endforeach
                        ],
                        borderColor: [
                            @foreach($drugs as $i)
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
            @else
                var selectedDrugChart = $("#selectedDrug");
            var myChart = new Chart(selectedDrugChart, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($drug_stat as $drug)
                            '{{$drug[0]->created_at->format('M-Y')}}',
                        @endforeach
                    ],
                    datasets: [{
                        label: "Total Use",
                        data: [
                            @foreach($drug_stat as $drug)
                                '{{count($drug)}}',
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach($drug_stat as $i)
                                '{{'rgba('.rand(200,300).','.rand(1,300).','.rand(700,900).', 1)'}}',
                            @endforeach
                        ],
                        borderColor: [
                            @foreach($drug_stat as $i)
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

    @if($drug_id != 0)
        <link rel="stylesheet" href="{{url('/dashboard/plugins/datatables/datatable.min.css')}}">
        <script src="{{url('/dashboard/plugins/datatables/datatable.min.js')}}"></script>
        <script>
            $(document).ready(function () {
                $('.datatable').DataTable();
            })
        </script>
    @endif
@endsection