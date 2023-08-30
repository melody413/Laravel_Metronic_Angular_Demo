<?php

if( ! class_exists( 'TIE_SOCIAL_WIDGET' ) ) {

	/**
	 * Widget API: TIE_SOCIAL_WIDGET class
	 */
	 class TIE_SOCIAL_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops = array( 'classname' => 'social-icons-widget' );
			parent::__construct( 'social', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Social Icons', TIELABS_TEXTDOMAIN) , $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$custom_class = ! empty( $instance['center'] ) ? ' is-centered' : '';


			if( empty( $instance['tran_bg'] ) ){

				echo ( $args['before_widget'] );

				if ( ! empty($instance['title']) ){
					echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
				}

				tie_get_social( array( 'before' => '<ul class="solid-social-icons'. $custom_class .'">' ) );
				echo '<div class="clearfix"></div>';

				echo ( $args['after_widget'] );

			}
			else{
				echo '<div class="widget social-icons-widget widget-content-only">';
				tie_get_social( array( 'before' => '<ul class="solid-social-icons'. $custom_class .'">' ) );
				echo '<div class="clearfix"></div></div>';
			}

		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance = $old_instance;
			$instance['title']   = strip_tags( $new_instance['title'] );
			$instance['tran_bg'] = ! empty( $new_instance['tran_bg'] ) ? 'true' : 0;
			$instance['center']  = ! empty( $new_instance['center'] )  ? 'true' : 0;

			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' => 'Social'  );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title   = isset( $instance['title'] )   ? $instance['title']   : '';
			$tran_bg = isset( $instance['tran_bg'] ) ? $instance['tran_bg'] : '';
			$center  = isset( $instance['center'] )  ? $instance['center']  : '';
		?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ) ?>" class="widefat" type="text" />
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'tran_bg' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tran_bg' ) ); ?>" value="true" <?php checked( $tran_bg, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'tran_bg' ) ); ?>"><?php esc_html_e( 'Show the social icons only?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'center' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'center' ) ); ?>" value="true" <?php checked( $center, 'true' ) ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'center' ) ); ?>"><?php esc_html_e( 'Center the content?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

		  <?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_social_widget_register' );
	function tie_social_widget_register(){
		register_widget( 'TIE_SOCIAL_WIDGET' );
	}

}
