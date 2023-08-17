<?php
/**
 * AMP
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_AMP' ) ) {

	class TIELABS_AMP{

		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			// Disable if the AMP plugin is not active or the theme option is disabled
			if( ! TIELABS_AMP_IS_ACTIVE ){
				return;
			}

			// Plugin options
			add_filter( 'pre_update_option_amp-options', array( $this, 'set_amp_options' ), 10, 2 );

			// Back-end Notice
			add_action( 'admin_head', array( $this, 'amp_reader_mode_notice' ) );

			// Check if the AMP is active
			if( ! tie_get_option( 'amp_active' ) ){
				return;
			}

			// Disable the AMP Customizer menu, Control styles from the theme options page.
			add_filter( 'amp_customizer_is_enabled', '__return_false' );

			// Translations
			add_filter( 'TieLabs/default_translation_texts', array( $this, 'amp_translation_texts' ), 99 );

			// Sub title
			add_filter( 'amp_post_article_header_meta', array( $this, 'post_subtitle_template' ) );

			// Author name and date
			add_filter( 'amp_post_article_header_meta', array( $this, 'meta_info' ) );

			// Actions
			add_action( 'amp_post_template_head',      array( $this, 'custom_head_codes' ) );
			add_action( 'amp_post_template_body_open', array( $this, 'custom_body_codes' ) );
			add_action( 'pre_amp_render_post',         array( $this, 'content_filters' ) );
			add_action( 'amp_post_template_head',      array( $this, 'remove_google_fonts' ), 2 );
			add_action( 'amp_post_template_body_open', array( $this, 'sidebar_menu' ), 1 );

			// Filters
			add_filter( 'amp_content_max_width',        array( $this, 'content_width' ) );
			add_filter( 'TieLabs/content_width',        array( $this, 'content_width' ) );
			add_filter( 'amp_post_template_file',       array( $this, 'templates_path' ), 10, 3 );
			add_filter( 'amp_site_icon_url',            array( $this, 'logo_path' ) );
			add_filter( 'amp_post_template_metadata',   array( $this, 'post_template_metadata' ) );
			add_filter( 'amp_post_article_footer_meta', array( $this, 'meta_taxonomy' ) );
			add_filter( 'amp_post_template_data',       array( $this, 'amp_scripts' ) );
			add_filter( 'nav_menu_link_attributes',     array( $this, 'nav_menu_link_attributes' ) );
		}


		/**
		 * Custom <head> codes
		 */
		function custom_head_codes() {
			echo tie_get_option( 'amp_header_code' );
		}


		/**
		 * Custom <body> codes
		 */
		function custom_body_codes() {
			echo tie_get_option( 'amp_body_code' );
		}


		/**
		 * Include the AMP-Ad js file
		 */
		function amp_scripts( $data ) {

			if ( ! isset( $data['amp_component_scripts'] ) ) {
				$data['amp_component_scripts'] = array();
			}

			$data['amp_component_scripts']['amp-ad'] = 'https://cdn.ampproject.org/v0/amp-ad-0.1.js';
			$data['amp_component_scripts']['amp-sidebar'] = 'https://cdn.ampproject.org/v0/amp-sidebar-0.1.js';

			return $data;
		}


		/**
		 * post_subtitle_template
		 */
		function post_subtitle_template( $templates ){

			return array_merge( array( 'sub-title' ), $templates );
		}


		/**
		 * content_filters
		 *
		 * Add related posts, ads, formats and share buttons to the post content
		 */
		function content_filters(){

			add_filter( 'the_content', array( $this, 'strip_shortcodes' ));
			add_filter( 'the_content', array( $this, 'ads' ));
			add_filter( 'the_content', array( $this, 'share_buttons' ));
			add_filter( 'the_content', array( $this, 'post_formats'  ));
			add_filter( 'the_content', array( $this, 'related_posts' ));

			// Co-Authors Plus plugin
			if( function_exists( 'get_coauthors' ) ){
				remove_filter( 'amp_post_template_file', 'cap_set_amp_author_meta_template', 10, 3 );
			}
		}


		/**
		 * post_formats
		 */
		function post_formats( $content ){

			$post_format = tie_get_postdata( 'tie_post_head', 'standard' );

			ob_start();

			if( $post_format ){

				// Get the post video
				if( $post_format == 'video' ){

					tie_video();
				}

				// Get post audio
				elseif( $post_format == 'audio' ){

					tie_audio();
				}

				// Get post map
				elseif( $post_format == 'map' ){
					echo tie_google_maps( tie_get_postdata( 'tie_googlemap_url' ));
				}

				// Get post slider
				elseif( $post_format == 'slider' ){

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

					$ids = array();
					if( ! empty( $images ) && is_array( $images ) ){
						foreach( $images as $single_image ){
							$ids[] = $single_image['id'];
						}
					}

					echo( '[gallery ids="'. implode( ',', $ids ) .'"]');
				}

				// Featured Image
				elseif( has_post_thumbnail() && ( $post_format == 'thumb' ||
							( $post_format == 'standard' && ( tie_get_object_option( 'post_featured', 'cat_post_featured', 'tie_post_featured' ) && tie_get_object_option( 'post_featured', 'cat_post_featured', 'tie_post_featured' ) != 'no' ) ) ) ) {

					the_post_thumbnail();
				}
			}

			$output = ob_get_clean();

			if( ! empty( $output ) ){
				$output = '<div class="amp-featured">'. $output .'</div>';
				$content = $output . $content;
			}

			return $content;
		}


		/**
		 * related_posts
		 *
		 * Add related posts below the post content
		 */
		function related_posts( $content ){

			if( tie_get_option( 'amp_related_posts' ) ){

				// Current Post ID
				$post_id = get_the_ID();

				// Default Query Args
				$args = array(
					'posts_per_page' => tie_get_option( 'amp_related_posts_number', 4 ),
					'post_status'    => 'publish',
					'post__not_in'   => array( $post_id ),
				);

				// Get the current post categories
				$categories   = wp_get_object_terms( $post_id, 'category' ); //get_the_category doesn't work in AMP
				$category_ids = array();

				if( ! empty( $categories ) && is_array( $categories ) ){
					foreach( $categories as $single_category ){
						$category_ids[] = $single_category->term_id;
					}

					$args['category__in'] = $category_ids;
				}

				// Run the Query
				$recent_posts = new WP_Query( $args );

				if( $recent_posts->have_posts() ){

					$output = '
						<div class="amp-related-posts">
							<span>'. esc_html__( 'Related Articles', TIELABS_TEXTDOMAIN ) .'</span>
							<ul>
							';

							while ( $recent_posts->have_posts() ){
								$recent_posts->the_post();
								$output .= '
									<li>
										<a href="' . amp_get_permalink( get_the_ID() ) . '">'. get_the_post_thumbnail( null, TIELABS_THEME_SLUG.'-image-large' ) . get_the_title() .'</a>
									</li>';
							}

							$output .= '
							</ul>
						</div>
					';

					$content = $content . $output;
				}

				// Reset the main Post query
				wp_reset_postdata();
			}

			return $content;
		}


		/**
		 * share_buttons
		 *
		 * Add the share buttons
		 */
		function share_buttons( $content ){

			if( tie_get_option( 'amp_share_buttons' ) ){

				$share_buttons = '
					<div class="social">
						<amp-social-share type="facebook"
							width="32"
							height="32"
							data-param-app_id='. tie_facebook_app_id() .'></amp-social-share>

						<amp-social-share type="twitter"
							width="32"
							height="32"></amp-social-share>

						<amp-social-share type="pinterest"
							width="32"
							height="32"></amp-social-share>

						<amp-social-share type="linkedin"
							width="32"
							height="32"></amp-social-share>

						<amp-social-share type="whatsapp"
							width="32"
							height="32"></amp-social-share>

						<amp-social-share type="tumblr"
							width="32"
							height="32"></amp-social-share>

						<amp-social-share type="line"
							width="32"
							height="32"></amp-social-share>

						<amp-social-share type="email"
							width="32"
							height="32"></amp-social-share>
					</div>
				';

				/*
					<amp-social-share type="sms"
							width="32"
							height="32"></amp-social-share>
				*/

				$content = $content . $share_buttons;
			}

			return $content;
		}


		/**
		 * strip_shortcodes
		 */
		function strip_shortcodes( $content ){

			$content = preg_replace( '/(\[(padding)\s?.*?\])/', '', $content );
			$content = str_replace( '[/padding]', '', $content );

			return $content;
		}


		/**
		 * ads
		 */
		function ads( $content ){

			if( tie_get_option( 'amp_ad_above' ) ){
				$content = '<div class="amp-custom-ad amp-above-content-ad amp-ad">'. tie_get_option( 'amp_ad_above' ) .'</div>'. $content;
			}

			if( tie_get_option( 'amp_ad_below' ) ){
				$content = $content . '<div class="amp-custom-ad amp-above-content-ad amp-ad">'. tie_get_option( 'amp_ad_below' ) .'</div>';
			}

			return $content;
		}


		/**
		 * content_width
		 */
		function content_width( $content_max_width ){

			if( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ){
				return 700;
			}

			return $content_max_width;
		}


		/**
		 * sidebar_menu
		 * Add the sidebar menu
		 */
		function sidebar_menu(){

			if( ! tie_get_option( 'amp_menu_active' ) ){
				return;
			}

			$menu_position = tie_get_option( 'amp_menu_position', 'left' ) == 'left' ? 'left' : 'right';
			?>
			<amp-sidebar id='sidebar' layout="nodisplay" side="<?php echo $menu_position ?>">
				<div class="toggle-navigationv2">
					<div role="button" tabindex="0" on="tap:sidebar.close" class="close-nav">X</div>
					<nav id ="primary-amp-menu" itemscope="" itemtype="https://schema.org/SiteNavigationElement">
						<div class="menu-main-menu-container">

						<?php
							if( tie_get_option( 'amp_the_menu' ) ){

								wp_nav_menu(
									array(
										'menu_class' => 'amp-menu',
										'menu' => tie_get_option( 'amp_the_menu' ),
									));
							}
						?>

						</div>
					</nav>
				</div>
			</amp-sidebar>
			<?php
		}


		/**
		 * remove_google_fonts
		 * Do not load Merriweather Google fonts on AMP pages
		 */
		function remove_google_fonts(){

			remove_action( 'amp_post_template_head', 'amp_post_template_add_fonts' );
		}


		/**
		 * templates_path
		 * Set custom template path
		 */
		function templates_path( $file, $type, $post ){

			if ( 'header-bar' === $type || 'sub-title' === $type || 'featured-image' === $type || 'footer' === $type || 'style' === $type ) {
				return locate_template( 'framework/plugins/amp-templates/'. $type .'.php' );
			}

			// Co-Authors Plus plugin
			if ( function_exists( 'get_coauthors' ) && 'meta-author' === $type ) {
				return locate_template( 'framework/plugins/amp-templates/meta-coauthors.php' );
			}

			return $file;
		}


		/**
		 * meta_info
		 * Show/Hide Post Author name and date
		 */
		function meta_info( $meta ){

			if( ! tie_get_option( 'amp_author_meta') ){
				$author_key = array_search( 'meta-author', $meta );
				unset( $meta[ $author_key ] );
			}

			if( ! tie_get_option( 'amp_date_meta') ){
				$date_key = array_search( 'meta-time', $meta );
				unset( $meta[ $date_key ] );
			}

			return $meta;
		}


		/**
		 * meta_taxonomy
		 * Show/Hide the categories and tags below the post
		 */
		function meta_taxonomy(){

			$meta = array( 'meta-comments-link' );

			if( tie_get_option( 'amp_taxonomy') ){
				$meta[] = 'meta-taxonomy';
			}

			return $meta;
		}


		/**
		 * logo_path
		 * Add the custom logo to the AMP structure data
		 */
		function logo_path(){

			// Custom AMP logo
			if( tie_get_option( 'amp_logo' ) ){
				return tie_get_option( 'amp_logo' );
			}

			// Site Logo
			return tie_get_option( 'logo_retina' ) ? tie_get_option( 'logo_retina' ) : tie_get_option( 'logo' );
		}


		/**
		 * post_template_metadata
		 * Modify the structure data of posts
		 */
		function post_template_metadata( $metadata ){

			if( ! empty( $metadata['publisher']['logo'] ) ){

				$metadata['publisher']['logo'] = array(
					'type' => 'ImageObject',
					'url'  => $metadata['publisher']['logo']
				);
			}

			return $metadata;
		}


		/**
		 * set_amp_options
		 * Force the right mode
		 */
		function set_amp_options( $value, $old_value ){
			$value['theme_support'] = 'reader';
			return $value;
		}


		/**
		 * set_amp_options
		 * Force the right mode
		 */
		function amp_reader_mode_notice(){

			if( function_exists('get_current_screen') ){

				$current_screen = get_current_screen();
				if( $current_screen->id != 'toplevel_page_amp-options' ){
					return;
				}

				?>
				<script type="text/javascript">
					jQuery(document).ready(function(){
						var $target = jQuery('.amp-website-mode td fieldset');
						$target.find('.notice-info').remove();
						$target.find('dt:not(:last-of-type) input').attr('disabled','disabled');
						$target.find('dt:not(:last-of-type), dd:not(:last-of-type)').attr('style','opacity: 0.8');
						jQuery('#theme_support_disabled').attr('checked','checked');
						$target.find('dd:last-child').append('\<div class="notice notice-success notice-alt inline"><p><strong>Your active theme is known to work well in the READER mode.</strong></p></div>');
					});
				</script>
				<?php

			}
		}


		/**
		 * amp_translation_texts
		 */
		function amp_translation_texts( $texts ){

			$texts['amp'] = array(
				'title' => esc_html__( 'AMP', TIELABS_TEXTDOMAIN ),
				'texts' => array(
					'Tags: %s'        => 'Tags: %s',
					'Categories: %s'  => 'Categories: %s',
					'Leave a Comment' => 'Leave a Comment',
				),
			);

			return $texts;
		}


		/**
		 * Menu links
		 */
		function nav_menu_link_attributes( $atts = array() ){

			if( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ){

				if( ! empty( $atts['href'] ) ){
					$atts['href'] = add_query_arg( 'amp', '1', $atts['href'] );
				}
			}

			return $atts;
		}

	}

	// Instantiate the class
	new TIELABS_AMP();

}

