<?php

if (has_nav_menu('primary')) {

	$menu_items = wp_get_nav_menu_items(wp_get_nav_menu_object(get_nav_menu_locations()['primary']));
	_wp_menu_item_classes_by_context($menu_items);

	show_nav_menu_items(0, $menu_items, 'primary');

}