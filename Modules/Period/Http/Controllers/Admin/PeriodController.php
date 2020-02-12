<?php

namespace Modules\Period\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Campaign\Entities\Campaign;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Country\Repositories\CountryRepository;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\Period\Entities\Period;
use Modules\Period\Entities\PeriodDate;
use Modules\Period\Http\Requests\CreatePeriodRequest;
use Modules\Period\Http\Requests\UpdatePeriodRequest;
use Modules\Period\Repositories\PeriodRepository;

class PeriodController extends AdminBaseController
{
    /**
     * @var PeriodRepository
     */
    private $period;

    /**
     * @var CountryRepository
     */
    private $country;

    /**
     * @var HotelRepository
     */
    private $hotel;

    /**
     * PeriodController constructor.
     * @param PeriodRepository $period
     * @param HotelRepository $hotel
     * @param CountryRepository $country
     */
    public function __construct(PeriodRepository $period, HotelRepository $hotel, CountryRepository $country)
    {
        parent::__construct();

        $this->period = $period;
        $this->hotel = $hotel;
        $this->country = $country;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $periods = $this->period->all();

        return view('period::admin.periods.index', compact('periods'));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function hotelCampaigns(Request $request)
    {
        $input = $request->all();
        $hotelIds = $input['hotel_ids'];

        $campaigns = Campaign::where(function ($qr) use ($hotelIds) {
            $qr->whereHas('hotels', function ($q) use ($hotelIds) {
                $q->whereIn('id', $hotelIds);
            })
                ->orHas('hotels', '=', 0);
        })
            ->get();

        return $this->prepareAjaxResult($campaigns);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('period::periods.form.hotel_id_empty_option'));

        $countryList = $this->country->all();
        $countries = $this->prepareDropdownData($countryList, trans('period::periods.form.country_id_empty_option'));

        return view('period::admin.periods.create', compact('hotels', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePeriodRequest $request
     * @return Response
     */
    public function store(CreatePeriodRequest $request)
    {
        $data = $request->all();

        $createdPeriod = $this->period->create($data);

        /** @var Period $createdPeriod */
        $createdPeriod->hotels()->sync($data['hotel_id']);

        if (!empty($data['country_id'])) {
            $createdPeriod->countries()->sync($data['country_id']);
        }

        $startDates = $data['start_date'];
        $endDates = $data['end_date'];
        $dateData = [];
        foreach ($startDates as $key => $startDate) {
            $startDateFormatted = \DateTime::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
            $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $endDates[$key])->format('Y-m-d');
            $dateData[] = new PeriodDate([
                'period_id' => $createdPeriod->id,
                'start_date' => $startDateFormatted,
                'end_date' => $endDateFormatted,
            ]);
        }

        $createdPeriod->dates()->saveMany($dateData);

        return redirect()->route('admin.period.period.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('period::periods.title.periods')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Period $period
     * @return Response
     */
    public function edit(Period $period)
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('period::periods.form.hotel_id_empty_option'));

        $countryList = $this->country->all();
        $countries = $this->prepareDropdownData($countryList, trans('period::periods.form.country_id_empty_option'));

        return view('period::admin.periods.edit', compact('period', 'hotels', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Period $period
     * @param  UpdatePeriodRequest $request
     * @return Response
     */
    public function update(Period $period, UpdatePeriodRequest $request)
    {
        $data = $request->all();

        $this->period->update($period, $data);

        $period->hotels()->sync($data['hotel_id']);

        if (!empty($data['country_id'])) {
            $period->countries()->sync($data['country_id']);
        } else {
            $period->countries()->sync([]);
        }

        $period->dates()->delete();

        $startDates = $data['start_date'];
        $endDates = $data['end_date'];
        $dateData = [];
        foreach ($startDates as $key => $startDate) {
            $startDateFormatted = \DateTime::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
            $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $endDates[$key])->format('Y-m-d');
            $dateData[] = new PeriodDate([
                'period_id' => $period->id,
                'start_date' => $startDateFormatted,
                'end_date' => $endDateFormatted,
            ]);
        }

        $period->dates()->saveMany($dateData);

        return redirect()->route('admin.period.period.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('period::periods.title.periods')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Period $period
     * @return Response
     */
    public function destroy(Period $period)
    {
        $this->period->destroy($period);

        return redirect()->route('admin.period.period.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('period::periods.title.periods')]));
    }
}
