<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', trans('campaign::campaigns.form.name'), array('class' => 'required')) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('campaign::campaigns.form.name')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', trans('campaign::campaigns.form.description')) !!}
                {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => trans('campaign::campaigns.form.description')]) !!}
                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                {!! Form::label('amount', trans('campaign::campaigns.form.amount'), array('class' => 'required')) !!}
                {!! Form::text('amount', old('amount'), ['class' => 'form-control', 'placeholder' => trans('campaign::campaigns.form.amount')]) !!}
                {!! $errors->first('amount', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('change') ? 'has-error' : '' }}">
                {!! Form::label('change', trans('campaign::campaigns.form.change'), array('class' => 'required')) !!}
                {!! Form::select('change', $changes, old('change') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('change', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                {!! Form::label('type', trans('campaign::campaigns.form.type'), array('class' => 'required')) !!}
                {!! Form::select('type', $types, old('type') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('hotel_id') ? 'has-error' : '' }}">
                {!! Form::label('hotel_id', trans('campaign::campaigns.form.hotel_id')) !!}
                {!! Form::select('hotel_id[]', $hotels, old('hotel_id') , ['class' => 'selectize-hotel', 'multiple' => 'multiple']) !!}
                {!! $errors->first('hotel_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('room_id') ? 'has-error' : '' }}">
                {!! Form::label('room_id', trans('campaign::campaigns.form.room_id')) !!}
                {!! Form::select('room_id[]', [], old('room_id') , ['class' => 'selectize-room', 'multiple' => 'multiple']) !!}
                {!! $errors->first('room_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('service_id') ? 'has-error' : '' }}">
                {!! Form::label('service_id', trans('campaign::campaigns.form.service_id')) !!}
                {!! Form::select('service_id[]', [], old('service_id') , ['class' => 'selectize-service', 'multiple' => 'multiple']) !!}
                {!! $errors->first('service_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('service_id') ? 'has-error' : '' }}">
                {!! Form::label('surcharge_id', trans('campaign::campaigns.form.surcharge_id')) !!}
                {!! Form::select('surcharge_id[]', [], old('surcharge_id') , ['class' => 'selectize-surcharge', 'multiple' => 'multiple']) !!}
                {!! $errors->first('surcharge_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>

@include('campaign::admin.campaigns.partials.javascript', ['editMode' => false])


