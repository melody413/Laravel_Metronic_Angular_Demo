<?php
/**
 * Theme Options
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


/**
 * Save Theme Settings
 */
function tie_save_theme_options( $data, $refresh = 0 ){

	if( ! empty( $data['tie_options'] ) ) {

		//
		$new_settings = $data['tie_options'];

		// DB option field name
		$option_field = apply_filters( 'TieLabs/theme_options', '' );

		// Get the Stored options
		//$stored_settings = get_option( $option_field );

		// Prepare the data
		do_action( 'TieLabs/Options/before_update', $new_settings );

		// To avoid reseting addons settings if they are disabled
		//if( $stored_settings ){
			//$new_settings = wp_parse_args( $new_settings, $stored_settings );
		//}

		// Remove all empty keys
		$new_settings = TIELABS_ADMIN_HELPER::clean_settings( $new_settings );
		$new_settings = TIELABS_ADMIN_HELPER::array_filter( $new_settings );

		foreach ( $new_settings as $key => $value ) {
			if( ! is_array( $value ) ) {
				$new_settings[ $key ] = str_replace( 'tie-open-tag', '', $value );
			}
		}

		// Remove the Logo Text if it is the same as the site title
		if( ! empty( $new_settings['logo_text'] ) && $new_settings['logo_text'] == get_bloginfo() ){
			unset( $new_settings['logo_text'] );
		}

		// If the site uses SSL, make sure all site links are SSL
		if( TIELABS_HELPER::is_ssl() ){
			array_walk_recursive( $new_settings, array( 'TIELABS_HELPER', 'replace_ssl' ) );
		}

		// Save the settings
		update_option( $option_field, $new_settings );

		// WPML
		if( ! empty( $new_settings['breaking_custom'] ) && is_array( $new_settings['breaking_custom'] ) ) {
			$count = 0;

			foreach ( $new_settings['breaking_custom'] as $custom_text ){
				$count++;

				if( ! empty( $custom_text['text'] ) ) {
					do_action( 'wpml_register_single_string', TIELABS_THEME_SLUG, 'Breaking News Custom Text #'.$count, $custom_text['text'] );
				}

				if( ! empty( $custom_text['link'] ) ) {
					do_action( 'wpml_register_single_string', TIELABS_THEME_SLUG, 'Breaking News Custom Link #'.$count, $custom_text['link'] );
				}
			}
		}
	}

	// After updating the theme options action
	do_action( 'TieLabs/Options/updated' );

	// Refresh the page?
	$refresh = apply_filters( 'TieLabs/options_refresh', $refresh );

	if( ! empty( $refresh ) ){
		echo esc_html( $refresh );
		die();
	}
}


/**
 * Save Options
 */
add_action( 'wp_ajax_tie_theme_data_save', 'tie_save_theme_options_ajax' );
function tie_save_theme_options_ajax(){
	check_ajax_referer( 'tie-theme-data', 'tie-security' );

	if( current_user_can( 'manage_options' ) ){
		tie_save_theme_options( stripslashes_deep( $_POST ), 1 );
	}
}


/**
 * Add the Theme Options Page to the about page's tabs
 */
add_filter( 'TieLabs/about_tabs', 'tie_about_tabs_options', 99 );
function tie_about_tabs_options( $tabs ){

	$tabs['theme-options'] = array(
		'text' => esc_html__( 'Theme Options', TIELABS_TEXTDOMAIN ),
		'url'  => menu_page_url( 'tie-theme-options', false ),
	);

	return $tabs;
}


/**
 * Add Panel Page
 */
add_action( 'admin_menu', 'tie_admin_menus' );
function tie_admin_menus(){

	// Add the main theme settings page
	add_menu_page(
		$page_title = apply_filters( 'TieLabs/theme_name', 'TieLabs' ),
		$menu_title = 'tietheme',
		$capability = 'switch_themes',
		$menu_slug  = 'tie-theme-options',
		$function   = 'tie_show_theme_options',
		$icon_url   = tie_get_option( 'white_label_menu_icon', TIELABS_TEMPLATE_URL.'/framework/admin/assets/images/tie.png' ),
		$position   = 99
	);

	// Add Sub menus
	$theme_submenus = array(
		array(
			'page_title' => esc_html__( 'Theme Options', TIELABS_TEXTDOMAIN ),
			'menu_title' => esc_html__( 'Theme Options', TIELABS_TEXTDOMAIN ),
			'menu_slug'  => 'tie-theme-options',
			'function'   => 'tie_show_theme_options',
		),
	);

	$theme_submenus = apply_filters( 'TieLabs/panel_submenus', $theme_submenus );

	foreach ( $theme_submenus as $submenu ){
		add_submenu_page(
			$parent_slug = 'tie-theme-options',
			$page_title  = $submenu['page_title'],
			$menu_title  = $submenu['menu_title'],
			$capability  = 'switch_themes',
			$menu_slug   = $submenu['menu_slug'],
			$function    = $submenu['function']
		);
	}


	if( ! TIELABS_ADMIN_HELPER::is_theme_options_page() ) {
		return;
	}

	// Reset settings
	if( isset( $_REQUEST['reset-settings'] ) && check_admin_referer( 'reset-theme-settings', 'reset_nonce' ) ){

		$default_data = tie_default_theme_settings();
		tie_save_theme_options( $default_data );

		# Redirect to the theme options page
		wp_safe_redirect( add_query_arg( array( 'page' => 'tie-theme-options', 'reset' => 'true' ), admin_url( 'admin.php' ) ) );
		exit;
	}

	// Export Settings
	elseif( isset( $_REQUEST['export-settings'] ) && check_admin_referer( 'export-theme-settings', 'export_nonce' ) ){

		global $wpdb;

		$stored_options = $wpdb->get_results( $wpdb->prepare( "SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name = '%s'", apply_filters( 'TieLabs/theme_options', '' ) ));

		header( 'Cache-Control: public, must-revalidate' );
		header( 'Pragma: hack' );
		header( 'Content-Type: text/plain' );
		header( 'Content-Disposition: attachment; filename="'. TIELABS_THEME_SLUG .'-options-'.date("dMy").'.dat"');
		echo json_encode( unserialize( $stored_options[0]->option_value ) );
		die();
	}

	// Import the settings
	elseif( isset( $_FILES[ 'tie_import_file' ] ) && check_admin_referer( 'tie-theme-data', 'tie-security' ) ){
		if( $_FILES['tie_import_file']['error'] > 0 ){
			// error
		}
		else {
			$options = json_decode( file_get_contents( $_FILES['tie_import_file']['tmp_name'] ), true );

			if ( ! empty( $options ) && is_array( $options ) ) {
				update_option( apply_filters( 'TieLabs/theme_options', '' ), $options );
			}
		}

		wp_safe_redirect( add_query_arg( array( 'page' => 'tie-theme-options', 'import' => 'true' ), admin_url( 'admin.php' ) ) );
		exit;
	}

}


/**
 * Dark Skin
 */
add_Action( 'admin_head', 'tie_options_dark_skin' );
function tie_options_dark_skin(){
	if( TIELABS_ADMIN_HELPER::is_theme_options_page() ) {
		?>
		<script>
			if( 'undefined' != typeof localStorage ){
				var skin = localStorage.getItem('tie-backend-skin');
				if( skin == 'dark' ){
					var html = document.getElementsByTagName('html')[0].classList;
					html.add('tie-darkskin');
				}
			}
		</script>
		<?php
	}
}


/**
 * Get The Panel Options
 */
function tie_build_theme_option( $value ){
	$data = false;

	if( empty( $value['id'] ) ) {
		$value['id'] = ' ';
	}

	if( tie_get_option( $value['id'] ) ){
		$data = tie_get_option( $value['id'] );
	}

	tie_build_option( $value, 'tie_options['.$value["id"].']', $data );
}



/**
 * Save button
 */
add_action( 'TieLabs/save_button', 'tie_save_options_button' );
function tie_save_options_button(){ ?>

	<div class="tie-panel-submit">
		<button name="save" class="tie-save-button tie-primary-button button button-primary button-hero" type="submit"><?php esc_html_e( 'Save Changes', TIELABS_TEXTDOMAIN ) ?></button>
	</div>
	<?php
}



/**
 * Add Extra Mimes Types
 */
add_filter( 'upload_mimes', 'tie_fonts_mimes_types', 1, 1 );
function tie_fonts_mimes_types( $mime_types ) {

	// Allow this for Administrators and in the backend only.
	if( ! is_admin() || ! current_user_can( 'manage_options' ) ){
		return $mime_types;
	}

	$mime_types['html']  = 'text/html';
	$mime_types['svg']   = 'image/svg+xml';
	$mime_types['eot']   = 'application/vnd.ms-fontobject';
	$mime_types['ttf']   = 'application/x-font-ttf';
	$mime_types['woff']  = 'application/x-font-woff';
	$mime_types['woff2'] = 'application/x-font-woff2';

	return $mime_types;
}



/**
 * The Panel UI
 */
function tie_show_theme_options(){

	wp_enqueue_media();

	$settings_tabs = apply_filters( 'TieLabs/options_tab_title', '' );

	?>

	<div id="tie-page-overlay"></div>

	<div id="tie-saving-settings">
		<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
			<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
			<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
			<path class="checkmark__error_1" d="M38 38 L16 16 Z"/>
			<path class="checkmark__error_2" d="M16 38 38 16 Z" />
		</svg>
	</div>

	<?php do_action( 'TieLabs/before_theme_panel' );?>

	<div class="tie-panel">

		<div class="tie-panel-tabs">

			<?php

				if( tie_get_option( 'white_label_options_logo' ) ){
					echo '
						<span class="tie-logo">
							<img loading="lazy" class="tie-logo-normal" src="'. tie_get_option( 'white_label_options_logo' ) .'" alt="" />
						</span>
					';
				}
				else{ ?>
					<a href="http://tielabs.com/" target="_blank" class="tie-logo">
						<img loading="lazy" class="tie-logo-normal" src="<?php echo TIELABS_TEMPLATE_URL .'/framework/admin/assets/images/tielabs-logo.png' ?>" alt="<?php esc_html_e( 'TieLabs', TIELABS_TEXTDOMAIN ) ?>" />
						<img loading="lazy" class="tie-logo-mini" src="<?php echo TIELABS_TEMPLATE_URL .'/framework/admin/assets/images/tielabs-logo-mini.png' ?>" alt="<?php esc_html_e( 'TieLabs', TIELABS_TEXTDOMAIN ) ?>" />
					</a>
					<?php
				}
			?>

			<ul>
				<?php
					foreach( $settings_tabs as $tab => $settings ){

						$icon  = $settings['icon'];
						$title = $settings['title'];

						echo "
							<li class=\"tie-tabs tie-options-tab-$tab\">
								<a href=\"#tie-options-tab-$tab\">
									<span class=\"dashicons-before dashicons-$icon tie-icon-menu\"></span>
									$title
								</a>
							</li>
						";
					}


					if( ! tie_is_theme_rated() ){
						?>
							<li class="tie-tabs tie-rate tie-not-tab"><a target="_blank" href="<?php echo tie_get_purchase_link(); ?>"><span class="dashicons-before dashicons-star-filled tie-icon-menu"></span><?php printf( esc_html__( 'Rate %s', TIELABS_TEXTDOMAIN ), apply_filters( 'TieLabs/theme_name', 'TieLabs' ) ); ?></a></li>
						<?php
					}
				?>

				<li class="tie-tabs tie-more tie-not-tab"><a target="_blank" href="<?php echo apply_filters( 'TieLabs/External/portfolio', '' ); ?>"><span class="dashicons-before dashicons-smiley tie-icon-menu"></span><?php esc_html_e( 'More Themes', TIELABS_TEXTDOMAIN ) ?></a></li>
			</ul>
			<div class="clear"></div>

			<div id="tiepanel-darkskin-wrap">
				<input id="tiepanel-darkskin" class="tie-js-switch" type="checkbox" value="true">
				<span class="darkskin-label"><?php esc_html_e( 'Dark Skin', TIELABS_TEXTDOMAIN ) ?> <span class="tie-label-primary-bg"><?php esc_html_e( 'Beta', TIELABS_TEXTDOMAIN ) ?></span></span>
				<script>
					if( 'undefined' != typeof localStorage ){
						var skin = localStorage.getItem('tie-backend-skin');
						if( skin == 'dark' ){
							document.getElementById('tiepanel-darkskin').setAttribute('checked', 'checked');
						}
					}
				</script>
			</div>
		</div> <!-- .tie-panel-tabs -->

		<div class="tie-panel-content">

			<div id="theme-options-search-wrap">
				<input id="theme-panel-search" type="text" placeholder="<?php esc_html_e( 'Search', TIELABS_TEXTDOMAIN ) ?>">
				<div id="theme-search-list-wrap" class="has-custom-scroll">
					<ul id="theme-search-list"></ul>
				</div>
			</div>


			<form method="post" name="tie_form" id="tie_form" enctype="multipart/form-data">

				<?php
					foreach( $settings_tabs as $tab => $settings ){

						echo "
						<!-- $tab Settings -->
						<div id=\"tie-options-tab-$tab\" class=\"tabs-wrap\">";

						TIELABS_HELPER::get_template_part( 'framework/admin/theme-options/'.$tab );

						do_action( 'tie_theme_options_tab_'.$tab );

						echo "</div>";

					}
				?>

				<?php wp_nonce_field( 'tie-theme-data', 'tie-security' ); ?>
				<input type="hidden" name="action" value="tie_theme_data_save" />

				<div class="tie-footer">

					<?php //TIELABS_VERIFICATION::support_compact_notice(); ?>

					<?php do_action( 'TieLabs/save_button' ); ?>
				</div>

			</form>

		</div><!-- .tie-panel-content -->
		<div class="clear"></div>

	</div><!-- .tie-panel -->

	<?php

	// HelpSout Beacon
	if( get_option( 'tie_token_'.TIELABS_THEME_ID ) && ! tie_get_option( 'white_label_beacon' ) ){ ?>
		<script type="text/javascript">!function(e,t,n){function a(){var e=t.getElementsByTagName("script")[0],n=t.createElement("script");n.type="text/javascript",n.async=!0,n.src="https://beacon-v2.helpscout.net",e.parentNode.insertBefore(n,e)}if(e.Beacon=n=function(t,n,a){e.Beacon.readyQueue.push({method:t,options:n,data:a})},n.readyQueue=[],"complete"===t.readyState)return a();e.attachEvent?e.attachEvent("onload",a):e.addEventListener("load",a,!1)}(window,document,window.Beacon||function(){});</script>
		<script type="text/javascript">
			window.Beacon('init', 'e9254113-3842-4968-97fa-13dee4551b96');
			window.Beacon('config', {
				display: {
					style: 'iconAndText',
					iconImage: 'help',
					text: '<?php esc_html_e( 'Need Help?', TIELABS_TEXTDOMAIN ) ?>',
					textAlign: '<?php echo is_rtl() ? 'left'  : 'right'; ?>',
					position:  '<?php echo is_rtl() ? 'right' : 'left'; ?>',
					zIndex: 9991,
				},
				labels: {
					suggestedForYou: '<?php esc_html_e( 'Knowledge Base', TIELABS_TEXTDOMAIN ) ?>',
					searchLabel: '<?php esc_html_e( 'Need Help? Search the knowledge base', TIELABS_TEXTDOMAIN ) ?>',
				}
			})
		</script>
		<?php
	}

}


/**
 * Share buttons
 */
function tie_get_share_buttons_options( $share_position = '' ){

	$position = ! empty( $share_position ) ? '_'.$share_position : '';

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Twitter', TIELABS_TEXTDOMAIN ),
			'id'     => 'share_twitter'.$position,
			'type'   => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Facebook', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_facebook'.$position,
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'LinkedIn', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_linkedin'.$position,
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Pinterest', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_pinterest'.$position,
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Reddit', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_reddit'.$position,
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Tumblr', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_tumblr'.$position,
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'VKontakte', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_vk'.$position,
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Odnoklassniki', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_odnoklassniki'.$position,
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Pocket', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_pocket'.$position,
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Skype', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_skype'.$position,
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Messenger', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_messenger'.$position,
			'type' => 'checkbox',
		));

	if( $share_position != 'sticky' ){
		tie_build_theme_option(
			array(
				'name' => esc_html__( 'WhatsApp', TIELABS_TEXTDOMAIN ),
				'id'   => 'share_whatsapp'.$position,
				'type' => 'checkbox',
				'hint' => ( $share_position != 'mobile' ) ? esc_html__( 'For Mobiles Only', TIELABS_TEXTDOMAIN ) : '',
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Telegram', TIELABS_TEXTDOMAIN ),
				'id'   => 'share_telegram'.$position,
				'type' => 'checkbox',
				'hint' => ( $share_position != 'mobile' ) ? esc_html__( 'For Mobiles Only', TIELABS_TEXTDOMAIN ) : '',
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Viber', TIELABS_TEXTDOMAIN ),
				'id'   => 'share_viber'.$position,
				'type' => 'checkbox',
				'hint' => ( $share_position != 'mobile' ) ? esc_html__( 'For Mobiles Only', TIELABS_TEXTDOMAIN ) : '',
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Line', TIELABS_TEXTDOMAIN ),
				'id'   => 'share_line'.$position,
				'type' => 'checkbox',
				'hint' => ( $share_position != 'mobile' ) ? esc_html__( 'For Mobiles Only', TIELABS_TEXTDOMAIN ) : '',
			));
	}

	if( $share_position != 'mobile' ){
		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Email', TIELABS_TEXTDOMAIN ),
				'id'   => 'share_email'.$position,
				'type' => 'checkbox',
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Print', TIELABS_TEXTDOMAIN ),
				'id'   => 'share_print'.$position,
				'type' => 'checkbox',
			));
	}

}


