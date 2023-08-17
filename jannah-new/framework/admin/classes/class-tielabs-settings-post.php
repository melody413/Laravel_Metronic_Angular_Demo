<?php
/**
 * Post Settings Class
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_SETTINGS_POST' ) ) {

	class TIELABS_SETTINGS_POST{


		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			add_action( 'admin_head', array( $this, 'post_subtitle' ) );
			add_action( 'admin_head', array( $this, 'meta_boxes_roles' ) );

			add_action( 'save_post',      array( $this, 'save' ) );
			add_action( 'add_meta_boxes', array( $this, 'meta_boxes' ), 3 );

			add_filter( 'TieLabs/Settings/Post/general', array( $this, 'posts_page_template' ) );
			add_filter( 'TieLabs/Settings/Post/general', array( $this, 'authors_page_template' ) );

			add_filter( 'TieLabs/Settings/Post/general', array( $this, 'general_page_settings' ) );
			add_filter( 'TieLabs/Settings/Post/general', array( $this, 'general_post_settings' ) );
			add_filter( 'TieLabs/Settings/Post/general', array( $this, 'post_format_settings' ) );

			add_filter( 'TieLabs/Settings/Post/layout',  array( $this, 'layout_settings' ) );
			add_filter( 'TieLabs/Settings/Post/logo',    array( $this, 'logo_settings' ) );
			add_filter( 'TieLabs/Settings/Post/sidebar', array( $this, 'sidebar_settings' ) );
			add_filter( 'TieLabs/Settings/Post/styles',  array( $this, 'styles_settings' ) );
			add_filter( 'TieLabs/Settings/Post/menu',    array( $this, 'menu_settings' ) );

			add_filter( 'TieLabs/Settings/Post/components', array( $this, 'components_settings' ) );
			add_filter( 'TieLabs/Settings/Post/components', array( $this, 'post_components_settings' ) );
			add_filter( 'TieLabs/Settings/Post/e3lan',      array( $this, 'e3lan_settings' ) );

			add_action( 'TieLabs/Settings/Post/after_source-via', array( $this, 'source_settings' ) );
			add_action( 'TieLabs/Settings/Post/after_source-via', array( $this, 'via_settings' ) );
			add_action( 'TieLabs/Settings/Post/after_highlights', array( $this, 'highlights_settings' ) );
		}


		/**
		 * post_subtitle
		 *
		 * Handle the position of the post subtitle depending on the Editor
		 */
		function post_subtitle(){

			// Enable/Disable Sub Title
			if( ! apply_filters( 'TieLabs/Settings/Post/is_subtitle', true ) ){
				return;
			}

			// is Gutenberg?
			if( TIELABS_ADMIN_HELPER::is_edit_gutenberg() ){

				add_meta_box(
					'tie_post_secondry_title',
					esc_html__( 'Subtitle', TIELABS_TEXTDOMAIN ),
					array( $this, 'secondry_title' ),
					TIELABS_HELPER::get_supported_post_types(),
					'side',
					'high'
				);
			}
			else{
				add_action( 'edit_form_after_title', array( $this, 'secondry_title' ), 40 );
			}
		}


		/**
		 * Allow Post meta boxes for specfic user roles only
		 */
		function meta_boxes_roles(){

			if ( current_user_can( 'manage_options' ) ) {
				return;
			}

			if( tie_get_option( 'posts_advanced_options_admin' ) ){
				remove_meta_box( 'tie_post_options',     'post', 'normal' );
				remove_meta_box( 'tie_post_options',     'page', 'normal' );
				remove_meta_box( 'tie_frontpage_option', 'page', 'normal' );
				//remove_meta_box( 'taqyeem_post_options', 'post', 'normal' );
				//remove_meta_box( 'taqyeem_post_options', 'page', 'normal' );

				do_action( 'TieLabs/posts_advanced_options_admin' );
			}
		}


		/**
		 * Register The Meta Boxes
		 */
		function meta_boxes(){

			add_meta_box(
				'tie_post_options',
				apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '. esc_html__( 'Settings', TIELABS_TEXTDOMAIN ),
				array( $this, 'custom_options' ),
				apply_filters( 'TieLabs/settings_post_types', array( 'post', 'page' ) ),
				'normal',
				'high'
			);

			add_meta_box(
				'tie_frontpage_option',
				apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '. esc_html__( 'Front Page', TIELABS_TEXTDOMAIN ),
				array( $this, 'frontpage_option' ),
				'page',
				'side',
				'low'
			);
		}


		/**
		 * Secondry post title
		 *
		 * CLASSIC EDITOR
		 */
		function secondry_title(){

			$post_id = get_the_id();

			// Get current post type
			if( ! empty( $post_id ) ){
				$current_post_type = get_post_type( $post_id );
			}

			if( empty( $current_post_type ) && get_current_screen()->post_type ){
				$current_post_type = get_current_screen()->post_type;
			}

			// return if it is not supported
			if( ! in_array( $current_post_type, TIELABS_HELPER::get_supported_post_types() ) ){
				return;
			}

			?>

			<div id="subtitlediv">
				<div id="subtitlewrap">
					<label class="screen-reader-text" id="sub-title-prompt-text" for="tie-sub-title"><?php esc_html_e( 'Enter sub title here', TIELABS_TEXTDOMAIN ) ?></label>
					<input type="text" name="tie_post_sub_title" size="30" value="<?php echo esc_attr( get_post_meta( $post_id, 'tie_post_sub_title', true ) ) ?>" id="tie-sub-title" placeholder="<?php esc_html_e( 'Enter sub title here', TIELABS_TEXTDOMAIN ) ?>" spellcheck="true" autocomplete="off">
				</div>
			</div>

			<?php
		}


		/**
		 * Set the page as a front page
		 */
		function frontpage_option(){

			$notice = $data  = '';

			if( get_option( 'show_on_front' ) == 'page' ){

				$current_page_id = get_the_id();
				$front_page_id   = get_option( 'page_on_front' );

				if( $current_page_id == $front_page_id ){
					$data = 'true';
				}
				else{

					$link = add_query_arg( array( 'post' => $front_page_id, 'action' => 'edit' ), admin_url( 'post.php' ) );
					$page = '<a href='. $link .' target="_blank">'. get_the_title( $front_page_id ) .'</a>';
					$notice = '
						<p>'. sprintf( esc_html__( 'Current Front Page: %s', TIELABS_TEXTDOMAIN ), $page ) .'</p>
					';
				}
			}

			$option = array(
				'name'   => esc_html__( 'Set as the site Front Page?', TIELABS_TEXTDOMAIN ),
				'id'     => 'tie-set-front-page',
				'type'   => 'checkbox',
			);

			tie_build_option( $option, 'page_on_front', $data );

			echo $notice;
		}


		/**
		 * Add Button in the Gutenburg page to the TieLabs Builder
		 */
		function gutenburg_use_classic_builder(){
			?>
				<a class="tie-primary-button button button-hero button-primary" id="gutenburg-use-classic-builder" style="width: 100%;"><?php echo esc_html__( 'Use the TieLabs Builder', TIELABS_TEXTDOMAIN ); ?></a>
			<?php
		}


		/**
		 * Build The Post Option
		 */
		function build_option( $option ){

			$id   = ! empty( $option['id'] ) ? $option['id'] : '';
			$data = tie_get_postdata( $id );

			tie_build_option( $option, $id, $data );
		}


		/**
		 * Save Category Options
		 */
		function save( $post_id ){

			// Check if this is an auto save
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
				return $post_id;
			}

			// Begin to save ---------
			if ( ! isset( $_POST['tie_hidden_flag'] ) ){
				return;
			}

			// --
			/*
			foreach ( $_POST as $key => $value ) {
				if ( $value === '-tie-101' ) { // Checkbox is disabled
					unset( $_POST[ $key ] );
				}
			}
			*/

			// Prevent set the revision pages as frontpage
			if( ! wp_is_post_revision( $post_id ) ){

				// Update the Front Page option
				if( ! empty( $_POST['page_on_front'] ) ){

					update_option( 'show_on_front', 'page' );
					update_option( 'page_on_front', $post_id );
				}
				else{

					if( get_option( 'show_on_front' ) == 'page' && $post_id == get_option( 'page_on_front' ) ){
						update_option( 'show_on_front', 'posts' );
						update_option( 'page_on_front', 0 );
					}
				}
			}


			// Post / Page Options
			$custom_meta_fields = apply_filters( 'TieLabs/post_options_meta', array(

				// Misc
				'tie_post_sub_title',
				'tie_primary_category',
				'tie_trending_post',
				'tie_hide_title',
				'tie_hide_page_featured',
				'tie_hide_header',
				'tie_hide_footer',
				'tie_builder_breadcrumbs',
				'tie_do_not_dublicate',
				'tie_header_extend_bg',

				// Post Layout
				'tie_theme_layout',
				'tie_post_layout',
				'tie_featured_use_fea',
				'tie_featured_custom_bg',
				'tie_featured_bg_color',

				// Logo
				'custom_logo' => array(
					'logo_setting',
					'logo_text',
					'logo',
					'logo_retina',
					'logo_inverted',
					'logo_inverted_retina',
					'logo_retina_width',
					'logo_retina_height',
					'logo_margin',
					'logo_margin_bottom',
					'logo_url',
				),

				// Post Sidebar
				'tie_sidebar_pos',
				'tie_sidebar_post',
				'tie_sticky_sidebar',

				// Post Format settings
				'tie_post_head',

				'tie_post_featured',
				'tie_image_uncropped',
				'tie_image_lightbox',

				'tie_post_slider',
				'tie_post_gallery',

				'tie_googlemap_url',

				'tie_video_url',
				'tie_video_self',
				'tie_embed_code',

				'tie_audio_m4a',
				'tie_audio_mp3',
				'tie_audio_oga',
				'tie_audio_soundcloud',
				'tie_audio_embed',

				// Custom Ads
				'tie_disable_all_ads',
				'tie_hide_above',
				'tie_get_banner_above',
				'tie_hide_below',
				'tie_get_banner_below',
				'tie_hide_above_content',
				'tie_get_banner_above_content',
				'tie_hide_below_content',
				'tie_get_banner_below_content',

				// Post Components
				'tie_hide_meta',
				'tie_hide_tags',
				'tie_hide_categories',
				'tie_hide_author',
				'tie_hide_nav',
				'tie_hide_share_top',
				'tie_hide_share_bottom',
				'tie_hide_newsletter',
				'tie_hide_related',
				'tie_hide_read_next',
				'tie_hide_check_also',

				// Story Highlights
				'tie_highlights_text',

				// Source & Via
				'tie_source',
				'tie_via',

				// Post Color and background
				'post_color',
				'tie_custom_css',
				'background_color',
				'background_color_2',
				'background_type' => array(
					'background_pattern',
					'background_image',
				),
				'background_dots',
				'background_dimmer' => array(
					'background_dimmer_value',
					'background_dimmer_color',
				),

				// Custom Menu
				'tie_menu',

				// Page templates
				'tie_blog_excerpt' => array(
					'tie_blog_length',
				),
				'tie_blog_uncropped_image',
				'tie_blog_category_meta',
				'tie_blog_meta',
				'tie_posts_num',
				'tie_blog_cats',
				'tie_blog_layout',
				'tie_authors',
				'tie_blog_pagination',
			));

			foreach( $custom_meta_fields as $key => $custom_meta_field ){

				// Dependency Options fields
				if( is_array( $custom_meta_field ) ){

					if( ! empty( $_POST[ $key ] ) ) {

						update_post_meta( $post_id, $key, $_POST[ $key ] );

						foreach ( $custom_meta_field as $single_field ){
							if( ! empty( $_POST[ $single_field ] ) ) {
								update_post_meta( $post_id, $single_field, $_POST[ $single_field ] );
							}
							else{
								delete_post_meta( $post_id, $single_field );
							}
						}
					}
					else{
						delete_post_meta( $post_id, $key );
					}
				}

				// Single Options fields
				else{
					if( ! empty( $_POST[ $custom_meta_field ] ) ) {
						update_post_meta( $post_id, $custom_meta_field, $_POST[ $custom_meta_field ] );
					}
					else{
						delete_post_meta( $post_id, $custom_meta_field );
					}
				}
			}
		}


		/**
		 * Post Custom Options
		 */
		function custom_options( ){

			$settings_tabs = array(

				'general' => array(
					'icon'  => 'admin-settings',
					'title' => esc_html__( 'General', TIELABS_TEXTDOMAIN ),
				),

				'layout' => array(
					'icon'	=> 'schedule',
					'title'	=> esc_html__( 'Layout', TIELABS_TEXTDOMAIN ),
				),

				'logo' => array(
					'icon'	=> 'lightbulb',
					'title'	=> esc_html__( 'Logo', TIELABS_TEXTDOMAIN ),
				),

				'sidebar' => array(
					'icon'  => 'slides',
					'title' => esc_html__( 'Sidebar', TIELABS_TEXTDOMAIN ),
				),

				'styles' => array(
					'icon'  => 'art',
					'title' => esc_html__( 'Styles', TIELABS_TEXTDOMAIN ),
				),

				'menu' => array(
					'icon'  => 'menu',
					'title' => esc_html__( 'Main Menu', TIELABS_TEXTDOMAIN ),
				),

				'e3lan' => array( // Avoid elemnt blocking by the AdBlockers
					'icon'  => 'megaphone',
					'title' => esc_html__( 'Advertisement', TIELABS_TEXTDOMAIN ),
				),

				'components' => array(
					'icon'  => 'admin-settings',
					'title' => esc_html__( 'Components', TIELABS_TEXTDOMAIN ),
				),
			);

			if( TIELABS_HELPER::is_supported_post_type() ){

				$settings_tabs['highlights'] = array(
					'icon'  => 'editor-alignleft',
					'title' => esc_html__( 'Story Highlights', TIELABS_TEXTDOMAIN ),
				);

				$settings_tabs['source-via'] = array(
					'icon'  => 'share-alt2',
					'title' => esc_html__( 'Source and Via', TIELABS_TEXTDOMAIN ),
				);
			}

			$settings_tabs = apply_filters( 'TieLabs/Settings/Post', $settings_tabs );

			?>

			<input type="hidden" name="tie_hidden_flag" value="true" />

			<div class="tie-panel">
				<div class="tie-panel-tabs">
					<ul>
						<?php
							foreach( $settings_tabs as $tab => $settings ){

								$icon  = $settings['icon'];
								$title = $settings['title'];

								echo "
									<li class=\"tie-tabs tie-options-tab-$tab\">
										<a href=\"#tie-options-tab-$tab\">
											<span class=\"dashicons-before dashicons-$icon tie-icon-menu\"></span>
											$title
										</a>
									</li>
								";
							}
						?>
					</ul>
					<div class="clear"></div>
				</div> <!-- .tie-panel-tabs -->

				<div class="tie-panel-content">

					<?php
						foreach( $settings_tabs as $tab => $settings ){
							?>

							<div id="tie-options-tab-<?php echo $tab ?>" class="tabs-wrap">
								<?php

									do_action( 'TieLabs/Settings/Post/before_'.$tab );

									$tab_options = apply_filters( 'TieLabs/Settings/Post/'.$tab, array() );

									if( ! empty( $tab_options ) && is_array( $tab_options ) ){
										foreach ( $tab_options as $option ){
											$this->build_option( $option );
										}
									}

									do_action( 'TieLabs/Settings/Post/after_'.$tab );

								?>
							</div>

							<?php
						}
					?>

				</div><!-- .tie-panel-content -->

				<div class="clear"></div>
			</div><!-- .tie-panel -->

			<div class="clear"></div>

			<?php
		}


		/**
		 * Page Templates Settings
		 */
		function posts_page_template( $current_settings ){

			// These options available in Pages only
			if( get_post_type() != 'page' ){
				return $current_settings;
			}

			$settings = array(

				array(
					'content' => '<div id="tie-page-template-categories" class="tie-page-templates-options">',
					'type'    => 'html',
				),

				array(
					'title' => esc_html__( 'Masonry Page', TIELABS_TEXTDOMAIN ),
					'id'    => 'tie_categories_title',
					'type'  => 'header',
				),

				array(
					'id'      => 'tie_blog_layout',
					'type'    => 'visual',
					'columns' => 5,
					'options' => array(
						'masonry'        => array( esc_html__( 'Masonry', TIELABS_TEXTDOMAIN ).' #1' => 'archives/masonry.png' ),
						'overlay'        => array( esc_html__( 'Masonry', TIELABS_TEXTDOMAIN ).' #2' => 'archives/overlay.png' ),
						'overlay-spaces' => array( esc_html__( 'Masonry', TIELABS_TEXTDOMAIN ).' #3' => 'archives/overlay-spaces.png' ),
				)),

				array(
					'name' => esc_html__( 'Uncropped featured image', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_blog_uncropped_image',
					'type' => 'checkbox',
				),

				array(
					'name' => esc_html__( 'Post Meta', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_blog_meta',
					'type' => 'checkbox',
				),

				array(
					'name' => esc_html__( 'Categories Meta', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_blog_category_meta',
					'type' => 'checkbox',
				),

				array(
					'name'   => esc_html__( 'Posts Excerpt', TIELABS_TEXTDOMAIN ),
					'id'     => 'tie_blog_excerpt',
					'toggle' => '#tie_blog_length-item',
					'type'   => 'checkbox',
				),

				array(
					'name' => esc_html__( 'Posts Excerpt Length', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_blog_length',
					'type' => 'number',
				),

				array(
					'name'    => esc_html__( 'Categories', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_blog_cats',
					'type'    => 'select-multiple',
					'options' => TIELABS_ADMIN_HELPER::get_categories(),
				),

				array(
					'name' => esc_html__( 'Number of posts to show', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_posts_num',
					'type' => 'number',
				),

				array(
					'name'    => esc_html__( 'Pagination', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_blog_pagination',
					'type'    => 'radio',
					'options' => array(
						''          => esc_html__( 'Default',           TIELABS_TEXTDOMAIN ),
						'next-prev' => esc_html__( 'Next and Previous', TIELABS_TEXTDOMAIN ),
						'numeric'   => esc_html__( 'Numeric',           TIELABS_TEXTDOMAIN ),
						'load-more' => esc_html__( 'Load More',         TIELABS_TEXTDOMAIN ),
						'infinite'  => esc_html__( 'Infinite Scroll',   TIELABS_TEXTDOMAIN ),
				)),

				array(
					'content' => '</div>',
					'type'    => 'html',
				),
			);

			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/posts_page_template/defaults', $settings );
		}


		/**
		 * Authors Templates Settings
		 */
		function authors_page_template( $current_settings ){

			// These options available in Pages only
			if( get_post_type() != 'page' ){
				return $current_settings;
			}

			// Authors options for the page templates
			$get_roles  = wp_roles();
			$user_roles = $get_roles->get_names();

			$settings = array(

				array(
					'content' => '<div id="tie-page-template-authors" class="tie-page-templates-options">',
					'type'    => 'html',
				),

				array(
					'title' => esc_html__( 'User Roles', TIELABS_TEXTDOMAIN ),
					'id'    => 'tie_authors_title',
					'type'  => 'header',
				),

				array(
					'name'    => esc_html__( 'User Roles', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_authors',
					'type'    => 'select-multiple',
					'options' => $user_roles,
				),

				array(
					'content' => '</div>',
					'type'    => 'html',
				),

			);

			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/authors_page_template/defaults', $settings );
		}


		/**
		 * General Pages Settings
		 */
		function general_page_settings( $current_settings ){

			// These options available in Pages only
			if( get_post_type() != 'page' ){
				return $current_settings;
			}

			$settings = array(

				// Header and Footer Settings
				array(
					'title' => esc_html__( 'Header and Footer Settings', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name' => esc_html__( 'Hide the Header', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_hide_header',
					'type' => 'checkbox',
				),

				array(
					'name' => esc_html__( 'Hide the Footer', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_hide_footer',
					'type' => 'checkbox',
				),

				// Hide Page title
				array(
					'content' => '<div id="tie_hide_page_title_option">',
					'type'    => 'html',
				),

				array(
					'title' => esc_html__( 'Hide page elements', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name' => esc_html__( 'Hide the page title', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_hide_title',
					'type' => 'checkbox',
				),

				array(
					'name' => esc_html__( 'Hide the featured image', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_hide_page_featured',
					'type' => 'checkbox',
				),

				array(
					'content' => '</div>',
					'type'    => 'html',
				),

				// Builder Breadcrumbs
				array(
					'content' => '<div id="tie_builder_breadcrumbs_option">',
					'type'    => 'html',
				),

				array(
					'title' => esc_html__( 'Breadcrumbs', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name' => esc_html__( 'Display Breadcrumbs', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_builder_breadcrumbs',
					'type' => 'checkbox',
				),

				array(
					'content' => '</div>',
					'type'    => 'html',
				),

				// Do Not Dublicate Posts
				array(
					'content' => '<div id="tie_do_not_dublicate_option">',
					'type'    => 'html',
				),

				array(
					'title' => esc_html__( 'Don\'t duplicate posts', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name' => esc_html__( 'Don\'t duplicate posts', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_do_not_dublicate',
					'type' => 'checkbox',
					'hint' => esc_html__( 'Note: This option doesn\'t work with the AJAX pagination.', TIELABS_TEXTDOMAIN ),
				),

				array(
					'content' => '</div>',
					'type'    => 'html',
				),
			);

			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/general_page/defaults', $settings );

		}


		/**
		 * General Post Settings
		 */
		function general_post_settings( $current_settings ){

			if( ! TIELABS_HELPER::is_supported_post_type() ){
				return $current_settings;
			}

			$settings = array(

				array(
					'title' => esc_html__( 'Primary Category', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name'    => esc_html__( 'Primary Category', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_primary_category',
					'type'    => 'select',
					'hint'    => esc_html__( 'If the post has multiple categories, the one selected here will be used for settings and it appears in the category labels.', TIELABS_TEXTDOMAIN ),
					'options' => TIELABS_ADMIN_HELPER::get_categories( true ),
				),

				array(
					'title' => esc_html__( 'Trending Post', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name' => esc_html__( 'Trending Post', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_trending_post',
					'type' => 'checkbox',
				),
			);


			// Post Views
			if( tie_get_option( 'tie_post_views') == 'theme' ){

				$settings[] = array(
					'title' => esc_html__( 'Post Views', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				);

				$settings[] = array(
					'name'    => esc_html__( 'Post Views', TIELABS_TEXTDOMAIN ),
					'id'      => apply_filters( 'TieLabs/views_meta_field', 'tie_views' ),
					'type'    => 'number',
					'default' => tie_get_option( 'views_starter_number', 0 )
				);
			}


			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/general/defaults', $settings );
		}


		/**
		 * Post Format Settings
		 */
		function post_format_settings( $current_settings ){

			if( ! TIELABS_HELPER::is_supported_post_type() ){
				return $current_settings;
			}

			$settings = array(

				array(
					'title' => esc_html__( 'Post format', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'id'      => 'tie_post_head',
					'type'    => 'visual',
					'columns' => 6,
					'toggle'  => array(
						'standard' => '#tie_post_featured-item',
						'thumb'    => '#tie_image_uncropped-item, #tie_image_lightbox-item',
						'video'    => '#tie_embed_code-item, #tie_video_url-item, #tie_video_self-item',
						'audio'    => '#tie_audio_embed-item, #tie_audio_mp3-item, #tie_audio_m4a-item, #tie_audio_oga-item, #tie_audio_soundcloud-item, #tie_audio_soundcloud_play-item , #tie_audio_soundcloud_visual-item',
						'slider'   => '#tie_post_slider-item, #tie_post_gallery-item',
						'map'      => '#tie_googlemap_url-item, #tie_googlemap_notice-item', ),
					'options' => array(
						'standard' => array( esc_html__( 'Standard', TIELABS_TEXTDOMAIN ) => 'formats/format-standard.png' ),
						'thumb'    => array( esc_html__( 'Image',    TIELABS_TEXTDOMAIN ) => 'formats/format-img.png' ),
						'video'    => array( esc_html__( 'Video',    TIELABS_TEXTDOMAIN ) => 'formats/format-video.png' ),
						'audio'    => array( esc_html__( 'Audio',    TIELABS_TEXTDOMAIN ) => 'formats/format-audio.png' ),
						'slider'   => array( esc_html__( 'Slider',   TIELABS_TEXTDOMAIN ) => 'formats/format-slider.png' ),
						'map'      => array( esc_html__( 'Map',      TIELABS_TEXTDOMAIN ) => 'formats/format-map.png' ),
				)),

				// Standard
				array(
					'name'    => esc_html__( 'Show the featured image', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_post_featured',
					'type'    => 'select',
					'class'   => 'tie_post_head',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Yes',     TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'No',      TIELABS_TEXTDOMAIN ),
				)),

				// Image
				array(
					'name'    => esc_html__( 'Uncropped featured image', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_image_uncropped',
					'type'    => 'select',
					'class'   => 'tie_post_head',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Yes',     TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'No',      TIELABS_TEXTDOMAIN ),
				)),

				array(
					'name'    => esc_html__( 'Featured image lightbox', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_image_lightbox',
					'type'    => 'select',
					'class'   => 'tie_post_head',
					'options' => array(
							''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
							'yes' => esc_html__( 'Yes',     TIELABS_TEXTDOMAIN ),
							'no'  => esc_html__( 'No',      TIELABS_TEXTDOMAIN ),
				)),

				// Video
				array(
					'name'  => esc_html__( 'Embed Code', TIELABS_TEXTDOMAIN ),
					'id'    => 'tie_embed_code',
					'type'  => 'textarea',
					'class' => 'tie_post_head',
				),

				array(
					'name'     => esc_html__( 'Self Hosted Video', TIELABS_TEXTDOMAIN ),
					'id'       => 'tie_video_self',
					'pre_text' => esc_html__( '- OR -', TIELABS_TEXTDOMAIN ),
					'type'     => 'text',
					'class'    => 'tie_post_head',
				),

				array(
					'name'     => esc_html__( 'Video URL', TIELABS_TEXTDOMAIN ),
					'id'       => 'tie_video_url',
					'pre_text' => esc_html__( '- OR -', TIELABS_TEXTDOMAIN ),
					'type'     => 'text',
					'hint'     => esc_html__( 'supports : YouTube, Vimeo, Viddler, Qik, Hulu, FunnyOrDie, DailyMotion, WordPress.tv and blip.tv', TIELABS_TEXTDOMAIN ),
					'class'    => 'tie_post_head',
				),

				// Audio
				array(
					'name'  => esc_html__( 'Embed Code', TIELABS_TEXTDOMAIN ),
					'id'    => 'tie_audio_embed',
					'type'  => 'textarea',
					'class' => 'tie_post_head',
				),

				array(
					'name'     => esc_html__( 'MP3 file URL', TIELABS_TEXTDOMAIN ),
					'id'       => 'tie_audio_mp3',
					'pre_text' => esc_html__( '- OR -', TIELABS_TEXTDOMAIN ),
					'type'     => 'text',
					'class'    => 'tie_post_head',
				),

				array(
					'name'  => esc_html__( 'M4A file URL', TIELABS_TEXTDOMAIN ),
					'id'    => 'tie_audio_m4a',
					'type'  => 'text',
					'class' => 'tie_post_head',
				),

				array(
					'name'  => esc_html__( 'OGA file URL', TIELABS_TEXTDOMAIN ),
					'id'    => 'tie_audio_oga',
					'type'  => 'text',
					'class' => 'tie_post_head',
				),

				array(
					'name'     => esc_html__( 'SoundCloud URL', TIELABS_TEXTDOMAIN ),
					'id'       => 'tie_audio_soundcloud',
					'pre_text' => esc_html__( '- OR -', TIELABS_TEXTDOMAIN ),
					'type'     => 'text',
					'class'    => 'tie_post_head',
				),

				// Slider
				array(
					'id'    => 'tie_post_gallery',
					'type'  => 'gallery',
					'class' => 'tie_post_head',
				),

				array(
					'name'     => esc_html__( 'Custom Slider', TIELABS_TEXTDOMAIN ),
					'id'       => 'tie_post_slider',
					'type'     => 'select',
					'pre_text' => esc_html__( '- OR -', TIELABS_TEXTDOMAIN ),
					'class'    => 'tie_post_head',
					'options'  => TIELABS_ADMIN_HELPER::get_sliders( true ),
				),
			);

			// Maps
			if( ! tie_get_option( 'api_google_maps' ) ){
				$settings[] = array(
					'id'    => 'tie_googlemap_notice',
					'type'  => 'error',
					'class' => 'tie_post_head',
					'text' => esc_html__( 'You need to set the Google Map API Key in the theme options page > Integrations.', TIELABS_TEXTDOMAIN ),
				);
			}

			$settings[] = array(
				'name'  => esc_html__( 'Google Maps URL', TIELABS_TEXTDOMAIN ),
				'id'    => 'tie_googlemap_url',
				'type'  => 'text',
				'class' => 'tie_post_head',
			);


			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/formats/defaults', $settings );
		}


		/**
		 * Post Layout Settings
		 */
		function layout_settings( $current_settings ){

			// General Layout
			$settings = array(

				array(
					'title' => esc_html__( 'Page Layout', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'id'      => 'tie_theme_layout',
					'type'    => 'visual',
					'columns' => 5,
					'options' => array(
						''       => array( esc_html__( 'Default',    TIELABS_TEXTDOMAIN ) => 'default.png' ),
						'full'   => array( esc_html__( 'Full-Width', TIELABS_TEXTDOMAIN ) => 'layouts/layout-full.png'   ),
						'boxed'  => array( esc_html__( 'Boxed',      TIELABS_TEXTDOMAIN ) => 'layouts/layout-boxed.png'  ),
						'framed' => array( esc_html__( 'Framed',     TIELABS_TEXTDOMAIN ) => 'layouts/layout-framed.png' ),
						'border' => array( esc_html__( 'Bordered',   TIELABS_TEXTDOMAIN ) => 'layouts/layout-border.png' ),
				)),
			);


			// Post layout
			if( TIELABS_HELPER::is_supported_post_type() ){

				$settings[] =	array(
					'title' => esc_html__( 'Post Layout', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				);

				$settings[] =	array(
					'id'      => 'tie_post_layout',
					'type'    => 'visual',
					'toggle'  => array(
						'' => '',
						'4' => '#tie_featured_bg_title, #tie_featured_use_fea-item, #tie_featured_custom_bg-item',
						'5' => '#tie_featured_bg_title, #tie_featured_use_fea-item, #tie_featured_custom_bg-item',
						'8' => '#tie_featured_bg_title, #tie_featured_use_fea-item, #tie_featured_custom_bg-item, #tie_featured_bg_color-item',),
					'options' => array(
						''  => array( esc_html__( 'Default', TIELABS_TEXTDOMAIN )       => 'default.png' ),
						'1' => array( esc_html__( 'Layout',  TIELABS_TEXTDOMAIN ).' #1' => 'post-layouts/1.png' ),
						'2' => array( esc_html__( 'Layout',  TIELABS_TEXTDOMAIN ).' #2' => 'post-layouts/2.png' ),
						'3' => array( esc_html__( 'Layout',  TIELABS_TEXTDOMAIN ).' #3' => 'post-layouts/3.png' ),
						'4' => array( esc_html__( 'Layout',  TIELABS_TEXTDOMAIN ).' #4' => 'post-layouts/4.png' ),
						'5' => array( esc_html__( 'Layout',  TIELABS_TEXTDOMAIN ).' #5' => 'post-layouts/5.png' ),
						'6' => array( esc_html__( 'Layout',  TIELABS_TEXTDOMAIN ).' #6' => 'post-layouts/6.png' ),
						'7' => array( esc_html__( 'Layout',  TIELABS_TEXTDOMAIN ).' #7' => 'post-layouts/7.png' ),
						'8' => array( esc_html__( 'Layout',  TIELABS_TEXTDOMAIN ).' #8' => 'post-layouts/8.png' ),
				));

				$settings[] =	array(
					'title' => esc_html__( 'Featured area background', TIELABS_TEXTDOMAIN ),
					'id'    => 'tie_featured_bg_title',
					'type'  => 'header',
					'class' => 'tie_post_layout',
				);

				$settings[] =	array(
					'name'  => esc_html__( 'Use the featured image', TIELABS_TEXTDOMAIN ),
					'id'    => 'tie_featured_use_fea',
					'type'  => 'select',
					'class' => 'tie_post_layout',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Yes',     TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'No',      TIELABS_TEXTDOMAIN ),
					));

				$settings[] =	array(
					'name'     => esc_html__( 'Upload Custom Image', TIELABS_TEXTDOMAIN ),
					'id'       => 'tie_featured_custom_bg',
					'type'     => 'upload',
					'pre_text' => esc_html__( '- OR -', TIELABS_TEXTDOMAIN ),
					'class'    => 'tie_post_layout',
				);

				$settings[] =	array(
					'name'  => esc_html__( 'Background Color', TIELABS_TEXTDOMAIN ),
					'id'    => 'tie_featured_bg_color',
					'type'  => 'color',
					'class' => 'tie_post_layout',
				);

			} // post if



			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/layout/defaults', $settings );
		}


		/**
		 * Post Logo Settings
		 */
		function logo_settings( $current_settings ){

			$settings = array(

				array(
					'title' => esc_html__( 'Custom Logo', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name'   => esc_html__( 'Custom Logo', TIELABS_TEXTDOMAIN ),
					'id'     => 'custom_logo',
					'toggle' => '#tie-post-logo-item',
					'type'   => 'checkbox',
				),

				array(
					'content' => '<div id="tie-post-logo-item">',
					'type'    => 'html',
				),
				array(
					'name'    => esc_html__( 'Logo Settings', TIELABS_TEXTDOMAIN ),
					'id'      => 'logo_setting',
					'type'    => 'radio',
					'toggle'  => array(
						'logo'  => '#logo-image-settings',
						'title' => ''),
					'options'	=> array(
						'logo'  => esc_html__( 'Image', TIELABS_TEXTDOMAIN ),
						'title' => esc_html__( 'Site Title', TIELABS_TEXTDOMAIN ),
				)),

				array(
					'content' => '<div id="logo-image-settings" class="logo_setting-options">',
					'type'    => 'html',
				),

				array(
					'name'  => esc_html__( 'Logo Image', TIELABS_TEXTDOMAIN ),
					'id'    => 'logo',
					'type'  => 'upload',
				),

				array(
					'name'  => esc_html__( 'Logo Image (Retina Version @2x)', TIELABS_TEXTDOMAIN ),
					'id'    => 'logo_retina',
					'type'  => 'upload',
					'hint'	=> esc_html__( 'Please choose an image file for the retina version of the logo. It should be 2x the size of main logo.', TIELABS_TEXTDOMAIN ),
				),

				array(
					'name'  => esc_html__( 'Logo Inverted Image', TIELABS_TEXTDOMAIN ),
					'id'    => 'logo_inverted',
					'type'  => 'upload',
					'hint'	=> '<strong>'. esc_html__( 'Used if users are allowed to switch between Light and Dark skins.', TIELABS_TEXTDOMAIN ) .'</strong>',
				),

				array(
					'name'  => esc_html__( 'Logo Inverted Image (Retina Version @2x)', TIELABS_TEXTDOMAIN ),
					'id'    => 'logo_inverted_retina',
					'type'  => 'upload',
					'hint'	=> '<strong>'. esc_html__( 'Used if users are allowed to switch between Light and Dark skins.', TIELABS_TEXTDOMAIN ) .'</strong><br />'. esc_html__( 'Please choose an image file for the retina version of the logo. It should be 2x the size of main logo.', TIELABS_TEXTDOMAIN ),
				),

				array(
					'name'  => esc_html__( 'Logo width', TIELABS_TEXTDOMAIN ),
					'id'    => 'logo_retina_width',
					'type'  => 'number',
				),

				array(
					'name'  => esc_html__( 'Logo height', TIELABS_TEXTDOMAIN ),
					'id'    => 'logo_retina_height',
					'type'  => 'number',
				),

				array(
					'content' => '</div>',
					'type'    => 'html',
				),

				array(
					'name'  => esc_html__( 'Logo Text', TIELABS_TEXTDOMAIN ),
					'id'    => 'logo_text',
					'type'  => 'text',
					'hint'  => esc_html__( 'In the Logo Image type this will be used as the ALT text.', TIELABS_TEXTDOMAIN ),
				),

				array(
					'name' => esc_html__( 'Logo Margin Top', TIELABS_TEXTDOMAIN ),
					'id'   => 'logo_margin',
					'type' => 'number',
					'hint' => esc_html__( 'Leave it empty to use the default value.', TIELABS_TEXTDOMAIN ),
				),

				array(
					'name' => esc_html__( 'Logo Margin Bottom', TIELABS_TEXTDOMAIN ),
					'id'   => 'logo_margin_bottom',
					'type' => 'number',
					'hint' => esc_html__( 'Leave it empty to use the default value.', TIELABS_TEXTDOMAIN ),
				),

				array(
					'name'  => esc_html__( 'Custom Logo URL', TIELABS_TEXTDOMAIN ),
					'id'    => 'logo_url',
					'type'  => 'text',
					'hint'  => esc_html__( 'Leave it empty to use the Site URL.', TIELABS_TEXTDOMAIN ),
				),

				array(
					'content' => '</div>',
					'type'    => 'html',
				),
			);



			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/logo/defaults', $settings );
		}


		/**
		 * Post Logo Settings
		 */
		function sidebar_settings( $current_settings ){

			$settings = array(

				array(
					'title' => esc_html__( 'Sidebar Position', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'id'      => 'tie_sidebar_pos',
					'type'    => 'visual',
					'columns' => 5,
					'options' => array(
						''           => array( esc_html__( 'Default',         TIELABS_TEXTDOMAIN ) => 'default.png' ),
						'right'	     => array( esc_html__( 'Sidebar Right',   TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-right.png' ),
						'left'	     => array( esc_html__( 'Sidebar Left',    TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-left.png' ),
						'full'	     => array( esc_html__( 'Without Sidebar', TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-full-width.png' ),
						'one-column' => array( esc_html__( 'One Column',      TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-one-column.png' ),
				)),

				array(
					'name'   => esc_html__( 'Sticky Sidebar', TIELABS_TEXTDOMAIN ),
					'id'     => 'tie_sticky_sidebar',
					'type'   => 'select',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Yes',     TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'No',      TIELABS_TEXTDOMAIN ),
				)),

				array(
					'title' => esc_html__( 'Custom Sidebar', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name'    => esc_html__( 'Choose Sidebar', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_sidebar_post',
					'type'    => 'select',
					'options' => TIELABS_ADMIN_HELPER::get_sidebars(),
				),
			);


			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/sidebar/defaults', $settings );
		}


		/**
		 * Post Styles Settings
		 */
		function styles_settings( $current_settings ){

			$settings = array(

				array(
					'content' => '<div id="tie_header_extend_bg_option">',
					'type'    => 'html',
				),

				array(
					'title' => esc_html__( 'Header Background', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name' => esc_html__( 'Extend the background of the first section to cover the Header', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_header_extend_bg',
					'type' => 'checkbox',
				),

				array(
					'content' => '</div>',
					'type'    => 'html',
				),

				array(
					'title' => esc_html__( 'Primary Color', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name' => esc_html__( 'Primary Color', TIELABS_TEXTDOMAIN ),
					'id'   => 'post_color',
					'type' => 'color',
				),

				array(
					'title' =>	esc_html__( 'Background', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'text'  => esc_html__( 'Bordered Layout supports plain background color only.', TIELABS_TEXTDOMAIN ),
					'type'  => 'message',
				),

				array(
					'name'  => esc_html__( 'Background Color', TIELABS_TEXTDOMAIN ),
					'id'    => 'background_color',
					'type'  => 'color',
				),

				array(
					'name'  => esc_html__( 'Background Color 2', TIELABS_TEXTDOMAIN ),
					'id'    => 'background_color_2',
					'type'  => 'color',
				),

				array(
					'name'   => esc_html__( 'Background Image type', TIELABS_TEXTDOMAIN ),
					'id'     => 'background_type',
					'type'   => 'radio',
					'toggle' => array(
						''        => '',
						'pattern' => '#background_pattern-item',
						'image'   => '#background_image-item',),
					'options' => array(
						''        => esc_html__( 'None',    TIELABS_TEXTDOMAIN ),
						'pattern' => esc_html__( 'Pattern', TIELABS_TEXTDOMAIN ),
						'image'   => esc_html__( 'Image',   TIELABS_TEXTDOMAIN ),
				)),

				array(
					'name'    => esc_html__( 'Background Pattern', TIELABS_TEXTDOMAIN ),
					'id'      => 'background_pattern',
					'type'    => 'visual',
					'class'   => 'background_type',
					'options' => TIELABS_ADMIN_HELPER::get_patterns(),
				),

				array(
					'name'  => esc_html__( 'Background Image', TIELABS_TEXTDOMAIN ),
					'id'    => 'background_image',
					'class' => 'background_type',
					'type'  => 'background',
				),

				array(
					'type'  => 'header',
					'title' => esc_html__( 'Background Settings', TIELABS_TEXTDOMAIN ),
				),

				array(
					'name' => esc_html__( 'Dots overlay layer', TIELABS_TEXTDOMAIN ),
					'id'   => 'background_dots',
					'type' => 'checkbox',
				),

				array(
					'name'   => esc_html__( 'Background dimmer', TIELABS_TEXTDOMAIN ),
					'id'     => 'background_dimmer',
					'toggle' => '#background_dimmer_value-item, #background_dimmer_color-item',
					'type'   => 'checkbox',
				),

				array(
					'name' => esc_html__( 'Background dimmer', TIELABS_TEXTDOMAIN ),
					'id'   => 'background_dimmer_value',
					'hint' => esc_html__( 'Value between 0 and 100 to dim background image. 0 - no dim, 100 - maximum dim.', TIELABS_TEXTDOMAIN ),
					'type' => 'number',
				),

				array(
					'name'    => esc_html__( 'Background dimmer color', TIELABS_TEXTDOMAIN ),
					'id'      => 'background_dimmer_color',
					'type'    => 'radio',
					'options'	=> array(
						'black' => esc_html__( 'Black', TIELABS_TEXTDOMAIN ),
						'white' => esc_html__( 'White', TIELABS_TEXTDOMAIN ),
				)),

				array(
					'title' =>	esc_html__( 'Custom CSS', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'text' => esc_html__( 'Paste your CSS code, do not include any tags or HTML in the field. Any custom CSS entered here will override the theme CSS. In some cases, the !important tag may be needed.', TIELABS_TEXTDOMAIN ),
					'type' => 'message',
				),

				array(
					'name'  => esc_html__( 'Custom CSS', TIELABS_TEXTDOMAIN ),
					'id'    => 'tie_custom_css',
					'class' => 'tie-css',
					'type'  => 'textarea',
					'hint'  => sprintf( esc_html__( 'Use %s and it will be replaced with the primary color.', TIELABS_TEXTDOMAIN ), '<code>primary-color</code>' ),
				),
			);


			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/styles/defaults', $settings );
		}


		/**
		 * Post Menu Settings
		 */
		function menu_settings( $current_settings ){

			$settings = array(

				array(
					'title' => esc_html__( 'Custom Menu', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name'    => esc_html__( 'Custom Menu', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_menu',
					'type'    => 'select',
					'options' => TIELABS_ADMIN_HELPER::get_menus( true ),
				),
			);


			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/components/defaults', $settings );
		}


		/**
		 * General Components Settings
		 */
		function components_settings( $current_settings ){

			$settings = array(

				array(
					'title' => esc_html__( 'Post Components', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name'	  => esc_html__( 'Above Post share Buttons', TIELABS_TEXTDOMAIN ),
					'id'		  => 'tie_hide_share_top',
					'type'	  => 'select',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Hide',    TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'Show',    TIELABS_TEXTDOMAIN ),
				)),

				array(
					'name'	  => esc_html__( 'Below Post Share Buttons', TIELABS_TEXTDOMAIN ),
					'id'		  => 'tie_hide_share_bottom',
					'type'	  => 'select',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Hide',    TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'Show',    TIELABS_TEXTDOMAIN ),
				)),

			);


			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/menu/defaults', $settings );
		}


		/**
		 * Post Components Settings
		 */
		function post_components_settings( $current_settings ){

			if( ! TIELABS_HELPER::is_supported_post_type() ){
				return $current_settings;
			}

			$settings = array(

				array(
					'name'    => esc_html__( 'Categories', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_hide_categories',
					'type'    => 'select',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Hide',    TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'Show',    TIELABS_TEXTDOMAIN ),
				)),

				array(
					'name'    => esc_html__( 'Tags', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_hide_tags',
					'type'    => 'select',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Hide',    TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'Show',    TIELABS_TEXTDOMAIN ),
				)),

				array(
					'name'    => esc_html__( 'Post Meta', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_hide_meta',
					'type'    => 'select',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Hide',    TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'Show',    TIELABS_TEXTDOMAIN ),
				)),

				array(
					'name'    => esc_html__( 'Post Author box', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_hide_author',
					'type'    => 'select',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Hide',    TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'Show',    TIELABS_TEXTDOMAIN ),
				)),

				array(
					'name'	  => esc_html__( 'Next/Prev posts', TIELABS_TEXTDOMAIN ),
					'id'		  => 'tie_hide_nav',
					'type'	  => 'select',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Hide',    TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'Show',    TIELABS_TEXTDOMAIN ),
				)),

				array(
					'name'    => esc_html__( 'Newsletter', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_hide_newsletter',
					'type'    => 'select',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Hide',    TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'Show',    TIELABS_TEXTDOMAIN ),
				)),

				array(
					'name'    => esc_html__( 'Related Posts', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_hide_related',
					'type'    => 'select',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Hide',    TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'Show',    TIELABS_TEXTDOMAIN ),
				)),

				array(
					'name'    => esc_html__( 'Read Next Slider', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_hide_read_next',
					'type'    => 'select',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Hide',    TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'Show',    TIELABS_TEXTDOMAIN ),
				)),

				array(
					'name'    => esc_html__( 'Fly Check Also Box', TIELABS_TEXTDOMAIN ),
					'id'      => 'tie_hide_check_also',
					'type'    => 'select',
					'options' => array(
						''    => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'yes' => esc_html__( 'Hide',    TIELABS_TEXTDOMAIN ),
						'no'  => esc_html__( 'Show',    TIELABS_TEXTDOMAIN ),
				)),

			);


			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/post_components/defaults', $settings );
		}


		/**
		 * Post Ads Settings
		 */
		function e3lan_settings( $current_settings ){

			$settings = array(

				array(
					'title' => esc_html__( 'Advertisement', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name' => esc_html__( 'Disable All Ads', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_disable_all_ads',
					'type' => 'checkbox',
				),

				array(
					'title' => esc_html__( 'Above Post Ad', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name' => esc_html__( 'Hide Above Post Ad', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_hide_above',
					'type' => 'checkbox',
				),

				array(
					'name' => esc_html__( 'Custom Above Post Ad', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_get_banner_above',
					'type' => 'textarea',
				),

				array(
					'title' => esc_html__( 'Below Post Ad', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name' => esc_html__( 'Hide Below Post Ad', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_hide_below',
					'type' => 'checkbox',
				),

				array(
					'name' => esc_html__( 'Custom Below Post Ad', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_get_banner_below',
					'type' => 'textarea',
				),


				array(
					'title' => esc_html__( 'Above Content Ad', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name' => esc_html__( 'Hide Above Content Ad', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_hide_above_content',
					'type' => 'checkbox',
				),

				array(
					'name' => esc_html__( 'Custom Above Content Ad', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_get_banner_above_content',
					'type' => 'textarea',
				),


				array(
					'title' => esc_html__( 'Below Content Ad', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				),

				array(
					'name' => esc_html__( 'Hide Below Content Ad', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_hide_below_content',
					'type' => 'checkbox',
				),

				array(
					'name' => esc_html__( 'Custom Below Content Ad', TIELABS_TEXTDOMAIN ),
					'id'   => 'tie_get_banner_below_content',
					'type' => 'textarea',
				),
			);


			if( ! empty( $current_settings ) && is_array( $current_settings ) ){
				$settings = array_merge( $current_settings, $settings );
			}

			return apply_filters( 'TieLabs/Settings/Post/e3lan/defaults', $settings );
		}


		/**
		 * Source Settings
		 */
		function source_settings(){

			$this->build_option(
				array(
					'title' => esc_html__( 'Source', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
			));

			?>

			<div class="option-item source-via-options">

				<p><?php esc_html_e( 'These links will appear at the end of the article in the Source section.', TIELABS_TEXTDOMAIN ) ?></p>

				<input id="source_name" type="text" size="56" name="source_name" placeholder="<?php esc_html_e( 'Source', TIELABS_TEXTDOMAIN ) ?>" value="" />
				<input id="source_link" type="text" size="56" name="source_link" placeholder="<?php esc_html_e( 'Link', TIELABS_TEXTDOMAIN ) ?>" value="" />
				<input id="add_source_button"  class="button" type="button" value="<?php esc_html_e( 'Add', TIELABS_TEXTDOMAIN ) ?>" />

				<?php
					$this->build_option(
						array(
							'text' => esc_html__( 'Source name is required.', TIELABS_TEXTDOMAIN ),
							'id'   => 'add-source-error',
							'type' => 'error',
						));
				?>

				<div class="clear"></div>
				<ul id="sources-list">
					<?php

						$sources = tie_get_postdata( 'tie_source' );
						$sources_count = 0;

						if( ! empty( $sources ) && is_array( $sources ) ) {

							foreach ( $sources as $single_source ){

								$sources_count++; ?>

								<li class="parent-item">
									<div class="tie-block-head">

										<?php
											if( ! empty( $single_source['url'] ) ){ ?>
												<a href="<?php echo esc_url( $single_source['url'] ) ?>" target="_blank"><?php echo esc_html( $single_source['text'] ) ?></a>
												<input name="tie_source[<?php echo esc_attr( $sources_count ) ?>][url]"  type="hidden" value="<?php echo esc_attr( $single_source['url']  ) ?>" />
												<?php
											}
											else{
												echo esc_html( $single_source['text'] );
											}
										?>

										<input name="tie_source[<?php echo esc_attr( $sources_count ) ?>][text]" type="hidden" value="<?php echo esc_attr( $single_source['text'] ) ?>" />
										<a class="del-item dashicons dashicons-trash"></a>
									</div>
								</li>
								<?php
							}
						}
					?>
				</ul>

				<script>
					var source_next = <?php echo esc_js( $sources_count+1 ); ?>;

					jQuery(function(){
						jQuery( '#sources-list' ).sortable({placeholder: 'tie-state-highlight'});
					});
				</script>
			</div>
			<?php
		}


		/**
		 * Via Settings
		 */
		function via_settings(){

			$this->build_option(
				array(
					'title' => esc_html__( 'Via', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
				));
			?>

			<div class="option-item source-via-options">

				<p><?php esc_html_e( 'These links will appear at the end of the article in the Via section.', TIELABS_TEXTDOMAIN ) ?></p>

				<input id="via_name" type="text" size="56" name="via_name" placeholder="<?php esc_html_e( 'Via', TIELABS_TEXTDOMAIN ) ?>" value="" />
				<input id="via_link" type="text" size="56" name="via_link" placeholder="<?php esc_html_e( 'Link', TIELABS_TEXTDOMAIN ) ?>" value="" />
				<input id="add_via_button"  class="button" type="button" value="<?php esc_html_e( 'Add', TIELABS_TEXTDOMAIN ) ?>" />

				<?php
					$this->build_option(
						array(
							'text' => esc_html__( 'Via name is required.', TIELABS_TEXTDOMAIN ),
							'id'   => 'add-via-error',
							'type' => 'error',
					));
				?>

				<div class="clear"></div>
				<ul id="via-list">
					<?php

						$via = tie_get_postdata( 'tie_via' );
						$via_count = 0;

						if( ! empty( $via ) && is_array( $via ) ) {
							foreach ( $via as $single_via ){
								$via_count++; ?>

								<li class="parent-item">
									<div class="tie-block-head">

										<?php
											if( ! empty( $single_via['url'] ) ){ ?>
												<a href="<?php echo esc_url( $single_via['url'] ) ?>" target="_blank"><?php echo esc_html( $single_via['text'] ) ?></a>
												<input name="tie_via[<?php echo esc_attr( $via_count ) ?>][url]"  type="hidden" value="<?php echo esc_attr( $single_via['url']  ) ?>" />
												<?php
											}
											else{
												echo esc_html( $single_via['text'] );
											}
										?>

										<input name="tie_via[<?php echo esc_attr( $via_count ) ?>][text]" type="hidden" value="<?php echo esc_attr( $single_via['text'] ) ?>" />
										<a class="del-item dashicons dashicons-trash"></a>
									</div>
								</li>
								<?php
							}
						}
					?>
				</ul>

				<script>
					var via_next = <?php echo esc_js( $via_count+1 ); ?>;

					jQuery(function(){
						jQuery( '#via-list' ).sortable({placeholder: 'tie-state-highlight'});
					});
				</script>
			</div>
			<?php
		}


		/**
		 * Highlights Settings
		 */
		function highlights_settings(){

			$this->build_option(
				array(
					'title' => esc_html__( 'Story Highlights', TIELABS_TEXTDOMAIN ),
					'type'  => 'header',
			));
			?>

			<div class="option-item breaking_type-options" id="breaking_custom-item">

				<span class="tie-label"><?php esc_html_e( 'Add Custom Text', TIELABS_TEXTDOMAIN ) ?></span>
				<input id="custom_text" type="text" size="56" name="custom_text" placeholder="<?php esc_html_e( 'Custom Text', TIELABS_TEXTDOMAIN ) ?>" value="" />
				<input id="add_highlights_button"  class="button" type="button" value="<?php esc_html_e( 'Add', TIELABS_TEXTDOMAIN ) ?>" />

				<?php
					$this->build_option(
						array(
							'text' => esc_html__( 'Text is required.', TIELABS_TEXTDOMAIN ),
							'id'   => 'highlights_custom_error',
							'type' => 'error',
					));
				?>

				<script>
					jQuery(function(){
						jQuery( "#customList" ).sortable({placeholder: "tie-state-highlight"});
					});
				</script>

				<div class="clear"></div>
				<ul id="customList">
					<?php
						$highlights_text = tie_get_postdata( 'tie_highlights_text' );
						$custom_count    = 0;

						if( ! empty( $highlights_text ) && is_array( $highlights_text ) ) {
							foreach ( $highlights_text as $custom_text ){
								$custom_count++; ?>

								<li class="parent-item">
									<div class="tie-block-head">
										<?php echo esc_html( $custom_text ) ?>
										<input name="tie_highlights_text[<?php echo esc_attr( $custom_count ) ?>]" type="hidden" value="<?php echo esc_attr( $custom_text ) ?>" />
										<a class="del-item dashicons dashicons-trash"></a>
									</div>
								</li>
								<?php
							}
						}
					?>
				</ul>

				<script>
					var customnext = <?php echo esc_js( $custom_count+1 ); ?>;
				</script>

			</div><!-- #breaking_custom-item /-->

			<?php
		}

	}

	$TIELABS_SETTINGS_POST = new TIELABS_SETTINGS_POST();
}
