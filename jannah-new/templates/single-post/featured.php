<?php
/**
 * Featured Area
 *
 * This template can be overridden by copying it to your-child-theme/templates/single-post/featured.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

$post_format = tie_get_postdata( 'tie_post_head', 'standard' );

if( $post_format ){ // $post_format == 'standard' and no featured image

	$featured_id = ( $post_format == 'video' && tie_get_option( 'sticky_featured_video' ) ) ? 'id="the-sticky-video"' : '';

	$before = '<div '. $featured_id .' class="featured-area"><div class="featured-area-inner">';
	$after  = '</div></div>';

	// Get Post Layout
	$post_layout = tie_get_object_option( 'post_layout', 'cat_post_layout', 'tie_post_layout' );
	$post_layout = ! empty( $post_layout ) ? $post_layout : 1;

	// Get the post thumbnail size
	if( $post_layout == 6 || $post_layout == 7 ){
		$image_size = 'full';
	}
	else{
		$image_size = ( tie_get_object_option( 'sidebar_pos', 'cat_posts_sidebar_pos', 'tie_sidebar_pos' ) == 'full' ) ? 'full' : TIELABS_THEME_SLUG.'-image-post';
	}

	$image_size = apply_filters( 'TieLabs/post_featured_area/image_size', $image_size, $post_format, $post_layout );

	/**
	 * Get the post video
	 */
	if( $post_format == 'video' ){

		echo ( $before );

			// Sticky Videos Close button
			if( tie_get_option( 'sticky_featured_video' ) ){
				echo '<span class="tie-icon-cross video-close-btn" aria-hidden="true"></span>';
			}

			tie_video();
		echo ( $after );
	}


	/**
	 * Get post audio
	 */
	elseif( $post_format == 'audio' ){

		echo ( $before );
			tie_audio( $image_size );
		echo ( $after );
	}


	/**
	 * Get post map
	 */
	elseif( $post_format == 'map' ){

		echo ( $before );
			echo tie_google_maps( tie_get_postdata( 'tie_googlemap_url' ));
		echo ( $after );
	}


	/**
	 * Get post featured image
	 */
	elseif( has_post_thumbnail() && ( $post_format == 'thumb' ||
		    ( $post_format == 'standard' && ( tie_get_object_option( 'post_featured', 'cat_post_featured', 'tie_post_featured' ) && tie_get_object_option( 'post_featured', 'cat_post_featured', 'tie_post_featured' ) != 'no' ) ) ) ) {

		// Uncropped featured image
		if( tie_get_object_option( 'image_uncropped', 'cat_image_uncropped', 'tie_image_uncropped' ) ) {
			$image_size = 'full';
		}

		// Featured image Lightbox
		$lightbox_before = '';
		$lightbox_after  = '';

		if( $post_format == 'thumb' && tie_get_object_option( 'image_lightbox', 'cat_image_lightbox', 'tie_image_lightbox' ) && tie_get_object_option( 'image_lightbox', 'cat_image_lightbox', 'tie_image_lightbox' ) != 'no' ){
			$lightbox_url    = tie_thumb_src( 'full' );
			$lightbox_before = '<a href="'. $lightbox_url .'" class="lightbox-enabled">';
			$lightbox_after  = '</a><!-- .lightbox-enabled /-->';

			// Enqueue the LightBox Js file
			wp_enqueue_script( 'tie-js-ilightbox' );
		}

		// Display the featured image
		echo ( $before );
			echo '<figure class="single-featured-image">';
				echo ( $lightbox_before );
					the_post_thumbnail( $image_size, array( 'is_main_img' => true ) );
				echo ( $lightbox_after );

				// Featured image caption
				$thumb_caption = get_post( get_post_thumbnail_id() );
				if( ! empty( $thumb_caption->post_excerpt ) ) {
					echo '
						<figcaption class="single-caption-text">
							<span class="tie-icon-camera" aria-hidden="true"></span> '.
								do_shortcode( $thumb_caption->post_excerpt ) .'
						</figcaption>
					';
				}
			echo '</figure>';
		echo ( $after );
	}


	/**
	 * Get post slider
	 */
	elseif( $post_format == 'slider' ){

		// Enqueue the Sliders Js file
		wp_enqueue_script( 'tie-js-sliders' );

		if( $post_layout == 6 || $post_layout == 7 ){
			$image_size = 'full';
			$slider_id  = 'tie-post-fullwidth-gallery';
			$class      = '';
			$data_attr  = '';

			$post_slider = "
				jQuery(document).ready(function(){
					var slider = jQuery('#tie-post-fullwidth-gallery .tie-slick-slider');
					slider.slick({
						lazyLoad     : 'ondemand',
						slidesToShow : 3,
						infinite     : true,
						rtl          : is_RTL,
						slide        : '.slide',
						centerMode   : true,
						variableWidth: true,
						appendArrows : '#tie-post-fullwidth-gallery .tie-slider-nav',
						prevArrow    : '<li><span class=\"tie-icon-angle-left\"></span></li>',
						nextArrow    : '<li><span class=\"tie-icon-angle-right\"></span></li>'
					});
					jQuery('#tie-post-fullwidth-gallery').find('.loader-overlay').remove();
			";

			if( tie_get_option( 'lazy_load' ) ){
				$post_slider .= "
					slider.on('lazyLoaded', function (e, slick, image, imageSource){
						image.attr('src','');
						image.next('.slide-bg').css('background-image','url(\"'+imageSource+'\")');
					});
				";
			}

			$post_slider .= " });";

			TIELABS_HELPER::inline_script( 'tie-js-sliders', $post_slider );
		}
		else{
			$slider_id = 'tie-post-normal-gallery';
			$class     = ' tie-slick-slider-wrapper';
			$data_attr = 'data-slider-id="10"';
		}

		// Custom slider
		if( tie_get_postdata( 'tie_post_slider' ) ) {
			$slider     = tie_get_postdata( 'tie_post_slider' );
			$get_slider = get_post_custom( $slider );

			if( ! empty( $get_slider['custom_slider'][0] ) ){
				$images = maybe_unserialize( $get_slider['custom_slider'][0] );
			}
		}
		// Uploaded images
		elseif( tie_get_postdata( 'tie_post_gallery' ) ) {
			$images = maybe_unserialize( tie_get_postdata( 'tie_post_gallery' ));
		}

		if( ! empty( $images ) && is_array( $images ) ){

			echo ( $before ); ?>

			<div id="<?php echo esc_attr( $slider_id ) ?>" class="post-gallery<?php echo esc_attr( $class ) ?>" <?php echo ( $data_attr ) ?>>

				<?php

			    if( ($post_layout == 6 || $post_layout == 7 ) ){
						tie_get_ajax_loader();
			    }

				?>

				<div class="tie-slick-slider">
					<ul class="tie-slider-nav"></ul>
					<?php

					foreach( $images as $single_image ):

						$image = wp_get_attachment_image_src( $single_image['id'], $image_size ); ?>

						<div class="slide">
							<div class="thumb-overlay">
								<div class="thumb-content">
									<?php

										// Get the image title
										$title = ! empty( $single_image['title'] ) ? $single_image['title'] : get_post_field( 'post_content', $single_image['id'] );

										if( ! empty( $title ) ){
											?>
												<h3 class="thumb-title"><?php echo $title ?></h3>
											<?php
										}

										// Get the image description
										$caption = ! empty( $single_image['caption'] ) ? $single_image['caption'] : get_post_field( 'post_excerpt', $single_image['id'] );

										if( ! empty( $caption ) ){
											?>
												<div class="thumb-desc"><?php echo $caption ?></div>
											<?php
										}

									?>
								</div><!-- .thumb-content /-->
							</div><!-- .thumb-overlay /-->

							<?php

								$link_before = $link_after = '';
								$img_attrs = array();

								if( ! empty( $single_image['link'] ) ) {
									$link_before = '<a href="'. esc_url( $single_image['link'] ) .'">';
									$link_after  = '</a>';
								}

								if( tie_get_option( 'lazy_load' ) ){

									$img_attrs[] = 'data-lazy="'. esc_attr( $image[0] ) .'"';
									$img_attrs[] = 'src="'. tie_lazyload_placeholder() .'"';

									$link_after = '<div class="slide-bg lazy-bg"></div>'.$link_after;

									if( $post_layout == 6 || $post_layout == 7 ){
										$img_attrs[] = 'style="width:'. ( $image[1] * ( 600/$image[2] ) ) .'px;"';
									}
								}

								else{
									$img_attrs[] = 'src="'. esc_attr( $image[0] ) .'"';
								}

							?>

							<?php echo $link_before; ?>
								<img <?php echo join( ' ', $img_attrs ); ?> width="<?php echo esc_attr( $image[1] ) ?>" height="<?php echo esc_attr( $image[2] ) ?>" alt="<?php echo esc_attr( $title ) ?>">
							<?php echo $link_after; ?>


						</div><!-- .slide /-->
						<?php
					endforeach;
					?>
				</div><!-- .tie-slick-slider /-->
			</div><!-- .post-gallery /-->
			<?php
			echo ( $after );

		}
	} // Post Format type if

}
