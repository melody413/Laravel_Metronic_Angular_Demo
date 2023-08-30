
<div class="input-group input-group-lg hidden" >
    <span class="input-group-addon">
        {{ Form::label('Parent Branch ') }} :
    </span>
    <div class="form-line">
        {!! Form::select('parent_id', dataForm()->getParentLab()->prepend('Select parent branch', 0) ,null , ['class' => 'form-control parentGetAjaxData' , 'data-from' => env('ADMIN_PREFIX') . '/data/labInfo/']) !!}
    </div>
    @include('admin.partial._row_error', ['input' => 'phone'])
</div>


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
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('excerpt ' . $key) }} :
                {{ Form::textarea($key.'[excerpt]', isset($item)?$item->translate($key)->excerpt:'', array_merge(['class' => 'form-control', 'placeholder' => 'excerpt', 'rows'=>2 ])) }}
            </div>
            <small>display in list not show in unit</small>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>
        <div class="form-group">
            <div class="form-line">
                {{ Form::label('description ' . $key) }} :
                {{ Form::textarea($key.'[description]', isset($item)?$item->translate($key)->description:'', array_merge(['class' => 'form-control tinymce', 'placeholder' => 'Description' ])) }}
            </div>
            @include('admin.partial._row_error', ['input' => $key.'.content'])
        </div>

        <div class="input-group input-group-lg">
            <div class="input-group-addon">
                {{ Form::label('address ' . $key ) }} :

            </div>
            <div class="form-line">
                {{ Form::textarea($key. '[address]', isset($item)?$item->translate($key)->address:'', array_merge(['class' => 'form-control', 'placeholder' => 'address', 'rows'=>2 ])) }}
            </div>
            <small>display in list not show in unit</small>
            @include('admin.partial._row_error', ['input' => $key.'.address'])
        </div>

    </div>
@endforeach

<h2><b>Other Data : </b></h2>
<div class="col-sm-12">
    <br>
    @include('admin.partial._form_image', ['input' => 'image', 'label' => 'Logo', 'path' => 'centers'])

    @include('admin.partial._image_gallery_field', ['input' => 'image_gallery', 'label' => 'Gallery', 'path' => 'centers'])

    <div class="col-sm-12">
        @include('admin.partial._form_tags_input', ['name'=>'insurance_company','id'=>'tagsinputInsuranceCompany' , 'available' => isset($insuranceCompanies)?$insuranceCompanies:null])
    </div>

    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('Phones ') }} :
        </span>
        <div class="form-line">
            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
        </div>
        <small>separate between numbers using "/" </small>
        @include('admin.partial._row_error', ['input' => 'phone'])
    </div>

    @include('admin.partial._locationInpts', [])
    <br>
    <div class="input-group input-group-lg">
        <span class="input-group-addon">
            {{ Form::label('map_link') }} :
        </span>
        <div class="form-line">
            {!! Form::text('map_link', null , ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'map_link'])
    </div>
 <h2><b>Speciality : </b></h2>
<br>
    <div class="col-sm-10 center center-align">
		<div id="specialties-tags" class="demo-checkbox">
            <div class="row">
            @foreach(dataForm()->getSpeciality() as $row)

                {!! Form::checkbox('specialties[]', $row->id, isset($specialityIds) && in_array($row->id, $specialityIds), array('id'=> 'specialties_'.$row->id,'class' => 'filled-in chk-col-brown')) !!}
                <label for="specialties_{{ $row->id }}">{{ $row->name }}</label>
            @endforeach
            </div>
        </div>
    </div>

    <div class="form-group">
        @include('admin.partial._form_switch', ['input' => 'is_active', 'label' => 'is active'])
    </div>
	<div class="text-right" hidden>
		<a class="btn btn-lg btn-default waves-effect" value="" id="flexCheckTagsSubs">
			Manual Tags & Sub-Categories
		</a>
	</div>
	<hr>
	<div id="current_tag_box" hidden>
		<h2>Tags:</h2><br>
		@if(isset($item->tags_en) && $item->tags_en)
			@foreach (array_map('intval', explode(',', $item->tags_en)) as $tg)
				<label>{{\App\Models\Tag::find($tg)->name}}</label> |
			@endforeach
			<br><br>
		@endif

		<h2>SubCategory:</h2><br>
		@if(isset($item->sub_cats_en) && $item->sub_cats_en)
			@foreach (array_map('intval', explode(',', $item->sub_cats_en)) as $sc)
			<label>{{\App\Models\SubCategory::find($sc)->name}}</label> |
			@endforeach
		@endif
	</div>
	<div id="tag_box" class="row">
		<h2 title="Please choose speciality firstly">Tags:</h2><br>
		@if(isset($specialityIds) && $specialityIds)
			@foreach (\App\Models\Tag::all() as $tag_s)
				@foreach ($tag_s->specialties()->whereIn('specialty_id', $specialityIds)->distinct()->get() as $tg)
					{!! Form::checkbox('tag_sp', $tg->pivot->tag_id, isset($item->tags_en) && in_array($tg->pivot->tag_id, explode(',', $item->tags_en)), array('id'=> 'tag_sp_'.$tg->pivot->tag_id,'class' => 'filled-in chk-col-brown tag_sp', 'onchange' => 'return OptionsSelected(this)' )) !!}
					<label for="tag_sp_{{ $tg->pivot->tag_id }}">{{\App\Models\Tag::find($tg->pivot->tag_id)->name}}</label>
				@endforeach
			@endforeach
		@endif
		<hr>
		<h2 title="Please choose speciality firstly">SubCategory:</h2><br>

		@if(isset($specialityIds) && $specialityIds)
			@foreach (\App\Models\SubCategory::all() as $subc)
				@foreach ($subc->specialties()->whereIn('specialty_id', $specialityIds)->distinct()->get() as $tg)
					{!! Form::checkbox('subcp', $tg->pivot->sub_category_id, isset($item->sub_cats_en) && in_array($tg->pivot->sub_category_id, explode(',', $item->sub_cats_en)), array('id'=> 'subcp_'.$tg->pivot->sub_category_id,'class' => 'filled-in chk-col-brown subcp', 'onchange' => 'return OptionsSelectedSubs(this)' )) !!}
					<label for="subcp_{{ $tg->pivot->sub_category_id }}">{{\App\Models\SubCategory::find($tg->pivot->sub_category_id)->name}}</label>
				@endforeach
			@endforeach
		@endif

	</div>

	<div class="input-group input-group-lg hidden">
		<span class="input-group-addon">
			{{ Form::label('tags en') }} :
		</span>
		<div class="form-line">
		{!! Form::text('tags_en', null , ['id' => 'tags_en', 'class' => 'form-control ', 'readonly' => 'true']) !!}
		</div>
	</div>

	<div class="input-group input-group-lg hidden">
		<span class="input-group-addon">
			{{ Form::label('sub categories en') }} :
		</span>
		<div class="form-line">
			{!! Form::text('sub_cats_en', null , ['id' => 'sub_cats_en', 'class' => 'form-control', 'readonly' => 'true']) !!}
		</div>
	</div>

	<hr>

	<div class="input-group input-group-lg hidden">
		<span class="input-group-addon">
			{{ Form::label('tags ar') }} :
		</span>
		<div class="form-line">
			{!! Form::text('tags_ar', null , ['id' => 'tags_ar', 'class' => 'form-control hidden', 'readonly' => 'true']) !!}
		</div>
	</div>
	<div class="input-group input-group-lg hidden">
		<span class="input-group-addon">
			{{ Form::label('sub categories ar') }} :
		</span>
		<div class="form-line">
			{!! Form::text('sub_cats_ar', null , ['id' => 'sub_cats_ar', 'class' => 'form-control hidden', 'readonly' => 'true']) !!}
		</div>
	</div>
	<style>
		[type=checkbox]+label {
				min-width: 170px;
		}
		</style>
    <script>
        document.getElementById('specialties-tags').onclick = function() {
          $("button.btn.btn-success.waves-effect").click()
            document.getElementById('specialties-tags').style.display = 'none'
        };
        document.getElementById('flexCheckTagsSubs').onclick = function() {
            /*document.getElementById('sub_cats_en').removeAttribute('readonly');
            document.getElementById('sub_cats_ar').removeAttribute('readonly');
            document.getElementById('tags_ar').removeAttribute('readonly');
            document.getElementById('tags_en').removeAttribute('readonly');*/
                document.getElementById('tag_box').classList.remove('hidden');
                document.getElementById('current_tag_box').classList.add('hidden');
            /*document.getElementById('sub_cats_en').value = "";
            document.getElementById('sub_cats_ar').value = "";
            document.getElementById('tags_ar').value = "";
            document.getElementById('tags_en').value = "";*/
    
        };
        function getValue(value){
            alert(value);
        }
        function OptionsSelected(me){
            var arr = [];
            tag_s = "";
            nl = document.querySelectorAll('input[name=tag_sp]:checked');
            for (var i = 0, ref = arr.length = nl.length; i < ref; i++) {
                arr[i] = nl[i];
                tag_s += arr[i]['defaultValue']+",";
            }
            document.getElementById('tags_ar').value = tag_s.slice(0, -1);
            document.getElementById('tags_en').value = tag_s.slice(0, -1);
    
            console.log(tag_s.slice(0, -1));
        }
    
        function OptionsSelectedSubs(me){
            var arr = [];
            sub_cats = "";
            nl = document.querySelectorAll('input[name=subcp]:checked');
            for (var i = 0, ref = arr.length = nl.length; i < ref; i++) {
                arr[i] = nl[i];
                sub_cats += arr[i]['defaultValue']+",";
            }
            document.getElementById('sub_cats_ar').value = sub_cats.slice(0, -1);
            document.getElementById('sub_cats_en').value = sub_cats.slice(0, -1);
    
            console.log(sub_cats.slice(0, -1));
        }
    
        </script>
    
    @include('admin.partial._form_submit')
</div>
