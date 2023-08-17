<?php
/**
 * Top Navigation
 *
 * This template can be overridden by copying it to your-child-theme/templates/header/nav-top.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


// Is the Top Navigation enabled?
if( ! tie_get_option( 'top_nav' ) ){
	return;
}

// Top nav Classes
$top_nav_class   = array();
$top_nav_class[] = tie_get_option( 'top_date' ) ? 'date' : '';
$top_nav_class[] = tie_get_option( 'top-nav-area-1' );
$top_nav_class[] = tie_get_option( 'top-nav-area-2' );
$top_nav_class   = implode( '-', array_filter( $top_nav_class ) );
$top_nav_class   = ! empty( $top_nav_class ) ? 'has-' . $top_nav_class : '';

$top_nav_class  .= ' top-nav header-nav';

// Class for the Breakin News
if( tie_get_option( 'top-nav-area-1' ) == 'breaking' ){
	$top_nav_class .= ' has-breaking-news';
}

// Live Search skin
$live_search_data_skin = '';
if( tie_get_option( "top-nav-components_search" ) && tie_get_option( "top-nav-components_live_search" ) ){
	$live_search_skin      = tie_get_option( 'top_nav_dark' ) ? 'dark' : 'light';
	$top_nav_class        .= ' live-search-parent';
	$live_search_data_skin = 'data-skin="search-in-top-nav"';
}

?>

<nav id="top-nav" <?php echo ( $live_search_data_skin ); ?> class="<?php echo esc_attr( $top_nav_class ) ?>" aria-label="<?php esc_html_e( 'Secondary Navigation', TIELABS_TEXTDOMAIN ); ?>">
	<div class="container">
		<div class="topbar-wrapper">

			<?php
				// Today's Date
				if( tie_get_option( 'top_date' ) ){
					$date_format = tie_get_option( 'todaydate_format', 'l ,  j  F Y' ); ?>

					<div class="topbar-today-date tie-icon">
						<?php echo date_i18n( $date_format, current_time( 'timestamp' ) ); ?>
					</div>
					<?php
				}
			?>

			<div class="tie-alignleft">
				<?php

					// Breaking News
					if( tie_get_option( 'top-nav-area-1' ) == 'breaking' ){
						TIELABS_HELPER::get_template_part( 'templates/breaking-news', '', array(
							'type'            => 'header',
							'breaking_id'     => 'in-header',
							'breaking_title'  => tie_get_option( 'breaking_title'  ),
							'breaking_effect' => tie_get_option( 'breaking_effect' ),
							'breaking_arrows' => tie_get_option( 'breaking_arrows' ),
							'breaking_type'   => tie_get_option( 'breaking_type'   ),
							'breaking_number' => tie_get_option( 'breaking_number' ),
							'breaking_tag'    => tie_get_option( 'breaking_tag'    ),
							'breaking_cat'    => tie_get_option( 'breaking_cat'    ),
							'breaking_custom' => tie_get_option( 'breaking_custom' ),
							'breaking_speed'  => tie_get_option( 'breaking_speed'  ),
						));
					}

					// Top Menu
					if( tie_get_option( 'top-nav-area-1' ) == 'menu' && has_nav_menu( 'top-menu' ) ){
						wp_nav_menu(
							array(
								'container_class' => 'top-menu header-menu',
								'theme_location'  => 'top-menu'
							));
					}

					// Get components template
					if( tie_get_option( 'top-nav-area-1' ) == 'components' ){
						TIELABS_HELPER::get_template_part( 'templates/header/components', '', array( 'components_id' => 'top-nav', 'position' => 'area-1' ) );
					}
				?>
			</div><!-- .tie-alignleft /-->

			<div class="tie-alignright">
				<?php

				// Top Menu
				if( tie_get_option( 'top-nav-area-2' ) == 'menu' && has_nav_menu( 'top-menu' ) ){
					wp_nav_menu(
						array(
							'container_class' => 'top-menu header-menu',
							'theme_location'  => 'top-menu'
						));
				}

				// Get components template
				if( tie_get_option( 'top-nav-area-2' ) == 'components' ){
					TIELABS_HELPER::get_template_part( 'templates/header/components', '', array( 'components_id' => 'top-nav', 'position' => 'area-2' ) );
				}

				?>
			</div><!-- .tie-alignright /-->

		</div><!-- .topbar-wrapper /-->
	</div><!-- .container /-->
</nav><!-- #top-nav /-->
