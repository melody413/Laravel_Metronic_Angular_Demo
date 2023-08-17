@extends('frontend.master')

@section('content')
    <section class="inner_container unit row_unit">
        <div class="container">
            @if( isset($specialty) && isset($row->city->name) && isset($row->area_id) )
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.labs') => route('frontend.lab.index'),
                   // $specialty->name => route('frontend.lab.index'). '?speciality=' . $specialty->id. '&city=' . $row->city_id,
                    $row->city->name => route('frontend.lab.index') . '?city=' . $row->city_id,
                    $row->area->name => route('frontend.lab.index') . '?area=' . $row->area_id. '&city=' . $row->city_id,
                ]
            ])
        @elseif(isset($row->city->name) && isset($row->area_id))
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.labs') => route('frontend.lab.index'),
                    $row->city->name => route('frontend.lab.index') . '?city=' . $row->city_id,
                    $row->area->name => route('frontend.lab.index') . '?area=' . $row->area_id. '&city=' . $row->city_id,
                ]
            ])
        @endif

        <br>

            @unit_block(['row' => $row ,'imagePath' => 'labs/', 'withAddress' => true])
                @Slot('topping')
                    <div class="topping">
                        <div class="head">
                            <h2>{{ trans('general.service') }}</h2>
                        </div>
                        <div class="content">
                            @foreach (\App\Models\LabCategory::where('is_active' , 1)->get() as $alphabet => $collection)
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                        <h6 class="panel-title">
                                            <a data-toggle="collapse" href="#collapse1">
                                                {!! $collection->name !!} <i class="fas fa-arrow-down float-right"></i>
                                            </a>
                                        </h6>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ul class="raw_list">
                                                @foreach ($row->labServices()->withTranslation()->get() as $inc)
                                                    @if($inc->lab_category == $collection->id)
                                                        <li>{{ $inc->name }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                        {{-- <div class="panel-footer">Panel Footer</div> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="topping">
                                <ul class="raw_list">
                                    @foreach ($row->labServices()->withTranslation()->get() as $inc)
                                        <li>{{ $inc->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
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

                @endslot
            @endunit_block
        </div>
    </section>
@endsection
