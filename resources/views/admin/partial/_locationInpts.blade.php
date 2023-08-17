<div class="form-group">
    <span class="col-sm-1">{{ Form::label('Country ') }}</span>
    <div class="col-sm-11">
        {!! Form::select('country_id', dataForm()->getCountries() ,null , ['class' => 'form-control show-tick bsGetAjaxData','id'=> 'bsCountryId']) !!}
        @include('admin.partial._row_error', ['input' => 'country_id'])
    </div>
</div>
<div class="form-group">
    <span class="col-sm-1">{{ Form::label('City ') }}</span>
    <div class="col-sm-11">
        {!! Form::select('city_id', [] ,null , ['class' => 'form-control show-tick bsGetAjaxData', 'id' => 'bsCityies', 'data-val' => isset($item->city_id)?$item->city_id:'']) !!}
        @include('admin.partial._row_error', ['input' => 'city_id'])
    </div>
</div>
<div class="form-group">
    <span class="col-sm-1 ">{{ Form::label('Area ') }}</span>
    <div class="col-sm-11">
        {!! Form::select('area_id', [] ,null , ['class' => 'form-control show-tick bsGetAjaxData', 'id' => 'bsAreas', 'data-val' => isset($item->area_id)?$item->area_id:'']) !!}
        @include('admin.partial._row_error', ['input' => 'area_id'])
    </div>
</div>

<div class="input-group input-group-lg">
    <span class="input-group-addon">{{ Form::label('GMap ') }}</span>
    <div class="form-line">
        @include('admin.partial._GMapSelect', ['lat_lng' => isset($item->lat_lng)?$item->lat_lng:env('DEF_LAT_LONG')])
    </div>
</div>


