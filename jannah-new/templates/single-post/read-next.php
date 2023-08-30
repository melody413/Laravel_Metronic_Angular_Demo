<?php
/**
 * Read Next
 *
 * This template can be overridden by copying it to your-child-theme/templates/single-post/read-next.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  3.2.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( (( tie_get_option( 'read_next' ) && ! tie_get_postdata( 'tie_hide_read_next' )) || ( tie_get_postdata( 'tie_hide_read_next' ) == 'no' ) ) && is_singular( 'post' ) ):

	// Check if the Read Next is hidden on mobiles
	if( TIELABS_HELPER::is_mobile_and_hidden( 'read_next' ) ){
		return;
	}

	// Prepare the query
	$query_type = tie_get_option('read_next_query');

	// Post Order
	$order = tie_get_option( 'read_next_order' );

	// Post Order
	$style = tie_get_option( 'read_next_style', 50 );

	//Numebr
	$posts_number = tie_get_option( 'read_next_number', 10 );

	//
	$args = tie_get_related_posts_args( $query_type, $order, $posts_number );

	// ---
	$args = apply_filters( 'TieLabs/read_next_query', $args );

	?>

	<div id="read-next-block" class="container-wrapper read-next-slider-<?php echo $style ?>">
		<h2 class="read-next-block-title"><?php esc_html_e( 'Read Next', TIELABS_TEXTDOMAIN ); ?></h2>
		<?php
			TIELABS_HELPER::get_template_part( 'templates/featured', '', array(
				'slider_settings'  => array(
					'slider'         => $style,
					'featured_posts' => true,
					'featured_auto'  => true,
					'show_date'      => true,
					'show_category'  => true,
					'show_reviews'   => true,
					'slider_id'      => 'read-next',
					'related_mode'   => $args,
				)
			));
		?>
	</div><!-- #read-next-block -->

	<?php

	wp_reset_postdata();

endif;
