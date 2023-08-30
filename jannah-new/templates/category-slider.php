<?php
/**
 * Category Slider
 *
 * This template can be overridden by copying it to your-child-theme/templates/category-slider.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

if( is_category() && tie_get_category_option( 'featured_posts' ) ) {

	// Category Settings
	$slider           = tie_get_category_option( 'featured_posts_style' );
	$background_color = tie_get_category_option( 'featured_posts_color' );
	$background_img   = tie_get_category_option( 'featured_posts_bg' );
	$background_video = tie_get_category_option( 'featured_posts_bg_video' );
	$parallax         = tie_get_category_option( 'featured_posts_parallax' );
	$parallax_effect  = tie_get_category_option( 'featured_posts_parallax_effect' );

	$section_styles   = array();
	$outer_class      = '';
	$section_video_bg = '';
	$parallax_options = '';

	$classes = array(
		'full-width',
		'is-first-section',
	);

	// Background
	$outer_class = 'without-background';

	if( $background_img || $background_color || $background_video ){

		$outer_class = 'has-background';

		if( $background_color ){
			$section_styles[] = 'background-color: '. $background_color .';';
		}

		if( $background_img ){
			$section_styles[] = 'background-image: url( '. $background_img .');';
		}

		if( $background_video ){

			// Check if the URL contains an mp4 file
			if( strpos( $background_video, '.mp4' ) !== false ){

				// Make sure that there is no mp4: added before
				if( substr( $background_video, 0, 4 ) !== "mp4:" ){

					// Add mp4:
					$background_video = 'mp4:'.background_video;
				}
			}

			$section_video_bg = 'data-jarallax-video="'. $background_video .'"';
			$classes[] = 'has-video-background';
		}


		if( $parallax || $background_video ){ // If video is active enable the parallax

			# Get the parallax js file
			wp_enqueue_script( 'tie-js-parallax' );

			$classes[] = 'tie-parallax';

			$parallax_effect  = $parallax_effect ? $parallax_effect : 'scroll';
			$parallax_options = " data-type='$parallax_effect'";

		}
		else{
			$section_styles[] = 'background-size: cover;';
		}
	}


	if( ( $slider < 5 || $slider >= 50 ) && $slider != 'videos_list' ){
		$classes[] = 'first-block-is-full-width';
	}

	?>
		<div id="category-slider" class="section-wrapper container-full <?php echo esc_attr( $outer_class ) ?>">
			<div class="section-item <?php echo join( ' ', $classes ); ?>" style="<?php echo join( ' ', $section_styles ); ?>" <?php echo ( $section_video_bg.$parallax_options ) ?>>

				<?php

					if( $slider > 4 || $slider == 'videos_list' ) echo '<div class="container">';

					TIELABS_HELPER::get_template_part('templates/featured');

					if( $slider > 4 || $slider == 'videos_list' ) echo '</div>';
				?>

			</div><!-- .section-item /-->
		</div><!-- #category-slider /-->
	<?php

	do_action( 'TieLabs/Category/after_slider' );
}
