<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
$main_menu = get_term_by( 'name', 'Top Menu', 'nav_menu' );

set_theme_mod( 'nav_menu_locations', array(
		'primary-menu' => $main_menu->term_id,
	)
);

// Assign front page and posts page (blog page).
$front_page_id = get_page_by_title( 'Home' );
$blog_page_id  = get_page_by_title( 'Blog' );

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $front_page_id->ID );
update_option( 'page_for_posts', $blog_page_id->ID );