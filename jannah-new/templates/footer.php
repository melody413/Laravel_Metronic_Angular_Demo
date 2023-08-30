<?php
/**
 * Footer Main Template Part
 *
 * This template can be overridden by copying it to your-child-theme/templates/footer.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   4.4.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

// Show the Footer if it is enabled
if( ! apply_filters( 'TieLabs/is_footer_active', true ) ){
	return;
}

do_action( 'TieLabs/before_footer' );

?>

<footer id="footer" class="site-footer dark-skin dark-widgetized-area">

	<?php

		do_action( 'TieLbas/Footer/before_widgets' );

		TIELABS_HELPER::get_template_part( 'templates/footer', 'tiktok' );
		TIELABS_HELPER::get_template_part( 'templates/footer', 'instagram' );

		// Check if the footer sidebars area is hidden on mobiles
		if( ( tie_get_option( 'footer_widgets_area_1' ) || tie_get_option( 'footer_widgets_area_2' ) ) && ! TIELABS_HELPER::is_mobile_and_hidden( 'footer' ) ) {

			?>

			<div id="footer-widgets-container">
				<div class="container">
					<?php

						do_action( 'TieLbas/Footer/before_widgets_sections' );

						TIELABS_HELPER::get_template_part( 'sidebar', 'footer', array( 'name' => 'area_1' ) );
						TIELABS_HELPER::get_template_part( 'sidebar', 'footer', array( 'name' => 'area_2' ) );

						do_action( 'TieLbas/Footer/after_widgets_sections' );

					?>
				</div><!-- .container /-->
			</div><!-- #Footer-widgets-container /-->
			<?php
		}


		// Check if the copyright area is hidden on mobiles
		if( tie_get_option( 'copyright_area') && ! TIELABS_HELPER::is_mobile_and_hidden( 'copyright' ) ){

			$site_info_class  = tie_get_option( 'footer_centered' ) ? 'site-info' : 'site-info site-info-layout-2';

			?>

			<div id="site-info" class="<?php echo esc_attr( $site_info_class ) ?>">
				<div class="container">
					<div class="tie-row">
						<div class="tie-col-md-12">

							<?php

								do_action( 'TieLbas/Footer/Copyright/before' );

								// Replace Footers variables
								$footer_vars = array( '%year%', '%site%', '%url%' );
								$footer_val  = array( date('Y') , get_bloginfo('name') , esc_url(home_url( '/' )) );

								// First text area
								if( tie_get_option( 'footer_one' ) ){
									echo '<div class="copyright-text copyright-text-first">'. str_replace( $footer_vars , $footer_val , do_shortcode( tie_get_option( 'footer_one' ))) . '</div>';
								}

								// Second text area
								if( tie_get_option( 'footer_two' ) ){
									echo '<div class="copyright-text copyright-text-second">'. str_replace( $footer_vars , $footer_val , do_shortcode( tie_get_option( 'footer_two' ))) . '</div>';
								}

								// Footer Menu
								if( tie_get_option( 'footer_menu' ) && has_nav_menu( 'footer-menu' ) ){
									wp_nav_menu(
										array(
											'container_class' => 'footer-menu',
											'theme_location'  => 'footer-menu',
											'depth' => 1,
										));
								}

								// Footer social icons
								if( tie_get_option( 'footer_social' ) ){

									do_action( 'TieLbas/Footer/Copyright/before_social' );

									tie_get_social( array( 'before' => '<ul class="social-icons">') );

									do_action( 'TieLbas/Footer/Copyright/after_social' );
								}

								do_action( 'TieLbas/Footer/Copyright/after' );
							?>

						</div><!-- .tie-col /-->
					</div><!-- .tie-row /-->
				</div><!-- .container /-->
			</div><!-- #site-info /-->
			<?php
		}

	?>

</footer><!-- #footer /-->

<?php do_action( 'TieLabs/after_footer' ); ?>

<?php

# Go to top button
if( tie_get_option( 'footer_top' ) ){
	?>
		<a id="go-to-top" class="go-to-top-button" href="#go-to-tie-body">
			<span class="tie-icon-angle-up"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Back to top button', TIELABS_TEXTDOMAIN ) ?></span>
		</a>
	<?php
}
