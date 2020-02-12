<?php

namespace Modules\Company\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Company\Entities\Company;
use Modules\Company\Http\Requests\CreateCompanyRequest;
use Modules\Company\Http\Requests\UpdateCompanyRequest;
use Modules\Company\Repositories\CompanyRepository;
use Modules\Core\Entities\BaseModel;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CompanyController extends AdminBaseController
{
    /**
     * @var CompanyRepository
     */
    private $company;

    public function __construct(CompanyRepository $company)
    {
        parent::__construct();

        $this->company = $company;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $companies = $this->company->all();

        return view('company::admin.companies.index', compact('companies'));
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

        return view('company::admin.companies.create', compact('changes', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCompanyRequest $request
     * @return Response
     */
    public function store(CreateCompanyRequest $request)
    {
        $this->company->create($request->all());

        return redirect()->route('admin.company.company.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('company::companies.title.companies')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Company $company
     * @return Response
     */
    public function edit(Company $company)
    {
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('company::admin.companies.edit', compact('company', 'changes', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Company $company
     * @param  UpdateCompanyRequest $request
     * @return Response
     */
    public function update(Company $company, UpdateCompanyRequest $request)
    {
        $this->company->update($company, $request->all());

        return redirect()->route('admin.company.company.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('company::companies.title.companies')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Company $company
     * @return Response
     */
    public function destroy(Company $company)
    {
        $this->company->destroy($company);

        return redirect()->route('admin.company.company.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('company::companies.title.companies')]));
    }
}
