<div class="box-body">
    @if(!empty($booking))
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('booking_id', trans('bill::bills.form.booking_id'), array('class' => 'required')) !!}
                    {!! Form::text('booking_id', $booking->id, ['class' => 'hidden form-control', 'placeholder' => trans('bill::bills.form.booking_id')]) !!}
                    <p>{{ $booking->booking_number }}</p>
                </div>
            </div>
        </div>
    @endif
    @if(!empty($booking))
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('type', trans('bill::bills.form.type'), array('class' => 'required')) !!}
                    {!! Form::text('type', \Modules\Bill\Entities\Bill::TYPE_BOOKING_PAYMENT, ['class' => 'hidden form-control', 'placeholder' => trans('bill::bills.form.type')]) !!}
                    <p>{{ trans('bill::bills.form.type_choices.' . \Modules\Bill\Entities\Bill::TYPE_BOOKING_PAYMENT) }}</p>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                    {!! Form::label('type', trans('bill::bills.form.type'), array('class' => 'required')) !!}
                    {!! Form::select('type', $types, $bill->type, ['class' => 'selectize-single selectize-type']) !!}
                    {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('payment_type') ? 'has-error' : '' }}">
                {!! Form::label('payment_type', trans('bill::bills.form.payment_type'), array('class' => 'required')) !!}
                {!! Form::select('payment_type', $paymentTypes, $bill->payment_type, ['class' => 'selectize-single selectize-payment-type']) !!}
                {!! $errors->first('payment_type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                {!! Form::label('amount', trans('bill::bills.form.amount'), array('class' => 'required')) !!}
                {!! Form::text('amount', $bill->amount, ['class' => 'form-control', 'placeholder' => trans('bill::bills.form.amount')]) !!}
                {!! $errors->first('amount', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    @if(!empty($booking))
        <div class="row parent_id_container hidden">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                    {!! Form::label('parent_id', trans('bill::bills.form.parent_id'), array('class' => 'required')) !!}
                    {!! Form::select('parent_id', $originalBills, $bill->parent_id, ['class' => 'selectize-single selectize-parent-id']) !!}
                    {!! $errors->first('parent_id', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                {!! Form::label('status', trans('bill::bills.form.status'), array('class' => 'required')) !!}
                {!! Form::select('status', $statuses, $bill->status, ['class' => 'selectize-single selectize-status']) !!}
                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    @php
        $startDate = \DateTime::createFromFormat('Y-m-d', $bill->start_date)->format('d/m/Y');
    @endphp
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                {!! Form::label('start_date', trans('bill::bills.form.start_date')) !!}
                {!! Form::text('start_date', $startDate, ['class' => 'form-control has-datepicker', 'placeholder' => trans('bill::bills.form.start_date')]) !!}
                {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                {!! Form::label('note', trans('bill::bills.form.note')) !!}
                {!! Form::textarea('note', $bill->note, ['class'=>'form-control']) !!}
                {!! $errors->first('note', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>

@include('bill::admin.bills.partials.javascript', ['editMode' => true])
