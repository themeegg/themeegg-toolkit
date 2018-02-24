<?php
/**
 * Themeegg_Toolkit setup
 *
 * @author   ThemeEgg
 * @category API
 * @package  Themeegg_Toolkit
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Themeegg_Toolkit Class.
 *
 * @class Themeegg_Toolkit
 * @version    1.0.0
 */
final class Themeegg_Toolkit {

	/**
	 * Themeegg_Toolkit version.
	 *
	 * @var string
	 */
	public $version = '1.2.2';

	/**
	 * The single instance of the class.
	 *
	 * @var Themeegg_Toolkit
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Themeegg_Toolkit Instance.
	 *
	 * Ensures only one instance of Themeegg_Toolkit is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see TET()
	 * @return Themeegg_Toolkit - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 2.1
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'themeegg-toolkit' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'themeegg-toolkit' ), '1.0.0' );
	}

	/**
	 * Auto-load in-accessible properties on demand.
	 *
	 * @param mixed $key Key name.
	 *
	 * @return mixed
	 */
	public function __get( $key ) {
		if ( in_array( $key, array( '' ), true ) ) {
			return $this->$key();
		}
	}

	/**
	 * Themeegg_Toolkit Constructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();

		do_action( 'themeegg_toolkit_loaded' );
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since 2.3
	 */
	private function init_hooks() {
		//register_activation_hook( TETK_PLUGIN_FILE, array( 'TETK_Install', 'install' ) );
		register_shutdown_function( array( $this, 'log_errors' ) );
		add_action( 'after_setup_theme', array( $this, 'include_template_functions' ), 11 );
		add_action( 'init', array( $this, 'init' ), 0 );
	}

	/**
	 * Ensures fatal errors are logged so they can be picked up in the status report.
	 *
	 * @since 1.0.0
	 */
	public function log_errors() {

	}

	/**
	 * Define WC Constants.
	 */
	private function define_constants() {
		$upload_dir = wp_upload_dir( null, false );

		$this->define( 'TETK_ABSPATH', dirname( TETK_PLUGIN_FILE ) . '/' );
		$this->define( 'TETK_PLUGIN_BASENAME', plugin_basename( TETK_PLUGIN_FILE ) );
		$this->define( 'TETK_VERSION', $this->version );
		$this->define( 'THEMEEGG_TOOLKIT_VERSION', $this->version );
		$this->define( 'TETK_LOG_DIR', $upload_dir['basedir'] . '/tetk-logs/' );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string $name Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 *
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Check the active theme.
	 *
	 * @since  2.6.9
	 *
	 * @param  string $theme Theme slug to check.
	 *
	 * @return bool
	 */
	private function is_active_theme( $theme ) {
		return get_template() === $theme;
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {
		/**
		 * Class autoloader.
		 */
		include_once( TETK_ABSPATH . 'includes/class-tetk-autoloader.php' );

		/**
		 * Abstract classes.
		 */
		include_once( TETK_ABSPATH . 'includes/abstracts/abstract-tetk-theme-demo.php' ); // TETK_Data for CRUD.
		/**
		 * Core classes.
		 */
		include_once( TETK_ABSPATH . 'includes/tetk-core-functions.php' );
		include_once( TETK_ABSPATH . 'includes/class-tetk-ajax.php' );


		if ( $this->is_request( 'admin' ) ) {
			include_once( TETK_ABSPATH . 'includes/admin/class-tetk-admin.php' );
		}

		if ( $this->is_request( 'frontend' ) ) {
			$this->frontend_includes();
		}
	}

	/**
	 * Include required frontend files.
	 */
	public function frontend_includes() {

	}

	/**
	 * Function used to Init Themeegg_Toolkit Template Functions - This makes them pluggable by plugins and themes.
	 */
	public function include_template_functions() {
	}

	/**
	 * Init Themeegg_Toolkit when WordPress Initialises.
	 */
	public function init() {
		// Before init action.
		do_action( 'before_themeegg_toolkit_init' );

		// Set up localisation.
		$this->load_plugin_textdomain();

		// Init action.
		do_action( 'themeegg_toolkit_init' );
	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/themeegg-toolkit/themeegg-toolkit-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/themeegg-toolkit-LOCALE.mo
	 */
	public function load_plugin_textdomain() {
		$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'themeegg-toolkit' );

		unload_textdomain( 'themeegg-toolkit' );
		load_textdomain( 'themeegg-toolkit', WP_LANG_DIR . '/themeegg-toolkit/themeegg-toolkit-' . $locale . '.mo' );
		load_plugin_textdomain( 'themeegg-toolkit', false, plugin_basename( dirname( TETK_PLUGIN_FILE ) ) . '/i18n/languages' );
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', TETK_PLUGIN_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( TETK_PLUGIN_FILE ) );
	}

	/**
	 * Get the template path.
	 *
	 * @return string
	 */
	public function template_path() {
		return apply_filters( 'themeegg_toolkit_template_path', 'themeegg-toolkit/' );
	}

	/**
	 * Get Ajax URL.
	 *
	 * @return string
	 */
	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}
}
