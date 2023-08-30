@extends('frontend.master')

@section('content')
    <section class="inner_container pharmacy_list">
        <div class="container">
            @if($city && $area)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.pharmacy') => route('frontend.pharmacy.index'),
                        $city->name => route('frontend.pharmacy.index') . '?city=' . $city->id,
                        $area->name => route('frontend.pharmacy.index') . '?area=' . $area->id. '&city=' . $city->id,
                    ]
                ])
            @elseif($city)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.pharmacies') => route('frontend.pharmacy.index'),
                        $city->name => route('frontend.pharmacy.index') . '?city=' . $city->id,
                        //$area->name => route('frontend.pharmacy.index') . '?area=' . $area->id,
                    ]
                ])
            @elseif($area)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.pharmacies') => route('frontend.pharmacy.index'),
                        $area->name => route('frontend.pharmacy.index') . '?area=' . $area->id,
                    ]
                ])
            @endif
            <div class="row">
                <div class="col-md">
                    <h1 class="list_title">
                        {{ getMainModuleTitle('pharmacies_best',$city, $area) }}
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="list_holder">
                        @forelse( $pharmacies as $row)
                            @list_block(['row' => $row, 'imagePath' => 'pharmacies/' , 'routeKey' => 'pharmacy' ]) @endlist_block
                        @empty
                            @include('frontend.partials._no_data')
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="pagination_holder">
                {{ $pharmacies->appends(Request::query())->links() }}
            </div>
        </div>
    </section>
@endsection
