<?php
/**
 * Menus Components
 *
 * This template can be overridden by copying it to your-child-theme/templates/header/components.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

ob_start();


// Search
if( tie_get_option( $components_id.'-components_search' ) ):
	$live_search_class = tie_get_option( "$components_id-components_live_search" ) ? 'class="is-ajax-search" ' : '';

	if( tie_get_option( "$components_id-components_search_layout" ) == 'compact' ):?>
		<li class="search-compact-icon menu-item custom-menu-link">
			<a href="#" class="tie-search-trigger">
				<span class="tie-icon-search tie-search-icon" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Search for', TIELABS_TEXTDOMAIN ) ?></span>
			</a>
		</li>
		<?php

	else: ?>
		<li class="search-bar menu-item custom-menu-link" aria-label="<?php esc_html_e( 'Search', TIELABS_TEXTDOMAIN ); ?>">
			<form method="get" id="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input id="search-input" <?php echo ( $live_search_class ); ?> inputmode="search" type="text" name="s" title="<?php esc_html_e( 'Search for', TIELABS_TEXTDOMAIN ) ?>" placeholder="<?php esc_html_e( 'Search for', TIELABS_TEXTDOMAIN ) ?>" />
				<button id="search-submit" type="submit">
					<span class="tie-icon-search tie-search-icon" aria-hidden="true"></span>
					<span class="screen-reader-text"><?php esc_html_e( 'Search for', TIELABS_TEXTDOMAIN ) ?></span>
				</button>
			</form>
		</li>
		<?php
	endif;
endif;


// Skin Switcher
if( tie_get_option( $components_id.'-components_skin' ) ):
	?>
	<li class="skin-icon menu-item custom-menu-link">
		<a href="#" class="change-skin" title="<?php esc_html_e( 'Switch skin', TIELABS_TEXTDOMAIN ) ?>">
			<span class="tie-icon-moon change-skin-icon" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Switch skin', TIELABS_TEXTDOMAIN ) ?></span>
		</a>
	</li>
	<?php
endif;


// Slide sidebar
if( tie_get_option( $components_id.'-components_slide_area' ) ):?>
	<li class="side-aside-nav-icon menu-item custom-menu-link">
		<a href="#">
			<span class="tie-icon-navicon" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Sidebar', TIELABS_TEXTDOMAIN ) ?></span>
		</a>
	</li>
	<?php
endif;


// Random
if( tie_get_option( $components_id.'-components_random' ) ): ?>
	<li class="random-post-icon menu-item custom-menu-link">
		<a href="<?php echo esc_url( add_query_arg( 'random-post', 1 ) ); ?>" class="random-post" title="<?php esc_html_e( 'Random Article', TIELABS_TEXTDOMAIN ) ?>" rel="nofollow">
			<span class="tie-icon-random" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Random Article', TIELABS_TEXTDOMAIN ) ?></span>
		</a>
	</li>
	<?php
endif;


// Cart
if( tie_get_option( $components_id.'-components_cart' ) && TIELABS_WOOCOMMERCE_IS_ACTIVE ):?>
	<li class="shopping-cart-icon menu-item custom-menu-link"><?php echo tie_component_button_cart(); ?></li><!-- .shopping-cart-btn /-->
	<?php
endif;


// BuddyPress Notifications
if( tie_get_option( $components_id.'-components_bp_notifications' ) && is_user_logged_in() && TIELABS_BUDDYPRESS_IS_ACTIVE ):

	?>

	<li class="notifications-icon menu-item custom-menu-link">

		<?php
			$notification = apply_filters( 'TieLabs/BuddyPress/notifications', '' );
			echo tie_component_button_bp_notifications();
		?>

		<div class="bp-notifications-menu components-sub-menu comp-sub-menu">
			<?php echo ( $notification['data'] ) ?>
		</div><!-- .components-sub-menu /-->

	</li><!-- .notifications-btn /-->
	<?php
endif;


// Login
if( tie_get_option( $components_id.'-components_login' ) ): ?>

	<?php if( is_user_logged_in() ){ ?>

		<li class="profile-icon menu-item custom-menu-link">
			<a href="#" class="profile-btn">
				<?php
					$current_user = wp_get_current_user();
					echo get_avatar( $current_user->ID, apply_filters( 'TieLabs/Login/avatar_size', 30 ) );
				?>
				<span class="screen-reader-text"><?php esc_html_e( 'Your Profile', TIELABS_TEXTDOMAIN ) ?></span>
			</a>

			<div class="components-sub-menu comp-sub-menu components-user-profile">
				<?php tie_login_form(); ?>
			</div><!-- .components-sub-menu /-->
		</li>

		<?php
		}
		else {
			$login_icon_class = tie_get_option( $components_id.'-components_login_text' ) ? 'has-title' : '';
		?>

		<li class="<?php echo $login_icon_class ?> popup-login-icon menu-item custom-menu-link">
			<a href="#" class="lgoin-btn tie-popup-trigger">
				<span class="tie-icon-author" aria-hidden="true"></span>
				<?php
					if( tie_get_option( $components_id.'-components_login_text' ) ){
						echo '<span class="login-title">'. tie_get_option( $components_id.'-components_login_text' ) .'</span>';
					}
					else{
						echo '<span class="screen-reader-text">'. esc_html__( 'Log In', TIELABS_TEXTDOMAIN ) .'</span>';
					}
				?>
			</a>
		</li>

		<?php } ?>
	<?php
endif;


// Social
if( tie_get_option( $components_id.'-components_social' ) ):
	if( tie_get_option( "$components_id-components_social_layout" ) == 'list' ):?>
		<li class="list-social-icons menu-item custom-menu-link">
			<a href="#" class="follow-btn">
				<span class="tie-icon-plus" aria-hidden="true"></span>
				<span class="follow-text"><?php esc_html_e( 'Follow', TIELABS_TEXTDOMAIN ) ?></span>
			</a>
			<?php
				tie_get_social(
					array(
						'show_name' => true,
						'before'    => '<ul class="dropdown-social-icons comp-sub-menu">',
						'after'     => '</ul><!-- #dropdown-social-icons /-->'
					));
			?>
		</li><!-- #list-social-icons /-->
		<?php
	elseif( tie_get_option( $components_id.'-components_social_layout' ) == 'grid' ):?>
		<li class="grid-social-icons menu-item custom-menu-link">
			<a href="#" class="follow-btn">
				<span class="tie-icon-plus" aria-hidden="true"></span>
				<span class="follow-text"><?php esc_html_e( 'Follow', TIELABS_TEXTDOMAIN ) ?></span>
			</a>
			<?php
				tie_get_social(
					array(
						'before' => '<ul class="dropdown-social-icons comp-sub-menu">',
						'after'  => '</ul><!-- #dropdown-social-icons /-->'
					));
			?>
		</li><!-- #grid-social-icons /-->
		<?php

	else:
		$reverse = false;

		if( $components_id == 'main-nav' || ( $components_id == 'top-nav' && ! empty( $position ) && $position == 'area-2' ) ){
			$reverse = true;
		}

		tie_get_social(
			array(
				'reverse' => $reverse,
				'before'  => ' ',
				'after'   => ' '
			));

	endif;
endif;


// Weather
if( tie_get_option( $components_id.'-components_weather' ) ):

	$location  = tie_get_option( $components_id.'-components_wz_location' );

	if( ! empty( $location ) ){

		$args = array(
			'location'      => $location,
			'units'         => tie_get_option( $components_id.'-components_wz_unit' ),
			'custom_name'   => tie_get_option( $components_id.'-components_wz_city_name' ),
			'animated'      => tie_get_option( $components_id.'-components_wz_animated' ),
			'compact'       => true,
			'forecast_days' => 'hide',
		);

		echo '<li class="weather-menu-item menu-item custom-menu-link">';
		new TIELABS_WEATHER( $args );
		echo '</li>';
	}
endif;


// Show the elements
$output = ob_get_clean();

if( ! empty( $output ) ) {
	echo empty( $before ) ? '<ul class="components">' : $before;
	echo ( $output );
	echo empty( $after ) ? '</ul><!-- Components -->' : $before;
}
