<?php

if( ! class_exists( 'TIE_WIDGET_TABS' ) ) {

	/**
	 * Widget API: TIE_WIDGET_TABS class
	 */
	 class TIE_WIDGET_TABS extends WP_Widget {


		public function __construct(){
			$widget_ops = array( 'description' => 'Most Popular, Recent posts and Comments'  );
			parent::__construct( 'widget_tabs', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Tabs', TIELABS_TEXTDOMAIN) , $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			$posts_number = empty( $instance['posts_number'] ) ? 5 : $instance['posts_number'];

			// Get the Order of tabs
			$tabs_order = 'r,p,c';
			if( ! empty( $instance['tabs_order'] ) ){
				$tabs_order = $instance['tabs_order'];
			}

			$tabs_order_array = explode( ',', $tabs_order );

			// Check the disabled tabs
			$disabled_tabs = array(
				'disable_recent'   => 'r',
				'disable_popular'  => 'p',
				'disable_comments' => 'c',
			);

			foreach ( $disabled_tabs as $option => $tab_id ) {

				if( ! empty( $instance[ $option ] ) && ( $key = array_search( $tab_id, $tabs_order_array ) ) !== false ){
					unset( $tabs_order_array[ $key ] );
				}
			}

			// Return if all Tabs are disabled !!
			if( empty( $tabs_order_array ) ){
				return;
			}

			$popular_order = 'popular';

			if( ! empty( $instance['posts_order'] ) ){
				$popular_order = ( $instance['posts_order'] == 'viewed' ) ? 'views' : $instance['posts_order'];
			}

			$tabs_icons = ! empty( $instance['tabs_title_icons'] ) ? true : false;

			$popular_text  = esc_html__( 'Popular', TIELABS_TEXTDOMAIN );
			$recent_text   = $tabs_icons ? '<span class="tie-icon-file-text"></span>' : esc_html__( 'Recent', TIELABS_TEXTDOMAIN );
			$comments_text = $tabs_icons ? '<span class="tie-icon-comments"></span>'  : esc_html__( 'Comments', TIELABS_TEXTDOMAIN );

			if( $tabs_icons ){
				$popular_text = $popular_order == 'popular' ? '<span class="tie-icon-thumbs-up"></span>' : '<span class="tie-icon-eye"></span>';
			}
			?>

			<div class="container-wrapper tabs-container-wrapper tabs-container-<?php echo count( $tabs_order_array ) ?>">
				<div class="widget tabs-widget">
					<div class="widget-container">
						<div class="tabs-widget">
							<div class="tabs-wrapper">

								<ul class="tabs">
									<?php

										// Widget ID
										$id        = explode( '-', $this->get_field_id( 'widget_id' ));
										$widget_id =  $id[1] .'-'. $id[2];

										foreach ( $tabs_order_array as $tab ){

											if( $tab == 'p' ){
												echo '<li><a href="#'.$widget_id.'-popular">'. $popular_text .'</a></li>';
											}

											elseif( $tab == 'r' ){
												echo '<li><a href="#'.$widget_id.'-recent">'. $recent_text .'</a></li>';
											}

											elseif( $tab == 'c' ){
												echo '<li><a href="#'.$widget_id.'-comments">'. $comments_text .'</a></li>';
											}

										}

									?>
								</ul><!-- ul.tabs-menu /-->

								<?php
									foreach ( $tabs_order_array as $tab ){

										if( $tab == 'p' ): ?>

											<div id="<?php echo esc_attr( $widget_id ) ?>-popular" class="tab-content tab-content-popular">
												<ul class="tab-content-elements">
													<?php tie_widget_posts( array( 'number' => $posts_number, 'order' => $popular_order )); ?>
												</ul>
											</div><!-- .tab-content#popular-posts-tab /-->

										<?php

										elseif( $tab == 'r' ): ?>

											<div id="<?php echo esc_attr( $widget_id ) ?>-recent" class="tab-content tab-content-recent">
												<ul class="tab-content-elements">
													<?php tie_widget_posts( array( 'number' => $posts_number ));?>
												</ul>
											</div><!-- .tab-content#recent-posts-tab /-->

										<?php

										elseif( $tab == 'c' ): ?>

											<div id="<?php echo esc_attr( $widget_id ) ?>-comments" class="tab-content tab-content-comments">
												<ul class="tab-content-elements">
													<?php tie_recent_comments( $posts_number );?>
												</ul>
											</div><!-- .tab-content#comments-tab /-->

										<?php endif;
									}
								?>

							</div><!-- .tabs-wrapper-animated /-->
						</div><!-- .tabs-widget /-->
					</div><!-- .widget-container /-->
				</div><!-- .tabs-widget /-->
			</div><!-- .container-wrapper /-->
			<?php
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                     = $old_instance;
			$instance['posts_number']     = $new_instance['posts_number'];
			$instance['posts_order']      = $new_instance['posts_order'];
			$instance['tabs_order']       = $new_instance['tabs_order'];
			$instance['disable_popular']  = ! empty( $new_instance['disable_popular'] )  ? 'true' : false;
			$instance['disable_recent']   = ! empty( $new_instance['disable_recent'] )   ? 'true' : false;
			$instance['disable_comments'] = ! empty( $new_instance['disable_comments'] ) ? 'true' : false;

			$instance['tabs_title_icons'] = ! empty( $new_instance['tabs_title_icons'] ) ? 'true' : false;
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){

			$id = explode( '-', $this->get_field_id( 'widget_id' ));

			$defaults  = array( 'posts_order' => 'popular', 'posts_number' => 5 );
			$instance  = wp_parse_args( (array) $instance, $defaults );

			$posts_number = empty( $instance['posts_number'] ) ? 5 : $instance['posts_number'];
			$posts_order  = isset( $instance['posts_order'] )  ? $instance['posts_order'] : '';

			$disable_popular  = isset( $instance['disable_popular'] )  ? $instance['disable_popular']  : '';
			$disable_recent   = isset( $instance['disable_recent'] )   ? $instance['disable_recent']   : '';
			$disable_comments = isset( $instance['disable_comments'] ) ? $instance['disable_comments'] : '';

			$tabs_title_icons = isset( $instance['tabs_title_icons'] ) ? $instance['tabs_title_icons'] : '';

			?>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'tabs_title_icons' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tabs_title_icons' ) ); ?>" value="true" <?php checked( $tabs_title_icons, 'true' ) ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'tabs_title_icons' ) ); ?>"><?php esc_html_e( 'Use icons', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>"><?php esc_html_e( 'Number of items to show:', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_number' ) ); ?>" value="<?php echo esc_attr( $posts_number ) ?>" type="number" step="1" min="1" size="3" class="tiny-text" />
			</p>

			<hr />

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tabs_order' ) ); ?>"><?php esc_html_e( 'Order of tabs:', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<ul class="tab-sortable">
				<?php
					$tabs_order = ! empty( $instance['tabs_order'] ) ? $instance['tabs_order'] : 'r,p,c';

					$tabs_order_array = explode( ',', $tabs_order );

					foreach ( $tabs_order_array as $tab ){

						if( $tab == 'p' ){
							echo '<li data-tab="p">'. esc_html__( 'Popular', TIELABS_TEXTDOMAIN ) .'</li>';
						}

						elseif( $tab == 'r' ){
							echo '<li data-tab="r">'. esc_html__( 'Recent', TIELABS_TEXTDOMAIN ) .'</li>';
						}

						elseif( $tab == 'c' ){
							echo '<li data-tab="c">'. esc_html__( 'Comments', TIELABS_TEXTDOMAIN ) .'</li>';
						}
					}
				?>
			</ul>

			<input class="stored-tabs-order" name="<?php echo esc_attr( $this->get_field_name( 'tabs_order' ) ); ?>" value="<?php if( ! empty($instance['tabs_order']) ) echo esc_attr( $instance['tabs_order'] ); ?>" type="hidden" />

			<hr />

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>"><?php esc_html_e( 'Popular tab order', TIELABS_TEXTDOMAIN) ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'posts_order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_order' ) ); ?>" class="widefat tie-posts-order-option">
					<option value="popular" <?php selected( $posts_order, 'popular' ) ?>><?php esc_html_e( 'Most Commented', TIELABS_TEXTDOMAIN) ?></option>
					<option value="viewed" <?php selected( $posts_order, 'viewed' )  ?>><?php esc_html_e( 'Most Viewed', TIELABS_TEXTDOMAIN) ?></option>
					<option value="jetpack-7" <?php selected( $posts_order, 'jetpack-7' ) ?>><?php esc_html_e( 'Jetpack - Most Viewed for 7 days', TIELABS_TEXTDOMAIN) ?></option>
					<option value="jetpack-30" <?php selected( $posts_order, 'jetpack-30' ) ?>><?php esc_html_e( 'Jetpack - Most Viewed for 30 days', TIELABS_TEXTDOMAIN) ?></option>
				</select>
			</p>

			<div class="tie-jetpack-posts-order" <?php if( strpos( $posts_order, 'jetpack' ) !== false ) echo 'style="display:block"' ?>>
				<?php
					if( ! TIELABS_JETPACK_IS_ACTIVE || ! Jetpack::is_module_active( 'stats' ) ){
						echo '<p class="tie-message-hint tie-message-error">'. esc_html__( 'You need to install the Jetpack plugin. in order to use the show the most viewed for 7 or 30 days.', TIELABS_TEXTDOMAIN) .'</p>';
					}
					else{
						echo '<p class="tie-message-hint">'. esc_html__( 'Please Note that for Jetpack - Most Viewed posts it may take a few hours before views are counted. It will fallback to comments sorting type until then.', TIELABS_TEXTDOMAIN) .'</p>';
					}
				?>
			</div>

			<hr />

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'disable_popular' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_popular' ) ); ?>" value="true" <?php checked( $disable_popular, 'true' ) ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'disable_popular' ) ); ?>"><?php esc_html_e( 'Disable the Popular tab?', TIELABS_TEXTDOMAIN) ?></label>
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'disable_recent' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_recent' ) ); ?>" value="true" <?php checked( $disable_recent, 'true' ) ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'disable_recent' ) ); ?>"><?php esc_html_e( 'Disable the Recent tab?', TIELABS_TEXTDOMAIN) ?></label>
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'disable_comments' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_comments' ) ); ?>" value="true" <?php checked( $disable_comments, 'true' ) ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'disable_comments' ) ); ?>"><?php esc_html_e( 'Disable the Comments tab?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

		<?php
		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_widget_tabs_register' );
	function tie_widget_tabs_register(){
		register_widget( 'TIE_WIDGET_TABS' );
	}

}
