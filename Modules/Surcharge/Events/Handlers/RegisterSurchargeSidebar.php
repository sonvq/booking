<?php

namespace Modules\Surcharge\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterSurchargeSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('surcharge::surcharges.title.surcharges'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('surcharge.surcharges.index')
                );
                $item->item(trans('surcharge::surcharges.title.surcharges'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.surcharge.surcharge.create');
                    $item->route('admin.surcharge.surcharge.index');
                    $item->authorize(
                        $this->auth->hasAccess('surcharge.surcharges.index')
                    );
                });
                // append
                $item->item(trans('surcharge::surcharges.title.import surcharge'), function (Item $item) {
                    $item->icon('fa fa-cloud-download');
                    $item->weight(52);
                    $item->route('admin.surcharge.surcharge.import.index');
                    $item->authorize(
                        $this->auth->hasAccess('surcharge.surcharges.import')
                    );
                });

            });
        });

        return $menu;
    }
}
