<?php
/**
 * Theme Custom Styles
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


/*
 * Setup Theme
 */
add_action( 'after_setup_theme', 'jannah_theme_setup' );
function jannah_theme_setup(){

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Switch default core markup for comment form, and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-list',
		'comment-form',
		'search-form',
		'gallery',
		'caption'
	) );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( TIELABS_THEME_SLUG.'-image-small', 220, 150, true );
	add_image_size( TIELABS_THEME_SLUG.'-image-large', 390, 220, true );
	add_image_size( TIELABS_THEME_SLUG.'-image-post',  780, 470, true );

	// Add Support for the Arqam Lite plugin.
	add_theme_support( 'Arqam_Lite' );

	// Gutenberg
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
	 */
	if( ! tie_get_option( 'disable_editor_styles' ) && is_admin() ){
		add_editor_style( 'assets/css/editor-style.css' );
	}

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( TIELABS_TEXTDOMAIN, TIELABS_TEMPLATE_PATH . '/languages' );

	// The theme uses wp_nav_menu() in multiple locations.
	register_nav_menus( array(
		'top-menu'    => esc_html__( '​Secondary Nav Menu', TIELABS_TEXTDOMAIN ),
		'primary'     => esc_html__( 'Main Nav Menu',     TIELABS_TEXTDOMAIN ),
		'404-menu'    => esc_html__( '404 Page menu',     TIELABS_TEXTDOMAIN ),
		'footer-menu' => esc_html__( 'Footer Navigation', TIELABS_TEXTDOMAIN ),
	));

}


/**
 * Enqueue IE Scripts and Styles
 */
add_action( 'wp_enqueue_scripts', 'jannah_enqueue_IE_assets' );
function jannah_enqueue_IE_assets(){

	global $is_IE;

	if( ! $is_IE ){
		return;
	}

	preg_match( '/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches );

	if( empty( $matches ) ){
		return;
	}

	if( is_array( $matches ) && count( $matches ) < 2 ){
		preg_match( '/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches );
	}

	$version = $matches[1];

	// IE 10 && IE 11
	if( $version <= 11 ){
		wp_enqueue_style( 'tie-css-ie-11', TIELABS_TEMPLATE_URL .'/assets/css/ie/ie-lte-11.css', array(), TIELABS_DB_VERSION );
		wp_enqueue_script( 'tie-js-ie',    TIELABS_TEMPLATE_URL . '/assets/js/ie.js', array( 'jquery' ), TIELABS_DB_VERSION, true );
	}

	// IE 10
	if ( $version == 10 ) {
		wp_enqueue_style( 'tie-css-ie-10-only', TIELABS_TEMPLATE_URL.'/assets/css/ie/ie-10.css', array(), TIELABS_DB_VERSION );
	}
	// < IE 10
	elseif ( $version < 10 ) {
		wp_enqueue_style( 'tie-css-ie-10', TIELABS_TEMPLATE_URL.'/assets/css/ie/ie-lt-10.css', array(), TIELABS_DB_VERSION );
	}
}


/*
 * Register Main Scripts and Styles
 */
add_action( 'wp_enqueue_scripts', 'jannah_register_assets', 20 );
function jannah_register_assets(){

	//$ver = current_user_can( 'switch_themes' ) ? time() : TIELABS_DB_VERSION; // Always avoid browser cache for admins
	$ver = apply_filters( 'TieLabs/enqueue_scripts/version', TIELABS_DB_VERSION );
	$min = TIELABS_STYLES::is_minified();

	/**
	 * Scripts
	 */

	/*
	 * Main Scripts file
	 */
	wp_register_script( 'tie-scripts', TIELABS_TEMPLATE_URL . '/assets/js/scripts'. $min .'.js', array( 'jquery' ), $ver, true );

	/*
	 * Scripts requrie tie-scripts
	 */
	// Sliders
	wp_register_script( 'tie-js-sliders', TIELABS_TEMPLATE_URL . '/assets/js/sliders'. $min .'.js', array( 'jquery', 'tie-scripts' ), $ver, true );
	// Desktop only JS
	wp_register_script( 'tie-js-desktop', TIELABS_TEMPLATE_URL . '/assets/js/desktop'. $min .'.js', array( 'jquery', 'tie-scripts' ), $ver, true );
	// single
	wp_register_script( 'tie-js-single', TIELABS_TEMPLATE_URL . '/assets/js/single'. $min .'.js',  array( 'jquery', 'tie-scripts' ), $ver, true );
	// ViewPort
	wp_register_script( 'tie-js-viewport', TIELABS_TEMPLATE_URL . '/assets/js/viewport-scripts.js',  array( 'jquery', 'tie-scripts' ), $ver, true );

	// Breaking News
	wp_register_script( 'tie-js-breaking', TIELABS_TEMPLATE_URL . '/assets/js/br-news.js', array( 'jquery' ), $ver, true );
	// Live Search
	wp_register_script( 'tie-js-livesearch', TIELABS_TEMPLATE_URL . '/assets/js/live-search.js', array( 'jquery' ), $ver, true );
	// iLightBox
	wp_register_script( 'tie-js-ilightbox', TIELABS_TEMPLATE_URL . '/assets/ilightbox/lightbox.js', array( 'jquery' ), $ver, true );
	// Videos Playlist
	wp_register_script( 'tie-js-videoslist', TIELABS_TEMPLATE_URL . '/assets/js/videos-playlist.js', array( 'jquery' ), $ver, true );
	// Velocity
	wp_register_script( 'tie-js-velocity', TIELABS_TEMPLATE_URL . '/assets/js/velocity.js', array( 'jquery' ), $ver, true );

	// Parallax
	wp_register_script( 'tie-js-parallax', TIELABS_TEMPLATE_URL . '/assets/js/parallax.js', array( 'jquery', 'imagesloaded' ), $ver, true );


	/**
	 * Styles
	 */
	// base.css file
	wp_register_style( 'tie-css-base', TIELABS_TEMPLATE_URL . '/assets/css/base'. $min .'.css', array(), $ver );

	// Main style.css file
	wp_register_style( 'tie-css-styles', TIELABS_TEMPLATE_URL . '/assets/css/style'. $min .'.css', array(), $ver );

	// Single Post CSS file
	wp_register_style( 'tie-css-single', TIELABS_TEMPLATE_URL . '/assets/css/single'. $min .'.css', array(), $ver );

	// Widgets
	wp_register_style( 'tie-css-widgets', TIELABS_TEMPLATE_URL . '/assets/css/widgets'. $min .'.css', array(), $ver );

	// Widgets
	wp_register_style( 'tie-css-helpers', TIELABS_TEMPLATE_URL . '/assets/css/helpers'. $min .'.css', array(), $ver );

	// Font Awesome 5.0
	wp_register_style( 'tie-fontawesome5', TIELABS_TEMPLATE_URL . '/assets/css/fontawesome.css', array(), $ver );

	// Print
	wp_register_style( 'tie-css-print', TIELABS_TEMPLATE_URL . '/assets/css/print.css', array(), $ver, 'print' );

	// LightBox
	wp_register_style( 'tie-css-ilightbox', TIELABS_TEMPLATE_URL . '/assets/ilightbox/'. tie_get_option( 'lightbox_skin', 'dark' ) .'-skin/skin.css', array(), $ver );

	// Mp-Timetable css file
	if ( TIELABS_MPTIMETABLE_IS_ACTIVE ){
		wp_enqueue_style( 'tie-css-mptt', TIELABS_TEMPLATE_URL.'/assets/css/plugins/mptt'. $min .'.css', array(), $ver );
	}

	// Shortcodes
	if( TIELABS_EXTENSIONS_IS_ACTIVE ){
		wp_register_style( 'tie-css-shortcodes', TIELABS_TEMPLATE_URL . '/assets/css/plugins/shortcodes'. $min .'.css', array(), $ver );
		wp_register_script('tie-js-shortcodes',  TIELABS_TEMPLATE_URL . '/assets/js/shortcodes.js', array( 'tie-js-sliders' ), $ver, true );
	}

	// Prevent TieLabs shortcodes plugin from loading its JS and CSS files
	add_filter( 'tie_plugin_shortcodes_enqueue_assets', '__return_false' );
}


/*
 * Enqueue Main Scripts
 */
add_action( 'wp_enqueue_scripts', 'jannah_enqueue_scripts', 20 );
function jannah_enqueue_scripts(){

	// Scripts
	wp_enqueue_script( 'tie-scripts' );

	// LightBox
	wp_enqueue_script( 'tie-js-ilightbox' );

	// Shortcodes
	if( TIELABS_EXTENSIONS_IS_ACTIVE ){
		wp_enqueue_script( 'tie-js-shortcodes' );
	}

	// Desktop only scripts
	if( ! tie_is_mobile() ){

		wp_enqueue_script( 'tie-js-desktop' );

		// Live search
		if( tie_menu_has_search( 'top_nav', true ) || tie_menu_has_search( 'main_nav', true ) ){
			wp_enqueue_script( 'tie-js-livesearch' );
		}
	}

	// Mobile
	// else{ // Always load the file even on desktop
		if( tie_get_option( 'mobile_header_components_search') && tie_get_option( 'mobile_header_live_search') ){
			wp_enqueue_script( 'tie-js-livesearch' );
		}
	//}

	// Single pages with no builder
	if( is_singular() && ! TIELABS_HELPER::has_builder() ){

		// Single.js
		wp_enqueue_script( 'tie-js-single' );

		// Queue Comments reply js
		if ( comments_open() && get_option('thread_comments') ){
			wp_enqueue_script( 'comment-reply' );
		}
	}
}


/*
 * Enqueue Styles
 */
add_action( 'wp_enqueue_scripts', 'jannah_enqueue_styles', 20 );
function jannah_enqueue_styles(){

	wp_enqueue_style( 'tie-css-base' );
	wp_enqueue_style( 'tie-css-styles' );
	wp_enqueue_style( 'tie-css-widgets' );
	wp_enqueue_style( 'tie-css-helpers' );
	wp_enqueue_style( 'tie-fontawesome5' );
	wp_enqueue_style( 'tie-css-ilightbox' );

	if( TIELABS_EXTENSIONS_IS_ACTIVE ){
		wp_enqueue_style( 'tie-css-shortcodes' );
	}

	// Single pages with no builder
	if( ( is_singular() && ! TIELABS_HELPER::has_builder() ) || ( TIELABS_BBPRESS_IS_ACTIVE && is_bbpress() ) ){

		// Single page styling
		wp_enqueue_style( 'tie-css-single' );

		// Print File
		wp_enqueue_style( 'tie-css-print' );
	}
}


/**
 * Demos
 */
 add_filter( 'TieLabs/Demo_Importer/demos_data', 'jannah_demo_importer_data' );
 function jannah_demo_importer_data( $demos_data = false ){

 	if( ! empty( $demos_data ) || get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
 		return $demos_data;
 	}

 	// --
	$demos = array(
		'demo'           => 'Main Demo',
		'tech'           => 'Tech',
		'sport'          => 'Sport',
		'auto'           => 'Auto',
		'creative'       => 'Creative',
		'foods'          => 'Recipes & Tips',
		'times'          => 'Times',
		'photography'    => 'Photography',
		'hotels'         => 'Hotels',
		'health'         => 'Health',
		'house'          => 'House',
		'videos'         => 'Videos',
		'videos-2'       => 'Videos 2',
		'pets'           => 'Pets',
		'travel'         => 'Travel',
		'traveling'      => 'Traveling',
		'science'        => 'Science',
		'blog'           => 'Personal Blog',
		'minimal-blog'   => 'Minimal Blog',
		'city'           => 'City',
		'school'         => 'school',
		'games'          => 'Games',
		'geo'            => 'Geo',
		'cryptocurrency' => 'Cryptocurrency',
		'salad-dash'     => 'Salad Dash',
		'fitness'        => 'Fitness',
	);

	$demos_data = array();

	foreach ( $demos as $slug => $name ) {
		$demos_data[] = array(
			'name' => $name,
			'url'      => 'https://jannah.tielabs.com/'.$slug,
			'img'      => TIELABS_TEMPLATE_URL ."/framework/admin/assets/images/demos-thumbnails/$slug.jpg",
			'desc'     => '',
			'xml'      => '-',
			'settings' => '-',
		);
	}

	return $demos_data;
 }


/**
 * Plugins
 */
 add_filter( 'TieLabs/Plugins_Installer/data', 'jannah_plugins_installer_data' );
 function jannah_plugins_installer_data( $plugins_data = false ){

 	if( ! empty( $plugins_data ) || get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
 		return $plugins_data;
 	}

	return array(
		'taqyeem' => array(
			'name'   => 'Taqyeem',
			'slug'   => 'taqyeem-tie_sample',
			'source' => '-',
		),
		'jannah-extensions' => array(
			'name'   => 'Jannah Extensions',
			'slug'   => 'jannah-extensions-tie_sample',
			'source' => '-',
		),
		'arqam-lite' => array(
			'name'   => 'Arqam Lite',
			'slug'   => 'arqam-lite-tie_sample',
			'source' => '-',
		),
		'jannah-switcher' => array(
			'name'   => 'Jannah Switcher',
			'slug'   => 'jannah-switcher-tie_sample',
			'source' => '-',
		),
		'jannah-optimization' => array(
			'name'   => 'Jannah Speed Optimization',
			'slug'   => 'jannah-optimization-tie_sample',
			'source' => '-',
		),
		'tielabs-instagram' => array(
			'name'   => 'TieLabs Instagram Feed',
			'slug'   => 'tielabs-instagram-tie_sample',
			'source' => '-',
		),
		'jannah-autoload-posts' => array(
			'name'   => 'Jannah Autoload Posts',
			'slug'   => 'jannah-autoload-posts-tie_sample',
			'source' => '-',
		),
	);

 }
