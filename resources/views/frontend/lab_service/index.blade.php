@extends('frontend.master')

@section('content')
    <section class="inner_container lab_service_list">
        <div class="container">
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.lab_services') => route('frontend.lab_service.index'),
                ]
            ])
{{-- 
            <div class="row">
                <div class="col-md">
                    <h1 class="list_title">
                        {{ getMainModuleTitle('lab_service',"","") }}
                    </h1>
                </div>
            </div> --}}

            <div class="row list_holder">
                @forelse( $rows as $row)
                    <div class="col-md-3 col-sm-6">
                        @list_block(['row' => $row, 'imagePath' => 'lab_services/' , 'routeKey' => 'lab_service' ]) @endlist_block
                    </div>
                @empty
                    @include('frontend.partials._no_data')
                @endforelse
            </div>
            <div class="pagination_holder">
                {{ $rows->appends(Request::query())->links() }}
            </div>
        </div>
    </section>
@endsection
