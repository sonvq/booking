<?php

namespace Modules\Audit\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterAuditSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
        $menu->group(trans('core::sidebar.other'), function (Group $group) {
            $group->item(trans('audit::audits.title.audits'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(5);
                $item->authorize(
                    $this->auth->hasAccess('audit.audits.index')
                );
                $item->item(trans('audit::audits.title.audits'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->route('admin.audit.audit.index');
                    $item->authorize(
                        $this->auth->hasAccess('audit.audits.index')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
