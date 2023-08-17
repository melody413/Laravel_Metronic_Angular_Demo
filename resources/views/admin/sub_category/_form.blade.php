
<div class="input-group input-group-lg hidden">
    <span class="input-group-addon">
        {{ Form::label('Module') }} :
    </span>
    <div class="form-line">
        <select name="module_name" id="module_name">
            <option value="">Select Module</option>
            <option value="doctor">Doctor</option>
            <option value="hospital">Hospital</option>
            <option value="center">Center</option>
        </select>
    </div>
    @include('admin.partial._row_error', ['input' => 'module_name'])
</div>
<script>
    (function() {
        @if(isset($item))
        document.getElementById('module_name').value="{{$item->module_name}}";
        @endif
    })();
</script>


<h2><b>Language Data</b></h2>
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
    </div>
@endforeach

<h2><b>Other Data : </b></h2>
<div class="col-sm-12">
    <br>
    <div class="form-group" hidden>
        <span class="col-sm-1">{{ Form::label('Country ') }} :</span>
        <div class="col-sm-11">
            {!! Form::select('country_id', dataForm()->getCountries() ,null , ['class' => 'form-control show-tick bsGetAjaxData','id'=> 'bsCountryId']) !!}
            @include('admin.partial._row_error', ['input' => 'country_id'])
        </div>
    </div>

    <h2><b>Speciality : </b></h2>
    <br>
    <div class="col-sm-12 tag tag-align">
        <div class="demo-checkbox">
            <div class="row">
            @foreach(dataForm()->getSpeciality() as $row)
                {!! Form::checkbox('specialties[]', $row->id, isset($specialityIds) && in_array($row->id, $specialityIds), array('id'=> 'specialties_'.$row->id,'class' => 'filled-in chk-col-brown')) !!}
                <label for="specialties_{{ $row->id }}">{{ $row->name }}</label>
            @endforeach
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <h2><b>Parent Sub Category : </b></h2>
    <br>
    @if(isset($sub_categories_parent))

    @endif

    <div class="subs-checkbox">
        @foreach (\App\Models\SubCategory::all() as $subc)
            @if(isset($specialityIds) && $specialityIds)
                @foreach ($subc->specialties()->whereIn('specialty_id', $specialityIds)->distinct()->get() as $tg)
                    {!! Form::checkbox('parent[]', $tg->pivot->sub_category_id, isset($sub_categories_parent) && in_array($tg->pivot->sub_category_id, $sub_categories_parent), array('id'=> 'subcp_'.$tg->pivot->sub_category_id,'class' => 'filled-in chk-col-brown subcp', 'onchange' => 'return OptionsSelectedSubs(this)' )) !!}
                    <label for="subcp_{{ $tg->pivot->sub_category_id }}">{{\App\Models\SubCategory::find($tg->pivot->sub_category_id)->name}}</label>
                @endforeach
            @endif
        @endforeach
    </div>
    {{-- <div hidden class="form-group" style="border: 1px solid; box-shadow: 1px 3px;">
        <select multiple="multiple" data-placeholder="{{ trans('general.specialities_multiple') }}" class="form-control" name="parent[]" id="">
            <option></option>
            @foreach($sub_categories as $row)
                <option {{isset($sub_categories_parent) && in_array($row->id, $sub_categories_parent) ? 'selected' : ''}} value="{{$row->id}}" class="">{{ $row->name }}</option>
            @endforeach
        </select>
    </div> --}}

    <div class="form-group">
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>
    @include('admin.partial._form_submit')
</div>


<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>

<script>
checkedSubsflt = $('[name="parent[]"]').filter(":checked");
checkedSubs = []
$.each( checkedSubsflt, function( key, value ) {
    checkedSubs.push(parseInt(value.value))
});
$('[name="specialties[]"]').click(function(){
    // checked = $('[name="specialties[]"]').filter(":checked");
    // checkedIds = "0"
    // $.each( checked, function( key, value ) {
    //     checkedIds += "," + value.value
    // });
    $.ajax({
        url: "https://doctorak.com/totoadmin/data/getSubsBySpecialty/"+checkedIds,
        type: "GET",
        success: function (data) {
            console.log(data)
            $(".subs-checkbox").html("")
            $.each( data, function( key, value ) {
                if(checkedSubs.includes(value.sub_category_id))
                    checked = "checked"
                else
                    checked = ""

                $(".subs-checkbox").append('<input id="specialties_'+value.sub_category_id+'" '+checked+' class="filled-in chk-col-brown" name="parent[]" type="checkbox" value="'+value.sub_category_id+'">')
                $(".subs-checkbox").append('<label for="specialties_'+value.sub_category_id+'">'+value.name+'</label>')
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
});


$('[name="parent[]"]').click(function(){
    checked = $('[name="parent[]"]').filter(":checked");
    checkedIds = "0"
    $.each( checked, function( key, value ) {
        checkedIds += "," + value.value
    });
    $.ajax({
        url: "https://doctorak.com/totoadmin/data/getSubsBySub/"+checkedIds,
        type: "GET",
        success: function (data) {
            console.log(data)
            // $(".subs-checkbox").html("")
            $.each( data, function( key, value ) {
                // $(".subs-checkbox").append('<hr>')
                // $(".subs-checkbox").append('<input id="specialties_'+value.sub_category_id+'" class="filled-in chk-col-brown" name="parent[]" type="checkbox" value="'+value.sub_category_id+'">')
                // $(".subs-checkbox").append('<label for="specialties_'+value.sub_category_id+'">'+value.name+'</label>')
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            alert("expired")
            window.location.reload()
        }
    });
});
</script>