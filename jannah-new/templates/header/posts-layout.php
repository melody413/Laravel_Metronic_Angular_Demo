<?php
/**
 * Posts Layout Header Part
 *
 * This template can be overridden by copying it to your-child-theme/templates/header/posts-layout.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


// Posts Only
if ( ! TIELABS_HELPER::is_supported_post_type() ){
	return;
}

// Get the current post
the_post();

// Post Layout
if( tie_get_object_option( 'post_layout', 'cat_post_layout', 'tie_post_layout' ) ){

	$post_layout = tie_get_object_option( 'post_layout', 'cat_post_layout', 'tie_post_layout' );
	$post_layout = ! empty( $post_layout ) ? $post_layout : 1;

	// Post title area
	if( $post_layout == 3 || $post_layout == 7 ){
		// fullwidth-entry-title-wrapper used in the ajax-loaded posts
		echo '
			<div class="container fullwidth-entry-title-wrapper">
				<div class="container-wrapper fullwidth-entry-title">';
					TIELABS_HELPER::get_template_part( 'templates/single-post/head' );
					echo '
				</div>
			</div>
		';
	}
	elseif( $post_layout == 4 || $post_layout == 5 || $post_layout == 8 ){

		// Get the parallax js file
		wp_enqueue_script( 'tie-js-parallax' );

		# Normal Width layout
		$before_featured     = $after_featured = '';
		$featured_area_class = 'full-width-area tie-parallax';
		$inner_featured_1    = '<div class="container fullwidth-entry-title-wrapper">'; // fullwidth-entry-title-wrapper used in the ajax-loaded posts
		$inner_featured_2    = '</div><!-- .container /-->';
		$bg_overlay_effect   =  '<div class="thumb-overlay"></div><!-- .thumb-overlay /-->';

		# Full Width layout
		if( $post_layout == 5 ){

			$featured_area_class = 'container-wrapper tie-parallax';
			$before_featured     = '<div class="container fullwidth-entry-title-wrapper">'; // fullwidth-entry-title-wrapper used in the ajax-loaded posts
			$after_featured      = '</div><!-- .container /-->';
			$inner_featured_1    = $inner_featured_2 = '';
		}

		// Get the custom featured area bg
		if( tie_get_object_option( 'featured_custom_bg', 'cat_featured_custom_bg', 'tie_featured_custom_bg' ) ){
			$featured_img = tie_get_object_option( 'featured_custom_bg', 'cat_featured_custom_bg', 'tie_featured_custom_bg' );
		}
		elseif( tie_get_object_option( 'featured_use_fea', 'cat_featured_use_fea', 'tie_featured_use_fea' ) && ( tie_get_object_option( 'featured_use_fea', 'cat_featured_use_fea', 'tie_featured_use_fea' )  != 'no' ) && has_post_thumbnail() ){
			$featured_img = tie_thumb_src( 'full' );
		}

		$featured_bg = ! empty( $featured_img ) ? 'style="background-image: url('. $featured_img .')"' : '';


		if( $post_layout == 8 ){

			$bg_overlay_effect   = '';
			$featured_bg         = '';
			$featured_area_class = 'full-width-area';

			if( ! empty( $featured_img ) ){

				$featured_color = tie_get_object_option( 'featured_bg_color', 'cat_featured_bg_color', 'tie_featured_bg_color' );
				$featured_color = ! empty( $featured_color ) ? 'background-color: '. $featured_color .' !important;' : '';

				echo'
					<style scoped type="text/css">
						#tie-container{
							'. $featured_color .'
							background-image: url('. $featured_img .') !important;
						}
					</style>
				';
			}
		}

		echo
			$before_featured.
			'<div '.$featured_bg.' class="fullwidth-entry-title single-big-img '. $featured_area_class .'">'
				.$bg_overlay_effect
				.$inner_featured_1;
				TIELABS_HELPER::get_template_part( 'templates/single-post/head' );
				echo
				$inner_featured_2 .'
				</div><!-- .single-big-img /-->
			'.$after_featured;
	}

	// Post featured area
	if( $post_layout == 6 || $post_layout == 7 ){

		$before_featured = $after_featured = '';

		if( tie_get_postdata( 'tie_post_head' ) != 'slider' && tie_get_postdata( 'tie_post_head' ) != 'map' ){
			$before_featured = '<div class="container fullwidth-featured-area-wrapper">';
			$after_featured  = '</div><!-- .container /-->';
		}

		echo ( $before_featured );
			TIELABS_HELPER::get_template_part( 'templates/single-post/featured' );
		echo ( $after_featured );
	}
}


rewind_posts();
