<?php
/**
 * Block Layout - Mini
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-mini.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


// Set custom class for the post without thumb
$no_thumb = ( ! has_post_thumbnail() || ! empty( $block['thumb_all'] )) ? 'no-small-thumbs' : '';

?>

<li <?php tie_post_class( 'post-item '.$no_thumb ); ?>>

	<?php

		# Get the Post Meta info
		if( ! empty( $block['post_meta'] ) ) {
			tie_the_post_meta( array( 'trending' => true, 'author' => false, 'comments' => false, 'review' => true ) );
		}
	?>

	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php tie_the_title( $block['title_length'] ); ?></a></h2>

	<?php

		// Get the post thumbnail
		if ( has_post_thumbnail() && empty( $block['thumb_all'] ) ){

			$thumbnail_size = apply_filters( 'TieLabs/loop_thumbnail_size', TIELABS_THEME_SLUG.'-image-small', 'mini' );

			tie_post_thumbnail( $thumbnail_size, false, false, true, $block['media_overlay'] );
		}

		if( ! empty( $block['excerpt'] ) ) { ?>
			<div class="post-details">
				<p class="post-excerpt"><?php tie_the_excerpt( $block['excerpt_length'] ) ?></p>
			</div>
			<?php
		}
	?>
</li>
