<?php

namespace Modules\Tag\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Sidebar\AbstractAdminSidebar;

class RegisterTagSidebar extends AbstractAdminSidebar
{
    /**
     * Method used to define your sidebar menu groups and items
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.other'), function (Group $group) {
            $group->weight(4);
            $group->item(trans('tag::tags.tags'), function (Item $item) {
                $item->icon('fa fa-tag');
                $item->weight(1);
                $item->route('admin.tag.tag.index');
                $item->authorize(
                    $this->auth->hasAccess('tag.tags.index')
                );
            });
        });

        return $menu;
    }
}
