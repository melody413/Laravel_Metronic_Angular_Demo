<?php

if( ! class_exists( 'TIE_ADS125_WIDGET' ) ) {

	/**
	 * Widget API: TIE_ADS125_WIDGET class
	 */
	 class TIE_ADS125_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops  = array( 'classname' => 'stream-item-125-widget' );
			parent::__construct( 'stream-item-125-widget', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Ads 125 x 125', TIELABS_TEXTDOMAIN ) , $widget_ops );	}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			// Check if the banner is disabled
			if( ! TIELABS_HELPER::has_builder() && tie_get_postdata( 'tie_disable_all_ads' ) ){
				return;
			}

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$new_window = ! empty( $instance['new_window'] ) ? ' target="_blank"' : '';
			$nofollow   = ! empty( $instance['nofollow'] )   ? ' rel="nofollow noopener"' : '';

			if( ! empty( $instance['tran_bg'] ) ) {
				$args['before_widget'] = '<div id="'. $args['widget_id'] .'" class="widget stream-item-125-widget widget-content-only">';
				$args['after_widget']  = '</div>';
				$instance['title']     = '';
			}


			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			echo '<ul>';

			for($i=1 ; $i<11 ; $i++ ){

				if( ! empty( $instance['e3lan'.$i.'_code'] ) ) {
					echo'<li>';
					echo do_shortcode( apply_filters( 'TieLabs/Ad_widget/code', $instance['e3lan'.$i.'_code'] ) );
					echo '</li>';
				}

				elseif( ! empty( $instance['e3lan'.$i.'_img'] ) ) {
					echo '<li>';
					if( ! empty( $instance['e3lan'.$i.'_url'] ) ) {

						$url = apply_filters( 'TieLabs/ads_url', $instance['e3lan'.$i.'_url'] );
						echo '<a href="'. esc_url( $url ) .'"'. $new_window . $nofollow .'>';
					}

					echo apply_filters( 'TieLabs/Ad_widget/image', '<img class="widget-ad-image" src="'. $instance['e3lan'.$i.'_img'] .'" width="125" height="125" alt="">', $instance['e3lan'.$i.'_img'] );

					if( ! empty( $instance['e3lan'.$i.'_url'] ) ) {
						echo '</a>';
					}
				echo '</li>';
				}
			}

			echo '</ul>';

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance               = $old_instance;
			$instance['title']      = sanitize_text_field( $new_instance['title'] );

			$instance['tran_bg']    = ! empty( $new_instance['tran_bg'] )    ? 'true' : false;
			$instance['new_window'] = ! empty( $new_instance['new_window'] ) ? 'true' : false;
			$instance['nofollow']   = ! empty( $new_instance['nofollow'] )   ? 'true' : false;

			for($i=1 ; $i<11 ; $i++ ){
				$instance['e3lan'.$i.'_img']  = $new_instance['e3lan'.$i.'_img'];
				$instance['e3lan'.$i.'_url']  = $new_instance['e3lan'.$i.'_url'];
				$instance['e3lan'.$i.'_code'] = $new_instance['e3lan'.$i.'_code'];
			}

			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' =>esc_html__( 'Advertisement', TIELABS_TEXTDOMAIN) );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title      = isset( $instance['title'] )      ? $instance['title']      : '';
			$tran_bg    = isset( $instance['tran_bg'] )    ? $instance['tran_bg']    : '';
			$new_window = isset( $instance['new_window'] ) ? $instance['new_window'] : '';
			$nofollow   = isset( $instance['nofollow'] )   ? $instance['nofollow']   : '';

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'tran_bg' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tran_bg' ) ); ?>" value="true" <?php checked( $tran_bg, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'tran_bg' ) ); ?>"><?php esc_html_e( 'Show the ads only?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'new_window' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'new_window' ) ); ?>" value="true" <?php checked( $new_window, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'new_window' ) ); ?>"><?php esc_html_e( 'Open links in a new window?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'nofollow' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'nofollow' ) ); ?>" value="true" <?php checked( $nofollow, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'nofollow' ) ); ?>"><?php esc_html_e( 'Nofollow?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<?php

			for($i=1 ; $i<11 ; $i++ ){ ?>
				<strong class="tie-widget-sub-title"><?php printf( esc_html__( 'Ad #%s', TIELABS_TEXTDOMAIN), $i ) ?></strong>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'e3lan'.$i.'_img' ) ); ?>"><?php esc_html_e( 'Image path:', TIELABS_TEXTDOMAIN ) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'e3lan'.$i.'_img' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'e3lan'.$i.'_img' ) ); ?>" value="<?php if( ! empty( $instance['e3lan'.$i.'_img'] ) ) echo esc_attr( $instance['e3lan'.$i.'_img'] ); ?>" placeholder="http://" class="widefat" type="text" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'e3lan'.$i.'_url' ) ); ?>"><?php esc_html_e( 'Ad URL', TIELABS_TEXTDOMAIN ) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'e3lan'.$i.'_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'e3lan'.$i.'_url' ) ); ?>" value="<?php if( ! empty( $instance['e3lan'.$i.'_url'] ) ) echo esc_attr( $instance['e3lan'.$i.'_url'] ); ?>" placeholder="http://" class="widefat" type="text" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'e3lan'.$i.'_code' ) ); ?>"><strong><?php esc_html_e( '- OR -', TIELABS_TEXTDOMAIN) ?></strong> <?php esc_html_e( 'Code:', TIELABS_TEXTDOMAIN ) ?></label>
					<textarea id="<?php echo esc_attr( $this->get_field_id( 'e3lan'.$i.'_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'e3lan'.$i.'_code' ) ); ?>" class="widefat" rows="5"><?php if( ! empty( $instance['e3lan'.$i.'_code'] ) ) echo esc_attr( $instance['e3lan'.$i.'_code'] ); ?></textarea>
				</p>
				<?php
			}
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_ads125_widget_register' );
	function tie_ads125_widget_register(){
		register_widget( 'TIE_ADS125_WIDGET' );
	}

}




if( ! class_exists( 'TIE_AD_WIDGET' ) ) {

	/**
	 * Widget API: TIE_AD_WIDGET class
	 */
	 class TIE_AD_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops  = array( 'classname' => 'stream-item-widget' );
			parent::__construct( 'stream-item-widget', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Ad', TIELABS_TEXTDOMAIN ) , $widget_ops );	}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			// Check if the banner is disabled
			if( ! TIELABS_HELPER::has_builder() && tie_get_postdata( 'tie_disable_all_ads' ) ){
				return;
			}

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$new_window = ! empty( $instance['new_window'] ) ? ' target="_blank"' : '';
			$nofollow   = ! empty( $instance['nofollow'] )   ? ' rel="nofollow noopener"' : '';
			$alt_text   = ! empty( $instance['e3lan_alt'] )  ? $instance['e3lan_alt'] : '';

			$width  = ! empty( $instance['e3lan_img_width'] )  ? $instance['e3lan_img_width']  : '336';
			$height = ! empty( $instance['e3lan_img_height'] ) ? $instance['e3lan_img_height'] : '280';

			if( ! empty( $instance['tran_bg'] ) ) {
				$args['before_widget'] = '<div id="'. $args['widget_id'] .'" class="widget stream-item-widget widget-content-only">';
				$args['after_widget']  = '</div>';
				$instance['title']     = '';
			}


			echo ( $args['before_widget'] );

			if ( ! empty($instance['title']) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			echo '<div class="stream-item-widget-content">';

			# Ad Title
			if( ! empty( $instance['e3lan_title'] ) ){

				echo ! empty( $instance['e3lan_title_link'] ) ? '<a title="'. esc_attr( $instance['e3lan_title'] ) .'" href="'. esc_attr( $instance['e3lan_title_link'] ) .'" rel="nofollow noopener" target="_blank" class="stream-title">' : '<span class="stream-title">';
				echo $instance['e3lan_title'];
				echo ! empty( $instance['e3lan_title_link'] ) ? '</a>' : '</span>';
			}


			if( ! empty( $instance['e3lan_code'] ) ) {
				echo do_shortcode( apply_filters( 'TieLabs/Ad_widget/code', $instance['e3lan_code'] ) );
			}

			elseif( ! empty( $instance['e3lan_img'] ) ) {
				if( ! empty( $instance['e3lan_url'] ) ) {

					$url = apply_filters( 'TieLabs/ads_url', $instance['e3lan_url'] );
					echo '<a href="'. esc_url( $url ) .'"'. $new_window . $nofollow .'>';
				}

				echo apply_filters( 'TieLabs/Ad_widget/image', '<img class="widget-ad-image" src="'. $instance['e3lan_img'] .'" width="'. esc_attr( $width ).'" height="'. esc_attr( $height ).'" alt="'. $alt_text .'">', $instance['e3lan_img'] );

				if( ! empty( $instance['e3lan_url'] ) ) {
					echo '</a>';
				}
			}

			echo '</div>';

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance               = $old_instance;
			$instance['title']      = sanitize_text_field( $new_instance['title'] );

			$instance['tran_bg']    = ! empty( $new_instance['tran_bg'] ) ?    'true' : false;
			$instance['new_window'] = ! empty( $new_instance['new_window'] ) ? 'true' : false;
			$instance['nofollow']   = ! empty( $new_instance['nofollow'] ) ?   'true' : false;

			$instance['e3lan_img']  = $new_instance['e3lan_img'];
			$instance['e3lan_alt']  = $new_instance['e3lan_alt'];
			$instance['e3lan_url']  = $new_instance['e3lan_url'];
			$instance['e3lan_code'] = $new_instance['e3lan_code'];

			$instance['e3lan_title']      = $new_instance['e3lan_title'];
			$instance['e3lan_title_link'] = $new_instance['e3lan_title_link'];

			$instance['e3lan_img_height'] = $new_instance['e3lan_img_height'];
			$instance['e3lan_img_width']  = $new_instance['e3lan_img_width'];

			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' =>esc_html__( 'Advertisement', TIELABS_TEXTDOMAIN) );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title      = isset( $instance['title'] ) ?      esc_attr( $instance['title'] )      : '';
			$tran_bg    = isset( $instance['tran_bg'] ) ?    esc_attr( $instance['tran_bg'] )    : '';
			$new_window = isset( $instance['new_window'] ) ? esc_attr( $instance['new_window'] ) : '';
			$nofollow   = isset( $instance['nofollow'] ) ?   esc_attr( $instance['nofollow'] )   : '';

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'e3lan_title' ) ); ?>"><?php esc_html_e( 'Ad Title', TIELABS_TEXTDOMAIN ) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'e3lan_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'e3lan_title' ) ); ?>" value="<?php if( ! empty( $instance['e3lan_title'] ) ) echo esc_attr( $instance['e3lan_title'] ); ?>" class="widefat" type="text" />
				<small><?php esc_html_e( 'A title for the Ad, like Advertisement - leave this empty to disable.', TIELABS_TEXTDOMAIN ); ?></small>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'e3lan_title_link' ) ); ?>"><?php esc_html_e( 'Ad Title Link', TIELABS_TEXTDOMAIN ) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'e3lan_title_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'e3lan_title_link' ) ); ?>" value="<?php if( ! empty( $instance['e3lan_title_link'] ) ) echo esc_attr( $instance['e3lan_title_link'] ); ?>" class="widefat" placeholder="http://" type="text" />
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'tran_bg' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tran_bg' ) ); ?>" value="true" <?php checked( $tran_bg, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'tran_bg' ) ); ?>"><?php esc_html_e( 'Show the ads only?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'new_window' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'new_window' ) ); ?>" value="true" <?php checked( $new_window, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'new_window' ) ); ?>"><?php esc_html_e( 'Open links in a new window?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'nofollow' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'nofollow' ) ); ?>" value="true" <?php checked( $nofollow, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'nofollow' ) ); ?>"><?php esc_html_e( 'Nofollow?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'e3lan_img' ) ); ?>"><?php esc_html_e( 'Image path:', TIELABS_TEXTDOMAIN ) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'e3lan_img' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'e3lan_img' ) ); ?>" value="<?php if( ! empty( $instance['e3lan_img'] ) ) echo esc_attr( $instance['e3lan_img'] ); ?>" class="widefat" placeholder="http://" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'e3lan_img_width' ) ); ?>"><?php esc_html_e( 'Ad Image Width', TIELABS_TEXTDOMAIN ) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'e3lan_img_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'e3lan_img_width' ) ); ?>" value="<?php if( ! empty( $instance['e3lan_img_width'] ) ) echo esc_attr( $instance['e3lan_img_width'] ); ?>" class="widefat" type="number" style="width: 50px;" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'e3lan_img_height' ) ); ?>"><?php esc_html_e( 'Ad Image Height', TIELABS_TEXTDOMAIN ) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'e3lan_img_height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'e3lan_img_height' ) ); ?>" value="<?php if( ! empty( $instance['e3lan_img_height'] ) ) echo esc_attr( $instance['e3lan_img_height'] ); ?>" class="widefat" type="number" style="width: 50px;" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'e3lan_alt' ) ); ?>"><?php esc_html_e( 'Alternative Text For The image', TIELABS_TEXTDOMAIN ) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'e3lan_alt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'e3lan_alt' ) ); ?>" value="<?php if( ! empty( $instance['e3lan_alt'] ) ) echo esc_attr( $instance['e3lan_alt'] ); ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'e3lan_url' ) ); ?>"><?php esc_html_e( 'Ad URL', TIELABS_TEXTDOMAIN ) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'e3lan_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'e3lan_url' ) ); ?>" value="<?php if( ! empty( $instance['e3lan_url'] ) ) echo esc_attr( $instance['e3lan_url'] ); ?>" class="widefat" placeholder="http://" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'e3lan_code' ) ); ?>"><strong><?php esc_html_e( '- OR -', TIELABS_TEXTDOMAIN) ?></strong> <?php esc_html_e( 'Code:', TIELABS_TEXTDOMAIN ) ?></label>
				<textarea id="<?php echo esc_attr( $this->get_field_id( 'e3lan_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'e3lan_code' ) ); ?>" class="widefat" rows="5"><?php if( ! empty( $instance['e3lan_code'] ) ) echo esc_textarea( $instance['e3lan_code'] ); ?></textarea>
			</p>
			<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_ad_widget_register' );
	function tie_ad_widget_register(){
		register_widget( 'TIE_AD_WIDGET' );
	}

}
