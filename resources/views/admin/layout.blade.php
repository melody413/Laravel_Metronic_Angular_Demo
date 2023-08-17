
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Doctorak</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('/assets/admin/favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- CSS Files -->
    <link href="{{ asset('assets/admin/css/material-dashboard.css?v=2.1.2') }}"  rel="stylesheet" />

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('/assets/admin/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('/assets/admin/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('/assets/admin/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <link href="{{ asset('/assets/admin/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />


    <!-- Main Css -->
    <link href="{{ asset('/assets/admin/css/style.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('/assets/admin/css/themes/all-themes.css') }}" rel="stylesheet" />

    <!-- Dropzone Css -->
    <link href="{{ asset('/assets/admin/plugins/dropzone/dropzone.css') }}" rel="stylesheet">

    <!-- Custom Css -->
    <link href="{{ asset('/assets/admin/css/custom.css') }}" rel="stylesheet">

    <!-- datepicker -->
    <link href="{{ asset('/assets/admin/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    @yield('css')
</head>

<body class="theme-blue">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
<div class="search-bar">
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <input type="text" placeholder="START TYPING...">
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
</div>
<!-- #END# Search Bar -->
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="/admin">Doctorak - V1</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ route('admin.user.logout') }}">
                        <i class="material-icons">logout</i>
                    </a>
                </li>
            </ul>
        </div>
        {{--@include('admin/_header')--}}
    </div>
</nav>
<!-- #Top Bar -->
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        {{--<div class="user-info">
            <div class="image">
                <img src="{{ asset('/assets/admin/images/user.png') }}" width="48" height="48" alt="User" />
            </div>
            --}}{{--<div class="info-container">--}}{{--
                --}}{{--<div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">John Doe</div>--}}{{--
                --}}{{--<div class="email">john.doe@example.com</div>--}}{{--
                --}}{{--<div class="btn-group user-helper-dropdown">--}}{{--
                    --}}{{--<i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>--}}{{--
                    --}}{{--<ul class="dropdown-menu pull-right">--}}{{--
                        --}}{{--<li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>--}}{{--
                        --}}{{--<li role="seperator" class="divider"></li>--}}{{--
                        --}}{{--<li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>--}}{{--
                        --}}{{--<li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>--}}{{--
                        --}}{{--<li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>--}}{{--
                        --}}{{--<li role="seperator" class="divider"></li>--}}{{--
                        --}}{{--<li><a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a></li>--}}{{--
                    --}}{{--</ul>--}}{{--
                --}}{{--</div>--}}{{--
            --}}{{--</div>--}}{{--
        </div>--}}
        <!-- #User Info -->
        <!-- Menu -->
        @include('admin/_sidebar')
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2017 - <?php echo date('Y');?> <a href="javascript:void(0);">Doctorak</a>.
            </div>
            <div class="version">
                <b>Version: </b> 1.0.0
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
            <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                <ul class="demo-choose-skin">
                    <li data-theme="red" class="active">
                        <div class="red"></div>
                        <span>Red</span>
                    </li>
                    <li data-theme="pink">
                        <div class="pink"></div>
                        <span>Pink</span>
                    </li>
                    <li data-theme="purple">
                        <div class="purple"></div>
                        <span>Purple</span>
                    </li>
                    <li data-theme="deep-purple">
                        <div class="deep-purple"></div>
                        <span>Deep Purple</span>
                    </li>
                    <li data-theme="indigo">
                        <div class="indigo"></div>
                        <span>Indigo</span>
                    </li>
                    <li data-theme="blue">
                        <div class="blue"></div>
                        <span>Blue</span>
                    </li>
                    <li data-theme="light-blue">
                        <div class="light-blue"></div>
                        <span>Light Blue</span>
                    </li>
                    <li data-theme="cyan">
                        <div class="cyan"></div>
                        <span>Cyan</span>
                    </li>
                    <li data-theme="teal">
                        <div class="teal"></div>
                        <span>Teal</span>
                    </li>
                    <li data-theme="green">
                        <div class="green"></div>
                        <span>Green</span>
                    </li>
                    <li data-theme="light-green">
                        <div class="light-green"></div>
                        <span>Light Green</span>
                    </li>
                    <li data-theme="lime">
                        <div class="lime"></div>
                        <span>Lime</span>
                    </li>
                    <li data-theme="yellow">
                        <div class="yellow"></div>
                        <span>Yellow</span>
                    </li>
                    <li data-theme="amber">
                        <div class="amber"></div>
                        <span>Amber</span>
                    </li>
                    <li data-theme="orange">
                        <div class="orange"></div>
                        <span>Orange</span>
                    </li>
                    <li data-theme="deep-orange">
                        <div class="deep-orange"></div>
                        <span>Deep Orange</span>
                    </li>
                    <li data-theme="brown">
                        <div class="brown"></div>
                        <span>Brown</span>
                    </li>
                    <li data-theme="grey">
                        <div class="grey"></div>
                        <span>Grey</span>
                    </li>
                    <li data-theme="blue-grey">
                        <div class="blue-grey"></div>
                        <span>Blue Grey</span>
                    </li>
                    <li data-theme="black">
                        <div class="black"></div>
                        <span>Black</span>
                    </li>
                </ul>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="settings">
                <div class="demo-settings">
                    <p>GENERAL SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Report Panel Usage</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Email Redirect</span>
                            <div class="switch">
                                <label><input type="checkbox"><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                    <p>SYSTEM SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Notifications</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Auto Updates</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                    <p>ACCOUNT SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Offline</span>
                            <div class="switch">
                                <label><input type="checkbox"><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Location Permission</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
    <!-- #END# Right Sidebar -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
           {{-- <h2>
                --}}{{--@isset( $module_title )
                    {{ $module_title }}
                @endisset--}}{{--
            </h2>
            <br>--}}
            @include('admin.partial._sys_alert')
            <br>
            @yield('content')
        </div>
    </div>
</section>


<script>
    appVars = {
        'assetsDir': '{{ asset('/assets/admin/') }}',
        'site_url': '{{ env('FULL_DEFAULT_DOMAIN') }}',
        'admin_url': '{{ env('FULL_BACKEND_DOMAIN') }}',
        'admin_prefix': '{{ env('ADMIN_PREFIX') }}',
        'lang': '',
        'route': '{!!   json_encode(dataForm()->getAdminRouteInfo()) !!}'
    }
</script>
<!-- Jquery Core Js -->
<script src="{{ asset('/assets/admin/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('/assets/admin/plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Select Plugin Js -->
<script src="{{ asset('/assets/admin/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/bootstrap-select/js/ajax-bootstrap-select.min.js') }}"></script>

<!-- Slimscroll Plugin Js -->
<script src="{{ asset('/assets/admin/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('/assets/admin/plugins/node-waves/waves.js') }}"></script>

<script src="{{ asset('/assets/admin/plugins/tinymce/tinymce.js') }}"></script>
{{-- <script src="https://cdn.tiny.cloud/1/7f5qtu192hxgbb7e7gkyntmp1827rlfzymjj7xfaiwaeaird/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> --}}


<!-- Custom Js -->
<script src="{{ asset('assets/admin/js/admin.js') }}"></script>

<script src="{{ asset('/assets/admin/js/pages/forms/editors.js') }}"></script>

<script src="{{ asset('/assets/admin/plugins/dropzone/dropzone.js') }}"></script>


<!-- Demo Js -->
<script src="{{ asset('/assets/admin/js/demo.js') }}"></script>

<!-- emmbeded JS -->
<script src="{{ asset('/assets/admin/plugins/underscore-min.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/bootstrap-tagsinput/typeahead.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/bootstrap-tagsinput/bloodhound.min.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/tagmanager.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>


@yield('js')

<script src="{{ asset('/assets/admin/js/back.js?v=1') }}"></script>

</body>

</html>
