<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', trans('customer::customers.form.name'), array('class' => 'required')) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('customer::customers.form.name')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {!! Form::label('email', trans('customer::customers.form.email')) !!}
                {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('customer::customers.form.email')]) !!}
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
                {!! Form::label('country_id', trans('customer::customers.form.country_id'), array('class' => 'required')) !!}
                {!! Form::select('country_id', $countries, old('country_id') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('country_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                {!! Form::label('telephone', trans('customer::customers.form.telephone')) !!}
                {!! Form::text('telephone', old('telephone'), ['class' => 'form-control', 'placeholder' => trans('customer::customers.form.telephone')]) !!}
                {!! $errors->first('telephone', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('identity') ? ' has-error' : '' }}">
                {!! Form::label('identity', trans('customer::customers.form.identity')) !!}
                {!! Form::text('identity', old('identity'), ['class' => 'form-control', 'placeholder' => trans('customer::customers.form.identity')]) !!}
                {!! $errors->first('identity', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                {!! Form::label('birthday', trans('customer::customers.form.birthday')) !!}
                {!! Form::text('birthday', old('birthday'), ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'placeholder' => trans('customer::customers.form.birthday')]) !!}
                {!! $errors->first('birthday', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                {!! Form::label('gender', trans('customer::customers.form.gender'), array('class' => 'required')) !!}
                {!! Form::select('gender', $genders, old('gender') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('appointment') ? ' has-error' : '' }}">
                {!! Form::label('appointment', trans('customer::customers.form.appointment')) !!}
                {!! Form::text('appointment', old('appointment'), ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'placeholder' => trans('customer::customers.form.appointment')]) !!}
                {!! $errors->first('appointment', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                {!! Form::label('note', trans('customer::customers.form.note')) !!}
                {!! Form::textarea('note', old('note'), ['class'=>'form-control']) !!}
                {!! $errors->first('note', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

</div>
