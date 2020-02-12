<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', trans('surcharge::surcharges.form.name'), array('class' => 'required')) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('surcharge::surcharges.form.name')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', trans('surcharge::surcharges.form.description')) !!}
                {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => trans('surcharge::surcharges.form.description')]) !!}
                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                {!! Form::label('price', trans('surcharge::surcharges.form.price'), array('class' => 'required')) !!}
                {!! Form::text('price', old('price'), ['class' => 'form-control', 'placeholder' => trans('surcharge::surcharges.form.price')]) !!}
                {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                {!! Form::label('amount', trans('surcharge::surcharges.form.amount')) !!}
                {!! Form::text('amount', old('amount'), ['class' => 'form-control', 'placeholder' => trans('surcharge::surcharges.form.amount')]) !!}
                {!! $errors->first('amount', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('change') ? 'has-error' : '' }}">
                {!! Form::label('change', trans('surcharge::surcharges.form.change')) !!}
                {!! Form::select('change', $changes, old('change') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('change', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                {!! Form::label('type', trans('surcharge::surcharges.form.type')) !!}
                {!! Form::select('type', $types, old('type') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('hotel_id') ? 'has-error' : '' }}">
                {!! Form::label('hotel_id', trans('surcharge::surcharges.form.hotel_id'), array('class' => 'required')) !!}
                {!! Form::select('hotel_id[]', $hotels, old('hotel_id[]') , ['class' => 'selectize-multiple', 'multiple' => 'multiple']) !!}
                {!! $errors->first('hotel_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>


