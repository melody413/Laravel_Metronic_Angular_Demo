<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Welcome back!', TIELABS_TEXTDOMAIN ),
		'id'    => 'dashboard-tab',
		'type'  => 'tab-title',
	));


// ---

$cached_data = get_transient( 'tie_theme_news_'. TIELABS_THEME_ID );

if( empty( $cached_data ) ){

	$body = array(
		'tie_token'      => get_option( 'tie_token_'.TIELABS_THEME_ID ),
		'theme_version'  => TIELABS_DB_VERSION,
		'item_id'        => TIELABS_THEME_ID,
		'local'          => get_locale(),
		'blog_url'       => esc_url( home_url( '/' ) ),
		'active_plugins' => get_option( 'active_plugins' ),
	);

	$response = wp_remote_post( 'https://tielabs.net/json/'. TIELABS_THEME_ID .'.php' , array(
		'headers' => array(
			'User-Agent' => 'wp/' . get_bloginfo( 'version' ) . ' ; ' . get_bloginfo( 'url' ) . ' ; ' . TIELABS_THEME_ID . ' ; ' . TIELABS_DB_VERSION,
		),
		'body'      => $body,
		'sslverify' => false,
		'timeout'   => 10,
	));

	// Check Response for errors
	$response_code    = wp_remote_retrieve_response_code( $response );
	$response_message = wp_remote_retrieve_response_message( $response );

	if ( is_wp_error( $response ) ){
		$is_error = true;
		$response_message = $response->get_error_message();
	}
	elseif ( ! empty( $response->errors ) && isset( $response->errors['http_request_failed'] ) ) {
		$is_error = true;
		$response_message = esc_html( current( $response->errors['http_request_failed'] ) );
	}
	elseif ( 200 !== $response_code ){
		$is_error = true;

		if( empty( $response_message ) ) {
			$response_message = 'Connection Error';
		}
	}

	// Check if it is a valid response
	if ( isset( $is_error ) ){
		tie_debug_log( $response_message, true );
		set_transient( 'tie_theme_news_'. TIELABS_THEME_ID, $response_message, 24 * HOUR_IN_SECONDS );
	}
	else{

		$cached_data = wp_remote_retrieve_body( $response );
		$cached_data = json_decode( $cached_data, true );
		set_transient( 'tie_theme_news_'. TIELABS_THEME_ID, $cached_data, 24 * HOUR_IN_SECONDS );
	}
}


// ---
$active_theme = wp_get_theme();

$theme = array(
	'name'           => $active_theme->Name,
	'version'        => TIELABS_DB_VERSION, //$parent_theme->Version,
	'version_latest' => tie_get_latest_theme_data( 'version' ),
);

if ( is_child_theme() ) {
	$parent_theme = wp_get_theme( $active_theme->Template );
	$theme['name'] = $parent_theme->Name;
}


if( empty( $theme['version_latest'] ) ){
	$theme['version_latest'] = 0;
}

if( ! empty( $theme['version_latest'] ) && ! empty( $cached_data['version'] ) && version_compare( $theme['version_latest'], $cached_data['version'], '<' )  ){
	$theme['version_latest'] = $cached_data['version'];
}


// Update Notice
if ( ! empty( $theme['version'] ) && ! empty( $theme['version_latest'] ) && version_compare( $theme['version'], $theme['version_latest'], '<' ) ) {

	tie_build_theme_option(
		array(
			'text' => '<strong style="font-size: 14px; color: red;">'. esc_html__( 'Important:', TIELABS_TEXTDOMAIN ) . '</strong> <strong style="font-size: 14px;"><a target="_blank" href="'. tie_get_purchase_link( array( 'utm_medium' => 'version-notice' ) ) .'">' . sprintf( esc_html__( 'There is a new version of %s available.', TIELABS_TEXTDOMAIN ), apply_filters( 'TieLabs/theme_name', 'TieLabs' ) ) .'</a></strong>',
			'type' => 'error',
		));

	echo '<br />';
}

?>

<table class="tie-status-table status-report widefat" cellspacing="0" style="margin-bottom: 20px;">
	<thead>
		<tr>
			<th colspan="2"><?php esc_html_e( 'Theme', TIELABS_TEXTDOMAIN ); ?>: <?php echo esc_html( $theme['name'] ) ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php esc_html_e( 'License', TIELABS_TEXTDOMAIN ); ?>:</td>
			<td>
				<?php
					if( get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
						echo '<strong style="color: #65b70e"><span class="dashicons dashicons-yes"></span> '. esc_html__( 'Your Site is Validated', TIELABS_TEXTDOMAIN ) .'</strong>';
					}
					else{
						echo '<strong style="color: red"><span class="dashicons dashicons-no"></span>'. esc_html__( 'Your Site is not Validated', TIELABS_TEXTDOMAIN ) .'</strong>';
					}
				?>
			</td>
		</tr>

		<?php if( get_option( 'tie_token_'.TIELABS_THEME_ID ) ): ?>
			<tr>
				<td><?php esc_html_e( 'Support', TIELABS_TEXTDOMAIN ); ?>:</td>
				<td><?php TIELABS_VERIFICATION::support_compact_notice() ?></td>
			</tr>
		<?php endif; ?>

		<tr>
			<td><?php esc_html_e( 'Version', TIELABS_TEXTDOMAIN ); ?>:</td>
			<td><?php

				echo esc_html( $theme['version'] );

				if ( ! empty( $theme['version'] ) && ! empty( $theme['version_latest'] ) && version_compare( $theme['version'], $theme['version_latest'], '<' ) ) {
					echo ' &ndash; <a style="color:orange; text-decoration: underline; font-weight: bold;" target="_blank" href="'. tie_get_purchase_link( array( 'utm_medium' => 'version-notice' ) ) .'">'. sprintf( esc_html__( '%s is available', TIELABS_TEXTDOMAIN ), esc_html( $theme['version_latest'] ) ) . '</a>';
				}
			?></td>
		</tr>
	</tbody>
</table>


<?php

do_action( 'TieLabs/Dashboard_tab/before_news' );

if( ! empty( $cached_data['deals'] ) && is_array( $cached_data['deals'] ) ){ ?>
	<table class="tie-deals-table widefat" cellspacing="0">
		<thead>
			<tr>
				<th colspan="3"><?php esc_html_e( 'News', TIELABS_TEXTDOMAIN ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ( $cached_data['deals'] as $single ) {
					tie_dashboard_news_deals( $single );
				}
			?>
		</tbody>
	</table>
	<?php
}

do_action( 'TieLabs/Dashboard_tab/after_news' );


// --
function tie_dashboard_news_deals( $data ){

	$data = wp_parse_args( $data, array(
		'url'         => '',
		'img'         => '',
		'button'      => '',
		'message'     => '',
		'bg_color'    => '',
		'state'       => '', 	//active, non-active, active-support, expired-support
		'version_min' => '',
		'version_max' => '',
		'start_date'  => '',
		'expire_date' => '',
	));


	// State
	if( ! empty( $data['state'] ) ){

		if( $data['state'] == 'active' && ! get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
			return false;
		}
		elseif( $data['state'] == 'inactive' && get_option( 'tie_token_'.TIELABS_THEME_ID ) ){
			return false;
		}

		$support_info = tie_get_support_period_info();

		if( $data['state'] == 'active-support' && ! empty( $support_info['status'] ) && $support_info['status'] == 'expired' ){
			return false;
		}
		elseif( $data['state'] == 'expired-support' && ! empty( $support_info['status'] ) && $support_info['status'] != 'expired' ){
			return false;
		}
	}

	// Function Exists
	if( ! empty( $data['function'] ) && function_exists( $data['function'] ) ){
		return false;
	}

	// Show the message if current Version is lower than
	if( ! empty( $data['version_max'] ) && version_compare( TIELABS_DB_VERSION, $data['version_max'], '>' ) ){
		return false;
	}

	// Show the message if current Version is greater than
	if( ! empty( $data['version_min'] ) && version_compare( TIELABS_DB_VERSION, $data['version_min'], '<' ) ){
		return false;
	}

	// --
	$today = strtotime( date('Y-m-d') );

	// Start date
	if( ! empty( $data['start_date'] ) ) {
		$start_date = strtotime( $data['start_date'] );

		if( $start_date > $today ){
			return false;
		}
	}

	// Expire date
	if( ! empty( $data['expire_date'] ) ) {
		$expire_date = strtotime( $data['expire_date'] );

		if( $expire_date <= $today ){
			return false;
		}
	}

	$style = ! empty( $data['bg_color'] ) ? 'style="background-color:'. $data['bg_color'] .'"' : false;
	?>

	<tr <?php echo $style ?>>
		<td style="width: 100px">
			<a href="<?php echo esc_url( $data['url'] ); ?>" target="_blank"><img src="<?php echo esc_url( $data['img'] ); ?>" style="max-width: 100%;" alt=""></a>
		</td>
		<td class="tie-deal-message"><?php echo wp_kses_post( $data['message'] ); ?></td>
		<td><a href="<?php echo esc_url( $data['url'] ); ?>" target="_blank" class="button button-primary"><?php echo wp_kses_post( $data['button'] ); ?></a></td>
	</tr>
	<?php
}

?>


<div id="dashboard-need-help">
	<div class="col column tie-info-col">
		<h3><span class="dashicons dashicons-sos"></span> <?php esc_html_e( 'Submit a Ticket', TIELABS_TEXTDOMAIN ); ?></h3>
		<p><?php esc_html_e( 'Need one-to-one assistance? Get in touch with our Support team.', TIELABS_TEXTDOMAIN ); ?></p>

		<?php

			if( get_option( 'tie_token_'.TIELABS_THEME_ID ) ){

				$support_info = tie_get_support_period_info();

				if( ! empty( $support_info['status'] ) && $support_info['status'] == 'expired' ){
					echo '<p style="font-weight:bold; color: red;">'. esc_html__( 'Your Support Period Has Expired', TIELABS_TEXTDOMAIN ) .'</p>';
				}
				else{
					?>
						<a target="_blank" class="button button-primary button-hero" href="<?php echo apply_filters( 'TieLabs/External/open_ticket', '' ); ?>"><?php esc_html_e( 'Submit a Ticket', TIELABS_TEXTDOMAIN ); ?></a>
					<?php
				}
			}
			else{

				echo '<p style="font-weight:bold; color: red;">'. esc_html__( 'You need to validate your license to access the support system.', TIELABS_TEXTDOMAIN ) .'</p>';
			}

		?>
	</div>

	<div class="col column tie-info-col">
		<h3><span class="dashicons dashicons-book"></span> <?php esc_html_e( 'Knowledge Base', TIELABS_TEXTDOMAIN ); ?></h3>
		<p><?php esc_html_e( 'This is the place to go to reference different aspects of the theme.', TIELABS_TEXTDOMAIN ); ?></p>
		<a target="_blank" class="button button-primary" href="<?php echo apply_filters( 'TieLabs/External/knowledge_base', '' ); ?>"><?php esc_html_e( 'Browse the Knowledge Base', TIELABS_TEXTDOMAIN ); ?></a>
	</div>

	<div class="col column tie-info-col">
		<h3><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'Troubleshooting', TIELABS_TEXTDOMAIN ); ?></h3>
		<p><?php esc_html_e( 'If something is not working as expected, Please try these common solutions.', TIELABS_TEXTDOMAIN ); ?></p>
		<a target="_blank" class="button button-primary" href="<?php echo apply_filters( 'TieLabs/External/troubleshooting', '' ); ?>"><?php esc_html_e( 'Visit The Page', TIELABS_TEXTDOMAIN ); ?></a>
	</div>
</div>
