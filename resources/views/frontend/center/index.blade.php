@extends('frontend.master')

@section('content')

    <section class="inner_container pharmacy_list">
        <div class="container">
            @if( isset($Speciality) && isset($city) && $area)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.centers') => route('frontend.center.index'),
                        $city->name => route('frontend.center.index') . '?city=' . $city->id,
                        $area->name => route('frontend.center.index') . '?area=' . $area->id,
                        $Speciality->name => route('frontend.center.index'). '?speciality=' . $Speciality->id. '&city=' . $city->id. '&area=' . $area->id,
                    ]
                ])
            @elseif( isset($Speciality) && isset($city))
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.centers') => route('frontend.center.index'),
                        $city->name => route('frontend.center.index') . '?city=' . $city->id,
                        $Speciality->name => route('frontend.center.index'). '?speciality=' . $Speciality->id. '&city=' . $city->id,
                    ]
                ])
            @elseif($city && $area)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.centers') => route('frontend.center.index'),
                        $city->name => route('frontend.center.index') . '?city=' . $city->id,
                        $area->name => route('frontend.center.index') . '?area=' . $area->id,
                    ]
                ])
            @elseif($city)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.centers') => route('frontend.center.index'),
                        $city->name => route('frontend.center.index') . '?city=' . $city->id,
                        //$area->name => route('frontend.center.index') . '?area=' . $area->id,
                    ]
                ])
            @elseif($area)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.centers') => route('frontend.center.index'),
                        //$city->name => route('frontend.center.index') . '?city=' . $city->id,
                        $area->name => route('frontend.center.index') . '?area=' . $area->id,
                    ]
                ])
            @elseif( isset($Speciality))
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.centers') => route('frontend.center.index'),
                        $Speciality->name => route('frontend.center.index'). '?speciality=' . $Speciality->id,
                    ]
                ])
            @else
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.centers') => route('frontend.center.index'),
                    ]
                ])
            @endif

            <div class="row">
                <div class="col-md">
                    <h1 class="list_title">
                        {{ getMainModuleTitle('centers_best',$city,$area,\App\Models\SubCategory::find($sub_cat) ?: $Speciality) }}
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="list_holder">
                        @forelse( $rows as $row)
                            @list_block(['row' => $row, 'imagePath' => 'centers/' , 'routeKey' => 'center', 'speciality' => $Speciality ]) @endlist_block
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
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$qa->id}}" aria-expanded="true" aria-controls="collapse{{$qa->id}}">
                                {{$qa->name}}
                            </button>
                        </h5>
                        </div>

                        <div id="collapse{{$qa->id}}" class="collapse @if($key == 0) show @endif" aria-labelledby="heading{{$qa->id}}" data-parent="#accordion">
                        <div class="card-body">
                            {!! $qa->description !!}
                        </div>
                        </div>
                    </div>    
                    @if($key == 2) @break @endif
                @endforeach
            </div>


        </div>
    </section>
@endsection
