<?php

namespace Modules\Region\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterRegionSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('region::regions.title.regions'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(14);
                $item->authorize(
                    $this->auth->hasAccess('region.regions.index')
                );
                $item->item(trans('region::regions.title.regions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.region.region.create');
                    $item->route('admin.region.region.index');
                    $item->authorize(
                        $this->auth->hasAccess('region.regions.index')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
