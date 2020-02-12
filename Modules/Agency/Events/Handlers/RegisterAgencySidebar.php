<?php

namespace Modules\Agency\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterAgencySidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('agency::agencies.title.agencies'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(4);
                $item->authorize(
                    $this->auth->hasAccess('agency.agencies.index')
                );
                $item->item(trans('agency::agencies.title.agencies'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.agency.agency.create');
                    $item->route('admin.agency.agency.index');
                    $item->authorize(
                        $this->auth->hasAccess('agency.agencies.index')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
