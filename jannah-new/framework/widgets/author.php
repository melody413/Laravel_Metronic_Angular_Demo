<?php

if( ! class_exists( 'TIE_ABOUT_AUTHOR_WIDGET' ) ) {

	/**
	 * Widget API: TIE_ABOUT_AUTHOR_WIDGET class
	 */
	 class TIE_ABOUT_AUTHOR_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops = array( 'classname' => 'widget_author' );
			parent::__construct( 'author_widget', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'About the post&rsquo;s author' , TIELABS_TEXTDOMAIN ) , $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			if ( ! is_single() ){
				return;
			}

			// Get the Authors IDs | Co Author Plus Support
			$post_authors  = tie_get_post_authors();
			$authors_count = count( $post_authors );

			$title = ( $authors_count > 1 ) ? esc_html__( 'Authors', TIELABS_TEXTDOMAIN ) : $post_authors[0]->display_name;
			$class = ( $authors_count > 1 ) ? 'multiple-authors' : 'single-author';

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', sprintf( esc_html__( 'About %s', TIELABS_TEXTDOMAIN ), $title ), $instance, $this->id_base );

			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			if ( is_array( $post_authors ) && ! empty( $post_authors ) ) {

				echo '<div class="'. $class .'">';
					foreach ( $post_authors as $author ) {
						tie_author_box( $author, $class );
					}
				echo '</div>';
			}


			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			return;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			echo '<p class="tie-message-hint">'. esc_html__( 'This Widget appears in the single post page only.', TIELABS_TEXTDOMAIN) .'</p>';
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_about_author_widget_register' );
	function tie_about_author_widget_register(){
		register_widget( 'TIE_ABOUT_AUTHOR_WIDGET' );
	}

}





if( ! class_exists( 'TIE_AUTHOR_POSTS_WIDGET' ) ) {

	/**
	 * Widget API: TIE_Author_Posts_Widget class
	 */
	 class TIE_AUTHOR_POSTS_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops = array( 'classname' => 'widget_author_posts'  );
			parent::__construct( 'author_post_widget', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( "Posts By Post's Author" , TIELABS_TEXTDOMAIN ), $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			if ( ! is_single() ){
				return;
			}

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', sprintf( esc_html__( 'By %s', TIELABS_TEXTDOMAIN ), get_the_author() ) , $instance, $this->id_base );

			$author_id   = get_the_author_meta( 'ID' );
			$no_of_posts = ! empty( $instance['no_of_posts'] ) ? $instance['no_of_posts'] : 5;

			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			echo '<ul class="widget-posts-list">';

			tie_widget_posts( array( 'number' => $no_of_posts, 'author' => $author_id ));

			echo '</ul>';


			if( $instance['see_all'] ){
				echo '<a class="button dark-btn fullwidth" href="'. get_author_posts_url( $author_id ). '">'. esc_html__( 'All', TIELABS_TEXTDOMAIN ) .' ('. TIELABS_WP_HELPER::count_user_posts( $author_id ) .')</a>';
			}

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                = $old_instance;
			$instance['no_of_posts'] = $new_instance['no_of_posts'];
			$instance['see_all']     = ! empty( $new_instance['see_all'] ) ? 'true' : 0;
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){

			$no_of_posts = isset( $instance['no_of_posts'] ) ? $instance['no_of_posts'] : 5;
			$see_all     = isset( $instance['see_all'] )     ? $instance['see_all']     : '';

			echo '<p class="tie-message-hint">'. esc_html__( 'This Widget appears in the single post page only.', TIELABS_TEXTDOMAIN) .'</p>';
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'no_of_posts' ) ); ?>"><?php esc_html_e( 'Number of posts to show', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'no_of_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no_of_posts' ) ); ?>" value="<?php echo esc_attr( $no_of_posts ) ?>" type="text" size="3" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'see_all' ) ); ?>"><?php esc_html_e( 'Display (All) link:', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'see_all' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'see_all' ) ); ?>" value="true" <?php checked( $see_all, 'true' ); ?> type="checkbox" />
			</p>
			<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_author_posts_widget_register' );
	function tie_author_posts_widget_register(){
		register_widget( 'TIE_Author_Posts_Widget' );
	}

}



if( ! class_exists( 'TIE_AUTHOR_CUSTOM_WIDGET' ) ) {

	/**
	 * Widget API: TIE_AUTHOR_CUSTOM_WIDGET class
	 */
	 class TIE_AUTHOR_CUSTOM_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops 	= array( 'classname' => 'author-custom'  );
			$control_ops 	= array( 'id_base' => 'author-custom-widget' );
			parent::__construct( 'author-custom-widget', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( "Custom Author Content" , TIELABS_TEXTDOMAIN ) , $widget_ops, $control_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			if ( ! is_single() || ( is_single() && ! get_the_author_meta( 'author_widget_content' )) ) {
				return;
			}

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$center = ! empty( $instance['center'] ) ? ' style="text-align:center;"' : '';

			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}


			$text_code = get_the_author_meta( 'author_widget_content' );

			echo '
				<div '.$center.'>'.
					do_shortcode( $text_code ) .'
				</div>
				<div class="clearfix"></div>
			';

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance            = $old_instance;
			$instance['title']   = sanitize_text_field( $new_instance['title'] );
			$instance['center']  = ! empty( $new_instance['center'] ) ? 'true' : 0;
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){

			$title   = isset( $instance['title'] )  ? esc_attr( $instance['title'])  : '';
			$center  = isset( $instance['center'] ) ? esc_attr( $instance['center']) : '';

			echo '<p class="tie-message-hint">'. esc_html__( 'This Widget appears in the single post page only.', TIELABS_TEXTDOMAIN) .'</p>';
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'center' ) ); ?>"><?php esc_html_e( 'Center content:', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'center' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'center' ) ); ?>" value="true" <?php checked( $center, 'true' ) ?> type="checkbox" />
			</p>
			<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_author_custom_widget_register' );
	function tie_author_custom_widget_register(){
		register_widget( 'TIE_AUTHOR_CUSTOM_WIDGET' );
	}

}
