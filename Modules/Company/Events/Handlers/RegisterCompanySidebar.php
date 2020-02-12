<?php

namespace Modules\Company\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterCompanySidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('company::companies.title.companies'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(6);
                $item->authorize(
                    $this->auth->hasAccess('company.companies.index')
                );
                $item->item(trans('company::companies.title.companies'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.company.company.create');
                    $item->route('admin.company.company.index');
                    $item->authorize(
                        $this->auth->hasAccess('company.companies.index')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
