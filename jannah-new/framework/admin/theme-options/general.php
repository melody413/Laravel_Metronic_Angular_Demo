<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'General Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'general-settings-tab',
		'type'  => 'tab-title',
	));


tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Date Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'time-format-settings',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Date format for blog posts', TIELABS_TEXTDOMAIN ),
		'id'      => 'time_format',
		'type'    => 'radio',
		'options' => array(
			'traditional' => esc_html__( 'Traditional', TIELABS_TEXTDOMAIN ),
			'modern'      => esc_html__( 'Time Ago Format', TIELABS_TEXTDOMAIN ),
			'none'        => esc_html__( 'Disable all', TIELABS_TEXTDOMAIN ),
		)));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Show the date depending on', TIELABS_TEXTDOMAIN ),
		'id'      => 'time_type',
		'type'    => 'radio',
		'options' => array(
			'published' => esc_html__( 'Post Published Date', TIELABS_TEXTDOMAIN ),
			'modified'  => esc_html__( 'Post Modified Date', TIELABS_TEXTDOMAIN ),
		)));


tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Breadcrumbs Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'breadcrumbs-settings',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'   => esc_html__( 'Breadcrumbs', TIELABS_TEXTDOMAIN ),
		'id'     => 'breadcrumbs',
		'toggle' => '#breadcrumbs_delimiter-item',
		'type'   => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Breadcrumbs Delimiter', TIELABS_TEXTDOMAIN ),
		'id'      => 'breadcrumbs_delimiter',
		'type'    => 'text',
		'default' => '&#47;',
	));


tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Trim Text Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'trim-text-settings',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Trim text by', TIELABS_TEXTDOMAIN ),
		'id'      => 'trim_type',
		'type'		=> 'radio',
		'options'	=> array(
			'words' =>	esc_html__( 'Words', TIELABS_TEXTDOMAIN ) ,
			'chars'	=>	esc_html__( 'Characters', TIELABS_TEXTDOMAIN ),
		)));

tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Post format icon on hover', TIELABS_TEXTDOMAIN ),
		'id'    => 'post-font-icon',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'   => esc_html__( 'Show the post format icon on hover?', TIELABS_TEXTDOMAIN ),
		'id'     => 'thumb_overlay',
		'type'   => 'checkbox',
	));

tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Custom Codes', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Header Code', TIELABS_TEXTDOMAIN ),
		'id'   => 'header_code',
		'hint' => esc_html__( 'Will add to the &lt;head&gt; tag. Useful if you need to add additional codes such as CSS or JS.', TIELABS_TEXTDOMAIN ),
		'type' => 'textarea',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Body Code', TIELABS_TEXTDOMAIN ),
		'id'   => 'body_code',
		'hint' => esc_html__( 'Will add after opening the &lt;body&gt; tag.', TIELABS_TEXTDOMAIN ),
		'type' => 'textarea',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Footer Code', TIELABS_TEXTDOMAIN ),
		'id'   => 'footer_code',
		'hint' => esc_html__( 'Will add to the footer before the closing  &lt;/body&gt; tag. Useful if you need to add Javascript.', TIELABS_TEXTDOMAIN ),
		'type' => 'textarea',
	));

