<?php
/**
 * Header Content Area
 *
 * This template can be overridden by copying it to your-child-theme/templates/header/content.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   2.1.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?>

<div class="container header-container">
	<div class="tie-row logo-row">

		<?php do_action( 'TieLabs/Logo/before_wrapper' ); ?>

		<div class="logo-wrapper">
			<div class="tie-col-md-4 logo-container clearfix">
				<?php

					do_action( 'TieLabs/Logo/before' );

					tie_logo();

					do_action( 'TieLabs/Logo/after' );

				?>
			</div><!-- .tie-col /-->
		</div><!-- .logo-wrapper /-->

		<?php do_action( 'TieLabs/Logo/after_wrapper' ); ?>

	</div><!-- .tie-row /-->
</div><!-- .container /-->
