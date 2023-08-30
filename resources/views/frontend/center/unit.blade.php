@extends('frontend.master')

@section('content')
    <section class="inner_container unit insurance_company_unit">
        <div class="container">
            @if ($specialty->first() && isset($row->city->name) && isset($row->area_id))
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.centers') => route('frontend.center.index'),
                        $row->city->name => route('frontend.center.index') . '?city=' . $row->city_id,
                        $row->area->name => route('frontend.center.index') . '?area=' . $row->area_id. '&city=' . $row->city_id,
                        \App\Models\Specialty::find( $specialty->first() )->name => route('frontend.center.index'). '?speciality=' .$specialty->first(). '&city=' . $row->city->id. '&area=' . $row->area->id,
                    ]
                ])
            @elseif(isset($row->city->name) && isset($row->area_id))
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.centers') => route('frontend.center.index'),
                        $row->city->name => route('frontend.center.index') . '?city=' . $row->city_id,
                        $row->area->name => route('frontend.center.index') . '?area=' . $row->area_id. '&city=' . $row->city_id,
                    ]
                ])
            @else
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.centers') => route('frontend.center.index'),
                        $row->city->name => route('frontend.center.index') . '?city=' . $row->city_id,
                        // $row->area->name => route('frontend.center.index') . '?area=' . $row->area_id. '&city=' . $row->city_id,
                    ]
                ])
            @endif

            @unit_block(['row' => $row ,'imagePath' => 'centers/', 'withAddress' => true, 'specialty' => $specialty])

            @if(is_numeric(basename($_SERVER['REQUEST_URI'])))
                @slot('titlePlus')
                    {{ $row->title }}
                    <br>
                    <span id="specialty">
                        @if( isset($specialty) && isset($specialty))
                        {{-- {{ trans('general.specialty') }} --}}
                        @foreach ($specialty as $specialty_row)
                                <a class="specialty-row" href="{{ route('frontend.center.index') . '?speciality='. $specialty_row }}">
                                    {{ \App\Models\Specialty::find($specialty_row)->name }}
                                </a>
                            @endforeach
                        @endif
                    </span>
                @endslot
            @endif
                @slot('content')
                    <div id="lightgallery" class="unit_images flexer flexer_ac_space_between flexer_ai_stretch flexer_wrap">
                        @if(!empty($row->image_gallery))
                            @foreach (json_decode($row->image_gallery) as $ga)
                                <a href="/uploads/centers/{{ $ga }}">
                                    <img src="/uploads/centers/{{ $ga }}" />
                                </a>
                            @endforeach
                        @endif
                    </div>
                @endslot

                @slot('topping')
                    <div class="topping">
                        <div class="head">
                            <h2>{{ trans('general.covering_the_followings') }}</h2>
                        </div>
                        <div class="content">
                            <div class="topping_tabs">
                                <ul class="nav nav-tabs" id="topping_tabs_ul" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="doctors-tab" data-toggle="tab" href="#doctors" role="tab" aria-controls="home" aria-selected="true">{{ trans('general.doctors') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="centers-tab" data-toggle="tab" href="#centers" role="tab" aria-controls="profile" aria-selected="false">{{ trans('general.insurances_companies') }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="doctors" role="tabpanel" aria-labelledby="doctors-tab">
                                        <div class="row justify-content-between tab_panel_head">
                                            <div class="col-md-8 flexer flexer_ai_center flexer_jc_center">
                                                <h3>{{ trans('general.list_of_doctors_that') }} {{ $row->name }} {{ trans('general.coverage_deal_with') }}</h3>
                                            </div>
                                            <div class="col-md-4 flexer flexer_ai_center flexer_jc_end">
                                                <i class="icon-doctor"></i>
                                            </div>
                                        </div>
                                        <div class="row tab_panel_content doctors">
                                            <?php $specialty_id[] = [""] ?>
                                            <div id="specialties">
                                                <button specialty_id="" class="btn btn-primary active dr-specialty">كل التخصصات</button>
                                            </div>
                                            <br>
                                            @foreach ($row->getDoctors() as $doctor)
                                                <?php $dr_specialty_id = $doctor->specialties()->pluck('specialty_id')->first();
                                                $dr_specialty_name = \App\Models\Specialty::find($dr_specialty_id)->name; ?>
                                                @if(!in_array($dr_specialty_id, $specialty_id))
                                                    <script> document.getElementById('specialties').insertAdjacentHTML('afterend', '<button specialty_id='+"{{$dr_specialty_id}}"+' class="btn btn-primary dr-specialty">'+"{{$dr_specialty_name}}"+'</button>');</script>
                                                    <?php $specialty_id[] = $dr_specialty_id ?>
                                                @endif
                                                <div class="col-md-12 item doctor dr_specialty_row dr_specialty_{{$dr_specialty_id}}">
                                                    <a href="{{ route('frontend.center.unit', ['id' => $doctor->id]) }}">
                                                        <div class="flexer flexer_jc_start flexer_ai_center">
                                                            <div class="img_frame">
                                                                {!! img_tag([
                                                                    'path' => 'doctors/',
                                                                    'src' => $doctor->image,
                                                                    'alt' => $doctor->name,
                                                                    'title' => $doctor->name
                                                                ]); !!}
                                                            </div>
                                                            <div class="data">
                                                                <h4>{{ $doctor->name }}</h4>
                                                                <span>{{ $doctor->title }}</span>
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
                                                <h3>{{ trans('general.list_of_insurance_companies_that') }} {{ $row->name }} {{ trans('general.coverage_deal_with') }}</h3>
                                            </div>
                                            <div class="col-md-4 flexer flexer_ai_center flexer_jc_end">
                                                <i class="icon-center"></i>
                                            </div>
                                        </div>
                                        <div class="row tab_panel_content doctors">
                                            @foreach ($row->getInsuranceCompanies() as $doctor)
                                                <div class="col-md-12 item doctor">
                                                    <a href="{{ route('frontend.insurance_company.unit', ['id' => $doctor->id]) }}">
                                                        <div class="flexer flexer_jc_start flexer_ai_center">
                                                            <div class="img_frame">
                                                                {!! img_tag([
                                                                   'path' => 'insurance_companies/',
                                                                   'src' => $doctor->image,
                                                                   'alt' => $doctor->name
                                                                ]); !!}
                                                            </div>
                                                            <div class="data">
                                                                <h4>{{ $doctor->name }}</h4>
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
                            @if($row->tags_ar)
                                @php $tags_arr = explode(',', $row->tags_ar); @endphp
                                @foreach ( $tags_arr as $tg)
                                    <a href="{{ route('frontend.center.index') . '?speciality=' . $specialty[0] . '&tag=' . $tg}}">
                                        <span style="color: #fff" class="badge badge-primary">
                                            @if( is_numeric($tg) ) {{\App\Models\Tag::find($tg)->name}} @else {{$tg}} @endif
                                        </span>
                                    </a>
                                @endforeach
                            @else
                                @foreach ($tags as $tag_s)
                                    @foreach ($tag_s->specialties()->whereIn('specialty_id', $specialty)->get() as $tg)
                                        <a href="{{ route('frontend.center.index') . '?speciality=' . $specialty[0] . '&tag=' . $tg->pivot->tag_id}}">
                                            <span style="color: #fff" class="badge badge-primary">
                                                {{\App\Models\Tag::find($tg->pivot->tag_id)->name}}
                                                @php $tags_ar .=  $tg->pivot->tag_id . ","; @endphp
                                                @php $tags_en .=  $tg->pivot->tag_id . ","; @endphp
                                            </span>
                                        </a>
                                    @endforeach
                                @endforeach
                                @php
                                    $new_tags_ar = rtrim($tags_ar, ",");
                                    $new_tags_en = rtrim($tags_en, ",");
                                    DB::table('centers')
                                        ->where('id', $row->id)
                                        ->update(['tags_ar' => $new_tags_ar, 'tags_en' => $new_tags_en]);
                                @endphp
                            @endif
                            <hr>
                            <style>
                                span.specialty-center:last-child {display: none;}
                            </style>
        
                        </div>
                    </div>
                @endslot

            @endunit_block

        </div>
    </section>

<style>
button.btn {
    margin: 5px 1.5px;
}
a.specialty-row {
    background: #eeefff;
    margin: 6px 4px;
    padding: 6px 10px;
    display: inline-block;
    /* float: right; */
    /* clear: both; */
    border-radius: 35px;
}
.unit_content .topping {
    clear: both;
    margin-top: 42px;
    padding: 2px 0;
}
.unit .unit_content .topping .content .topping_tabs .tab-content .tab-pane .tab_panel_content .item {
    margin-top: 15px;
    margin-bottom: 0
}
</style>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
    $("button.btn").on("click", function() {
        $(".dr-specialty").removeClass("active")
        $(this).addClass("active")
        $(".dr_specialty_row").hide()
        $(".dr_specialty_"+$(this).attr('specialty_id')).show()
        if(!$(this).attr('specialty_id'))
            $(".dr_specialty_row").show()
    });
</script>
@endsection
