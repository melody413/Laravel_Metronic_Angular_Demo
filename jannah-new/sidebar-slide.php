<?php
/**
 * The template for the sidebar containing the slide widget area
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! apply_filters( 'TieLabs/is_header_active', true ) ){
	return;
}

// General Variables
$slide_sidebar_desktop = $slide_sidebar_mobile = false;

// Main Classes
$classes = array( 'side-aside', 'normal-side', 'dark-skin', 'dark-widgetized-area' );

// Check if it is active on desktop
if( ( tie_get_option( 'top_nav'  ) && tie_get_option( 'top-nav-components_slide_area'  ) ) || ( tie_get_option( 'main_nav' ) && tie_get_option( 'main-nav-components_slide_area' ) ) ){
	$slide_sidebar_desktop = true;
	$classes[] = 'slide-sidebar-desktop';
}

// Check if it is active on mobile
if( tie_get_option( 'mobile_header_components_menu' ) ){
	$slide_sidebar_mobile = true;

	$classes[] = tie_get_option( 'mobile_menu_layout' ) == 'fullwidth'         ? 'is-fullwidth'     : '';
	$classes[] = tie_get_option( 'mobile_header_components_menu' ) == 'area_1' ? 'appear-from-left' : 'appear-from-right';

	$search_position = tie_get_option( 'mobile_menu_search_position' ) == 'top' ? 'top' : 'bottom';
}

$classes = join( ' ', apply_filters( 'TieLabs/slide_sidebar/classes', array_filter( $classes ) ) ) ;

// --
if( $slide_sidebar_desktop || $slide_sidebar_mobile ) : ?>

	<aside class=" <?php echo $classes ?>" aria-label="<?php esc_html_e( 'Secondary Sidebar', TIELABS_TEXTDOMAIN ); ?>" style="visibility: hidden;">
		<div data-height="100%" class="side-aside-wrapper has-custom-scroll">

			<a href="#" class="close-side-aside remove big-btn light-btn">
				<span class="screen-reader-text"><?php esc_html_e( 'Close', TIELABS_TEXTDOMAIN ); ?></span>
			</a><!-- .close-side-aside /-->


			<?php if( $slide_sidebar_mobile ){ ?>

				<div id="mobile-container">

					<?php
					// Search on Top
					if( tie_get_option( 'mobile_menu_search' ) && $search_position == 'top' ){ ?>
						<div id="mobile-search">
							<?php get_search_form(); ?>
						</div><!-- #mobile-search /-->
						<?php
					}

					// Menu Classes
					$class = ! tie_get_option( 'mobile_menu_icons' ) ? 'hide-menu-icons' : '';

					// Mobile Menu
					$mobile_menu = tie_get_object_option( 'mobile_the_menu', 'cat_menu', 'tie_menu' );

					if( ! empty( $mobile_menu ) && $mobile_menu != 'main-secondary' ){
						$class = ' has-custom-menu';
					}
					?>

					<div id="mobile-menu" class="<?php echo esc_attr( $class ) ?>">
						<?php
							if( ! empty( $mobile_menu ) && $mobile_menu != 'main-secondary' ){
								wp_nav_menu(
									array(
										'menu'       => $mobile_menu,
										'walker'     => new TIELABS_MEGA_MENU(),
										'items_wrap' => '<ul id="mobile-custom-menu" class="%2$s" role="menubar">%3$s</ul>',
									));
							}
						?>
					</div><!-- #mobile-menu /-->

					<?php
					// Social Networks
					if( tie_get_option( 'mobile_menu_social' ) ){ ?>
						<div id="mobile-social-icons" class="social-icons-widget solid-social-icons">
							<?php tie_get_social(); ?>
						</div><!-- #mobile-social-icons /-->
						<?php
					}

					// Search
					if( tie_get_option( 'mobile_menu_search' ) && $search_position == 'bottom' ){ ?>
						<div id="mobile-search">
							<?php get_search_form(); ?>
						</div><!-- #mobile-search /-->
						<?php
					}
					?>

				</div><!-- #mobile-container /-->
			<?php } ?>


			<?php if( ! tie_is_mobile() && $slide_sidebar_desktop ){ ?>
				<div id="slide-sidebar-widgets">
					<?php dynamic_sidebar( 'slide-sidebar-area' ); ?>
				</div>
			<?php } ?>

		</div><!-- .side-aside-wrapper /-->
	</aside><!-- .side-aside /-->

	<?php

endif;
