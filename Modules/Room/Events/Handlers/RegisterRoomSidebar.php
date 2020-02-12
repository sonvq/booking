<?php

namespace Modules\Room\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterRoomSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('room::rooms.title.rooms'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(8);
                $item->authorize(
                    $this->auth->hasAccess('room.rooms.index')
                );
                $item->item(trans('room::rooms.title.rooms'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.room.room.create');
                    $item->route('admin.room.room.index');
                    $item->authorize(
                        $this->auth->hasAccess('room.rooms.index')
                    );
                });
                // append
                $item->item(trans('room::rooms.title.import room'), function (Item $item) {
                    $item->icon('fa fa-cloud-download');
                    $item->weight(1);
                    $item->route('admin.room.room.import.index');
                    $item->authorize(
                        $this->auth->hasAccess('room.rooms.import')
                    );
                });
            });
        });

        return $menu;
    }
}
