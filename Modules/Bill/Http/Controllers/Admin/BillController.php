<?php

namespace Modules\Bill\Http\Controllers\Admin;

use Excel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Bill\Entities\Bill;
use Modules\Bill\Http\Requests\CreateBillRequest;
use Modules\Bill\Http\Requests\UpdateBillRequest;
use Modules\Bill\Repositories\BillRepository;
use Modules\Booking\Entities\Booking;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;

/**
 * Class BillController
 * @package Modules\Bill\Http\Controllers\Admin
 */
class BillController extends AdminBaseController
{
    /**
     * @var BillRepository
     */
    private $bill;

    /**
     * @var Authentication
     */
    private $auth;

    /**
     * BillController constructor.
     * @param BillRepository $bill
     * @param Authentication $auth
     */
    public function __construct(BillRepository $bill, Authentication $auth)
    {
        parent::__construct();

        $this->bill = $bill;
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
        $bills = Bill::with(['booking'])->get();
        $billStatus = Bill::status();
        $billType = Bill::type();
        $billPaymentType = Bill::paymentType();

        if (count($input) > 0) {
            $billQuery = Bill::where('id', '>', 0);

            if (!empty($input['unique_number_filter'])) {
                $billQuery = $billQuery->where('unique_number', 'like', '%' . $input['unique_number_filter'] . '%');
            }

            if (!empty($input['booking_number_filter'])) {
                $billQuery = $billQuery->whereHas('booking', function ($q) use ($input) {
                    $q->where('booking_number', 'like', '%' . $input['booking_number_filter'] . '%');
                });
            }

            if (!empty($input['type_filter'])) {
                $billQuery = $billQuery->where('type', $input['type_filter']);
            }

            if (!empty($input['amount_filter'])) {
                $billQuery = $billQuery->where('amount', 'like', '%' . $input['amount_filter'] . '%');
            }

            if (!empty($input['payment_type_filter'])) {
                $billQuery = $billQuery->where('payment_type', $input['payment_type_filter']);
            }

            if (!empty($input['status_filter'])) {
                $billQuery = $billQuery->where('status', $input['status_filter']);
            }

            if (!empty($input['start_date_filter'])) {
                $startDateFormatted = \DateTime::createFromFormat('d/m/Y', $input['start_date_filter'])->format('Y-m-d');
                $billQuery = $billQuery->where('start_date', '>=', $startDateFormatted);
            }
            if (!empty($input['end_date_filter'])) {
                $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $input['end_date_filter'])->format('Y-m-d');
                $billQuery = $billQuery->where('start_date', '<=', $endDateFormatted);
            }

            if (!empty($input['author_id_filter'])) {
                $billQuery = $billQuery->whereHas('author', function ($q) use ($input) {
                    $q->where('name', 'like', '%' . $input['author_id_filter'] . '%');
                });
            }

            $bills = $billQuery->get();

            $exportedFile = Excel::create(trans('bill::bills.title.export'), function ($excel) use (
                $bills,
                $billStatus,
                $billType,
                $billPaymentType
            ) {
                $excel->sheet(trans('bill::bills.title.export'), function ($sheet) use (
                    $bills,
                    $billStatus,
                    $billType,
                    $billPaymentType
                ) {
                    $sheet->loadView('bill::admin.bills.export', array('bills' => $bills,
                        'status' => $billStatus,
                        'type' => $billType,
                        'paymentType' => $billPaymentType));
                });
            })->export('xls');

            return $exportedFile;
        }

        return view('bill::admin.bills.index', compact('bills', 'billStatus', 'billType', 'billPaymentType'));
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

        $originalBillType = [
            Bill::TYPE_BOOKING_PAYMENT,
            Bill::TYPE_OTHER_EXPENSE,
        ];
        $bills = Bill::whereIn('type', $originalBillType)->get();
        $originalBills[''] = trans('bill::bills.form.empty_select_original_bill');
        foreach ($bills as $item) {
            $originalBills[$item->id] = $item->unique_number;
        }

        $types = Bill::type();
        $paymentTypes = Bill::paymentType();
        $statuses = Bill::status();

        if (empty($booking)) {
            unset(
                $paymentTypes[Bill::PAYMENT_TYPE_DEDUCT],
                $types[Bill::TYPE_BOOKING_PAYMENT]
            );
        }

        return view('bill::admin.bills.create', compact('booking', 'originalBills', 'canChangeStatus',
            'types', 'paymentTypes', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBillRequest $request
     * @return Response
     */
    public function store(CreateBillRequest $request)
    {
        $userId = $this->auth->id();
        $data = $request->all();

        $data['author_id'] = $userId;
        $data['unique_number'] = uniqid('PC', false);

        if (!empty($data['start_date'])) {
            $data['start_date'] = \DateTime::createFromFormat('d/m/Y', $data['start_date'])->format('Y-m-d');
        }
        $this->bill->create($data);

        if (!empty($data['booking_id'])) {
            $booking = Booking::find($data['booking_id']);
            if ($booking) {
                $this->alterBookingStatus($booking);
            }
        }

        if (empty($data['booking_id'])) {
            return redirect()->route('admin.bill.bill.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('bill::bills.title.bills')]));
        }

        return redirect()->route('admin.booking.booking.edit', [$data['booking_id']])
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('bill::bills.title.bills')]));
    }

    /**
     * @param $booking
     */
    public function alterBookingStatus($booking)
    {
        if (!empty($booking)) {
            $bookingPendingBillCount = Bill::where('status', Bill::STATUS_PENDING)
                ->where('booking_id', $booking->id)
                ->count();

            $bookingConfirmedBillCount = Bill::where('status', Bill::STATUS_CONFIRMED)
                ->where('booking_id', $booking->id)
                ->count();

            $bookingConfirmedBillAmount = Bill::where('status', Bill::STATUS_CONFIRMED)
                ->where('booking_id', $booking->id)
                ->sum('amount');

            if ($bookingPendingBillCount === 0) {
                if ($bookingConfirmedBillCount > 0 && $bookingConfirmedBillAmount < $booking->total_buy_price) {
                    $booking->vendor_purchase_status = Booking::VENDOR_PURCHASE_STATUS_PARTIALLY_PAID;
                    $booking->save();
                }

                if ($bookingConfirmedBillCount > 0 && $bookingConfirmedBillAmount >= $booking->total_buy_price) {
                    $booking->vendor_purchase_status = Booking::VENDOR_PURCHASE_STATUS_COMPLETED;
                    $booking->save();
                }
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param  Bill $bill
     * @return Response
     */
    public function edit(Request $request, Bill $bill)
    {
        $data = $request->all();
        $origin_url = !empty($data['origin_url']) ? $data['origin_url'] : 'bill';

        $user = $this->auth->user();
        $canChangeStatus = ($user->hasRoleSlug(config('asgard.user.config.role-list.admin', ''))
            || $user->hasRoleSlug(config('asgard.user.config.role-list.manager', ''))
            || $user->hasRoleSlug(config('asgard.user.config.role-list.accountant', '')));
        $booking = $bill->booking;

        $originalBillType = [
            Bill::TYPE_BOOKING_PAYMENT,
            Bill::TYPE_OTHER_EXPENSE,
        ];
        $bills = Bill::whereIn('type', $originalBillType)->get();
        $originalBills[''] = trans('bill::bills.form.empty_select_original_bill');
        foreach ($bills as $item) {
            $originalBills[$item->id] = $item->unique_number;
        }

        $types = Bill::type();
        $paymentTypes = Bill::paymentType();
        $statuses = Bill::status();

        if (empty($booking)) {
            unset(
                $paymentTypes[Bill::PAYMENT_TYPE_DEDUCT],
                $types[Bill::TYPE_BOOKING_PAYMENT]
            );
        }

        return view('bill::admin.bills.edit', compact('bill', 'originalBills',
            'canChangeStatus', 'booking', 'types', 'paymentTypes', 'statuses', 'user', 'origin_url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Bill $bill
     * @param  UpdateBillRequest $request
     * @return Response
     */
    public function update(Bill $bill, UpdateBillRequest $request)
    {
        $data = $request->all();
        $origin_url = !empty($data['origin_url']) ? $data['origin_url'] : 'bill';

        if (!empty($data['start_date'])) {
            $data['start_date'] = \DateTime::createFromFormat('d/m/Y', $data['start_date'])->format('Y-m-d');
        }

        $this->bill->update($bill, $data);

        if (!empty($data['booking_id'])) {
            $booking = Booking::find($data['booking_id']);
            if ($booking) {
                $this->alterBookingStatus($booking);
            }
        }

        if ($origin_url === 'booking') {
            return redirect()->route('admin.booking.booking.edit', [$data['booking_id']])
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('bill::bills.title.bills')]));
        }

        return redirect()->route('admin.bill.bill.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('bill::bills.title.bills')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Bill $bill
     * @return Response
     */
    public function destroy(Bill $bill)
    {
        $booking = $bill->booking;

        $this->bill->destroy($bill);

        if (!empty($booking)) {
            $this->alterBookingStatus($booking);
        }

        return back()->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('bill::bills.title.bills')]));
    }
}
