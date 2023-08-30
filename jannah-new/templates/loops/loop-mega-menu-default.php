<?php
/**
 * Mega Menu Default Layout
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-mega-menu-default.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  4.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


// Set custom class for the post without thumb
$no_thumb = ! has_post_thumbnail() ? ' no-small-thumbs' : '';

?>

<li <?php tie_post_class( 'mega-menu-post '.$no_thumb ) ?>>

	<?php
		if ( has_post_thumbnail() ){ ?>

			<div class="post-thumbnail">
				<a class="post-thumb" href="<?php the_permalink(); ?>">
					<?php tie_post_format_icon( $media_icon ); ?>
					<?php the_post_thumbnail( $thumbnail ) ?>
				</a>
			</div><!-- .post-thumbnail /-->
			<?php
		}
	?>

	<div class="post-details">
		<h3 class="post-box-title">
			<a class="mega-menu-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<?php tie_the_post_meta( array( 'trending' => true, 'author' => false, 'comments' => false, 'views' => false ) ); ?>
	</div>

</li>
