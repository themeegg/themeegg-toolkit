<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class TETK_Theme_Demo_Eggnews extends TETK_Theme_Demo {

	public static function import_files() {

		$demo_urls = array(
			array(
				'import_file_name'           => 'Eggnews',
				'import_file_url'            => 'https://demo.themeegg.com/themes/eggnews/wp-content/themes/eggnews/demo-content/content.xml',
				'import_widget_file_url'     => 'https://demo.themeegg.com/themes/eggnews/wp-content/themes/eggnews/demo-content/widgets.wie',
				'import_customizer_file_url' => 'https://demo.themeegg.com/themes/eggnews/wp-content/themes/eggnews/demo-content/customizer.dat',
				'import_preview_image_url'   => 'https://demo.themeegg.com/themes/eggnews/wp-content/themes/eggnews/screenshot.png',
				'demo_url'                   => 'https://demo.themeegg.com/themes/eggnews/',
				//'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
			)
		);

		return $demo_urls;
	}

	public static function after_import() {


		$widget_categories = get_option( 'widget_eggnews_featured_slider' );

		$feature_slider_category = get_category_by_slug( 'model' );
		$term_id                 = isset( $feature_slider_category->term_id ) ? $feature_slider_category->term_id : 6;

		foreach ( $widget_categories as $cat_key => $cat_value ) {

			if ( isset( $cat_value['eggnews_featured_category'] ) ) {

				$widget_categories[ $cat_key ]['eggnews_featured_category'] = $term_id;
			}
		}

		update_option( 'widget_eggnews_featured_slider', $widget_categories );
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
}

?>