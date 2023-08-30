<?php
/**
 * Block / Archives Layout - Overlay
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-overlay.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


$thumbnail_size = apply_filters( 'TieLabs/loop_thumbnail_size', TIELABS_THEME_SLUG.'-image-post', 'overlay' );
?>

<div <?php tie_post_class( 'container-wrapper post-element' ); ?>>
	<div style="<?php echo tie_thumb_src_bg( $thumbnail_size ) ?>" class="slide">
		<a href="<?php the_permalink() ?>" class="all-over-thumb-link"><span class="screen-reader-text"><?php the_title(); ?></span></a>

		<div class="thumb-overlay">

			<?php
				// Get the Post Category
				if( $block['category_meta'] ){
					tie_the_category();
				}
			?>

			<div class="thumb-content">

				<?php
					if( $block['post_meta'] ){
						tie_the_post_meta( array( 'author' => false, 'comments' => false, 'views' => false ), '<div class="thumb-meta">', '</div>' );
					}
				?>

				<h2 class="thumb-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>

				<?php if( $block['excerpt'] ): ?>
					<div class="thumb-desc">
						<?php tie_the_excerpt( $block['excerpt_length'] ) ?>
					</div><!-- .thumb-desc -->
				<?php endif; ?>

			</div> <!-- .thumb-content /-->
		</div><!-- .thumb-overlay /-->
	</div><!-- .slide /-->
</div><!-- .container-wrapper /-->
