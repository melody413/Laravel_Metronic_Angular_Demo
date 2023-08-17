<?php
/**
 * Mega menus module
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! class_exists( 'TIELABS_MEGA_MENU' ) ) {

	class TIELABS_MEGA_MENU extends Walker_Nav_Menu {

		private $tie_megamenu_tiny_text     = '';
		private $tie_megamenu_tiny_bg       = '';
		private $tie_megamenu_type          = '';
		private $tie_megamenu_icon          = '';
		private $tie_megamenu_image         = '';
		private $tie_megamenu_position      = '';
		private $tie_megamenu_position_y    = '';
		private $tie_megamenu_repeat        = '';
		private $tie_megamenu_min_height    = '';
		private $tie_megamenu_padding_left  = '';
		private $tie_megamenu_padding_right = '';
		private $tie_megamenu_media_overlay = '';
		private $tie_megamenu_icon_only     = '';
		private $tie_megamenu_hide_headings = '';
		private $tie_has_children           = '';

		/**
		 * Starts the list before the elements are added.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ){
			$indent = str_repeat("\t", $depth);

			if( $depth === 0 && $this->tie_megamenu_type == 'links' ){

				$output .= "\n$indent<ul class=\"sub-menu-columns\">\n";
			}
			elseif( $depth === 1 && $this->tie_megamenu_type == 'links' ){

				$output .= "\n$indent<ul class=\"sub-menu-columns-item\">\n";
			}
			elseif( $depth === 0 && ( $this->tie_megamenu_type == 'sub-posts' || $this->tie_megamenu_type == 'sub-hor-posts' ) ){

				$output .= "\n$indent<ul class=\"sub-menu mega-cat-more-links\">\n";
			}
			elseif( $depth === 0 && $this->tie_megamenu_type == 'recent' ){

				$output .= "\n$indent<ul class=\"mega-recent-featured-list sub-list\">\n";
			}
			else{

				$output .= "\n$indent<ul class=\"sub-menu menu-sub-content\">\n";
			}
		}


		/**
		 * Ends the list of after the elements are added.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ){

			$indent  = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}


		/**
		 * Start the element output.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			  $t = '';
			  $n = '';
			} else {
			  $t = "\t";
			  $n = "\n";
			}
			$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

      /**
       * Filters the arguments for a single nav menu item.
       *
       * @since 4.4.0
       *
       * @param stdClass $args  An object of wp_nav_menu() arguments.
       * @param WP_Post  $item  Menu item data object.
       * @param int      $depth Depth of menu item. Used for padding.
       */
      $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );


		//By TieLabs ===========

			/**
			 * Filter the CSS class(es) applied to a menu item's <li>.
			 */
			$class_names = join( ' ' , apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

			$a_class = $item_output = $item_data_id = $media_icon = '';

			// Get All custom data
			$menu_item_data = get_post_meta( $item->ID );
			$mega_prefix    = 'tie_megamenu_';

			// Define the mega vars
			if( $depth === 0 ){

				$this->tie_has_children = 0;

				if( ! empty( $args->has_children ) ){
					$this->tie_has_children = $args->has_children;
				}

				// Assign the heigh-level menu only item data
				$menu_data_array = array( 'columns', 'type', 'image', 'position', 'position_y', 'repeat', 'min_height', 'padding_left', 'padding_right', 'media_overlay', 'icon_only', 'hide_headings' );

				foreach ( $menu_data_array as $meta_item ) {
					$meta_name = $mega_prefix.$meta_item;
					$this->$meta_name = ! empty( $menu_item_data[ $meta_name ][0] ) ? $menu_item_data[ $meta_name ][0] : false;
				}
			}

			// Assign the general menu only item data
			$menu_data_array = array( 'tiny_text', 'tiny_bg', 'icon' );

			foreach ( $menu_data_array as $meta_item ) {
				$meta_name = $mega_prefix.$meta_item;
				$this->$meta_name = ! empty( $menu_item_data[ $meta_name ][0] ) ? $menu_item_data[ $meta_name ][0] : false;
			}

			//Menu Item has an icon
			if( $depth === 0 && ! empty( $this->tie_megamenu_icon ) ){
				$class_names .= ' menu-item-has-icon';
			}

			//Menu Item has icon only
			if( $depth === 0 && ! empty( $this->tie_megamenu_icon_only ) ){
				$class_names .= ' is-icon-only';
			}

			//Menu Classes
			if( $depth === 0 && ! empty( $this->tie_megamenu_type ) && $this->tie_megamenu_type != 'disable' ){

				$class_names .= ' mega-menu';

				// Links
				if( $this->tie_megamenu_type == 'links' ){

					$columns     = ( ! empty( $this->tie_megamenu_columns ) ? $this->tie_megamenu_columns :  2 );
					$class_names  .= ' mega-links mega-links-'.$columns.'col ';
				}

				// Category
				elseif( $item->object == 'category' ){

					// Category ID
					if( ! empty( $item->object_id ) ){
						$item_data_id = " data-id=\"$item->object_id\" ";
					}

					// Media Icon
					if( ! empty( $this->tie_megamenu_media_overlay ) ){
						$media_icon = ' data-icon="true" ';
					}

					if( $this->tie_megamenu_type == 'sub-posts' || $this->tie_megamenu_type == 'sub-hor-posts' ){
						$class_names .= ' mega-cat ';
					}
					elseif( $this->tie_megamenu_type == 'recent' ){
						$class_names .= ' mega-recent-featured ';
					}
				}

			}

			if( $depth === 1 && $this->tie_megamenu_type == 'links' ){
				$class_names .= ' mega-link-column ';
				$a_class      = ' class="mega-links-head';

				if( ! empty( $this->tie_megamenu_hide_headings ) ){
					$class_names .= ' hide-mega-headings';
				}

				$a_class .= '" ';
			}

		// =====================

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's <li>.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			//$output .= $indent . '<li' . $id . $class_names . $item_data_id . $media_icon '>';

			$output .= sprintf( '%s<li%s%s%s%s>',
				$indent,
				$id,
				$class_names,
				$item_data_id,
				$media_icon,
				in_array( 'menu-item-has-children', $classes ) ? ' aria-haspopup="true" aria-expanded="false" tabindex="0"' : ''
			);

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

			/**
			 * Filter the HTML attributes applied to a menu item's <a>.
			 *
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ){
				if ( ! empty( $value ) ){
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			# ---------
			if( ! empty( $args->before ) ){
				$item_output = $args->before;
			}

			$item_output .= '<a'.$a_class . $attributes .'>';

			if( ! empty( $this->tie_megamenu_icon ) || ( $depth === 0 && ! empty( $this->tie_megamenu_icon_only )) ){

				$tie_megamenu_icon = 'tie-icon-warning';
				if( ! empty( $this->tie_megamenu_icon ) ){
					$tie_megamenu_icon = $this->tie_megamenu_icon;
				}

				$item_output .= ' <span aria-hidden="true" class="tie-menu-icon '.$tie_megamenu_icon.'"></span> ';

			}elseif( $depth === 2 && $this->tie_megamenu_type == 'links' ){

				$item_output .= ' <span aria-hidden="true" class="mega-links-default-icon"></span>';
			}


			/** This filter is documented in wp-includes/post-template.php */
			$menu_item = apply_filters( 'the_title', $item->title, $item->ID );

     	/**
       * Filters a menu item's title.
       *
       * @since 4.4.0
       *
       * @param string   $title The menu item's title.
       * @param WP_Post  $item  The current menu item.
       * @param stdClass $args  An object of wp_nav_menu() arguments.
       * @param int      $depth Depth of menu item. Used for padding.
       */
      $menu_item = apply_filters( 'nav_menu_item_title', $menu_item, $item, $args, $depth );


			// -------
			if( $depth === 0 && ! empty( $this->tie_megamenu_icon_only ) ){
				$menu_item = ' <span class="screen-reader-text">'. $menu_item .'</span>';
			}

			// Tiny Text
			if( $this->tie_megamenu_tiny_text ){

				$label_bg = '';
				if( $this->tie_megamenu_tiny_bg ){
					$text_color = TIELABS_STYLES::light_or_dark( $this->tie_megamenu_tiny_bg );
					$label_bg   = 'style="background-color:'.$this->tie_megamenu_tiny_bg.'; color:'.$text_color.'"';
				}

				$label_class = ( strlen( $this->tie_megamenu_tiny_text ) == 1 ) ? 'menu-tiny-circle' : '';
				$menu_item  .= ' <small class="menu-tiny-label '. $label_class .'" '.$label_bg.'>'. $this->tie_megamenu_tiny_text .'</small>';
			}

			$item_output .= $args->link_before . $menu_item . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;


		//By TieLabs ===========
			if( $depth === 0 && ! empty( $this->tie_megamenu_type ) && $this->tie_megamenu_type != 'disable' /*&& ! tie_is_mobile() */ ){

				$style = '';
				if ( ! empty( $this->tie_megamenu_image ) ) {

					$style .= " background-image: url($this->tie_megamenu_image) ; background-position: $this->tie_megamenu_position_y $this->tie_megamenu_position ; background-repeat: $this->tie_megamenu_repeat ; ";
				}

				if ( ! empty( $this->tie_megamenu_padding_left ) ){

					$padding_left = $this->tie_megamenu_padding_left;
					if ( strpos( $padding_left , 'px' ) === false && strpos( $padding_left , '%' ) === false ) $padding_left .= 'px';
					$style .= " padding-left : $padding_left; ";
				}

				if ( ! empty( $this->tie_megamenu_padding_right ) ){

					$padding_right = $this->tie_megamenu_padding_right;
					if ( strpos( $padding_right , 'px' ) === false && strpos( $padding_right , '%' ) === false ) $padding_right .= 'px';
					$style .= " padding-right : $padding_right; ";
				}

				if ( ! empty( $this->tie_megamenu_min_height ) ){

					$min_height = $this->tie_megamenu_min_height;
					if ( strpos( $min_height , 'px' ) === false ) $min_height .= 'px';
					$style .= " min-height : $min_height; ";
				}

				if ( ! empty( $style ) ) $style=' style="'. $style .'"';

				$item_output .="\n<div class=\"mega-menu-block menu-sub-content\"$style>\n";
			}

		// =====================

			/**
			 * Filter a menu item's starting output.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}


		/**
		 * Ends the element output, if needed.
		 */
		public function end_el( &$output, $item, $depth = 0, $args = array() ){

		//By TieLabs ===========
			if( $depth === 0 && ! empty( $this->tie_megamenu_type ) && $this->tie_megamenu_type != 'disable' /* && ! tie_is_mobile() */ ){

				if( $this->tie_megamenu_type != 'links' ){

					$media_icon = '';
					if( ! empty( $this->tie_megamenu_media_overlay ) ){
						$media_icon = ' media-overlay';
					}

					$output .="\n<div class=\"mega-menu-content$media_icon\">\n";
				}

			//Sub Categories ===============================================================
				if( ( $this->tie_megamenu_type == 'sub-posts' || $this->tie_megamenu_type == 'sub-hor-posts' ) &&  $item->object == 'category' ){

					$no_sub_categories = $sub_categories_exists = $sub_categories = '';

					$query_args = apply_filters( 'TieLabs/Mega_Menu/child_categories_args', array(
						'parent' => $item->object_id,
					));

					$sub_categories = get_categories( $query_args );

					// Check if the Category doesn't contain any sub categories.
					if( count( $sub_categories ) == 0){
						$sub_categories    = array( $item->object_id ) ;
						$no_sub_categories = true ;
					}
					else{
						$sub_categories_exists = ' mega-cat-sub-exists';
					}

					//Horizontal sub categories filter
					if( $this->tie_megamenu_type == 'sub-hor-posts' || $no_sub_categories ){
						$sub_categories_exists .= ' horizontal-posts';
						$sub_categories_type    = ' cats-horizontal';
					}
					//Vertical sub categories filter
					else{
						$sub_categories_exists .= ' vertical-posts';
						$sub_categories_type = ' cats-vertical';
					}

					$output .= "<div class=\"mega-cat-wrapper\">\n";

					if( ! $no_sub_categories ){

						$cat_link = TIELABS_WP_HELPER::get_term_link( (int) $item->object_id, 'category' );

						// Media Icon
						$media_icon = '';
						if( ! empty( $this->tie_megamenu_media_overlay ) ){
							$media_icon = ' data-icon="true" ';
						}

						$output .= "<ul class=\"mega-cat-sub-categories$sub_categories_type\">\n";
						$output .= "<li class=\"mega-all-link\"><a href=\"$cat_link\" class=\"is-active is-loaded mega-sub-cat\" data-id=\"$item->object_id\">". esc_html__( 'All', TIELABS_TEXTDOMAIN ) ."</a></li>\n";

						foreach( $sub_categories as $category ){
							$cat_link = TIELABS_WP_HELPER::get_term_link( $category->term_id, 'category' );
							$output  .= "<li><a href=\"$cat_link\" class=\"mega-sub-cat\" $media_icon data-id=\"$category->term_id\">$category->name</a></li>\n";
						}

						$output .=  "</ul>\n";
					}

					$output .= "<div class=\"mega-cat-content$sub_categories_exists\">\n
												<div class=\"mega-ajax-content mega-cat-posts-container clearfix\">\n
												</div><!-- .mega-ajax-content -->\n";

					/*

					$output .= "
							<ul class=\"slider-arrow-nav tie-direction-nav\">
								<li><a class=\"tie-mega-pagination prev-posts pagination-disabled\" href=\"#\"><span class=\"tie-icon-angle-left\" aria-hidden=\"true\"></span></a></li>
								<li><a class=\"tie-mega-pagination next-posts\" href=\"#\"><span class=\"tie-icon-angle-right\" aria-hidden=\"true\"></span></a></li>
							</ul>\n";

					*/

					$output .= "
						</div><!-- .mega-cat-content -->\n
					</div><!-- .mega-cat-Wrapper -->\n";
				}


			//Recent + Check also ========================================================
				if( $this->tie_megamenu_type == 'recent' &&  $item->object == 'category' ){

					$output .= "<div class=\"mega-ajax-content\">\n</div><!-- .mega-ajax-content -->\n";
				}

			// End of Sub Categories =====================================================

				if( $this->tie_megamenu_type != 'links' ){
					$output .= "\n</div><!-- .mega-menu-content -->\n";
				}

				$output .= "\n</div><!-- .mega-menu-block --> \n";
			}
		// =====================

			$output .= "</li>\n";
		}


		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args = array(), &$output ){
			$id_field = $this->db_fields['id'];
			if ( is_object( $args[0] ) ){
				$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
			}
			return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}
	} // Walker_Nav_Menu



	// Back end modification on Menus page ===============================================
	if( ! tie_get_option( 'disable_mega_menu' ) ){

		add_filter( 'wp_edit_nav_menu_walker', 'tie_custom_nav_edit_walker', 10, 2 );

		// Custom icons beside the title
		add_action( 'wp_nav_menu_item_before_title', 'tie_add_megamenu_icon_preview', 10, 4 );

		// The Custom TieLabs menu fields
		add_action( 'wp_nav_menu_item_custom_fields', 'tie_add_megamenu_fields', 10, 4 );
	}


	function tie_custom_nav_edit_walker( $walker, $menu_id = false ){
		return 'TIELABS_MEGA_MENU_EDIT_WALKER';
	}

	// Custom icons beside the title
	function tie_add_megamenu_icon_preview( $item_id, $item, $depth, $args ){
		echo "<span class=\"preview-menu-item-icon $item->tie_megamenu_icon\"></span>";
	}

	// The Custom TieLabs menu fields
	function tie_add_megamenu_fields( $item_id, $item, $depth, $args ){

		$theme_color = tie_get_option( 'global_color', '#000000' );
		?>

		<div class="clear"></div>
		<br />
		<strong><?php esc_html_e( 'Custom Settings:', TIELABS_TEXTDOMAIN ); ?></strong> <small><em><?php esc_html_e( '(Only for Main Nav)', TIELABS_TEXTDOMAIN ); ?></em></small>

		<div class="clear"></div>

		<p class="description description-thin">
			<label for="edit-menu-item-megamenu-tiny-text-<?php echo esc_attr( $item_id ); ?>">
				<?php esc_html_e( 'Label Text', TIELABS_TEXTDOMAIN ); ?><br />
				<input type="text" id="edit-menu-item-megamenu-tiny-text-<?php echo esc_attr( $item_id ) ?>" class="widefat edit-menu-item-megamenu-tiny-text" name="menu-item-tie-megamenu-tiny-text[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->tie_megamenu_tiny_text ); ?>" />
			</label>
		</p>
		<p class="description description-thin tie-custom-color-picker">
			<label for="edit-menu-item-attr-megamenu-tiny-bg-<?php echo esc_attr( $item_id ); ?>">
				<?php esc_html_e( 'Label Background', TIELABS_TEXTDOMAIN ); ?><br />
				<span>
					<input class="tieColorSelector" id="edit-menu-item-megamenu-tiny-bg-<?php echo esc_attr( $item_id ) ?>" name="menu-item-tie-megamenu-tiny-bg[<?php echo esc_attr( $item_id ); ?>]" data-palette="<?php echo esc_attr( $theme_color ); ?>, #9b59b6, #3498db, #2ecc71, #f1c40f, #34495e, #e74c3c"  style="width:80px;" type="text" value="<?php echo esc_attr( $item->tie_megamenu_tiny_bg ); ?>">
				</span>

			</label>
		</p>

		<div class="tie-mega-menu-type">

			<p class="field-megamenu-icon description description-wide">
				<label for="edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Menu Icon', TIELABS_TEXTDOMAIN ); ?>
					<div class="icon-picker-wrapper">
						<div id="preview_edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ) ?>" data-target="#edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ) ?>" class="button icon-picker <?php echo esc_attr( $item->tie_megamenu_icon ) ?>"></div>
					</div>
					<input type="text" placeholder="fab fa-icon" id="edit-menu-item-megamenu-icon-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-icon" name="menu-item-tie-megamenu-icon[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr( $item->tie_megamenu_icon ) ?>">
				</label>
			</p>

			<p class="field-megamenu-icon-only description description-wide">
				<label for="edit-menu-item-megamenu-icon-only-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Show the icon only?', TIELABS_TEXTDOMAIN );?>
					<input type="checkbox" id="edit-menu-item-megamenu-icon-only-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-icon-only" name="menu-item-tie-megamenu-icon-only[<?php echo esc_attr( $item_id ) ?>]" value="true" <?php checked( $item->tie_megamenu_icon_only, 'true' ); ?>>
				</label>
			</p>

			<p class="field-megamenu-type description description-wide">
				<label for="edit-menu-item-megamenu-type-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Enable The Mega Menu?', TIELABS_TEXTDOMAIN ); ?>
					<select id="edit-menu-item-megamenu-type-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-type" name="menu-item-tie-megamenu-type[<?php echo esc_attr( $item_id ) ?>]">
						<option value=""><?php esc_html_e( 'Disable', TIELABS_TEXTDOMAIN ); ?></option>
						<?php  if( $item->object == 'category' ){  ?>
						<option value="sub-posts" <?php selected( $item->tie_megamenu_type, 'sub-posts' ); ?>><?php esc_html_e( 'Posts - Vertical Sub-Categories Filter', TIELABS_TEXTDOMAIN ); ?></option>
						<option value="sub-hor-posts" <?php selected( $item->tie_megamenu_type, 'sub-hor-posts' ); ?>><?php esc_html_e( 'Posts - Horizontal Sub-Categories Filter', TIELABS_TEXTDOMAIN ); ?></option>
						<option value="recent" <?php selected( $item->tie_megamenu_type, 'recent' ); ?>><?php esc_html_e( 'Posts - 1st Post Highlighted', TIELABS_TEXTDOMAIN ); ?></option>
						<?php } ?>
						<option value="links" <?php selected( $item->tie_megamenu_type, 'links' ); ?>><?php esc_html_e( 'Mega Menu Columns', TIELABS_TEXTDOMAIN ); ?></option>
					</select>
				</label>
			</p>

			<?php if( $item->object == 'category' ){  ?>
				<p class="field-megamenu-media-overlay description description-wide">
					<label for="edit-menu-item-megamenu-media-overlay-<?php echo esc_attr( $item_id ) ?>">
						<?php esc_html_e( 'Media Icon', TIELABS_TEXTDOMAIN );?>
						<input type="checkbox" id="edit-menu-item-megamenu-media-overlay-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-media-overlay" name="menu-item-tie-megamenu-media-overlay[<?php echo esc_attr( $item_id ) ?>]" value="true" <?php checked( $item->tie_megamenu_media_overlay, 'true' ); ?>>
					</label>
				</p>
			<?php } ?>

			<p class="field-megamenu-columns description description-wide">
				<label for="edit-menu-item-megamenu-columns-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Number of Mega Menu Columns', TIELABS_TEXTDOMAIN ); ?>
					<select id="edit-menu-item-megamenu-columns-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-columns" name="menu-item-tie-megamenu-columns[<?php echo esc_attr( $item_id ) ?>]">
						<option value=""></option>
						<option value="2" <?php selected( $item->tie_megamenu_columns, '2' ); ?>>2</option>
						<option value="3" <?php selected( $item->tie_megamenu_columns, '3' ); ?>>3</option>
						<option value="4" <?php selected( $item->tie_megamenu_columns, '4' ); ?>>4</option>
						<option value="5" <?php selected( $item->tie_megamenu_columns, '5' ); ?>>5</option>
					</select>
				</label>
			</p>

			<p class="field-megamenu-hide-headings description description-wide">
				<label for="edit-menu-item-megamenu-hide-headings-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Hide Mega Menu headings?', TIELABS_TEXTDOMAIN );?>
					<input type="checkbox" id="edit-menu-item-megamenu-hide-headings-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-hide-headings" name="menu-item-tie-megamenu-hide-headings[<?php echo esc_attr( $item_id ) ?>]" value="true" <?php checked( $item->tie_megamenu_hide_headings, 'true' ); ?>>
				</label>
			</p>

			<p class="field-megamenu-image description description-wide">
				<label for="edit-menu-item-megamenu-image-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Mega Menu Background Image', TIELABS_TEXTDOMAIN ); ?>
				</label>
				<input type="text" id="edit-menu-item-megamenu-image-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-image" name="menu-item-tie-megamenu-image[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr( $item->tie_megamenu_image ) ?>" />
				<select id="edit-menu-item-megamenu-position-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-position" name="menu-item-tie-megamenu-position[<?php echo esc_attr( $item_id ) ?>]">
					<option value=""></option>
					<option value="center" <?php selected( $item->tie_megamenu_position, 'center' ); ?>><?php esc_html_e( 'Center', TIELABS_TEXTDOMAIN ); ?></option>
					<option value="right" <?php selected( $item->tie_megamenu_position, 'right' ); ?>><?php esc_html_e( 'Right', TIELABS_TEXTDOMAIN ); ?></option>
					<option value="left" <?php selected( $item->tie_megamenu_position, 'left' ); ?>><?php esc_html_e( 'Left', TIELABS_TEXTDOMAIN ); ?></option>
				</select>
				<select id="edit-menu-item-megamenu-position-y-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-position-y" name="menu-item-tie-megamenu-position-y[<?php echo esc_attr( $item_id ) ?>]">
					<option value=""></option>
					<option value="center" <?php selected( $item->tie_megamenu_position_y, 'center' ); ?>><?php esc_html_e( 'Center', TIELABS_TEXTDOMAIN ); ?></option>
					<option value="top" <?php selected( $item->tie_megamenu_position_y, 'top' ); ?>><?php esc_html_e( 'Top', TIELABS_TEXTDOMAIN ); ?></option>
					<option value="bottom" <?php selected( $item->tie_megamenu_position_y, 'bottom' ); ?>><?php esc_html_e( 'Bottom', TIELABS_TEXTDOMAIN ); ?></option>
				</select>
				<select id="edit-menu-item-megamenu-repeat-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-repeat" name="menu-item-tie-megamenu-repeat[<?php echo esc_attr( $item_id ) ?>]">
					<option value=""></option>
					<option value="no-repeat" <?php selected( $item->tie_megamenu_repeat, 'no-repeat' ); ?>><?php esc_html_e( 'no-repeat', TIELABS_TEXTDOMAIN ); ?></option>
					<option value="repeat" <?php selected( $item->tie_megamenu_repeat, 'repeat' ); ?>><?php esc_html_e( 'repeat', TIELABS_TEXTDOMAIN ); ?></option>
					<option value="repeat-x" <?php selected( $item->tie_megamenu_repeat, 'repeat-x' ); ?>><?php esc_html_e( 'repeat-x', TIELABS_TEXTDOMAIN ); ?></option>
					<option value="repeat-y" <?php selected( $item->tie_megamenu_repeat, 'repeat-y' ); ?>><?php esc_html_e( 'repeat-y', TIELABS_TEXTDOMAIN ); ?></option>
				</select>
			</p>

			<p class="field-megamenu-styling description description-thin">
				<label for="edit-menu-item-megamenu-padding-right-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Padding Right', TIELABS_TEXTDOMAIN ); ?>
					<input type="text" id="edit-menu-item-megamenu-padding-right-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-padding-right" name="menu-item-tie-megamenu-padding-right[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr( $item->tie_megamenu_padding_right ) ?>" />
				</label>
			</p>

			<p class="field-megamenu-styling description description-thin">
				<label for="edit-menu-item-megamenu-padding-left-<?php echo esc_attr( $item_id ); ?>">
					<?php esc_html_e( 'Padding left', TIELABS_TEXTDOMAIN ); ?>
					<input type="text" id="edit-menu-item-megamenu-padding-left-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-padding-left" name="menu-item-tie-megamenu-padding-left[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr( $item->tie_megamenu_padding_left ) ?>" />
				</label>
			</p>

			<p class="field-megamenu-styling description description-thin">
				<label for="edit-menu-item-megamenu-min-height-<?php echo esc_attr( $item_id ) ?>">
					<?php esc_html_e( 'Min Height', TIELABS_TEXTDOMAIN ); ?>
					<input type="text" id="edit-menu-item-megamenu-min-height-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-min-height" name="menu-item-tie-megamenu-min-height[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr( $item->tie_megamenu_min_height ) ?>" />
				</label>
			</p>


		</div><!-- .tie-mega-menu-type-->
	<?php }


	// Save The custom Fields
	add_action('wp_update_nav_menu_item', 'tie_custom_nav_update', 10, 3);
	function tie_custom_nav_update( $menu_id, $menu_item_db_id, $args ){

		// Run only if the Mega menu feature is enabled
		if( tie_get_option( 'disable_mega_menu' ) ){
			return;
		}

		$custom_meta_fields = array(
			'menu-item-tie-megamenu-tiny-text',
			'menu-item-tie-megamenu-tiny-bg',
			'menu-item-tie-megamenu-type',
			'menu-item-tie-megamenu-columns',
			'menu-item-tie-megamenu-icon',
			'menu-item-tie-megamenu-image',
			'menu-item-tie-megamenu-position',
			'menu-item-tie-megamenu-position-y',
			'menu-item-tie-megamenu-min-height',
			'menu-item-tie-megamenu-repeat',
			'menu-item-tie-megamenu-padding-left',
			'menu-item-tie-megamenu-padding-right',
			'menu-item-tie-megamenu-icon-only',
			'menu-item-tie-megamenu-hide-headings',
			'menu-item-tie-megamenu-media-overlay',
		);

		foreach( $custom_meta_fields as $custom_meta_field ){
			$save_option_name = str_replace( 'menu-item-', '', $custom_meta_field);
			$save_option_name = str_replace( '-', '_', $save_option_name);

			if ( ! empty($_REQUEST[ $custom_meta_field ][ $menu_item_db_id ] ) ){
				$custom_value = $_REQUEST[ $custom_meta_field ][ $menu_item_db_id ];
				update_post_meta( $menu_item_db_id, $save_option_name, $custom_value );
			}
			else{
				delete_post_meta( $menu_item_db_id, $save_option_name );
			}
		}
	}


	/*
	 * Adds value of the new fields to $item object that will be passed to Walker_Nav_Menu_Edit_Custom
	 */
	add_filter( 'wp_setup_nav_menu_item', 'tie_custom_nav_item' );
	function tie_custom_nav_item( $menu_item ){

		$menu_item_data  = get_post_meta( $menu_item->ID );
		$menu_data_array = array( 'tiny_text', 'tiny_bg', 'type', 'icon', 'image', 'position', 'position_y', 'repeat', 'min_height', 'padding_left', 'padding_right', 'media_overlay', 'icon_only', 'hide_headings' );
		$mega_prefix     = 'tie_megamenu_';

		foreach ( $menu_data_array as $meta_item ) {
			$meta_name = $mega_prefix.$meta_item;
			$menu_item->$meta_name = ! empty( $menu_item_data[ $meta_name ][0] ) ? $menu_item_data[ $meta_name ][0] : false;
		}

		return $menu_item;
	}


	/**
	 * Navigation Menu template functions
	 */
	class TIELABS_MEGA_MENU_EDIT_WALKER extends Walker_Nav_Menu {
			/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker_Nav_Menu::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ){}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker_Nav_Menu::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ){}

		/**
		 * Start the element output.
		 *
		 * @see Walker_Nav_Menu::start_el()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   Not used.
		 * @param int    $id     Not used.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			global $_wp_nav_menu_max_depth;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

			ob_start();
			$item_id      = esc_attr( $item->ID );
			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);

			$original_title = false;

			if ( 'taxonomy' == $item->type ) {
				$original_object = get_term( (int) $item->object_id, $item->object );
				if ( $original_object && ! is_wp_error( $original_title ) ) {
					$original_title = $original_object->name;
				}
			} elseif ( 'post_type' == $item->type ) {
				$original_object = get_post( $item->object_id );
				if ( $original_object ) {
					$original_title = get_the_title( $original_object->ID );
				}
			} elseif ( 'post_type_archive' == $item->type ) {
				$original_object = get_post_type_object( $item->object );
				if ( $original_object ) {
					$original_title = $original_object->labels->archives;
				}
			}

			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive' ),
			);

			$title = $item->title;

			if ( ! empty( $item->_invalid ) ) {
				$classes[] = 'menu-item-invalid';
				/* translators: %s: Title of an invalid menu item. */
				$title = sprintf( __( '%s (Invalid)' ), $item->title );
			} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
				$classes[] = 'pending';
				/* translators: %s: Title of a menu item in draft status. */
				$title = sprintf( __( '%s (Pending)' ), $item->title );
			}

			$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

			$submenu_text = '';
			if ( 0 == $depth ) {
				$submenu_text = 'style="display: none;"';
			}

			?>
			<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode( ' ', $classes ); ?>">
				<div class="menu-item-bar">
					<div class="menu-item-handle">
						<span class="item-title">

							<?php
								//By Tielabs **************************************************
								// Since WordPress 5.4.0 this is the only change we need to do on this method.
								// We can replace this via JS, but since wp_nav_menu_item_custom_fields intreduced in v5.4.0 we will keep use this for a while for backward compatibility
								do_action( 'wp_nav_menu_item_before_title', $item_id, $item, $depth, $args );
								// END ********************************************************
							?>

							<span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo $submenu_text; ?>><?php _e( 'sub item' ); ?></span></span>
						<span class="item-controls">
							<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
							<span class="item-order hide-if-js">
								<?php
								printf(
									'<a href="%s" class="item-move-up" aria-label="%s">&#8593;</a>',
									wp_nonce_url(
										add_query_arg(
											array(
												'action'    => 'move-up-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
										),
										'move-menu_item'
									),
									esc_attr__( 'Move up' )
								);
								?>
								|
								<?php
								printf(
									'<a href="%s" class="item-move-down" aria-label="%s">&#8595;</a>',
									wp_nonce_url(
										add_query_arg(
											array(
												'action'    => 'move-down-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
										),
										'move-menu_item'
									),
									esc_attr__( 'Move down' )
								);
								?>
							</span>
							<?php
							if ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) {
								$edit_url = admin_url( 'nav-menus.php' );
							} else {
								$edit_url = add_query_arg(
									array(
										'edit-menu-item' => $item_id,
									),
									remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) )
								);
							}

							printf(
								'<a class="item-edit" id="edit-%s" href="%s" aria-label="%s"><span class="screen-reader-text">%s</span></a>',
								$item_id,
								$edit_url,
								esc_attr__( 'Edit menu item' ),
								__( 'Edit' )
							);
							?>
						</span>
					</div>
				</div>

				<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo $item_id; ?>">
					<?php if ( 'custom' == $item->type ) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo $item_id; ?>">
								<?php _e( 'URL' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-wide">
						<label for="edit-menu-item-title-<?php echo $item_id; ?>">
							<?php _e( 'Navigation Label' ); ?><br />
							<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>
					<p class="field-title-attribute field-attr-title description description-wide">
						<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
							<?php _e( 'Title Attribute' ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>
					<p class="field-link-target description">
						<label for="edit-menu-item-target-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
							<?php _e( 'Open link in a new tab' ); ?>
						</label>
					</p>
					<p class="field-css-classes description description-thin">
						<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
							<?php _e( 'CSS Classes (optional)' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode( ' ', $item->classes ) ); ?>" />
						</label>
					</p>
					<p class="field-xfn description description-thin">
						<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
							<?php _e( 'Link Relationship (XFN)' ); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
						</label>
					</p>
					<p class="field-description description description-wide">
						<label for="edit-menu-item-description-<?php echo $item_id; ?>">
							<?php _e( 'Description' ); ?><br />
							<textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
							<span class="description"><?php _e( 'The description will be displayed in the menu if the current theme supports it.' ); ?></span>
						</label>
					</p>

					<?php
					/**
					 * Fires just before the move buttons of a nav menu item in the menu editor.
					 *
					 * @since 5.4.0
					 *
					 * @param int      $item_id Menu item ID.
					 * @param WP_Post  $item    Menu item data object.
					 * @param int      $depth   Depth of menu item. Used for padding.
					 * @param stdClass $args    An object of menu item arguments.
					 * @param int      $id      Nav menu ID.
					 */
					do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args, $id );
					?>

					<fieldset class="field-move hide-if-no-js description description-wide">
						<span class="field-move-visual-label" aria-hidden="true"><?php _e( 'Move' ); ?></span>
						<button type="button" class="button-link menus-move menus-move-up" data-dir="up"><?php _e( 'Up one' ); ?></button>
						<button type="button" class="button-link menus-move menus-move-down" data-dir="down"><?php _e( 'Down one' ); ?></button>
						<button type="button" class="button-link menus-move menus-move-left" data-dir="left"></button>
						<button type="button" class="button-link menus-move menus-move-right" data-dir="right"></button>
						<button type="button" class="button-link menus-move menus-move-top" data-dir="top"><?php _e( 'To the top' ); ?></button>
					</fieldset>

					<div class="menu-item-actions description-wide submitbox">
						<?php if ( 'custom' !== $item->type && false !== $original_title ) : ?>
							<p class="link-to-original">
								<?php
								/* translators: %s: Link to menu item's original object. */
								printf( __( 'Original: %s' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' );
								?>
							</p>
						<?php endif; ?>

						<?php
						printf(
							'<a class="item-delete submitdelete deletion" id="delete-%s" href="%s">%s</a>',
							$item_id,
							wp_nonce_url(
								add_query_arg(
									array(
										'action'    => 'delete-menu-item',
										'menu-item' => $item_id,
									),
									admin_url( 'nav-menus.php' )
								),
								'delete-menu_item_' . $item_id
							),
							__( 'Remove' )
						);
						?>
						<span class="meta-sep hide-if-no-js"> | </span>
						<?php
						printf(
							'<a class="item-cancel submitcancel hide-if-no-js" id="cancel-%s" href="%s#menu-item-settings-%s">%s</a>',
							$item_id,
							esc_url(
								add_query_arg(
									array(
										'edit-menu-item' => $item_id,
										'cancel'         => time(),
									),
									admin_url( 'nav-menus.php' )
								)
							),
							$item_id,
							__( 'Cancel' )
						);
						?>
					</div>

					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		}


	} // Walker_Nav_Menu

}



/*-----------------------------------------------------------------------------------*/
# Modify the menu classes
/*-----------------------------------------------------------------------------------*/
add_filter( 'nav_menu_css_class', 'tie_special_current_nav_class', 10, 4 );
function tie_special_current_nav_class( $classes, $item, $args, $depth = 0 ) {

	// Return the default Classes if we are not in the top level or the mega menu is disabled
	if ( $depth != 0 || tie_get_option( 'disable_mega_menu' )) {
		return $classes;
	}


	// Highlight the primary category only
	if( is_single() && ! empty( $item->object ) && $item->object == 'category' && ! empty( $item->object_id ) ){

		$primary_id = tie_get_primary_category_id();

		if( $item->object_id != $primary_id ){
			return $classes;
		}
	}

	// Add custom class for the current menu item to use it in the CSS files
	$current_classes = array(
		'current-menu-item',
		'current-menu-parent',
		'current-menu-ancestor',
		'current_page_parent',
		'current-page-ancestor',
		'current-post-ancestor',
		'current-post-parent',
		'current-category-ancestor',
	);

  $current_classes = apply_filters( 'TieLabs/Mega_Menu/current_classes', $current_classes, $classes, $item, $args, $depth );

  if( ! empty( $current_classes ) && is_array( $current_classes ) ){
		foreach ( $classes as $class ){
			if( in_array( $class, $current_classes ) ) {

				$classes[] = 'tie-current-menu';
				break;
			}
		}
	}

	return $classes;
}

