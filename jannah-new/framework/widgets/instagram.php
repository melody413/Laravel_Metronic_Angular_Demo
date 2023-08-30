<?php

if( ! class_exists( 'TIE_INSTAGRAM_WIDGET' ) ) {

	/**
	 * Widget API: TIE_INSTAGRAM_WIDGET class
	 */
	 class TIE_INSTAGRAM_WIDGET extends WP_Widget {


		public function __construct(){
			parent::__construct( 'tie-instagram-theme', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Instagram', TIELABS_TEXTDOMAIN ) );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){


			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo ( $args['before_widget'] );

			if ( ! empty( $instance['title'] ) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			if( ! TIELABS_INSTAGRAM_FEED_IS_ACTIVE ){

				TIELABS_HELPER::notice_message( sprintf( esc_html__( 'You need to install the %s plugin to use this feature.', TIELABS_TEXTDOMAIN ), '<strong>TieLabs Instagram Feed</strong>' ) );
			}
			elseif( tielabs_instagram_feed_error() ){
				TIELABS_HELPER::notice_message( esc_html__( 'Error: Check the widget settings!', TIELABS_TEXTDOMAIN ) );
			}
			else{

				// Instagram feed
				$media_link   = ! empty( $instance['media_link'] )   ? $instance['media_link']   : 'file';
				$media_number = ! empty( $instance['media_number'] ) ? $instance['media_number'] : 9;
				$button_text  = ! empty( $instance['button_text'] )  ? $instance['button_text']  : '';
				$button_url   = ! empty( $instance['button_url'] )   ? $instance['button_url']   : tielabs_instagram_feed()->account->profile_url();
				$bio          = ! empty( $instance['bio'] )          ? $instance['bio']          : '';
				$name         = ! empty( $instance['name'] )         ? $instance['name']         : '';
				$avatar       = ! empty( $instance['avatar'] )       ? $instance['avatar']       : '';

				$atts = array(
					'number' => $media_number,
					'link'   => $media_link,
					'bio'    => $bio,
					'name'   => $name,
					'avatar' => $avatar,
				);

				tielabs_instagram_feed()->account->display( $atts );

				if( ! empty( $button_text ) ){?>
					<a target="_blank" rel="nofollow noopener" href="<?php echo esc_url( $button_url ) ?>" class="button fullwidth"><span class="tie-icon-instagram"></span> <?php echo esc_html( $button_text ); ?></a>
					<?php
				}
			}

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                 = $old_instance;
			$instance['title']        = sanitize_text_field( $new_instance['title'] );
			$instance['media_link']   = $new_instance['media_link'];
			$instance['name']         = $new_instance['name'];
			$instance['avatar']       = $new_instance['avatar'];
			$instance['media_number'] = $new_instance['media_number'];
			$instance['button_text']  = $new_instance['button_text'];
			$instance['button_url']   = $new_instance['button_url'];
			$instance['bio']          = $new_instance['bio'];
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' => esc_html__( 'Follow Us', TIELABS_TEXTDOMAIN), 'media_number' => 9, 'media_link' => 'file' );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title        = isset( $instance['title'] )        ? $instance['title']        : '';
			$media_link   = isset( $instance['media_link'] )   ? $instance['media_link']   : 'file';
			$name         = isset( $instance['name'] )         ? $instance['name']         : '';
			$avatar       = isset( $instance['avatar'] )       ? $instance['avatar']       : '';
			$media_number = isset( $instance['media_number'] ) ? $instance['media_number'] : 9;
			$button_text  = isset( $instance['button_text'] )  ? $instance['button_text']  : '';
			$button_url   = isset( $instance['button_url'] )   ? $instance['button_url']   : '';
			$bio          = isset( $instance['bio'] )          ? $instance['bio']          : '';

			$show_insta_settings = 'none';

			if( ! TIELABS_INSTAGRAM_FEED_IS_ACTIVE ){
				tie_build_theme_option(
					array(
						'text' => sprintf( esc_html__( 'You need to install the %s plugin to use this feature.', TIELABS_TEXTDOMAIN ), '<a href="'. admin_url('admin.php?page=tie-install-plugins') .'"><strong>TieLabs Instagram Feed</strong></a>' ),
						'type' => 'error',
					));
			}
			elseif( tielabs_instagram_feed_error() ){
				tie_build_theme_option(
					array(
						'text' => tielabs_instagram_feed_error(),
						'type' => 'error',
					));
			}
			elseif( ! tielabs_instagram_feed()->account->is_active() ){
				tie_build_theme_option(
					array(
						'text' => tielabs_instagram_feed()->helper->get_error('inactive'),
						'type' => 'message',
					));
			}
			elseif( tielabs_instagram_feed()->account->is_expired() ){
				tie_build_theme_option(
					array(
						'text' => tielabs_instagram_feed()->helper->get_error('expired'),
						'type' => 'error',
					));
			}
			else{
				$show_insta_settings = 'block';
			}

			?>
			<div style="display:<?php echo $show_insta_settings ?>">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php esc_html_e( 'Account Name', TIELABS_TEXTDOMAIN) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" value="<?php echo esc_attr( $name ); ?>" class="widefat" type="text" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>"><?php esc_html_e( 'Avatar Image', TIELABS_TEXTDOMAIN) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'avatar' ) ); ?>" value="<?php echo esc_attr( $avatar ); ?>" class="widefat" type="text" placeholder="https://" />
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'bio' ) ); ?>"><?php esc_html_e( 'Bio', TIELABS_TEXTDOMAIN) ?></label>
					<textarea rows="3" id="<?php echo esc_attr( $this->get_field_id( 'bio' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bio' ) ); ?>" class="widefat" ><?php echo esc_textarea( $bio ) ?></textarea>
				</p>


				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'media_link' ) ); ?>"><?php esc_html_e( 'Link Images to', TIELABS_TEXTDOMAIN) ?> *</label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'media_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'media_link' ) ); ?>" class="widefat">
						<option value="file" <?php selected( $media_link, 'file' ); ?>><?php esc_html_e( 'Media File', TIELABS_TEXTDOMAIN) ?></option>
						<option value="page" <?php selected( $media_link, 'page' ); ?>><?php esc_html_e( 'Media Page on Instagram', TIELABS_TEXTDOMAIN) ?></option>
					</select>
					<small>* <?php esc_html_e( 'Videos always linked to the Media Page on Instagram.', TIELABS_TEXTDOMAIN) ?></small>
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'media_number' ) ); ?>"><?php esc_html_e( 'Number of Media Items', TIELABS_TEXTDOMAIN) ?></label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'media_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'media_number' ) ); ?>" class="widefat">
						<option value="3" <?php selected( $media_number, 3 ); ?>><?php echo '3'; ?></option>
						<option value="6" <?php selected( $media_number, 6 ); ?>><?php echo '6'; ?></option>
						<option value="9" <?php selected( $media_number, 9 ); ?>><?php echo '9'; ?></option>
						<option value="12" <?php selected( $media_number, 12 ); ?>><?php echo '12'; ?></option>
						<option value="15" <?php selected( $media_number, 15 ); ?>><?php echo '15'; ?></option>
						<option value="18" <?php selected( $media_number, 18 ); ?>><?php echo '18'; ?></option>
					</select>
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Follow Us Button Text', TIELABS_TEXTDOMAIN) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" value="<?php echo esc_attr( $button_text ); ?>" class="widefat" type="text" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"><?php esc_html_e( 'Follow Us Button URL', TIELABS_TEXTDOMAIN) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_url' ) ); ?>" value="<?php echo esc_attr( $button_url ); ?>" class="widefat" type="text" placeholder="https://" />
				</p>
			</div>
		<?php

		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_instagram_widget_register' );
	function tie_instagram_widget_register(){
		register_widget( 'TIE_INSTAGRAM_WIDGET' );
	}

}
