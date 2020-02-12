<?php

namespace Modules\Service\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Entities\BaseModel;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\Service\Entities\Service;
use Modules\Service\Http\Requests\CreateServiceRequest;
use Modules\Service\Http\Requests\UpdateServiceRequest;
use Modules\Service\Repositories\ServiceRepository;

class ServiceController extends AdminBaseController
{
    /**
     * @var ServiceRepository
     */
    private $service;

    /**
     * @var HotelRepository
     */
    private $hotel;

    public function __construct(ServiceRepository $service, HotelRepository $hotel)
    {
        parent::__construct();

        $this->service = $service;
        $this->hotel = $hotel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $services = $this->service->all();
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('service::admin.services.index', compact('services', 'changes', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('service::services.form.hotel_id_empty_option'));
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('service::admin.services.create', compact('hotels', 'changes', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateServiceRequest $request
     * @return Response
     */
    public function store(CreateServiceRequest $request)
    {
        $data = $request->all();
        $serviceCreated = $this->service->create($data);

        /** @var Service $serviceCreated */
        $serviceCreated->hotels()->sync($data['hotel_id']);

        return redirect()->route('admin.service.service.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('service::services.title.services')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Service $service
     * @return Response
     */
    public function edit(Service $service)
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('service::services.form.hotel_id_empty_option'));
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('service::admin.services.edit', compact('service', 'hotels', 'changes', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Service $service
     * @param  UpdateServiceRequest $request
     * @return Response
     */
    public function update(Service $service, UpdateServiceRequest $request)
    {
        $data = $request->all();

        $this->service->update($service, $data);

        $service->hotels()->sync($data['hotel_id']);

        return redirect()->route('admin.service.service.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('service::services.title.services')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Service $service
     * @return Response
     */
    public function destroy(Service $service)
    {
        $this->service->destroy($service);

        return redirect()->route('admin.service.service.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('service::services.title.services')]));
    }
}
