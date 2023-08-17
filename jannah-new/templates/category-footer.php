<?php
/**
 * Category Footer
 *
 * This template can be overridden by copying it to your-child-theme/templates/category-footer.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author   TieLabs
 * @version  5.0.8
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

// Reset the query
wp_reset_query();
wp_reset_postdata();

if( is_category() && tie_get_category_option( 'footer_description' ) ){

	?>


	<div id="category-footer-description">
		<div class="container-wrapper">
		<?php

			if( tie_get_category_option( 'secondary_description_title' ) ): ?>
				<div <?php tie_box_class( 'mag-box-title' ) ?>>
					<h3><?php echo tie_get_category_option( 'secondary_description_title' ) ?></h3>
				</div>
			<?php endif; ?>

			<div class="footer-description-content entry">
				<?php echo apply_filters( 'the_content', wp_kses_stripslashes( stripslashes( tie_get_category_option( 'secondary_description' ) ) ) ); ?>
			</div><!-- .footer-description-content /-->

		</div><!-- .related-posts-list /-->
	</div><!-- #related-posts /-->


	<?php
}
