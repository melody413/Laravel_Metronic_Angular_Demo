<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Logo Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'logo-settings-tab',
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
		'title' => esc_html__( 'Logo', TIELABS_TEXTDOMAIN ),
		'id'    => 'logo-settings-section',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Logo Settings', TIELABS_TEXTDOMAIN ),
		'id'      => 'logo_setting',
		'type'    => 'radio',
		'toggle'  => array(
			'logo'  => '#logo-image-settings',
			'title' => ''),
		'options'	=> array(
			'logo'  => esc_html__( 'Image', TIELABS_TEXTDOMAIN ),
			'title' => esc_html__( 'Site Title', TIELABS_TEXTDOMAIN ),
		)));

echo '<div id="logo-image-settings" class="logo_setting-options">';

tie_build_theme_option(
	array(
		'name'  => esc_html__( 'Logo Image', TIELABS_TEXTDOMAIN ),
		'id'    => 'logo',
		'type'  => 'upload',
	));

tie_build_theme_option(
	array(
		'name'  => esc_html__( 'Logo Image (Retina Version @2x)', TIELABS_TEXTDOMAIN ),
		'id'    => 'logo_retina',
		'type'  => 'upload',
		'hint'	=> esc_html__( 'Please choose an image file for the retina version of the logo. It should be 2x the size of main logo.', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name'  => esc_html__( 'Logo Inverted Image', TIELABS_TEXTDOMAIN ),
		'id'    => 'logo_inverted',
		'type'  => 'upload',
		'hint'	=> '<strong>'. esc_html__( 'Used if users are allowed to switch between Light and Dark skins.', TIELABS_TEXTDOMAIN ) .'</strong>',
	));

tie_build_theme_option(
	array(
		'name'  => esc_html__( 'Logo Inverted Image (Retina Version @2x)', TIELABS_TEXTDOMAIN ),
		'id'    => 'logo_inverted_retina',
		'type'  => 'upload',
		'hint'	=> '<strong>'. esc_html__( 'Used if users are allowed to switch between Light and Dark skins.', TIELABS_TEXTDOMAIN ) .'</strong><br />'. esc_html__( 'Please choose an image file for the retina version of the logo. It should be 2x the size of main logo.', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name'  => esc_html__( 'Logo width', TIELABS_TEXTDOMAIN ),
		'id'    => 'logo_retina_width',
		'type'  => 'number',
	));

tie_build_theme_option(
	array(
		'name'  => esc_html__( 'Logo height', TIELABS_TEXTDOMAIN ),
		'id'    => 'logo_retina_height',
		'type'  => 'number',
	));

echo '</div>';

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Logo Text', TIELABS_TEXTDOMAIN ),
		'id'      => 'logo_text',
		'type'    => 'text',
		'default' => get_bloginfo(),
		'hint'    => esc_html__( 'In the Logo Image type this will be used as the ALT text.', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Logo Margin Top', TIELABS_TEXTDOMAIN ),
		'id'   => 'logo_margin',
		'type' => 'number',
		'hint' => esc_html__( 'Leave it empty to use the default value.', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Logo Margin Bottom', TIELABS_TEXTDOMAIN ),
		'id'   => 'logo_margin_bottom',
		'type' => 'number',
		'hint' => esc_html__( 'Leave it empty to use the default value.', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name'  => esc_html__( 'Custom Logo URL', TIELABS_TEXTDOMAIN ),
		'id'    => 'logo_url',
		'type'  => 'text',
		'hint'  => esc_html__( 'Leave it empty to use the Site URL.', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Favicon', TIELABS_TEXTDOMAIN ),
		'id'    => 'set-favicon-section',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'text' => '<a href="'. admin_url( '/customize.php?autofocus[section]=title_tagline' ) .'" target="_blank">'. esc_html__( 'Click here to set a Site Icon (favicon)', TIELABS_TEXTDOMAIN ) .'</a>',
		'type' => 'message',
	));

echo '</div>'; // Settings locked
