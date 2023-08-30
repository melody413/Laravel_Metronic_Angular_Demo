<?php
/**
 * Not Found
 *
 * This template can be overridden by copying it to your-child-theme/templates/not-found.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  2.1.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?>

<header class="entry-header-outer container-wrapper">
	<h1 class="page-title"><?php esc_html_e( 'Nothing Found', TIELABS_TEXTDOMAIN ); ?></h1>
</header><!-- .entry-header-outer /-->

<div class="mag-box not-found">
	<div class="container-wrapper">

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<h5><?php printf( esc_html__( 'Ready to publish your first post? %1$sGet started here%2$s.', TIELABS_TEXTDOMAIN ), '<a href="'. esc_url( admin_url( 'post-new.php' ) ) .'">', '</a>' ); ?></h5>

		<?php elseif ( is_search() ) : ?>

			<h5><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', TIELABS_TEXTDOMAIN ); ?></h5>
			<?php get_search_form(); ?>

		<?php else : ?>

			<h5><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', TIELABS_TEXTDOMAIN ); ?></h5>
			<?php get_search_form(); ?>

		<?php endif; ?>

	</div><!-- .container-wrapper /-->
</div><!-- .mag-box /-->
