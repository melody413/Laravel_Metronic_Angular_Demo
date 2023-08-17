<?php
/**
 * The template for the Footer widgets area
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( tie_get_option( 'footer_widgets_'.$name ) ):

	$normal_width  = ' normal-side';
	$footer_layout = tie_get_option( 'footer_widgets_layout_'.$name );
	$border_class  = tie_get_option( 'footer_widgets_border_'.$name ) ? 'footer-boxed-widget-area' : '';

	$footer_widget_1 = $footer_widget_2 = $footer_widget_3 = $footer_widget_4 = '';

	# Footer Columns
	switch ( $footer_layout ){

		case 'footer-1c':
			$footer_widget_1 = 'fullwidth-area tie-col-sm-12';
			$normal_width    = '';
			break;

		case 'footer-2c':
			$footer_widget_1 = $footer_widget_2 = 'tie-col-sm-6';
			break;

		case 'narrow-wide-2c':
			$footer_widget_1 = 'tie-col-sm-4';
			$footer_widget_2 = 'tie-col-sm-8';
			break;

		case 'wide-narrow-2c':
			$footer_widget_1 = 'tie-col-sm-8';
			$footer_widget_2 = 'tie-col-sm-4';
			break;

		case 'footer-3c':
			$footer_widget_1 = $footer_widget_2 = $footer_widget_3 = 'tie-col-sm-4';
			break;

		case 'wide-left-3c':
			$footer_widget_1 = 'tie-col-sm-6';
			$footer_widget_2 = $footer_widget_3 = 'tie-col-sm-3';
			break;

		case 'wide-right-3c':
			$footer_widget_1 = $footer_widget_2 = 'tie-col-sm-3';
			$footer_widget_3 = 'tie-col-sm-6';
			break;

		case 'footer-4c':
			$footer_widget_1 = $footer_widget_2 = $footer_widget_3 = $footer_widget_4 = 'tie-col-md-3';
			break;

		default:
	}

	$first_column  = 'first-footer-widget-'.$name;
	$second_column = 'second-footer-widget-'.$name;
	$third_column  = 'third-footer-widget-'.$name;
	$fourth_column = 'fourth-footer-widget-'.$name;

	if(
		is_active_sidebar( $first_column )  ||
		is_active_sidebar( $second_column ) ||
		is_active_sidebar( $third_column )  ||
		is_active_sidebar( $fourth_column ) ){ ?>

		<div class="footer-widget-area <?php echo esc_attr( $border_class ) ?>">
			<div class="tie-row">

				<?php if ( is_active_sidebar( $first_column )): ?>
					<div class="<?php echo esc_attr( $footer_widget_1.$normal_width ) ?>">
						<?php dynamic_sidebar( $first_column ); ?>
					</div><!-- .tie-col /-->
				<?php endif; ?>

				<?php if ( is_active_sidebar( $second_column )): ?>
					<div class="<?php echo esc_attr( $footer_widget_2.$normal_width ) ?>">
						<?php dynamic_sidebar( $second_column ); ?>
					</div><!-- .tie-col /-->
				<?php endif; ?>

				<?php if ( is_active_sidebar( $third_column )): ?>
					<div class="<?php echo esc_attr( $footer_widget_3.$normal_width ) ?>">
						<?php dynamic_sidebar( $third_column ); ?>
					</div><!-- .tie-col /-->
				<?php endif; ?>

				<?php if ( is_active_sidebar( $fourth_column )): ?>
					<div class="<?php echo esc_attr( $footer_widget_4.$normal_width ) ?>">
						<?php dynamic_sidebar( $fourth_column ); ?>
					</div><!-- .tie-col /-->
				<?php endif; ?>

			</div><!-- .tie-row /-->
		</div><!-- .footer-widget-area /-->

		<?php
	}

endif;
