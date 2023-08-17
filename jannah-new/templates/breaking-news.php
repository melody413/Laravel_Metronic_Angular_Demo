<?php
/**
 * Breaking News
 *
 * This template can be overridden by copying it to your-child-theme/templates/breaking-news.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  4.0.4
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


// Check if the breaking news is hidden on mobiles
if( $type == 'header' && TIELABS_HELPER::is_mobile_and_hidden( 'breaking_news' ) ){
	return;
}

// Cache field key
$cache_key = apply_filters( 'TieLabs/cache_key', '' );

// Classes and attr.
$breaking_attr  = array();
$breaking_class = array( 'breaking' );


// Effect type.
$breaking_effect = ! empty( $breaking_effect ) ? $breaking_effect : 'flipY';

$breaking_attr[] = 'data-type="'. $breaking_effect .'"';

if( $breaking_effect == 'slideUp' || $breaking_effect == 'slideDown' ){
	$breaking_class[] = 'up-down-controls';
}


// Breaking News arrows.
if( ! empty( $breaking_arrows ) ){
	$breaking_attr[]  = 'data-arrows="true"';
	$breaking_class[] = 'controls-is-active';
}

if( ! empty( $breaking_speed ) ){
	$breaking_attr[]  = 'data-speed="'. $breaking_speed .'"';
}

$breaking_class = join( ' ', array_filter( apply_filters( 'TieLabs/Breaking_news/class', $breaking_class ) ) );
$breaking_attr  = join( ' ', array_filter( apply_filters( 'TieLabs/Breaking_news/attr',  $breaking_attr  ) ) );


// Enqueue the breaking news Js files
if( $breaking_effect == 'slideRight' || $breaking_effect == 'slideLeft' || $breaking_effect == 'slideUp' || $breaking_effect == 'slideDown' ){
	wp_enqueue_script( 'tie-js-velocity' );
}

wp_enqueue_script( 'tie-js-breaking' );

?>

<div class="<?php echo esc_attr( $breaking_class ) ?>">

	<span class="breaking-title">
		<span class="tie-icon-bolt breaking-icon" aria-hidden="true"></span>
		<span class="breaking-title-text"><?php echo ! empty( $breaking_title ) ? $breaking_title : esc_html__( 'Breaking News', TIELABS_TEXTDOMAIN ); ?></span>
	</span>

	<ul id="breaking-news-<?php echo esc_attr( $breaking_id ) ?>" class="breaking-news" <?php echo ( $breaking_attr ); ?>>

		<?php

			if( $breaking_type != 'custom' ){

				// Get the Cached data
				if ( $type == 'header' && tie_get_option( 'jso_cache' ) /*&& ! ( defined( 'WP_CACHE' ) && WP_CACHE ) */ && ( false !== ( $cached_data = get_transient( $cache_key )) ) ){
					if( isset( $cached_data['breaking-news'] ) ) {
						$cached_breaking_news = $cached_data['breaking-news'];
					}
				}

				// It wasn't there, so render the Breaking news and save it as a transient
				if( empty( $cached_breaking_news ) ) {

					ob_start();

					# Category or Tags
					if( $type == 'header' ){

						$args = array(
							'number' => ( ! empty( $breaking_number ) ? $breaking_number : 10 ),
							'update_post_meta_cache' => false,
							'update_post_term_cache' => false,
						);

						if( $breaking_type == 'tag' ){
							$args['tags'] = $breaking_tag;
						}
						else{
							$args['id'] = $breaking_cat;
						}
					}
					else{
						$args = $breaking_block;
					}

					$breaking_query = tie_query( $args );

					if( $breaking_query->have_posts() ){
						while( $breaking_query->have_posts() ){ $breaking_query->the_post(); ?>

							<li class="news-item">
								<a href="<?php the_permalink()?>"><?php the_title(); ?></a>
							</li>

							<?php
						}
					}

					wp_reset_postdata();

					$cached_breaking_news = ob_get_clean();

					if( $type == 'header' && tie_get_option( 'jso_cache' ) /*&& ! ( defined( 'WP_CACHE' ) && WP_CACHE ) */ ){
						$GLOBALS[ $cache_key ]['breaking-news'] = $cached_breaking_news;
					}
				}

				echo ( $cached_breaking_news );
			}

			else{

				if( ! empty( $breaking_custom ) && is_array( $breaking_custom ) ){
					$count = 0;
					foreach ($breaking_custom as $custom_text){
						$count++;

						$text = $link = '';

						# WPML
						if( ! empty( $custom_text['text'] ) ){
							$text = ( $type == 'block' ) ? $custom_text['text'] : apply_filters( 'wpml_translate_single_string', $custom_text['text'], TIELABS_THEME_SLUG, 'Breaking News Custom Text #'.$count );
						}

						if( ! empty( $custom_text['link'] ) ){
							$link = ( $type == 'block' ) ? $custom_text['link'] : apply_filters( 'wpml_translate_single_string', $custom_text['link'], TIELABS_THEME_SLUG, 'Breaking News Custom Link #'.$count );
						}
						?>

						<li class="news-item">
							<a href="<?php echo esc_url( $link ) ?>"><?php echo esc_html( $text ); ?></a>
						</li>

						<?php
					}
				}

			}
		?>

	</ul>
</div><!-- #breaking /-->
