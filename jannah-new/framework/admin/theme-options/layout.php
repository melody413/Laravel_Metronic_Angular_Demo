<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Layout', TIELABS_TEXTDOMAIN ),
		'id'    => 'layout-tab',
		'type'  => 'tab-title',
	));

tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Site Width', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Site Width', TIELABS_TEXTDOMAIN ),
		'id'      => 'site_width',
		'type'    => 'text',
		'default' => '1200px',
		'hint'    => esc_html__( 'Controls the overall site width. In px or %, ex: 100% or 1170px.', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Sidebar Column Width', TIELABS_TEXTDOMAIN ),
		'id'      => 'sidebar_width',
		'type'    => 'number',
		'hint'    => esc_html__( 'Controls the sidebar column width in %.', TIELABS_TEXTDOMAIN ),
	));


tie_build_theme_option(
	array(
		'title' => esc_html__( 'Theme Layout', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'id'      => 'theme_layout',
		'type'    => 'visual',
		'options' => array(
			'full'   => array( esc_html__( 'Full-Width', TIELABS_TEXTDOMAIN ) => 'layouts/layout-full.png'   ),
			'boxed'  => array( esc_html__( 'Boxed', TIELABS_TEXTDOMAIN )      => 'layouts/layout-boxed.png'  ),
			'framed' => array( esc_html__( 'Framed', TIELABS_TEXTDOMAIN )     => 'layouts/layout-framed.png' ),
			'border' => array( esc_html__( 'Bordered', TIELABS_TEXTDOMAIN )   => 'layouts/layout-border.png' ),
		)));


	tie_build_theme_option(
		array(
			'title' =>	esc_html__( 'Loader Icon', TIELABS_TEXTDOMAIN ),
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'id'      => 'loader-icon',
			'type'    => 'visual',
			'options' => array(
				'1'	=> 'ajax-loader-1.png',
				'2' => 'ajax-loader-2.png',
			)));
