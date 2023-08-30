<?php

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Header Settings', TIELABS_TEXTDOMAIN ),
			'id'    => 'header-settings-tab',
			'type'  => 'tab-title',
		));


$lock_settings = 'block';

if( ! get_option( 'tie_token_'.TIELABS_THEME_ID ) ){

	$lock_settings = 'none !important';

	tie_build_theme_option(
		array(
			'text' => esc_html__( 'Verify your license to unlock this section.', TIELABS_TEXTDOMAIN ),
			'type' => 'error',
		));
}

echo '<div style="display:'. $lock_settings .'" >';



	$headers_path   = TIELABS_TEMPLATE_URL. '/framework/admin/assets/images/headers';
	$top_nav_class  = '';
	$header_class   = '';
	$main_nav_class = '';

	//Top Nav Classes
	if( !tie_get_option( 'top_nav' ) ){
		$top_nav_class .= ' tie-hide';
		$header_class  .= ' top-nav-disabled';
	}

	if( tie_get_option( 'top_nav_dark' ) ){
		$top_nav_class .= ' top-nav-dark-skin';
	}

	if( !tie_get_option( 'top_nav_layout' ) ){
		$top_nav_class .= ' top-nav-full';
	}

	if( tie_get_option( 'top_nav_position' ) ){
		$header_class .= ' top-nav-below';
	}

	if( tie_get_option( 'header_layout' ) ){
		$header_class .= ' header-layout-'.tie_get_option( 'header_layout' );
	}

	if( tie_get_option( 'header_layout' ) == 4 ){
		$header_class .= ' header-layout-1';
	}

	//Top Components
	$top_components = '
		<span class="top-nav-components-live_search">
			<span class="header-top-nav-components-search1 tie-alert-circle top-nav-components_search_layout-options">
				<img loading="lazy" class="h-light-skin" src="'. esc_url( $headers_path ) .'/search-icon-light.png" alt="" />
				<img loading="lazy" class="h-dark-skin" src="'. esc_url( $headers_path ) .'/search-icon.png" alt="" />
			</span>
			<span class="header-top-nav-components-search tie-alert-circle top-nav-components_search_layout-options">
				<img loading="lazy" class="h-light-skin" src="'. esc_url( $headers_path ) .'/search-light.png" alt="" />
				<img loading="lazy" class="h-dark-skin" src="'. esc_url( $headers_path ) .'/search.png" alt="" />
			</span>
		</span>

		<span class="header-top-nav-components-skin tie-alert-circle">
			<img loading="lazy" class="h-light-skin" src="'. esc_url( $headers_path ) .'/skin-light.png" alt="" />
			<img loading="lazy" class="h-dark-skin" src="'. esc_url( $headers_path ) .'/skin.png" alt="" />
		</span>

		<span class="header-top-nav-components-slide tie-alert-circle">
			<img loading="lazy" class="h-light-skin" src="'. esc_url( $headers_path ) .'/slide-light.png" alt="" />
			<img loading="lazy" class="h-dark-skin" src="'. esc_url( $headers_path ) .'/slide.png" alt="" />
		</span>

		<span class="header-top-nav-components-login tie-alert-circle">
			<img loading="lazy" class="h-light-skin" src="'. esc_url( $headers_path ) .'/login-light.png" alt="" />
			<img loading="lazy" class="h-dark-skin" src="'. esc_url( $headers_path ) .'/login.png" alt="" />
		</span>

		<span class="header-top-nav-components-random tie-alert-circle">
			<img loading="lazy" class="h-light-skin" src="'. esc_url( $headers_path ) .'/random-light.png" alt="" />
			<img loading="lazy" class="h-dark-skin" src="'. esc_url( $headers_path ) .'/random.png" alt="" />
		</span>
	';

	if ( TIELABS_WOOCOMMERCE_IS_ACTIVE ){
		$top_components .= '
			<span class="header-top-nav-components-cart tie-alert-circle">
				<img loading="lazy" class="h-light-skin" src="'. esc_url( $headers_path ) .'/cart-light.png" alt="" />
				<img loading="lazy" class="h-dark-skin" src="'. esc_url( $headers_path ) .'/cart.png" alt="" />
			</span>
		';
	}

	if ( TIELABS_BUDDYPRESS_IS_ACTIVE ){
		$top_components .= '
			<span class="header-top-nav-components-bp_notifications tie-alert-circle">
				<img loading="lazy" class="h-light-skin" src="'. esc_url( $headers_path ) .'/bp_notifications-light.png" alt="" />
				<img loading="lazy" class="h-dark-skin" src="'. esc_url( $headers_path ) .'/bp_notifications.png" alt="" />
			</span>
		';
	}

	$top_components .= '
		<span class="top-nav-components-live_social">
			<span class="header-top-nav-components-follow tie-alert-circle top-nav-components_social_layout-options">
				<img loading="lazy" class="h-light-skin" src="'. esc_url( $headers_path ) .'/follow-light.png" alt="" />
				<img loading="lazy" class="h-dark-skin" src="'. esc_url( $headers_path ) .'/follow.png" alt="" />
			</span>
			<span class="header-top-nav-components-follow1 tie-alert-circle top-nav-components_social_layout-options">
				<img loading="lazy" class="h-light-skin" src="'. esc_url( $headers_path ) .'/follow-icons-light.png" alt="" />
				<img loading="lazy" class="h-dark-skin" src="'. esc_url( $headers_path ) .'/follow-icons.png" alt="" />
			</span>
		</span>
	';

	$top_components .= '
		<span class="header-top-nav-components-weather tie-alert-circle">
			<img loading="lazy" class="h-light-skin" src="'. esc_url( $headers_path ) .'/weather-light.png" alt="" />
			<img loading="lazy" class="h-dark-skin" src="'. esc_url( $headers_path ) .'/weather.png" alt="" />
		</span>
	';



	//Main Nav Classes
	if( !tie_get_option( 'main_nav' ) ){
		$main_nav_class .= ' tie-hide';
		$header_class   .= ' main-nav-disabled';
	}

	if( tie_get_option( 'main_nav_dark' ) ){
		$main_nav_class .= ' main-nav-dark-skin';
	}

	if( !tie_get_option( 'main_nav_layout' ) ){
		$main_nav_class .= ' main-nav-full';
	}

	if( tie_get_option( 'main_nav_position' ) ){
		$header_class .= ' main-nav-above';
	}
	?>
<div id="header-preview-wrapper">
	<div id="header-preview" class="site-header<?php echo esc_attr( $header_class ) ?>">
		<div class="top-nav-container">
			<div class="main-nav-container">

				<div class="top-bar-wrap<?php echo esc_attr( $top_nav_class ) ?>">
					<div class="top-bar">

						<div class="tie-alignleft">
							<?php
							$date_format = 'l ,  j  F Y';
							if( tie_get_option( 'todaydate_format' ) ){
								$date_format = tie_get_option( 'todaydate_format' );
							}
								?>
								<span id="today-date">
									<?php echo date_i18n( $date_format, current_time( 'timestamp' ) ); ?>
								</span>


							<span id="top-nav-breaking-news" class="top-nav-area-1-options tie-alert-circle">
								<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/breaking-light.png" alt="" />
								<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/breaking.png" alt="" />
							</span>

							<span id="top-nav-menu-1" class="top-nav-area-1-options tie-alert-circle">
								<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/top-menu-light.png" alt="" />
								<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/top-menu.png" alt="" />
							</span>

							<span id="top-nav-components-1" class="components-icons top-nav-area-1-options">
								<?php echo ( $top_components ) ?>
							</span>
						</div><!-- .tie-alignleft /-->

						<div class="tie-alignright">
							<span id="top-nav-menu-2" class="top-nav-area-2-options tie-alert-circle">
								<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/top-menu-light.png" alt="" />
								<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/top-menu.png" alt="" />
							</span>

							<span id="top-nav-components-2" class="components-icons top-nav-area-2-options">
								<?php echo ( $top_components ) ?>
							</span>
						</div><!-- .tie-alignright -->

					</div><!-- .top-bar -->
				</div><!-- .top-bar-wrap -->

				<div class="header-content">
					<img loading="lazy" class="header-top-logo" src="<?php echo esc_url( $headers_path ) ?>/header-logo.png" style="width:130px;" alt="" />
					<img loading="lazy" class="header-top-ads" src="<?php echo esc_url( $headers_path ) ?>/header-e3lan.png" style="width:500px;" alt="" />
				</div><!-- .header-content -->

				<div class="header-main-menu-wrap<?php echo esc_attr( $main_nav_class ) ?>">
					<div class="header-main-menu">

						<img loading="lazy" class="header-top-logo" src="<?php echo esc_url( $headers_path ) ?>/header-logo.png" style="width:130px;" alt="" />

						<div class="tie-alignleft">
							<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/menu.png" height="40" alt="" />
							<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/menu-light.png" height="40" alt="" />
						</div><!-- .tie-alignleft /-->


						<div id="main-nav-components" class="components-icons">
							<span class="main-nav-components-live_search">
								<span class="header-main-nav-components-search1 tie-alert-circle main-nav-components_search_layout-options">
									<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/search-icon-light.png" height="40" alt="" />
									<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/search-icon.png" height="40" alt="" />
								</span>
								<span class="header-main-nav-components-search tie-alert-circle main-nav-components_search_layout-options">
									<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/search-light.png" height="40" alt="" />
									<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/search.png" height="40" alt="" />
								</span>
							</span>

							<span class="header-main-nav-components-skin tie-alert-circle">
								<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/skin-light.png" height="40" alt="" />
								<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/skin.png" height="40" alt="" />
							</span>

							<span class="header-main-nav-components-slide tie-alert-circle">
								<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/slide-light.png" height="40" alt="" />
								<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/slide.png" height="40" alt="" />
							</span>
							<span class="header-main-nav-components-login tie-alert-circle">
								<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/login-light.png" height="40" alt="" />
								<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/login.png" height="40" alt="" />
							</span>
							<span class="header-main-nav-components-random tie-alert-circle">
								<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/random-light.png" height="40" alt="" />
								<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/random.png" height="40" alt="" />
							</span>

							<?php
							if ( TIELABS_WOOCOMMERCE_IS_ACTIVE ){?>
								<span class="header-main-nav-components-cart tie-alert-circle">
									<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/cart-light.png" height="40" alt="" />
									<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/cart.png" height="40" alt="" />
								</span>
								<?php
							}
							?>

							<?php
							if ( TIELABS_BUDDYPRESS_IS_ACTIVE ){ ?>
								<span class="header-main-nav-components-bp_notifications tie-alert-circle">
									<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/bp_notifications-light.png" height="40" alt="" />
									<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/bp_notifications.png" height="40" alt="" />
								</span>
								<?php
							}
							?>

							<span class="main-nav-components-live_social">
								<span class="header-main-nav-components-follow tie-alert-circle main-nav-components_social_layout-options">
									<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/follow-light.png" height="40" alt="" />
									<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/follow.png" height="40" alt="" />
								</span>
								<span class="header-main-nav-components-follow1 tie-alert-circle main-nav-components_social_layout-options">
									<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/follow-icons-light.png" height="40" alt="" />
									<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/follow-icons.png" height="40" alt="" />
								</span>
							</span>


							<span class="header-main-nav-components-weather tie-alert-circle">
								<img loading="lazy" class="h-light-skin" src="<?php echo esc_url( $headers_path ) ?>/weather-light.png" height="40" alt="" />
								<img loading="lazy" class="h-dark-skin" src="<?php echo esc_url( $headers_path ) ?>/weather.png" height="40" alt="" />
							</span>


						</div><!-- #main-nav-components-->

					</div><!-- #main-nav-components-->
				</div><!-- .header-main-menu-wrap-->

			</div><!-- .main-nav-container /-->
		</div><!-- .top-nav-container /-->
	</div><!-- #header-preview-->
</div><!-- #header-preview-wrapper-->

	<?php

	tie_build_theme_option(
		array(
			'title' => esc_html__( 'Header Layout', TIELABS_TEXTDOMAIN ),
			'id'    => 'header-layout',
			'type'  => 'header',
		));

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Header Layout', TIELABS_TEXTDOMAIN ),
			'id'     => 'header_layout',
			'type'   => 'radio',
			'toggle' => array(
				'3' => '',
				'2' => '',
				'1' => '',
			),
			'options' => array(
				'3' => esc_html__( 'Layout', TIELABS_TEXTDOMAIN ) .' #1',
				'2'	=> esc_html__( 'Layout', TIELABS_TEXTDOMAIN ) .' #2',
				'1' => esc_html__( 'Layout', TIELABS_TEXTDOMAIN ) .' #3',
				'4' => esc_html__( 'Layout', TIELABS_TEXTDOMAIN ) .' #4',
			)));


		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Stretch Header', TIELABS_TEXTDOMAIN ),
				'id'   => 'stretch_header',
				'type' => 'checkbox',
				'hint' => esc_html__( 'Stretch the section to the full width of the page, supported if the site layout is Full-Width.', TIELABS_TEXTDOMAIN ),
			));


		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Full-Width Logo', TIELABS_TEXTDOMAIN ),
				'id'   => 'full_logo',
				'type' => 'checkbox',
			));
	?>

	<div class="tie-section-title tie-section-tabs header-settings-tabs">
		<a href="#main-nav-settings" class="active"><?php esc_html_e( 'Main Nav Settings', TIELABS_TEXTDOMAIN ) ?></a>
		<a href="#top-nav-settings"><?php esc_html_e( '​Secondary Nav Settings',  TIELABS_TEXTDOMAIN ) ?></a>
	</div>


	<?php

	echo'<div id="top-nav-settings" class="top-main-nav-settings">';

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Enable', TIELABS_TEXTDOMAIN ),
				'id'     => 'top_nav',
				'type'   => 'checkbox',
				'toggle' => '.top-nav-news-all-options, #header-preview .top-bar-wrap',
			));

		echo'<div class="top-nav-news-all-options">';

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Dark Skin', TIELABS_TEXTDOMAIN ),
				'id'   => 'top_nav_dark',
				'type' => 'checkbox',
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Boxed Layout', TIELABS_TEXTDOMAIN ),
				'id'   => 'top_nav_layout',
				'type' => 'checkbox',
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Below The Header', TIELABS_TEXTDOMAIN ),
				'id'   =>  'top_nav_position',
				'type' => 'checkbox',
			));

		tie_build_theme_option(
			array(
				'name'   => esc_html__( "Today's date", TIELABS_TEXTDOMAIN ),
				'id'     => 'top_date',
				'toggle' => '#todaydate_format-item, #today-date',
				'type'   => 'checkbox',
			));

		tie_build_theme_option(
			array(
				'name'    => esc_html__( "Today's date format", TIELABS_TEXTDOMAIN ),
				'id'      => 'todaydate_format',
				'type'    => 'text',
				'default' => 'l ,  j  F Y',
				'hint'    => '<a target="_blank" href="http://codex.wordpress.org/Formatting_Date_and_Time">'.esc_html__( 'Documentation on date and time formatting', TIELABS_TEXTDOMAIN ).'</a>',
			));


		echo '<div class="top-nav-areas-live-options tie-two-columns-options">';

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Left Area', TIELABS_TEXTDOMAIN ),
				'id'     => 'top-nav-area-1',
				'type'   => 'radio',
				'toggle' => array(
					'none'       => '',
					'components' => '#top-nav-components-1, .top-nav-components-wrapper',
					'menu'       => '#top-nav-menu-1',
					'breaking'   => '#top-nav-breaking-news, .breaking-news-all-options',),
				'options' => array(
					''           => esc_html__( 'Disable', TIELABS_TEXTDOMAIN ),
					'components' => esc_html__( 'Components', TIELABS_TEXTDOMAIN ),
					'menu'       => esc_html__( 'Menu', TIELABS_TEXTDOMAIN ),
					'breaking'   => esc_html__( 'Breaking News', TIELABS_TEXTDOMAIN ),
			)));

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Right Area', TIELABS_TEXTDOMAIN ),
				'id'     => "top-nav-area-2",
				'type'   => "radio",
				'toggle' => array(
					'none'       => '',
					'components' => '#top-nav-components-2, .top-nav-components-wrapper',
					'menu'       => '#top-nav-menu-2',),
				'options' => array(
					''           => esc_html__( 'Disable', TIELABS_TEXTDOMAIN ),
					'components' => esc_html__( 'Components', TIELABS_TEXTDOMAIN ),
					'menu'       => esc_html__( 'Menu', TIELABS_TEXTDOMAIN ),
					)));

		echo'<div class="clear"></div></div>';

		tie_header_area_options( esc_html__( '​Secondary Nav Components', TIELABS_TEXTDOMAIN ), 'top-nav-components' );

		echo'<div class="breaking-news-all-options top-nav-area-1-options">';

		tie_build_theme_option(
			array(
				'title' => esc_html__( 'Breaking News', TIELABS_TEXTDOMAIN ),
				'id'    => 'breaking_news_head',
				'type'  => 'header',
			));

		tie_build_theme_option(
			array(
				'name'        => esc_html__( 'Title', TIELABS_TEXTDOMAIN ),
				'id'          => 'breaking_title',
				'placeholder'	=> esc_html__( 'Breaking News', TIELABS_TEXTDOMAIN ),
				'type'        => 'text',
			));

		tie_build_theme_option(
			array(
				'name'    => esc_html__( 'Animation Effect', TIELABS_TEXTDOMAIN ),
				'id'      => 'breaking_effect',
				'type'    => "select",
				'options' => array(
					'reveal'     => esc_html__( 'Typing',        TIELABS_TEXTDOMAIN ),
					'flipY'      => esc_html__( 'Fading',        TIELABS_TEXTDOMAIN ),
					'slideLeft'  => esc_html__( 'Sliding Left',  TIELABS_TEXTDOMAIN ),
					'slideRight' => esc_html__( 'Sliding Right', TIELABS_TEXTDOMAIN ),
					'slideUp'    => esc_html__( 'Sliding Up',    TIELABS_TEXTDOMAIN ),
					'slideDown'  => esc_html__( 'Sliding Down',  TIELABS_TEXTDOMAIN ),
			)));

		tie_build_theme_option(
			array(
				'name'  =>  esc_html__( 'Speed in ms', TIELABS_TEXTDOMAIN ),
				'id'    => 'breaking_speed',
				'type'  => 'number',
				'hint'  => sprintf( esc_html__( 'Default is: %s', TIELABS_TEXTDOMAIN ), 2000 ),
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Show the scrolling arrows?', TIELABS_TEXTDOMAIN ),
				'id'   => 'breaking_arrows',
				'type' => 'checkbox',
			));

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Query Type', TIELABS_TEXTDOMAIN ),
				'id'     => 'breaking_type',
				'type'   => 'radio',
				'toggle' => array(
					'category' => '#breaking_cat-item, #breaking_number-item',
					'tag'      => '#breaking_tag-item, #breaking_number-item',
					'custom'   => '#breaking_custom-item'),
				'options' => array(
					'category' => esc_html__( 'Categories', TIELABS_TEXTDOMAIN ),
					'tag'      => esc_html__( 'Tags', TIELABS_TEXTDOMAIN ),
					'custom'   => esc_html__( 'Custom Text', TIELABS_TEXTDOMAIN ),
				)));

		tie_build_theme_option(
			array(
				'name'    => esc_html__( 'Categories', TIELABS_TEXTDOMAIN ),
				'id'      => 'breaking_cat',
				'class'   => 'breaking_type',
				'type'    => 'select-multiple',
				'options' => TIELABS_ADMIN_HELPER::get_categories(),
			));

		tie_build_theme_option(
			array(
				'name'  => esc_html__( 'Tags', TIELABS_TEXTDOMAIN ),
				'hint'  => esc_html__( 'Enter a tag name, or names separated by comma.', TIELABS_TEXTDOMAIN ),
				'id'    => 'breaking_tag',
				'class'	=> 'breaking_type',
				'type'  => 'text',
			));

		tie_build_theme_option(
			array(
				'name'    => esc_html__( 'Number of posts to show', TIELABS_TEXTDOMAIN ),
				'id'      => 'breaking_number',
				'class'   => 'breaking_type',
				'default' => 10,
				'type'    => 'number',
			));

			?>


		<div class="option-item breaking_type-options" id="breaking_custom-item">

			<span class="tie-label"><?php esc_html_e( 'Add Custom Text', TIELABS_TEXTDOMAIN ) ?></span>
			<input id="custom_text" type="text" size="56" name="custom_text" placeholder="<?php esc_html_e( 'Custom Text', TIELABS_TEXTDOMAIN ) ?>" value="" />
			<input id="custom_link" type="text" size="56" name="custom_link" placeholder="http://" value="" />
			<input id="breaking_news_button"  class="button" type="button" value="<?php esc_html_e( 'Add', TIELABS_TEXTDOMAIN ) ?>" />

			<?php

				tie_build_theme_option(
					array(
						'text' => esc_html__( 'Text and Link are required.', TIELABS_TEXTDOMAIN ),
						'id'   => 'breaking_custom_error',
						'type' => 'error',
					));
			?>

			<script>
				jQuery(function(){
					jQuery( "#customList" ).sortable({placeholder: "tie-state-highlight"});
				});
			</script>

			<div class="clear"></div>
			<ul id="customList">
				<?php
					$breaking_custom 	= tie_get_option( 'breaking_custom' );
					$custom_count 		= 0;

					if( ! empty( $breaking_custom ) && is_array( $breaking_custom ) ) {
						foreach ( $breaking_custom as $custom_text ){
							$custom_count++; ?>

							<li class="parent-item">
								<div class="tie-block-head">
									<a href="<?php echo esc_attr( $custom_text['link'] ) ?>" target="_blank"><?php echo esc_html( $custom_text['text'] ) ?></a>
									<input name="tie_options[breaking_custom][<?php echo esc_attr( $custom_count ) ?>][link]" type="hidden" value="<?php echo esc_attr( $custom_text['link'] ) ?>" />
									<input name="tie_options[breaking_custom][<?php echo esc_attr( $custom_count ) ?>][text]" type="hidden" value="<?php echo esc_attr( $custom_text['text'] ) ?>" />
									<a class="del-item dashicons dashicons-trash"></a>
								</div>
							</li>
							<?php
						}
					}
				?>
			</ul>

			<script>
				var customnext = <?php echo esc_js( $custom_count+1 ); ?> ;
			</script>

		</div><!-- #breaking_custom-item /-->
	</div> <!-- Breaking News /-->

	<?php

	echo'</div><!-- .top-nav-news-all-options /-->';
	echo'</div><!-- #top-nav-settings /-->';

	echo'<div id="main-nav-settings" class="top-main-nav-settings">';

	tie_build_theme_option(
		array(
			'name'   => esc_html__( 'Enable', TIELABS_TEXTDOMAIN ),
			'id'     => 'main_nav',
			'type'   => 'checkbox',
			'toggle' => '.main-nav-related-options, .main-nav-components-wrapper, #header-preview .header-main-menu-wrap',
		));

	tie_build_theme_option(
		array(
			'name'  => esc_html__( 'Dark Skin', TIELABS_TEXTDOMAIN ),
			'id'    => 'main_nav_dark',
			'type'  => 'checkbox',
			'class' => 'main-nav-related',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Boxed Layout', TIELABS_TEXTDOMAIN ),
			'id'   => 'main_nav_layout',
			'type' => 'checkbox',
			'class' => 'main-nav-related',
		));

	tie_build_theme_option(
		array(
			'name' => esc_html__( 'Above The Header', TIELABS_TEXTDOMAIN ),
			'id'   => 'main_nav_position',
			'type' => 'checkbox',
			'class' => 'main-nav-related',
		));

	tie_header_area_options( esc_html__( 'Main Nav Components', TIELABS_TEXTDOMAIN ), 'main-nav-components' );


	echo '<div id="sticky-nav-section" class="main-nav-related-options">';

		tie_build_theme_option(
			array(
				'title' => esc_html__( 'Sticky Menu', TIELABS_TEXTDOMAIN ),
				'id'    => 'sticky-menu',
				'type'  => 'header',
			));

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Enable', TIELABS_TEXTDOMAIN ),
				'id'     => 'stick_nav',
				'toggle' => '#sticky-menu-items',
				'type'   => 'checkbox',
			));

		echo '<div id="sticky-menu-items">';

			tie_build_theme_option(
				array(
					'name'    => esc_html__( 'Sticky Menu behavior', TIELABS_TEXTDOMAIN ),
					'id'      => 'sticky_behavior',
					'type'    => 'radio',
					'options' => array(
						'default' => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'upwards' => esc_html__( 'When scrolling upwards', TIELABS_TEXTDOMAIN ),
					)));

			tie_build_theme_option(
				array(
					'name'   => esc_html__( 'Sticky Menu Logo', TIELABS_TEXTDOMAIN ),
					'id'     => 'sticky_logo_type',
					'toggle' => '#sticky-logo-options',
					'type'   => 'checkbox',
				));

				echo '<div id="sticky-logo-options">';

					tie_build_theme_option(
						array(
							'name'   => esc_html__( 'Custom Sticky Menu Logo', TIELABS_TEXTDOMAIN ),
							'hint'   => esc_html__( 'Use this option to set a custom logo in the sticky menu or Disable it to use the main logo.', TIELABS_TEXTDOMAIN ),
							'id'     => 'custom_logo_sticky',
							'toggle' => '#sticky-logo-custom-options',
							'type'   => 'checkbox',
						));

					echo '<div id="sticky-logo-custom-options">';

						tie_build_theme_option(
							array(
								'name'  => esc_html__( 'Logo Image', TIELABS_TEXTDOMAIN ),
								'id'    => 'logo_sticky',
								'type'  => 'upload',
							));

						tie_build_theme_option(
							array(
								'name'  => esc_html__( 'Logo Image (Retina Version @2x)', TIELABS_TEXTDOMAIN ),
								'id'    => 'logo_retina_sticky',
								'type'  => 'upload',
								'hint'	=> esc_html__( 'Please choose an image file for the retina version of the logo. It should be 2x the size of main logo.', TIELABS_TEXTDOMAIN ),
							));

					echo'</div><!-- #sticky-logo-custom-options -->';
				echo'</div><!-- #sticky-logo-options -->';
			echo'</div><!-- #sticky-menu-items -->';


		echo'</div><!-- #sticky-nav-section -->';

	echo'</div><!-- #top-nav-settings /-->';







/*-----------------------------------------------------------------------------------*/
# Header area options
/*-----------------------------------------------------------------------------------*/
function tie_header_area_options( $text_field, $area_name ){ ?>
	<div class="<?php echo esc_attr( $area_name.'-wrapper' ) ?>">

	<?php

		tie_build_theme_option(
			array(
				'title' => $text_field,
				'id'    => $area_name,
				'type'  => 'header',
			));

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Search', TIELABS_TEXTDOMAIN ),
				'id'     => $area_name.'_search',
				'type'   => 'checkbox',
				'toggle' => "#$area_name-search, .$area_name-live_search",
			));

	?>

	<div id="<?php echo esc_attr( $area_name ) ?>-search">

		<?php

			tie_build_theme_option(
				array(
					'name' => esc_html__( 'Live Search', TIELABS_TEXTDOMAIN ),
					'id'   => $area_name.'_live_search',
					'type' => 'checkbox',
				));

			tie_build_theme_option(
				array(
					'name'   => esc_html__( 'Search Layout', TIELABS_TEXTDOMAIN ),
					'id'     => $area_name."_search_layout",
					'type'   => "radio",
					'toggle' => array(
						'default' => ".header-$area_name-search",
						'compact'	=> ".header-$area_name-search1, #$area_name"."_type_to_search-item" ),
					'options' => array(
						'default' => esc_html__( 'Default', TIELABS_TEXTDOMAIN ),
						'compact' => esc_html__( 'Compact', TIELABS_TEXTDOMAIN ),
				)));

			tie_build_theme_option(
				array(
					'name'  => esc_html__( 'Type To Search', TIELABS_TEXTDOMAIN ),
					'id'    => $area_name.'_type_to_search',
					'class' => $area_name.'_search_layout',
					'type'  => 'checkbox',

				));
		?>

	</div>

	<?php

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Slide Sidebar', TIELABS_TEXTDOMAIN ),
				'id'     => $area_name.'_slide_area',
				'type'   => 'checkbox',
				'toggle' => ".header-$area_name-slide",
			));

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Log In', TIELABS_TEXTDOMAIN ),
				'id'     => $area_name.'_login',
				'type'   => 'checkbox',
				'toggle' => ".header-$area_name-login, #$area_name"."_login_text-item",
			));

		tie_build_theme_option(
			array(
				'name' => esc_html__( 'Log In text', TIELABS_TEXTDOMAIN ),
				'id'   => $area_name.'_login_text',
				'type' => 'text',
				'hint' => esc_html__( 'Text beside the icon, Leave this empty to disable.', TIELABS_TEXTDOMAIN ),
			));

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Random Article Button', TIELABS_TEXTDOMAIN ),
				'id'     => $area_name.'_random',
				'type'   => 'checkbox',
				'toggle' => ".header-$area_name-random",
			));

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Light/Dark Skin Switcher', TIELABS_TEXTDOMAIN ),
				'id'     => $area_name.'_skin',
				'type'   => 'checkbox',
				'toggle' => ".header-$area_name-skin",
			));

		if ( TIELABS_WOOCOMMERCE_IS_ACTIVE ){
			tie_build_theme_option(
				array(
					'name'   => esc_html__( 'Shopping Cart', TIELABS_TEXTDOMAIN ),
					'id'     => $area_name.'_cart',
					'type'   => 'checkbox',
					'toggle' => ".header-$area_name-cart",
				));
		}

		if ( TIELABS_BUDDYPRESS_IS_ACTIVE ){
			tie_build_theme_option(
				array(
					'name'   => esc_html__( 'BuddyPress Notifications', TIELABS_TEXTDOMAIN ),
					'id'     => $area_name.'_bp_notifications',
					'type'   => 'checkbox',
					'toggle' => ".header-$area_name-bp_notifications",
				));
		}

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Social Icons', TIELABS_TEXTDOMAIN ),
				'id'		 => $area_name.'_social',
				'type'   => "checkbox",
				'toggle' => "#$area_name-social-icons, .$area_name-live_social",
			));

	?>

	<div id="<?php echo esc_attr( $area_name ) ?>-social-icons">

		<?php

			tie_build_theme_option(
				array(
					'name'   => esc_html__( 'Social icons layout', TIELABS_TEXTDOMAIN ),
					'id'     => $area_name.'_social_layout',
					'type'   => 'radio',
					'toggle' => array(
						'default' => ".header-$area_name-follow1",
						'list'    => ".header-$area_name-follow",
						'grid'    => ".header-$area_name-follow",),
					'options' => array(
						'default' => esc_html__( 'Default', TIELABS_TEXTDOMAIN ) ,
						'list'    => esc_html__( 'Menu with names', TIELABS_TEXTDOMAIN ),
						'grid'    => esc_html__( 'Grid Menu', TIELABS_TEXTDOMAIN ),
				)));

			?>

		</div>
	<?php

		tie_build_theme_option(
			array(
				'name'   => esc_html__( 'Weather', TIELABS_TEXTDOMAIN ),
				'id'		 => $area_name.'_weather',
				'type'   => "checkbox",
				'toggle' => ".header-$area_name-weather, #$area_name-weather",
			));

	?>

	<div id="<?php echo esc_attr( $area_name ) ?>-weather">

		<?php

			if( ! tie_get_option( 'api_openweather' ) ){

				tie_build_theme_option(
					array(
						'text'   => esc_html__( 'You need to set the Weather API Key in the theme options page > Integrations.', TIELABS_TEXTDOMAIN ),
						'type'   => 'error',
					));
			}

			tie_build_theme_option(
				array(
					'name'  => esc_html__( 'Location', TIELABS_TEXTDOMAIN ),
					'hint'  => esc_html__( '(i.e: London,UK or New York City)', TIELABS_TEXTDOMAIN ),
					'id'    => $area_name.'_wz_location',
					'class' => 'header-weather',
					'type'  => 'text',
				));

			tie_build_theme_option(
				array(
					'name'  => esc_html__( 'Custom City Name', TIELABS_TEXTDOMAIN ),
					'id'    => $area_name.'_wz_city_name',
					'class' => 'header-weather',
					'type'  => 'text',
				));

			tie_build_theme_option(
				array(
					'name'  => esc_html__( 'Units', TIELABS_TEXTDOMAIN ),
					'id'    => $area_name.'_wz_unit',
					'class' => 'header-weather',
					'type'  => 'select',
					'options' => array(
						'F' => 'F',
						'C' => 'C',
					)
				));

			tie_build_theme_option(
				array(
					'name'  => esc_html__( 'Animated Icons?', TIELABS_TEXTDOMAIN ),
					'id'    => $area_name.'_wz_animated',
					'class' => 'header-weather',
					'type'  => 'checkbox',
				));

			?>

		</div>

	</div>
<?php
}


echo '</div>'; // Settings locked
