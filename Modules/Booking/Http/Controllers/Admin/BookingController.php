<?php

namespace Modules\Booking\Http\Controllers\Admin;

use Carbon\Carbon;
use Excel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Modules\Agency\Entities\Agency;
use Modules\Agency\Repositories\AgencyRepository;
use Modules\Bill\Entities\Bill;
use Modules\Booking\Entities\Booking;
use Modules\Booking\Http\Requests\CreateBookingRequest;
use Modules\Booking\Http\Requests\UpdateBookingRequest;
use Modules\Booking\Repositories\BookingRepository;
use Modules\Campaign\Entities\Campaign;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Email\Entities\Email;
use Modules\Hotel\Entities\Hotel;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\Period\Entities\Period;
use Modules\Receipt\Entities\Receipt;
use Modules\Room\Entities\Room;
use Modules\Service\Entities\Service;
use Modules\Supplier\Entities\Supplier;
use Modules\Supplier\Repositories\SupplierRepository;
use Modules\Surcharge\Entities\Surcharge;
use Modules\User\Contracts\Authentication;
use Modules\User\Entities\Sentinel\User;

class BookingController extends AdminBaseController
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
     * @var SupplierRepository
     */
    private $supplier;

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
     * @param SupplierRepository $supplier
     */
    public function __construct(
        BookingRepository $booking,
        HotelRepository $hotel,
        AgencyRepository $agency,
        CustomerRepository $customer,
        Authentication $auth,
        SupplierRepository $supplier
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
        $this->supplier = $supplier;
    }

    /**
     * @param Booking $booking
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Webklex\IMAP\Exceptions\MaskNotFoundException
     */
    public function email(Booking $booking)
    {
        $oClient = \Webklex\IMAP\Facades\Client::account('default');

        //Connect to the IMAP Server
        $oClient->connect();

        $sentFolder = $oClient->getFolder('[Gmail]/T&HqU-t c&HqM- th&AbA-');
        $emails = $sentFolder->query()->text($booking->booking_number)->get();

        $email = Email::where('type', Email::TYPE_BOOKING)
            ->where('status', Email::STATUS_PUBLISH)
            ->first();
        $newContent = '';
        $newSubject = '';

        if ($email) {
            $content = $email->content;
            $subject = $email->subject;
            $search = [
                '[customer_name]',
                '[room_info]',
                '[checkin_date]',
                '[checkout_date]',
                '[booking_number]',
                '[hotel_name]',
                '[campaign_name]',
                '[customer_info]',
                '[service_info]',
                '[surcharge_info]'
            ];

            $roomInfo = "";
            $rooms = $booking->rooms()->get();
            if (count($rooms) > 0) {
                $roomInfo = $roomInfo . "<table border='1' style='border: 1px solid #ddd'>
<tr>
<th>" . trans('booking::bookings.form.room_id') . "</th>
<th>" . trans('booking::bookings.form.quantity') . "</th>
<th>" . trans('booking::bookings.form.start_date') . "</th>
<th>" . trans('booking::bookings.form.end_date') . "</th>
<th>" . trans('booking::bookings.form.buy_price') . "</th>
</tr>";
                foreach ($rooms as $room) {
                    $quantity = $room->pivot->quantity;
                    $buyPrice = $room->pivot->buy_price;
                    $roomStartDate = \DateTime::createFromFormat('Y-m-d', $room->pivot->start_date)->format('d/m/Y');
                    $roomEndDate = \DateTime::createFromFormat('Y-m-d', $room->pivot->end_date)->format('d/m/Y');
                    $roomInfo = $roomInfo . "<tr>
<td>$room->name</td>
<td>$quantity</td>
<td>$roomStartDate</td>
<td>$roomEndDate</td>
<td>$buyPrice</td>
</tr>";
                }
                $roomInfo = $roomInfo . "</table>";
            }

            $serviceInfo = "";
            $services = $booking->services()->get();
            if (count($services) > 0) {
                $serviceInfo .= "<table border='1' style='border: 1px solid #ddd'>
<tr>
<th>" . trans('booking::bookings.form.service_id') . "</th>
<th>" . trans('booking::bookings.form.quantity') . "</th>
<th>" . trans('booking::bookings.form.start_date') . "</th>
<th>" . trans('booking::bookings.form.end_date') . "</th>
<th>" . trans('booking::bookings.form.buy_price') . "</th>
</tr>";
                foreach ($services as $service) {
                    $quantity = $service->pivot->quantity;
                    $buyPrice = $service->pivot->buy_price;
                    $serviceStartDate = \DateTime::createFromFormat('Y-m-d', $service->pivot->start_date)->format('d/m/Y');
                    $serviceEndDate = \DateTime::createFromFormat('Y-m-d', $service->pivot->end_date)->format('d/m/Y');
                    $serviceInfo = $serviceInfo . "<tr>
<td>$service->name</td>
<td>$quantity</td>
<td>$serviceStartDate</td>
<td>$serviceEndDate</td>
<td>$buyPrice</td>
</tr>";
                }
                $serviceInfo = $serviceInfo . "</table>";
            }

            $surchargeInfo = "";
            $surcharges = $booking->surcharges()->get();
            if (count($surcharges) > 0) {
                $surchargeInfo .= "<table border='1' style='border: 1px solid #ddd'>
<tr>
<th>" . trans('booking::bookings.form.surcharge_id') . "</th>
<th>" . trans('booking::bookings.form.quantity') . "</th>
<th>" . trans('booking::bookings.form.start_date') . "</th>
<th>" . trans('booking::bookings.form.end_date') . "</th>
<th>" . trans('booking::bookings.form.buy_price') . "</th>
</tr>";
                foreach ($surcharges as $surcharge) {
                    $quantity = $surcharge->pivot->quantity;
                    $buyPrice = $surcharge->pivot->buy_price;
                    $surchargeStartDate = \DateTime::createFromFormat('Y-m-d', $surcharge->pivot->start_date)->format('d/m/Y');
                    $surchargeEndDate = \DateTime::createFromFormat('Y-m-d', $surcharge->pivot->end_date)->format('d/m/Y');
                    $surchargeInfo = $surchargeInfo . "<tr>
<td>$surcharge->name</td>
<td>$quantity</td>
<td>$surchargeStartDate</td>
<td>$surchargeEndDate</td>
<td>$buyPrice</td>
</tr>";
                }
                $surchargeInfo .= "</table>";
            }

            $customerInfo = "<table border='0'>";
            if (!empty($booking->customer->email)) {
                $customerInfo .= "<td style='padding: 0px 20px 0px 0px'>Email: " . $booking->customer->email . "</td>";
            }
            if (!empty($booking->customer->telephone)) {
                $customerInfo .= "<td style='padding: 0px 20px 0px 0px'>SĐT: " . $booking->customer->telephone. "</td>";
            }
            if (!empty($booking->customer->identity)) {
                $customerInfo .= "<td style='padding: 0px 20px 0px 0px'>CMT: " . $booking->customer->identity . "</td>";
            }
            $customerInfo .= "</table>";

            $replaceWith = [
                $booking->customer->name,
                $roomInfo,
                \DateTime::createFromFormat('Y-m-d', $booking->checkin_date)->format('d/m/Y'),
                \DateTime::createFromFormat('Y-m-d', $booking->checkout_date)->format('d/m/Y'),
                $booking->booking_number,
                $booking->hotel->name,
                $booking->campaign->name,
                $customerInfo,
                $serviceInfo,
                $surchargeInfo
            ];
            $newContent = str_replace($search, $replaceWith, $content);
            $newSubject = str_replace($search, $replaceWith, $subject);
        }

        return view('booking::admin.bookings.email', compact('booking', 'email', 'newContent', 'newSubject', 'emails'));
    }

    /**
     * @param Booking $booking
     * @param Request $request
     * @return mixed
     */
    public function send(Booking $booking, Request $request)
    {
        $input = $request->all();

        $now = Carbon::now()->format('Y-m-d');

        if (strtotime($now) > strtotime($booking->cod) && $booking->payment_status !== Booking::PAYMENT_STATUS_FULLY_PAID) {
            return redirect()->route('admin.booking.booking.email', ['booking' => $booking])
                ->withError(trans('booking::bookings.messages.email sent fail because of booking status', ['name' => trans('booking::bookings.title.email')]));
        }

        try {
            Mail::send('booking::admin.bookings.email.booking_email', ['content' => $input['content']], function ($m) use ($input, $booking) {
                $m->to($booking->hotel->email)->subject($input['subject']);
            });

            return redirect()->route('admin.booking.booking.email', ['booking' => $booking])
                ->withSuccess(trans('booking::bookings.messages.email sent successfully', ['name' => trans('booking::bookings.title.email')]));
        } catch (\Exception $e) {
            return redirect()->route('admin.booking.booking.email', ['booking' => $booking])
                ->withError(trans('booking::bookings.messages.email sent fail', ['name' => trans('booking::bookings.title.email')]));
        }
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
        $bookingStatuses = Booking::bookingStatus();
        $paymentStatuses = Booking::paymentStatus();
        $vendorPurchaseStatuses = Booking::vendorPurchaseStatus();

        $user = $this->auth->user();
        $isOperator = $user->hasRoleSlug(config('asgard.user.config.role-list.operator', ''));
        $currentUserName = $user->name;

        if (count($input) > 0) {
            $bookingQuery = Booking::where('id', '>', 0);

            if (!empty($input['booking_number_filter'])) {
                $bookingQuery = $bookingQuery->where('booking_number', 'like', '%' . $input['booking_number_filter'] . '%');
            }
            if (!empty($input['hotel_id_filter'])) {
                $bookingQuery = $bookingQuery->whereHas('hotel', function ($q) use ($input) {
                    $q->where('name', 'like', '%' . $input['hotel_id_filter'] . '%');
                });
            }
            if (!empty($input['agency_id_filter'])) {
                $bookingQuery = $bookingQuery->whereHas('agency', function ($q) use ($input) {
                    $q->where('name', 'like', '%' . $input['agency_id_filter'] . '%');
                });
            }
            if (!empty($input['supplier_id_filter'])) {
                $bookingQuery = $bookingQuery->whereHas('supplier', function ($q) use ($input) {
                    $q->where('name', 'like', '%' . $input['supplier_id_filter'] . '%');
                });
            }
            if (!empty($input['customer_id_filter'])) {
                $bookingQuery = $bookingQuery->whereHas('customer', function ($q) use ($input) {
                    $q->where('name', 'like', '%' . $input['customer_id_filter'] . '%');
                });
            }
            if (!empty($input['date_filter'])) {
                if (!empty($input['start_date_filter'])) {
                    $startDateFormatted = \DateTime::createFromFormat('d/m/Y', $input['start_date_filter'])->format('Y-m-d');
                    $bookingQuery = $bookingQuery->where($input['date_filter'], '>=', $startDateFormatted);
                }
                if (!empty($input['end_date_filter'])) {
                    $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $input['end_date_filter'])->format('Y-m-d');
                    $bookingQuery = $bookingQuery->where($input['date_filter'], '<=', $endDateFormatted);
                }
            }

            if (!empty($input['booking_status_filter'])) {
                $bookingQuery = $bookingQuery->where('booking_status', $input['booking_status_filter']);
            }
            if (!empty($input['payment_status_filter'])) {
                $bookingQuery = $bookingQuery->where('payment_status', $input['payment_status_filter']);
            }
            if (!empty($input['vendor_purchase_status_filter'])) {
                $bookingQuery = $bookingQuery->where('vendor_purchase_status', $input['vendor_purchase_status_filter']);
            }
            if (!empty($input['hotel_confirm_code_filter'])) {
                $bookingQuery = $bookingQuery->where('hotel_confirm_code', 'like', '%' . $input['hotel_confirm_code_filter'] . '%');
            }
            if (!empty($input['flight_code_filter'])) {
                $bookingQuery = $bookingQuery->where('flight_code', 'like', '%' . $input['flight_code_filter'] . '%');
            }
            if (!empty($input['author_id_filter'])) {
                $bookingQuery = $bookingQuery->whereHas('author', function ($q) use ($input) {
                    $q->where('name', 'like', '%' . $input['author_id_filter'] . '%');
                });
            }
            if (!empty($input['sale_id_filter'])) {
                $bookingQuery = $bookingQuery->whereHas('sale', function ($q) use ($input) {
                    $q->where('name', 'like', '%' . $input['sale_id_filter'] . '%');
                });
            }
            if (!empty($input['campaign_id_filter'])) {
                $bookingQuery = $bookingQuery->whereHas('campaign', function ($q) use ($input) {
                    $q->where('name', 'like', '%' . $input['campaign_id_filter'] . '%');
                });
            }

            if (!empty($input['booking_type_filter'])) {
                $today = date('Y-m-d');
                $todayPlusSevenDays = date('Y-m-d', strtotime('+7 days', strtotime($today)));
                if ($input['booking_type_filter'] === 'booking_urgent') {
                    $bookingQuery = $bookingQuery->whereIn('booking_status', [
                        Booking::BOOKING_STATUS_CREATED,
                        Booking::BOOKING_STATUS_HOTEL_SENT,
                        Booking::BOOKING_STATUS_HOTEL_CONFIRMED
                    ])
                        ->where(function ($q) {
                            $q->where('payment_status', '!=', Booking::PAYMENT_STATUS_FULLY_PAID)
                                ->orWhere('vendor_purchase_status', '!=', Booking::VENDOR_PURCHASE_STATUS_COMPLETED);
                        })
                        ->where('cod', '<=', $today);
                } else if ($input['booking_type_filter'] === 'booking_in_due') {
                    $bookingQuery = $bookingQuery->whereIn('booking_status', [
                        Booking::BOOKING_STATUS_CREATED,
                        Booking::BOOKING_STATUS_HOTEL_SENT,
                        Booking::BOOKING_STATUS_HOTEL_CONFIRMED
                    ])
                        ->where(function ($q) {
                            $q->where('payment_status', '!=', Booking::PAYMENT_STATUS_FULLY_PAID)
                                ->orWhere('vendor_purchase_status', '!=', Booking::VENDOR_PURCHASE_STATUS_COMPLETED);
                        })
                        ->where('cod', '>', $today)
                        ->where('cod', '<=', $todayPlusSevenDays);
                } else if ($input['booking_type_filter'] === 'booking_completed') {
                    $bookingQuery = $bookingQuery->where('booking_status', Booking::BOOKING_STATUS_HOTEL_CONFIRMED)
                        ->where('payment_status', Booking::PAYMENT_STATUS_FULLY_PAID)
                        ->where('vendor_purchase_status', Booking::VENDOR_PURCHASE_STATUS_COMPLETED);
                } else if ($input['booking_type_filter'] === 'booking_cancelled') {
                    $bookingQuery = $bookingQuery->where(function ($q) {
                        $q->where('booking_status', Booking::BOOKING_STATUS_HOTEL_REJECTED)
                            ->orWhere('booking_status', Booking::BOOKING_STATUS_CUSTOMER_REJECTED)
                            ->orWhere('booking_status', Booking::BOOKING_STATUS_PENALTY_FOR_CANCELLATION);
                    });
                } else if ($input['booking_type_filter'] === 'booking_in_dept') {
                    $bookingQuery = $bookingQuery->whereIn('booking_status', [
                        Booking::BOOKING_STATUS_CREATED,
                        Booking::BOOKING_STATUS_HOTEL_SENT,
                        Booking::BOOKING_STATUS_HOTEL_CONFIRMED
                    ])
                        ->where('payment_status', '!=', Booking::PAYMENT_STATUS_FULLY_PAID)
                        ->whereIn('vendor_purchase_status', [
                            Booking::VENDOR_PURCHASE_STATUS_COMPLETED,
                            Booking::VENDOR_PURCHASE_STATUS_PARTIALLY_PAID
                        ]);
                } else if ($input['booking_type_filter'] === 'booking_customer_balance') {
                    $bookingQuery = $bookingQuery->whereIn('booking_status', [
                        Booking::BOOKING_STATUS_CREATED,
                        Booking::BOOKING_STATUS_HOTEL_SENT,
                        Booking::BOOKING_STATUS_HOTEL_CONFIRMED
                    ])
                        ->whereHas('confirmedReceipt', function ($qr) {
                            $qr->havingRaw('SUM(amount) > total_sell_price');
                        });
                } else if ($input['booking_type_filter'] === 'booking_hotel_balance') {
                    $bookingQuery = $bookingQuery->whereIn('booking_status', [
                        Booking::BOOKING_STATUS_CREATED,
                        Booking::BOOKING_STATUS_HOTEL_SENT,
                        Booking::BOOKING_STATUS_HOTEL_CONFIRMED
                    ])
                        ->whereHas('confirmedBill', function ($qr) {
                            $qr->havingRaw('SUM(amount) > total_buy_price');
                        });
                }

            }
            $bookings = $bookingQuery->get();

            $exportedFile = Excel::create(trans('booking::bookings.title.export'), function ($excel) use (
                $bookings,
                $bookingStatuses,
                $paymentStatuses,
                $vendorPurchaseStatuses
            ) {
                $excel->sheet(trans('booking::bookings.title.export'), function ($sheet) use (
                    $bookings,
                    $bookingStatuses,
                    $paymentStatuses,
                    $vendorPurchaseStatuses
                ) {
                    $sheet->loadView('booking::admin.bookings.export', array('bookings' => $bookings,
                        'bookingStatuses' => $bookingStatuses,
                        'paymentStatuses' => $paymentStatuses,
                        'vendorPurchaseStatuses' => $vendorPurchaseStatuses));
                });
            })->export('xls');

            return $exportedFile;
        }

        $bookings = Booking::with(['customer', 'hotel'])->orderBy('checkin_date', 'asc')->get();

        return view('booking::admin.bookings.index', compact('bookings',
            'bookingStatuses', 'paymentStatuses', 'vendorPurchaseStatuses', 'isOperator', 'currentUserName'));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function hotelRooms(Request $request)
    {
        $rooms = $this->getRoomList($request);

        return $this->prepareAjaxResult($rooms);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection|Room[]
     */
    private function getRoomList(Request $request)
    {
        $input = $request->all();
        $hotelId = $input['hotel_id'];
        $campaignId = $input['campaign_id'];

        $rooms = Room::whereHas('hotels', function ($q) use ($hotelId) {
            $q->where('id', $hotelId);
        })
            ->whereHas('campaigns', function ($q) use ($campaignId) {
                $q->where('id', $campaignId);
            })
            ->get();

        return $rooms;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function hotelServices(Request $request)
    {
        $services = $this->getServiceList($request);

        return $this->prepareAjaxResult($services);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection|Service[]
     */
    private function getServiceList(Request $request)
    {
        $input = $request->all();
        $hotelId = $input['hotel_id'];
        $campaignId = $input['campaign_id'];

        $services = Service::whereHas('hotels', function ($q) use ($hotelId) {
            $q->where('id', $hotelId);
        })
            ->whereHas('campaigns', function ($q) use ($campaignId) {
                $q->where('id', $campaignId);
            })
            ->get();

        return $services;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function hotelSurcharges(Request $request)
    {
        $surcharges = $this->getSurchargeList($request);

        return $this->prepareAjaxResult($surcharges);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection|Surcharge[]
     */
    private function getSurchargeList(Request $request)
    {
        $input = $request->all();
        $hotelId = $input['hotel_id'];
        $campaignId = $input['campaign_id'];

        $surcharges = Surcharge::whereHas('hotels', function ($q) use ($hotelId) {
            $q->where('id', $hotelId);
        })
            ->whereHas('campaigns', function ($q) use ($campaignId) {
                $q->where('id', $campaignId);
            })
            ->get();

        return $surcharges;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function hotelCampaigns(Request $request)
    {
        $input = $request->all();
        $hotelId = $input['hotel_id'];

        $checkinDate = $input['checkin_date'];
        $checkinDateFormatted = \DateTime::createFromFormat('d/m/Y', $checkinDate)->format('Y-m-d');

        $customerId = $input['customer_id'];
        $customer = Customer::find($customerId);

        $campaigns = new Collection();

        if ($customer) {
            $countryId = $customer->country_id;
            $periodIds = Period::whereHas('hotels', function ($q) use ($hotelId) {
                $q->where('id', $hotelId);
            })
                ->whereHas('dates', function ($q) use ($checkinDateFormatted) {
                    $q->where('start_date', '<=', $checkinDateFormatted)
                        ->where('end_date', '>=', $checkinDateFormatted);
                })
                ->where(function ($qr) use ($countryId) {
                    $qr->whereHas('countries', function ($q) use ($countryId) {
                        $q->where('id', $countryId);
                    })
                        ->orHas('countries', '=', 0);
                })
                ->groupBy('campaign_id')
                ->pluck('campaign_id')
                ->toArray();

            if (count($periodIds) > 0) {
                $campaigns = Campaign::whereIn('id', $periodIds)->get();
            }

        }


        return $this->prepareAjaxResult($campaigns);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function sellBuyPrice(Request $request)
    {
        $input = $request->all();
        $campaignId = $input['campaign_id'];
        $hotelId = $input['hotel_id'];
        $agencyId = $input['agency_id'];
        $supplierId = $input['supplier_id'];
        $isAdjustSurchargeService = $input['is_adjust_surcharge'];
        $rooms = $this->getRoomList($request);
        $services = $this->getServiceList($request);
        $surcharges = $this->getSurchargeList($request);

        $resultRoomPrice = [];
        foreach ($rooms as $item) {
            /** @var Room $item */
            $temp['id'] = $item->id;

            $roomPrice = $item->price;
            $buyPrice = $sellPrice = $roomPrice;

            /**
             * Calculate the buy price for room
             */
            $campaign = Campaign::find($campaignId);
            if ($campaign && $this->calculateAmountByObject($campaign, $roomPrice) !== null) {
                $buyPrice = $this->calculateAmountByObject($campaign, $roomPrice);
            } else {
                $supplier = Supplier::find($supplierId);
                if ($supplier && $this->calculateAmountByObject($supplier, $roomPrice) !== null) {
                    $buyPrice = $this->calculateAmountByObject($supplier, $roomPrice);
                } else {
                    $hotel = Hotel::find($hotelId);
                    if ($hotel && $this->calculateAmountBySaleType($hotel, $roomPrice, 'buy') !== null) {
                        $buyPrice = $this->calculateAmountBySaleType($hotel, $roomPrice, 'buy');
                    } else {
                        $company = $hotel->company;
                        if ($company && $this->calculateAmountBySaleType($company, $roomPrice, 'buy') !== null) {
                            $buyPrice = $this->calculateAmountBySaleType($company, $roomPrice, 'buy');
                        }
                    }
                }
            }

            /**
             * Calculate the sell price for room
             */
            if ($this->calculateAmountByObject($item, $roomPrice) !== null) {
                $sellPrice = $this->calculateAmountByObject($item, $roomPrice);
            } else {
                $promotion = $item->promotions()->first();
                if ($promotion && $this->calculateAmountByObject($promotion, $roomPrice) !== null) {
                    $sellPrice = $this->calculateAmountByObject($promotion, $roomPrice);
                } else {
                    $agency = Agency::find($agencyId);
                    if ($agency && $this->calculateAmountByObject($agency, $roomPrice) !== null) {
                        $sellPrice = $this->calculateAmountByObject($agency, $roomPrice);
                    } else {
                        $hotel = Hotel::find($hotelId);
                        if ($hotel && $this->calculateAmountBySaleType($hotel, $roomPrice, 'sell') !== null) {
                            $sellPrice = $this->calculateAmountBySaleType($hotel, $roomPrice, 'sell');
                        } else {
                            $company = $hotel->company;
                            if ($company && $this->calculateAmountBySaleType($company, $roomPrice, 'sell') !== null) {
                                $sellPrice = $this->calculateAmountBySaleType($company, $roomPrice, 'sell');
                            }
                        }
                    }
                }
            }

            $temp['buy_price'] = round($buyPrice);
            $temp['sell_price'] = round($sellPrice);
            $temp['actual_price'] = round($item->price);
            $resultRoomPrice[$item->id] = $temp;
        }

        $resultServicePrice = [];
        foreach ($services as $item) {
            /** @var Service $item */
            $temp['id'] = $item->id;

            $servicePrice = $item->price;
            $buyPrice = $sellPrice = $servicePrice;

            if ($isAdjustSurchargeService === '1') {
                /**
                 * Calculate the buy price for service
                 */
                $campaign = Campaign::find($campaignId);
                if ($campaign && $this->calculateAmountByObject($campaign, $servicePrice) !== null) {
                    $buyPrice = $this->calculateAmountByObject($campaign, $servicePrice);
                } else {
                    $supplier = Supplier::find($supplierId);
                    if ($supplier && $this->calculateAmountByObject($supplier, $servicePrice) !== null) {
                        $buyPrice = $this->calculateAmountByObject($supplier, $servicePrice);
                    } else {
                        $hotel = Hotel::find($hotelId);
                        if ($hotel && $this->calculateAmountBySaleType($hotel, $servicePrice, 'buy') !== null) {
                            $buyPrice = $this->calculateAmountBySaleType($hotel, $servicePrice, 'buy');
                        } else {
                            $company = $hotel->company;
                            if ($company && $this->calculateAmountBySaleType($company, $servicePrice, 'buy') !== null) {
                                $buyPrice = $this->calculateAmountBySaleType($company, $servicePrice, 'buy');
                            }
                        }
                    }
                }

                /**
                 * Calculate the sell price for service
                 */
                if ($this->calculateAmountByObject($item, $servicePrice) !== null) {
                    $sellPrice = $this->calculateAmountByObject($item, $servicePrice);
                } else {
                    $agency = Agency::find($agencyId);
                    if ($agency && $this->calculateAmountByObject($agency, $servicePrice) !== null) {
                        $sellPrice = $this->calculateAmountByObject($agency, $servicePrice);
                    } else {
                        $hotel = Hotel::find($hotelId);
                        if ($hotel && $this->calculateAmountBySaleType($hotel, $servicePrice, 'sell') !== null) {
                            $sellPrice = $this->calculateAmountBySaleType($hotel, $servicePrice, 'sell');
                        } else {
                            $company = $hotel->company;
                            if ($company && $this->calculateAmountBySaleType($company, $servicePrice, 'sell') !== null) {
                                $sellPrice = $this->calculateAmountBySaleType($company, $servicePrice, 'sell');
                            }
                        }
                    }
                }
            }

            $temp['buy_price'] = round($buyPrice);
            $temp['sell_price'] = round($sellPrice);
            $temp['actual_price'] = round($item->price);
            $resultServicePrice[$item->id] = $temp;
        }

        $resultSurchargePrice = [];
        foreach ($surcharges as $item) {
            /** @var Surcharge $item */
            $temp['id'] = $item->id;

            $surchargePrice = $item->price;
            $buyPrice = $sellPrice = $surchargePrice;

            if ($isAdjustSurchargeService === '1') {
                /**
                 * Calculate the buy price for surcharge
                 */
                $campaign = Campaign::find($campaignId);
                if ($campaign && $this->calculateAmountByObject($campaign, $surchargePrice) !== null) {
                    $buyPrice = $this->calculateAmountByObject($campaign, $surchargePrice);
                } else {
                    $supplier = Supplier::find($supplierId);
                    if ($supplier && $this->calculateAmountByObject($supplier, $surchargePrice) !== null) {
                        $buyPrice = $this->calculateAmountByObject($supplier, $surchargePrice);
                    } else {
                        $hotel = Hotel::find($hotelId);
                        if ($hotel && $this->calculateAmountBySaleType($hotel, $surchargePrice, 'buy') !== null) {
                            $buyPrice = $this->calculateAmountBySaleType($hotel, $surchargePrice, 'buy');
                        } else {
                            $company = $hotel->company;
                            if ($company && $this->calculateAmountBySaleType($company, $surchargePrice, 'buy') !== null) {
                                $buyPrice = $this->calculateAmountBySaleType($company, $surchargePrice, 'buy');
                            }
                        }
                    }
                }

                /**
                 * Calculate the sell price for surcharge
                 */
                if ($this->calculateAmountByObject($item, $surchargePrice) !== null) {
                    $sellPrice = $this->calculateAmountByObject($item, $surchargePrice);
                } else {
                    $agency = Agency::find($agencyId);
                    if ($agency && $this->calculateAmountByObject($agency, $surchargePrice) !== null) {
                        $sellPrice = $this->calculateAmountByObject($agency, $surchargePrice);
                    } else {
                        $hotel = Hotel::find($hotelId);
                        if ($hotel && $this->calculateAmountBySaleType($hotel, $surchargePrice, 'sell') !== null) {
                            $sellPrice = $this->calculateAmountBySaleType($hotel, $surchargePrice, 'sell');
                        } else {
                            $company = $hotel->company;
                            if ($company && $this->calculateAmountBySaleType($company, $surchargePrice, 'sell') !== null) {
                                $sellPrice = $this->calculateAmountBySaleType($company, $surchargePrice, 'sell');
                            }
                        }
                    }
                }
            }

            $temp['buy_price'] = round($buyPrice);
            $temp['sell_price'] = round($sellPrice);
            $temp['actual_price'] = round($item->price);
            $resultSurchargePrice[$item->id] = $temp;
        }

        $result['room_price'] = (count($resultRoomPrice) > 0) ? $resultRoomPrice : 0;
        $result['service_price'] = (count($resultServicePrice) > 0) ? $resultServicePrice : 0;
        $result['surcharge_price'] = (count($resultSurchargePrice) > 0) ? $resultSurchargePrice : 0;

        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('booking::bookings.form.hotel_id_empty_option'));

        $agencyList = $this->agency->all();
        $agencies = $this->prepareDropdownData($agencyList, trans('booking::bookings.form.agency_id_empty_option'));

        $supplierList = $this->supplier->all();
        $suppliers = $this->prepareDropdownData($supplierList, trans('booking::bookings.form.supplier_id_empty_option'));

        $saleRoleSlug = config('asgard.user.config.role-list.sale', '');
        $saleList = User::whereHas('roles', function ($q) use ($saleRoleSlug) {
            $q->where('slug', $saleRoleSlug);
        })->get();
        $sales = $this->prepareDropdownData($saleList, trans('booking::bookings.form.sale_id_empty_option'));

        $customerList = $this->customer->all();
        $customers = $this->prepareDropdownData($customerList, trans('booking::bookings.form.customer_id_empty_option'));

        return view('booking::admin.bookings.create', compact(
            'hotels',
            'agencies',
            'sales',
            'customers',
            'suppliers'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBookingRequest $request
     * @return Response
     */
    public function store(CreateBookingRequest $request)
    {
        $userId = $this->auth->id();
        $data = $request->all();

        $data['author_id'] = $userId;

        if (!empty($data['checkin_date'])) {
            $data['cod'] = \DateTime::createFromFormat('d/m/Y', $data['checkin_date'])->format('Y-m-d');
        }

        if (!empty($data['checkin_date']) && !empty($data['hotel_id']) && !empty($data['customer_id'])) {
            $customerId = $data['customer_id'];
            $customer = Customer::find($customerId);

            if ($customer) {
                $countryId = $customer->country_id;
                $hotelId = $data['hotel_id'];
                $checkinDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['checkin_date'])->format('Y-m-d');

                $period = Period::whereHas('hotels', function ($q) use ($hotelId) {
                    $q->where('id', $hotelId);
                })
                    ->whereHas('countries', function ($q) use ($countryId) {
                        $q->where('id', $countryId);
                    })
                    ->whereHas('dates', function ($q) use ($checkinDateFormatted) {
                        $q->where('start_date', '<=', $checkinDateFormatted)
                            ->where('end_date', '>=', $checkinDateFormatted);
                    })
                    ->where('campaign_id', $data['campaign_id'])
                    ->first();
                if ($period) {
                    $dateCheckin = \DateTime::createFromFormat('d/m/Y', $data['checkin_date']);
                    if ($period->cod > 0) {
                        $modifyString = '-' . $period->cod . ' days';
                        $dateCheckin->modify($modifyString);
                        $data['cod'] = $dateCheckin->format('Y-m-d');
                    }
                }
            }
        }

        if (!empty($data['checkin_date'])) {
            $data['checkin_date'] = \DateTime::createFromFormat('d/m/Y', $data['checkin_date'])->format('Y-m-d');
        }

        if (!empty($data['checkout_date'])) {
            $data['checkout_date'] = \DateTime::createFromFormat('d/m/Y', $data['checkout_date'])->format('Y-m-d');
        }

        if (!empty($data['is_adjust_surcharge']) && $data['is_adjust_surcharge'] === 'on') {
            $data['is_adjust_surcharge'] = 1;
        } else {
            $data['is_adjust_surcharge'] = 0;
        }

        if (!empty($data['is_adjust_price']) && $data['is_adjust_price'] === 'on') {
            $data['is_adjust_price'] = 1;
        } else {
            $data['is_adjust_price'] = 0;
        }

        $data['booking_number'] = uniqid('VO', false);

        $createdBooking = $this->booking->create($data);

        if (!empty($data['room_id']) && count($data['room_id']) > 0) {
            $roomData = [];
            foreach ($data['room_id'] as $key => $roomId) {
                $startDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['start_date'][$key])->format('Y-m-d');
                $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['end_date'][$key])->format('Y-m-d');

                $roomData[] = [
                    'room_id' => $roomId,
                    'quantity' => $data['quantity'][$key],
                    'start_date' => $startDateFormatted,
                    'end_date' => $endDateFormatted,
                    'buy_price' => $data['buy_price'][$key],
                    'sell_price' => $data['sell_price'][$key],
                ];
            }

            /** @var Booking $createdBooking */
            $createdBooking->rooms()->sync($roomData);
        }

        if (!empty($data['service_id']) && count($data['service_id']) > 0) {
            $serviceData = [];
            foreach ($data['service_id'] as $key => $serviceId) {
                $startDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['service_start_date'][$key])->format('Y-m-d');
                $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['service_end_date'][$key])->format('Y-m-d');
                $serviceData[] = [
                    'service_id' => $serviceId,
                    'quantity' => $data['service_quantity'][$key],
                    'start_date' => $startDateFormatted,
                    'end_date' => $endDateFormatted,
                    'buy_price' => $data['service_buy_price'][$key],
                    'sell_price' => $data['service_sell_price'][$key],
                ];
            }
            $createdBooking->services()->sync($serviceData);
        }

        if (!empty($data['surcharge_id']) && count($data['surcharge_id']) > 0) {
            $surchargeData = [];
            foreach ($data['surcharge_id'] as $key => $surchargeId) {
                $startDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['surcharge_start_date'][$key])->format('Y-m-d');
                $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['surcharge_end_date'][$key])->format('Y-m-d');
                $surchargeData[] = [
                    'surcharge_id' => $surchargeId,
                    'quantity' => $data['surcharge_quantity'][$key],
                    'start_date' => $startDateFormatted,
                    'end_date' => $endDateFormatted,
                    'buy_price' => $data['surcharge_buy_price'][$key],
                    'sell_price' => $data['surcharge_sell_price'][$key],
                ];
            }
            $createdBooking->surcharges()->sync($surchargeData);
        }

        return redirect()->route('admin.booking.booking.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('booking::bookings.title.bookings')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Booking $booking
     * @return Response
     */
    public function edit(Booking $booking)
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('booking::bookings.form.hotel_id_empty_option'));

        $agencyList = $this->agency->all();
        $agencies = $this->prepareDropdownData($agencyList, trans('booking::bookings.form.agency_id_empty_option'));

        $supplierList = $this->supplier->all();
        $suppliers = $this->prepareDropdownData($supplierList, trans('booking::bookings.form.supplier_id_empty_option'));

        $saleRoleSlug = config('asgard.user.config.role-list.sale', '');
        $saleList = User::whereHas('roles', function ($q) use ($saleRoleSlug) {
            $q->where('slug', $saleRoleSlug);
        })->get();
        $sales = $this->prepareDropdownData($saleList, trans('booking::bookings.form.sale_id_empty_option'));

        $customerList = $this->customer->all();
        $customers = $this->prepareDropdownData($customerList, trans('booking::bookings.form.customer_id_empty_option'));

        $bills = Bill::where('booking_id', $booking->id)->get();
        $receipts = Receipt::where('booking_id', $booking->id)->get();

        $bookingStatuses = Booking::bookingStatus();
        $paymentStatuses = Booking::paymentStatus();
        $vendorPurchaseStatuses = Booking::vendorPurchaseStatus();
        $checkinDate = \DateTime::createFromFormat('Y-m-d', $booking->checkin_date)->format('d/m/Y');
        $checkoutDate = \DateTime::createFromFormat('Y-m-d', $booking->checkout_date)->format('d/m/Y');
        $codDate = \DateTime::createFromFormat('Y-m-d', $booking->cod)->format('d/m/Y');

        $receiptStatus = Receipt::status();
        $receiptType = Receipt::type();
        $receiptPaymentType = Receipt::paymentType();

        $billStatus = Bill::status();
        $billType = Bill::type();
        $billPaymentType = Bill::paymentType();


        return view('booking::admin.bookings.edit', compact('booking', 'hotels',
            'agencies', 'sales', 'customers', 'bills', 'receipts', 'bookingStatuses', 'paymentStatuses',
            'vendorPurchaseStatuses', 'checkinDate', 'checkoutDate', 'codDate',
            'receiptStatus', 'receiptType', 'receiptPaymentType',
            'billStatus', 'billType', 'billPaymentType', 'suppliers'));
    }

    /**
     * @param Request $request
     * @return string
     */
    public function updateStatus(Request $request)
    {
        $input = $request->all();
        $status = $input['status'];
        $type = $input['type'];
        $bookingId = $input['id'];

        $booking = Booking::find($bookingId);
        $dataUpdate = [
            $type => $status
        ];

        if ($booking) {
            $this->booking->update($booking, $dataUpdate);
            return 'success';
        }
        return 'fail';
    }

    /**
     * @param Request $request
     * @return string
     */
    public function cod(Request $request)
    {
        $data = $request->all();
        $result = '';
        if (!empty($data['checkin_date'])) {
            $result = $data['checkin_date'];
        }

        if (!empty($data['checkin_date']) && !empty($data['hotel_id']) && !empty($data['customer_id'])) {
            $customerId = $data['customer_id'];
            $customer = Customer::find($customerId);

            if ($customer) {
                $countryId = $customer->country_id;
                $hotelId = $data['hotel_id'];
                $checkinDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['checkin_date'])->format('Y-m-d');

                $period = Period::whereHas('hotels', function ($q) use ($hotelId) {
                    $q->where('id', $hotelId);
                })
                    ->whereHas('countries', function ($q) use ($countryId) {
                        $q->where('id', $countryId);
                    })
                    ->whereHas('dates', function ($q) use ($checkinDateFormatted) {
                        $q->where('start_date', '<=', $checkinDateFormatted)
                            ->where('end_date', '>=', $checkinDateFormatted);
                    })
                    ->first();
                if ($period) {
                    $dateCheckin = \DateTime::createFromFormat('d/m/Y', $data['checkin_date']);
                    if ($period->cod > 0) {
                        $modifyString = '-' . $period->cod . ' days';
                        $dateCheckin->modify($modifyString);
                        $result = $dateCheckin->format('d/m/Y');
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Booking $booking
     * @param  UpdateBookingRequest $request
     * @return Response
     */
    public function update(Booking $booking, UpdateBookingRequest $request)
    {
        $data = $request->all();

        if (!empty($data['checkin_date'])) {
            $data['cod'] = \DateTime::createFromFormat('d/m/Y', $data['checkin_date'])->format('Y-m-d');
        }

        if (!empty($data['checkin_date']) && !empty($data['hotel_id']) && !empty($data['customer_id'])) {
            $customerId = $data['customer_id'];
            $customer = Customer::find($customerId);

            if ($customer) {
                $countryId = $customer->country_id;
                $hotelId = $data['hotel_id'];
                $checkinDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['checkin_date'])->format('Y-m-d');

                $period = Period::whereHas('hotels', function ($q) use ($hotelId) {
                    $q->where('id', $hotelId);
                })
                    ->whereHas('countries', function ($q) use ($countryId) {
                        $q->where('id', $countryId);
                    })
                    ->whereHas('dates', function ($q) use ($checkinDateFormatted) {
                        $q->where('start_date', '<=', $checkinDateFormatted)
                            ->where('end_date', '>=', $checkinDateFormatted);
                    })
                    ->first();
                if ($period) {
                    $dateCheckin = \DateTime::createFromFormat('d/m/Y', $data['checkin_date']);
                    if ($period->cod > 0) {
                        $modifyString = '-' . $period->cod . ' days';
                        $dateCheckin->modify($modifyString);
                        $data['cod'] = $dateCheckin->format('Y-m-d');
                    }
                }
            }
        }


        if (!empty($data['checkin_date'])) {
            $data['checkin_date'] = \DateTime::createFromFormat('d/m/Y', $data['checkin_date'])->format('Y-m-d');
        }

        if (!empty($data['checkout_date'])) {
            $data['checkout_date'] = \DateTime::createFromFormat('d/m/Y', $data['checkout_date'])->format('Y-m-d');
        }

        if (!empty($data['is_adjust_surcharge']) && $data['is_adjust_surcharge'] === 'on') {
            $data['is_adjust_surcharge'] = 1;
        } else {
            $data['is_adjust_surcharge'] = 0;
        }

        if (!empty($data['is_adjust_price']) && $data['is_adjust_price'] === 'on') {
            $data['is_adjust_price'] = 1;
        } else {
            $data['is_adjust_price'] = 0;
        }

        $this->booking->update($booking, $data);

        if (!empty($data['room_id']) && count($data['room_id']) > 0) {
            $roomData = [];
            foreach ($data['room_id'] as $key => $roomId) {
                $startDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['start_date'][$key])->format('Y-m-d');
                $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['end_date'][$key])->format('Y-m-d');

                $roomData[] = [
                    'room_id' => $roomId,
                    'quantity' => $data['quantity'][$key],
                    'start_date' => $startDateFormatted,
                    'end_date' => $endDateFormatted,
                    'buy_price' => $data['buy_price'][$key],
                    'sell_price' => $data['sell_price'][$key],
                ];
            }
            $booking->rooms()->sync($roomData);
        }

        if (!empty($data['service_id']) && count($data['service_id']) > 0) {
            $serviceData = [];
            foreach ($data['service_id'] as $key => $serviceId) {
                $startDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['service_start_date'][$key])->format('Y-m-d');
                $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['service_end_date'][$key])->format('Y-m-d');
                $serviceData[] = [
                    'service_id' => $serviceId,
                    'quantity' => $data['service_quantity'][$key],
                    'start_date' => $startDateFormatted,
                    'end_date' => $endDateFormatted,
                    'buy_price' => $data['service_buy_price'][$key],
                    'sell_price' => $data['service_sell_price'][$key],
                ];
            }
            $booking->services()->sync($serviceData);
        }

        if (!empty($data['surcharge_id']) && count($data['surcharge_id']) > 0) {
            $surchargeData = [];
            foreach ($data['surcharge_id'] as $key => $surchargeId) {
                $startDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['surcharge_start_date'][$key])->format('Y-m-d');
                $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $data['surcharge_end_date'][$key])->format('Y-m-d');
                $surchargeData[] = [
                    'surcharge_id' => $surchargeId,
                    'quantity' => $data['surcharge_quantity'][$key],
                    'start_date' => $startDateFormatted,
                    'end_date' => $endDateFormatted,
                    'buy_price' => $data['surcharge_buy_price'][$key],
                    'sell_price' => $data['surcharge_sell_price'][$key],
                ];
            }
            $booking->surcharges()->sync($surchargeData);
        }

        return redirect()->route('admin.booking.booking.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('booking::bookings.title.bookings')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Booking $booking
     * @return Response
     */
    public function destroy(Booking $booking)
    {
        $this->booking->destroy($booking);

        return redirect()->back()
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('booking::bookings.title.bookings')]));
    }
}
