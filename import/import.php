<?php

function tetk_get_supported_themes() {

	$supported_themes = array( 'Eggnews', 'Eggnews Pro' );

	return $supported_themes;
}

function TETK_import_files() {
	$theme     = wp_get_theme(); // gets the current theme
	$demo_urls = array();

	if ( $theme == 'Eggnews' ) {

		$demo_urls[] = array(
			'import_file_name'           => 'Eggnews',
			'import_file_url'            => 'http://demo.themeegg.com/themes/eggnews/wp-content/themes/eggnews/demo-content/content.xml',
			'import_widget_file_url'     => 'http://demo.themeegg.com/themes/eggnews/wp-content/themes/eggnews/demo-content/widgets.wie',
			'import_customizer_file_url' => 'http://demo.themeegg.com/themes/eggnews/wp-content/themes/eggnews/demo-content/customizer.dat',
			'import_preview_image_url'   => 'http://demo.themeegg.com/themes/eggnews/wp-content/themes/eggnews/screenshot.png',
			'demo_url'                   => 'http://demo.themeegg.com/themes/eggnews/',
			//'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
		);
	}
	if ( $theme == 'Eggnews Pro' ) {

		$demo_urls[] = array(
			'import_file_name'           => 'EggNews Pro',
			'import_file_url'            => 'http://demo.themeegg.com/themes/eggnews-pro/wp-content/themes/eggnews-pro/demo-content/content.xml',
			'import_widget_file_url'     => 'http://demo.themeegg.com/themes/eggnews-pro/wp-content/themes/eggnews-pro/demo-content/widgets.wie',
			'import_customizer_file_url' => 'http://demo.themeegg.com/themes/eggnews-pro/wp-content/themes/eggnews-pro/demo-content/customizer.dat',
			'import_preview_image_url'   => 'http://demo.themeegg.com/themes/eggnews-pro/wp-content/themes/eggnews-pro/screenshot.png',
			'demo_url'                   => 'http://demo.themeegg.com/themes/eggnews-pro/',
			//'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
		);
	}

	return $demo_urls;
}

function TETK_after_import_setup() {
	// Assign menus to their locations.
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

}

$theme            = wp_get_theme(); // gets the current theme
$supported_themes = tetk_get_supported_themes();
if ( in_array( $theme, $supported_themes ) ) {
	add_action( 'tetk-demo-content-import', 'TETK_import_files' );
	add_action( 'tetk-after-demo-content-import', 'TETK_after_import_setup' );

}


/*
function TETK_after_import( $selected_import ) {
	echo "This will be displayed on all after imports!";

	if ( 'Demo Import 1' === $selected_import['import_file_name'] ) {
		echo "This will be displayed only on after import if user selects Demo Import 1";

		// Set logo in customizer
		set_theme_mod( 'logo_img', get_template_directory_uri() . '/assets/images/logo1.png' );
	}
	elseif ( 'Demo Import 2' === $selected_import['import_file_name'] ) {
		echo "This will be displayed only on after import if user selects Demo Import 2";

		// Set logo in customizer
		set_theme_mod( 'logo_img', get_template_directory_uri() . '/assets/images/logo2.png' );
	}
}
add_action( 'tetk-after-demo-content-import', 'TETK_after_import' );*/

?>