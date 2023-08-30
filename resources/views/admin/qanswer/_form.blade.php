
<div class="input-group input-group-lg">
    <span class="input-group-addon">
        {{ Form::label('Module') }} :
    </span>
    <div class="form-line">
            <select name="module_name" id="module_name">
                <option value="">Select Module</option>
                <option value="doctor">Doctor</option>
                <option value="hospital">Hospital</option>
                <option value="center">Center</option>
                <option value="medicine">Medicine</option>
                <option value="bodypart">Body part</option>
                <option value="labservice">lab service</option>
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
                {{ Form::label('Question ' . $key) }} :
            </span>
            <div class="form-line">
                {!! Form::text($key.'[name]', isset($item)?$item->translate($key)->name:'' , ['class' => 'form-control']) !!}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.name'])
        </div>
        <div class="form-group hidden">
            <div class="form-line">
                {{ Form::label('excerpt ' . $key) }} :
                {{ Form::textarea($key.'[excerpt]', isset($item)?$item->translate($key)->excerpt:'', array_merge(['class' => 'form-control', 'placeholder' => 'excerpt', 'rows'=>2 ])) }}
            </div>
            <small>display in list not show in unit</small>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('answer ' . $key) }} :
                {{ Form::textarea($key.'[description]', isset($item)?$item->translate($key)->description:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'Description' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
    </div>
@endforeach

<h2><b>Other Data : </b></h2>
<div class="col-sm-12">
    <br>
    <div class="form-group">
        <span class="col-sm-1">{{ Form::label('Country ') }} :</span>
        <div class="col-sm-11">
            {!! Form::select('country_id', dataForm()->getCountries() ,null , ['class' => 'form-control show-tick bsGetAjaxData','id'=> 'bsCountryId']) !!}
            @include('admin.partial._row_error', ['input' => 'country_id'])
        </div>
    </div>

    <h2 class="tag-specialties" @if(isset($item) && $item->module_name == "medicine") hidden @endif><b>Speciality : </b></h2>
    <br>
    <div class="col-sm-10 tag tag-align tag-specialties" @if(isset($item) && $item->module_name == "medicine") hidden @endif>
        <div class="demo-checkbox">
            <div class="row">
            @foreach(dataForm()->getSpeciality() as $row)

                {!! Form::checkbox('specialties[]', $row->id, isset($specialityIds) && in_array($row->id, $specialityIds), array('id'=> 'specialties_'.$row->id,'class' => 'filled-in chk-col-brown')) !!}
                <label for="specialties_{{ $row->id }}">{{ $row->name }}</label>
            @endforeach
            </div>
        </div>
    </div>

    <div class="tag-categories" class="col-sm-12" @if(isset($item) && $item->module_name != "medicine") hidden @endif>
        <h2><b>Category : </b></h2>
        <br>
        <div class="col-sm-12 tag tag-align tag-categories">
            <div class="demo-checkbox">
                <div class="row">
                @foreach(\App\Models\MedicinesCategoryTrans::where('locale','ar')->get() as $row)
                    {!! Form::checkbox('medicine_categories[]', $row->medicines_category_id, isset($categoryIds) && in_array($row->medicines_category_id, $categoryIds), array('id'=> 'medicine_categories_'.$row->medicines_category_id,'class' => 'filled-in chk-col-brown')) !!}
                    <label for="medicine_categories_{{ $row->medicines_category_id }}">{{ $row->name }}</label>
                @endforeach
                </div>
            </div>
        </div>
    </div>

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
$('#module_name').change(function() {
    if( $(this).find('option:selected').val() == "medicine") {
        $('.tag-categories input:checkbox').removeAttr('checked')
        // $(".tag-specialties").hide()
        // $(".tag-categories").show()
        $(".tag-specialties").attr("hidden", true)
        $(".tag-categories").removeAttr("hidden")

    } else {
        // $(".tag-specialties").show()
        // $(".tag-categories").hide()
        $(".tag-specialties").removeAttr("hidden")
        $(".tag-categories").attr("hidden", true)
    }
});
</script>