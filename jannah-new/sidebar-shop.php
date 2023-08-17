<?php
/**
 * The template for the sidebar containing the Shop widget area
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


// Returen if the current page is full width or one column
if( ! TIELABS_HELPER::has_sidebar() ) return;

// Check if the sidebars is hidden on mobiles
if( TIELABS_HELPER::is_mobile_and_hidden( 'sidebars' )) return;

// Show the sidebar if contains Widgets
if( is_active_sidebar( 'shop-widget-area' ) ){ ?>

	<aside class="sidebar tie-col-md-4 tie-col-xs-12 normal-side" aria-label="<?php esc_html_e( 'Primary Sidebar', TIELABS_TEXTDOMAIN ); ?>">
		<div class="theiaStickySidebar">
			<?php dynamic_sidebar( 'shop-widget-area' ); ?>
		</div><!-- .theiaStickySidebar /-->
	</aside><!-- .sidebar /-->
	<?php
}
