@extends('frontend.master')

@section('title', trans('general.contact_us'))

@section('content')
    <section class="inner_container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="stand_alone_container">
                        <h1>{{ trans('general.contact_us') }}</h1>
                        <div class="stand_alone_inner">
                            <form method="POST" action="{{ route('frontend.staticPages.sendEmail') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">{{ trans('general.name') }}</label>
                                    <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="" placeholder="{{ trans('general.name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="phone">{{ trans('general.phone') }}</label>
                                    <input id="phone" type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="" placeholder="{{ trans('general.phone') }}" required autofocus>
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="clear c15"></div>
                                <div class="form-group">
                                    <label for="email">{{ trans('general.email_address') }}</label>
                                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="" placeholder="{{ trans('general.email_address') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="clear c15"></div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">{{ trans('general.message') }}</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" name="message" required></textarea>
                                </div>

                                {!! app('captcha')->render(); !!}

                                <button type="submit" onclick="myFunction()" class="register_btn">
                                    {{ trans('general.send') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p id="snackbar">تم ارسال الرسالة..</p>
        <style>
            /* The snackbar - position it at the bottom and in the middle of the screen */
        #snackbar {
          visibility: hidden; /* Hidden by default. Visible on click */
          min-width: 250px; /* Set a default minimum width */
          margin-left: -125px; /* Divide value of min-width by 2 */
          background-color: #333; /* Black background color */
          color: #fff; /* White text color */
          text-align: center; /* Centered text */
          border-radius: 2px; /* Rounded borders */
          padding: 16px; /* Padding */
          position: fixed; /* Sit on top of the screen */
          z-index: 1; /* Add a z-index if needed */
          left: 50%; /* Center the snackbar */
          bottom: 38% /* 25% from the bottom */
        }
        
        /* Show the snackbar when clicking on a button (class added with JavaScript) */
        #snackbar.show {
          visibility: visible; /* Show the snackbar */
          /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
          However, delay the fade out process for 2.5 seconds */
          -webkit-animation: fadein 0.5s, fadeout 0.5s 4.5s;
          animation: fadein 0.5s, fadeout 0.5s 4.5s;
        }
        
        /* Animations to fade the snackbar in and out */
        @-webkit-keyframes fadein {
          from {bottom: 0; opacity: 0;}
          to {bottom: 38%; opacity: 1;}
        }
        
        @keyframes fadein {
          from {bottom: 0; opacity: 0;}
          to {bottom: 38%; opacity: 1;}
        }
        
        @-webkit-keyframes fadeout {
          from {bottom: 38%; opacity: 1;}
          to {bottom: 0; opacity: 0;}
        }
        
        @keyframes fadeout {
          from {bottom: 38%; opacity: 1;}
          to {bottom: 0; opacity: 0;}
        }

        </style>
        <script>
            function myFunction() {
            // Get the snackbar DIV
            var x = document.getElementById("snackbar");

            // Add the "show" class to DIV
            x.className = "show";

            // After 3 seconds, remove the show class from DIV
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }
        </script>
    </section>
@endsection