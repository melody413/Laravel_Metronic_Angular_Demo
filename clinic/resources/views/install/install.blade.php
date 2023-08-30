@extends('layouts.auth')


@section('title')
    Dr Assistant 2.0 Install
@endsection

@section('content')

    <div class="clearfix"></div>
    <div class="wrapper-page">
        <div class="card-box form-zoom-in-up ">
            <div class="panel-heading">
                <h4 class="text-center"> Install <strong>Dr.Assistant</strong></h4>
            </div>
            <p class="text-center">Avoid white space in this form </p>
            <div class="p-20">
                <form class="form-horizontal m-t-20" id="saveMySQLForm" action="{{ url('/save-mysql') }}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group-custom">
                        <input type="ip" name="db_host" value="127.0.0.1" required="required"/>
                        <label class="control-label" for="user-name">Host</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        <input type="number" id="user-name" name="db_port" value="3306" required="required"/>
                        <label class="control-label" for="user-name">Port</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        <input type="text" id="user-name" name="db_name" required="required"/>
                        <label class="control-label" for="user-name">Database name</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        <input type="text" id="user-name" name="db_username" required="required"/>
                        <label class="control-label" for="user-name">DB Username</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        <input type="password" id="user-name" name="db_password" required="required"/>
                        <label class="control-label" for="user-name">Password</label><i class="bar"></i>
                    </div>
                    <div class="form-group-custom">
                        <input type="password" id="user-name" name="confirm_pass" required="required"/>
                        <label class="control-label" for="user-name">Re-Type Password</label><i class="bar"></i>
                    </div>
                    <div class="form-group text-center m-t-40">
                        <div class="col-12">
                            <button class="btn btn-success btn-block text-uppercase waves-effect waves-light"
                                    type="submit">Submit &nbsp; <i id="loading" class="fa fa-refresh fa-spin"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script src="{{url('/dashboard/js/fastclick.js')}}"></script>
    <script src="{{url('/dashboard/plugins/notifyjs/js/notify.js')}}"></script>
    <script src="{{url('/dashboard/plugins/notifications/notify-metro.js')}}"></script>
    <script src="{{url('/dashboard/js/jquery.core.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#loading").hide();
            $("#saveMySQLForm").on('submit', function (e) {
                e.preventDefault();
                $("#loading").show();
                var data = new FormData(this);
                $.ajax({
                    url: '{{url('/save-mysql')}}',
                    type: 'POST',
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $.Notification.notify('success', 'top right', 'Migration success');
                        location.replace('/install-success');
                        $("#loading").hide();
                    }, error: function (data) {
                        if (data.status == 422) {
                            $.each(data.responseJSON, function (key, data) {
                                for (var key in data) {
                                    if (key.length > 2) {
                                        $.each(data[key], function (index, data) {
                                            $.Notification.notify('error', 'top right', data)
                                        })
                                    }
                                }
                            });
                        } else {
                            $.Notification.notify('error', 'top right', 'Access Denied');
                            console.log(data);
                        }
                        $("#loading").hide();
                    }
                });

            })
        })
    </script>
@endsection