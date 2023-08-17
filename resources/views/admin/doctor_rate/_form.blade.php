


<h2><b>doctor_rate Data : </b></h2>
<div class="col-sm-12">
    <br>
    <div class="input-group input-group-lg error">
                <span class="input-group-addon">
                    {{ Form::label('Name') }} :
                </span>
        <div class="form-line">
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'name'])
    </div>

    <div class="input-group input-group-lg error">
                <span class="input-group-addon">
                    {{ Form::label('Label') }} :
                </span>
        <div class="form-line">
            {!! Form::text('label', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'label'])
    </div>

</div>
<h2><b>Permission : </b></h2>

@foreach(config('permission.admin') as $permission)

    <div class="col-sm-10">
        <h4><b>{!! $permission['group'] !!}</b></h4>
        <div class="col-sm-8">
            @foreach($permission['permissions'] as $row)
                @if( ! isset($row['hidden']) || $row['hidden'] != true )
                    {!! Form::checkbox( 'doctor_rates_premissions[]' , 'admin.' . $permission['key'] . '.' . $row['key'] , @in_array('admin.' . $permission['key'] . '.' . $row['key'], $permissions)?true:false , ['id' => 'prm_' . $permission['group'] . '.' . $permission['key'] . '.' . $row['key'] ]) !!}  <label for="prm_{{ $permission['group'] . '.' . $permission['key'] . '.' . $row['key'] }}">{!! $row['label'] !!}</label> <br>
                @endif
            @endforeach
        </div>
    </div>

@endforeach


<div class="col-sm-12">
@include('admin.partial._form_submit')
</div>
