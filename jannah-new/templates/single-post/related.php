<?php
/**
 * Post Related
 *
 * This template can be overridden by copying it to your-child-theme/templates/single-post/related.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  3.1.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( (( tie_get_option( 'related' ) && ! tie_get_postdata( 'tie_hide_related' )) || ( tie_get_postdata( 'tie_hide_related' ) == 'no' ) ) && is_singular( 'post' ) ):

	// Check if the related posts is hidden on mobiles
	if( TIELABS_HELPER::is_mobile_and_hidden( 'related' ) ){
		return;
	}

	$class   = 'container-wrapper';
	$post_id = get_the_id();

	// Post titles length
	$title_length = tie_get_option( 'related_title_length' ) ? tie_get_option( 'related_title_length' ) : '';

	// Above The Footer
	if( tie_get_option( 'related_position') == 'footer' ){

		$related_number = tie_get_option( 'related_number', 4 );
	}
	else{

		// Number of posts for the normal layout with sidebar
		$related_number = tie_get_option( 'related_number', 3 );

		// Number of posts for the Full width layout without sidebar
		if( tie_get_object_option( 'sidebar_pos', 'cat_posts_sidebar_pos', 'tie_sidebar_pos' ) == 'full' ){
			$related_number = (int) tie_get_option( 'related_number_full', 4 );
		}
	}

	// For responsive layout add extra 1 post if the number is odd
	if ( $related_number % 2 != 0 ){
		$related_number++;
		$extra_post = true;
	}

	// Prepare the query
	$query_type = tie_get_option( 'related_query' );

	// Post Order
	$order = tie_get_option( 'related_order' );

	//
	$args = tie_get_related_posts_args( $query_type, $order, $related_number );

	// ---
	$args = apply_filters( 'TieLabs/related_posts_query', $args );

	// Get the posts
	$related_query = new wp_query( $args );

	// For responsive layout add extra custom class for the extra post
	if( ! empty( $extra_post ) && ! empty( $related_query->post_count ) && $related_query->post_count == $related_number ){
		$class .= ' has-extra-post';
	}

	if( $related_query->have_posts() ): ?>

	<?php if( tie_get_option( 'related_position') == 'footer' ){ ?>
		<div class="container full-width related-posts-full-width">
			<div class="tie-row">
				<div class="tie-col-md-12">
			<?php } ?>


				<div id="related-posts" class="<?php echo esc_attr( $class ) ?>">

					<div <?php tie_box_class( 'mag-box-title' ) ?>>
						<h3><?php esc_html_e( 'Related Articles', TIELABS_TEXTDOMAIN ); ?></h3>
					</div>

					<div class="related-posts-list">

					<?php

						while ( $related_query->have_posts() ):

							$related_query->the_post();

							$do_not_duplicate[] = get_the_ID(); ?>

							<div <?php tie_post_class( 'related-item' ); ?>>

								<?php

									if ( has_post_thumbnail() ){
										tie_post_thumbnail( TIELABS_THEME_SLUG.'-image-large', false );
									}
								?>

								<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php tie_the_title( $title_length ); ?></a></h3>

								<?php

									// Get the Post Meta info
									tie_the_post_meta( array( 'comments' => false, 'views' => false, 'author' => false ) );

								?>
							</div><!-- .related-item /-->

						<?php endwhile;?>

					</div><!-- .related-posts-list /-->
				</div><!-- #related-posts /-->

			<?php if( tie_get_option( 'related_position') == 'footer' ){ ?>
			</div><!-- .tie-col-md-12 -->
		</div><!-- .tie-row -->
	</div><!-- .container -->
	<?php }

	endif;

	if( ! empty( $do_not_duplicate ) ){

		// Remove the Id of the extra post from the do not duplicate array
		if( ! empty( $extra_post ) && ! empty( $related_query->post_count ) && $related_query->post_count == $related_number ){
			$the_extra_post = array_pop( $do_not_duplicate );
		}

		// Add the do not duplicate array to the GLOBALS to use it in the fly check also template file
		tie_single_post_do_not_dublicate( $do_not_duplicate );
	}

	wp_reset_postdata();

endif;
