<?php

namespace Modules\Promotion\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterPromotionSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('promotion::promotions.title.promotions'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(13);
                $item->authorize(
                    $this->auth->hasAccess('promotion.promotions.index')
                );
                $item->item(trans('promotion::promotions.title.promotions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.promotion.promotion.create');
                    $item->route('admin.promotion.promotion.index');
                    $item->authorize(
                        $this->auth->hasAccess('promotion.promotions.index')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
