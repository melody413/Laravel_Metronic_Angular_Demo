<?php
/**
 * Block Layout - Grid
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-grid.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  4.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( $block['style'] != 'row' && $count == 1 ):

	$background = tie_get_option( 'lazy_load' ) ? 'data-lazy-bg="'. esc_attr( tie_thumb_src( TIELABS_THEME_SLUG.'-image-post' ) ) .'"' : 'style="'. esc_attr( tie_thumb_src_bg( TIELABS_THEME_SLUG.'-image-post' ) ) .'"'; ?>

	<li>
		<a href="<?php the_permalink() ?>" <?php tie_post_class( 'post-thumb' ); ?> <?php echo ( $background ); ?>>
			<?php tie_the_score( 'large' ); ?>
			<?php tie_post_format_icon( $block['media_overlay'] ); ?>
		</a>
	</li>

<?php else:

	$background = tie_get_option( 'lazy_load' ) ? 'data-lazy-bg="'. esc_attr( tie_thumb_src( TIELABS_THEME_SLUG.'-image-large' ) ) .'"' : 'style="'. esc_attr( tie_thumb_src_bg( TIELABS_THEME_SLUG.'-image-large' ) ) .'"'; ?>

	<li>
		<a href="<?php the_permalink() ?>" <?php tie_post_class( 'post-thumb' ); ?> <?php echo ( $background ); ?>>
			<?php tie_post_format_icon( $block['media_overlay'] ); ?>
		</a>
	</li>

<?php endif;
