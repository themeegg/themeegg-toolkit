<?php
/*
Plugin Name: ThemeEgg ToolKit
Plugin URI: https://wordpress.org/plugins/themeegg-toolkit/
Description: ToolKit for ThemeEgg themes and demo content importer for themes.
Version: 1.1.1
Author: ThemeEgg
Author URI: http://themeegg.com
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: themeegg-toolkit
*/

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Display admin error message if PHP version is older than 5.3.2.
 * Otherwise execute the main plugin class.
 */
if ( version_compare( phpversion(), '5.3.2', '<' ) ) {

	/**
	 * Display an admin error notice when PHP is older the version 5.3.2.
	 * Hook it to the 'admin_notices' action.
	 */
	function TETK_old_php_admin_error_notice() {
		$message = sprintf( esc_html__( 'The %2$sThemeEgg ToolKit%3$s plugin requires %2$sPHP 5.3.2+%3$s to run properly. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.3.2.%4$s Your current version of PHP: %2$s%1$s%3$s', 'themeegg-toolkit' ), phpversion(), '<strong>', '</strong>', '<br>' );

		printf( '<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}

	add_action( 'admin_notices', 'TETK_old_php_admin_error_notice' );
} else {

	// Current version of the plugin.
	define( 'TETK_VERSION', '1.1.1' );

	// Path/URL to root of this plugin, with trailing slash.
	define( 'TETK_PATH', plugin_dir_path( __FILE__ ) );
	define( 'TETK_URL', plugin_dir_url( __FILE__ ) );

	require TETK_PATH . 'import/import.php';
	// Require main plugin file.
	require TETK_PATH . 'inc/class-tetk-main.php';

	// Instantiate the main plugin class *Singleton*.
	$TETK_Demo_Import = TETK_Demo_Import::getInstance();
}
