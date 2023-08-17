<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <?php header('Access-Control-Allow-Origin: *'); ?>

    @include('assets.css')

    @yield('extra-css')
</head>
<body class="fixed-left">
<div id="wrapper">
    @guest

    @else
        @include('assets.secondary-header')
        @doctor
            @include('assets.sidebar.admin')
        @enddoctor
        @assistant
            @include('assets.sidebar.assistant')
        @endassistant

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @endguest

</div>
@include('assets.js')

@yield('extra-js')
</body>
</html>