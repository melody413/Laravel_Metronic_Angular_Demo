<?php

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'WooCommerce Settings', TIELABS_TEXTDOMAIN ),
			'id'    => 'woocommerce-tab',
			'type'  => 'tab-title',
		));

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'WooCommerce Settings', TIELABS_TEXTDOMAIN ),
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Number of products per page', TIELABS_TEXTDOMAIN ),
			'id'   => 'products_pre_page',
			'type' => 'number',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Number of the related products', TIELABS_TEXTDOMAIN ),
			'id'   => 'related_products_number',
			'type' => 'number',
		));

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'WooCommerce Sidebar Position', TIELABS_TEXTDOMAIN ),
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'id'      => 'woo_sidebar_pos',
			'type'    => 'visual',
			'options' => array(
				''      => array( esc_html__( 'Default', TIELABS_TEXTDOMAIN ) => 'default.png' ),
				'right'	=> array( esc_html__( 'Sidebar Right', TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-right.png' ),
				'left'	=> array( esc_html__( 'Sidebar Left', TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-left.png' ),
				'full'	=> array( esc_html__( 'Without Sidebar', TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-full-width.png' ),
			)));

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'WooCommerce Product Page Sidebar Position', TIELABS_TEXTDOMAIN ),
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'id'      => 'woo_product_sidebar_pos',
			'type'    => 'visual',
			'options' => array(
				''      => array( esc_html__( 'Default', TIELABS_TEXTDOMAIN ) => 'default.png' ),
				'right'	=> array( esc_html__( 'Sidebar Right', TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-right.png' ),
				'left'	=> array( esc_html__( 'Sidebar Left', TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-left.png' ),
				'full'	=> array( esc_html__( 'Without Sidebar', TIELABS_TEXTDOMAIN ) => 'sidebars/sidebar-full-width.png' ),
			)));

?>
