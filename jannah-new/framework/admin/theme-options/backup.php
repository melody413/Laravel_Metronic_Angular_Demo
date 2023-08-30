<?php

# Export/Import Theme Options
tie_build_theme_option(
	array(
		'title' => esc_html__( 'Export/Import Theme Options', TIELABS_TEXTDOMAIN ),
		'type'  => 'tab-title',
	));

if( isset( $_REQUEST['import'] ) ) {

	tie_build_theme_option(
		array(
			'text' => esc_html__( 'The theme options have been imported successfully.', TIELABS_TEXTDOMAIN ),
			'type' => 'message',
		));
}

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Export', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

?>

<div class="option-item">

	<p><?php esc_html_e( 'When you click the button below the theme will create a .dat file for you to save to your computer.', TIELABS_TEXTDOMAIN ); ?></p>
	<p><?php esc_html_e( 'Once you’ve saved the download file, you can use the Import function in another WordPress installation to import the theme options from this site.', TIELABS_TEXTDOMAIN ); ?></p>

	<p><a class="tie-primary-button button button-primary button-hero" href="<?php print wp_nonce_url( admin_url( 'admin.php?page=tie-theme-options&export-settings' ), 'export-theme-settings', 'export_nonce' ) ?>"><?php esc_html_e( 'Download Export File', TIELABS_TEXTDOMAIN ); ?></a></p>
</div>

<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'Import', TIELABS_TEXTDOMAIN ),
		'type'  => 'header',
	));

?>

<div class="option-item">

	<p><?php esc_html_e( 'Upload your .dat theme options file and we will import the options into this site.', TIELABS_TEXTDOMAIN ); ?></p>
	<p><?php esc_html_e( 'Choose a (.dat) file to upload, then click Upload file and import.', TIELABS_TEXTDOMAIN ); ?></p>

	<p>
		<label for="upload"><?php esc_html_e( 'Choose a file from your computer:', TIELABS_TEXTDOMAIN ); ?></label>
		<input type="file" name="tie_import_file" id="tie-import-file" />
	</p>

	<p>
		<input type="submit" name="tie-import-upload" id="tie-import-upload" class="button-primary" value="<?php esc_html_e( 'Upload file and import', TIELABS_TEXTDOMAIN ); ?>" />
	</p>
</div>





