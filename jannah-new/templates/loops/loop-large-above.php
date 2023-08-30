<?php
/**
 * Block Layout - Large Above
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-large-above.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?>

<li <?php tie_post_class( 'post-item' ); ?>>

	<?php

	if( ! empty( $count ) && $count == 1 ) :

		// Get the post thumbnail
		if ( has_post_thumbnail() ){

			$thumbnail_size = ! empty( $block['is_full'] ) ? 'full' : TIELABS_THEME_SLUG.'-image-post';
			$thumbnail_size = apply_filters( 'TieLabs/loop_thumbnail_size', $thumbnail_size, 'large-above', $count );

			tie_post_thumbnail( $thumbnail_size, 'large', false, true, $block['media_overlay'] );
		}
		?>

		<div class="clearfix"></div>

		<div class="post-overlay">
			<div class="post-content">

				<?php tie_the_category(); ?>

				<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php tie_the_title( $block['title_length'] ); ?></a></h2>

				<?php

					// Get the Post Meta info
					if( ! empty( $block['post_meta'] ) ){
						tie_the_post_meta( '', '<div class="thumb-meta">', '</div><!-- .thumb-meta -->' );
					}
				?>
			</div><!-- .post-content -->
		</div><!-- .post-overlay -->

		<?php
	else:

		// Get the post thumbnail
		if ( has_post_thumbnail() ){
			$thumbnail_size = apply_filters( 'TieLabs/loop_thumbnail_size', TIELABS_THEME_SLUG.'-image-large', 'large-above', $count );

			tie_post_thumbnail( $thumbnail_size, 'small', false, true, $block['media_overlay']  );
		}
		?>

		<div class="clearfix"></div>

		<div class="post-overlay">
			<div class="post-content">

				<?php

					// Get the Post Meta info
					if( ! empty( $block['post_meta'] ) ){
						tie_the_post_meta( array( 'trending' => true, 'author' => false, 'views' => false ) );
					}
				?>

				<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php tie_the_title( $block['title_length'] ); ?></a></h2>

				<?php

					// Get the review score for the posts with stars
					if( ! empty( $block['post_meta'] ) ) {
						echo '<div class="post-meta">'. tie_get_score( 'stars' ) .'</div>';
					}
				?>
			</div><!-- .post-content -->
		</div><!-- .post-overlay -->

	<?php endif; ?>
</li>
