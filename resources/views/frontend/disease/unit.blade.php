@extends('frontend.master')

@section('content')
    <section class="inner_container unit insurance_category_unit">
        <div class="container">
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.medicines') => route('frontend.medicine.index'),
                ]
            ])

            @unit_block(['row' => $row ,'imagePath' => 'medicines/', 'withAddress' => false])
                
            @endunit_block

        </div>
    </section>
@endsection
