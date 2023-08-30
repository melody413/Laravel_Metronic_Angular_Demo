@extends('layouts.app')

@section('title')
    Profile Setting
@endsection

@section('extra-css')

@endsection

@section('content')
    @include('user.doctor.setting.profile.change-password')
    @include('user.doctor.setting.profile.about-me')
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="fa fa-user-circle-o fa-2x"></i>
            </div>
            <div class="card-content">
                <h4 class="card-title">{{auth()->user()->name}}</h4>
                <center>
                    <img class="img-rounded" width="220px" src="{{url(auth()->user()->image ? auth()->user()->image : '/dashboard/images/image_placeholder.jpg')}}" alt="">
                    <h4>{{auth()->user()->name}}</h4>
                    <p>
                        {{auth()->user()->email}} <br>
                        {{auth()->user()->phone}} <br>
                        @if(auth()->user()->role == 1)
                            {!! nl2br(e(auth()->user()->info)) !!}
                        @endif
                    </p>
                    <a href="{{url('/edit-profile')}}" class="btn btn-success"><i class="fa fa-pencil-square-o"></i> Edit Profile</a>
                    <button class="btn btn-success" data-toggle="modal" data-target="#change-password"><i class="fa fa-key"></i> Change Password</button>
                    @if(auth()->user()->role == 1)
                    <button class="btn btn-primary"  data-toggle="modal" data-target="#about-me"> About Me</button>
                    @endif
                </center>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function () {
            $('#passwordChangeForm').on('submit',function (e) {
                e.preventDefault();
                var data = new FormData(this);
                $.ajax({
                    url: '{{url('/change-password')}}',
                    type: 'POST',
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $.Notification.notify('success', 'top right', 'Password has been changed successfully');
                        $("#change-password").modal('hide');
                    }, error: function (data) {
                        if(data.status == 422 ){
                            $(this).showValidationError(data);
                        }else if(data.status == 500){
                            $.Notification.notify('error', 'top right', 'Current password not match','Current password not match');
                        }else{
                         $.Notification.notify('error','top right','Internal server error');
                        }
                    }
                });
            });

            $("#saveAboutMe").on('submit',function (e) {
                e.preventDefault();
                var data = new FormData(this);
                $.ajax({
                    url: '{{url('/save-about')}}',
                    type: 'POST',
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $.Notification.notify('success', 'top right', 'About me saved successfully');
                        $("#about-me").modal('hide');
                    }, error: function (data) {
                        if(data.status == 422 ){
                            $(this).showValidationError(data);
                        }else if(data.status == 500){
                            $.Notification.notify('error', 'top right', 'Current password not match','Current password not match');
                        }else{
                            $.Notification.notify('error','top right','Internal server error');
                        }
                    }
                });
            })
        })
    </script>
@endsection