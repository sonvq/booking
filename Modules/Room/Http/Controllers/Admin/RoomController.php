<?php

namespace Modules\Room\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Entities\BaseModel;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\Room\Entities\Room;
use Modules\Room\Http\Requests\CreateRoomRequest;
use Modules\Room\Http\Requests\UpdateRoomRequest;
use Modules\Room\Repositories\RoomRepository;

class RoomController extends AdminBaseController
{
    /**
     * @var RoomRepository
     */
    private $room;

    /**
     * @var HotelRepository
     */
    private $hotel;

    public function __construct(RoomRepository $room, HotelRepository $hotel)
    {
        parent::__construct();

        $this->room = $room;
        $this->hotel = $hotel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $rooms = $this->room->all();
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('room::admin.rooms.index', compact('rooms', 'changes', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('room::rooms.form.hotel_id_empty_option'));
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('room::admin.rooms.create', compact('hotels', 'changes', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRoomRequest $request
     * @return Response
     */
    public function store(CreateRoomRequest $request)
    {
        $data = $request->all();
        $roomCreated = $this->room->create($data);

        /** @var Room $roomCreated */
        $roomCreated->hotels()->sync($data['hotel_id']);

        return redirect()->route('admin.room.room.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('room::rooms.title.rooms')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Room $room
     * @return Response
     */
    public function edit(Room $room)
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('room::rooms.form.hotel_id_empty_option'));
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('room::admin.rooms.edit', compact('room', 'hotels', 'changes', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Room $room
     * @param  UpdateRoomRequest $request
     * @return Response
     */
    public function update(Room $room, UpdateRoomRequest $request)
    {
        $data = $request->all();

        $this->room->update($room, $data);

        $room->hotels()->sync($data['hotel_id']);

        return redirect()->route('admin.room.room.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('room::rooms.title.rooms')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Room $room
     * @return Response
     */
    public function destroy(Room $room)
    {
        $this->room->destroy($room);

        return back()->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('room::rooms.title.rooms')]));
    }
}
