<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ThemeEggToolKit Autoloader.
 *
 * @class           TETK_Autoloader
 * @version        1.0.0
 * @package        ThemeEggToolKit/Classes
 * @category        Class
 * @author        ThemeEgg
 */
class TETK_Autoloader {

	/**
	 * Path to the includes directory.
	 *
	 * @var string
	 */
	private $include_path = '';

	/**
	 * The Constructor.
	 */
	public function __construct() {
		if ( function_exists( "__autoload" ) ) {
			spl_autoload_register( "__autoload" );
		}

		spl_autoload_register( array( $this, 'autoload' ) );

		$this->include_path = untrailingslashit( plugin_dir_path( TETK_PLUGIN_FILE ) ) . '/includes/';
	}

	/**
	 * Take a class name and turn it into a file name.
	 *
	 * @param  string $class
	 *
	 * @return string
	 */
	private function get_file_name_from_class( $class ) {
		return 'class-' . str_replace( '_', '-', $class ) . '.php';
	}

	/**
	 * Include a class file.
	 *
	 * @param  string $path
	 *
	 * @return bool successful or not
	 */
	private function load_file( $path ) {
		if ( $path && is_readable( $path ) ) {
			include_once( $path );

			return true;
		}

		return false;
	}

	/**
	 * Auto-load TETK classes on demand to reduce memory consumption.
	 *
	 * @param string $class
	 */
	public function autoload( $class ) {
		$class = strtolower( $class );

		if ( 0 !== strpos( $class, 'tetk_' ) ) {
			return;
		}

		$file = $this->get_file_name_from_class( $class );
		$path = '';

		if ( 0 === strpos( $class, 'tetk_theme_demo' ) ) {
			$path = $this->include_path . 'theme-demo/';
		} elseif ( 0 === strpos( $class, 'tetk_admin' ) ) {
			$path = $this->include_path . 'admin/';
		} elseif ( 0 === strpos( $class, 'tetk_log_handler_' ) ) {
			$path = $this->include_path . 'log-handlers/';
		} elseif ( 0 === strpos( $class, 'tetk_importer' ) ) {
			$path = $this->include_path . 'importer/';
		}

		if ( empty( $path ) || ! $this->load_file( $path . $file ) ) {
			$this->load_file( $this->include_path . $file );
		}
	}
}

new TETK_Autoloader();
