@if(Session::has('flash_type'))
    <div class="alert alert-{{ session('flash_type') }}">
        <strong>Well done!</strong> {{ session('flash_message') }} .
    </div>
@endif


@if (count($errors) > 0)
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
           <li> {{ $error }}</li>
        @endforeach
    </div>
@endif