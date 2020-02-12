<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('hotel_id') ? 'has-error' : '' }}">
                {!! Form::label('hotel_id', trans('booking::bookings.form.hotel_id'), array('class' => 'required')) !!}
                {!! Form::select('hotel_id', $hotels, old('hotel_id') , ['class' => 'selectize-hotel']) !!}
                {!! $errors->first('hotel_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('customer_id') ? 'has-error' : '' }}">
                {!! Form::label('customer_id', trans('booking::bookings.form.customer_id'), array('class' => 'required')) !!}
                {!! Form::select('customer_id', $customers, old('customer_id') , ['class' => 'selectize-customer']) !!}
                {!! $errors->first('customer_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('supplier_id') ? 'has-error' : '' }}">
                {!! Form::label('supplier_id', trans('booking::bookings.form.supplier_id')) !!}
                {!! Form::select('supplier_id', $suppliers, old('supplier_id') , ['class' => 'selectize-supplier']) !!}
                {!! $errors->first('supplier_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('agency_id') ? 'has-error' : '' }}">
                {!! Form::label('agency_id', trans('booking::bookings.form.agency_id'), array('class' => 'required')) !!}
                {!! Form::select('agency_id', $agencies, old('agency_id') , ['class' => 'selectize-agency']) !!}
                {!! $errors->first('agency_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('sale_id') ? 'has-error' : '' }}">
                {!! Form::label('sale_id', trans('booking::bookings.form.sale_id')) !!}
                {!! Form::select('sale_id', $sales, old('sale_id') , ['class' => 'selectize-single']) !!}
                {!! $errors->first('sale_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ ($errors->has('checkin_date') || $errors->has('date_range')) ? ' has-error' : '' }}">
                {!! Form::label('checkin_date', trans('booking::bookings.form.checkin_date'), array('class' => 'required')) !!}
                {!! Form::text('checkin_date', old('checkin_date'), ['autocomplete' => 'off', 'class' => 'checkin_date form-control datepicker', 'placeholder' => trans('booking::bookings.form.checkin_date')]) !!}
                {!! $errors->first('checkin_date', '<span class="help-block">:message</span>') !!}
                {!! $errors->first('date_range', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ ($errors->has('checkout_date')) ? ' has-error' : '' }}">
                {!! Form::label('checkout_date', trans('booking::bookings.form.checkout_date'), array('class' => 'required')) !!}
                {!! Form::text('checkout_date', old('checkout_date'), ['autocomplete' => 'off', 'class' => 'checkout_date form-control datepicker', 'placeholder' => trans('booking::bookings.form.checkout_date')]) !!}
                {!! $errors->first('checkout_date', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('hotel_confirm_code') ? ' has-error' : '' }}">
                {!! Form::label('hotel_confirm_code', trans('booking::bookings.form.hotel_confirm_code')) !!}
                {!! Form::text('hotel_confirm_code', old('hotel_confirm_code'), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.hotel_confirm_code')]) !!}
                {!! $errors->first('hotel_confirm_code', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('flight_code') ? ' has-error' : '' }}">
                {!! Form::label('flight_code', trans('booking::bookings.form.flight_code')) !!}
                {!! Form::text('flight_code', old('flight_code'), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.flight_code')]) !!}
                {!! $errors->first('flight_code', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('campaign_id') ? 'has-error' : '' }}">
                {!! Form::label('campaign_id', trans('booking::bookings.form.campaign_id'), array('class' => 'required')) !!}
                {!! Form::select('campaign_id', [], old('campaign_id') , ['class' => 'selectize-campaign']) !!}
                {!! $errors->first('campaign_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('is_adjust_surcharge') ? 'has-error' : '' }}">
                {{ Form::checkbox('is_adjust_surcharge', old('is_adjust_surcharge'), 0, ['id' => 'is_adjust_surcharge']) }}
                {!! Form::label('is_adjust_surcharge', trans('booking::bookings.form.is_adjust_surcharge')) !!}
                {!! $errors->first('is_adjust_surcharge', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('is_adjust_price') ? 'has-error' : '' }}">
                {{ Form::checkbox('is_adjust_price', old('is_adjust_price'), 0, ['id' => 'is_adjust_price']) }}
                {!! Form::label('is_adjust_price', trans('booking::bookings.form.is_adjust_price')) !!}
                {!! $errors->first('is_adjust_price', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="room-list-container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="required">{{  trans('booking::bookings.form.room') }}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group {{ $errors->has('room_id.0') ? 'has-error' : '' }}">
                    {!! Form::label('room_id', trans('booking::bookings.form.room_id'), array('class' => 'required')) !!}
                    {!! Form::select('room_id[]', ['' => trans('booking::bookings.form.room_id_empty_option')], old('room_id.0') , ['class' => 'selectize-room']) !!}
                    {!! $errors->first('room_id.0', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group{{ ($errors->has('quantity.0')) ? ' has-error' : '' }}">
                    {!! Form::label('quantity', trans('booking::bookings.form.quantity'), array('class' => 'required')) !!}
                    {!! Form::text('quantity[]', old('quantity.0'), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.quantity')]) !!}
                    {!! $errors->first('quantity.0', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group{{ ($errors->has('start_date.0')) ? ' has-error' : '' }}">
                    {!! Form::label('start_date', trans('booking::bookings.form.start_date'), array('class' => 'required')) !!}
                    {!! Form::text('start_date[]', old('start_date.0'), ['autocomplete' => 'off', 'class' => 'form-control datepicker', 'placeholder' => trans('booking::bookings.form.start_date')]) !!}
                    {!! $errors->first('start_date.0', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group{{ ($errors->has('end_date.0')) ? ' has-error' : '' }}">
                    {!! Form::label('end_date', trans('booking::bookings.form.end_date'), array('class' => 'required')) !!}
                    {!! Form::text('end_date[]', old('end_date.0'), ['autocomplete' => 'off', 'class' => 'form-control datepicker', 'placeholder' => trans('booking::bookings.form.end_date')]) !!}
                    {!! $errors->first('end_date.0', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group{{ ($errors->has('buy_price.0')) ? ' has-error' : '' }}">
                    {!! Form::label('buy_price', trans('booking::bookings.form.buy_price'), array('class' => 'required')) !!}
                    {!! Form::text('buy_price[]', old('buy_price.0'), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.buy_price')]) !!}
                    {!! $errors->first('buy_price.0', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group{{ ($errors->has('sell_price.0')) ? ' has-error' : '' }}">
                    {!! Form::label('sell_price', trans('booking::bookings.form.sell_price'), array('class' => 'required')) !!}
                    {!! Form::text('sell_price[]', old('sell_price.0'), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.sell_price')]) !!}
                    {!! $errors->first('sell_price.0', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="add-new-room-row add-new-row">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <?php if(!empty(old('room_id')) && count(old('room_id')) > 1) :?>
            <?php foreach (old('room_id') as $key => $value) : ?>
                <?php if ($key !== 0) : ?>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group {{ $errors->has("room_id.$key") ? 'has-error' : '' }}">
                            {!! Form::select('room_id[]', [], old("room_id.$key") , ['class' => 'selectize-room']) !!}
                            {!! $errors->first("room_id.$key", '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group{{ ($errors->has("quantity.$key")) ? ' has-error' : '' }}">
                            {!! Form::text('quantity[]', old("quantity.$key"), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.quantity')]) !!}
                            {!! $errors->first("quantity.$key", '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group{{ ($errors->has("start_date.$key")) ? ' has-error' : '' }}">
                            {!! Form::text('start_date[]', old("start_date.$key"), ['autocomplete' => 'off', 'class' => 'form-control datepicker', 'placeholder' => trans('booking::bookings.form.start_date')]) !!}
                            {!! $errors->first("start_date.$key", '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group{{ ($errors->has("end_date.$key")) ? ' has-error' : '' }}">
                            {!! Form::text('end_date[]', old("end_date.$key"), ['autocomplete' => 'off', 'class' => 'form-control datepicker', 'placeholder' => trans('booking::bookings.form.end_date')]) !!}
                            {!! $errors->first("end_date.$key", '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group{{ ($errors->has("buy_price.$key")) ? ' has-error' : '' }}">
                            {!! Form::text('buy_price[]', old("buy_price.$key"), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.buy_price')]) !!}
                            {!! $errors->first("buy_price.$key", '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group{{ ($errors->has("sell_price.$key")) ? ' has-error' : '' }}">
                            {!! Form::text('sell_price[]', old("sell_price.$key"), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.sell_price')]) !!}
                            {!! $errors->first("sell_price.$key", '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="remove-row" href="javascript:;" onclick="remove_row(this, '{{ trans('booking::bookings.form.confirm_delete_row') }}');">
                            <i class="fa fa-remove"></i>
                        </button>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="service-list-container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="required">{{  trans('booking::bookings.form.service') }}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('service_id', trans('booking::bookings.form.service_id'), array('class' => 'required')) !!}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    {!! Form::label('service_quantity', trans('booking::bookings.form.service_quantity'), array('class' => 'required')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('service_start_date', trans('booking::bookings.form.service_start_date'), array('class' => 'required')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('service_end_date', trans('booking::bookings.form.service_end_date'), array('class' => 'required')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('service_buy_price', trans('booking::bookings.form.service_buy_price'), array('class' => 'required')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('service_sell_price', trans('booking::bookings.form.service_sell_price'), array('class' => 'required')) !!}
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="add-new-service-row add-new-row margin-top-m-10">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <?php if(!empty(old('service_id')) && count(old('service_id')) > 0) :?>
        <?php foreach (old('service_id') as $key => $value) : ?>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group {{ $errors->has("service_id.$key") ? 'has-error' : '' }}">
                    {!! Form::select('service_id[]', [], old("service_id.$key") , ['class' => 'selectize-service']) !!}
                    {!! $errors->first("service_id.$key", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group{{ ($errors->has("service_quantity.$key")) ? ' has-error' : '' }}">
                    {!! Form::text('service_quantity[]', old("service_quantity.$key"), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.service_quantity')]) !!}
                    {!! $errors->first("service_quantity.$key", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group{{ ($errors->has("service_start_date.$key")) ? ' has-error' : '' }}">
                    {!! Form::text('service_start_date[]', old("service_start_date.$key"), ['autocomplete' => 'off', 'class' => 'form-control datepicker', 'placeholder' => trans('booking::bookings.form.service_start_date')]) !!}
                    {!! $errors->first("service_start_date.$key", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group{{ ($errors->has("service_end_date.$key")) ? ' has-error' : '' }}">
                    {!! Form::text('service_end_date[]', old("service_end_date.$key"), ['autocomplete' => 'off', 'class' => 'form-control datepicker', 'placeholder' => trans('booking::bookings.form.service_end_date')]) !!}
                    {!! $errors->first("service_end_date.$key", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group{{ ($errors->has("service_buy_price.$key")) ? ' has-error' : '' }}">
                    {!! Form::text('service_buy_price[]', old("service_buy_price.$key"), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.service_buy_price')]) !!}
                    {!! $errors->first("service_buy_price.$key", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group{{ ($errors->has("service_sell_price.$key")) ? ' has-error' : '' }}">
                    {!! Form::text('service_sell_price[]', old("service_sell_price.$key"), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.service_sell_price')]) !!}
                    {!! $errors->first("service_sell_price.$key", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="remove-row" href="javascript:;" onclick="remove_row(this, '{{ trans('booking::bookings.form.confirm_delete_row') }}');">
                    <i class="fa fa-remove"></i>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="surcharge-list-container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="required">{{  trans('booking::bookings.form.surcharge') }}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('surcharge_id', trans('booking::bookings.form.surcharge_id'), array('class' => 'required')) !!}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    {!! Form::label('surcharge_quantity', trans('booking::bookings.form.surcharge_quantity'), array('class' => 'required')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('surcharge_start_date', trans('booking::bookings.form.surcharge_start_date'), array('class' => 'required')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('surcharge_end_date', trans('booking::bookings.form.surcharge_end_date'), array('class' => 'required')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('surcharge_buy_price', trans('booking::bookings.form.surcharge_buy_price'), array('class' => 'required')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('surcharge_sell_price', trans('booking::bookings.form.surcharge_sell_price'), array('class' => 'required')) !!}
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="add-new-surcharge-row add-new-row margin-top-m-10">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <?php if(!empty(old('surcharge_id')) && count(old('surcharge_id')) > 0) :?>
        <?php foreach (old('surcharge_id') as $key => $value) : ?>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group {{ $errors->has("surcharge_id.$key") ? 'has-error' : '' }}">
                    {!! Form::select('surcharge_id[]', [], old("surcharge_id.$key") , ['class' => 'selectize-surcharge']) !!}
                    {!! $errors->first("surcharge_id.$key", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group{{ ($errors->has("surcharge_quantity.$key")) ? ' has-error' : '' }}">
                    {!! Form::text('surcharge_quantity[]', old("surcharge_quantity.$key"), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.surcharge_quantity')]) !!}
                    {!! $errors->first("surcharge_quantity.$key", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group{{ ($errors->has("surcharge_start_date.$key")) ? ' has-error' : '' }}">
                    {!! Form::text('surcharge_start_date[]', old("surcharge_start_date.$key"), ['autocomplete' => 'off', 'class' => 'form-control datepicker', 'placeholder' => trans('booking::bookings.form.surcharge_start_date')]) !!}
                    {!! $errors->first("surcharge_start_date.$key", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group{{ ($errors->has("surcharge_end_date.$key")) ? ' has-error' : '' }}">
                    {!! Form::text('surcharge_end_date[]', old("surcharge_end_date.$key"), ['autocomplete' => 'off', 'class' => 'form-control datepicker', 'placeholder' => trans('booking::bookings.form.surcharge_end_date')]) !!}
                    {!! $errors->first("surcharge_end_date.$key", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group{{ ($errors->has("surcharge_buy_price.$key")) ? ' has-error' : '' }}">
                    {!! Form::text('surcharge_buy_price[]', old("surcharge_buy_price.$key"), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.surcharge_buy_price')]) !!}
                    {!! $errors->first("surcharge_buy_price.$key", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group{{ ($errors->has("surcharge_sell_price.$key")) ? ' has-error' : '' }}">
                    {!! Form::text('surcharge_sell_price[]', old("surcharge_sell_price.$key"), ['class' => 'form-control', 'placeholder' => trans('booking::bookings.form.surcharge_sell_price')]) !!}
                    {!! $errors->first("surcharge_sell_price.$key", '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="remove-row" href="javascript:;" onclick="remove_row(this, '{{ trans('booking::bookings.form.confirm_delete_row') }}');">
                    <i class="fa fa-remove"></i>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="total-list-container">
        <div class="row">
            <div class="col-md-12">
                <h4>{{  trans('booking::bookings.form.total') }}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group{{ ($errors->has('total_price')) ? ' has-error' : '' }}">
                    {!! Form::label('total_price', trans('booking::bookings.form.total_price'), array('class' => 'required')) !!}
                    {!! Form::text('total_price', old('total_price'), ['readonly' => true, 'class' => 'form-control', 'placeholder' => trans('booking::bookings.form.total_price')]) !!}
                    {!! $errors->first('total_price', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group{{ ($errors->has('total_buy_price')) ? ' has-error' : '' }}">
                    {!! Form::label('total_buy_price', trans('booking::bookings.form.total_buy_price'), array('class' => 'required')) !!}
                    {!! Form::text('total_buy_price', old('total_buy_price'), ['readonly' => true, 'class' => 'form-control', 'placeholder' => trans('booking::bookings.form.total_buy_price')]) !!}
                    {!! $errors->first('total_buy_price', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group{{ ($errors->has('total_sell_price')) ? ' has-error' : '' }}">
                    {!! Form::label('total_sell_price', trans('booking::bookings.form.total_sell_price'), array('class' => 'required')) !!}
                    {!! Form::text('total_sell_price', old('total_sell_price'), ['readonly' => true, 'class' => 'form-control', 'placeholder' => trans('booking::bookings.form.total_sell_price')]) !!}
                    {!! $errors->first('total_sell_price', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group{{ ($errors->has('total_profit')) ? ' has-error' : '' }}">
                    {!! Form::label('total_profit', trans('booking::bookings.form.total_profit'), array('class' => 'required')) !!}
                    {!! Form::text('total_profit', old('total_profit'), ['readonly' => true, 'class' => 'form-control', 'placeholder' => trans('booking::bookings.form.total_profit')]) !!}
                    {!! $errors->first('total_profit', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                {!! Form::label('note', trans('booking::bookings.form.note')) !!}
                {!! Form::textarea('note', old('note'), ['class'=>'form-control']) !!}
                {!! $errors->first('note', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>

@include('booking::admin.bookings.partials.javascript', ['editMode' => false])
