<?php

namespace Modules\Room\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\Room\Entities\Room;
use Modules\Room\Http\Requests\ImportRoomRequest;
use Modules\Room\Repositories\RoomRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class ImportController
 * @package Modules\Room\Http\Controllers\Admin
 */
class ImportController extends AdminBaseController
{
    /**
     * @var RoomRepository
     */
    private $room;

    /**
     * @var HotelRepository
     */
    private $hotel;

    /**
     * ImportController constructor.
     * @param RoomRepository $room
     * @param HotelRepository $hotel
     */
    public function __construct(RoomRepository $room, HotelRepository $hotel)
    {
        parent::__construct();

        $this->room = $room;
        $this->hotel = $hotel;
    }

    /**
     * @return Factory|View
     */
    public function importIndex()
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('room::rooms.form.hotel_id_empty_option'));

        return view('room::admin.rooms.import.index', compact('hotels'));
    }

    /**
     * @param ImportRoomRequest $request
     * @return RedirectResponse
     */
    public function importCreate(ImportRoomRequest $request)
    {
        $path = $request->file('import_file');
        $input = $request->all();
        $successCount = 0;

        try {
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $data = $reader->load($path)->getActiveSheet()->toArray();
            $rooms = $this->getRoomDataFromImportFile($data);

            foreach ($rooms as $room) {
                $roomCreated = $this->room->create($room);

                /** @var Room $roomCreated */
                $roomCreated->hotels()->sync($input['hotel_id']);

                $successCount++;
            }
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.room.room.index')
            ->withSuccess($successCount . ' ' . trans('room::rooms.messages.import-room-successfully'));
    }

    /**
     * @param array $data
     * @return array
     */
    protected function getRoomDataFromImportFile(array $data)
    {
        $rooms = [];
        if (count($data) > 1) {
            $lastRoomName = array_shift($data);
            foreach ($data as $row) {
                $firstRoomName = array_shift($row);
                foreach ($row as $key => $price) {
                    if (is_numeric($price)) {
                        $rooms[] = [
                            'name' => $firstRoomName . ': ' . $lastRoomName[$key + 1],
                            'price' => $price,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
            }
        }

        return $rooms;
    }
}
