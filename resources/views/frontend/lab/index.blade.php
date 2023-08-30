@extends('frontend.master')

@section('content')
    <section class="inner_container lab_list">
        <div class="container">
            @if( isset($Speciality) && isset($city) && $area && $sub_cat)
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.labs') => route('frontend.lab.index'),
                    $city->name => route('frontend.lab.index') . '?speciality=' . $Speciality->id. '&city=' . $city->id,
                    $area->name => route('frontend.lab.index') . '?speciality=' . $Speciality->id. '&area=' . $area->id. '&city=' . $city->id,
                    $Speciality->name => route('frontend.lab.index'). '?speciality=' . $Speciality->id. '&city=' . $city->id. '&area=' . $area->id,
                    \App\Models\SubCategory::find($sub_cat)->name => route('frontend.lab.index'). '?speciality=' . $Speciality->id. '&city=' . $city->id. '&area=' . $area->id. '&sub_cat=' .$sub_cat,
                ]
            ])
        @elseif( isset($Speciality) && isset($city) && $area)
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.labs') => route('frontend.lab.index'),
                    $city->name => route('frontend.lab.index') . '?speciality=' . $Speciality->id. '&city=' . $city->id,
                    $area->name => route('frontend.lab.index') . '?speciality=' . $Speciality->id. '&area=' . $area->id,
                    $Speciality->name => route('frontend.lab.index'). '?speciality=' . $Speciality->id. '&city=' . $city->id. '&area=' . $area->id,
                ]
            ])
        @elseif( isset($Speciality) && isset($city))
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.labs') => route('frontend.lab.index'),
                    $city->name => route('frontend.lab.index') . '?city=' . $city->id,
                    $Speciality->name => route('frontend.lab.index'). '?speciality=' . $Speciality->id. '&city=' . $city->id,
                ]
            ])
        @elseif( isset($Speciality) )
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.labs') => route('frontend.lab.index'),
                    $Speciality->name => route('frontend.lab.index'). '?speciality=' . $Speciality->id,
                ]
            ])
        @elseif($city && $area)
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.labs') => route('frontend.lab.index'),
                    $city->name => route('frontend.lab.index') . '?city=' . $city->id,
                    $area->name => route('frontend.lab.index') . '?area=' . $area->id. '&city=' . $city->id,
                ]
            ])
        @elseif($city)
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.labs') => route('frontend.lab.index'),
                    $city->name => route('frontend.lab.index') . '?city=' . $city->id,
                    //$area->name => route('frontend.lab.index') . '?area=' . $area->id,
                ]
            ])
        @elseif($area)
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.labs') => route('frontend.lab.index'),
                    $area->name => route('frontend.lab.index') . '?area=' . $area->id,
                ]
            ])
        @else
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.labs') => route('frontend.lab.index'),
                ]
            ])
        @endif

            <div class="row">
                <div class="col-md">
                    <h1 class="list_title">
                        {{ getMainModuleTitle('labs_best',$city, $area) }}
                    </h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="list_holder">
                        @forelse( $rows as $row)
                            @list_block(['row' => $row, 'imagePath' => 'labs/' , 'routeKey' => 'lab' ]) @endlist_block
                        @empty
                            @include('frontend.partials._no_data')
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="pagination_holder">
                {{ $rows->appends(Request::query())->links() }}
            </div>
        </div>
    </section>
@endsection
