<?php
/**
 * Posts Widget
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-widgets.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?>

<li <?php tie_post_class( 'widget-single-post-item widget-post-list' ); ?>>

	<?php if ( has_post_thumbnail() ): ?>
		<div class="post-widget-thumbnail">

			<?php

				if( $count == 1 ){
					$thumbnail = ! empty( $thumbnail_first ) ? $thumbnail_first : $thumbnail;
					$review    = ! empty( $review_first )    ? $review_first    : $review;
				}

				tie_post_thumbnail( $thumbnail, $review, true, false, $media_icon );

			?>
		</div><!-- post-alignleft /-->
	<?php endif; ?>

	<div class="post-widget-body <?php echo ! has_post_thumbnail() ? 'no-small-thumbs' : '' ?>">
		<a class="post-title the-subtitle" href="<?php the_permalink(); ?>"><?php tie_the_title( $title_length ); ?></a>

		<div class="post-meta">
			<?php

				tie_get_time();

				if( ! empty( $thumbnail_first ) && $count == 1 ){
					// do nothing
				}
				elseif( ! empty( $show_score ) ){
					tie_the_score( 'stars' );
				}
			?>
		</div>
	</div>
</li>
