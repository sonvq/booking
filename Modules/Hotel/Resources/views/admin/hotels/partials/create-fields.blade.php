<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', trans('hotel::hotels.form.name'), array('class' => 'required')) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('hotel::hotels.form.name')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', trans('hotel::hotels.form.description')) !!}
                {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => trans('hotel::hotels.form.description')]) !!}
                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {!! Form::label('email', trans('hotel::hotels.form.email'), array('class' => 'required')) !!}
                {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('hotel::hotels.form.email')]) !!}
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                {!! Form::label('telephone', trans('hotel::hotels.form.telephone'), array('class' => 'required')) !!}
                {!! Form::text('telephone', old('telephone'), ['class' => 'form-control', 'placeholder' => trans('hotel::hotels.form.telephone')]) !!}
                {!! $errors->first('telephone', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('region_id') ? 'has-error' : '' }}">
                {!! Form::label('region_id', trans('hotel::hotels.form.region_id'), array('class' => 'required')) !!}
                {!! Form::select('region_id', $regions, old('region_id') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('region_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('company_id') ? 'has-error' : '' }}">
                {!! Form::label('company_id', trans('hotel::hotels.form.company_id'), array('class' => 'required')) !!}
                {!! Form::select('company_id', $companies, old('company_id') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('company_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('amount_buy') ? ' has-error' : '' }}">
                {!! Form::label('amount_buy', trans('hotel::hotels.form.amount_buy')) !!}
                {!! Form::text('amount_buy', old('amount_buy'), ['class' => 'form-control', 'placeholder' => trans('hotel::hotels.form.amount_buy')]) !!}
                {!! $errors->first('amount_buy', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group {{ $errors->has('change_buy') ? 'has-error' : '' }}">
                {!! Form::label('change_buy', trans('hotel::hotels.form.change_buy')) !!}
                {!! Form::select('change_buy', $changes, old('change_buy') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('change_buy', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('type_buy') ? 'has-error' : '' }}">
                {!! Form::label('type_buy', trans('hotel::hotels.form.type_buy')) !!}
                {!! Form::select('type_buy', $types, old('type_buy') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('type_buy', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('amount_sell') ? ' has-error' : '' }}">
                {!! Form::label('amount_sell', trans('hotel::hotels.form.amount_sell')) !!}
                {!! Form::text('amount_sell', old('amount_sell'), ['class' => 'form-control', 'placeholder' => trans('hotel::hotels.form.amount_sell')]) !!}
                {!! $errors->first('amount_sell', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group {{ $errors->has('change_sell') ? 'has-error' : '' }}">
                {!! Form::label('change_sell', trans('hotel::hotels.form.change_sell')) !!}
                {!! Form::select('change_sell', $changes, old('change_sell') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('change_sell', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('type_sell') ? 'has-error' : '' }}">
                {!! Form::label('type_sell', trans('hotel::hotels.form.type_sell')) !!}
                {!! Form::select('type_sell', $types, old('type_sell') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('type_sell', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
