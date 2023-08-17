<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Advertisement Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'advertisements-settings-tab',
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
		'text' => esc_html__( 'It is recommended to avoid using words like ad, ads, adv, advert, advertisement, banner, banners, sponsor, 300x250, 728x90, etc. in the image names or image path to avoid AdBlocks from blocking your Ad.', TIELABS_TEXTDOMAIN ),
		'type' => 'message',
	));

tie_build_theme_option(
	array(
		'title'   => esc_html__( 'Ad Blocker Detector', TIELABS_TEXTDOMAIN ),
		'id'    => 'ad-blocker-detector',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'   => esc_html__( 'Ad Blocker Detector', TIELABS_TEXTDOMAIN ),
		'id'     => 'ad_blocker_detector',
		'toggle' => '#adblock_title-item, #adblock_message-item, #adblock_background-item',
		'type'   => 'checkbox',
		'hint'   => esc_html__( 'Block the adblockers from browsing the site, till they turnoff the Ad Blocker', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Title', TIELABS_TEXTDOMAIN ),
		'id'   => 'adblock_title',
		'type' => 'text',
		'placeholder' => esc_html__( 'Adblock Detected', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Message', TIELABS_TEXTDOMAIN ),
		'id'   => 'adblock_message',
		'type' => 'textarea',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Background Color', TIELABS_TEXTDOMAIN ),
		'id'   => 'adblock_background',
		'type' => 'color',
	));

tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Background Image Ad', TIELABS_TEXTDOMAIN ),
		'id'    => 'background-image-ad',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'   => esc_html__( 'Full Page Takeover', TIELABS_TEXTDOMAIN ),
		'id'     => 'banner_bg',
		'toggle' => '#banner_bg_url-item, #banner_bg_img-item, #banner_bg_site_margin-item',
		'type'   => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Link', TIELABS_TEXTDOMAIN ),
		'id'   => 'banner_bg_url',
		'type' => 'text',
	));

tie_build_theme_option(
	array(
		'name'  => esc_html__( 'Background Image', TIELABS_TEXTDOMAIN ),
		'id'    => 'banner_bg_img',
		'type'  => 'background',
	));

tie_build_theme_option(
	array(
		'name'  => esc_html__( 'Site margin top', TIELABS_TEXTDOMAIN ),
		'id'    => 'banner_bg_site_margin',
		'type'  => 'number',
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
);

foreach( $theme_ads as $ad => $name ){

	tie_build_theme_option(
		array(
			'title' => $name,
			'type'  => 'header',
			'id'    => $ad . '-ad',
		));

	tie_build_theme_option(
		array(
			'name'   => $name,
			'id'     => $ad,
			'type'   => 'checkbox',
			'toggle' => '#'.$ad.'_title-item, #'.$ad.'_title_link-item, #'.$ad.'_img-item, #'.$ad.'_img_width-item, #'.$ad.'_img_height-item, #'.$ad.'_posts_number-item, #'.$ad.'_paragraphs_number-item, #'.$ad.'_align-item, #'.$ad.'_url-item, #'.$ad.'_alt-item, #'.$ad.'_tab-item, #'.$ad.'_nofollow-item, #' .$ad. '_adsense-item, #'.$ad.'-adrotate-options',
		));


	// Custom Ads Options
	if( strpos( $ad, 'between_posts' ) !== false ){

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Number of posts before the Ad', TIELABS_TEXTDOMAIN ),
				'id'   => $ad.'_posts_number',
				'type' => 'number',
			));
	}
	elseif( strpos( $ad, 'article_inline_ad' ) !== false ){

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Number of paragraphs before the Ad', TIELABS_TEXTDOMAIN ),
				'id'   => $ad.'_paragraphs_number',
				'type' => 'number',
			));


		tie_build_theme_option(
			array(
				'name'    => esc_html__( 'Ad Alignment', TIELABS_TEXTDOMAIN ),
				'id'      => $ad.'_align',
				'type'    => 'radio',
				'options' => array(
					'center' => esc_html__( 'Center', TIELABS_TEXTDOMAIN ),
					'right'  => esc_html__( 'Right',  TIELABS_TEXTDOMAIN ),
					'left'   => esc_html__( 'Left',   TIELABS_TEXTDOMAIN ),
				)));
	}


	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Ad Title', TIELABS_TEXTDOMAIN ),
			'hint' => esc_html__( 'A title for the Ad, like Advertisement - leave this empty to disable.', TIELABS_TEXTDOMAIN ),
			'id'   => $ad.'_title',
			'type' => 'text',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Ad Title Link', TIELABS_TEXTDOMAIN ),
			'id'   => $ad.'_title_link',
			'type' => 'text',
		));

	tie_build_theme_option(
		array(
			'name'     => esc_html__( 'Ad Image', TIELABS_TEXTDOMAIN ),
			'id'       => $ad.'_img',
			'pre_text' => esc_html__( 'Ad Image', TIELABS_TEXTDOMAIN ),
			'type'     => 'upload',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Ad Image Width', TIELABS_TEXTDOMAIN ),
			'id'   => $ad.'_img_width',
			'type' => 'number',
			'hint' => '<a href="https://web.dev/cls/" target="_blank">'. esc_html__( 'Recommended to reduce Cumulative Layout Shift (CLS)', TIELABS_TEXTDOMAIN ) .'</a>',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Ad Image Height', TIELABS_TEXTDOMAIN ),
			'id'   => $ad.'_img_height',
			'type' => 'number',
			'hint' => '<a href="https://web.dev/cls/" target="_blank">'. esc_html__( 'Recommended to reduce Cumulative Layout Shift (CLS)', TIELABS_TEXTDOMAIN ) .'</a>',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Ad URL', TIELABS_TEXTDOMAIN ),
			'id'   => $ad.'_url',
			'type' => 'text',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Alternative Text For The image', TIELABS_TEXTDOMAIN ),
			'id'   => $ad.'_alt',
			'type' => 'text',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Open The Link In a new Tab', TIELABS_TEXTDOMAIN ),
			'id'   => $ad.'_tab',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Nofollow?', TIELABS_TEXTDOMAIN ),
			'id'   => $ad.'_nofollow',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name'     => esc_html__( 'Custom Ad Code', TIELABS_TEXTDOMAIN ),
			'id'       => $ad.'_adsense',
			'pre_text' => esc_html__( '- OR -', TIELABS_TEXTDOMAIN ) . ' ' . esc_html__( 'Custom Ad Code', TIELABS_TEXTDOMAIN ),
			'hint'     => esc_html__( 'Supports: Text, HTML and Shortcodes.', TIELABS_TEXTDOMAIN ),
			'type'     => 'textarea',
		));

	if( function_exists( 'adrotate_ad' ) ) {

		echo '<div id="'.$ad.'-adrotate-options">';

		tie_build_theme_option(
			array(
				'name'     => esc_html__( 'AdRotate', TIELABS_TEXTDOMAIN ),
				'id'       => $ad.'_adrotate',
				'pre_text' => esc_html__( '- OR -', TIELABS_TEXTDOMAIN ),
				'toggle'   => '#'.$ad.'_adrotate_type-item, #'.$ad.'_adrotate_id-item',
				'type'     => 'checkbox',
			));

		tie_build_theme_option(
			array(
				'name'    => esc_html__( 'Type', TIELABS_TEXTDOMAIN ),
				'id'      => $ad.'_adrotate_type',
				'type'    => 'radio',
				'options' => array(
					'single' => esc_html__( 'Advert - Use Advert ID', TIELABS_TEXTDOMAIN ),
					'group'  => esc_html__( 'Group - Use group ID', TIELABS_TEXTDOMAIN ),
				)));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'ID', TIELABS_TEXTDOMAIN ),
				'id'   => $ad.'_adrotate_id',
				'type' => 'number',
			));

		echo '</div>';
	}
}

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Shortcodes Ads', TIELABS_TEXTDOMAIN ),
		'id'    => 'shortcodes-ads',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name' => '[ads1] '. esc_html__( 'Ad Shortcode', TIELABS_TEXTDOMAIN ),
		'id'   => 'ads1_shortcode',
		'type' => 'textarea',
	));

tie_build_theme_option(
	array(
		'name' => '[ads2] '. esc_html__( 'Ad Shortcode', TIELABS_TEXTDOMAIN ),
		'id'   => 'ads2_shortcode',
		'type' => 'textarea',
	));

tie_build_theme_option(
	array(
		'name' => '[ads3] '. esc_html__( 'Ad Shortcode', TIELABS_TEXTDOMAIN ),
		'id'   => 'ads3_shortcode',
		'type' => 'textarea',
	));

tie_build_theme_option(
	array(
		'name' => '[ads4] '. esc_html__( 'Ad Shortcode', TIELABS_TEXTDOMAIN ),
		'id'   => 'ads4_shortcode',
		'type' => 'textarea',
	));

tie_build_theme_option(
	array(
		'name' => '[ads5] '. esc_html__( 'Ad Shortcode', TIELABS_TEXTDOMAIN ),
		'id'   => 'ads5_shortcode',
		'type' => 'textarea',
	));

echo '</div>'; // Settings locked

