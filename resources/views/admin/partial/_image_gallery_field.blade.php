<div class="input-group input-group-lg">
    <span class="input-group-addon">
        {{ Form::label($label) }} :
    </span>
    <div class="">
        <div id="id_dropzone" class="dropzone" data-path="{{ $path }}" data-input="{{ $input }}" data-imgs="@if(isset($item)){{  $item->$input }}@endif">
            <div class="dz-message">
                <div class="drag-icon-cph">
                    <i class="material-icons">touch_app</i>
                </div>
                <h3>Drop files here or click to upload.</h3>
                {{--<em>(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</em>--}}
            </div>
            <div class="fallback">
                <input name="file_gallerys" type="file" multiple />
            </div>

        </div>
    </div>
</div>

