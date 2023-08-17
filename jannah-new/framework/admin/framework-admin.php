<?php
/**
 * Dashboard main file
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


/*-----------------------------------------------------------------------------------
	WordPress uses the menu parent name in the sub menu pages class names example:
	{menu-slug}_page_{sub-menu-slug} and use it in the main page hook name example:
	load-{menu-slug}_page_{sub-menu-slug} and that craetes a lot of issues as you can't
	use these hooks or classes if the parent menu name is translatable

	What we do here is change the Parent menu page from the English static name to a
	translatable text
/*-----------------------------------------------------------------------------------*/
add_filter( 'parent_file', 'tie_chnage_theme_parent_menu', 1 );
function tie_chnage_theme_parent_menu( $name ){

	global $menu;

	foreach ($menu as $key => $value) {
		if( ! empty( $value[0] ) && $value[0] == 'tietheme' ){
			$menu[$key][0] = apply_filters( 'TieLabs/theme_name', 'TieLabs' );
			break;
		}
	}

	return $name;
}


/**
 * Custom Admin Bar Menus
 */
add_action( 'admin_bar_menu', 'tie_modify_admin_bar', 40 );
function tie_modify_admin_bar( $wp_admin_bar ){

	if ( ! current_user_can( 'switch_themes' ) || ! tie_get_option( 'theme_toolbar' ) || TIELABS_ADMIN_HELPER::is_theme_options_page() ){
		return;
	}

	// Icon
	if( tie_get_option( 'white_label_menu_icon' ) ){
		$menu_icon = '<span class="ab-icon dashicons '. tie_get_option( 'white_label_menu_icon' ) .'"></span>';
	}
	else{
		$menu_icon = '<span class="ab-icon"><img src="'. TIELABS_TEMPLATE_URL .'/framework/admin/assets/images/tie.png" alt=""></span>';
	}

	// Add the main menu item
	$wp_admin_bar->add_menu( array(
		'id'     => 'tie-adminbar-panel',
		'title'  => $menu_icon .' '. apply_filters( 'TieLabs/theme_name', 'TieLabs' ),
		'href'   => add_query_arg( array( 'page' => 'tie-theme-options' ), admin_url( 'admin.php' ) ),
	));

	$wp_admin_bar->add_menu( array(
		'parent' => 'tie-adminbar-panel',
		'id'     => 'tie-adminbar-options',
		'title'  => '<span class="dashicons-before dashicons-admin-generic"></span> '. esc_html__( 'Theme Options', TIELABS_TEXTDOMAIN ),
		'href'   => add_query_arg( array( 'page' => 'tie-theme-options' ), admin_url( 'admin.php' ) ),
	));

	// Sub Menu
	$settings_tabs = apply_filters( 'TieLabs/options_tab_title', '' );

	foreach ( $settings_tabs as $tab_id => $tab_data ){

		$wp_admin_bar->add_menu( array(
			'parent' => 'tie-adminbar-options',
			'id'     => 'tie-theme-'.$tab_id,
			'title'  => '<span class="dashicons-before dashicons-'. $tab_data['icon'] .'"></span> '. $tab_data['title'],
			'href'   => add_query_arg( array( 'page' => 'tie-theme-options#tie-options-tab-'. $tab_id .'-target' ), admin_url( 'admin.php' ) ),
		));
	}

	if( get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
		$wp_admin_bar->add_menu(array(
			'parent' => 'tie-adminbar-panel',
			'id'     => 'tie-knowledge-base',
			'title'  => '<span class="dashicons-before dashicons-book"></span> '. esc_html__( 'Knowledge Base', TIELABS_TEXTDOMAIN ),
			'href'   => apply_filters( 'TieLabs/External/knowledge_base', '' )
		));
	}
	else{

		$wp_admin_bar->add_menu(array(
			'parent' => 'tie-adminbar-panel',
			'id'     => 'tie-adminbar-activate-theme',
			'title'  => '<span class="dashicons-before dashicons-unlock"></span> '. sprintf( esc_html__( 'Activate %s', TIELABS_TEXTDOMAIN ), apply_filters( 'TieLabs/theme_name', 'TieLabs' ) ),
			'href'   => add_query_arg( array( 'page' => 'tie-theme-welcome' ), admin_url( 'admin.php' ) ),
		));

		$wp_admin_bar->add_menu(array(
			'parent' => 'tie-adminbar-panel',
			'id'     => 'tie-buy-theme',
			'title'  => '<span class="dashicons-before dashicons-cart"></span> '. esc_html__( 'Buy a License', TIELABS_TEXTDOMAIN ),
			'href'   => tie_get_purchase_link( array( 'utm_source' => 'admin-bar' )
			),
		));
	}

	// Style the icons
	echo '
		<style>
			#wp-admin-bar-tie-adminbar-panel .ab-icon img{
				max-width: 17px;
				height: auto;
			}

			#wp-admin-bar-tie-adminbar-panel .dashicons-before:before {
				font-size: 14px;
				vertical-align: middle;
			}
			#wpadminbar ul li#wp-admin-bar-tie-adminbar-activate-theme a{
				color: #f44336 !important;
			}
		</style>
	';
}


/**
 * Theme Options tabs
 */
add_filter( 'TieLabs/options_tab_title', 'tie_build_theme_options_tabs', 9 );
function tie_build_theme_options_tabs(){

	$settings_tabs = array(

		'dashboard' => array(
			'icon'  => 'dashboard',
			'title' => esc_html__( 'Dashboard', TIELABS_TEXTDOMAIN )),

		'general' => array(
			'icon'  => 'admin-generic',
			'title' => esc_html__( 'General', TIELABS_TEXTDOMAIN )),

		'layout' => array(
			'icon'  => 'admin-settings',
			'title' => esc_html__( 'Layout', TIELABS_TEXTDOMAIN )),

		'header' => array(
			'icon'	=> 'schedule',
			'title'	=> esc_html__( 'Header', TIELABS_TEXTDOMAIN )),

		'logo' => array(
			'icon'  => 'lightbulb',
			'title' => esc_html__( 'Logo', TIELABS_TEXTDOMAIN )),

		'footer' => array(
			'icon'  => 'editor-insertmore',
			'title' => esc_html__( 'Footer', TIELABS_TEXTDOMAIN )),

		'blocks' => array(
			'icon'	=> 'welcome-widgets-menus',
			'title'	=> esc_html__( 'Blocks', TIELABS_TEXTDOMAIN )),

		'archives' => array(
			'icon'	=> 'exerpt-view',
			'title'	=> esc_html__( 'Archives', TIELABS_TEXTDOMAIN )),

		'posts' => array(
			'icon'  => 'media-text',
			'title' => esc_html__( 'Single Post Page', TIELABS_TEXTDOMAIN )),

		'post-views' => array(
			'icon'  => 'visibility',
			'title' => esc_html__( 'Post Views', TIELABS_TEXTDOMAIN )),

		'share' => array(
			'icon'  => 'share',
			'title' => esc_html__( 'Share Buttons', TIELABS_TEXTDOMAIN )),

		'sidebars' => array(
			'icon'  => 'slides',
			'title' => esc_html__( 'Sidebars', TIELABS_TEXTDOMAIN )),

		'lightbox' => array(
			'icon'  => 'format-image',
			'title' => esc_html__( 'LightBox', TIELABS_TEXTDOMAIN )),

		'page-404' => array(
			'icon'  => 'info',
			'title' => esc_html__( '404 Page', TIELABS_TEXTDOMAIN )),

		'e3lan' => array(
			'icon'  => 'megaphone',
			'title' => esc_html__( 'Advertisement', TIELABS_TEXTDOMAIN )),

		'background' => array(
			'icon'  => 'art',
			'title' => esc_html__( 'Background', TIELABS_TEXTDOMAIN )),

		'styling' => array(
			'icon'  => 'admin-appearance',
			'title' => esc_html__( 'Styling', TIELABS_TEXTDOMAIN )),

		'typography' => array(
			'icon'  => 'editor-italic',
			'title' => esc_html__( 'Typography', TIELABS_TEXTDOMAIN )),

		'translations' => array(
			'icon'  => 'editor-textcolor',
			'title' => esc_html__( 'Translations', TIELABS_TEXTDOMAIN )),

		'social' => array(
			'icon'  => 'networking',
			'title' => esc_html__( 'Social Networks', TIELABS_TEXTDOMAIN )),

		'mobile' => array(
			'icon'  => 'smartphone',
			'title' => esc_html__( 'Mobile', TIELABS_TEXTDOMAIN )),

		'amp' => array(
			'icon'  => 'search',
			'title' => esc_html__( 'AMP', TIELABS_TEXTDOMAIN )),

		'web-notifications' => array(
			'icon'  => 'admin-site',
			'title' => esc_html__( 'Web Notifications', TIELABS_TEXTDOMAIN )),

		'integrations' => array(
			'icon'  => 'admin-network',
			'title' => esc_html__( 'Integrations', TIELABS_TEXTDOMAIN )),

		'images' => array(
			'icon'  => 'format-image',
			'title' => esc_html__( 'Images', TIELABS_TEXTDOMAIN )),

		'white-label' => array(
			'icon'  => 'hidden',
			'title' => esc_html__( 'White Label', TIELABS_TEXTDOMAIN )),

		'advanced' => array(
			'icon'  => 'admin-tools',
			'title' => esc_html__( 'Advanced', TIELABS_TEXTDOMAIN )),
	);

	if ( TIELABS_WOOCOMMERCE_IS_ACTIVE ){

		$settings_tabs['woocommerce'] = array(
			'icon'  => 'woocommerce',
			'title' => esc_html__( 'WooCommerce', TIELABS_TEXTDOMAIN ),
		);
	}


	if ( TIELABS_BBPRESS_IS_ACTIVE ){

		$settings_tabs['bbpress'] = array(
			'icon'  => 'buddicons-bbpress-logo',
			'title' => esc_html__( 'bbPress', TIELABS_TEXTDOMAIN ),
		);
	}

	if ( TIELABS_BUDDYPRESS_IS_ACTIVE ){

		$settings_tabs['buddypress'] = array(
			'icon'  => 'buddicons-buddypress-logo',
			'title' => esc_html__( 'BuddyPress', TIELABS_TEXTDOMAIN ),
		);
	}

	$settings_tabs['backup'] = array(
		'icon'  => 'migrate',
		'title' => esc_html__( 'Export/Import', TIELABS_TEXTDOMAIN ),
	);

	return $settings_tabs;
}


/**
 * Get theme purchase link
*/
function tie_get_purchase_link( $utm_data = array() ){

	// Let's track the source of purchase
	return add_query_arg(
		wp_parse_args( $utm_data, array(
		'utm_source'   => 'theme-panel',
		'utm_medium'   => 'link',
		'utm_campaign' => TIELABS_THEME_SLUG,
		'utm_content'  => false
		)),
		'https://tielabs.com/buy/jannah'
	);
}


/**
 * Return if current page is not ADMIN
	*/
if( ! is_admin() ){
	return;
}


/*-----------------------------------------------------------------------------------*/
# Include the Requried files
/*-----------------------------------------------------------------------------------*/
require TIELABS_TEMPLATE_PATH . '/framework/admin/theme-options.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-builder-widgets.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-welcome-page.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-menu-limit-detector.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-required-plugins.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-demo-importer.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-posts-switcher.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-system-status.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-theme-updater.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-settings.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-settings-category.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-settings-post.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-notices.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/classes/class-tielabs-verification.php';
require TIELABS_TEMPLATE_PATH . '/framework/admin/page-builder.php';



/*-----------------------------------------------------------------------------------*/
# Register main Scripts and Styles
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_enqueue_scripts', 'tie_admin_enqueue_scripts' );
function tie_admin_enqueue_scripts(){

	if( is_customize_preview() ){
		return;
	}

	// Enqueue dashboard scripts and styles
	$ver = time(); // Avoid browser cache for admins
	wp_enqueue_script( 'tie-admin-scripts', TIELABS_TEMPLATE_URL.'/framework/admin/assets/tie.js',    array( 'jquery', 'jquery-ui-sortable', 'jquery-ui-draggable', 'wp-color-picker' ), $ver, false );

	wp_register_style( 'tie-admin-style',    TIELABS_TEMPLATE_URL.'/framework/admin/assets/style.css', array(), $ver, 'all' );

	// Font Awesome CSS file
	wp_register_style( 'tie-fontawesome', TIELABS_TEMPLATE_URL.'/assets/fonts/fontawesome/font-awesome.css', array(), $ver, 'all' );

	wp_enqueue_style( 'tie-admin-style' );
	wp_enqueue_style( 'tie-fontawesome' );
	wp_enqueue_style( 'wp-color-picker' );

	$localize = array(
		'update' => esc_html__( 'Update', TIELABS_TEXTDOMAIN ),
		'search' => esc_html__( 'Search', TIELABS_TEXTDOMAIN ),
	);
	wp_localize_script( 'tie-admin-scripts', 'tieLang', $localize );


	// Avoid JS conflicts with some plugins
	wp_dequeue_script( 'insert-post-adschart-admin' );  // Insert Post Ads plugin | Chart.js library which causes conflict with the Iris color picker used by WordPress https://github.com/chartjs/Chart.js/issues/3168
	wp_dequeue_script( 'buy_sell_ads_pro_admin_jquery_ui_js_script' ); // ADS PRO – Multi-Purpose WordPress Ad Manager plugin
}


/*-----------------------------------------------------------------------------------*/
# Code Editor
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_enqueue_scripts', 'tie_admin_code_editor' );
function tie_admin_code_editor(){

	// Check if WP > 4.9 && syntax highlighting is enabled
	if( ! function_exists( 'wp_enqueue_code_editor' ) || ( is_user_logged_in() && 'false' === wp_get_current_user()->syntax_highlighting ) ){
		return;
	}


	// Posts and Pages elements
	$settings_post_types = apply_filters( 'TieLabs/settings_post_types', array( 'post', 'page' ) );
	if( is_array( $settings_post_types ) && in_array( get_post_type(), $settings_post_types ) ){

		$elements = array(
			'tie_custom_css' => 'text/css',
			'tie_get_banner_above' => 'text/html',
			'tie_get_banner_below' => 'text/html',
			'tie_get_banner_above_content' => 'text/html',
			'tie_get_banner_below_content' => 'text/html',
		);

		// Posts Only
		if( get_post_type() == 'post' ){

			$elements = array_merge(
				array(
					'tie_audio_embed' => 'text/html',
					'tie_embed_code'  => 'text/html',
				),
				$elements
			);
		}
	}

	// Category settings
	elseif( get_current_screen()->id === 'edit-category' ){

		$elements = array(
			'cat_custom_css' => 'text/css',
		);

	}

	// Theme Options Page
	elseif( TIELABS_ADMIN_HELPER::is_theme_options_page() ){

		$elements = array(

			//
			'header_code' => 'text/html',
			'body_code'   => 'text/html',
			'footer_code' => 'text/html',

			// ADS
			'banner_top_adsense'    => 'text/html',
			'banner_above_adsense'  => 'text/html',
			'banner_bottom_adsense' => 'text/html',
			'banner_header_adsense' => 'text/html',
			'banner_below_adsense'  => 'text/html',
			'banner_below_header_adsense'  => 'text/html',
			'banner_above_content_adsense' => 'text/html',
			'banner_below_content_adsense' => 'text/html',
			'between_posts_1_adsense'      => 'text/html',
			'between_posts_2_adsense'      => 'text/html',
			'banner_comments_adsense'      => 'text/html',

			// Inline Article Ads
			'article_inline_ad_1_adsense' => 'text/html',
			'article_inline_ad_2_adsense' => 'text/html',
			'article_inline_ad_3_adsense' => 'text/html',
			'article_inline_ad_4_adsense' => 'text/html',
			'article_inline_ad_5_adsense' => 'text/html',

			// Category Ads
			'banner_category_below_slider_adsense'     => 'text/html',
			'banner_category_above_title_adsense'      => 'text/html',
			'banner_category_below_title_adsense'      => 'text/html',
			'banner_category_below_posts_adsense'      => 'text/html',
			'banner_category_below_pagination_adsense' => 'text/html',

			// Ads Shortcodes
			'ads1_shortcode' => 'text/html',
			'ads2_shortcode' => 'text/html',
			'ads3_shortcode' => 'text/html',
			'ads4_shortcode' => 'text/html',
			'ads5_shortcode' => 'text/html',

			// AMP
			'amp_header_code'      => 'text/html',
			'amp_body_code'        => 'text/html',
			'amp_footer_copyright' => 'text/html',
			'amp_ad_above'         => 'text/html',
			'amp_ad_below'         => 'text/html',
			'amp_ad_below_header'  => 'text/html',
			'amp_ad_above_footer'  => 'text/html',

			// CSS
			'css'         => 'text/css',
			'css_tablets' => 'text/css',
			'css_phones'  => 'text/css',
			'css_amp'     => 'text/css',
		);
	}

	if( empty( $elements ) ){
		return;
	}

	// Prepare the output
	$out = '
		jQuery( function() {';

			foreach ($elements as $ele => $type ) {

				$settings = wp_enqueue_code_editor( array( 'type' => $type, 'codemirror' => array( 'indentUnit' => 2, 'tabSize' => 2 ) ));

				$out .= '
					if( jQuery("#'. $ele .'").length ){
						var '. $ele .' = wp.codeEditor.initialize( "'. $ele .'", '. wp_json_encode( $settings ) .' );
						';

						// Only in the theme options page
						//if( TIELABS_ADMIN_HELPER::is_theme_options_page() ){
							$out .= $ele.'.codemirror.on("change",function(cMirror){
								jQuery("#'.$ele.'").val( cMirror.getValue() );
							});';
						//}

						$out .= '
					}
				';
			}

			$out .='
		});
	';

	// Add the inline code
	wp_add_inline_script( 'code-editor', $out);
}


/*-----------------------------------------------------------------------------------*/
# Install the default theme settings
/*-----------------------------------------------------------------------------------*/
add_action( 'after_switch_theme', 'tie_install_theme', 1 );
function tie_install_theme(){

	// Save the default settings
	if( ! get_option( 'tie_ver_'. TIELABS_THEME_ID ) && ! get_option( apply_filters( 'TieLabs/theme_options', '' ) ) ){

		// Store the default settings
		$default_data = tie_default_theme_settings();

		tie_save_theme_options( $default_data );

		// Store the DB theme's version
		update_option( 'tie_ver_'. TIELABS_THEME_ID, TIELABS_DB_VERSION );

		// Store the data of installing the theme temporarily
		update_option( 'tie_install_date_'. TIELABS_THEME_ID, time(), false );
	}


	// Store the total number of puplished posts before Installing our theme
	$count_posts     = wp_count_posts();
	$published_posts = ! empty( $count_posts->publish ) ? $count_posts->publish : 0;
	update_option( 'tie_published_posts_'. TIELABS_THEME_ID, $published_posts, false );

	// Redirect to the Welcome page
	wp_safe_redirect( add_query_arg( array( 'page' => 'tie-theme-welcome' ), admin_url( 'admin.php' ) ));
}


/*-----------------------------------------------------------------------------------*/
# Default theme settings
/*-----------------------------------------------------------------------------------*/
function tie_default_theme_settings(){

	$default_settings = array(
		'tie_options' => array(

			'site_width'                        => '1200px',

			// General Settings
			'time_format'                       => 'modern',
			'time_type'                         => 'published',
			'breadcrumbs'                       => 'true',
			'breadcrumbs_delimiter'             => '&#47;',

			'structure_data'                    => 'true',
			'schema_type'                       => 'Article',

			// Layout
			'theme_layout'                      => 'full',
			'boxes_style'                       => 2,
			'loader-icon'                       => 1,

			// Header
			'header_layout'                     => '3',
			'main_nav'                          => 'true',
			'main_nav_dark'                     => 'true',
			'main_nav_layout'                   => 'true',
			'main-nav-components_search'       	=> 'true',
			'main-nav-components_live_search'   => 'true',
			'main-nav-components_search_layout' => 'default',
			'main-nav-components_social_layout' => 'compact',
			'stick_nav'                         => 'true',
			'sticky_behavior'                   => 'default',
			'top_nav'                           => 'true',
			'top_date'                          => 'true',
			'todaydate_format'                  => 'l, F j Y',
			'top-nav-area-1'                    => 'breaking',
			'breaking_effect'                   => 'reveal',
			'breaking_arrows'                   => 'true',
			'breaking_type'                     => 'category',
			'breaking_number'                   => 10,
			'top-nav-area-2'                    => 'components',
			'top-nav-components_slide_area'     => 'true',
			'top-nav-components_login'          => 'true',
			'top-nav-components_random'         => 'true',
			'top-nav-components_cart'           => 'true',

			// Logo
			'logo_setting'                      => 'logo',

			// Footer
			'footer_widgets_area_1'             => 'true',
			'footer_widgets_layout_area_1'      => 'footer-3c',
			'footer_widgets_area_2'             => 'true',
			'footer_widgets_layout_area_2'      => 'wide-left-3c',
			'copyright_area'                    => 'true',
			'footer_top'                        => 'true',
			'footer_social'                     => 'true',
			'footer_one'                        => sprintf( esc_html__( '%1$s Copyright %2$s, All Rights Reserved &nbsp;|&nbsp; %3$s Theme by %4$s', TIELABS_TEXTDOMAIN ), '&copy;', '%year%', '<span style="color:red;" class="tie-icon-heart"></span> <a href="'. apply_filters( 'TieLabs/External/theme_footer', '' ) .'" target="_blank" rel="nofollow noopener">'. apply_filters( 'TieLabs/theme_name', 'TieLabs' ), 'TieLabs</a>' ),

			// Mobile
			'mobile_header'                     => 'default',
			'stick_mobile_nav'                  => 'true',
			'sticky_mobile_behavior'            => 'default',
			'mobile_header_components_menu'     => 'area_1',
			'mobile_header_components_search'   => 'area_2',
			'mobile_menu_icon'                  => 1,
			'mobile_menu_layout'                => 'fullwidth',
			'mobile_menu_search'                => 'true',
			'mobile_menu_social'                => 'true',
			'share_post_mobile'                 => 'true',
			'share_twitter_mobile'              => 'true',
			'share_facebook_mobile'             => 'true',
			'share_whatsapp_mobile'             => 'true',
			'share_telegram_mobile'             => 'true',
			'mobile_post_show_more'             => false,

			// Aechives
			'trim_type'                         => 'words',

			'blog_display'        => 'excerpt',
			'blog_excerpt_length' => 20,
			'blog_pagination'     => 'next-prev',
			'blog_excerpt'        => 'true',
			'blog_read_more'      => 'true',

			'category_desc'           => 'true',
			'category_display'        => 'excerpt',
			'category_excerpt_length' => 20,
			'category_pagination'     => 'next-prev',
			'category_excerpt'        => 'true',
			'category_read_more'      => 'true',

			'tag_desc'           => 'true',
			'tag_display'        => 'excerpt',
			'tag_excerpt_length' => 20,
			'tag_pagination'     => 'next-prev',
			'tag_excerpt'        => 'true',
			'tag_read_more'      => 'true',

			'author_bio'            => 'true',
			'author_excerpt_length' => 20,
			'author_excerpt'        => 'true',
			'author_read_more'      => 'true',

			'search_excerpt'            => 'true',
			'search_read_more'          => 'true',
			'search_excerpt_length'     => 20,
			'search_exclude_post_types' => array( 'page' ),

			// 404
			'page_404_search' => 'true',
			'page_404_menu'   => 'true',

			// Single post layout
			'post_layout'           => 1,
			'post_featured'         => 'true',
			'sticky_featured_video' => 'true',
			'image_lightbox'        => 'true',
			'post_og_cards'         => 'true',
			'post_meta_escription'  => 'true',
			'reading_indicator'     => 'true',
			'post_authorbio'        => 'true',
			'post_cats'             => 'true',
			'post_tags'             => 'true',
			'post_meta'             => 'true',
			'post_author'           => 'true',
			'post_author_avatar'    => 'true',
			'post_date'             => 'true',
			'post_comments'         => 'true',
			'post_views'            => 'true',
			'reading_time'          => 'true',
			'responsive_tables'     => 'true',

			'post_newsletter_text'  => '
<h4>With Product You Purchase</h4>
<h3>Subscribe to our mailing list to get the new updates!</h3>
<p>Lorem ipsum dolor sit amet, consectetur.</p>',

			'related'             => 'true',
			'related_position'    => 'post',
			'related_number'      => 3,
			'related_number_full' => 4,
			'related_query'       => 'category',
			'related_order'       => 'rand',

			'check_also'          => 'true',
			'check_also_position' => 'right',
			'check_also_number'   => 1,
			'check_also_query'    => 'category',
			'check_also_order'    => 'rand',

			// Post Views
			'tie_post_views'       => 'theme',
			'views_meta_field'     => 'tie_views',
			'views_colored'        => 'true',
			'views_warm_color'     => 500,
			'views_hot_color'      => 2000,
			'views_veryhot_color'  => 5000,

			// Share Posts
			'select_share'       => 'true',

			'share_style_top'    => 'style_3',
			'share_center_top'   => 'true',
			'share_twitter_top'  => 'true',
			'share_facebook_top' => 'true',
			'share_linkedin_top' => 'true',

			'share_post_bottom' => 'true',
			'share_twitter'     => 'true',
			'share_facebook'    => 'true',
			'share_linkedin'    => 'true',
			'share_pinterest'   => 'true',
			'share_reddit'      => 'true',
			'share_tumblr'      => 'true',
			'share_vk'          => 'true',
			'share_email'       => 'true',
			'share_print'       => 'true',

			// Sidebar
			'widgets_icon'   => 'true',
			'sidebar_pos'    => 'right',
			'sticky_sidebar' => 'true',

			// LightBox
			'lightbox_all'     => 'true',
			'lightbox_gallery' => 'true',
			'lightbox_skin'    => 'dark',
			'lightbox_thumbs'  => 'horizontal',
			'lightbox_arrows'  => 'true',

			// 404 Page
			'page_404_search' => 'true',
			'page_404_menu'   => 'true',


			// Background
			'background_pattern'      => 'body-bg1',
			'background_dimmer_color' => 'black',

			// Styling
			'inline_css' => 'true',

			// AMP
			'amp_active'      => 'true',
			'amp_author_meta' => 'true',
			'amp_date_meta'   => 'true',
		)
	);

	if( is_rtl() ){
		$default_settings['tie_options']['sidebar_pos']             = 'left';
		$default_settings['tie_options']['check_also_position']     = 'left';
		$default_settings['tie_options']['bbpress_sidebar_pos']     = 'left';
		$default_settings['tie_options']['woo_sidebar_pos']         = 'left';
		$default_settings['tie_options']['woo_product_sidebar_pos'] = 'left';

		$default_settings['tie_options']['typography_headings_font_source'] = 'google';
		$default_settings['tie_options']['typography_headings_google_font'] = 'Changa';

		$default_settings['tie_options']['typography_menu_font_source'] = 'google';
		$default_settings['tie_options']['typography_menu_google_font'] = 'early#Noto Sans Kufi Arabic';

		$default_settings['tie_options']['typography_post_small_title_blocks']['weight'] = '500';
		$default_settings['tie_options']['typography_single_post_title']['line_height']  = '1.3';
	}
	else{
		$default_settings['tie_options']['typography_headings_font_source'] = 'google';
		$default_settings['tie_options']['typography_headings_google_font'] = 'Poppins';
		$default_settings['tie_options']['typography_headings_google_variants'] = array( '600' );
	}

	return $default_settings;
}


/*-----------------------------------------------------------------------------------*/
# Add user's social accounts
/*-----------------------------------------------------------------------------------*/
add_action( 'show_user_profile', 'tie_user_profile_custom_options', 1 );
add_action( 'edit_user_profile', 'tie_user_profile_custom_options', 1 );
function tie_user_profile_custom_options( $user ){ ?>

	<br />
	<div class="tie-block-head"><?php echo apply_filters( 'TieLabs/theme_name', 'TieLabs' ) ?> - <?php esc_html_e( 'Custom Author widget', TIELABS_TEXTDOMAIN ) ?></div>
	<div class="option-item">
		<label class="tie-label" for="author_widget_content"><?php esc_html_e( 'Custom Author widget content', TIELABS_TEXTDOMAIN ) ?></label>
		<textarea name="author_widget_content" id="author_widget_content" rows="5" cols="30"><?php echo esc_textarea( get_the_author_meta( 'author_widget_content', $user->ID ) ); ?></textarea>
		<span class="extra-text"><?php esc_html_e( 'Supports: Text, HTML and Shortcodes.', TIELABS_TEXTDOMAIN ) ?></span>
	</div>

	<br />
	<div class="tie-block-head"><?php echo apply_filters( 'TieLabs/theme_name', 'TieLabs' ) ?> - <?php esc_html_e( 'Social Networks', TIELABS_TEXTDOMAIN ) ?></div>
	<?php
		$author_social = tie_author_social_array();
		foreach ( $author_social as $network => $button ){ ?>
			<div class="option-item">
				<label class="tie-label" for="<?php echo esc_attr( $network ) ?>"><?php echo esc_html( $button['text'] ) ?></label>
				<input type="text" name="<?php echo esc_attr( $network ) ?>" id="<?php echo esc_attr( $network ) ?>" value="<?php echo esc_attr( get_the_author_meta( $network, $user->ID )); ?>" />
			</div>
			<?php
		}
}


/*-----------------------------------------------------------------------------------*/
# Save user's custom fields
/*-----------------------------------------------------------------------------------*/
add_action( 'personal_options_update',  'tie_save_user_profile_custom_options' );
add_action( 'edit_user_profile_update', 'tie_save_user_profile_custom_options' );
function tie_save_user_profile_custom_options( $user_id ){

	if ( ! current_user_can( 'edit_user', $user_id ) ){
		return false;
	}

	update_user_meta( $user_id, 'author_widget_content', wp_kses_post( $_POST['author_widget_content'] ) );

	// Save the social networks
	$author_social = tie_author_social_array();

	foreach ( $author_social as $network => $button ){
		update_user_meta( $user_id, $network, wp_kses_post( $_POST[ $network ] ) );
	}
}


/*-----------------------------------------------------------------------------------*/
# Get Latest Theme Data
/*-----------------------------------------------------------------------------------*/
function tie_get_latest_theme_data( $key = '', $token = false, $force_update = false, $update_files = false, $revoke = false ){

	// Check the current user role
	if( ! function_exists( 'current_user_can' ) || ( function_exists( 'current_user_can' ) && ! current_user_can( 'manage_options' ) ) ){
		return false;
	}

	$cache_key        = 'tie-data-'.TIELABS_THEME_SLUG;
	$plugins_field    = 'tie-plugins-data-'.TIELABS_THEME_SLUG;
	$token_key        = 'tie_token_'.TIELABS_THEME_ID;
	$token_error_key  = 'tie_token_error_'.TIELABS_THEME_ID;
	$server_error_key = 'tie_server_error_'.TIELABS_THEME_ID;

	$request_url      = 'https://tielabs.com/wp-json/api/v1/get';

	// Stored Cache
	$cached_data = get_option( $cache_key );

	// Update Plugins Paths
	if( $update_files && ! get_transient( $plugins_field ) ){
		$update = true;
	}

	// Use the given $token and force update the TieLabs data from Envato
	if( $token !== false ){

		$update       = true;
		$force_update = true;
		$update_files = true;

		delete_option( $token_error_key );
		delete_transient( $server_error_key );
	}

	// Revoke the theme
	elseif( $revoke !== false || $force_update !== false ){

		$token = get_option( $token_key );

		// --
		$update = true;
		delete_option( $token_error_key );
		delete_transient( $server_error_key );
	}

	// Get data by the stored token
	else{

		// No cached data
		if( empty( $cached_data ) ){
			$update = true;
		}

		// Check if cache is expired
		else{
			$timeout = get_option( $cache_key.'_timeout' );

			 if ( false === $timeout || ( false !== $timeout && $timeout < time() ) ) {
				$update = true;
			}
		}

		// API Token
		$token = get_option( $token_key );
	}

	// debug
	//$update = true;
	//delete_transient( $server_error_key );
	//delete_option( $token_error_key );

	// We need to update the data, Get the Cached data
	if( isset( $update ) && ! empty( $token ) && ! get_option( $token_error_key ) && ! get_transient( $server_error_key ) ){

		$body = array(
			'tie_token'      => $token,
			'item_id'        => TIELABS_THEME_ID,
			'force_update'   => $force_update,
			'update_files'   => $update_files,
			'revoke_theme'   => $revoke,
			'theme_version'  => TIELABS_DB_VERSION,
			'blog_url'       => esc_url( home_url( '/' ) ),
			'php_version'    => phpversion(),
			'local'          => get_locale(),
			'wp_version'     => get_bloginfo( 'version' ),
			'demo_installed' => get_option( 'tie_installed_demo_'. TIELABS_THEME_ID ),
			'is_switched'    => get_option( 'tie_switch_to_'. TIELABS_THEME_ID ),
			'active_plugins' => get_option( 'active_plugins' ),
		);

		// Social
		if( function_exists( 'arq_counters_data' ) ) {
			$arq_counters = arq_counters_data();
		}
		elseif( class_exists( 'ARQAM_LITE_COUNTERS' ) ) {
			$counters = new ARQAM_LITE_COUNTERS();
			$arq_counters = $counters->counters_data();
		}

		if( ! empty( $arq_counters ) && is_array( $arq_counters ) ){

			unset( $arq_counters['rss'] );
			unset( $arq_counters['posts'] );
			unset( $arq_counters['comments'] );
			unset( $arq_counters['members'] );
			unset( $arq_counters['groups'] );
			unset( $arq_counters['forums'] );
			unset( $arq_counters['topics'] );
			unset( $arq_counters['replies'] );

			foreach ( $arq_counters as $social_key => $values ) {
				unset( $arq_counters[ $social_key ]['text'] );
				unset( $arq_counters[ $social_key ]['icon'] );
			}

			if( ! empty( $arq_counters ) && is_array( $arq_counters ) ){
				$body['social'] = $arq_counters;
			}
		}
		else{

			$social = tie_get_option( 'social' );
			if( ! empty( $social ) && is_array( $social ) ){
				$body['social'] = $social;
			}
		}

		// Prepare the remote post
		$response = wp_remote_post( $request_url, array(
			'headers' => array(
				'User-Agent' => 'wp/' . get_bloginfo( 'version' ) . ' ; ' . get_bloginfo( 'url' ) . ' ; ' . TIELABS_THEME_ID . ' ; ' . TIELABS_DB_VERSION . ' ; '. md5( $token ). ' ; '. $key,
			),
			'body' => apply_filters( 'TieLabs/api_connect_body', $body ),
			//'sslverify' => false,
			'timeout'   => 15,
		));

		// Check Response for errors
		$response_code    = wp_remote_retrieve_response_code( $response );
		$response_message = wp_remote_retrieve_response_message( $response );

		if ( is_wp_error( $response ) ){
			$is_error = true;
			$response_message = $response->get_error_message();
		}
		elseif ( ! empty( $response->errors ) && isset( $response->errors['http_request_failed'] ) ) {
			$is_error = true;
			$response_message = esc_html( current( $response->errors['http_request_failed'] ) );
		}
		elseif ( 200 !== $response_code ){
			$is_error = true;

			if( empty( $response_message ) ) {
				$response_message = 'Connection Error';
			}
		}

		// Check if it is a valid response
		if ( isset( $is_error ) ){
			tie_debug_log( $response_message, true );
			set_transient( $server_error_key, $response_message, 12 * HOUR_IN_SECONDS );
		}
		else{

			$cached_data = wp_remote_retrieve_body( $response );
			$cached_data = json_decode( $cached_data, true );

			//echo '<pre>';
			//var_dump( $cached_data );
			//echo '</pre>';

			if( ! empty( $cached_data['status'] ) && $cached_data['status'] == 1 ){

				// Delete Stored Errors
				delete_option( $token_error_key );

				// Update Cached data
				$cache_period = ( ! empty( $cached_data['cache_period'] ) && is_numeric( $cached_data['cache_period'] ) ) ? (int) $cached_data['cache_period'] : 24;
				$cache_period = ( is_integer( $cache_period ) && $cache_period > 4 ) ? $cache_period : 24;
				$expiration   = $cache_period * HOUR_IN_SECONDS;

				update_option( $cache_key .'_timeout', time() + $expiration );
				update_option( $cache_key, $cached_data, false );
				update_option( $token_key, $token, false );

				if( $update_files ){
					set_transient( $plugins_field, 'true', $expiration );
				}
				else{
					delete_transient( $plugins_field ); // to re-fresh the Plugins stored cache
				}

				// Use this action to run functions after updating the theme data
			  do_action( 'TieLabs/after_theme_data_update' );
			}
			else{

				if( isset( $cached_data['status'] ) && $cached_data['status'] == 0 ){
					update_option( $token_error_key, $cached_data['error'], false );

					delete_option( $token_key );
					delete_option( $cache_key );
				}
			}
		}

	}

	// Return the data
	if( empty( $cached_data ) ){
		return false;
	}

	if( ! empty( $key ) ){
		if( ! empty( $cached_data[ $key ] ) ){
			return $cached_data[ $key ];
		}

		return false;
	}

	return $cached_data;
}


/*-----------------------------------------------------------------------------------*/
# Check if the theme is't rated or have a low rate
/*-----------------------------------------------------------------------------------*/
function tie_is_theme_rated(){

	$the_rate = tie_get_latest_theme_data( 'rating' );

	if( empty( $the_rate ) || $the_rate < 4 ){

		return false;
	}

	return true;
}


/*-----------------------------------------------------------------------------------*/
# Move the custom theme Mods to the Child theme
/*-----------------------------------------------------------------------------------*/
add_action( 'after_switch_theme', 'tie_switch_theme_update_mods' );
function tie_switch_theme_update_mods() {

	if ( is_child_theme() ) {

		$mods = get_option( 'theme_mods_' . get_option( 'template' ) );

		if ( false !== $mods ) {
			foreach ( (array) $mods as $mod => $value ) {
				set_theme_mod( $mod, $value );
			}
		}
	}

}


/*-----------------------------------------------------------------------------------*/
# Prune the WP Super Cache.
/*-----------------------------------------------------------------------------------*/
add_action( 'TieLabs/Options/updated', 'tie_clear_super_cache' );
function tie_clear_super_cache() {

	if ( function_exists( 'prune_super_cache' ) ) {
		global $cache_path;

		prune_super_cache( $cache_path . 'supercache/', true );
		prune_super_cache( $cache_path, true );
	}
}


/*-----------------------------------------------------------------------------------*/
# Changing the base and the ID of the theme options page to Widgets!!!!
# We use this method to force the plugins to load their JS files so we be able
# to store them every time the user access the theme options page to be used later
# in the Page builder.
#
# Added: tiebase: so we can check if this is the theme options page.
/*-----------------------------------------------------------------------------------*/
add_action( 'load-toplevel_page_tie-theme-options',         'tie_theme_pages_screen_data', 99 );
add_action( 'load-tietheme_page_tie-theme-welcome',         'tie_theme_pages_screen_data', 99 );
add_action( 'load-tietheme_page_tie-system-status',         'tie_theme_pages_screen_data', 99 );
add_action( 'load-tietheme_page_tie-one-click-demo-import', 'tie_theme_pages_screen_data', 99 );
function tie_theme_pages_screen_data() {
	global $current_screen;

	$current_screen->base    = 'widgets';
	$current_screen->id      = 'widgets';
	$current_screen->tiebase = str_replace( 'load-', '', current_filter() );
}


/*-----------------------------------------------------------------------------------*/
# Welcome Page ARGS
/*-----------------------------------------------------------------------------------*/
add_filter( 'TieLabs/welcome_args', 'tie_welcome_args' );
function tie_welcome_args( $args ){

	$args['color'] = apply_filters( 'TieLabs/default_theme_color', '#000' );
	$args['img']   = TIELABS_TEMPLATE_URL .'/framework/admin/assets/images/tielabs-logo-mini.png';
	$args['about'] = sprintf( esc_html__( 'You are awesome! Thanks for using our theme, %s is now installed and ready to use! Get ready to build something beautiful :)', TIELABS_TEXTDOMAIN ), apply_filters( 'TieLabs/theme_name', 'TieLabs' ) );

	return $args;
}


/*-----------------------------------------------------------------------------------*/
# Welcome Page contents
/*-----------------------------------------------------------------------------------*/
add_filter( 'TieLabs/welcome_splash_content', 'tie_welcome_splash_content' );
function tie_welcome_splash_content(){
	?>

	<h2><?php printf( esc_html__( 'Need help? We\'re here %s', TIELABS_TEXTDOMAIN ), '&#x1F60A' ); ?></h2>

	<div class="under-the-hood">
		<div class="col column">
			<p><?php printf( wp_kses_post( 'The Theme comes with 6 months of free support for every license you purchase. Support can be <a target="_blank" href="%1s">extended through subscriptions via ThemeForest</a>. All support is handled through our <a target="_blank" href="%2s">support center</a>. Below are all the resources we offer in our support center.', TIELABS_TEXTDOMAIN ), apply_filters( 'TieLabs/External/renew_support_article', '' ), apply_filters( 'TieLabs/External/support_center', '' ) ); ?></p>
		</div>
	</div>

	<div class="has-3-columns is-fullwidth">
		<div class="col column tie-info-col">
			<h3><span class="dashicons dashicons-sos"></span> <?php esc_html_e( 'Submit a Ticket', TIELABS_TEXTDOMAIN ); ?></h3>
			<p><?php esc_html_e( 'Need one-to-one assistance? Get in touch with our Support team.', TIELABS_TEXTDOMAIN ); ?></p>

			<?php

				if( get_option( 'tie_token_'.TIELABS_THEME_ID ) ){

					$support_info = tie_get_support_period_info();

					if( ! empty( $support_info['status'] ) && $support_info['status'] == 'expired' ){
						echo '<p style="font-weight:bold; color: red;">'. esc_html__( 'Your Support Period Has Expired', TIELABS_TEXTDOMAIN ) .'</p>';
					}
					else{
						?>
							<a target="_blank" class="button button-primary button-hero" href="<?php echo apply_filters( 'TieLabs/External/open_ticket', '' ); ?>"><?php esc_html_e( 'Submit a Ticket', TIELABS_TEXTDOMAIN ); ?></a>
						<?php
					}
				}
				else{

					echo '<p style="font-weight:bold; color: red;">'. esc_html__( 'You need to validate your license to access the support system.', TIELABS_TEXTDOMAIN ) .'</p>';
				}

			?>
		</div>

		<div class="col column tie-info-col">
			<h3><span class="dashicons dashicons-book"></span> <?php esc_html_e( 'Knowledge Base', TIELABS_TEXTDOMAIN ); ?></h3>
			<p><?php esc_html_e( 'This is the place to go to reference different aspects of the theme.', TIELABS_TEXTDOMAIN ); ?></p>
			<a target="_blank" class="button button-primary button-hero" href="<?php echo apply_filters( 'TieLabs/External/knowledge_base', '' ); ?>"><?php esc_html_e( 'Browse the Knowledge Base', TIELABS_TEXTDOMAIN ); ?></a>
		</div>

		<div class="col column tie-info-col">
			<h3><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'Troubleshooting', TIELABS_TEXTDOMAIN ); ?></h3>
			<p><?php esc_html_e( 'If something is not working as expected, Please try these common solutions.', TIELABS_TEXTDOMAIN ); ?></p>
			<a target="_blank" class="button button-primary button-hero" href="<?php echo apply_filters( 'TieLabs/External/troubleshooting', '' ); ?>"><?php esc_html_e( 'Visit The Page', TIELABS_TEXTDOMAIN ); ?></a>
		</div>
	</div>

	<hr />

	<ul id="follow-tielabs" class="column">
		<li class="follow-tielabs-fb">
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=280065775530401";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-like" data-href="https://facebook.com/tielabs" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
		</li>

		<li class="follow-tielabs-twitter">
			<a href="https://twitter.com/tielabs" class="twitter-follow-button" data-size="large" data-show-count="false">Follow @tielabs</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
			<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		</li>
	</ul>

	<?php
}


/**
 * Get the theme's support period info
 */
function tie_get_support_period_info(){

	$support_info    = array();
	$today_date      = time();
	$supported_until = tie_get_latest_theme_data( 'supported_until' );
	$supported_until = strtotime( $supported_until );
	$support_time    = date( 'F j, Y', $supported_until );

	// The support is active
	if( $supported_until >= $today_date ){

		$support_info['status'] = 'active';

		// Check if it less than 2 months
		$diff = (int) abs( $supported_until - $today_date );

		if( $diff < 2 * MONTH_IN_SECONDS ){
			$support_info['expiring'] = true;
		}

		// Get the date and the remaning period
		$support_time .= ' ('. human_time_diff( $supported_until ) .')';

		$support_info['human_date'] = $support_time;
	}

	// Opps it is expired
	else{
		$support_info['status'] = 'expired';
	}

	return $support_info;
}
