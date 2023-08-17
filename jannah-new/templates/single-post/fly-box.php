<?php
/**
 * Fly Box
 *
 * This template can be overridden by copying it to your-child-theme/templates/single-post/fly-box.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  3.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

$post_id = get_the_id();

// Post titles length
$title_length = tie_get_option( 'check_also_title_length' ) ? tie_get_option( 'check_also_title_length' ) : '';

// Check Also Position
$check_also_position = tie_get_option( 'check_also_position', 'right' );

// Prepare the query
$query_type   = tie_get_option( 'check_also_query' );
$posts_number = tie_get_option( 'check_also_number', 1 );
$order        = tie_get_option( 'check_also_order' );

$args = tie_get_related_posts_args( $query_type, $order, $posts_number );

$args = apply_filters( 'TieLabs/checkalso_query', $args );

// Get the posts
$check_also_query = new wp_query( $args );


if( $check_also_query->have_posts() ):

	$style_args  = array();
	$block_class = 'widget';

	if( $check_also_query->post_count == 1 ){

		$style_args['thumbnail_first'] = TIELABS_THEME_SLUG.'-image-large';
		$style_args['review_first']    = 'large';

		$block_class .= ' posts-list-big-first has-first-big-post';
	}

	?>

	<div id="check-also-box" class="container-wrapper check-also-<?php echo esc_attr( $check_also_position ) ?>">

		<div <?php tie_box_class( 'widget-title' ) ?>>
			<div class="the-subtitle"><?php esc_html_e( 'Check Also', TIELABS_TEXTDOMAIN ); ?></div>

			<a href="#" id="check-also-close" class="remove">
				<span class="screen-reader-text"><?php esc_html_e( 'Close', TIELABS_TEXTDOMAIN ); ?></span>
			</a>
		</div>

		<div class="<?php echo $block_class; ?>">
			<ul class="posts-list-items">

			<?php

				$style_args = wp_parse_args( $style_args, array(
					'thumbnail'       => TIELABS_THEME_SLUG.'-image-small',
					'thumbnail_first' => '',
					'review'          => 'small',
					'review_first'    => '',
					'count'           => 0,
					'show_score'      => true,
					'title_length'    => $title_length,
					'media_icon'      => false,
				));

				$do_not_duplicate = array();

				while ( $check_also_query->have_posts() ){
					$style_args['count']++;

					$check_also_query->the_post();
					$do_not_duplicate[] = get_the_ID();

					TIELABS_HELPER::get_template_part( 'templates/loops/loop', 'widgets', $style_args );
				}

				// Add the do not duplicate array to the GLOBALS
				tie_single_post_do_not_dublicate( $do_not_duplicate );

 			?>

			</ul><!-- .related-posts-list /-->
		</div>
	</div><!-- #related-posts /-->

	<?php
endif;

wp_reset_postdata();
