<?php

namespace Modules\Supplier\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterSupplierSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('supplier::suppliers.title.suppliers'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                    $this->auth->hasAccess('supplier.suppliers.index')
                );
                $item->item(trans('supplier::suppliers.title.suppliers'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.supplier.supplier.create');
                    $item->route('admin.supplier.supplier.index');
                    $item->authorize(
                        $this->auth->hasAccess('supplier.suppliers.index')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
