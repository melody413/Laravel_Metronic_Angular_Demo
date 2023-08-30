

<h2><b>Language Data</b></h2>
  <ul class="nav nav-tabs" id="myTabs" role="tablist">
    <li class="nav-item" role="presentation" class="active">
      <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Basic content</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Dosage</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Warnings</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="content-tab" data-toggle="tab" href="#content" role="tab" aria-controls="content" aria-selected="false">Content</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
        {{-- start 11111111111111111 --}}
        
        @foreach( config('laravellocalization.supportedLocales') as $key=>$row )
        <div class="col-sm-6">
            <br>
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('name ' . $key) }} :
                </span>
                <div class="form-line">
                    {!! Form::text($key.'[name]', isset($item)?$item->translate($key)->name:'' , ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.name'])
            </div>
            <div class="form-group" >
                <div class="form-line">
                    {{ Form::label('excerpt ' . $key) }} :
                    {{ Form::textarea($key.'[excerpt]', isset($item)?$item->translate($key)->excerpt:'', array_merge(['class' => 'form-control', 'placeholder' => 'excerpt', 'rows'=>2 ])) }}
                </div>
                <small>display in list not show in unit</small>
                @include('admin.partial._row_error', ['input' => $key.'.content'])
            </div>
            <div class="form-group" >
                <div class="form-line">
                    {{ Form::label('who is medicine ' . $key) }} :
                    {{ Form::textarea($key.'[description]', isset($item)?$item->translate($key)->description:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'Description' ])) }}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.content'])
            </div>

        </div>
        @endforeach

        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('active_ingredient_1') }} :
                </span>
                <div class="form-inline">
                    <div class="form-group" >
                        {!! Form::text('scientific_name_1', null, ['class' => 'hidden']) !!}
                        <select name="scientific_name_1" id="scientific_name_1_sel">
                            <option value="">Select active ingredient 1</option>
                            @foreach ($medicines_sc_names as $alphabet => $collection)
                                <option value="{!! $collection->id !!}">{!! $collection->translate('ar')->name !!}, 
                                {!! $collection->translate('en')->name !!}</option>
                            @endforeach                
                        </select>
    
                        <script>
                        var x = document.getElementById("scientific_name_1").value;
                        document.getElementById("scientific_name_1_sel").value = x;
                        </script>
                    </div>
                </div>
                @include('admin.partial._row_error', ['input' => 'scientific_name_1'])
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('concentration ') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('concentration', null, ['class' => 'form-control', 'step' => '0.0001', 'onkeypress' => 'return isNumberKey(event)' ]) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'concentration'])
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('activeIngredient') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('activeIngredient', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'activeIngredient'])
            </div>
        </div>
    
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('maximumIntake') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('maximumIntake', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'maximumIntake'])
            </div>
        </div>
    
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('strengthUnit') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('strengthUnit', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'strengthUnit'])
            </div>
        </div>
        <hr>
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('active_ingredient_2') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('scientific_name_2', null, ['class' => 'hidden']) !!}
                    <select name="scientific_name_2" id="scientific_name_2_sel">
                        <option value="">Select active ingredient 2</option>
                        @foreach ($medicines_sc_names as $alphabet => $collection)
                            <option value="{!! $collection->id !!}">{!! $collection->translate('ar')->name !!}, 
                            {!! $collection->translate('en')->name !!}</option>
                        @endforeach                
                    </select>
                    
                    <script>
                    var x = document.getElementById("scientific_name_2").value;
                    document.getElementById("scientific_name_2_sel").value = x;
                    </script>
                </div>
                @include('admin.partial._row_error', ['input' => 'scientific_name_2'])
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('concentration_2 ') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('concentration_2', null, ['class' => 'form-control', 'step' => '0.0001', 'onkeypress' => 'return isNumberKey(event)' ]) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'concentration_2'])
            </div>
        </div>
    
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('active_ingredient_3') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('scientific_name_3', null, ['class' => 'hidden']) !!}
                    <select name="scientific_name_3" id="scientific_name_3_sel">
                        <option value="">Select active ingredient 3</option>
                        @foreach ($medicines_sc_names as $alphabet => $collection)
                            <option value="{!! $collection->id !!}">{!! $collection->translate('ar')->name !!}, 
                            {!! $collection->translate('en')->name !!}</option>
                        @endforeach                
                    </select>
                    <script>
                    var x = document.getElementById("scientific_name_3").value;
                    document.getElementById("scientific_name_3_sel").value = x;
                    </script>
                </div>
                @include('admin.partial._row_error', ['input' => 'scientific_name_3'])
            </div>
        </div>

        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('concentration_3 ') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('concentration_3', null, ['class' => 'form-control', 'step' => '0.0001', 'onkeypress' => 'return isNumberKey(event)' ]) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'concentration_3'])
            </div>
            <SCRIPT language=Javascript>
                function isNumberKey(evt)
                {
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode != 46 && charCode > 31 && charCode > 43
                    && (charCode < 48 || charCode > 57))
                    return false;
        
                return true;
                }
            </SCRIPT>
        </div>
     
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('drug_class') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('drug_class', null, ['class' => 'hidden']) !!}
                    <select name="drug_class" id="drug_class_sel">
                        <option value="">Select drug class</option>
                        @foreach ($drug_classes as $alphabet => $collection)
                            {{-- <option value="{!! $collection->id !!}">{!! $collection->translate('ar')->name !!}, 
                            {!! $collection->translate('en')->name !!}</option> --}}
                        @endforeach                
                    </select>
                    <script>
                    var x = document.getElementById("drug_class").value;
                    document.getElementById("drug_class_sel").value = x;
                    </script>
                </div>
                @include('admin.partial._row_error', ['input' => 'drug_class'])
            </div>
        </div>
    
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('available_strength') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('available_strength', null, ['class' => 'hidden']) !!}
                    <select name="available_strength" id="available_strength_sel">
                        <option value="">Select available strength</option>
                        @foreach ($available_strengthes as $alphabet => $collection)
                            {{-- <option value="{!! $collection->id !!}">{!! $collection->translate('ar')->name !!}, 
                            {!! $collection->translate('en')->name !!}</option> --}}
                        @endforeach                
                    </select>
                    <script>
                    var x = document.getElementById("available_strength").value;
                    document.getElementById("available_strength_sel").value = x;
                    </script>
                </div>
                @include('admin.partial._row_error', ['input' => 'available_strength'])
            </div>
        </div>
    

        <div class="input-group input-group-lg">
            <span class="input-group-addon">
                {{ Form::label('company') }} :
            </span>
            <div class="form-line">
                {!! Form::text('company', null, ['class' => 'hidden']) !!}
    
                <select name="company" id="company_sel" style="width: 100%">
                    <option value="">Select company</option>
                    @foreach ($companies as $alphabet => $collection)
                        <option value="{!! $collection->id !!}">{!! $collection->translate('ar')->name !!}, 
                        {!! $collection->translate('en')->name !!}</option>
                    @endforeach                
                </select>
    
                <script>
                var x = document.getElementById("company").value;
                document.getElementById("company_sel").value = x;
                </script>
    
            </div>
            @include('admin.partial._row_error', ['input' => 'company'])
        </div>

        <div class="form-group" >
            @include('admin.partial._form_switch', ['input' => 'isAvailableGenerically', 'label' => 'is Available Generically'])
            @include('admin.partial._form_switch', ['input' => 'isProprietary', 'label' => 'is Proprietary'])
        </div>
        {{-- end 11111111111111111 --}}
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        {{-- start 2222222222222222222 --}}
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('form') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('form', null, ['class' => 'hidden', 'id' => 'form']) !!}
    
                    <select name="form" id="form_sel">
                        <option value="">Select form</option>
                        <option value="Tablets">Tablets, اقراص</option>
                        <option value="Capsule">Capsule, كبسولات </option>
                        <option value="Ampoules">Ampoules, أمبول</option>
                        <option value="Syrup">Syrup, شراب</option>
                        <option value="Cream">Cream, كريم</option>
                        <option value="Sachets">Sachets, اكياس </option>
                        <option value="Lotion">Lotion, لوشن </option>
                        <option value="Drops">Drops, قطرة </option>
                        <option value="Antiseptic_Solution">Antiseptic Solution, محلول مطهر </option>
                        <option value="Infant_Milk">Infant Milk, لبن اطفال </option>
                        <option value="Mouth_Wash">Mouth Wash, غسول فم </option>
                        <option value="Tea_bag">Tea bag, أكياس شاي </option>
                        <option value="Powder">Powder, بودرة </option>
                        <option value="Infusion">Infusion, محلول معلق </option>
                        <option value="Inhalation">Inhalation, بخاخة للصدر </option>
                        <option value="Hair_Oil">Hair Oil. زيت شعر</option>
                        <option value="Lozenges">Lozenges, استحلاب </option>
                        <option value="Oral_Drops">Oral Drops, قطرة فم </option>
                        <option value="Vial">Vial, امبول</option>
                        <option value="Suppository">Suppository, لبوس</option>
                        <option value="Vag.Douch">Vag.Douch, دش مهبلي</option>
                        <option value="foam_spray">Foam spray, بخاخ فوم</option>
                        <option value="solution">Solution, محلول</option>
                        <option value="Emulsion">Emulsion, مستحلب</option>
                        <option value="Liquid">Liquid, سائل</option>
                        <option value="Oint">Oint, مرهم</option>
                        <option value="inhaln">inhaln, استنشاق</option>
                        <option value="Spray">Spray, رش</option>
                        <option value="Gel">Gel, جل</option>
                        <option value="Volatile">Volatile, متطايرة</option>
                        <option value="bottle">Bottle, زجاجة</option>
                        <option value="sprayer">Sprayer, بخاخ</option>
                        <option value="soap">Soap, صابون</option>
                        <option value="shampoo">Shampoo, شامبو</option>
                        <option value="hair_lotion">Hair lotion, غسول للشعر</option>
                        <option value="serum">Serum, سيروم</option>
                        <option value="mask">Mask, ماسك</option>
                        <option value="Condition">Condition, بلسم</option>
                        <option value="hair_ampoules">Hair ampoules, أمبولات الشعر</option>
                        <option value="bath_oil">Bath oil, زيت الاستحمام</option>
                    </select>
                    <script>
                        var x = document.getElementById("form").value;
                        document.getElementById("form_sel").value = x;
                    </script>
            
                </div>
                @include('admin.partial._row_error', ['input' => 'form'])
            </div>

            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('conc_type ') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('conc_type', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'conc_type'])
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('max_doseUnit') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('max_doseUnit', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'max_doseUnit'])
            </div>

            <div class="form-group" >
                <div class="form-line">
                    {{ Form::label('overdosage ' . $key) }} :
                    {{ Form::textarea($key.'[overdosage]', isset($item)?$item->translate($key)->overdosage:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'overdosage' ])) }}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.content'])
            </div>
        </div>

        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('max_doseValue') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('max_doseValue', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'max_doseValue'])
            </div>
        </div>

        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('dose_ar') }} :
                </span>
                <div class="form-line">
                    {!! Form::textarea('dose_ar', null, ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'dose_ar'])
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('dose') }} :
                </span>
                <div class="form-line">
                    {!! Form::textarea('dose', null, ['class' => 'form-control tinymce']) !!}
                    {{-- {!! Form::textarea('disease_ar', null, ['class' => 'form-control tinymce']) !!} --}}
        
                </div>
                @include('admin.partial._row_error', ['input' => 'dose'])
            </div>
        </div>
        
    
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('doseUnit') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('doseUnit', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'doseUnit'])
            </div>
        </div>
    
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('frequency') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('frequency', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'frequency'])
            </div>
        </div>
    
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('targetPopulation') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('targetPopulation', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'targetPopulation'])
            </div>
        </div>
    
    
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('max_frequency') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('max_frequency', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'max_frequency'])
            </div>
        </div>
    
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('max_targetPopulation') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('max_targetPopulation', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'max_targetPopulation'])
            </div>
        </div>
        {{-- end 2222222222222222222 --}}
    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        {{-- start 333333333333 --}}
        @foreach( config('laravellocalization.supportedLocales') as $key=>$row )
            <div class="col-sm-6">
                <br>
                <div class="form-group" >
                    <div class="form-line">
                        {{ Form::label('breastfeedingWarning ' . $key) }} :
                        {{ Form::textarea($key.'[breastfeedingWarning]', isset($item)?$item->translate($key)->breastfeedingWarning:'', array_merge(['class' => 'form-control', 'placeholder' => 'breastfeedingWarning', 'rows'=>2 ])) }}
                    </div>
                    @include('admin.partial._row_error', ['input' => $key.'.breastfeedingWarning'])
                </div>
                <div class="form-group" >
                    <div class="form-line">
                        {{ Form::label('clinicalPharmacology ' . $key) }} :
                        {{ Form::textarea($key.'[clinicalPharmacology]', isset($item)?$item->translate($key)->clinicalPharmacology:'', array_merge(['class' => 'form-control', 'placeholder' => 'clinicalPharmacology', 'rows'=>2 ])) }}
                    </div>
                    <small>display in list not show in unit</small>
                    @include('admin.partial._row_error', ['input' => $key.'.content'])
                </div>
                <div class="form-group" >
                    <div class="form-line">
                        {{ Form::label('foodWarning ' . $key) }} :
                        {{ Form::textarea($key.'[foodWarning]', isset($item)?$item->translate($key)->foodWarning:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'foodWarning' ])) }}
                    </div>
                    @include('admin.partial._row_error', ['input' => $key.'.content'])
                </div>
                <div class="form-group" >
                    <div class="form-line">
                        {{ Form::label('mechanismOfAction ' . $key) }} :
                        {{ Form::textarea($key.'[mechanismOfAction]', isset($item)?$item->translate($key)->mechanismOfAction:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'mechanismOfAction' ])) }}
                    </div>
                    @include('admin.partial._row_error', ['input' => $key.'.content'])
                </div>
                
                <div class="form-group" >
                    <div class="form-line">
                        {{ Form::label('pregnancyWarning ' . $key) }} :
                        {{ Form::textarea($key.'[pregnancyWarning]', isset($item)?$item->translate($key)->pregnancyWarning:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'pregnancyWarning' ])) }}
                    </div>
                    @include('admin.partial._row_error', ['input' => $key.'.content'])
                </div>
                <div class="form-group" >
                    <div class="form-line">
                        {{ Form::label('prescriptionStatus ' . $key) }} :
                        {{ Form::textarea($key.'[prescriptionStatus]', isset($item)?$item->translate($key)->prescriptionStatus:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'prescriptionStatus' ])) }}
                    </div>
                    @include('admin.partial._row_error', ['input' => $key.'.content'])
                </div>

            </div>
        @endforeach
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('warning_ar') }} :
                </span>
                <div class="form-line">
                    {!! Form::textarea('warning_ar', null, ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'warning_ar'])
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('warning_en') }} :
                </span>
                <div class="form-line">
                    {!! Form::textarea('warning_en', null, ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'warning_en'])
            </div>
        </div>

        {{-- end 333333333333333333333 --}}
    </div>

    <div class="tab-pane fade" id="content" role="tabpanel" aria-labelledby="content-tab">
        {{-- start 444444444444444 --}}
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('medical_uses_ar') }} :
                </span>
                <div class="form-line">
                    {!! Form::textarea('medical_uses_ar', null, ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'medical_uses_ar'])
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('medical_uses') }} :
                </span>
                <div class="form-line">
                    {!! Form::textarea('medical_uses', null, ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'medical_uses'])
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('type ') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('type', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'type'])
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('suspensie ') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('suspensie', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'suspensie'])
            </div>
        </div>
        
        <div class="form-group hidden">
                @include('admin.partial._form_tags_input', [
                    'name'=>'user_id',
                    'id'=>'tagsInput',
                    'label' => 'user E-mail',
                    'data' => [
                        'data-url' => '/data/getUser',
                        'data-input-hidden' => 'user_id',
                        'data-display-key' => 'email',
                        'data-max-tags' => 1
                    ],
                    'available' => isset($item->user->email)?[$item->user->id => $item->user->email]:null
                ])
            </div>
            
        <div class="col-sm-6">
        
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('quantity') }} :
                </span>
                <div class="form-line">
                    {!! Form::input('number', 'quantity', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'quantity'])
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('price') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('price', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'price'])
            </div>
        </div>
        
        <div id="sa-price" class="col-sm-6 col-sm-offset-6" @if(!$item->show_all) hidden @endif>
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('sa price') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('sa_price', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'sa_price'])
            </div>
        </div>
        <div class="col-sm-12">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('Category') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('category', null, ['class' => 'hidden', 'id' => 'category']) !!}
                        <select name="category[]" id="category_sel__" multiple>
                            <option value="">Select category</option>
                            @foreach (\App\Models\MedicinesCategory::where('is_active' , 1)->where('parent', NULL)->orWhere('parent', '')->get() as $alphabet => $collection)
                                <option value="{!! $collection->id !!}" @if(isset($categories_parent) && in_array($collection->id, $categories_parent)) selected @endif>{!! $collection->name !!}</option>
                                @foreach (\App\Models\MedicinesCategory::where('is_active' , 1)->where('parent', $collection->id)->get() as $collection2)
                                    <option value="{!! $collection2->id !!}" @if(isset($categories_parent) && in_array($collection2->id, $categories_parent)) selected @endif>—{!! $collection2->name !!}</option>
                                    @foreach (\App\Models\MedicinesCategory::where('is_active' , 1)->where('parent', $collection2->id)->get() as $collection3)
                                        <option value="{!! $collection3->id !!}" @if(isset($categories_parent) && in_array($collection3->id, $categories_parent)) selected @endif>—{!! $collection3->name !!}</option>
                                        @foreach (\App\Models\MedicinesCategory::where('is_active' , 1)->where('parent', $collection3->id)->get() as $collection4)
                                            <option value="{!! $collection4->id !!}" @if(isset($categories_parent) && in_array($collection4->id, $categories_parent)) selected @endif>—{!! $collection4->name !!}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                            {{-- @foreach ($categories as $alphabet => $collection)
                                <option value="{!! $collection->id !!}">{!! $collection->translate('ar')->name !!}, 
                                {!! $collection->translate('en')->name !!}</option>
                            @endforeach                 --}}
                        </select>
                        {{-- <script>
                            var x = document.getElementById("category").value;
                            document.getElementById("category_sel").value = x;
                        </script> --}}
                </div>
                @include('admin.partial._row_error', ['input' => 'category'])
            </div>
        </div>
           
        {{-- <div class="col-sm-6" hidden>
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('Category 2') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('category_2', null, ['class' => 'hidden', 'id' => 'category_2']) !!}
                        <select name="category_2" id="category_2_sel">
                            <option value="">Select category 2</option>
                            @foreach ($categories as $alphabet => $collection)
                                <option value="{!! $collection->id !!}">{!! $collection->translate('ar')->name !!}, 
                                {!! $collection->translate('en')->name !!}</option>
                            @endforeach                
                        </select>
                        <script>
                            var x = document.getElementById("category_2").value;
                            document.getElementById("category_2_sel").value = x;
                        </script>
                </div>
                @include('admin.partial._row_error', ['input' => 'category_2'])
            </div>
        </div>
        
        <div class="col-sm-6" hidden>
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('Category 3') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('category_3', null, ['class' => 'hidden', 'id' => 'category_3']) !!}
                        <select name="category_3" id="category_3_sel">
                            <option value="">Select category 3</option>
                            @foreach ($categories as $alphabet => $collection)
                                <option value="{!! $collection->id !!}">{!! $collection->translate('ar')->name !!}, 
                                {!! $collection->translate('en')->name !!}</option>
                            @endforeach                
                        </select>
                        <script>
                            var x = document.getElementById("category_3").value;
                            document.getElementById("category_3_sel").value = x;
                        </script>
                </div>
                @include('admin.partial._row_error', ['input' => 'category_3'])
            </div>
        </div> --}}
        
            
        
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('made_in') }} :
                </span>
                <div class="form-line">
                    {!! Form::text('made_in', null, ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'made_in'])
            </div>
        
            <div class="col-sm-6">
                <div class="input-group input-group-lg">
                <span class="input-group-addon col-sm-12">
                    {{ Form::label('side_effects_ar') }} :
                </span>
                <div class="form-line">
                    {!! Form::textarea('side_effects_ar', null, ['class' => 'form-control tinymce']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'side_effects_ar'])
            </div>
            </div>
            <div class="col-sm-6">
                    <div class="input-group input-group-lg">
                    <span class="input-group-addon col-sm-12">
                        {{ Form::label('side_effects') }} :
                    </span>
                    <div class="form-line">
                        {{ Form::textarea('side_effects', null, array_merge(['class' => 'form-control tinymce', 'placeholder' => 'side effects' ])) }}
                    </div>
                    @include('admin.partial._row_error', ['input' => 'side_effects'])
                </div>
            </div>
        
            <div class="col-sm-6">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon col-sm-12">
                        {{ Form::label('disease_ar') }} :
                    </span>
                    <div class="form-line">
                        {!! Form::textarea('disease_ar', null, ['class' => 'form-control tinymce']) !!}
                    </div>
                    @include('admin.partial._row_error', ['input' => 'disease_ar'])
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon col-sm-12">
                        {{ Form::label('disease') }} :
                    </span>
                    <div class="form-line">
                        {!! Form::textarea('disease', null, ['class' => 'form-control tinymce']) !!}
                    </div>
                    @include('admin.partial._row_error', ['input' => 'disease'])
                </div>
            </div>
        
            <div class="col-sm-6">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon col-sm-12">
                        {{ Form::label('disease_2_ar') }} :
                    </span>
                    <div class="form-line">
                        {!! Form::textarea('disease_2_ar', null, ['class' => 'form-control tinymce']) !!}
                    </div>
                    @include('admin.partial._row_error', ['input' => 'disease_2_ar'])
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon col-sm-12">
                        {{ Form::label('disease_2') }} :
                    </span>
                    <div class="form-line">
                        {!! Form::textarea('disease_2', null, ['class' => 'form-control tinymce']) !!}
                    </div>
                    @include('admin.partial._row_error', ['input' => 'disease_2'])
                </div>
            </div>
        
            <div class="col-sm-6">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon col-sm-12">
                        {{ Form::label('disease_3_ar') }} :
                    </span>
                    <div class="form-line">
                        {!! Form::textarea('disease_3_ar', null, ['class' => 'form-control tinymce']) !!}
                    </div>
                    @include('admin.partial._row_error', ['input' => 'disease_3_ar'])
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon col-sm-12">
                        {{ Form::label('disease_3') }} :
                    </span>
                    <div class="form-line">
                        {!! Form::textarea('disease_3', null, ['class' => 'form-control tinymce']) !!}
                    </div>
                    @include('admin.partial._row_error', ['input' => 'disease_3'])
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon col-sm-12">
                        {{ Form::label('interactions_ar') }} :
                    </span>
                    <div class="form-line">
                        {!! Form::textarea('interactions_ar', null, ['class' => 'form-control tinymce']) !!}
                    </div>
                    @include('admin.partial._row_error', ['input' => 'interactions_ar'])
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-group input-group-lg">
                    <span class="input-group-addon col-sm-12">
                        {{ Form::label('interactions') }} :
                    </span>
                    <div class="form-line">
                        {!! Form::textarea('interactions', null, ['class' => 'form-control tinymce']) !!}
                    </div>
                    @include('admin.partial._row_error', ['input' => 'interactions'])
                </div>
            </div>
        
            <div class="clearfix">.
            </div>
        
        
          
            <h2><b>Body Part: </b></h2>
            <br>
            @if(isset($bps_parent))
        
            @endif
        
            <div class="body-parts-checkbox">
                {!! Form::text('body_part_ids', null, ['class' => 'hidden', 'id' => 'body_part_id']) !!}
                <select name="body_part_id" id="body_part_id_sel">
                    <option value="">Select Body Part</option>
        
                    @foreach (\App\Models\BodyPart::all() as $alphabet => $collection)
                        <option value="{!! $collection->id !!}">{!! $collection->translate('ar')->name !!}, 
                        {!! $collection->translate('en')->name !!}</option>
                    @endforeach
                </select>
                <script>
                    var x = document.getElementById("body_part_id").value;
                    document.getElementById("body_part_id_sel").value = x;
                </script>
            </div>
        
        
            <br>
            <h2><b>Symptoms: </b></h2>
            <br>
            <div class="subs-checkbox">
                @foreach (\App\Models\Symptom::all() as $symp)
                    {{-- @if(isset($specialityIds) && $specialityIds)
                        @foreach ($subc->specialties()->whereIn('specialtyid', $specialityIds)->distinct()->get() as $tg) --}}
                            {!! Form::checkbox('symptom_ids[]', $symp->id, isset($symps_parent) && in_array($symp->id, $symps_parent), array('id'=> 'sympid_'.$symp->id,'class' => 'filled-in chk-col-brown subcp', 'onchange' => 'return OptionsSelectedSubs(this)' )) !!}
                            <label for="sympid_{{ $symp->id }}">{{\App\Models\Symptom::find($symp->id)->name}}</label>
                        {{-- @endforeach
                    @endif --}}
                @endforeach
            </div>
        <br>
        <br>
            <div class="form-group" >
                <span class="col-sm-1">{{ Form::label('Country ') }} :</span>
                <div class="col-sm-11">
                    {!! Form::select('country_id', dataForm()->getCountries() ,null , ['class' => 'form-control show-tick bsGetAjaxData','id'=> 'bsCountryId']) !!}
                    @include('admin.partial._row_error', ['input' => 'country_id'])
                </div>
            </div>
            @include('admin.partial._form_image', ['input' => 'image', 'label' => 'image', 'path' => 'medicines'])
        
            <div class="form-group" >
                @include('admin.partial._form_switch', ['input' => 'show_all', 'label' => 'show all countries'])
                @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
            </div>
            @include('admin.partial._form_submit')
        {{-- end 44444444444444444 --}}
    </div>

  </div>


  <div class="col-sm-12">
    <br>

</div>
<style>
.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 100%;
}
</style>
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>

<script>
checkedSubsflt = $('[name="symptom_ids"]').filter(":checked");
checkedSubs = []
$.each( checkedSubsflt, function( key, value ) {
    checkedSubs.push(parseInt(value.value))
});
$('#body_part_id_sel').change(function(e){
    checked = $('[name="symptom_ids"]').filter(":checked");
    checkedIds = "0"
    $.each( checked, function( key, value ) {
        checkedIds += "," + value.value
    });
    // alert(e.target.value)
    $.ajax({
        url: "https://doctorak.com/totoadmin/data/getSymptomsByBodyPart/"+e.target.value,
        type: "GET",
        success: function (data) {
            console.log(data)
            $(".subs-checkbox").html("")
            $.each( data, function( key, value ) {
                if(checkedSubs.includes(value.sub_category_id))
                    checked = "checked"
                else
                    checked = ""
debugger
                $(".subs-checkbox").append('<input id="sympid_'+value.sub_category_id+'" '+checked+' class="filled-in chk-col-brown" name="symptom_ids[]" type="checkbox" value="'+value.sub_category_id+'">')
                $(".subs-checkbox").append('<label for="sympid_'+value.sub_category_id+'">'+value.name+'</label>')
            });

            if(data.length === 0)
                $(".subs-checkbox").html("No Symptoms")

        },
        error: function(jqXHR, textStatus, errorThrown) {

            console.log(textStatus, errorThrown);
        }
    });
});
$(".show_all").click(function(){
    if($('[name="show_all"]').prop('checked') == true)
        $("#sa-price").removeAttr("hidden")
    else
    $   ("#sa-price").attr("hidden")
});

tinymce.init({
        selector: '.tinymce'
      });

$('#myTabs a:first').tab('show') // Select first tab

</script>