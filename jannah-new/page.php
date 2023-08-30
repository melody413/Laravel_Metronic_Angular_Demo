<?php
/**
 * The template for displaying pages
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

get_header(); ?>

<?php

/**
 * Page Builder
 */
if( TIELABS_HELPER::has_builder() ):

	// Get Blocks
	TIELABS_HELPER::get_template_part( 'framework/blocks' );

	// After the page builder contents
	do_action( 'TieLabs/after_builder_content' );


/**
 * Normal Page
 */
else:

	if ( have_posts() ) :

		while ( have_posts() ): the_post();

			TIELABS_HELPER::get_template_part( 'templates/single-post/content' );

		endwhile;

	endif;

	get_sidebar();

endif;

get_footer();
