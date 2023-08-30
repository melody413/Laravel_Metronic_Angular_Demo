<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'White Label', TIELABS_TEXTDOMAIN ),
		'id'    => 'white-label-tab',
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
		'type'  => 'message',
		'text' => esc_html__( 'For further customization on theme name, slug, thumbnail and description that appears in Appearance > Themes, please use the child theme.', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'type'  => 'header',
		'id'    => 'white-label-general',
		'title' => esc_html__( 'General', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Theme Name', TIELABS_TEXTDOMAIN ),
		'id'   => 'white_label_theme_name',
		'type' => 'text',
		'hint' => sprintf( esc_html__( 'Replace %s text in the entire admin pages.', TIELABS_TEXTDOMAIN ), '<strong>'. apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .'</strong>' ),
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Theme Options Page Logo', TIELABS_TEXTDOMAIN ),
		'id'   => 'white_label_options_logo',
		'type' => 'upload',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Menu Icon', TIELABS_TEXTDOMAIN ),
		'id'   => 'white_label_menu_icon',
		'type' => 'text',
		'hint' => '<a href="https://developer.wordpress.org/resource/dashicons/#editor-aligncenter" target="_blank">'. esc_html__( 'Choose an icon and paste the class name.', TIELABS_TEXTDOMAIN ) .'</a>',
		'placeholder' => 'dashicons-admin-generic',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Disable Help Links', TIELABS_TEXTDOMAIN ),
		'id'   => 'white_label_help_links',
		'type' => 'checkbox',
		'hint' => esc_html__( 'Enable help links from control panel and meta options.', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Disable the Knowledge Base Beacon', TIELABS_TEXTDOMAIN ),
		'id'   => 'white_label_beacon',
		'type' => 'checkbox',
	));


tie_build_theme_option(
	array(
		'type'  => 'header',
		'id'    => 'white-label',
		'title' => esc_html__( 'Posts Settings', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Only admins can manage the advanced settings in the post edit page', TIELABS_TEXTDOMAIN ),
		'id'   => 'posts_advanced_options_admin',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'type'  => 'header',
		'id'    => 'wordpress-login-page-logo',
		'title' => esc_html__( 'WordPress Login page', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'WordPress Login page Logo', TIELABS_TEXTDOMAIN ),
		'id'   => 'dashboard_logo',
		'type' => 'upload',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'WordPress Login page Logo URL', TIELABS_TEXTDOMAIN ),
		'id'   => 'dashboard_logo_url',
		'type' => 'text',
	));

echo '</div>';
