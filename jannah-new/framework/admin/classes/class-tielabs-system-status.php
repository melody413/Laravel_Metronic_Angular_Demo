<?php
/**
 * System Status
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! class_exists( 'TIELABS_SYSTEM_STATUS' ) ) {

	class TIELABS_SYSTEM_STATUS{

		public $menu_slug = 'tie-system-status';


		/**
		 * __construct
		 *
		 * Class constructor
		 */
		function __construct(){

			//add_action( 'tie_admin_notices',      array( $this, 'outdated_templates_notice' ) );
			add_filter( 'TieLabs/panel_submenus', array( $this, '_add_options_menu' ), 99 );
			add_filter( 'TieLabs/about_tabs',     array( $this, '_add_about_tabs' ),   20 );
		}


		/**
		 * _output
		 *
		 * Dispaly the data
		 */
		function _output(){
			$this->_start_page();
			$this->_print_theme_info();
			$this->_print_environment_info();
			$this->_print_plugins_info();
			$this->_template_file_check( true, false );
			$this->_print_report();
			$this->_end_page();
		}


		/**
		 * _add_options_menu
		 *
		 * Add the system status page to the theme menu
		 */
		function _add_options_menu( $menus ){

			$menus[] = array(
				'page_title' => esc_html__( 'System Status', TIELABS_TEXTDOMAIN ),
				'menu_title' => esc_html__( 'System Status', TIELABS_TEXTDOMAIN ),
				'menu_slug'  => $this->menu_slug,
				'function'   => array( $this, '_output' ),
			);

			return $menus;
		}


		/**
		 * _add_bout_tabs
		 *
		 * Add the System Status Page to the about page's tabs
		 */
		function _add_about_tabs( $tabs ){

			$tabs['system-status'] = array(
				'text' => esc_html__( 'System Status', TIELABS_TEXTDOMAIN ),
				'url'  => menu_page_url( $this->menu_slug, false ),
			);

			return $tabs;
		}


		/**
		 * _curl_version
		 *
		 * Figure out cURL version, if installed
		 */
		private function _curl_version(){

			$curl_version = '';
			if ( function_exists( 'curl_version' ) ) {
				$curl_version = curl_version();
				$curl_version = $curl_version['version'] . ', ' . $curl_version['ssl_version'];
			}

			return $curl_version;
		}


		/**
		 * _memory_limit
		 *
		 * Get the wp memory limit
		 */
		private function _memory_limit(){

			$wp_memory_limit = $this->_let_to_num( WP_MEMORY_LIMIT );
			if ( function_exists( 'memory_get_usage' ) ) {
				$wp_memory_limit = max( $wp_memory_limit, $this->_let_to_num( @ini_get( 'memory_limit' ) ) );
			}

			return $wp_memory_limit;
		}


		/**
		 * _post_request
		 *
		 * Test POST requests
		 */
		private function _post_request(){

			$post_response = wp_safe_remote_post( 'https://www.paypal.com/cgi-bin/webscr', array(
				'timeout'     => 60,
				'user-agent'  => 'woocommerce/',
				'httpversion' => '1.1',
				'body'        => array(
					'cmd'    => '_notify-validate',
				),
			));

			$post_response_successful = false;
			if ( ! is_wp_error( $post_response ) && $post_response['response']['code'] >= 200 && $post_response['response']['code'] < 300 ) {
				$post_response_successful = true;
			}

			return $post_response_successful;
		}


		/**
		 * _get_request
		 *
		 * Test GET requests
		 */
		private function _get_request(){

			$get_response = wp_safe_remote_get( 'https://woocommerce.com/wc-api/product-key-api?request=ping&network=' . ( is_multisite() ? '1' : '0' ) );

			$get_response_successful = false;
			if ( ! is_wp_error( $get_response ) && $get_response['response']['code'] >= 200 && $get_response['response']['code'] < 300 ) {
				$get_response_successful = true;
			}

			return $get_response_successful;
		}


		/**
		 * _environment_info
		 *
		 * All environment info
		 */
		private function _environment_info(){
			global $wpdb;

			$get_response_msg  = '';

			// Remote Post
			$post_response     = $this->_post_request();
			$post_response_msg = '';

			if( is_wp_error( $post_response ) ){
				$post_response_msg = $post_response->get_error_message();
			}
			elseif( ! empty( $post_response['response']['code'] ) ) {
				$post_response_msg = $post_response['response']['code'];
			}

			// Remote Get
			$get_response     = $this->_get_request();
			$get_response_msg = '';

			if( is_wp_error( $get_response ) ){
				$get_response_msg = $get_response->get_error_message();
			}
			elseif( ! empty( $get_response['response']['code'] ) ) {
				$get_response_msg = $get_response['response']['code'];
			}


			return array(
				'home_url'                  => home_url( '/' ),
				'site_url'                  => site_url( '/' ),
				'wp_version'                => get_bloginfo( 'version' ),
				'wp_multisite'              => is_multisite(),
				'wp_memory_limit'           => $this->_memory_limit(),
				'wp_debug_mode'             => ( defined( 'WP_DEBUG' ) && WP_DEBUG ),
				'language'                  => get_locale(),
				'server_info'               => $_SERVER['SERVER_SOFTWARE'],
				'php_version'               => phpversion(),
				'php_post_max_size'         => $this->_let_to_num( ini_get( 'post_max_size' ) ),
				'php_max_execution_time'    => ini_get( 'max_execution_time' ),
				'php_max_input_vars'        => ini_get( 'max_input_vars' ),
				'curl_version'              => $this->_curl_version(),
				'suhosin_installed'         => extension_loaded( 'suhosin' ),
				'max_upload_size'           => wp_max_upload_size(),
				'mysql_version'             => ( ! empty( $wpdb->is_mysql ) ? $wpdb->db_version() : '' ),
				'fsockopen_or_curl_enabled' => ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ),
				'mbstring_enabled'          => extension_loaded( 'mbstring' ),
				'xmlreader_enabled'         => extension_loaded( 'xmlreader' ),
				'remote_post_successful'    => $post_response,
				'remote_post_response'      => $post_response_msg,
				'remote_get_successful'     => $get_response,
				'remote_get_response'       => $get_response_msg,
				'secure_connection'         => 'https' === substr( get_home_url(), 0, 5 ),
				'hide_errors'               => ! ( defined( 'WP_DEBUG' ) && defined( 'WP_DEBUG_DISPLAY' ) && WP_DEBUG && WP_DEBUG_DISPLAY ) || 0 === intval( ini_get( 'display_errors' ) ),
			);

		}


		/**
		 * _theme_info
		 *
		 * Get the theme info
		 */
		private function _theme_info(){

			$active_theme = wp_get_theme();

			if ( is_child_theme() ) {
				$parent_theme = wp_get_theme( $active_theme->Template );
				$parent_theme_info = array(
					'parent_name'           => $parent_theme->Name,
					'parent_version'        => $parent_theme->Version,
					'parent_author_url'     => $parent_theme->{'Author URI'},
				);
			}
			else {
				$parent_theme_info = array( 'parent_name' => '', 'parent_version' => '', 'parent_author_url' => '' );
			}

			$active_theme_info = array(
				'name'                    => $active_theme->Name,
				'version'                 => $active_theme->Version,
				'version_latest'          => tie_get_latest_theme_data( 'version' ),
				'author_url'              => esc_url_raw( $active_theme->{'Author URI'} ),
				'is_child_theme'          => is_child_theme(),
			);

			return array_merge( $active_theme_info, $parent_theme_info );
		}


		/**
		 * _get_active_plugins
		 *
		 * Get all active plugins info
		 */
		private function _get_active_plugins() {

			// This Plugin causes an Fatal error
			if ( class_exists( 'Envira_Gallery' ) ) return;

			include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

			// Get both site plugins and network plugins
			$active_plugins = (array) get_option( 'active_plugins', array() );

			if ( is_multisite() ) {
				$network_activated_plugins = array_keys( get_site_option( 'active_sitewide_plugins', array() ) );
				$active_plugins            = array_merge( $active_plugins, $network_activated_plugins );
			}

			$active_plugins_data = array();

			foreach ( $active_plugins as $plugin ) {
				$data           = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
				$dirname        = dirname( $plugin );
				$version_latest = '';
				$slug           = explode( '/', $plugin );
				$slug           = explode( '.', end( $slug ) );
				$slug           = $slug[0];


				$api = plugins_api( 'plugin_information', array(
					'slug'     => $slug,
					'fields'   => array(
						'sections' => false,
						'tags'     => false,
					),
				) );

				if ( is_object( $api ) && ! is_wp_error( $api ) && ! empty( $api->version ) ) {
					$version_latest = $api->version;
				}

				// convert plugin data to json response format.
				$active_plugins_data[] = array(
					'plugin'            => $plugin,
					'name'              => wp_strip_all_tags( $data['Name'] ),
					'version'           => wp_strip_all_tags( $data['Version'] ),
					'version_latest'    => $version_latest,
					'url'               => wp_strip_all_tags( $data['PluginURI'] ),
					'author_name'       => wp_strip_all_tags( str_replace( ',', ' | ', $data['AuthorName'] ), true ),
					'author_url'        => esc_url_raw( $data['AuthorURI'] ),
					'network_activated' => $data['Network'],
				);
			}

			return $active_plugins_data;
		}


		/**
		 * _let_to_num
		 *
		 * Transform the php.ini notation for numbers (like '2M') to an integer.
		 */
		function _let_to_num( $size ) {
			$l   = substr( $size, -1 );
			$ret = substr( $size, 0, -1 );
			switch ( strtoupper( $l ) ) {
				case 'P':
					$ret *= 1024;
				case 'T':
					$ret *= 1024;
				case 'G':
					$ret *= 1024;
				case 'M':
					$ret *= 1024;
				case 'K':
					$ret *= 1024;
			}
			return $ret;
		}


		/**
		 * _print_environment_info
		 */
		private function _print_environment_info(){
			global $wpdb;
			$environment = $this->_environment_info(); ?>

			<table class="tie-status-table status-report widefat" cellspacing="0">
				<thead>
					<tr>
						<th colspan="2" data-export-label="WordPress Environment"><?php esc_html_e( 'WordPress environment', TIELABS_TEXTDOMAIN ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td data-export-label="Home URL"><?php esc_html_e( 'Home URL', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php echo esc_html( $environment['home_url'] ) ?></td>
					</tr>
					<tr>
						<td data-export-label="Site URL"><?php esc_html_e( 'Site URL', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php echo esc_html( $environment['site_url'] ) ?></td>
					</tr>
					<tr>
						<td data-export-label="WP Version"><?php esc_html_e( 'WP version', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php echo esc_html( $environment['wp_version'] ) ?></td>
					</tr>
					<tr>
						<td data-export-label="WP Multisite"><?php esc_html_e( 'WP multisite', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php echo ( $environment['wp_multisite'] ) ? '<span class="dashicons dashicons-yes"></span>' : '&ndash;'; ?></td>
					</tr>
					<tr>
						<td data-export-label="WP Memory Limit"><?php esc_html_e( 'WP memory limit', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php
							if ( $environment['wp_memory_limit'] < 134217728 ) {
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend setting memory to at least %2$s. To import the demo data %3$s of memory limit is required. See: %4$s', TIELABS_TEXTDOMAIN ), size_format( $environment['wp_memory_limit'] ), '128MB', '256MB', '<a href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . esc_html__( 'Increasing memory allocated to PHP', TIELABS_TEXTDOMAIN ) . '</a>' ) . '</mark>';
							} else {
								echo '<mark class="yes">' . size_format( $environment['wp_memory_limit'] ) . '</mark>';
							}
						?></td>
					</tr>
					<tr>
						<td data-export-label="WP Debug Mode"><?php esc_html_e( 'WP debug mode', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td>
							<?php if ( $environment['wp_debug_mode'] ) : ?>
								<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
							<?php else : ?>
								<mark class="no">&ndash;</mark>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td data-export-label="Language"><?php esc_html_e( 'Language', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php echo esc_html( $environment['language'] ) ?></td>
					</tr>

					<?php /*
						<tr>
							<td data-export-label="Secure connection (HTTPS)"><?php esc_html_e( 'Secure connection (HTTPS)', TIELABS_TEXTDOMAIN ); ?>:</td>
							<td>
								<?php if ( $environment['secure_connection'] ) : ?>
									<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
								<?php else : ?>
									<mark class="error"><span class="dashicons dashicons-warning"></span><?php printf( __( 'Your site is not using HTTPS. <a href="%s" target="_blank">Learn more about HTTPS and SSL Certificates</a>.', TIELABS_TEXTDOMAIN ), 'https://docs.tielabs.com/document/ssl-and-https/' ); ?></mark>
								<?php endif; ?>
							</td>
						</tr>
						*/
					?>


					<tr>
						<td data-export-label="Hide errors from visitors"><?php esc_html_e( 'Hide errors from visitors', TIELABS_TEXTDOMAIN ); ?></td>
						<td>
							<?php if ( $environment['hide_errors'] ) : ?>
								<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
							<?php else : ?>
								<mark class="error"><span class="dashicons dashicons-warning"></span> <?php esc_html_e( 'Error messages can contain sensitive information about your website environment. These should be hidden from untrusted visitors.', TIELABS_TEXTDOMAIN ); ?></mark>
							<?php endif; ?>
						</td>
					</tr>

				</tbody>
			</table>

			<table class="tie-status-table status-report widefat" cellspacing="0">
				<thead>
					<tr>
						<th colspan="2" data-export-label="Server Environment"><?php esc_html_e( 'Server environment', TIELABS_TEXTDOMAIN ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td data-export-label="Server Info"><?php esc_html_e( 'Server info', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php echo esc_html( $environment['server_info'] ); ?></td>
					</tr>
					<tr>
						<td data-export-label="PHP Version"><?php esc_html_e( 'PHP version', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php
							$php_version_requirements = 5.3;

							if ( version_compare( $environment['php_version'], $php_version_requirements, '<' ) ) {
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend a minimum PHP version of %2$s.', TIELABS_TEXTDOMAIN ), esc_html( $environment['php_version'] ), $php_version_requirements ) . '</mark>';
							} else {
								echo '<mark class="yes">' . esc_html( $environment['php_version'] ) . '</mark>';
							}
							?>
						</td>
					</tr>
					<?php if ( function_exists( 'ini_get' ) ) : ?>
						<tr>
							<td data-export-label="PHP Post Max Size"><?php esc_html_e( 'PHP post max size', TIELABS_TEXTDOMAIN ); ?>:</td>
							<td><?php echo esc_html( size_format( $environment['php_post_max_size'] ) ) ?></td>
						</tr>
						<tr>
							<td data-export-label="PHP Execution Time Limit"><?php esc_html_e( 'PHP time limit', TIELABS_TEXTDOMAIN ); ?>:</td>
							<td>
								<?php

									if ( 120 > $environment['php_max_execution_time'] && 0 != $environment['php_max_execution_time'] ) {
										echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend setting max execution time to at least %2$s.', TIELABS_TEXTDOMAIN ), $environment['php_max_execution_time'], 120 ) . '</mark>';
									}
									else{
										echo esc_html( $environment['php_max_execution_time'] );
									}
								?>
							</td>
						</tr>
						<tr>
							<td data-export-label="PHP Max Input Vars"><?php esc_html_e( 'PHP max input vars', TIELABS_TEXTDOMAIN ); ?>:</td>
							<td>
								<?php
									if( $environment['php_max_input_vars'] < 3000 ){
										echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - Recommended Value: %2$s. Max input vars limitation will truncate POST data such as menus. See: %3$sIncreasing max input vars limit.%4$s', TIELABS_TEXTDOMAIN ), $environment['php_max_input_vars'], '3000', '<a href="'. apply_filters( 'TieLabs/External/max_input_vars', '' ) .'" target="_blank" rel="noopener noreferrer">', '</a>' ) . '</mark>';
									}
									else{
										echo '<mark class="yes">' . esc_html( $environment['php_max_input_vars'] ) . '</mark>';
									}
								?>
							</td>
						</tr>
						<tr>
							<td data-export-label="cURL Version"><?php esc_html_e( 'cURL version', TIELABS_TEXTDOMAIN ); ?>:</td>
							<td><?php echo esc_html( $environment['curl_version'] ) ?></td>
						</tr>
						<tr>
							<td data-export-label="SUHOSIN Installed"><?php esc_html_e( 'SUHOSIN installed', TIELABS_TEXTDOMAIN ); ?>:</td>
							<td><?php echo ( $environment['suhosin_installed'] ) ? '<span class="dashicons dashicons-yes"></span> '. esc_html__( 'You have to increase the suhosin.post.max_vars and suhosin.request.max_vars parameters to 2000 or more.', TIELABS_TEXTDOMAIN ) : '&ndash;'; ?></td>
						</tr>
					<?php endif;

					if ( $wpdb->use_mysqli ) {
						$ver = mysqli_get_server_info( $wpdb->dbh );
					} else {
						$ver = 0;
					}
					if ( ! empty( $wpdb->is_mysql ) && ! stristr( $ver, 'MariaDB' ) ) : ?>
						<tr>
							<td data-export-label="MySQL Version"><?php esc_html_e( 'MySQL version', TIELABS_TEXTDOMAIN ); ?>:</td>
							<td>
								<?php
								$mysql_version_requirements = 5.0;

								if ( version_compare( $environment['mysql_version'], $mysql_version_requirements, '<' ) ) {
									echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - WordPress recommends a minimum MySQL version of %2$s. See: %3$sWordPress requirements%4$s', TIELABS_TEXTDOMAIN ), esc_html( $environment['mysql_version'] ), $mysql_version_requirements, '<a href="https://wordpress.org/about/requirements/" target="_blank">', '</a>' ) . '</mark>';
								} else {
									echo '<mark class="yes">' . esc_html( $environment['mysql_version'] ) . '</mark>';
								}
								?>
							</td>
						</tr>
					<?php endif; ?>
					<tr>
						<td data-export-label="Max Upload Size"><?php esc_html_e( 'Max upload size', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php echo size_format( $environment['max_upload_size'] ) ?></td>
					</tr>
					<tr>
						<td data-export-label="fsockopen/cURL"><?php esc_html_e( 'fsockopen/cURL', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php
							if ( $environment['fsockopen_or_curl_enabled'] ) {
								echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
							} else {
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html__( 'Your server does not have fsockopen or cURL enabled. Contact your hosting provider.', TIELABS_TEXTDOMAIN ) . '</mark>';
							} ?>
						</td>
					</tr>
					<tr>
						<td data-export-label="Multibyte String"><?php esc_html_e( 'Multibyte string', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php
							if ( $environment['mbstring_enabled'] ) {
								echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
							} else {
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html__( 'Your server does not support the mbstring functions - this is required for better character encoding. Some fallbacks will be used instead for it.', TIELABS_TEXTDOMAIN ) . '</mark>';
							} ?>
						</td>
					</tr>
					<tr>
						<td data-export-label="XMLReader"><?php esc_html_e( 'XMLReader', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php
							if ( $environment['xmlreader_enabled'] ) {
								echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
							} else {
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html__( 'The XMLReader PHP module/extension is missing. Please contact your hosting company and ask them to install that for you.', TIELABS_TEXTDOMAIN ) . '</mark>';
							} ?>
						</td>
					</tr>
					<tr>
						<td data-export-label="Remote Post"><?php esc_html_e( 'Remote post', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php
							if ( $environment['remote_post_successful'] ) {
								echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
							} else {
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html__( 'wp_remote_post() failed. Contact your hosting provider.', TIELABS_TEXTDOMAIN ) . ' ' . esc_html( $environment['remote_post_response'] ) . '</mark>';
							} ?>
						</td>
					</tr>
					<tr>
						<td data-export-label="Remote Get"><?php esc_html_e( 'Remote get', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php
							if ( $environment['remote_get_successful'] ) {
								echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
							} else {
								echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html__( 'wp_remote_get() failed. Contact your hosting provider.', TIELABS_TEXTDOMAIN ) . ' ' . esc_html( $environment['remote_get_response'] ) . '</mark>';
							} ?>
						</td>
					</tr>
				</tbody>
			</table>
			<?php
		}


		/**
		 * _print_theme_info
		 */
		private function _print_theme_info(){
			$theme = $this->_theme_info(); ?>

			<table class="tie-status-table status-report widefat" cellspacing="0">
				<thead>
					<tr>
						<th colspan="2" data-export-label="Theme"><?php esc_html_e( 'Theme', TIELABS_TEXTDOMAIN ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td data-export-label="Name"><?php esc_html_e( 'Name', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php echo esc_html( $theme['name'] ) ?></td>
					</tr>
					<tr>
						<td data-export-label="License"><?php esc_html_e( 'License', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td>
							<?php
								if( tie_get_latest_theme_data( 'version' ) ){
									echo '<strong style="color: #65b70e"><span class="dashicons dashicons-yes"></span> '. esc_html__( 'Your Site is Validated', TIELABS_TEXTDOMAIN ) .'</strong>';
								}
								else{
									echo '<strong style="color: red"><span class="dashicons dashicons-no"></span>'. esc_html__( 'Your Site is not Validated', TIELABS_TEXTDOMAIN ) .'</strong>';
								}
							?>
						</td>
					</tr>

					<?php if( tie_get_latest_theme_data( 'version' ) ): ?>
						<tr>
							<td data-export-label="Support"><?php esc_html_e( 'Support', TIELABS_TEXTDOMAIN ); ?>:</td>
							<td><?php TIELABS_VERIFICATION::support_compact_notice() ?></td>
						</tr>
					<?php endif; ?>

					<tr>
						<td data-export-label="Version"><?php esc_html_e( 'Version', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php
							echo esc_html( $theme['version'] );

							if ( ! $theme['is_child_theme'] && version_compare( $theme['version'], $theme['version_latest'], '<' ) ) {
								echo ' &ndash; <strong style="color:red;">' . sprintf( esc_html__( '%s is available', TIELABS_TEXTDOMAIN ), esc_html( $theme['version_latest'] ) ) . '</strong>';
							}
						?></td>
					</tr>
					<tr>
						<td data-export-label="Author URL"><?php esc_html_e( 'Author URL', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php echo esc_html( $theme['author_url'] ) ?></td>
					</tr>
					<tr>
						<td data-export-label="Child Theme"><?php esc_html_e( 'Child theme', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php
							echo ( $theme['is_child_theme'] ) ? '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>' : '&ndash;';
						?></td>
					</tr>
					<?php
					if ( $theme['is_child_theme'] ) :
					?>
					<tr>
						<td data-export-label="Parent Theme Name"><?php esc_html_e( 'Parent theme name', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php echo esc_html( $theme['parent_name'] ); ?></td>
					</tr>
					<tr>
						<td data-export-label="Parent Theme Version"><?php esc_html_e( 'Parent theme version', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php
							echo esc_html( $theme['parent_version'] );

							if ( version_compare( $theme['parent_version'], $theme['version_latest'], '<' ) ) {
								echo ' &ndash; <strong style="color:red;">' . sprintf( esc_html__( '%s is available', TIELABS_TEXTDOMAIN ), esc_html( $theme['version_latest'] ) ) . '</strong>';
							}
						?></td>
					</tr>
					<tr>
						<td data-export-label="Parent Theme Author URL"><?php esc_html_e( 'Parent theme author URL', TIELABS_TEXTDOMAIN ); ?>:</td>
						<td><?php echo esc_html( $theme['parent_author_url'] ) ?></td>
					</tr>
					<?php endif ?>

					<?php if( $demo = get_option( 'tie_installed_demo_'. TIELABS_THEME_ID ) ): ?>
						<tr>
							<td data-export-label="Demo Installed"><?php esc_html_e( 'Latest Demo Installed', TIELABS_TEXTDOMAIN ); ?>:</td>
							<td><?php echo $demo; ?></td>
						</tr>
					<?php endif ?>

					<?php if( $switcher = get_option( 'tie_switch_to_'. TIELABS_THEME_ID ) ):
										$switcher = explode( '.', $switcher );
										if( is_array( $switcher ) && ! empty( $switcher[0] ) ){ ?>
						<tr>
							<td data-export-label="Switched From"><?php esc_html_e( 'Switched From', TIELABS_TEXTDOMAIN ); ?>:</td>
							<td><?php echo $switcher[0]; ?></td>
						</tr>
							<?php
							}
					endif ?>

				</tbody>
			</table>

			<?php
		}


		/**
		 * _print_plugins_info
		 */
		private function _print_plugins_info(){

			$active_plugins = $this->_get_active_plugins();

			if( empty( $active_plugins ) ){
				return;
			}

			?>

			<table class="tie-status-table status-report widefat" cellspacing="0">
				<thead>
					<tr>
						<th colspan="2" data-export-label="Active Plugins (<?php echo count( $active_plugins ) ?>)"><?php esc_html_e( 'Active plugins', TIELABS_TEXTDOMAIN ); ?> (<?php echo count( $active_plugins ) ?>)</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $active_plugins as $plugin ) {
						if ( ! empty( $plugin['name'] ) ) {

							$plugin_name = esc_html( $plugin['name'] );

							// Link the plugin name to the plugin url if available.
							if ( ! empty( $plugin['url'] ) ) {
								$plugin_name = '<a href="' . esc_url( $plugin['url'] ) . '" target="_blank">' . $plugin_name . '</a>';
							}

							$version_string = '';
							$network_string = '';

							if ( ! empty( $plugin['version_latest'] ) && version_compare( $plugin['version_latest'], $plugin['version'], '>' ) ) {
								$version_string = ' &ndash; <strong style="color:red;">' . sprintf( esc_html__( '%s is available', TIELABS_TEXTDOMAIN ), $plugin['version_latest'] ) . '</strong>';
							}

							if ( false != $plugin['network_activated'] ) {
								$network_string = ' &ndash; <strong style="color:black;">' . esc_html__( 'Network enabled', TIELABS_TEXTDOMAIN ) . '</strong>';
							}

							?>
							<tr>
								<td><?php echo ( $plugin_name ); ?></td>
								<td><?php
									printf( esc_html__( 'by %s', TIELABS_TEXTDOMAIN ), $plugin['author_name'] );
									echo ' &ndash; ' . esc_html( $plugin['version'] ) . $version_string . $network_string;
								?></td>
							</tr>
							<?php
						}
					}
					?>
				</tbody>
			</table>

			<?php
		}


		/**
		 * _print_report
		 */
		private function _print_report(){ ?>

			<table class="tie-status-table widefat" cellspacing="0">
				<tbody>
				<tr>
					<td>
						<p><?php esc_html_e( 'Please copy and paste this information in your ticket when contacting support:', TIELABS_TEXTDOMAIN ); ?> </p>
						<a id="get-debug-report" href="#" class="button-primary"><?php esc_html_e( 'Get system report', TIELABS_TEXTDOMAIN ); ?></a>
						<div id="tie-debug-report">
							<textarea readonly="readonly"></textarea>
						</div>
					</td>
				</tr>
				</tbody>
			</table>

			<script type="text/javascript">
				jQuery( '#get-debug-report' ).click(
					function() {
						var report = '';

						jQuery( '.status-report thead, .status-report tbody' ).each(
							function() {
								if ( jQuery( this ).is( 'thead' ) ) {
									var label = jQuery( this ).find( 'th:eq(0)' ).data( 'export-label' ) || jQuery( this ).text();
									report = report + '\n### ' + jQuery.trim( label ) + ' ###\n\n';
								} else {
									jQuery( 'tr', jQuery( this ) ).each( function() {
										var label       = jQuery( this ).find( 'td:eq(0)' ).data( 'export-label' ) || jQuery( this ).find( 'td:eq(0)' ).text();
										var the_name    = jQuery.trim( label ).replace( /(<([^>]+)>)/ig, '' ); // Remove HTML.

										// Find value
										var $value_html = jQuery( this ).find( 'td:eq(1)' ).clone();
										$value_html.find( '.private' ).remove();
										$value_html.find( '.dashicons-yes' ).replaceWith( '&#10004;' );
										$value_html.find( '.dashicons-no-alt, .dashicons-warning' ).replaceWith( '&#10060;' );

										// Format value
										var the_value   = jQuery.trim( $value_html.text() );
										var value_array = the_value.split( ', ' );

										if ( value_array.length > 1 ) {
											// If value have a list of plugins ','.
											// Split to add new line.
											var temp_line ='';
											jQuery.each( value_array, function( key, line ) {
												temp_line = temp_line + line + '\n';
											});

											the_value = temp_line;
										}

										report = report + '' + the_name + ': ' + the_value + '\n';
									});
								}
							}
						);

						try {
							jQuery( this ).hide();
							jQuery( "#tie-debug-report" ).slideDown();
							jQuery( "#tie-debug-report textarea" ).val( report ).focus().select();

							return false;
						} catch ( e ) {
							console.log( e );
						}

						return false;
					}
				);
			</script>
			<?php


			tie_build_theme_option(
				array(
					'text'  => sprintf( esc_html__( 'Looking for a good web hosting company? %1$sCheck our recommendations!%2$s', TIELABS_TEXTDOMAIN ), '<a target="_blank" href="'. apply_filters( 'TieLabs/External/hosting', '' ) .'"><strong>', '</strong></a>' ),
					'type'  => 'message',
				));
		}


		/**
		 * _start_page
		 */
		private function _start_page(){
			echo '<div class="wrap about-wrap tie-about-wrap tie-system-status-wrap">';

			TIELABS_WELCOME_PAGE::_head_section( 'system-status' );
		}


		/**
		 * _end_page
		 */
		private function _end_page(){
			echo '</div>';
		}


		/**
		 * Show a notice highlighting bad template files
		 */
		function outdated_templates_notice(){
			add_action( 'admin_notices', array( $this, '_template_file_check' ), 105 );
		}


		/**
		 * Find the overriden files
		 */
		function _template_file_check( $show_table = false, $show_notice = true ) {

			if ( ! is_child_theme() ) {
				return;
			}

			$original_path = get_template_directory()   . '/templates/';
			$template_path = get_stylesheet_directory() . '/templates/';

			$core_templates = $this->scan_template_files( $original_path );
			$outdated       = false;
			$override_files = array();

			foreach ( $core_templates as $file ) {

				$ext = explode( '.', $file );

				if( end( $ext ) == 'php' ){

					$developer_theme_file = false;

					if ( file_exists( $template_path . $file ) ) {

						$developer_theme_file = $template_path . $file;

						$core_version      = $this->get_template_version( $original_path . $file );
						$developer_version = $this->get_template_version( $developer_theme_file );

						$override_files[] = array(
							'file'         => str_replace( WP_CONTENT_DIR . '/themes/', '', $developer_theme_file ),
							'version'      => $developer_version,
							'core_version' => $core_version,
						);

						if ( $core_version && $developer_version && version_compare( $developer_version, $core_version, '<' ) ) {
							$outdated = true;
						}
					}
				}
			}

			// if there is no any overriden files don't print anything
			if( empty( $override_files ) ){
				return;
			}

			// Display the Error message

			if( $outdated && $show_notice ){
				TIELABS_NOTICES::message( array(
					'title'          => esc_html__( 'ERROR', TIELABS_TEXTDOMAIN ),
					'message'        => esc_html__( 'Your child theme contains outdated copies of some template files. These files may need updating to ensure they are compatible with the current version of the theme.', TIELABS_TEXTDOMAIN ),
					'dismissible'    => false,
					'class'          => 'error',
					'button_text'    => esc_html__( 'View affected templates', TIELABS_TEXTDOMAIN ),
					'button_url'     => esc_url( admin_url( 'admin.php?page=tie-system-status' ) ),
				));
			}


			if( $show_table ){
			?>

				<p class="tie-message-hint tie-message-error" style="font-size: 10pt;">
					<?php esc_html_e( 'Your child theme contains outdated copies of some template files. These files may need updating to ensure they are compatible with the current version of the theme.', TIELABS_TEXTDOMAIN ); ?>
				</p>

				<table class="tie-status-table status-report widefat" cellspacing="0">
					<thead>
						<tr>
							<th colspan="2" data-export-label="Templates"><?php esc_html_e( 'Child Theme Templates', TIELABS_TEXTDOMAIN ); ?></th>
						</tr>
					</thead>
					<tbody>

						<?php if ( ! empty( $override_files ) ) { ?>
							<tr>
								<td data-export-label="Overrides"><?php esc_html_e( 'Overrides', TIELABS_TEXTDOMAIN ); ?></td>
								<td>
									<?php
									$total_overrides = count( $override_files );
									for ( $i = 0; $i < $total_overrides; $i++ ) {
										$override = $override_files[ $i ];
										if ( $override['core_version'] && ( empty( $override['version'] ) || version_compare( $override['version'], $override['core_version'], '<' ) ) ) {
											$current_version = $override['version'] ? $override['version'] : '-';
											printf(
												/* Translators: %1$s: Template name, %2$s: Template version, %3$s: Core version. */
												esc_html__( '%1$s version %2$s is out of date. The core version is %3$s', TIELABS_TEXTDOMAIN ),
												'<code>' . esc_html( $override['file'] ) . '</code>',
												'<strong style="color:red">' . esc_html( $current_version ) . '</strong>',
												esc_html( $override['core_version'] )
											);
										} else {
											echo esc_html( $override['file'] );
										}
										if ( ( count( $override_files ) - 1 ) !== $i ) {
											echo ', ';
										}
										echo '<br />';
									}
									?>
								</td>
							</tr>
						<?php } ?>

					</tbody>
				</table>

				<?php
			} // Show the table
		}


		/**
		 * Scan the template files
		 */
		function scan_template_files( $template_path ) {
			$files  = scandir( $template_path );
			$result = array();
			if ( $files ) {
				foreach ( $files as $key => $value ) {
					if ( ! in_array( $value, array( ".", ".." ) ) ) {
						if ( is_dir( $template_path . DIRECTORY_SEPARATOR . $value ) ) {
							$sub_files = $this->scan_template_files( $template_path . DIRECTORY_SEPARATOR . $value );
							foreach ( $sub_files as $sub_file ) {
								$result[] = $value . DIRECTORY_SEPARATOR . $sub_file;
							}
						} else {
							$result[] = $value;
						}
					}
				}
			}

			return $result;
		}


		/**
		 * Retrieve metadata from a file. Based on WP Core's get_file_data function
		 */
		function get_template_version( $file ) {
			// We don't need to write to the file, so just open for reading.
			$fp = fopen( $file, 'r' );

			// Pull only the first 8kiB of the file in.
			$file_data = fread( $fp, 8192 );

			// PHP will close file handle, but we are good citizens.
			fclose( $fp );

			// Make sure we catch CR-only line endings.
			$file_data = str_replace( "\r", "\n", $file_data );
			$version   = '';

			if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( '@version', '/' ) . '(.*)$/mi', $file_data, $match ) && $match[1] ){
				$version = _cleanup_header_comment( $match[1] );
			}

			return $version ;
		}

	}


	// Instantiate the class
	new TIELABS_SYSTEM_STATUS();
}
