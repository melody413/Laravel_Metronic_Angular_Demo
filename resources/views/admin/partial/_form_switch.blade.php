<div class="input-group input-group-lg demo-switch {{$input}}">
    <span class="input-group-addon">
        {{ Form::label($label) }} :
    </span>
    <div class="">
        <div class="switch">
            <label>OFF
                <?php
                    if (isset($item->$input))
                        $switchVal = ($item->$input == 1)?true:false;
                    else
                        $switchVal = (isset($defV))?$defV:1
                ?>
                {{ Form::checkbox($input, 1 , $switchVal, array_merge(['class' => 'form-control'])) }}
                <span class="lever"></span>ON
            </label>
        </div>
    </div>
</div>
