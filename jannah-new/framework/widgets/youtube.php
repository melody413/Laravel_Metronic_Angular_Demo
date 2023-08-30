<?php

if( ! class_exists( 'TIE_YOUTUBE_WIDGET' ) ) {

	/**
	 * Widget API: TIE_YOUTUBE_WIDGET class
	 */
	 class TIE_YOUTUBE_WIDGET extends WP_Widget {


		public function __construct(){
			parent::__construct( 'youtube-widget', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'YouTube', TIELABS_TEXTDOMAIN ) );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			//YouTube Widget
			if( ! empty( $instance['page_url'] ) ){

				wp_enqueue_script( 'tie-google-platform-js', '//apis.google.com/js/platform.js' );

				// Check if it is a channel or a user account
				if ( strpos( $instance['page_url'], 'UC' ) === 0 ){
					$source = 'channelid';
				}
				else{
					$source = 'channel';
				}


				echo '
					<div class="youtube-box tie-ignore-fitvid">
						<div class="g-ytsubscribe" data-'.$source.'="' .$instance['page_url']. '" data-layout="full" data-count="default"></div>
					</div>
				';
			}

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance             = $old_instance;
			$instance['title']    = sanitize_text_field( $new_instance['title'] );
			$instance['page_url'] = $new_instance['page_url'];
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' =>esc_html__( 'Subscribe to our channel', TIELABS_TEXTDOMAIN) );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title    = isset( $instance['title'] )    ? $instance['title'] : '';
			$page_url = isset( $instance['page_url'] ) ? $instance['page_url'] : '';

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ) ?>" class="widefat" type="text" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ) ?>"><?php esc_html_e( 'Channel Name or ID:', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ) ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_url' ) ) ?>" value="<?php echo esc_attr( $page_url ) ?>" class="widefat" type="text" />
				<small><a href="<?php echo esc_url( 'https://www.youtube.com/account_advanced' ); ?>" target="_blank" rel="nofollow noopener"><?php esc_html_e( 'Get it from your account advanced page.', TIELABS_TEXTDOMAIN) ?></a></small>
			</p>

		<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_youtube_widget_register' );
	function tie_youtube_widget_register(){
		register_widget( 'TIE_YOUTUBE_WIDGET' );
	}

}
?>
