@extends('frontend.master')

@section('content')
    <section class="inner_container unit row_unit">
        <div class="container">
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.lab_services') => route('frontend.lab_service.index'),
                    $row->name => '',
                ]
            ])

        <br>

            @unit_block(['row' => $row ,'imagePath' => 'labs/', 'withAddress' => false])
                @Slot('topping')
                    {{-- <div class="topping">
                        <div class="head">
                            <h2>{{ trans('general.service') }}</h2>
                        </div>
                        <div class="content">
                            <div class="topping">

                            </div>
                        </div>
                    </div> --}}

                @endslot
            @endunit_block
        </div>
<style>
tr {
    font-family: Cairo,Tahoma,sans-serif;
}
</style>
    </section>
@endsection
