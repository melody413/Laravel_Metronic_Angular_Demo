@extends('frontend.master')


@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <div class="inner_container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="stand_alone_container">
                        <h1>{{ __('general.register_doctors') }}</h1>
                        <div class="stand_alone_inner">
                            <form method="POST" action="{{ route('frontend.user.post_register') }}">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="first_name">{{ trans('general.first_name') }}</label>
                                        <input id="first_name" type="text" class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" placeholder="{{ trans('general.first_name') }}" required autofocus>
                                        @if ($errors->has('first_name'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="last_name">{{ trans('general.last_name') }}</label>
                                        <input id="last_name" type="text" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" placeholder="{{ trans('general.last_name') }}" required autofocus>
                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dr_phone">{{ trans('general.dr_phone') }}</label>
                                    <input id="dr_phone" type="text" class="form-control {{ $errors->has('dr_phone') ? ' is-invalid' : '' }}" name="dr_phone" value="{{ old('dr_phone') }}" placeholder="{{ trans('general.dr_phone') }}" required autofocus>
                                    @if ($errors->has('dr_phone'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('dr_phone') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="phone">{{ trans('general.specialty') }}</label>
                                    <div class="demo-checkbox">
                                        <div id="specialties-tags">
                                            {{-- @foreach(dataForm()->getSpeciality() as $row)
                                                <div class="col-sm specialty-row" class="row">
                                                    {!! Form::checkbox($row->id, 'specialties[]', isset($specialityIds) && in_array($row->id, $specialityIds), array('id'=> 'specialties_'.$row->id,'class' => 'form-control filled-in chk-col-brown')) !!}
                                                    <label for="specialties_{{ $row->id }}">{{ $row->name }}</label>
                                                </div>
                                            @endforeach --}}
                                            <select multiple="multiple" data-placeholder="{{ trans('general.specialities_multiple') }}" class="form-control specialities-multiple select2" name="specialties" id="" required="required">
                                                <option></option>
                                                @foreach(dataForm()->getSpeciality() as $row)
                                                    <option {{isset($specialityIds) && in_array($row->id, $specialityIds) ? 'selected' : ''}} value="{{$row->id}}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @include('admin.partial._row_error', ['input' => 'specialties'])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="specialty_sub">{{ trans('general.in_specialty') }}</label>
                                    <input id="specialty_sub" type="text" class="form-control" name="specialty_in" value="{{ old('specialty_sub') }}" placeholder="{{trans('general.specialty')}}">
                                </div>

                                <div class="form-group">
                                    <label for="phone">{{ trans('general.clinic_phone') }}</label>
                                    <input id="phone" type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" placeholder="{{ trans('general.phone') }}" required autofocus>
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="phone">{{ trans('general.city') }}</label>
                                    <div class="">
                                        <select data-placeholder="{{ trans('general.city') }}" class="form-control bsCityies select2" name="bsCityies" id="" required="required">
                                            <option></option>
                                            @if(\Request::segment(1) == "eg")
                                                @foreach(\App\Models\City::where("country_id", 1)->get() as $row)
                                                    <option value="مصر - {{$row->name}} - ">{{ $row->name }}</option>
                                                @endforeach
                                            @elseif(\Request::segment(1) == "sa")
                                                @foreach(\App\Models\City::where("country_id", 2)->get() as $row)
                                                    <option value="السعودية - {{$row->name}} - ">{{ $row->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @include('admin.partial._row_error', ['input' => 'city_id'])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">{{ trans('general.clinic_address') }}</label>
                                    <input id="address" type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}" placeholder="{{ trans('general.clinic_address') }}" required autofocus>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input id="facebook" type="text" class="form-control" name="ddfacebook" value="{{ old('facebook') }}" placeholder="facebook">
                                </div>
                                <div class="form-group">
                                    <label for="twitter">Twitter</label>
                                    <input id="twitter" type="text" class="form-control" name="ddtwitter" value="{{ old('twitter') }}" placeholder="twitter">
                                </div>
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input id="instagram" type="text" class="form-control" name="instagram" value="{{ old('instagram') }}" placeholder="instagram">
                                </div>                                
                                <div class="form-check form-check-inline">
                                    <input id="gender_male" checked type="radio" class="form-check-input {{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" value="male">
                                    <label for="name" class="form-check-label">{{ trans('general.male') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="gender_female" type="radio" class="form-check-input {{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" value="female">
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
                                    <input id="birthdate" type="text" class="form-control {{ $errors->has('birthdate') ? ' is-invalid' : '' }} datepicker" name="birthdate" value="{{ old('birthdate') }}" placeholder="{{ trans('general.birth_date') }}">
                                    @if ($errors->has('birthdate'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('birthdate') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ trans('general.email_address') }}</label>
                                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ trans('general.email_address') }}" required>
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
                                <br>
                                <div class="form-check form-group">
                                    <input id="share_approved" type="checkbox" class="form-check-input {{ $errors->has('share_approved') ? ' is-invalid' : '' }}" name="share_approved" value="1">
                                    <label for="name" class="form-check-label">
                                        أرغب في المشاركة في تسجيل لقاءات مصورة توعوية يقوم الموقع بانتاجها وتنشر على موقع دكتورك ومواقع التواصل الاجتماعي باسمي
                                    </label>
                                </div>
                                <br>
                                <div class="form-check form-group">
                                    <input id="live_approved" type="checkbox" class="form-check-input {{ $errors->has('live_approved') ? ' is-invalid' : '' }}" name="live_approved" value="1">
                                    <label for="name" class="form-check-label">  
                                        أوافق على المشاركة في فقرة لايف طبي مع متابعي الصفحة
                                    </label>
                                </div>
                                <br>
                                <div class="form-check form-group">
                                    <input id="services_approved" type="checkbox" class="form-check-input {{ $errors->has('services_approved') ? ' is-invalid' : '' }}" name="services_approved" value="1">
                                    <label for="name" class="form-check-label">  
                                        ارغب في الاستفادة من خدمات دكتورك للاطباء والعيادات
                                    </label>
                                </div>
                                <input type="hidden" name="type" value="{{$type}}">
                                <br>
                                <button type="submit" class="register_btn">
                                    {{ trans('general.register') }}
                                </button>
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<style>
        input[name="specialties[]"] {
            width: 20px;
            margin: -5px 5px 0px 5px;
            float: right;
        }
        label {
            width: 80%;
        }
        .col-sm.specialty-row {
            min-width: 175px;
            font-size: 88%;
            background: #eee;
            padding: 5px 0px 0;
        }
        body {
            font-family: Cairo,Tahoma,sans-serif;
        }
        .select2-container .select2-search--inline .select2-search__field {
            height: 26px;
            text-align: right;
            font-family: Cairo,Tahoma,sans-serif;
            padding-right: 1ch
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        document.addEventListener("DOMContentLoaded", function(event) {
            $('.specialities-multiple').select2()
            $('.bsCityies').select2()
        });
</script>

@endsection
