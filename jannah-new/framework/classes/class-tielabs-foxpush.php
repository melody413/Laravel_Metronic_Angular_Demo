<?php
/**
 * FoxPush Class
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_FOXPUSH' ) ) {

	class TIELABS_FOXPUSH{

		/**
		 * __construct
		 *
		 */
		function __construct(){

		}


		/**
		 * run
		 *
		 * Call our filter and action hooks.
		 */
		function run(){

			// Actions
			add_action( 'wp_ajax_tie-foxpush-send-campaign', array( $this, 'create_campaign' ) );
			add_action( 'wp_ajax_tie-foxpush-show-campaign', array( $this, 'show_campaigns' ) );
			add_action( 'wp_footer',                         array( $this, 'get_embed_code' ) );
			add_action( 'add_meta_boxes',                    array( $this, 'post_meta_boxes' ) );
		}


		/**
		 * get_embed_code
		 *
		 * Get the Js Embed Code
		 */
		function get_embed_code(){

			// If the Web notificatiosn is enabled
			if( ! tie_get_option( 'web_notifications' ) || TIELABS_HELPER::is_bot() ){

				return false;
			}

			// Get codes and data
			$foxpush_domain = tie_get_option( 'foxpush_domain' );
			$foxpush_apikey = tie_get_option( 'foxpush_api' );

			if( empty( $foxpush_domain ) || empty( $foxpush_apikey ) ){
				return false;
			}

			$foxpush_domain = str_replace( '.', '', strtolower( $foxpush_domain ) );

			$code = "
        var _foxpush = _foxpush || [];
        _foxpush.push(['_setDomain', '$foxpush_domain']);

        (function(){
            var foxscript = document.createElement('script');
            foxscript.src = '//cdn.foxpush.net/sdk/foxpush_SDK_min.js';
            foxscript.type = 'text/javascript';
            foxscript.async = 'true';
            var fox_s = document.getElementsByTagName('script')[0];
            fox_s.parentNode.insertBefore(foxscript, fox_s);})();
			";

			TIELABS_HELPER::inline_script( 'tie-scripts', apply_filters( 'TieLabs/foxpush_embedcode', $code ) );
		}


		/**
		 * post_meta_boxes
		 *
		 * Post meta boxes
		 */
		function post_meta_boxes(){

			// Make some checks on before showing the boxes
			if( tie_get_option( 'web_notifications' ) && tie_get_option( 'foxpush_domain' ) && tie_get_option( 'foxpush_api' ) ){

				// Campagins States
				if( 'publish' === get_post_status( get_the_ID() ) ){

					$get_campaigns = get_post_meta( get_the_ID(), 'foxpush_campaigns_data', true );

					if( $get_campaigns && is_array( $get_campaigns ) ){

						add_meta_box(
							'foxpush-get-campaigns',
							esc_html__( 'Web Notification Campaigns', TIELABS_TEXTDOMAIN ),
							array( $this, 'get_meta_box_content' ),
							TIELABS_HELPER::get_supported_post_types(),
							'side'
						);
					}
				}

				// Send notifications meta box
				add_meta_box(
					'foxpush-create-campaign',
					esc_html__( 'Send a Web Notification', TIELABS_TEXTDOMAIN ),
					array( $this, 'send_meta_box_content' ),
					TIELABS_HELPER::get_supported_post_types(),
					'side'
				);
			}
		}


		/**
		 * get_meta_box_content
		 *
		 * Show the campaigns data
		 */
		function get_meta_box_content( $post_id = false, $meta_box_atts = false ){

			$post_id = ! empty( $post_id->ID ) ? $post_id->ID : $post_id;

			// Show the Campaigns
			$get_campaigns = get_post_meta( $post_id, 'foxpush_campaigns_data', true );

			if( $get_campaigns && is_array( $get_campaigns ) ){

				if( $meta_box_atts ){
					echo '<div class="campaigns-statistics">'. esc_html__( 'Statistics (Updated Hourly)', TIELABS_TEXTDOMAIN ) .' <a href="#" id="update-campaign-status" class="button">'. esc_html__( 'Update', TIELABS_TEXTDOMAIN ) .'</a></div>';
				}

				echo '<div id="campaigns-statistics-tables">';

				foreach ( $get_campaigns as $campaign_id => $campaign_data ) {

					if( empty( $campaign_data['timeout'] ) || ! $meta_box_atts || ( ! empty( $campaign_data['timeout'] ) && ( time() - $campaign_data['timeout'] ) > HOUR_IN_SECONDS ) ){

						$campaign_data = $this->get_campaign_data( $campaign_id );

						if( ! empty( $campaign_data ) ){

							# If it waiting or Pending we need to recall the API to get the data
							if( $campaign_data['status'] == 'done' ){

								$campaign_data['timeout'] = time();
							}

							$get_campaigns[ $campaign_id ] = $campaign_data;
						}
					}

					echo '
						<br />

						<table class="wp-list-table widefat striped">
							<thead>
							<tr>
								<th colspan="3"><strong>#'. $campaign_id .'</strong> <span class="campaign-status status-'.$campaign_data['status'].'">'. $campaign_data['status'] .'</span></th>
							</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="3">'. esc_html__( 'Date', TIELABS_TEXTDOMAIN ) .': '. $campaign_data['created_time'] .'</td>
								</tr>
								<tr>
									<td>'. esc_html__( 'Sent', TIELABS_TEXTDOMAIN ) .'</td>
									<td>'. esc_html__( 'Views', TIELABS_TEXTDOMAIN ) .'</td>
									<td>'. esc_html__( 'Clicks', TIELABS_TEXTDOMAIN ) .'</td>
								</tr>
								<tr>
									<td>'. $campaign_data['sent'] .'</td>
									<td>'. $campaign_data['views'] .'</td>
									<td>'. $campaign_data['clicks'] .'</td>
								</tr>
							</tbody>
						</table>
					';
				}

				echo '</div>';
				echo '<span class="foxpush-spinner spinner"></span>';

				update_post_meta( $post_id, 'foxpush_campaigns_data', $get_campaigns );


				if( ! $meta_box_atts ) die;
			}
		}


		/**
		 * send_meta_box_content
		 *
		 * Send a Push notification directly from the post page
		 */
		function send_meta_box_content(){

			if( ! get_option( 'tie_token_'.TIELABS_THEME_ID ) ){

				tie_build_theme_option(
					array(
						'text' => esc_html__( 'Verify your license to use this feature.', TIELABS_TEXTDOMAIN ),
						'type' => 'error',
					));

				return;
			}

			elseif( 'publish' !== get_post_status( get_the_ID() ) ){

				tie_build_theme_option(
					array(
						'text' => esc_html__( 'You need to publish the post first.', TIELABS_TEXTDOMAIN ),
						'type' => 'message',
					));

				return;
			}

			echo '<div id="send-notification-options">';

				tie_build_option(
					array(
						'placeholder' => esc_html__( 'Title', TIELABS_TEXTDOMAIN ),
						'default'     => tie_get_title( 49, 'chars' ),
						'id'          => 'tie_foxpush_title',
						'type'        => 'text',
					),
					'tie_foxpush_title',
					false
				);

				tie_build_option(
					array(
						'placeholder' => esc_html__( 'Message', TIELABS_TEXTDOMAIN ),
						'id'          => 'tie_foxpush_msg',
						'type'        => 'text',
					),
					'tie_foxpush_msg',
					false
				);

				tie_build_option(
					array(
						'custom_text' => esc_html__( 'Upload Icon', TIELABS_TEXTDOMAIN ),
						'hint'        => sprintf( esc_html__( 'Recommended size is %1spx x %2spx', TIELABS_TEXTDOMAIN ), 250, 250 ),
						'id'          => 'tie_foxpush_icon',
						'type'        => 'upload',
					),
					'tie_foxpush_icon',
					false
				);

				echo '
					<input type="hidden" id="foxpush_post_id" name="foxpush_post_id" value="'. get_the_ID() .'" />

					<div class="clear"></div>

					<div id="send-notification-actions">
						<a id="send-notification" class="button button-primary button-large">'. esc_html__( 'Send', TIELABS_TEXTDOMAIN ) .'</a>
					</div>
				';

			echo '</div>';
			echo '<span class="foxpush-spinner spinner"></span>';

		}


		/**
		 * get_statistics
		 *
		 * FoxPush Statistics
		 */
		function get_statistics( $type = 'chart' ){

			$foxpush_domain = tie_get_option( 'foxpush_domain' );
			$foxpush_apikey = tie_get_option( 'foxpush_api' );

			if( empty( $foxpush_domain ) || empty( $foxpush_apikey ) ){
				return false;
			}

			// Get stored data
			if( $type == 'stats' ){
				$data = get_transient( 'tie_foxpush_stats' );
				$api_path = 'stats';
			}
			else{
				$data = get_transient( 'tie_foxpush_chart' );
				$api_path = 'daily_chart';
			}

			// Get New data
			if( empty( $data ) ) {

				$args = array(
					'headers'     => array(
						'FOXPUSH_DOMAIN' => TIELABS_HELPER::remove_spaces( $foxpush_domain ),
						'FOXPUSH_TOKEN'  => TIELABS_HELPER::remove_spaces( $foxpush_apikey ),
					)
				);

				add_filter( 'https_ssl_verify', '__return_false' );

				$api_url = 'https://api.foxpush.com/v1/publisher/'.$api_path;
				$request = wp_remote_get( $api_url , $args );
				$request = wp_remote_retrieve_body( $request );
				$request = json_decode( $request, true );


				# Store the new data
				if( $type == 'stats' ){
					if( ! empty( $request['total_subscribers'] ) ) {
						$data = $request;
						set_transient( 'tie_foxpush_stats', $data, HOUR_IN_SECONDS );
					}
				}
				else{
					if( ! empty( $request['chart'] ) ) {
						$data = $request['chart'];
						set_transient( 'tie_foxpush_chart', $data, HOUR_IN_SECONDS );
					}
				}
			}

			return ! empty( $data ) ? $data : '';
		}


		/**
		 * create_campaign
		 *
		 * Send a Post Campaign
		 */
		function create_campaign(){

			$domain  = tie_get_option( 'foxpush_domain' );
			$api_key = tie_get_option( 'foxpush_api' );

			// check
			if( ! $domain || ! $api_key || empty( $_REQUEST['title'] ) || empty( $_REQUEST['message'] ) || empty( $_REQUEST['id'] ) ){

				tie_build_theme_option(
					array(
						'text' => esc_html__( 'Requried data Missing', TIELABS_TEXTDOMAIN ),
						'type' => 'error',
					));

				die;
			}

			// Prepare the request data
			$args = array(
				'headers' => array(
					'FOXPUSH_DOMAIN' => $domain,
					'FOXPUSH_TOKEN'  => $api_key,
				),
				'body' => array(
					'name'    => esc_html( $_REQUEST['title'] ),
					'title'   => esc_html( $_REQUEST['title'] ),
					'message' => esc_html( $_REQUEST['message'] ),
					'url'     => get_permalink( $_REQUEST['id'] ),
				),
			);

			// Attach the image if it exists
			if( ! empty( $_REQUEST['image'] ) ){

				$args['body']['icon'] =	$_REQUEST['image'];
				$args['body']['check_image'] = 1;
			}

			// Go
			$api_url = 'https://api.foxpush.com/v1/campaigns/create/';
			$request = wp_remote_post( $api_url, $args );

			// Check if there is an error
			if ( is_wp_error( $request ) ) {

				tie_build_theme_option(
					array(
						'text' => esc_html( $request->get_error_message() ),
						'type' => 'error',
					));

				die;
			}

			// No? then get the body response
			$request = wp_remote_retrieve_body( $request );
			$request = json_decode( $request, true );


			if( ! empty( $request['code'] ) ){
				if( $request['code'] == '411' && $request['error_message'] == 'hotlink_image' ){

					tie_build_theme_option(
						array(
							'text' => esc_html__( 'Can not access the image from your server, send the Campaign from your account on FoxPush.com', TIELABS_TEXTDOMAIN ),
							'type' => 'error',
						));

					die;
				}
				elseif( $request['code'] == '200' && ! empty( $request['campaign_id'] ) ){

					$campaign_id = $request['campaign_id'];

					// Get All Stored Campaigns
					$get_campaigns = get_post_meta( $_REQUEST['id'], 'foxpush_campaigns_data', true );
					$get_campaigns = ( empty( $get_campaigns ) || ! array( $get_campaigns ) ) ? array() : $get_campaigns;

					// Store the data of the new Campaign
					$get_campaigns[ $campaign_id ] = '';

					// Update the Stored Campaigns
					$update_campaigns = update_post_meta( $_REQUEST['id'], 'foxpush_campaigns_data', $get_campaigns );

					tie_build_theme_option(
						array(
							'text' => esc_html__( 'Campaign has been sent', TIELABS_TEXTDOMAIN ),
							'type' => 'success',
						));

					die;
				}
			}
		}


		/**
		 * show_campaigns
		 *
		 * Show campaigns via AJAX
		 */
		function show_campaigns(){

			if( empty( $_REQUEST['id'] ) ){
				return false;
			}

			$this->get_meta_box_content( $_REQUEST['id'], false );
		}


		/**
		 * get_campaign_data
		 *
		 * Get the campaigns data from the API
		 */
		function get_campaign_data( $campaign_id ){

			// Request the campaign data
			$args = array(
				'headers' => array(
					'FOXPUSH_DOMAIN' => tie_get_option( 'foxpush_domain' ),
					'FOXPUSH_TOKEN'  => tie_get_option( 'foxpush_api' ),
				)
			);

			// Go
			$api_url = 'https://api.foxpush.com/v1/campaigns/get/'. $campaign_id;
			$request = wp_remote_get( $api_url, $args );

			# Check if there is an error
			if ( is_wp_error( $request ) ) {
				echo esc_html( $request->get_error_message() );
				die;
			}

			$request = wp_remote_retrieve_body( $request );
			$request = json_decode( $request, true );

			if( ! empty( $request['campaign'] ) ){

				$campaign = $request['campaign'];

				// Remove the unwanted data
				unset( $campaign['message'] );
				unset( $campaign['name'] );
				unset( $campaign['image'] );
				unset( $campaign['url'] );

				return $campaign;
			}
		}

	}

	// Instantiate the class
	$foxpush = new TIELABS_FOXPUSH();
	$foxpush->run();
}
