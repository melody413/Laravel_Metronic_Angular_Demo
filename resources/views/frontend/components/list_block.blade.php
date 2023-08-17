

<div class="item {{ $row->is_reserve ? "has_booking" : "hasnt_booking" }}"  >
    {{-- itemscope @if(isset($routeKey) && $routeKey == 'medicine') itemtype="https://schema.org/Drug" @elseif(isset($view) && $view == 'DOCTOR') itemtype="http://schema.org/Physician" @else itemtype="http://schema.org/MedicalOrganization" @endif --}}
    <div class="row">
        <div class=" @if( isset($routeKey) && $routeKey == 'lab_service') col-md-12 @else col-md-2 @endif ">
            <div class="face">
                <a href="{{ route('frontend.'.$routeKey.'.unit', ['id'=>$row->id]) }}" title="{{ $row->name }}">
                    <div class="img_frame">
                        {!! img_tag([
                                'path' => $imagePath,
                                'src' => $row->image,
                                'alt' => $row->name
                        ]); !!}
                    </div>
                    @if( isset($routeKey) && $routeKey == 'lab_service') <h6 itemprop="name">{{ ucfirst($row->name) }}</h6>@endif
                    <span>{{ trans('general.details') }}</span>
                </a>
            </div>
        </div>
        <?php //dd($row->address) ?>
        <div class="col-md" @if( isset($routeKey) && $routeKey == 'lab_service') hidden @endif>
            <div class="data">
                <div class="metas">
                    <h2>
                        <a href="{{ route('frontend.'. $routeKey .'.unit', ['id'=>$row->id]) }}" itemprop="name">
                            @if( isset($view) && $view == 'DOCTOR'){{ trans('general.dr') }} @endif 
                            @if( isset($view) && $view == 'Hospital' && (\App::getLocale()=='ar')){{ trans('general.hospital') }} @endif 
                            @if( isset($routeKey) && $routeKey == 'center' && (\App::getLocale()=='ar')){{ trans('general.center') }} @endif 
                            @if( isset($routeKey) && $routeKey == 'pharmacy' && (\App::getLocale()=='ar')){{ trans('general.pharmacy') }} @endif 
                            @if( isset($routeKey) && $routeKey == 'lab' && (\App::getLocale()=='ar')){{ trans('general.lab') }} @endif 

                            @if( isset($routeKey) && $routeKey != 'lab_service') {{ ucfirst($row->name) }}@endif

                            @if( isset($view) && $view == 'Hospital' && (\App::getLocale()=='en')){{ trans('general.hospital') }} @endif 
                            @if( isset($routeKey) && $routeKey == 'center' && (\App::getLocale()=='en')){{ trans('general.center') }} @endif 
                            @if( isset($routeKey) && $routeKey == 'pharmacy' && (\App::getLocale()=='en')){{ trans('general.pharmacy') }} @endif 
                            @if( isset($routeKey) && $routeKey == 'lab' && (\App::getLocale()=='en')){{ trans('general.lab') }} @endif 
                        </a>
                    </h2>
                    @if($row->title && isset($routeKey) && $routeKey != 'lab_service' )
                        <span itemprop="title">{{ ucfirst($row->title) }}</span>
                    @endif
                    <p itemprop="subjectOf">{{ $row->excerpt }}</p>
                    @if( isset($routeKey) && $routeKey == 'medicine')
                    {{ trans('general.use_to') }}
                    <?php 
                        $cats = (explode(",",$row->category));
                        $categories = \App\Models\MedicinesCategory::where('is_active' , 1)->whereIn('id', $cats)->orderBy('id', 'desc')->get();
                    ?>
                    @foreach ($categories as $collection)
                    <a href="{{ route('frontend.medicine.index') . '?category=' .$collection->id. '&country='.$row->country_id }}" >
                        {{ $collection->name }} 
                    </a><span class="comma">،</span>
                    @endforeach <br>
                        {{ $row->disease_ar }} 
                        @if($row->form)<p class="vote" itemprop="dosageForm"><strong><i class="fas fa-weight"></i> {{ trans('general.form') }}: </strong> 
                            @if(app()->getLocale() == "ar")
                                @if($row->form == "Tablets") اقراص @elseif ($row->form == "Capsule") كبسولات 
                                @elseif ($row->form == "Ampoules") أمبول @elseif ($row->form == "Syrup") شراب 
                                @elseif ($row->form == "Cream") كريم @elseif ($row->form == "Sachets") اكياس 
                                @elseif ($row->form == "Lotion") لوشن @elseif ($row->form == "Drops") قطرة 
                                @elseif ($row->form == "Antiseptic_Solution") محلول مطهر @elseif ($row->form == "Infant_Milk") لبن اطفال 
                                @elseif ($row->form == "Mouth_Wash") غسول فم @elseif ($row->form == "Tea_bag") أكياس شاي 
                                @elseif ($row->form == "Powder") بودرة @elseif ($row->form == "Infusion") محلول معلق 
                                @elseif ($row->form == "Inhalation") بخاخة للصدر @elseif ($row->form == "Hair_Oil") زيت شعر 
                                @elseif ($row->form == "Lozenges") استحلاب @elseif ($row->form == "Oral_Drops") قطرة فم 
                                @elseif ($row->form == "Vial") امبول @elseif ($row->form == "Suppository") لبوس 
                                @elseif ($row->form == "Vag.Douch") دش مهبلي @elseif ($row->form == "Syringe") حقنه  @endif
                            @else
                                {{ $row->form }}
                            @endif
                        </p>@endif
                    @endif 

                </div>
                <div class="specs">
                    <ul>
                        @if($routeKey == "doctor")
                            <span id="more-subs{{$row->id}}" class="subs">@if( isset($view) && $view == 'DOCTOR' && $speciality){{ trans('general.dr') }} 
                                <a itemprop="affiliation" href="{{ route('frontend.'. $routeKey .'.index') . '?speciality=' . $speciality->id . '&city=' . $row->city->id}}">
                                    {{ $speciality->name }}
                                </a>{{ trans('general.in_specialty') }}
                                @php $status=1; $sub_cats_ar=''; $sub_cats_en=''; @endphp

                                @if($row->sub_cats_ar)
                                    @php $sub_cats_arr = explode(',', $row->sub_cats_ar); @endphp
                                    @foreach ( $sub_cats_arr as $scs)
                                        @if( is_numeric($scs) ) 
                                            <a itemprop="additionalName" href="{{ route('frontend.'. $routeKey .'.index') . '?speciality=' . $speciality->id . '&sub_cat=' .$scs. '&city=' . $row->city->id }}@if($row->area)&area={{$row->area->id}}@endif" title="احسن دكتور في @if( is_numeric($scs) ) {{\DB::table('sub_category_trans')->where("sub_category_id",$scs)->first()->name}}  @endif">
                                                {{\DB::table('sub_category_trans')->where("sub_category_id",$scs)->first()->name}} 
                                            </a> <span class="comma">،</span>  
                                        @endif
                                    @endforeach
                                @endif
                                @endif</span>
                            @if($row->sub_cats_ar && $speciality)
                                <span id="more{{$row->id}}" class="text-right" onclick="moreSubs({{$row->id}})"> المزيد 
                                </span>
                            @endif 
                        @endif

                        @if($routeKey == "hospital")
                            <span id="more-subs{{$row->id}}" class="subs">
                                @if( isset($view) && $view == 'Hospital' && $speciality) {{ trans('general.specialty') }}
                                <a itemprop="affiliation" href="{{ route('frontend.'. $routeKey .'.index') . '?speciality=' . $speciality->id . '&city=' . $row->city->id}}">
                                    {{ $speciality->name }}
                                </a>, 
                                @php $status=1; $sub_cats_ar=''; $sub_cats_en=''; @endphp

                                @if($row->sub_cats_ar)
                                    @php $sub_cats_arr = explode(',', $row->sub_cats_ar); @endphp
                                    @foreach ( $sub_cats_arr as $scs)
                                        <a href="{{ route('frontend.'. $routeKey .'.index') . '?speciality=' . $speciality->id . '&sub_cat=' .$scs. '&city=' . $row->city->id }}@if($row->area)&area={{$row->area->id}}@endif" title="احسن دكتور في @if( is_numeric($scs)  ) {{\DB::table('sub_category_trans')->where("sub_category_id",$scs)->first()->name}}  @endif">
                                            @if( is_numeric($scs)  ) {{\DB::table('sub_category_trans')->where("sub_category_id",$scs)->first()->name}}  @endif
                                        </a> <span class="comma">،</span>
                                    @endforeach
                                @else
                                  @foreach (\App\Models\SpecialtySubCategory::where('specialty_id', $speciality->id)->get() as $subcat)
                                    @if(isset(\App\Models\SubCategory::where('id', $subcat->sub_category_id)->first()->name))
                                        @php $status+=1; 
                                        $sub_cats_ar .=  $subcat->sub_category_id . ",";
                                        $sub_cats_en .=  $subcat->sub_category_id . ",";
                                        @endphp
                                        <a href="{{ route('frontend.'. $routeKey .'.index') . '?speciality=' . $speciality->id . '&sub_cat=' .\App\Models\SubCategory::where('id', $subcat->sub_category_id)->first()->id. '&city=' . $row->city->id }}@if($row->area) &area={{$row->area->id}} @endif" title="احسن دكتور في {{ \App\Models\SubCategory::where('id', $subcat->sub_category_id)->first()->name }}">
                                            {{ \App\Models\SubCategory::where('id', $subcat->sub_category_id)->first()->name }}
                                        </a> <span class="comma">،</span>
                                    @endif
                                    @if($status == 15)
                                        @break
                                    @endif
                                  @endforeach
                                    @php
                                        $new_sub_cats_ar = rtrim($sub_cats_ar, ",");
                                        $new_sub_cats_en = rtrim($sub_cats_en, ",");
                                        DB::table('hospitals')
                                        ->where('id', $row->id)
                                        ->update(['sub_cats_ar' => $new_sub_cats_ar, 'sub_cats_en' => $new_sub_cats_en]);
                                    @endphp
                                @endif
                                @endif</span>
                                @if($row->sub_cats_ar && $speciality)
                                    <span id="more{{$row->id}}" class="text-right" onclick="moreSubs({{$row->id}})"> المزيد 
                                    </span>
                                @endif
                        @endif
                        @if($routeKey == "center")
                        <span id="more-subs{{$row->id}}" class="subs">
                            @if( $speciality) {{ trans('general.specialty') }}
                            <a itemprop="affiliation" href="{{ route('frontend.'. $routeKey .'.index') . '?speciality=' . $speciality->id . '&city=' . $row->city->id}}">
                                {{ $speciality->name }}
                            </a>{{ trans('general.in_specialty') }}

                            @php $status=1; $sub_cats_ar=''; $sub_cats_en=''; @endphp

                            @if($row->sub_cats_ar)
                                @php $sub_cats_arr = explode(',', $row->sub_cats_ar); @endphp
                                @foreach ( $sub_cats_arr as $scs)
                                    <a href="{{ route('frontend.'. $routeKey .'.index') . '?speciality=' . $speciality->id . '&sub_cat=' .$scs. '&city=' . $row->city->id }}@if($row->area)&area={{$row->area->id}}@endif" title="احسن دكتور في @if( is_numeric($scs)  ) {{\DB::table('sub_category_trans')->where("sub_category_id",$scs)->first()->name}}  @endif">
                                        @if( is_numeric($scs)  ) {{\DB::table('sub_category_trans')->where("sub_category_id",$scs)->first()->name}}  @endif
                                    </a> <span class="comma">،</span>
                                @endforeach
                            @else
                              @foreach (\App\Models\SpecialtySubCategory::where('specialty_id', $speciality->id)->get() as $subcat)
                                @if(isset(\App\Models\SubCategory::where('id', $subcat->sub_category_id)->first()->name))
                                    @php $status+=1; 
                                    $sub_cats_ar .=  $subcat->sub_category_id . ",";
                                    $sub_cats_en .=  $subcat->sub_category_id . ",";
                                    @endphp
                                    <a href="{{ route('frontend.'. $routeKey .'.index') . '?speciality=' . $speciality->id . '&sub_cat=' .\App\Models\SubCategory::where('id', $subcat->sub_category_id)->first()->id. '&city=' . $row->city->id }}@if($row->area) &area={{$row->area->id}} @endif" title="احسن دكتور في {{ \App\Models\SubCategory::where('id', $subcat->sub_category_id)->first()->name }}">
                                        {{ \App\Models\SubCategory::where('id', $subcat->sub_category_id)->first()->name }}
                                    </a> <span class="comma">،</span>
                                @endif
                                @if($status == 15)
                                    @break
                                @endif
                              @endforeach
                                @php
                                    $new_sub_cats_ar = rtrim($sub_cats_ar, ",");
                                    $new_sub_cats_en = rtrim($sub_cats_en, ",");
                                    DB::table('centers')
                                    ->where('id', $row->id)
                                    ->update(['sub_cats_ar' => $new_sub_cats_ar, 'sub_cats_en' => $new_sub_cats_en]);
                                @endphp
                            @endif
                            @endif</span>
                            @if($row->sub_cats_ar && $speciality)
                                <span id="more{{$row->id}}" class="text-right" onclick="moreSubs({{$row->id}})"> المزيد 
                                </span>
                            @endif 
                    @endif
                        @if(isset($row->city))
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                @if($routeKey == "doctor")
                                    @if(isset($row->address->first()->translations[0]->address))
                                        <span>{{  is_string($row->address)? $row->address :$row->address->first()->translations[0]->address }}</span>
                                    @endif
                                @else
                                    @if(isset($row->address) && $row->address)
                                        <span>{{  is_string($row->address)? $row->address :$row->address->first()->translations[0]->address }}</span>
                                    @endif
                                @endif
                                 | 
                                <span>
                                    <a href="{{ route('frontend.'. $routeKey .'.index') . '?city=' . $row->city->id }}@if(isset($speciality)){{'&speciality=' . $speciality->id}} @endif ">
                                        {{ $row->city->translations[0]->name }}
                                    </a>
                                </span>
                                @if( isset($row->area) && $row->area)
                                    - <span>
                                        <a href="{{ route('frontend.'. $routeKey .'.index') . '?area=' . $row->area->id . '&city=' . $row->city->id}}@if(isset($speciality)){{'&speciality=' . $speciality->id}} @endif ">
                                            {{ $row->area->name }}
                                        </a>
                                    </span>
                                @endif
                            </li>
                        @endif

                        @isset($row->rate)
                            @if ($row->rate_cnt > 0)
                                <li>
                                    <ul class="list_rates">
                                        @for($i= 0; $i<$row->rate; $i++)
                                            <li><i class="fas fa-star"></i></li>
                                        @endfor
                                        @for($i=$row->rate; $i<5; $i++)
                                            <li><i class="far fa-star"></i></li>
                                        @endfor
                                        <li class="goto_reviews"><a href="{{ route('frontend.'. $routeKey .'.unit', ['id'=>$row->id]) }}#topping_content">{{ trans('general.see_all_reviews') }}</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endisset
                        {{--
                        @if($row->phone)
                            <li>
                                <i class="fas fa-phone"></i>
                                <span>{{ $row->phone }}</span>
                            </li>
                        @endif
                        --}}
                        @if ( $row->open_hours )
                            <li>
                                <i class="fas fa-clock"></i>
                                <span class="opened">{{ trans('general.open') }}: {{ $row->open_hours }} {{ trans('general.h') }}</span>
                            </li>
                        @endif
                        @if ( $row->price )
                            <li>
                                <i class="fas fa-tag"></i>
                                <span>{{ $row->price }} {{ trans('general.egp') }}</span>
                            </li>
                        @endif
                        @if ( $row->wait_time )
                            <li>
                                <i class="fas fa-clock"></i>
                                <span>{{ trans('general.waiting_time') }}: {{ $row->wait_time }} {{ trans('general.minutes') }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        @if(get_option('doctor_reservation'))
            @if(isset($reserve)) {!! $reserve !!} @endif
        @endif
    </div>
</div>
<script>
function moreSubs(x) {
  var element = document.getElementById("more-subs"+x);
  element.classList.toggle("subs");
  var element = document.getElementById("more"+x);
  element.classList.add("hidden");
}
</script>
