<?php
/**
 * The template for displaying tag pages
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

get_header(); ?>

	<div <?php tie_content_column_attr(); ?>>

		<?php if ( have_posts() ) : ?>


			<header class="entry-header-outer container-wrapper">
				<?php

					do_action( 'TieLabs/before_archive_title' );

					the_archive_title( '<h1 class="page-title">', '</h1>' );

					if( tie_get_option( 'tag_desc' ) ) {
						the_archive_description( '<div class="taxonomy-description entry">', '</div>' );
					}

					do_action( 'TieLabs/after_archive_title' );

				?>
			</header><!-- .entry-header-outer /-->

			<?php

			// Get the layout template part
			TIELABS_HELPER::get_template_part( 'templates/archives', '', array(
				'layout'          => tie_get_option( 'tag_layout', 'excerpt' ),
				'excerpt'         => tie_get_option( 'tag_excerpt' ),
				'excerpt_length'  => tie_get_option( 'tag_excerpt_length' ),
				'read_more'       => tie_get_option( 'tag_read_more' ),
				'read_more_text'  => tie_get_option( 'tag_read_more_text' ),
			));

			// Page navigation
			TIELABS_PAGINATION::show( array( 'type' => tie_get_option( 'tag_pagination' ) ) );

		// If no content, include the "No posts found" template
		else :
			TIELABS_HELPER::get_template_part( 'templates/not-found' );

		endif;

		?>

	</div><!-- .main-content /-->

<?php get_sidebar(); ?>
<?php get_footer();
