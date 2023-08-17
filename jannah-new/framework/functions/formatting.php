<?php
/**
 * Formating Functions
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



/**
 * Custom Classes for header
 */
if( ! function_exists( 'tie_header_class' ) ) {

	function tie_header_class( $custom = '' ){

		// Custom Classes defined in the header.php file
		$classes = explode( ' ', $custom );

		// intial Class
		$classes[] = 'theme-header';

		// Header Layout
		$header_layout = tie_get_option( 'header_layout', 3 );
		$classes[] = 'header-layout-'.$header_layout;

		if( $header_layout == 4 ){
			$classes[] = 'header-layout-1';
		}

		// Main Nav Skin
		if( tie_get_option( 'main_nav_dark' ) ){
			$classes['main-nav-skin'] = 'main-nav-dark';
			$classes[] = 'main-nav-default-dark';
		}
		else{
			$classes['main-nav-skin'] = 'main-nav-light';
			$classes[] = 'main-nav-default-light';
		}

		// Main Nav position
		$classes[] = tie_get_option( 'main_nav_position' ) ? 'main-nav-above' : 'main-nav-below';

		// Boxed Layout
		if( tie_get_option( 'main_nav_layout' ) && $header_layout != 1 && $header_layout != 4 ){
			$classes[] = 'main-nav-boxed';
		}

		// Header AD
		if( ! tie_get_option( 'banner_top' ) || TIELABS_HELPER::is_mobile_and_hidden( 'banner_top' ) || ( ! TIELABS_HELPER::has_builder() && tie_get_postdata( 'tie_disable_all_ads' ) ) ) {
			$classes[] = 'no-stream-item';
		}
		else{
			$classes[] = 'has-stream-item';
		}

		// Top Nav classes
		if( tie_get_option( 'top_nav' ) ){

			$classes[] = 'top-nav-active';

			// Top Nav Skin
			if( tie_get_option( 'top_nav_dark' ) ){
				$classes['top-nav-skin'] = 'top-nav-dark';
				$classes[] = 'top-nav-default-dark';
			}
			else{
				$classes['top-nav-skin'] = 'top-nav-light';
				$classes[] = 'top-nav-default-light';
			}

			// Boxed Layout
			$classes[] = tie_get_option( 'top_nav_layout' ) ? 'top-nav-boxed' : '';

			// Check if the top nav is below the header
			$classes[] = tie_get_option( 'top_nav_position' ) ? 'top-nav-below' : 'top-nav-above';
		}

		// Top Nav Below the Main Nav
		if( ! tie_get_option( 'main_nav_position' ) && tie_get_option( 'top_nav' ) && tie_get_option( 'top_nav_position' ) ){
			$classes[] = 'top-nav-below-main-nav';
		}

		// Header Shadow
		$classes[] = tie_get_option( 'header_disable_shadows' ) ? '' : 'has-shadow';

		// Stretch Header
		$classes[] = tie_get_option( 'stretch_header' ) ? 'is-stretch-header' : '';

		// Full Width Logo
		if( $header_layout != 1 && $header_layout != 4 ){
			$classes[] = tie_get_option( 'full_logo' ) ? 'has-full-width-logo mobile-components-row' : 'has-normal-width-logo';
		}
		else{
			$classes[] = 'has-normal-width-logo';
		}

		// Custom Sticky Logo
		if( tie_get_option( 'sticky_logo_type' ) && tie_get_option( 'custom_logo_sticky' ) ){
			$classes[] = 'has-custom-sticky-logo';
		}

		// Mobile Layout Logo
		if( tie_get_option( 'mobile_header' ) ){
			$classes[] = 'mobile-header-'. tie_get_option( 'mobile_header' );
		}

		if( tie_get_option( 'mobile_components_row' ) ){
			$classes[] = 'mobile-components-row';
		}

		// Print the Classes
		echo 'class="'. join( ' ', apply_filters( 'TieLabs/header/classes', array_filter( $classes ) ) ) .'"';
	}
}


/**
 * Get the Custom Classes for blocks
 */
if( ! function_exists( 'tie_get_box_class' ) ) {

	function tie_get_box_class( $custom = '' ){

		// Custom Classes
		$classes = explode( ' ', $custom );

		// Default Class
		$classes[]   = 'the-global-title';
		$block_style = tie_get_option( 'blocks_style' );

		if( $block_style == 4 || $block_style == 5 || $block_style == 6 || $block_style == 10 || $block_style == 11 ){
			if( ! in_array( 'mag-box-title', $classes ) ){
				$classes[] = 'has-block-head-4';
			}
		}

		return join( ' ', array_filter( $classes ) );
	}
}


/**
 * Custom Classes for blocks
 */
if( ! function_exists( 'tie_box_class' ) ) {

	function tie_box_class( $custom = '', $echo = true ){

		$out = 'class="'. tie_get_box_class( $custom ) .'"';

		if( $echo ){
			echo $out;
		}

		return $out;
	}
}


/**
 * Custom Classes for body
 */
if( ! function_exists( 'tie_body_class' ) ) {

	add_filter( 'body_class', 'tie_body_class' );
	function tie_body_class( $classes ){

		// Theme layout
		$theme_layout = tie_get_object_option( 'theme_layout', 'cat_theme_layout', 'tie_theme_layout' );

		if( TIELABS_BUDDYPRESS_IS_ACTIVE && is_buddypress() && TIELABS_BUDDYPRESS::get_page_data( 'tie_theme_layout' ) ){
			$theme_layout = TIELABS_BUDDYPRESS::get_page_data( 'tie_theme_layout' );
		}

		$theme_layout = apply_filters( 'TieLabs/body_class/theme_layout', $theme_layout );

		if( $theme_layout == 'boxed' ){
			$classes[] = 'boxed-layout'; // Boxed
		}
		elseif( $theme_layout == 'framed' ){
			$classes[] = 'boxed-layout framed-layout'; // Framed
		}
		elseif( $theme_layout == 'border' ){
			$classes[] = 'border-layout'; // Border
		}

		// Site Width Class
		if( strpos( tie_get_option( 'site_width' ), '%' ) !== false ){
			$classes[] = 'is-percent-width';
		}

		// Wrapper Shadow
		if( ! tie_get_option( 'wrapper_disable_shadows' ) ){
			$classes[] = 'wrapper-has-shadow';
		}

		// Blocks Style
		$block_style = tie_get_option( 'blocks_style', 1 );

		if( $block_style == 5 || $block_style == 6 ){
			$classes[] = 'block-head-4';
		}

		$classes[] = 'block-head-'. $block_style;

		// Boxes Style
		$classes[] = 'magazine'. tie_get_option( 'boxes_style', 1 );

		if( tie_get_option( 'boxes_style' ) == 3 ){
			$classes[] = 'magazine1';
		}


		// Custom Body CLasses
		if( tie_get_option( 'body_class' ) ){
			$classes[] = tie_get_option( 'body_class' );
		}

		// Lazy Load
		if( tie_get_option( 'lazy_load' ) ){
			$classes[] = 'is-lazyload';
		}

		// Post Format icon overlay
		if( ! tie_get_option( 'thumb_overlay' ) ){
			$classes[] = 'is-thumb-overlay-disabled';
		}

		// is-mobile or desktop
		$classes[] = tie_is_mobile() ? 'is-mobile' : 'is-desktop';

		// Header Layout
		$header_layout = tie_get_option( 'header_layout', 3 );
		$classes[] = 'is-header-layout-'.$header_layout;


		// Header Ad
		if( tie_get_option( 'banner_top' ) && ! ( is_page() && tie_get_postdata( 'tie_hide_header' ) ) ){
			$classes[] = 'has-header-ad';
		}

		// Below Header Ad
		if( tie_get_option( 'banner_below_header' ) ){
			$classes[] = 'has-header-below-ad';
		}

		// Page Builder Classes
		if( TIELABS_HELPER::has_builder() ){

			$classes[] = 'has-builder';

			if( tie_get_postdata( 'tie_header_extend_bg' ) ){
				$classes[] = 'is-header-bg-extended';
			}
		}
		else{
			$sidebar_position = tie_get_sidebar_position();

			$GLOBALS['tie_has_sidebar'] = true;

			if( $sidebar_position == 'full-width' ){

				$GLOBALS['tie_has_sidebar'] = false;

				// Show 4 products per row for WooCommerce
				add_filter( 'loop_shop_columns', array( 'TIELABS_WOOCOMMERCE', 'full_width_loop_shop_columns'), 99, 1 );
			}
			elseif( $sidebar_position == 'one-column-no-sidebar' ){
				$GLOBALS['tie_has_sidebar'] = false;
			}

			$classes[] = $sidebar_position;

			// Posts and pages layout
			if( TIELABS_HELPER::is_supported_post_type() ){

				// Post Layout
				$post_layout = tie_get_object_option( 'post_layout', 'cat_post_layout', 'tie_post_layout' );
				$post_layout = ! empty( $post_layout ) ? $post_layout : 1;

				$post_layout_class = 'narrow-title-narrow-media';

				if( $post_layout == 3 ){
					$post_layout_class = 'wide-title-narrow-media';
				}
				elseif( $post_layout == 6 ){
					$post_layout_class = 'wide-media-narrow-title';
				}
				elseif( $post_layout == 7 ){
					$post_layout_class = 'full-width-title-full-width-media';
				}
				elseif( $post_layout == 8 ){
					$post_layout_class = 'centered-title-big-bg';
				}

				$classes[] = 'post-layout-' . $post_layout;
				$classes[] = $post_layout_class;

				// Post Format
				if( $post_format = tie_get_postdata( 'tie_post_head' ) ){
					$classes[] = 'is-'. $post_format .'-format';
				}

				// Post Meta Layout
				if( tie_get_option( 'post_meta' ) && tie_get_option( 'post_meta_style' ) == 'column' ){
					$classes[] = 'post-meta-column';
				}

			}
			elseif( is_page() || ( TIELABS_BBPRESS_IS_ACTIVE && is_bbpress() ) || is_singular() ){
				$classes[] = 'post-layout-1';
			}

			// Mobile Share buttons
			if( is_singular() && tie_get_option( 'share_post_mobile' ) ) {
				$classes[] = 'has-mobile-share';
			}
		}

		// Without Header or Footer
		if( is_page() ){

			// Without Header
			if( tie_get_postdata( 'tie_hide_header' ) ){

				$classes[] = 'without-header';
				add_filter('TieLabs/is_header_active', '__return_false');
			}

			// Without Footer
			if( tie_get_postdata( 'tie_hide_footer' ) ) {

				$classes[] = 'without-footer';
				add_filter('TieLabs/is_footer_active', '__return_false');
			}
		}

		// Mobile show more button
		if( TIELABS_HELPER::is_supported_post_type() && tie_get_option( 'mobile_post_show_more' ) ) {
			$classes[] = 'post-has-toggle';
		}

		// Mobile Sidebar before Content
		if( tie_get_option( 'mobile_sidebar_before_content' ) ) {
			$classes[] = 'sidebar-before-content';
		}

		// Compact Comments layout
		/*
		if( tie_get_option( 'compact_comments' ) ) {
			$classes[] = 'compact-comments';
		}
		*/

		// Hide some elements on mobiles
		$mobile_elements = array(
			'banner_header',
			'banner_top',
			'banner_below_header',
			'banner_bottom',
			'banner_above',
			'banner_above_content',
			'banner_below_content',
			'banner_below',
			'banner_comments',

			'breaking_news',
			'sidebars',
			'footer',
			'copyright',
			'breadcrumbs',
			'read_more_buttons',
			'share_post_top',
			'share_post_bottom',
			'post_newsletter',
			'read_next',
			'related',
			'post_authorbio',
			'post_nav',
			'back_top_button',
			'inline_related_posts'
		);

		foreach ( $mobile_elements as $element ){
			if( tie_get_option( 'mobile_hide_'.$element ) ) {
				$classes[] = 'hide_' . $element;
			}
		}

		return $classes;
	}
}


/**
 * Custom Classes for HTML
 */
if( ! function_exists( 'tie_html_class' ) ) {

	add_filter( 'language_attributes', 'tie_html_class' );
	function tie_html_class( $output ){

		$classes = array();

		// Enable Theme Dark Skin
		if( tie_skin_current() == 'dark' ){
			$classes[] = 'dark-skin';
			$data_skin = 'dark';
		}
		else{
			$data_skin = 'light';
		}

		$classes = apply_filters( 'tie_html_class', $classes );

		$output .= ' class="'. join( ' ', array_filter( $classes ) ) .'" data-skin="'. $data_skin .'"';

		return $output;
	}
}


/**
 * Get Sidebar Position
 */
if( ! function_exists( 'tie_get_sidebar_position' ) ) {

	function tie_get_sidebar_position(){

		// 404 page is full width by default
		if( is_404() ){
			return 'full-width';
		}

		// Get the default sidebar position
		$sidebar_position = tie_get_option( 'sidebar_pos' );

		// WooCommerce sidebar position
		if( TIELABS_WOOCOMMERCE_IS_ACTIVE && is_product() && tie_get_option( 'woo_product_sidebar_pos' ) ) {
			$sidebar_position = tie_get_option( 'woo_product_sidebar_pos' );
		}

		// WooCommerce sidebar position
		elseif( TIELABS_WOOCOMMERCE_IS_ACTIVE && is_woocommerce() && tie_get_option( 'woo_sidebar_pos' ) ) {
			$sidebar_position = tie_get_option( 'woo_sidebar_pos' );
		}

		// buddyPress Sidebar Settings
		elseif( TIELABS_BUDDYPRESS_IS_ACTIVE && is_buddypress() ){
			$sidebar_position = TIELABS_BUDDYPRESS::get_page_data( 'tie_sidebar_pos' );
		}

		// bbPress Sidebar Settings
		elseif( TIELABS_BBPRESS_IS_ACTIVE && is_bbpress() ){
			$sidebar_position = tie_get_option( 'bbpress_sidebar_pos' );
		}

		// Posts
		elseif( is_single() ){

			$sidebar_position = tie_get_object_option( 'sidebar_pos', 'cat_posts_sidebar_pos', 'tie_sidebar_pos' );
		}

		// Custom Sidebar Position for pages and categories
		else{
			$sidebar_position = tie_get_object_option( 'sidebar_pos', 'cat_sidebar_pos', 'tie_sidebar_pos' );
		}

		// Add the sidebar class
		if( $sidebar_position == 'left' ){
			$sidebar = 'sidebar-left has-sidebar';
		}
		elseif( $sidebar_position == 'full' ){
			$sidebar = 'full-width';
		}
		elseif( $sidebar_position == 'one-column' ){
			$sidebar = 'one-column-no-sidebar';
		}
		else{
			$sidebar = 'sidebar-right has-sidebar';
		}


		return $sidebar;
	}
}


/**
 * Post Classes
 */
if( ! function_exists( 'tie_get_post_class' ) ){

	function tie_get_post_class( $classes = false, $post_id = null, $standard = false, $main_post = false ){

		$classes = ! empty( $classes ) ? explode( ' ', $classes ) : array();

		if( $standard ){
 			$classes = get_post_class( $classes );

 			// Remove the hentry class.
			$classes = array_diff( $classes , array( 'hentry' ) );
		}

		// is this post trending?
		if( tie_get_postdata( 'tie_trending_post', false, $post_id ) ){
			$classes[] = 'is-trending';
		}

		// Post format
		if( $post_format = tie_get_postdata( 'tie_post_head', false, $post_id ) ){
			$classes[] = 'tie-'. $post_format;
		}

		$classes = apply_filters( 'TieLabs/post_classes', $classes, $post_id, $standard, $main_post );

		// Return the classes
		if( ! empty( $classes ) ) {
			return apply_filters( 'TieLabs/post_class_attr', 'class="'. join( ' ', $classes ) .'"', $post_id, $standard, $main_post );
		}
	}
}


/**
 * Print Post Classes
 */
if( ! function_exists( 'tie_post_class' ) ) {

	function tie_post_class( $classes = false, $post_id = null, $standard = false, $main_post = false ){

		echo tie_get_post_class( $classes, $post_id, $standard, $main_post );
	}
}


/**
 * Before Comments Form
 */
if( ! function_exists( 'tie_comment_form_before' ) ) {

	add_action( 'comment_form_before', 'tie_comment_form_before', 5 );
	function tie_comment_form_before(){

		if( TIELABS_WOOCOMMERCE_IS_ACTIVE && is_woocommerce() ){
			return;
		}

		echo '<div id="add-comment-block" class="container-wrapper">';
	}
}


/**
 * After Comments Form
 */
if( ! function_exists( 'tie_comment_form_after' ) ) {

	add_action( 'comment_form_after', 'tie_comment_form_after', 100 );
	function tie_comment_form_after(){

		if ( TIELABS_WOOCOMMERCE_IS_ACTIVE && is_woocommerce() ){
			return;
		}

		//|| ( TIELABS_JETPACK_IS_ACTIVE && Jetpack::is_active() && in_array( 'comments', Jetpack::get_active_modules() ) ) ){

		echo '</div><!-- #add-comment-block /-->';
	}
}


/**
 * Main Content Column attributes
 */
if( ! function_exists( 'tie_content_column_attr' ) ) {

	function tie_content_column_attr( $echo = true ){

		$columns_classes = 'tie-col-md-8 tie-col-xs-12';

		if( ! TIELABS_HELPER::has_builder() ){

			$sidebar_position = tie_get_sidebar_position();

			if( $sidebar_position == 'full-width' ){
				$columns_classes = 'tie-col-md-12';
			}
		}

		$attr = apply_filters( 'TieLabs/content_column_attr', 'class="main-content '. $columns_classes .'" role="main"' );

		if( ! $echo ){
			return $attr;
		}

		echo ( $attr );
	}
}


/**
 * Before Content markup
 */
if( ! function_exists( 'tie_before_main_content' ) ) {

	add_action( 'TieLabs/before_main_content', 'tie_before_main_content' );
	function tie_before_main_content(){

		if( ( TIELABS_BUDDYPRESS_IS_ACTIVE && is_buddypress() ) || ( TIELABS_HELPER::has_builder() && ! post_password_required() ) ) {
			return;
		}

		tie_html_before_main_content();
	}
}

if( ! function_exists( 'tie_html_before_main_content' ) ) {

	function tie_html_before_main_content(){

		echo '<div id="content" class="site-content container">';

			do_action( 'TieLabs/main_content_row/before' );

			echo '<div id="main-content-row" class="tie-row main-content-row">';
	}
}


/**
 * After Content markup
 */
if( ! function_exists( 'tie_after_main_content' ) ) {

	add_action( 'TieLabs/after_main_content', 'tie_after_main_content' );
	function tie_after_main_content(){

		if( ( TIELABS_BUDDYPRESS_IS_ACTIVE && is_buddypress() ) || ( TIELABS_HELPER::has_builder() && ! post_password_required() ) ) {
			return;
		}

		tie_html_after_main_content();
	}
}

if( ! function_exists( 'tie_html_after_main_content' ) ) {

	function tie_html_after_main_content(){

			echo '</div><!-- .main-content-row /-->';

			do_action( 'TieLabs/main_content_row/after' );

		echo '</div><!-- #content /-->';
	}
}


/**
 * Post Media icon code
 */
if( ! function_exists( 'tie_post_format_icon' ) ) {

	function tie_post_format_icon( $force = false, $echo = true ){

		$is_enabled = false;

		if( tie_get_option( 'thumb_overlay' ) ){
			$is_enabled = true;
		}
		elseif( $force ){
			$post_format = tie_get_postdata( 'tie_post_head', 'standard' );

			if( $post_format != 'standard' && $post_format != 'map' ){
				$is_enabled = true;
			}
		}

		// ----
		if( ! $is_enabled ){
			return;
		}

		$code = '
			<div class="post-thumb-overlay-wrap">
				<div class="post-thumb-overlay">
					<span class="tie-icon tie-media-icon"></span>
				</div>
			</div>
		';

		if( ! $echo ){
			return $code;
		}

		echo $code;
	}
}


/**
 * Skin Switcher JS | <head>
 */
if( ! function_exists( 'tie_skin_switcher_head_js' ) ) {
	add_action( 'wp_head', 'tie_skin_switcher_head_js', 1 );
	function tie_skin_switcher_head_js(){

		if( ! tie_is_skin_switcher_active() ){
			return;
		}

		/*
		try {
			if( 'undefined' != typeof localStorage ){
				var tieSkin = localStorage.getItem('tie-skin'),
				    html = document.getElementsByTagName('html')[0].classList,
				    htmlSkin = 'light';

				if( html.contains('dark-skin') ){
					htmlSkin = 'dark';
				}

				if( tieSkin != null && tieSkin != htmlSkin ){
					html.add('tie-skin-inverted');
					var tieSkinInverted = true;
				}

				if( tieSkin == 'dark' ){
					html.add('dark-skin');
				}
				else if( tieSkin == 'light' ){
					html.remove( 'dark-skin' );
				}
			}
		} catch(e) { console.log( e ) }
		*/
		?>
		<script type="text/javascript">try{if("undefined"!=typeof localStorage){var tieSkin=localStorage.getItem("tie-skin"),html=document.getElementsByTagName("html")[0].classList,htmlSkin="light";if(html.contains("dark-skin")&&(htmlSkin="dark"),null!=tieSkin&&tieSkin!=htmlSkin){html.add("tie-skin-inverted");var tieSkinInverted=!0}"dark"==tieSkin?html.add("dark-skin"):"light"==tieSkin&&html.remove("dark-skin")}}catch(t){console.log(t)}</script>
		<?php
	}
}

/**
 * Skin Switcher JS
 */
if( ! function_exists( 'tie_skin_switcher_js' ) ) {
	add_action( 'TieLabs/after_header', 'tie_skin_switcher_js', 1 );
	function tie_skin_switcher_js(){

		if( ! tie_is_skin_switcher_active() ){
			return;
		}

		/*
			try {
				if( 'undefined' != typeof localStorage ){

					//if( 'undefined' != typeof tieSkinInverted ){
						//var invertedLogo = document.getElementById('tie-logo-inverted-img');
						//if( invertedLogo ){
							//invertedLogo.setAttribute('src', invertedLogo.getAttribute('src') );
							//invertedLogo = document.getElementById('tie-logo-inverted-source');
							//invertedLogo.setAttribute('srcset', invertedLogo.getAttribute('srcset'));
						//}
					//}

					var mnIsDark = false,
					    tnIsDark = false,
					    header;

					if( header = document.getElementById('theme-header') ){

						header = header.classList;

						if( header.contains('main-nav-default-dark') ){
							mnIsDark = true;
						}
						if( header.contains('top-nav-default-dark') ){
							tnIsDark = true;
						}
						if( tieSkin == 'dark' ){
							header.add('main-nav-dark','top-nav-dark');
							header.remove('main-nav-light','top-nav-light');
						}
						else if( tieSkin == 'light' ){
							if( ! mnIsDark ){
								header.remove('main-nav-dark');
								header.add('main-nav-light');
							}
							if( ! tnIsDark ){
								header.remove('top-nav-dark');
								header.add('top-nav-light');
							}
						}
					}
				}
			} catch(e) { console.log( e ) }
		*/
		?>
		<script type="text/javascript">
			try{if("undefined"!=typeof localStorage){var header,mnIsDark=!1,tnIsDark=!1;(header=document.getElementById("theme-header"))&&((header=header.classList).contains("main-nav-default-dark")&&(mnIsDark=!0),header.contains("top-nav-default-dark")&&(tnIsDark=!0),"dark"==tieSkin?(header.add("main-nav-dark","top-nav-dark"),header.remove("main-nav-light","top-nav-light")):"light"==tieSkin&&(mnIsDark||(header.remove("main-nav-dark"),header.add("main-nav-light")),tnIsDark||(header.remove("top-nav-dark"),header.add("top-nav-light"))))}}catch(a){console.log(a)}
		</script>
		<?php
	}
}


/**
 * Native Images LazyLoad
 */
if( ! function_exists( 'tie_lazyload_native' ) ) {
	add_action( 'wp_footer', 'tie_lazyload_native', 1 );
	function tie_lazyload_native(){

		if( ! tie_get_option( 'lazy_load' ) ){
			return;
		}

		?>
		<script type="text/javascript">
			if( 'loading' in HTMLImageElement.prototype) {
				document.querySelectorAll('[data-src]').forEach( function(img){
					img.src = img.dataset.src;
					img.removeAttribute('data-src');
				});
			}
		</script>
		<?php
	}
}
