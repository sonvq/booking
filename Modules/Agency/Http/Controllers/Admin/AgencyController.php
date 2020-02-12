<?php

namespace Modules\Agency\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Agency\Entities\Agency;
use Modules\Agency\Http\Requests\CreateAgencyRequest;
use Modules\Agency\Http\Requests\UpdateAgencyRequest;
use Modules\Agency\Repositories\AgencyRepository;
use Modules\Core\Entities\BaseModel;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

/**
 * Class AgencyController
 * @package Modules\Agency\Http\Controllers\Admin
 */
class AgencyController extends AdminBaseController
{
    /**
     * @var AgencyRepository
     */
    private $agency;

    public function __construct(AgencyRepository $agency)
    {
        parent::__construct();

        $this->agency = $agency;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $agencies = $this->agency->all();
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('agency::admin.agencies.index', compact('agencies', 'changes', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('agency::admin.agencies.create', compact('changes', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAgencyRequest $request
     * @return Response
     */
    public function store(CreateAgencyRequest $request)
    {
        $this->agency->create($request->all());

        return redirect()->route('admin.agency.agency.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('agency::agencies.title.agencies')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Agency $agency
     * @return Response
     */
    public function edit(Agency $agency)
    {
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('agency::admin.agencies.edit', compact('agency', 'changes', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Agency $agency
     * @param  UpdateAgencyRequest $request
     * @return Response
     */
    public function update(Agency $agency, UpdateAgencyRequest $request)
    {
        $this->agency->update($agency, $request->all());

        return redirect()->route('admin.agency.agency.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('agency::agencies.title.agencies')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Agency $agency
     * @return Response
     */
    public function destroy(Agency $agency)
    {
        $this->agency->destroy($agency);

        return redirect()->route('admin.agency.agency.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('agency::agencies.title.agencies')]));
    }
}
