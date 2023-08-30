@extends('layouts.auth')

@section('content')

<div class="clearfix"></div>
<div class="wrapper-page">
    <div class="card-box {{ $errors->has('email') ? 'form-shake' : '' }}">
        <div class="panel-heading text-center" style="background: #fff04b; color: #222;">
            <h4 class=""> Reset Password</h4>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="p-20">
            <form class="form-horizontal m-t-20" action="{{ route('password.email') }}" method="POST">
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

                <div class="form-group text-center m-t-40">
                    <div class="col-12">
                        <button class="btn btn-success btn-block text-uppercase waves-effect waves-light"
                                type="submit">Send Password Reset Link
                        </button>
                    </div>
                </div>


                <div class="form-group m-t-30 m-b-0">
                    <div class="col-12">
                        <a href="{{route('login')}}" class="text-dark"><i class="fa fa-lock m-r-5"></i>
                            Login</a>
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
