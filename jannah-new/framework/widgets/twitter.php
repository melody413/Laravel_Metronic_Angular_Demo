<?php

if( ! class_exists( 'TIE_LATEST_TWEET_WIDGET' ) ) {

	/**
	 * Widget API: TIE_LATEST_TWEET_WIDGET class
	 */
	 class TIE_LATEST_TWEET_WIDGET extends WP_Widget {


		public function __construct(){
			$widget_ops = array( 'classname' => 'latest-tweets-widget' );
			parent::__construct( 'latest_tweets_widget', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Twitter', TIELABS_TEXTDOMAIN ), $widget_ops );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			extract( $args );

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo ( $before_widget );

			if ( ! empty($instance['title']) ){
				echo
					$before_title.
						'<a href="https://twitter.com/' .$instance['username']. '" rel="nofollow noopener">' .$instance['title']. '</a>'.
					$after_title;
			}


			# Get the tweets
			if( ! empty( $instance['username'] ) && ! empty( $instance['consumer_key'] ) && ! empty( $instance['consumer_secret'] ) ){

				$twitter_username = str_replace( '@', '', TIELABS_HELPER::remove_spaces( $instance['username'] ) );
				$consumer_key     = $instance['consumer_key'];
				$consumer_secret  = $instance['consumer_secret'];
				$no_of_tweets     = ! empty( $instance['no_of_tweets'] ) ? $instance['no_of_tweets'] : 5;
				$widget_id        = $args['widget_id'];

				// Get the stored data
				$token        = get_option( 'tie_TwitterToken'.$widget_id );
				$twitter_data = get_transient( 'list_tweets'.$widget_id );

				if( empty( $twitter_data ) ) {

					if( empty( $token ) ){

						//preparing credentials
						$credentials  = $consumer_key . ':' . $consumer_secret;
						$data_to_send = TIELABS_HELPER::api_credentials( $credentials );

						// http post arguments
						$args = array(
							'method'      => 'POST',
							'httpversion' => '1.1',
							'blocking'    => true,
							'body'        => array( 'grant_type' => 'client_credentials' ),
							'headers'     => array(
									'Authorization' => 'Basic ' . $data_to_send,
									'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8',
							));

						add_filter('https_ssl_verify', '__return_false');

						$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);
						$keys     = json_decode(wp_remote_retrieve_body($response));

						if( ! empty( $keys ) ){
							update_option( 'tie_TwitterToken'.$widget_id , $keys->access_token );
							$token = $keys->access_token;
						}
					}

					//we have bearer token wether we obtained it from API or from options
					$args = array(
						'httpversion' => '1.1',
						'blocking'    => true,
						'headers'     => array(
							'Authorization' => "Bearer $token",
					));


					add_filter('https_ssl_verify', '__return_false');

					$api_url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=$twitter_username&count=$no_of_tweets";
					$api_url = TIELABS_HELPER::remove_spaces( $api_url );

					$response = wp_remote_get( $api_url, $args );

					if ( is_wp_error( $response ) ) {

						tie_debug_log( $response->get_error_message(), true );
					}
					else{

						$twitter_data = json_decode(wp_remote_retrieve_body($response));
						set_transient( 'list_tweets'.$widget_id, $twitter_data, HOUR_IN_SECONDS );
					}
				}

				if( is_array( $twitter_data ) ){
					$i=0;

					# Enqueue the Sliders Js file
					if( ! empty( $instance['slider'] ) ) {
						wp_enqueue_script( 'tie-js-sliders' );
					}

					?>

					<ul<?php if( ! empty( $instance['slider'] )) echo' class="tie-slick-slider"';?>>

						<?php

							foreach( $twitter_data as $item ){
								$tweet     = $item->text;
								$tweet     = $this->hyperlinks( $tweet );
								$tweet     = $this->twitter_users( $tweet );
								$permalink = 'http://twitter.com/'. $twitter_username .'/status/'. $item->id_str;

								$time = strtotime( $item->created_at );
								if ((abs( time() - $time) ) < 86400 ){
									$h_time = sprintf( esc_html__( '%s ago', TIELABS_TEXTDOMAIN ), human_time_diff( $time ) );
								}
								else{
									$h_time = date( 'Y/m/d', $time);
								}

							?>

							<li class="slide">
								<div class="twitter-icon-wrap">
									<span class="tie-icon-twitter" aria-hidden="true"></span>
								</div>
								<div class="tweetaya-body">
									<p><?php echo ( $tweet ); ?></p>
									<span class="tweetaya-meta"><a href="<?php echo esc_url( $permalink ) ?>" title="<?php echo date( 'Y/m/d H:i:s', $time ) ?>" target="_blank" rel="nofollow noopener"><?php echo ( $h_time ) ?></a></span>
								</div>
							</li>

							<?php
								$i++;
								if ( $i >= $no_of_tweets ){
									break;
								}
							}
						?>
					</ul>

					<?php

					if( ! empty( $instance['slider'] ) ){ ?>
						<div class="slider-links">
							<ul class="tie-slider-nav"></ul><a href="https://twitter.com/<?php echo esc_attr( $twitter_username )  ?>" target="_blank" rel="nofollow noopener" class="button"><?php esc_html_e( 'Follow Us', TIELABS_TEXTDOMAIN ) ?></a>
						</div>
						<div class="clearfix"></div>
						<?php
					}
					else{ ?>

						<a href="https://twitter.com/<?php echo esc_attr( $twitter_username ) ?>" target="_blank" rel="nofollow noopener" class="button dark-btn fullwidth"><?php esc_html_e( 'Follow us on Twitter', TIELABS_TEXTDOMAIN ) ?></a>
						<?php
					}
				}
			}
			else{
				TIELABS_HELPER::notice_message( esc_html__( 'Error Can not Get Tweets, Incorrect account info.', TIELABS_TEXTDOMAIN ) );
			}

			echo ( $after_widget );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){

			$id        = explode("-", $this->get_field_id("widget_id"));
			$widget_id = $id[1] . "-" . $id[2];

			$instance                    = $old_instance;
			$instance['title']           = sanitize_text_field( $new_instance['title'] );
			$instance['no_of_tweets']    = absint( $new_instance['no_of_tweets'] );
			$instance['username']        = $new_instance['username'];
			$instance['consumer_key']    = $new_instance['consumer_key'];
			$instance['consumer_secret'] = $new_instance['consumer_secret'];
			$instance['slider']          = ! empty( $new_instance['slider'] ) ? 'true' : 0;

			delete_option( 'tie_TwitterToken'.$widget_id );
			delete_transient( 'list_tweets'.$widget_id );
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' => esc_html__( 'Follow Us', TIELABS_TEXTDOMAIN ) , 'no_of_tweets' => '5' );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title           = isset( $instance['title'] )           ? $instance['title'] : '';
			$username        = isset( $instance['username'] )        ? $instance['username'] : '';
			$consumer_key    = isset( $instance['consumer_key'] )    ? $instance['consumer_key'] : '';
			$consumer_secret = isset( $instance['consumer_secret'] ) ? $instance['consumer_secret'] : '';
			$no_of_tweets    = isset( $instance['no_of_tweets'] )    ? $instance['no_of_tweets'] : 5;
			$slider          = isset( $instance['slider'] )          ? $instance['slider'] : '';

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ) ?>" class="widefat" type="text" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Twitter Username', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" value="<?php echo esc_attr( $username ) ?>" class="widefat" type="text" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>"><?php esc_html_e( 'Consumer key:', TIELABS_TEXTDOMAIN) ?> </label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_key' ) ); ?>" value="<?php echo esc_attr( $consumer_key ) ?>" class="widefat" type="text" />
			</p>		<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>"><?php esc_html_e( 'Consumer secret:', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_secret' ) ); ?>" value="<?php echo esc_attr( $consumer_secret ) ?>" class="widefat" type="text" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'no_of_tweets' ) ); ?>"><?php esc_html_e( 'Number of Tweets to show:', TIELABS_TEXTDOMAIN) ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'no_of_tweets' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no_of_tweets' ) ); ?>" value="<?php echo esc_attr( $no_of_tweets ) ?>" type="number" step="1" min="1" size="3" class="tiny-text" />
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'slider' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slider' ) ); ?>" value="true" <?php checked( $slider, 'true' ) ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'slider' ) ); ?>"><?php esc_html_e( 'Slider Layout?', TIELABS_TEXTDOMAIN) ?></label>
			</p>

			<?php
		}


		//Find links and create the hyperlinks
		private function hyperlinks($text){
			$text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" target=\"_blank\" rel=\"nofollow noopener\">$1</a>", $text);
			$text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" target=\"_blank\" rel=\"nofollow noopener\">$1</a>", $text);
			$text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" target=\"_blank\" rel=\"nofollow noopener\">$1</a>", $text);
			$text = preg_replace('/([\.|\,|\:|\?|\?|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" target=\"_blank\" rel=\"nofollow noopener\">#$2</a>$3 ", $text);
			return $text;
		}

		//Find twitter usernames and link to them
		private function twitter_users($text){
			$text = preg_replace('/([\.|\,|\:|\?|\?|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" target=\"_blank\" rel=\"nofollow noopener\">@$2</a>$3 ", $text);
			return $text;
		}

	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_latest_tweet_widget_register' );
	function tie_latest_tweet_widget_register(){
		register_widget( 'TIE_LATEST_TWEET_WIDGET' );
	}

}
