<div class="input-group input-group-lg">
    <span class="input-group-addon">
        {{ Form::label($label) }} :
    </span>
    <div class="">
        @if ( isset($item) && $item->$input)
            <img src="{{ url('/uploads/' . $path . '/' . $item->$input) }}" width="100" height="100"/>
            <div class="demo-checkbox">
                <br>
                <input name="image_delete" type="checkbox" id="md_checkbox_21" class="filled-in chk-col-red"  />
                <label for="md_checkbox_21">Delete This Image</label>
            </div>
        @endif
        {{ Form::file($input, array_merge(['class' => 'form-control'])) }}
    </div>
</div>