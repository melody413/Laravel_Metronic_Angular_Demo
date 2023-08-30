<?php
/**
 * The template for displaying BuddyPress
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

get_header(); ?>

<?php
	if ( have_posts() ) : while ( have_posts()): the_post();

		if( ( function_exists( 'bp_is_user' ) && ! bp_is_user() ) && ! TIELABS_BUDDYPRESS::get_page_data( 'tie_hide_title' ) ){

			do_action( 'TieLabs/before_post_head' );

			?>
			<header class="buddypress-header-outer">
				<div class="container">

					<?php do_action( 'TieLabs/before_entry_head' ); ?>

					<div class="entry-header">
						<h1 class="name post-title entry-title"><?php the_title(); ?></h1>
					</div><!-- .entry-header /-->

					<?php do_action( 'TieLabs/after_entry_head' ); ?>

				</div>
			</header><!-- .entry-header-outer /-->
			<?php

			do_action( 'TieLabs/after_post_head' );
		}

		the_content();

	endwhile; endif;
?>

<?php get_footer();
