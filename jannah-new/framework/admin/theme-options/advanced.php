<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Advanced Settings', TIELABS_TEXTDOMAIN ),
		'id'    => 'advanced-settings-tab',
		'type'  => 'tab-title',
	));

tie_build_theme_option(
	array(
		'type'  => 'header',
		'id'    => 'advanced-settings',
		'title' => esc_html__( 'Advanced Settings', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Add a link to the theme options page to the Toolbar', TIELABS_TEXTDOMAIN ),
		'id'   => 'theme_toolbar',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Disable the custom styles in the editor', TIELABS_TEXTDOMAIN ),
		'id'   => 'disable_editor_styles',
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Disable the Posts Switcher', TIELABS_TEXTDOMAIN ),
		'id'   => 'disable_switcher',
		'hint' => esc_html__( 'This will disable the Switcher page, all notifications and hide the plugin from the Bundeled plugins installing page.', TIELABS_TEXTDOMAIN ),
		'type' => 'checkbox',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Disable the Built-in Mega Menus', TIELABS_TEXTDOMAIN ),
		'id'   => 'disable_mega_menu',
		'type' => 'checkbox',
		'hint' => esc_html__( 'Use this option to disable the built-in mega menus feature if you want to use a third party mega menus plugin.', TIELABS_TEXTDOMAIN ),
	));

tie_build_theme_option(
	array(
		'type'  => 'header',
		'id'    => 'reset-all-settings',
		'title' => esc_html__( 'Reset All Settings', TIELABS_TEXTDOMAIN ),
	));
	?>

	<div class="option-item">
		<a id="tie-reset-settings" class="tie-primary-button button button-primary button-hero tie-button-red" href="<?php print wp_nonce_url( admin_url( 'admin.php?page=tie-theme-options&reset-settings' ), 'reset-theme-settings', 'reset_nonce' ) ?>" data-message="<?php esc_html_e( 'This action can not be Undo. Clicking "OK" will reset your theme options to the default installation. Click "Cancel" to stop this operation.', TIELABS_TEXTDOMAIN); ?>"><?php esc_html_e( 'Reset All Settings', TIELABS_TEXTDOMAIN ); ?></a>
	</div>

