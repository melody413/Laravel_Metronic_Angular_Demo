<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Translations Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'translations-settings-tab',
		'type'  => 'tab-title',
	));

$translation_texts = apply_filters( 'TieLabs/translation_texts', array() );

if( ! empty( $translation_texts ) && is_array( $translation_texts ) ){

	foreach( $translation_texts as $section_id => $section_data ){

		tie_build_theme_option(
			array(
				'title' =>	$section_data['title'],
				'type'  => 'header',
			));

		if( ! empty( $section_data['texts'] ) ){
			foreach ( $section_data['texts'] as $id => $text ){

				tie_build_theme_option(
					array(
						'id'          => 'translations',
						'key'         => sanitize_title( htmlspecialchars( $id ) ),
						'name'        => htmlspecialchars( $text ),
						'placeholder' => htmlspecialchars( $text ),
						'type'        => 'arrayText',
					));
			}
		}
	}
}


tie_build_theme_option(
	array(
		'title' =>	esc_html__( 'Numbers', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

$numbers = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
foreach ( $numbers as $number ) {
	tie_build_theme_option(
		array(
			'id'          => 'translation_numbers',
			'key'         => $number,
			'placeholder' => $number,
			'type'        => 'arrayText',
			'class'       => 'translation-numbers',
		));
}
echo '<div class="clear"></div>';
