
<p style="clear: both"></p>
<div style="width: 100%; height: 300px">
    <?php $ex = explode(',', $lat_lng); ?>
    {!! Mapper::map($ex[0], $ex[1], ['zoom' => 12, 'center' => true ,'draggable' => false, 'eventAfterLoad' => 'GMapMarkerChangeOnClick()'])->render() !!}
</div>
<p style="clear: both"></p>

@section('js')
    {!! Mapper::renderJavascript() !!}
@stop
