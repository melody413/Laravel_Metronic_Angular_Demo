@extends('frontend.master')

@section('content')
    <div class="inner_container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="stand_alone_container">
                        <h1>{{ trans('general.profile_settings') }}</h1>
                        <div class="stand_alone_inner">
                            <form method="POST" action="{{ route('frontend.user.post_profile') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">{{ trans('general.name') }}</label>
                                    <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" placeholder="{{ trans('general.name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="phone">{{ trans('general.clinic_phone') }}</label>
                                    <input id="phone" type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ $user->phone }}" placeholder="{{ trans('general.phone') }}" required autofocus>
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="dr_phone">{{ trans('general.dr_phone') }}</label>
                                    <input id="dr_phone" type="text" class="form-control {{ $errors->has('dr_phone') ? ' is-invalid' : '' }}" name="dr_phone" value="{{ $user->dr_phone }}" placeholder="{{ trans('general.dr_phone') }}" required autofocus>
                                    @if ($errors->has('dr_phone'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('dr_phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="gender_male" @if($user->gender == 'male') checked @endif type="radio" class="form-check-input {{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" value="male">
                                    <label for="name" class="form-check-label">{{ trans('general.male') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="gender_female" @if($user->gender == 'female') checked @endif type="radio" class="form-check-input {{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" value="female">
                                    <label for="name" class="form-check-label">{{ trans('general.female') }}</label>
                                    @if ($errors->has('gender'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="clear c15"></div>
                                <div class="form-group">
                                    <label for="birthdate">{{ trans('general.birth_date') }}</label>
                                    <input id="birthdate" type="text" class="form-control {{ $errors->has('birthdate') ? ' is-invalid' : '' }} datepicker" name="birthdate" value="{{ $user->birthdate }}" placeholder="{{ trans('general.birth_date') }}">
                                    @if ($errors->has('birthdate'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('birthdate') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ trans('general.email_address') }}</label>
                                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" placeholder="{{ trans('general.email_address') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>



                                <div class="form-group">
                                    <label for="name">{{ trans('general.specialties') }}</label>
                                    <input id="name" type="text" class="form-control {{ $errors->has('specialties') ? ' is-invalid' : '' }}" name="specialties" value="{{ $user->specialties }}" placeholder="{{ trans('general.specialties') }}" required autofocus>
                                    @if ($errors->has('specialties'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('specialties') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="name">{{ trans('general.specialty_in') }}</label>
                                    <input id="name" type="text" class="form-control {{ $errors->has('specialty_in') ? ' is-invalid' : '' }}" name="specialty_in" value="{{ $user->specialty_in }}" placeholder="{{ trans('general.specialty_in') }}" required autofocus>
                                    @if ($errors->has('specialty_in'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('specialty_in') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="name">{{ trans('general.address') }}</label>
                                    <input id="name" type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ $user->address }}" placeholder="{{ trans('general.address') }}" required autofocus>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="name">{{ trans('general.facebook') }}</label>
                                    <input id="name" type="text" class="form-control {{ $errors->has('facebook') ? ' is-invalid' : '' }}" name="facebook" value="{{ $user->facebook }}" placeholder="{{ trans('general.facebook') }}">
                                    @if ($errors->has('facebook'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="name">{{ trans('general.twitter') }}</label>
                                    <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="twitter" value="{{ $user->twitter }}" placeholder="{{ trans('general.twitter') }}">
                                    @if ($errors->has('twitter'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('twitter') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="name">{{ trans('general.instagram') }}</label>
                                    <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="instagram" value="{{ $user->instagram }}" placeholder="{{ trans('general.instagram') }}">
                                    @if ($errors->has('instagram'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('instagram') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <button type="submit" class="register_btn">
                                    {{ trans('general.save') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
