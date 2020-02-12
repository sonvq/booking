<?php

namespace Modules\Booking\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterBookingSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('booking::bookings.title.bookings'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(0);
                $item->authorize(
                    $this->auth->hasAccess('booking.bookings.index')
                );
                $item->item(trans('booking::bookings.title.bookings'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.booking.booking.create');
                    $item->route('admin.booking.booking.index');
                    $item->authorize(
                        $this->auth->hasAccess('booking.bookings.index')
                    );
                });
// append

                // append
                $item->item(trans('booking::bookings.title.report booking'), function (Item $item) {
                    $item->icon('fa fa-cloud-download');
                    $item->weight(1);
                    $item->route('admin.booking.booking.report.index');
                    $item->authorize(
                        $this->auth->hasAccess('booking.bookings.report')
                    );
                });

                $item->item(trans('booking::bookings.title.financial booking'), function (Item $item) {
                    $item->icon('fa fa-cloud-download');
                    $item->weight(2);
                    $item->route('admin.booking.booking.financial.index');
                    $item->authorize(
                        $this->auth->hasAccess('booking.bookings.financial')
                    );
                });

            });
        });

        return $menu;
    }
}
