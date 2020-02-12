<div class="box-body">
    @if(!empty($booking))
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('booking_id', trans('receipt::receipts.form.booking_id'), array('class' => 'required')) !!}
                    {!! Form::text('booking_id', $booking->id, ['class' => 'hidden form-control', 'placeholder' => trans('receipt::receipts.form.booking_id')]) !!}
                    <p>{{ $booking->booking_number }}</p>
                </div>
            </div>
        </div>
    @endif
    @if(!empty($booking))
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('type', trans('receipt::receipts.form.type'), array('class' => 'required')) !!}
                    {!! Form::text('type', \Modules\Receipt\Entities\Receipt::TYPE_BOOKING_PAYMENT, ['class' => 'hidden form-control', 'placeholder' => trans('receipt::receipts.form.type')]) !!}
                    <p>{{ trans('receipt::receipts.form.type_choices.' . \Modules\Receipt\Entities\Receipt::TYPE_BOOKING_PAYMENT) }}</p>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                    {!! Form::label('type', trans('receipt::receipts.form.type'), array('class' => 'required')) !!}
                    {!! Form::select('type', $types, $receipt->type, ['class' => 'selectize-single selectize-type']) !!}
                    {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('payment_type') ? 'has-error' : '' }}">
                {!! Form::label('payment_type', trans('receipt::receipts.form.payment_type'), array('class' => 'required')) !!}
                {!! Form::select('payment_type', $paymentTypes, $receipt->payment_type, ['class' => 'selectize-single selectize-payment-type']) !!}
                {!! $errors->first('payment_type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                {!! Form::label('amount', trans('receipt::receipts.form.amount'), array('class' => 'required')) !!}
                {!! Form::text('amount', $receipt->amount, ['class' => 'form-control', 'placeholder' => trans('receipt::receipts.form.amount')]) !!}
                {!! $errors->first('amount', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    @if(!empty($booking))
        <div class="row parent_id_container hidden">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                    {!! Form::label('parent_id', trans('receipt::receipts.form.parent_id'), array('class' => 'required')) !!}
                    {!! Form::select('parent_id', $originalReceipts, $receipt->parent_id, ['class' => 'selectize-single selectize-parent-id']) !!}
                    {!! $errors->first('parent_id', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                {!! Form::label('status', trans('receipt::receipts.form.status'), array('class' => 'required')) !!}
                {!! Form::select('status', $statuses, $receipt->status, ['class' => 'selectize-single selectize-status']) !!}
                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    @php
        $startDate = \DateTime::createFromFormat('Y-m-d', $receipt->start_date)->format('d/m/Y');
    @endphp
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                {!! Form::label('start_date', trans('receipt::receipts.form.start_date'), array('class' => 'required')) !!}
                {!! Form::text('start_date', $startDate, ['class' => 'form-control has-datepicker', 'placeholder' => trans('receipt::receipts.form.start_date')]) !!}
                {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                {!! Form::label('note', trans('receipt::receipts.form.note')) !!}
                {!! Form::textarea('note', $receipt->note, ['class'=>'form-control']) !!}
                {!! $errors->first('note', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>

@include('receipt::admin.receipts.partials.javascript', ['editMode' => true])
