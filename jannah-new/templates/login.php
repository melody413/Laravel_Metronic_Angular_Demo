<?php
/**
 * Login
 *
 * This template can be overridden by copying it to your-child-theme/templates/login.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   5.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


$redirect     = apply_filters( 'TieLabs/Login/redirect', site_url() );
$current_user = wp_get_current_user();

if ( is_user_logged_in() ){

	// Build the Array of custom links
	$logged_in_links = array();

	// Add the Dashboared Link
	if( current_user_can( 'manage_options' ) ){
		$logged_in_links['dashboard'] = array(
			'icon' => 'tie-icon-cog',
			'link' => admin_url(),
			'text' => esc_html__( 'Dashboard', TIELABS_TEXTDOMAIN ),
		);
	}

	// Profile Page
	$logged_in_links['profile'] = array(
		'icon' => 'tie-icon-author',
		'link' => get_edit_profile_url(),
		'text' => esc_html__( 'Your Profile', TIELABS_TEXTDOMAIN ),
	);

	// LogOut
	$logged_in_links['logout'] = array(
		'icon' => 'tie-icon-sign-out',
		'link' => wp_logout_url( $redirect ),
		'text' => esc_html__( 'Log Out', TIELABS_TEXTDOMAIN ),
	);

	$logged_in_links = apply_filters( 'TieLabs/Login/links', $logged_in_links, $current_user );

	?>

	<div class="is-logged-login">

		<?php

			do_action( 'TieLabs/Login/before_avatar' );

			// Show the avatar if it is active only
			if( get_option( 'show_avatars' ) ){ ?>
				<span class="author-avatar">
					<a href="<?php echo tie_get_author_profile_url( $current_user->ID ) ?>"><?php echo get_avatar( $current_user->ID, apply_filters( 'TieLabs/Login/avatar_size', '90' ) ); ?></a>
				</span>
				<?php
			}

			do_action( 'TieLabs/Login/after_avatar' );
		?>

		<div class="welcome-text the-subtitle">
			<?php esc_html_e( 'Welcome', TIELABS_TEXTDOMAIN ) ?> <strong><?php echo esc_html( $current_user->display_name ) ?></strong>
		</div>

		<?php

			do_action( 'TieLabs/Login/before_links' );

			if( ! empty( $logged_in_links ) && is_array( $logged_in_links ) ){

				echo '<ul class="user-logged-links">';

				foreach ( $logged_in_links as $link_id => $link_data ){
					echo '<li><a href="'. esc_url( $link_data['link'] ) .'"><span class="'. $link_data['icon'] .'" aria-hidden="true"></span> '. $link_data['text'] .'</a></li>';
				}

				echo '</ul>';
			}


			do_action( 'TieLabs/Login/after_links' );
		?>

	</div>

	<?php
}

else{

	do_action( 'TieLabs/Login/before_form' ); ?>

	<div class="login-form">

		<form name="registerform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ) ?>" method="post">
			<input type="text" name="log" title="<?php esc_html_e( 'Username', TIELABS_TEXTDOMAIN ) ?>" placeholder="<?php esc_html_e( 'Username', TIELABS_TEXTDOMAIN ) ?>">
			<div class="pass-container">
				<input type="password" name="pwd" title="<?php esc_html_e( 'Password', TIELABS_TEXTDOMAIN ) ?>" placeholder="<?php esc_html_e( 'Password' ) ?>">
				<a class="forget-text" href="<?php echo wp_lostpassword_url( $redirect ) ?>"><?php esc_html_e( 'Forget?', TIELABS_TEXTDOMAIN ) ?></a>
			</div>

			<input type="hidden" name="redirect_to" value="<?php echo esc_attr( apply_filters( 'TieLabs/Login/redirect_after', $_SERVER['REQUEST_URI'] ) ); ?>"/>
			<label for="rememberme" class="rememberme">
				<input id="rememberme" name="rememberme" type="checkbox" checked="checked" value="forever" /> <?php esc_html_e( 'Remember me', TIELABS_TEXTDOMAIN ) ?>
			</label>

			<?php
				if( ! TIELABS_JETPACK_IS_ACTIVE ){
					do_action( 'login_form' );
				}
			?>

			<?php do_action( 'TieLabs/Login/before_button' ); ?>

			<button type="submit" class="button fullwidth login-submit"><?php esc_html_e( 'Log In', TIELABS_TEXTDOMAIN ) ?></button>

			<?php do_action( 'TieLabs/Login/after_button' ); ?>
		</form>

		<?php

			do_action( 'TieLabs/Login/after_form' );

			// Register Link
			if ( get_option( 'users_can_register' ) ){

				$registration_url = sprintf( '<p class="register-link"><a href="%1$s">%2$s</a></p>', esc_url( wp_registration_url() ), esc_html__( "Don't have an account?", TIELABS_TEXTDOMAIN ) );
				echo apply_filters( 'register', $registration_url );
			}
		?>

	</div>
	<?php
}
