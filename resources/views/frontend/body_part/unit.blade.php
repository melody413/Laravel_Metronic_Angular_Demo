@extends('frontend.master')

@section('content')
    <section class="inner_container unit insurance_category_unit">
        <div class="container">
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.body_parts') => route('frontend.body_part.index'),
                ]
            ])

            @unit_block(['row' => $row, 'diseases' => $diseases ,'imagePath' => 'body_parts/', 'withAddress' => false])

            @endunit_block

        </div>
    </section>
@endsection
