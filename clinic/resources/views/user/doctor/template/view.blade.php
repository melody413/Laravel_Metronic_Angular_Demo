@extends('layouts.app')

@section('title')
    View Template {{$template->name}}
@endsection

@section('extra-css')

@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-file-o fa-2x"></i>
            </div>
            <div class="card-content">
                <h4 class="card-title">View template -{{$template->name}}</h4>
                <div id="print_prescription">
                    <style>
                        @media print {
                            .col-md-4 {
                                width: 40%;
                            }

                            .col-md-8 {
                                width: 60%;
                            }
                        }
                    </style>
                    <div class="row">
                        <div class="col-md-4" style="margin-top: 35px;">
                            <p><b>Chief Complain :</b> <br>
                                {!! nl2br(e($template->prescriptionTemplateLeft->cc)) !!}
                            </p>
                            <p><b>On Examination :</b> <br>
                                {!! nl2br(e($template->prescriptionTemplateLeft->oe)) !!}
                            </p>
                            <p><b>Provisional Diagnosis :</b> <br>
                                &emsp;{!! nl2br(e($template->prescriptionTemplateLeft->pd)) !!}
                            </p>
                            <p><b>Differential Diagnosis :</b> <br>
                                &emsp;&emsp;{!! nl2br(e($template->prescriptionTemplateLeft->dd)) !!}
                            </p>
                            <p><b>Lab workup :</b> <br>
                                &emsp;&emsp;{!! nl2br(e($template->prescriptionTemplateLeft->lab_workup)) !!}
                            </p>
                            <p><b>Advice :</b> <br>
                                {!! nl2br(e($template->prescriptionTemplateLeft->advice)) !!}
                            </p>
                        </div>
                        <div class="col-md-8" style="border-left: 1px solid black;">
                            <img src="{{url('/dashboard/images/rx.png')}}" width="30px" alt="">

                            <ol>
                                @foreach($template->drugs as $drug)
                                    <li><i>{{$drug->type}}</i> <b>{{$drug->drug['name']}}</b> {{$drug->strength}}
                                        <ul style="padding-left: 10px">
                                            <li style="list-style: none">{{$drug->dose}} &emsp; {{$drug->duration}}</li>
                                            <li style="list-style: none">{{$drug->advice}}</li>
                                        </ul>
                                    </li>
                                @endforeach
                            </ol>
                            {{--<code>{{$drug}}</code>--}}

                        </div>
                    </div>
                </div>
                <button id="print" class="btn btn-success pull-right"><i class="fa fa-print"></i> &nbsp; Print</button>
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
        });
    </script>
@endsection