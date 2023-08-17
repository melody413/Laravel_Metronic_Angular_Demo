<?php
/**
 * Class for logging events and errors
 *
 * Based on the EDD log class
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * TIE_LOGGING Class
 *
 * A general use class for logging events and errors.
 */
class TIE_LOGGING {

	public $is_writable = true;
	private $filename   = '';
	private $file       = '';

	/**
	 * Set up the TIE Logging Class
	 */
	public function __construct() {

		add_action( 'after_setup_theme', array( $this, 'setup_log_file' ), 0 );
	}

	/**
	 * Sets up the log file if it is writable
	 */
	public function setup_log_file() {

		$upload_dir       = wp_upload_dir();
		$this->filename   = wp_hash( home_url( '/' ) ) . '-tie-debug-'. TIELABS_THEME_SLUG .'.log';
		$this->file       = trailingslashit( $upload_dir['basedir'] ) . $this->filename;

		if ( ! is_writeable( $upload_dir['basedir'] ) ) {
			$this->is_writable = false;
		}
	}

	/**
	 * Retrieve the log data
	 */
	public function get_file_contents() {
		return $this->get_file();
	}

	/**
	 * Log message to file
	 */
	public function log_to_file( $message = '' ) {
		$message = date( 'Y-n-d H:i:s' ) . ' - ' . serialize( $message ) . "\r\n";
		$this->write_to_log( $message );
	}

	/**
	 * Retrieve the file data is written to
	 */
	protected function get_file() {

		$file = '';

		if ( @file_exists( $this->file ) ) {

			if ( ! is_writeable( $this->file ) ) {
				$this->is_writable = false;
			}

			$file = @file_get_contents( $this->file );

		} else {

			@file_put_contents( $this->file, '' );
			@chmod( $this->file, 0664 );

		}

		return $file;
	}

	/**
	 * Write the log message
	 */
	protected function write_to_log( $message = '' ) {

		$file = $this->get_file();
		$file .= $message;
		@file_put_contents( $this->file, $file );
	}

	/**
	 * Delete the log file or removes all contents in the log file if we cannot delete it
	 */
	public function clear_log_file() {

		@unlink( $this->file );

		if ( file_exists( $this->file ) ) {

			// it's still there, so maybe server doesn't have delete rights
			chmod( $this->file, 0664 ); // Try to give the server delete rights
			@unlink( $this->file );

			// See if it's still there
			if ( @file_exists( $this->file ) ) {

				/*
				 * Remove all contents of the log file if we cannot delete it
				 */
				if ( is_writeable( $this->file ) ) {

					file_put_contents( $this->file, '' );

				} else {
					return false;
				}
			}
		}

		$this->file = '';
		return true;
	}

	/**
	 * Return the location of the log file that EDD_Logging will use.
	 */
	public function get_log_file_path() {
		return $this->file;
	}

}

// Initiate the logging system
$GLOBALS['tie_logs'] = new TIE_LOGGING();


/**
 * Logs a message to the debug log file
 */
function tie_debug_log( $message = '', $force = false ) {

	global $tie_logs;

	if ( tie_is_debug_mode() || $force ) {

		if( function_exists( 'mb_convert_encoding' ) ) {

			//$message = mb_convert_encoding( $message, 'UTF-8' );
		}

		$tie_logs->log_to_file( $message );
	}

	else{
		error_log( print_r( $message, true ) );
	}
}


/**
 * Is Debug Mode
 */
function tie_is_debug_mode() {

	$ret = tie_get_option( 'debug_mode' );

	if( defined( 'TIE_DEBUG_MODE' ) && TIE_DEBUG_MODE ) {
		$ret = true;
	}

	return (bool) apply_filters( 'tie_is_debug_mode', $ret );
}
