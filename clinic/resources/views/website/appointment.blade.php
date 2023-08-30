@extends('layouts.auth')
@section('title')
    {{config('app.name')}} Appointment Schedule
@endsection

@section('content')
    <div class="container form-zoom-in-up" style="padding-top: 50px;">
        <div class="card-box">
            <div class="panel-heading">
                <h4 class="text-center"><strong>Appointment Schedule</strong></h4>
            </div>
            <div class="panel-body">
                @foreach($appointments as $appointment)
                    <div class="row">
                        <div class="col-md-6">
                            <h4>{{$appointment->name}}</h4>
                        </div>
                        <div class="col-md-6">
                            <h4>Contact :</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="padding-left: 45px;">
                            @foreach($appointment->dateTime as $date)
                                <p><b><u>{{$date->days}}</u></b> <br>
                                    Chamber Time : <b>{{\Carbon\Carbon::parse($date->start_time)->format('h:g a')}}</b> to
                                   <b> {{\Carbon\Carbon::parse($date->end_time)->format('h:g a')}}</b></p>
                            @endforeach
                        </div>
                        <div class="col-md-6" style="padding-left: 45px;">
                            <h4 style="font-size: 20px;">
                                {{$appointment->contact_person_name}}
                            </h4>
                            <dl class="row">
                                <dt class="col-sm-1"><i class="fa fa-phone-square" aria-hidden="true"></i></dt>
                                <dd class="col-sm-11"><a href="tel:{{$appointment->phone}}">{{$appointment->phone}}</a></dd>
                                <dt class="col-sm-1"><i class="fa fa-envelope" aria-hidden="true"></i></dt>
                                <dd class="col-sm-11"><a href="mailto:{{$appointment->email}}">{{$appointment->email}}</a></dd>
                                <dt class="col-sm-1"><i class="fa fa-map-marker" aria-hidden="true"></i></dt>
                                <dd class="col-sm-11"> {!! nl2br(e($appointment->address)) !!}</dd>
                            </dl>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection