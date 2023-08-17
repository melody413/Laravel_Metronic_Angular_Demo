@extends('frontend.master')

@section('content')
<div class="inner_container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="stand_alone_container">
                    <h1>{{ trans('general.reset_password') }}</h1>
                    <div class="stand_alone_inner">
                        <form method="POST" action="{{ route('password.request') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ trans('general.email_address') }}</label>
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" placeholder="{{ trans('general.email_address') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">{{ trans('general.password') }}</label>
                                <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ trans('general.password') }}" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">{{ trans('general.confirm_password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('general.confirm_password') }}" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="register_btn">
                                {{ trans('general.reset_password') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
