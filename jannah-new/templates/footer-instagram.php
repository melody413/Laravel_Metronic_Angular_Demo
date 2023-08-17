<?php
/**
 * Instagram Above Footer
 *
 * This template can be overridden by copying it to your-child-theme/templates/footers/footer-instagram.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( tie_get_option( 'footer_instagram' ) && ! TIELABS_HELPER::is_mobile_and_hidden( 'footer_instagram' ) ) {

	$number = tie_get_option( 'footer_instagram_rows' ) == 2 ? 12 : 6;

	$args = array(
		'number' => $number,
		'link'   => tie_get_option( 'footer_instagram_media_link', 'file' ),
	);


	if( ! TIELABS_INSTAGRAM_FEED_IS_ACTIVE ){
		// TIELABS_HELPER::notice_message( sprintf( esc_html__( 'You need to install the %s plugin to use this feature.', TIELABS_TEXTDOMAIN ), '<strong>TieLabs Instagram Feed</strong>' ) );
	}
	elseif( tielabs_instagram_feed_error() ){
		TIELABS_HELPER::notice_message( esc_html__( 'Error: Check the Instagarm section settings.', TIELABS_TEXTDOMAIN ) );
	}
	else{
		?>
		<div id="footer-instagram" class="footer-instagram-section">
			<?php

				if( tie_get_option( 'footer_instagram_button' ) ) {
					$button_text  = tie_get_option( 'footer_instagram_button_text', esc_html__( 'Follow us', TIELABS_TEXTDOMAIN ) );
					$button_url   = tie_get_option( 'footer_instagram_button_url' ) ? tie_get_option( 'footer_instagram_button_url' ) : tielabs_instagram_feed()->account->profile_url();
					$button_style = tie_get_option( 'footer_instagram_button_style' ) ? 'is-'. tie_get_option( 'footer_instagram_button_style' ) : 'is-compact';
					$button_class = "$button_style has-$number-media";

					// --
					if( $button_style == 'is-colored' ){
						$button_class .= ' is-expanded';
						$button_style  = 'is-expanded';
					}

					echo '<div id="instagram-link" class="'. $button_class .'">';
						if( $button_style == 'is-expanded' ){

                echo '<a target="_blank" title="'. $button_text .'" rel="nofollow noopener" href="'. esc_url( $button_url ) .'">';
                  echo '<span class="tie-icon-instagram" aria-hidden="true"></span> ';
                echo'</a>';

                if( $button_style == 'is-expanded' ){
                  echo '<span class="account-username">@'. tielabs_instagram_feed()->account->get('username') .'</span>';
                }

								echo '<a class="follow-button button" title="'. $button_text .'" target="_blank" rel="nofollow noopener" href="'. esc_url( $button_url ) .'">'. $button_text .'</span></a>';

						}
						else{
							echo '<a target="_blank" title="'. $button_text .'" rel="nofollow noopener" href="'. esc_url( $button_url ) .'">';
							echo '<span class="tie-icon-instagram" aria-hidden="true"></span> <span class="follow-button">'. $button_text .'</span>';
							echo'</a>';
						}
					echo'</div>';

				}

				tielabs_instagram_feed()->account->display( $args );
			?>
		</div>
		<?php
	}
}
