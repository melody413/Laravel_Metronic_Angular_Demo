<?php

/*
Plugin One Click Demo Import
Plugin URI: https://wordpress.org/plugins/one-click-demo-import/
Description: Import your content, widgets and theme settings with one click. Theme authors! Enable simple demo import for your theme demo data.
Version: 1.1.3
Author: ProteusThemes
Author URI: http://www.proteusthemes.com
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
*/

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Path/URL to root of this plugin, with trailing slash.
define( 'PT_OCDI_URL',  get_template_directory_uri().'/framework/vendor/one-click-demo-import/' );
define( 'PT_OCDI_PATH',     get_template_directory().'/framework/vendor/one-click-demo-import/' );

// Current version of the plugin.
define( 'PT_OCDI_VERSION', '1.1.3' );

// Include files.
require PT_OCDI_PATH . 'inc/class-ocdi-helpers.php';
require PT_OCDI_PATH . 'inc/class-ocdi-importer.php';
require PT_OCDI_PATH . 'inc/class-ocdi-widget-importer.php';
require PT_OCDI_PATH . 'inc/class-ocdi-customizer-importer.php';
require PT_OCDI_PATH . 'inc/class-ocdi-logger.php';

/**
 * One Click Demo Import class, so we don't have to worry about namespaces.
 */
class PT_One_Click_Demo_Import {

	/**
	 * @var $instance the reference to *Singleton* instance of this class
	 */
	private static $instance;

	/**
	 * Private variables used throughout the plugin.
	 */
	private $importer, $plugin_page, $import_files, $logger, $log_file_path, $selected_index, $selected_import_files, $microtime, $frontend_error_messages, $ajax_call_number;

	private $start_time; // TieLabs


	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return PT_One_Click_Demo_Import the *Singleton* instance.
	 */
	public static function getInstance(){
		if ( null === static::$instance ){
			static::$instance = new static();
		}

		return static::$instance;
	}


	/**
	 * Class construct function, to initiate the plugin.
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct(){

		// Actions.
		add_action( 'admin_menu', array( $this, 'create_plugin_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'wp_ajax_ocdi_import_demo_data', array( $this, 'import_demo_data_ajax_callback' ) );
		add_action( 'after_setup_theme', array( $this, 'setup_plugin_with_filter_data' ) );
		//add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
	}


	/**
	 * Private clone method to prevent cloning of the instance of the *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone(){}


	/**
	 * Private unserialize method to prevent unserializing of the *Singleton* instance.
	 *
	 * @return void
	 */
	public function __wakeup(){}


	/**
	 * Creates the plugin page and a submenu item in WP Appearance menu.
	 */
	public function create_plugin_page(){
		$plugin_page_setup = apply_filters( 'pt-ocdi/plugin_page_setup', array(
				'parent_slug' => 'themes.php',
				'page_title'  => esc_html__( 'Choose the demo which you want to import', TIELABS_TEXTDOMAIN ),
				'menu_title'  => esc_html__( 'Demo Import', TIELABS_TEXTDOMAIN ),
				'capability'  => 'import',
				'menu_slug'   => 'pt-one-click-demo-import',
			)
		);

		$menu = 'add_'.'submenu'.'_page'; //#####
		$this->plugin_page = $menu( $plugin_page_setup['parent_slug'], $plugin_page_setup['page_title'], $plugin_page_setup['menu_title'], $plugin_page_setup['capability'], $plugin_page_setup['menu_slug'], array( $this, 'display_plugin_page' ) );
	}


	/**
	 * Plugin page display.
	 */
	public function display_plugin_page(){


	// by TieLabs ***************************************************************

		if( isset( $_REQUEST['uninstall-demo'] ) ){

			if( 'yes' == $_REQUEST['uninstall-demo'] && check_admin_referer( 'uninstall_demos', 'uninstall_demos_nonce' ) ){
				TIELABS_DEMO_IMPORTER::_uninstall();
			}

			elseif( 'done' == $_REQUEST['uninstall-demo'] ){
				?>
				<div style="display: block;" class="ocdi__response js-tie-ajax-response js-ocdi-ajax-response">

					<div class="tie-loading-container js-tie-ajax-loader">
						<div id="tie-saving-settings" class="is-success">
							<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
								<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"></circle>
								<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path>
								<path class="checkmark__error_1" d="M38 38 L16 16 Z"></path>
								<path class="checkmark__error_2" d="M16 38 38 16 Z"></path>
							</svg>
						</div>
					</div>

					<h3 class="is-done"><?php esc_html_e( 'Demo data has been successfully uninstalled', TIELABS_TEXTDOMAIN ); ?></h3>
				</div>
				<?php
			}
			return;
		}

	// by TieLabs ***************************************************************



		$demos_count = tie_get_latest_theme_data( 'demos' );
		if( ! empty( $demos_count ) && is_array( $demos_count ) ){

			$demos_count = count( tie_get_latest_theme_data( 'demos' ) );
			update_option( TIELABS_THEME_SLUG .'_demos_count', $demos_count, false );
		}

	?>

	<div id="tie-import-wrap" class="ocdi wrap about-wrap tie-about-wrap">

		<?php TIELABS_WELCOME_PAGE::_head_section( 'demos' ); ?>

		<?php

			$plugin_page_setup = apply_filters( 'pt-ocdi/plugin_page_setup', array(
					'page_title'  => esc_html__( 'Choose the demo which you want to import', TIELABS_TEXTDOMAIN ),
				)
			);

			do_action( 'TieLabs/Demos/before_page_title' );
		?>

		<h2 class="tie-import-title"><?php echo esc_html( $plugin_page_setup['page_title'] ) ?></h2>

		<?php

			if( ! get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
				TIELABS_VERIFICATION::authorize_notice( false );
			}

			//else{
		?>



		<?php

		// Start output buffer for displaying the plugin intro text.
		ob_start();
		?>

		<div class="ocdi__intro-text">
			<p>
				<?php esc_html_e( 'Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme. It will allow you to quickly edit everything instead of creating content from scratch. When you import the data, the following things might happen:', TIELABS_TEXTDOMAIN ); ?>
			</p>

			<ul>
				<li><?php esc_html_e( 'No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', TIELABS_TEXTDOMAIN ); ?></li>
				<li><?php esc_html_e( 'Posts, pages, images, widgets and menus will get imported.', TIELABS_TEXTDOMAIN ); ?></li>
				<li><?php esc_html_e( 'Please click "Import Demo Data" button only once and wait, it can take a couple of minutes.', TIELABS_TEXTDOMAIN ); ?></li>
			</ul>
		</div>

		<div class="ocdi__intro-text">
			<p><?php esc_html_e( 'Before you begin, make sure all the required plugins are activated.', TIELABS_TEXTDOMAIN ); ?></p>
		</div>

		<?php
			$plugin_intro_text = ob_get_clean();

			// Display the plugin intro text (can be replaced with custom text through the filter below).
			echo wp_kses_post( apply_filters( 'pt-ocdi/plugin_intro_text', $plugin_intro_text ) );
		?>


		<?php if ( ! empty ( $this->import_files ) ) : ?>


		<?php // by TieLabs *************************************************************** ?>

		<div class="theme-browser tie-demo-importer rendered" id="ocdi__demo-import-files">
			<?php foreach ( $this->import_files as $index => $import_file ) :	?>
				<div class="theme">
					<div class="theme-screenshot" data-value="<?php echo esc_attr( $index ); ?>">
						<div class="demo-desc"><?php echo ! empty( $import_file['import_notice'] ) ? wp_kses_post( $import_file['import_notice'] ) : ''; ?></div>
						<img src="<?php echo esc_attr( $import_file['import_preview_image_url'] ); ?>">
						<span class="more-details"><?php echo esc_html__( 'Import', TIELABS_TEXTDOMAIN ); ?></span>
						<?php
							if( ! empty( $import_file['new_demos'] ) ){
								echo '<span class="new-demo">'. esc_html__( 'New', TIELABS_TEXTDOMAIN ) .'</span>';
							}
						?>
					</div>

					<div class="theme-id-container">
						<h3 class="theme-name"><?php echo esc_html( $import_file['import_file_name'] ); ?></h3>
						<?php
							if( ! empty( $import_file['import_demo'] ) ) { ?>
								<div class="theme-actions">
									<a class="tie-live-demo button button-secondry" target="_blank" href="<?php echo esc_url( $import_file['import_demo'] ); ?>"><?php echo esc_html__( 'Live Demo', TIELABS_TEXTDOMAIN ); ?></a>
								</div>
								<?php
							}
						?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<?php // by TieLabs ***************************************************************?>


		<?php endif; ?>


		<div class="clear"></div>

		<div id="tie-page-overlay"></div>

		<div id="tie-import-data-notes" class="theme-overlay tie-popup-window">
			<div class="theme-overlay">

				<div class="theme-wrap wp-clearfix">
					<div class="theme-header">
						<button class="close dashicons dashicons-no"><span class="screen-reader-text"></span></button>
					</div>
					<div class="theme-about wp-clearfix">

						<div class="theme-screenshots">
							<div class="screenshot"><img alt=""></div>
						</div>

						<div class="theme-info">
							<h3 class="theme-name"></h3>
							<p class="theme-tags"></p>
							<div id="theme-description" class="theme-description"></div>
						</div>

						<div class="wp-clearfix"></div>

						<?php

							if( ! get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
								TIELABS_VERIFICATION::authorize_notice( false );
							}

							else{ ?>
							<div class="tie-message-hint">
								<h4>
									<?php esc_html_e( 'Important Notes:', TIELABS_TEXTDOMAIN ); ?>
								</h4>

								<ol>
									<li><?php esc_html_e( 'We recommend to run Demo Import on a clean WordPress installation.', TIELABS_TEXTDOMAIN ); ?></li>
									<li><?php esc_html_e( 'The Demo Import will not import the images we have used in our live demos, due to copyright / license reasons.', TIELABS_TEXTDOMAIN ); ?></li>
									<li><?php esc_html_e( 'No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', TIELABS_TEXTDOMAIN ); ?></li>
									<li><?php esc_html_e( 'Posts, pages, images, widgets and menus will get imported.', TIELABS_TEXTDOMAIN ); ?></li>
									<li><?php esc_html_e( 'Before you begin, make sure all the required plugins are activated.', TIELABS_TEXTDOMAIN ); ?></li>
									<li><?php esc_html_e( 'Do not run the Demo Import multiple times one after another, it will result in double content.', TIELABS_TEXTDOMAIN ); ?></li>
								</ol>
							</div>
						<?php } ?>

					</div>

					<?php if( get_option( 'tie_token_'.TIELABS_THEME_ID ) ): ?>
					<div class="theme-actions">
						<div class="import-button">
							<a id="tie-install-demo" class="tie-primary-button button button-primary button-hero" href="#"><?php echo esc_html__( 'Import', TIELABS_TEXTDOMAIN ); ?></a>
							<a id="tie-view-demo" class="tie-primary-button button button-hero" target="_blank" href="#"><?php echo esc_html__( 'Live Demo', TIELABS_TEXTDOMAIN ); ?></a>
						</div>

						<div class="imported-buttons">
							<a class="tie-primary-button button button-primary button-hero" href="<?php echo admin_url( 'admin.php?page=tie-theme-options' ) ?>"><?php echo esc_html__( 'Theme Options', TIELABS_TEXTDOMAIN ); ?></a>
							<a class="tie-primary-button button button-hero" target="_blank" href="<?php echo esc_url(home_url( '/' )) ?>"><?php echo esc_html__( 'Visit Site', TIELABS_TEXTDOMAIN ); ?></a>
						</div>
					</div>
					<?php endif; ?>

					<div class="ocdi__response js-tie-ajax-response js-ocdi-ajax-response">

						<div class="tie-loading-container js-tie-ajax-loader">
							<div id="tie-saving-settings">
								<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
									<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
									<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
									<path class="checkmark__error_1" d="M38 38 L16 16 Z"/>
									<path class="checkmark__error_2" d="M16 38 38 16 Z" />
								</svg>
							</div>
						</div>

						<div class="clear"></div>

						<div class="tie-loading-wrapper">
							<h3><?php esc_html_e( 'Importing Demo Content...', TIELABS_TEXTDOMAIN ); ?></h3>
							<h4><?php esc_html_e( 'Please be patient and do not navigate away from this page while the import is in progress. This can take a while if your server is slow.', TIELABS_TEXTDOMAIN ); ?></h4>
							<h4><?php esc_html_e( 'You will be notified via this page when the import is completed.', TIELABS_TEXTDOMAIN ); ?></h4>
						</div>
					</div>

				</div><!-- .theme-wrap -->
			</div><!-- .theme-overlay -->
		</div><!-- .tie-import-data-notes -->


	</div> <!-- #tie-import-wrap -->

	<?php

		//}//Validation else
	}


	/**
	 * Enqueue admin scripts (JS and CSS)
	 *
	 * @param string $hook holds info on which admin page you are currently loading.
	 */
	public function admin_enqueue_scripts( $hook ){

		// Enqueue the scripts only on the plugin page.
		if ( $this->plugin_page === $hook ){
			wp_enqueue_script( 'ocdi-main-js', PT_OCDI_URL . 'assets/js/main.js', array( 'jquery', 'jquery-form' ), PT_OCDI_VERSION );

			wp_localize_script( 'ocdi-main-js', 'ocdi',
				array(
					//'ajax_url'     => admin_url( 'admin-ajax.php' ), // TieLabs, replaced in the JS file to use the global ajaxurl to avoid SSL importing demo issue
					'ajax_nonce'   => wp_create_nonce( 'ocdi-ajax-verification' ),
					'import_files' => $this->import_files,
					'texts'        => array(
						'missing_preview_image' => esc_html__( 'No preview image defined for this import.', TIELABS_TEXTDOMAIN ),
					),
				)
			);
		}
	}


	/**
	 * Main AJAX callback function for:
	 * 1. prepare import files (uploaded or predefined via filters)
	 * 2. import content
	 * 3. before widgets import setup (optional)
	 * 4. import widgets (optional)
	 * 5. import customizer options (optional)
	 * 6. after import setup (optional)
	 */
	public function import_demo_data_ajax_callback(){
		// Try to update PHP memory limit (so that it does not run out of it).
		$memory = 'ini'.'_'.'set'; $memory( 'memory_limit', apply_filters( 'pt-ocdi/import_memory_limit', '350M' ) ); //##### add @ later


		// TieLabs ===
		if( empty( $this->start_time ) ) {
			$this->start_time = microtime(true);
		}


		// Verify if the AJAX call is valid (checks nonce and current_user_can).
		OCDI_Helpers::verify_ajax_call();

		// Is this a new AJAX call to continue the previous import?
		$use_existing_importer_data = $this->get_importer_data();

		if ( ! $use_existing_importer_data ){

			// Set the AJAX call number.
			$this->ajax_call_number = empty( $this->ajax_call_number ) ? 0 : $this->ajax_call_number;

			// Error messages displayed on front page.
			$this->frontend_error_messages = '';

			// Create a date and time string to use for demo and log file names.
			$demo_import_start_time = date( apply_filters( 'pt-ocdi/date_format_for_file_names', 'Y-m-d__H-i-s' ) );

			// Define log file path.
			$this->log_file_path = OCDI_Helpers::get_log_path( $demo_import_start_time );

			// Get selected file index or set it to 0.
			$this->selected_index = empty( $_POST['selected'] ) ? 0 : absint( $_POST['selected'] );

			/**
			 * 1. Prepare import files.
			 * Manually uploaded import files or predefined import files via filter: pt-ocdi/import_files
			 */
			if ( ! empty( $_FILES ) ){ // Using manual file uploads?

				// Get paths for the uploaded files.
				$this->selected_import_files = OCDI_Helpers::process_uploaded_files( $_FILES, $this->log_file_path );

				// Set the name of the import files, because we used the uploaded files.
				$this->import_files[ $this->selected_index ]['import_file_name'] = esc_html__( 'Manually uploaded files', TIELABS_TEXTDOMAIN );
			}
			elseif ( ! empty( $this->import_files[ $this->selected_index ] ) ){ // Use predefined import files from wp filter: pt-ocdi/import_files.

				// Download the import files (content and widgets files) and save it to variable for later use.
				$this->selected_import_files = OCDI_Helpers::download_import_files(
					$this->import_files[ $this->selected_index ],
					$demo_import_start_time
				);


				// Check Errors.
				if ( is_wp_error( $this->selected_import_files ) ){

					// Write error to log file and send an AJAX response with the error.
					OCDI_Helpers::log_error_and_send_ajax_response(
						$this->selected_import_files->get_error_message(),
						$this->log_file_path,
						esc_html__( 'Downloaded files', TIELABS_TEXTDOMAIN )
					);
				}

				// Add this message to log file.
				$log_added = OCDI_Helpers::append_to_file(
					sprintf(
						'The import files for: %s were successfully downloaded!',
						$this->import_files[ $this->selected_index ]['import_file_name']
					) . OCDI_Helpers::import_file_info( $this->selected_import_files ),
					$this->log_file_path,
					esc_html__( 'Downloaded files', TIELABS_TEXTDOMAIN )
				);

				// Store the installed Demo // TieLabs
				if( ! empty( $this->import_files[ $this->selected_index ]['import_file_name'] ) ) {
					update_option( 'tie_installed_demo_'. TIELABS_THEME_ID, $this->import_files[ $this->selected_index ]['import_file_name'], false );
				}
			}
			else {

				// Send JSON Error response to the AJAX call.
				wp_send_json( esc_html__( 'No import files specified!', TIELABS_TEXTDOMAIN ) );
			}
		}

		/**
		 * 2. Import content.
		 * Returns any errors greater then the "error" logger level, that will be displayed on front page.
		 */

		$log_added = OCDI_Helpers::append_to_file( 'Begin to import the media files from the XML', $this->log_file_path, 'Debugging' );

		$this->frontend_error_messages .= $this->import_content( $this->selected_import_files['content'] );

		$log_added = OCDI_Helpers::append_to_file( 'After importing the media files from the XML', $this->log_file_path, 'Debugging' );

		/**
		 * 2.2 Import WooCommerce.
		 * WooCommerce Data Import by TieLabs
		 */
		if( ! empty( $this->selected_import_files['woocommerce'] ) ) {

			$log_added = OCDI_Helpers::append_to_file( 'Begin to import the media files from the WooCommerce XML', $this->log_file_path, 'Debugging' );

			$this->frontend_error_messages .= $this->import_content( $this->selected_import_files['woocommerce'] );

			$log_added = OCDI_Helpers::append_to_file( 'After importing the media files from the WooCommerce XML', $this->log_file_path, 'Debugging' );
		}

		/**
		 * 3. Before widgets import setup.
		 */
		$action = 'pt-ocdi/before_widgets_import';
		if ( ( false !== has_action( $action ) ) && empty( $this->frontend_error_messages ) ){

			// Run the before_widgets_import action to setup other settings.
			$this->do_import_action( $action, $this->import_files[ $this->selected_index ] );
		}

		/**
		 * 4. Import widgets.
		 */
		if ( ! empty( $this->selected_import_files['widgets'] ) && empty( $this->frontend_error_messages ) ){
			$this->import_widgets( $this->selected_import_files['widgets'] );
		}

		/**
		 * 5. Import customize options.
		 */
		if ( ! empty( $this->selected_import_files['customizer'] ) && empty( $this->frontend_error_messages ) ){
			$this->import_customizer( $this->selected_import_files['customizer'] );
		}


	//TieLabs *************
		/**
		 * 5. Import Theme Settings.
		 */
		if ( ! empty( $this->selected_import_files['settings'] ) && empty( $this->frontend_error_messages ) ){

			do_action( 'TieLabs/demo_import_settings', $this->selected_import_files['settings'] );

		}


		$end_time  = microtime(true);
		$completed = ($end_time - $this->start_time);

		// Add this message to log file.
		$log_added = OCDI_Helpers::append_to_file(
			sprintf(
				'The Demo has been imported in % seconds.',
				$completed
			),
			$this->log_file_path,
			esc_html__( 'Completed', TIELABS_TEXTDOMAIN )
		);
	//END *************


		/**
		 * 6. After import setup.
		 */
		$action = 'pt-ocdi/pport';
		if ( ( false !== has_action( $action ) ) && empty( $this->frontend_error_messages ) ){

			// Run the after_import action to setup other settings.
			$this->do_import_action( $action, $this->import_files[ $this->selected_index ] );
		}

		// Display final messages (success or error messages).
		if ( empty( $this->frontend_error_messages ) ){

			$response['message'] = '<h3 class="is-done">' .__( 'That\'s it, all done!', TIELABS_TEXTDOMAIN ). '</h3>'.
				'<h4>'.
					sprintf(
						__( 'The demo import has finished. Now you can see the result at %1$syour site%2$s or start customize via %3$sTheme Options%2$s.', TIELABS_TEXTDOMAIN ),
						'<a href="'. esc_url(home_url( '/' )) .'" target="_blank">',
						'</a>',
						'<a href="'. admin_url( 'admin.php?page=tie-theme-options' ) .'">'
					).
				'</h4>
			';

			/*
			$response['message'] = sprintf(
				__( '%1$s%3$sThat\'s it, all done!%4$s%2$sThe demo import has finished. Please check your page and make sure that everything has imported correctly. If it did, you can deactivate the %3$sOne Click Demo Import%4$s plugin, because it has done its job.%5$s', TIELABS_TEXTDOMAIN ),
				'<div class="notice  notice-success"><p>',
				'<br>',
				'<strong>',
				'</strong>',
				'</p></div>'
			);
			*/

		}
		else {
			$response['message'] = $this->frontend_error_messages . '<br>';
			$response['message'] .= sprintf(
				__( '%1$sThe demo import has finished, but there were some import errors.%2$sMore details about the errors can be found in this %3$s%5$slog file%6$s%4$s%7$s', TIELABS_TEXTDOMAIN ),
				'<div class="tie-message-hint tie-message-error"><p>',
				'<br>',
				'<strong>',
				'</strong>',
				'<a href="' . OCDI_Helpers::get_log_url( $this->log_file_path ) .'" target="_blank">',
				'</a>',
				'</p></div>'
			);
		}

		wp_send_json( $response );
	}


	/**
	 * Import content from an WP XML file.
	 *
	 * @param string $import_file_path path to the import file.
	 */
	private function import_content( $import_file_path ){

		$this->microtime = microtime( true );

		// This should be replaced with multiple AJAX calls (import in smaller chunks)
		// so that it would not come to the Internal Error, because of the PHP script timeout.
		// Also this function has no effect when PHP is running in safe mode
		// http://php.net/manual/en/function.set-time-limit.php.
		// Increase PHP max execution time.
		@set_time_limit( apply_filters( 'pt-ocdi/set_time_limit_for_demo_data_import', 300 ) );

		// Disable import of authors.
		add_filter( 'wxr_importer.pre_process.user', '__return_false' );

		// Check, if we need to send another AJAX request.
		add_filter( 'wxr_importer.pre_process.post', array( $this, 'new_ajax_request_maybe' ) );

		// Disables generation of multiple image sizes (thumbnails) in the content import step.
		if ( ! apply_filters( 'pt-ocdi/regenerate_thumbnails_in_content_import', true ) ){
			add_filter( 'intermediate_image_sizes_advanced',
				function(){
					return null;
				}
			);
		}

		// Import content.
		if ( ! empty( $import_file_path ) ){
			ob_start();
				$this->importer->import( $import_file_path );

			$message = ob_get_clean();

			// Add this message to log file. // TieLabs
			$log_added = OCDI_Helpers::append_to_file(
				$message . PHP_EOL . 'MAX EXECUTION TIME = ' . ini_get( 'max_execution_time' ) . PHP_EOL . 'MEMORY LIMIT = ' . ini_get( 'memory_limit' ),
				$this->log_file_path,
				esc_html__( 'Importing content', TIELABS_TEXTDOMAIN )
			);
		}

		// Delete content importer data for current import from DB.
		delete_transient( 'ocdi_importer_data' );

		// Return any error messages for the front page output (errors, critical, alert and emergency level messages only).
		return $this->logger->error_output;
	}


	/**
	 * Import widgets from WIE or JSON file.
	 *
	 * @param string $widget_import_file_path path to the widget import file.
	 */
	private function import_widgets( $widget_import_file_path ){

		// Widget import results.
		$results = array();

		// Create an instance of the Widget Importer.
		$widget_importer = new OCDI_Widget_Importer();

		// Import widgets.
		if ( ! empty( $widget_import_file_path ) ){

			// Import widgets and return result.
			$results = $widget_importer->import_widgets( $widget_import_file_path );
		}

		// Check for errors.
		if ( is_wp_error( $results ) ){

			// Write error to log file and send an AJAX response with the error.
			OCDI_Helpers::log_error_and_send_ajax_response(
				$results->get_error_message(),
				$this->log_file_path,
				esc_html__( 'Importing widgets', TIELABS_TEXTDOMAIN )
			);
		}

		ob_start();
			$widget_importer->format_results_for_log( $results );
		$message = ob_get_clean();

		// Add this message to log file.
		$log_added = OCDI_Helpers::append_to_file(
			$message,
			$this->log_file_path,
			esc_html__( 'Importing widgets', TIELABS_TEXTDOMAIN )
		);
	}


	/**
	 * Import customizer from a DAT file, generated by the Customizer Export/Import plugin.
	 *
	 * @param string $customizer_import_file_path path to the customizer import file.
	 */
	private function import_customizer( $customizer_import_file_path ){

		// Try to import the customizer settings.
		$results = OCDI_Customizer_Importer::import_customizer_options( $customizer_import_file_path );

		// Check for errors.
		if ( is_wp_error( $results ) ){

			// Write error to log file and send an AJAX response with the error.
			OCDI_Helpers::log_error_and_send_ajax_response(
				$results->get_error_message(),
				$this->log_file_path,
				esc_html__( 'Importing customizer settings', TIELABS_TEXTDOMAIN )
			);
		}

		// Add this message to log file.
		$log_added = OCDI_Helpers::append_to_file(
			'Customizer settings import finished!',
			$this->log_file_path,
			esc_html__( 'Importing customizer settings', TIELABS_TEXTDOMAIN )
		);
	}


	/**
	 * Setup other things in the passed wp action.
	 *
	 * @param string $action the action name to be executed.
	 * @param array  $selected_import with information about the selected import.
	 */
	private function do_import_action( $action, $selected_import ){

		ob_start();
			do_action( $action, $selected_import );
		$message = ob_get_clean();

		// Add this message to log file.
		$log_added = OCDI_Helpers::append_to_file(
			$message,
			$this->log_file_path,
			$action
		);
	}


	/**
	 * Check if we need to create a new AJAX request, so that server does not timeout.
	 *
	 * @param array $data current post data.
	 * @return array
	 */
	public function new_ajax_request_maybe( $data ){
		$time = microtime( true ) - $this->microtime;


		// We should make a new ajax call, if the time is right.
		if ( $time > apply_filters( 'pt-ocdi/time_for_one_ajax_call', 10 ) ){
			$this->ajax_call_number++;
			$this->set_importer_data();

			$response = array(
				'status'  => 'newAJAX',
				'message' => 'Time for new AJAX request!: ' . $time,
			);

			// Add any output to the log file and clear the buffers.
			$message = ob_get_clean();

			// Add message to log file.
			$log_added = OCDI_Helpers::append_to_file(
				'Completed AJAX call number: ' . $this->ajax_call_number . PHP_EOL . $message,
				$this->log_file_path,
				''
			);

			wp_send_json( $response );
		}

		return $data;
	}

	/**
	 * Set current state of the content importer, so we can continue the import with new AJAX request.
	 */
	private function set_importer_data(){
		$data = array(
			'frontend_error_messages' => $this->frontend_error_messages,
			'ajax_call_number'        => $this->ajax_call_number,
			'log_file_path'           => $this->log_file_path,
			'selected_index'          => $this->selected_index,
			'selected_import_files'   => $this->selected_import_files,
		);

		$data = array_merge( $data, $this->importer->get_importer_data() );

		set_transient( 'ocdi_importer_data', $data, 0.5 * HOUR_IN_SECONDS );
	}

	/**
	 * Get content importer data, so we can continue the import with this new AJAX request.
	 */
	private function get_importer_data(){
		if ( $data = get_transient( 'ocdi_importer_data' ) ){
			$this->frontend_error_messages                = empty( $data['frontend_error_messages'] ) ? '' : $data['frontend_error_messages'];
			$this->ajax_call_number                       = empty( $data['ajax_call_number'] ) ? 1 : $data['ajax_call_number'];
			$this->log_file_path                          = empty( $data['log_file_path'] ) ? '' : $data['log_file_path'];
			$this->selected_index                         = empty( $data['selected_index'] ) ? 0 : $data['selected_index'];
			$this->selected_import_files                  = empty( $data['selected_import_files'] ) ? array() : $data['selected_import_files'];
			$this->importer->set_importer_data( $data );

			return true;
		}
		return false;
	}

	/**
	 * Get data from filters, after the theme has loaded and instantiate the importer.
	 */
	public function setup_plugin_with_filter_data(){

		if( ! is_admin() ){
			return;
		}

		// Check the current user role
		if( ! function_exists( 'current_user_can' ) || function_exists( 'current_user_can' ) && ! current_user_can( 'manage_options' ) ){
			return;
		}

		// Get info of import data files and filter it.
		$this->import_files = OCDI_Helpers::validate_import_file_info( apply_filters( 'pt-ocdi/import_files', array() ) );

		// Importer options array.
		$importer_options = apply_filters( 'pt-ocdi/importer_options', array(
			'fetch_attachments' => true,
		) );

		// Logger options for the logger used in the importer.
		$logger_options = apply_filters( 'pt-ocdi/logger_options', array(
			'logger_min_level' => 'warning',
		) );

		// Configure logger instance and set it to the importer.
		$this->logger            = new OCDI_Logger();
		$this->logger->min_level = $logger_options['logger_min_level'];

		// Create importer instance with proper parameters.
		$this->importer = new OCDI_Importer( $importer_options, $this->logger );
	}
}

$pt_one_click_demo_import = PT_One_Click_Demo_Import::getInstance();
