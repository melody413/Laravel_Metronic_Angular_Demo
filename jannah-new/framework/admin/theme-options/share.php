<?php

tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Share Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'share-settings-tab',
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


// General share buttons settings
tie_build_theme_option(
	array(
		'title' => esc_html__( 'General Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'share-general-settings',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Share Buttons for Pages', TIELABS_TEXTDOMAIN ),
		'id'   => 'share_buttons_pages',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( "Use the post's Short Link", TIELABS_TEXTDOMAIN ),
		'id'   => 'share_shortlink',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Twitter Username', TIELABS_TEXTDOMAIN ) . ' <small>'. esc_html__( '(optional)', TIELABS_TEXTDOMAIN ). '</small>',
		'id'   => 'share_twitter_username',
		'type' => 'text',
	));


# Above Posts share buttons
tie_build_theme_option(
	array(
		'title' => esc_html__( 'Above Post share Buttons', TIELABS_TEXTDOMAIN ),
		'id'    => 'above-post-share',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'   => esc_html__( 'Above Post share Buttons', TIELABS_TEXTDOMAIN ),
		'id'     => 'share_post_top',
		'type'   => 'checkbox',
		'toggle' => '#share-top-options',
	));

echo '<div id="share-top-options">';
	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Buttons Position', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_position_top',
			'type' => 'radio',
			'options' => array(
				''         => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
				'center'   => esc_html__( 'Center', TIELABS_TEXTDOMAIN ),
				'inverted' => esc_html__( 'Inverted', TIELABS_TEXTDOMAIN ),
			),
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Show the share title', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_title_top',
			'hint' => sprintf( esc_html__( 'You can change the "%s" text from the Translation tab.', TIELABS_TEXTDOMAIN ), esc_html__( 'Share', TIELABS_TEXTDOMAIN ) ),
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name'	  => esc_html__( 'Share Buttons Style', TIELABS_TEXTDOMAIN ),
			'id'      => 'share_style_top',
			'type'    => 'visual',
			'options' => array(
				''        => 'share/share-1.png',
				'style_2' => 'share/share-2.png',
				'style_3' => 'share/share-3.png',
				'style_4' => 'share/share-4.png',
				'style_5' => 'share/share-5.png',
				'style_6' => 'share/share-6.png',
				'style_7' => 'share/share-7.png',
		)));

	tie_get_share_buttons_options( 'top' );
echo '</div>';


// Below Posts share buttons
tie_build_theme_option(
	array(
		'title' => esc_html__( 'Below Post Share Buttons', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'   => esc_html__( 'Below Post Share Buttons', TIELABS_TEXTDOMAIN ),
		'id'     => 'share_post_bottom',
		'type'   => 'checkbox',
		'toggle' => '#share-bottom-options',
	));

echo '<div id="share-bottom-options">';
	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Buttons Position', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_position_bottom',
			'type' => 'radio',
			'options' => array(
				''         => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
				'center'   => esc_html__( 'Center', TIELABS_TEXTDOMAIN ),
				'inverted' => esc_html__( 'Inverted', TIELABS_TEXTDOMAIN ),
			),
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Show the share title', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_title_bottom',
			'hint' => sprintf( esc_html__( 'You can change the "%s" text from the Translation tab.', TIELABS_TEXTDOMAIN ), esc_html__( 'Share', TIELABS_TEXTDOMAIN ) ),
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name'	  => esc_html__( 'Share Buttons Style', TIELABS_TEXTDOMAIN ),
			'id'      => 'share_style_bottom',
			'type'    => 'visual',
			'options' => array(
				''        => 'share/share-1.png',
				'style_2' => 'share/share-2.png',
				'style_3' => 'share/share-3.png',
				'style_4' => 'share/share-4.png',
				'style_5' => 'share/share-5.png',
				'style_6' => 'share/share-6.png',
				'style_7' => 'share/share-7.png',
		)));

	tie_get_share_buttons_options();
echo '</div>';


// Sticky share buttons
tie_build_theme_option(
	array(
		'title' => esc_html__( 'Sticky Share Buttons', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'name'   => esc_html__( 'Sticky Share Buttons', TIELABS_TEXTDOMAIN ),
		'id'     => 'share_post_sticky',
		'type'   => 'checkbox',
		'toggle' => '#share-sticky-options',
	));

echo '<div id="share-sticky-options">';
	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Buttons Position', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_position_sticky',
			'type' => 'radio',
			'options' => array(
				'left'  => esc_html__( 'Left', TIELABS_TEXTDOMAIN ),
				'right' => esc_html__( 'Right', TIELABS_TEXTDOMAIN ),
			),
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Breakpoint (in px)', TIELABS_TEXTDOMAIN ),
			'id'   => 'share_breakpoint_sticky',
			'type' => 'number',
			'hint' => sprintf( esc_html__( 'Hide the buttons if the device/window width size is lower than this, default %s', TIELABS_TEXTDOMAIN ), '1250' ),
		));

	tie_get_share_buttons_options( 'sticky' );
echo '</div>';


// Select and Share
tie_build_theme_option(
	array(
		'title' => esc_html__( 'Select and Share', TIELABS_TEXTDOMAIN ),
		'id'    => 'select-and-share',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'text' => esc_html__( 'When you double-click a word or highlight a few words, a small share icons are displayed. When you click an icon, a share modal will automatically launch, containing the text you selected along with a link to the post.', TIELABS_TEXTDOMAIN ),
		'type' => 'message',
	));

tie_build_theme_option(
	array(
		'name'   => esc_html__( 'Select and Share', TIELABS_TEXTDOMAIN ),
		'id'     => 'select_share',
		'toggle' => '#select_share_twitter-item, #select_share_linkedin-item, #select_share_facebook-item, #facebook-api-key, #facebook_app_id-item, #select_share_email-item',
		'type'   => 'checkbox',
	));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Twitter', TIELABS_TEXTDOMAIN ),
			'id'     => 'select_share_twitter',
			'type'   => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'LinkedIn', TIELABS_TEXTDOMAIN ),
			'id'   => 'select_share_linkedin',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Email', TIELABS_TEXTDOMAIN ),
			'id'   => 'select_share_email',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Facebook', TIELABS_TEXTDOMAIN ),
			'id'   => 'select_share_facebook',
			'type' => 'checkbox',
		));

echo '</div>'; // Settings locked
