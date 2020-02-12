<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', trans('region::regions.form.name'), array('class' => 'required')) !!}
                {!! Form::text('name', $region->name, ['class' => 'form-control', 'placeholder' => trans('region::regions.form.name')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
