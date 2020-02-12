<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', trans('service::services.form.name'), array('class' => 'required')) !!}
                {!! Form::text('name', $service->name, ['class' => 'form-control', 'placeholder' => trans('service::services.form.name')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', trans('service::services.form.description')) !!}
                {!! Form::textarea('description', $service->description, ['class' => 'form-control', 'placeholder' => trans('service::services.form.description')]) !!}
                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                {!! Form::label('price', trans('service::services.form.price'), array('class' => 'required')) !!}
                {!! Form::text('price', $service->price, ['class' => 'form-control', 'placeholder' => trans('service::services.form.price')]) !!}
                {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                {!! Form::label('amount', trans('service::services.form.amount')) !!}
                {!! Form::text('amount', $service->amount, ['class' => 'form-control', 'placeholder' => trans('service::services.form.amount')]) !!}
                {!! $errors->first('amount', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('change') ? 'has-error' : '' }}">
                {!! Form::label('change', trans('service::services.form.change')) !!}
                {!! Form::select('change', $changes, $service->change , ['class' => 'selectize-single']) !!}
                {!! $errors->first('change', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                {!! Form::label('type', trans('service::services.form.type')) !!}
                {!! Form::select('type', $types, $service->type , ['class' => 'selectize-single']) !!}
                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('hotel_id') ? 'has-error' : '' }}">
                {!! Form::label('hotel_id', trans('service::services.form.hotel_id'), array('class' => 'required')) !!}
                {!! Form::select('hotel_id[]', $hotels, $service->hotels()->allRelatedIds() , ['class' => 'selectize-multiple', 'multiple' => 'multiple']) !!}
                {!! $errors->first('hotel_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>

