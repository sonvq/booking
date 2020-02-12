<?php

namespace Modules\Hotel\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterHotelSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('hotel::hotels.title.hotels'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(7);
                $item->authorize(
                    $this->auth->hasAccess('hotel.hotels.index')
                );
                $item->item(trans('hotel::hotels.title.hotels'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.hotel.hotel.create');
                    $item->route('admin.hotel.hotel.index');
                    $item->authorize(
                        $this->auth->hasAccess('hotel.hotels.index')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
