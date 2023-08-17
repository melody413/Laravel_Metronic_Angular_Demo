<?php

if( ! class_exists( 'TIE_COMMENTS_AVATAR' ) ) {

	/**
	 * Widget API: TIE_COMMENTS_AVATAR class
	 */
	 class TIE_COMMENTS_AVATAR extends WP_Widget {


		public function __construct(){
			$widget_ops 	= array( 'classname' => 'recent-comments-widget' );
			$control_ops 	= array( 'id_base'   => 'comments_avatar-widget' );
			parent::__construct( 'comments_avatar-widget', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Recent Comments with avatar', TIELABS_TEXTDOMAIN ) , $widget_ops, $control_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$no_of_comments = ! empty( $instance['no_of_comments'] ) ? $instance['no_of_comments'] : 5;

			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			echo '<ul>';

			tie_recent_comments( $no_of_comments );

			echo '</ul>';

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                   = $old_instance;
			$instance['title']          = sanitize_text_field( $new_instance['title'] );
			$instance['no_of_comments'] = $new_instance['no_of_comments'];
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' => esc_html__( 'Recent Comments', TIELABS_TEXTDOMAIN ), 'no_of_comments' => 5 );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title    = isset( $instance['title'] ) ? $instance['title'] : '';
			$no_of_comments = isset( $instance['no_of_comments'] ) ? $instance['no_of_comments'] : 5;

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ) ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'no_of_comments' ) ); ?>"><?php esc_html_e( 'Number of comments to show:', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'no_of_comments' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no_of_comments' ) ); ?>" value="<?php echo esc_attr( $no_of_comments ) ?>" type="number" step="1" min="1" size="3" class="tiny-text" />
			</p>

		<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_comments_avatar_register' );
	function tie_comments_avatar_register(){
		register_widget( 'TIE_COMMENTS_AVATAR' );
	}

}
