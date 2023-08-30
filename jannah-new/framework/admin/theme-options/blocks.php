<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Blocks Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'blocks-tab',
		'type'  => 'tab-title',
	));


tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Block Style', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));


tie_build_theme_option(
	array(
		'id'      => 'boxes_style',
		'type'    => 'visual',
		'options' => array(
			'1'	=> array( esc_html__( 'Bordered', TIELABS_TEXTDOMAIN ) => 'blocks/magazine-1.png' ),
			'3' => array( esc_html__( 'Rounded', TIELABS_TEXTDOMAIN )  => 'blocks/magazine-3.png' ),
			'2' => array( esc_html__( 'Clean', TIELABS_TEXTDOMAIN )    => 'blocks/magazine-2.png' ),
		)));

tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Block Head Style', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));


tie_build_theme_option(
	array(
		'id'      => 'blocks_style',
		'type'    => 'visual',
		'options' => array(
			'1'	=> array( esc_html__( 'Style', TIELABS_TEXTDOMAIN ) .' #1' => 'blocks/head-1.png' ),
			'2' => array( esc_html__( 'Style', TIELABS_TEXTDOMAIN ) .' #2' => 'blocks/head-2.png' ),
			'3' => array( esc_html__( 'Style', TIELABS_TEXTDOMAIN ) .' #3' => 'blocks/head-3.png' ),
			'4' => array( esc_html__( 'Style', TIELABS_TEXTDOMAIN ) .' #4' => 'blocks/head-4.png' ),
			'5' => array( esc_html__( 'Style', TIELABS_TEXTDOMAIN ) .' #5' => 'blocks/head-5.png' ),
			'6' => array( esc_html__( 'Style', TIELABS_TEXTDOMAIN ) .' #6' => 'blocks/head-6.png' ),
			'7' => array( esc_html__( 'Style', TIELABS_TEXTDOMAIN ) .' #7' => 'blocks/head-7.png' ),
			'8' => array( esc_html__( 'Style', TIELABS_TEXTDOMAIN ) .' #8' => 'blocks/head-8.png' ),
			'9' => array( esc_html__( 'Style', TIELABS_TEXTDOMAIN ) .' #9' => 'blocks/head-9.png' ),
			'10' => array( esc_html__( 'Style', TIELABS_TEXTDOMAIN ) .' #10' => 'blocks/head-10.png' ),
			'11' => array( esc_html__( 'Style', TIELABS_TEXTDOMAIN ) .' #11' => 'blocks/head-11.png' ),
		)));


// Global Blocks Meta Settings
tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Blocks Meta Settings', TIELABS_TEXTDOMAIN ),
		'id'    =>	'blocks-meta-settings',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Disable Author name meta', TIELABS_TEXTDOMAIN ),
		'id'   => 'blocks_disable_author_meta',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Disable Comments number meta', TIELABS_TEXTDOMAIN ),
		'id'   => 'blocks_disable_comments_meta',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Disable Views Number meta', TIELABS_TEXTDOMAIN ),
		'id'   => 'blocks_disable_views_meta',
		'type' => 'checkbox',
	));


// Global Sliders Settings
tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Sliders Settings', TIELABS_TEXTDOMAIN ),
		'id'    =>	'blocks-meta-settings',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'    =>  esc_html__( 'Default Featured Image Position', TIELABS_TEXTDOMAIN ),
		'id'      => 'background_position',
		'type'    => 'select',
		'options' => array(
			''            => esc_html__( 'Default',     TIELABS_TEXTDOMAIN ),
			'left top'    => esc_html__( 'Left Top',    TIELABS_TEXTDOMAIN ),
			'left center' => esc_html__( 'Left Center', TIELABS_TEXTDOMAIN ),
			'left bottom' => esc_html__( 'Left Bottom', TIELABS_TEXTDOMAIN ),

			'right top'    => esc_html__( 'Right Top',    TIELABS_TEXTDOMAIN ),
			'right center' => esc_html__( 'Right Center', TIELABS_TEXTDOMAIN ),
			'right bottom' => esc_html__( 'Right Bottom', TIELABS_TEXTDOMAIN ),

			'center top'    => esc_html__( 'Center Top',    TIELABS_TEXTDOMAIN ),
			'center center' => esc_html__( 'Center Center', TIELABS_TEXTDOMAIN ),
			'center bottom' => esc_html__( 'Center Bottom', TIELABS_TEXTDOMAIN ),
		),
	));
