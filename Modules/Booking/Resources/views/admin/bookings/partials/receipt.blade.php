<div class="tab-pane" id="tab_3-3">
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                        <a href="{{ route('admin.receipt.receipt.create', ['booking' => $booking->id]) }}" class="btn btn-primary btn-flat"
                           style="padding: 4px 10px;">
                            <i class="fa fa-pencil"></i> {{ trans('receipt::receipts.button.create receipt') }}
                        </a>
                    </div>
                </div>
                @include('receipt::admin.receipts.partials.index-fields', ['origin_url' => 'booking'])
            </div>
        </div>
    </div>
</div>
