<?php
/**
 * The template part for displaying single posts
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

get_header(); ?>

<?php

if ( have_posts() ) :

	while ( have_posts() ): the_post();

		TIELABS_HELPER::get_template_part( 'templates/single-post/content' );

	endwhile;

endif;

get_sidebar();
get_footer();
