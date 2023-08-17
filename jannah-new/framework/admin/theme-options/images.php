<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Images Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'images-settings-tab',
		'type'  => 'tab-title',
	));

tie_build_theme_option(
	array(
		'title' => esc_html__( 'GIF Featured Image', TIELABS_TEXTDOMAIN ),
		'id'    => 'GIF-settings-section',
		'type'  => 'header',
	));


tie_build_theme_option(
	array(
		'name' => esc_html__( 'Disable GIF Featured Images', TIELABS_TEXTDOMAIN ),
		'id'   => 'disable_featured_gif',
		'type' => 'checkbox',
	));


tie_build_theme_option(
	array(
		'title' => esc_html__( 'Default Featured Image', TIELABS_TEXTDOMAIN ),
		'id'    => 'default-featured-image-settings-section',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'   => esc_html__( 'Enable', TIELABS_TEXTDOMAIN ),
		'id'     => 'default_featured_image',
		'type'   => 'checkbox',
		'toggle' => '#default_featured_image_id-item',
		'hint'   => esc_html__( 'This featured image will show up if no featured image is set.', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'The Default Image', TIELABS_TEXTDOMAIN ),
		'id'      => 'default_featured_image_id',
		'type'    => 'select_image',
	));

