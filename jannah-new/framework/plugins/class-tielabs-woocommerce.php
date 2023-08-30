<?php
/**
 * WooCommerce Class
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_WOOCOMMERCE' ) ) {

	class TIELABS_WOOCOMMERCE{

		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			// Disable if the WooCommerce plugin is not active
			if( ! TIELABS_WOOCOMMERCE_IS_ACTIVE ){
				return;
			}

			// Add Theme Support for WooCommerce
			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-slider' );

			// Disable the tabs Heading
			add_filter( 'woocommerce_product_description_heading',            '__return_false' );
			add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );

			// Remove default wrappers.
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
			remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end' );

			// Add custom wrappers.
			add_action( 'woocommerce_before_main_content', array( $this, 'output_content_wrapper_start' ) );
			add_action( 'woocommerce_after_main_content',  array( $this, 'output_content_wrapper_end' ) );

			// Custom Markup
			add_action( 'woocommerce_before_shop_loop',            array( $this, 'before_shop_loop' ),    33 );
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'product_img_start' ), 9 );
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'product_img_end' ),  11 );

			// Add Custom Theme LightBox
			add_filter( 'woocommerce_single_product_image_thumbnail_html', array( $this, 'single_product_image_html' ), 20, 2 );

			// Number of products per page
			add_filter( 'loop_shop_per_page', array( $this, 'products_pre_page' ), 20 );

			// Number of columns
			add_filter( 'loop_shop_columns', array( $this, 'loop_shop_columns' ), 99, 1 );

			// WooCommerce Related posts Number
			add_filter( 'woocommerce_upsell_display_args',          array( $this, 'related_products_args' ) );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );

			// Product thumbnails slider
			add_action( 'woocommerce_product_thumbnails', array( $this, 'product_thumbnails_slider' ), 20 );

			// Enqueue CSS for the theme
			add_filter( 'woocommerce_enqueue_styles', array( $this, 'enqueue_styles' ) );

			// Change the position of the breadcrumbs if it is active
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
			if( tie_get_option( 'breadcrumbs' ) ){
				add_action( 'woocommerce_before_main_content',  'woocommerce_breadcrumb', 30, 0 );
			}

			// WooCommerce Breadcrumb Args
			add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'breadcrumbs_args' ) );

			// WooCommerce update Cart details
			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'cart_items_details' ) );

			// WooCommerce update Cart counter
			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'cart_items_number' ) );

			// WooCommerce update Cart details function
			add_action( 'TieLabs/wc_cart_menu_content', array( $this, 'header_cart_content' ) );

			// WooCommerce pages logo
			add_filter( 'TieLabs/Logo/args', array( $this, 'logo_args' ), 10, 2 );

			// Blocks Query
			add_filter( 'TieLabs/Query/args', array( $this, 'block_query_args' ), 10, 2 );

			// Post Sidebars Settings
			add_filter( 'TieLabs/Settings/Post/sidebar/defaults', array( $this, 'post_sidebar_settings' ) );

			// Add Support for the the theme text styles in the short description area
			add_filter( 'woocommerce_short_description', array( $this, 'short_description' ) );
		}


		/**
		 * Enqueue CSS for this theme.
		 *
		 * @param  array $styles Array of registered styles.
		 * @return array
		 */
		function enqueue_styles( $styles ) {

			$styles = array(); 		// Reset the default WooCommerce Styles

			$styles['tie-css-woocommerce'] = array(
				'src'     => TIELABS_TEMPLATE_URL.'/assets/css/plugins/woocommerce'. TIELABS_STYLES::is_minified() .'.css',
				'deps'    => '',
				'version' => TIELABS_DB_VERSION,
				'media'   => 'all',
			);

			return $styles;
		}


		/*
		 * Woocommerce Logo
		 */
		function logo_args( $logo_args, $logo_suffix ){

			if( ! is_woocommerce() || ( is_woocommerce() && ! self::get_page_data( 'custom_logo'.$logo_suffix ) ) ){
				return $logo_args;
			}

			$logo_args['logo_type']            = self::get_page_data( 'logo_setting'.$logo_suffix );
			$logo_args['logo_img']             = self::get_page_data( 'logo'.$logo_suffix );
			$logo_args['logo_retina']          = self::get_page_data( 'logo_retina'.$logo_suffix );
			$logo_args['logo_inverted']        = self::get_page_data( 'logo_inverted'.$logo_suffix );
			$logo_args['logo_inverted_retina'] = self::get_page_data( 'logo_inverted_retina'.$logo_suffix );
			$logo_args['logo_width']           = self::get_page_data( 'logo_retina_width'.$logo_suffix );
			$logo_args['logo_height']          = self::get_page_data( 'logo_retina_height'.$logo_suffix );
			$logo_args['logo_margin_top']      = self::get_page_data( 'logo_margin'.$logo_suffix );
			$logo_args['logo_margin_bottom']   = self::get_page_data( 'logo_margin_bottom'.$logo_suffix );
			$logo_args['logo_title']           = self::get_page_data( 'logo_text', get_bloginfo() );
			$logo_args['logo_url']             = self::get_page_data( 'logo_url'.$logo_suffix );

			return $logo_args;
		}


		/*
		 * WooCommerce : Post Query
		 */
		function block_query_args( $args, $block ){

			if( empty( $block['style'] ) || ( ! empty( $block['style'] ) && $block['style'] != 'woocommerce' ) ){
				return $args;
			}

			if( ! empty( $block['woo_cats'] ) ) {
				$woo_categories = $block['woo_cats'];
			}
			else{
				$woo_categories = array();
				$get_categories = get_terms( array( 'taxonomy' => 'product_cat' ) );

				if ( ! empty( $get_categories ) && ! is_wp_error( $get_categories ) ){
					foreach ( $get_categories as $cat ){
						$woo_categories[] = $cat->term_id;
					}
				}
			}

			$args['post_type'] = 'product';
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => $woo_categories,
				),
			);

			unset( $args['cat'] );
			unset( $args['post__not_in'] );

			return $args;
		}


		/**
		 * Open the theme wrapper.
		 */
		function output_content_wrapper_start(){
			echo '<div '. tie_content_column_attr( false ) .'>';
			echo '<div class="container-wrapper">';
		}


		/**
		 * Close the theme wrapper.
		 */
		function output_content_wrapper_end(){
			echo '</div>';
			echo '</div>';
		}


		/**
		 * Add Clear before the Shop Loop.
		 */
		function before_shop_loop(){
			echo '<div class="clearfix"></div>';
		}


		/**
		 * Add Wrap around the Image in the Loop, Start.
		 */
		function product_img_start(){
			echo '<div class="product-img">';
		}


		/**
		 * Add Wrap around the Image in the Loop, End.
		 */
		function product_img_end(){
			echo '</div>';
		}


		/**
		 * Add Custom Icon with LightBox.
		 */
		function single_product_image_html( $html, $attachment_id ){

			$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
			$zoom_trigger = 'class="woocommerce-product-gallery__image"><a href="'. esc_url( $full_size_image[0] ) .'" class="woocommerce-product-gallery__trigger"><span class="tie-icon-search-plus"></span></a>';

			return str_replace( 'class="woocommerce-product-gallery__image">', $zoom_trigger, $html );
		}


		/**
		 * Number of Products Per Page.
		 */
		function products_pre_page(){
			if( tie_get_option( 'products_pre_page' ) ){
				 return tie_get_option( 'products_pre_page' );
			}
		}


		/**
		 * Default Number of Column.
		 */
		function loop_shop_columns(){
			return 3;
		}


		/**
		 * Full Width Number Of Column.
		 */
		public static function full_width_loop_shop_columns(){
			return 4;
		}


		/**
		 * Get WooCommerce custom option.
		 */
		public static function get_page_data( $key, $default = false ){

			// Check if WooCommerce is active
			if( ! TIELABS_WOOCOMMERCE_IS_ACTIVE ){
				return;
			}

			// Get the Shop page ID
			$wc_id = wc_get_page_id( 'shop' );

			if( ! empty( $wc_id ) ){
				if( $value = get_post_meta( $wc_id, $key, $single = true ) ) {
					return $value;
				}
			}

			if( $default ){
				return $default;
			}

			return false;
		}


		/**
		 * Get all WooCommerce categories as array of ID and name.
		 */
		public static function categories( $label = false ){

			// Check if WooCommerce is active
			if( ! TIELABS_WOOCOMMERCE_IS_ACTIVE ){
				return;
			}

			$categories = array();

			if( ! empty( $label ) ) {
				$categories = array( '' => esc_html__( '- Select a category -', TIELABS_TEXTDOMAIN ));
			}

			$get_categories = get_categories( array( 'hide_empty'	=> 0, 'taxonomy' => 'product_cat' ) );

			if( ! empty( $get_categories ) && is_array( $get_categories ) ){
				foreach ( $get_categories as $category ){
					$categories[ $category->cat_ID ] = $category->cat_name;
				}
			}

			return $categories;
		}


		/**
		 * Related Posts Number.
		 */
		function related_products_args( $args ){

			$columns = ( tie_get_option( 'woo_product_sidebar_pos' ) == 'full' ) ? 4 : 3;
			$args['posts_per_page'] = tie_get_option( 'related_products_number', $columns );
			$args['columns'] = $columns;

			return $args;
		}


		/**
		 * Product Thumbnails slider.
		 */
		function product_thumbnails_slider(){

			// Enqueue the Sliders Js file
			wp_enqueue_script( 'tie-js-sliders' );

			// Enqueue the LightBox Js file
			wp_enqueue_script( 'tie-js-ilightbox' );

			$products_script = "
				jQuery(document).ready(function(){

					if( tie.lazyload ){
						jQuery( '.woocommerce-product-gallery__image' ).each(function(){
							var elem = jQuery(this).find('img');
							if( typeof elem.data('src') !== 'undefined' ){
								elem.attr('src', elem.data('src') );
								elem.removeAttr('data-src');
							}
						});
					}

					/* Product Gallery */
					jQuery('.flex-control-nav').wrap('<div class=\"flex-control-nav-wrapper\"></div>').after('<div class=\"tie-slider-nav\">').slick({
						slide         : 'li',
						speed         : 300,
						slidesToShow  : 4,
						slidesToScroll: 1,
						infinite      : false,
						rtl           : is_RTL,
						appendArrows  : '.images .tie-slider-nav',
						prevArrow     : '<li><span class=\"tie-icon-angle-left\"></span></li>',
						nextArrow     : '<li><span class=\"tie-icon-angle-right\"></span></li>',
					});

					/* WooCommerce LightBox */
					jQuery( '.woocommerce-product-gallery__trigger' ).iLightBox({
						skin: tie.lightbox_skin,
						path: tie.lightbox_thumb,
						controls: {
							arrows: tie.lightbox_arrows,
						}
					});

				});
			";

			TIELABS_HELPER::inline_script( 'tie-scripts', $products_script );
		}


		/**
		 * Update Cart Details.
		 */
		function cart_items_details( $fragments ){
			ob_start();

			do_action( 'TieLabs/wc_cart_menu_content' );

			$fragments['.shopping-cart-details'] = ob_get_clean();

			return $fragments;
		}


		/**
		 * Update Cart Counter.
		 */
		function cart_items_number( $fragments ){

			$output = '<span class="shooping-cart-counter menu-counter-bubble-outer">';

			if( isset( WC()->cart ) && WC()->cart->get_cart_contents_count() != 0 ){
				$output .= '<span class="menu-counter-bubble">'. apply_filters( 'TieLabs/number_format', WC()->cart->get_cart_contents_count() ) .'</span>';
			}

			$output .= '</span><!-- .menu-counter-bubble-outer -->';

			$fragments['.shooping-cart-counter'] = $output;

			return $fragments;
		}


		/**
		 * Breadcrumb Args.
		 */
		function breadcrumbs_args(){
			return array(
				'delimiter'   => '<em class="delimiter">'. ( tie_get_option( 'breadcrumbs_delimiter') ? wp_kses_post( tie_get_option( 'breadcrumbs_delimiter') ) : '&#47;' ) .'</em>',
				'wrap_before' => '<nav id="breadcrumb" class="woocommerce-breadcrumb" itemprop="breadcrumb">',
				'wrap_after'  => '</nav>',
				'home'        => ' '. esc_html__( 'Home', TIELABS_TEXTDOMAIN ),
				'before'      => '',
				'after'       => '',
			);
		}


		/**
		 * Update Cart Details.
		 */
		function header_cart_content(){

			$cart_items = isset( WC()->cart ) ? WC()->cart->get_cart() : false; ?>

			<div class="shopping-cart-details">
			<?php

			if( ! empty( $cart_items ) ){ ?>
				<ul class="cart-list">
					<?php

						foreach( $cart_items as $item => $details ){

							$_product = $details['data'];
							$product_img = $_product->get_image();

							if( tie_get_option( 'lazy_load' ) ){
								$product_img = str_replace( ' src', ' data-old', $product_img );
								$product_img = str_replace( 'data-src', 'src', $product_img );
							}

							// WooCommerce > 3.3.0
							$remove_url = function_exists( 'wc_get_cart_remove_url' ) ? wc_get_cart_remove_url( $item ) : WC()->cart->get_remove_url( $item );

							?>

							<li>
								<div class="product-thumb">
									<a href="<?php echo esc_url( $_product->get_permalink() ); ?>"><?php echo ( $product_img ); ?></a>
								</div>
								<h5 class="product-title"><a href="<?php echo esc_url( $_product->get_permalink() ); ?>"><?php echo ( $_product->get_title() ) ?></a></h5>
								<div class="product-meta">
									<div class="product-quantity-price">
										<?php printf(
												esc_html__( '%1$s x %2$s.', TIELABS_TEXTDOMAIN ),
												$details['quantity'],
												wc_price( $_product->get_price() )
											);
										?>
									</div>
								</div>
								<a href="<?php echo esc_url( $remove_url  ) ?>" class="remove"><span class="screen-reader-text"><?php esc_html_e( 'Remove', TIELABS_TEXTDOMAIN ); ?></span></a>
							</li>

							<?php
						}
					?>
				</ul>

				<div class="shopping-subtotal">
					<?php esc_html_e( 'Subtotal:', TIELABS_TEXTDOMAIN ); ?> <?php echo WC()->cart->get_total(); ?>
				</div><!-- .shopping-subtotal /-->

				<a href="<?php echo wc_get_checkout_url() ?>" class="checkout-button button"><?php esc_html_e( 'Checkout', TIELABS_TEXTDOMAIN ); ?></a>
				<a href="<?php echo wc_get_cart_url() ?>" class="view-cart-button button guest-btn"><?php esc_html_e( 'View Cart', TIELABS_TEXTDOMAIN ); ?></a>
				<?php
			}
			else{ ?>
				<div class="cart-empty-message">
					<?php esc_html_e( 'Your cart is currently empty.', TIELABS_TEXTDOMAIN ); ?>
				</div>
				<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="checkout-button button"><?php esc_html_e( 'Go to the shop', TIELABS_TEXTDOMAIN ); ?></a>
				<?php
			}

			?>
			</div><!-- shopping-cart-details -->
		<?php
		}


		/**
		 * post_sidebar_settings
		 */
		function post_sidebar_settings( $current_settings ){

			if( get_the_ID() != wc_get_page_id( 'shop' ) ){
				return $current_settings;
			}

			return array(

				array(
					'text' =>  sprintf(
						esc_html__( 'Control WooCommerce sidebar settings from the theme options page &gt; %1$sWooCommerce settings%2$s.', TIELABS_TEXTDOMAIN ),
						'<a href="'. admin_url( 'admin.php?page=tie-theme-options#tie-options-tab-woocommerce-target' ) .'">',
						'</a>'
					),
					'type' => 'message',
			));
		}


		/**
		 * short_description
		 */
		function short_description( $short_description = false ){

			if( empty( $short_description ) ){
				return;
			}

			return '<div class="entry">'.$short_description.'</div>';
		}

	}


	// Instantiate the class
	new TIELABS_WOOCOMMERCE();
}
