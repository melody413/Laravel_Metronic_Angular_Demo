
{{--
 $row: unit data
 $imagePath: path to images
 $topping :  tabs and unit other data
 $withAddress: show address block
 $showcase: blocks after address block
--}}

<?php
    preg_match('/([a-z]*)@/i', request()->route()->getActionName(), $matches);
    $controllerName = $matches[1];
    $methodName  = explode("@", request()->route()->getActionName())[1];
?>
<div class="row">
    <div class="@if( isset($controllerName) && $controllerName == 'MedicineController') col-md-12
        @elseif( isset($controllerName) && $controllerName == 'LabServiceController') col-md-12
        @else col-md-8 @endif">
        <div class="unit_content">
            <div class="identity">
                {!! img_tag([
                    'path' => $imagePath,
                    'src' => $row->image,
                    'alt' => $row->name,
                    'title' => $row->name,
                    'itemprop' => "url"
                    ]); !!}
            </div>
            <div class="data_set @if(isset($controllerName) && $controllerName != 'MedicineController') text-center @else text-left @endif"
            @if(isset($controllerName) && $controllerName == 'MedicineController') itemtype="https://schema.org/Drug" @endif >
                <h1 itemprop="name" class="@if(isset($controllerName) && $controllerName != 'MedicineController') text-center @else text-left @endif">@if( isset($view) && $view == 'DOCTOR' )
                        @if(basename($_SERVER['REQUEST_URI']) == 'address' ) {{ trans('general.address') }} @endif
                        @if(basename($_SERVER['REQUEST_URI']) == 'phone' ) {{ trans('general.phones') }} @endif
                        {{ trans('general.dr') }}
                    @elseif( isset($controllerName) && $controllerName == 'HospitalController' || $controllerName == 'CenterController')
                        @if(basename($_SERVER['REQUEST_URI']) == 'address' ) {{ trans('general.address') }} @endif
                        @if(basename($_SERVER['REQUEST_URI']) == 'phone' ) {{ trans('general.phones') }} @endif
                        @if(basename($_SERVER['REQUEST_URI']) == 'doctors' ) {{ trans('general.doctorsbest') }} @endif
                        @if(basename($_SERVER['REQUEST_URI']) == 'doctors_names' ) {{ trans('general.doctors_names') }} @endif
                        @if(basename($_SERVER['REQUEST_URI']) == 'categories' ) {{ trans('general.categories') }} @endif
                        @if(basename($_SERVER['REQUEST_URI']) == 'outpatient_clinics' ) {{ trans('general.outpatient_clinics') }} @endif
                        @if(basename($_SERVER['REQUEST_URI']) == 'clinics' ) {{ trans('general.clinics') }} @endif
                        @if( isset($controllerName) && $controllerName == 'CenterController'&& (\App::getLocale()=='ar'))
                            {{ trans('general.center') }}
                        @elseif( isset($controllerName) && $controllerName == 'HospitalController'&& (\App::getLocale()=='ar'))
                            {{ trans('general.hospital') }}
                        @endif
                    @elseif( isset($controllerName) && $controllerName == 'PharmacyController' && (\App::getLocale()=='ar')){{ trans('general.pharmacy') }}
                    @elseif( isset($controllerName) && $controllerName == 'LabController' && (\App::getLocale()=='ar')){{ trans('general.lab') }}
                    @endif
                    {{ ucfirst($row->name) }}
                    @if( isset($controllerName) && $controllerName == 'CenterController'&& (\App::getLocale()=='en'))
                            {{ trans('general.center') }}
                    @elseif( isset($controllerName) && $controllerName == 'HospitalController'&& (\App::getLocale()=='en'))
                        {{ trans('general.hospital') }}
                    @elseif( isset($controllerName) && $controllerName == 'PharmacyController' && (\App::getLocale()=='en')){{ trans('general.pharmacy') }}
                    @elseif( isset($controllerName) && $controllerName == 'LabController' && (\App::getLocale()=='en')){{ trans('general.lab') }}
                    @endif
                </h1><br>
                @if(isset($controllerName) && $controllerName == 'MedicineController')
                    <h5 itemprop="alternateName">
                        @if ((\App::getLocale()=='en'))
                            {{\DB::table('medicine_trans')->where("medicine_id",$row->id)->where("locale", "ar")->first()->name}}</h5>
                        @else
                            {{\DB::table('medicine_trans')->where("medicine_id",$row->id)->where("locale", "en")->first()->name}}</h5>
                        @endif
                    <h6 class="@if(isset($controllerName) && $controllerName != 'MedicineController') text-center @else text-left @endif">{{ ucfirst($row->excerpt) }}</h6>
                    @if($row->category)
                        <span id="category" class="text-header mt-1">{{ trans('general.category') }}:</span>
                        <span class="product-description">
                            {{ trans('general.use_to') }}
                            @foreach ($categories as $collection)
                            <a href="{{ route('frontend.medicine.index') . '?category=' .$collection->id. '&country='.$row->country_id }}" >
                                {{ $collection->name }} 
                            </a><span class="comma">،</span>
                            @endforeach
                        </span>
                    @endif
                    <br>
                    @if($row->concentration)
                        <span id="what_concentration" class="text-header mt-1">{{ trans('general.concentration') }}:</span>
                        <span class="">
                            <span class="vote">@if($row->concentration)<strong><i class="fas fa-weight"></i> </strong> {{ $row->concentration.$row->conc_type }}@endif
                                @if($row->concentration_2) , {{ $row->concentration_2.$row->conc_type }}@endif
                                @if($row->concentration_3) , {{ $row->concentration_3.$row->conc_type }}@endif 
                            </span>                            
                        </span>
                    @endif  
                @else
                    <h6 class="text-center font-weight-bold">{{ $row->title }} </h6>
                @endif

                @if( isset($controllerName) && is_numeric(basename($_SERVER['REQUEST_URI'])) && $controllerName == 'DoctorController' || $controllerName == 'HospitalController' 
                || $controllerName == 'CenterController' && $specialty->first())
                    @if($controllerName != 'HospitalController' && $controllerName != 'CenterController' && \App\Models\Specialty::find($specialty->first()))
                        {{ trans('general.dr') }} 
                        <a href="{{ route(str_replace("unit", "index", \Request::route()->getName())) . '?speciality=' . $specialty->first() . '&city=' . $row->city->id}}">
                            {{ \App\Models\Specialty::find($specialty->first())->name }}
                        </a>
                    @endif
                    {{ trans('general.in_specialty') }}
                    @if($controllerName == 'HospitalController' && \App\Models\Specialty::find($specialty->first()))
                    @php $status=1; $sub_cats_ar=''; $sub_cats_en=''; @endphp
                        @if($row->sub_cats_ar)
                            @php $sub_cats_arr = explode(',', $row->sub_cats_ar); @endphp
                            @foreach ( $sub_cats_arr as $scs)
                                <a href="{{ route('frontend.hospital.index') . '?speciality=' . $specialty->first() . '&sub_cat=' .$scs. '&city=' . $row->city->id }}@if($row->area)&area={{$row->area->id}}@endif" title="احسن مشتشفى في @if( is_numeric($scs) && \App\Models\SubCategory::find($scs) ) {{\DB::table('sub_category_trans')->where("sub_category_id",$scs)->first()->name}}  @endif">
                                    @if( is_numeric($scs) ) {{\DB::table('sub_category_trans')->where("sub_category_id",$scs)->first()->name}}  @endif
                                </a>
                                @if(next($sub_cats_arr) && is_numeric($scs)) 
                                    <span class="comma">،</span>
                                @endif
                            @endforeach
                        @endif

                    @else
                        @if($row->sub_cats_ar)
                            @php $sub_cats_arr = explode(',', $row->sub_cats_ar); @endphp
                            @foreach ( $sub_cats_arr as $scs)
                                <a href="{{ route(str_replace("unit", "index", \Request::route()->getName())) . '?speciality=' . $specialty->first() . '&sub_cat=' .$scs. '&city=' . $row->city->id }}@if($row->area)&area={{$row->area->id}}@endif" title="احسن دكتور في @if( is_numeric($scs) && \App\Models\SubCategory::find($scs) ) {{\DB::table('sub_category_trans')->where("sub_category_id",$scs)->first()->name}}  @endif">
                                    @if( is_numeric($scs) ) {{\DB::table('sub_category_trans')->where("sub_category_id",$scs)->first()->name}}  @endif
                                </a>
                                @if(next($sub_cats_arr) && is_numeric($scs)) 
                                    <span class="comma">،</span>
                                @endif
                            @endforeach
                        @endif
                    @endif
                @endif

                {{-- @if( isset($controllerName) && $controllerName == 'MedicineController' )
                    <div class="col-sm-12 text-center">
                        @if($row->category)
                            @foreach ($categories as $category)
                                <a href="{{ route('frontend.medicine.index') . '?category=' .$category. '&country='.$row->country_id }}" >
                                    @if( is_numeric($category) ) {{\DB::table('medicines_category_trans')->where("medicines_category_id",$category)->first()->name}}  @endif
                                </a>
                                <span class="comma">،</span>
                            @endforeach

                        @endif
                        @if(is_numeric($row->category_2)) 
                            <span class="comma">،</span>
                            <a href="{{ route('frontend.medicine.index') . '?category=' .$row->category_2. '&country='.$row->country_id }}" >
                                @if( is_numeric($row->category_2) ) {{\DB::table('medicines_category_trans')->where("medicines_category_id",$row->category_2)->first()->name}}  @endif
                            </a>
                        @endif
                        @if(is_numeric($row->category_3)) 
                            <span class="comma">،</span>
                            <a href="{{ route('frontend.medicine.index') . '?category=' .$row->category_3. '&country='.$row->country_id }}" >
                                @if( is_numeric($row->category_3) ) {{\DB::table('medicines_category_trans')->where("medicines_category_id",$row->category_3)->first()->name}}  @endif
                            </a>
                        @endif
                    </div>
                @endif --}}

                @if(isset($titlePlus))
                    <div class="title_pluse">
                        <span>{{ $titlePlus }}</span>
                    </div>
                @endif


                @if( isset($controllerName) && $controllerName == 'LabServiceController' )
                    <div class="row">
                        <div class="col-lg-6 col-md-12 list-group">
                            <a href="#about_test" class="titles list-group-item">{{ trans('general.about_test') }} {{ $row->name }}</a>
                            <a href="#used_to" class="titles list-group-item">{{ trans('general.used_to') }} {{ $row->name }}</a>
                            <a href="#reasons_for" class="titles list-group-item">{{ trans('general.reasons_for') }} {{ $row->name }}</a>
                            <a href="#how_is" class="titles list-group-item">{{ trans('general.how_is') }} {{ $row->name }}</a>
                            <a href="#how_prepare" class="titles list-group-item">{{ trans('general.how_prepare') }} {{ $row->name }}</a>
                            <a href="#risks" class="titles list-group-item">{{ trans('general.risks') }} {{ $row->name }}</a>
                            <a href="#interpretation_result" class="titles list-group-item">{{ trans('general.interpretation_result') }} {{ $row->name }}</a>
                            <a href="#reasons_high_reading" class="titles list-group-item">{{ trans('general.reasons_high_reading') }} {{ $row->name }}</a>
                            <a href="#references" class="titles list-group-item">{{ trans('general.references') }} {{ $row->name }}</a>
                        </div>
                        <div class="col-6 table-wrapper text-center">
                            <table class="table table-striped text-center">
                                <tbody>
                                    <tr class="table-header">
                                        <th class="lab-definition-header font-medium">{{ trans('general.test_type') }}</th>
                                        <th class="lab-definition-header font-bold">{{ trans('general.details') }}</th>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('general.sample') }}</td>
                                        <td>{{ $row->sample }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('general.normal_range') }}</td>
                                        <td>{{ $row->normal_range }}</td>
                                    </tr>
                                    <tr itemprop="normalRange">
                                        <td>{{ trans('general.measruing_unit') }}</td>
                                        <td>{{ $row->measruing_unit }}</td>
                                    </tr>
                                    <tr itemprop="normalRange">
                                        <td>{{ trans('general.measruing_unit_female') }}</td>
                                        <td>{{ $row->measruing_unit_female }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <hr>
                        <h4 id="about_test" class="text-header mt-1">{{ trans('general.about_test') }} {{ $row->name }}</h4>
                        <div class="text-desc">{!! $row->about_test !!}</div>
                        <hr>
                        <h4 id="used_to" class="text-header mt-1">{{ trans('general.used_to') }} {{ $row->name }}</h4>
                        <div class="text-desc">{!! $row->used_to !!}</div>
                        <hr>
                        <h4 id="reasons_for" class="text-header mt-1">{{ trans('general.reasons_for') }} {{ $row->name }}</h4>
                        <div class="text-desc">{!! $row->reasons_for !!}</div>
                        <hr>
                        <h4 id="how_is" class="text-header mt-1">{{ trans('general.how_is') }} {{ $row->name }}</h4>
                        <div class="text-desc">{!! $row->how_is !!}</div>
                        <hr>
                        <h4 id="how_prepare" class="text-header mt-1">{{ trans('general.how_prepare') }} {{ $row->name }}</h4>
                        <div class="text-desc">{!! $row->how_prepare !!}</div>
                        <hr>
                        <h4 id="risks" class="text-header mt-1">{{ trans('general.risks') }} {{ $row->name }}</h4>
                        <div class="text-desc">{!! $row->risks !!}</div>
                        <hr>
                        <h4 id="interpretation_result" class="text-header mt-1">{{ trans('general.interpretation_result') }} {{ $row->name }}</h4>
                        <div class="text-desc">{!! $row->interpretation_result !!}</div>
                        <hr>
                        <h4 id="reasons_high_reading" class="text-header mt-1">{{ trans('general.reasons_high_reading') }} {{ $row->name }}</h4>
                        <div class="text-desc">{!! $row->reasons_high_reading !!}</div>
                        <hr>
                        <h4 id="references" class="text-header mt-1">{{ trans('general.references') }} {{ $row->name }}</h4>
                        <div class="text-desc">{!! $row->references !!}</div>
                    </div>
                @endif

                @if(isset($controllerName) && $controllerName == 'MedicineController')
                    <div class="details" @if(app()->getLocale() == "en") style="text-align: left;" @endif>
                        <!-- <h3 class="product-title">{{ ucfirst($row->name) }}</h3> -->
                        {{-- <div class="rating hidden">
                            <div class="stars">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                        </div> --}}
                        <div class="col-sm-12">
                            
                            <div class="col-sm-12 mt-3">
                                <a href="#used_to" class=""> {{ trans('general.uses') }}</a> | 
                                <a href="#scientific_name" class=""> {{ trans('general.scientific_name') }}</a> | 
                                <a href="#what_form" class=""> {{ trans('general.form') }}</a> | 
                                <a href="#what_side_effects" class=""> {{ trans('general.side_effects') }}</a> | 
                                <a href="#what_risks" class=""> {{ trans('general.risks') }}</a> | 
                                <a href="#what_Interactions" class=""> {{ trans('general.interactions') }}</a> | 
                                <a href="#what_doses" class=""> {{ trans('general.dose') }}</a>
                            </div>
                            
                            <h4 id="about_test" class="text-header mb-3 mt-3">{{ trans('general.what_medicine') }} {{ $row->name }}؟</h4>
                            <div id="used_to" class="text-desc mb-2" itemprop="description">
                                {!! $row->description !!}
                            </div>
                            @if($row->scientific_name_1)
                                <h4 id="scientific_name" class="text-header mt-1">{{ trans('general.what_scientific_name') }} {{ $row->name }}؟</h4>
                                <div class="text-desc mb-2" itemtype="https://schema.org/DrugClass">
                                    <p class="vote" itemprop="activeIngredient">@if($row->scientific_name_1)<strong><i class="fas fa-atom"></i> </strong> <a href="/eg/medicines?scientific-name-1={{$row->scientific_name_1}}"> @if(app()->getLocale() == "ar") {{ $medicines_sc_name_1_ar }} @else {{ $medicines_sc_name_1_en }} @endif</a>@endif    
                                    @if($row->scientific_name_2), <a href="/eg/medicines?scientific-name-1={{$row->scientific_name_2}}"> {{ $medicines_sc_name_2_ar }}</a>@endif
                                    @if($row->scientific_name_3), <a href="/eg/medicines?scientific-name-1={{$row->scientific_name_3}}"> {{ $medicines_sc_name_3_ar }}</a>@endif </p>
                                </div>
                            @endif
                            <div class="text-desc mb-2">
                                @if($row->form)
                                <h4 id="what_form" class="text-header mt-1">{{ trans('general.what_form') }} {{ $row->name }}؟</h4>

                                <p class="vote" itemprop="dosageForm"><strong><i class="fas fa-weight"></i> </strong> 
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
                            </div>
                            
                            <div class="text-desc mb-2">
                                @if($row->suspensie)
                                <h4 id="what_obstacles" class="text-header mt-1">{{ trans('general.what_obstacles') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="suspensie"><strong><i class="fas fa-pills"></i> {{ trans('general.suspensie') }}: </strong> {{ $row->suspensie }}</p>@endif    
                            </div>
                            
                            <div class="text-desc mb-2">
                                @if($row->interactions)
                                <h4 id="what_Interactions" class="text-header mt-1">{{ trans('general.what_Interactions') }} {{ $row->name }}؟</h4>
  
                                <p class="vote" itemprop="interactingDrug"><strong><i class="fas fa-sort-amount-up"></i> </strong> {{ $row->interactions }}</p>@endif    
                            </div>
                            
                            <div class="text-desc mb-2">
                                @if($row->warning)
                                <h4 id="what_risks" class="text-header mt-1">{{ trans('general.what_risks') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="warning"><i class="fas fa-briefcase"></i> <strong>{{ trans('general.warning') }}: </strong> {{ $row->warning }}</p>@endif    
                            </div>
                            
                            <div class="text-desc mb-2">
                                @if($row->dose_ar)
                                <h4 id="what_doses" class="text-header mt-1">{{ trans('general.what_doses') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="prescribingInfo"><strong><i class="fas fa-th-list"></i></strong> {{ $row->dose_ar }}</p>@endif    
                            </div>
                            <div class="text-desc mb-2">
                                @if($row->doseUnit)
                                <h4 id="what_doseUnit" class="text-header mt-1">{{ trans('general.what_doseUnit') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="doseUnit"><strong><i class="fas fa-th-list"></i></strong> {{ $row->doseUnit }}</p>@endif    
                            </div>
                            <div class="text-desc mb-2">
                                @if($row->frequency)
                                <h4 id="what_frequency" class="text-header mt-1">{{ trans('general.what_frequency') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="frequency"><strong><i class="fas fa-th-list"></i></strong> {{ $row->frequency }}</p>@endif    
                            </div>
                            <div class="text-desc mb-2">
                                @if($row->targetPopulation)
                                <h4 id="what_targetPopulation" class="text-header mt-1">{{ trans('general.what_targetPopulation') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="targetPopulation"><strong><i class="fas fa-th-list"></i></strong> {{ $row->targetPopulation }}</p>@endif    
                            </div>
                            <div class="text-desc mb-2">
                                @if($row->max_doseUnit)
                                <h4 id="what_max_doseUnit" class="text-header mt-1">{{ trans('general.what_max_doseUnit') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="max_doseUnit"><strong><i class="fas fa-th-list"></i></strong> {{ $row->max_doseUnit }}</p>@endif    
                            </div>
                            <div class="text-desc mb-2">
                                @if($row->max_doseValue)
                                <h4 id="what_max_doseValue" class="text-header mt-1">{{ trans('general.what_max_doseValue') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="max_doseValue"><strong><i class="fas fa-th-list"></i></strong> {{ $row->max_doseValue }}</p>@endif    
                            </div>
                            <div class="text-desc mb-2">
                                @if($row->max_frequency)
                                <h4 id="what_max_frequency" class="text-header mt-1">{{ trans('general.what_max_frequency') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="max_frequency"><strong><i class="fas fa-th-list"></i></strong> {{ $row->max_frequency }}</p>@endif    
                            </div>
                            <div class="text-desc mb-2">
                                @if($row->max_targetPopulation)
                                <h4 id="what_max_targetPopulation" class="text-header mt-1">{{ trans('general.what_max_targetPopulation') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="max_targetPopulation"><strong><i class="fas fa-th-list"></i></strong> {{ $row->max_targetPopulation }}</p>@endif    
                            </div>

                            <div class="text-desc mb-2">
                                @if($row->strengthUnit)
                                <h4 id="what_strengthUnit" class="text-header mt-1">{{ trans('general.what_strengthUnit') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="strengthUnit">{{$row->strengthUnit}}</p>
                                @endif    
                            </div>

                            <div class="text-desc mb-2">
                                @if($row->breastfeedingWarning)
                                <h4 id="what_breastfeedingWarning" class="text-header mt-1">{{ trans('general.what_breastfeedingWarning') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="breastfeedingWarning">{{$row->breastfeedingWarning}}</p>
                                @endif    
                            </div>

                            <div class="text-desc mb-2">
                                @if($row->clinicalPharmacology)
                                <h4 id="what_clinicalPharmacology" class="text-header mt-1">{{ trans('general.what_clinicalPharmacology') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="clinicalPharmacology">{{$row->clinicalPharmacology}}</p>
                                @endif    
                            </div>

                            <div class="text-desc mb-2">
                                @if($row->foodWarning)
                                <h4 id="what_foodWarning" class="text-header mt-1">{{ trans('general.what_foodWarning') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="foodWarning">{{$row->foodWarning}}</p>
                                @endif    
                            </div>

                            <div class="text-desc mb-2">
                                @if($row->mechanismOfAction)
                                <h4 id="what_mechanismOfAction" class="text-header mt-1">{{ trans('general.what_mechanismOfAction') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="mechanismOfAction">{{$row->mechanismOfAction}}</p>
                                @endif    
                            </div>

                            <div class="text-desc mb-2">
                                @if($row->overdosage)
                                <h4 id="what_overdosage" class="text-header mt-1">{{ trans('general.what_overdosage') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="overdosage">{{$row->overdosage}}</p>
                                @endif    
                            </div>

                            <div class="text-desc mb-2">
                                @if($row->pregnancyWarning)
                                <h4 id="what_pregnancyWarning" class="text-header mt-1">{{ trans('general.what_pregnancyWarning') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="pregnancyWarning">{{$row->pregnancyWarning}}</p>
                                @endif    
                            </div>
                            
                            <div class="text-desc mb-2">
                                @if($row->prescriptionStatus)
                                <h4 id="what_prescriptionStatus" class="text-header mt-1">{{ trans('general.what_prescriptionStatus') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="prescriptionStatus">{{$row->prescriptionStatus}}</p>
                                @endif    
                            </div>

                            <div class="text-desc mb-2">
                                @if($row->company)
                                <h4 id="what_company" class="text-header mt-1">{{ trans('general.what_company') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="manufacturer"><strong><i class="fas fa-building"></i></strong> <a href="/eg/medicines?company={{$row->company}}"> @if(app()->getLocale() == "ar") {{ $medicines_company_ar }} @else {{ $medicines_company_en }} @endif</a></p>@endif    
                            </div>
                            
                            <div class="text-desc mb-2"itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                @if($row->price)
                                <h4 id="what_price" class="text-header mt-1">{{ trans('general.what_price') }} {{ $row->name }}؟</h4>

                                <p class="vote"><strong><i class="fas fa-tag"></i> </strong> 
                                    <span itemprop="price" content="{{ $row->price .' ' }}">{{ $row->price .' ' }} </span>
                                    <span itemprop="priceCurrency" content="@if ($country_code == "sa"){{trans('general.sar')}} @else {{trans('general.egp')}} @endif">@if ($country_code == "sa"){{trans('general.sar')}} @else {{trans('general.egp')}} @endif</span>
                                    </p>
                                @endif    
                            </div>

                            <div class="text-desc mb-2">
                                @if($row->company)
                                <h4 id="activeIngredient" class="text-header mt-1">{{ trans('general.what_company') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="manufacturer"><strong><i class="fas fa-building"></i></strong> <a href="/eg/medicines?company={{$row->company}}"> @if(app()->getLocale() == "ar") {{ $medicines_company_ar }} @else {{ $medicines_company_en }} @endif</a></p>@endif    
                            </div>
                            <div class="text-desc mb-2">
                                @if($row->activeIngredient)
                                <h4 id="what_activeIngredient" class="text-header mt-1">{{ trans('general.what_activeIngredient') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="manufacturer">{{$row->activeIngredient}}</p>
                                @endif    
                            </div>
                            <div class="text-desc mb-2">
                                @if($row->maximumIntake)
                                <h4 id="what_maximumIntake" class="text-header mt-1">{{ trans('general.what_maximumIntake') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="manufacturer">{{$row->maximumIntake}}</p>
                                @endif    
                            </div>
                            <div class="text-desc mb-2">
                                @if($row->company)
                                <h4 id="what_company" class="text-header mt-1">{{ trans('general.what_company') }} {{ $row->name }}؟</h4>
                                
                                <p class="vote" itemprop="manufacturer"><strong><i class="fas fa-building"></i></strong> <a href="/eg/medicines?company={{$row->company}}"> @if(app()->getLocale() == "ar") {{ $medicines_company_ar }} @else {{ $medicines_company_en }} @endif</a></p>@endif    
                            </div>
                            
                            <div class="text-desc mb-2">
                                <!-- @if($row->disease)<p class="vote"><strong><i class="fas fa-disease"></i> {{ trans('general.use_to') }}: </strong> @if(app()->getLocale() == "ar") {{ $row->disease_ar }} @else {{ $row->disease }} @endif </p>@endif -->
                                <!-- @if($row->made_in)<p class="vote"><strong><i class="fas fa-flag"></i> {{ trans('general.made_in') }}: </strong> {{ $row->made_in }}</p>@endif -->
                                @if($row->side_effects)
                                <h4 id="what_side_effects" class="text-header mt-1">{{ trans('general.what_side_effects') }} {{ $row->name }}</h4>
                                
                                <p class="vote" itemprop="interactingDrug"><strong><i class="fas fa-exclamation-circle"></i> {{ trans('general.side_effects') }}: </strong> {!! $row->side_effects_ar !!}</p>@endif
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($controllerName) && $controllerName == 'MedicineController')
                    {!! $row->description !!}
                @endif
                
                @if(isset($content))
                    {!! $content !!}
                @endif

                @if(isset($controllerName) && $controllerName == 'MedicineController')
                    <br>
                    @if(app()->getLocale() == "ar")
                        <p dir="rtl"><span style="color: #ff0000;"><strong>تنبيه هام:</strong></span> <strong>خلاصة المعلومات الواردة عن هذا الدواء لا تغنى عن استشارة الطبيب مع تمنياتنا بالشفاء للجميع.</strong></p>
                    @else
                        <p class="text-left"><span style="color: #ff0000;"><strong>Note:</strong></span> <strong>All the provided information about this drug does not substitute for consulting a doctor.</strong></p>
                    @endif
                @endif

                @if(isset($controllerName) && $controllerName == 'BodyPartController')
                    <br>
                    <h5 class="text-left" style="color: #007bff;">{{trans('general.body_parts')}}</h5>
                    <hr style="border-top: 2px solid rgb(16 124 250 / 40%)">

                    <a href="{{ route('frontend.body_part.index') }}">
                        @if( is_numeric($row->parent) && $row->parent) {{\DB::table('body_part_trans')->where("body_part_id",$row->parent)->first()->name}} @endif
                    </a>
<br>
<br>
                    <h5 class="text-left" style="color: #007bff;">{{trans('general.related_diseases')}}</h5>
                    <hr style="border-top: 2px solid rgb(16 124 250 / 40%)">

                    @foreach ($diseases as $disease)
                        <a href="{{ route('frontend.body_part.index') }}">
                            @if($disease) {{$disease->name}} @endif
                        </a>
                    @endforeach
                @endif


                @if(isset($row->image_gallery) && !empty($row->image_gallery))
                    <div id="lightgallery" class="unit_images flexer flexer_jc_start flexer_ai_stretch flexer_wrap">
                        @foreach (json_decode($row->image_gallery) as $k=>$img)
                            <a href="{{ url('uploads/' . $imagePath .'/'. $img ) }}" title="{{ $row->name }}">
                                {!! img_tag([
                                   'path' => $imagePath,
                                   'src' => $img,
                                   'alt' => $row->name
                                ]); !!}
                            </a>
                        @endforeach
                    </div>
                @endif

            </div>
            @if(isset($topping))
                <div class="topping">
                    {!! $topping !!}
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="unit_showcase" id="to_booking">

            @if(isset($withAddress) && $withAddress == true)
                @include('frontend.partials._address_block')
            @endif

            @if(isset($addressBlock))
               @include('frontend.' . $addressBlock)
            @endif

            @if(isset($showcase))
                {!! $showcase !!}
            @endif
        </div>
    </div>
</div>
