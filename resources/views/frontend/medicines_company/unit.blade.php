@extends('frontend.master')

@section('content')
    <section class="inner_container unit insurance_company_unit">
        <div class="container">
            @include('frontend.partials.breadcrumb', [
                'breadcrumb' => [
                    trans('general.home') => route('frontend.home'),
                    trans('general.medicines') => route('frontend.medicine.index'),
                ]
            ])

            @unit_block(['row' => $row ,'imagePath' => 'medicines/', 'withAddress' => false, 'medicines_company_ar'=> $medicines_company_ar, 'currency_code'=> $currency_code, 
            'medicines_sc_name_1_ar'=> $medicines_sc_name_1_ar])
                
            @endunit_block

        </div>
    </section>
@endsection
