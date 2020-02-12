<?php

namespace Modules\Service\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\Service\Entities\Service;
use Modules\Service\Http\Requests\ImportServiceRequest;
use Modules\Service\Repositories\ServiceRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class ImportController
 * @package Modules\Service\Http\Controllers\Admin
 */
class ImportController extends AdminBaseController
{
    /**
     * @var ServiceRepository
     */
    private $service;

    /**
     * @var HotelRepository
     */
    private $hotel;

    /**
     * ImportController constructor.
     * @param ServiceRepository $service
     * @param HotelRepository $hotel
     */
    public function __construct(ServiceRepository $service, HotelRepository $hotel)
    {
        parent::__construct();

        $this->service = $service;
        $this->hotel = $hotel;
    }

    /**
     * @return Factory|View
     */
    public function importIndex()
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('service::services.form.hotel_id_empty_option'));

        return view('service::admin.services.import.index', compact('hotels'));
    }

    /**
     * @param ImportServiceRequest $request
     * @return RedirectResponse
     */
    public function importCreate(ImportServiceRequest $request)
    {
        $path = $request->file('import_file');
        $input = $request->all();
        $successCount = 0;

        try {
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $data = $reader->load($path)->getActiveSheet()->toArray();
            $services = $this->getServiceDataFromImportFile($data);

            foreach ($services as $service) {
                $serviceCreated = $this->service->create($service);

                /** @var Service $serviceCreated */
                $serviceCreated->hotels()->sync($input['hotel_id']);

                $successCount++;
            }
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.service.service.index')
            ->withSuccess($successCount . ' ' . trans('service::services.messages.import-service-successfully'));
    }

    /**
     * @param array $data
     * @return array
     */
    protected function getServiceDataFromImportFile(array $data)
    {
        $services = [];
        if (count($data) > 1) {
            $lastServiceName = array_shift($data);
            foreach ($data as $row) {
                $firstServiceName = array_shift($row);
                foreach ($row as $key => $price) {
                    if (is_numeric($price)) {
                        $services[] = [
                            'name' => $firstServiceName . ' ' . $lastServiceName[$key + 1],
                            'price' => $price,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
            }
        }

        return $services;
    }
}
