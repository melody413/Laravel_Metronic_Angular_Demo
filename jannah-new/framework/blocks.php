<?php
/**
 * Page builder blocks
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


// Check if the page is protected by password
if( post_password_required() ){

	echo '
		<div class="container">
			<div class="entry">'.
				get_the_password_form() .'
			</div>
		</div>
	';

	return;
}


// Get the builder data
$sections = maybe_unserialize( tie_get_postdata( 'tie_page_builder' ) );


if( ! empty( $sections ) && is_array( $sections ) ){

	do_action( 'TieLabs/Builder/before' );

	if( tie_get_postdata( 'tie_builder_breadcrumbs' ) ){
		echo '<div id="page-builder-breadcrumbs" class="container">';
			tie_breadcrumbs();
		echo '</div>';
	}

	// check if the do not duplicate option is enabled
	$is_do_not_dublicate = tie_get_postdata( 'tie_do_not_dublicate' ) ? true : false;

	$section_number = 0;

	foreach( $sections as $section ){

		$section['settings'] = ! empty( $section['settings'] ) ? $section['settings'] : array();

		$section_settings = wp_parse_args( $section['settings'], array(
			'section_title'      => '',
			'title'              => '',
			'url'                => '',
			'title_style'        => '',
			'title_icon'         => '',
			'title_color'        => '',
			'stretch_section'    => '',
			'section_width'      => '',
			'custom_class'       => '',
			'dark_skin'          => '',
			'parallax'           => '',
			'parallax_effect'    => '',
			'background_img'     => '',
			'background_video'   => '',
			'background_color'   => '',
			'predefined_sidebar' => '',
			'sidebar_position'   => '',
			'sidebar_id'         => '',
			'section_id'         => '',
		));

		$classes          = array();
		$section_id       = $section_settings['section_id'];
		$section_styles   = array();
		$internal_class   = '';
		$section_video_bg = '';
		$parallax_options = '';
		$before_content   = '';
		$after_content    = '';
		$after_sidebar    = '';
		$container_open   = '';
		$container_close  = '';
		$outer_class      = '-full';
		$block_count      = 0;
		$is_tag_open      = false;
		$count_half_box   = 0;
		$is_first_section = false;

		// Section Number
		$section_number++;

		if( $section_number == 1 ){
			$is_first_section = true;
			$classes[] = 'is-first-section';
		}

		// Section Sidebar
		$sidebar = 'full-width';
		$sidebar_position = $section_settings['sidebar_position'];

		if( $sidebar_position == 'left' ){
			$sidebar = 'sidebar-left has-sidebar';
		}
		elseif( $sidebar_position == 'right' ){
			$sidebar = 'sidebar-right has-sidebar';
		}

		$classes[] = $sidebar;

		// Section Width
		if( ! $section_settings['section_width'] ){
			$internal_class = '-normal';
			$outer_class = ' normal-width';
		}


		if( $sidebar == 'full-width' ){

			$container_open  = '
				<div class="container'. $internal_class .'">
					<div class="tie-row main-content-row">
						<div class="main-content tie-col-md-12">';

			$container_close = '
						</div><!-- .main-content /-->
					</div><!-- .main-content-row /-->
				</div><!-- .container /-->';

			if( $section_settings['section_width'] && ! empty( $section['blocks'] ) && is_array( $section['blocks'] ) ) {
				 $blocks = $section['blocks'];
				 $first_block = array_values( $blocks );
				 $first_block = array_shift( $first_block );
				 if( ! empty( $first_block['style'] ) && ( $first_block['style'] == 'slider_1' || $first_block['style'] == 'slider_2' || $first_block['style'] == 'slider_3' || $first_block['style'] == 'slider_4' ) ) {
					 $classes[] = 'first-block-is-full-width';
				 }
			}

		}
		else{
			$before_content = '
				<div class="container'. $internal_class .'">
					<div class="tie-row main-content-row">
						<div '. tie_content_column_attr( false ) .'>';

			$after_content = '</div><!-- .main-content /-->';
			$after_sidebar = '
					</div><!-- .main-content-row -->
				</div><!-- .container /-->';
		}


		// Background
		$section_bg_class = ' without-background';
		if( $section_settings['background_img'] || $section_settings['background_color'] || $section_settings['background_video'] || $section_settings['dark_skin'] ){

			$section_bg_class = ' has-background';

			// Section Dark Skin
			if( $section_settings['dark_skin'] ){
				$classes[] = 'dark-skin';
			}

			if( $section_settings['background_color'] ){
				$section_styles[] = 'background-color: '. $section_settings['background_color'] .';';
			}

			if( $section_settings['background_img'] ){
				$section_styles[] = 'background-image: url( '. $section_settings['background_img'] .');';
			}

			if( $section_settings['background_video'] ){

				$video_url = $section_settings['background_video'];

				// Check if the URL contains an mp4 file
				if( strpos( $video_url, '.mp4' ) !== false ){

					// Make sure that there is no mp4: added before
					if( substr( $video_url, 0, 4 ) !== "mp4:" ){

						// Add mp4:
						$video_url = 'mp4:'. $video_url;
					}
				}

				$section_video_bg = 'data-jarallax-video="'. $video_url .'"';
				$classes[] = 'has-video-background';
			}

			if( $section_settings['parallax'] || $section_settings['background_video'] ){ // If video is active enable the parallax

				// Get the parallax js file
				wp_enqueue_script( 'tie-js-parallax' );

				$classes[] = 'tie-parallax';

				$parallax_effect  = $section_settings['parallax_effect'] ? $section_settings['parallax_effect'] : 'scroll';
				$parallax_options = " data-type='$parallax_effect'";

			}
			else{
				$section_styles[] = 'background-size: cover;';
			}
		}

		$outer_class .= $section_bg_class;

		// Section Stretch
		if( $section_settings['stretch_section'] ){
			$outer_class .= ' is-stretch-section';
		}

		// Section Title Class
		if( $section_settings['section_title'] && $section_settings['title'] ){
			$outer_class .= ' has-title';
		}

		// Section Title Icon
		if( $section_settings['title_icon'] ){
			$outer_class .= ' has-title-icon';
		}

		// Section Custom Classes
		if( $section_settings['custom_class'] ){
			$outer_class .= ' '.$section_settings['custom_class'];
		}

		// Before Section action
		do_action( 'TieLabs/Builder/before_section', $section );
	?>

<div id="<?php echo esc_attr( $section_id ) ?>" class="section-wrapper container<?php echo esc_attr( $outer_class ) ?>">
	<div class="section-item <?php echo join( ' ', $classes ); ?>" style="<?php echo join( ' ', $section_styles ); ?>" <?php echo ( $section_video_bg.$parallax_options ) ?>>

		<?php

		// Section Title
		if( $section_settings['section_title'] && ( $section_settings['title'] || $section_settings['title_icon'] ) ){

			// Section title tags
			$before_section_title = $section_settings['section_width'] ? '<div class="container">' : '';
			$after_section_title  = $section_settings['section_width'] ? '</div>' : '';

			// Title
			$title  = '';

			if( $section_settings['title_icon'] ){
				$title .= '<span class="the-section-icon '. $section_settings['title_icon'] .'"></span>';
			}

			if( $section_settings['title'] ){
				if( ! empty( $title ) ){
					$title .= ' ';
				}
				$title .= $section_settings['title'];
			}

			// Url
			$before_section_link = $section_settings['url'] ? '<a href="'. esc_url( $section_settings['url'] ) .'" title="'.esc_attr( $section_settings['title'] ).'">' : '';
			$after_section_link  = $section_settings['url'] ? '</a>' : '';

			// CLass
			$title_class  = 'section-title ';
			$title_class .= $section_settings['title_style'] ? 'section-title-'.$section_settings['title_style'] : tie_get_box_class( 'section-title-default' );

			echo apply_filters( 'TieLabs/before_section_title', $before_section_title, $section_settings );

			echo '<h2 class="'. $title_class .'">';
			echo '<span class="the-section-title">' .$before_section_link . $title . $after_section_link.'</span>';
			echo '</h2>';

			echo apply_filters( 'TieLabs/after_section_title', $after_section_title, $section_settings );
		}

		echo ( $before_content );

		// Get the Blocks
		if( ! empty( $section['blocks'] ) && is_array( $section['blocks'] ) ) {

			foreach( $section['blocks'] as $block ){

				// Before Block Action
				do_action( 'TieLabs/Builder/before_block', $block );

				/**
				 * Reset variables
				 */
				$count          = 0;
				$after	        = '';
				$style 	        = 'default';
				$block_class 	  = '';
				$before_items	  = '<ul class="posts-items posts-list-container">';
				$after_items	  = '</ul><div class="clearfix"></div>';
				$excerpt_length = '';

				$block_count++;

				/**
				 * Default Block settings
				 */
				$block = wp_parse_args( $block, array(
					'style'               => 'default',
					'cat'                 => '',
					'title'               => '',
					'icon'                => '',
					'url'                 => '',
					'order'               => 'latest',
					'woo_cats'            => '',
					'source'              => '',
					'id'                  => '',
					'tags'                => '',
					'exclude_posts'       => '',
					'custom_slider'       => '',
					'number'              => 5 ,
					'offset'              => '',
					'pagi'                => '',
					'color'               => '',
					'dark'                => '',
					'title_length'        => '',
					'excerpt'             => '',
					'excerpt_length'      => '',
					'thumb_first'         => '',
					'thumb_small'         => '',
					'thumb_all'           => '',
					'more'                => '',
					'post_meta'           => '',
					'media_overlay'       => '',
					'read_more'           => '',
					'read_more_text'      => '',
					'filters'             => '',
					'custom_content'      => '',
					'ad_img'              => '',
					'ad_url'              => '',
					'ad_alt'              => '',
					'ad_target'           => '',
					'ad_nofollow'         => '',
					'ad_code'             => '',
					'colored_mask'        => '',
					'gradiant_overlay'    => '',
					'animate_auto'        => '',
					'slider_speed'        => '',
					'posts_category'      => '',
					'posts_review'        => '',
					'videos_list_data'    => '',
					'breaking_effect'     => '',
					'breaking_arrows'     => '',
					'lsslider'            => '',
					'revslider'           => '',
					'boxid'               => '',
					'background_position' => '',
				));


				// Version 4 Compatability
				if( empty( $block['source'] ) ) {
					$block['source'] = ! empty( $block['tags'] ) ? 'tags' : 'id';
				}

				// Custom Post Type support
				/*
				if( $block['source'] != 'id' ){
					unset( $block['id'] );
				}
				if( $block['source'] != 'tags' ){
					unset( $block['tags'] );
				}
				*/

				//echo '<pre>';
				//var_dump( $block );
				//echo '</pre>';


				/**
				 * Set the $style variable
				 */
				if( ! empty( $block['style'] ) ){

					// $style will be changed to the match the suitable loop file name
					$style = str_replace( '_', '-', $block['style'] );

					// Hold the original style
					$block['sub_style'] = $style;
				}

				// If the Section is full width
				if( $sidebar == 'full-width' ){
					$block['is_full'] = 'true';
				}

				/**
				 * Check the box id
				 */
				if( ! empty( $block['boxid'] ) ){
					$block['boxid'] = str_replace( '-', '_', $block['boxid'] );
				}

				/**
				 * The Block is a SLIDER
				 */
				if( ( strpos( $style, 'slider-' ) !== false ) || $style == 'videos-list' || $style == 'lsslider' || $style == 'revslider' ){

					$slider = str_replace( 'slider-', '', $style );

					$is_first_slider = ( $block_count == 1 ) ? true : false;

					if( $block_count != 1 && $is_tag_open && ( $slider <= 4 || $slider == 17 ) ){
						echo ( $container_close );
						$is_tag_open = false;
					}

					if( ( $slider > 4 || $slider == 'videos-list' ) && ! $is_tag_open ){
						echo ( $container_open );
						$is_tag_open = true;
					}


					// Source
					if( ! empty( $block['custom_slider'] ) ){
						$query_type = 'custom';
					}
					else{

						if( $block['source'] == 'tags' ){
							$query_type = 'tags';
						}
						else{
							$query_type = 'cat';
						}
					}


					TIELABS_HELPER::get_template_part( 'templates/featured', '', array(
						'slider_settings' => array(
							'title'               => $block['title'],
							'icon'                => $block['icon'],
							'url'                 => $block['url'],
							'slider'              => $slider,
							'featured_posts'      => true,
							'featured_auto'       => $block['animate_auto'],
							'slider_speed'        => $block['slider_speed'],
							'lsslider'            => $block['lsslider'],
							'revslider'           => $block['revslider'],
							'title_length'        => $block['title_length'],
							'excerpt_length'      => $block['excerpt_length'],
							'show_date'           => $block['post_meta'],
							'show_excerpt'        => $block['excerpt'],
							'show_category'       => $block['posts_category'],
							'show_reviews'        => $block['posts_review'],
							'query_type'          => $query_type,
							'custom_slider'       => $block['custom_slider'],
							'posts_number'        => $block['number'],
							'query_tags'          => $block['tags'],
							'query_cats'          => $block['id'],
							'exclude_posts'       => $block['exclude_posts'],
							'offset'              => $block['offset'],
							'order'               => $block['order'],
							'colored_mask'        => $block['colored_mask'],
							'gradiant_overlay'    => $block['gradiant_overlay'],
							'media_overlay'       => $block['media_overlay'],
							'bg_color'            => false,
							'bg_image'            => false,
							'bg_parallax'         => false,
							'playlist_title'      => $block['title'],
							'videos_data'         => $block['videos_list_data'],
							'slider_id'           => $block['boxid'],
							'dark_skin'           => $block['dark'],
							'color'               => $block['color'],
							'background_position' => $block['background_position'],
							'is_first_section'    => $is_first_section,
							'is_first_slider'     => $is_first_slider,
						)
					));
				}

				/**
				 * The Block is NOT a SLIDER
				 */
				else{

					if( ! $is_tag_open ){
						echo ( $container_open );
						$is_tag_open = true;
					}

					/**
					 * Blocks settings
					 */

					// Allow external modify on the block args
					if( $custom_block_style = apply_filters( 'TieLabs/block_style_'. $style .'_args', false ) ){
						extract( $custom_block_style  );
					}

					// The Default for blocks
					else{

						switch ( $style ){

							/**
							 * Block Style: Default
							 * Loop Template: loop-default.php
							 */
							case 'default':
								$block_class = 'wide-post-box top-news-box';
								break;

							/**
							 * Block Style: Default
							 * Loop Template: loop-default.php
							 */
							case 'classic-small':
								$block_class = 'small-wide-post-box wide-post-box top-news-box';
								$style       = 'default';
								break;

							/**
							 * Block Style: Big
							 * Loop Template: loop-default.php
							 */
							case 'big':
								$block_class = 'big-posts-box';
								$style       = 'default';
								break;

							/**
							 * Block Style: full_thumb
							 * Loop Template: loop-full-thumb.php
							 */
							case 'full-thumb':
					 			$excerpt_length = 75;
					 			$block_class    = 'full-width-img-news-box';
					 			break;

					 		/**
							 * Block Style: Overlay Title
							 * Loop Template: loop-overlay-title.php
							 */
							case 'overlay-title':
					 			$excerpt_length = 75;
					 			$block_class    = 'full-width-img-news-box full-overlay-title';
					 			break;

							/**
							 * Block Style: Overlay Title Center
							 * Loop Template: loop-overlay-title.php
							 */
							case 'overlay-title-center':
					 			$excerpt_length = 75;
					 			$block_class    = 'full-width-img-news-box full-overlay-title center-overlay-title';
					 			$style          = 'overlay-title';
					 			break;

							/**
							 * Block Style: li
							 * Loop Template: loop-large-first.php
							 */
							case 'li':
							 	$excerpt_length = 35;
								$block_class    = 'big-post-left-box has-first-big-post';
								$style          = 'large-first';
								break;

							/**
							 * Block Style: 1c
							 * Loop Template: loop-large-first.php
							 */
							case '1c':
							 	$excerpt_length = 15;
								$block_class    = 'big-post-top-box has-first-big-post';
								$style          = 'large-first';
								break;

							/**
							 * Block Style: 2c
							 * Loop Template: loop-large_first.php
							 */
							case '2c':
							 	$excerpt_length = 20;
								$block_class    = 'tie-col-sm-6 half-box has-first-big-post';
								$style          = 'large-first';
								break;

							/**
							 * Block Style: 1c
							 * Loop Template: loop-big-thumb.php
							 */
							case 'big-thumb':
								$block_class = 'big-post-left-box big-thumb-left-box first-post-gradient';
								break;

							/**
							 * Block Style: Grid
							 * Loop Template: loop-grid.php
							 */
							case 'grid':
								$block_class         = 'news-gallery big-first-gallery has-first-big-post';
								$before_items        = '<ul class="news-gallery-items posts-list-container">';
								$block['number']     = 13;
								$block['ajax_class'] = 'news-gallery-items';
								break;

							/**
							 * Block Style: Row
							 * Loop Template: loop-grid.php
							 */
							case 'row':
								$block_class         = 'news-gallery news-grid';
								$before_items        = '<ul class="news-gallery-items">';
								$style               = 'grid';
								$block['ajax_class'] = 'news-gallery-items';
								break;

							/**
							 * Block Style: Scroll
							 * Loop Template: loop-scroll.php
							 */
							case 'scroll':
								$block_class            = 'scrolling-box';
								$before_items           = tie_get_ajax_loader( false ) .'<div class="scrolling-slider scrolling-box-slider">';
								$after_items            = '</div>';
								$block['pagi']          = false;
								$block['filters']       = false;
								$block['scrolling_box'] = true;

								// Enqueue the Sliders Js file
								wp_enqueue_script( 'tie-js-sliders' );

								break;

							/**
							 * Block Style: Scroll2
							 * Loop Template: loop-scroll_2.php
							 */
							case 'scroll-2':
								$block_class            = 'scrolling-box scroll-2-box';
								$before_items           = tie_get_ajax_loader( false ) .'<div class="scrolling-slider">';
								$after_items            = '</div>';
								$block['pagi']          = false;
								$block['filters']       = false;
								$block['scrolling_box'] = true;

								// Enqueue the Sliders Js file
								wp_enqueue_script( 'tie-js-sliders' );

								break;

							/**
							 * Block Style: Mini
							 * Loop Template: loop-mini.php
							 */
							case 'mini':
								$excerpt_length	= 12;
								$block_class    = 'mini-posts-box';
								break;

							/**
							 * Block Style: Content
							 * Loop Template: loop-content.php
							 */
							case 'content':
								$block_class = 'full-width-img-news-box';
								break;

							/**
							 * Block Style: Timeline
							 * Loop Template: loop-timeline.php
							 */
							case 'timeline':
								$excerpt_length           = 15;
								$block_class              = 'wide-post-box timeline-box';
								$block['order']           = false;
								$GLOBALS['timeline_time'] = false;
								break;

							/**
							 * Block Style: first_big
							 * Loop Template: loop-large_above.php
							 */
							case 'first-big':
								$block_class 	= 'miscellaneous-box first-post-gradient has-first-big-post';
								$style        = 'large-above';
								break;

							/**
							 * Block Style: Slider
							 * Loop Template: loop-slider.php
							 */
							case 'slider':
								$block_class = 'category-featured-posts';
								break;

							/**
							 * Block Style: Slider
							 * Loop Template: loop-slider.php
							 */
							case 'breaking':
								$block_class = 'breaking-news-outer';
								break;

							/**
							 * Block Style: Tabs
							 */
							case 'tabs':
								$block_class = 'tabs-container-wrapper tabs-box has-first-big-post flex-tabs container-wrapper';
								break;

							/**
							 * Block Style: Ad
							 */
							case 'ad':
								$block_class = 'stream-item-mag stream-item';
								break;

							/**
							 * Block Style: Ad_50
							 */
							case 'ad-50':
								$block_class = 'stream-item-mag stream-item tie-col-sm-6 half-box';
								break;

							/**
							 * Block Style: Code
							 */
							case 'code':
								$block['pagi']    = false;
								$block['filters'] = false;
								$block_class      = 'block-custom-content';
								break;

							/**
							 * Block Style: Code_50
							 */
							case 'code-50':
								$block['pagi']    = false;
								$block['filters'] = false;
								$block_class      = 'block-custom-content-50 tie-col-sm-6 half-box';
								break;

							/**
							 * Block Style: woocommerce
							 */
							case 'woocommerce':
								$block_class         = 'latest-poroducts-box latest-poroducts-normal-box woocommerce';
								$block_ul_class      = '';
								$block['filters']    = false;
								$block['ajax_class'] = 'products';

								if( $sidebar == 'full-width' ){

									// WooCommerce 3.3.0
									if( function_exists( 'wc_reset_loop' ) ){
										wc_reset_loop();
									}

									add_filter( 'loop_shop_columns', array( 'TIELABS_WOOCOMMERCE', 'full_width_loop_shop_columns' ), 99, 1 );
								}
								else{

									// WooCommerce 3.3.0
									if( function_exists( 'wc_reset_loop' ) ){
										wc_reset_loop();
									}

									remove_filter( 'loop_shop_columns', array( 'TIELABS_WOOCOMMERCE', 'full_width_loop_shop_columns'), 99, 1 );
								}

								break;

							/**
							 * Block Style: woocommerce-slider
							 */
							case 'woocommerce-slider':
								$block_class            = 'scrolling-box latest-poroducts-box latest-poroducts-slider-box woocommerce';
								$block_ul_class         = ' scrolling-slider';
								$block['style']         = 'woocommerce';
								$block['pagi']          = false;
								$block['filters']       = false;
								$block['scrolling_box'] = true;

								// Enqueue the Sliders Js file
								wp_enqueue_script( 'tie-js-sliders' );

								break;


							default:
								//$style = false;
								break;
						}
					}

					// Dark Skin Class
					if( ! empty( $block['dark'] ) ){
						$block_class .= ' box-dark-skin dark-skin';
					}

					// Content Only without wrapper
					if( ! empty( $block['content_only'] ) ){
						$block_class .= ' content-only';
					}

					// Media Overlay Class
					if( ! empty( $block['media_overlay'] ) ){
						$block_class .= ' media-overlay';
					}

					// Custom Excerpt Length
					if( empty( $block['excerpt_length'] ) ){
						$block['excerpt_length'] = $excerpt_length;
					}

					// Doesn't support custom colors
					if( $block['style'] != 'ad_50' && $block['style'] != 'ad' ){

						// Custom Color Class
						if( ! empty( $block['color'] ) ){
							$block_class .= ' has-custom-color';
						}

						// Custom Bg Color Class
						if( ! empty( $block['bgcolor'] ) && empty( $block['content_only'] ) ){
							$block_class .= ' has-custom-bg-color';
						}
					}



					// Classes for the 50% blocks
					if( $block['style'] == '2c' || $block['style'] == 'ad_50' || $block['style'] == 'code_50' ){

						$count_half_box++;

						if( $count_half_box == 1 ){ // the first half
							$block_class .= ' first-half-box';
						}
						else{ // the second half

							$block_class .= ' second-half-box';
							$after = '<div class="clearfix half-box-clearfix"></div>';

							//Reset the 2 columns counter
							$count_half_box = 0;
						}

					}
					else{
						$count_half_box = 0;
					}


					// Get the block query
					$block = apply_filters( 'TieLabs/Builder/Block/args', $block );

					$query_args = $block;

					// --
					// To avoid SQL_CALC_FOUND_ROWS quries we request the number +1 and use it to detect if there is more pages
					if( ! empty( $query_args['pagi'] ) && $block['pagi'] != 'numeric' ){
						unset( $query_args['pagi'] );
						if( ! empty( $query_args['number'] ) ){
							$query_args['number'] = $query_args['number'] + 1;
						}
					}

					//--
					$block_query = tie_query( $query_args );

					$pagination_data = ! empty( $block['pagi'] ) ? ' data-current="1"' : '';

					?>


				<div id="tie-<?php echo esc_attr( $block['boxid'] ) ?>" class="mag-box <?php echo esc_attr( $block_class ) ?>"<?php echo ( $pagination_data ) ?>>
				<?php


			if( ! empty( $style ) ):

				/*-----------------------------------------------------------------------------------*/
				# Tabs Block
				/*-----------------------------------------------------------------------------------*/
				if( $style == 'tabs' ):

					$home_tabs = empty( $block['cat'] ) ? array() : $block['cat']; ?>

					<div class="tabs-widget">
						<div class="tabs-wrapper">

							<?php

							if( ! empty( $home_tabs ) ){

								echo '<ul class="tabs is-flex-tabs">';
								foreach ( $home_tabs as $cat ){
									echo'<li><a href="#cat-tab-'. $block['boxid'] .'-'. $cat .'">'. get_the_category_by_ID( $cat ) .'</a></li>';
								}
								echo '</ul>';
							}

							$block['number'] = ! empty( $block['number'] ) ? $block['number'] : 5;

							$cat_num = 0;
							foreach ( $home_tabs as $cat ):

								$count = 0;
								$cat_num ++;

								$args = array(
									'id'     => $cat,
									'number' => $block['number'],
									'order'  => $block['order'],
								);

								$cat_query = tie_query( $args ); ?>

								<div id="cat-tab-<?php echo esc_attr( $block['boxid'] .'-'. $cat ) ?>" class="tab-content tab-wrap-<?php echo esc_attr( $cat_num ); ?>">
									<div class="tab-content-wrap">
										<div class="mag-box big-post-left-box">
											<div class="container-wrapper">
												<div class="mag-box-container clearfix">

												<?php
													if( $cat_query->have_posts() ){
														echo ( $before_items );
															while ( $cat_query->have_posts() ){

																$cat_query->the_post();
																$count++;

																$b_args = array(
																	'block' => $block,
																	'count' => $count,
																);

																TIELABS_HELPER::get_template_part( 'templates/loops/loop', 'large-first', $b_args );

																// Do not dublicate posts
																if( $is_do_not_dublicate ){
																	TIELABS_HELPER::do_not_dublicate( get_the_ID() );
																}
															}
														echo ( $after_items );
													}
												?>

												</div><!-- .mag-box-container /-->
											</div><!-- .container-wrapper /-->
										</div><!-- .mag-box /-->
									</div><!-- .tab-content-wrap /-->
								</div><!-- .tab-content /-->
							<?php endforeach; ?>
						</div><!-- .tabs-wrapper-animated /-->
					</div><!-- .tabs-widget /-->
			    <?php

				/*-----------------------------------------------------------------------------------*/
				# Breeaking News
				/*-----------------------------------------------------------------------------------*/
				elseif( $style == 'breaking' ):

					TIELABS_HELPER::get_template_part( 'templates/breaking-news', '', array(
						'type'            => 'block',
						'breaking_id'     => $block['boxid'],
						'breaking_title'  => $block['title'],
						'breaking_effect' => $block['breaking_effect'],
						'breaking_arrows' => $block['breaking_arrows'],
						'breaking_type'   => '',
						'breaking_block'  => $block,
					));

				/*-----------------------------------------------------------------------------------*/
				 # Ad and Ad 50% Block
				/*-----------------------------------------------------------------------------------*/
				elseif( $style == 'ad' || $style == 'ad-50' ):
					?>

					<div class="container-wrapper">
						<?php
							// Get the Ad banner Image
							if( ! empty( $block['ad_img'] ) ){

								$ad_image = $block['ad_img'];
								$target   = empty( $block['ad_target'] )   ? '' : ' target="_blank"';
								$nofollow = empty( $block['ad_nofollow'] ) ? '' : ' rel="nofollow noopener"';
								$alt      = empty( $block['ad_alt'] )      ? '' : esc_attr( $block['ad_alt'] );
								$url      = apply_filters( 'TieLabs/ads_url', empty( $block['ad_url'] ) ? '' : esc_url( $block['ad_url'] ) );

								echo "<a href=\"$url\" title=\"$alt\"$target$nofollow>";
								echo apply_filters( "TieLabs/block/ad_image", "<img src=\"$ad_image\" alt=\"$alt\" width=\"728\" height=\"90\">", $ad_image ) ;
								echo"</a>";
							}

							// Get the Ad Custom Code
							elseif( ! empty( $block['ad_code'] ) ){
								echo do_shortcode( apply_filters( 'TieLabs/block/ad_code', $block['ad_code'] ) );
							}
						?>
					</div><!-- .container-wrapper /-->
				<?php

				/*-----------------------------------------------------------------------------------*/
				# All Other blocks
				/*-----------------------------------------------------------------------------------*/
				else: ?>

					<div class="container-wrapper">

						<?php
							// Get The Blcok Title
							tie_block_title( $block );
						?>

						<div class="mag-box-container clearfix">

							<?php

							// Ad and Ad 50% Block
							if( $style == 'code' || $style == 'code-50' ){

								// Get the custom content code and apply the content filters
								if( ! empty( $block['custom_content'] ) ){

									// Fix the_content issue with Elementor
									if( defined( 'ELEMENTOR_PLUGIN_BASE' ) ){
										if( apply_filters( 'TieLabs/Builder/disable_elementor', true ) ){
											$is_built_with_elementor = \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() );
											if( $is_built_with_elementor ){
												\Elementor\Plugin::$instance->frontend->remove_content_filter();
											}
										}
									}

									echo '
										<div class="entry clearfix">'. apply_filters( 'the_content', $block['custom_content'] ) . '</div>
									';

								}
							}

							// WooCommerce Block
							elseif( ( $style == 'woocommerce' || $style == 'woocommerce-slider' ) ){

								if( TIELABS_WOOCOMMERCE_IS_ACTIVE ){

									if( $style == 'woocommerce-slider'){
										tie_get_ajax_loader();
									}

									echo '<ul class="products'. $block_ul_class .'">';

									if ( $block_query->have_posts() ){
										while ( $block_query->have_posts() ):
											$block_query->the_post();
											wc_get_template_part( 'content', 'product' );
										endwhile;
									}
									else {
										esc_html_e( 'No products found', TIELABS_TEXTDOMAIN );
									}

									echo '</ul>';
								}
								else{
									TIELABS_HELPER::notice_message( esc_html__( 'This Block requires the WooCoomerce plugin.', TIELABS_TEXTDOMAIN ) );
								}

							}

							// Posts Blocks
							else{

								if( $block_query->have_posts() ){
									echo ( $before_items );
									while ( $block_query->have_posts() ){

										$block_query->the_post();
										$count++;

										if( $count > $block['number'] ){
											break;
										}

										$b_args = array(
											'block' => $block,
											'count' => $count,
										);

										TIELABS_HELPER::get_template_part( 'templates/loops/loop', $style, $b_args );

										// Do not dublicate posts
										if( $is_do_not_dublicate ){
											TIELABS_HELPER::do_not_dublicate( get_the_ID() );
										}
									}

									echo ( $after_items );
								}
							}

						?>

						</div><!-- .mag-box-container /-->


						<?php

							// Pagination is active
							if ( ! empty( $block['pagi'] ) ){

								// Need to check if there is at least on more page
								$show_pagination = false;

								// Non Ajax Request
								if( $block['pagi'] == 'numeric' ){
									$max_page = ! empty( $block_query->query_vars['new_max_num_pages'] ) ? $block_query->query_vars['new_max_num_pages'] : $block_query->max_num_pages;
									$show_pagination = ( $max_page > 1 ) ? true : false;
								}
								// Ajax Request
								elseif( ! empty( $block_query->posts ) && is_array( $block_query->posts ) ){
									if( count( $block_query->posts ) > $block['number'] ){
										$show_pagination = true;
									}
								}

								//--
								if ( $show_pagination ){

									// Numeric Pagination
									if( $block['pagi'] == 'numeric' ){
										TIELABS_PAGINATION::show( array( 'query' => $block_query, 'type' => 'numeric' ) );
									}

									// Show more button Pagination
									elseif( $block['pagi'] == 'show-more' ){
										echo'<a class="block-pagination next-posts show-more-button" data-text="'. esc_html__( 'Show More', TIELABS_TEXTDOMAIN ) .'">'. esc_html__( 'Show More', TIELABS_TEXTDOMAIN ) .'</a>';
									}

									// Load more button Pagination
									elseif( $block['pagi'] == 'load-more' ){
										echo '<a class="block-pagination next-posts show-more-button load-more-button" data-text="'. esc_html__( 'Load More', TIELABS_TEXTDOMAIN ) .'">'. esc_html__( 'Load More', TIELABS_TEXTDOMAIN ) .'</a>';
									}

									// Next and Prev buttons Pagination
									elseif( $block['pagi'] == 'next-prev-buttons' ){
										echo '
											<div class="pages-nav">
												<div class="pages-numbers pages-standard">
													<span class="first-page first-last-pages">
														<a class="block-pagination prev-posts pagination-disabled" href="#">
															<span class="pagination-icon" aria-hidden="true"></span>
															'. esc_html__( 'Previous', TIELABS_TEXTDOMAIN ) .'
														</a>
													</span>
													<span class="last-page first-last-pages">
														<a class="block-pagination next-posts" href="#">
															<span class="pagination-icon" aria-hidden="true"></span>
															'. esc_html__( 'Next', TIELABS_TEXTDOMAIN ) .'
														</a>
													</span>
												</div>
											</div>
										';
									}
								}
							}
						?>

					</div><!-- .container-wrapper /-->

				<?php endif; ?>

			</div><!-- .mag-box /-->

			<?php

				// Block Js Variable
				if( ( ! empty( $block['pagi'] ) && $block['pagi'] != 'numeric' ) || ! empty( $block['filters'] ) ){

					$unwanted_keys = array(
						'title'   => '',
						'style'   => '',
						'url'     => '',
						'color'   => '',
						'ad_img'  => '',
						'ad_url'  => '',
						'ad_alt'  => '',
						'ad_code' => '',
						'videos'  => '',
						'boxid'   => '',
						'custom_content'   => '',
						'videos_list_data' => '',
					);
					$js_block = array_filter( $block );
					$js_block = array_diff_key( $js_block, $unwanted_keys );
					$js_block['style'] = $style;

					// Avoid PHP Warnings in the AJAX requests
					if( empty( $js_block['title_length'] ) ){
						$js_block['title_length'] = '';
					}
					if( empty( $js_block['excerpt_length'] ) ){
						$js_block['excerpt_length'] = '';
					}
					if( empty( $js_block['media_overlay'] ) ){
						$js_block['media_overlay'] = '';
					}
					if( empty( $js_block['read_more_text'] ) ){
						$js_block['read_more_text'] = '';
					}

					?>

					<script>var js_tie_<?php echo esc_js($block['boxid']) ?> = <?php echo wp_json_encode( $js_block ) ?>;</script>

					<?php
				}

			endif;

				echo ( $after );

			} // else | it is not a slider
		} // Foreach
	} // if

	?>

		<?php echo ( $after_content ); ?>

			<?php
			if( ! empty( $sidebar_position ) && $sidebar_position != 'full' ):

				if( ! empty( $section['settings']['predefined_sidebar'] ) ){
					if( ! empty( $section['settings']['sidebar_id'] ) ){
						$sidebar = $section['settings']['sidebar_id'];
					}
					else{
						$sidebar = tie_get_option( 'sidebar_page' );

						// Default sidebar if there is no a custom sidebar
						if( empty( $sidebar ) || ( ! empty( $sidebar ) && ! TIELABS_HELPER::is_sidebar_registered( $sidebar ) ) ) {
							 $sidebar = 'primary-widget-area';
						}
					}
				}
				else{
					$sidebar = $section_id;
				}


				// Show the sidebar if contains Widgets
				if( is_active_sidebar( $sidebar ) ){

					$sidebar_class = 'sidebar tie-col-md-4 tie-col-xs-12 normal-side';

					if( ! empty( $section_settings['sticky_sidebar'] ) ) {
						$sidebar_class .= ' is-sticky';
					}
				?>

					<aside class="<?php echo esc_attr( $sidebar_class ); ?>" aria-label="<?php esc_html_e( 'Primary Sidebar', TIELABS_TEXTDOMAIN ); ?>">
						<div class="theiaStickySidebar">
							<?php dynamic_sidebar( $sidebar ); ?>
						</div><!-- .theiaStickySidebar /-->
					</aside><!-- .sidebar /-->
				<?php
				}
			endif;
			?>

			<?php echo ( $after_sidebar ); ?>

			<?php
				if( $is_tag_open ){
					echo ( $container_close );
					$is_tag_open = false;
				}
			?>
	</div><!-- .section-item /-->
</div><!-- .<?php echo esc_attr( $section_id ) ?> /-->

	<?php

		wp_reset_postdata();

	} // Foreach
}
