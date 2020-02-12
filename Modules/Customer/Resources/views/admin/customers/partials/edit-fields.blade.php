@php
    $birthday = '';
    $appointment = '';
    if (!empty($customer->birthday) && $customer->birthday !== '0000-00-00') {
        $birthday = \DateTime::createFromFormat('Y-m-d', $customer->birthday)->format('d/m/Y');
    }

    if (!empty($customer->appointment) && $customer->appointment !== '0000-00-00') {
        $appointment = \DateTime::createFromFormat('Y-m-d', $customer->appointment)->format('d/m/Y');
    }
@endphp
<div class="tab-pane active" id="tab_1-1">
    {!! Form::open(['route' => ['admin.customer.customer.update', $customer->id], 'method' => 'put']) !!}
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', trans('customer::customers.form.name'), array('class' => 'required')) !!}
                    {!! Form::text('name', $customer->name, ['class' => 'form-control', 'placeholder' => trans('customer::customers.form.name')]) !!}
                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::label('email', trans('customer::customers.form.email')) !!}
                    {!! Form::text('email',  $customer->email, ['class' => 'form-control', 'placeholder' => trans('customer::customers.form.email')]) !!}
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
                    {!! Form::label('country_id', trans('customer::customers.form.country_id'), array('class' => 'required')) !!}
                    {!! Form::select('country_id', $countries,  $customer->country_id , ['class' => 'selectize-single']) !!}
                    {!! $errors->first('country_id', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                    {!! Form::label('telephone', trans('customer::customers.form.telephone')) !!}
                    {!! Form::text('telephone', $customer->telephone, ['class' => 'form-control', 'placeholder' => trans('customer::customers.form.telephone')]) !!}
                    {!! $errors->first('telephone', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('identity') ? ' has-error' : '' }}">
                    {!! Form::label('identity', trans('customer::customers.form.identity')) !!}
                    {!! Form::text('identity', $customer->identity, ['class' => 'form-control', 'placeholder' => trans('customer::customers.form.identity')]) !!}
                    {!! $errors->first('identity', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                    {!! Form::label('birthday', trans('customer::customers.form.birthday')) !!}
                    {!! Form::text('birthday', $birthday, ['class' => 'form-control datepicker', 'placeholder' => trans('customer::customers.form.birthday')]) !!}
                    {!! $errors->first('birthday', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                    {!! Form::label('gender', trans('customer::customers.form.gender'), array('class' => 'required')) !!}
                    {!! Form::select('gender', $genders, $customer->gender, ['class' => 'selectize-single']) !!}
                    {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('appointment') ? ' has-error' : '' }}">
                    {!! Form::label('appointment', trans('customer::customers.form.appointment')) !!}
                    {!! Form::text('appointment', $appointment, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'placeholder' => trans('customer::customers.form.appointment')]) !!}
                    {!! $errors->first('appointment', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                    {!! Form::label('note', trans('customer::customers.form.note')) !!}
                    {!! Form::textarea('note', $customer->note, ['class'=>'form-control']) !!}
                    {!! $errors->first('note', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.customer.customer.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
    </div>
    {!! Form::close() !!}
</div>
