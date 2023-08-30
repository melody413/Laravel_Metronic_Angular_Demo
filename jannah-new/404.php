<?php
/**
 * The template for displaying 404 pages (not found)
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

get_header(); ?>

	<div <?php tie_content_column_attr(); ?>>

		<div class="container-404">

			<?php
				/**
				 * tie_before_404_content hook.
				 */
				do_action( 'TieLabs/before_404_content' );
			?>

			<?php
			if( tie_get_option( 'page_404_img' ) ){
				echo '<img class="img-404" src="'. esc_url( tie_get_option( 'page_404_img' ) ) .'" alt="" />';
			}
			?>

			<h2><?php esc_html_e( '404 :(', TIELABS_TEXTDOMAIN ); ?></h2>
			<h3><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', TIELABS_TEXTDOMAIN ); ?></h3>


			<?php if( tie_get_option( 'page_404_search' ) ): ?>

				<h4><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', TIELABS_TEXTDOMAIN ); ?></h4>
				<div id="content-404">
					<?php get_search_form(); ?>
				</div><!-- #content-404 /-->

			<?php endif; ?>


			<?php

			if( tie_get_option( 'page_404_menu' ) && has_nav_menu( '404-menu' ) ){
				wp_nav_menu(
					array(
						'menu_id'        => 'menu-404',
						'container_id'   => 'menu-404',
						'theme_location' => '404-menu',
						'depth'          => 1,
					));
			}

			/**
			 * tie_after_404_content hook.
			 */
			do_action( 'TieLabs/after_404_content' );
			?>

		</div><!-- .container-404 /-->

	</div><!-- .main-content /-->

<?php get_footer(); ?>
