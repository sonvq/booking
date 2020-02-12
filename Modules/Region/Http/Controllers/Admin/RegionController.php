<?php

namespace Modules\Region\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Region\Entities\Region;
use Modules\Region\Http\Requests\CreateRegionRequest;
use Modules\Region\Http\Requests\UpdateRegionRequest;
use Modules\Region\Repositories\RegionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class RegionController extends AdminBaseController
{
    /**
     * @var RegionRepository
     */
    private $region;

    public function __construct(RegionRepository $region)
    {
        parent::__construct();

        $this->region = $region;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $regions = $this->region->all();

        return view('region::admin.regions.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('region::admin.regions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRegionRequest $request
     * @return Response
     */
    public function store(CreateRegionRequest $request)
    {
        $this->region->create($request->all());

        return redirect()->route('admin.region.region.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('region::regions.title.regions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Region $region
     * @return Response
     */
    public function edit(Region $region)
    {
        return view('region::admin.regions.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Region $region
     * @param  UpdateRegionRequest $request
     * @return Response
     */
    public function update(Region $region, UpdateRegionRequest $request)
    {
        $this->region->update($region, $request->all());

        return redirect()->route('admin.region.region.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('region::regions.title.regions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Region $region
     * @return Response
     */
    public function destroy(Region $region)
    {
        $this->region->destroy($region);

        return redirect()->route('admin.region.region.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('region::regions.title.regions')]));
    }
}
