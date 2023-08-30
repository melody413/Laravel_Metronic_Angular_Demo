<?php

tie_build_theme_option(
	array(
		'title' => esc_html__( 'BuddyPress', TIELABS_TEXTDOMAIN ),
		'id'    => 'buddypress-tab',
		'type'  => 'tab-title',
	));

tie_build_theme_option(
	array(
		'name' => esc_html__( 'Use the BuddyPress Member Profile link', TIELABS_TEXTDOMAIN ),
		'id'   => 'bp_use_member_profile',
		'type' => 'checkbox',
		'hint' => esc_html__( 'Use the BuddyPress Member Profile link instead of the default author page link in the post meta, author box and the login sections.', TIELABS_TEXTDOMAIN ),
	));
