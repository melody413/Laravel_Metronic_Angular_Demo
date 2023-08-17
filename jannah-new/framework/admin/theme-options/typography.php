<?php

tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Typography Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'typorgraphy-settings-tab',
		'type'  => 'tab-title',
	));

$fonts_sections = array(
	'body'         => esc_html__( 'Body Font Family',         TIELABS_TEXTDOMAIN ),
	'headings'     => esc_html__( 'Headings Font Family',     TIELABS_TEXTDOMAIN ),
	'menu'         => esc_html__( 'Primary menu Font Family', TIELABS_TEXTDOMAIN ),
	'blockquote'   => esc_html__( 'Blockquote Font Family',   TIELABS_TEXTDOMAIN ),
);

foreach( $fonts_sections as $font_section_key => $font_section_text ){

	tie_build_theme_option(
		array(
			'title' => $font_section_text,
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Source', TIELABS_TEXTDOMAIN ),
			'id'      => 'typography_'. $font_section_key .'_font_source',
			'type'    => 'select',
			'options' => array(
				''           => esc_html__( 'Theme Defaults',     TIELABS_TEXTDOMAIN ),
				'standard'   => esc_html__( 'Standard Fonts',     TIELABS_TEXTDOMAIN ),
				'google'     => esc_html__( 'Google Fonts',       TIELABS_TEXTDOMAIN ),
				'fontfaceme' => esc_html__( 'FontFace.me Fonts',  TIELABS_TEXTDOMAIN ),
				'custom'     => esc_html__( 'Upload Custom Font', TIELABS_TEXTDOMAIN ),
				'external'   => esc_html__( 'Any external fonts (e.g. Typekit)', TIELABS_TEXTDOMAIN ),
			),
			'toggle' => array(
				''           => '',
				'standard'   => '#typography_'. $font_section_key .'_standard_font-item',
				'google'     => '#typography_'. $font_section_key .'_google_font_hint-item, #typography_'. $font_section_key .'_google_font-item, #typography_'. $font_section_key .'_google_variants-item, #typography_'. $font_section_key .'_google_char-item',
				'fontfaceme' => '#typography_'. $font_section_key .'_fontfaceme-item',
				'custom'     => '#typography_'. $font_section_key .'_ext_font-item, #typography_'. $font_section_key .'_custom_files',
				'external'   => '#typography_'. $font_section_key .'_ext_font-item, #typography_'. $font_section_key .'_ext_head-item',
			)
		));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Font Family', TIELABS_TEXTDOMAIN ),
			'id'    => 'typography_'. $font_section_key .'_standard_font',
			'class' => 'typography_'. $font_section_key .'_font_source',
			'type'  => 'fonts',
		));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Font Family', TIELABS_TEXTDOMAIN ),
			'id'    => 'typography_'. $font_section_key .'_google_font',
			'class' => 'typography_'. $font_section_key .'_font_source',
			'type'  => 'fonts',
		));

	tie_build_theme_option(
		array(
			'id'    => 'typography_'. $font_section_key .'_google_font_hint',
			'text'  => '<strong>'. esc_html__( 'Tip:', TIELABS_TEXTDOMAIN ) .'</strong> '. esc_html__( 'Choosing a lot of Variants may make your pages slow to load.', TIELABS_TEXTDOMAIN ),
			'class' => 'typography_'. $font_section_key .'_font_source',
			'type'  => 'message',
		));

	tie_build_theme_option(
		array(
			'name'    => esc_html__( 'Font Variants', TIELABS_TEXTDOMAIN ),
			'id'      => 'typography_'. $font_section_key .'_google_variants',
			'class'   => 'typography_'. $font_section_key .'_font_source',
			'hint'    => esc_html__( 'Please, make sure that chosen font supports chosen weight.', TIELABS_TEXTDOMAIN ),
			'type'    => 'select-multiple',
			'options' => array(
				'100'       => esc_html__( 'Thin 100',               TIELABS_TEXTDOMAIN ),
				'100italic' => esc_html__( 'Thin 100 Italic',        TIELABS_TEXTDOMAIN ),
				'200'       => esc_html__( 'Extra 200 Light',        TIELABS_TEXTDOMAIN ),
				'200italic' => esc_html__( 'Extra 200 Light Italic', TIELABS_TEXTDOMAIN ),
				'300'       => esc_html__( 'Light 300',              TIELABS_TEXTDOMAIN ),
				'300italic' => esc_html__( 'Light 300 Italic',       TIELABS_TEXTDOMAIN ),
				'regular'   => esc_html__( 'Regular 400',            TIELABS_TEXTDOMAIN ),
				'italic'    => esc_html__( 'Regular 400 Italic',     TIELABS_TEXTDOMAIN ),
				'500'       => esc_html__( 'Medium 500',             TIELABS_TEXTDOMAIN ),
				'500italic' => esc_html__( 'Medium 500 Italic',      TIELABS_TEXTDOMAIN ),
				'600'       => esc_html__( 'Semi 600 Bold',          TIELABS_TEXTDOMAIN ),
				'600italic' => esc_html__( 'Semi 600 Bold Italic',   TIELABS_TEXTDOMAIN ),
				'700'       => esc_html__( 'Bold 700',               TIELABS_TEXTDOMAIN ),
				'700italic' => esc_html__( 'Bold 700 Italic',        TIELABS_TEXTDOMAIN ),
				'800'       => esc_html__( 'Extra 800 Bold',         TIELABS_TEXTDOMAIN ),
				'800italic' => esc_html__( 'Extra 800 Bold Italic',  TIELABS_TEXTDOMAIN ),
				'900'       => esc_html__( 'Black 900',              TIELABS_TEXTDOMAIN ),
				'900italic' => esc_html__( 'Black 900 Italic',       TIELABS_TEXTDOMAIN ),
			)));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Font Family', TIELABS_TEXTDOMAIN ),
			'id'    => 'typography_'. $font_section_key .'_fontfaceme',
			'class' => 'typography_'. $font_section_key .'_font_source',
			'type'  => 'fonts',
		));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Embed code for the &lt;head&gt; section', TIELABS_TEXTDOMAIN ),
			'id'    => 'typography_'. $font_section_key .'_ext_head',
			'class' => 'typography_'. $font_section_key .'_font_source',
			'type'  => 'textarea',
		));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Font Family', TIELABS_TEXTDOMAIN ),
			'id'    => 'typography_'. $font_section_key .'_ext_font',
			'hint'  => esc_html__( "Enter the value for 'font-family' attribute, also you can specify the stack of the fonts.", TIELABS_TEXTDOMAIN ),
			'class' => 'typography_'. $font_section_key .'_font_source',
			'type'  => 'text',
		));

	echo '<div id="typography_'. $font_section_key .'_custom_files" class="typography_'. $font_section_key .'_font_source-options">';

		tie_build_theme_option(
			array(
				'name'  => sprintf( esc_html__( '%s Font File', TIELABS_TEXTDOMAIN ), '.EOT' ),
				'id'    => 'typography_'. $font_section_key .'_custom_eot',
				'type'  => 'upload-font',
			));

		tie_build_theme_option(
			array(
				'name'  => sprintf( esc_html__( '%s Font File', TIELABS_TEXTDOMAIN ), '.WOFF2' ),
				'id'    => 'typography_'. $font_section_key .'_custom_woff2',
				'type'  => 'upload-font',
			));

		tie_build_theme_option(
			array(
				'name'  => sprintf( esc_html__( '%s Font File', TIELABS_TEXTDOMAIN ), '.WOFF' ),
				'id'    => 'typography_'. $font_section_key .'_custom_woff',
				'type'  => 'upload-font',
			));

		tie_build_theme_option(
			array(
				'name'  => sprintf( esc_html__( '%s Font File', TIELABS_TEXTDOMAIN ), '.TTF' ),
				'id'    => 'typography_'. $font_section_key .'_custom_ttf',
				'type'  => 'upload-font',
			));

		tie_build_theme_option(
			array(
				'name'  => sprintf( esc_html__( '%s Font File', TIELABS_TEXTDOMAIN ), '.SVG' ),
				'id'    => 'typography_'. $font_section_key .'_custom_svg',
				'type'  => 'upload-font',
			));

	echo '</div>';


} //end foreach;


tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Google Web Font Character sets', TIELABS_TEXTDOMAIN ),
		'id'    => 'google-web-font-character-sets',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'text'  => '<strong>'. esc_html__( 'Tip:', TIELABS_TEXTDOMAIN ) .'</strong> '. esc_html__( 'Choosing a lot of Character sets may make your pages slow to load.', TIELABS_TEXTDOMAIN ),
		'type'  => 'message',
	));

tie_build_theme_option(
	array(
		'name'    => esc_html__( 'Google Web Font Character sets', TIELABS_TEXTDOMAIN ),
		'id'      => 'typography_google_character_sets',
		'class'   => 'typography_font_source',
		'hint'    => esc_html__( 'Latin charset by default. Include additional character sets for fonts (make sure at http://www.google.com/fonts/ before that charset is available for chosen font)', TIELABS_TEXTDOMAIN ),
		'type'    => 'select-multiple',
		'options' => array(
			'latin-ext'    => 'Latin Extended',
			'cyrillic'     => 'Cyrillic',
			'cyrillic-ext' => 'Cyrillic Extended',
			'devanagari'   => 'Devanagari',
			'greek'        => 'Greek',
			'greek-ext'    => 'Greek Extended',
			'gujarati'     => 'Gujarati',
			'gurmukhi'     => 'Gurmukhi',
			'hebrew'       => 'Hebrew',
			'kannada'      => 'kannada',
			'khmer'        => 'khmer',
			'vietnamese'   => 'vietnamese',
			'arabic'       => 'Arabic',
			'bengali'      => 'Bengali',
			'malayalam'    => 'Malayalam',
			'myanmar'      => 'Myanmar',
			'oriya' 	     => 'Oriya',
			'sinhala'      => 'Sinhala',
			'tamil'        => 'Tamil',
			'telugu'       => 'Telugu',
			'thai'         => 'Thai',
		)));

tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Font Sizes, Weights and Line Heights', TIELABS_TEXTDOMAIN ),
		'id'    => 'font-sizes-weights-and-line-heights',
		'type'  => 'header',
	));

tie_build_theme_option(
	array(
		'text' => '<strong>'. esc_html__( 'Font Weight Tips:', TIELABS_TEXTDOMAIN ) .'</strong> <br />'.esc_html__( "- If you use a google font, make sure to load the font weight in 'Google Font Variants' field that corresponds to the one in parenthesis here.", TIELABS_TEXTDOMAIN ) .'<br />'. esc_html__( "- Browser standard fonts in general support only 'Normal (400)' and 'Bold (700)' font weights.", TIELABS_TEXTDOMAIN ),
		'type' => 'message',
	));

$fonts_settings = array(

	'general' => array(
		'title'    => esc_html__( 'General', TIELABS_TEXTDOMAIN ),
		'settings' => array(
			'body'                     => esc_html__( 'General Secondary Texts', TIELABS_TEXTDOMAIN ),
			'breadcrumbs'              => esc_html__( 'Breadcrumbs',             TIELABS_TEXTDOMAIN ),
			'buttons'                  => esc_html__( 'Buttons',                 TIELABS_TEXTDOMAIN ),
			'post_cat_label'           => esc_html__( 'Post Categories Label',   TIELABS_TEXTDOMAIN ),
			'widgets_title'            => esc_html__( 'Widgets Titles',          TIELABS_TEXTDOMAIN ),
			'widgets_post_title'       => esc_html__( 'Post title in widgets',   TIELABS_TEXTDOMAIN ),
			'copyright'                => esc_html__( 'Copyright Area',          TIELABS_TEXTDOMAIN ),
			'footer_widgets_title'     => esc_html__( 'Footer Widgets Titles',   TIELABS_TEXTDOMAIN ),
		)
	),

	'header' => array(
		'title'    => esc_html__( 'Header', TIELABS_TEXTDOMAIN ),
		'settings' => array(

			'site_title'               => esc_html__( 'Header Site name',          TIELABS_TEXTDOMAIN ),
			'top_menu'                 => esc_html__( 'Secondary Menu',            TIELABS_TEXTDOMAIN ),
			'top_menu_sub'             => esc_html__( 'Secondary sub menus',       TIELABS_TEXTDOMAIN ),
			'main_nav'                 => esc_html__( 'Main Navigation',           TIELABS_TEXTDOMAIN ),
			'main_nav_sub'             => esc_html__( 'Main Navigation sub menus', TIELABS_TEXTDOMAIN ),
			'mobile_menu'              => esc_html__( 'Mobile Menu',               TIELABS_TEXTDOMAIN ),
			'breaking_news'            => esc_html__( 'Breaking News Label',       TIELABS_TEXTDOMAIN ),
			'breaking_news_posts'      => esc_html__( 'Breaking News post titles', TIELABS_TEXTDOMAIN ),
		)
	),

	'page_builder' => array(
		'title'    => esc_html__( 'Page Builder', TIELABS_TEXTDOMAIN ),
		'settings' => array(
			'sections_title_default'    => esc_html__( 'Sections Titles: Default & Centered Styles', TIELABS_TEXTDOMAIN ),
			'sections_title_big'        => esc_html__( 'Sections Titles: Big Style',                 TIELABS_TEXTDOMAIN ),
			'boxes_title'               => esc_html__( 'Blocks Titles',                              TIELABS_TEXTDOMAIN ),
			'post_title_sliders'        => esc_html__( 'Post Titles in Homepage Sliders',            TIELABS_TEXTDOMAIN ),
			'post_medium_title_sliders' => esc_html__( 'Medium Post Titles in Homepage Sliders',     TIELABS_TEXTDOMAIN ),
			'post_small_title_sliders'  => esc_html__( 'Small Post Titles in Homepage Sliders',      TIELABS_TEXTDOMAIN ),
			'post_title_blocks'         => esc_html__( 'Post Titles in Homepage Blocks',             TIELABS_TEXTDOMAIN ),
			'post_medium_title_blocks'  => esc_html__( 'Medium Post Titles in Homepage Blocks',      TIELABS_TEXTDOMAIN ),
			'post_small_title_blocks'   => esc_html__( 'Small Post Titles in Homepage Blocks',       TIELABS_TEXTDOMAIN ),
		)
	),

	'archives' => array(
		'title'    => esc_html__( 'Archive page', TIELABS_TEXTDOMAIN ),
		'settings' => array(
			'single_archive_title' => esc_html__( 'Archive Page Title', TIELABS_TEXTDOMAIN ),
		)
	),

	'page_404' => array(
		'title'    => esc_html__( '404 Page', TIELABS_TEXTDOMAIN ),
		'settings' => array(
			'page_404_main_title'  => esc_html__( 'Main Title', TIELABS_TEXTDOMAIN ),
			'page_404_sec_title'   => esc_html__( 'Secondary Title', TIELABS_TEXTDOMAIN ),
			'page_404_description' => esc_html__( 'Description', TIELABS_TEXTDOMAIN ),
		)
	),

	'single_post' => array(
		'title'    => esc_html__( 'Single Post Page', TIELABS_TEXTDOMAIN ),
		'settings' => array(
			'single_post_title' => esc_html__( 'Single Post Title',        TIELABS_TEXTDOMAIN ),
			'post_entry'        => esc_html__( 'Single Post Page Content', TIELABS_TEXTDOMAIN ),
			'comment_text'      => esc_html__( 'Comment content',          TIELABS_TEXTDOMAIN ),
			'blockquote'        => esc_html__( 'Blockquotes',              TIELABS_TEXTDOMAIN ),
			'post_heading_h1'   => esc_html__( 'Post Heading:',            TIELABS_TEXTDOMAIN ) .' H1',
			'post_heading_h2'   => esc_html__( 'Post Heading:',            TIELABS_TEXTDOMAIN ) .' H2',
			'post_heading_h3'   => esc_html__( 'Post Heading:',            TIELABS_TEXTDOMAIN ) .' H3',
			'post_heading_h4'   => esc_html__( 'Post Heading:',            TIELABS_TEXTDOMAIN ) .' H4',
			'post_heading_h5'   => esc_html__( 'Post Heading:',            TIELABS_TEXTDOMAIN ) .' H5',
			'post_heading_h6'   => esc_html__( 'Post Heading:',            TIELABS_TEXTDOMAIN ) .' H6',
		),
	)
);


foreach( $fonts_settings as $font_section => $font_section_data ){

	tie_build_theme_option(
		array(
			'title' =>	$font_section_data['title'],
			'type'  => 'header',
		));


	foreach( $font_section_data['settings'] as $font_section_key => $font_section_text ){
		tie_build_theme_option(
			array(
				'name' => $font_section_text,
				'id'    => 'typography_'. $font_section_key,
				'type'  => 'typography',
			));
	}

}
