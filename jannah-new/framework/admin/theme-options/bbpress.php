<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'bbPress', TIELABS_TEXTDOMAIN ),
		'id'    => 'bbpress-tab',
		'type'  => 'tab-title',
	));

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Sidebar Position', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'id'      => 'bbpress_sidebar_pos',
		'type'    => 'visual',
		'options' => array(
			''      => array( esc_html__( 'Default', TIELABS_TEXTDOMAIN )         => 'default.png' ),
			'right'	=> array( esc_html__( 'Sidebar Right', TIELABS_TEXTDOMAIN )   => 'sidebars/sidebar-right.png' ),
			'left'	=> array( esc_html__( 'Sidebar Left', TIELABS_TEXTDOMAIN )    => 'sidebars/sidebar-left.png' ),
			'full'	=> array( esc_html__( 'Without Sidebar', TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-full-width.png' ),
		)));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'bbPress Sidebar', TIELABS_TEXTDOMAIN ),
		'id'      => 'sidebar_bbpress',
		'type'    => 'select',
		'options' => TIELABS_ADMIN_HELPER::get_sidebars(),
	));
