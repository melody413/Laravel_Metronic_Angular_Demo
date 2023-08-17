<?php

if( ! class_exists( 'TIE_SOCIAL_COUNTER_WIDGET' ) ) {

	/**
	 * Widget API: TIE_SOCIAL_COUNTER_WIDGET class
	 */
	 class TIE_SOCIAL_COUNTER_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops = array( 'classname' => 'social-statistics-widget' );
			parent::__construct( 'social-statistics', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Social Counters', TIELABS_TEXTDOMAIN ), $widget_ops );
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


			$class = 'two-cols';

			$layouts = array(
				1  => 'two-cols transparent-icons',
				2  => 'two-cols white-bg',
				3  => 'two-cols',
				4  => 'fullwidth-stats-icons transparent-icons',
				5  => 'fullwidth-stats-icons white-bg',
				6  => 'fullwidth-stats-icons',
				7  => 'three-cols',
				8  => 'solid-social-icons three-cols three-cols-without-spaces',
				9  => 'solid-social-icons white-bg two-cols circle-icons',
				10 => 'solid-social-icons circle-three-cols circle-icons',
				11 => 'solid-social-icons white-bg squared-four-cols circle-icons',
				12 => 'solid-social-icons white-bg squared-four-cols',
			);

			if( ! empty( $instance['style'] ) && ! empty( $layouts[ $instance['style'] ] ) ) {
				$class = $layouts[ $instance['style'] ];
			}

			# Arqam or Arqam Lite?
			$is_installed = false;

			if( function_exists( 'arq_counters_data' ) ) {
				$arq_counters = arq_counters_data();
				$class  .= ' Arqam';
				$is_installed = true;
			}
			elseif( class_exists( 'ARQAM_LITE_COUNTERS' ) ) {
				$counters = new ARQAM_LITE_COUNTERS();
				$arq_counters = $counters->counters_data();
				$class .= ' Arqam-Lite';
				$is_installed = true;
			}


			// Get the total followers number
			$total_position = ! empty( $instance['total_position'] ) ? $instance['total_position'] : 'before';
			if( ! empty( $instance['total'] ) ){

				$total = 0;
				foreach ( $arq_counters as $social => $counter ){

					if( ! empty( $counter['count'] ) ){

						$count = str_replace( '+', '', $counter['count'] );
						$count = str_replace( '.', '', $count );

						if( strpos( $count, 'M' ) !== false ){
							$count = str_replace( '٬', '.', $count );
							$count = str_replace( ',', '.', $count );
							$count = str_replace( 'M', '', $count ) * 1000000;
						}
						elseif( strpos( $count, 'k' ) !== false ){
							$count = str_replace( '٬', '.', $count );
							$count = str_replace( ',', '.', $count );
							$count = str_replace( 'k', '', $count ) * 1000;
						}

						$count = str_replace( '٬', '', $count );
						$count = str_replace( ',', '', $count );

						$total += $count;
					}
				}

				if( ! empty( $total ) && is_integer( $total ) ){
					if( $total >= 1000000 ){
						$total = round( ( $total/1000)/1000, 0) . 'M';
					}
					elseif( $total >= 100000){
						$total = round( $total/1000, 0) . 'K';
					}
					else{
						$total = number_format_i18n( $total );
					}
				}

				$total   = apply_filters( 'TieLabs/Social_Counters/number', $total );
				$before = ! empty( $instance['total_before'] ) ? $instance['total_before'] : '';
				$after  = ! empty( $instance['total_after'] )  ? $instance['total_after']  : '';

				$total = '
					<div class="social-counter-total">
						<span class="tie-icon-heart"></span>
						<span class="counter-total-text">'. $before .' <strong>'. $total .'</strong> '. $after.'</span>
					</div>
				';
			}


			if( ! empty( $total ) && $total_position == 'before' ){
				echo $total;
			}
			?>
			<ul class="solid-social-icons <?php echo esc_attr( $class ) ?>">
				<?php

					if( ! $is_installed ){

						TIELABS_HELPER::notice_message( esc_html__( 'This widget requries the Arqam Lite Plugin, You can install it from the Theme settings menu > Install Plugins.', TIELABS_TEXTDOMAIN ) );
					}
					elseif( ! empty( $arq_counters ) && is_array( $arq_counters ) ){
						foreach ( $arq_counters as $social => $counter ){

							if( $social == '500px' ){
								$social = 'px500';
				 			}
			 				?>

							<li class="social-icons-item">
								<a class="<?php echo esc_attr( $social ) ?>-social-icon" href="<?php echo esc_url( $counter['url'] ) ?>" rel="nofollow noopener" target="_blank">
									<?php
										$icon = str_replace( '<i', '<span', $counter['icon'] );
										$icon = str_replace( 'fa fa-', 'tie-icon-', $icon ); // old version of Arqam Lite
										echo str_replace( '</i', '</span', $icon );
									?>
									<span class="followers">
										<span class="followers-num"><?php  echo apply_filters( 'TieLabs/Social_Counters/number', $counter['count'] ) ?></span>
										<span class="followers-name"><?php echo $counter['text'] ?></span>
									</span>
								</a>
							</li>
							<?php
						}
					}
					else{
						TIELABS_HELPER::notice_message( esc_html__( 'Go to the Arqam options page to set your social accounts.', TIELABS_TEXTDOMAIN ) );
					}
				?>
			</ul>
			<?php

			if( ! empty( $total ) && $total_position == 'after' ){
				echo $total;
			}

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                 = $old_instance;
			$instance['title']        = sanitize_text_field( $new_instance['title'] );
			$instance['style']        = $new_instance['style'];
			$instance['total_before'] = $new_instance['total_before'];
			$instance['total_after']  = $new_instance['total_after'];
			$instance['total']        = ! empty( $new_instance['total'] ) ? 'true' : false;
			$instance['total_position'] = $new_instance['total_position'];

			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' => esc_html__( 'Follow Us', TIELABS_TEXTDOMAIN), 'style' => 1 );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title        = isset( $instance['title'] ) ? $instance['title'] : '';
			$total_before = isset( $instance['total_before'] ) ? $instance['total_before'] : '';
			$total_after  = isset( $instance['total_after'] )   ? $instance['total_after'] : '';
			$total_position = isset( $instance['total_position'] )  ? $instance['total_position'] : 'before';
			$total = isset( $instance['total'] ) ? $instance['total']  : '';
			$style = isset( $instance['style'] ) ? $instance['style'] : 1;
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
			</p>

			<label><?php esc_html_e( 'Style', TIELABS_TEXTDOMAIN) ?></label>
			<div class="tie-styles-list-widget">
				<p>
					<?php
						for ( $i=1; $i < 13; $i++ ){ ?>
							<label class="tie-widget-options">
								<input name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" type="radio" value="<?php echo esc_attr( $i ) ?>" <?php echo checked( $style, $i ) ?>> <img src="<?php echo TIELABS_TEMPLATE_URL .'/framework/admin/assets/images/widgets/counter-'.$i.'.png'; ?>" />
							</label>
							<?php
						}
					?>
				</p>
			</div>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'total' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'total' ) ); ?>" value="true" <?php checked( $total, 'true' ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'total' ) ); ?>"><?php esc_html_e( 'Show the total followers number?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'total_before' ) ); ?>"><?php esc_html_e( 'Text before the total number', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'total_before' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'total_before' ) ); ?>" value="<?php echo esc_attr( $total_before ); ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'total_after' ) ); ?>"><?php esc_html_e( 'Text after the total number', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'total_after' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'total_after' ) ); ?>" value="<?php echo esc_attr( $total_after ); ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('total_position') ); ?>"><?php esc_html_e( 'Position', TIELABS_TEXTDOMAIN ); ?></label><br />
				<label><input name="<?php echo esc_attr( $this->get_field_name('total_position') ); ?>" type="radio" value="before" <?php checked( $total_position, 'before' ); ?> /> <?php esc_html_e('Before the counters.', TIELABS_TEXTDOMAIN); ?></label> <br />
				<label><input name="<?php echo esc_attr( $this->get_field_name('total_position') ); ?>" type="radio" value="after" <?php checked( $total_position, 'after' ); ?> /> <?php esc_html_e('After the counters.', TIELABS_TEXTDOMAIN); ?></label>
			</p>

			<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_social_counter_widget_register' );
	function tie_social_counter_widget_register(){
		register_widget( 'TIE_SOCIAL_COUNTER_WIDGET' );
	}

}
