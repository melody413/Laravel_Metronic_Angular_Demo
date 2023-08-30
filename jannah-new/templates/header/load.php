<?php
/**
 * Header Main Template Part
 *
 * This template can be overridden by copying it to your-child-theme/templates/header/load.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


// Show the header if it is enabled
if( ! apply_filters( 'TieLabs/is_header_active', true ) ){
	return;
}

$layout = tie_get_option( 'header_layout', 3 );

do_action( 'TieLabs/before_header', $layout );

// Rainbow Line
if( tie_get_option( 'rainbow_header' ) ){
	echo '<div class="rainbow-line"></div>';
}

?>

<header id="theme-header" <?php tie_header_class(); ?>>
	<?php

		// Top Nav Above the Header
		if( ! tie_get_option( 'top_nav_position' ) ){
			TIELABS_HELPER::get_template_part( 'templates/header/nav', 'top' );
		}

		// Main Nav above the Header
		if( tie_get_option( 'main_nav_position' ) ){
			TIELABS_HELPER::get_template_part( 'templates/header/nav', 'main' );
		}

		// Header Content area
		if( $layout != 1 && $layout != 4 ){
			TIELABS_HELPER::get_template_part( 'templates/header/content' );
		}

		// Main Nav Below the Header
		if( ! tie_get_option( 'main_nav_position' ) ){
			TIELABS_HELPER::get_template_part( 'templates/header/nav', 'main' );
		}

		// Top Nav Below the Header
		if( tie_get_option( 'top_nav_position' ) ){
			TIELABS_HELPER::get_template_part( 'templates/header/nav', 'top' );
		}

	?>
</header>

<?php

	do_action( 'TieLabs/after_header', $layout );

	// Get the main slider for the categories
	TIELABS_HELPER::get_template_part('templates/category-slider');

	// Get single post below header layouts
	TIELABS_HELPER::get_template_part( 'templates/header/posts-layout' );

