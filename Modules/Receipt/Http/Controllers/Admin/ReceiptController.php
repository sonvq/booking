<?php

namespace Modules\Receipt\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Booking\Entities\Booking;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Receipt\Entities\Receipt;
use Modules\Receipt\Http\Requests\CreateReceiptRequest;
use Modules\Receipt\Http\Requests\UpdateReceiptRequest;
use Modules\Receipt\Repositories\ReceiptRepository;
use Modules\User\Contracts\Authentication;
use Excel;

class ReceiptController extends AdminBaseController
{
    /**
     * @var ReceiptRepository
     */
    private $receipt;

    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(ReceiptRepository $receipt, Authentication $auth)
    {
        parent::__construct();

        $this->receipt = $receipt;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $receipts = Receipt::with(['booking'])->get();
        $receiptStatus = Receipt::status();
        $receiptType = Receipt::type();
        $receiptPaymentType = Receipt::paymentType();

        if (count($input) > 0) {
            $receiptQuery = Receipt::where('id', '>', 0);

            if (!empty($input['unique_number_filter'])) {
                $receiptQuery = $receiptQuery->where('unique_number', 'like', '%' . $input['unique_number_filter'] . '%');
            }

            if (!empty($input['booking_number_filter'])) {
                $receiptQuery = $receiptQuery->whereHas('booking', function($q) use ($input) {
                    $q->where('booking_number', 'like', '%' . $input['booking_number_filter'] . '%');
                });
            }

            if (!empty($input['type_filter'])) {
                $receiptQuery = $receiptQuery->where('type', $input['type_filter']);
            }

            if (!empty($input['amount_filter'])) {
                $receiptQuery = $receiptQuery->where('amount', 'like', '%' . $input['amount_filter'] . '%');
            }

            if (!empty($input['payment_type_filter'])) {
                $receiptQuery = $receiptQuery->where('payment_type', $input['payment_type_filter']);
            }

            if (!empty($input['status_filter'])) {
                $receiptQuery = $receiptQuery->where('status', $input['status_filter']);
            }

            if (!empty($input['start_date_filter'])) {
                $startDateFormatted = \DateTime::createFromFormat('d/m/Y', $input['start_date_filter'])->format('Y-m-d');
                $receiptQuery = $receiptQuery->where('start_date', '>=', $startDateFormatted);
            }
            if (!empty($input['end_date_filter'])) {
                $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $input['end_date_filter'])->format('Y-m-d');
                $receiptQuery = $receiptQuery->where('start_date', '<=', $endDateFormatted);
            }

            if (!empty($input['author_id_filter'])) {
                $receiptQuery = $receiptQuery->whereHas('author', function($q) use ($input) {
                    $q->where('name', 'like', '%' . $input['author_id_filter'] . '%');
                });
            }

            $receipts = $receiptQuery->get();

            $exportedFile = Excel::create(trans('receipt::receipts.title.export'), function ($excel) use ($receipts,
                $receiptStatus,
                $receiptType,
                $receiptPaymentType) {
                $excel->sheet(trans('receipt::receipts.title.export'), function ($sheet) use ($receipts,
                    $receiptStatus,
                    $receiptType,
                    $receiptPaymentType) {
                    $sheet->loadView('receipt::admin.receipts.export', array('receipts' => $receipts,
                        'status' => $receiptStatus,
                        'type' => $receiptType,
                        'paymentType' => $receiptPaymentType));
                });
            })->export('xls');

            return $exportedFile;
        }

        return view('receipt::admin.receipts.index', compact('receipts', 'receiptStatus', 'receiptType', 'receiptPaymentType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param null $booking
     * @return Response
     */
    public function create($booking = null)
    {
        $user = $this->auth->user();
        $canChangeStatus = ($user->hasRoleSlug(config('asgard.user.config.role-list.admin', ''))
            || $user->hasRoleSlug(config('asgard.user.config.role-list.manager', ''))
            || $user->hasRoleSlug(config('asgard.user.config.role-list.accountant', '')));

        $originalReceiptType = [
            Receipt::TYPE_BOOKING_PAYMENT,
            Receipt::TYPE_OTHER_EXPENSE,
        ];
        $receipts = Receipt::whereIn('type', $originalReceiptType)->get();
        $originalReceipts[''] = trans('receipt::receipts.form.empty_select_original_receipt');
        foreach ($receipts as $item) {
            $originalReceipts[$item->id] = $item->unique_number;
        }

        $types = Receipt::type();
        $paymentTypes = Receipt::paymentType();
        $statuses = Receipt::status();

        if (empty($booking)) {
            unset(
                $paymentTypes[Receipt::PAYMENT_TYPE_DEDUCT],
                $types[Receipt::TYPE_BOOKING_PAYMENT]
            );
        }

        return view('receipt::admin.receipts.create', compact('booking', 'originalReceipts',
            'canChangeStatus', 'types', 'paymentTypes', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateReceiptRequest $request
     * @return Response
     */
    public function store(CreateReceiptRequest $request)
    {
        $userId = $this->auth->id();
        $data = $request->all();

        $data['author_id'] = $userId;
        $data['unique_number'] = uniqid('PT', false);

        if (!empty($data['start_date'])) {
            $data['start_date'] = \DateTime::createFromFormat('d/m/Y', $data['start_date'])->format('Y-m-d');
        }

        $this->receipt->create($data);

        if (!empty($data['booking_id'])) {
            $booking = Booking::find($data['booking_id']);
            if ($booking) {
                $this->alterBookingStatus($booking);
            }
        }


        if (empty($data['booking_id'])) {
            return redirect()->route('admin.receipt.receipt.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('receipt::receipts.title.receipts')]));
        }

        return redirect()->route('admin.booking.booking.edit', [$data['booking_id']])
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('receipt::receipts.title.receipts')]));
    }

    /**
     * @param $booking
     */
    public function alterBookingStatus($booking)
    {
        if (!empty($booking)) {
            $bookingPendingReceiptCount = Receipt::where('status', Receipt::STATUS_PENDING)
                ->where('booking_id', $booking->id)
                ->count();

            $bookingConfirmedReceiptCount = Receipt::where('status', Receipt::STATUS_CONFIRMED)
                ->where('booking_id', $booking->id)
                ->count();

            $bookingConfirmedReceiptAmount = Receipt::where('status', Receipt::STATUS_CONFIRMED)
                ->where('booking_id', $booking->id)
                ->sum('amount');

            if ($bookingPendingReceiptCount > 0) {
                $booking->payment_status = Booking::PAYMENT_STATUS_PAYMENT_CONFIRMATION;
                $booking->save();
            } else {
                if ($bookingConfirmedReceiptCount > 0 && $bookingConfirmedReceiptAmount < $booking->total_sell_price) {
                    $booking->payment_status = Booking::PAYMENT_STATUS_PARTIALLY_PAID;
                    $booking->save();
                }

                if ($bookingConfirmedReceiptCount > 0 && $bookingConfirmedReceiptAmount >= $booking->total_sell_price) {
                    $booking->payment_status = Booking::PAYMENT_STATUS_FULLY_PAID;
                    $booking->save();
                }
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param  Receipt $receipt
     * @return Response
     */
    public function edit(Request $request, Receipt $receipt)
    {
        $data = $request->all();
        $origin_url = !empty($data['origin_url']) ? $data['origin_url'] : 'receipt';

        $user = $this->auth->user();
        $canChangeStatus = ($user->hasRoleSlug(config('asgard.user.config.role-list.admin', ''))
            || $user->hasRoleSlug(config('asgard.user.config.role-list.manager', ''))
            || $user->hasRoleSlug(config('asgard.user.config.role-list.accountant', '')));
        $booking = $receipt->booking;

        $originalReceiptType = [
            Receipt::TYPE_BOOKING_PAYMENT,
            Receipt::TYPE_OTHER_EXPENSE,
        ];
        $receipts = Receipt::whereIn('type', $originalReceiptType)->get();
        $originalReceipts[''] = trans('receipt::receipts.form.empty_select_original_receipt');
        foreach ($receipts as $item) {
            $originalReceipts[$item->id] = $item->unique_number;
        }

        $types = Receipt::type();
        $paymentTypes = Receipt::paymentType();
        $statuses = Receipt::status();

        if (empty($booking)) {
            unset(
                $paymentTypes[Receipt::PAYMENT_TYPE_DEDUCT],
                $types[Receipt::TYPE_BOOKING_PAYMENT]
            );
        }

        return view('receipt::admin.receipts.edit', compact('receipt', 'originalReceipts',
            'canChangeStatus', 'booking', 'types', 'paymentTypes', 'statuses', 'user', 'origin_url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Receipt $receipt
     * @param  UpdateReceiptRequest $request
     * @return Response
     */
    public function update(Receipt $receipt, UpdateReceiptRequest $request)
    {
        $data = $request->all();
        $origin_url = !empty($data['origin_url']) ? $data['origin_url'] : 'receipt';

        if (!empty($data['start_date'])) {
            $data['start_date'] = \DateTime::createFromFormat('d/m/Y', $data['start_date'])->format('Y-m-d');
        }

        $this->receipt->update($receipt, $data);

        if (!empty($data['booking_id'])) {
            $booking = Booking::find($data['booking_id']);
            if ($booking) {
                $this->alterBookingStatus($booking);
            }
        }

        if ($origin_url === 'booking') {
            return redirect()->route('admin.booking.booking.edit', [$data['booking_id']])
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('receipt::receipts.title.receipts')]));
        }

        return redirect()->route('admin.receipt.receipt.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('receipt::receipts.title.receipts')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Receipt $receipt
     * @return Response
     */
    public function destroy(Receipt $receipt)
    {
        $booking = $receipt->booking;

        $this->receipt->destroy($receipt);

        if (!empty($booking)) {
            $this->alterBookingStatus($booking);
        }

        return back()->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('receipt::receipts.title.receipts')]));
    }
}
