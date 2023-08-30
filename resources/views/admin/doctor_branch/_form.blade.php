

<h2><b></b></h2>
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-12">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('branch work days') }} :
                </span>
                <div class="form-line">
                    @foreach(dataForm()->weekDays() as $k=>$d)
                    <span>
                        <input type="checkbox" value="1" name="work_days[{{$k}}]" id="brn_{{ $k }}" class="filled-in" @if( isset($item) && $item->day_of_week[$k]) checked @endif>
                        <label for="brn_{{ $k }}">{{ $d }}</label>
                    </span>
                    @endforeach
                </div>
                @include('admin.partial._row_error', ['input' => 'day_of_week'])
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="col-sm-3">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('start time' ) }} :
                </span>
                <div class="form-line">
                    {!! Form::text('time_start', (isset($item->time_start))?$item->time_start:null , ['class' => 'form-control time24']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'time_start'])
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    {{ Form::label('end time' ) }} :
                </span>
                <div class="form-line">
                    {!! Form::text('time_end', (isset($item->time_end))?$item->time_end:null , ['class' => 'form-control time24']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'time_end'])
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group input-group-lg">
            <span class="input-group-addon">
                {{ Form::label('Patient Every' ) }} :
            </span>
                <div class="form-line">
                    {!! Form::number('patient_every', (isset($item->patient_every))?$item->patient_every:null , ['class' => 'form-control']) !!}
                </div>
                @include('admin.partial._row_error', ['input' => 'patient_every'])
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="input-group input-group-lg">
            <span class="input-group-addon">
                {{ Form::label('price') }} :
            </span>
            <div class="form-line">
                {!! Form::text('price', null , ['class' => 'form-control']) !!}
            </div>
            @include('admin.partial._row_error', ['input' => 'price'])
        </div>
    </div>

    <div class="col-sm-12">
        <div class="input-group input-group-lg">
            <span class="input-group-addon">
                {{ Form::label('phones') }} :
            </span>
            <div class="form-line">
                {!! Form::text('phone', null , ['class' => 'form-control']) !!}
            </div>
            @include('admin.partial._row_error', ['input' => 'phone'])
        </div>
    </div>
    @foreach( config('laravellocalization.supportedLocales') as $key=>$row )
    <div class="col-sm-6">
        <div class="input-group input-group-lg">
            <div class="form-group">
                <div class="form-line">
                    {{ Form::label('address ' . $key) }} :
                    {{ Form::textarea($key.'[address]', isset($item)?$item->translate($key)->address:'', ['class' => 'form-control', 'placeholder' => 'address', 'rows'=>2 ]) }}
                </div>
                @include('admin.partial._row_error', ['input' => $key.'.address'])
            </div>
        </div>
    </div>
    @endforeach

    <div class="col-sm-12">
        @include('admin.partial._locationInpts', [])
    </div>

    @if( ! isset($hasSubmitBtn))
        <div class="col-sm-12">
            @include('admin.partial._form_submit')
        </div>
    @endif

</div>

@section('js')
    {!! Mapper::renderJavascript() !!}
@stop

