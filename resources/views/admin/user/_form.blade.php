

<h2><b>User Info : </b></h2>

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
            {{ Form::label('email') }} :
        </span>
        <div class="form-line">
            {!! Form::email('email', null, ['class' => 'form-control', 'autocomplete'=>'false']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'email'])
    </div>

    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('password') }} :
        </span>
        <div class="form-line">
            {!! Form::input('password','password', null, ['class' => 'form-control', 'autocomplete'=>'false']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'email'])
    </div>

    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('dr_phone') }} :
        </span>
        <div class="form-line">
            {!! Form::text('dr_phone', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'name'])
    </div>

    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('clinic_phone') }} :
        </span>
        <div class="form-line">
            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'name'])
    </div>

    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('gender') }} :
        </span>
        <div class="form-line">
            {!! Form::select('gender', dataForm()->getGender() , null , ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'gender'])
    </div>

    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('birthdate') }} :
        </span>
        <div class="form-line">
            {!! Form::text('birthdate', null, ['class' => 'form-control datepicker']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'name'])
    </div>



    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('address') }} :
        </span>
        <div class="form-line">
            {!! Form::text('address', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'address'])
    </div>
    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('specialties') }} :
        </span>
        <div class="form-line">
            <div class="col-sm-2">
                {!! Form::text('specialties', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-sm-10">
                @if( isset($item) && \App\Models\Specialty::find($item->specialties) )
                    <h4>{{\App\Models\Specialty::find($item->specialties)->name}}</h4>
                @endif
            </div>
        </div>
        @include('admin.partial._row_error', ['input' => 'specialties'])
    </div>
    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('specialty_in') }} :
        </span>
        <div class="form-line">
            {!! Form::text('specialty_in', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'specialty_in'])
    </div>
    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('facebook') }} :
        </span>
        <div class="form-line">
            {!! Form::text('facebook', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'facebook'])
    </div>
    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('twitter') }} :
        </span>
        <div class="form-line">
            {!! Form::text('twitter', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'twitter'])
    </div>
    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('instagram') }} :
        </span>
        <div class="form-line">
            {!! Form::text('instagram', null, ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'instagram'])
    </div>
    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('share_approved') }} :
        </span>
        <div class="">
            {!! Form::checkbox('share_approved', 1, (isset($item))? $item->share_approved: null, array('id'=> 'share_approved','class' => 'filled-in chk-col-brown')) !!}
            <label for="share_approved"></label>
        </div>
        @include('admin.partial._row_error', ['input' => 'share_approved'])
    </div>
    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('live_approved') }} :
        </span>
        <div class="">
            {!! Form::checkbox('live_approved', 1, (isset($item))? $item->live_approved: null, array('id'=> 'live_approved','class' => 'filled-in chk-col-brown')) !!}
            <label for="live_approved"></label>
        </div>
        @include('admin.partial._row_error', ['input' => 'live_approved'])
    </div>
    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('services_approved') }} :
        </span>
        <div class="">
            {!! Form::checkbox('services_approved', 1, (isset($item))? $item->services_approved: null, array('id'=> 'services_approved','class' => 'filled-in chk-col-brown')) !!}
            <label for="services_approved"></label>
        </div>
        @include('admin.partial._row_error', ['input' => 'services_approved'])
    </div>

</div>


<h2><b>User Role : </b></h2>

<div class="col-sm-12">
    <br>
    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('type') }} :
        </span>
        <div class="form-line">
            {!! Form::select('type', array_flip(dataForm()->userTypes()) , null , ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'type'])
    </div>
</div>


<div class="col-sm-12">
    <br>
    <div class="input-group input-group-lg error">
        <span class="input-group-addon">
            {{ Form::label('role') }} :
        </span>
        <div class="form-line">
            {!! Form::select('role', dataForm()->getRoles()->pluck('name','id')->prepend('-- Select user role --','0') , (isset($item))?@$item->roles()->first()->id:null , ['class' => 'form-control']) !!}
        </div>
        @include('admin.partial._row_error', ['input' => 'type'])
    </div>
</div>




<div class="col-sm-12">
    @include('admin.partial._form_submit')
</div>
