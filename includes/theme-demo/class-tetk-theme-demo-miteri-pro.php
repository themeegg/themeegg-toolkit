<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class TETK_Theme_Demo_Miteri_Pro extends TETK_Theme_Demo {

	public static function import_files() {

		$server_url = 'https://demo.themeegg.com/themes/miteri-pro/';
		$demo_urls  = array(
			array(
				'import_file_name'           => 'Miteri Default',
				'import_file_url'            => $server_url . 'wp-content/demo-content/default/content.xml',
				'import_widget_file_url'     => $server_url . 'wp-content/demo-content/default/widgets.wie',
				'import_customizer_file_url' => $server_url . 'wp-content/demo-content/default/customizer.dat',
				'import_preview_image_url'   => $server_url . 'wp-content/demo-content/default/screenshot.png',
				'demo_url'                   => $server_url . '',
				//'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
			),
			array(
				'import_file_name'           => 'Miteri Blog',
				'import_file_url'            => $server_url . 'wp-content/demo-content/blog/content.xml',
				'import_widget_file_url'     => $server_url . 'wp-content/demo-content/blog/widgets.wie',
				'import_customizer_file_url' => $server_url . 'wp-content/demo-content/blog/customizer.dat',
				'import_preview_image_url'   => $server_url . 'wp-content/demo-content/blog/screenshot.png',
				'demo_url'                   => $server_url . '',
				//'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
			)
		);

		return $demo_urls;

	}

	public static function after_import( $selected_import ) {
		$installed_demos  = get_option( 'themeegg_themes', array() );
		$import_file_name = isset( $selected_import['import_file_name'] ) ? $selected_import['import_file_name'] : '';
		if ( ! empty( $import_file_name ) ) {
			array_push( $installed_demos, $import_file_name );
		}

		$installed_demos = array_unique( $installed_demos );

		// SET Menus

		$new_theme_locations = get_registered_nav_menus();

		$nav_menus = array();

		foreach ( $new_theme_locations as $location_key => $location ) {

			$menu = get_term_by( 'name', $location, 'nav_menu' );

			if ( isset( $menu->term_id ) ) {

				$nav_menus[ $location_key ] = $menu->term_id;
			}
		}
		if ( count( $nav_menus ) > 0 ) {
			set_theme_mod( 'nav_menu_locations', $nav_menus );
		}

// Assign front page and posts page (blog page).
		$front_page_id    = get_page_by_title( 'Home' );
		$blog_page_id     = get_page_by_title( 'Blog' );
		$blog_category_id = get_cat_ID( 'Blog' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		update_option( 'page_for_posts', $blog_page_id->ID );
		update_option( 'themeegg_themes', $installed_demos );

		switch ( $import_file_name ) {
			case 'Miteri Default':
				$menu_locations = get_nav_menu_locations();

				$menu_id = isset( $menu_locations['main_menu'] ) ? $menu_locations['main_menu'] : '-1';

				$main_navigation = wp_get_nav_menu_items( $menu_id );

				$home_menu_obj = array_filter( $main_navigation, function ( $var ) {
					return ( isset( $var->title ) && $var->title == 'Home' );
				} );
				$home_menu_id  = isset( $home_menu_obj[0] ) ? $home_menu_obj[0]->ID : 0;

				update_post_meta( $home_menu_id, 'te_mega_menu_cat', $blog_category_id );

				// Feature Slider Widget
				$feature_slider           = get_option( 'widget_miteri_featured_slider' );
				$miteri_slider_category   = get_cat_ID( 'Blog' );
				$miteri_featured_category = get_cat_ID( 'International' );
				foreach ( $feature_slider as $slider_key => $slider ) {
					$feature_slider[ $slider_key ]['miteri_slider_category']   = $miteri_slider_category;
					$feature_slider[ $slider_key ]['miteri_featured_category'] = $miteri_featured_category;
				}
				update_option( 'widget_miteri_featured_slider', $feature_slider );

				// Timeline widget
				$timeline_widget      = get_option( 'widget_miteri_timeline_widget' );
				$miteri_post_category = get_cat_ID( 'Technology' );
				foreach ( $timeline_widget as $timeline_key => $timeline ) {
					$timeline_widget[ $timeline_key ]['miteri_post_category'] = $miteri_post_category;
				}
				update_option( 'widget_miteri_timeline_widget', $timeline_widget );

				// Partner widget
				$logo_widget          = get_option( 'widget_miteri_logo_slider' );
				$miteri_logo_category = get_cat_ID( 'Our Partners' );
				foreach ( $logo_widget as $logo_key => $logo ) {
					$logo_widget[ $logo_key ]['miteri_logo_category'] = $miteri_logo_category;
				}
				update_option( 'widget_miteri_logo_slider', $logo_widget );

				// Latest News widget
				$post_grid_widget    = get_option( 'widget_miteri_post_grid' );
				$miteri_block_cat_id = get_cat_ID( 'Blog' );
				foreach ( $post_grid_widget as $post_grid_key => $grid ) {
					$post_grid_widget[ $post_grid_key ]['miteri_block_cat_id'] = $miteri_block_cat_id;
				}
				update_option( 'widget_miteri_post_grid', $post_grid_widget );
				break;

			case 'Miteri Blog':
				// Feature Slider Widget
				$feature_slider           = get_option( 'widget_miteri_featured_slider' );
				$miteri_slider_category   = get_cat_ID( 'Mobile' );
				$miteri_featured_category = get_cat_ID( 'Technology' );
				foreach ( $feature_slider as $slider_key => $slider ) {
					$feature_slider[ $slider_key ]['miteri_slider_category']   = $miteri_slider_category;
					$feature_slider[ $slider_key ]['miteri_featured_category'] = $miteri_featured_category;
				}
				update_option( 'widget_miteri_featured_slider', $feature_slider );

				// Timeline widget
				$timeline_widget      = get_option( 'widget_miteri_timeline_widget' );
				$miteri_post_category = get_cat_ID( 'Mobile' );
				foreach ( $timeline_widget as $timeline_key => $timeline ) {
					$timeline_widget[ $timeline_key ]['miteri_post_category'] = $miteri_post_category;
				}
				update_option( 'widget_miteri_timeline_widget', $timeline_widget );

				// Alternative widget
				$alternative_widget  = get_option( 'widget_miteri_alternative_post' );
				$miteri_block_cat_id = get_cat_ID( 'Mobile' );
				foreach ( $alternative_widget as $alternative_key => $alternative ) {
					$alternative_widget[ $alternative_key ]['miteri_block_cat_id'] = $miteri_block_cat_id;
				}
				update_option( 'widget_miteri_alternative_post', $alternative_widget );

				// Block Posts
				$post_grid_widget    = get_option( 'widget_miteri_post_grid' );
				$miteri_block_cat_id = get_cat_ID( 'Mobile' );
				foreach ( $post_grid_widget as $post_grid_key => $grid ) {
					$post_grid_widget[ $post_grid_key ]['miteri_block_cat_id'] = $miteri_block_cat_id;
				}
				update_option( 'widget_miteri_post_grid', $post_grid_widget );


				// Recent Posts
				$miteri_block_layout = get_option( 'widget_miteri_block_layout' );
				$miteri_block_cat_id = get_cat_ID( 'Technology' );
				foreach ( $miteri_block_layout as $block_key => $block ) {
					$miteri_block_layout[ $block_key ]['miteri_block_cat_id'] = $miteri_block_cat_id;
				}
				update_option( 'widget_miteri_block_layout', $miteri_block_layout );
				break;
			default:

		}
	}
}

?>