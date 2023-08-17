<?php
/**
 * Block Layout - Big Thumb
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-big-thumb.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( $count == 1 ) :

	$background = '';

	$thumbnail_size = apply_filters( 'TieLabs/loop_thumbnail_size', TIELABS_THEME_SLUG.'-image-post', 'big-thumb' );

	$thumbnail  = tie_thumb_src( $thumbnail_size );

	if( ! empty( $thumbnail ) ){
		$background = tie_get_option( 'lazy_load' ) ? 'data-lazy-bg="'. esc_attr( $thumbnail ) .'"' : 'style="'. esc_attr( tie_thumb_src_bg( $thumbnail_size ) ) .'"';
	}

	?>

	<li <?php tie_post_class( 'post-item' ); ?>>
		<div class="big-thumb-left-box-inner" <?php echo ( $background ); ?>>

			<?php
				// Get the post thumbnail
				if ( has_post_thumbnail() ){
					tie_post_thumbnail( false, 'large', false, true, $block['media_overlay'] );
				}
			?>


			<div class="post-overlay">
				<div class="post-content">

					<?php tie_the_category(); ?>

					<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php tie_the_title( $block['title_length'] ); ?></a></h2>

					<?php

						// Get the Post Meta info
						if( ! empty( $block['post_meta'] ) ) {
							tie_the_post_meta( '', '<div class="thumb-meta">', '</div>' );
						}
					?>
				</div>
			</div>
		</div>
	</li><!-- .first-post -->

<?php else:

	// Set custom class for the post without thumb
	$no_thumb = ( ! has_post_thumbnail() || ! empty( $block['thumb_small'] )) ? 'no-small-thumbs' : '';

	?>

	<li <?php tie_post_class( 'post-item '. $no_thumb ); ?>>

		<?php

			// Get the post thumbnail
			if ( has_post_thumbnail() && empty( $block['thumb_small'] ) ){
				tie_post_thumbnail( TIELABS_SMALL_IMAGE, 'small', false, true, $block['media_overlay'] );
			}
		?>

		<div class="post-details">

			<?php

				// Get the Post Meta info
				if( ! empty( $block['post_meta'] ) ) {
					tie_the_post_meta( array( 'trending' => true,'author' => false, 'comments' => false, 'views' => false, 'review' => true ) );
				}
			?>

			<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php tie_the_title( $block['title_length'] ); ?></a></h2>
		</div><!-- .post-details /-->
	</li>

<?php endif;
