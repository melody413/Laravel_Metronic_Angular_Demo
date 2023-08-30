<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Lightbox Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'lightbox-settings-tab',
		'type'  => 'tab-title',
	));

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Lightbox Settings', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Enable Lightbox Automatically', TIELABS_TEXTDOMAIN ),
		'hint' => esc_html__( 'Enable Lightbox automatically for all images linked to an image file in the post content area', TIELABS_TEXTDOMAIN ),
		'id'   => 'lightbox_all',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Lightbox for Galleries', TIELABS_TEXTDOMAIN ),
		'hint' => esc_html__( 'Enable Lightbox automatically for all images added via [gallery] shortcode in the content area', TIELABS_TEXTDOMAIN ),
		'id'   => 'lightbox_gallery',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Lightbox Skin', TIELABS_TEXTDOMAIN ),
		'id'      => 'lightbox_skin',
		'type'    => 'select',
		'options' => array(
			'dark'        => 'dark',
			'light'       => 'light',
			'smooth'      => 'smooth',
			'metro-black' => 'metro-black',
			'metro-white' => 'metro-white',
			'mac'         => 'mac',
		)));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Lightbox Thumbnail Position', TIELABS_TEXTDOMAIN ),
		'id'      => 'lightbox_thumbs',
		'type'    => 'radio',
		'options' => array(
			'vertical'   => esc_html__( 'Vertical',   TIELABS_TEXTDOMAIN ),
			'horizontal' => esc_html__( 'Horizontal', TIELABS_TEXTDOMAIN ),
		)));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Show Lightbox Arrows', TIELABS_TEXTDOMAIN ),
		'id'   => 'lightbox_arrows',
		'type' => 'checkbox',
	));

