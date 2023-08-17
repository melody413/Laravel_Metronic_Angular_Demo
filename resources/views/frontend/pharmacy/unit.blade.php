@extends('frontend.master')

@section('content')
    <section class="inner_container unit pharmacy_unit">
        <div class="container">
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.pharmacies') => route('frontend.pharmacy.index'),
                    $row->city->name => route('frontend.pharmacy.index') . '?city=' . $row->city_id,
                    $row->area->name => route('frontend.pharmacy.index') . '?area=' . $row->area_id. '&city=' . $row->city_id,
                ]
            ])

            @unit_block(['row' => $row ,'imagePath' => 'pharmacies/', 'withAddress' => true])

            @Slot('topping')
                @if(count($row->getInsuranceCompanies()))
                    <div class="topping">
                        <div class="head">
                            <h2>{{ trans('general.insurances_companies') }}</h2>
                        </div>
                        <div class="content">
                            <div class="row tab_panel_content topping_single_list">
                                @foreach ($row->getInsuranceCompanies() as $insuranceCompany)
                                    <div class="col-md-12 item">
                                        <a href="{{ route('frontend.insurance_company.unit', ['id' => $insuranceCompany->id]) }}">
                                            <div class="flexer flexer_jc_start flexer_ai_center">
                                                <div class="img_frame">
                                                    {!! img_tag([
                                                       'path' => 'insurance_companies/',
                                                       'src' => $insuranceCompany->image,
                                                       'alt' => $insuranceCompany->name
                                                    ]); !!}
                                                </div>
                                                <div class="data">
                                                    <h4>{{ $insuranceCompany->name }}</h4>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endslot;

            @endunit_block
        </div>
    </section>
@endsection
