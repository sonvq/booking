<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', trans('promotion::promotions.form.name'), array('class' => 'required')) !!}
                {!! Form::text('name', $promotion->name, ['class' => 'form-control', 'placeholder' => trans('promotion::promotions.form.name')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', trans('promotion::promotions.form.description')) !!}
                {!! Form::textarea('description', $promotion->description, ['class' => 'form-control', 'placeholder' => trans('promotion::promotions.form.description')]) !!}
                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                {!! Form::label('amount', trans('promotion::promotions.form.amount'), array('class' => 'required')) !!}
                {!! Form::text('amount', $promotion->amount, ['class' => 'form-control', 'placeholder' => trans('promotion::promotions.form.amount')]) !!}
                {!! $errors->first('amount', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('change') ? 'has-error' : '' }}">
                {!! Form::label('change', trans('promotion::promotions.form.change'), array('class' => 'required')) !!}
                {!! Form::select('change', $changes, $promotion->change , ['class' => 'selectize-single']) !!}
                {!! $errors->first('change', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                {!! Form::label('type', trans('promotion::promotions.form.type'), array('class' => 'required')) !!}
                {!! Form::select('type', $types, $promotion->type , ['class' => 'selectize-single']) !!}
                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('agency_id') ? 'has-error' : '' }}">
                {!! Form::label('agency_id', trans('promotion::promotions.form.agency_id'), array('class' => 'required')) !!}
                {!! Form::select('agency_id[]', $agencies, $promotion->agencies()->allRelatedIds(), ['class' => 'selectize-multiple', 'multiple' => 'multiple']) !!}
                {!! $errors->first('agency_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('campaign_id') ? 'has-error' : '' }}">
                {!! Form::label('campaign_id', trans('promotion::promotions.form.campaign_id'), array('class' => 'required')) !!}
                {!! Form::select('campaign_id', $campaigns, $promotion->campaign_id, ['class' => 'selectize-campaign']) !!}
                {!! $errors->first('campaign_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('hotel_id') ? 'has-error' : '' }}">
                {!! Form::label('hotel_id', trans('promotion::promotions.form.hotel_id'), array('class' => 'required')) !!}
                {!! Form::select('hotel_id[]', [], $promotion->hotels()->allRelatedIds(), ['class' => 'selectize-hotel', 'multiple' => 'multiple']) !!}
                {!! $errors->first('hotel_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('room_id') ? 'has-error' : '' }}">
                {!! Form::label('room_id', trans('promotion::promotions.form.room_id'), array('class' => 'required')) !!}
                {!! Form::select('room_id[]', [], $promotion->rooms()->allRelatedIds(), ['class' => 'selectize-room', 'multiple' => 'multiple']) !!}
                {!! $errors->first('room_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>

@include('promotion::admin.promotions.partials.javascript', ['editMode' => true])