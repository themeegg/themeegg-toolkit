<?php
/**
 * Logger class used in the ThemeEgg ToolKit plugin
 *
 * @package tetk
 */

// Include files.
if ( ! class_exists( 'TETK_Importer_Logger' ) ) {
	require TETK_ABSPATH. 'inc/importer/class-logger.php';
}
if ( ! class_exists( 'TETK_Importer_Logger_CLI' ) ) {
	require TETK_ABSPATH. 'inc/importer/class-logger-cli.php';
}


class TETK_Logger extends TETK_Importer_Logger_CLI {

	/**
	 * Variable for front-end error display.
	 */
	public $error_output = '';

	/**
	 * Overwritten log function from TETK_Importer_Logger_CLI.
	 *
	 * Logs with an arbitrary level.
	 *
	 * @param mixed $level level of reporting.
	 * @param string $message log message.
	 * @param array $context context to the log message.
	 */
	public function log( $level, $message, array $context = array() ) {

		// Save error messages for front-end display.
		$this->error_output( $level, $message, $context = array() );

		if ( $this->level_to_numeric( $level ) < $this->level_to_numeric( $this->min_level ) ) {
			return;
		}

		printf(
			'[%s] %s' . PHP_EOL,
			strtoupper( $level ),
			$message
		);
	}


	/**
	 * Save messages for error output.
	 * Only the messages greater then Error.
	 *
	 * @param mixed $level level of reporting.
	 * @param string $message log message.
	 * @param array $context context to the log message.
	 */
	public function error_output( $level, $message, array $context = array() ) {
		if ( $this->level_to_numeric( $level ) < $this->level_to_numeric( 'error' ) ) {
			return;
		}

		$this->error_output .= sprintf(
			'[%s] %s<br>',
			strtoupper( $level ),
			$message
		);
	}
}