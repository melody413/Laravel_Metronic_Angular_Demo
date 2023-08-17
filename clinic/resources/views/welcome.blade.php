@extends('layouts.auth')

@section('title')
    {{config('app.name')}} Home
@endsection

@section('content')
    <style>
        .text-center > h1,h2,h3,h4,p{
            color: #fff;
        }

    </style>
    <?php $doctor = \App\User::first(); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="text-center">
                    <img height="400px"  src="{{\App\User::first() ? \App\User::first()->image : 'http://cdn.24.co.za/files/Cms/General/d/2809/34cbd0492a23476887812102f40f21d7.jpg'}}"  class="img-fluid" alt="">
                </div>
            </div>
            <div class="col-md-6" style="padding-top: 56px;">
                <div class="text-center">
                    <h2>{{$doctor ? $doctor->name : "Demo"}}</h2>
                    <p>
                        {!! nl2br(e($doctor ? $doctor->info : "Demo")) !!}
                    </p>
                </div>
            </div>
           <div class="col-md-12" style="padding-top: 85px;">
               <div class="card-box">
                   <div class="panel-heading">
                       <h4 class="text-center"><strong>About Me</strong></h4>
                   </div>
                   <div class="card-content" style="padding-top: 25px;">
                       <center>
                           {!! nl2br(e(\App\Model\About::first() ? \App\Model\About::first()->about : "Demo About")) !!}
                       </center>
                   </div>

               </div>
           </div>
        </div>
        <div style="padding: 100px"></div>
    </div>



@endsection