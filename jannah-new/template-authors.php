<?php
/**
 * Template Name: Authors List
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


add_action( 'TieLabs/after_post_content', 'tie_template_get_authors', 4 );

TIELABS_HELPER::get_template_part( 'page' );
