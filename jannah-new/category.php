<?php
/**
 * The template for displaying category pages
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

get_header(); ?>

	<div <?php tie_content_column_attr(); ?>>

		<?php

		// Do not duplicate posts
		if( ! empty( $GLOBALS['tie_do_not_duplicate'] ) && is_array( $GLOBALS['tie_do_not_duplicate'] ) ) {

			global $wp_query;
			$args = array_merge( $wp_query->query_vars, array( 'post__not_in' => $GLOBALS['tie_do_not_duplicate'] ) );

			// Run The Query
			query_posts( $args );
		}


		if ( have_posts() ) : ?>

			<header class="entry-header-outer container-wrapper">
				<?php

					do_action( 'TieLabs/before_archive_title' );

					the_archive_title( '<h1 class="page-title">', '</h1>' );

					if( tie_get_option( 'category_desc' ) ) {
						the_archive_description( '<div class="taxonomy-description entry">', '</div>' );
					}

					do_action( 'TieLabs/after_archive_title' );

				?>
			</header><!-- .entry-header-outer /-->

			<?php

			// Category layout
			$layout = tie_get_object_option( 'category_layout' ) ? tie_get_object_option( 'category_layout' ) : tie_get_option( 'category_layout' );
			$layout = ! empty( $layout ) ? $layout : 'excerpt';

			// Category Excerpt
			$excerpt = tie_get_object_option( 'category_excerpt' ) ? tie_get_object_option( 'category_excerpt' ) : tie_get_option( 'category_excerpt' );

			if( $excerpt == 'no' ){
				$excerpt = false;
			}

			$excerpt_length = tie_get_object_option( 'category_excerpt_length' ) ? tie_get_object_option( 'category_excerpt_length' ) : tie_get_option( 'category_excerpt_length' );

			// Category Read More
			$read_more = tie_get_object_option( 'category_read_more' ) ? tie_get_object_option( 'category_read_more' ) : tie_get_option( 'category_read_more' );

			if( $read_more == 'no' ){
				$read_more = false;
			}

			$read_more_text = tie_get_object_option( 'category_read_more_text' ) ? tie_get_object_option( 'category_read_more_text' ) : tie_get_option( 'category_read_more_text' );

			// Category Media Overlay
			$media_overlay = tie_get_object_option( 'category_media_overlay' ) ? true : false;

			// Get the layout template part
			TIELABS_HELPER::get_template_part( 'templates/archives', '', array(
				'layout'          => $layout,
				'excerpt'         => $excerpt,
				'excerpt_length'  => $excerpt_length,
				'read_more'       => $read_more,
				'read_more_text'  => $read_more_text,
				'media_overlay'   => $media_overlay,
				'category_meta'   => apply_filters( 'TieLabs/Archive_Thumbnail/category_meta', false ),
			));

			do_action( 'TieLabs/after_archive_posts' );

			// Page navigation
			$pagination = tie_get_object_option( 'category_pagination' ) ? tie_get_object_option( 'category_pagination' ) : tie_get_option( 'category_pagination' );

			TIELABS_PAGINATION::show( array( 'type' => $pagination ) );

			// Get the Footer Description section
			TIELABS_HELPER::get_template_part( 'templates/category', 'footer' );

			do_action( 'TieLabs/after_archive_pagination' );

		// If no content, include the "No posts found" template
		else :
			TIELABS_HELPER::get_template_part( 'templates/not-found' );

		endif;

		?>

	</div><!-- .main-content /-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
