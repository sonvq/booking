<?php

namespace Modules\Booking\Http\Controllers\Admin;

use Excel;
use Illuminate\Http\Response;
use Modules\Agency\Repositories\AgencyRepository;
use Modules\Bill\Entities\Bill;
use Modules\Booking\Entities\Booking;
use Modules\Booking\Http\Requests\ReportBookingRequest;
use Modules\Booking\Repositories\BookingRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\Receipt\Entities\Receipt;
use Modules\User\Contracts\Authentication;

class FinancialReportController extends AdminBaseController
{
    /**
     * @var BookingRepository
     */
    private $booking;

    /**
     * @var HotelRepository
     */
    private $hotel;

    /**
     * @var AgencyRepository
     */
    private $agency;

    /**
     * @var Authentication
     */
    private $auth;

    /**
     * @var CustomerRepository
     */
    private $customer;

    /**
     * @var []
     */
    private $reportType;

    /**
     * BookingController constructor.
     * @param BookingRepository $booking
     * @param HotelRepository $hotel
     * @param AgencyRepository $agency
     * @param CustomerRepository $customer
     * @param Authentication $auth
     */
    public function __construct(
        BookingRepository $booking,
        HotelRepository $hotel,
        AgencyRepository $agency,
        CustomerRepository $customer,
        Authentication $auth
    )
    {
        parent::__construct();

        $this->booking = $booking;
        $this->hotel = $hotel;
        $this->agency = $agency;
        $this->customer = $customer;
        $this->auth = $auth;
        $this->reportType = [
            '' => trans('booking::bookings.form.empty_financial_type'),
            'total_sell_price' => trans('booking::bookings.form.financial_report_choices.total_sell_price'),
            'total_buy_price' => trans('booking::bookings.form.financial_report_choices.total_buy_price'),
            'total_profit' => trans('booking::bookings.form.financial_report_choices.total_profit'),
            'total_customer_deposit' => trans('booking::bookings.form.financial_report_choices.total_customer_deposit'),
            'total_customer_in_debt' => trans('booking::bookings.form.financial_report_choices.total_customer_in_debt'),
            'total_hotel_in_debt' => trans('booking::bookings.form.financial_report_choices.total_hotel_in_debt'),
            'total_customer_deduct' => trans('booking::bookings.form.financial_report_choices.total_customer_deduct'),
            'total_hotel_deduct' => trans('booking::bookings.form.financial_report_choices.total_hotel_deduct'),
        ];
    }

    /**
     * @return Response
     */
    public function index()
    {
        $reportType = $this->reportType;

        return view('booking::admin.bookings.financial.index', compact('reportType'));
    }

    /**
     * @param ReportBookingRequest $request
     * @return Response
     */
    public function create(ReportBookingRequest $request)
    {
        $reportType = $this->reportType;
        $input = $request->all();

        if ($input['submit_button'] == 'Create Report') {
            list($reports, $totalRow) = $this->prepareExportData($input);
        } else {
            list($reports, $totalRow) = $this->prepareExportData($input);
            if (count($reports) > 0) {
                $exportedFile = Excel::create(trans('booking::bookings.title.financial booking'), function ($excel) use ($reports, $totalRow) {
                    $excel->sheet(trans('booking::bookings.title.financial booking'), function ($sheet) use ($reports, $totalRow) {
                        $sheet->loadView('booking::admin.bookings.financial.export', array('reports' => $reports, 'totalRow' => $totalRow));
                    });
                })->export('xls');

                return $exportedFile;
            }
        }

        return view('booking::admin.bookings.financial.index', compact('reportType', 'reports', 'totalRow'));
    }


    /**
     * @param array $input
     * @return array
     */
    public function prepareExportData(array $input)
    {
        $reports = [];
        $startDateFormatted = \DateTime::createFromFormat('d/m/Y', $input['start_date'])->format('Y-m-d');
        $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $input['end_date'])->format('Y-m-d');
        $totalRow = [
            'total_amount' => 0,
        ];

        $bookingsCompleted = Booking::where('checkout_date', '>=', $startDateFormatted)
            ->where('checkout_date', '<=', $endDateFormatted)
            ->where('booking_status', '=', Booking::BOOKING_STATUS_HOTEL_CONFIRMED)
            ->where('payment_status', '=', Booking::PAYMENT_STATUS_FULLY_PAID)
            ->where('vendor_purchase_status', '=', Booking::VENDOR_PURCHASE_STATUS_COMPLETED)
            ->get();

        $receiptOtherExpenses = Receipt::where('start_date', '>=', $startDateFormatted)
            ->where('start_date', '<=', $endDateFormatted)
            ->where('type', Receipt::TYPE_OTHER_EXPENSE)
            ->where('status', Receipt::STATUS_CONFIRMED)
            ->get();

        $billsSalaryExpenses = Bill::where('start_date', '>=', $startDateFormatted)
            ->where('start_date', '<=', $endDateFormatted)
            ->where('type', Bill::TYPE_SALARY)
            ->where('status', Bill::STATUS_CONFIRMED)
            ->get();

        $billsTaxExpenses = Bill::where('start_date', '>=', $startDateFormatted)
            ->where('start_date', '<=', $endDateFormatted)
            ->where('type', Bill::TYPE_TAX)
            ->where('status', Bill::STATUS_CONFIRMED)
            ->get();

        $billsMarketingExpenses = Bill::where('start_date', '>=', $startDateFormatted)
            ->where('start_date', '<=', $endDateFormatted)
            ->where('type', Bill::TYPE_MARKETING_EXPENSE)
            ->where('status', Bill::STATUS_CONFIRMED)
            ->get();

        $billsOfficeExpenses = Bill::where('start_date', '>=', $startDateFormatted)
            ->where('start_date', '<=', $endDateFormatted)
            ->where('type', Bill::TYPE_OFFICE_EXPENSE)
            ->where('status', Bill::STATUS_CONFIRMED)
            ->get();

        $billsOtherExpenses = Bill::where('start_date', '>=', $startDateFormatted)
            ->where('start_date', '<=', $endDateFormatted)
            ->where('type', Bill::TYPE_OTHER_EXPENSE)
            ->where('status', Bill::STATUS_CONFIRMED)
            ->get();

        $bookingsNotCancelled = Booking::where('cod', '>=', $startDateFormatted)
            ->where('cod', '<=', $endDateFormatted)
            ->whereNotIn('booking_status', [Booking::BOOKING_STATUS_CUSTOMER_REJECTED, Booking::BOOKING_STATUS_HOTEL_REJECTED, Booking::BOOKING_STATUS_PENALTY_FOR_CANCELLATION])
            ->get();

        $deductReceipts = Receipt::where('start_date', '>=', $startDateFormatted)
            ->where('start_date', '<=', $endDateFormatted)
            ->where('payment_type', Receipt::PAYMENT_TYPE_DEDUCT)
            ->where('status', Receipt::STATUS_CONFIRMED)
            ->get();

        $deductBills = Bill::where('start_date', '>=', $startDateFormatted)
            ->where('start_date', '<=', $endDateFormatted)
            ->where('payment_type', Bill::PAYMENT_TYPE_DEDUCT)
            ->where('status', Bill::STATUS_CONFIRMED)
            ->get();

        $reportType = $input['report_type'];

        if ($reportType === 'total_sell_price') {
            list($reports, $totalRow) = $this->calculateTotalSellPrice($bookingsCompleted, $receiptOtherExpenses);
        } else if ($reportType === 'total_buy_price') {
            list($reports, $totalRow) = $this->calculateTotalBuyPrice($bookingsCompleted, $billsSalaryExpenses, $billsTaxExpenses, $billsMarketingExpenses, $billsOfficeExpenses, $billsOtherExpenses);
        } else if ($reportType === 'total_profit') {
            list($reportSellPrices, $totalRowSellPrice) = $this->calculateTotalSellPrice($bookingsCompleted, $receiptOtherExpenses);
            list($reportBuyPrices, $totalRowBuyPrice) = $this->calculateTotalBuyPrice($bookingsCompleted, $billsSalaryExpenses, $billsTaxExpenses, $billsMarketingExpenses, $billsOfficeExpenses, $billsOtherExpenses);
            $reports['result']['name'] = trans('booking::bookings.title.financial-report.total_profit');
            $reports['result']['amount'] = $totalRowSellPrice['total_amount'] - $totalRowBuyPrice['total_amount'];
            $totalRow['total_amount'] = $totalRowSellPrice['total_amount'] - $totalRowBuyPrice['total_amount'];
        } else if ($reportType === 'total_customer_deposit') {
            list($reports, $totalRow) = $this->calculateTotalCustomerDeposit($bookingsNotCancelled);
        } else if ($reportType === 'total_customer_in_debt') {
            list($reports, $totalRow) = $this->calculateTotalCustomerInDept($bookingsNotCancelled);
        } else if ($reportType === 'total_hotel_in_debt') {
            list($reports, $totalRow) = $this->calculateTotalHotelInDebt($bookingsNotCancelled);
        } else if ($reportType === 'total_customer_deduct') {
            list($reports, $totalRow) = $this->calculateTotalCustomerDeduct($deductReceipts);
        } else if ($reportType === 'total_hotel_deduct') {
            list($reports, $totalRow) = $this->calculateTotalHotelDeduct($deductBills);
        }

        return [$reports, $totalRow];
    }

    /**
     * @param $bookingsCompleted
     * @param $receiptOtherExpenses
     * @return array
     */
    public function calculateTotalSellPrice($bookingsCompleted, $receiptOtherExpenses)
    {
        $reports = [];
        $totalRow = [
            'total_amount' => 0,
        ];

        $keys = [
            'booking',
            'other'
        ];
        foreach ($keys as $key) {
            $reports[$key]['name'] = trans('booking::bookings.title.financial-report.' . $key);
            if (empty($reports[$key]['amount'])) {
                $reports[$key]['amount'] = 0;
            }
        }

        if (count($bookingsCompleted) > 0) {
            foreach ($bookingsCompleted as $booking) {
                $reports['booking']['amount'] += $booking->total_sell_price;
            }
        }
        if (count($receiptOtherExpenses) > 0) {
            foreach ($receiptOtherExpenses as $receiptOtherExpense) {
                $reports['other']['amount'] += $receiptOtherExpense->amount;
            }
        }
        foreach ($keys as $key) {
            $totalRow['total_amount'] += $reports[$key]['amount'];
        }

        return [$reports, $totalRow];
    }

    /**
     * @param $bookingsCompleted
     * @param $billsSalaryExpenses
     * @param $billsTaxExpenses
     * @param $billsMarketingExpenses
     * @param $billsOfficeExpenses
     * @param $billsOtherExpenses
     * @return array
     */
    public function calculateTotalBuyPrice($bookingsCompleted, $billsSalaryExpenses, $billsTaxExpenses, $billsMarketingExpenses, $billsOfficeExpenses, $billsOtherExpenses)
    {
        $reports = [];
        $totalRow = [
            'total_amount' => 0,
        ];

        $keys = [
            'booking',
            'salary',
            'tax',
            'marketing_expense',
            'office_expense',
            'other_expense'
        ];
        foreach ($keys as $key) {
            $reports[$key]['name'] = trans('booking::bookings.title.financial-report.' . $key);
            if (empty($reports[$key]['amount'])) {
                $reports[$key]['amount'] = 0;
            }
        }
        if (count($bookingsCompleted) > 0) {
            foreach ($bookingsCompleted as $booking) {
                $reports['booking']['amount'] += $booking->total_buy_price;
            }
        }
        if (count($billsSalaryExpenses) > 0) {
            foreach ($billsSalaryExpenses as $bill) {
                $reports['salary']['amount'] += $bill->amount;
            }
        }
        if (count($billsTaxExpenses) > 0) {
            foreach ($billsTaxExpenses as $bill) {
                $reports['tax']['amount'] += $bill->amount;
            }
        }
        if (count($billsMarketingExpenses) > 0) {
            foreach ($billsMarketingExpenses as $bill) {
                $reports['marketing_expense']['amount'] += $bill->amount;
            }
        }
        if (count($billsOfficeExpenses) > 0) {
            foreach ($billsOfficeExpenses as $bill) {
                $reports['office_expense']['amount'] += $bill->amount;
            }
        }
        if (count($billsOtherExpenses) > 0) {
            foreach ($billsOtherExpenses as $bill) {
                $reports['other_expense']['amount'] += $bill->amount;
            }
        }

        foreach ($keys as $key) {
            $totalRow['total_amount'] += $reports[$key]['amount'];
        }

        return [$reports, $totalRow];
    }

    /**
     * @param $bookingsNotCancelled
     * @return array
     */
    public function calculateTotalCustomerDeposit($bookingsNotCancelled)
    {
        $reports = [];
        $totalRow = [
            'total_amount' => 0,
        ];

        if (count($bookingsNotCancelled) > 0) {
            foreach ($bookingsNotCancelled as $booking) {
                $reports[$booking->customer_id]['name'] = $booking->customer->name;
                if (empty($reports[$booking->customer_id]['total_sell_price'])) {
                    $reports[$booking->customer_id]['total_sell_price'] = 0;
                }
                if (empty($reports[$booking->customer_id]['total_buy_price'])) {
                    $reports[$booking->customer_id]['total_buy_price'] = 0;
                }
                if (empty($reports[$booking->customer_id]['total_receipt_amount'])) {
                    $reports[$booking->customer_id]['total_receipt_amount'] = 0;
                }
                if (empty($reports[$booking->customer_id]['total_bill_amount'])) {
                    $reports[$booking->customer_id]['total_bill_amount'] = 0;
                }
                $reports[$booking->customer_id]['total_sell_price'] += $booking->total_sell_price;
                $reports[$booking->customer_id]['total_receipt_amount'] += $booking->confirmedReceipt->sum('amount');
                $reports[$booking->customer_id]['total_buy_price'] += $booking->total_buy_price;
                $reports[$booking->customer_id]['total_bill_amount'] += $booking->confirmedBill->sum('amount');

                $reports[$booking->customer_id]['min_total_sell_price_and_receipt_amount'] = min(
                    $reports[$booking->customer_id]['total_sell_price'],
                    $reports[$booking->customer_id]['total_receipt_amount']
                );

                $reports[$booking->customer_id]['min_total_buy_price_and_bill_amount'] = min(
                    $reports[$booking->customer_id]['total_buy_price'],
                    $reports[$booking->customer_id]['total_bill_amount']
                );

                $reports[$booking->customer_id]['amount'] = $reports[$booking->customer_id]['min_total_sell_price_and_receipt_amount'] - $reports[$booking->customer_id]['min_total_buy_price_and_bill_amount'];
            }
            foreach($reports as $key => $report) {
                $totalRow['total_amount'] += $report['amount'];
                if ($report['amount'] === 0) {
                    unset($reports[$key]);
                }
            }
        }
        return [$reports, $totalRow];
    }

    /**
     * @param $bookingsNotCancelled
     * @return array
     */
    public function calculateTotalCustomerInDept($bookingsNotCancelled)
    {
        $reports = [];
        $totalRow = [
            'total_amount' => 0,
        ];

        if (count($bookingsNotCancelled) > 0) {
            foreach ($bookingsNotCancelled as $booking) {
                $reports[$booking->customer_id]['name'] = $booking->customer->name;
                if (empty($reports[$booking->customer_id]['total_sell_price'])) {
                    $reports[$booking->customer_id]['total_sell_price'] = 0;
                }

                if (empty($reports[$booking->customer_id]['total_receipt_amount'])) {
                    $reports[$booking->customer_id]['total_receipt_amount'] = 0;
                }

                $reports[$booking->customer_id]['total_sell_price'] += $booking->total_sell_price;
                $reports[$booking->customer_id]['total_receipt_amount'] += $booking->confirmedReceipt->sum('amount');

                $reports[$booking->customer_id]['min_total_sell_price_and_receipt_amount'] = min(
                    $reports[$booking->customer_id]['total_sell_price'],
                    $reports[$booking->customer_id]['total_receipt_amount']
                );

                $reports[$booking->customer_id]['amount'] = $reports[$booking->customer_id]['total_sell_price'] - $reports[$booking->customer_id]['min_total_sell_price_and_receipt_amount'];
            }
            foreach($reports as $key => $report) {
                $totalRow['total_amount'] += $report['amount'];
                if ($report['amount'] === 0) {
                    unset($reports[$key]);
                }
            }
        }
        return [$reports, $totalRow];
    }

    /**
     * @param $bookingsNotCancelled
     * @return array
     */
    public function calculateTotalHotelInDebt($bookingsNotCancelled)
    {
        $reports = [];
        $totalRow = [
            'total_amount' => 0,
        ];

        if (count($bookingsNotCancelled) > 0) {
            foreach ($bookingsNotCancelled as $booking) {
                $reports[$booking->hotel_id]['name'] = $booking->hotel->name;
                if (empty($reports[$booking->hotel_id]['total_buy_price'])) {
                    $reports[$booking->hotel_id]['total_buy_price'] = 0;
                }

                if (empty($reports[$booking->hotel_id]['total_bill_amount'])) {
                    $reports[$booking->hotel_id]['total_bill_amount'] = 0;
                }

                $reports[$booking->hotel_id]['total_buy_price'] += $booking->total_buy_price;
                $reports[$booking->hotel_id]['total_bill_amount'] += $booking->confirmedBill->sum('amount');

                $reports[$booking->hotel_id]['min_total_buy_price_and_bill_amount'] = min(
                    $reports[$booking->hotel_id]['total_buy_price'],
                    $reports[$booking->hotel_id]['total_bill_amount']
                );

                $reports[$booking->hotel_id]['amount'] = $reports[$booking->hotel_id]['total_buy_price'] - $reports[$booking->hotel_id]['min_total_buy_price_and_bill_amount'];
            }
            foreach($reports as $key => $report) {
                $totalRow['total_amount'] += $report['amount'];
                if ($report['amount'] === 0) {
                    unset($reports[$key]);
                }
            }
        }
        return [$reports, $totalRow];
    }

    /**
     * @param $deductReceipts
     * @return array
     */
    public function calculateTotalCustomerDeduct($deductReceipts)
    {
        $reports = [];
        $totalRow = [
            'total_amount' => 0,
        ];

        if (count($deductReceipts) > 0) {
            foreach ($deductReceipts as $receipt) {
                $reports[$receipt->booking->customer_id]['name'] = $receipt->booking->customer->name;
                if (empty($reports[$receipt->booking->customer_id]['amount'])) {
                    $reports[$receipt->booking->customer_id]['amount'] = 0;
                }

                $reports[$receipt->booking->customer_id]['amount'] += $receipt->amount;
            }
            foreach($reports as $key => $report) {
                $totalRow['total_amount'] += $report['amount'];
            }
        }

        return [$reports, $totalRow];
    }

    /**
     * @param $deductBills
     * @return array
     */
    public function calculateTotalHotelDeduct($deductBills)
    {
        $reports = [];
        $totalRow = [
            'total_amount' => 0,
        ];

        if (count($deductBills) > 0) {
            foreach ($deductBills as $bill) {
                $reports[$bill->booking->hotel_id]['name'] = $bill->booking->hotel->name;
                if (empty($reports[$bill->booking->hotel_id]['amount'])) {
                    $reports[$bill->booking->hotel_id]['amount'] = 0;
                }

                $reports[$bill->booking->hotel_id]['amount'] += $bill->amount;
            }
            foreach($reports as $key => $report) {
                $totalRow['total_amount'] += $report['amount'];
            }
        }

        return [$reports, $totalRow];
    }

}
