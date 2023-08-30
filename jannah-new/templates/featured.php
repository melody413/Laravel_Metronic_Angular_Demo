<?php
/**
 * Sliders template
 *
 * This template can be overridden by copying it to your-child-theme/templates/featured.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


$is_do_not_dublicate = false;

// Page builder slider
if( ( is_page() || is_front_page() ) && tie_get_postdata( 'tie_builder_active' ) ){

	// check if the do not duplicate option is enabled
	$is_do_not_dublicate = tie_get_postdata( 'tie_do_not_dublicate' ) ? true : false;
}

// Category slider
elseif( is_category() ){

	$category_id = get_query_var( 'cat' );

	// Don't duplicate posts
	$is_do_not_dublicate = tie_get_category_option( 'do_not_dublicate' ) ? true : false;

	// Cache field key
	$cache_key = apply_filters( 'TieLabs/cache_key', '-slider-cat-'.$category_id );

	$slider_settings = array(
		'slider'           => tie_get_category_option( 'featured_posts_style' ),
		'featured_auto'    => tie_get_category_option( 'featured_auto' ),
		'slider_speed'     => tie_get_category_option( 'slider_speed' ),
		'lsslider'         => tie_get_category_option( 'lsslider' ),
		'revslider'        => tie_get_category_option( 'revslider' ),
		'featured_posts'   => tie_get_category_option( 'featured_posts' ),
		'title_length'     => tie_get_category_option( 'featured_posts_title_length' ),
		'excerpt_length'   => tie_get_category_option( 'featured_posts_excerpt_length' ),
		'show_date'        => tie_get_category_option( 'featured_posts_date' ),
		'show_excerpt'     => tie_get_category_option( 'featured_posts_excerpt' ),
		'show_category'    => tie_get_category_option( 'featured_posts_category' ),
		'show_reviews'     => tie_get_category_option( 'featured_posts_review' ),
		'query_type'       => tie_get_category_option( 'featured_posts_query' ),
		'custom_slider'    => tie_get_category_option( 'featured_posts_custom' ),
		'posts_number'     => tie_get_category_option( 'featured_posts_number' ),
		'offset'           => tie_get_category_option( 'featured_posts_offset' ),
		'order'            => tie_get_category_option( 'featured_posts_order' ),
		'colored_mask'     => tie_get_category_option( 'featured_posts_colored_mask' ),
		'gradiant_overlay' => tie_get_category_option( 'featured_posts_gradiant_overlay' ),
		'media_overlay'    => tie_get_category_option( 'featured_posts_media_overlay' ),
		'playlist_title'   => tie_get_category_option( 'featured_videos_list_title' ),
		'videos_data'      => tie_get_category_option( 'featured_videos_list_data' ),
		'dark_skin'        => tie_get_category_option( 'dark_skin' ),
		'slider_id'        => 'category-videos',
		'color'            => false,
	);

}


if( ! empty( $slider_settings ) ){

	// Testing
	$is_lazyload = false; //tie_get_option( 'lazy_load' );

	$slider_settings = wp_parse_args( $slider_settings, array(
		'title'               => false,
		'icon'                => false,
		'url'                 => false,
		'featured_auto'       => false,
		'slider_speed'        => false,
		'lsslider'            => false,
		'revslider'           => false,
		'featured_posts'      => false,
		'title_length'        => '',
		'excerpt_length'      => 12,
		'show_date'           => false,
		'show_excerpt'        => false,
		'show_category'       => false,
		'show_reviews'        => false,
		'query_type'          => false,
		'custom_slider'       => false,
		'posts_number'        => 10,
		'query_tags'          => false,
		//'query_posts'       => false,
		//'query_pages'       => false,
		'query_cats'          => false,
		'exclude_posts'       => false,
		'offset'              => false,
		'order'               => false,
		'colored_mask'        => false,
		'gradiant_overlay'    => false,
		'media_overlay'       => false,
		'playlist_title'      => false,
		'videos_data'         => false,
		'slider_id'           => false,
		'dark_skin'           => false,
		'color'               => false,
		'background_position' => false,
		'is_first_section'    => false,
		'is_first_slider'     => false,
	));

	extract( $slider_settings );

	// Get the LayerSlider
	if( $lsslider && TIELABS_LS_Sliders_IS_ACTIVE ){
		echo '<div class="third-party-slider">';
			layerslider( $lsslider );
		echo '</div>';
	}

	// Get the Revolution slider
	elseif( $revslider && TIELABS_REVSLIDER_IS_ACTIVE ){
		echo '<div class="third-party-slider">';
			putRevSlider( $revslider );
		echo '</div>';
	}

	// Get the main slider
	elseif( $featured_posts ){


		// Default Images Size
		$image_size    = apply_filters( 'TieLabs/Sliders/img_grid_size', TIELABS_THEME_SLUG.'-image-post', $slider );
		$full_img_size = apply_filters( 'TieLabs/Sliders/img_full_size', 'full', $slider );

		// Reset the posts counter
		$count = 0;
		$grid_count = 0;

		$slider_class = '';

		switch( $slider ){

			case 1:
				$slider_class = 'fullwidth-slider-wrapper wide-slider-wrapper';
				$image_size   = $full_img_size;
				break;

			case 2:
				$slider_class = 'wide-slider-three-slids-wrapper';
				break;

			case 3:
				$slider_class = 'wide-next-prev-slider-wrapper wide-slider-wrapper centered-title-slider';
				$image_size   = $full_img_size;
				break;

			case 4:
				$slider_class = 'wide-slider-with-navfor-wrapper wide-slider-wrapper centered-title-slider';
				$image_size   = $full_img_size;
				break;

			case 5:
				$slider_class = 'boxed-slider-three-slides-wrapper boxed-slider';
				break;

			case 6:
				$slider_class = 'boxed-five-slides-slider boxed-slider';
				break;

			case 7:
				$slider_class = 'boxed-four-taller-slider boxed-slider';
				break;

			case 8:
				$slider_class = 'boxed-slider-wrapper boxed-slider';
				$image_size   = $full_img_size;
				break;

			case 9:
				$slider_class = 'grid-2-big boxed-slider grid-slider-wrapper';
				$posts_per_slide = 2;
				break;

			case 10:
				$slider_class = 'grid-3-slides boxed-slider grid-slider-wrapper';
				$posts_per_slide = 3;
				break;

			case 11:
				$slider_class = 'grid-4-slides boxed-slider grid-slider-wrapper';
				$posts_per_slide = 4;
				break;

			case 12:
				$slider_class = 'grid-5-in-rows boxed-slider grid-slider-wrapper';
				$posts_per_slide = 5;
				break;

			case 13:
				$slider_class = 'grid-5-big-centerd grid-5-slider boxed-slider grid-slider-wrapper';
				$posts_per_slide = 5;
				break;

			case 14:
				$slider_class = 'grid-5-first-big grid-5-slider boxed-slider grid-slider-wrapper';
				$posts_per_slide = 5;
				break;

			case 15:
				$slider_class = 'grid-6-slides boxed-slider grid-slider-wrapper';
				$posts_per_slide = 6;
				break;

			case 16:
				$slider_class = 'grid-4-big-first-half-second boxed-slider grid-slider-wrapper';
				$posts_per_slide = 4;
				break;

			case 17:
				$slider_class = 'grid-3-slides boxed-slider grid-slider-wrapper grid-3-slides-half-first';
				$posts_per_slide = 3;
				break;

			case 50:
				$slider_class = 'wide-slider-with-navfor-wrapper wide-slider-wrapper slider-vertical-navigation';
				$image_size   = $full_img_size;
				break;
		}


		// Enqueue the Sliders Js file if it is needed only
		if( empty( $posts_per_slide ) || $posts_number > $posts_per_slide ){
			wp_enqueue_script( 'tie-js-sliders' );
		}
		// Lazy image loaded via the slick slider js, as it is not loaded we need to disable is_lazyload
		else{
			$is_lazyload = false;
		}

		// Check the Cache
		if( tie_get_option( 'jso_cache' ) && ! empty( $cache_key ) && false !== get_transient( $cache_key ) /*&& ! ( defined( 'WP_CACHE' ) && WP_CACHE )*/ ){
			$cached_slider = get_transient( $cache_key );
		}

		else{

			ob_start();

			// Slider query
			$args         = array();
			$slider_items = array();

			// If this is not a video list, we need to check the quries
			if( $slider != 'videos-list' && $slider != 'videos_list' ){

				// Custom Slider
				if( ! empty( $query_type ) && $query_type == 'custom' ){

					$get_custom_slider = get_post_custom( $custom_slider );
					$slider_items      = ( ! empty( $get_custom_slider['custom_slider'][0] )) ? maybe_unserialize( $get_custom_slider['custom_slider'][0] ) : '';

					if( ! empty( $slider_items ) && is_array( $slider_items ) ) {
						foreach ( $slider_items as $slide_id => $slide_item ){
							$slider_items[ $slide_id ]['slide_title'] = $slide_item['title'];
							$slider_items[ $slide_id ]['slide_image'] = $is_lazyload ? 'data-lazy="'. tie_slider_img_src( $slide_item['id'], $image_size ) .'"' : 'style="'. tie_slider_img_src_bg( $slide_item['id'], $image_size ) .'"';
							$slider_items[ $slide_id ]['slide_link']  = esc_url( $slide_item['link'] );

							if( $show_excerpt ){
								$slider_items[ $slide_id ]['slide_caption'] = '<div class="thumb-desc">'. $slide_item['caption'] .'</div><!-- .thumb-desc -->';
							}

						}
					}
				}
				else{

					$args['number'] = $posts_number;
					$args['offset'] = $offset;
					$args['order']  = $order;


					// If the current page is category
					if( is_category() ){

						$args['id'] = $category_id;

						if( ! empty( $query_type ) && $query_type == 'random' ){
							$args['order'] = 'rand';
						}
					}

					// Block in the page builder
					else{

						// Get posts by tags
						if( ! empty( $query_type ) && $query_type == 'tags' ){
							$args['tags'] = $query_tags;
						}

						/*
						# Get Selective posts
						elseif( $query_type == 'post' ){
							$args['posts'] = $query_posts;
						}

						# Get Selective Pages
						elseif( $query_type == 'page' ){
							$args['pages'] = $query_pages;
						}
						*/

						# Get Posts by categories
						elseif( $query_cats ){
							$args['id'] = $query_cats;
						}
					}

					// Exclude posts by IDs
					if( $exclude_posts ){
						$args['exclude_posts'] = $exclude_posts;
					}

					// Run the Query
					// Related Posts Mode in the Single Post Page
					if( ! empty( $related_mode ) ){
						$slider_query = new wp_query( $related_mode );
					}
					else{
						$slider_query = tie_query( $args );
					}

					// ----------------------------- EXPERIMENT ---------------------------------------------------------
					$slider_preload_images = array();
					$slides_preload_images_number = 0;
					// ----------------------------- EXPERIMENT ---------------------------------------------------------

					while ( $slider_query->have_posts() ){

						// Get the post ID
						$slider_query->the_post();
						$slider_post_id = get_the_ID();

						// ----------------------------- EXPERIMENT ---------------------------------------------------------
						// Get the bakground image
						// Testing preloading first slider images
						// $background = $is_lazyload ? 'data-lazy="'. tie_thumb_src( $image_size ) .'"' : 'style="'. tie_thumb_src_bg( $image_size ) .'"';
						$the_image = tie_thumb_src( $image_size );

						if( $is_lazyload ){
							$background = 'data-lazy="'. $the_image .'"';
						}
						else{
							$background = ! empty( $the_image ) ? 'url('. $the_image .')' : 'none';
							$background = 'style="'. esc_attr( 'background-image: '. $background ) .'"';
						}

						if( $the_image && $slides_preload_images_number < 6 ){
							$slider_preload_images[] = $the_image;
						}

						$slides_preload_images_number++;
						// ----------------------------- EXPERIMENT ---------------------------------------------------------

						// Add the slide data
						$slider_items[ $slider_post_id ]['slide_title'] = tie_get_title( $title_length );
						$slider_items[ $slider_post_id ]['slide_image'] = $background;
						$slider_items[ $slider_post_id ]['slide_link']  = get_permalink();

						// Slide Meta
						$slide_meta  = '';
						$slide_meta .= tie_get_trending_icon();
						$slide_meta  = apply_filters( 'TieLabs/Slider/post_meta/before_date', $slide_meta );
						$slide_meta .= $show_date ? tie_get_time( true ) : '';
						$slide_meta  = apply_filters( 'TieLabs/Slider/post_meta/after_date', $slide_meta );

						if( ! empty( $slide_meta ) ){
							$slider_items[ $slider_post_id ]['slide_meta'] = $slide_meta;
						}

						// Excerpt
						if( $show_excerpt ){
							$slider_items[ $slider_post_id ]['slide_caption'] = '<div class="thumb-desc">'. tie_get_excerpt( $excerpt_length ) .'</div><!-- .thumb-desc -->';
						}

						// Primary Category
						if( $show_category ){
							$slider_items[ $slider_post_id ]['slide_categories'] = tie_get_category();
						}

						// Review
						if( $show_reviews ){
							$slider_items[ $slider_post_id ]['review_score'] = tie_get_score( 'large' );
						}

						// Do not duplicate posts For Page Builder
						if( $is_do_not_dublicate ){
							TIELABS_HELPER::do_not_dublicate( $slider_post_id );
						}

						// Do not duplicate posts For Posts
						if( ! empty( $related_mode ) ){
							tie_single_post_do_not_dublicate( $slider_post_id );
						}

					} // While

					// ----------------------------- EXPERIMENT ---------------------------------------------------------
					if( ( is_home() || is_front_page() ) && class_exists( 'JANNAH_OPTIMIZATION_GENERAL' ) && ! empty( $slider_preload_images ) ){
						$home_slider_key = apply_filters( 'TieLabs/cache_key', '-home-slider' );
						if( false === get_transient( $home_slider_key ) ){
							set_transient( $home_slider_key, $slider_preload_images );
						}
					}
					// ----------------------------- EXPERIMENT ---------------------------------------------------------

					wp_reset_postdata();
				}
			} // is not Video PlayList


			// Colored Mask class
			$slider_class .= $colored_mask ? ' slide-mask' : '';

			// slide class
			$single_slide_class = ( $slider > 8 && $slider < 50 ) ? 'grid-item' : 'slide';

			// LazyLoad is enaled
			if( $is_lazyload ){
				$single_slide_class .= ' lazy-bg';
			}


			$slider_wrapper_class = '';

			// Media Overlay
			if( $media_overlay && $query_type != 'custom' ){
				$slider_wrapper_class .= ' media-overlay';
			}

			// Disable Gradient Overlay
			if( $gradiant_overlay && ! $colored_mask ){
				$slider_wrapper_class .= ' is-slider-overlay-disabled';
			}

			// Video list parent box class
			if( $slider == 'videos-list' || $slider == 'videos_list' ){
				$slider_wrapper_class .= ' tie-video-main-slider';

				if( $dark_skin ){
					$slider_wrapper_class .= ' box-dark-skin dark-skin';
				}
			}

			// Slider data attr.
			$slider_data_attr = '';

			// AutoPlay
			$slider_data_attr .= ( $featured_auto ) ? ' data-autoplay="true"' : '';

			// Slider Speed
			$slider_data_attr .= ( $slider_speed ) ? ' data-speed="'. $slider_speed .'"' : ' data-speed="3000"';

			// Common slider markup
      $lazy_or_no_content = $is_lazyload ? '<div %2$s><img loading="lazy" %1$s src="'. tie_lazyload_placeholder('slider') .'" width="780" height="470" alt="%4$s"><div class="slide-bg"></div>' : '<div %1$s %2$s>';

      $before_slider = $lazy_or_no_content . '
					<a href="%3$s" class="all-over-thumb-link" aria-label="%4$s"></a>
					<div class="thumb-overlay">';

						if( $media_overlay && $query_type != 'custom' ){
							$before_slider .= '
								<span class="tie-icon tie-media-icon"></span>
							';
						}

						$after_slider = '
					</div><!-- .thumb-overlay /-->
				</div><!-- .slide || .grid-item /-->
			';

			$slide_title_html = '
				<h2 class="thumb-title"><a href="%1$s">%2$s</a></h2>
			'; ?>

			<section id="tie-<?php echo esc_attr( $slider_id ) ?>" class="slider-area mag-box<?php echo esc_attr( $slider_wrapper_class ) ?>">

				<?php

				// Video Play List
				if( $slider == 'videos-list' || $slider == 'videos_list' ){

					if( $videos_data ){

						$args = array(
							'videos_data' => $videos_data,
		 					'title'       => $playlist_title,
		 					'id'          => $slider_id,
		 					'color'       => $color,
						);

						TIELABS_HELPER::get_template_part( 'templates/videos-list', '', $args );
					}

				}
				else{

					// Slider ID
					$slider_wrapper_id = 'tie-main-slider-'. esc_attr( $slider .'-'.$slider_id );

					// Get The Blcok Title
					if( $slider_settings['title'] != 'Block Title' && $slider_settings['title'] != esc_html__( 'Block Title', TIELABS_TEXTDOMAIN ) ){ // don't show it if it uses the placeholder title
						tie_block_title( $slider_settings );
					}

					// Background position
					if( ! empty( $slider_settings['background_position'] ) ){
						$background_position = $slider_settings['background_position'];
						$background_position = "#$slider_wrapper_id .slide-bg, #$slider_wrapper_id .slide{ background-position: $background_position; }";
						TIELABS_STYLES::print_inline_css( $background_position );
					}

					?>

				<div class="slider-area-inner">

					<div id="<?php echo $slider_wrapper_id ?>" class="tie-main-slider main-slider <?php echo esc_attr( $slider_class ) ?> tie-slick-slider-wrapper" data-slider-id="<?php echo esc_attr( $slider ) ?>" <?php echo ( $slider_data_attr ) ?>>

						<?php

							// Loader icon
							if( $slider == 2 || $slider == 5 || $slider == 6 || $slider == 7 ){
								tie_get_ajax_loader();
							}

						?>

						<div class="main-slider-inner">

							<?php

							if( $slider < 5 || $slider >= 50 ): ?>

								<div class="container slider-main-container">
									<div class="tie-slick-slider">
										<ul class="tie-slider-nav"></ul>

										<?php

											foreach ( $slider_items as $slider_post_id => $single_slide ){
												extract( $single_slide );
												$count++;

												$class = tie_get_post_class( $single_slide_class . ' slide-id-'.$slider_post_id .' tie-slide-'.$count, $slider_post_id );

												printf( $before_slider, $slide_image, $class, $slide_link, esc_attr( strip_tags( $slide_title ) ) );

													if( ! empty( $review_score ) ){
														echo ( $review_score );
													}

													echo '<div class="container">';

														if( $slider == 1 ){

															echo '<div class="thumb-content">';

																if( ! empty( $slide_categories ) ){
																	echo ( $slide_categories );
																}

																if( ! empty( $slide_meta ) ){
																	echo '<div class="thumb-meta">'. $slide_meta .'</div>';
																}

																printf( $slide_title_html, $slide_link, $slide_title );

															echo '</div> <!-- .thumb-content /-->';
														}

														elseif( $slider == 2 ){

															if( ! empty( $slide_categories ) ){
																echo ( $slide_categories );
															}


															echo '<div class="thumb-content">';

																if( ! empty( $slide_meta ) ){
																	echo '<div class="thumb-meta">'. $slide_meta .'</div>';
																}

																printf( $slide_title_html, $slide_link, $slide_title );

																if( ! empty( $slide_caption ) ) {
																	echo ( $slide_caption );
																}

															echo '</div> <!-- .thumb-content /-->';

														}

														else{

															if( ! empty( $slide_categories ) ){
																echo ( $slide_categories );
															}

															echo '<div class="thumb-content">';

																if( ! empty( $slide_meta ) ){
																	echo '<div class="thumb-meta">'. $slide_meta .'</div>';
																}

																printf( $slide_title_html, $slide_link, $slide_title );

															echo '</div> <!-- .thumb-content /-->';
														}

													echo '</div><!-- .container -->';

												echo ( $after_slider );

												// Reset the posts count after 6 posts
												$count = ( $count == 6 ) ? 0 : $count;
											}
										?>

									</div><!-- .tie-slick-slider /-->
								</div><!-- .slider-main-container /-->

							<?php

							else:
								if( $slider != 8 && $slider < 9 ){

									echo '<ul class="tie-slider-nav"></ul>';
								}?>

								<div class="container<?php echo esc_attr( $slider_id ) ?>">
									<div class="tie-slick-slider">

										<?php

											if( $slider >= 8 ){
												echo '<ul class="tie-slider-nav"></ul>';
											}

											if( ! empty( $slider_items ) && is_array( $slider_items ) ) {

												$number_of_posts = count( $slider_items );

												foreach ( $slider_items as $slider_post_id => $single_slide ){

													// Grid Sliders
														if( ! empty( $posts_per_slide ) ){

															if( $grid_count == 0 ){
																echo '<div class="slide">';
															}

															// Grid Sliders counters
															$number_of_posts--;
															$grid_count++;
														}
													//------------

													extract( $single_slide );

													$count++;

													$class = tie_get_post_class( $single_slide_class . ' slide-id-'.$slider_post_id .' tie-slide-'.$count, $slider_post_id );

													printf( $before_slider, $slide_image, $class, $slide_link, esc_attr( strip_tags( $slide_title ) ) );

														if( $slider != 6 ){

															if( ! empty( $slide_categories ) ){
																echo ( $slide_categories );
															}

															if( ! empty( $review_score ) ){
																echo ( $review_score );
															}
														}

														echo '<div class="thumb-content">';

															if( ! empty( $slide_meta ) ){
																echo '<div class="thumb-meta">'. $slide_meta .'</div>';
															}

															printf( $slide_title_html, $slide_link, $slide_title );

															if( $slider != 6 && ! empty( $slide_caption ) ){
																echo ( $slide_caption );
															}

														echo '</div> <!-- .thumb-content /-->';

													echo ( $after_slider );

													// Grid Sliders
													if( ! empty( $posts_per_slide ) ){

														if( $grid_count == $posts_per_slide || $number_of_posts == 0 ){
															echo '</div> <!-- .slide -->';
														}

														$grid_count = ( $grid_count == $posts_per_slide ) ? 0 : $grid_count;
													}
													//------------


													// Reset the posts count after 6 posts
													$count = ( $count == 6 ) ? 0 : $count;
												}
											}
										?>

									</div><!-- .tie-slick-slider /-->
								</div><!-- container /-->

							<?php endif; ?>

						</div><!-- .main-slider-inner  /-->
					</div><!-- .main-slider /-->

					<?php

					// Navigation of Slider 4
					if( $slider == 4 || $slider == 50 ):

						$nav_slider_class = 'wide-slider-nav-wrapper';

						if( $slider == 50 ){
							$nav_slider_class .= ' vertical-slider-nav';
						}
						?>

						<div class="<?php echo $nav_slider_class ?> ">
							<ul class="tie-slider-nav"></ul>

							<div class="container">
								<div class="tie-row">
									<div class="tie-col-md-12">
										<div class="tie-slick-slider">

											<?php

												foreach ( $slider_items as $single_slide ):

													extract( $single_slide );
													$count ++; ?>

													<div class="slide tie-slide-<?php echo $count ?>">
														<div class="slide-overlay">

															<?php
																if( ! empty( $slide_meta ) ){
																	echo '<div class="thumb-meta">'. $slide_meta .'</div>';
																}
															?>

															<h3 class="thumb-title"><?php echo $slide_title ?></h3>

														</div>
													</div><!-- slide /-->

													<?php

													// Reset the posts count after 6 posts
													$count = ( $count == 6 ) ? 0 : $count;

												endforeach;
											?>

										</div><!-- .wide_slider_nav /-->
									</div><!-- .tie-col /-->
								</div><!-- .tie-row /-->
							</div><!-- .container /-->
						</div><!-- #wide-slider-nav-wrapper /-->
						<?php
					endif;

					echo '</div><!-- .slider-area-inner -->';

				} // else of the video playlist
			?>
		</section><!-- .slider-area -->

			<?php

			$cached_slider = ob_get_clean();

			if( tie_get_option( 'jso_cache' ) &&  ! empty( $cache_key ) ){
				set_transient( $cache_key, $cached_slider, 5 * HOUR_IN_SECONDS );
			}

		} //Else cache

		echo ( $cached_slider );
	}
}
