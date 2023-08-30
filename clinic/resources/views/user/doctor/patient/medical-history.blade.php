@extends('layouts.app')

@section('title')
    Medical History
@endsection

@section('extra-css')
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-user-circle-o fa-2x"></i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Medical History of - {{$patient->name}}</h4>
                <div class="row">
                    <div class="col-md-4">
                        <img width="250px"
                             src="{{$patient->iamge != null ? $patient->iamge : "/dashboard/images/image_placeholder.jpg"}}"
                             alt="">

                    </div>
                    <div class="col-md-8">
                        <dl class="dl-horizontal">
                            <dt>Name</dt>
                            <dd>{{$patient->name}}</dd>
                            <dt>Gender</dt>
                            <dd>
                                @if($patient->gender ==1)
                                    Male
                                @elseif($patient->gender ==2)
                                    Fe-Male
                                @else
                                    Other
                                @endif
                            <dt>Age</dt>
                            <dd>{{$patient->age()}}</dd>
                        </dl>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Prescriptions <a style="font-size: 15px;"
                                             href="{{url('/take-patient-to-prescription-page/'.$patient->id)}}"
                                             class="pull-right"> <i class="ti ti-ink-pen"></i> Write new
                                prescription</a></h4>
                        <ul class="list-group">
                            @foreach($patient->prescriptions as $pres)
                                <li class="list-group-item"><a href="{{url('/print-prescription/'.$pres->id)}}"
                                                               class="btn btn-default pull-right"><i
                                                class="fa fa-eye"></i> View</a> {{$pres->created_at->format('d-M-Y')}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Medical document (Image) <a style="font-size: 15px;"
                                                        href="{{url('/patient-medical-file/'.$patient->id)}}"
                                                        class="pull-right"> <i class="fa fa-plus"></i> Add Medical file</a>
                        </h4>
                        @foreach($patient->medicalFiles as $file)
                            <a href="{{url($file->path)}}" target="_blank" class="swipebox" title="My Caption">
                                <img src="{{url($file->path)}}" class="img-thumbnail" width="220px" alt="image">
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('extra-js')

@endsection