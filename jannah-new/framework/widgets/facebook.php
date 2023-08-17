<?php

if( ! class_exists( 'TIE_FACEBOOK_WIDGET' ) ) {

	/**
	 * Widget API: TIE_FACEBOOK_WIDGET class
	 */
	 class TIE_FACEBOOK_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops 	= array( 'classname' => 'facebook-widget' );
			$control_ops 	= array( 'id_base' => 'facebook-widget' );
			parent::__construct( 'facebook-widget', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Facebook', TIELABS_TEXTDOMAIN ), $widget_ops, $control_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$hide_cover  = ! empty( $instance['hide_cover'] )  ? $instance['hide_cover']  : '';
			$show_faces  = ! empty( $instance['show_faces'] )  ? $instance['show_faces']  : '';
			$show_stream = ! empty( $instance['show_stream'] ) ? $instance['show_stream'] : '';

			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			if( ! empty( $instance['page_url'] ) ){

				$lang = get_locale();

				$instance['page_url'] = str_replace( 'https://', 'http://', $instance['page_url'] );

				?>
					<div id="fb-root"></div>


					<script data-cfasync="false">(function(d, s, id){
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/<?php echo esc_attr($lang)?>/sdk.js#xfbml=1&version=v3.2";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
					<div class="fb-page" data-href="<?php echo esc_url( $instance['page_url'] ) ?>" data-hide-cover="<?php echo ( $hide_cover == 'true'?'true':'false' ) ?>" data-show-facepile="<?php echo ( $show_faces == 'true'?'true':'false') ?>" data-show-posts="<?php echo ($show_stream == 'true'?'true':'false' ) ?>" data-adapt-container-width="true">
						<div class="fb-xfbml-parse-ignore"><a href="<?php echo esc_url($instance['page_url']) ?>"><?php echo esc_html__( 'Find us on Facebook', TIELABS_TEXTDOMAIN); ?></a></div>
					</div>

				<?php
			}

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                = $old_instance;
			$instance['title']       = sanitize_text_field( $new_instance['title'] );
			$instance['page_url']    = $new_instance['page_url'];
			$instance['hide_cover']  = ! empty( $new_instance['hide_cover'] )  ? 'true' : false;
			$instance['show_faces']  = ! empty( $new_instance['show_faces'] )  ? 'true' : false;
			$instance['show_stream'] = ! empty( $new_instance['show_stream'] ) ? 'true' : false;
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){

			$defaults = array( 'title' => esc_html__( 'Find us on Facebook', TIELABS_TEXTDOMAIN) );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title       = isset( $instance['title'] )       ? $instance['title']       : '';
			$page_url    = isset( $instance['page_url'] )    ? $instance['page_url']    : '';
			$hide_cover  = isset( $instance['hide_cover'] )  ? $instance['hide_cover']  : '';
			$show_faces  = isset( $instance['show_faces'] )  ? $instance['show_faces']  : '';
			$show_stream = isset( $instance['show_stream'] ) ? $instance['show_stream'] : '';

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>"><?php esc_html_e( 'Page URL:', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'page_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_url' ) ); ?>" value="<?php echo esc_attr( $page_url ); ?>" class="widefat" placeholder="https://www.facebook.com/your-page" type="text" />
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_cover' ) ); ?>" value="true" <?php checked( $hide_cover, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>"><?php esc_html_e( 'Hide cover Photo?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_faces' ) ); ?>" value="true" <?php checked( $show_faces, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>"><?php esc_html_e( 'Show Faces?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'show_stream' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_stream' ) ); ?>" value="true" <?php checked( $show_stream, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_stream' ) ); ?>"><?php esc_html_e( 'Show Stream?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

		<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_facebook_widget_register' );
	function tie_facebook_widget_register(){
		register_widget( 'TIE_FACEBOOK_WIDGET' );
	}

}
