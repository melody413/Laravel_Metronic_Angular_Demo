@extends('frontend.master')

@section('content')
    <section class="inner_container unit insurance_company_unit">
        <div class="container">
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.insurances_companies') => route('frontend.insurance_company.index'),
                    $row->city->name => route('frontend.insurance_company.index') . '?city=' . $row->city_id,
                    $row->area->name => route('frontend.insurance_company.index') . '?area=' . $row->area_id. '&city=' . $row->city_id,
                ]
            ])

            @unit_block(['row' => $row ,'imagePath' => 'insurance_companies/', 'withAddress' => true])

                @slot('topping')
                    <div class="topping">
                        <div class="head">
                            <h2>{{ trans('general.covering_the_followings') }}</h2>
                        </div>
                        <div class="content">
                            <div class="topping_tabs">
                                <ul class="nav nav-tabs" id="topping_tabs_ul" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="doctors-tab" data-toggle="tab" href="#doctors" role="tab" aria-controls="home" aria-selected="true">Doctors</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="hospitals-tab" data-toggle="tab" href="#hospitals" role="tab" aria-controls="profile" aria-selected="false">Hospitals</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="labs-tab" data-toggle="tab" href="#labs" role="tab" aria-controls="contact" aria-selected="false">Labs</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="labs-tab" data-toggle="tab" href="#pharmacy" role="tab" aria-controls="contact" aria-selected="false">{{ trans('general.pharmacies') }}</a>
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

                                            @foreach ($row->getDoctors() as $doctor)
                                                <div class="col-md-12 item doctor">
                                                    <a href="{{ route('frontend.doctor.unit', ['id' => $doctor->id]) }}">
                                                        <div class="flexer flexer_jc_start flexer_ai_center">
                                                            <div class="img_frame">
                                                                {!! img_tag([
                                                                   'path' => 'doctors/',
                                                                   'src' => $doctor->image,
                                                                   'alt' => $doctor->name
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
                                    <div class="tab-pane fade" id="hospitals" role="tabpanel" aria-labelledby="hospitals-tab">
                                        <div class="row justify-content-between tab_panel_head">
                                            <div class="col-md-8 flexer flexer_ai_center flexer_jc_center">
                                                <h3>{{ trans('general.list_of_hospitals_that') }} {{ $row->name }} {{ trans('general.coverage_deal_with') }}</h3>
                                            </div>
                                            <div class="col-md-4 flexer flexer_ai_center flexer_jc_end">
                                                <i class="icon-hospital"></i>
                                            </div>
                                        </div>
                                        <div class="row tab_panel_content doctors">
                                            @foreach ($row->getHospitals() as $doctor)
                                                <div class="col-md-12 item doctor">
                                                    <a href="{{ route('frontend.hospital.unit', ['id' => $doctor->id]) }}">
                                                        <div class="flexer flexer_jc_start flexer_ai_center">
                                                            <div class="img_frame">
                                                                {!! img_tag([
                                                                   'path' => 'hospitals/',
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
                                    <div class="tab-pane fade" id="labs" role="tabpanel" aria-labelledby="labs-tab">
                                        <div class="row justify-content-between tab_panel_head">
                                            <div class="col-md-8 flexer flexer_ai_center flexer_jc_center">
                                                <h3>{{ trans('general.list_of_labs_that') }} {{ $row->name }} {{ trans('general.coverage_deal_with') }}</h3>
                                            </div>
                                            <div class="col-md-4 flexer flexer_ai_center flexer_jc_end">
                                                <i class="icon-lab"></i>
                                            </div>
                                        </div>
                                        <div class="row tab_panel_content doctors">
                                            @foreach ($row->getLabs() as $doctor)
                                                <div class="col-md-12 item doctor">
                                                    <a href="{{ route('frontend.lab.unit', ['id' => $doctor->id]) }}">
                                                        <div class="flexer flexer_jc_start flexer_ai_center">
                                                            <div class="img_frame">
                                                                {!! img_tag([
                                                                   'path' => 'labs/',
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
                                    <div class="tab-pane fade" id="pharmacy" role="tabpanel" aria-labelledby="pharmacy-tab">
                                        <div class="row justify-content-between tab_panel_head">
                                            <div class="col-md-8 flexer flexer_ai_center flexer_jc_center">
                                                <h3>List of Pharmacies that {{ $row->name }} coverage deal with</h3>
                                            </div>
                                            <div class="col-md-4 flexer flexer_ai_center flexer_jc_end">
                                                <i class="icon-lab"></i>
                                            </div>
                                        </div>
                                        <div class="row tab_panel_content doctors">
                                            @foreach ($row->getPharmacy() as $pharmacy)
                                                <div class="col-md-12 item insurance_companies">
                                                    <a href="{{ route('frontend.pharmacy.unit', ['id' => $pharmacy->id]) }}">
                                                        <div class="flexer flexer_jc_start flexer_ai_center">
                                                            <div class="img_frame">
                                                                {!! img_tag([
                                                                   'path' => 'pharmacies/',
                                                                   'src' => $pharmacy->image,
                                                                   'alt' => $pharmacy->name
                                                                ]); !!}
                                                            </div>
                                                            <div class="data">
                                                                <h4>{{ $pharmacy->name }}</h4>
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
