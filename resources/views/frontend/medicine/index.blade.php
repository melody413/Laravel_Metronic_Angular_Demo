@extends('frontend.master')

@section('content')
    <section class="inner_container pharmacy_list">
        <div class="container">
            @if( isset($category) && $category)
                @if ($parent2)
                    @include('frontend.partials.breadcrumb', [
                        'breadcrumb' => [
                            trans('general.home') => route('frontend.home'),
                            trans('general.medicines_directory').' '.trans('general.in').' '.$country => route('frontend.medicine.index'),
                            $parent2->name => route('frontend.medicine.index') . '?category=' . $parent2->id,
                            $parent->name => route('frontend.medicine.index') . '?category=' . $parent->id,
                            $category->name => route('frontend.medicine.index') . '?category=' . $category->id,
                        ]
                    ])
                @elseif ($parent)
                    @include('frontend.partials.breadcrumb', [
                        'breadcrumb' => [
                            trans('general.home') => route('frontend.home'),
                            trans('general.medicines_directory').' '.trans('general.in').' '.$country => route('frontend.medicine.index'),
                            $parent->name => route('frontend.medicine.index') . '?category=' . $parent->id,
                            $category->name => route('frontend.medicine.index') . '?category=' . $category->id,
                        ]
                    ])
                @else
                    @include('frontend.partials.breadcrumb', [
                        'breadcrumb' => [
                            trans('general.home') => route('frontend.home'),
                            trans('general.medicines_directory').' '.trans('general.in').' '.$country => route('frontend.medicine.index'),
                            $category->name => route('frontend.medicine.index') . '?category=' . $category->id,
                        ]
                    ])
                @endif
            @elseif ($scientific_name_1_title)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.medicines_directory').' '.trans('general.in').' '.$country => route('frontend.medicine.index'),
                        trans('general.scientific_names') => route('frontend.medicine.index') . '?scientific-name-1=' . $scientific_name_1_title->id,
                        $scientific_name_1_title->name =>  route('frontend.medicine.index') . '?scientific-name-1=' . $scientific_name_1_title->id,
                    ]
                ])
            @elseif ($medicines_company_ar)
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.medicines_directory').' '.trans('general.in').' '.$country => route('frontend.medicine.index'),
                        $medicines_company_ar->name =>  route('frontend.medicine.index') . '?company=' . $company_id,
                    ]
                ])
            @else
                @include('frontend.partials.breadcrumb', [
                    'breadcrumb' => [
                        trans('general.home') => route('frontend.home'),
                        trans('general.medicines_directory').' '.trans('general.in').' '.$country => route('frontend.medicine.index'),
                    ]
                ])
            @endif

            <div class="row">
                <div class="col-md">
                    <h1 class="list_title">
                        {{-- {{ getMainModuleTitle('medicines',$city,$area) }} --}}
                        @if($scientific_name_1_title)
                            {{getMainModuleTitleWithoutIn('medicines',$scientific_name_1_title, $area)}}
                        @elseif($medicines_company_ar)
                            {{getMainModuleTitleWithoutIn('medicines_company',$medicines_company_ar, $area)}}
                        @elseif($form)
                            {{getMainModuleTitle($form.'_medicines',$city, $area,\App\Models\MedicinesCategory::find($category_id) ?: $category )}} 
                        @else
                            {{ getMainModuleTitle('medicines',$city,$area,\App\Models\MedicinesCategory::find($category_id) ?: $category ) }}
                        @endif

                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="list_holder">
                        @forelse( $rows as $row)
                            @list_block(['row' => $row, 'imagePath' => 'medicines/' , 'routeKey' => 'medicine' ]) @endlist_block
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
                    @if($key == 9) @break @endif
                @endforeach
            </div>
        </div>
    </section>

    <script type="application/ld+json">[{"@context":"http://schema.org/","@type":"MedicalWebPage","@id":"{{route('frontend.medicine.index') }}#alpha/a.html","url":"{{route('frontend.medicine.index') }}#alpha/a.html","audience":{"@context":"https://schema.org","@type":"medicalAudience","audienceType":["Patient"]},"publisher":{"@context":"http://schema.org/","@type":"Organization","@id":"{{route('frontend.medicine.index') }}#organization","name":"doctorak.com","url":"{{route('frontend.medicine.index') }}","logo":{"@context":"http://schema.org","@type":"ImageObject","url":"https://doctorak.com/assets/frontend/images/general/doctorak_default_logo_img.png","width":112,"height":112}},"image":{"@type":"ImageObject","contentUrl":"https://doctorak.com/assets/frontend/images/general/doctorak_default_logo_img.png","url":"https://doctorak.com/assets/frontend/images/general/doctorak_default_logo_img.png","caption":""},"name":"{{trans('general.medicines_directory')}}","description":"@if( isset($category) && $category) {{$category->name}} @elseif ($scientific_name_1_title) {{$scientific_name_1_title->name}}  @elseif ($medicines_company_ar) $medicines_company_ar->name @endif - {{trans('general.medicines_directory')}}"}]</script>
@endsection
