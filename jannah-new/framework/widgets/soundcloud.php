<?php

if( ! class_exists( 'TIE_SOUNDCLOUD_WIDGET' ) ) {

	/**
	 * Widget API: TIE_SOUNDCLOUD_WIDGET class
	 */
	 class TIE_SOUNDCLOUD_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops 	= array( 'classname' => 'soundcloud-widget'  );
			parent::__construct( 'tie-soundcloud-widget', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'SoundCloud', TIELABS_TEXTDOMAIN) , $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			// Get the widget settings
			$url  = ! empty( $instance['url'] )      ? $instance['url'] : '';
			$play = ! empty( $instance['autoplay'] ) ? 'true' : 'false';

			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			echo tie_soundcloud( $url, $play, true );

			echo ( $args['after_widget'] );

		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){

			$instance = $old_instance;
			$instance['title']    = strip_tags( $new_instance['title'] );
			$instance['url']      = ! empty( $new_instance['url'] )      ? $new_instance['url']      : false;
			$instance['autoplay'] = ! empty( $new_instance['autoplay'] ) ? $new_instance['autoplay'] : false;
			return $instance;

		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' => esc_html__( 'SoundCloud', TIELABS_TEXTDOMAIN ) );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title    = ! empty( $instance['title'] )    ? $instance['title'] : '';
			$url      = ! empty( $instance['url'] )      ? $instance['url'] : '';
			$autoplay = ! empty( $instance['autoplay'] ) ? $instance['autoplay'] : ''; ?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ) ?>" class="widefat" type="text" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_html_e( 'URL', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" value="<?php echo esc_attr( $url ) ?>" type="text" class="widefat" />
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'autoplay' ) ); ?>" value="true" <?php checked( $autoplay, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>"><?php esc_html_e( 'Autoplay?', TIELABS_TEXTDOMAIN) ?></label>
			</p>
		  <?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_soundcloud_widget_register' );
	function tie_soundcloud_widget_register(){
		register_widget( 'TIE_SOUNDCLOUD_WIDGET' );
	}

}
