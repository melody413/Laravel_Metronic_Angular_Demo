@extends('layouts.app')

@section('title')
    App Settings
@endsection

@section('extra-css')

@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-icon">
                <i class="icon icon-pill"></i>
            </div>
            <div class="card-content">
                <a href="{{url('/config-cache')}}" class="btn btn-success pull-right">Clear Cache</a>
                <h4 class="card-title">App Setting</h4>
                <p>After save your app setting you need to clear the application cache. to make change the application behavior . <i>You might need to re login after config the cache</i> </p>

                <ul class="nav nav-tabs tabs">
                    <li class="tab">
                        <a href="ui-tabs.html#mail-setup" data-toggle="tab" aria-expanded="false">
                            Mail Setup
                        </a>
                    </li>
                    <li class="tab">
                        <a href="ui-tabs.html#application-setup" data-toggle="tab" aria-expanded="false">
                            Application Setup
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    @include('user.doctor.setting.app-setting.tab-body.mail')
                    @include('user.doctor.setting.app-setting.tab-body.application')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    @if(session('cache-config'))
        <script>
            $(document).ready(function () {
                console.log('ddd');
                $.Notification.notify('success','top right','Application configuration cache updated')
            });
        </script>
    @endif
    <script>
        $(document).ready(function () {
            console.log('Ready');
            $('#mailSettingForm').on('submit',function (e) {
                e.preventDefault();
                var data = new FormData(this);
                $(this).speedPost('{{url('/mail-setting')}}',data);
                console.log('Submit');
            });

            $("#appSetupForm").on('submit',function (e) {
                e.preventDefault();
                var data = new FormData(this);
                $(this).speedPost('{{url('/app-setting')}}',data);
            })
        })
    </script>
@endsection