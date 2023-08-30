<?php
/**
 * Template Name: Sitemap Page
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


add_action( 'TieLabs/after_post_content', 'tie_template_sitemap', 4 );

TIELABS_HELPER::get_template_part( 'page' );
