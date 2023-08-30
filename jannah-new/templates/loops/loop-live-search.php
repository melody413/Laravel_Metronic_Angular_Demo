<?php
/**
 * Block Layout - Live Search
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-live-search.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  4.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?>

<div <?php tie_post_class( 'widget-post-list' ); ?>>

	<?php if ( has_post_thumbnail() ): ?>
		<div class="post-widget-thumbnail">
			<a class="post-thumb" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php tie_post_format_icon(); ?>
				<?php the_post_thumbnail( TIELABS_THEME_SLUG.'-image-small' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="post-widget-body <?php echo ! has_post_thumbnail() ? 'no-small-thumbs' : ''; ?>">
		<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
		<div class="post-meta">
			<?php tie_get_score(); ?> <?php tie_get_time(); ?>
		</div>
	</div>

</div>
