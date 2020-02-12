<?php

namespace Modules\Bill\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterBillSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('bill::bills.title.bills'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(2);
                $item->authorize(
                    $this->auth->hasAccess('bill.bills.index')
                );
                $item->item(trans('bill::bills.title.bills'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.bill.bill.create');
                    $item->route('admin.bill.bill.index');
                    $item->authorize(
                        $this->auth->hasAccess('bill.bills.index')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
