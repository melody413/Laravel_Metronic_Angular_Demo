<?php
/*
Weather Widget developed By : Fouad Badawy | TieLabs
Based On :  Awesome Weather Widget http://halgatewood.com/awesome-weather
*/

if( ! class_exists( 'TIE_WEATHER_WIDGET' ) ) {

	add_action( 'widgets_init', 'tie_weather_widget_register' );
	function tie_weather_widget_register(){
		register_widget( 'TIE_WEATHER_WIDGET' );
	}


	class TIE_WEATHER_WIDGET extends WP_Widget{

		public function __construct(){
			$widget_ops  = array( 'classname' => 'tie-weather-widget' );
			parent::__construct( 'tie-weather-widget', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Weather', TIELABS_TEXTDOMAIN ), $widget_ops );
		}

		public function widget( $args, $instance ){

			extract( $args );

			$widget_title  = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			// Weather Settings
			$location      = ! empty( $instance['location'] )      ? $instance['location']      : false;
			$custom_name   = ! empty( $instance['custom_name'] )   ? $instance['custom_name']   : false;
			$units         = ! empty( $instance['units'] )         ? $instance['units']         : false;
			$forecast_days = ! empty( $instance['forecast_days'] ) ? $instance['forecast_days'] : false;
			$animated      = ! empty( $instance['animated'] )      ? $instance['animated']      : false;
			$bg_image      = ! empty( $instance['bg_image'] )      ? $instance['bg_image']      : false;
			$user_location = ! empty( $instance['user_location'] ) ? $instance['user_location'] : false;

			# Colors
			$bg_color   = ! empty( $instance['bg_color'] )   ? $instance['bg_color']   : '';
			$bg_color_2 = ! empty( $instance['bg_color_2'] ) ? $instance['bg_color_2'] : '';
			$font_color = ! empty( $instance['font_color'] ) ? $instance['font_color'] : '';

			echo ( str_replace( 'container-wrapper ', '', $before_widget ) );

			$user_location_class = 'tie-weather-user-location';

			if ( ! empty( $widget_title ) ){
				echo ( $before_title . $widget_title . $after_title );

				$user_location_class .= ' has-title';
			}

			$atts = array(
				'location'      => $location,
				'units'         => $units,
				'forecast_days' => $forecast_days,
				'custom_name'   => $custom_name,
				'animated'      => $animated
			);

			if( $user_location && tie_get_option( 'api_openweather' ) ){
				if( isset( $_COOKIE['TieUserLocation'] ) ){
					$atts['location']    = $_COOKIE['TieUserLocation'];
					$atts['custom_name'] = false;
					//$atts['avoid_cache'] = true;
				}

				echo '<span class="'. $user_location_class .'" data-options="'. str_replace( '"', '\'', wp_json_encode( $atts )) .'"><span class="tie-icon-gps"></span></span>';
			}

			new TIELABS_WEATHER( $atts );

			$widget_id = '#'. $args['widget_id'];

			if ( ! empty( $bg_color ) || ! empty( $bg_color_2 ) || ! empty( $font_color ) || ! empty( $bg_image ) ){

				$out = "<style scoped type=\"text/css\">";

				if ( ! empty( $font_color ) ){
					$out .= "
						$widget_id,
						$widget_id .widget-title .the-subtitle{
							color: $font_color;
						}
					";
				}

				if ( ! empty( $bg_color ) ){
					$out .= "
						$widget_id{
							background-color: $bg_color;
						}

						$widget_id .icon-basecloud-bg:after{
							color: $bg_color;
						}
					";
				}

				if( ! empty( $bg_image ) ){
					$out .= "
						$widget_id{
							background-image: url( $bg_image );
							background-repeat: no-repeat;
							background-size: cover;
						}

						$widget_id .icon-basecloud-bg:after{
							color: inherit;
						}
					";
				}
				elseif ( ! empty( $bg_color ) && ! empty( $bg_color_2 ) ){
					$out .= "
						$widget_id{
							". TIELABS_STYLES::gradiant( $bg_color, $bg_color_2 ) ."
						}

						$widget_id .icon-basecloud-bg:after{
							color: inherit;
						}
					";
				}

				echo ( $out ) ."</style>";
			}


			echo ( $after_widget );
		}

		public function update( $new_instance, $old_instance ){
			$instance                  = $old_instance;
			$instance['location']      = strip_tags($new_instance['location']);
			$instance['custom_name']   = strip_tags($new_instance['custom_name']);
			$instance['title']         = strip_tags($new_instance['title']);
			$instance['units']         = strip_tags($new_instance['units']);
			$instance['forecast_days'] = strip_tags($new_instance['forecast_days']);
			$instance['font_color']    = strip_tags($new_instance['font_color']);
			$instance['bg_color']      = strip_tags($new_instance['bg_color']);
			$instance['bg_color_2']    = strip_tags($new_instance['bg_color_2']);
			$instance['animated']      = ! empty( $new_instance['animated'] ) ? 'true' : 0;
			$instance['user_location'] = ! empty( $new_instance['user_location'] ) ? 'true' : 0;
			$instance['bg_image']      = strip_tags($new_instance['bg_image']);

			# Delete the Cached data
			if( ! empty( $instance['location'] ) ){
				TIELABS_WEATHER::clear_cache( $instance['location'] );
			}

			# ---------

			return $instance;
		}

		public function form( $instance ){
			$defaults = array( 'title' => esc_html__('Weather', TIELABS_TEXTDOMAIN) );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$location      = isset( $instance['location'] )      ? esc_attr( $instance['location'])       : '';
			$custom_name   = isset( $instance['custom_name'] )   ? esc_attr( $instance['custom_name'])    : '';
			$title         = isset( $instance['title'] )         ? esc_attr( $instance['title'])          : '';
			$forecast_days = isset( $instance['forecast_days'] ) ? esc_attr( $instance['forecast_days'] ) : 5;
			$font_color    = isset( $instance['font_color'] )    ? esc_attr( $instance['font_color'])     : '';
			$bg_color      = isset( $instance['bg_color'] )      ? esc_attr( $instance['bg_color'])       : '';
			$bg_color_2    = isset( $instance['bg_color_2'] )    ? esc_attr( $instance['bg_color_2'])     : '';
			$bg_image      = isset( $instance['bg_image'] )      ? esc_attr( $instance['bg_image'])       : '';
			$animated      = isset( $instance['animated'] )      ? esc_attr( $instance['animated'])       : '';
			$user_location = isset( $instance['user_location'] ) ? esc_attr( $instance['user_location'])  : '';
			$units         = ( isset( $instance['units'] ) AND strtoupper( $instance['units']) == 'C' ) ? 'C' : 'F';

			$id = explode( '-', $this->get_field_id( 'widget_id' ));
			$colors_class = ( $id[4] == '__i__' ) ? 'ajax-added' : '';

			$theme_color = tie_get_option( 'global_color', '#000000' );

			if( ! tie_get_option( 'api_openweather' ) ){
				echo '<p class="tie-message-hint">'. esc_html__( 'You need to set the Weather API Key in the theme options page > Integrations.', TIELABS_TEXTDOMAIN ) .'</p>';
			}
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title', TIELABS_TEXTDOMAIN); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('location') ); ?>">
				<strong><?php esc_html_e('Location', TIELABS_TEXTDOMAIN); ?></strong> - <a href="<?php echo esc_url( 'http://openweathermap.org/find' ); ?>" target="_blank" rel="nofollow noopener"><?php esc_html_e('Find Your Location', TIELABS_TEXTDOMAIN); ?></a><br />
				<small><?php esc_html_e( '(i.e: London,UK or New York City)', TIELABS_TEXTDOMAIN ); ?></small>
			</label>
			<input class="widefat" style="margin-top: 4px;" id="<?php echo esc_attr( $this->get_field_id('location') ); ?>" name="<?php echo esc_attr( $this->get_field_name('location') ); ?>" type="text" value="<?php echo esc_attr( $location ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('custom_name') ); ?>">
				<?php esc_html_e('Custom City Name', TIELABS_TEXTDOMAIN); ?><br />
			</label>
			<input class="widefat" style="margin-top: 4px;" id="<?php echo esc_attr( $this->get_field_id('custom_name') ); ?>" name="<?php echo esc_attr( $this->get_field_name('custom_name') ); ?>" type="text" value="<?php echo esc_attr( $custom_name ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('units') ); ?>"><?php esc_html_e('Units', TIELABS_TEXTDOMAIN); ?></label>  &nbsp;
			<input id="<?php  echo esc_attr( $this->get_field_id('units') ); ?>-f" name="<?php echo esc_attr( $this->get_field_name('units') ); ?>" type="radio" value="F" <?php checked( $units, 'F' ); ?> /> <?php esc_html_e('F', TIELABS_TEXTDOMAIN); ?> &nbsp; &nbsp;
			<input id="<?php  echo esc_attr( $this->get_field_id('units') ); ?>-c" name="<?php echo esc_attr( $this->get_field_name('units') ); ?>" type="radio" value="C" <?php checked( $units, 'C' ); ?> /> <?php esc_html_e('C', TIELABS_TEXTDOMAIN); ?>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('forecast_days') ); ?>"><?php esc_html_e('Forecast', TIELABS_TEXTDOMAIN ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('forecast_days') ); ?>" name="<?php echo esc_attr( $this->get_field_name('forecast_days') ); ?>">
				<?php
					for ( $i=5; $i>0; $i-- ) {
						echo '<option value="'. $i .'"'. selected( $forecast_days, $i, false ) .'>'. sprintf( _n( '%d day', '%d days', $i, TIELABS_TEXTDOMAIN ), $i ) .'</option>';
					}
				?>
				<option value="hide"<?php selected( $forecast_days, 'hide' ); ?>><?php esc_html_e('Disable', TIELABS_TEXTDOMAIN); ?></option>
			</select>
		</p>

		<hr />
		<br />
		<strong><?php esc_html_e('Visitor\'s Location?', TIELABS_TEXTDOMAIN); ?><br /></strong>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'user_location' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'user_location' ) ); ?>" value="true" <?php checked( $user_location, 'true' ) ?> type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'user_location' ) ); ?>"><?php esc_html_e( 'Allow visitors to view the weather in their location', TIELABS_TEXTDOMAIN) ?></label>
		</p>

		<hr />
		<br />
		<strong><?php esc_html_e('Style and Layout', TIELABS_TEXTDOMAIN); ?><br /></strong>
		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'animated' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'animated' ) ); ?>" value="true" <?php checked( $animated, 'true' ) ?> type="checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'animated' ) ); ?>"><?php esc_html_e( 'Animated Icons?', TIELABS_TEXTDOMAIN) ?></label>
		</p>

		<div class="weather-color tie-custom-color-picker <?php echo esc_attr( $colors_class ) ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Background Color', TIELABS_TEXTDOMAIN ); ?></label>
			<input data-palette="<?php echo esc_attr( $theme_color ); ?>, #9b59b6, #3498db, #2ecc71, #f1c40f, #34495e, #e74c3c" class="widefat tieColorSelector" id="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bg_color' ) ); ?>" type="text" value="<?php echo esc_attr( $bg_color ) ?>" />
		</div>

		<div class="weather-color tie-custom-color-picker <?php echo esc_attr( $colors_class ) ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'bg_color_2' ) ); ?>" style="display:block;"><?php esc_html_e( 'Background Color 2 (Gradient)', TIELABS_TEXTDOMAIN ); ?></label>
			<input data-palette="<?php echo esc_attr( $theme_color ); ?>, #9b59b6, #3498db, #2ecc71, #f1c40f, #34495e, #e74c3c" class="widefat tieColorSelector" id="<?php echo esc_attr( $this->get_field_id( 'bg_color_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bg_color_2' ) ); ?>" type="text" value="<?php echo esc_attr( $bg_color_2 ) ?>" />
		</div>

		<div class="weather-color tie-custom-color-picker <?php echo esc_attr( $colors_class ) ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'font_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Text Color', TIELABS_TEXTDOMAIN ); ?></label>
			<input data-palette="<?php echo esc_attr( $theme_color ); ?>, #9b59b6, #3498db, #2ecc71, #f1c40f, #34495e, #e74c3c" class="widefat tieColorSelector" id="<?php echo esc_attr( $this->get_field_id( 'font_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'font_color' ) ); ?>" type="text" value="<?php echo esc_attr( $font_color ) ?>" />
		</div>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('bg_image') ); ?>">
				<?php esc_html_e('Background Image', TIELABS_TEXTDOMAIN); ?><br />
			</label>
			<input class="widefat" style="margin-top: 4px;" id="<?php echo esc_attr( $this->get_field_id('bg_image') ); ?>" name="<?php echo esc_attr( $this->get_field_name('bg_image') ); ?>" type="text" value="<?php echo esc_attr( $bg_image ); ?>" placeholder="https://" />
		</p>

		<?php
		}
	}

}
