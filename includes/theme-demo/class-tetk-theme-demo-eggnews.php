<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class TETK_Theme_Demo_Eggnews extends TETK_Theme_Demo {

	public static function import_files() {

		$server_url = 'https://demo.themeegg.com/themes/eggnews/';
		//$server_url = 'http://localhost/WordPressThemes/wordpress_fresh/';
		$demo_urls  = array(
			array(
				'import_file_name'           => 'Eggnews',
				'import_file_url'            => $server_url . 'wp-content/themes/eggnews/demo-content/content.xml',
				'import_widget_file_url'     => $server_url . 'wp-content/themes/eggnews/demo-content/widgets.wie',
				'import_customizer_file_url' => $server_url . 'wp-content/themes/eggnews/demo-content/customizer.dat',
				'import_preview_image_url'   => $server_url . 'wp-content/themes/eggnews/screenshot.png',
				'demo_url'                   => $server_url . '',
				//'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
			)
		);

		return $demo_urls;
	}

	public static function after_import( $selected_import ) {


		$widget_categories = get_option( 'widget_eggnews_featured_slider' );

		$feature_slider_category = get_category_by_slug( 'model' );

		$installed_demos  = get_option( 'themeegg_themes', array() );
		$import_file_name = isset( $selected_import['import_file_name'] ) ? $selected_import['import_file_name'] : '';
		if ( ! empty( $import_file_name ) ) {
			array_push( $installed_demos, $import_file_name );
		}

		$installed_demos = array_unique( $installed_demos );

		$term_id = isset( $feature_slider_category->term_id ) ? $feature_slider_category->term_id : 6;

		foreach ( $widget_categories as $cat_key => $cat_value ) {

			if ( isset( $cat_value['eggnews_featured_category'] ) ) {

				$widget_categories[ $cat_key ]['eggnews_featured_category'] = $term_id;
			}
		}

		update_option( 'widget_eggnews_featured_slider', $widget_categories );


		// SET Menus

		$new_theme_locations = get_registered_nav_menus();

		foreach ( $new_theme_locations as $location_key => $location ) {

			$menu = get_term_by( 'name', $location, 'nav_menu' );

			if ( isset( $menu->term_id ) ) {
				set_theme_mod( 'nav_menu_locations', array(
						'primary' => $menu->term_id,
					)
				);
			}
		}


// Assign front page and posts page (blog page).
		$front_page_id = get_page_by_title( 'Home' );
		$blog_page_id  = get_page_by_title( 'Blog' );

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		update_option( 'page_for_posts', $blog_page_id->ID );
		update_option( 'themeegg_themes', $installed_demos );


	}
}

?>