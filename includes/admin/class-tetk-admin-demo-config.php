<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ThemeEggToolKit Autoloader.
 *
 * @class           TETK_Config_Demo
 * @version        1.0.0
 * @package        ThemeEggToolKit/Classes
 * @category        Class
 * @author        ThemeEgg
 */
class TETK_Admin_Demo_Config {

	private $theme = '';
	private $import_class = '';

	public function __construct() {
		$this->theme = wp_get_theme();
		add_filter( 'tetk-demo-content-import', array( $this, 'import_files' ) );
		add_action( 'tetk-after-demo-content-import', array( $this, 'after_import' ) );
	}

	private function get_import_class() {

		$supported_themes = $this->supported_themes();
		$demo_class       = '';
		foreach ( $supported_themes as $theme ) {
			$theme_name = isset( $theme['theme_name'] ) ? $theme['theme_name'] : '';
			if ( trim( $theme_name ) === trim( $this->theme ) ) {

				$demo_class = isset( $theme['demo_class'] ) ? $theme['demo_class'] : '';
				break;
			}
		}

		return $demo_class;
	}

	private function supported_themes() {

		return array(

			'eggnews'       => array(

				'theme_name' => 'Eggnews',
				'demo_class' => 'TETK_Theme_Demo_Eggnews',
			),
			'eggnews_pro'   => array(

				'theme_name' => 'Eggnews Pro',
				'demo_class' => 'TETK_Theme_Demo_Eggnews_Pro',
			),
			'official_plus' => array(
				'theme_name' => 'Official Plus',
				'demo_class' => 'TETK_Theme_Demo_Official_Plus',
			),
			'miteri'        => array(
				'theme_name' => 'Miteri',
				'demo_class' => 'TETK_Theme_Demo_Miteri',
			),
			'miteri_pro'    => array(
				'theme_name' => 'Miteri Pro',
				'demo_class' => 'TETK_Theme_Demo_Miteri_Pro',
			)
		);


	}


	public function import_files() {

		$import_class = $this->get_import_class();

		if ( empty( $import_class ) ) {

			return array();
		}


		return $import_class::import_files();

	}

	public function after_import( $selected_import ) {


		$import_class = $this->get_import_class();


		if ( empty( $import_class ) ) {

			return '';
		}

		$import_class::after_import( $selected_import );
	}
}

new TETK_Admin_Demo_Config();
