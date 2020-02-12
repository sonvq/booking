<?php

namespace Modules\Surcharge\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\Surcharge\Entities\Surcharge;
use Modules\Surcharge\Http\Requests\ImportSurchargeRequest;
use Modules\Surcharge\Repositories\SurchargeRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class ImportController
 * @package Modules\Surcharge\Http\Controllers\Admin
 */
class ImportController extends AdminBaseController
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
     * ImportController constructor.
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
     * @return Factory|View
     */
    public function importIndex()
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('surcharge::surcharges.form.hotel_id_empty_option'));

        return view('surcharge::admin.surcharges.import.index', compact('hotels'));
    }

    /**
     * @param ImportSurchargeRequest $request
     * @return RedirectResponse
     */
    public function importCreate(ImportSurchargeRequest $request)
    {
        $path = $request->file('import_file');
        $input = $request->all();
        $successCount = 0;

        try {
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $data = $reader->load($path)->getActiveSheet()->toArray();
            $surcharges = $this->getSurchargeDataFromImportFile($data);

            foreach ($surcharges as $surcharge) {
                $surchargeCreated = $this->surcharge->create($surcharge);

                /** @var Surcharge $surchargeCreated */
                $surchargeCreated->hotels()->sync($input['hotel_id']);

                $successCount++;
            }
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.surcharge.surcharge.index')
            ->withSuccess($successCount . ' ' . trans('surcharge::surcharges.messages.import-surcharge-successfully'));
    }

    /**
     * @param array $data
     * @return array
     */
    protected function getSurchargeDataFromImportFile(array $data)
    {
        $surcharges = [];
        if (count($data) > 1) {
            $lastSurchargeName = array_shift($data);
            foreach ($data as $row) {
                $firstSurchargeName = array_shift($row);
                foreach ($row as $key => $price) {
                    if (is_numeric($price)) {
                        $surcharges[] = [
                            'name' => $firstSurchargeName . ' ' . $lastSurchargeName[$key + 1],
                            'price' => $price,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
            }
        }

        return $surcharges;
    }
}
