<?php

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Mobile Settings', TIELABS_TEXTDOMAIN ),
			'id'    => 'mobile-settings-tab',
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
			'title' => esc_html__( 'Mobile Settings', TIELABS_TEXTDOMAIN ),
			'id'    => 'mobile-settings',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Disable the Responsiveness', TIELABS_TEXTDOMAIN ),
			'id'   => 'disable_responsive',
			'hint' => esc_html__( 'This option works only on Tablets and Phones.', TIELABS_TEXTDOMAIN ),
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Mobile Header', TIELABS_TEXTDOMAIN ),
			'id'    => 'mobile-header',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Logo Position', TIELABS_TEXTDOMAIN ),
			'id'      => 'mobile_header',
			'type'    => 'radio',
			'options' => array(
				'default'  => esc_html__( 'Default',  TIELABS_TEXTDOMAIN ),
				'centered' => esc_html__( 'Centered', TIELABS_TEXTDOMAIN ),
			)));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Logo Width', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_logo_width',
			'type' => 'number',
		));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Sticky Header', TIELABS_TEXTDOMAIN ),
			'id'     => 'stick_mobile_nav',
			'type'   => 'checkbox',
			'toggle' => '#sticky_mobile_behavior-item',
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Sticky Header behavior', TIELABS_TEXTDOMAIN ),
			'id'      => 'sticky_mobile_behavior',
			'type'    => 'radio',
			'options' => array(
				'default' => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
				'upwards' => esc_html__( 'When scrolling upwards', TIELABS_TEXTDOMAIN ),
			)));

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Mobile Header Buttons', TIELABS_TEXTDOMAIN ),
			'id'    => 'mobile-header',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Display the buttons below the logo', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_components_row',
			'type' => 'checkbox',
		));

	echo '<div class="mobile-header-options">';

		$mobile_header_areas = array(
			''       => esc_html__( 'Disable', TIELABS_TEXTDOMAIN ),
			'area_1' => esc_html__( 'Left',    TIELABS_TEXTDOMAIN ),
			'area_2' => esc_html__( 'Right',   TIELABS_TEXTDOMAIN ),
		);

		$mobile_header_components = array(
			'menu'   => esc_html__( 'Menu Button', TIELABS_TEXTDOMAIN ),
			'search' => esc_html__( 'Search', TIELABS_TEXTDOMAIN ),
			'login'  => esc_html__( 'Log In', TIELABS_TEXTDOMAIN ),
			'skin'   => esc_html__( 'Light/Dark Skin Switcher', TIELABS_TEXTDOMAIN ),
		);

		if ( TIELABS_WOOCOMMERCE_IS_ACTIVE ){
			$mobile_header_components['cart'] = esc_html__( 'Shopping Cart', TIELABS_TEXTDOMAIN );
		}

		if ( TIELABS_BUDDYPRESS_IS_ACTIVE ){
			$mobile_header_components['bp_notifications'] = esc_html__( 'BuddyPress Notifications', TIELABS_TEXTDOMAIN );
		}


		foreach ( $mobile_header_components as $key => $option_name ) {

			$args = array(
				'name'    => $option_name,
				'id'      => 'mobile_header_components_'. $key,
				'type'    => 'radio',
				'options' => $mobile_header_areas
			);

			if( $key == 'menu' ){
				$args['toggle'] = array(
					'area_1' => '#mobile-menu-options',
					'area_2' => '#mobile-menu-options',
				);
			}
			elseif( $key == 'search' ){
				$args['toggle'] = array(
					'area_1' => '#mobile_header_live_search-item',
					'area_2' => '#mobile_header_live_search-item',
				);
			}

			tie_build_theme_option( $args );

			if( $key == 'search' ){
				tie_build_theme_option(
					array(
						'name'  => esc_html__( 'Live Search', TIELABS_TEXTDOMAIN ),
						'id'    => 'mobile_header_live_search',
						'type'  => 'checkbox',
						'class' => 'mobile_header_components_search',
					));
			}
		}

	echo '</div><!-- .mobile-header-options -->';


	echo '<div id="mobile-menu-options" class="mobile_header_components_menu-options">';

		tie_build_theme_option(
			array(
				'title' => esc_html__( 'Mobile Menu', TIELABS_TEXTDOMAIN ),
				'id'    => 'mobile-menu',
				'type'  => 'header',
			));

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Mobile Menu Icon', TIELABS_TEXTDOMAIN ),
				'id'      => 'mobile_menu_icon',
				'type'    => 'visual',
				'options' => array(
					'1' => array( sprintf( esc_html__( 'Icon %s',  TIELABS_TEXTDOMAIN ), 1 ) => 'mobile/menu-1.png' ),
					'2' => array( sprintf( esc_html__( 'Icon %s',  TIELABS_TEXTDOMAIN ), 2 ) => 'mobile/menu-2.png' ),
					'3' => array( sprintf( esc_html__( 'Icon %s',  TIELABS_TEXTDOMAIN ), 3 ) => 'mobile/menu-3.png' ),
					'4' => array( sprintf( esc_html__( 'Icon %s',  TIELABS_TEXTDOMAIN ), 4 ) => 'mobile/menu-4.png' ),

					'grid-4' => array( sprintf( esc_html__( 'Icon %s',  TIELABS_TEXTDOMAIN ), 5 ) => 'mobile/menu-5.png' ),
					'grid-9' => array( sprintf( esc_html__( 'Icon %s',  TIELABS_TEXTDOMAIN ), 6 ) => 'mobile/menu-6.png' ),

					'dots-three-vertical'   => array( sprintf( esc_html__( 'Icon %s',  TIELABS_TEXTDOMAIN ), 7 ) => 'mobile/menu-7.png' ),
					'dots-three-horizontal' => array( sprintf( esc_html__( 'Icon %s',  TIELABS_TEXTDOMAIN ), 8 ) => 'mobile/menu-8.png' ),
				)));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Show menu text beside the icon', TIELABS_TEXTDOMAIN ),
				'id'   => 'mobile_menu_text',
				'type' => 'checkbox',
			));

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Mobile Menu Layout', TIELABS_TEXTDOMAIN ),
				'id'      => 'mobile_menu_layout',
				'type'    => 'visual',
				'options' => array(
					''          => array( esc_html__( 'Default',  TIELABS_TEXTDOMAIN )   => 'mobile/mobile-default.png' ),
					'fullwidth' => array( esc_html__( 'Full-Width', TIELABS_TEXTDOMAIN ) => 'mobile/mobile-fullwidth.png' ),
				)));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Parent items as links', TIELABS_TEXTDOMAIN ),
				'hint' => esc_html__( 'If disabled, parent menu items will only toggle child items.', TIELABS_TEXTDOMAIN ),
				'id'   => 'mobile_menu_parent_link',
				'type' => 'checkbox',
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Show the icons', TIELABS_TEXTDOMAIN ),
				'id'   => 'mobile_menu_icons',
				'type' => 'checkbox',
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Search', TIELABS_TEXTDOMAIN ),
				'id'   => 'mobile_menu_search',
				'type' => 'checkbox',
				'toggle' => '#mobile_menu_search_position-item',
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Search Position', TIELABS_TEXTDOMAIN ),
				'id'   => 'mobile_menu_search_position',
				'type' => 'radio',
				'options' => array(
					'top'    => esc_html__( 'Top', TIELABS_TEXTDOMAIN ),
					'bottom' => esc_html__( 'Bottom', TIELABS_TEXTDOMAIN ),
				),
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Social Icons', TIELABS_TEXTDOMAIN ),
				'id'   => 'mobile_menu_social',
				'type' => 'checkbox',
			));

		tie_build_theme_option(
			array(
				'name'    => esc_html__( 'Mobile Menu', TIELABS_TEXTDOMAIN ),
				'id'      => 'mobile_the_menu',
				'type'    => 'select',
				'options' => TIELABS_ADMIN_HELPER::get_menus( false, array( '' => esc_html__( 'Main Nav Menu', TIELABS_TEXTDOMAIN ), 'main-secondary' => esc_html__( 'Main Nav and Secondary Nav Menus', TIELABS_TEXTDOMAIN ) ) ),
			));

	echo '</div><!-- #mobile-menu-options -->';

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Single Post Page', TIELABS_TEXTDOMAIN ),
			'id'    => 'mobile-single-post-page',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name' => '<strong>'. esc_html__( 'Show More', TIELABS_TEXTDOMAIN ) .':</strong> '. esc_html__( 'Compact the post content and show more button', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_post_show_more',
			'type' => 'checkbox',
		));


	// Sidebars on Mobile
	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Sidebars on Mobile', TIELABS_TEXTDOMAIN ),
			'id'    => 'mobile-elements',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Display sidebars before the content', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_sidebar_before_content',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide all sidebars', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_sidebars',
			'type' => 'checkbox',
		));

	// Mobile Elements
	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Mobile Elements', TIELABS_TEXTDOMAIN ),
			'id'    => 'mobile-elements',
			'type'  => 'header',
		));



	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Header Breaking News', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_breaking_news',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Instagram Media Above Footer', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_footer_instagram',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide the Footer', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_footer',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide copyright area', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_copyright',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Breadcrumbs', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_breadcrumbs',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Read More Buttons', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_read_more_buttons',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Inline Related posts', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_inline_related_posts',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Above Post share Buttons', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_share_post_top',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Below Post share Buttons', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_share_post_bottom',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Below Post Newsletter', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_post_newsletter',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Below Post Read Next', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_read_next',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Below Post Related posts', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_related',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Below Post Author Box', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_post_authorbio',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Below Post Next/Prev posts', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_post_nav',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Hide Back to top button', TIELABS_TEXTDOMAIN ),
			'id'   => 'mobile_hide_back_top_button',
			'type' => 'checkbox',
		));



	$theme_ads = array(
		'banner_header'        => esc_html__( 'Above Header Ad', TIELABS_TEXTDOMAIN ),
		'banner_top'           => esc_html__( 'Header Ad', TIELABS_TEXTDOMAIN ),
		'banner_bottom'        => esc_html__( 'Above Footer Ad', TIELABS_TEXTDOMAIN ),
		'banner_below_header'  => esc_html__( 'Below the Header Ad', TIELABS_TEXTDOMAIN ),
		'banner_above'         => esc_html__( 'Above Article Ad', TIELABS_TEXTDOMAIN ),
		'banner_above_content' => esc_html__( 'Above Article Content Ad', TIELABS_TEXTDOMAIN ),
		'banner_below_content' => esc_html__( 'Below Article Content Ad', TIELABS_TEXTDOMAIN ),
		'banner_below'         => esc_html__( 'Below Article Ad', TIELABS_TEXTDOMAIN ),
		'banner_comments'      => esc_html__( 'Below Comments Ad', TIELABS_TEXTDOMAIN ),

		/*
		'banner_category_below_slider' => esc_html__( 'Category Pages: Below the slider', TIELABS_TEXTDOMAIN ),
		'banner_category_above_title'  => esc_html__( 'Category Pages: Above the title', TIELABS_TEXTDOMAIN ),
		'banner_category_below_title'  => esc_html__( 'Category Pages: Below the title', TIELABS_TEXTDOMAIN ),

		'banner_category_below_posts'      => esc_html__( 'Category Pages: Below Posts', TIELABS_TEXTDOMAIN ),
		'banner_category_below_pagination' => esc_html__( 'Category Pages: Below Pagination', TIELABS_TEXTDOMAIN ),

		'between_posts_1'      => sprintf( esc_html__( 'Between Posts in Archives #%s', TIELABS_TEXTDOMAIN ), 1 ),
		'between_posts_2'      => sprintf( esc_html__( 'Between Posts in Archives #%s', TIELABS_TEXTDOMAIN ), 2 ),

		'article_inline_ad_1'  => sprintf( esc_html__( 'Article inline ad #%s', TIELABS_TEXTDOMAIN ), 1 ),
		'article_inline_ad_2'  => sprintf( esc_html__( 'Article inline ad #%s', TIELABS_TEXTDOMAIN ), 2 ),
		'article_inline_ad_3'  => sprintf( esc_html__( 'Article inline ad #%s', TIELABS_TEXTDOMAIN ), 3 ),
		'article_inline_ad_4'  => sprintf( esc_html__( 'Article inline ad #%s', TIELABS_TEXTDOMAIN ), 4 ),
		'article_inline_ad_5'  => sprintf( esc_html__( 'Article inline ad #%s', TIELABS_TEXTDOMAIN ), 5 ),
		*/
	);

	foreach( $theme_ads as $ad => $name ){

		tie_build_theme_option(
			array(
				'name' => sprintf( esc_html__( 'Hide %s', TIELABS_TEXTDOMAIN ), $name ),
				'id'   => 'mobile_hide_'. $ad,
				'type' => 'checkbox',
			));
	}

	# General share buttons settings
	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Sticky Mobile Share Buttons', TIELABS_TEXTDOMAIN ),
			'id'    => 'sticky-mobile-share',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Sticky Mobile Share Buttons', TIELABS_TEXTDOMAIN ),
			'id'     => 'share_post_mobile',
			'type'   => 'checkbox',
			'toggle' => '#mobile-share-buttons',
		));

	echo '<div id="mobile-share-buttons">';
		tie_get_share_buttons_options( 'mobile' );
	echo '</div>';

echo '</div>'; // Settings locked
