<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ThemeEggToolKit TETK_AJAX.
 *
 * AJAX Event Handler.
 *
 * @class    TETK_AJAX
 * @package  ThemeEggToolKit/Classes
 * @category Class
 * @author   ThemeEgg
 */
class TETK_AJAX {

	/**
	 * Hook in ajax handlers.
	 */
	public static function init() {
		return;
		add_action( 'init', array( __CLASS__, 'define_ajax' ), 0 );
		add_action( 'template_redirect', array( __CLASS__, 'do_tetk_ajax' ), 0 );
		self::add_ajax_events();
	}

	/**
	 * Set TETK AJAX constant and headers.
	 */
	public static function define_ajax() {
		if ( ! empty( $_GET['tetk-ajax'] ) ) {
			tetk_maybe_define_constant( 'DOING_AJAX', true );
			tetk_maybe_define_constant( 'TETK_DOING_AJAX', true );
			if ( ! WP_DEBUG || ( WP_DEBUG && ! WP_DEBUG_DISPLAY ) ) {
				@ini_set( 'display_errors', 0 ); // Turn off display_errors during AJAX events to prevent malformed JSON
			}
			$GLOBALS['wpdb']->hide_errors();
		}
	}

	/**
	 * Send headers for TETK Ajax Requests.
	 *
	 * @since 1.0.0
	 */
	private static function tetk_ajax_headers() {
		send_origin_headers();
		@header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
		@header( 'X-Robots-Tag: noindex' );
		send_nosniff_header();
		status_header( 200 );
	}

	/**
	 * Check for TETK Ajax request and fire action.
	 */
	public static function do_tetk_ajax() {
		global $wp_query;

		if ( ! empty( $_GET['tetk-ajax'] ) ) {
			$wp_query->set( 'tetk-ajax', sanitize_text_field( $_GET['tetk-ajax'] ) );
		}

		if ( $action = $wp_query->get( 'tetk-ajax' ) ) {
			self::tetk_ajax_headers();
			do_action( 'tetk_ajax_' . sanitize_text_field( $action ) );
			wp_die();
		}
	}

	/**
	 * Hook in methods - uses WordPress ajax handlers (admin-ajax).
	 */
	public static function add_ajax_events() {
		// themeegg_toolkit_EVENT => nopriv
		$ajax_events = array(
			'test' => false,
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_themeegg_toolkit_' . $ajax_event, array( __CLASS__, $ajax_event ) );

			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_themeegg_toolkit_' . $ajax_event, array( __CLASS__, $ajax_event ) );

				// TETK AJAX can be used for frontend ajax requests.
				add_action( 'tetk_ajax_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
		}
	}


	/**
	 * AJAX test.
	 */
	public static function test() {
	}
}

TETK_AJAX::init();
