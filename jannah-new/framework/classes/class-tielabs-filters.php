<?php
/**
 * Filters
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


class TIELABS_FILTERS {

	/**
	 * Runs on class initialization. Adds filters and actions.
	 */
	function __construct() {

		// Add Support for Shortcodes in the terms descriptions
		add_filter( 'term_description', 'do_shortcode' );

		//add_action( 'init',                  array( $this, 'init_hook' ) );
		add_action( 'init',                  array( $this, 'redirect_random_post' ) );

		add_action( 'wp_head',               array( $this, 'meta_description' ) );
		add_action( 'wp_head',               array( $this, 'meta_generator' ) );
		add_action( 'wp_head',               array( $this, 'x_ua_compatible' ) );

		add_action( 'wp_footer',             array( $this, 'footer_inline_scripts' ), 999 );
		add_action( 'wp_footer',             array( $this, 'footer_misc'  ) );
		add_action( 'wp_footer',             array( $this, 'popup_module' ) );

		add_action( 'comment_class',         array( $this, 'is_avatar_enabled' ) );
		add_filter( 'pre_get_posts',         array( $this, 'search_filters' ) );
		add_filter( 'pre_get_posts',         array( $this, 'category_posts_order' ) );
		add_filter( 'TieLabs/cache_key',     array( $this, 'cache_key' ) );
		add_filter( 'widget_tag_cloud_args', array( $this, 'tag_widget_limit' ) );
		add_filter( 'widget_title',          array( $this, 'tagcloud_widget_title' ), 10, 3 );
		add_filter( 'login_headerurl',       array( $this, 'dashboard_login_logo_url' ) );
		add_filter( 'login_head',            array( $this, 'dashboard_login_logo' ) );
		add_filter( 'get_the_archive_title', array( $this, 'archive_title' ), 15 );
		add_filter( 'wp_link_pages_args',    array( $this, 'pages_next_and_number' ) );
		add_filter( 'excerpt_more',          array( $this, 'excerpt_more' ) );
		add_filter( 'get_the_excerpt',       array( $this, 'post_excerpt' ), 9 );

		add_filter( 'has_post_thumbnail',    array( $this, 'has_post_thumbnail' ) );
		add_filter( 'post_thumbnail_html',   array( $this, 'default_featured_image' ), 10, 5 );

		add_filter( 'TieLabs/exclude_content',            'TIELABS_HELPER::strip_shortcodes' );
		add_filter( 'wp_get_attachment_image_src',        array( $this, 'gif_image' ), 10, 4 );
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'small_thumb_image_class' ), 10, 3 );

		add_filter( 'TieLabs/Primary_Category/custom', array( $this, 'yoast_seo_primary_category' ) );

		// Translations
		if( tie_get_option( 'translations' ) ){
			add_filter( 'gettext', array( $this, 'theme_translation' ), 10, 3 );
		}

		if( tie_get_option( 'translation_numbers' ) ){
			add_filter( 'get_the_date',                   array( $this, 'translate_numbers' ), 55 );
			add_filter( 'get_comment_date',               array( $this, 'translate_numbers' ), 55 );
			add_filter( 'get_comment_time',               array( $this, 'translate_numbers' ), 55 );
			add_filter( 'comments_number',                array( $this, 'translate_numbers' ), 55 );
			add_filter( 'wp_list_categories',             array( $this, 'translate_numbers' ), 55 );
			add_filter( 'TieLabs/number_format',          array( $this, 'translate_numbers' ), 55 );
			add_filter( 'TieLabs/post_date',              array( $this, 'translate_numbers' ), 55 );
			add_filter( 'TieLabs/reading_time',           array( $this, 'translate_numbers' ), 55 );
			add_filter( 'TieLabs/post_views_number',      array( $this, 'translate_numbers' ), 55 );
			add_filter( 'TieLabs/Social_Counters/number', array( $this, 'translate_numbers' ), 55 );
			add_filter( 'TieLabs/Weather/number',         array( $this, 'translate_numbers' ), 55 );
		}
	}


	/**
	 * init_hook
	 */
	function init_hook(){

		if( current_user_can( 'manage_options' ) ){
			add_filter( 'the_content', array( $this, 'shortcodes_notice' ) );
		}
	}


	/**
	 * Add notice for the shortcodes plugin
	 */
	function shortcodes_notice( $content ){

		// Don't show the message if this is excerpt OR backend OR AMP
		if(
				is_admin() ||
				( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) ||
				in_array( 'parse_request',   $GLOBALS['wp_current_filter'] ) ||
				in_array( 'get_the_excerpt', $GLOBALS['wp_current_filter'] ) ){
			return $content;
		}

		$message = '';

		// Timetable and Event Schedule Plugin
		if( ! TIELABS_MPTIMETABLE_IS_ACTIVE ){

			if( strpos( $content, '[mp-timetable' ) !== false ){

				$message .= TIELABS_HELPER::notice_message( sprintf(
					esc_html__( 'This section contains some shortcodes that requries the %2$s%1$s%3$s Plugin.', TIELABS_TEXTDOMAIN ),
					'<strong>Timetable and Event Schedule</strong>',
					'<a href="https://wordpress.org/plugins/mp-timetable/" target="_blank" rel="noopener">',
					'</a>'
				), false );
			}
		}

		// Contact Form 7 Plugin
		if( ! class_exists( 'WPCF7' ) ){

			if( strpos( $content, '[contact-form-7' ) !== false ){

				$message .= TIELABS_HELPER::notice_message( sprintf(
					esc_html__( 'This section contains some shortcodes that requries the %2$s%1$s%3$s Plugin.', TIELABS_TEXTDOMAIN ),
					'<strong>Contact Form 7</strong>',
					'<a href="https://wordpress.org/plugins/contact-form-7/" target="_blank" rel="noopener">',
					'</a>'
				), false) ;
			}
		}

		// Return the content with message
		return apply_filters( 'TieLabs/shortcodes_check', $message, $content ) . $content;
	}


	/**
	 * x_ua_compatible
	 */
	function x_ua_compatible(){
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
	}


	/**
	 * meta_escription
	 */
	function meta_description(){

		// Return if the description option is disabled or the Yoast SEO plugin is active
		if( ! tie_get_option( 'post_meta_escription' ) || class_exists( 'WPSEO_Frontend' ) ){
			return;
		}

		// Single Page doesn't have a builder
		if( is_singular() && ! TIELABS_HELPER::has_builder() ){

			$post = get_post();

			if( ! empty( $post->post_content ) ){
				$description = apply_filters( 'TieLabs/exclude_content', $post->post_content );
			}
		}
		// Archives
		elseif( get_the_archive_description() ){
			$description = get_the_archive_description();
		}

		// Default
		if( empty( $description ) ){
			$description = get_bloginfo( 'description' );
		}

		if( ! empty( $description ) ){
			$description = strip_tags( strip_shortcodes( $description ) );
			echo ' <meta name="description" content="'. esc_attr( wp_html_excerpt( $description, 150 ) ) .'" />';
		}
	}


	/**
	 * Theme translations
	 */
	function theme_translation( $translation, $text, $domain ){

		if( $domain == TIELABS_TEXTDOMAIN || $domain == 'amp' ){

			$translations = tie_get_option( 'translations' );

			if( ! empty( $translations ) ){  // To minimize the calls of sanitize_title
				$sanitize_text = sanitize_title( htmlspecialchars( $text ) );

				if( ! empty( $translations[ $sanitize_text ] ) ){
					return htmlspecialchars_decode( $translations[ $sanitize_text ] );
				}
			}
		}

		return $translation;
	}


	/**
	 * Add the inline scripts to the Footer
	 */
	function footer_inline_scripts(){

		// Check if we are in an AMP page
		if( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ){
			return;
		}

		// Print the inline scripts if the BWP is active
		if( ! empty( $GLOBALS['tie_inline_scripts'] ) && TIELABS_HELPER::is_js_minified() ){
			echo '<script type="text/javascript">'. $GLOBALS['tie_inline_scripts'] .'</script>';
		}
	}


	/**
	 * Add Misc Footer Conetnt
	 */
	function footer_misc(){

		// Check if we are in an AMP page
		if( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ){
			return;
		}

		// Custom Footer Code
		if ( tie_get_option( 'footer_code' ) ){
			echo do_shortcode( apply_filters( 'TieLabs/footer_code', tie_get_option( 'footer_code' ) ) );
		}

		// Reading Position Indicator
		if ( tie_get_option( 'reading_indicator' ) && is_single() && ! tie_get_option( 'autoload_posts' ) ){
			echo '<div id="reading-position-indicator"></div>';
		}

		// Live Search
		if(
			tie_menu_has_search( 'top_nav', true )  ||
			tie_menu_has_search( 'main_nav', true ) ||
		  ( tie_get_option( 'mobile_header_components_search') && tie_get_option( 'mobile_header_live_search') )
		){
			echo '<div id="autocomplete-suggestions" class="autocomplete-suggestions"></div>';
		}

		// Scrollbar - Used to get the default scrollbar width.
		echo '<div id="is-scroller-outer"><div id="is-scroller"></div></div>';

		// Facebook buttons
		echo '<div id="fb-root"></div>';
	}


	/**
	 * Add the Popup module to the footer
	 */
	function popup_module(){

		// Check if we are in an AMP page
		if( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ){
			return;
		}

		TIELABS_HELPER::get_template_part( 'templates/popup' );
	}


	/**
	 * Add an extra class to the comment item if the avatar is active
	 */
	function is_avatar_enabled( $classes ){

		if( is_array( $classes ) && get_option( 'show_avatars' ) ){
			$classes[] = 'has-avatar';
		}

		return $classes;
	}


	/**
	 * Exclude post types and categories From Search results
	 */
	function search_filters( $query ){

		if( is_admin() || isset( $_GET['post_type'] ) ){
			return $query;
		}

		if( is_search() && $query->is_main_query() ){

			// Exclude Post types from search
			if ( ($exclude_post_types = tie_get_option( 'search_exclude_post_types' )) && is_array( $exclude_post_types ) ){

				$args = array(
					'public' => true,
					'exclude_from_search' => false,
				);

				$post_types = get_post_types( $args );

				foreach ( $exclude_post_types as $post_type ){
					unset( $post_types[ $post_type ] );
				}

				$query->set( 'post_type', $post_types );
			}

			// Exclude specific categoies from search
			if ( tie_get_option( 'search_cats' ) ){
				$query->set( 'cat', tie_get_option( 'search_cats' ) );
			}
		}

		return $query;
	}


	/**
	 * Change the posts order in the category page
	 */
	function category_posts_order( $query ){

		if( ! is_admin() && is_category() && $query->is_main_query() ){

			$current_category = get_queried_object();

			if( ! empty( $current_category->term_id ) ){

				$posts_order = tie_get_category_option( 'posts_order', $current_category->term_id );

				// Posts Order
				if( ! empty( $posts_order ) ){

					if( $posts_order == 'views' && tie_get_option( 'tie_post_views' ) ){ // Most Viewd posts
						$query->set( 'orderby', 'meta_value_num' );
						$query->set( 'meta_key', apply_filters( 'TieLabs/views_meta_field', 'tie_views' ) );
					}
					elseif( $posts_order == 'popular' ){ // Popular Posts by comments
						$query->set( 'orderby', 'comment_count' );
					}
					elseif( $posts_order == 'title' ){
						$query->set( 'orderby', 'title' );
						$query->set( 'order', 'ASC' );
					}
					else{
						$query->set( 'orderby', $posts_order );
					}
				}
			}
		}

		return $query;
	}


	/**
	 * Random Article
	 */
	function redirect_random_post(){

		if( wp_doing_ajax() ){
			return;
		}

		if( isset( $_GET['random-post'] ) && ( tie_get_option( 'top-nav-components_random' ) || tie_get_option( 'main-nav-components_random' ) ) ) {

			$args = array(
				'posts_per_page'      => 1,
				'orderby'             => 'rand',
				'fields'              => 'ids',
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			);

			$random_post = new WP_Query ( $args );

			while ( $random_post->have_posts () ){
				$random_post->the_post();
				wp_redirect( get_permalink() );
				exit;
			}
		}
	}


	/**
	 * Widgets Small Image Class
	 *
	 * By default WordPress uses 2 classes attachment-{size} size-{size}
	 * we need to add a general class doesn't linked with the thumb name
	 */
	function small_thumb_image_class( $attr, $attachment, $size = false ) {

		if( ! empty( $size ) && $size == TIELABS_THEME_SLUG.'-image-small' ){
			$attr['class'] .= ' tie-small-image';
		}

		return $attr;
	}


	/**
	 * Gif images
	 */
	function gif_image( $image, $attachment_id, $size, $icon ){

		if( ! tie_get_option( 'disable_featured_gif' ) ){

			$file_type = ! empty( $image[0] ) ? wp_check_filetype( $image[0] ) : false;

			if( ! empty( $file_type ) && $file_type['ext'] == 'gif' && $size != 'full' ){

				$full_image = wp_get_attachment_image_src( $attachment_id, $size = 'full', $icon );

				// For the avatars we need to keep the original width and height
				if( ! empty( $full_image ) && in_array( 'get_avatar', $GLOBALS['wp_current_filter'] ) ){
					$full_image[1] = $image[1];
					$full_image[2] = $image[2];
				}

				return $full_image;
			}
		}

		return $image;
	}


	/**
	 * Modify Excerpts
	 */
	function post_excerpt( $text = '' ){

		$raw_excerpt = $text;

		if ( '' == $text ){
			$text = get_the_content( '' );
			$text = apply_filters( 'TieLabs/exclude_content', $text );

			/**
			 * If images with class wp-image-{ID} exists in the conetnt, WordPress make a DB request to get andd add the srcset
			 * Since we are in excerpt we don't need that, Great affect on archives pages
			 */
			$text = str_replace( 'wp-image-', 'tie-image', $text );

			$text = strip_shortcodes( $text );
			$text = apply_filters( 'the_content', $text );
			$text = str_replace( ']]>', ']]>', $text );

			$excerpt_length = apply_filters( 'excerpt_length', 55 );
			$excerpt_more   = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
			$text           = wp_trim_words( $text, $excerpt_length, $excerpt_more );
		}

		return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );
	}


	/**
	 * Global Cache Key
	 */
	function cache_key( $key ){
		return 'tie-cache-'. TIELABS_HELPER::get_locale() . $key;
	}


	/**
	 * Change the number of tags in the cloud tags
	 */
	function tag_widget_limit( $args ){

		if( isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag' ){
			$args['number'] = 18;
		}

		return $args;
	}


	/**
	 * Remove the default Tag CLoud titles if the title field is empty
	 */
	function tagcloud_widget_title( $title = false, $instance = false, $id_base = false ){

		if( $id_base == 'tag_cloud' && empty( $instance['title'] ) ){
			return false;
		}

		return $title;
	}


	/**
	 * Custom Dashboard login URL
	 */
	function dashboard_login_logo_url(){

		if( tie_get_option( 'dashboard_logo_url' ) ){
			return tie_get_option( 'dashboard_logo_url' );
		}
	}


	/**
	 * Custom Dashboard login page logo
	 */
	function dashboard_login_logo(){

		if( tie_get_option( 'dashboard_logo' ) ){
			echo '<style type="text/css"> .login h1 a {  background-image:url('.tie_get_option( 'dashboard_logo' ).')  !important; background-size: contain; width: 320px; height: 85px; } </style>';
		}
	}



	/**
	 * Remove anything that looks like an archive title prefix ("Archive:", "Foo:", "Bar:").
	 */
	function archive_title( $title ){

		if ( is_category() ) {
			return single_cat_title( '', false );
		}
		elseif ( is_tag() ) {
			return single_tag_title( '', false );
		}
		elseif ( is_author() ) {
			return '<span class="vcard">' . get_the_author() . '</span>';
		}
		elseif ( is_post_type_archive() ) {
			return post_type_archive_title( '', false );
		}
		elseif ( is_tax() ) {
			return single_term_title( '', false );
		}

		return $title;
	}


	/**
	 * Add Number and Next / prev multiple post pages
	 */
	function pages_next_and_number( $args ){

		if( $args['next_or_number'] == 'next_and_number' ){

			global $page, $numpages, $multipage, $more;
			$args['next_or_number'] = 'number';
			$prev = '';
			$next = '';

			if ( $multipage && $more ){
				$i = $page - 1;
				if ( $i && $more ){
					$prev .= _wp_link_page($i);
					$prev .= $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>';
				}

				$i = $page + 1;
				if ( $i <= $numpages && $more ){
					$next .= _wp_link_page($i);
					$next .= $args['link_before']. $args['nextpagelink'] . $args['link_after'] . '</a>';
				}
			}

			$args['before'] = $args['before'].$prev;
			$args['after'] = $next.$args['after'];
		}

		return $args;
	}


	/**
	 * Excerpt More
	 */
	function excerpt_more( $more ){
		return ' &hellip;';
	}


	/**
	 * Theme Generator Meta
	 */
	function meta_generator(){

		$active_theme = wp_get_theme();

		if ( is_child_theme() ) {
			$active_theme = wp_get_theme( $active_theme->Template );
		}

		if( ! empty( $active_theme->Name ) ){
			$theme_info = apply_filters( 'TieLabs/theme_meta_generator', $active_theme->Name .' '.  TIELABS_DB_VERSION );
			if( ! empty( $theme_info ) ){
				echo "\n" . "<meta name='generator' content='' />" . "\n";
			}
		}
	}


	/**
	 * If the post doesn't have a Primary Category, use the Primary Category of Yoast if it is available
	 */
	function yoast_seo_primary_category( $category = false ){

		if( class_exists( 'WPSEO_Meta' ) ){

			$wpseo_primary_term = get_post_meta( get_the_id(), WPSEO_Meta::$meta_prefix . 'primary_category', true );

			if( ! empty( $wpseo_primary_term ) ){
				$get_the_category = TIELABS_WP_HELPER::get_term_by( 'id', $wpseo_primary_term, 'category' );

				if ( ! empty( $get_the_category ) && ! is_wp_error( $get_the_category ) ) {
					return $get_the_category;
				}
			}
		}

		return false;
	}


	/**
	 * Always return true, If there is a default featured image
	 */
	function has_post_thumbnail( $has_thumbnail ) {

		if( tie_get_option( 'default_featured_image' ) && tie_get_option( 'default_featured_image_id' ) ){
			$has_thumbnail = true;
		}

		return $has_thumbnail;
	}


	/**
	 * Set a default featured image if it is missing
	 */
	function default_featured_image( $html, $post_id, $post_thumbnail_id, $size, $attr ) {

		// Return if the post has a featured image
		if( ! empty( $html ) ){
			return $html;
		}

		// Check if the default eatured image option is active
		if( ! tie_get_option( 'default_featured_image' ) || ! tie_get_option( 'default_featured_image_id' ) ){
			return $html;
		}

		$default_thumbnail_id = tie_get_option( 'default_featured_image_id' ); // select the default thumb.

		return wp_get_attachment_image( $default_thumbnail_id, $size, false, $attr );
	}


	/**
	 * Translate numbers
	 */
	function translate_numbers( $the_number ) {

		if( ! ( is_admin() && ! wp_doing_ajax() ) ) {

			$translated_numbers = tie_get_option( 'translation_numbers' );

			if( ! empty( $translated_numbers ) && is_array( $translated_numbers ) && count( $translated_numbers ) == 10 ){

				$original_numbers = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
				return str_replace( $original_numbers, $translated_numbers, $the_number );
			}
		}

		return $the_number;
	}

}

// Single instance.
$TIELABS_FILTERS = new TIELABS_FILTERS();
