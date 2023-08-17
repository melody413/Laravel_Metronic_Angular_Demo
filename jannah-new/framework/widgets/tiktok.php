<?php

if( ! class_exists( 'TIE_TIKTOK_WIDGET' ) ) {

	/**
	 * Widget API: TIE_TIKTOK_WIDGET class
	 */
	 class TIE_TIKTOK_WIDGET extends WP_Widget {


		public function __construct(){
			parent::__construct( 'tie-tiktok-theme', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'TikTok', TIELABS_TEXTDOMAIN ) );
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

			if( ! TIELABS_TIKTOK_IS_ACTIVE ){
				TIELABS_HELPER::notice_message( esc_html__( 'This section requries the TikTok Plugin, You can install it from the Theme settings menu > Install Plugins.', TIELABS_TEXTDOMAIN ) );
			}
			else{

				$feeds = get_option( 'tiktok_feed_feeds' );
				if( empty( $feeds ) || ! is_array( $feeds ) ) {
					TIELABS_HELPER::notice_message( esc_html__( 'No accounts found, Go to TikTok Feed > Feeds to setup your account.', TIELABS_TEXTDOMAIN ) );
				}

				else{
					if( isset( $instance['source'] ) ){

						$feeds = get_option( 'tiktok_feed_feeds' );

						if( ! empty( $feeds[ $instance['source'] ] ) ){


							if( $feeds[ $instance['source'] ]['source'] == 'username' && function_exists( 'qlttf_get_username_profile' ) ){

								$account_info = qlttf_get_username_profile( $feeds[ $instance['source'] ]['username'] );

								if( ! empty( $account_info ) ){
								?>
									<div class="tie-tiktok-header">

										<div class="tie-tiktok-avatar">
											<a href="<?php echo esc_attr( $account_info['link'] ) ?>" target="_blank" rel="nofollow noopener">
												<img src="<?php echo $account_info['profile_pic_url'] ?>" alt="<?php echo esc_attr( $account_info['full_name'] ) ?>">
											</a>
										</div>

										<div class="tie-tiktok-info">
											<a href="<?php echo esc_attr( $account_info['link'] ) ?>" target="_blank" rel="nofollow noopener" class="tie-tiktok-username">
												<?php
													echo esc_attr( $account_info['username'] );
													if( $account_info['verified'] ){
														echo '<span class="tie-tiktok-verified tie-icon-check1"></span>';
													}
												?>
											</a>

											<span class="tie-tiktok-full-name">
												<?php echo esc_attr( $account_info['full_name'] ); ?>
											<span>
										</div>

										<?php if( ! empty( $account_info['tagline'] ) ){ ?>
											<div class="tie-tiktok-desc">
												<?php echo $account_info['tagline'] ?>
											</div>
										<?php } ?>

										<div class="tie-tiktok-counts clearfix">
											<ul>
												<li>
													<span class="counts-number"><?php echo $this->format_number( $account_info['following_count'] ) ?></span>
													<span><?php esc_html_e( 'Following', TIELABS_TEXTDOMAIN ) ?></span>
												</li>
												<li>
													<span class="counts-number"><?php echo $this->format_number( $account_info['fans_count'] ) ?></span>
													<span><?php esc_html_e( 'Followers', TIELABS_TEXTDOMAIN ) ?></span>
												</li>
												<li>
													<span class="counts-number"><?php echo $this->format_number( $account_info['heart_count'] ) ?></span>
													<span><?php esc_html_e( 'Likes', TIELABS_TEXTDOMAIN ) ?></span>
												</li>

											</ul>
										</div>
									</div>
								<?php
								}
							}

							echo do_shortcode( '[tiktok-feed id="'. $instance['source'] .'"]' );
						}


					}
				}
			}

			echo ( $args['after_widget'] );
		}


		/**
		 * Format the comments and links numbers
		 */
		private function format_number( $number ){

			if( ! is_numeric( $number ) ){
				$number = $number;
			}

			elseif( $number >= 1000000 ){
				$number = round( ($number/1000)/1000 , 1) . "M";
			}

			elseif( $number >= 100000 ){
				$number = round( $number/1000, 0) . "k";
			}

			else{
				$number = number_format( $number );
			}

			return apply_filters( 'TieLabs/number_format', $number );
		}


		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance           = $old_instance;
			$instance['title']  = sanitize_text_field( $new_instance['title'] );
			$instance['source'] = $new_instance['source'];
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' => esc_html__( 'TikTok', TIELABS_TEXTDOMAIN ), );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title  = isset( $instance['title'] )  ? $instance['title']  : '';
			$source = isset( $instance['source'] ) ? $instance['source'] : '';

			$show_settings = 'none';

			if( ! TIELABS_TIKTOK_IS_ACTIVE ){
				tie_build_theme_option(
					array(
						'text' => esc_html__( 'This section requries the TikTok Plugin, You can install it from the Theme settings menu > Install Plugins.', TIELABS_TEXTDOMAIN ),
						'type' => 'error',
					));
			}

			else{
				$show_settings = 'block';
			}

			?>
			<div style="display:<?php echo $show_settings ?>">
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
				</p>

				<?php

					$feeds = get_option( 'tiktok_feed_feeds' );

					if( empty( $feeds ) || ! is_array( $feeds ) ) {

						tie_build_theme_option(
							array(
								'text' => esc_html__( 'No accounts found, Go to TikTok Feed > Feeds to setup your account.', TIELABS_TEXTDOMAIN ),
								'type' => 'error',
							));
					}
					else{
					?>

					<p>
						<label for="<?php echo esc_attr( $this->get_field_id( 'source' ) ); ?>"><?php esc_html_e( 'Source', TIELABS_TEXTDOMAIN ) ?></label>
						<select id="<?php echo esc_attr( $this->get_field_id( 'source' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'source' ) ); ?>" class="widefat">
							<option value=""><?php esc_html_e( 'Choose', TIELABS_TEXTDOMAIN) ?></option>
							<?php

								foreach ( $feeds as $id => $data ) {

									if( $data['source'] == 'username' ){
										$source_name = $data['username'];
									}
									elseif( $data['source'] == 'hashtag' ){
										$source_name = $data['hashtag'];
									}

									?>
										<option value="<?php echo $id ?>" <?php selected( $source, $id ); ?>><?php echo $source_name ?></option>
									<?php
								}

							?>
						</select>
					</p>
					<?php

					}
				?>
			</div>
		<?php

		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_tiktok_widget_register' );
	function tie_tiktok_widget_register(){
		register_widget( 'TIE_TIKTOK_WIDGET' );
	}

}
