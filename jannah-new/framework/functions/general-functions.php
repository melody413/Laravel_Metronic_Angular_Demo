<?php
/**
 * General Functions
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


/**
 * Get Theme Options
 */
if( ! function_exists( 'tie_get_option' ) ) {

	function tie_get_option( $name, $default = false ){

		// Cache the theme settings
		if( ! empty( $GLOBALS['tie_options'] ) ){
			$get_options = $GLOBALS['tie_options'];
		}
		else{
			$get_options = get_option( apply_filters( 'TieLabs/theme_options', '' ) );
			$GLOBALS['tie_options'] = $get_options;
		}

		if( ! empty( $get_options[ $name ] ) ) {
			return $get_options[ $name ];
		}

		if ( $default ){
			return $default;
		}

		return false;
	}
}


/**
 * Get Site skin
 */
if( ! function_exists( 'tie_skin_current' ) ){
	function tie_skin_current() {
		return tie_get_option( 'dark_skin' ) ? 'dark' : 'light';
	}
}


/**
 * Check if skin switcher is active
 */
if( ! function_exists( 'tie_is_switch_skin_active' ) ) {
	function tie_is_skin_switcher_active() {

		if(
			( tie_get_option( 'main_nav' ) && tie_get_option( 'main-nav-components_skin' ) ) ||
			( tie_get_option( 'top_nav' ) && tie_get_option( 'top-nav-components_skin' ) )   ||
			( tie_get_option( 'mobile_header_components_skin' ) )
		){
			return true;
		}

		return false;
	}
}


/**
 * Get Post custom option
 */
if( ! function_exists( 'tie_get_postdata' ) ) {

	function tie_get_postdata( $key, $default = false, $post_id = null ){

		if( ! $post_id ){
			$post_id = get_the_ID();
		}

		if( $value = get_post_meta( $post_id, $key, $single = true ) ){
			return $value;
		}
		elseif( $default ){
			return $default;
		}

		return false;
	}
}


/**
 * Get Category custom option
 */
if( ! function_exists( 'tie_get_category_option' ) ) {

	function tie_get_category_option( $key, $category_id = 0 ){

		if( is_category() && empty( $category_id ) ) {
			$category_id = get_query_var('cat');
		}

		if( empty( $category_id ) ) {
			return false;
		}

		$categories_options = get_option( 'tie_cats_options' );

		if( ! empty( $categories_options[ $category_id ][ $key ] ) ) {
			return $categories_options[ $category_id ][ $key ];
		}

		return false;
	}
}


/**
 * Get custom option > post > primary category > theme options
 */
if( ! function_exists( 'tie_get_object_option' ) ) {

	function tie_get_object_option( $key = false, $cat_key = false, $post_key = false ){

		// CHeck if the $cat_key or $post_key are empty
		if( ! empty( $key ) ){
			$cat_key  = ! empty( $cat_key  ) ? $cat_key  : $key;
			$post_key = ! empty( $post_key ) ? $post_key : $key;
		}

		// BuddyPress
		if( TIELABS_BUDDYPRESS_IS_ACTIVE && is_buddypress() ){

			$option = TIELABS_BUDDYPRESS::get_page_data( $post_key );
			$option = ( $option == 'default') ? '' : $option; //Compatability Sahifa
		}

		// WooCommerce
		elseif( TIELABS_WOOCOMMERCE_IS_ACTIVE && is_woocommerce() ){

			$option = TIELABS_WOOCOMMERCE::get_page_data( $post_key );
			$option = ( $option == 'default') ? '' : $option; //Compatability Sahifa
		}

		// Get Single options
		elseif( is_singular() ){

			// Get the post option if exists
			$option = tie_get_postdata( $post_key );

			$option = ( $option == 'default') ? '' : $option; //Compatability Sahifa

			// Get the category option if the post option isn't exists
			if( ( empty( $option ) || ( is_array( $option ) && ! array_filter( $option )) ) && is_singular( 'post' ) ){

				$category_id = tie_get_primary_category_id();
				$option      = tie_get_category_option( $cat_key, $category_id );
			}
		}

		// Get Category options
		elseif( is_category() ){
			$option = tie_get_category_option( $cat_key );
		}

		// Get the global value
		if( ( empty( $option ) || ( is_array( $option ) && ! array_filter( $option )) ) && ! empty( $key ) ){
			$option = tie_get_option( $key );
		}

		// --
		$option = ! empty( $option ) ? $option : false;

		return apply_filters( 'TieLabs/object_option', $option, $key, $cat_key, $post_key );
	}
}


/**
 * Logo args
 */
if( ! function_exists( 'tie_logo_args' ) ) {

	function tie_logo_args( $type = false ){

		$logo_args   = array();
		$logo_suffix = ( $type == 'sticky' ) ? '_sticky' : '';

		// Custom Post || Page logo
		if( is_singular() ){

			if( tie_get_postdata( 'custom_logo'.$logo_suffix ) ) {

				$logo_args['logo_type']            = tie_get_postdata( 'logo_setting'.$logo_suffix );
				$logo_args['logo_img']             = tie_get_postdata( 'logo'.$logo_suffix );
				$logo_args['logo_retina']          = tie_get_postdata( 'logo_retina'.$logo_suffix );
				$logo_args['logo_inverted']        = tie_get_postdata( 'logo_inverted'.$logo_suffix );
				$logo_args['logo_inverted_retina'] = tie_get_postdata( 'logo_inverted_retina'.$logo_suffix );
				$logo_args['logo_width']           = tie_get_postdata( 'logo_retina_width'.$logo_suffix );
				$logo_args['logo_height']          = tie_get_postdata( 'logo_retina_height'.$logo_suffix );
				$logo_args['logo_margin_top']      = tie_get_postdata( 'logo_margin'.$logo_suffix );
				$logo_args['logo_margin_bottom']   = tie_get_postdata( 'logo_margin_bottom'.$logo_suffix );
				$logo_args['logo_title']           = tie_get_postdata( 'logo_text', get_bloginfo() );
				$logo_args['logo_url']             = tie_get_postdata( 'logo_url' );

			}
			// Get the category option if the post option isn't exists
			else{
				if( is_singular( 'post' ) ){
					$category_id = tie_get_primary_category_id();
				}
			}
		}

		// Custom category logo or primary category logo for a single post
		if( is_category() || ! empty( $category_id ) ){

			if( is_category() ){
				$category_id = get_query_var('cat');
			}

			if( tie_get_category_option( 'custom_logo'.$logo_suffix, $category_id ) ) {

				$logo_args['logo_type']            = tie_get_category_option( 'logo_setting'.$logo_suffix,         $category_id );
				$logo_args['logo_img']             = tie_get_category_option( 'logo'.$logo_suffix,                 $category_id );
				$logo_args['logo_retina']          = tie_get_category_option( 'logo_retina'.$logo_suffix,          $category_id );
				$logo_args['logo_inverted']        = tie_get_category_option( 'logo_inverted'.$logo_suffix,        $category_id );
				$logo_args['logo_inverted_retina'] = tie_get_category_option( 'logo_inverted_retina'.$logo_suffix, $category_id );
				$logo_args['logo_width']           = tie_get_category_option( 'logo_retina_width'.$logo_suffix,    $category_id );
				$logo_args['logo_height']          = tie_get_category_option( 'logo_retina_height'.$logo_suffix,   $category_id );
				$logo_args['logo_margin_top']      = tie_get_category_option( 'logo_margin'.$logo_suffix,          $category_id );
				$logo_args['logo_margin_bottom']   = tie_get_category_option( 'logo_margin_bottom'.$logo_suffix,   $category_id );
				$logo_args['logo_title']           = tie_get_category_option( 'logo_text',                         $category_id ) ? tie_get_category_option( 'logo_text', $category_id ) : get_cat_name( $category_id );
				$logo_args['logo_url']             = tie_get_category_option( 'logo_url',                          $category_id );

			}
		}

		// Allow filtering the args
		$logo_args = apply_filters( 'TieLabs/Logo/args', $logo_args, $logo_suffix );


		// Get the theme default logo
		if( empty( $logo_args ) ){

			$logo_args['logo_type']            = tie_get_option( 'logo_setting'.$logo_suffix );
			$logo_args['logo_img']             = tie_get_option( 'logo'.$logo_suffix ) ? tie_get_option( 'logo'.$logo_suffix ) : get_theme_file_uri( '/assets/images/logo.png' );
			$logo_args['logo_inverted']        = tie_get_option( 'logo_inverted'.$logo_suffix );
			$logo_args['logo_inverted_retina'] = tie_get_option( 'logo_inverted_retina'.$logo_suffix );
			$logo_args['logo_width']           = tie_get_option( 'logo_retina_width'.$logo_suffix, 300 );
			$logo_args['logo_height']          = tie_get_option( 'logo_retina_height'.$logo_suffix, 49 );
			$logo_args['logo_margin_top']      = tie_get_option( 'logo_margin'.$logo_suffix );
			$logo_args['logo_margin_bottom']   = tie_get_option( 'logo_margin_bottom'.$logo_suffix );
			$logo_args['logo_title']           = tie_get_option( 'logo_text' ) ? tie_get_option( 'logo_text' ) : get_bloginfo();
			$logo_args['logo_url']             = tie_get_option( 'logo_url' );

			if( tie_get_option( 'logo_retina'.$logo_suffix ) ){
				$logo_args['logo_retina'] = tie_get_option( 'logo_retina'.$logo_suffix );
			}
			elseif( tie_get_option( 'logo'.$logo_suffix ) ){
				$logo_args['logo_retina'] = tie_get_option( 'logo'.$logo_suffix );
			}
			else{
				$logo_args['logo_retina'] = get_theme_file_uri( '/assets/images/logo@2x.png' );
			}
		}


		return $logo_args;
	}
}


/**
 * Sticky Logo args Function
 */
if( ! function_exists( 'tie_logo_sticky_args' ) ) {

	function tie_logo_sticky_args(){

		// Sticky Logo is disabled
		if( ! tie_get_option( 'sticky_logo_type' ) ){
			return;
		}

		// Custom Site Sticky Logo
		if( tie_get_option( 'custom_logo_sticky' ) && tie_get_option( 'logo_sticky' ) ){
			return tie_logo_args( 'sticky' );
		}

		// Site Logo
		return tie_logo_args();
	}
}


/**
 * Logo Function
 */
if( ! function_exists( 'tie_logo' ) ) {

	function tie_logo(){

		$header_layout = tie_get_option( 'header_layout', 3 );

		$logo_args  = tie_logo_args();
		$logo_style = '';

		extract( $logo_args );

		// Logo URL
		$logo_url = ! empty( $logo_url ) ? $logo_url : home_url( '/' );

		// Logo Title
		$logo_title_attr = ! empty( $logo_title ) ? esc_attr( strip_tags( $logo_title ) ) : '';

		// Logo Margin
		if( $logo_margin_top || $logo_margin_bottom ){

			$logo_style   = array();
			$logo_style[] = $logo_margin_top    ? "margin-top: {$logo_margin_top}px;"       : '';
			$logo_style[] = $logo_margin_bottom ? "margin-bottom: {$logo_margin_bottom}px;" : '';

			$logo_style = 'style="'. join( ' ', array_filter( $logo_style ) ) .'"';
		}

		// Logo Type : Title
		if( $logo_type == 'title' ){

			$logo_class  = 'text-logo';
			$logo_output = apply_filters( 'TieLabs/Logo/text_logo', '<div class="logo-text">'. $logo_title .'</div>', $logo_title );
		}

		// Logo Type : Image
		else{

			$logo_size 	= '';
			$logo_class	= 'image-logo';

			// Logo Width and Height
			if( $logo_width && $logo_height ){

				$logo_size = 'width="'. esc_attr( $logo_width ) .'" height="'. esc_attr( $logo_height ) .'"';

				// ! Full Width Logo
				if( tie_get_option( 'full_logo' ) && $header_layout != 1 && $header_layout != 4 ){

				}
				else{
					$height_important = ( $logo_height < 60 ) ? ' !important' : '';

					$logo_size .= ' style="max-height:'. esc_attr( $logo_height ) .'px'. $height_important .'; width: auto;"';
				}

			}

			$logo_srcset = esc_attr( $logo_img );

			// Logo Retina
			if( $logo_retina && $logo_retina != $logo_img ){
				$logo_srcset = esc_attr( $logo_retina ) .' 2x, '. esc_attr( $logo_img ) .' 1x';
			}

			$is_skin_switcher_active = tie_is_skin_switcher_active();

			$default_logo_id = ( $logo_inverted && $is_skin_switcher_active ) ? ' id="tie-logo-default"' : '';

			/* Future Updates
			 * Mobile Logo
			 * <source media="(min-width: 992px)" srcset="" data-srcset="'. $logo_inverted_srcset .'">
			 * <source media="(max-width: 991px)" srcset="http://localhost:8888/wp/wp-content/uploads/2020/01/hoodie_6_front.jpg 2x, http://localhost:8888/wp/wp-content/uploads/2020/01/hoodie_6_front.jpg 1x">
			 */

			$logo_output = '
				<picture'. $default_logo_id .' class="tie-logo-default tie-logo-picture">
					<source class="tie-logo-source-default tie-logo-source" srcset="'. $logo_srcset .'">
					<img class="tie-logo-img-default tie-logo-img" src="'. esc_attr( $logo_img ) .'" alt="'. $logo_title_attr .'" '. $logo_size .' />
				</picture>
			';

			if( $logo_inverted && $is_skin_switcher_active ){

				$logo_inverted_srcset = esc_attr( $logo_inverted );

				// Logo Inverted Retina
				if( $logo_inverted_retina && $logo_inverted_retina != $logo_inverted ){
					$logo_inverted_srcset = esc_attr( $logo_inverted_retina ) .' 2x, '. esc_attr( $logo_inverted ) .' 1x';
				}

				/*
				$logo_output .= '
					<picture id="tie-logo-inverted">
						<source id="tie-logo-inverted-source" srcset="'. tie_lazyload_placeholder('wide') .'" data-srcset="'. $logo_inverted_srcset .'">
						<img id="tie-logo-inverted-img" src="'. tie_lazyload_placeholder('wide') .'" data-src="'. esc_attr( $logo_inverted ) .'" alt="'. esc_attr( $logo_title ) .'" '. $logo_size .' />
					</picture>
				';
				*/

				$logo_output .= '
					<picture id="tie-logo-inverted" class="tie-logo-inverted tie-logo-picture">
						<source class="tie-logo-source-inverted tie-logo-source" id="tie-logo-inverted-source" srcset="'. $logo_inverted_srcset .'">
						<img class="tie-logo-img-inverted tie-logo-img" id="tie-logo-inverted-img" src="'. esc_attr( $logo_inverted ) .'" alt="'. $logo_title_attr .'" '. $logo_size .' />
					</picture>
				';
			}

		}

		// H1 for the site title in Homepage
		if( is_home() || is_front_page() ){
			$logo_output .= apply_filters( 'TieLabs/Logo/h1', '<h1 class="h1-off">'. $logo_title_attr .'</h1>', $logo_title_attr );
		}
		// H1 for internal pages built via the page builder
		elseif( TIELABS_HELPER::has_builder() ){
			$logo_output .= apply_filters( 'TieLabs/Logo/h1', '<h1 class="h1-off">'. get_the_title() .'</h1>', get_the_title() );
		}

		?>

		<div id="logo" class="<?php echo esc_attr( $logo_class ) ?>" <?php echo ( $logo_style ) ?>>

			<?php do_action( 'TieLabs/Logo/before_link' ); ?>

			<a title="<?php echo $logo_title_attr ?>" href="<?php echo esc_url( apply_filters( 'TieLabs/Logo/url', $logo_url ) ) ?>">
				<?php
					do_action( 'TieLabs/Logo/before_img_text' );
					echo $logo_output;
					do_action( 'TieLabs/Logo/after_img_text' );
				?>
			</a>

			<?php do_action( 'TieLabs/Logo/after_link' ); ?>

		</div><!-- #logo /-->

		<?php
	}
}


/**
 * Sticky Logo Function
 */
if( ! function_exists( 'tie_sticky_logo' ) ) {

	function tie_sticky_logo(){

		// Get the Sticky logo args
		$logo_args = tie_logo_sticky_args();

		if( ! $logo_args ){
			return;
		}

		extract( $logo_args );

		// Logo URL
		$logo_url = ! empty( $logo_url ) ? $logo_url : home_url( '/' );

		// Logo Title
		$logo_title_attr = ! empty( $logo_title ) ? esc_attr( strip_tags( $logo_title ) ) : '';

		// Logo Type : Title
		if( $logo_type == 'title' ){

			// return if the type is text not image
			return;

			/*
				$logo_class  = 'text-logo';
				$logo_output = apply_filters( 'TieLabs/Logo/Sticky/text_logo', '<div class="logo-text">'. $logo_title .'</div>', $logo_title );
			*/
		}

		// Logo Type : Image
		else{

			$logo_size 	= '';
			$logo_class	= 'image-logo';

			// Logo Width and Height
			if( $logo_height && $logo_height < 50 ){
				$logo_size = 'style="max-height:'. esc_attr( $logo_height ) .'px; width: auto;"';
			}

			$logo_srcset = esc_attr( $logo_img );

			// Logo Retina
			if( $logo_retina && $logo_retina != $logo_img ){
				$logo_srcset = esc_attr( $logo_retina ) .' 2x, '. esc_attr( $logo_img ) .' 1x';
			}


			$is_skin_switcher_active = tie_is_skin_switcher_active();

			$default_logo_id = ( $logo_inverted && $is_skin_switcher_active ) ? ' id="tie-sticky-logo-default"' : '';


			$logo_output = '
				<picture'. $default_logo_id .' class="tie-logo-default tie-logo-picture">
					<source class="tie-logo-source-default tie-logo-source" srcset="'. $logo_srcset .'">
					<img class="tie-logo-img-default tie-logo-img" src="'. esc_attr( $logo_img ) .'" alt="'. $logo_title_attr .'" '. $logo_size .' />
				</picture>
			';

			if( $logo_inverted && $is_skin_switcher_active ){

				$logo_inverted_srcset = esc_attr( $logo_inverted );

				// Logo Inverted Retina
				if( $logo_inverted_retina && $logo_inverted_retina != $logo_inverted ){
					$logo_inverted_srcset = esc_attr( $logo_inverted_retina ) .' 2x, '. esc_attr( $logo_inverted ) .' 1x';
				}

				$logo_output .= '
					<picture id="tie-sticky-logo-inverted" class="tie-logo-inverted tie-logo-picture">
						<source class="tie-logo-source-inverted tie-logo-source" id="tie-logo-inverted-source" srcset="'. $logo_inverted_srcset .'">
						<img class="tie-logo-img-inverted tie-logo-img" id="tie-logo-inverted-img" src="'. esc_attr( $logo_inverted ) .'" alt="'. $logo_title_attr .'" '. $logo_size .' />
					</picture>
				';
			}



		}

		?>

		<div id="sticky-logo" class="<?php echo esc_attr( $logo_class ) ?>">

			<?php do_action( 'TieLabs/Logo/Sticky/before_link' ); ?>

			<a title="<?php echo $logo_title_attr ?>" href="<?php echo esc_url( apply_filters( 'TieLabs/Logo/Sticky/url', $logo_url ) ) ?>">
				<?php
					do_action( 'TieLabs/Logo/Sticky/before_img_text' );
					echo $logo_output;
					do_action( 'TieLabs/Logo/Sticky/after_img_text' );
				?>
			</a>

			<?php do_action( 'TieLabs/Logo/Sticky/after_link' ); ?>

		</div><!-- #Sticky-logo /-->

		<div class="flex-placeholder"></div>
		<?php
	}
}


/**
 * Custom Quries
 */
if( ! function_exists( 'tie_query' ) ) {

	function tie_query( $block = array() ){

		$args = array(
			'post_status'         => array( 'publish' ),
			'posts_per_page'      => 5,
			'ignore_sticky_posts' => true,
		);

		// Posts Status for the Ajax Requests
		if( is_user_logged_in() && current_user_can('read_private_posts') ){
			$args['post_status'] = array( 'publish', 'private' );
		}

		// Posts Number
		if( ! empty( $block['number'] ) ) {
			$args['posts_per_page'] = $block['number'];
		}

		// Tags_array : Post Query
		if( ! empty( $block['tags_ids'] ) ){

			$args['tag__in'] = $block['tags_ids'];
		}

		// Posts : Post Query - Used by the JetPack quries
		elseif( ! empty( $block['posts'] ) ) {

			$selective_posts  = explode ( ',', $block['posts'] );
			$args['orderby']  = 'post__in';
			$args['post__in'] = $selective_posts;

			// Use the count Added posts as the number of posts value
			if( ! empty( $block['use_posts_count'] ) ){

				$selective_posts_number	= count( $selective_posts );
				$args['posts_per_page']	= $selective_posts_number;
			}
		}

		// Pages : Post Query
		elseif( ! empty( $block['pages'] ) ) {

			$selective_pages        = explode ( ',', $block['pages'] );
			$selective_pages_number = count( $selective_pages );
			$args['orderby']        = 'post__in';
			$args['post__in']       = $selective_pages;
			$args['posts_per_page']	= $selective_pages_number;
			$args['post_type']      = 'page';
		}

		// Author : Post Query
		elseif( ! empty( $block['author'] ) ) {

			$args['author'] = $block['author'];
		}

		else{

			// Version 4 Compatability
			if( empty( $block['source'] ) ) {
				$block['source'] = ! empty( $block['tags'] ) ? 'tags' : 'id';
			}

			// Categories : Post Query
			if( $block['source'] == 'id' ){

				if( ! empty( $block['id'] ) ){
					$block_cat = maybe_unserialize( $block['id'] );
					$args['cat'] = is_array( $block_cat ) ? implode( ',', $block_cat ) : $block_cat;
				}
			}

			// Tags : Post Query
			elseif( $block['source'] == 'tags' ){

				$tags = array_unique( explode( ',', $block['tags'] ) );

				$args['tag__in'] = array();

				foreach ( $tags as $tag ){
					$post_tag = TIELABS_WP_HELPER::get_term_by( 'name', trim( $tag ), 'post_tag' );

					if( ! empty( $post_tag ) ) {
						$args['tag__in'][] = $post_tag->term_id;
					}
				}
			}

			// Custom taxonomy
			else{

				$taxonomy = $block['source'];

				$custom_taxonomies = TIELABS_ADMIN_HELPER::get_taxonomies();

				if( ! empty( $custom_taxonomies[ $taxonomy ] ) ){

					$terms = ! empty( $block[ $taxonomy ] ) ? $block[ $taxonomy ] : array();

					$args['tax_query'] = array(
						array(
							'taxonomy' => $taxonomy,
							'field'    => 'term_id',
							'terms'    => $terms,
						)
					);
				}
			}

		}


		// Exclude Posts
		if( ! empty( $block['exclude_posts'] ) ){
			$args['post__not_in'] = explode( ',', $block['exclude_posts'] );
		}

		// Posts Order
		if( ! empty( $block['order'] ) ){

			if( $block['order'] == 'views' && tie_get_option( 'tie_post_views' ) ){ // Most Viewd posts
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = apply_filters( 'TieLabs/views_meta_field', 'tie_views' );
			}
			elseif( $block['order'] == 'popular' ){ // Popular Posts by comments
				$args['orderby'] = 'comment_count';
			}
			elseif( $block['order'] == 'title' ){
				$args['orderby'] = 'title';
				$args['order']   = 'ASC';
			}
			else{
				$args['orderby'] = $block['order'];
			}
		}

		// Pagination
		if ( ! empty( $block['pagi'] ) ){

			$paged = 1;

			if( ! empty( $block['target_page'] ) ){
				$paged = intval( $block['target_page'] );
			}

			elseif( $block['pagi'] == 'numeric' ){
				$paged   = intval( get_query_var( 'paged' ));
				$paged_2 = intval( get_query_var( 'page'  ));

				if( empty( $paged ) && ! empty( $paged_2 )  ){
					$paged = intval( get_query_var('page') );
				}
			}

			$args['paged'] = $paged;
		}
		else{
			$args['no_found_rows'] = true ;
		}

		// Offset
		if( ! empty( $block['offset'] ) ){

			if( ! empty( $block['pagi'] ) && ! empty( $paged ) ){
				$args['offset'] = $block['offset'] + ( ($paged-1) * $args['posts_per_page'] );
			}

			else{
				$args['offset'] = $block['offset'];
			}
		}

		// Do not duplicate posts
		if( ! empty( $GLOBALS['tie_do_not_duplicate'] ) && is_array( $GLOBALS['tie_do_not_duplicate'] ) ) {
			$args['post__not_in'] = $GLOBALS['tie_do_not_duplicate'];
		}

		// Allow making changes on the Query
		$args = apply_filters( 'TieLabs/Query/args', $args, $block );

		// Run the Query
		$block_query = tie_run_the_query( $args );

		// Fix the numbe of pages WordPress Offset bug with pagination
		if(	! empty( $block['pagi'] ) ) {

			if( ! empty( $block['offset'] ) ) {

				// Modify the found_posts
				$found_posts = $block_query->found_posts;
				$found_posts = $found_posts - $block['offset'];
				$block_query->set( 'new_found_posts', $found_posts );

				// Modify the max_num_pages
				$block_query->set( 'new_max_num_pages', ceil( $found_posts/$args['posts_per_page'] ) );
			}
			else{
				$block_query->set( 'new_max_num_pages', $block_query->max_num_pages );
			}
		}

		return $block_query;
	}
}


/**
 * Run the Quries and Cache them
 */
function tie_run_the_query( $args = array() ){

	// Check if the theme cache is enabled
	if ( ! tie_get_option( 'jso_cache' ) ) {
		return new WP_Query( $args );
	}

	// Prepare the cache key
	$cache_key = http_build_query( $args );

	// Check for the custom key in the theme group
	$custom_query = wp_cache_get( $cache_key, 'tie_theme' );

	// If nothing is found, build the object.
	if ( false === $custom_query ) {
		$custom_query = new WP_Query( $args );

		if ( ! is_wp_error( $custom_query ) && $custom_query->have_posts() ) {
			wp_cache_set( $cache_key, $custom_query, 'tie_theme' );
		}
	}

	return $custom_query;
}


/**
 * Block title
 */
if( ! function_exists( 'tie_block_title' ) ) {

	function tie_block_title( $block = false ){

		if( empty( $block['title'] ) && empty( $block['icon'] ) ){
			return;
		}

		?>

		<div <?php tie_box_class( 'mag-box-title' ) ?>>
			<h3>
				<?php

					// Title
					$title  = '';

					if( $block['icon'] ){
						$title .= '<span class="'. $block['icon'] .'"></span>';
					}

					if( $block['title'] ){
						if( ! empty( $title ) ){
							$title .= ' ';
						}
						$title .= $block['title'];
					}

					if( ! empty( $block['url'] ) ) {
						echo '<a href="'. esc_url( $block['url'] ) .'">';
						echo $title;
						echo '</a>';
					}
					else{
						echo $title;
					}
				?>
			</h3>

			<?php

			// Ajax Filters
			$block_options = tie_block_ajax_filters( $block );

			// More Button
			if( ! empty( $block['more'] ) && ! empty( $block['url'] ) ){
				$block_options .= '<a class="block-more-button" href="'. esc_url( $block['url'] ) .'">'. esc_html__( 'More', TIELABS_TEXTDOMAIN ) .'</a>';
			}

			// Ajax Block Arrows
			if( ! empty( $block['pagi'] ) && $block['pagi'] == 'next-prev' ){
				$block_options .= '
					<ul class="slider-arrow-nav">
						<li>
							<a class="block-pagination prev-posts pagination-disabled" href="#">
								<span class="tie-icon-angle-left" aria-hidden="true"></span>
								<span class="screen-reader-text">'. esc_html__( 'Previous page', TIELABS_TEXTDOMAIN ) .'</span>
							</a>
						</li>
						<li>
							<a class="block-pagination next-posts" href="#">
								<span class="tie-icon-angle-right" aria-hidden="true"></span>
								<span class="screen-reader-text">'. esc_html__( 'Next page', TIELABS_TEXTDOMAIN ) .'</span>
							</a>
						</li>
					</ul>
				';
			}

			// Scrolling Block Arrows
			if( ! empty( $block['scrolling_box'] ) ) {
				$block_options .= '<ul class="slider-arrow-nav"></ul>';
			}


			if( ! empty( $block_options ) ){
				echo '
					<div class="tie-alignright">
						<div class="mag-box-options">
							'. $block_options .'
						</div><!-- .mag-box-options /-->
					</div><!-- .tie-alignright /-->
				';
			}

		echo '</div><!-- .mag-box-title /-->';
	}
}


/**
 * Ajax Filters
 */
function tie_block_ajax_filters( $block = false ){

	if( empty( $block['filters'] ) || $block['pagi'] == 'numeric' || empty( $block['source'] ) ){
		return;
	}

	$source = $block['source'];

	$block_options  = '<ul class="mag-box-filter-links is-flex-tabs">';
	$block_options .= '<li><a href="#" class="block-ajax-term block-all-term active">'. esc_html__( 'All', TIELABS_TEXTDOMAIN ) .'</a></li>';

	// Filter by tags || using term name
	if( $source == 'tags' ) {

		if( ! empty( $block['tags'] ) ) {
			$tags = array_unique( explode( ',', $block['tags'] ) );

			foreach ( $tags as $tag ){
				$post_tag = TIELABS_WP_HELPER::get_term_by( 'name', $tag, 'post_tag' );

				if( ! empty( $post_tag ) && ! empty( $post_tag->count ) && ( $block['offset'] < $post_tag->count ) ) {
					$block_options .= '<li><a href="#" data-id="'.$post_tag->name.'" class="block-ajax-term" >'. $post_tag->name .'</a></li>';
				}
			}
		}
	}

	// Other taxonomies use IDs
	else{

		// Filter by categories
		if( $block['source'] == 'id' && ! empty( $block['id'] ) && is_array( $block['id'] ) ) {
			$taxonomy = 'category';
			$terms    = $block['id'];
		}
		// Custom taxonomy
		else{
			$taxonomy = $block['source'];
			$terms    = array();

			if( ! empty( $block[ $taxonomy ] ) && is_array( $block[ $taxonomy ] ) ){
				$terms = $block[ $taxonomy ];
			}
		}


		foreach ( $terms as $term_id ){
			$get_terms = TIELABS_WP_HELPER::get_term_by( 'id', $term_id, $taxonomy );

			if( ! empty( $get_terms ) && ! empty( $get_terms->count ) && ( $block['offset'] < $get_terms->count ) ) {
				$block_options .= '<li><a href="#" data-id="'. $term_id .'" class="block-ajax-term" >'. $get_terms->name .'</a></li>';
			}
		}
	}

	$block_options .= '</ul>';

	return $block_options;
}


/**
 * Author Box
 */
if( ! function_exists( 'tie_author_box' ) ) {

	function tie_author_box( $author = false ){

		// Current object
		if( empty( $author ) ){
			$author = get_queried_object();
		}

		// Profile URL
		$profile = tie_get_author_profile_url( $author );

		// Author name
		$display_name = tie_get_the_author( $author );

		?>

		<div class="about-author container-wrapper about-author-<?php echo $author->ID ?>">

			<?php

				// Show the avatar if it is active only
				if( get_option( 'show_avatars' ) ){ ?>
					<div class="author-avatar">
						<a href="<?php echo $profile; ?>">
							<?php echo tie_get_author_avatar( $author, apply_filters( 'TieLabs/Author_Box/avatar_size', 180 ) ); ?>
						</a>
					</div><!-- .author-avatar /-->
					<?php
				}

			?>

			<div class="author-info">
				<h3 class="author-name"><a href="<?php echo $profile; ?>"><?php echo esc_html( $display_name ) ?></a></h3>

				<div class="author-bio">
					<?php

						// Co-Auother Plus Guests
						if( isset( $author->type ) && 'guest-author' == $author->type ){
							echo $author->description;
						}
						else{
							the_author_meta( 'description', $author->ID );
						}
					?>
				</div><!-- .author-bio /-->

				<?php

					// Add the website URL
					$author_social = tie_author_social_array();
					$website = array(
						'url' => array(
							'text' => esc_html__( 'Website', TIELABS_TEXTDOMAIN ),
							'icon' => 'home',
						));

					$author_social = array_merge( $website, $author_social );

					// Generate the social icons
					echo '<ul class="social-icons">';

					foreach ( $author_social as $network => $button ){
						if( get_the_author_meta( $network , $author->ID ) ) {

							$icon = empty( $button['icon'] ) ? $network : $button['icon'];

							$profile_url = apply_filters( 'TieLabs/author/social_url', get_the_author_meta( $network, $author->ID ), $network, $author->ID );

							echo '
								<li class="social-icons-item">
									<a href="'. esc_url( $profile_url ) .'" rel="external noopener nofollow" target="_blank" class="social-link '. $network .'-social-icon">
										<span class="tie-icon-'. $icon .'" aria-hidden="true"></span>
										<span class="screen-reader-text">'. $button['text'] .'</span>
									</a>
								</li>
							';
						}
					}

					echo '</ul>';
				?>
			</div><!-- .author-info /-->
			<div class="clearfix"></div>
		</div><!-- .about-author /-->
		<?php
	}
}


/**
 * Get posts in a Widget
*/
if( ! function_exists( 'tie_widget_posts' ) ) {

	function tie_widget_posts( $query_args = array(), $args = array() ){

		$args = wp_parse_args( $args, array(
			'thumbnail'       => TIELABS_THEME_SLUG.'-image-small',
			'thumbnail_first' => '',
			'review'          => 'small',
			'review_first'    => '',
			'count'           => 0,
			'show_score'      => true,
			'title_length'    => '',
			'exclude_current' => false,
			'media_icon'      => false,
		));

		// Exclude the Current Post
		if( $args['exclude_current'] ){
			$query_args['exclude_posts'] = $args['exclude_current'];
		}

		$query_args = apply_filters( 'TieLabs/posts_widget_query', $query_args );

		// Related Posts Order
		if( ! empty( $query_args['order'] ) && strpos( $query_args['order'], 'related' ) !== false  ){

			$related_type = $query_args['order'];

			// Exclude the Current Post from the related posts
			$query_args['exclude_posts'] = get_the_id();

			// Unset the attrs
			unset( $query_args['id'] );
			unset( $query_args['order'] );

			// Related By Author
			if( $related_type == 'related-author' ){
				$query_args['author'] = get_the_author_meta( 'ID' );
			}

			// Related By Tags
			elseif( $related_type == 'related-tag' ){

				$post_tags = get_the_terms( get_the_id(), 'post_tag' );

				if( ! empty( $post_tags ) ){
					foreach( $post_tags as $individual_tag ){
						$tags_ids[] = $individual_tag->term_id;
					}

					$query_args['tags_ids'] = $tags_ids;
				}
			}

			// Related by Cats
			elseif( $related_type == 'related-cat' ){

				$category_ids = array();
				$categories   = get_the_category( get_the_id() );

				foreach( $categories as $individual_category ){
					$category_ids[] = $individual_category->term_id;
				}

				$query_args['id'] = $category_ids;
			}
		}

		// Run the query
		$query = tie_query( $query_args );

		if ( $query->have_posts() ){
			while ( $query->have_posts() ){
				$query->the_post();

				do_action( 'TieLabs/widget_posts/before', $query_args, $args, get_the_ID() );

				$args['count']++;

				if( ! empty( $args['style'] ) && $args['style'] == 'timeline' ){ ?>
					<li class="widget-single-post-item">
						<a href="<?php the_permalink(); ?>">
							<?php tie_get_time() ?>
							<h3><?php the_title();?></h3>
						</a>
					</li>
					<?php
				}

				elseif( ! empty( $args['style'] ) && $args['style'] == 'grid' ){
					if ( has_post_thumbnail() ){ ?>
						<div <?php tie_post_class( 'widget-single-post-item tie-col-xs-4' ); ?>>
							<?php
								tie_post_thumbnail( TIELABS_THEME_SLUG.'-image-large', false, false, true, $args['media_icon']  );
							?>
						</div>
						<?php
					}
				}

				elseif( ! empty( $args['style'] ) && $args['style'] == 'authors' ){
					TIELABS_HELPER::get_template_part( 'templates/loops/loop', 'authors-widget', $args );
				}

				else{
					TIELABS_HELPER::get_template_part( 'templates/loops/loop', 'widgets', $args );
				}
			}
		}

		wp_reset_postdata();
	}
}


/**
 * Get recent comments
 */
if( ! function_exists( 'tie_recent_comments' ) ) {

	function tie_recent_comments( $comment_posts = 5, $avatar_size = 70 ){

		$comments = get_comments( 'status=approve&number='.$comment_posts );

		foreach ($comments as $comment){ ?>
			<li>
				<?php

				$no_thumb = 'no-small-thumbs';

				// Show the avatar if it is active only
				if( get_option( 'show_avatars' ) ){

					$no_thumb = ''; ?>
					<div class="post-widget-thumbnail" style="width:<?php echo esc_attr( $avatar_size ) ?>px">
						<a class="author-avatar" href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo esc_attr( $comment->comment_ID ); ?>">
							<?php echo get_avatar( $comment, $avatar_size, '', sprintf( esc_html__( 'Photo of %s', TIELABS_TEXTDOMAIN ), esc_html( $comment->comment_author ) ) ); ?>
						</a>
					</div>
					<?php
				}

				?>

				<div class="comment-body <?php echo esc_attr( $no_thumb ) ?>">
					<a class="comment-author" href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo esc_attr( $comment->comment_ID ); ?>">
						<?php echo strip_tags($comment->comment_author); ?>
					</a>
					<p><?php echo wp_html_excerpt( $comment->comment_content, 60 ); ?>...</p>
				</div>

			</li>
			<?php
		}
	}
}


/**
 * Login Form
 */
if( ! function_exists( 'tie_login_form' ) ) {

	function tie_login_form(){
		TIELABS_HELPER::get_template_part( 'templates/login' );
	}
}


/**
 * Rich Snippets
 */
if( ! function_exists( 'tie_article_schemas' ) ) {

	add_action( 'TieLabs/after_post_entry',  'tie_article_schemas' );
	function tie_article_schemas(){

		if( ! tie_get_option( 'structure_data' ) ){
			return false;
		}

		// bbPress
		if( TIELABS_BBPRESS_IS_ACTIVE && is_bbpress() ){
			return false;
		}

		// Check if the rich snippts supported on pages?
		if( is_page() && ! apply_filters( 'TieLabs/is_page_rich_snippet', false ) ){
			return false;
		}

		$post    = get_post();
		$post_id = $post->ID;

		// Site Logo
		$site_logo = tie_get_option( 'logo_retina' ) ? tie_get_option( 'logo_retina' ) : tie_get_option( 'logo' );
		$site_logo = ! empty( $site_logo ) ? $site_logo : get_stylesheet_directory_uri().'/assets/images/logo@2x.png';


		// Post data
		$article_body   = strip_tags(strip_shortcodes( apply_filters( 'TieLabs/exclude_content', $post->post_content ) ));
		$description    = wp_html_excerpt( $article_body, 200 );

		$puplished_date = get_post_time( 'Y-m-d\TH:i:sP', false );
		$modified_date  = get_post_modified_time( 'Y-m-d\TH:i:sP', false );
		$modified_date  = ! empty( $modified_date ) ? $modified_date : $puplished_date;

		$schema_type    = tie_get_object_option( 'schema_type', 'cat_schema_type', false );
		$schema_type    = ! empty( $schema_type ) ? $schema_type : 'Article';

		// The Scemas Array
		$schema = array(
			'@context'       => 'http://schema.org',
			'@type'          => $schema_type,
			'dateCreated'    => $puplished_date,
			'datePublished'  => $puplished_date,
			'dateModified'   => $modified_date,
			'headline'       => get_the_title(),
			'name'           => get_the_title(),
			'keywords'       => tie_get_plain_terms( $post_id, 'post_tag' ),
			'url'            => get_permalink(),
			'description'    => $description,
			'copyrightYear'  => get_the_time( 'Y' ),
			'articleSection' => tie_get_plain_terms( $post_id, 'category' ),
			'articleBody'    => $article_body,
			'publisher'      => array(
				'@id'   => '#Publisher',
				'@type' => 'Organization',
				'name'  => get_bloginfo(),
				'logo'  => array(
					'@type' => 'ImageObject',
					'url'   => $site_logo,
				)
			),
			'sourceOrganization' => array(
				'@id' => '#Publisher'
			),
			'copyrightHolder' => array(
				'@id' => '#Publisher'
			),
			'mainEntityOfPage' => array(
				'@type' => 'WebPage',
				'@id'   => get_permalink(),
			),
			'author' => array(
				'@type' => 'Person',
				'name'  => get_the_author(),
				'url'   => tie_get_author_profile_url(),
			),
		);

		// Post image
		$image_id   = tie_get_post_thumbnail_id();
		$image_data = wp_get_attachment_image_src( $image_id, 'full' );

		if( ! empty( $image_data ) ){
			$schema['image'] = array(
				'@type'  => 'ImageObject',
				'url'    => $image_data[0],
				'width'  => ( $image_data[1] < 1200 ) ? 1200 : $image_data[1],
				'height' => $image_data[2],
			);
		}

		// Breadcrumbs
		if( tie_get_option( 'breadcrumbs' ) ){
			$schema['mainEntityOfPage']['breadcrumb'] = array(
				'@id' => '#Breadcrumb'
			);
		}

		// Social links
		$social = tie_get_option( 'social' );
		if( ! empty( $social ) && is_array( $social ) ) {
			$schema['publisher']['sameAs'] = array_values( $social );
		}

		//-
		$schema = apply_filters( 'TieLabs/rich_snippet_schema', $schema );

		// Print the schema
		if( $schema ){
			echo '<script id="tie-schema-json" type="application/ld+json">'. json_encode( $schema ) .'</script>';
		}

	}
}


/**
 * Get the Ajax loader icon
 */
if( ! function_exists( 'tie_get_ajax_loader' ) ) {

	function tie_get_ajax_loader( $echo = true ){

		$out = '<div class="loader-overlay">';

		if( tie_get_option( 'loader-icon' ) == 2 ){
			$out .= '
				<div class="spinner">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"> </div>
				</div>
			';
		}
		else{
			$out .= '<div class="spinner-circle"></div>';
		}

		$out .= '</div>';

		if( $echo ){
			echo ( $out );
		}

		return $out;
	}
}


/**
 * Check if the Search is active in the menus
 */
if( ! function_exists( 'tie_menu_has_search' ) ) {

	function tie_menu_has_search( $position = false, $ajax = false, $compact = false ){

		if( empty( $position ) || ! tie_get_option( $position ) ){ // check if the menu itself is active
			return false;
		}

		$position = str_replace( '_', '-', $position );

		$is_active = false;

		if( tie_get_option( $position.'-components_search' ) ){ // search is active

			$is_active = true;

			// check if compact layout
			if( $compact && tie_get_option( $position.'-components_search_layout' ) != 'compact' ){ // check if compact layout

				$is_active = false;
			}

			// Ajax search check
			if( $ajax ){
				$is_active = false;

				if( tie_get_option( $position.'-components_live_search' ) ){
					$is_active = true;
				}
			}
		}

		return $is_active;
	}
}


/**
 * Get the author profile link
 */
if( ! function_exists( 'tie_get_author_profile_url' ) ) {

	function tie_get_author_profile_url( $author = false ){

		// Author is object
		if( ! empty( $author ) && is_object( $author ) ){

			// Guest Author
			if( isset( $author->type ) && 'guest-author' == $author->type ){
				return get_author_posts_url( $author->ID, $author->user_nicename );
			}

			$author = $author->ID;
		}

		// Empty Author
		if( empty( $author ) ){
			$author = get_the_author_meta( 'ID' );
		}

		// Use the BuddyPress member profile page
		if( TIELABS_BUDDYPRESS_IS_ACTIVE && tie_get_option( 'bp_use_member_profile' ) ){
			return bp_core_get_user_domain( $author );
		}

		// Use the default Author profile page
		return get_author_posts_url( $author );
	}
}


/**
 * Get author Avatar
 */
if( ! function_exists( 'tie_get_author_avatar' ) ) {

	function tie_get_author_avatar( $author = false, $size = 140 ){

		if( ! empty( $author ) ) {

			// Author is object
			if( is_object( $author ) ){

				// Guest Author
				if( function_exists( 'coauthors' ) && isset( $author->type ) && 'guest-author' == $author->type ){

					global $coauthors_plus;
					$guest_author_thumbnail = $coauthors_plus->guest_authors->get_guest_author_thumbnail( $author, $size, '' );

					if ( $guest_author_thumbnail ) {
						return $guest_author_thumbnail;
					}
				}
			}
			elseif ( is_numeric( $author ) ) {
				$author = get_user_by( 'id', $author );
			}
		}

		// Empty Author
		if( empty( $author->user_email ) ){
			$author = get_the_author();
		}

		if( empty( $author->user_email ) ){
			return;
		}

		return get_avatar( $author->user_email, $size, '', sprintf( esc_html__( 'Photo of %s', TIELABS_TEXTDOMAIN ), $author->display_name ) );
	}
}


/**
 * Social
 */
if( ! function_exists( 'tie_get_social' ) ) {

	function tie_get_social( $options = array() ){

		$defaults = array(
			'reverse'   => false,
			'show_name' => false,
			'before'    => "<ul>",
			'after'     => "</ul> \n",
		);

		$options = wp_parse_args( $options, $defaults );

		extract( $options );

		/*
		 * Get the cached social networks
		 * There are multiple places for the social networks, to avoid walking throw the whole process and to avoid
		 * calling tie_social_networks multiple times, we cache the social array
		 */
		if( ! empty( $GLOBALS['tie_social_networks'] ) ){
			$social = $GLOBALS['tie_social_networks'];
		}

		// No cached version
		else{

			$social = tie_get_option( 'social' );

			// RSS
			if ( tie_get_option( 'rss_icon' ) ){
				$social['rss'] = ! empty( $social['rss'] ) ? $social['rss'] : get_bloginfo( 'rss2_url' );
			}

			$social_array = ! empty( $social ) ? tie_social_networks() : array();

			// Custom Social Networks
			for( $i=1 ; $i<=5 ; $i++ ){
				if ( ( tie_get_option( "custom_social_icon_img_$i" ) || tie_get_option( "custom_social_icon_$i" ) ) && tie_get_option( "custom_social_url_$i" ) && tie_get_option( "custom_social_title_$i" ) ){

					$network = "custom-link-$i";

					$icon_format = array(
						'title'	=> tie_get_option( "custom_social_title_$i" ),
						'class'	=> 'social-custom-link ' . $network,
					);

					if( tie_get_option( "custom_social_icon_img_$i" ) ){
						$icon_format['img']  = tie_get_option( "custom_social_icon_img_$i" );
						$icon_format['icon'] = "social-icon-img social-icon-img-$i";
					}
					else{
						$icon_format['icon'] = tie_get_option( "custom_social_icon_$i" );
					}

					$social[ $network ] = array(
						'url'    => esc_url( tie_get_option( "custom_social_url_$i" ) ),
						'format' => $icon_format
					);
				}
			}

			// Create one array hold the social and it's icon, link, etc
			if( ! empty( $social ) && is_array( $social ) ){
				foreach ( $social as $network => $link ){

					if( ! empty( $link ) && ! empty( $social_array[ $network ] ) ){
						$social[ $network ] = array(
							'url'    => esc_url( $link ),
							'format' => $social_array[ $network ]
						);
					}
				}
			}

			// Cache the social networks
			$GLOBALS['tie_social_networks'] = $social;
		}

		//---
		if( $reverse && is_array( $social ) ){
			$social = array_reverse( $social );
		}

		// Print the Icons
		echo ( $before );

		if( ! empty( $social ) ){

			foreach ( $social as $network => $data ){

				// Check if we have icon or img to continue
				if( ! empty( $data['format']['img'] ) || ! empty( $data['format']['icon'] ) ){

					// URL
					$link = ! empty( $data['url'] ) ? $data['url'] : '#';

					//
					$icon  = ! empty( $data['format']['icon'] )  ? $data['format']['icon']  : '';
					$title = ! empty( $data['format']['title'] ) ? $data['format']['title'] : '';
					$class = ! empty( $data['format']['class'] ) ? $data['format']['class'] . '-social-icon' : '';

					$text_class = ! empty( $show_name ) ? 'social-text' : 'screen-reader-text';

					if( ! empty ( $data['format']['img'] ) ){
						$class .= ' custom-social-img';
					}

					echo '<li class="social-icons-item"><a class="social-link '. $class .'" rel="external noopener nofollow" target="_blank" href="'. $link .'"><span class="tie-social-icon '. $icon .'"></span><span class="'.$text_class.'">'.$title.'</span></a></li>';
				}
			}
		}

		echo ( $after );
	}
}


/**
 * Social Networks
 */
if( ! function_exists( 'tie_facebook_app_id' ) ) {

	function tie_facebook_app_id(){

		return '5303202981'; // '53300906';

		// ---
		//$app_id = tie_get_option( 'facebook_app_id' ) ? tie_get_option( 'facebook_app_id' ) : '5303202981';
		//return apply_filters( 'tie_facebook_app_id', $app_id );
	}
}



/**
 * WooCommerce Cart
 */
if( ! function_exists( 'tie_component_button_cart' ) ) {

	function tie_component_button_cart(){

		if( ! TIELABS_WOOCOMMERCE_IS_ACTIVE ){
			return;
		}

		$counter_bubble = false;

		if( isset( WC()->cart ) ){
			$cart_count_items = WC()->cart->get_cart_contents_count();
		}

		if( ! empty( $cart_count_items ) ){
			$bubble_class   = ( $cart_count_items > 9 ) ? 'is-two-digits' : 'is-one-digit';
			$counter_bubble = '<span class="menu-counter-bubble '. esc_attr( $bubble_class ) .'">'. apply_filters( 'TieLabs/number_format', $cart_count_items ) .'</span>';
		}

		ob_start();
		?>
		<div class="components-sub-menu comp-sub-menu">
			<div class="shopping-cart-details">
				<?php do_action( 'TieLabs/wc_cart_menu_content' ) ?>
			</div><!-- shopping-cart-details -->
		</div><!-- .components-sub-menu /-->
		<?php
		$the_cart = ob_get_clean();

		return '
			<a href="'. wc_get_cart_url() .'" title="'. esc_html__( 'View your shopping cart', TIELABS_TEXTDOMAIN ) .'">
				<span class="shooping-cart-counter menu-counter-bubble-outer">'. $counter_bubble .'</span>
				<span class="tie-icon-shopping-bag" aria-hidden="true"></span>
				<span class="screen-reader-text">'. esc_html__( 'View your shopping cart', TIELABS_TEXTDOMAIN ) .'</span>
			</a>
		'. $the_cart;

	}
}


/**
 * buddyPress Notifications
 */
if( ! function_exists( 'tie_component_button_bp_notifications' ) ) {

	function tie_component_button_bp_notifications(){

		if( ! TIELABS_BUDDYPRESS_IS_ACTIVE || ! is_user_logged_in() ){
			return;
		}

		$notification = apply_filters( 'TieLabs/BuddyPress/notifications', '' );
		$counter_bubble = false;

		if( ! empty( $notification['count'] ) ) {
			$bubble_class   = ( $notification['count'] > 9 ) ? 'is-two-digits' : 'is-one-digit';
			$counter_bubble = '<span class="menu-counter-bubble '. esc_attr( $bubble_class ) .'">'. apply_filters( 'TieLabs/number_format', $notification['count'] ) .'</span>';
		}

		return '
			<a href="'. esc_url( $notification['link'] ) .'" title="'. esc_html__( 'Notifications', TIELABS_TEXTDOMAIN ) .'">
				<span class="notifications-total-outer">'. $counter_bubble .'</span>
				<span class="tie-icon-bell" aria-hidden="true"></span>
				<span class="screen-reader-text">'. esc_html__( 'Notifications', TIELABS_TEXTDOMAIN ) .'</span>
			</a>
		';
	}
}


/**
 * Social Networks
 */
if( ! function_exists( 'tie_social_networks' ) ) {

	function tie_social_networks(){

		$social_array = array(
			'rss' => array(
				'title' => esc_html__( 'RSS', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-feed',
				'class' => 'rss',
			),

			'facebook' => array(
				'title' => esc_html__( 'Facebook', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-facebook',
				'class' => 'facebook',
			),

			'twitter' => array(
				'title' => esc_html__( 'Twitter', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-twitter',
				'class' => 'twitter',
			),

			'Pinterest' => array(
				'title' => esc_html__( 'Pinterest', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-pinterest',
				'class' => 'pinterest',
			),

			'dribbble' => array(
				'title' => esc_html__( 'Dribbble', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-dribbble',
				'class' => 'dribbble',
			),

			'linkedin' => array(
				'title' => esc_html__( 'LinkedIn', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-linkedin',
				'class' => 'linkedin',
			),

			'flickr' => array(
				'title' => esc_html__( 'Flickr', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-flickr',
				'class' => 'flickr',
			),

			'youtube' => array(
				'title' => esc_html__( 'YouTube', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-youtube',
				'class' => 'youtube',
			),

			'reddit' => array(
				'title' => esc_html__( 'Reddit', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-reddit',
				'class' => 'reddit',
			),

			'tumblr' => array(
				'title' => esc_html__( 'Tumblr', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-tumblr',
				'class' => 'tumblr',
			),

			'vimeo' => array(
				'title' => esc_html__( 'Vimeo', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-vimeo',
				'class' => 'vimeo',
			),

			'wordpress' => array(
				'title' => esc_html__( 'WordPress', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-wordpress',
				'class' => 'wordpress',
			),

			'yelp' => array(
				'title' => esc_html__( 'Yelp', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-yelp',
				'class' => 'yelp',
			),

			'lastfm' => array(
				'title' => esc_html__( 'Last.FM', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-lastfm',
				'class' => 'lastfm',
			),

			'xing' => array(
				'title' => esc_html__( 'Xing', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-xing',
				'class' => 'xing',
			),

			'deviantart' => array(
				'title' => esc_html__( 'DeviantArt', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-deviantart',
				'class' => 'deviantart',
			),

			'apple' => array(
				'title' => esc_html__( 'Apple', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-apple',
				'class' => 'apple',
			),

			'foursquare' => array(
				'title' => esc_html__( 'Foursquare', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-foursquare',
				'class' => 'foursquare',
			),

			'github' => array(
				'title' => esc_html__( 'GitHub', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-github',
				'class' => 'github',
			),

			'soundcloud' => array(
				'title' => esc_html__( 'SoundCloud', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-soundcloud',
				'class' => 'soundcloud',
			),

			'behance'	=> array(
				'title' => esc_html__( 'Behance', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-behance',
				'class' => 'behance',
			),

			'instagram' => array(
				'title' => esc_html__( 'Instagram', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-instagram',
				'class' => 'instagram',
			),

			'paypal' => array(
				'title' => esc_html__( 'Paypal', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-paypal',
				'class' => 'paypal',
			),

			'spotify' => array(
				'title' => esc_html__( 'Spotify', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-spotify',
				'class' => 'spotify',
			),

			'google_play'=> array(
				'title' => esc_html__( 'Google Play', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-play',
				'class' => 'google_play',
			),

			'px500' => array(
				'title' => esc_html__( '500px', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-500px',
				'class' => 'px500',
			),

			'vk' => array(
				'title' => esc_html__( 'vk.com', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-vk',
				'class' => 'vk',
			),

			'odnoklassniki' => array(
				'title' => esc_html__( 'Odnoklassniki', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-odnoklassniki',
				'class' => 'odnoklassniki',
			),

			'bitbucket'	=> array(
				'title' => esc_html__( 'Bitbucket', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-bitbucket',
				'class' => 'bitbucket',
			),

			'mixcloud' => array(
				'title' => esc_html__( 'Mixcloud', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-mixcloud',
				'class' => 'mixcloud',
			),

			'medium' => array(
				'title' => esc_html__( 'Medium', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-medium',
				'class' => 'medium',
			),

			'twitch' => array(
				'title' => esc_html__( 'Twitch', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-twitch',
				'class' => 'twitch',
			),

			'viadeo' => array(
				'title' => esc_html__( 'Viadeo', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-viadeo',
				'class' => 'viadeo',
			),

			'snapchat' => array(
				'title' => esc_html__( 'Snapchat', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-snapchat',
				'class' => 'snapchat',
			),

			'telegram' => array(
				'title' => esc_html__( 'Telegram', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-paper-plane',
				'class' => 'telegram',
			),

			'tripadvisor' => array(
				'title' => esc_html__( 'TripAdvisor', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-tripadvisor',
				'class' => 'tripadvisor',
			),

			'steam' => array(
				'title' => esc_html__( 'Steam', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-steam',
				'class' => 'steam',
			),

			'tiktok' => array(
				'title' => esc_html__( 'TikTok', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-tiktok',
				'class' => 'tiktok',
			),

			'whatsapp' => array(
				'title' => esc_html__( 'WhatsApp', TIELABS_TEXTDOMAIN ),
				'icon'  => 'tie-icon-whatsapp',
				'class' => 'whatsapp',
			),
		);

		// Add the RSS hint in the backend only.
		if( is_admin() ){
			$social_array['rss']['hint'] = esc_html__( 'Optional Custom Feed URL, Leave it empty to use the default WordPress feed URL.', TIELABS_TEXTDOMAIN );
		}

		return apply_filters( 'TieLabs/social_networks', $social_array );
	}
}


/**
 * Author social networks
 */
if( ! function_exists( 'tie_author_social_array' ) ) {

	function tie_author_social_array(){

		$author_social = array(
			'facebook'    => array( 'text' => esc_html__( 'Facebook',   TIELABS_TEXTDOMAIN ) ),
			'twitter'     => array( 'text' => esc_html__( 'Twitter',    TIELABS_TEXTDOMAIN ) ),
			'linkedin'    => array( 'text' => esc_html__( 'LinkedIn',   TIELABS_TEXTDOMAIN ) ),
			'flickr'      => array( 'text' => esc_html__( 'Flickr',     TIELABS_TEXTDOMAIN ) ),
			'youtube'     => array( 'text' => esc_html__( 'YouTube',    TIELABS_TEXTDOMAIN ) ),
			'pinterest'   => array( 'text' => esc_html__( 'Pinterest',  TIELABS_TEXTDOMAIN ) ),
			'behance'     => array( 'text' => esc_html__( 'Behance',    TIELABS_TEXTDOMAIN ) ),
			'instagram'   => array( 'text' => esc_html__( 'Instagram',  TIELABS_TEXTDOMAIN ) ),
			'instagram'   => array( 'text' => esc_html__( 'Instagram',  TIELABS_TEXTDOMAIN ) ),
			'github'      => array( 'text' => esc_html__( 'GitHub',     TIELABS_TEXTDOMAIN ) ),
			'soundcloud'  => array( 'text' => esc_html__( 'SoundCloud', TIELABS_TEXTDOMAIN ) ),
			'medium'      => array( 'text' => esc_html__( 'Medium',     TIELABS_TEXTDOMAIN ) ),
			'twitch'      => array( 'text' => esc_html__( 'Twitch',     TIELABS_TEXTDOMAIN ) ),
			'snapchat'    => array( 'text' => esc_html__( 'Snapchat',   TIELABS_TEXTDOMAIN ) ),
			'steam'       => array( 'text' => esc_html__( 'Steam',      TIELABS_TEXTDOMAIN ) ),
			'tiktok'      => array( 'text' => esc_html__( 'TikTok',     TIELABS_TEXTDOMAIN ) ),
		);

		return apply_filters( 'TieLabs/author_social_array', $author_social );
	}
}


/**
 * Translations texts
 */
if( ! function_exists( 'tie_default_translation_texts' ) ) {

	add_filter( 'TieLabs/translation_texts', 'tie_default_translation_texts' );
	function tie_default_translation_texts( $texts ){

		$default_texts = array(

			'general' => array(
				'title' => esc_html__( 'General', TIELABS_TEXTDOMAIN ),
				'texts' => array(
					'Home'   => esc_html__( 'Home',   TIELABS_TEXTDOMAIN ),
					'Menu'   => esc_html__( 'Menu',   TIELABS_TEXTDOMAIN ),
					'%s ago' => esc_html__( '%s ago', TIELABS_TEXTDOMAIN ),
					'and'    => esc_html__( 'and',    TIELABS_TEXTDOMAIN ),
					'Random Article' => esc_html__( 'Random Article', TIELABS_TEXTDOMAIN ),
					'No new notifications' => esc_html__( 'No new notifications', TIELABS_TEXTDOMAIN ),
					'Notifications'        => esc_html__( 'Notifications',        TIELABS_TEXTDOMAIN ),
				)
			),

			'search' => array(
				'title' => esc_html__( 'Search', TIELABS_TEXTDOMAIN ),
				'texts' => array(
					'Search for'             => esc_html__( 'Search for',            TIELABS_TEXTDOMAIN ),
					'Nothing Found'          => esc_html__( 'Nothing Found',         TIELABS_TEXTDOMAIN ),
					'View all results'       => esc_html__( 'View all results',      TIELABS_TEXTDOMAIN ),
					'Type and hit Enter'     => esc_html__( 'Type and hit Enter',    TIELABS_TEXTDOMAIN ),
					'Search Results for: %s' => esc_html__( 'Search Results for: %s',TIELABS_TEXTDOMAIN ),
					'Type your search words then press enter' => esc_html__( 'Type your search words then press enter', TIELABS_TEXTDOMAIN ),
					'Sorry, but nothing matched your search terms. Please try again with some different keywords.' => esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', TIELABS_TEXTDOMAIN ),
				)
			),

			'single_post' => array(
				'title' => esc_html__( 'Single Post Page', TIELABS_TEXTDOMAIN ),
				'texts' => array(
					'Last Updated:'          => esc_html__( 'Last Updated:',         TIELABS_TEXTDOMAIN ),
					'Share'                  => esc_html__( 'Share',                 TIELABS_TEXTDOMAIN ),
					'Trending'               => esc_html__( 'Trending',              TIELABS_TEXTDOMAIN ),
					'Via'                    => esc_html__( 'Via',                   TIELABS_TEXTDOMAIN ),
					'Source'                 => esc_html__( 'Source',                TIELABS_TEXTDOMAIN ),
					'Views'                  => esc_html__( 'Views',                 TIELABS_TEXTDOMAIN ),
					'One Comment'            => esc_html__( 'One Comment',           TIELABS_TEXTDOMAIN ),
					'%s Comments'            => esc_html__( '%s Comments',           TIELABS_TEXTDOMAIN ),
					'Check Also'             => esc_html__( 'Check Also',            TIELABS_TEXTDOMAIN ),
					'Story Highlights'       => esc_html__( 'Story Highlights',      TIELABS_TEXTDOMAIN ),
					'Less than a minute'     => esc_html__( 'Less than a minute',    TIELABS_TEXTDOMAIN ),
					'%s hours read'          => esc_html__( '%s hours read',         TIELABS_TEXTDOMAIN ),
					'1 minute read'          => esc_html__( '1 minute read',         TIELABS_TEXTDOMAIN ),
					'%s minutes read'        => esc_html__( '%s minutes read',       TIELABS_TEXTDOMAIN ),
					'Share via Email'        => esc_html__( 'Share via Email',       TIELABS_TEXTDOMAIN ),
					'Print'                  => esc_html__( 'Print',                 TIELABS_TEXTDOMAIN ),
					'Related Articles'       => esc_html__( 'Related Articles',      TIELABS_TEXTDOMAIN ),
					'About %s'               => esc_html__( 'About %s',              TIELABS_TEXTDOMAIN ),
					'By %s'                  => esc_html__( 'By %s',                 TIELABS_TEXTDOMAIN ),
					'Read Next'              => esc_html__( 'Read Next',             TIELABS_TEXTDOMAIN ),
				)
			),

			'blocks_archives' => array(
				'title' => esc_html__( 'Blocks and Archives', TIELABS_TEXTDOMAIN ),
				'texts' => array(
					'All'                    => esc_html__( 'All',                   TIELABS_TEXTDOMAIN ),
					'Previous page'          => esc_html__( 'Previous page',         TIELABS_TEXTDOMAIN ),
					'Next page'              => esc_html__( 'Next page',             TIELABS_TEXTDOMAIN ),
					'First'                  => esc_html__( 'First',                 TIELABS_TEXTDOMAIN ),
					'Last'                   => esc_html__( 'Last',                  TIELABS_TEXTDOMAIN ),
					'Show More'              => esc_html__( 'Show More',             TIELABS_TEXTDOMAIN ),
					'Load More'              => esc_html__( 'Load More',             TIELABS_TEXTDOMAIN ),
					'No More Posts'          => esc_html__( 'No More Posts',         TIELABS_TEXTDOMAIN ),
					'page'                   => esc_html__( 'page',                  TIELABS_TEXTDOMAIN ),
					'More'                   => esc_html__( 'More',                  TIELABS_TEXTDOMAIN ),
					'Pages'                  => esc_html__( 'Pages',                 TIELABS_TEXTDOMAIN ),
					'Categories'             => esc_html__( 'Categories',            TIELABS_TEXTDOMAIN ),
					'Tags'                   => esc_html__( 'Tags',                  TIELABS_TEXTDOMAIN ),
					'Authors'                => esc_html__( 'Authors',               TIELABS_TEXTDOMAIN ),
					'Archives'               => esc_html__( 'Archives',              TIELABS_TEXTDOMAIN ),
					'Read More &raquo;'      => esc_html__( 'Read More &raquo;',     TIELABS_TEXTDOMAIN ),
					'Videos'                 => esc_html__( 'Videos',                TIELABS_TEXTDOMAIN ),
				)
			),

			'page_404' => array(
				'title' => esc_html__( '404 Page', TIELABS_TEXTDOMAIN ),
				'texts' => array(
					'404 :(' => esc_html__( '404 :(', TIELABS_TEXTDOMAIN ),
					'Oops! That page can&rsquo;t be found.' => esc_html__( 'Oops! That page can&rsquo;t be found.', TIELABS_TEXTDOMAIN ),
					'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.' => esc_html__( "It seems we can't find what you're looking for. Perhaps searching can help.", TIELABS_TEXTDOMAIN ),
				)
			),

			'weather' => array(
				'title' => esc_html__( 'Weather', TIELABS_TEXTDOMAIN ),
				'texts' => array(
					'km/h'             => esc_html__( 'km/h',                  TIELABS_TEXTDOMAIN ),
					'mph'              => esc_html__( 'mph',                   TIELABS_TEXTDOMAIN ),
					'Thunderstorm'     => esc_html__( 'Thunderstorm',          TIELABS_TEXTDOMAIN ),
					'Drizzle'          => esc_html__( 'Drizzle',               TIELABS_TEXTDOMAIN ),
					'Light Rain'       => esc_html__( 'Light Rain',            TIELABS_TEXTDOMAIN ),
					'Heavy Rain'       => esc_html__( 'Heavy Rain',            TIELABS_TEXTDOMAIN ),
					'Rain'             => esc_html__( 'Rain',                  TIELABS_TEXTDOMAIN ),
					'Snow'             => esc_html__( 'Snow',                  TIELABS_TEXTDOMAIN ),
					'Mist'             => esc_html__( 'Mist',                  TIELABS_TEXTDOMAIN ),
					'Clear Sky'        => esc_html__( 'Clear Sky',             TIELABS_TEXTDOMAIN ),
					'Scattered Clouds' => esc_html__( 'Scattered Clouds',      TIELABS_TEXTDOMAIN ),
				)
			),

			'login' => array(
				'title' => esc_html__( 'Login Section', TIELABS_TEXTDOMAIN ),
				'texts' => array(
					'Log In'       => esc_html__( 'Log In',       TIELABS_TEXTDOMAIN ),
					'Log Out'      => esc_html__( 'Log Out',      TIELABS_TEXTDOMAIN ),
					'Welcome'      => esc_html__( 'Welcome',      TIELABS_TEXTDOMAIN ),
					'Dashboard'    => esc_html__( 'Dashboard',    TIELABS_TEXTDOMAIN ),
					'Your Profile' => esc_html__( 'Your Profile', TIELABS_TEXTDOMAIN ),
					'Username'     => esc_html__( 'Username',     TIELABS_TEXTDOMAIN ),
					'Password'     => esc_html__( 'Password',     TIELABS_TEXTDOMAIN ),
					'Forget?'      => esc_html__( 'Forget?',      TIELABS_TEXTDOMAIN ),
					'Remember me'  => esc_html__( 'Remember me',  TIELABS_TEXTDOMAIN ),
					"Don't have an account?" => esc_html__( "Don't have an account?", TIELABS_TEXTDOMAIN ),
				)
			),

			'widgets' => array(
				'title' => esc_html__( 'Widgets', TIELABS_TEXTDOMAIN ),
				'texts' => array(
					'Enter your Email address' => esc_html__( 'Enter your Email address', TIELABS_TEXTDOMAIN ),
					'Subscribe'                => esc_html__( 'Subscribe',                TIELABS_TEXTDOMAIN ),
					'Follow us on Flickr'      => esc_html__( 'Follow us on Flickr',      TIELABS_TEXTDOMAIN ),
					'Follow Us'                => esc_html__( 'Follow Us',                TIELABS_TEXTDOMAIN ),
					'Follow us on Twitter'     => esc_html__( 'Follow us on Twitter',     TIELABS_TEXTDOMAIN ),
					'Follow'                   => esc_html__( 'Follow',                   TIELABS_TEXTDOMAIN ),
					'Popular'                  => esc_html__( 'Popular',                  TIELABS_TEXTDOMAIN ),
					'Recent'                   => esc_html__( 'Recent',                   TIELABS_TEXTDOMAIN ),
					'Comments'                 => esc_html__( 'Comments',                 TIELABS_TEXTDOMAIN ),

				)
			),
			'woocommerce' => array(
				'title' => esc_html__( 'WooCommerce', TIELABS_TEXTDOMAIN ),
				'texts' => array(
					'Subtotal:'      => esc_html__( 'Cart Subtotal:', TIELABS_TEXTDOMAIN ),
					'View Cart'      => esc_html__( 'View Cart',      TIELABS_TEXTDOMAIN ),
					'Checkout'       => esc_html__( 'Checkout',       TIELABS_TEXTDOMAIN ),
					'Go to the shop' => esc_html__( 'Go to the shop', TIELABS_TEXTDOMAIN ),
					'No products found' => esc_html__( 'No products found', TIELABS_TEXTDOMAIN ),
					'View your shopping cart' => esc_html__( 'View your shopping cart', TIELABS_TEXTDOMAIN ),
					'Your cart is currently empty.' => esc_html__( 'Your cart is currently empty.', TIELABS_TEXTDOMAIN ),
				)
			),
		);

		if( ! empty( $texts ) && is_array( $texts ) ){
			$default_texts = array_merge( $texts, $default_texts );
		}

		return apply_filters( 'TieLabs/default_translation_texts', $default_texts );
	}
}
