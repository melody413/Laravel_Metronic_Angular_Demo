<?php

if( ! class_exists( 'TIE_CATEGORIES_WIDGET' ) ) {

	/**
	 * Widget API: TIE_CATEGORIES_WIDGET class
	 */
	 class TIE_CATEGORIES_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops = array( 'classname' => 'widget_categories tie-widget-categories'  );
			parent::__construct( 'tie-widget-categories', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Categories', TIELABS_TEXTDOMAIN), $widget_ops );
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

			$depth = empty( $instance['depth'] ) ? 1 : 0;

			$categories = wp_list_categories( apply_filters( 'TieLabs/Widgets/Categories/args', array(
				'echo'       => false,
				'title_li'   => 0,
				'show_count' => 1,
				'depth'      => $depth,
				'orderby'    => 'count',
				'order'      => 'DESC',
			)));

			$categories = str_replace( 'cat-item-', 'cat-counter tie-cat-item-', $categories );
			//$categories = preg_replace( '~\((\d+)\)(?=\s*+<)~', '<span>$1</span>', $categories );
			$categories = preg_replace( '~\((.*?)\)~', '<span>$1</span>', $categories );

			echo "<ul>$categories</ul>";

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance          = $old_instance;
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
			$instance['depth'] = ! empty( $new_instance['depth'] ) ? 'true' : 0;
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' => esc_html__('Categories', TIELABS_TEXTDOMAIN)  );
			$instance = wp_parse_args( (array) $instance, $defaults );
			$title    = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$depth    = ! empty( $instance['depth'] ) ? $instance['depth'] : ''; ?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'depth' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'depth' ) ); ?>" value="true" <?php checked( $depth, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'depth' ) ); ?>"><?php esc_html_e( 'Show child categories?', TIELABS_TEXTDOMAIN) ?></label>
			</p>
		<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_categories_widget_register' );
	function tie_categories_widget_register(){
		register_widget( 'TIE_CATEGORIES_WIDGET' );
	}

}
