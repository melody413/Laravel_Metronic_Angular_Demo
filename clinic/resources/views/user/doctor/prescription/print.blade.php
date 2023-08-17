@extends('layouts.app')
@section('title')
    Print
@endsection

@section('extra-css')
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <style>
        @if(config('app.fancy_font') == 1)
        p > b {
            font-family: 'Lobster', cursive;
        }

        .prescription-p-title{
            font-family: 'Lobster', cursive;
            font-weight: 100;
            font-size: 16px;
        }
        @endif
    </style>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-print fa-2x"></i>
            </div>
            <div class="card-content">
                <div id="printPage">
                    <div class="text-right">
                        <h3>{{$prescription->user->name}}</h3>
                        <p>{!! nl2br(e($prescription->user->info)) !!}</p>
                    </div>

                    <div id="print_prescription">

                        <style>
                            @media print {
                                @if(config('app.fancy_font') == 1)
                                p > b {
                                    font-family: 'Lobster', cursive;
                                }
                                .prescription-p-title{
                                    font-family: 'Lobster', cursive;
                                    font-weight: 100;
                                    font-size: 16px;
                                }
                                @endif
                                .col-md-4 {
                                    width: 40%;
                                }

                                .col-md-8 {
                                    width: 60%;
                                }
                            }
                        </style>


                        <table width="100%" style="margin-bottom: 10px;">
                            <thead>
                            <tr>
                                <th> <span class="prescription-p-title">Name</span> : {{$prescription->patient->name}}</th>
                                <th> <span class="prescription-p-title">Age</span>
                                    : {{$prescription->patient->date_of_birth->diff($prescription->created_at)->format('%y years,%m month,%d days')}}</th>
                                <th><span class="prescription-p-title">Gender</span>
                                    : @if($prescription->patient->gender ==1)
                                        Male
                                    @elseif($prescription->patient->gender ==2)
                                        Fe-Male
                                    @else
                                        Other
                                    @endif
                                </th>
                                <th>
                                    <span class="prescription-p-title">Date :</span>
                                    {{$prescription->prescription_date->format('d-M-Y')}}
                                </th>
                            </tr>
                            </thead>
                        </table>
                        <div class="row">

                            <div class="col-md-4" style="margin-top: 0px;">
                                <dl>
                                    @if($prescription->prescriptionLeft->cc != null || $prescription->prescriptionLeft->cc != "" )
                                    <dt class="prescription-p-title">Chief Complain :</dt>
                                    <dd>{!! nl2br(e($prescription->prescriptionLeft->cc)) !!}</dd>
                                    @endif
                                    @if($prescription->prescriptionLeft->oe != null || $prescription->prescriptionLeft->oe != '')
                                    <dt class="prescription-p-title">On Examination :</dt>
                                    <dd>{!! nl2br(e($prescription->prescriptionLeft->oe)) !!}</dd>
                                    @endif
                                    @if($prescription->prescriptionLeft->pd != null || $prescription->prescriptionLeft->pd != '')
                                    <dt class="prescription-p-title">Provisional Diagnosis :</dt>
                                    <dd>{!! nl2br(e($prescription->prescriptionLeft->pd)) !!}</dd>
                                    @endif
                                    @if($prescription->prescriptionLeft->dd != null || $prescription->prescriptionLeft->dd != '')
                                    <dt class="prescription-p-title">Differential Diagnosis :</dt>
                                    <dd>{!! nl2br(e($prescription->prescriptionLeft->dd)) !!}</dd>
                                    @endif
                                    @if($prescription->prescriptionLeft->lab_workup != null || $prescription->prescriptionLeft->lab_workup != '')
                                    <dt class="prescription-p-title">Lab workup :</dt>
                                    <dd>{!! nl2br(e($prescription->prescriptionLeft->lab_workup)) !!}</dd>
                                    @endif
                                    @if($prescription->prescriptionLeft->advice != null || $prescription->prescriptionLeft->advice != '')
                                    <dt class="prescription-p-title">Advice :</dt>
                                    <dd>{!! nl2br(e($prescription->prescriptionLeft->advice)) !!}</dd>
                                    @endif
                                </dl>

                            </div>
                            <div class="col-md-8" style="border-left: 1px solid black;">
                                <img src="{{url('/dashboard/images/rx.png')}}" width="30px" alt="">

                                <ol>
                                    @foreach($prescription->drugs as $drug)
                                        <li><i>{{$drug->type}}</i> <b>{{$drug->drug['name']}}</b>
                                            @if(config('app.generic_name') == 1)
                                                ({{$drug->drug['generic_name']}})
                                            @endif
                                            {{$drug->strength}}
                                            <ul style="padding-left: 10px">
                                                <li style="list-style: none">
                                                    {{$drug->dose}} &emsp; {{$drug->duration}}</li>
                                                <li style="list-style: none">{{$drug->advice}}</li>
                                            </ul>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                            <div class="col-md-4">
                                @if($prescription->next_visit != null || $prescription->next_visit != '')
                                <p><b>Next Visit :</b>
                                    {{$prescription->next_visit}}
                                </p>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <p class="prescription-p-title" style="border-top: 1px solid black; width: 150px;float: right;">Seal and
                                    Signature</p>
                            </div>
                        </div>

                    </div>
                </div>
                <button id="print" class="btn btn-inverse pull-right" ><i class="fa fa-print"></i> &nbsp; Print Prescription</button>
                <button id="printPageBtn" class="btn btn-success pull-right" style="margin-right: 15px;"><i class="fa fa-print"></i> &nbsp; Print Page</button>
                <br>
                <br>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script src="{{url('/dashboard/plugins/printthis/printThis.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#print").on('click', function () {
                $("#print_prescription").printThis();
            });

            $("#printPageBtn").on('click',function () {
                $("#printPage").printThis();
            });
        });
    </script>
@endsection