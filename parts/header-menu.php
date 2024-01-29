<div id="main-navigation-container" class="menu-container font-signika d-block d-xxl-none">
	<input type="checkbox" id="menu-checkbox" class="visually-hidden position-fixed">
	<label for="menu-checkbox" class="d-block cursor-pointer menu-button-container d-block py-20">
		<div class="menu-button d-flex justify-content-between align-items-center">
			<img src="<?php echo get_template_directory_uri(  ) . '/images/menu-button.svg'; ?>" alt="Menu button">
		</div>
	</label>

	<div class="menu-wrapper rounded-3">
		<div id="menu-primary-no" class="d-flex flex-column fw-semibold nav primary-menu align-items-center flex-nowrap wp-edit-button-box left bg-dark">
			<div class="align-self-end my-15">
				<label for="menu-checkbox" class="d-block cursor-pointer menu-button-container-mobile d-flex">
					<div class="menu-button-mobile"></div>
				</label>
			</div><?php

				if ( has_nav_menu( 'primary' ) ) { 
					echo '<ul class="w-100">';
					$menu_items = wp_get_nav_menu_items( wp_get_nav_menu_object( get_nav_menu_locations()['primary'] ) );
					_wp_menu_item_classes_by_context($menu_items);

					show_nav_menu_items(0, $menu_items, 'primary');
					echo '</ul>';
				} ?>
		
		</div>
	</div>
</div>
<div class="d-none d-xxl-block"><?php 
	if ( has_nav_menu( 'primary' ) ) { 
		echo '<ul class="w-100 mb-0 px-0">';
		$menu_items = wp_get_nav_menu_items( wp_get_nav_menu_object( get_nav_menu_locations()['primary'] ) );
		_wp_menu_item_classes_by_context($menu_items);

		show_nav_menu_items(0, $menu_items, 'primary');
		echo '</ul>';
	}
?></div>