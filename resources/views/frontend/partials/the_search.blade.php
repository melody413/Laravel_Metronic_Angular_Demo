
@if(isset($headerSearchParams) && is_array($headerSearchParams))
    <form action="{{ $headerSearchParams['route'] }}" method="GET" id="the_search_form">
        <ul class="the_search home">
            @if(in_array('speciality',$headerSearchParams))
                <li>
                    {!! Form::select('speciality', dataForm()->getSpeciality()->pluck('name','id')->prepend(trans('general.specialty'), '') , app('request')->input('speciality') , ['class' => 'speciality', 'required' => 'required']) !!}
                </li>
            @endif
            @if(in_array('city',$headerSearchParams))
                <li>
                    {!! Form::select('city', dataForm()->getCities()->prepend(trans('general.city'), '') , app('request')->input('city') , ['class' => 'bsCityies', 'required' => 'required']) !!}
                </li>
            @endif
            @if(in_array('area',$headerSearchParams))
                <li>
                    {!! Form::select('area', isset($headerSearchParams['areas'])?$headerSearchParams['areas']->prepend(trans('general.area'), ''):[''=>trans('general.area')] ,  app('request')->input('area') , ['class' => 'bsAreas']) !!}
                </li>
            @endif
            @if(in_array('labServices',$headerSearchParams))
                <li>
                    {!! Form::select('lab_service', dataForm()->getLabServices()->pluck('name','id')->prepend(trans('general.service'), '') , app('request')->input('lab_service') , ['class' => '', 'id' => '']) !!}
                </li>
            @endif
            @if(in_array('insurance',$headerSearchParams))
                <li>
                    {!! Form::select('insurance_company', dataForm()->getInsuranceCompany()->pluck('name','id')->prepend(trans('general.insurance'), '') , app('request')->input('insurance_company') , ['class' => '']) !!}
                </li>
            @endif
            @if(in_array('category',$headerSearchParams))
                <li>
                    {!! Form::select('category', dataForm()->getMedicineCategory()->pluck('name','id')->prepend(trans('general.category'), '') , app('request')->input('category') , ['class' => '']) !!}
                </li>
            @endif
            {{-- @if(in_array('company',$headerSearchParams))
                <li>
                    {!! Form::select('company', dataForm()->getMedicineCompany()->pluck('name','id')->prepend(trans('general.company'), '') , app('request')->input('company') , ['class' => '']) !!}
                </li>
            @endif --}}
            {{-- @if(in_array('scientific_name',$headerSearchParams))
                <li>
                    {!! Form::select('scientific_name_1', dataForm()->getMedicineScientificName1()->pluck('name','id')->prepend(trans('general.scientific_name'), '') , app('request')->input('scientific_name_1') , ['class' => 'scientific_name']) !!}
                </li>
            @endif --}}
            @if(in_array('form',$headerSearchParams))
                <li>
                    {!! Form::select('form', dataForm()->getMedicineForm() , app('request')->input('form') , ['class' => 'form']) !!}
                </li>
            @endif
            @if(in_array('name',$headerSearchParams))
                <li class="double">
                    <input type="text" placeholder="@if(isset($controllerName) && $controllerName == 'MedicineController') {{trans('general.medicine')}} @else {{trans('general.name')}} @endif" name="name" value="{{ app('request')->input('name') }}">
                </li>
            @endif
            <li class="action">
                <button type="submit" class="search"><i class="icon-search"></i></button>
            </li>
        </ul>
    </form>
@endif
<style>
li.dropdown-header.optgroup-1 {
    display: none;
}
</style>