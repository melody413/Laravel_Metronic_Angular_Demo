@extends('frontend.master')

@section('content')
    <section class="inner_container doctor_list">
        <div class="container">
            @if( isset($Speciality) && isset($city) && $area && $sub_cat)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.doctors') => route('frontend.doctor.index'),
                        $city->name => route('frontend.doctor.index') . '?speciality=' . $Speciality->id. '&city=' . $city->id,
                        $area->name => route('frontend.doctor.index') . '?speciality=' . $Speciality->id. '&area=' . $area->id. '&city=' . $city->id,
                        $Speciality->name => route('frontend.doctor.index'). '?speciality=' . $Speciality->id. '&city=' . $city->id. '&area=' . $area->id,
                        \App\Models\SubCategory::find($sub_cat)->name => route('frontend.doctor.index'). '?speciality=' . $Speciality->id. '&city=' . $city->id. '&area=' . $area->id. '&sub_cat=' .$sub_cat,
                    ]
                ])
            @elseif( isset($Speciality) && isset($city) && $area)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.doctors') => route('frontend.doctor.index'),
                        $city->name => route('frontend.doctor.index') . '?speciality=' . $Speciality->id. '&city=' . $city->id,
                        $area->name => route('frontend.doctor.index') . '?speciality=' . $Speciality->id. '&area=' . $area->id,
                        $Speciality->name => route('frontend.doctor.index'). '?speciality=' . $Speciality->id. '&city=' . $city->id. '&area=' . $area->id,
                    ]
                ])
            @elseif( isset($Speciality) && isset($city))
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.doctors') => route('frontend.doctor.index'),
                        $city->name => route('frontend.doctor.index') . '?city=' . $city->id,
                        $Speciality->name => route('frontend.doctor.index'). '?speciality=' . $Speciality->id. '&city=' . $city->id,
                    ]
                ])
            @elseif( isset($Speciality) )
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.doctors') => route('frontend.doctor.index'),
                        $Speciality->name => route('frontend.doctor.index'). '?speciality=' . $Speciality->id,
                    ]
                ])
            @elseif($city && $area)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.doctors') => route('frontend.doctor.index'),
                        $city->name => route('frontend.doctor.index') . '?city=' . $city->id,
                        $area->name => route('frontend.doctor.index') . '?area=' . $area->id. '&city=' . $city->id,
                    ]
                ])
            @elseif($city)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.doctors') => route('frontend.doctor.index'),
                        $city->name => route('frontend.doctor.index') . '?city=' . $city->id,
                        //$area->name => route('frontend.doctor.index') . '?area=' . $area->id,
                    ]
                ])
            @elseif($area)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.doctors') => route('frontend.doctor.index'),
                        $area->name => route('frontend.doctor.index') . '?area=' . $area->id,
                    ]
                ])
            @else
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.doctors') => route('frontend.doctor.index'),
                    ]
                ])
            @endif
            <div class="row">
                <div class="col-md">
                    <h1 class="list_title">
                        @if (request()->input('gender', null) == "female")
                            {{ getMainModuleTitle('doctors_female_best',$city, $area, \App\Models\SubCategory::find($sub_cat) ?: $Speciality) }} @if(isset($tag)) - {{ $tag->name }} @endif
                        @else
                            {{ getMainModuleTitle('doctors_best',$city, $area, \App\Models\SubCategory::find($sub_cat) ?: $Speciality) }} @if(isset($tag)) - {{ $tag->name }} @endif
                        @endif
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="list_holder">
                        @forelse( $rows as $row)
                            @list_block(['row' => $row, 'imagePath' => 'doctors/' , 'routeKey' => 'doctor', 'view' => 'DOCTOR', 'speciality' => $Speciality ])
                                @slot('reserve')
                                    @if($row->is_reserve)
                                        <div class="booking_holder booking_on_list flexer flex-column flexer_jc_center flexer_ai_end">
                                            <div class="is_booking">
                                                <a href="{{ "doctor/" . $row->id . "#to_booking" }}" class="flexer flexer_ai_center flexer_jc_center">
                                                    <i class="fas fa-calendar-check"></i>
                                                    <span>{{ trans('general.booking_an_appointment') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="booking_holder booking_on_list flexer flex-column flexer_jc_center flexer_ai_end">
                                            <div class="no_booking flexer flexer_ai_center flexer_jc_center">
                                                <i class="fas fa-exclamation-circle"></i>
                                                <span>{{ trans('general.reservation_not_available') }}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endslot
                            @endlist_block
                        @empty
                            @include('frontend.partials._no_data')
                        @endforelse
                    </div>
                    
                </div>
            </div>
            <div class="pagination_holder">
                {{ $rows->appends(Request::query())->links() }}
            </div>
            <hr>
            <h5 class="btn btn-primary">{{ trans('general.repeated_question') }}</h5>

            <div id="accordion">
                @foreach ($qanswers_ar as $key=>$qa)
                    <div class="card">
                        <div class="card-header" id="heading{{$qa->id}}">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse"  data-target="#collapse{{$qa->id}}" aria-expanded="true" aria-controls="collapse{{$qa->id}}">
                                    {{$qa->name}}
                                </button>
                            </h5>
                        </div>

                        <div id="collapse{{$qa->id}}"  class="collapse @if($key == 0) show @endif" aria-labelledby="heading{{$qa->id}}" data-parent="#accordion">
                            <div class="card-body" >
                                {!! $qa->description !!}
                            </div>
                        </div>

                    </div>    
                    @if($key == 9) @break @endif
                @endforeach
            </div>

            @if(isset($Speciality))
                <hr>
                <h5>{{ trans('general.most_choices_specialities') }}</h5>
                @foreach ( $sub_cats_arr as $scs)
                    <a class="badge badge-primary" href="{{ route('frontend.doctor.index') . '?speciality=' . $Speciality->id. '&sub_cat=' . $scs->sub_category_id }}@if(isset($city))&city={{$city->id}}@endif
@if(isset($area))&area={{$area->id}}@endif">
                        {{\DB::table('sub_category_trans')->where("sub_category_id",$scs->sub_category_id)->first()->name}}
                    </a>
                    {{-- @if(next($sub_cats_arr)) 
                        <span class="comma">،</span>
                    @endif --}}
                @endforeach

                <br>
                <br>
                <h5>{{$Speciality->name}}</h5>

                من على دكتورك تقدر تدخل وتبحث عن أقرب دكتور {{$Speciality->name}} حيث يوفر موقع دكتورك بيانات التواصل مع أفضل دكاترة {{$Speciality->name}} متخصصين في @foreach ( $sub_cats_arr2 as $scs)
                <a class="" href="{{ route('frontend.doctor.index') . '?speciality=' . $Speciality->id. '&sub_cat=' . $scs->sub_category_id }}@if(isset($city))&city={{$city->id}}@endif
@if(isset($area))&area={{$area->id}}@endif">
                    {{\DB::table('sub_category_trans')->where("sub_category_id",$scs->sub_category_id)->first()->name}}
                </a>
                <span class="comma">،</span>
                @if(next($sub_cats_arr)) 
                    <span class="">،</span>
                @endif
            @endforeach ومن البيانات التي يمكنك الحصول عليها من موقع دكتورك انك تستطيع أن تعرف رقم التليفون الخاص ب أفضل دكتور {{$Speciality->name}} ، كما يمكنك التعرف على عنوان أشهر دكتور {{$Speciality->name}} وتفاصيل الوصول اليه.
                الوصول الى دكتور {{$Speciality->name}} شاطر قد يبدو صعبًا ولكن مع بيانات اطباء {{$Speciality->name}} المتوافرة على دكتورك يمكن الوصول بسهولة إلى أحسن دكتور {{$Speciality->name}} كما يمكنك معرفة انسب دكتور {{$Speciality->name}} لك من خلال المستشفيات والمراكز التي يعمل بها وشركات التأمين المتعاقد معها، يمكنك ايضًا الوصول الي دكتور {{$Speciality->name}} ممتاز من خلال تقييمات المترددين على العيادات وتجاربهم مع اطباء {{$Speciality->name}}.

            @endif
        </div>
    </section>
    <script type="application/ld+json">
        {
          "@context": "https://schema.org/",
          "@type": "Physician",
          "name": "doctors",
          "url": "https://doctorak.com/eg/doctor/",
          "image": "",
          "sameAs": [
            "https://www.facebook.com/",
            "http://twitter.com/"
          ],
          "jobTitle": "{{$Speciality}}"  
        }
        </script>
        <style>
            span.comma:last-child {
                display: none;
            }
        </style>
@endsection
