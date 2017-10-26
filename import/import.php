<?php

function TETK_import_files() {
	return array(
		array(
			'import_file_name'           => 'EggNews',
			'import_file_url'            => 'https://raw.githubusercontent.com/themeegg/eggnews/master/demo-content/content.xml',
			'import_widget_file_url'     => 'https://raw.githubusercontent.com/themeegg/eggnews/master/demo-content/widgets.wie',
			'import_customizer_file_url' => 'https://raw.githubusercontent.com/themeegg/eggnews/master/demo-content/customizer.dat',
			'import_preview_image_url'   => 'https://raw.githubusercontent.com/themeegg/eggnews/master/screenshot.png',
			//'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
		),
	);
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

$theme = wp_get_theme(); // gets the current theme
if ( 'Eggnews' == $theme ) {
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