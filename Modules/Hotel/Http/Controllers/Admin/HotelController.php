<?php

namespace Modules\Hotel\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Company\Repositories\CompanyRepository;
use Modules\Core\Entities\BaseModel;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Hotel\Entities\Hotel;
use Modules\Hotel\Http\Requests\CreateHotelRequest;
use Modules\Hotel\Http\Requests\UpdateHotelRequest;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\Region\Repositories\RegionRepository;

class HotelController extends AdminBaseController
{
    /**
     * @var HotelRepository
     */
    private $hotel;

    /**
     * @var CompanyRepository
     */
    private $company;

    /**
     * @var RegionRepository
     */
    private $region;

    /**
     * HotelController constructor.
     * @param HotelRepository $hotel
     * @param CompanyRepository $company
     * @param RegionRepository $region
     */
    public function __construct(HotelRepository $hotel, CompanyRepository $company, RegionRepository $region)
    {
        parent::__construct();

        $this->hotel = $hotel;
        $this->company = $company;
        $this->region = $region;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $hotels = Hotel::with(['region', 'company'])->get();

        return view('hotel::admin.hotels.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $companyList = $this->company->all();
        $companies = $this->prepareDropdownData($companyList, trans('hotel::hotels.form.company_id_empty_option'));

        $regionList = $this->region->all();
        $regions = $this->prepareDropdownData($regionList, trans('hotel::hotels.form.region_id_empty_option'));

        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('hotel::admin.hotels.create', compact('companies', 'regions', 'changes', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateHotelRequest $request
     * @return Response
     */
    public function store(CreateHotelRequest $request)
    {
        $this->hotel->create($request->all());

        return redirect()->route('admin.hotel.hotel.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('hotel::hotels.title.hotels')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Hotel $hotel
     * @return Response
     */
    public function edit(Hotel $hotel)
    {
        $companyList = $this->company->all();
        $companies = $this->prepareDropdownData($companyList, trans('hotel::hotels.form.company_id_empty_option'));

        $regionList = $this->region->all();
        $regions = $this->prepareDropdownData($regionList, trans('hotel::hotels.form.region_id_empty_option'));

        $changes = BaseModel::change();
        $types = BaseModel::type();

        $rooms = $hotel->rooms;

        return view('hotel::admin.hotels.edit', compact('hotel', 'companies', 'regions',
            'changes', 'types', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Hotel $hotel
     * @param  UpdateHotelRequest $request
     * @return Response
     */
    public function update(Hotel $hotel, UpdateHotelRequest $request)
    {
        $this->hotel->update($hotel, $request->all());

        return redirect()->route('admin.hotel.hotel.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('hotel::hotels.title.hotels')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Hotel $hotel
     * @return Response
     */
    public function destroy(Hotel $hotel)
    {
        $this->hotel->destroy($hotel);

        return redirect()->route('admin.hotel.hotel.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('hotel::hotels.title.hotels')]));
    }
}
