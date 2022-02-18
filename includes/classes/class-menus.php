<?php

/**
 * Register Menus
 *
 * @package lyra
 */

namespace LYRA_THEME\Includes;

use LYRA_THEME\Includes\traits\singleton;

class Menus
{
    use singleton;

    protected function __construct()
    {

        $this->setup_hooks();

    }

    public function setup_hooks()
    {

        register_nav_menus(array(
            'lyra-header-menu' => esc_html__('Header Menu', 'lyra'),
            'lyra-footer-menu' => esc_html__('Footer Menu', 'lyra'),
            'lyra-dashboard-menu' => esc_html__('Dashboard Menu', 'lyra'),
            'lyra-dashboard-secondry-menu' => esc_html__('Dashboard Secondry Menu', 'lyra'),
        ));

    }

    public function get_nav_menu_id($location)
    {
        $menu_locations = get_nav_menu_locations();

        return $menu_locations[$location];
    }

    public function get_child_menu_items($menu_items, $parent)
    {
        $child_items = [];

        foreach ($menu_items as $menu_item) {
            if (intval($menu_item->menu_item_parent) === $parent) {
                array_push($child_items, $menu_item);
            }
        }

        return $child_items;

    }
}
