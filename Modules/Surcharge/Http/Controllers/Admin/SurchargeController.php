<?php

namespace Modules\Surcharge\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Entities\BaseModel;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\Surcharge\Entities\Surcharge;
use Modules\Surcharge\Http\Requests\CreateSurchargeRequest;
use Modules\Surcharge\Http\Requests\UpdateSurchargeRequest;
use Modules\Surcharge\Repositories\SurchargeRepository;

/**
 * Class SurchargeController
 * @package Modules\Surcharge\Http\Controllers\Admin
 */
class SurchargeController extends AdminBaseController
{
    /**
     * @var SurchargeRepository
     */
    private $surcharge;

    /**
     * @var HotelRepository
     */
    private $hotel;

    /**
     * SurchargeController constructor.
     * @param SurchargeRepository $surcharge
     * @param HotelRepository $hotel
     */
    public function __construct(SurchargeRepository $surcharge, HotelRepository $hotel)
    {
        parent::__construct();

        $this->surcharge = $surcharge;
        $this->hotel = $hotel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $surcharges = $this->surcharge->all();
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('surcharge::admin.surcharges.index', compact('surcharges', 'changes', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('surcharge::surcharges.form.hotel_id_empty_option'));

        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('surcharge::admin.surcharges.create', compact('hotels', 'changes', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSurchargeRequest $request
     * @return Response
     */
    public function store(CreateSurchargeRequest $request)
    {
        $data = $request->all();
        $surchargeCreated = $this->surcharge->create($data);

        /** @var Surcharge $surchargeCreated */
        $surchargeCreated->hotels()->sync($data['hotel_id']);

        return redirect()->route('admin.surcharge.surcharge.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('surcharge::surcharges.title.surcharges')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Surcharge $surcharge
     * @return Response
     */
    public function edit(Surcharge $surcharge)
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('surcharge::surcharges.form.hotel_id_empty_option'));

        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('surcharge::admin.surcharges.edit', compact('surcharge', 'hotels',
            'changes', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Surcharge $surcharge
     * @param  UpdateSurchargeRequest $request
     * @return Response
     */
    public function update(Surcharge $surcharge, UpdateSurchargeRequest $request)
    {
        $data = $request->all();

        $this->surcharge->update($surcharge, $data);

        $surcharge->hotels()->sync($data['hotel_id']);

        return redirect()->route('admin.surcharge.surcharge.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('surcharge::surcharges.title.surcharges')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Surcharge $surcharge
     * @return Response
     */
    public function destroy(Surcharge $surcharge)
    {
        $this->surcharge->destroy($surcharge);

        return redirect()->route('admin.surcharge.surcharge.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('surcharge::surcharges.title.surcharges')]));
    }
}
