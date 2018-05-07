<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class TETK_Theme_Demo_Education_Master_Pro extends TETK_Theme_Demo {

	public static function import_files() {

		$server_url = 'https://demo.themeegg.com/themes/education-master-pro/';
		$demo_urls  = array(
			array(
				'import_file_name'           => 'Education Master Pro',
				'import_file_url'            => $server_url . 'wp-content/themes/education-master-pro/demo-content/content.xml',
				'import_widget_file_url'     => $server_url . 'wp-content/themes/education-master-pro/demo-content/widgets.wie',
				'import_customizer_file_url' => $server_url . 'wp-content/themes/education-master-pro/demo-content/customizer.dat',
				'import_preview_image_url'   => $server_url . 'wp-content/themes/education-master-pro/screenshot.png',
				'demo_url'                   => $server_url . '',
				//'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'your-textdomain' ),
			)

		);

		return $demo_urls;

	}

	public static function after_import( $selected_import ) {

		$installed_demos = get_option( 'themeegg_themes', array() );

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
		$front_page_id = get_page_by_title( 'Home Page' );
		$blog_page_id  = get_page_by_title( 'Blog' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		update_option( 'page_for_posts', $blog_page_id->ID );
		update_option( 'themeegg_themes', $installed_demos );


		// Our Team
		$team_options     = get_option( 'widget_education-master-our-team' );
		$cat              = get_term_by( 'name', 'OurTeacher', 'team-categories' );
		$team_category_id = 0;
		if ( $cat ) {
			$team_category_id = $cat->term_id;
		}

		foreach ( $team_options as $key => $value ) {
			$team_options[ $key ]['post_category'] = $team_category_id;
		}
		update_option( 'widget_education-master-our-team', $team_options );

		// Carousel
		$carousel_widget_option = get_option( 'widget_education_master_carousel' );
		$event_id               = get_cat_ID( 'Event' );
		$school_id              = get_cat_ID( 'School' );
		foreach ( $carousel_widget_option as $key => $value ) {
			$carousel_widget_option[ $key ]['block_cat_ids'][ $event_id ]  = 1;
			$carousel_widget_option[ $key ]['block_cat_ids'][ $school_id ] = 1;
		}
		update_option( 'widget_education_master_carousel', $carousel_widget_option );

		// Feature Posts
		$feature_posts_options = get_option( 'widget_education_master_featured_posts' );
		foreach ( $feature_posts_options as $key => $value ) {
			$feature_posts_options[ $key ]['block_cat_ids'][ $event_id ]  = 1;
			$feature_posts_options[ $key ]['block_cat_ids'][ $school_id ] = 1;
		}
		update_option( 'widget_education_master_featured_posts', $feature_posts_options );


		// Education Master Timeline
		$timeline_options = get_option( 'widget_education-master-timeline' );
		$timeline_id      = get_cat_ID( 'Timeline' );
		foreach ( $timeline_options as $time_key => $time_value ) {
			$timeline_options[ $time_key ]['post_category'] = $timeline_id;
		}
		update_option( 'widget_education-master-timeline', $timeline_options );

	}
}

?>