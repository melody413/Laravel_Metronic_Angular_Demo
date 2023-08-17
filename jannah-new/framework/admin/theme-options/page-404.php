<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( '404 Page Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'page-404-tab',
		'type'  => 'tab-title',
	));

tie_build_theme_option(
	array(
		'title' => esc_html__( '404 Page Settings', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Image above the main title', TIELABS_TEXTDOMAIN ),
		'id'   => 'page_404_img',
		'type' => 'upload',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Enable Search', TIELABS_TEXTDOMAIN ),
		'id'   => 'page_404_search',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Enable Menu', TIELABS_TEXTDOMAIN ),
		'id'   => 'page_404_menu',
		'type' => 'checkbox',
		'hint' => '<a href="'. admin_url( '/nav-menus.php' ) .'" target="_blank">'. esc_html__( 'You can set the menu in the Menus page.', TIELABS_TEXTDOMAIN ) .'</a>',
	));

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Texts', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'text' => esc_html__( 'You can change the texts from the Translations section.', TIELABS_TEXTDOMAIN ),
		'type' => 'message',
	));
