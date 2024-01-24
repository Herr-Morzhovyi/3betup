<?php

// ! Get menu items children
function get_children_of($parent_id, &$menu_items) {
	$children = [];
	foreach ($menu_items as &$menu_item) {
		if ($menu_item->menu_item_parent == $parent_id) {
			$children[] = $menu_item;
		}
	}

	return $children;
}

// ! Show nav menu
function show_nav_menu_items($current_item = 0, &$menu_items) {

	$children = get_children_of($current_item, $menu_items);

	if ($children and count($children)) {

		if ($current_item == 0) {
			?>
			
			<ul class="d-flex gap-20 flex-column flex-xxl-row nav flex-nowrap container fw-medium mb-0"><?php
		} else {

			echo '<button type="button" class="sub-menu-button"></button>';

			echo '<ul class="sub-menu">';
		}

		foreach ($children as $child) {

			echo '<li class="menu-item-' . $child->ID;

			echo implode(' ', $child->classes);
			echo '">';

			echo '<a class="text-nowrap text-white text-decoration-none" href="' . $child->url . '"';
			
			echo '>'. $child->title . '</a>';

			show_nav_menu_items($child->ID, $menu_items);

			echo '</li>';
		}

		if ($current_item == 0) { ?>
			</ul>
			<?php

		} else {
			?></ul><?php
		}
	}
}

function show_nav_menu_items_footer($current_item = 0, &$menu_items) {
	$children = get_children_of($current_item, $menu_items);

	if ($children and count($children)) {

		if ($current_item == 0) {
			?>
			
			<ul class="d-flex gap-20 flex-row flex-xxl-column nav flex-nowrap fw-medium mb-0"><?php
		} else {

			echo '<button type="button" class="sub-menu-button"></button>';

			echo '<ul class="sub-menu">';
		}

		foreach ($children as $child) {

			echo '<li class="menu-item-' . $child->ID;

			echo implode(' ', $child->classes);
			echo '">';

			echo '<a class="text-nowrap text-white text-decoration-none" href="' . $child->url . '"';
			
			echo '>'. $child->title . '</a>';

			show_nav_menu_items($child->ID, $menu_items);

			echo '</li>';
		}

		if ($current_item == 0) { ?>
			</ul>
			<?php

		} else {
			?></ul><?php
		}
	}
}