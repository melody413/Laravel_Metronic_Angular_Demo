<?php
/**
 * The template for the sidebar containing the main widget area
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


// Returen if the current page is full width or one column
if( ! TIELABS_HELPER::has_sidebar() ){
	return;
}

// Check if the sidebars is hidden on mobiles
if( TIELABS_HELPER::is_mobile_and_hidden( 'sidebars' ) ){
	return;
}


// Sticky Sidebar
$is_sticky = tie_get_option( 'sticky_sidebar' ) ? true : false;

// Home Page
if ( is_home() || is_front_page() ){
	$sidebar = tie_get_option( 'sidebar_home' );
}
// BuddyPress
elseif( TIELABS_BUDDYPRESS_IS_ACTIVE && is_buddypress() ){
	$sidebar   = TIELABS_BUDDYPRESS::get_page_data( 'tie_sidebar_post' );
	$is_sticky = TIELABS_BUDDYPRESS::get_page_data( 'tie_sticky_sidebar' ) ? TIELABS_BUDDYPRESS::get_page_data( 'tie_sticky_sidebar' ) : $is_sticky;
}
// bbPress
elseif ( TIELABS_BBPRESS_IS_ACTIVE && is_bbpress() ){
	$sidebar = tie_get_option( 'sidebar_bbpress' );
}
// Pages
elseif( is_page() ){
	$sidebar   = tie_get_object_option( 'sidebar_page',   '', 'tie_sidebar_post'   );
	$is_sticky = tie_get_object_option( 'sticky_sidebar', '', 'tie_sticky_sidebar' );
}
// Posts
elseif ( is_single() ){
	$sidebar   = tie_get_object_option( 'sidebar_post',   'cat_posts_sidebar',        'tie_sidebar_post'   );
	$is_sticky = tie_get_object_option( 'sticky_sidebar', 'cat_posts_sticky_sidebar', 'tie_sticky_sidebar' );
}
// Categories
elseif ( is_category() ){
	$sidebar   = tie_get_object_option( 'sidebar_archive', 'cat_sidebar',        '' );
	$is_sticky = tie_get_object_option( 'sticky_sidebar',  'cat_sticky_sidebar', '' );
}
// All Archives
else{
	$sidebar = tie_get_option( 'sidebar_archive' );
}

// Default sidebar if there is no a custom sidebar
if( empty( $sidebar ) || ( ! empty( $sidebar ) && ! TIELABS_HELPER::is_sidebar_registered( $sidebar ) ) ) {
	 $sidebar = 'primary-widget-area';
}

// Show the sidebar if contains Widgets
if( is_active_sidebar( $sidebar ) ){

		$sidebar_class = 'sidebar tie-col-md-4 tie-col-xs-12 normal-side';

		if( $is_sticky && $is_sticky !== 'no' ){
			$sidebar_class .= ' is-sticky';
		}
	?>

	<aside class="<?php echo esc_attr( $sidebar_class ) ?>" aria-label="<?php esc_html_e( 'Primary Sidebar', TIELABS_TEXTDOMAIN ); ?>">
		<div class="theiaStickySidebar">
			<?php dynamic_sidebar( sanitize_title( $sidebar ) ); ?>
		</div><!-- .theiaStickySidebar /-->
	</aside><!-- .sidebar /-->
	<?php
}
