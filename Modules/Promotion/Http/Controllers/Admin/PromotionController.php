<?php

namespace Modules\Promotion\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Agency\Repositories\AgencyRepository;
use Modules\Campaign\Entities\Campaign;
use Modules\Campaign\Repositories\CampaignRepository;
use Modules\Core\Entities\BaseModel;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\Promotion\Entities\Promotion;
use Modules\Promotion\Http\Requests\CreatePromotionRequest;
use Modules\Promotion\Http\Requests\UpdatePromotionRequest;
use Modules\Promotion\Repositories\PromotionRepository;
use Modules\Room\Entities\Room;
use Modules\Room\Repositories\RoomRepository;

/**
 * Class PromotionController
 * @package Modules\Promotion\Http\Controllers\Admin
 */
class PromotionController extends AdminBaseController
{
    /**
     * @var PromotionRepository
     */
    private $promotion;

    /**
     * @var CampaignRepository
     */
    private $campaign;

    /**
     * @var HotelRepository
     */
    private $hotel;

    /**
     * @var AgencyRepository
     */
    private $agency;

    /**
     * @var RoomRepository
     */
    private $room;

    /**
     * PromotionController constructor.
     * @param PromotionRepository $promotion
     * @param AgencyRepository $agency
     * @param CampaignRepository $campaign
     * @param HotelRepository $hotel
     * @param RoomRepository $room
     */
    public function __construct(
        PromotionRepository $promotion,
        AgencyRepository $agency,
        CampaignRepository $campaign,
        HotelRepository $hotel,
        RoomRepository $room
    )
    {
        parent::__construct();

        $this->promotion = $promotion;
        $this->agency = $agency;
        $this->campaign = $campaign;
        $this->hotel = $hotel;
        $this->room = $room;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $promotions = $this->promotion->all();
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('promotion::admin.promotions.index', compact('promotions', 'changes', 'types'));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function campaignHotels(Request $request)
    {
        $input = $request->all();
        $campaignId = $input['campaign_id'];
        $campaign = Campaign::with('rooms')->find($campaignId);
        $hotels = $campaign->hotels;

        return $this->prepareAjaxResult($hotels);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function campaignRooms(Request $request)
    {
        $input = $request->all();
        $campaignId = $input['campaign_id'];
        $hotelIds = $input['hotel_id'];
        $rooms = Room::whereHas('campaigns', function ($q) use ($campaignId) {
            $q->where('id', '=', $campaignId);
        })
        ->whereHas('hotels', function ($q) use ($hotelIds) {
            $q->whereIn('id', $hotelIds);
        })
        ->get();

        return $this->prepareAjaxResult($rooms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $agencyList = $this->agency->all();
        $campaignList = $this->campaign->all();
        $hotelList = $this->hotel->all();
        $roomList = $this->room->all();

        $agencies = $this->prepareDropdownData($agencyList, trans('promotion::promotions.form.agency_id_empty_option'));
        $campaigns = $this->prepareDropdownData($campaignList, trans('promotion::promotions.form.campaign_id_empty_option'));
        $hotels = $this->prepareDropdownData($hotelList, trans('promotion::promotions.form.hotel_id_empty_option'));
        $rooms = $this->prepareDropdownData($roomList, trans('promotion::promotions.form.room_id_empty_option'));

        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('promotion::admin.promotions.create', compact('agencies', 'campaigns',
            'hotels', 'rooms', 'changes', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePromotionRequest $request
     * @return Response
     */
    public function store(CreatePromotionRequest $request)
    {
        $data = $request->all();

        $promotionCreated = $this->promotion->create($data);

        /** @var Promotion $promotionCreated */
        $promotionCreated->agencies()->sync($data['agency_id']);
        $promotionCreated->hotels()->sync($data['hotel_id']);
        $promotionCreated->rooms()->sync($data['room_id']);

        return redirect()->route('admin.promotion.promotion.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('promotion::promotions.title.promotions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Promotion $promotion
     * @return Response
     */
    public function edit(Promotion $promotion)
    {
        $agencyList = $this->agency->all();
        $campaignList = $this->campaign->all();
        $hotelList = $this->hotel->all();
        $roomList = $this->room->all();

        $agencies = $this->prepareDropdownData($agencyList, trans('promotion::promotions.form.agency_id_empty_option'));
        $campaigns = $this->prepareDropdownData($campaignList, trans('promotion::promotions.form.campaign_id_empty_option'));
        $hotels = $this->prepareDropdownData($hotelList, trans('promotion::promotions.form.hotel_id_empty_option'));
        $rooms = $this->prepareDropdownData($roomList, trans('promotion::promotions.form.room_id_empty_option'));

        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('promotion::admin.promotions.edit', compact('promotion', 'agencies',
            'campaigns', 'hotels', 'rooms', 'changes', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Promotion $promotion
     * @param  UpdatePromotionRequest $request
     * @return Response
     */
    public function update(Promotion $promotion, UpdatePromotionRequest $request)
    {
        $data = $request->all();

        $this->promotion->update($promotion, $data);

        $promotion->agencies()->sync($data['agency_id']);
        $promotion->hotels()->sync($data['hotel_id']);
        $promotion->rooms()->sync($data['room_id']);

        return redirect()->route('admin.promotion.promotion.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('promotion::promotions.title.promotions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Promotion $promotion
     * @return Response
     */
    public function destroy(Promotion $promotion)
    {
        $this->promotion->destroy($promotion);

        return redirect()->route('admin.promotion.promotion.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('promotion::promotions.title.promotions')]));
    }
}
