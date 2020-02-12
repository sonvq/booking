<?php

namespace Modules\Period\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterPeriodSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('period::periods.title.periods'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(12);
                $item->authorize(
                    $this->auth->hasAccess('period.periods.index')
                );
                $item->item(trans('period::periods.title.periods'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.period.period.create');
                    $item->route('admin.period.period.index');
                    $item->authorize(
                        $this->auth->hasAccess('period.periods.index')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
