
<header class="header inner_header responsive_container">
    <div class="main">
        <div class="yello_shape"></div>
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md">
                    <a href="{{ getCountryLangUrl() }}" class="logo">
                        <img src="https://doctorak.fra1.cdn.digitaloceanspaces.com/logo_header.png" alt="doctorak logo">
                    </a>
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
                            {{--<li class="country has_children">--}}
                                {{--<a href="">--}}
                                    {{--<img src="{{ f_assets('images/general/' . \App\Mangers\SettingsManger::Instance()->getCountry()->code . '.png') }}" alt="">--}}
                                {{--</a>--}}
                                {{--<ul class="nav_children">--}}
                                    {{--@add_businessforeach(App\Mangers\SettingsManger::Instance()->getCountries() as $country)--}}
                                        {{--@if(\App\Mangers\SettingsManger::Instance()->getCountry()->code != $country->code)--}}
                                            {{--<li>--}}
                                                {{--<a href="{{ getCountryLangUrl($country->code) }}">--}}
                                                    {{--<img src="{{ f_assets('images/general/' . $country->code . '.png') }}" alt="">--}}
                                                    {{--<span>{{ $country->name }}</span>--}}
                                                {{--</a>--}}
                                            {{--</li>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</li>--}}
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
                                <li class="signin_signup">
                                    <a href="#" onclick="return false" data-toggle="modal" data-target="#signin_signup_modal">{{ trans('general.signin_join') }}</a>
                                </li>
                            @endguest
                            {{--<li class="full_nav_toggler"><a href="#" onclick="return false" ><i class="fas fa-bars"></i></a></li>--}}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="the_search_holder">
        <div class="container">
            @include('frontend.partials.the_search')
        </div>
    </div>
</header>
