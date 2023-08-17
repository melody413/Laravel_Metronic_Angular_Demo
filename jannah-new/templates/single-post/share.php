<?php
/**
 * Post Share
 *
 * This template can be overridden by copying it to your-child-theme/templates/single-post/share.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


// Disable on bbPress pages
if( TIELABS_BBPRESS_IS_ACTIVE && is_bbpress() ){
	return;
}

// Check if the share buttons is hidden on mobiles
if( TIELABS_HELPER::is_mobile_and_hidden( 'share_post_'.$share_position ) ){
	return;
}

// Reset the main Post query - Some plugins' widgets change the main post query
wp_reset_postdata();

// Check if the sharing buttons are active
if( tie_get_postdata( 'tie_hide_share_'.$share_position ) == 'no' ||
	( get_post_type() == 'page' && tie_get_option( 'share_buttons_pages' ) && tie_get_option( 'share_post_'.$share_position ) && ! tie_get_postdata( 'tie_hide_share_'.$share_position ) ) ||
	( TIELABS_HELPER::is_supported_post_type() && tie_get_option( 'share_post_'.$share_position ) && ! tie_get_postdata( 'tie_hide_share_'.$share_position ) ) ) {


	// --
	$counter      = 0;
	$share_class  = '';
	$share_style  = tie_get_option( 'share_style_'.$share_position );
	$button_class = '';
	$text_class   = '';

	// Mobile and Sticky Share buttons
	if( $share_position == 'mobile' || $share_position == 'sticky' ){
		$share_style = 'style_3';
	}

	// Centered buttons
	if( $position = tie_get_option( 'share_position_'.$share_position ) ){
		$share_class .= ( $position == 'center' ) ? ' share-centered' : ' share-'.$position;
	}

	// Share layout
	if( $share_style == 'style_2' || $share_style == 'style_6' || $share_style == 'style_7' ){
		$share_class .= ' icons-text';
		$button_class = ' large-share-button';
		$text_class   = 'social-text';
	}
	elseif( $share_style == 'style_3' ){
		$share_class .= ' icons-only';
		$button_class = '';
		$text_class   = 'screen-reader-text';
	}
	elseif( $share_style == 'style_4' ){
		$share_class .= ' icons-only';
		$button_class = ' equal-width';
		$text_class   = 'screen-reader-text';
	}
	elseif( $share_style == 'style_5' ){
		$share_class .= ' icons-only share-rounded';
		$button_class = '';
		$text_class   = 'screen-reader-text';
	}

	// Additional Classes
	if( $share_style == 'style_6' ){
		$share_class .= ' share-skew';
	}
	elseif( $share_style == 'style_7' ){
		$share_class .= ' share-pill';
	}

	// Get Share Buttons
	$share_buttons = tie_get_share_buttons( $share_position );

	//
	$button_position = ( $share_position == 'bottom' ) ? '' : '_'.$share_position;

	$active_share_buttons = array();

	foreach ( $share_buttons as $network => $button ){

		$network_id = $network;
		$custom_button_class = $network .'-share-btn';

		if( ! empty( $button['id'] ) ){
			$network_id   = $button['id'];
			$custom_button_class .= ' '. $button['id'] .'-share-btn';
		}

		if( tie_get_option( 'share_'.$network_id.$button_position ) ){

			$counter ++;

			// Buttons Style 1
			if( empty( $share_style ) ) {
				$button_class = '';
				$text_class   = 'screen-reader-text';

				if( $counter <= 2 ){
					$button_class = ' large-share-button';
					$text_class   = 'social-text';
				}
			}

			$esc = ! isset( $button['avoid_esc'] ) ? true : false;

			$active_share_buttons[] = '
				<a href="'. tie_share_button_url( $button['url'], $esc ) .'" rel="external noopener nofollow" title="'. $button['text'] .'" target="_blank" class="'. $custom_button_class .' '. $button_class .'" data-raw="'. $button['url'] .'">
					<span class="share-btn-icon '. $button['icon'] .'"></span> <span class="'. $text_class .'">'. $button['text'] .'</span>
				</a>'
			;
		}
	}

	if( is_array( $active_share_buttons ) && ! empty( $active_share_buttons ) ){ ?>

		<div id="share-buttons-<?php echo esc_attr( $share_position ) ?>" class="share-buttons share-buttons-<?php echo esc_attr( $share_position ) ?>">
			<div class="share-links <?php echo esc_attr( $share_class ) ?>">
				<?php
					if( tie_get_option( 'share_title_'.$share_position ) ){ ?>
						<div class="share-title">
							<span class="tie-icon-share" aria-hidden="true"></span>
							<span> <?php esc_html_e( 'Share', TIELABS_TEXTDOMAIN ); ?></span>
						</div>
						<?php
					}

					echo implode( '', $active_share_buttons );
				?>
			</div><!-- .share-links /-->
		</div><!-- .share-buttons /-->

		<?php

		// For mobile share buttons add a space below it
		if( $share_position == 'mobile' ){
			echo '<div class="mobile-share-buttons-spacer"></div>';
		}

	}
}
