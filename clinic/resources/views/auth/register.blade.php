@extends('layouts.auth')

@section('content')


<div class="clearfix"></div>
<div class="wrapper-page">
    <div class="card-box form-zoom-in-up {{ $errors->has('email') || $errors->has('password') || $errors->has('name') ? 'form-shake' : '' }}">
        <div class="panel-heading">
            <h4 class="text-center"> Register</h4>
        </div>

        <div class="p-20">
            <form class="form-horizontal m-t-20" action="{{ route('register') }}" method="POST">
                {{csrf_field()}}
                <div class="form-group-custom">
                    <input type="text" id="user-name" name="name" value="{{old('name')}}" required="required"/>
                    <label class="control-label" for="user-name">Full Name</label><i class="bar"></i>
                    @if ($errors->has('name'))
                        <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('name') }}</strong>
                            </span>
                    @endif
                </div>

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
                    <input type="password" id="user-password" name="password" required="required"/>
                    <label class="control-label" for="user-password">Password</label><i class="bar"></i>
                    @if ($errors->has('password'))
                        <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('password') }}</strong>
                            </span>
                    @endif
                </div>

                <div class="form-group-custom">
                    <input type="password" id="user-password" name="password_confirmation" required="required"/>
                    <label class="control-label" for="user-password">Confirm Password</label><i class="bar"></i>
                </div>

                <div class="form-group text-center m-t-40">
                    <div class="col-12">
                        <button class="btn btn-success btn-block text-uppercase waves-effect waves-light"
                                type="submit">Sign Up
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <p class="text-white">Already have an account? <a href="{{ route('login') }}" class="text-white m-l-5"><b>Sign
                        In</b></a>
            </p>

        </div>
    </div>
</div>
@endsection
