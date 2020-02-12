<div class="tab-pane" id="tab_2-2">
    <div class="box-body">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="3%">{{ trans('core::core.table.id') }}</th>
                                <th width="11%">{{ trans('booking::bookings.table.booking_number') }}</th>
                                <th width="11%">{{ trans('booking::bookings.table.campaign_id-hotel_id') }}</th>
                                <th width="7%">{{ trans('booking::bookings.table.agency_id-supplier_id') }}</th>
                                <th width="7%">{{ trans('booking::bookings.table.customer_id') }}</th>
                                <th width="8%">{{ trans('booking::bookings.table.checkin-checkout') }}</th>
                                <th width="17%">{{ trans('booking::bookings.table.status') }}</th>
                                <th width="10%">{{ trans('booking::bookings.table.hotel_confirm_code-flight_code') }}</th>
                                <th width="9%">{{ trans('booking::bookings.table.cod') }}</th>
                                <th width="8%">{{ trans('booking::bookings.table.sale_id-author_id') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($bookings)): ?>
                            <?php foreach ($bookings as $booking): ?>
                            @php
                                $checkinDate = \DateTime::createFromFormat('Y-m-d', $booking->checkin_date)->format('d/m/Y');
                                $checkoutDate = \DateTime::createFromFormat('Y-m-d', $booking->checkout_date)->format('d/m/Y');
                                $codDate = \DateTime::createFromFormat('Y-m-d', $booking->cod)->format('d/m/Y');
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('admin.booking.booking.edit', [$booking->id]) }}">
                                        {{ $booking->id }}
                                    </a>
                                </td>
                                <td>
                                    {{ $booking->booking_number }}
                                </td>
                                <td>
                                    @if($booking->campaign)
                                        <p>{{ $booking->campaign->name }}</p>
                                    @endif
                                    @if($booking->hotel)
                                        <p>{{ $booking->hotel->name }}</p>
                                    @endif
                                </td>
                                <td>
                                    @if($booking->agency)
                                        <p>{{ $booking->agency->name }}</p>
                                    @endif
                                    @if($booking->supplier)
                                        <p>{{ $booking->supplier->name }}</p>
                                    @endif
                                </td>
                                <td>
                                    @if($booking->customer)
                                        {{ $booking->customer->name }}
                                    @endif
                                </td>
                                <td>
                                    <p>{{ $checkinDate  }} to</p>
                                    <p>{{ $checkoutDate  }}</p>
                                </td>
                                <td>
                                    @if (!empty($bookingStatuses[$booking->booking_status]))
                                        <p>{{ $bookingStatuses[$booking->booking_status] }}</p>
                                    @endif

                                    @if (!empty($paymentStatuses[$booking->payment_status]))
                                        <p>{{ $paymentStatuses[$booking->payment_status] }}</p>
                                    @endif

                                    @if (!empty($vendorPurchaseStatuses[$booking->vendor_purchase_status]))
                                        <p>{{ $vendorPurchaseStatuses[$booking->vendor_purchase_status] }}</p>
                                    @endif
                                </td>
                                <td>
                                    <p>{{ $booking->hotel_confirm_code }}</p>
                                    <p>{{ $booking->flight_code }}</p>
                                </td>
                                <td>
                                    {{ $codDate }}
                                </td>
                                <td>
                                    @if($booking->author)
                                        <p>{{ $booking->author->name }}</p>
                                    @endif
                                    @if($booking->sale)
                                        <p>{{ $booking->sale->name }}</p>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.booking.booking.edit', [$booking->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ route('admin.booking.booking.email', [$booking->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-envelope"></i></a>
                                        <button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.booking.booking.destroy', [$booking->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="3%">{{ trans('core::core.table.id') }}</th>
                                <th width="11%">{{ trans('booking::bookings.table.booking_number') }}</th>
                                <th width="11%">{{ trans('booking::bookings.table.campaign_id-hotel_id') }}</th>
                                <th width="7%">{{ trans('booking::bookings.table.agency_id-supplier_id') }}</th>
                                <th width="7%">{{ trans('booking::bookings.table.customer_id') }}</th>
                                <th width="8%">{{ trans('booking::bookings.table.checkin-checkout') }}</th>
                                <th width="17%">{{ trans('booking::bookings.table.status') }}</th>
                                <th width="10%">{{ trans('booking::bookings.table.hotel_confirm_code-flight_code') }}</th>
                                <th width="9%">{{ trans('booking::bookings.table.cod') }}</th>
                                <th width="8%">{{ trans('booking::bookings.table.sale_id-author_id') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')

    </div>
</div>

@push('js-stack')
    <script type="text/javascript">
        <?php $locale = locale(); ?>
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[0, "desc"]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@endpush