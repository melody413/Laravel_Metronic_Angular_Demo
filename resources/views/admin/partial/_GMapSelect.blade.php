
<p style="clear: both"></p>
<div style="width: 100%; height: 300px">
<?php $ex = explode(',', $lat_lng); ?>
{!! Mapper::map($ex[0], $ex[1], ['zoom' => 14, 'center' => true ,'draggable' => true, 'eventDragEnd' => 'console.log("drag end");' , 'eventAfterLoad' => 'GMapMarkerChangeOnClick()'])->render() !!}
</div>
<p style="clear: both"></p>

<div class="input-group input-group-lg">
                        <span class="input-group-addon">
                            {{ Form::label('LatLang ') }} :
                        </span>
    <div class="form-line">
        <input width="300px" name="lat_lng" id="GMapSelectLatLng" value="{{ $lat_lng }}"/>
    </div>
</div>



@section('js')
    {!! Mapper::renderJavascript() !!}
@stop
