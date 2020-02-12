<?php

namespace Modules\Booking\Http\Controllers\Admin;

use Excel;
use Illuminate\Http\Response;
use Modules\Agency\Repositories\AgencyRepository;
use Modules\Booking\Entities\Booking;
use Modules\Booking\Http\Requests\ReportBookingRequest;
use Modules\Booking\Repositories\BookingRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\User\Contracts\Authentication;

class BookingReportController extends AdminBaseController
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
            '' => trans('booking::bookings.form.empty_report_type'),
            'hotel_id' => trans('booking::bookings.form.hotel_id'),
            'campaign_id' => trans('booking::bookings.form.campaign_id'),
            'author_id' => trans('booking::bookings.form.author_id'),
            'sale_id' => trans('booking::bookings.form.sale_id'),
            'agency_id' => trans('booking::bookings.form.agency_id'),
        ];
    }

    /**
     * @return Response
     */
    public function index()
    {
        $reportType = $this->reportType;

        return view('booking::admin.bookings.report.index', compact('reportType'));
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
                $exportedFile = Excel::create(trans('booking::bookings.title.report booking'), function ($excel) use ($reports, $totalRow) {
                    $excel->sheet(trans('booking::bookings.title.report booking'), function ($sheet) use ($reports, $totalRow) {
                        $sheet->loadView('booking::admin.bookings.report.export', array('reports' => $reports, 'totalRow' => $totalRow));
                    });
                })->export('xls');

                return $exportedFile;
            }
        }
        return view('booking::admin.bookings.report.index', compact('reportType', 'reports', 'totalRow'));
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
            'total_profit' => 0,
            'total_night' => 0
        ];

        $bookings = Booking::where('checkout_date', '>=', $startDateFormatted)
            ->where('checkout_date', '<=', $endDateFormatted)
            ->where('booking_status', '=', Booking::BOOKING_STATUS_HOTEL_CONFIRMED)
            ->where('payment_status', '=', Booking::PAYMENT_STATUS_FULLY_PAID)
            ->where('vendor_purchase_status', '=', Booking::VENDOR_PURCHASE_STATUS_COMPLETED)
            ->get();

        $commonKey = $input['report_type'];
        $commonRelation = str_replace("_id", "", $input['report_type']);

        if (count($bookings) > 0) {
            foreach ($bookings as $booking) {
                if ($booking->$commonRelation) {
                    $name = $booking->$commonRelation->name;
                    $reports[$booking->$commonKey]['name'] = $name;
                    if (empty($reports[$booking->$commonKey]['total_amount'])) {
                        $reports[$booking->$commonKey]['total_amount'] = 0;
                    }
                    if (empty($reports[$booking->$commonKey]['total_profit'])) {
                        $reports[$booking->$commonKey]['total_profit'] = 0;
                    }
                    if (empty($reports[$booking->$commonKey]['total_night'])) {
                        $reports[$booking->$commonKey]['total_night'] = 0;
                    }

                    if ($commonKey === 'hotel_id') {
                        $reports[$booking->$commonKey]['total_amount'] += $booking->total_price;
                        $totalRow['total_amount'] += $booking->total_price;
                    } else {
                        $reports[$booking->$commonKey]['total_amount'] += $booking->total_sell_price;
                        $totalRow['total_amount'] += $booking->total_sell_price;
                    }
                    $reports[$booking->$commonKey]['total_profit'] += $booking->total_profit;
                    $totalRow['total_profit'] += $booking->total_profit;

                    $rooms = $booking->rooms()->get();
                    $totalNightPerBooking = 0;
                    foreach ($rooms as $room) {
                        $roomName = $room->name;
                        $roomCoefficient = 1;
                        preg_match('/\d+/', $roomName, $matches);
                        if (!empty($matches[0])) {
                            $roomCoefficient = $matches[0];
                        }

                        $nightEachRoom = $roomCoefficient * $room->pivot->quantity * round((strtotime($room->pivot->end_date) - strtotime($room->pivot->start_date)) / (60 * 60 * 24));
                        $totalNightPerBooking += $nightEachRoom;

                    }
                    $reports[$booking->$commonKey]['total_night'] += $totalNightPerBooking;
                    $totalRow['total_night'] += $totalNightPerBooking;
                }
            }
        }

        return [$reports, $totalRow];
    }
}
