
@section('css')
    <link href="{{ asset('/assets/admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css">
@endsection

<div class="input-group input-group-lg">
    <span class="input-group-addon">
        @if (isset($label))
            {{ Form::label($label) }} :
        @else
            {{ Form::label($name) }} :
        @endif
    </span>
    <div class="form-line">
        <input type="text" class="form-control" id="{{ $id }}"  @if(isset($data)) @foreach($data as $k=>$d)  {{ $k }}="{{ $d }}"  @endforeach @endif  data-av-tags='{!! json_encode(isset($available)?$available:'') !!}'>
    </div>
</div>
