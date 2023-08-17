<?php
/**
 * Template Name: Masonry Page
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


add_filter( 'body_class', 'tie_template_masonry_custom_body_class' );

add_action( 'TieLabs/after_builder_content', 'tie_template_get_masonry' );
add_action( 'TieLabs/after_post_components', 'tie_template_get_masonry' );

TIELABS_HELPER::get_template_part( 'page' );
