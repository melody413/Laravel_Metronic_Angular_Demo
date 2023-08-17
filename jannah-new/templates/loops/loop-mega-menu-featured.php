<?php
/**
 * Mega Menu Featured Post Layout
 *
 * This template can be overridden by copying it to your-child-theme/templates/loops/loop-mega-menu-featured.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?>

<div <?php tie_post_class( 'mega-recent-post' ) ?>>

	<?php

		if( has_post_thumbnail() ){ ?>

			<div class="post-thumbnail">
				<a class="post-thumb" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

					<?php

						tie_post_format_icon( $media_icon );
						tie_the_trending_icon( 'trending-lg' );


						$thumbnail_size = apply_filters( 'TieLabs/loop_thumbnail_size', TIELABS_THEME_SLUG.'-image-post', 'mega-menu-featured' );
						the_post_thumbnail( $thumbnail_size );
					?>

				</a>
			</div><!-- .post-thumbnail /-->
			<?php
		}

		tie_the_post_meta();

	?>

	<h3 class="post-box-title">
		<a class="mega-menu-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h3>

</div><!-- mega-recent-post -->
