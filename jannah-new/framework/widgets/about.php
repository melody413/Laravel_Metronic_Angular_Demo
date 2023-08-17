<?php

if( ! class_exists( 'TIE_ABOUT_WIDGET' ) ) {

	/**
	 * Widget API: TIE_ABOUT_WIDGET class
	 */
	 class TIE_ABOUT_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops 	= array( 'classname' => 'aboutme-widget' );
			parent::__construct( 'author-bio-widget', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'About', TIELABS_TEXTDOMAIN ) , $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$image_style = '';

			if( ! empty( $instance['margin_top'] ) || ! empty( $instance['margin_bottom'] ) || ! empty( $instance['width'] ) || ! empty( $instance['height'] ) ){

				$image_style = ' style="';

				// Margin top
				if( ! empty( $instance['margin_top'] ) ) {
					$image_style .= 'margin-top: ' .str_replace( 'px', '', $instance['margin_top'] ). 'px; ';
				}

				// Margin bottom
				if( ! empty( $instance['margin_bottom'] ) ) {
					$image_style .= 'margin-bottom: ' .str_replace( 'px', '', $instance['margin_bottom'] ). 'px;';
				}

				// Width
				if( ! empty( $instance['width'] ) ) {
					$image_style .= 'width: ' .str_replace( 'px', '', $instance['width'] ). 'px; ';
				}

				// Height
				if( ! empty( $instance['height'] ) ) {
					$image_style .= 'height: ' .str_replace( 'px', '', $instance['height'] ). 'px;';
				}

				$image_style .= '" ';
			}

			// Image
			$img = '';
			$img_class = 'about-author-img';

			if( ! empty( $instance['img'] ) ){

				$alt = ! empty( $instance['alt'] ) ? $instance['alt'] : $instance['title'];

				// WPML
				$instance['img'] = apply_filters( 'wpml_translate_single_string', $instance['img'], TIELABS_THEME_SLUG, 'widget_img_'.$this->id );

				if( tie_get_option( 'lazy_load' ) ){
					$src = 'src="'. tie_lazyload_placeholder('wide') .'" data-src="'. $instance['img'] .'"';
					$img_class .= ' lazy-img';
				}
				else{
					$src = 'src="'. $instance['img'] .'"';
				}

				$img = '<img alt="'. $alt .'" '. $src.$image_style .' class="'. $img_class .'" width="280" height="47">';
			}

			$text_code  = ! empty( $instance['text_code'] )  ? $instance['text_code'] : '';

			$custom_class  = 'about-author about-content-wrapper';
			$custom_class .= ( ! empty( $instance['circle'] ) && isset( $instance['img'] ) ) ? ' image-is-circle' : '';
			$custom_class .= ! empty( $instance['center'] ) ? ' is-centered' : '';


			// WPML
			$text_code = apply_filters( 'wpml_translate_single_string', $text_code, TIELABS_THEME_SLUG, 'widget_content_'.$this->id );


			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			echo '
				<div class="'. $custom_class .'">'.
					$img .'

					<div class="aboutme-widget-content">'.
						do_shortcode( $text_code ).'
					</div>
					<div class="clearfix"></div>
			';


				# Social Icons
				if( ! empty( $instance['social_icons'] ) ){
					tie_get_social( array(
						'before'	=> 	'<ul class="social-icons">',
						'after'		=> 	'</ul>'
					));
				}

					echo '
				</div><!-- .about-widget-content -->
			';

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                  = $old_instance;
			$instance['title']         = sanitize_text_field( $new_instance['title'] );
			$instance['img']           = $new_instance['img'];
			$instance['alt']           = $new_instance['alt'];
			$instance['text_code']     = $new_instance['text_code'];
			$instance['circle']        = ! empty( $new_instance['circle'] ) ? 'true' : 0;
			$instance['center']        = ! empty( $new_instance['center'] ) ? 'true' : 0;
			$instance['social_icons']  = ! empty( $new_instance['social_icons'] ) ? 'true' : 0;
			$instance['margin_top']    = $new_instance['margin_top'];
			$instance['margin_bottom'] = $new_instance['margin_bottom'];
			$instance['width']         = $new_instance['width'];
			$instance['height']        = $new_instance['height'];

			# WPML
			do_action( 'wpml_register_single_string', TIELABS_THEME_SLUG, 'widget_content_'.$this->id, $new_instance['text_code'] );

			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' =>esc_html__( 'About', TIELABS_TEXTDOMAIN) );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title         = isset( $instance['title'] )         ? $instance['title']         : '';
			$img           = isset( $instance['img'] )           ? $instance['img']           : '';
			$alt           = isset( $instance['alt'] )           ? $instance['alt']           : '';
			$text_code     = isset( $instance['text_code'] )     ? $instance['text_code']     : '';
			$circle        = isset( $instance['circle'] )        ? $instance['circle']        : '';
			$center        = isset( $instance['center'] )        ? $instance['center']        : '';
			$social_icons  = isset( $instance['social_icons'] )  ? $instance['social_icons']  : '';
			$margin_top    = isset( $instance['margin_top'] )    ? $instance['margin_top']    : '';
			$margin_bottom = isset( $instance['margin_bottom'] ) ? $instance['margin_bottom'] : '';
			$width         = isset( $instance['width'] )         ? $instance['width']         : '';
			$height        = isset( $instance['height'] )        ? $instance['height']        : '';

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ) ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr(  $this->get_field_id( 'img' ) ); ?>"><?php esc_html_e( 'Image URL', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr(  $this->get_field_id( 'img' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'img' ) ); ?>" value="<?php echo esc_attr( $img ) ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr(  $this->get_field_id( 'alt' ) ); ?>"><?php esc_html_e( 'Image Alt text', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr(  $this->get_field_id( 'alt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'alt' ) ); ?>" value="<?php echo esc_attr( $alt ) ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr(  $this->get_field_id( 'width' ) ); ?>"><?php esc_html_e( 'Image Width', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr(  $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" value="<?php echo esc_attr( $width ) ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr(  $this->get_field_id( 'height' ) ); ?>"><?php esc_html_e( 'Image Height', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr(  $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" value="<?php echo esc_attr( $height ) ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr(  $this->get_field_id( 'margin_top' ) ); ?>"><?php esc_html_e( 'Image Margin Top', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr(  $this->get_field_id( 'margin_top' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'margin_top' ) ); ?>" value="<?php echo esc_attr( $margin_top ) ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr(  $this->get_field_id( 'margin_bottom' ) ); ?>"><?php esc_html_e( 'Image Margin Bottom', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr(  $this->get_field_id( 'margin_bottom' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'margin_bottom' ) ); ?>" value="<?php echo esc_attr( $margin_bottom ) ?>" class="widefat" type="text" />
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'circle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'circle' ) ); ?>" value="true" <?php checked( $circle, 'true' ) ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'circle' ) ); ?>"><?php esc_html_e( 'Circle Shape?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text_code' ) ); ?>"><?php esc_html_e( 'Text', TIELABS_TEXTDOMAIN) ?><i></i></label>
				<textarea rows="5" id="<?php echo esc_attr( $this->get_field_id( 'text_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_code' ) ); ?>" class="widefat" ><?php echo esc_textarea( $text_code ) ?></textarea>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'center' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'center' ) ); ?>" value="true" <?php checked( $center, 'true' ) ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'center' ) ); ?>"><?php esc_html_e( 'Center the content?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'social_icons' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_icons' ) ); ?>" value="true" <?php checked( $social_icons, 'true' ) ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'social_icons' ) ); ?>"><?php esc_html_e( 'Show Social Icons?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

		<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_about_widget_register' );
	function tie_about_widget_register(){
		register_widget( 'TIE_ABOUT_WIDGET' );
	}

}
