<?php
/**
 * Page Head Template
 *
 * This template can be overridden by copying it to your-child-theme/templates/page-head.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


// Page Title
if( ! tie_get_postdata( 'tie_hide_title' ) ){

	$title_tag = is_front_page() ? 'h2' : 'h1';

	do_action( 'TieLabs/before_post_head' );

	?>

	<header class="entry-header-outer">

		<?php do_action( 'TieLabs/before_entry_head' ); ?>

		<div class="entry-header">
			<<?php echo esc_attr( $title_tag ) ?> class="post-title entry-title"><?php the_title(); ?></<?php echo esc_attr( $title_tag ) ?>>
		</div><!-- .entry-header /-->

		<?php do_action( 'TieLabs/after_entry_head' ); ?>

	</header><!-- .entry-header-outer /-->

	<?php

	do_action( 'TieLabs/after_post_head' );
}


// Page Featured Image
if( has_post_thumbnail() && ! tie_get_postdata( 'tie_hide_page_featured' ) ){

	// Get the post thumbnail size
	$size = ( tie_get_object_option( 'sidebar_pos', '', 'tie_sidebar_pos' ) == 'full' ) ? 'full' : TIELABS_THEME_SLUG.'-image-post';

	// Display the featured image
	echo '
		<div class="featured-area">
			<figure class="single-featured-image">';

				the_post_thumbnail( $size );

				// Featured image caption
				$thumb_caption = get_post( get_post_thumbnail_id() );
				if( ! empty( $thumb_caption->post_excerpt ) ) {
					echo '
						<figcaption class="single-caption-text">
							<span class="tie-icon-camera" aria-hidden="true"></span> '.
							$thumb_caption->post_excerpt .'
						</figcaption>
					';
				}

				echo '
			</figure>
		</div><!-- .featured-area /-->
	';
}
