<?php

// Theme options
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> __('Theme settings', '3betup'),
		'menu_title' 	=> __('Theme settings', '3betup'),
		'menu_slug' 	=> 'theme-general-settings',
		'parent_slug'	=> 'themes.php',
		'capability' 	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_page(array(
		'page_title' 	=> __('Casinos', '3betup'),
		'menu_title' 	=> __('Casinos', '3betup'),
		'menu_slug' 	=> 'casino-overview-settings',
		'parent_slug'	=> 'edit.php?post_type=casino',
		'capability' 	=> 'edit_posts',
		'redirect'		=> false
	));

}