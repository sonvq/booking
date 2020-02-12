<?php

namespace Modules\Service\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterServiceSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('service::services.title.services'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(9);
                $item->authorize(
                    $this->auth->hasAccess('service.services.index')
                );
                $item->item(trans('service::services.title.services'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.service.service.create');
                    $item->route('admin.service.service.index');
                    $item->authorize(
                        $this->auth->hasAccess('service.services.index')
                    );
                });
                // append
                $item->item(trans('service::services.title.import service'), function (Item $item) {
                    $item->icon('fa fa-cloud-download');
                    $item->weight(1);
                    $item->route('admin.service.service.import.index');
                    $item->authorize(
                        $this->auth->hasAccess('service.services.import')
                    );
                });
            });
        });

        return $menu;
    }
}
