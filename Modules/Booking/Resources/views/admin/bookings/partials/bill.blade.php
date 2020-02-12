<div class="tab-pane" id="tab_4-4">
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                        <a href="{{ route('admin.bill.bill.create', ['booking' => $booking->id]) }}" class="btn btn-primary btn-flat"
                           style="padding: 4px 10px;">
                            <i class="fa fa-pencil"></i> {{ trans('bill::bills.button.create bill') }}
                        </a>
                    </div>
                </div>
                @include('bill::admin.bills.partials.index-fields', ['origin_url' => 'booking'])
            </div>
        </div>
    </div>
</div>
