<div id="responsive_nav_block" class="responsive_nav_block">
    <button id="responsive_nav_block_close" class="responsive_nav_block_close"><i class="fas fa-times"></i></button>
    <div class="responsive_nav_block_inner">
        <div class="responsive_nav_block_head flexer flex-column flexer_ai_center flexer_jc_center">
            <div class="responsive_nav_block_head_user_img">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="responsive_nav_block_head_user_action">
                @auth
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ route('frontend.user.profile') }}" class="btn btn-secondary">{{auth()->user()->name}} <i class="fas fa-cog"></i></a>
                        <a href="{{ route('frontend.user.logout') }}" class="btn btn-secondary logout"><i class="fas fa-sign-out-alt"></i></a>
                    </div>
                    <div class="reserviations_link">
                        @if(Auth::user()->type == \App\Models\User::USER_TYPE['user'])
                            <a href="{{ route('frontend.my.reservation') }}" class="btn btn-dark">{{ trans('general.my_reservations') }}</a>
                        @elseif(Auth::user()->type == \App\Models\User::USER_TYPE['doctor'])
                            <a href="{{ route('frontend.doctor.reservation') }}" class="btn btn-dark">{{ trans('general.patients_reservations') }}</a>
                        @endif
                    </div>
                @endauth
                @guest
                    <a href="#" class="responsive_nav_login_join" onclick="return false" data-toggle="modal" data-target="#signin_signup_modal">{{ trans('general.signin_join') }}</a>
                @endguest
            </div>
        </div>
        <div class="responsive_nav_block_nav">
            <ul>
                <li><a href="{{ getCountryLangUrl() }}"><i class="fas fa-circle"></i> <span>{{ trans('general.home') }}</span></a></li>
                <li><a href="{{ url('/blog') }}"><i class="fas fa-circle"></i> <span>{{ trans('general.articles') }}</span></a></li>
                <li><a href="{{route('frontend.user.register',['doctor'=>\App\Models\User::USER_TYPE['doctor']])}}"><i class="fas fa-circle"></i> <span>{{ trans('general.list_your_business') }}</span></a></li>
                <li><a href="{{route('frontend.doctor.index')}}"><i class="fas fa-circle"></i> <span>{{ trans('general.doctors') }}</span></a></li>
                <li><a href="{{route('frontend.hospital.index')}}"><i class="fas fa-circle"></i> <span>{{ trans('general.hospitals') }}</span></a></li>
                <li><a href="{{route('frontend.lab.index')}}"><i class="fas fa-circle"></i> <span>{{ trans('general.labs') }}</span></a></li>
                <li><a href="{{route('frontend.insurance_company.index')}}"><i class="fas fa-circle"></i> <span>{{ trans('general.insurances_companies') }}</span></a></li>
                @if(\App::getLocale()=='ar')
                    <li>
                        <a rel="alternate" hreflang="en" href="/{!! getCountry()->code !!}_en"><i class="fas fa-circle"></i> <span>English</span></a>
                    </li>
                @else
                    <li>
                        <a rel="alternate" hreflang="ar" href="/{!! getCountry()->code !!}"><i class="fas fa-circle"></i> <span>العربية</span></a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<div id="overlay" class="overlay"></div>