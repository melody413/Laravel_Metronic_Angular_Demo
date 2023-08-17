@extends('frontend.master')

@section('content')
    <section class="inner_container unit insurance_company_unit">
        <div class="container">
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
                @elseif ($category)
                    @include('frontend.partials.breadcrumb', [
                        'breadcrumb' => [
                            trans('general.home') => route('frontend.home'),
                            trans('general.medicines_directory').' '.trans('general.in').' '.$country => route('frontend.medicine.index'),
                            $category->name => route('frontend.medicine.index') . '?category=' . $category->id,
                        ]
                    ])
                @else
                    @include('frontend.partials.breadcrumb', [
                        'breadcrumb' => [
                            trans('general.home') => route('frontend.home'),
                            trans('general.medicines_directory').' '.trans('general.in').' '.$country => route('frontend.medicine.index'),
                            //$categories->first()->name => route('frontend.medicine.index') . '?category=' . $categories->first()->id,
                            $row->name => route('frontend.medicine.unit', ['id'=>$row->id]) ,
                        ]
                    ])
                @endif
            @unit_block(['row' => $row ,'imagePath' => 'medicines/', 'withAddress' => false, 'categories'=> $categories, 'country_code' => $country_code,
                'medicines_company_ar'=> $medicines_company_ar, 'medicines_company_en'=> $medicines_company_en, 'currency_code'=> $currency_code,
                'medicines_sc_name_1_ar'=> $medicines_sc_name_1_ar, 'medicines_sc_name_2_ar'=> $medicines_sc_name_2_ar, 'medicines_sc_name_3_ar'=> $medicines_sc_name_3_ar,
                'medicines_sc_name_1_en'=> $medicines_sc_name_1_en, 'medicines_sc_name_2_en'=> $medicines_sc_name_2_en, 'medicines_sc_name_3_en'=> $medicines_sc_name_3_en])
            @endunit_block

            <h5>{{ trans('general.services_tags') }}</h5>
                    @php $tags_ar=''; $tags_en=''; @endphp
                    @if($row->tags_ar)
                        @php $tags_arr = explode(',', $row->tags_ar); @endphp
                        @foreach ( $tags_arr as $tg)
                            <a href="{{ route('frontend.medicine.index') . '?medicine_category=' . $medicine_categories_tags[0] . '&tag=' . $tg}}">
                                <span style="color: #fff" class="badge badge-primary">
                                    @if( is_numeric($tg) ) {{\App\Models\Tag::find($tg)->name}} @else {{$tg}} @endif
                                </span>
                            </a>
                        @endforeach
                    @else
                        @foreach ($tags as $tag_s)
                            @foreach ($tag_s->medicine_categories()->whereIn('medicines_category_id', $categories)->get() as $tg)
                            {{dd($tg)}}
                                <a href="{{ route('frontend.medicine.index') . '?medicine_category=' . $categories[0] . '&tag=' . $tg->pivot->tag_id}}">
                                    <span style="color: #fff" class="badge badge-primary">
                                        {{\App\Models\Tag::find($tg->pivot->tag_id)->name}}
                                        @php $tags_ar .=  $tg->pivot->tag_id . ","; @endphp
                                        @php $tags_en .=  $tg->pivot->tag_id . ","; @endphp
                                    </span>
                                </a>
                            @endforeach
                        @endforeach
                        @php
                            $new_tags_ar = rtrim($tags_ar, ",");
                            $new_tags_en = rtrim($tags_en, ",");
                            DB::table('medicines')
                                ->where('id', $row->id)
                                ->update(['tags_ar' => $new_tags_ar, 'tags_en' => $new_tags_en]);
                        @endphp
                    @endif
                    <hr>
            <h3>{{ trans('general.related_medicines') }}</h3>
            <hr>
            <div class="row">
            @foreach ($related_medicines as $key => $related_medicine)
                <div class="list-group col-md-6"  @if($key == 4) hidden @endif>
                    <a href="{{ route('frontend.medicine.unit', ['id'=>$related_medicine->id])}}" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1" itemprop="relatedDrug">{{$related_medicine->name}}</h5>
                            <small>{{$related_medicine->price .' '. trans('general.egp') }}</small>
                        </div>
                        @if(\App\Models\MedicinesCompany::find($related_medicine->company))
                            <p class="mb-1"><strong><i class="fas fa-building"></i> {{ trans('general.company') }}: </strong> {{\App\Models\MedicinesCompany::find($related_medicine->company)->name}}</p>
                        @endif
                        <small>{{$related_medicine->excerpt}}</small>
                    </a>
                </div>
            @endforeach
            </div>
        </div>
        
    </section>
    <script type="application/ld+json">
        [{"@context":"http://schema.org/","@type":"MedicalWebPage","@id":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}","url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}"
        ,"audience":{"@context":"https://schema.org","@type":"medicalAudience","audienceType":["Patient"]}
        ,"publisher":{"@context":"http://schema.org/","@type":"Organization","@id":"https://www.doctorak.com/","name":"Doctorak.com"
        ,"url":"https://www.doctorak.com","logo":{"@context":"http://schema.org","@type":"ImageObject","url":"https://www.doctorak.com/img/logo/schema/drugscom-logomark-112x112.png","width":112,"height":112}}
        ,"image":{"@type":"ImageObject","contentUrl":"https://doctorak.com/assets/frontend/images/general/doctorak_default_logo_img.png"
        ,"url":"https://doctorak.com/assets/frontend/images/general/doctorak_default_logo_img.png","caption":"{{$row->name}} "}
        ,"about":{"@type":"Drug","@id":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}#{{$row->name}}","name":"{{$row->name}}"
        ,"image":{"@type":"ImageObject","contentUrl":"https://doctorak.com/assets/frontend/images/general/doctorak_default_logo_img.png"
        ,"url":"https://doctorak.com/assets/frontend/images/general/doctorak_default_logo_img.png","caption":"{{$row->name}} "}}
        ,"name":"{{$row->name}}","description":"{!!$row->description!!}"}
        ]</script>
{{-- 
        [{"@context":"http://schema.org/","@type":"MedicalWebPage","@id":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}","url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}"
        ,"audience":{"@context":"https://schema.org","@type":"medicalAudience","audienceType":["Patient"]}
        ,"publisher":{"@context":"http://schema.org/","@type":"Organization","@id":"https://www.doctorak.com/","name":"Doctorak.com"
        ,"url":"https://www.doctorak.com","logo":{"@context":"http://schema.org","@type":"ImageObject","url":"https://www.doctorak.com/img/logo/schema/drugscom-logomark-112x112.png","width":112,"height":112}}
        ,"image":{"@type":"ImageObject","contentUrl":"https://doctorak.com/assets/frontend/images/general/doctorak_default_logo_img.png"
        ,"url":"https://doctorak.com/assets/frontend/images/general/doctorak_default_logo_img.png","caption":"{{$row->name}} "}
        ,"about":{"@type":"Drug","@id":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}#{{$row->name}}","name":"{{$row->name}}"
        /*,"nonProprietaryName":"aripiprazole"
        ,"pregnancyCategory":"http://schema.org/FDAcategoryC","pregnancyWarning":"Risk cannot be ruled out"
        ,"prescriptionStatus":"http://schema.org/PrescriptionOnly"*/
        ,"image":{"@type":"ImageObject","contentUrl":"https://doctorak.com/assets/frontend/images/general/doctorak_default_logo_img.png"
        ,"url":"https://doctorak.com/assets/frontend/images/general/doctorak_default_logo_img.png","caption":"{{$row->name}} "}}
        ,"name":"{{$row->name}}","description":"{!!$row->description!!}"}
        /*,{"@context":"https://schema.org","@graph":[{"@context":"http://schema.org/","@type":"SiteNavigationElement","name":"Overview"
        ,"url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}"},{"@context":"http://schema.org/","@type":"SiteNavigationElement","name":"Side Effects","url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}#what_side_effects"}
        ,{"@context":"http://schema.org/","@type":"SiteNavigationElement","name":"Dosage","url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}#used_to"}
        ,{"@context":"http://schema.org/","@type":"SiteNavigationElement","name":"Professional","url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}#Professional"}
        ,{"@context":"http://schema.org/","@type":"SiteNavigationElement","name":"Tips","url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}#what_doses"}
        ,{"@context":"http://schema.org/","@type":"SiteNavigationElement","name":"Interactions","url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}#scientific_name"}
        ,{"@context":"http://schema.org/","@type":"SiteNavigationElement","name":"Pregnancy Warnings","url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}#Warnings"}
        ,{"@context":"http://schema.org/","@type":"SiteNavigationElement","name":"Breastfeeding Warnings","url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}#breastfeedingWarnings"}
        ,{"@context":"http://schema.org/","@type":"SiteNavigationElement","name":"Drug Images","url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}#image"}
        ,{"@context":"http://schema.org/","@type":"SiteNavigationElement","name":"Support Group Q & A","url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}#faq"}
        ,{"@context":"http://schema.org/","@type":"SiteNavigationElement","name":"Compare Alternatives","url":"{{route('frontend.medicine.unit', ['id'=>$row->id])}}#Alternatives"}]}*/]</script> --}}

@endsection
