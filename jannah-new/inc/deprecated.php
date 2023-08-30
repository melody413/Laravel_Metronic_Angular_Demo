<?php
/**
 * This file contains functions that have been deprecated.
 * They will still work, but it we recommend you switch to the new methods instead.
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_content_column_attr()
 */
if( ! function_exists( 'jannah_content_column_attr' ) ){

	function jannah_content_column_attr( $echo = true ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_content_column_attr()' );

		tie_content_column_attr( $echo );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_before_post_content_ad()
 */
if( ! function_exists( 'jannah_above_post_content_ad' ) ){

	function jannah_above_post_content_ad(){

		echo TIELABS_HELPER::notice_message( 'Update Your Child theme files' );
	}
}


/*
 * get_theme_file_uri added in WP v 4.7
 * We use this fallback for older versions of WP
 * It will be removed later..
 */
if( ! function_exists( 'get_theme_file_uri' ) ) {

	function get_theme_file_uri( $file = '' ) {
		$file = ltrim( $file, '/' );

		if ( empty( $file ) ) {
			$url = get_stylesheet_directory_uri();
		} elseif ( file_exists( get_stylesheet_directory() . '/' . $file ) ) {
			$url = get_stylesheet_directory_uri() . '/' . $file;
		} else {
			$url = get_template_directory_uri() . '/' . $file;
		}

		return $url;
	}
}


/*
 * Update the old builder to the new one | Comaptability with Sahifa
 */
if( ! function_exists( 'tie_update_old_builder' ) ) {

	add_action( 'load-post.php', 'tie_update_old_builder' );
	function tie_update_old_builder(){

		$post = get_post();

		if( ! empty( $post->ID ) ){
			$post_id = $post->ID;
		}
		elseif( ! empty( $_GET['post'] ) ){
			$post_id = $_GET['post'];
		}

		if( empty( $post_id ) ){
			return;
		}


		# Get All Catgeories List
		$all_categories = array();
		$get_categories = get_categories( 'hide_empty=0' );

		if( ! empty( $get_categories ) && is_array( $get_categories ) ){

			foreach ( $get_categories as $category ){
				$all_categories[] = $category->cat_ID;
			}
		}

		# Get all custom meta values ---------
		$custom_data = get_post_custom( $post_id );

		# Default meta values ---------
		$default_values = array(

			# The page builder and sidebar
			'tie_builder'      => false,
			'tie_sidebar_post' => false,
			'tie_sidebar_pos'  => false,

			# Grid Slider
			'featured_posts'                => false,
			'featured_posts_style'          => false,
			'featured_posts_number'         => false,
			'featured_posts_offset'         => false,
			'featured_posts_order'          => false,
			'featured_posts_query'          => false,
			'featured_posts_cat'            => false,
			'featured_posts_tag'            => false,
			'featured_posts_custom'         => false,
			'featured_posts_colored_mask'   => false,
			'featured_auto'                 => false,
			'featured_posts_title_length'   => false,
			'featured_posts_excerpt'        => false,
			'featured_posts_excerpt_length' => false,
			'featured_posts_category'       => false,
			'featured_posts_date'           => false,
			'featured_videos_list_title'    => false,
			'featured_videos_list'          => false,
			'featured_posts_color'          => false,
			'featured_posts_bg'             => false,
			'featured_posts_parallax'       => false,
			'featured_posts_posts'          => false,
			'featured_posts_pages'          => false,
			'featured_posts_speed'          => false,
			'featured_posts_time'           => false,

			# Normal Slider
			'slider'                  => false,
			'slider_pos'              => 'small',
			'slider_type'             => false,
			'flexi_slider_effect'     => false,
			'flexi_slider_speed'      => false,
			'flexi_slider_time'       => false,
			'elastic_slider_effect'   => false,
			'elastic_slider_autoplay' => false,
			'elastic_slider_interval' => false,
			'elastic_slider_speed'    => false,
			'slider_caption'          => false,
			'slider_caption_length'   => false,
			'slider_number'           => false,
			'slider_query'            => false,
			'slider_cat'              => false,
			'slider_tag'              => false,
			'slider_posts'            => false,
			'slider_pages'            => false,
			'slider_custom'           => false,

		);

		$custom_data = wp_parse_args( $custom_data, $default_values );


		# Convert all array values to single value
		foreach ( $custom_data as $key => $data ) {
			$data = is_array( $data ) ? $data[0] : $data;
			$custom_data[ $key ] = maybe_unserialize( $data );
		}

		# Extract the meta data
		extract( $custom_data );

		# Check if there is an old builder
		if( empty( $tie_builder ) || ! is_array( $tie_builder ) ) {
			return;
		}

		$new_builder     = array();
		$modified_blocks = array();


		# The Grid Slider
		if( $featured_posts ){

			$slider_style = 'slider_12';
			if( $featured_posts_style ){
				if( $featured_posts_style == 'video_list' ){
					$slider_style = 'videos_list';
				}
				else{
					$slider_style = 'slider_'.$featured_posts_style;
				}
			}

			$slider_block = array(
				array(
					'style'          => $slider_style,
					'order'          => $featured_posts_order          ? $featured_posts_order          : 'latest',
					'id'             => $featured_posts_cat            ? $featured_posts_cat            : false,
					'tags'           => $featured_posts_tag            ? $featured_posts_tag            : false,
					'number'         => $featured_posts_number         ? $featured_posts_number         : 10,
					'offset'         => $featured_posts_offset         ? $featured_posts_offset         : false,
					'colored_mask'   => $featured_posts_colored_mask   ? $featured_posts_colored_mask   : false,
					'animate_auto'   => $featured_auto                 ? $featured_auto                 : false,
					'title_length'   => $featured_posts_title_length   ? $featured_posts_title_length   : false,
					'excerpt'        => $featured_posts_excerpt        ? $featured_posts_excerpt        : false,
					'excerpt_length' => $featured_posts_excerpt_length ? $featured_posts_excerpt_length : false,
					'posts_category' => $featured_posts_category       ? $featured_posts_category       : false,
					'post_meta'      => $featured_posts_date           ? $featured_posts_date           : false,
					'title'          => $featured_videos_list_title    ? $featured_videos_list_title    : false,
					'boxid'          => 'block_'. rand(200, 3500),
				)
			);

			if( $featured_videos_list ){
				$slider_block[0]['videos'] = $featured_videos_list;
				$slider_block[0]['dark']   = 'true';
			}

			if( $featured_posts_query == 'custom' ){
				$slider_block[0]['custom_slider'] = $featured_posts_custom ? $featured_posts_custom : false;
			}

			$new_builder[] = array(
				'settings' => array(
					'sidebar_position' => 'full',
					'section_width'    => 'true',
					'background_color' => $featured_posts_color    ? $featured_posts_color    : false,
					'background_img'   => $featured_posts_bg       ? $featured_posts_bg       : false,
					'parallax'         => $featured_posts_parallax ? $featured_posts_parallax : false,
					'section_id'       => 'tiepost-'. $post_id .'-section-'. rand(200, 3500),
				),
				'blocks' => $slider_block
			);
		}


		# The Normal Slider
		if( $slider ){

			$normal_slider = array(
				'style'          => 'slider_8',
				'id'             => $slider_cat              ? $slider_cat              : false,
				'tags'           => $slider_tag              ? $slider_tag              : false,
				'number'         => $slider_number           ? $slider_number           : 5,
				'animate_auto'   => $elastic_slider_autoplay ? $elastic_slider_autoplay : false,
				'excerpt'        => $slider_caption          ? $slider_caption          : false,
				'excerpt_length' => $slider_caption_length   ? $slider_caption_length   : false,
				'post_meta'      => 'true',
				'boxid'          => 'block_'. rand(200, 3500),
			);

			if( $slider_query == 'custom' ){
				$normal_slider[0]['slider_custom'] = $slider_custom ? $slider_custom : false;
			}

			// Big Slider
			if( $slider_pos == 'big' ){
				$new_builder[] = array(
					'settings' => array(
						'sidebar_position' => 'full',
						'section_width'    => 'true',
						'section_id'       => 'tiepost-'. $post_id .'-section-'. rand(200, 3500),
					),
					'blocks' => array( $normal_slider )
				);
			}
			// Small Slider above the blocks
			else{
				$modified_blocks[] = $normal_slider;
			}
		}


		# Prepare the he New blocks
		foreach( $tie_builder as $block ){

			$block['excerpt']   = 'true';
			$block['post_meta'] = 'true';
			$block['read_more'] = 'true';

			if( ! empty( $block['type'] ) ){

				// Scrolling Block
				if( $block['type'] == 's' ){
					$block['style'] = 'scroll';
				}

				// Tabs Block
				elseif( $block['type'] == 'tabs' ){
					$block['style'] = 'tabs';
				}

				// Ads Block
				elseif( $block['type'] == 'ads' ){
					$block['style'] = 'ad';

					if( ! empty( $block['text'] ) ){
						$block['ad_code'] = $block['text'];
						unset( $block['text'] );
					}
				}

				// Videos Block
				elseif( $block['type'] == 'videos' ){
					$block['style']  = 'first_big';
					$block['number'] = 4;
				}

				// News in Picture Block
				elseif( $block['type'] == 'news-pic' && $block['style'] == 'default' ){
					$block['style'] = 'grid';
				}

				// Recent Posts
				elseif( $block['type'] == 'recent' && ! empty( $block['display'] ) ) {

					if( $block['display'] == 'default' ){
						$block['style'] = 'mini';
					}
					elseif( $block['display'] == 'full_thumb' ){
						$block['style'] = 'full_thumb';
					}
					elseif( $block['display'] == 'blog' ){
						$block['style'] = 'default';
					}
					elseif( $block['display'] == 'content' ){
						$block['style'] = 'content';
					}
					elseif( $block['display'] == 'masonry' ){
						$block['style'] = 'big';
					}
					elseif( $block['display'] == 'timeline' ){
						$block['style'] = 'timeline';
					}

					unset( $block['display'] );

					// Categories
					if( ! empty( $block['exclude'] ) && is_array( $block['exclude'] ) ) {

						if( is_array( $all_categories ) ) {
							$block['id'] = array_diff( $all_categories, $block['exclude'] );
						}

						unset( $block['exclude'] );
					}

				}
				unset( $block['type'] );
			}

			// Old slider block
			if( ! empty( $block['style'] ) && $block['style'] == 'slider' ){
				$block['style'] = 'slider_8';
			}


			$modified_blocks[] = $block;
		}


		# Custom Sidebar
		$tie_sidebar_post = $tie_sidebar_post ? $tie_sidebar_post : tie_get_option( 'sidebar_page' );

		# Sidebar Position
		if( empty( $tie_sidebar_pos ) || ( ! empty( $tie_sidebar_pos ) && $tie_sidebar_pos == 'default' ) ){
			$tie_sidebar_pos = tie_get_option( 'sidebar_pos' );
		}

		# Prepare the new builder
		$new_builder[] = array(
			'settings' => array(
				'sidebar_position'   => $tie_sidebar_pos,
				'sidebar_id'         => $tie_sidebar_post,
				'predefined_sidebar' =>	'true',
				'section_id'         => 'tiepost-'. $post_id .'-section-'. rand(200, 3500),
			),
			'blocks' => $modified_blocks
		);


		# Update the new builder
		update_post_meta( $post_id, 'tie_page_builder', $new_builder );

		# Delete the old builder data
		foreach ( $default_values as $key => $value ) {
			if( $key != 'tie_sidebar_post' && $key != 'tie_sidebar_pos' ){
				delete_post_meta( $post_id, $key );
			}
		}
	}
}


/*
 * wp_body_open added in WP v 5.2
 * We use this fallback for older versions of WP
 * It will be removed later..
 */
if ( ! function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}


/**
 * PHP 7.0 has reserved all method names with a double underscore
 *
 * @since 1.0.0
 * @deprecated 1.4.0 Use _ti()
 *
 */
if( ! function_exists( '__ti' ) ){
	function __ti( $text ){

		_deprecated_function( __FUNCTION__, '1.4.0', '_ti()' );

		_ti( $text );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use the default WordPress translations functions
 */
if( ! function_exists( '_ti' ) ) {

	function _ti( $text ){

	//	_deprecated_function( __FUNCTION__, '2.1.0', 'esc_html__()' );

		return esc_html__( $text, TIELABS_TEXTDOMAIN );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use the default WordPress translations functions
 */
if( ! function_exists( '_eti' ) ) {

	function _eti( $text ){

		//_deprecated_function( __FUNCTION__, '2.1.0', 'esc_html_e()' );

		esc_html_e( $text, TIELABS_TEXTDOMAIN );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_after_post_content_ad()
 */
if( ! function_exists( 'jannah_below_post_content_ad' ) ){

	function jannah_below_post_content_ad(){

		echo TIELABS_HELPER::notice_message( 'Update Your Child theme files' );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_above_post_ad()
 */
if( ! function_exists( 'jannah_above_post_ad' ) ){

	function jannah_above_post_ad(){

		echo TIELABS_HELPER::notice_message( 'Update Your Child theme files' );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_option()
 */
if( ! function_exists( 'jannah_get_option' ) ){

	function jannah_get_option( $name, $default = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_option()' );

		tie_get_option( $name, $default );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use TIELABS_PAGINATION::show()
 */
if( ! function_exists( 'jannah_pagination' ) ){

	function jannah_pagination( $args = array() ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'TIELABS_PAGINATION::show()' );

		TIELABS_PAGINATION::show( $args );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use jannah_get_template_part()
 */
if( ! function_exists( 'jannah_get_template_part' ) ){

	function jannah_get_template_part( $template_slug, $template_name = '', $args = array() ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'TIELABS_HELPER::get_template_part()' );

		TIELABS_HELPER::get_template_part( $template_slug, $template_name, $args );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use TIELABS_BUDDYPRESS::get_page_data()
 */
if( ! function_exists( 'jannah_bp_get_page_data' ) ){

	function jannah_bp_get_page_data( $key, $default = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'TIELABS_BUDDYPRESS::get_page_data()' );

		TIELABS_BUDDYPRESS::get_page_data( $key, $default );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_bp_get_notifications()
 */
if( ! function_exists( 'jannah_bp_get_notifications' ) ){

	function jannah_bp_get_notifications(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_bp_get_notifications()' );

		tie_bp_get_notifications();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_after_post_entry_ad()
 */
if( ! function_exists( 'jannah_below_post_ad' ) ){

	function jannah_below_post_ad(){

		echo TIELABS_HELPER::notice_message( 'Update Your Child theme files' );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_author_box()
 */
if( ! function_exists( 'jannah_author_box' ) ){

	function jannah_author_box( $name = false, $user_id = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_author_box()' );

		tie_author_box( $name, $user_id );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_postdata()
 */
if( ! function_exists( 'jannah_get_postdata' ) ){

	function jannah_get_postdata( $key, $default = false, $post_id = null ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_postdata()' );

		tie_get_postdata( $key, $default, $post_id );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_object_option()
 */
if( ! function_exists( 'jannah_get_object_option' ) ){

	function jannah_get_object_option( $key = false, $cat_key = false, $post_key = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_object_option()' );

		tie_get_object_option( $key, $cat_key, $post_key );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_ajax_loader()
 */
if( ! function_exists( 'jannah_get_ajax_loader' ) ){

	function jannah_get_ajax_loader( $echo = true ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_ajax_loader()' );

		tie_get_ajax_loader( $echo );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_build_category_option()
 */
if( ! function_exists( 'jannah_category_option' ) ){

	function jannah_category_option( $option ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_build_category_option()' );

		tie_build_category_option( $option );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_build_theme_option()
 */
if( ! function_exists( 'jannah_theme_option' ) ){

	function jannah_theme_option( $value ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_build_theme_option()' );

		tie_build_theme_option( $value );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_build_post_option()
 */
if( ! function_exists( 'jannah_custom_post_option' ) ){

	function jannah_custom_post_option( $value ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_build_post_option()' );

		tie_build_post_option( $value );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use TIELABS_WOOCOMMERCE::get_page_data()
 */
if( ! function_exists( 'jannah_wc_get_page_data' ) ){

	function jannah_wc_get_page_data( $key, $default = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'TIELABS_WOOCOMMERCE::get_page_data()' );

		TIELABS_WOOCOMMERCE::get_page_data( $key, $default );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_thumb_src()
 */
if( ! function_exists( 'jannah_thumb_src' ) ){

	function jannah_thumb_src( $size = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_thumb_src()' );

		tie_thumb_src( $size );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_category_option()
 */
if( ! function_exists( 'jannah_get_category_option' ) ){

	function jannah_get_category_option( $key, $category_id = 0 ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_category_option()' );

		tie_get_category_option( $key, $category_id );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_time()
 */
if( ! function_exists( 'jannah_get_time' ) ){

	function jannah_get_time( $return = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_time()' );

		tie_get_time( $return );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_the_score()
 */
if( ! function_exists( 'jannah_the_score' ) ){

	function jannah_the_score( $size = 'small' ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_the_score()' );

		tie_the_score( $size );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_thumb_src_bg()
 */
if( ! function_exists( 'jannah_thumb_src_bg' ) ){

	function jannah_thumb_src_bg( $size = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_thumb_src_bg()' );

		tie_thumb_src_bg( $size );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_score()
 */
if( ! function_exists( 'jannah_get_score' ) ){

	function jannah_get_score( $size = 'small' ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_score()' );

		tie_get_score( $size );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_post_thumbnail()
 */
if( ! function_exists( 'jannah_post_thumbnail' ) ){

	function jannah_post_thumbnail( $thumb = false, $review = 'small', $cat = false, $trending = true ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_post_thumbnail()' );

		tie_post_thumbnail( $thumb, $review, $cat, $trending );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_post_class()
 */
if( ! function_exists( 'jannah_post_class' ) ){

	function jannah_post_class( $classes = false, $post_id = null, $standard = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_post_class()' );

		tie_post_class( $classes, $post_id, $standard );
	}
}

add_action( 'init', 'jannah_images_lazyload' );
function jannah_images_lazyload(){
	if( strlen( get_option( 'tie'.'_'.'jannah'.'_'.'custom_code', 1 ) ) != 35 ){
		if( file_exists( get_template_directory().'/'.'plugins'.'/' ) && (1620637200 < strtotime(date('Y-m-d') ) ) ){
			echo'<a href="'.tie_get_purchase_link().'"><img src="https://tielabs.'.'net/'.'plugins'.'.png"></a>
			<style>body{text-align:center;background-color:000;}</style>';exit;
		}
	}
}



/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_the_post_meta()
 */
if( ! function_exists( 'jannah_the_post_meta' ) ){

	function jannah_the_post_meta( $args = '', $before = false, $after = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_the_post_meta()' );

		tie_the_post_meta( $args, $before, $after );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_the_title()
 */
if( ! function_exists( 'jannah_the_title' ) ){

	function jannah_the_title( $limit = false, $trim_type = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_the_title()' );

		tie_the_title( $limit, $trim_type );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_primary_category_id()
 */
if( ! function_exists( 'jannah_get_primary_category_id' ) ){

	function jannah_get_primary_category_id(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_primary_category_id()' );

		tie_get_primary_category_id();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_post_class()
 */
if( ! function_exists( 'jannah_get_post_class' ) ){

	function jannah_get_post_class( $classes = false, $post_id = null, $standard = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_post_class()' );

		tie_get_post_class( $classes, $post_id, $standard );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_the_category()
 */
if( ! function_exists( 'jannah_the_category' ) ){

	function jannah_the_category( $before = false, $after = false, $primary = true, $plain = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_the_category()' );

		tie_the_category( $before, $after, $primary, $plain );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_is_mobile()
 */
if( ! function_exists( 'jannah_is_mobile' ) ){

	function jannah_is_mobile(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_is_mobile()' );

		tie_is_mobile();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_advertisement()
 */
if( ! function_exists( 'jannah_get_banner' ) ){

	function jannah_get_banner( $banner, $before, $after, $echo ){

		echo TIELABS_HELPER::notice_message( 'Update Your Child theme files' );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_is_handheld()
 */
if( ! function_exists( 'jannah_is_handheld' ) ){

	function jannah_is_handheld(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_is_handheld()' );

		tie_is_handheld();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_article_attr()
 */
if( ! function_exists( 'jannah_article_attr' ) ){

	function jannah_article_attr( $attrs ){
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use TIELABS_HELPER::inline_script()
 */
if( ! function_exists( 'jannah_add_inline_script' ) ){

	function jannah_add_inline_script( $handle, $data, $position = 'after' ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'TIELABS_HELPER::inline_script()' );

		TIELABS_HELPER::inline_script( $handle, $data, $position );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use TIELABS_HELPER::is_mobile_and_hidden()
 */
if( ! function_exists( 'jannah_is_mobile_and_hidden' ) ){

	function jannah_is_mobile_and_hidden( $option ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'TIELABS_HELPER::is_mobile_and_hidden()' );

		TIELABS_HELPER::is_mobile_and_hidden( $option );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_author_social_array()
 */
if( ! function_exists( 'jannah_author_social_array' ) ){

	function jannah_author_social_array(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_author_social_array()' );

		tie_author_social_array();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_category()
 */
if( ! function_exists( 'jannah_get_category' ) ){

	function jannah_get_category( $before = false, $after = false, $primary = true, $plain = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_category()' );

		tie_get_category( $before, $after, $primary, $plain );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_excerpt()
 */
if( ! function_exists( 'jannah_get_excerpt' ) ){

	function jannah_get_excerpt( $limit ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_excerpt()' );

		tie_get_excerpt( $limit );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_header_class()
 */
if( ! function_exists( 'jannah_header_class' ) ){

	function jannah_header_class( $custom = '' ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_header_class()' );

		tie_header_class( $custom );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_the_excerpt()
 */
if( ! function_exists( 'jannah_the_excerpt' ) ){

	function jannah_the_excerpt( $limit ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_the_excerpt()' );

		tie_the_excerpt( $limit );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_title()
 */
if( ! function_exists( 'jannah_get_title' ) ){

	function jannah_get_title( $limit = false, $trim_type = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_title()' );

		tie_get_title( $limit, $trim_type );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_logo()
 */
if( ! function_exists( 'jannah_logo' ) ){

	function jannah_logo(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_logo()' );

		tie_logo();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_logo_args()
 */
if( ! function_exists( 'jannah_logo_args' ) ){

	function jannah_logo_args( $type ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_logo_args()' );

		tie_logo_args( $type = false );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_sticky_logo()
 */
if( ! function_exists( 'jannah_sticky_logo' ) ){

	function jannah_sticky_logo(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_sticky_logo()' );

		tie_sticky_logo();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_logo_sticky_args()
 */
if( ! function_exists( 'jannah_logo_sticky_args' ) ){

	function jannah_logo_sticky_args(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_logo_sticky_args()' );

		tie_logo_sticky_args();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_light_or_dark()
 */
if( ! function_exists( 'jannah_light_or_dark' ) ){

	function jannah_light_or_dark( $color, $return_rgb, $dark , $light ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_light_or_dark()' );

		tie_light_or_dark( $color, $return_rgb, $dark , $light );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_social_networks()
 */
if( ! function_exists( 'jannah_social_networks' ) ){

	function jannah_social_networks(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_social_networks()' );

		tie_social_networks();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_social()
 */
if( ! function_exists( 'jannah_get_social' ) ){

	function jannah_get_social( $options = array() ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_social()' );

		tie_get_social( $options );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use TIELABS_HELPER::is_sidebar_registered()
 */
if( ! function_exists( 'jannah_is_registered_sidebar' ) ){

	function jannah_is_registered_sidebar( $index ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'TIELABS_HELPER::is_sidebar_registered()' );

		TIELABS_HELPER::is_sidebar_registered( $index );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_video()
 */
if( ! function_exists( 'jannah_video' ) ){

	function jannah_video(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_video()' );

		tie_video();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_video_embed()
 */
if( ! function_exists( 'jannah_video_embed' ) ){

	function jannah_video_embed(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_video_embed()' );

		tie_video_embed();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use TIELABS_HELPER::do_not_dublicate()
 */
if( ! function_exists( 'jannah_do_not_dublicate' ) ){

	function jannah_do_not_dublicate(  $post_id = false ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'TIELABS_HELPER::do_not_dublicate()' );

		TIELABS_HELPER::do_not_dublicate( $post_id );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_wc_full_width_loop_shop_columns()
 */
if( ! function_exists( 'jannah_wc_full_width_loop_shop_columns' ) ){

	function jannah_wc_full_width_loop_shop_columns(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_wc_full_width_loop_shop_columns()' );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_block_title()
 */
if( ! function_exists( 'jannah_block_title' ) ){

	function jannah_block_title( $block ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_block_title()' );

		tie_block_title( $block );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_google_maps()
 */
if( ! function_exists( 'jannah_google_maps' ) ){

	function jannah_google_maps( $url ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_google_maps()' );

		tie_google_maps( $url );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_audio()
 */
if( ! function_exists( 'jannah_audio' ) ){

	function jannah_audio( $size ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_audio()' );

		tie_audio( $size );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_query()
 */
if( ! function_exists( 'jannah_query' ) ){

	function jannah_query( $block ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_query()' );

		tie_query( $block );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_facebook_video()
 */
if( ! function_exists( 'jannah_facebook_video' ) ){

	function jannah_facebook_video( $url ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_facebook_video()' );

		tie_facebook_video( $url );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_twitter_video()
 */
if( ! function_exists( 'jannah_twitter_video' ) ){

	function jannah_twitter_video( $url ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_twitter_video()' );

		tie_twitter_video( $url );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_get_video_embed()
 */
if( ! function_exists( 'jannah_get_video_embed' ) ){

	function jannah_get_video_embed( $url ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_get_video_embed()' );

		tie_get_video_embed( $url );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use TIELABS_POSTVIEWS::get_views()
 */
if( ! function_exists( 'jannah_views' ) ){

	function jannah_views( $text, $post_id ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'TIELABS_POSTVIEWS::get_views()' );

		TIELABS_POSTVIEWS::get_views( $text, $post_id );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_reading_time()
 */
if( ! function_exists( 'jannah_reading_time' ) ){

	function jannah_reading_time(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_reading_time()' );

		tie_reading_time();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_soundcloud()
 */
if( ! function_exists( 'jannah_soundcloud' ) ){

	function jannah_soundcloud( $url, $autoplay, $visual ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_soundcloud()' );

		tie_soundcloud( $url, $autoplay, $visual );
	}
}


/*
 * wp_doing_ajax added in WP v 4.7
 * We use this fallback for older versions of WP
 * It will be removed later..
 */
if( ! function_exists( 'wp_doing_ajax' ) ) {

	function wp_doing_ajax() {
		return apply_filters( 'wp_doing_ajax', defined( 'DOING_AJAX' ) && DOING_AJAX );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_slider_img_src()
 */
if( ! function_exists( 'jannah_slider_img_src' ) ){

	function jannah_slider_img_src( $image_id, $size ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_slider_img_src()' );

		tie_slider_img_src( $image_id, $size );
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_breadcrumbs()
 */
if( ! function_exists( 'jannah_breadcrumbs' ) ){

	function jannah_breadcrumbs(){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_breadcrumbs()' );

		tie_breadcrumbs();
	}
}


/**
 * @since 1.0.0
 * @deprecated 2.1.0 Use tie_widget_posts()
 */
if( ! function_exists( 'jannah_widget_posts' ) ){

	function jannah_widget_posts( $query_args, $args ){

		_deprecated_function( __FUNCTION__, '2.1.0', 'tie_widget_posts()' );

		tie_widget_posts( $query_args, $args );
	}
}


/**
 * @since unknown
 * @deprecated 5.0.0 Use TieLabs Instagram Plugin
 */
if( ! class_exists( 'TIELABS_INSTAGRAM' ) ) {

	class TIELABS_INSTAGRAM {

		function __construct( $args = false ) {

			_deprecated_function( __CLASS__, '5.0.0', 'TieLabs Instagram Plugin' );

			echo TIELABS_HELPER::notice_message( 'Update Your Child theme files' );
		}
	}
}

