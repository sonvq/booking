<?php

namespace Modules\Campaign\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Campaign\Entities\Campaign;
use Modules\Campaign\Http\Requests\CreateCampaignRequest;
use Modules\Campaign\Http\Requests\UpdateCampaignRequest;
use Modules\Campaign\Repositories\CampaignRepository;
use Modules\Core\Entities\BaseModel;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Hotel\Repositories\HotelRepository;
use Modules\Room\Entities\Room;
use Modules\Service\Entities\Service;
use Modules\Surcharge\Entities\Surcharge;

class CampaignController extends AdminBaseController
{
    /**
     * @var CampaignRepository
     */
    private $campaign;

    /**
     * @var HotelRepository
     */
    private $hotel;

    /**
     * CampaignController constructor.
     * @param CampaignRepository $campaign
     * @param HotelRepository $hotel
     */
    public function __construct(
        CampaignRepository $campaign,
        HotelRepository $hotel
    )
    {
        parent::__construct();

        $this->campaign = $campaign;
        $this->hotel = $hotel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $campaigns = $this->campaign->all();
        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('campaign::admin.campaigns.index', compact('campaigns', 'changes', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('campaign::campaigns.form.hotel_id_empty_option'));

        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('campaign::admin.campaigns.create', compact('hotels', 'changes', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCampaignRequest $request
     * @return Response
     */
    public function store(CreateCampaignRequest $request)
    {
        $data = $request->all();

        $createdCampaign = $this->campaign->create($data);
        /** @var Campaign $createdCampaign */
        if (!empty($data['hotel_id'])) {
            $createdCampaign->hotels()->sync($data['hotel_id']);
        }

        if (!empty($data['room_id'])) {
            $createdCampaign->rooms()->sync($data['room_id']);
        }

        if (!empty($data['service_id'])) {
            $createdCampaign->services()->sync($data['service_id']);
        }

        if (!empty($data['surcharge_id'])) {
            $createdCampaign->surcharges()->sync($data['surcharge_id']);
        }

        return redirect()->route('admin.campaign.campaign.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('campaign::campaigns.title.campaigns')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Campaign $campaign
     * @return Response
     */
    public function edit(Campaign $campaign)
    {
        $hotelList = $this->hotel->all();
        $hotels = $this->prepareDropdownData($hotelList, trans('campaign::campaigns.form.hotel_id_empty_option'));

        $changes = BaseModel::change();
        $types = BaseModel::type();

        return view('campaign::admin.campaigns.edit', compact('campaign', 'hotels', 'changes',
            'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Campaign $campaign
     * @param  UpdateCampaignRequest $request
     * @return Response
     */
    public function update(Campaign $campaign, UpdateCampaignRequest $request)
    {
        $data = $request->all();

        $this->campaign->update($campaign, $data);

        if (!empty($data['hotel_id'])) {
            $campaign->hotels()->sync($data['hotel_id']);
        } else {
            $campaign->hotels()->sync([]);
        }

        if (!empty($data['room_id'])) {
            $campaign->rooms()->sync($data['room_id']);
        } else {
            $campaign->rooms()->sync([]);
        }

        if (!empty($data['service_id'])) {
            $campaign->services()->sync($data['service_id']);
        } else {
            $campaign->services()->sync([]);
        }

        if (!empty($data['surcharge_id'])) {
            $campaign->surcharges()->sync($data['surcharge_id']);
        } else {
            $campaign->surcharges()->sync([]);
        }

        return redirect()->route('admin.campaign.campaign.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('campaign::campaigns.title.campaigns')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Campaign $campaign
     * @return Response
     */
    public function destroy(Campaign $campaign)
    {
        $this->campaign->destroy($campaign);

        return redirect()->route('admin.campaign.campaign.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('campaign::campaigns.title.campaigns')]));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function hotelRooms(Request $request)
    {
        $input = $request->all();
        $hotelIds = $input['hotel_ids'];

        $objectId = null;
        if (!empty($input['id'])) {
            $objectId = $input['id'];
        }

        $rooms = Room::whereHas('hotels', function ($q) use ($hotelIds) {
            $q->whereIn('id', $hotelIds);
        })->where(function ($qr) use ($objectId) {
            $qr->has('campaigns', '=', 0);
            if (!empty($objectId)) {
                $qr->orWhereHas('campaigns', function ($query) use ($objectId) {
                    $query->where('campaign_id', $objectId);
                });
            }
        })->get();

        return $this->prepareAjaxResult($rooms);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function hotelServices(Request $request)
    {
        $input = $request->all();
        $hotelIds = $input['hotel_ids'];

        $objectId = null;
        if (!empty($input['id'])) {
            $objectId = $input['id'];
        }

        $services = Service::whereHas('hotels', function ($q) use ($hotelIds) {
            $q->whereIn('id', $hotelIds);
        })->where(function ($qr) use ($objectId) {
            $qr->has('campaigns', '=', 0);
            if (!empty($objectId)) {
                $qr->orWhereHas('campaigns', function ($query) use ($objectId) {
                    $query->where('campaign_id', $objectId);
                });
            }
        })->get();

        return $this->prepareAjaxResult($services);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function hotelSurcharges(Request $request)
    {
        $input = $request->all();
        $hotelIds = $input['hotel_ids'];

        $objectId = null;
        if (!empty($input['id'])) {
            $objectId = $input['id'];
        }

        $surcharges = Surcharge::whereHas('hotels', function ($q) use ($hotelIds) {
            $q->whereIn('id', $hotelIds);
        })->where(function ($qr) use ($objectId) {
            $qr->has('campaigns', '=', 0);
            if (!empty($objectId)) {
                $qr->orWhereHas('campaigns', function ($query) use ($objectId) {
                    $query->where('campaign_id', $objectId);
                });
            }
        })->get();

        return $this->prepareAjaxResult($surcharges);
    }
}
