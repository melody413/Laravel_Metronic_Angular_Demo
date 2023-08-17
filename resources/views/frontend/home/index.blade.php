@extends('frontend.master')
@section('title', 'Home')

@section('header')
    @include('frontend.partials.home_header')
@endsection

@section('content')
    {{--<section class="section home_why_section">
        <div class="container">
            <h2>{{trans('general.why_doctorak_will_be_your_1_treats_supportive')}}</h2>
            <div class="row why_content">
                <div class="col-md item">
                    <i class="icon-free"></i>
                    <h3>{{trans('general.free_services')}}</h3>
                    <p>{{trans('general.free_services_p')}}</p>
                </div>
                <div class="col-md item">
                    <i class="icon-directories"></i>
                    <h3>{{trans('general.mighty_directories')}}</h3>
                    <p>{{trans('general.mighty_directories_p')}}</p>
                </div>--}}
                {{--<div class="col-md item">--}}
                    {{--<i class="icon-booking"></i>--}}
                    {{--<h3>{{trans('general.booking_appointments')}}</h3>--}}
                    {{--<p>{{trans('general.booking_appointments_p')}}</p>--}}
                    {{--<a href="" class="btn btn-link">Know More</a>--}}
                {{--</div>--}}
            {{--</div>
        </div>
    </section>--}}
    <section class="section pb0 grey">
        <div class="container">
            <h2 class="text-left">{{ trans('general.popular_specialty') }}</h2>
            <div class="row">
                <div class="col-md">
                    <div class="item text-center">
                        <a href="{{ route('frontend.doctor.index') . '?speciality=' . \App\Models\Specialty::find(28)->id }}" class="news_data">
                            <div class="image">
                                <span class="icon-ophthalmology"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span><span class="path18"></span><span class="path19"></span><span class="path20"></span><span class="path21"></span><span class="path22"></span><span class="path23"></span><span class="path24"></span><span class="path25"></span><span class="path26"></span><span class="path27"></span><span class="path28"></span><span class="path29"></span><span class="path30"></span></span>
                            </div>
                            <div class="content">
                                <h5>{{\App\Models\Specialty::find(28)->name}}</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md">
                    <div class="item text-center">
                        <a href="{{ route('frontend.doctor.index') . '?speciality=' . \App\Models\Specialty::find(31)->id }}" class="news_data">
                            <div class="image">
                                <span class="icon-dentistry"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
                            </div>
                            <div class="content">
                                <h5>{{\App\Models\Specialty::find(31)->name}}</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md">
                    <div class="item text-center">
                        <a href="{{ route('frontend.doctor.index') . '?speciality=' . \App\Models\Specialty::find(41)->id }}" class="news_data">
                            <div class="image">
                                <span class="icon-dermatologist"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span><span class="path18"></span><span class="path19"></span><span class="path20"></span><span class="path21"></span><span class="path22"></span><span class="path23"></span><span class="path24"></span><span class="path25"></span><span class="path26"></span><span class="path27"></span><span class="path28"></span><span class="path29"></span><span class="path30"></span><span class="path31"></span><span class="path32"></span><span class="path33"></span><span class="path34"></span><span class="path35"></span><span class="path36"></span><span class="path37"></span><span class="path38"></span><span class="path39"></span><span class="path40"></span><span class="path41"></span><span class="path42"></span></span>
                            </div>
                            <div class="content">
                                <h5>{{\App\Models\Specialty::find(41)->name}}</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md">
                    <div class="item text-center">
                        <a href="{{ route('frontend.doctor.index') . '?speciality=' . \App\Models\Specialty::find(25)->id }}" class="news_data">
                            <div class="image">
                                <span class="icon-gynecology"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span><span class="path18"></span><span class="path19"></span><span class="path20"></span><span class="path21"></span><span class="path22"></span><span class="path23"></span><span class="path24"></span><span class="path25"></span><span class="path26"></span><span class="path27"></span></span>
                            </div>
                            <div class="content">
                                <h5>{{\App\Models\Specialty::find(25)->name}}</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md">
                    <div class="item text-center">
                        <a href="{{ route('frontend.doctor.index') . '?speciality=' . \App\Models\Specialty::find(17)->id }}" class="news_data">
                            <div class="image">
                                <span class="icon-cardiology"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span></span>
                            </div>
                            <div class="content">
                                <h5>{{\App\Models\Specialty::find(17)->name}}</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md">
                    <div class="item text-center">
                        <a href="{{ route('frontend.doctor.index') . '?speciality=' . \App\Models\Specialty::find(43)->id }}" class="news_data">
                            <div class="image">
                                <span class="icon-pediatrician"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span><span class="path18"></span><span class="path19"></span><span class="path20"></span><span class="path21"></span><span class="path22"></span><span class="path23"></span><span class="path24"></span><span class="path25"></span><span class="path26"></span><span class="path27"></span><span class="path28"></span><span class="path29"></span><span class="path30"></span><span class="path31"></span><span class="path32"></span><span class="path33"></span><span class="path34"></span><span class="path35"></span><span class="path36"></span><span class="path37"></span><span class="path38"></span><span class="path39"></span><span class="path40"></span></span>
                            </div>
                            <div class="content">
                                <h5>{{\App\Models\Specialty::find(43)->name}}</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($blog_posts && app()->getLocale() == "ar")
    <section class="section pb0 grey home_news">
        <div class="container">
            <h2 class="text-left">{{ trans('general.latest_articles') }}</h2>
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="row home_news_holder_ carousel-inner">
                    <div class="carousel-item row active">
                        @foreach ($blog_posts as $index =>  $blog_post)
                            @if($index < 4)
                                @if($blog_post->post_title != 'Custom Styles')
                                    <div class="item col-md-3">
                                        <a href="https://doctorak.com/blog/{{$blog_post->post_name}}/" target="_blank" class="news_data">
                                            <div class="height-blog">
                                                <img class="d-block w-100" src="{{ $blog_post->image}}" alt="{{$blog_post->post_title}}">
                                            </div>                                    <div class="carousel-caption-new">
                                                <h5>{{$blog_post->post_title}}</h5>
                                                <div class="">
                                                    {{ mb_strimwidth(strip_tags($blog_post->post_content), 0, 100, "..."). trans('general.read_more')}}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @else @break
                            @endif
                        @endforeach
                    </div>
                    <div class="carousel-item row">
                    @foreach ($blog_posts as $index=> $blog_post)
                        @if($index > 4)
                        <div class="item col-md-3">
                            <a href="https://doctorak.com/blog/{{$blog_post->post_name}}" target="_blank" class="news_data">
                                <div class="height-blog">
                                    <img class="d-block w-100 lazy" src="{{ $blog_post->image}}" 
                                    alt="{{$blog_post->post_title}}">
                                </div>
                                <div class="carousel-caption-new">
                                    <h5>{{$blog_post->post_title}}</h5>
                                    <div class="">
                                        {{ mb_strimwidth(strip_tags($blog_post->post_content), 0, 100, "..."). trans('general.read_more')}}
                                    </div>
                                </div>
                            </a>
                        </div>
                        @elseif($index > 8) @break
                        @endif
                        @endforeach
                    </div>
                </div>
                <a class="carousel-control-prev carousel-navigation" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next carousel-navigation" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <a href="/blog/" target="_blank" class="btn btn-link home_news_view_all_btn">{{ trans('general.view_all_articles') }}</a>
        </div>
    </section>
    @endif
    @guest
    <section class="section convince_doctor lazy" data-bg="https://doctorak.fra1.cdn.digitaloceanspaces.com/doc_background.jpg">
        <div class="container">
            <div class="row align-items-center holder">
                <div class="col-md-8 content">
                    <strong>{{ trans('general.are_you_a_doctor') }}</strong>
                    <p>{{ trans('general.are_you_a_doctor_p') }}</p>
                    <ul>
                        <li>{{ trans('general.are_you_a_doctor_p_one') }}</li>
                        <li>{{ trans('general.are_you_a_doctor_p_two') }}</li>
                        <li>{{ trans('general.are_you_a_doctor_p_three') }}</li>
                    </ul>
                    <a href="{{route('frontend.user.register',['doctor'=>\App\Models\User::USER_TYPE['doctor']])}}" class="default_btn">{{ trans('general.list_your_practice_on_doctorak') }}</a>
                </div>
                <div class="doc_img">
                    <img class="lazy" data-src="https://doctorak.fra1.cdn.digitaloceanspaces.com/convince_doctor_img.png" width="340" height="464" alt="convince-doctor">
                </div>
            </div>
        </div>
    </section>
    @endguest
    <section class="section pb0 grey">
        <div class="container">
            <h2 class="text-left">{{ trans('general.calculator') }}</h2>
            <div class="row">
                <div class="col-md">
                    <div class="item text-center">
                        <a href="/eg/calc/pregnancy-calculator" class="news_data">
                            <div class="image">
                                <span class="icon-gynecology"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span><span class="path18"></span><span class="path19"></span><span class="path20"></span><span class="path21"></span><span class="path22"></span><span class="path23"></span><span class="path24"></span><span class="path25"></span><span class="path26"></span><span class="path27"></span></span>
                            </div>
                            <div class="content">
                                @if (app()->getLocale() == "ar")
                                    <h5>حاسبة الحمل والولادة</h5>
                                @else
                                    <h5>Pregnancy Calculator</h5>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md">
                    <div class="item text-center">
                        <a href="/eg/calc/bmr-calculator" class="news_data">
                            <div class="image">
                                <span class="icon-bmr-calculator"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span></span>
                            </div>
                            <div class="content">
                                @if (app()->getLocale() == "ar")
                                    <h5>حاسبة السعرات الحرارية</h5>
                                @else
                                    <h5>Calorie Calculator</h5>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md">
                    <div class="item text-center">
                        <a href="/eg/calc/ovulation-calculator" class="news_data">
                            <div class="image">
                                <span class="icon-ovulation"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span><span class="path18"></span><span class="path19"></span><span class="path20"></span><span class="path21"></span><span class="path22"></span><span class="path23"></span><span class="path24"></span><span class="path25"></span><span class="path26"></span><span class="path27"></span><span class="path28"></span><span class="path29"></span><span class="path30"></span><span class="path31"></span><span class="path32"></span><span class="path33"></span><span class="path34"></span><span class="path35"></span><span class="path36"></span><span class="path37"></span><span class="path38"></span><span class="path39"></span><span class="path40"></span><span class="path41"></span><span class="path42"></span></span>
                            </div>
                            <div class="content">
                                @if (app()->getLocale() == "ar")
                                    <h5>التبويض</h5>
                                @else
                                    <h5>Ovulation Calculator</h5>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md">
                    <div class="item text-center">
                        <a href="/eg/calc/bmi-calculator" class="news_data">
                            <div class="image">
                                <span class="icon-bmi-calculator"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span></span>
                            </div>
                            <div class="content">
                                @if (app()->getLocale() == "ar")
                                    <h5>مؤشر كتلة الجسم</h5>
                                @else
                                    <h5>Body Mass Index Calculator  (BMI)</h5>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md">
                    <div class="item text-center">
                        <a href="/eg/calc/period-calculator" class="news_data">
                            <div class="image">
                                <span class="icon-period-calculator"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                            </div>
                            <div class="content">
                                @if (app()->getLocale() == "ar")
                                    <h5>الدورة الشهرية</h5>
                                @else
                                    <h5>Period Calculator</h5>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
                <!--<div class="col-md">
                    <div class="item text-center">
                        <a href="/eg/calc/" class="news_data">
                            <div class="image">
                                <img src="/assets/frontend/images/home/السكري.png" width="100" alt="الاصابة بالسكري">
                            </div>
                            <div class="content">
                                <h5>الاصابة بالسكري</h5>
                            </div>
                        </a>
                    </div>
                </div>-->
            </div>
        </div>
    </section>
    <section class="section grey home_cats">
        <div class="container">
            <h2 class="text-left">{{ trans('general.find_whaever_you_seek') }}</h2>
            <div class="row cats_content">
                <div class="col-md item">
                    <div class="header">
                        <h3>
                            <i class="icon-doctor"></i>
                            <span>{{ trans('general.doctors') }}</span>
                        </h3>
                    </div>
                    <div class="content">
                        <ul>
                            @foreach($doctors_specialites as $specialite)
                                <li><a href="{{route('frontend.doctor.index',['speciality'=>$specialite->id])}}" target="_blank">{{$specialite->name}}</a></li>
                            @endforeach
                        </ul>
                        <a href="{{route('frontend.doctor.index')}}" class="btn btn-link" target="_blank">{{ trans('general.view_all') }}</a>
                    </div>
                </div>
                <div class="col-md item">
                    <div class="header">
                        <h3>
                            <i class="icon-hospital"></i>
                            <span>{{ trans('general.hospitals') }}</span>
                        </h3>
                    </div>
                    <div class="content">
                        <ul>
                            @foreach($hospitals as $hospital)
                            {{-- {{dd($hospital->id)}} --}}
                                <li><a href="{{route('frontend.hospital.unit',['id'=>$hospital->id])}}">{{ trans('general.hospital') }} {{$hospital->name}}</a></li>
                            @endforeach
                        </ul>
                        <a href="{{route('frontend.hospital.index')}}" class="btn btn-link">{{ trans('general.view_all') }}</a>
                    </div>
                </div>
                <div class="col-md item">
                    <div class="header">
                        <h3>
                            <i class="icon-center"></i>
                            <span>{{ trans('general.centers') }}</span>
                        </h3>
                    </div>
                    <div class="content">
                        <ul>
                            @foreach($centers as $center)
                                <li><a href="{{route('frontend.center.unit',['id'=>$center->id])}}">{{ trans('general.center') }} {{$center->name}}</a></li>
                            @endforeach
                        </ul>
                        <a href="{{route('frontend.center.index')}}" class="btn btn-link">{{ trans('general.view_all') }}</a>
                    </div>
                </div>
                <div class="col-md item">
                    <div class="header">
                        <h3>
                            <i class="icon-pharmacey"></i>
                            <span>{{ trans('general.pharmacies') }}</span>
                        </h3>
                    </div>
                    <div class="content">
                        <ul>
                            @foreach($pharmacies as $pharmacy)
                                <li><a href="{{route('frontend.pharmacy.unit',['id'=>$pharmacy->id])}}">{{ trans('general.pharmacy') }} {{$pharmacy->name}}</a></li>
                            @endforeach
                        </ul>
                        <a href="{{route('frontend.pharmacy.index')}}" class="btn btn-link">{{ trans('general.view_all') }}</a>
                    </div>
                </div>
                <!--<div class="col-md item">
                    <div class="header">
                        <h3>
                            <i class="icon-lab"></i>
                            <span>{{ trans('general.labs') }}</span>
                        </h3>
                    </div>
                    <div class="content">
                        <ul>
                            @foreach($labs as $lab)
                                <li><a href="{{route('frontend.lab.unit',['id'=>$lab->id])}}">{{$lab->name}}</a></li>
                            @endforeach
                        </ul>
                        <a href="{{route('frontend.lab.index')}}" class="btn btn-link">{{ trans('general.view_all') }}</a>
                    </div>
                </div>-->
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.4.0/dist/lazyload.min.js"></script>
    <style>
        img:not([src]):not([srcset]) {
            visibility: hidden;
        }
        div#carouselExampleControls .carousel-navigation {
            display: none;
        }
    </style>
        <script>
        (function () {
            function logElementEvent(eventName, element) {
            console.log(Date.now(), eventName, element.getAttribute("data-src"));
            }

            var callback_enter = function (element) {
            logElementEvent("🔑 ENTERED", element);
            };
            var callback_exit = function (element) {
            logElementEvent("🚪 EXITED", element);
            };
            var callback_loading = function (element) {
            logElementEvent("⌚ LOADING", element);
            };
            var callback_loaded = function (element) {
            logElementEvent("👍 LOADED", element);
            };
            var callback_error = function (element) {
            logElementEvent("💀 ERROR", element);
            element.src =
                "https://via.placeholder.com/440x560/?text=Error+Placeholder";
            };
            var callback_finish = function () {
            logElementEvent("✔️ FINISHED", document.documentElement);
            };
            var callback_cancel = function (element) {
            logElementEvent("🔥 CANCEL", element);
            };

            var ll = new LazyLoad({
            // Assign the callbacks defined above
            callback_enter: callback_enter,
            callback_exit: callback_exit,
            callback_cancel: callback_cancel,
            callback_loading: callback_loading,
            callback_loaded: callback_loaded,
            callback_error: callback_error,
            callback_finish: callback_finish
            });
        })();
        </script>
@endsection
