<div class="tab-pane active" id="tab_1-1">
    @if (!empty($email))
        @include('booking::admin.bookings.partials.email-fields')

        <div class="box-footer">
            <button type="submit" disabled class="btn btn-primary btn-flat">{{ trans('booking::bookings.button.send') }}</button>
            <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.booking.booking.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
        </div>
    @else
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-danger">
                        {{ trans('booking::bookings.messages.no_email_template_available') }}
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>