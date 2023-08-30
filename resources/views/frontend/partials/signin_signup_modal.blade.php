<!-- Modal -->
<div class="modal fade the_modal login_register_modal" id="signin_signup_modal" tabindex="-1" role="dialog" aria-labelledby="signin_signup_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signin_signup_modal_title">{{ trans('general.signin_join') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('frontend.user.post_login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="col-form-label">{{ trans('general.email_address') }}</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-form-label">{{ trans('general.password') }}</label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ trans('general.remember_me') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <a class="btn btn-link text-md-right" href="{{ route('frontend.password.request') }}">
                                {{ trans('general.forgot_your_password') }}
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn login_btn">
                            {{ trans('general.login') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row flex-column">
                    <strong>{{ trans('general.dont_have_account') }} </strong>
                    <a href="{{route('frontend.user.register',['user'=>\App\Models\User::USER_TYPE['user']])}}" class="btn register_btn">{{ trans('general.register_now_for_free') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>