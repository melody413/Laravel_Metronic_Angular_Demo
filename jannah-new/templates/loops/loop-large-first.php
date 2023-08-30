<?php
/**
 * Block Layout - Large First
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-large-first.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( $count == 1 ) :

	// Set custom class for the post without thumb
	$no_thumb = ( ! has_post_thumbnail() || ! empty( $block['thumb_first'] ) ) ? 'no-small-thumbs' : '';

	?>
	<li <?php tie_post_class( 'post-item '.$no_thumb ); ?>>

		<?php

			// Get the post thumbnail
			if ( has_post_thumbnail() && empty( $block['thumb_first'] ) ){

				$image_size = TIELABS_THEME_SLUG.'-image-large';

				if( !empty( $block['sub_style'] ) && $block['sub_style'] == '2c' && ! empty( $block['is_full'] ) ){
					$image_size = TIELABS_THEME_SLUG.'-image-post';
				}

				$thumbnail_size = apply_filters( 'TieLabs/loop_thumbnail_size', $image_size, 'large-first', $count );

				tie_post_thumbnail( $thumbnail_size, 'large', true, true, $block['media_overlay'] );
			}
		?>

		<div class="post-details">

			<?php

				// Get the Post Meta info
				if( ! empty( $block['post_meta'] ) ) {
					tie_the_post_meta();
				}
			?>

			<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php tie_the_title( $block['title_length'] ); ?></a></h2>

			<?php

				if( ! empty( $block['excerpt'] ) ) { ?>
					<p class="post-excerpt"><?php tie_the_excerpt( $block['excerpt_length'] ) ?></p>
					<?php
				}

				if( ! empty( $block['read_more'] ) ) {
					tie_the_more_button( $block['read_more_text'] );
				}
			?>
		</div><!-- .post-details /-->
	</li><!-- .first-post -->

<?php else:

	// Set custom class for the post without thumb
	$no_thumb = ( ! has_post_thumbnail() || ! empty( $block['thumb_small'] ) ) ? 'no-small-thumbs' : '';
	?>

	<li <?php tie_post_class( 'post-item '.$no_thumb ); ?>>
		<?php

			// Get the post thumbnail
			if ( has_post_thumbnail() && empty( $block['thumb_small'] ) ){

				$thumbnail_size = apply_filters( 'TieLabs/loop_thumbnail_size', TIELABS_SMALL_IMAGE, 'large-first', $count );

				tie_post_thumbnail( $thumbnail_size, 'small', false, true, $block['media_overlay']);
			}
		?>

		<div class="post-details">
			<?php

				// Get the Post Meta info
				if( ! empty( $block['post_meta'] ) ) {
					tie_the_post_meta( array( 'trending' => true, 'author' => false, 'comments' => false, 'views' => false, 'review' => true ) );
				}
			?>

			<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php tie_the_title( $block['title_length'] ); ?></a></h2>
		</div><!-- .post-details /-->
	</li>
<?php endif;
