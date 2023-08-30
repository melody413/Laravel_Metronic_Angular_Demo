<?php
/**
 * BuddyPress - Home
 *
 * @version 3.0.0
 */

?>

	<?php bp_nouveau_before_activity_directory_content(); ?>

	<?php bp_nouveau_template_notices(); ?>

	<div class="activity" data-bp-single="<?php echo esc_attr( bp_current_action() ); ?>">

		<ul id="activity-stream" class="activity-list item-list bp-list" data-bp-list="activity">

			<li id="bp-ajax-loader"><?php bp_nouveau_user_feedback( 'single-activity-loading' ); ?></li>

		</ul>

	</div>

	<?php bp_nouveau_after_activity_directory_content(); // This should be after .screen-content | TieLabs ?>
