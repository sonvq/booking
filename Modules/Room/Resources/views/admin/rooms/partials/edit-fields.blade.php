<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', trans('room::rooms.form.name'), array('class' => 'required')) !!}
                {!! Form::text('name', $room->name, ['class' => 'form-control', 'placeholder' => trans('room::rooms.form.name')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', trans('room::rooms.form.description')) !!}
                {!! Form::textarea('description', $room->description, ['class' => 'form-control', 'placeholder' => trans('room::rooms.form.description')]) !!}
                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                {!! Form::label('price', trans('room::rooms.form.price'), array('class' => 'required')) !!}
                {!! Form::text('price', $room->price, ['class' => 'form-control', 'placeholder' => trans('room::rooms.form.price')]) !!}
                {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                {!! Form::label('amount', trans('room::rooms.form.amount')) !!}
                {!! Form::text('amount', $room->amount, ['class' => 'form-control', 'placeholder' => trans('room::rooms.form.amount')]) !!}
                {!! $errors->first('amount', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('change') ? 'has-error' : '' }}">
                {!! Form::label('change', trans('room::rooms.form.change')) !!}
                {!! Form::select('change', $changes, $room->change , ['class' => 'selectize-single']) !!}
                {!! $errors->first('change', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                {!! Form::label('type', trans('room::rooms.form.type')) !!}
                {!! Form::select('type', $types, $room->type , ['class' => 'selectize-single']) !!}
                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('hotel_id') ? 'has-error' : '' }}">
                {!! Form::label('hotel_id', trans('room::rooms.form.hotel_id'), array('class' => 'required')) !!}
                {!! Form::select('hotel_id[]', $hotels, $room->hotels()->allRelatedIds() , ['class' => 'selectize-multiple', 'multiple' => 'multiple']) !!}
                {!! $errors->first('hotel_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>




