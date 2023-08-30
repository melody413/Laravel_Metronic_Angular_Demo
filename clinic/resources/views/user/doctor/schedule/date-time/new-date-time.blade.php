@extends('layouts.app')

@section('title')
    Date time
@endsection

@section('extra-css')

@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-calendar fa-2x"></i>
            </div>
            <div class="card-content">
                <a href="{{url('/all-schedule')}}" class="btn btn-success pull-right">My Schedule</a>
                <h4 class="card-title">{{$schedule->name}}</h4>
                <form action="{{url('/save-schedule-datetime/'.$schedule->id)}}" method="post">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group-custom">
                                <select name="days" id="">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                                <label class="control-label">Days &nbsp;*</label><i class="bar"></i>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-custom">
                                <input type="time" name="start_time" required="required" autofocus/>
                                <label class="control-label">Start Time &nbsp;*</label><i class="bar"></i>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-custom">
                                <input type="time" name="end_time" required="required" autofocus/>
                                <label class="control-label">End Time &nbsp;*</label><i class="bar"></i>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit &nbsp; <i id="loading" class="fa fa-refresh fa-spin"></i></button>
                    <button type="reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                </form>
                <hr>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th width="10%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($schedule->dateTime as $dateTime)
                            <tr>
                                <td>{{$dateTime->days}}</td>
                                <td>{{\Carbon\Carbon::parse($dateTime->start_time)->format('g:i A')}}</td>
                                <td>{{\Carbon\Carbon::parse($dateTime->end_time)->format('g:i A')}}</td>
                                <td> <button onclick="$(this).confirmDelete('{{url('/delete-schedule-datetime/'.$dateTime->id)}}')" class="btn btn-danger">Delete</button> </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')

@endsection