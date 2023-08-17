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
                        <img width="250px" src="{{$patient->iamge != null ? $patient->iamge : "/dashboard/images/image_placeholder.jpg"}}" alt="">

                    </div>
                    <div class="col-md-8">
                        <dl class="dl-horizontal">
                            <dt>Name</dt>
                            <dd>{{$patient->name}}</dd>
                            <dt>Gender</dt>
                            <dd>{{$patient->gender ==1 ? "Male" : $patient->gender ==2 ? "Fe-Male" : "Other" }}</dd>
                            <dt>Age</dt>
                            <dd>{{$patient->age()}}</dd>
                        </dl>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Prescription Info <a style="font-size: 15px;" href="{{url('/take-patient-to-prescription-page/'.$patient->id)}}" class="pull-right"> <i class="ti ti-ink-pen"></i> Write new prescription</a></h4>
                        <ul class="list-group">
                            @foreach($patient->prescriptions as $pres)
                                <li class="list-group-item"><a href="{{url('/print-prescription/'.$pres->id)}}" class="btn btn-default pull-right"><i class="fa fa-eye"></i> View</a> {{$pres->created_at->format('d-M-Y')}} </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Payment Info <a style="font-size: 15px;" href="javascript:void(0);" onclick="window.location.replace('{{url('/take-patient-to-appointment/'.$patient->id)}}')" class="pull-right"> <i class="ti ti-calendar"></i> Make an appointment</a> </h4>
                        <ul class="list-group">
                            @foreach($patient->payments as $payment)
                                <li class="list-group-item">{{$payment->payment}} <span class="pull-right">{{$payment->created_at->format('d-M-Y')}}</span> </li>
                            @endforeach
                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('extra-js')

@endsection