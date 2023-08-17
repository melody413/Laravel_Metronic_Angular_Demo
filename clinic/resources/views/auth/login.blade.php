@extends('layouts.auth')

@section('title')
    {{config('app.name')}} - Login
@endsection

@section('content')

    <div class="clearfix"></div>
    <div class="wrapper-page">
        <div class="card-box form-zoom-in-up {{ $errors->has('email') || $errors->has('password') ? 'form-shake' : '' }}">
            <div class="panel-heading text-center" style="background: #fff04b; color: #222;">
                <h4 class=""> Login to <strong>Doctorak Admin</strong></h4>
            </div>

            <div class="p-20">
                <form class="form-horizontal m-t-20" action="{{ route('login') }}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group-custom">
                        <input type="email" id="user-name" name="email" value="{{old('email')}}" required="required"/>
                        <label class="control-label" for="user-name">Email Address</label><i class="bar"></i>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group-custom">
                        <input type="password" id="user-password" name="password" value="{{old('password')}}"
                               required="required"/>
                        <label class="control-label" for="user-password">Password</label><i class="bar"></i>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>


                    <div class="form-group ">
                        <div class="col-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox"
                                       name="remember" {{ old('remember') ? 'checked' : '' }}/>
                                <label for="checkbox-signup">
                                    Remember me
                                </label>
                            </div>

                        </div>
                    </div>


                    <div class="form-group text-center m-t-40">
                        <div class="col-12">
                            <button class="btn btn-success btn-block text-uppercase waves-effect waves-light"
                                    type="submit">Log In
                            </button>
                        </div>
                    </div>


                    <div class="form-group m-t-30 m-b-0">
                        <div class="col-12">
                            <a href="{{route('password.request')}}" class="text-dark"><i class="fa fa-lock m-r-5"></i>
                                Forgot
                                your password?</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        {{--<div class="row">--}}
            {{--<div class="col-sm-12 text-center">--}}
                {{--<p class="text-white">Don't have an account? <a href="{{ route('register') }}" class="text-white m-l-5"><b>Sign--}}
                            {{--Up</b></a>--}}
                {{--</p>--}}

            {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function (e) {
            $("#user-name").bind('change keyup',function (e) {
                console.log('Change');
                $(".help-block").hide();
            });

            $("#user-password").on('change keyup',function (e) {
                $(".help-block").hide();
            });
        });
    </script>
@endsection