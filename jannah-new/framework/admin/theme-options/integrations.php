<?php

tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Integrations', TIELABS_TEXTDOMAIN ),
		'id'    => 'api-keys-tab',
		'type'  => 'tab-title',
	));


$lock_settings = 'block';

if( ! get_option( 'tie_token_'.TIELABS_THEME_ID ) ){

	$lock_settings = 'none !important';

	tie_build_theme_option(
		array(
			'text' => esc_html__( 'Verify your license to unlock this section.', TIELABS_TEXTDOMAIN ),
			'type' => 'error',
		));
}

echo '<div style="display:'. $lock_settings .'" >';

tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Instagram', TIELABS_TEXTDOMAIN ),
		'id'    => 'instagram_token',
		'type'  => 'header',
	));


// Instagram
if( ! TIELABS_INSTAGRAM_FEED_IS_ACTIVE ){
	tie_build_theme_option(
		array(
			'text' => sprintf( esc_html__( 'You need to install the %s plugin to use this feature.', TIELABS_TEXTDOMAIN ), '<a href="'. admin_url('admin.php?page=tie-install-plugins') .'"><strong>TieLabs Instagram Feed</strong></a>' ),
			'type' => 'error',
		));
}
elseif( tielabs_instagram_feed_error() ){
	tie_build_theme_option(
		array(
			'text' => tielabs_instagram_feed_error(),
			'type' => 'error',
		));
}
else{

	if( tielabs_instagram_feed()->account->is_expired() ){
		tie_build_theme_option(
			array(
				'text' => esc_html__( 'The Access Token is expired, click the button below to refresh it.', TIELABS_TEXTDOMAIN ),
				'type' => 'error',
			));
	}

	?>

	<div id="footer_instagram_connect" class="option-item">
		<span class="tie-label"><?php esc_html_e( 'Instagram Account', TIELABS_TEXTDOMAIN ) ?></span>

		<?php

			$button_text  = '<span class="dashicons dashicons-instagram"></span> ' . esc_html__( 'Connect your Instagram account', TIELABS_TEXTDOMAIN );
			$button_class = 'button-primary';

			if( tielabs_instagram_feed()->account->is_active() ){

				$button_text  = esc_html__( 'Connect another account', TIELABS_TEXTDOMAIN );
				$button_class = 'button-secondary';

				if( tielabs_instagram_feed()->account->is_expired() ){
					$button_text  = esc_html__( 'Refresh Access Token', TIELABS_TEXTDOMAIN );
					$button_class = 'button-primary';
				}

				?>
				<a class="tie-instagram-account" href="<?php echo tielabs_instagram_feed()->account->profile_url(); ?>" target="_blank">
					<span class="dashicons dashicons-instagram"></span>
					<strong><?php echo tielabs_instagram_feed()->account->get('username'); ?></strong>
				</a>
				<?php
			}
		?>

		<a id="tie-connect-instagram" href="<?php echo tielabs_instagram_feed()->api->authorize() ?>" class="tie-primary-button button <?php echo $button_class; ?> tie-has-custom-action"><?php echo $button_text; ?></a>
		<input type="hidden" name="tie-connect-instagram-link" id="tie-connect-instagram-link" />
	</div>

	<?php
} // TIELABS_INSTAGRAM_FEED_IS_ACTIVE


tie_build_theme_option(
	array(
		'title' => esc_html__( 'Google Maps', TIELABS_TEXTDOMAIN ),
		'id'    => 'google-maps-api-key',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Google Maps API Key', TIELABS_TEXTDOMAIN ),
		'id'   => 'api_google_maps',
		'hint' => esc_html__( 'Used for the Map post format.', TIELABS_TEXTDOMAIN ),
		'type' => 'text',
	));

tie_build_theme_option(
	array(
		'title' => esc_html__( 'YouTube', TIELABS_TEXTDOMAIN ),
		'id'    => 'youtube-api-key',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'YouTube API Key', TIELABS_TEXTDOMAIN ),
		'id'   => 'api_youtube',
		'hint' => esc_html__( 'Used for the Videos Playlist Block.', TIELABS_TEXTDOMAIN ),
		'type' => 'text',
	));


tie_build_theme_option(
	array(
		'title' => esc_html__( 'Weather', TIELABS_TEXTDOMAIN ),
		'id'    => 'weather-api-key',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'  => esc_html__( 'OpenWeather API Key', TIELABS_TEXTDOMAIN ),
		'hint'  => '<a href="'. esc_url( 'http://openweathermap.org/appid#get' ) .'" target="_blank">'. esc_html__( 'How to get your API Key?', TIELABS_TEXTDOMAIN ) .'</a>',
		'id'    => 'api_openweather',
		'type'  => 'text',
	));

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Facebook', TIELABS_TEXTDOMAIN ),
		'id'    => 'facebook-api-key',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Facebook APP ID', TIELABS_TEXTDOMAIN ),
		'id'   => 'facebook_app_id',
		'hint' => esc_html__( 'Required for Facebook share button in the AMP pages and Select and Share module.', TIELABS_TEXTDOMAIN ),
		'type' => 'text',
	));

echo '</div>'; // Settings locked
