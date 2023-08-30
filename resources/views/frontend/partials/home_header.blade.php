<header class="header home_top doctors_selected responsive_container lazy" data-bg="https://doctorak.fra1.cdn.digitaloceanspaces.com/doctors.jpg">
    <div class="yello_shape"></div>
    <div class="container home_header" style="z-index: 5;">
        <div class="row justify-content-between">
            <div class="col-md-2">
                <div class="floating_logo">
                    <a href="{{ getCountryLangUrl() }}"><img class="lazy" data-src="https://doctorak.fra1.cdn.digitaloceanspaces.com/logo_big.png" width="127" height="76" alt="doctorak logo"></a>
                </div>
            </div>
            <div class="col-md-8">
                <nav class="site_nav">
                    <ul>
                        @if( \App::getLocale() == 'ar' )
                            <li>
                                <a rel="alternate" hreflang="en" href="/{!! getCountry()->code !!}_en">English</a>
                            </li>
                        @else
                            <li>
                                <a rel="alternate" hreflang="ar" href="/{!! getCountry()->code !!}">العربية</a>
                            </li>
                        @endif
                            <li class="country has_children">
                                <a href="">
                                    <img src="{{ f_assets('images/general/' . \App\Mangers\SettingsManger::Instance()->getCountry()->code . '.png') }}" width="48" alt="">
                                </a>
                                <ul class="nav_children">
                                    <li>
                                        <a href="/eg">
                                            <img src="{{ f_assets('images/general/eg.png') }}" width="48" alt="">
                                            <span>Egypt</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/sa">
                                            <img src="{{ f_assets('images/general/sa.png') }}" width="48" alt="">
                                            <span>KSA</span>
                                        </a>
                                    </li>
                                    {{-- @foreach(App\Mangers\SettingsManger::Instance()->getCountries() as $country)
                                        @if(\App\Mangers\SettingsManger::Instance()->getCountry()->code != $country->code)
                                            <li>
                                                <a href="{{ getCountryLangUrl($country->code) }}">
                                                    <img src="{{ f_assets('images/general/' . $country->code . '.svg') }}" width="48" alt="">
                                                    <span>{{ $country->name }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach --}}
                                </ul>
                            </li>
                        <li class="articles"><a href="/blog/" target="_blank">{{ trans('general.articles') }}</a></li>
                        @guest
                            <li class="add_business"><a href="{{route('frontend.user.register',['doctor'=>\App\Models\User::USER_TYPE['doctor']])}}">{{ trans('general.list_your_business') }}</a></li>
                        @endguest
                        @auth
                            <li class="signin_signup has_children">
                                <a href="#" onclick="return false" ><i class="fas fa-user"></i>  {{auth()->user()->name}}</a>
                                <ul class="nav_children">
                                    <li><a href="{{ route('frontend.user.profile') }}"><i class="fas fa-cog"></i> {{ trans('general.profile_settings') }}</a></li>
                                    @if(Auth::user()->type == \App\Models\User::USER_TYPE['user'])
                                        <li><a href="{{ route('frontend.my.reservation') }}"><i class="fas fa-calendar-check"></i> {{ trans('general.my_reservations') }}</a></li>
                                    @elseif(Auth::user()->type == \App\Models\User::USER_TYPE['doctor'])
                                        <li><a href="{{ route('frontend.doctor.reservation') }}"><i class="fas fa-calendar-check"></i> {{ trans('general.patients_reservations') }}</a></li>
                                    @endif
                                    <li><a href="{{ route('frontend.user.logout') }}"><i class="fas fa-sign-out-alt"></i> {{ trans('general.logout') }}</a></li>
                                </ul>
                            </li>
                        @endauth
                        @guest
                            <li class="signin_signup"><a href="#" onclick="return false" data-toggle="modal" data-target="#signin_signup_modal">{{ trans('general.signin_join') }}</a></li>
                        @endguest
                        {{--<li class="full_nav_toggler"><a href="#" onclick="return false" ><i class="fas fa-bars"></i></a></li>--}}
                    </ul>
                </nav>
            </div>
        </div>

    </div>
    <div class="container home_intro_text">
        <div class="row justify-content-center">
            <div class="col">
                <h1>{{ trans('general.home_h1') }}<br />
                    {{ trans('general.home_h1_e') }}</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="home_filter_wrapper">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs home_tabs" id="homeFilter" role="tablist">
                <li class="nav-item">
                    <a class="nav-link doctors active" id="doctors-tab" data-toggle="tab" href="#doctors" role="tab" aria-controls="doctors" aria-selected="true">
                        <i class="icon-doctor"></i>
                        <span>{{ trans('general.doctors') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link hospitals" id="hospitals-tab" data-toggle="tab" href="#hospitals" role="tab" aria-controls="hospitals" aria-selected="false">
                        <i class="icon-hospital"></i>
                        <span>{{ trans('general.hospitals') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link centers" id="centers-tab" data-toggle="tab" href="#centers" role="tab" aria-controls="centers" aria-selected="false">
                        <i class="icon-center"></i>
                        <span>{{ trans('general.centers') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pharmacies" id="pharmacies-tab" data-toggle="tab" href="#pharmacies" role="tab" aria-controls="pharmacies" aria-selected="false">
                        <i class="icon-pharmacey"></i>
                        <span>{{ trans('general.pharmacies') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link labs" id="labs-tab" data-toggle="tab" href="#labs" role="tab" aria-controls="labs" aria-selected="false">
                        <i class="icon-lab"></i>
                        <span>{{ trans('general.labs') }}</span>
                    </a>
                </li>
                <li class="nav-item" style="display:none">
                    <a class="nav-link insurances" id="insurances-tab" data-toggle="tab" href="#insurances" role="tab" aria-controls="insurances" aria-selected="false">
                        <i class="icon-insurance"></i>
                        <span>{{ trans('general.insurances') }}</span>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link medicines" id="medicines-tab" data-toggle="tab" href="#medicines" role="tab" aria-controls="medicines" aria-selected="false">
                        <i class="icon-medicine"></i>
                        <span>{{ trans('general.medicines') }}</span>
                    </a>
                </li> --}}
            </ul>
            <!-- Tab panes -->
            <div class="tab-content home_tab_content">
                <div class="tab-pane fade show doctors active" id="doctors" role="tabpanel" aria-labelledby="doctors-tab">
                    <div class="home_the_search">
                        @include('frontend.partials.the_search',['headerSearchParams'=>$homeParams['doctorSearch']])
                    </div>
                </div>
                <div class="tab-pane fade hospitals" id="hospitals" role="tabpanel" aria-labelledby="hospitals-tab">
                    <div class="home_the_search">
                        @include('frontend.partials.the_search',['headerSearchParams'=>$homeParams['hospitalSearch']])
                    </div>
                </div>
                <div class="tab-pane fade centers" id="centers" role="tabpanel" aria-labelledby="centers-tab">
                    <div class="home_the_search">
                        @include('frontend.partials.the_search',['headerSearchParams'=>$homeParams['centerSearch']])
                    </div>
                </div>
                <div class="tab-pane fade pharmacies" id="pharmacies" role="tabpanel" aria-labelledby="pharmacies-tab">
                    <div class="home_the_search">
                        @include('frontend.partials.the_search',['headerSearchParams'=>$homeParams['pharmacySearch']])
                    </div>
                </div>
                <div class="tab-pane fade labs" id="labs" role="tabpanel" aria-labelledby="labs-tab">
                    <div class="home_the_search">
                        @include('frontend.partials.the_search',['headerSearchParams'=>$homeParams['labSearch']])
                    </div>
                </div>
                <div class="tab-pane fade insurances" id="insurances" role="tabpanel" aria-labelledby="insurances-tab">
                    <div class="home_the_search">
                        @include('frontend.partials.the_search',['headerSearchParams'=>$homeParams['insuranceSearch']])
                    </div>
                </div>
                <div class="tab-pane fade medicines hidden" id="medicines" role="tabpanel" aria-labelledby="medicines-tab">
                    <div class="home_the_search hidden">
                        {{-- @include('frontend.partials.the_search',['headerSearchParams'=>$homeParams['medicineSearch']]) --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
