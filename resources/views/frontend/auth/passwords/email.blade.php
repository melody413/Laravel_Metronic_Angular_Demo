@extends('frontend.master')

@section('content')
<div class="inner_container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="stand_alone_container">
                    <h1>{{ trans('general.reset_password') }}</h1>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="stand_alone_inner">
                        <form method="POST" action="{{ route('frontend.password.post_request') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ trans('general.email_address') }}</label>
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ trans('general.email_address') }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
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
