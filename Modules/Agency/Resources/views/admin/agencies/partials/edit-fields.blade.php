<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', trans('agency::agencies.form.name'), array('class' => 'required')) !!}
                {!! Form::text('name', $agency->name, ['class' => 'form-control', 'placeholder' => trans('agency::agencies.form.name')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {!! Form::label('email', trans('agency::agencies.form.email')) !!}
                {!! Form::text('email', $agency->email, ['class' => 'form-control', 'placeholder' => trans('agency::agencies.form.email')]) !!}
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                {!! Form::label('telephone', trans('agency::agencies.form.telephone')) !!}
                {!! Form::text('telephone', $agency->telephone, ['class' => 'form-control', 'placeholder' => trans('agency::agencies.form.telephone')]) !!}
                {!! $errors->first('telephone', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {!! Form::label('description', trans('agency::agencies.form.description')) !!}
                {!! Form::textarea('description', $agency->description, ['class' => 'form-control', 'placeholder' => trans('agency::agencies.form.description')]) !!}
                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                {!! Form::label('amount', trans('agency::agencies.form.amount'), array('class' => 'required')) !!}
                {!! Form::text('amount', $agency->amount, ['class' => 'form-control', 'placeholder' => trans('agency::agencies.form.amount')]) !!}
                {!! $errors->first('amount', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('change') ? 'has-error' : '' }}">
                {!! Form::label('change', trans('agency::agencies.form.change'), array('class' => 'required')) !!}
                {!! Form::select('change', $changes, $agency->change , ['class' => 'selectize-single']) !!}
                {!! $errors->first('change', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                {!! Form::label('type', trans('agency::agencies.form.type'), array('class' => 'required')) !!}
                {!! Form::select('type', $types, $agency->type , ['class' => 'selectize-single']) !!}
                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>



