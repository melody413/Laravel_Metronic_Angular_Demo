<?php
/**
 * Block Layout - Scroll
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-scroll.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?>

<div <?php tie_post_class( 'slide' ); ?>>

	<?php if ( has_post_thumbnail() ): ?>
		<div class="slide-img">
			<?php
				$thumbnail_size = apply_filters( 'TieLabs/loop_thumbnail_size', TIELABS_THEME_SLUG.'-image-large', 'scroll' );
				tie_post_thumbnail( $thumbnail_size, 'small', false, true, $block['media_overlay'] );
			?>
		</div><!-- .slide-img /-->
	<?php endif; ?>

	<div class="slide-content">

		<?php

			// Get the Post Meta info
			if( ! empty( $block['post_meta'] ) ) {
				tie_the_post_meta( array( 'author' => false ) );
			}
		?>

		<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php tie_the_title( $block['title_length'] ); ?></a></h2>

		<?php

			// Get the review score for the posts with stars
			if( ! empty( $block['post_meta'] ) ) {
				echo '<div class="post-meta">'. tie_get_score( 'stars' ) .'</div>';
			}
		?>

	</div>
</div><!-- .Slide /-->
