<html>
<head>
    <meta charset="utf-8">

    <title>Permission Denied</title>

    <link href="{{url('/dashboard/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('/dashboard/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('/dashboard/css/style.css')}}" rel="stylesheet" type="text/css" />

    <script src="{{url('/dashboard/js/modernizr.min.js')}}"></script>

</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>

<div class="wrapper-page">
    <div class="ex-page-content text-center">
        <div class="text-error"><span class="text-primary">4</span><i class="ti-face-sad text-pink"></i><span class="text-info">3</span></div>
        <h2 class="text-white">Forbidden</h2><br>
        <p class="text-muted">You don't have permission to access on this server.</p>
        <br>
        <a class="btn btn-success waves-effect waves-light" href="{{url('/home')}}"> Back to Home</a>
    </div>
</div>
</body>
</html>