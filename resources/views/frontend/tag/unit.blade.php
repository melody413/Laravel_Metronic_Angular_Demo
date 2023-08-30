@extends('frontend.master')

@section('content')
    <section class="inner_container unit insurance_company_unit">
        <div class="container">
            @if(isset($row->city->name) && isset($row->area_id))
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.tags') => route('frontend.tag.index'),
                        $row->city->name => route('frontend.tag.index') . '?city=' . $row->city_id,
                        $row->area->name => route('frontend.tag.index') . '?area=' . $row->area_id. '&city=' . $row->city_id,
                    ]
                ])
            @endif

            @unit_block(['row' => $row ,'imagePath' => 'tags/', 'withAddress' => false])

                @slot('content')
                    <div id="lightgallery" class="unit_images flexer flexer_ac_space_between flexer_ai_stretch flexer_wrap">
                        @if(!empty($row->image_gallery))
                            @foreach (json_decode($row->image_gallery) as $ga)
                                <a href="/uploads/tags/{{ $ga }}">
                                    <img src="/uploads/tags/{{ $ga }}" />
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
                                        <a class="nav-link" id="tags-tab" data-toggle="tab" href="#tags" role="tab" aria-controls="profile" aria-selected="false">{{ trans('general.insurances_companies') }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="doctors" role="tabpanel" aria-labelledby="doctors-tab">
                                        <div class="row justify-content-between tab_panel_head">
                                            <div class="col-md-8 flexer flexer_ai_tag flexer_jc_tag">
                                                <h3>{{ trans('general.list_of_doctors_that') }} {{ $row->name }} {{ trans('general.coverage_deal_with') }}</h3>
                                            </div>
                                            <div class="col-md-4 flexer flexer_ai_tag flexer_jc_end">
                                                <i class="icon-doctor"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tags" role="tabpanel" aria-labelledby="tags-tab">
                                        <div class="row justify-content-between tab_panel_head">
                                            <div class="col-md-8 flexer flexer_ai_tag flexer_jc_tag">
                                                <h3>{{ trans('general.list_of_insurance_companies_that') }} {{ $row->name }} {{ trans('general.coverage_deal_with') }}</h3>
                                            </div>
                                            <div class="col-md-4 flexer flexer_ai_tag flexer_jc_end">
                                                <i class="icon-tag"></i>
                                            </div>
                                        </div>
                                        <div class="row tab_panel_content doctors">
                                            @foreach ($row->getInsuranceCompanies() as $doctor)
                                                <div class="col-md-12 item doctor">
                                                    <a href="{{ route('frontend.insurance_company.unit', ['id' => $doctor->id]) }}">
                                                        <div class="flexer flexer_jc_start flexer_ai_tag">
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
                        </div>
                    </div>
                @endslot

            @endunit_block

        </div>
    </section>
@endsection
