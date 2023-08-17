@extends('layouts.app')

@section('title')
    Edit Schedule
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
                <h4 class="card-title">Edit Schedule - {{$schedule->name}}</h4>
                <form action="#" method="post" id="updateSchedule">
                    {{csrf_field()}}
                    <div class="form-group-custom">
                        <input type="text" name="name" value="{{$schedule->name}}" required="required" autofocus/>
                        <label class="control-label">Title &nbsp;*</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        <input type="text" name="contact_person_name" value="{{$schedule->contact_person_name}}" required="required"/>
                        <label class="control-label">Contact person name &nbsp;*</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        <input type="text" name="email" value="{{$schedule->email}}" required="required"/>
                        <label class="control-label">Contact person email &nbsp;*</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        <input type="text" name="phone" value="{{$schedule->phone}}" required="required"/>
                        <label class="control-label">Contact person phone &nbsp;*</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        <textarea name="address" required="required">{{$schedule->address}}</textarea>
                        <label class="control-label">Address</label><i class="bar"></i>
                    </div>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit &nbsp; <i id="loading" class="fa fa-refresh fa-spin"></i></button>
                    <button type="reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function () {
            $("#updateSchedule").on('submit',function (e) {
                e.preventDefault();
                var data = new FormData(this);
                $.ajax({
                    url: "/update-schedule/{{$schedule->id}}",
                    type:'POST',
                    data:data,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success:function (data) {
                        $.Notification.notify('success','top right','Schedule update successfully',
                            'We are taking you to the schedule date and time page');
                        window.location.replace('/schedule='+data.id+'/date-time');
                    },error:function (data) {
                        if(data.status == 422 ){
                            $.each(data.responseJSON,function (key,data) {
                                for(var key in data) {
                                    if(key.length > 2){
                                        $.each(data[key],function (index,data) {
                                            $.Notification.notify('error','top right',data)
                                        })
                                    }
                                }
                            });
                        }else{
                            $.Notification.notify('warning','top right',"Internal server error",
                                "Internal server error" +
                                "Refresh this page and try again" +
                                "Or, contact to your system admin")
                        }
                    }
                })
            })
        });
    </script>
@endsection