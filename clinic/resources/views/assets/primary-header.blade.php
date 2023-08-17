<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light container">
        <a class="navbar-brand mobile" href="#">Dr.Assistant</a>
        <button class="navbar-toggler" type="button">
            <span class="fa fa-bars"></span>
        </button>
        @if(config('app.has_installed') == 1)
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' :'' }}" href="{{url('/')}}"> <i class="fa fa-home fa-lg"></i> &nbsp; {!! trans('nav.home') !!}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('appointment') ? 'active' : '' }}" href="{{url('/appointment')}}"> <i class="fa fa-calendar"></i> &nbsp; {!! trans('nav.appointment') !!}</a>
                </li>
            </ul>
            @guest
            <ul class="navbar-nav">
                @if(count(\App\User::all()) == 0)
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('register') ? 'active' :'' }}" href="{{route('register')}}"><i class="fa fa-user-plus fa-lg"></i> &nbsp; {!! trans('nav.register') !!}</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('login') ? 'active' :'' }}" href="{{route('login')}}"><i class="fa fa-sign-in fa-lg"> </i> &nbsp; {!! trans('nav.login') !!}</a>
                </li>
            </ul>
            @else
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/home')}}"><i class="fa fa-dashboard"></i> &nbsp; {!! trans('nav.dashboard') !!}</a>
                    </li>
                </ul>
            @endguest
        </div>
        @endif
    </nav>
</div>
