@if ($errors->has($input))
    <label class="error">{!! $errors->first($input) !!}</label>
@endif