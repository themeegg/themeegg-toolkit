<?php
/*
Plugin Name: ThemeEgg ToolKit
Plugin URI: https://wordpress.org/plugins/themeegg-toolkit/
Description: ToolKit for ThemeEgg themes and demo content importer for themes.
Version: 1.2.2
Author: ThemeEgg
Author URI: http://themeegg.com
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: themeegg-toolkit
*/

// Block direct access to the main plugin file.
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define TETK_PLUGIN_FILE.
if ( ! defined( 'TETK_PLUGIN_FILE' ) ) {
	define( 'TETK_PLUGIN_FILE', __FILE__ );
}

// Include the main WooCommerce class.
if ( ! class_exists( 'Themeegg_Toolkit' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-themeegg-toolkit.php';
}

/**
 * Main instance of Themeegg_Toolkit.
 *
 * Returns the main instance of TET to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return Themeegg_Toolkit
 */
function TETK() {
	return Themeegg_Toolkit::instance();
}

// Global for backwards compatibility.
$GLOBALS['themeegg-toolkit'] = TETK();