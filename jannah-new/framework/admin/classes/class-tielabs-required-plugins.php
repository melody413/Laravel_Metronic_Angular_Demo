<?php
/**
 * TGM activation plugin
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


/* ---------------------------------------
		Note:
		In this file, we replaced tgm with tie_tgm and TGM with TIE_TGM to Avoid conflict with the standard TGM included with some plugins
   --------------------------------------*/


if( ! class_exists( 'TIELABS_REQUIRED_PLUGINS' ) ) {

	class TIELABS_REQUIRED_PLUGINS{

		public $menu_slug = 'tie-install-plugins';

		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			// Check if the current user role
			if( ! current_user_can( 'install_plugins' ) ){
				return;
			}

			// Include the main tgm activation file
			require TIELABS_TEMPLATE_PATH . '/framework/vendor/tgm/class-tgm-plugin-activation.php';

			add_action( 'tie_tgmpa_register',        array( $this, 'register_plugins' ) ); // check the notice
			add_filter( 'TieLabs/about_tabs',        array( $this, 'add_about_tabs'   ) );
			add_filter( 'get_user_metadata',         array( $this, 'remove_notice'    ), 10, 4 );
			add_filter( 'tie_tgmpa_admin_menu_args', array( $this, 'admin_menu_args'  ) ); // check the notice
		}


		/**
		 * register_plugins
		 *
		 */
		function register_plugins(){

			// To get the installable plugins links
			$update_files = false;

			if ( isset( $_GET['page'] ) && $_GET['page'] == 'tie-install-plugins' ){
				$update_files = true;
			}

			$plugins = false;

			// Get the TieLabs API PLugins
			if( get_option( 'tie_token_'.TIELABS_THEME_ID ) && tie_get_latest_theme_data( 'plugins' ) ){

				$plugins = tie_get_latest_theme_data( 'plugins', false, false, $update_files );

				// Remove the Arqam Lite Plugin if the Arqam Plugin is active
				if( function_exists( 'arq_counters_data' ) ) {
					unset( $plugins['arqam-lite'] );
				}

				// Remove the Switcher Plugin if the Disable the Switcher option is ON
				if( tie_get_option( 'disable_switcher' ) ){
					unset( $plugins['jannah-switcher'] );
				}
			}

			// Force Show the Install Plugins page if the $plugins is empty
			$plugins = apply_filters( 'TieLabs/Plugins_Installer/data', $plugins );

			// Run TGM
			if( ! empty( $plugins ) && is_array( $plugins ) ){

				$config = array(
					'id'           => apply_filters( 'TieLabs/theme_name', 'TieLabs' ),
					'default_path' => '',
					'menu'         => 'tie-install-plugins',
					'has_notices'  => true,
					'dismissable'  => false,
					'is_automatic' => false,
					'message'      => '',
				);

				tie_tgmpa( $plugins, $config ); // check the notice
			}
		}


		/**
		 * add_about_tabs
		 *
		 * Add the Install Plugins Page to the about page's tabs
		 */
		function add_about_tabs( $tabs ){

			$tabs['plugins'] = array(
				'text' => esc_html__( 'Install Plugins', TIELABS_TEXTDOMAIN ),
				'url'  => menu_page_url( $this->menu_slug, false ),
			);

			return $tabs;
		}


		/**
		 * remove_notice
		 *
		 * Remove TGM notice for users without permissions to install/update plugins
		 */
		function remove_notice( $val, $object_id, $meta_key, $single ){

			if( $meta_key === 'tie_tgmpa_dismissed_notice_'.TIELABS_THEME_SLUG ){ // check the notice
				return true;
			}

			return null;
		}


		/**
		 * admin_menu_args
		 *
		 * Add the TGM plugin page to the theme menu
		 */
		function admin_menu_args( $args ){
			$args['page_title']  = esc_html__( 'Install Bundled Plugins', TIELABS_TEXTDOMAIN );
			$args['parent_slug'] = 'admin';
			$args['capability']  = 'switch_themes';
			return $args;
		}
	}


	new TIELABS_REQUIRED_PLUGINS();
}
