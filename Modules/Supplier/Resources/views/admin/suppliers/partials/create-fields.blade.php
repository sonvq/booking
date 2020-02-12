<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', trans('supplier::suppliers.form.name'), array('class' => 'required')) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('supplier::suppliers.form.name')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {!! Form::label('email', trans('supplier::suppliers.form.email')) !!}
                {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('supplier::suppliers.form.email')]) !!}
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                {!! Form::label('telephone', trans('supplier::suppliers.form.telephone')) !!}
                {!! Form::text('telephone', old('telephone'), ['class' => 'form-control', 'placeholder' => trans('supplier::suppliers.form.telephone')]) !!}
                {!! $errors->first('telephone', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', trans('supplier::suppliers.form.description')) !!}
                {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => trans('supplier::suppliers.form.description')]) !!}
                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                {!! Form::label('amount', trans('supplier::suppliers.form.amount'), array('class' => 'required')) !!}
                {!! Form::text('amount', old('amount'), ['class' => 'form-control', 'placeholder' => trans('supplier::suppliers.form.amount')]) !!}
                {!! $errors->first('amount', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('change') ? 'has-error' : '' }}">
                {!! Form::label('change', trans('supplier::suppliers.form.change'), array('class' => 'required')) !!}
                {!! Form::select('change', $changes, old('change') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('change', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                {!! Form::label('type', trans('supplier::suppliers.form.type'), array('class' => 'required')) !!}
                {!! Form::select('type', $types, old('type') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>


