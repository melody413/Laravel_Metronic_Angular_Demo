<?php
/**
 * Theme External Links
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_EXTERNAL_LINKS' ) ) {

	class TIELABS_EXTERNAL_LINKS{

		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			add_action( 'TieLabs/admin_after_tab_title',  array( $this, 'help_icons' ), 10, 1 );
			add_action( 'TieLabs/admin_after_head_title', array( $this, 'help_icons' ), 10, 1 );

			add_filter( 'arqam_lite_docs_url', array( $this, 'arqam_lite' )); // Arqam Lite documentation url
			add_filter( 'tie_extensions_shortcodes_docs_url', array( $this, 'extensions_shortcodes' )); // Shortcodes documentation url

			add_filter( 'TieLabs/External/hosting',               array( $this, 'get_hosting' ));
			add_filter( 'TieLabs/External/support_center',        array( $this, 'support_center' ));
			add_filter( 'TieLabs/External/update_manually',       array( $this, 'update_manually' ));
			add_filter( 'TieLabs/External/theme_footer',          array( $this, 'theme_footer' ));
			add_filter( 'TieLabs/External/knowledge_base',        array( $this, 'knowledge_base' ));
			add_filter( 'TieLabs/External/troubleshooting',       array( $this, 'troubleshooting' ));
			add_filter( 'TieLabs/External/max_input_vars',        array( $this, 'max_input_vars' ));
			add_filter( 'TieLabs/External/licenses_article',      array( $this, 'licenses_article' ));
			add_filter( 'TieLabs/External/renew_support_article', array( $this, 'renew_support_article' ));
			add_filter( 'TieLabs/External/open_ticket',           array( $this, 'open_ticket' ));
			add_filter( 'TieLabs/External/share_idea',            array( $this, 'share_idea' ));
			add_filter( 'TieLabs/External/portfolio',             array( $this, 'portfolio' ));
			add_filter( 'TieLabs/External/foxpush',               array( $this, 'foxpush' ));
			add_filter( 'TieLabs/External/changelog',             array( $this, 'changelog' ));
			add_filter( 'TieLabs/translations_panel_url',         array( $this, 'translations_panel_url' ));
		}


		/**
		 * External Links
		 *
		 */
		function get_hosting( $url ){
			return esc_url( 'https://tielabs.com/wordpress-hosting/' );
		}

		function support_center( $url ){
			return esc_url( 'https://tielabs.com/help/' );
		}

		function update_manually( $url ){
			return esc_url( 'https://jannah.helpscoutdocs.com/article/169-how-do-i-manually-update-the-theme-to-the-newer-version' );
		}

		function theme_footer( $url ){
			return esc_url( 'https://tielabs.com/go/jannah-sites-footer' );
		}

		function knowledge_base( $url ){
			return esc_url( 'https://jannah.helpscoutdocs.com/' );
		}

		function troubleshooting( $url ){
			return esc_url( 'https://tielabs.com/help/troubleshooting/' );
		}

		function max_input_vars( $url ){
			return esc_url( 'https://tielabs.com/go/jannah-increase-php-max-input-vars' );
		}

		function licenses_article( $url ){
			return esc_url( 'https://jannah.helpscoutdocs.com/article/188-theme-licenses-and-activation' );
		}

		function renew_support_article( $url ){
			return esc_url( 'https://jannah.helpscoutdocs.com/article/190-extending-and-renewing-envato-item-support' );
		}

		function open_ticket( $url ){
			return esc_url( 'https://tielabs.com/members/open-new-ticket/' );
		}

		function share_idea( $url ){
			return esc_url( 'https://tielabs.com/ideas-categories/jannah-wordpress-theme-ideas/' );
		}

		function portfolio( $url ){
			return esc_url( 'https://tielabs.com/buy/portfolio-envato-1' );
		}

		function foxpush( $url ){
			return esc_url( 'https://tielabs.com/go/foxpush-jannah' );
		}

		function changelog( $url ){
			return esc_url( 'https://tielabs.com/changelogs/?id='. TIELABS_THEME_ID );
		}

		function arqam_lite( $url ) {
			return esc_url( 'https://jannah.helpscoutdocs.com/category/168-arqam-social-counter' );
		}

		function extensions_shortcodes( $url ) {
			return esc_url( 'https://jannah.helpscoutdocs.com/article/128-shortcodes' );
		}


		function translations_panel_url( $url ) {
			return esc_url( 'https://tielabs.oneskyapp.com/collaboration/project/304436' );
		}


		/**
		 * help_icons
		 *
		 * Add help icon with the documentation URLs
		 */
		function help_icons( $id = false ){

			if( tie_get_option( 'white_label_help_links' ) ){
				return;
			}

			$options = array(

		 		// General Settings
		 		'general-settings-tab' => '67-general-settings',
		 		'time-format-settings' => '67-general-settings#time-format',
		 		'breadcrumbs-settings' => '67-general-settings#breadcrumb',
		 		'trim-text-settings'   => '67-general-settings#trim-text-settings',
		 		'post-font-icon'       => '67-general-settings#post-format-icon-on-hover',

				// Layout
		 		'layout-tab' => '68-layout-settings',

				// Header Settings
				'header-layout'       => '65-header-options#header-layouts',
				'main-nav-components' => '175-mian-nav-settings#mian-nav-components',
				'sticky-menu'         => '175-mian-nav-settings#sticky-menu',
				'top-nav-components'  => '174-secondary-nav-settings#secondary-nav-components',
				'breaking_news_head'  => '174-secondary-nav-settings#breaking-news',

				// Logo Settings
		 		'logo-settings-section' => '69-logo-settings',
		 		'set-favicon-section'   => '118-how-to-add-a-favicon-to-your-wordpress-blog',

				// Footer Settings
		 		'footer-settings-tab'  => '33-footer-settings',
		 		'instagram-footer-area'=> '33-footer-settings#setting-up-the-instagram-footer-area',
		 		'footer-widgets-layout'=> '33-footer-settings#how-to-add-widgets-to-the-footer',
		 		'copyright-area'       => '33-footer-settings#copyright-area',
		 		'back-to-top-button'   => '33-footer-settings#back-to-top-button',

		 		// Archives
		 		'archives-settings-tab'            => '70-archives-settings',
		 		'archives-default-layout-settings' => '70-archives-settings#default-layout-settings',

				// Single Post Page
				'single-post-page-settings-tab' => '71-single-post-page',
				'default-posts-layout'          => '71-single-post-page#default-posts-layout',
				'structure-data'                => '71-single-post-page#structure-data',
				'post-general-settings'         => '71-single-post-page#general-settings',
				'post-info-settings'            => '71-single-post-page#post-info-settings',
				'post-newsletter'               => '71-single-post-page#newsletter',
				'related-posts'                 => '71-single-post-page#related-posts',
				'fly-check-also-box'            => '71-single-post-page#fly-check-also-box',

		 		// Post Views System
		 		'post-views-tab'      => '170-post-views-settings',
		 		'post-views-settings' => '170-post-views-settings#post-views-settings',

		 		// Share Settings
		 		'share-settings-tab'     => '72-share-buttons',
		 		'share-general-settings' => '72-share-buttons#general-settings',
		 		'above-post-share'       => '72-share-buttons#above-post-share-buttons',
		 		'select-and-share'       => '72-share-buttons#select-and-share',

		 		// Sidebars Settings
		 		'sidebars-settings-tab' => '73-sidebars-settings',

		 		// Lightbox Settings
		 		'lightbox-settings-tab' => '74-lightbox-settings',

		 		// Advertisement Settings
		 		'advertisements-settings-tab' => '75-advertisement-settings',
		 		'ad-blocker-detector'         => '75-advertisement-settings#ad-blocker-detector',
		 		'background-image-ad'         => '75-advertisement-settings#background-image-ad',
		 		'banner_top-ad'               => '75-advertisement-settings#header-e3lan',
		 		'shortcodes-ads'              => '75-advertisement-settings#shortcodes-a3lans',

				// Background
		 		'background-tab'      => '76-site-background-settings',
		 		'background-settings' => '76-site-background-settings',

		 		// Styling Settings
		 		'styling-tab'           => '77-styling-settings',
		 		'styling-settings'      => '77-styling-settings',
		 		'custom-body-classes'   => '77-styling-settings#custom-body-classes',
		 		'primary-color'         => '77-styling-settings#primary-color',
		 		'body-styling'          => '77-styling-settings#body',
		 		'secondary-nav-styling' => '77-styling-settings#secondary-nav',
		 		'header-styling'        => '77-styling-settings#header',
		 		'main-nav-styling'      => '77-styling-settings#main-nav-styling',
		 		'main-content-styling'  => '77-styling-settings#main-content-styling',
		 		'footer-styling'        => '77-styling-settings#footer-copyright-area',
		 		'copyright-area-styling'=> '77-styling-settings#footer-copyright-area',
		 		'mobile-menu-styling'   => '77-styling-settings#mobile-menu',
		 		'custom-css'            => '77-styling-settings#custom-css',

		 		// Typography Settings
		 		'typorgraphy-settings-tab'            => '78-typography-settings',
		 		'google-web-font-character-sets'      => '78-typography-settings#google-web-font-character-sets',
		 		'font-sizes-weights-and-line-heights' => '78-typography-settings#font-sizes-weights-and-line-heights',

				// Translations Settings
		 		'translations-settings-tab' => '79-translations-settings',

				// Social Networks
		 		'social-networks-tab'  => '80-social-networks',
		 		'social-networks'      => '80-social-networks#social-networks',
		 		'custom-social-network-1'=> '80-social-networks#custom-social-networks',
		 		'custom-social-network-2'=> '80-social-networks#custom-social-networks',
		 		'custom-social-network-3'=> '80-social-networks#custom-social-networks',
		 		'custom-social-network-4'=> '80-social-networks#custom-social-networks',
		 		'custom-social-network-5'=> '80-social-networks#custom-social-networks',

		 		// Mobile Settings
		 		'mobile-settings-tab'    => '81-mobile-settings',
		 		'mobile-settings'        => '81-mobile-settings#mobile-settings',
		 		'mobile-menu'            => '81-mobile-settings#mobile-menu',
		 		'mobile-single-post-page'=> '81-mobile-settings#single-post-page',
		 		'mobile-elements'        => '81-mobile-settings#mobile-elements',
		 		'sticky-mobile-share'    => '81-mobile-settings#sticky-mobile-share-buttons',

		 		// AMP
		 		'accelerated-mobile-pages-tab' => '83-amp-accelerated-mobile-pages',
		 		'accelerated-mobile-pages'     => '83-amp-accelerated-mobile-pages#accelerated-mobile-pages',
		 		'amp-logo'                     => '83-amp-accelerated-mobile-pages#logo',
		 		'amp-post-settings'            => '83-amp-accelerated-mobile-pages#post-settings',
		 		'amp-footer-settings'          => '83-amp-accelerated-mobile-pages#footer-settings',
		 		'amp-advertisement'            => '83-amp-accelerated-mobile-pages#advertisement',
		 		'amp-styling'                  => '83-amp-accelerated-mobile-pages#styling',

		 		// Web Notifications
		 		'web-notifications-tab'     => '84-web-notifications-settings',

		 		// Advanced
		 		'advanced-settings-tab'     => '85-advanced-settings',
		 		'advanced-settings'         => '85-advanced-settings#advanced-settings',
		 		'wordpress-login-page-logo' => '85-advanced-settings#wordpress-login-page-logo',
		 		'reset-all-settings'        => '85-advanced-settings#reset-all-settings',

		 		// Woocommerce
		 		'woocommerce-tab'     => '86-woocommerce-settings',

				// bbPress
				'bbpress-tab' => '87-bbpress-settings',

				// buddypress
				'buddypress-tab' => '176-buddypress-settings',

				//
				'google-maps-api-key' => '210-how-to-get-google-maps-api-key',
				'youtube-api-key'     => '209-how-to-get-youtube-api-key',
				'weather-api-key'     => '47-how-to-setup-the-weather-widget',

				//
				'speed-optimization-tab' => '211-jannah-speed-optimization-plugin-settings',

			);

			add_thickbox();

			$docs_url = 'https://jannah.helpscoutdocs.com/article/';

			if( ! empty( $id ) && ! empty( $options[ $id ] ) ){
				echo '<a href="'. esc_url( $docs_url . $options[ $id ] ) .'?tiedocs=true&TB_iframe=true&width=650&height=750" id="help-icon-'. $id .'" class="docs-link thickbox" target="_blank" rel="nofollow noopener" title="'. esc_html__( 'Need Help?', TIELABS_TEXTDOMAIN ) .'"><span class="dashicons dashicons-editor-help"></span></a>';
			}

			return false;
		}


	}

	# Instantiate the class
	new TIELABS_EXTERNAL_LINKS();

}
