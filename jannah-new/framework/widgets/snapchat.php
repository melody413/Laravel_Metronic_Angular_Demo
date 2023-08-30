<?php

if( ! class_exists( 'TIE_SNAPCHAT_WIDGET' ) ) {

	/**
	 * Widget API: TIE_SNAPCHAT_WIDGET class
	 */
	 class TIE_SNAPCHAT_WIDGET extends WP_Widget {


		public function __construct(){
			parent::__construct( 'tie-snapchat-theme', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Snapchat', TIELABS_TEXTDOMAIN ) );
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

			if( ! empty( $instance['username'] ) && ! empty( $instance['userid'] ) && ! empty( $instance['avatar'] ) ){
				$avatar_size = ! empty( $instance['avatar_size'] ) ? 'background-size:'. $instance['avatar_size'] .'px;' : '';
				$class       = ! empty( $instance['style'] )       ? 'is-' . $instance['style'] : 'is-rounded';
				$userid      = str_replace( '@', '', $instance['userid'] );

				?>

				<div class="tie-snapchat-badge-wrap">
					<a href="https://snapchat.com/add/<?php echo $userid ?>" rel="external noopener nofollow">
						<span class="tie-snapchat-badge <?php echo $class ?>" style="background-image: url(<?php echo esc_attr( $instance['avatar'] ) ?>); <?php echo $avatar_size ?>">
							<img src="<?php echo TIELABS_TEMPLATE_URL .'/assets/images/snapchat-flat-widget.png' ?>" loading="lazy" alt="<?php echo $instance['username'] ?>" />
						</span>

						<span class="snapchat-username"><?php echo $instance['username'] ?></span>
						<span class="snapchat-userid">@<?php echo $userid ?></span>
					</a>
				</div>
				<?php
			}
			else{
				TIELABS_HELPER::notice_message( esc_html__( 'Enter the required account info.', TIELABS_TEXTDOMAIN ) );
			}



			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                = $old_instance;
			$instance['title']       = sanitize_text_field( $new_instance['title'] );
			$instance['username']    = $new_instance['username'];
			$instance['userid']      = $new_instance['userid'];
			$instance['avatar']      = $new_instance['avatar'];
			$instance['avatar_size'] = $new_instance['avatar_size'];
			$instance['style']       = $new_instance['style'];

			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' => esc_html__( 'Follow me', TIELABS_TEXTDOMAIN ) );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title        = isset( $instance['title'] )        ? $instance['title']       : '';
			$username     = isset( $instance['username'] )     ? $instance['username']    : '';
			$userid       = isset( $instance['userid'] )       ? $instance['userid']      : '';
			$avatar       = isset( $instance['avatar'] )       ? $instance['avatar']      : '';
			$avatar_size  = isset( $instance['avatar_size'] )  ? $instance['avatar_size'] : '';
			$style        = isset( $instance['style'] )        ? $instance['style']       : 'rounded';

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Account Name', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" value="<?php echo esc_attr( $username ); ?>" class="widefat" type="text" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'userid' ) ); ?>"><?php esc_html_e( 'ID', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'userid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'userid' ) ); ?>" value="<?php echo esc_attr( $userid ); ?>" class="widefat" type="text" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>"><?php esc_html_e( 'Avatar Image', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'avatar' ) ); ?>" value="<?php echo esc_attr( $avatar ); ?>" class="widefat" type="text" placeholder="https://" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'avatar_size' ) ); ?>"><?php esc_html_e( 'Avatar size (px)', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'avatar_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'avatar_size' ) ); ?>" value="<?php echo esc_attr( $avatar_size ); ?>" class="widefat" type="number" placeholder="" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'Style', TIELABS_TEXTDOMAIN) ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" class="widefat">
					<option value="rounded" <?php selected( $style, 'rounded' ); ?>><?php esc_html_e( 'Rounded', TIELABS_TEXTDOMAIN) ?></option>
					<option value="circle" <?php selected( $style, 'circle' ); ?>><?php esc_html_e( 'Circle', TIELABS_TEXTDOMAIN) ?></option>
				</select>
			</p>
		<?php

		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_snapchat_widget_register' );
	function tie_snapchat_widget_register(){
		register_widget( 'TIE_SNAPCHAT_WIDGET' );
	}

}
