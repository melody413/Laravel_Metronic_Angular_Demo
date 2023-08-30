<?php
/**
 * Block / Archives Layout - Timeline
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-timeline.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


# Set custom class for the post without thumb
$no_thumb = ( ! has_post_thumbnail() || ! empty( $block['thumb_all'] ) ) ? 'no-small-thumbs' : '';

?>

<li <?php tie_post_class( 'post-item '.$no_thumb ); ?>>

	<?php

		if( empty( $GLOBALS['timeline_time'] ) || $GLOBALS['timeline_time'] != get_the_time('M Y') ){
			echo '<div class="year-month"><span>'. get_the_time('M') .'</span><em>- '. get_the_time('Y') .' -</em></div>';
		}

		$GLOBALS['timeline_time'] = get_the_time('M Y');
	?>

	<div class="clearfix"></div>
	<div class="day-month"><span><?php echo get_the_time('j F') ?></span></div>
	<div class="post-item-inner">

		<?php

			// Get the post thumbnail
			if ( has_post_thumbnail() && empty( $block['thumb_all'] ) ) {
				$thumbnail_size = apply_filters( 'TieLabs/loop_thumbnail_size', TIELABS_THEME_SLUG.'-image-large', 'timeline' );
				tie_post_thumbnail( $thumbnail_size, 'large', true, true, $block['media_overlay'] );
			}
		?>

		<div class="post-details">

			<?php

				// Get the Post Meta info
				if( ! empty( $block['post_meta'] ) ) {
					tie_the_post_meta( array( 'date' => false ) );
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
		</div><!-- .post-details -->
	</div><!-- .post-item-inner -->
</li>
