<?php

	// Above Footer Ad
	if( tie_get_option( 'amp_ad_above_footer' ) ){ ?>
		<div class="amp-custom-ad amp-above-footer-ad amp-ad">
			<?php echo tie_get_option( 'amp_ad_above_footer' ); ?>
		</div>
	<?php
	}

	// Back to top button
	if( tie_get_option( 'amp_back_to_top' ) ){ ?>
		<section class="top">
			<a href="#top">&uarr;</a>
		</section>
		<?php
	}
?>

<footer class="footer">

	<?php

		// Footer Logo
		if( tie_get_option( 'amp_footer_logo' ) ){ ?>
			<a class="footer-logo" href="<?php echo esc_url(home_url( '/' )); ?>" title="<?php echo esc_attr( get_bloginfo('name') ); ?>"></a>
			<?php
		}

		// Footer Menu
		if( tie_get_option( 'amp_footer_menu' ) ){

			$menu = tie_get_option( 'amp_footer_menu' );
			$args = array(
				'container'       => 'nav',
				'container_class' => 'footer-links',
				'items_wrap'      => '%3$s',
				'menu'            => $menu,
				'echo'            => false,
				'depth'           => 1,
			);

			echo strip_tags(wp_nav_menu( $args ), '<nav><a>');
		}


		# Replace Footers variables
		$footer_vars = array( '%year%', '%site%', '%url%' );
		$footer_val  = array( date('Y') , get_bloginfo('name') , esc_url(home_url( '/' )) );

		// First text area
		if( tie_get_option( 'amp_footer_copyright' ) ){
			echo '<div class="footer-colophon">'. str_replace( $footer_vars , $footer_val , tie_get_option( 'amp_footer_copyright' )) . '</div>';
		}
	?>
</footer>
