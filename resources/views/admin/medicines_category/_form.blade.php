<h2><b>Name</b></h2>
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

<div class="col-sm-12">
    <div class="form-group">
        <span class="col-sm-1">{{ Form::label('Country ') }} :</span>
        <div class="col-sm-11">
            {!! Form::select('country_id', dataForm()->getCountries() ,null , ['class' => 'form-control show-tick bsGetAjaxData','id'=> 'bsCountryId']) !!}
            @include('admin.partial._row_error', ['input' => 'country_id'])
        </div>
    </div>
</div>



<div class="col-sm-12">
    <h2><b>Parent Sub Category : </b></h2>
    <br>
    <div class="subs-checkbox">
        {{-- @foreach (\App\Models\MedicinesCategory::whereNull("parent")->get() as $subc)
            {!! Form::checkbox('parent[]', $subc->id, isset($categories_parent) && in_array($subc->id, $categories_parent), array('id'=> 'subcp_'.$subc->id,'class' => 'filled-in chk-col-brown subcp', 'onchange' => 'return OptionsSelectedSubs(this)' )) !!}
            <label for="subcp_{{ $subc->id }}">{{\App\Models\MedicinesCategory::find($subc->id)->name}}</label>
        @endforeach --}}
        {{-- {{ Form::select('parent[]', \App\Models\MedicinesCategory::whereNull("parent")->where('is_active' , 1)->listsTranslations('name')->pluck('name','id') ,null , ['class' => 'form-control parentGetAjaxData' , 'id'=> 'bsMedicineCatIds']) }} --}}
        <select name="parent[]" id="parent_sel" style="width: 100%">
            <option value="">Select parent</option>
            {{-- @foreach (\App\Models\MedicinesCategory::where('is_active' , 1)->where('parent', NULL)->get() as $alphabet => $collection)
                <option value="{!! $collection->id !!}" @if(isset($categories_parent) && in_array($collection->id, $categories_parent)) selected @endif>{!! $collection->name !!}</option>
                @foreach (\App\Models\MedicinesCategory::where('is_active' , 1)->where('parent', 'like', '%' . $collection->id . ',%')->orWhere('parent', 'like', '%,' . $collection->id . '')->get() as $collection2)
                    <option value="{!! $collection->id !!}" @if(isset($categories_parent) && in_array($collection2->id, $categories_parent)) selected @endif>--{!! $collection2->name !!}</option>
                @endforeach
            @endforeach --}}
            @foreach (\App\Models\MedicinesCategory::where('is_active' , 1)->where('parent', NULL)->orWhere('parent', '')->get() as $alphabet => $collection)
                <option value="{!! $collection->id !!}" @if(isset($categories_parent) && in_array($collection->id, $categories_parent)) selected @endif>{!! $collection->name !!}</option>
                @foreach (\App\Models\MedicinesCategory::where('is_active' , 1)->where('parent', $collection->id)->get() as $collection2)
                    <option value="{!! $collection2->id !!}" @if(isset($categories_parent) && in_array($collection2->id, $categories_parent)) selected @endif>--{!! $collection2->name !!}</option>
                    @foreach (\App\Models\MedicinesCategory::where('is_active' , 1)->where('parent', $collection2->id)->get() as $collection3)
                        <option value="{!! $collection3->id !!}" @if(isset($categories_parent) && in_array($collection3->id, $categories_parent)) selected @endif>----{!! $collection3->name !!}</option>
                        @foreach (\App\Models\MedicinesCategory::where('is_active' , 1)->where('parent', $collection3->id)->get() as $collection4)
                            <option value="{!! $collection4->id !!}" @if(isset($categories_parent) && in_array($collection4->id, $categories_parent)) selected @endif>------{!! $collection4->name !!}</option>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </select>
        <script>
            var x = document.getElementById("category").value;
            document.getElementById("category_sel").value = x;
        </script>
    </div>


    <div class="form-group">
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>
    @include('admin.partial._form_submit')
</div>
<style>
.btn-group.bootstrap-select.show-tick {
    width: 100% !important;
    text-align: right;
}
</style>
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
    checked = $('[name="specialties[]"]').filter(":checked");
    checkedIds = "0"
    $.each( checked, function( key, value ) {
        checkedIds += "," + value.value
    });
    $.ajax({
        url: "https://doctorak.com/totoadmin/data/getSubsBySpecialty/"+checkedIds,
        type: "GET",
        success: function (data) {
            console.log(data)
            $(".subs-checkbox").html("")
            $.each( data, function( key, value ) {
                if(checkedSubs.includes(value.category_id))
                    checked = "checked"
                else
                    checked = ""

                $(".subs-checkbox").append('<input id="specialties_'+value.category_id+'" '+checked+' class="filled-in chk-col-brown" name="parent[]" type="checkbox" value="'+value.category_id+'">')
                $(".subs-checkbox").append('<label for="specialties_'+value.category_id+'">'+value.name+'</label>')
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
                // $(".subs-checkbox").append('<input id="specialties_'+value.category_id+'" class="filled-in chk-col-brown" name="parent[]" type="checkbox" value="'+value.category_id+'">')
                // $(".subs-checkbox").append('<label for="specialties_'+value.category_id+'">'+value.name+'</label>')
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