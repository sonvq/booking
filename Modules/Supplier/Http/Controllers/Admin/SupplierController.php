<?php

namespace Modules\Supplier\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Entities\BaseModel;
use Modules\Supplier\Entities\Supplier;
use Modules\Supplier\Http\Requests\CreateSupplierRequest;
use Modules\Supplier\Http\Requests\UpdateSupplierRequest;
use Modules\Supplier\Repositories\SupplierRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class SupplierController extends AdminBaseController
{
    /**
     * @var SupplierRepository
     */
    private $supplier;

    public function __construct(SupplierRepository $supplier)
    {
        parent::__construct();

        $this->supplier = $supplier;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $suppliers = $this->supplier->all();
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('supplier::admin.suppliers.index', compact('suppliers', 'changes', 'types'));
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

        return view('supplier::admin.suppliers.create', compact('changes', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSupplierRequest $request
     * @return Response
     */
    public function store(CreateSupplierRequest $request)
    {
        $this->supplier->create($request->all());

        return redirect()->route('admin.supplier.supplier.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('supplier::suppliers.title.suppliers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Supplier $supplier
     * @return Response
     */
    public function edit(Supplier $supplier)
    {
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('supplier::admin.suppliers.edit', compact('supplier', 'changes', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Supplier $supplier
     * @param  UpdateSupplierRequest $request
     * @return Response
     */
    public function update(Supplier $supplier, UpdateSupplierRequest $request)
    {
        $this->supplier->update($supplier, $request->all());

        return redirect()->route('admin.supplier.supplier.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('supplier::suppliers.title.suppliers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Supplier $supplier
     * @return Response
     */
    public function destroy(Supplier $supplier)
    {
        $this->supplier->destroy($supplier);

        return redirect()->route('admin.supplier.supplier.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('supplier::suppliers.title.suppliers')]));
    }
}
