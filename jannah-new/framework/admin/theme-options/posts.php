<?php

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Single Post Page Settings', TIELABS_TEXTDOMAIN ),
			'id'    => 'single-post-page-settings-tab',
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
			'title' => esc_html__( 'Default Posts Layout', TIELABS_TEXTDOMAIN ),
			'id'    => 'default-posts-layout',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'id'      => 'post_layout',
			'type'    => 'visual',
			'columns' => 4,
			'toggle'  => array(
				''  => '',
				'4' => '#featured_use_fea-item, #featured_custom_bg-item',
				'5' => '#featured_use_fea-item, #featured_custom_bg-item',
				'8' => '#featured_use_fea-item, #featured_custom_bg-item, #featured_bg_color-item',),
			'options' => array(
				'1' => array( esc_html__( 'Layout', TIELABS_TEXTDOMAIN ). ' #1' => 'post-layouts/1.png' ),
				'2' => array( esc_html__( 'Layout', TIELABS_TEXTDOMAIN ). ' #2' => 'post-layouts/2.png' ),
				'3' => array( esc_html__( 'Layout', TIELABS_TEXTDOMAIN ). ' #3' => 'post-layouts/3.png' ),
				'4' => array( esc_html__( 'Layout', TIELABS_TEXTDOMAIN ). ' #4' => 'post-layouts/4.png' ),
				'5' => array( esc_html__( 'Layout', TIELABS_TEXTDOMAIN ). ' #5' => 'post-layouts/5.png' ),
				'6' => array( esc_html__( 'Layout', TIELABS_TEXTDOMAIN ). ' #6' => 'post-layouts/6.png' ),
				'7' => array( esc_html__( 'Layout', TIELABS_TEXTDOMAIN ). ' #7' => 'post-layouts/7.png' ),
				'8' => array( esc_html__( 'Layout', TIELABS_TEXTDOMAIN ). ' #8' => 'post-layouts/8.png' ),
		)));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Use the featured image', TIELABS_TEXTDOMAIN ),
			'id'    => 'featured_use_fea',
			'type'  => 'checkbox',
			'class' => 'post_layout',
		));

	tie_build_theme_option(
		array(
			'name'     => esc_html__( 'Upload Custom Image', TIELABS_TEXTDOMAIN ),
			'id'       => 'featured_custom_bg',
			'type'     => 'upload',
			'pre_text' => esc_html__( '- OR -', TIELABS_TEXTDOMAIN ),
			'class'    => 'post_layout',
		));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Background Color', TIELABS_TEXTDOMAIN ),
			'id'    => 'featured_bg_color',
			'type'  => 'color',
			'class' => 'post_layout',
		));


	tie_build_theme_option(
		array(
			'title' =>	esc_html__( 'Structure Data', TIELABS_TEXTDOMAIN ),
			'id'    => 'structure-data',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Enable', TIELABS_TEXTDOMAIN ),
			'id'     => 'structure_data',
			'toggle' => '#schema_type-item',
			'type'   => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Default Schema type', TIELABS_TEXTDOMAIN ),
			'id'      => 'schema_type',
			'type'    => 'radio',
			'options' => array(
				'Article'      => esc_html__( 'Article',      TIELABS_TEXTDOMAIN ),
				'NewsArticle'  => esc_html__( 'NewsArticle',  TIELABS_TEXTDOMAIN ),
				'BlogPosting'  => esc_html__( 'BlogPosting',  TIELABS_TEXTDOMAIN ),
			)));

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'General Settings', TIELABS_TEXTDOMAIN ),
			'id'    => 'post-general-settings',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Standard Post Format:', TIELABS_TEXTDOMAIN ) .' '. esc_html__( 'Show the featured image', TIELABS_TEXTDOMAIN ),
			'id'   => 'post_featured',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Image Post Format:', TIELABS_TEXTDOMAIN ) .' '. esc_html__( 'Uncropped featured image', TIELABS_TEXTDOMAIN ),
			'id'      => "image_uncropped",
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Image Post Format:', TIELABS_TEXTDOMAIN ) .' '. esc_html__( 'Featured image lightbox', TIELABS_TEXTDOMAIN ),
			'id'      => "image_lightbox",
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Video Post Format:', TIELABS_TEXTDOMAIN ) .' '. esc_html__( 'Sticky the Featured Video', TIELABS_TEXTDOMAIN ),
			'id'   => 'sticky_featured_video',
			'type' => 'checkbox',
			'hint' => '<span class="autoload-posts-features-notice-options tie-message-hint tie-message-error" style="padding-top: 2px; padding-bottom: 2px;">'. esc_html__( 'This feature can not be used while the Auto Load Posts option is active.', TIELABS_TEXTDOMAIN ) .'</span>'
		));


	if( ! class_exists( 'WPSEO_Frontend' ) ){

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Meta Description Tag', TIELABS_TEXTDOMAIN ),
				'id'     => 'post_meta_escription',
				'type'   => 'checkbox',
			));
	}


	if( ! TIELABS_OPENGRAPH::is_active() ){

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Open Graph meta', TIELABS_TEXTDOMAIN ),
				'id'     => 'post_og_cards',
				'type'   => 'checkbox',
				'toggle' => '#post_og_cards_image-item',
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Default Open Graph Image', TIELABS_TEXTDOMAIN ),
				'id'   => 'post_og_cards_image',
				'type' => 'upload',
			));
	}

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Reading Position Indicator', TIELABS_TEXTDOMAIN ),
			'id'   => 'reading_indicator',
			'type' => 'checkbox',
			'hint' => '<span class="autoload-posts-features-notice-options tie-message-hint tie-message-error" style="padding-top: 2px; padding-bottom: 2px;">'. esc_html__( 'This feature can not be used while the Auto Load Posts option is active.', TIELABS_TEXTDOMAIN ) .'</span>'
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Post Author Box', TIELABS_TEXTDOMAIN ),
			'id'   => 'post_authorbio',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Next/Prev posts', TIELABS_TEXTDOMAIN ),
			'id'   => 'post_nav',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'In Post Responsive Tables', TIELABS_TEXTDOMAIN ),
			'id'   => 'responsive_tables',
			'hint' => esc_html__( 'Disable this option if you use a custom responsive tables plugin.', TIELABS_TEXTDOMAIN ),
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Compact Comments Area', TIELABS_TEXTDOMAIN ),
			'id'     => 'compact_comments',
			'toggle' => '#compact_comments_title-item',
			'type'   => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Compact Comments Custom Title', TIELABS_TEXTDOMAIN ),
			'id'   => 'compact_comments_title',
			'type' => 'text',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Categories', TIELABS_TEXTDOMAIN ),
			'id'   => 'post_cats',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Tags', TIELABS_TEXTDOMAIN ),
			'id'   => 'post_tags',
			'type' => 'checkbox',
			'toggle' => '#post_tags_layout-item',
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Tags List Layout', TIELABS_TEXTDOMAIN ),
			'id'      => 'post_tags_layout',
			'type'    => 'radio',
			'options' => array(
				'' => esc_html__( 'Modern', TIELABS_TEXTDOMAIN ),
				'classic' => esc_html__( 'Classic', TIELABS_TEXTDOMAIN ),
			)
		));

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Post info Settings', TIELABS_TEXTDOMAIN ),
			'id'    => 'post-info-settings',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Post meta area', TIELABS_TEXTDOMAIN ),
			'id'     => 'post_meta',
			'toggle' => '#post_author-all-item, #post_meta_style-item, #post_date-item, #modified-item, #post_comments-item, #post_views-item, #reading_time-item',
			'type'   => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'id'      => 'post_meta_style',
			'name'   => esc_html__( 'Post meta area Layout', TIELABS_TEXTDOMAIN ),
			'type'    => 'visual',
			'toggle'  => array(
				''  => '',
				'column' => '#featured_use_fea-item, #featured_custom_bg-item',
			),
			'options' => array(
				''       => array( esc_html__( 'Default', TIELABS_TEXTDOMAIN ) => 'post-layouts/post-meta-1.png' ),
				'column' => array( esc_html__( 'Column', TIELABS_TEXTDOMAIN )  => 'post-layouts/post-meta-2.png' ),
		)));

	echo '<div id="post_author-all-item">';
	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Author', TIELABS_TEXTDOMAIN ),
			'id'     => 'post_author',
			'toggle' => '#post_author_wrap-item',
			'type'   => 'checkbox',
		));

		echo '<div id="post_author_wrap-item">';
			tie_build_theme_option(
				array(
					'name' => esc_html__( "Author's Avatar", TIELABS_TEXTDOMAIN ),
					'id'   => 'post_author_avatar',
					'type' => 'checkbox',
				));

			tie_build_theme_option(
				array(
					'name' => esc_html__( 'Twitter Icon', TIELABS_TEXTDOMAIN ),
					'id'   => 'post_author_twitter',
					'type' => 'checkbox',
				));

			tie_build_theme_option(
				array(
					'name' => esc_html__( 'Email Icon', TIELABS_TEXTDOMAIN ),
					'id'   => 'post_author_email',
					'type' => 'checkbox',
				));
		echo '</div>';
	echo '</div>';

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Date', TIELABS_TEXTDOMAIN ),
			'id'   => 'post_date',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Last Updated', TIELABS_TEXTDOMAIN ),
			'id'   => 'modified',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Comments', TIELABS_TEXTDOMAIN ),
			'id'   => 'post_comments',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Views', TIELABS_TEXTDOMAIN ),
			'id'   => 'post_views',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Estimated reading time', TIELABS_TEXTDOMAIN ),
			'id'   => 'reading_time',
			'type' => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Newsletter', TIELABS_TEXTDOMAIN ),
			'id'  	=> 'post-newsletter',
			'type'	=> 'header',
		));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Newsletter', TIELABS_TEXTDOMAIN ),
			'id'     => 'post_newsletter',
			'toggle' => '#post_newsletter_text-item, #post_newsletter_mailchimp-item, #post_newsletter_feedburner-item',
			'type'   => 'checkbox',
		));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Text above the Email input field', TIELABS_TEXTDOMAIN ),
				'id'   => 'post_newsletter_text',
				'hint' => esc_html__( 'Supports: Text, HTML and Shortcodes.', TIELABS_TEXTDOMAIN ),
				'type' => 'textarea',
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'MailChimp Form Action URL', TIELABS_TEXTDOMAIN ),
				'id'   => 'post_newsletter_mailchimp',
				'type' => 'text',
			));

		tie_build_theme_option(
			array(
				'name'     => esc_html__( 'Feedburner ID', TIELABS_TEXTDOMAIN ),
				'pre_text' => esc_html__( '- OR -', TIELABS_TEXTDOMAIN ),
				'id'       => 'post_newsletter_feedburner',
				'type'     => 'text',
			));

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Related Posts', TIELABS_TEXTDOMAIN ),
			'id'     => 'related-posts',
			'type'	=> 'header',
		));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Related Posts', TIELABS_TEXTDOMAIN ),
			'id'     => 'related',
			'toggle' => '#related-posts-options',
			'type'   => 'checkbox',
		));

	echo '<div id="related-posts-options">';

		tie_build_theme_option(
			array(
				'name'    => esc_html__( 'Related Posts Position', TIELABS_TEXTDOMAIN ),
				'id'      => 'related_position',
				'type'    => 'radio',
				'toggle'  => array(
					'post'     => '#related_number-item, #related_number_full-item',
					'comments' => '#related_number-item, #related_number_full-item',
					'footer'   => '#related_number-item',
				),
				'options' => array(
					'post'     => esc_html__( 'Below The Post', TIELABS_TEXTDOMAIN ),
					'comments' => esc_html__( 'Below The Comments', TIELABS_TEXTDOMAIN ),
					'footer'   => esc_html__( 'Above The Footer', TIELABS_TEXTDOMAIN ),
				)));

		tie_build_theme_option(
			array(
				'name'  => esc_html__( 'Number of posts to show', TIELABS_TEXTDOMAIN ),
				'id'    => 'related_number',
				'type'  => 'number',
				'class' => 'related_position',
			));

		tie_build_theme_option(
			array(
				'name'  => esc_html__( 'Number of posts to show in Full width pages', TIELABS_TEXTDOMAIN ),
				'id'    => 'related_number_full',
				'type'  => 'number',
				'class' => 'related_position',
			));

		tie_build_theme_option(
			array(
				'name'    => esc_html__( 'Query Type', TIELABS_TEXTDOMAIN ),
				'id'      => 'related_query',
				'type'    => 'radio',
				'options' => array(
					'category' => esc_html__( 'Posts in the same Categories', TIELABS_TEXTDOMAIN ),
					'tag'      => esc_html__( 'Posts in the same Tags', TIELABS_TEXTDOMAIN ),
					'author'   => esc_html__( 'Posts by the same Author', TIELABS_TEXTDOMAIN ),
				)));


		//Post Order
		$post_order = array(
			'latest'   => esc_html__( 'Recent Posts',         TIELABS_TEXTDOMAIN ),
			'rand'     => esc_html__( 'Random Posts',         TIELABS_TEXTDOMAIN ),
			'modified' => esc_html__( 'Last Modified Posts',  TIELABS_TEXTDOMAIN ),
			'popular'  => esc_html__( 'Most Commented posts', TIELABS_TEXTDOMAIN ),
			'title'    => esc_html__( 'Alphabetically',       TIELABS_TEXTDOMAIN ),
		);

		if( tie_get_option( 'tie_post_views' ) ){
			$post_order['views'] = esc_html__( 'Most Viewed posts', TIELABS_TEXTDOMAIN );
		}

		tie_build_theme_option(
			array(
				'name'    => esc_html__( 'Sort Order', TIELABS_TEXTDOMAIN ),
				'id'      => 'related_order',
				'type'    => 'select',
				'options' => apply_filters( 'TieLabs/Options/Related/post_order_args', $post_order ),
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Title Length', TIELABS_TEXTDOMAIN ),
				'id'   => 'related_title_length',
				'type' => 'number',
			));

	echo '</div>';

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Read Next Slider', TIELABS_TEXTDOMAIN ),
			'id'     => 'read-next-title',
			'type'	=> 'header',
		));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Read Next Slider', TIELABS_TEXTDOMAIN ),
			'id'     => 'read_next',
			'toggle' => '#read-next-options',
			'type'   => 'checkbox',
		));

	echo '<div id="read-next-options">';

		tie_build_theme_option(
			array(
				'name'    => esc_html__( 'Read Next Style', TIELABS_TEXTDOMAIN ),
				'id'      => 'read_next_style',
				'type'    => 'visual',
				'options' => array(
					'50' => array(  sprintf( esc_html__( 'Read Next #%s', TIELABS_TEXTDOMAIN ), 1 ) => 'blocks/block-slider_50.png' ),
					'4'  => array(  sprintf( esc_html__( 'Read Next #%s', TIELABS_TEXTDOMAIN ), 2 ) => 'blocks/block-slider_4.png' ),
			)
			));

		tie_build_theme_option(
			array(
				'name'  => esc_html__( 'Number of posts to show', TIELABS_TEXTDOMAIN ),
				'id'    => 'read_next_number',
				'type'  => 'number',
			));

		tie_build_theme_option(
			array(
				'name'    => esc_html__( 'Query Type', TIELABS_TEXTDOMAIN ),
				'id'      => 'read_next_query',
				'type'    => 'radio',
				'options' => array(
					'category' => esc_html__( 'Posts in the same Categories', TIELABS_TEXTDOMAIN ),
					'tag'      => esc_html__( 'Posts in the same Tags', TIELABS_TEXTDOMAIN ),
					'author'   => esc_html__( 'Posts by the same Author', TIELABS_TEXTDOMAIN ),
				)));


		//Post Order
		$post_order = array(
			'latest'   => esc_html__( 'Recent Posts',         TIELABS_TEXTDOMAIN ),
			'rand'     => esc_html__( 'Random Posts',         TIELABS_TEXTDOMAIN ),
			'modified' => esc_html__( 'Last Modified Posts',  TIELABS_TEXTDOMAIN ),
			'popular'  => esc_html__( 'Most Commented posts', TIELABS_TEXTDOMAIN ),
			'title'    => esc_html__( 'Alphabetically',       TIELABS_TEXTDOMAIN ),
		);

		if( tie_get_option( 'tie_post_views' ) ){
			$post_order['views'] = esc_html__( 'Most Viewed posts', TIELABS_TEXTDOMAIN );
		}

		tie_build_theme_option(
			array(
				'name'    => esc_html__( 'Sort Order', TIELABS_TEXTDOMAIN ),
				'id'      => 'read_next_order',
				'type'    => 'select',
				'options' => apply_filters( 'TieLabs/Options/Read_Next/post_order_args', $post_order ),
			));

	echo '</div>';

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Fly Check Also Box', TIELABS_TEXTDOMAIN ),
			'id'    => 'fly-check-also-box',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Check Also', TIELABS_TEXTDOMAIN ),
			'id'     => 'check_also',
			'toggle' => '#check_also_position-item, #check_also_number-item, #check_also_query-item, #check_also_order-item, #check_also_title_length-item',
			'type'   => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Number of posts to show', TIELABS_TEXTDOMAIN ),
			'id'   => 'check_also_number',
			'type' => 'number',
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Check Also Box Position', TIELABS_TEXTDOMAIN ),
			'id'      => 'check_also_position',
			'type'    => 'radio',
			'options' => array(
				'right'	=> esc_html__( 'Right',	TIELABS_TEXTDOMAIN ),
				'left'	=> esc_html__( 'Left',	TIELABS_TEXTDOMAIN ),
		)));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Query Type', TIELABS_TEXTDOMAIN ),
			'id'      => 'check_also_query',
			'type'    => 'radio',
			'options' => array(
				'category' => esc_html__( 'Posts in the same Categories',	TIELABS_TEXTDOMAIN ),
				'tag'      => esc_html__( 'Posts in the same Tags', TIELABS_TEXTDOMAIN ),
				'author'   => esc_html__( 'Posts by the same Author', TIELABS_TEXTDOMAIN ),
			)));

		tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Sort Order', TIELABS_TEXTDOMAIN ),
			'id'      => 'check_also_order',
			'type'    => 'select',
			'options' => apply_filters( 'TieLabs/Options/Checkalso/post_order_args', $post_order ),
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Title Length', TIELABS_TEXTDOMAIN ),
			'id'      => 'check_also_title_length',
			'type'    => 'number',
		));


	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Inline Related Posts', TIELABS_TEXTDOMAIN ),
			'id'    => 'inline-related-posts',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Inline Related Posts', TIELABS_TEXTDOMAIN ),
			'id'     => 'inline_related_posts',
			'toggle' => '#inline_related_posts_paragraphs-item, #inline_related_posts_number-item, #inline_related_posts_query-item, #inline_related_posts_order-item',
			'type'   => 'checkbox',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Number of paragraphs before', TIELABS_TEXTDOMAIN ),
			'id'   => 'inline_related_posts_paragraphs',
			'type' => 'number',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Number of posts to show', TIELABS_TEXTDOMAIN ),
			'id'   => 'inline_related_posts_number',
			'type' => 'number',
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Query Type', TIELABS_TEXTDOMAIN ),
			'id'      => 'inline_related_posts_query',
			'type'    => 'radio',
			'options' => array(
				'category' => esc_html__( 'Posts in the same Categories',	TIELABS_TEXTDOMAIN ),
				'tag'      => esc_html__( 'Posts in the same Tags', TIELABS_TEXTDOMAIN ),
				'author'   => esc_html__( 'Posts by the same Author', TIELABS_TEXTDOMAIN ),
			)));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Sort Order', TIELABS_TEXTDOMAIN ),
			'id'      => 'inline_related_posts_order',
			'type'    => 'select',
			'options' => apply_filters( 'TieLabs/Options/inline_related_post/post_order_args', $post_order ),
		));

	// ---
	if( ! defined( 'JANNAH_AUTOLOAD_POSTS_VERSION' ) ){

		tie_build_theme_option(
			array(
				'title' => esc_html__( 'Auto Load Posts', TIELABS_TEXTDOMAIN ),
				'id'    => 'autoload-posts',
				'type'  => 'header',
			));

		tie_build_theme_option(
			array(
				'text' => sprintf( esc_html__( 'You need to install the %s plugin to use this feature.', TIELABS_TEXTDOMAIN ), '<a href="'. admin_url('admin.php?page=tie-install-plugins') .'"><strong>Jannah Autoload Posts</strong></a>' ),
				'type' => 'error',
			));
	}

echo '</div>'; // Settings locked
