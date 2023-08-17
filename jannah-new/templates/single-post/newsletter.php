<?php
/**
 * NewsLetter
 *
 * This template can be overridden by copying it to your-child-theme/templates/single-post/newsletter.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?>

<div class="container-wrapper" id="post-newsletter">
	<div class="subscribe-widget">
		<div class="widget-inner-wrap">

			<span class="tie-icon-envelope newsletter-icon" aria-hidden="true"></span>

			<?php

				if( $text = tie_get_option( 'post_newsletter_text' ) ) { ?>

					<div class="subscribe-widget-content">
						<?php echo do_shortcode( $text ) ?>
					</div>

					<?php
				}

				if( $feedburner = tie_get_option( 'post_newsletter_feedburner' ) ) { ?>

					<form action="https://feedburner.google.com/fb/a/mailverify" method="post" class="subscribe-form" target="popupwindow" onsubmit="window.open('https://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr( $feedburner ) ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
						<label class="screen-reader-text" for="email"><?php esc_html_e( 'Enter your Email address', TIELABS_TEXTDOMAIN ); ?></label>
						<input class="subscribe-input required email" id="email" type="text" name="email" placeholder="<?php esc_html_e( 'Enter your Email address', TIELABS_TEXTDOMAIN ); ?>">
						<input type="hidden" value="<?php echo esc_attr( $feedburner ) ?>" name="uri">
						<input type="hidden" name="loc" value="en_US">
						<input class="button subscribe-submit" type="submit" name="submit" value="<?php esc_html_e( 'Subscribe', TIELABS_TEXTDOMAIN ) ; ?>">
					</form>
					<?php
				}

				elseif( $mailchimp = tie_get_option( 'post_newsletter_mailchimp' ) ) { ?>
					<div id="mc_embed_signup">
						<form action="<?php echo esc_attr( $mailchimp ) ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="subscribe-form validate" target="_blank" novalidate>
							<div id="mc_embed_signup_scroll">
								<div class="mc-field-group">
									<label class="screen-reader-text" for="mce-EMAIL"><?php esc_html_e( 'Enter your Email address', TIELABS_TEXTDOMAIN ); ?></label>
									<input type="email" value="" id="mce-EMAIL" placeholder="<?php esc_html_e( 'Enter your Email address', TIELABS_TEXTDOMAIN ); ?>" name="EMAIL" class="subscribe-input required email" id="mce-EMAIL">
								</div>
								<div id="mce-responses" class="clear">
									<div class="response" id="mce-error-response" style="display:none"></div>
									<div class="response" id="mce-success-response" style="display:none"></div>
								</div>
								<input type="submit" value="<?php esc_html_e( 'Subscribe', TIELABS_TEXTDOMAIN ); ?>" name="subscribe" id="mc-embedded-subscribe" class="button subscribe-submit">
							</div>
						</form>
					</div>
					<?php
				}
			?>

		</div><!-- .widget-inner-wrap /-->
	</div><!-- .subscribe-widget /-->
</div><!-- #post-newsletter /-->

