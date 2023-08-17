@extends('frontend.master')

@section('content')
    <section class="inner_container unit doctor_unit">
        <div class="container">
            @if( isset($specialty) && isset($row->city->name) && isset($row->area_id) )
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.doctors') => route('frontend.doctor.index'),
                       // $specialty->name => route('frontend.doctor.index'). '?speciality=' . $specialty->id. '&city=' . $row->city_id,
                        $row->city->name => route('frontend.doctor.index') . '?city=' . $row->city_id,
                        $row->area->name => route('frontend.doctor.index') . '?area=' . $row->area_id. '&city=' . $row->city_id,
                    ]
                ])
            @elseif(isset($row->city->name) && isset($row->area_id))
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.doctors') => route('frontend.doctor.index'),
                        $row->city->name => route('frontend.doctor.index') . '?city=' . $row->city_id,
                        $row->area->name => route('frontend.doctor.index') . '?area=' . $row->area_id. '&city=' . $row->city_id,
                    ]
                ])
            @endif

            <br>
        @unit_block(['row' => $row ,'imagePath' => 'doctors/', 'withAddress' => false , 'view' => 'DOCTOR', 'specialty' => $specialty])
            @if(is_numeric(basename($_SERVER['REQUEST_URI'])))

                @slot('titlePlus')
            {{-- {{ $row->title }} --}}
                    <span>
                        @if( isset($specialty) && ! isset($specialty))
                            {{ trans('general.dr') }}
                            @foreach ($specialty as $specialty_row)
                                <a href="{{ route('frontend.doctor.index') . '?speciality='. $specialty_row }}">
                                    {{ \App\Models\Specialty::find($specialty_row)->name }}
                                </a> <span class="specialty-doctor">,</span>
                            @endforeach
                        @endif
                    </span>
                    {{-- {{ str_replace("-", " ", urldecode(basename($_SERVER['REQUEST_URI'])) ) }} --}}
                @endslot
            @endif

            @slot('content')
                <div class="additions flexer flexer_jc_space_evenly flexer_ai_center">
                    @if(!empty($row->price))
                    <div class="item flexer flexer_jc_center flexer_ai_center">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>{{ trans('general.diagnosis_cost') }} <strong>{{ $row->price }} {{ trans('general.egp') }}</strong></span>
                    </div>
                    @endif
                    @if(!empty($row->wait_time))
                    <div class="item flexer flexer_jc_center flexer_ai_center">
                        <i class="far fa-clock"></i>
                        <span>{{ trans('general.waiting_time') }} <strong>{{ $row->wait_time }} {{ trans('general.minute') }}</strong></span>
                    </div>
                    @endif
                </div>
            @endslot

            @slot('topping')
                <div class="content" id="topping_content">
                    <div class="topping_tabs">
                        <ul class="nav nav-tabs" id="topping_tabs_ul" role="tablist">
                            @if(is_numeric(basename($_SERVER['REQUEST_URI'])))
                            <li class="nav-item">
                                <a class="nav-link active" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="home" aria-selected="true">{{ trans('general.reviews') }}</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link @if(!is_numeric(basename($_SERVER['REQUEST_URI']))) active @endif" id="hospitals-tab" data-toggle="tab" href="#hospitals" role="tab" aria-controls="profile" aria-selected="false">{{ trans('general.hospitals') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="centers-tab" data-toggle="tab" href="#centers" role="tab" aria-controls="profile" aria-selected="false">{{ trans('general.centers') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="insurance-tab" data-toggle="tab" href="#insurance" role="tab" aria-controls="contact" aria-selected="false">{{ trans('general.insurance') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane reviews_tab fade show @if(is_numeric(basename($_SERVER['REQUEST_URI']))) active @endif" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="row reviews_tab_head justify-content-between tab_panel_head">
                                    <div class="col-md-8 flexer flex-column flexer_ai_start flexer_jc_center">
                                        <h3>{{$row->rate}}</h3>
                                        <span>{{ trans('general.from') }} {{$row->rate_cnt}} {{ trans('general.visitors') }}</span>
                                        <div class="stars">
                                            <ul>
                                                @for($i= 0; $i<$row->rate; $i++)
                                                    <li><i class="fas fa-star"></i></li>
                                                @endfor
                                                @for($i=$row->rate; $i<5; $i++)
                                                    <li><i class="far fa-star"></i></li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4 flexer flexer_ai_center flexer_jc_end">
                                        <div class="rating_action">
                                            <strong>{{ trans('general.rate_this_doctor') }}</strong>
                                            <fieldset class="rating">
                                                <input type="radio" id="star5" name="rating" value="5" /><label onclick="@if(!isset(Auth::user()->id)) window.location.href = '{{ route('login') }}'; return false; @endif" class = "full rating-star" for="star5" title="Awesome - 5 stars" data-toggle="modal" data-target="#raiting_modal"></label>
                                                <input type="radio" id="star4" name="rating" value="4" /><label onclick="@if(!isset(Auth::user()->id)) window.location.href = '{{ route('login') }}'; return false; @endif" class = "full rating-star" for="star4" title="Pretty good - 4 stars" data-toggle="modal" data-target="#raiting_modal"></label>
                                                <input type="radio" id="star3" name="rating" value="3" /><label onclick="@if(!isset(Auth::user()->id)) window.location.href = '{{ route('login') }}'; return false; @endif" class = "full rating-star" for="star3" title="Meh - 3 stars" data-toggle="modal" data-target="#raiting_modal"></label>
                                                <input type="radio" id="star2" name="rating" value="2" /><label onclick="@if(!isset(Auth::user()->id)) window.location.href = '{{ route('login') }}'; return false; @endif" class = "full rating-star" for="star2" title="Kinda bad - 2 stars" data-toggle="modal" data-target="#raiting_modal"></label>
                                                <input type="radio" id="star1" name="rating" value="1" /><label onclick="@if(!isset(Auth::user()->id)) window.location.href = '{{ route('login') }}'; return false; @endif" class = "full rating-star" for="star1" title="Sucks big time - 1 star" data-toggle="modal" data-target="#raiting_modal"></label>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="row flex-column tab_panel_content reviews_tab_content">
                                    @foreach ($row->ratings as $rate)
                                        <div class="item">
                                            <div class="item_head row justify-content-between align-items-start">
                                                <div class="col-xs">
                                                    <strong>{{$rate->user->name}}</strong>
                                                    <span>{{$rate->created_at}}</span>
                                                </div>
                                                <div class="col-xs-4">
                                                    <div class="stars">
                                                        <ul>
                                                            @for($i= 0; $i<$rate->rate; $i++)
                                                                <li><i class="fas fa-star"></i></li>
                                                            @endfor
                                                            @for($i=$rate->rate; $i<5; $i++)
                                                                <li><i class="far fa-star"></i></li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row item_content">
                                                <div class="col-xs">
                                                    <p>
                                                        {{$rate->comment}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!is_numeric(basename($_SERVER['REQUEST_URI']))) active show @endif" id="hospitals" role="tabpanel" aria-labelledby="hospitals-tab">
                                <div class="row justify-content-between tab_panel_head">
                                    <div class="col-md-8 flexer flexer_ai_center flexer_jc_center">
                                        <h3>{{ trans('general.list_of_hospitals_that') }} {{$row->name}} {{ trans('general.working_with') }}</h3>
                                    </div>
                                    <div class="col-md-4 flexer flexer_ai_center flexer_jc_end">
                                        <i class="icon-hospital"></i>
                                    </div>
                                </div>
                                <div class="row tab_panel_content doctors">
                                    @foreach($row->hospitals as $hospital)
                                        <div class="col-md-12 item doctor">
                                            <a href="{{route('frontend.hospital.unit', ['id'=>$hospital->id])}}">
                                                <div class="flexer flexer_jc_start flexer_ai_center">
                                                    <div class="img_frame">
                                                        {!! img_tag([
                                                           'path' => 'hospitals',
                                                           'src' => $hospital->image,
                                                           'alt' => $hospital->name,
                                                        ]); !!}
                                                    </div>
                                                    <div class="data">
                                                        <h4>{{$hospital->name}}</h4>
                                                        <span>{{$hospital->excerpt}}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="centers" role="tabpanel" aria-labelledby="centers-tab">
                                <div class="row justify-content-between tab_panel_head">
                                    <div class="col-md-8 flexer flexer_ai_center flexer_jc_center">
                                        <h3>{{ trans('general.list_of_centers_that') }} {{$row->name}} {{ trans('general.working_with') }}</h3>
                                    </div>
                                    <div class="col-md-4 flexer flexer_ai_center flexer_jc_end">
                                        <i class="icon-hospital"></i>
                                    </div>
                                </div>
                                <div class="row tab_panel_content doctors">
                                    @foreach($row->centers as $center)
                                        <div class="col-md-12 item doctor">
                                            <a href="{{route('frontend.center.unit', ['id'=>$center->id])}}">
                                                <div class="flexer flexer_jc_start flexer_ai_center">
                                                    <div class="img_frame">
                                                        {!! img_tag([
                                                           'path' => 'centers',
                                                           'src' => $center->image,
                                                           'alt' => $center->name,
                                                        ]); !!}
                                                    </div>
                                                    <div class="data">
                                                        <h4>{{$center->name}}</h4>
                                                        <span>{{$center->excerpt}}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="insurance" role="tabpanel" aria-labelledby="insurance-tab">
                                <div class="row justify-content-between tab_panel_head">
                                    <div class="col-md-8 flexer flexer_ai_center flexer_jc_center">
                                        <h3>{{ trans('general.list_of_insurance_companies_that') }} {{$row->name}} {{ trans('general.coverage_deal_with') }}</h3>
                                    </div>
                                    <div class="col-md-4 flexer flexer_ai_center flexer_jc_end">
                                        <i class="icon-insurance"></i>
                                    </div>
                                </div>
                                <div class="row tab_panel_content doctors">
                                    @foreach ($row->insuranceCompanies as $company)
                                        <div class="col-md-12 item doctor">
                                            <a href="#">
                                                <div class="flexer flexer_jc_start flexer_ai_center">
                                                    <div class="img_frame">
                                                        {!! img_tag([
                                                           'path' => 'insurance_companies',
                                                           'src' => $company->image,
                                                           'alt' => $company->name,
                                                           'title' => $company->name
                                                        ]); !!}
                                                    </div>
                                                    <div class="data">
                                                        <h4><a href="{{route('frontend.insurance_company.unit', ['id'=>$company->id])}}">{{$company->name}}</a></h4>
                                                        <span>{{$company->excerpt}}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                    <h5>{{ trans('general.services_tags') }}</h5>
                    @php $tags_ar=''; $tags_en=''; @endphp
                    <?php \App\Mangers\SettingsManger::Instance()->getCountry()->id = 1; ?>
                    @if($row->tags_ar)
                        @php $tags_arr = explode(',', $row->tags_ar); @endphp
                        @foreach ( $tags_arr as $tg)
                            <a href="{{ route('frontend.doctor.index') . '?speciality=' . $specialty[0] . '&tag=' . $tg}}">
                                <span style="color: #fff" class="badge badge-primary">
                                    @if( is_numeric($tg) ) {{\DB::table('tag_trans')->where("tag_id",$tg)->first()->name}} @else {{$tg}} @endif
                                </span>
                            </a>
                        @endforeach
                    @else
                        @foreach ($tags as $tag_s)
                            @foreach ($tag_s->specialties()->whereIn('specialty_id', $specialty)->get() as $tg)
                                <a href="{{ route('frontend.doctor.index') . '?speciality=' . $specialty[0] . '&tag=' . $tg->pivot->tag_id}}">
                                    <span style="color: #fff" class="badge badge-primary">
                                        {{\DB::table('tag_trans')->where("tag_id",$tg->pivot->tag_id)->first()->name}}
                                        @php $tags_ar .=  $tg->pivot->tag_id . ","; @endphp
                                        @php $tags_en .=  $tg->pivot->tag_id . ","; @endphp
                                    </span>
                                </a>
                            @endforeach
                        @endforeach
                        @php
                            $new_tags_ar = rtrim($tags_ar, ",");
                            $new_tags_en = rtrim($tags_en, ",");
                            DB::table('doctors')
                            ->where('id', $row->id)
                            ->update(['tags_ar' => $new_tags_ar, 'tags_en' => $new_tags_en]);
                        @endphp
                    @endif
                    <hr>
                    <style>
                        span.specialty-doctor:last-child {   display: none;}
                    </style>
                </div>
            @endslot

            @slot('addressBlock')
                doctor._address_block
            @endslot
            @endunit_block
        </div>
    </section>
    @include('frontend.partials.rating_modal')
    @include('frontend.doctor._reservation_modal')
@endsection

