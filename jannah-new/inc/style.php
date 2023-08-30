<?php
/**
 * Theme Custom Styles
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


/*
 * Styles
 */
if( ! function_exists( 'jannah_get_custom_styling' ) ) {

	add_filter( 'TieLabs/CSS/after_theme_color', 'jannah_get_custom_styling' );
	function jannah_get_custom_styling( $out = '' ){

		// Theme Blocks style
		$block_style = tie_get_option( 'blocks_style', 1 );


		// Slider Background Position
		if( $background_position = tie_get_option( 'background_position' ) ) {
			$out .="
				.main-slider .slide-bg,
				.main-slider .slide{
					background-position: $background_position;
				}
			";
		}

		// Highlighted Color
		if( $color = tie_get_option( 'highlighted_color' ) ) {

			$bright = TIELABS_STYLES::light_or_dark( $color );

			$out .="
				::-moz-selection{
					background-color: $color;
					color: $bright;
				}

				::selection{
					background-color: $color;
					color: $bright;
				}
			";
		}

		// Links Color
		if( $color = tie_get_option( 'links_color' ) ) {
			$out .="
				a,
				body .entry a,
				.dark-skin body .entry a,
				.comment-list .comment-content a{
					color: $color;
				}
			";
		}

		// Links Color Hover
		if( $color = tie_get_option( 'links_color_hover' ) ) {
			$out .="
				a:hover,
				body .entry a:hover,
				.dark-skin body .entry a:hover,
				.comment-list .comment-content a:hover{
					color: $color;
				}
			";
		}

		// Links hover underline
		if( tie_get_option( 'underline_links_hover' ) ) {
			$out .="
				#content a:hover{
					text-decoration: underline !important;
				}
			";
		}


		// Theme Main Borders
		if( $color = tie_get_option( 'borders_color' ) ) {

			$out .="
				.container-wrapper,
				.the-global-title,
				.comment-reply-title,
				.tabs,
				.flex-tabs .flexMenu-popup,
				.magazine1 .tabs-vertical .tabs li a,
				.magazine1 .tabs-vertical:after,
				.mag-box .show-more-button,
				.white-bg .social-icons-item a,
				textarea, input, select,
				.toggle,
				.post-content-slideshow,
				.post-content-slideshow .slider-nav-wrapper,
				.share-buttons-bottom,
				.pages-numbers a,
				.pages-nav-item,
				.first-last-pages .pagination-icon,
				.multiple-post-pages .post-page-numbers,
				#story-highlights li,
				.review-item, .review-summary, .user-rate-wrap,
				.review-final-score,
				.tabs a{
					border-color: $color !important;
				}

				.magazine1 .tabs a{
					border-bottom-color: transparent !important;
				}

				.fullwidth-area .tagcloud a:not(:hover){
					background: transparent;
					box-shadow: inset 0 0 0 3px $color;
				}

				.subscribe-widget-content h4:after,
				.white-bg .social-icons-item:before{
					background-color: $color !important;
				}
			";

			if ( TIELABS_WOOCOMMERCE_IS_ACTIVE ){
				$out .="
					.related.products > h2,
					.up-sells > h2,
					.cross-sells > h2,
					.cart_totals > h2,
					.comment-text,
					.related.products,
					.up-sells,
					.cart_totals,
					.cross-sells,
					.woocommerce-product-details__short-description,
					.shop_table,
					form.cart,
					.checkout_coupon{
						border-color: $color !important;
					}
				";
			}

			if ( TIELABS_BUDDYPRESS_IS_ACTIVE ){
				$out .="
					.item-options a,
					.ac-textarea,
					.buddypress-header-outer,
					#groups-list > li,
					#member-list > li,
					#members-list > li,
					.generic-button a,
					#profile-edit-form .editfield,
					ul.button-nav,
					ul.button-nav li a{
						border-color: $color !important;
					}
				";
			}

			if ( TIELABS_BBPRESS_IS_ACTIVE ){
				$out .="
					.bbp-form legend,
					ul.topic,
					.bbp-header,
					.bbp-footer,
					.bbp-body .hentry,
					#wp-bbp_reply_content-editor-container{
						border-color: $color !important;
					}
				";
			}
		}



		// Secondry nav Background
		if( $color = tie_get_option( 'secondry_nav_background' ) ) {
			$dark   = TIELABS_STYLES::color_brightness( $color, -30 );
			$darker = TIELABS_STYLES::color_brightness( $color, -50 );
			$bright = TIELABS_STYLES::light_or_dark( $color, true );

			$out .="
				#top-nav,
				#top-nav .sub-menu,
				#top-nav .comp-sub-menu,
				#top-nav .ticker-content,
				#top-nav .ticker-swipe,
				.top-nav-boxed #top-nav .topbar-wrapper,
				.search-in-top-nav.autocomplete-suggestions,
				#top-nav .guest-btn:not(:hover){
					background-color : $color;
				}

				#top-nav *,
				.search-in-top-nav.autocomplete-suggestions{
					border-color: rgba( $bright, 0.08);
				}

				#top-nav .icon-basecloud-bg:after{
					color: $color;
				}
			";
		}

		// Secondry nav links
		if( $color = tie_get_option( 'topbar_links_color' ) ) {

			$out .="
				#top-nav a:not(:hover),
				#top-nav input,
				#top-nav #search-submit,
				#top-nav .fa-spinner,
				#top-nav .dropdown-social-icons li a span,
				#top-nav .components > li .social-link:not(:hover) span,
				.search-in-top-nav.autocomplete-suggestions a{
					color: $color;
				}

				#top-nav .menu-item-has-children > a:before{
					border-top-color: $color;
				}

				#top-nav li .menu-item-has-children > a:before{
					border-top-color: transparent;
					border-left-color: $color;
				}

				.rtl #top-nav .menu li .menu-item-has-children > a:before{
					border-left-color: transparent;
					border-right-color: $color;
				}

				#top-nav input::-moz-placeholder{
					color: $color;
				}

				#top-nav input:-moz-placeholder{
					color: $color;
				}

				#top-nav input:-ms-input-placeholder{
					color: $color;
				}

				#top-nav input::-webkit-input-placeholder{
					color: $color;
				}
			";
		}

		// Secondry nav links on hover
		if( $color = tie_get_option( 'topbar_links_color_hover' ) ) {

			$darker = TIELABS_STYLES::color_brightness( $color, -30 );
			$bright = TIELABS_STYLES::light_or_dark( $color );

			$out .="
				#top-nav .comp-sub-menu .button:hover,
				#top-nav .checkout-button,
				.search-in-top-nav.autocomplete-suggestions .button{
					background-color: $color;
				}

				#top-nav a:hover,
				#top-nav .menu li:hover > a,
				#top-nav .menu > .tie-current-menu > a,
				#top-nav .components > li:hover > a,
				#top-nav .components #search-submit:hover,
				.search-in-top-nav.autocomplete-suggestions .post-title a:hover{
					color: $color;
				}

				#top-nav .comp-sub-menu .button:hover{
					border-color: $color;
				}

				#top-nav .tie-current-menu > a:before,
				#top-nav .menu .menu-item-has-children:hover > a:before{
					border-top-color: $color;
				}

				#top-nav .menu li .menu-item-has-children:hover > a:before{
					border-top-color: transparent;
					border-left-color: $color;
				}

				.rtl #top-nav .menu li .menu-item-has-children:hover > a:before{
					border-left-color: transparent;
					border-right-color: $color;
				}

				#top-nav .comp-sub-menu .button:hover,
				#top-nav .comp-sub-menu .checkout-button,
				.search-in-top-nav.autocomplete-suggestions .button{
					color: $bright;
				}

				#top-nav .comp-sub-menu .checkout-button:hover,
				.search-in-top-nav.autocomplete-suggestions .button:hover{
					background-color: $darker;
				}
			";
		}

		// Top-bar text
		if( $color = tie_get_option( 'topbar_text_color' ) ) {

			$rgb = TIELABS_STYLES::rgb_color( $color );

			$out .="
				#top-nav,
				#top-nav .comp-sub-menu,
				#top-nav .tie-weather-widget{
					color: $color;
				}

				.search-in-top-nav.autocomplete-suggestions .post-meta,
				.search-in-top-nav.autocomplete-suggestions .post-meta a:not(:hover){
					color: rgba( $rgb, 0.7 );
				}


				#top-nav .weather-icon .icon-cloud,
				#top-nav .weather-icon .icon-basecloud-bg,
				#top-nav .weather-icon .icon-cloud-behind{
					color: $color !important;
				}
			";
		}

		// Breaking News label
		if( $color = tie_get_option( 'breaking_title_bg' ) ) {

			$bright = TIELABS_STYLES::light_or_dark( $color );

			$out .="
				#top-nav .breaking-title{
					color: $bright;
				}

				#top-nav .breaking-title:before{
					background-color: $color;
				}

				#top-nav .breaking-news-nav li:hover{
					background-color: $color;
					border-color: $color;
				}
			";
		}


		// Main nav Background
		if( $color = tie_get_option( 'main_nav_background' ) ) {

			$main_nav_selector = tie_get_option( 'main_nav_layout' ) ? '#main-nav .main-menu-wrapper' : '#main-nav';

			if( tie_get_option( 'header_layout' ) == 1 || tie_get_option( 'header_layout' ) == 4 ){
				$main_nav_selector = '#main-nav';
			}

			$bright = TIELABS_STYLES::light_or_dark( $color, true );
			$darker = TIELABS_STYLES::color_brightness( $color, -30 );

			// Main nav Gradiant
			if( $color_2 = tie_get_option( 'main_nav_background_2' ) ) {

				$out .= "
					.main-nav-boxed .main-nav.fixed-nav,
					$main_nav_selector{
						". TIELABS_STYLES::gradiant( $color, $color_2, 90 ) ."
					}

					$main_nav_selector .icon-basecloud-bg:after{
						color: inherit !important;
					}
				";

				$color = TIELABS_STYLES::average_color( $color, $color_2 ); // The avaerga color
			}

			$out .="
				$main_nav_selector,
				#main-nav .menu-sub-content,
				#main-nav .comp-sub-menu,
				#main-nav .guest-btn:not(:hover),
				#main-nav ul.cats-vertical li a.is-active,
				#main-nav ul.cats-vertical li a:hover
				.search-in-main-nav.autocomplete-suggestions{
					background-color: $color;
				}

				#main-nav{
					border-width: 0;
				}

				#theme-header #main-nav:not(.fixed-nav){
					bottom: 0;
				}

				#main-nav .icon-basecloud-bg:after{
					color: $color;
				}

				#main-nav *,
				.search-in-main-nav.autocomplete-suggestions{
					border-color: rgba($bright, 0.07);
				}

				.main-nav-boxed #main-nav .main-menu-wrapper{
					border-width: 0;
				}
			";
		}


		// Main nav links
		if( $color = tie_get_option( 'main_nav_links_color' ) ) {

			$out .= "
				#main-nav .menu li.menu-item-has-children > a:before,
				#main-nav .main-menu .mega-menu > a:before{
					border-top-color: $color;
				}

				#main-nav .menu li .menu-item-has-children > a:before,
				#main-nav .mega-menu .menu-item-has-children > a:before{
					border-top-color: transparent;
					border-left-color: $color;
				}

				.rtl #main-nav .menu li .menu-item-has-children > a:before,
				.rtl #main-nav .mega-menu .menu-item-has-children > a:before{
					border-left-color: transparent;
					border-right-color: $color;
				}

				#main-nav a:not(:hover),
				#main-nav a.social-link:not(:hover) span,
				#main-nav .dropdown-social-icons li a span,
				.search-in-main-nav.autocomplete-suggestions a{
					color: $color;
				}
			";
		}

		// Main nav Borders
		if( tie_get_option( 'main_nav_border_top_color' ) || tie_get_option( 'main_nav_border_top_width' ) ||
				tie_get_option( 'main_nav_border_bottom_color' ) || tie_get_option( 'main_nav_border_bottom_width' ) ){

			// Top
			$border_top_color = tie_get_option( 'main_nav_border_top_color' ) ? 'border-top-color:'. tie_get_option( 'main_nav_border_top_color' ) .' !important;'   : '';
			$border_top_width = tie_get_option( 'main_nav_border_top_width' ) ? 'border-top-width:'. tie_get_option( 'main_nav_border_top_width' ) .'px !important;' : '';

			// Bottom
			$border_bottom_color = tie_get_option( 'main_nav_border_bottom_color' ) ? 'border-bottom-color:'. tie_get_option( 'main_nav_border_bottom_color' ) .' !important;'   : '';
			$border_bottom_width = tie_get_option( 'main_nav_border_bottom_width' ) ? 'border-bottom-width:'. tie_get_option( 'main_nav_border_bottom_width' ) .'px !important;' : '';

			$out .= "
				#theme-header:not(.main-nav-boxed) #main-nav,
				.main-nav-boxed .main-menu-wrapper{
					$border_top_color
					$border_top_width
					$border_bottom_color
					$border_bottom_width
					border-right: 0 none;
					border-left : 0 none;
				}
			";

			if( tie_get_option( 'main_nav_border_bottom_color' ) || tie_get_option( 'main_nav_border_bottom_width' ) ) {
				$out .= "
					.main-nav-boxed #main-nav.fixed-nav{
						box-shadow: none;
					}
				";
			}
		}

		// Main nav links on hover
		if( $color = tie_get_option( 'main_nav_links_color_hover' ) ) {

			$darker = TIELABS_STYLES::color_brightness( $color, -30 );
			$bright = TIELABS_STYLES::light_or_dark( $color );

			$out .= "
				#main-nav .comp-sub-menu .button:hover,
				#main-nav .menu > li.tie-current-menu,
				#main-nav .menu > li > .menu-sub-content,
				#main-nav .cats-horizontal a.is-active,
				#main-nav .cats-horizontal a:hover{
					border-color: $color;
				}

				#main-nav .menu > li.tie-current-menu > a,
				#main-nav .menu > li:hover > a,
				#main-nav .mega-links-head:after,
				#main-nav .comp-sub-menu .button:hover,
				#main-nav .comp-sub-menu .checkout-button,
				#main-nav .cats-horizontal a.is-active,
				#main-nav .cats-horizontal a:hover,
				.search-in-main-nav.autocomplete-suggestions .button,
				#main-nav .spinner > div{
					background-color: $color;
				}


				#main-nav .menu ul li:hover > a,
				#main-nav .menu ul li.current-menu-item:not(.mega-link-column) > a,
				#main-nav .components a:hover,
				#main-nav .components > li:hover > a,
				#main-nav #search-submit:hover,
				#main-nav .cats-vertical a.is-active,
				#main-nav .cats-vertical a:hover,
				#main-nav .mega-menu .post-meta a:hover,
				#main-nav .mega-menu .post-box-title a:hover,
				.search-in-main-nav.autocomplete-suggestions a:hover,
				#main-nav .spinner-circle:after{
					color: $color;
				}

				#main-nav .menu > li.tie-current-menu > a,
				#main-nav .menu > li:hover > a,
				#main-nav .components .button:hover,
				#main-nav .comp-sub-menu .checkout-button,
				.theme-header #main-nav .mega-menu .cats-horizontal a.is-active,
				.theme-header #main-nav .mega-menu .cats-horizontal a:hover,
				.search-in-main-nav.autocomplete-suggestions a.button{
					color: $bright;
				}

				#main-nav .menu > li.tie-current-menu > a:before,
				#main-nav .menu > li:hover > a:before{
					border-top-color: $bright;
				}

				.main-nav-light #main-nav .menu-item-has-children li:hover > a:before,
				.main-nav-light #main-nav .mega-menu li:hover > a:before{
					border-left-color: $color;
				}

				.rtl .main-nav-light #main-nav .menu-item-has-children li:hover > a:before,
				.rtl .main-nav-light #main-nav .mega-menu li:hover > a:before{
					border-right-color: $color;
					border-left-color: transparent;
				}

				.search-in-main-nav.autocomplete-suggestions .button:hover,
				#main-nav .comp-sub-menu .checkout-button:hover{
					background-color: $darker;
				}
			";
		}

		// Main Nav text
		if( $color = tie_get_option( 'main_nav_text_color' ) ) {

			$rgb = TIELABS_STYLES::rgb_color( $color );

			$out .="
				#main-nav,
				#main-nav input,
				#main-nav #search-submit,
				#main-nav .fa-spinner,
				#main-nav .comp-sub-menu,
				#main-nav .tie-weather-widget{
					color: $color;
				}

				#main-nav input::-moz-placeholder{
					color: $color;
				}

				#main-nav input:-moz-placeholder{
					color: $color;
				}

				#main-nav input:-ms-input-placeholder{
					color: $color;
				}

				#main-nav input::-webkit-input-placeholder{
					color: $color;
				}

				#main-nav .mega-menu .post-meta,
				#main-nav .mega-menu .post-meta a,
				.search-in-main-nav.autocomplete-suggestions .post-meta{
					color: rgba($rgb, 0.6);
				}

				#main-nav .weather-icon .icon-cloud,
				#main-nav .weather-icon .icon-basecloud-bg,
				#main-nav .weather-icon .icon-cloud-behind{
					color: $color !important;
				}
			";
		}




		// In Post links
		if( tie_get_option( 'post_links_color' ) ) {
			$out .='
			#the-post .entry-content a:not(.shortc-button){
				color: '. tie_get_option( 'post_links_color' ) .' !important;
			}';
		}

		if( tie_get_option( 'post_links_color_hover' ) ) {
			$out .='
			#the-post .entry-content a:not(.shortc-button):hover{
				color: '. tie_get_option( 'post_links_color_hover' ) .' !important;
			}';
		}


		// Widget head color
		if( $color = tie_get_option( 'widgets_head_main_color' ) ) {

			switch ( $block_style ) {

				case 1:
					$out .="
						#tie-body .sidebar .widget-title:after{
							background-color: $color;
						}
						#tie-body .sidebar .widget-title:before{
							border-top-color: $color;
						}";
					break;

				case 3:
				case 10:
					$out .="
						#tie-body .sidebar .widget-title:after{
							background-color: $color;
						}";
					break;

				case 2:
					$out .="
						#tie-body .sidebar .widget-title{
							border-color: $color;
							color: $color;
						}";
					break;

				case 4:
				case 5:
				case 8:
					$out .="
						#tie-body .sidebar .widget-title:before{
							background-color: $color;
						}";
					break;

				case 6:
					$out .="
						#tie-body .sidebar .widget-title:before,
						#tie-body .sidebar .widget-title:after{
							background-color: $color;
						}";
					break;

				case 7:
					$out .="
						#tie-body .sidebar .widget-title{
							background-color: $color;
						}";
					break;

				case 11:
					$direction = is_rtl() ? 'right' : 'left';

					$out .="
						#tie-body .sidebar .widget-title:after{
							border-$direction-color: $color;
						}";
					break;
			}
		}


		// Backgrounds
		$backround_areas = array(
			'header_background'    => '#tie-wrapper #theme-header',
			'main_content_bg'      => '#tie-container #tie-wrapper, .post-layout-8 #content', // in post-layout-8 tie-wrapper will be transparent so, the #content area,
			'footer_background'    => '#footer',
			'copyright_background' => '#site-info',
			'banner_bg'            => '#background-ad-cover',
			'mobile_header_bg'     => '',
		);

		foreach ( $backround_areas as $area => $elements ){

			if( tie_get_option( $area . '_color' ) || tie_get_option( $area . '_img' ) ){

				$background_color = tie_get_option( $area . '_color' ) ? 'background-color: '. tie_get_option( $area . '_color' ) .';' : '';
				$background_image = tie_get_option( $area . '_img' );

				# Background Image
				$background_image = TIELABS_STYLES::bg_image_css( $background_image );

				if( ! empty( $background_color ) || ! empty( $background_image ) ){

					if( $area == 'mobile_header_bg'  ){

						$out .='
							@media (max-width: 991px) {
								#tie-wrapper #theme-header,
								#tie-wrapper #theme-header #main-nav .main-menu-wrapper,
								#tie-wrapper #theme-header .logo-container{
									background: transparent;
								}';

						// Gradiant
						if( tie_get_option( 'mobile_header_bg_color_2' ) && empty( $background_image ) ) {
							$out .= "
								#tie-wrapper #theme-header .logo-container,
								#tie-wrapper #theme-header #main-nav {
									". TIELABS_STYLES::gradiant( tie_get_option( 'mobile_header_bg_color' ), tie_get_option( 'mobile_header_bg_color_2' ), 90 ) ."
								}
								#mobile-header-components-area_1 .components .comp-sub-menu{
									background-color: ". tie_get_option( 'mobile_header_bg_color' ) .";
								}
								#mobile-header-components-area_2 .components .comp-sub-menu{
									background-color: ". tie_get_option( 'mobile_header_bg_color_2' ) .";
								}
							";
						}
						else{
							$out .='
								#tie-wrapper #theme-header .logo-container,
								#tie-wrapper #theme-header .logo-container.fixed-nav,
								#tie-wrapper #theme-header #main-nav {
									'. $background_color .'
									'. $background_image .'
								}

								.mobile-header-components .components .comp-sub-menu{
									'. $background_color .'
								}
							';
						}

						$out .='}';

					}
					else{

						$out .=
							$elements .'{
								'. $background_color .'
								'. $background_image .'
							}
						';

						# Header Related Colors
						if( $area == 'header_background' ){

							// Text Site Title color
							if( tie_get_option( $area . '_color' ) ){

								$out .='
									#logo.text-logo a,
									#logo.text-logo a:hover{
										color: '. TIELABS_STYLES::light_or_dark( tie_get_option( $area . '_color' ) ) .';
									}

									@media (max-width: 991px){
										#tie-wrapper #theme-header .logo-container.fixed-nav{
											background-color: rgba('. TIELABS_STYLES::rgb_color(tie_get_option( $area . '_color' )) .', 0.95);
										}
									}
								';
							}

							// Gradiant
							if( tie_get_option( 'header_background_color_2' ) && empty( $background_image ) ) {
								$out .= "
									$elements{
										". TIELABS_STYLES::gradiant( tie_get_option( 'header_background_color' ), tie_get_option( 'header_background_color_2' ), 90 ) ."
									}
								";
							}

							$out .='
								@media (max-width: 991px){
									#tie-wrapper #theme-header .logo-container{
									'. $background_color .'
									'. $background_image .'
									}
								}
							';
						} // Header Custom Colors

					} // else

				}

			}
		}





		// Footer area
		if( tie_get_option( 'footer_margin_top' ) || tie_get_option( 'footer_padding_bottom' ) ){

			$footer_margin_top     = tie_get_option( 'footer_margin_top' ) ?     'margin-top: '.     tie_get_option( 'footer_margin_top' )     .'px;' : '';
			$footer_padding_bottom = tie_get_option( 'footer_padding_bottom' ) ? 'padding-bottom: '. tie_get_option( 'footer_padding_bottom' ) .'px;' : ''; // Asking why? check the School Demo :)

			$out .="
				#footer{
					$footer_margin_top
					$footer_padding_bottom
				}
			";
		}

		if( tie_get_option( 'footer_padding_top' )  ){
			$out .='
				#footer .footer-widget-area:first-child{
					padding-top: '. tie_get_option( 'footer_padding_top' ) .'px;
				}
			';
		}

		if( $color = tie_get_option( 'footer_background_color' ) ) {
			$rgb    = TIELABS_STYLES::rgb_color( $color );
			$darker = TIELABS_STYLES::color_brightness( $color, -30 );
			$bright = TIELABS_STYLES::light_or_dark( $color, true );

			$out .="
				#footer .posts-list-counter .posts-list-items li.widget-post-list:before{
					border-color: $color;
				}

				#footer .timeline-widget a .date:before{
					border-color: rgba($rgb, 0.8);
				}

				#footer .footer-boxed-widget-area,
				#footer textarea,
				#footer input:not([type=submit]),
				#footer select,
				#footer code,
				#footer kbd,
				#footer pre,
				#footer samp,
				#footer .show-more-button,
				#footer .slider-links .tie-slider-nav span,
				#footer #wp-calendar,
				#footer #wp-calendar tbody td,
				#footer #wp-calendar thead th,
				#footer .widget.buddypress .item-options a{
					border-color: rgba($bright, 0.1);
				}

				#footer .social-statistics-widget .white-bg li.social-icons-item a,
				#footer .widget_tag_cloud .tagcloud a,
				#footer .latest-tweets-widget .slider-links .tie-slider-nav span,
				#footer .widget_layered_nav_filters a{
						border-color: rgba($bright, 0.1);
				}

				#footer .social-statistics-widget .white-bg li:before{
					background: rgba($bright, 0.1);
				}

				.site-footer #wp-calendar tbody td{
					background: rgba($bright, 0.02);
				}

				#footer .white-bg .social-icons-item a span.followers span,
				#footer .circle-three-cols .social-icons-item a .followers-num,
				#footer .circle-three-cols .social-icons-item a .followers-name{
					color: rgba($bright, 0.8);
				}

				#footer .timeline-widget ul:before,
				#footer .timeline-widget a:not(:hover) .date:before{
					background-color: $darker;
				}
			";
		}

		if( $color = tie_get_option( 'footer_widgets_head_color' ) ) {

			switch ( $block_style ) {

				case 1:
				case 2:
				case 3:
				case 10:
					$out .="
						#tie-body #footer .widget-title::after{
							background-color: $color;
						}";
					break;

				case 4:
				case 5:
				case 8:
					$out .="
						#tie-body #footer .widget-title::before{
							background-color: $color;
						}";
					break;

				case 6:
					$out .="
						#tie-body #footer .widget-title::before,
						#tie-body #footer .widget-title::after{
							background-color: $color;
						}";
					break;

				case 7:
					$out .="
						#tie-body #footer .widget-title{
							background-color: $color;
						}";
					break;

				case 11:
					$direction = is_rtl() ? 'right' : 'left';

					$out .="
						#tie-body #footer .widget-title:after{
							border-$direction-color: $color;
						}";
					break;
			}
		}

		if( tie_get_option( 'footer_title_color' ) ) {
			$out .='
				#footer .widget-title,
				#footer .widget-title a:not(:hover){
					color: '. tie_get_option( 'footer_title_color' ) .';
				}
			';
		}

		if( $color = tie_get_option( 'footer_text_color' ) ) {
			$rgb = TIELABS_STYLES::rgb_color( $color );

			$out .="
				#footer,
				#footer textarea,
				#footer input:not([type='submit']),
				#footer select,
				#footer #wp-calendar tbody,
				#footer .tie-slider-nav li span:not(:hover),

				#footer .widget_categories li a:before,
				#footer .widget_product_categories li a:before,
				#footer .widget_layered_nav li a:before,
				#footer .widget_archive li a:before,
				#footer .widget_nav_menu li a:before,
				#footer .widget_meta li a:before,
				#footer .widget_pages li a:before,
				#footer .widget_recent_entries li a:before,
				#footer .widget_display_forums li a:before,
				#footer .widget_display_views li a:before,
				#footer .widget_rss li a:before,
				#footer .widget_display_stats dt:before,

				#footer .subscribe-widget-content h3,
				#footer .about-author .social-icons a:not(:hover) span{
					color: $color;
				}

				#footer post-widget-body .meta-item,
				#footer .post-meta,
				#footer .stream-title,
				#footer.dark-skin .timeline-widget .date,
				#footer .wp-caption .wp-caption-text,
				#footer .rss-date{
					color: rgba($rgb, 0.7);
				}

				#footer input::-moz-placeholder{
					color: $color;
				}

				#footer input:-moz-placeholder{
					color: $color;
				}

				#footer input:-ms-input-placeholder{
					color: $color;
				}

				#footer input::-webkit-input-placeholder{
					color: $color;
				}
			";
		}

		if( tie_get_option( 'footer_links_color' ) ) {
			$out .='
				.site-footer.dark-skin a:not(:hover){
					color: '. tie_get_option( 'footer_links_color' ) .';
				}
			';
		}

		if( $color = tie_get_option( 'footer_links_color_hover' ) ) {

			$darker = TIELABS_STYLES::color_brightness( $color, -30 );
			$bright = TIELABS_STYLES::light_or_dark( $color );

			$out .="
				.site-footer.dark-skin a:hover,
				#footer .stars-rating-active,
				#footer .twitter-icon-wrap span,
				.block-head-4.magazine2 #footer .tabs li a{
					color: $color;
				}

				#footer .circle_bar{
					stroke: $color;
				}

				#footer .widget.buddypress .item-options a.selected,
				#footer .widget.buddypress .item-options a.loading,
				#footer .tie-slider-nav span:hover,
				.block-head-4.magazine2 #footer .tabs{
					border-color: $color;
				}

				.magazine2:not(.block-head-4) #footer .tabs a:hover,
				.magazine2:not(.block-head-4) #footer .tabs .active a,
				.magazine1 #footer .tabs a:hover,
				.magazine1 #footer .tabs .active a,
				.block-head-4.magazine2 #footer .tabs.tabs .active a,
				.block-head-4.magazine2 #footer .tabs > .active a:before,
				.block-head-4.magazine2 #footer .tabs > li.active:nth-child(n) a:after,

				#footer .digital-rating-static,
				#footer .timeline-widget li a:hover .date:before,
				#footer #wp-calendar #today,
				#footer .posts-list-counter .posts-list-items li.widget-post-list:before,
				#footer .cat-counter span,
				#footer.dark-skin .the-global-title:after,
				#footer .button,
				#footer [type='submit'],
				#footer .spinner > div,

				#footer .widget.buddypress .item-options a.selected,
				#footer .widget.buddypress .item-options a.loading,
				#footer .tie-slider-nav span:hover,
				#footer .fullwidth-area .tagcloud a:hover{
					background-color: $color;
					color: $bright;
				}

				.block-head-4.magazine2 #footer .tabs li a:hover{
					color: $darker;
				}

				.block-head-4.magazine2 #footer .tabs.tabs .active a:hover,
				#footer .widget.buddypress .item-options a.selected,
				#footer .widget.buddypress .item-options a.loading,
				#footer .tie-slider-nav span:hover{
					color: $bright !important;
				}

				#footer .button:hover,
				#footer [type='submit']:hover{
					background-color: $darker;
					color: $bright;
				}
			";
		}


		// Copyright area
		if( tie_get_option( 'copyright_text_color' ) ) {
			$out .='
			#site-info,
			#site-info ul.social-icons li a:not(:hover) span{
				color: '. tie_get_option( 'copyright_text_color' ) .';
			}';
		}

		if( tie_get_option( 'copyright_links_color' ) ) {
			$out .='
			#footer .site-info a:not(:hover){
				color: '. tie_get_option( 'copyright_links_color' ) .';
			}';
		}

		if( tie_get_option( 'copyright_links_color_hover' ) ) {
			$out .='
			#footer .site-info a:hover{
				color: '. tie_get_option( 'copyright_links_color_hover' ) .';
			}
			';
		}


		// Go to Top Button
		if( tie_get_option( 'back_top_background_color' ) ) {
			$out .='
				a#go-to-top{
					background-color: '. tie_get_option( 'back_top_background_color' ) .';
				}';
		}

		if( tie_get_option( 'back_top_text_color' ) ) {
			$out .='
				a#go-to-top{
					color: '. tie_get_option( 'back_top_text_color' ) .';
				}';
		}


		// AdBlock Popup
		if( $color = tie_get_option( 'adblock_background' ) ) {

			$bright = TIELABS_STYLES::light_or_dark( $color );

			$out .='
				#tie-popup-adblock .container-wrapper{
					background-color: '. tie_get_option( 'adblock_background' ) .' !important;
					color: '. $bright .';
				}';
		}


		// Custom Social Networks colors
		for( $i=1 ; $i<=5 ; $i++ ){
			if ( tie_get_option( "custom_social_title_$i" ) && ( tie_get_option( "custom_social_icon_img_$i" ) || tie_get_option( "custom_social_icon_$i" ) ) && tie_get_option( "custom_social_url_$i" ) ) {

				$color = tie_get_option( "custom_social_color_$i", '#333' );

				$out .="
					.social-icons-item .custom-link-$i-social-icon{
						background-color: $color !important;
					}

					.social-icons-item .custom-link-$i-social-icon span{
						color: $color;
					}
				";

				if( tie_get_option( "custom_social_icon_img_$i" ) ){
					$out .="
						.social-icons-item .custom-link-$i-social-icon.custom-social-img span.social-icon-img{
							background-image: url('". tie_get_option( "custom_social_icon_img_$i" ) ."');
						}
					";
				}
			}
		}


		// Colored Categories labels
		$cats_options = get_option( 'tie_cats_options' );

		if( ! empty( $cats_options ) && is_array( $cats_options ) ) {
			foreach ( $cats_options as $cat => $options){
				if( ! empty( $options['cat_color'] ) ) {

					$cat_custom_color = $options['cat_color'];
					$bright_color = TIELABS_STYLES::light_or_dark( $cat_custom_color);

					$out .='
						.tie-cat-'.$cat.', .tie-cat-item-'.$cat.' > span{
							background-color:'. $cat_custom_color .' !important;
							color:'. $bright_color .' !important;
						}

						.tie-cat-'.$cat.':after{
							border-top-color:'. $cat_custom_color .' !important;
						}
						.tie-cat-'.$cat.':hover{
							background-color:'. TIELABS_STYLES::color_brightness( $cat_custom_color ) .' !important;
						}

						.tie-cat-'.$cat.':hover:after{
							border-top-color:'. TIELABS_STYLES::color_brightness( $cat_custom_color ) .' !important;
						}
					';
				}
			}
		}


		// Arqam Plugin Custom colors
		if( TIELABS_ARQAM_IS_ACTIVE ){
			$arqam_options = get_option( 'arq_options' );
			if( ! empty( $arqam_options['color'] ) && is_array( $arqam_options['color'] ) ) {
				foreach ( $arqam_options['color'] as $social => $color ){
					if( ! empty( $color ) ) {
						if( $social == '500px' ){
							$social = 'px500';
						}
						$out .= "
							.social-statistics-widget .solid-social-icons .social-icons-item .$social-social-icon{
								background-color: $color !important;
								border-color: $color !important;
							}
							.social-statistics-widget .$social-social-icon span.counter-icon{
								background-color: $color !important;
							}
						";
					}
				}
			}
		}


		// Take Over Ad top margin
		if( tie_get_option( 'banner_bg' ) && tie_get_option( 'banner_bg_url' ) && tie_get_option( 'banner_bg_site_margin' ) && ! tie_is_auto_loaded_post() ){
			$out .= '
				@media (min-width: 992px){
					#tie-wrapper{
						margin-top: '. tie_get_option( 'banner_bg_site_margin' ) .'px !important;
					}
				}
			';
		}


		// Site Width
		if( tie_get_option( 'site_width' ) && tie_get_option( 'site_width' ) != '1200px' ){
			$out .= '
				@media (min-width: 1200px){
				.container{
						width: auto;
					}
				}
			';

			if( strpos( tie_get_option( 'site_width' ), '%' ) !== false ){
				$out .= '
					@media (min-width: 992px){
						.container,
						.boxed-layout #tie-wrapper,
						.boxed-layout .fixed-nav,
						.wide-next-prev-slider-wrapper .slider-main-container{
							max-width: '.tie_get_option( 'site_width' ).';
						}
						.boxed-layout .container{
							max-width: 100%;
						}
					}
				';
			}
			else{
				$outer_width = str_replace( 'px', '', tie_get_option( 'site_width' ) ) + 30;
				$out .= '
					.boxed-layout #tie-wrapper,
					.boxed-layout .fixed-nav{
						max-width: '.  $outer_width .'px;
					}
					@media (min-width: '.tie_get_option( 'site_width' ).'){
						.container,
						.wide-next-prev-slider-wrapper .slider-main-container{
							max-width: '.tie_get_option( 'site_width' ).';
						}
					}
				';
			}
		}

		// Sidebar Width
		if( tie_get_option( 'sidebar_width' ) ){

			$sidebar_width = (int) tie_get_option( 'sidebar_width' );
			$out .= '
				@media (min-width: 992px){
					.sidebar{
						width: '. $sidebar_width .'%;
					}
					.main-content{
						width: '. ( 100 - $sidebar_width ) .'%;
					}
				}
			';
		}

		// Sticky Share break point
		if( tie_get_option( 'share_post_sticky' ) ){
			$sticky_break_point = tie_get_option( 'share_breakpoint_sticky', '1250' );
			$out .='
				@media (max-width: '. $sticky_break_point .'px){
					.share-buttons-sticky{
						display: none;
					}
				}
			';
		}

		// Mobile Menu Background
		if( tie_get_option( 'mobile_header_components_menu' ) ){

			if( tie_get_option( 'mobile_menu_background_type' ) == 'color' ){
				if( tie_get_option( 'mobile_menu_background_color' ) ){
					$mobile_bg = 'background-color: '. tie_get_option( 'mobile_menu_background_color' ) .';';
					$out .='
						@media (max-width: 991px){
							.side-aside #mobile-menu .menu > li{
								border-color: rgba('.TIELABS_STYLES::light_or_dark( tie_get_option( 'mobile_menu_background_color' ), true ).',0.05);
							}
						}
					';
				}
			}

			elseif( tie_get_option( 'mobile_menu_background_type' ) == 'gradient' ){
				if( tie_get_option( 'mobile_menu_background_gradient_color_1' ) &&  tie_get_option( 'mobile_menu_background_gradient_color_2' ) ){
					$color1 = tie_get_option( 'mobile_menu_background_gradient_color_1' );
					$color2 = tie_get_option( 'mobile_menu_background_gradient_color_2' );

					$mobile_bg = TIELABS_STYLES::gradiant( $color1, $color2 );
				}
			}

			elseif ( tie_get_option( 'mobile_menu_background_type' ) == 'image' ){
				if( tie_get_option( 'mobile_menu_background_image' ) ){
					$background_image = tie_get_option( 'mobile_menu_background_image' );
					$mobile_bg = TIELABS_STYLES::bg_image_css( $background_image );
				}
			}


			if( ! empty( $mobile_bg ) ){
				$out .='
					@media (max-width: 991px){
						.side-aside.dark-skin{
							'.$mobile_bg.'
						}
					}
				';
			}

			if( tie_get_option( 'mobile_menu_text_color' ) ){
				$out .='
					.side-aside #mobile-menu li a,
					.side-aside #mobile-menu .mobile-arrows,
					.side-aside #mobile-search .search-field{
						color: '. tie_get_option( 'mobile_menu_text_color' ) .';
					}

					#mobile-search .search-field::-moz-placeholder {
						color: '. tie_get_option( 'mobile_menu_text_color' ) .';
					}

					#mobile-search .search-field:-moz-placeholder {
						color: '. tie_get_option( 'mobile_menu_text_color' ) .';
					}

					#mobile-search .search-field:-ms-input-placeholder {
						color: '. tie_get_option( 'mobile_menu_text_color' ) .';
					}

					#mobile-search .search-field::-webkit-input-placeholder {
						color: '. tie_get_option( 'mobile_menu_text_color' ) .';
					}

					@media (max-width: 991px){
						.tie-btn-close span{
							color: '. tie_get_option( 'mobile_menu_text_color' ) .';
						}
					}
				';
			}

			if( tie_get_option( 'mobile_menu_social_color' ) ){
				$out .='
					#mobile-social-icons .social-icons-item a:not(:hover) span{
						color: '. tie_get_option( 'mobile_menu_social_color' ) .'!important;
					}
				';
			}

			/*
			if( tie_get_option( 'mobile_menu_search_color' ) ){
				$search_color = tie_get_option( 'mobile_menu_search_color' );
				$out .='
					#mobile-search .search-submit{
						background-color: '. $search_color .';
						color: '.TIELABS_STYLES::light_or_dark( $search_color ).';
					}

					#mobile-search .search-submit:hover{
						background-color: '. TIELABS_STYLES::color_brightness( $search_color ) .';
					}
				';
			}
			*/
		}


		if( tie_get_option( 'mobile_menu_icon_color' ) ){
			$out .='
				.mobile-header-components li.custom-menu-link > a,
				#mobile-menu-icon .menu-text{
					color: '. tie_get_option( 'mobile_menu_icon_color' ) .'!important;
				}

				#mobile-menu-icon .nav-icon,
				#mobile-menu-icon .nav-icon:before,
				#mobile-menu-icon .nav-icon:after{
					background-color: '. tie_get_option( 'mobile_menu_icon_color' ) .'!important;
				}
			';
		}

		// Mobile Logo Width
		if( tie_get_option( 'mobile_logo_width' ) ){
			$out .='
				@media (max-width: 991px){
					#theme-header.has-normal-width-logo #logo img {
						width:'. tie_get_option( 'mobile_logo_width' ) .'px !important;
						max-width:100% !important;
						height: auto !important;
						max-height: 200px !important;
					}
				}
			';
		}

		return $out;

	}
}


/**
 * Rounded Layout
 */
if( ! function_exists( 'jannah_rounded_blocks_css' ) ) {

	add_filter( 'TieLabs/CSS/after_theme_color', 'jannah_rounded_blocks_css' );
	function jannah_rounded_blocks_css( $out = '' ){

		if( tie_get_option( 'boxes_style' ) == 3 ){

			$rounded = apply_filters( 'TieLabs/Blocks_Layout/Rounded', '15' );

			$right = ! is_rtl() ? 'right' : 'left';
			$left  = ! is_rtl() ? 'left'  : 'right';

			if( ! empty( $rounded ) ){
				$rounded .= 'px';

				$out .= "
					body a.go-to-top-button,
					body .more-link,
					body .button,
					body [type='submit'],
					body .generic-button a,
					body .generic-button button,
					body textarea,
					body input:not([type='checkbox']):not([type='radio']),
					body .mag-box .breaking,
					body .social-icons-widget .social-icons-item .social-link,
					body .widget_product_tag_cloud a,
					body .widget_tag_cloud a,
					body .post-tags a,
					body .widget_layered_nav_filters a,
					body .post-bottom-meta-title,
					body .post-bottom-meta a,
					body .post-cat,
					body .more-link,
					body .show-more-button,
					body #instagram-link.is-expanded .follow-button,
					body .cat-counter a + span,
					body .mag-box-options .slider-arrow-nav a,
					body .main-menu .cats-horizontal li a,
					body #instagram-link.is-compact,
					body .pages-numbers a,
					body .pages-nav-item,
					body .bp-pagination-links .page-numbers,
					body .fullwidth-area .widget_tag_cloud .tagcloud a,
					body .header-layout-1 #main-nav .components #search-input,
					body ul.breaking-news-nav li.jnt-prev,
					body ul.breaking-news-nav li.jnt-next{
						border-radius: 35px;
					}

					body .mag-box ul.breaking-news-nav li{
						border: 0 !important;
					}

					body #instagram-link.is-compact{
						padding-right: 40px;
						padding-left: 40px;
					}

					body .post-bottom-meta-title,
					body .post-bottom-meta a,
					body .post-cat,
					body .more-link{
						padding-right: 15px;
						padding-left: 15px;
					}

					body #masonry-grid .container-wrapper .post-thumb img{
						border-radius: 0px;
					}

					body .video-thumbnail,
					body .review-item,
					body .review-summary,
					body .user-rate-wrap,
					body textarea,
					body input,
					body select{
						border-radius: 5px;
					}

					body .post-content-slideshow,
					body #tie-read-next,
					body .prev-next-post-nav .post-thumb,
					body .post-thumb img,
					body .container-wrapper,
					body .tie-popup-container .container-wrapper,
					body .widget,
					body .grid-slider-wrapper .grid-item,
					body .slider-vertical-navigation .slide,
					body .boxed-slider:not(.grid-slider-wrapper) .slide,
					body .buddypress-wrap .activity-list .load-more a,
					body .buddypress-wrap .activity-list .load-newest a,
					body .woocommerce .products .product .product-img img,
					body .woocommerce .products .product .product-img,
					body .woocommerce .woocommerce-tabs,
					body .woocommerce div.product .related.products,
					body .woocommerce div.product .up-sells.products,
					body .woocommerce .cart_totals, .woocommerce .cross-sells,
					body .big-thumb-left-box-inner,
					body .miscellaneous-box .posts-items li:first-child,
					body .single-big-img,
					body .masonry-with-spaces .container-wrapper .slide,
					body .news-gallery-items li .post-thumb,
					body .scroll-2-box .slide,
					.magazine1.archive:not(.bbpress) .entry-header-outer,
					.magazine1.search .entry-header-outer,
					.magazine1.archive:not(.bbpress) .mag-box .container-wrapper,
					.magazine1.search .mag-box .container-wrapper,
					body.magazine1 .entry-header-outer + .mag-box,
					body .digital-rating-static,
					body .entry q,
					body .entry blockquote,
					body #instagram-link.is-expanded,
					body.single-post .featured-area,
					body.post-layout-8 #content,
					body .footer-boxed-widget-area,
					body .tie-video-main-slider,
					body .post-thumb-overlay,
					body .widget_media_image img,
					body .stream-item-mag img,
					body .media-page-layout .post-element{
						border-radius: {$rounded};
					}

					@media (max-width: 767px) {
						.tie-video-main-slider iframe{
							border-top-right-radius: {$rounded};
							border-top-left-radius: {$rounded};
						}
					}

					.magazine1.archive:not(.bbpress) .mag-box .container-wrapper,
					.magazine1.search .mag-box .container-wrapper{
						margin-top: 15px;
						border-top-width: 1px;
					}

					body .section-wrapper:not(.container-full) .wide-slider-wrapper .slider-main-container,
					body .section-wrapper:not(.container-full) .wide-slider-three-slids-wrapper{
						border-radius: {$rounded};
						overflow: hidden;
					}

					body .wide-slider-nav-wrapper,
					body .share-buttons-bottom,
					body .first-post-gradient li:first-child .post-thumb:after,
					body .scroll-2-box .post-thumb:after{
						border-bottom-left-radius: {$rounded};
						border-bottom-right-radius: {$rounded};
					}

					body .main-menu .menu-sub-content,
					body .comp-sub-menu{
						border-bottom-left-radius: 10px;
						border-bottom-right-radius: 10px;
					}

					body.single-post .featured-area{
						overflow: hidden;
					}

					body #check-also-box.check-also-left{
						border-top-right-radius: {$rounded};
						border-bottom-right-radius: {$rounded};
					}

					body #check-also-box.check-also-right{
						border-top-left-radius: {$rounded};
						border-bottom-left-radius: {$rounded};
					}

					body .mag-box .breaking-news-nav li:last-child{
						border-top-right-radius: 35px;
						border-bottom-right-radius: 35px;
					}

					body .mag-box .breaking-title:before{
						border-top-$left-radius: 35px;
						border-bottom-$left-radius: 35px;
					}

					body .tabs li:last-child a,
					body .full-overlay-title li:not(.no-post-thumb) .block-title-overlay{
						border-top-$right-radius: {$rounded};
					}

					body .center-overlay-title li:not(.no-post-thumb) .block-title-overlay,
					body .tabs li:first-child a{
						border-top-$left-radius: {$rounded};
					}
				";

			}
		}

		return $out;
	}
}


/**
 * Custom Theme Color
 */
if( ! function_exists( 'jannah_theme_color_css' ) ) {

	add_filter( 'TieLabs/CSS/custom_theme_color', 'jannah_theme_color_css', 1, 5 );
	function jannah_theme_color_css( $css_code, $color, $dark_color, $bright, $rgb_color ){

		/**
		 * Color
		 */

		// .brand-title, extra class to color texts

		$css_code .= "
			.brand-title,
			a:hover,
			.tie-popup-search-submit,
			#logo.text-logo a,

			.theme-header nav .components #search-submit:hover,
			.theme-header .header-nav .components > li:hover > a,
			.theme-header .header-nav .components li a:hover,

			.main-menu ul.cats-vertical li a.is-active,
			.main-menu ul.cats-vertical li a:hover,
			.main-nav li.mega-menu .post-meta a:hover,
			.main-nav li.mega-menu .post-box-title a:hover,
			.search-in-main-nav.autocomplete-suggestions a:hover,

			#main-nav .menu ul:not(.cats-horizontal) li:hover > a,
			#main-nav .menu ul li.current-menu-item:not(.mega-link-column) > a,

			.top-nav .menu li:hover > a,
			.top-nav .menu > .tie-current-menu > a,
			.search-in-top-nav.autocomplete-suggestions .post-title a:hover,

			div.mag-box .mag-box-options .mag-box-filter-links a.active,
			.mag-box-filter-links .flexMenu-viewMore:hover > a,
			.stars-rating-active,
			body .tabs.tabs .active > a,
			.video-play-icon,
			.spinner-circle:after,
			#go-to-content:hover,
			.comment-list .comment-author .fn,
			.commentlist .comment-author .fn,
			blockquote::before,
			blockquote cite,
			blockquote.quote-simple p,
			.multiple-post-pages a:hover,
			#story-index li .is-current,
			.latest-tweets-widget .twitter-icon-wrap span,
			.wide-slider-nav-wrapper .slide,
			.wide-next-prev-slider-wrapper .tie-slider-nav li:hover span,
			.review-final-score h3,
			#mobile-menu-icon:hover .menu-text,
			body .entry a,
			.dark-skin body .entry a,
			.entry .post-bottom-meta a:hover,
			.comment-list .comment-content a,
			q a,
			blockquote a,

			.widget.tie-weather-widget .icon-basecloud-bg:after,

			.site-footer a:hover,
			.site-footer .stars-rating-active,
			.site-footer .twitter-icon-wrap span,
			.site-info a:hover{
				color: $color;
			}

			#instagram-link a:hover{
				color: $color !important;
				border-color: $color !important;
			}

		";

		/*
		 * To fix an overwrite issue
		 */
		if( $main_nav_color = tie_get_option( 'main_nav_links_color_hover' ) ) {
			$css_code .="
				#theme-header #main-nav .spinner-circle:after{
					color: $main_nav_color;
				}
			";
		}

		/*
		 * Background-color
		 */

		// .generic-button > BuddyPress
		$css_code .="
			[type='submit'],
			.button,
			.generic-button a,
			.generic-button button,

			.theme-header .header-nav .comp-sub-menu a.button.guest-btn:hover,
			.theme-header .header-nav .comp-sub-menu a.checkout-button,

			nav.main-nav .menu > li.tie-current-menu > a,
			nav.main-nav .menu > li:hover > a,
			.main-menu .mega-links-head:after,

			.main-nav .mega-menu.mega-cat .cats-horizontal li a.is-active,

			#mobile-menu-icon:hover .nav-icon,
			#mobile-menu-icon:hover .nav-icon:before,
			#mobile-menu-icon:hover .nav-icon:after,

			.search-in-main-nav.autocomplete-suggestions a.button,
			.search-in-top-nav.autocomplete-suggestions a.button,
			.spinner > div,

			.post-cat,
			.pages-numbers li.current span,
			.multiple-post-pages > span,
			#tie-wrapper .mejs-container .mejs-controls,
			.mag-box-filter-links a:hover,
			.slider-arrow-nav a:not(.pagination-disabled):hover,
			.comment-list .reply a:hover,
			.commentlist .reply a:hover,
			#reading-position-indicator,
			#story-index-icon,
			.videos-block .playlist-title,
			.review-percentage .review-item span span,
			.tie-slick-dots li.slick-active button,
			.tie-slick-dots li button:hover,

			.digital-rating-static,
			.timeline-widget li a:hover .date:before,
			#wp-calendar #today,
			.posts-list-counter li.widget-post-list:before,
			.cat-counter a + span,
			.tie-slider-nav li span:hover,
			.fullwidth-area .widget_tag_cloud .tagcloud a:hover,

			.magazine2:not(.block-head-4) .dark-widgetized-area ul.tabs a:hover,
			.magazine2:not(.block-head-4) .dark-widgetized-area ul.tabs .active a,
			.magazine1 .dark-widgetized-area ul.tabs a:hover,
			.magazine1 .dark-widgetized-area ul.tabs .active a,
			.block-head-4.magazine2 .dark-widgetized-area .tabs.tabs .active a,
			.block-head-4.magazine2 .dark-widgetized-area .tabs > .active a:before,
			.block-head-4.magazine2 .dark-widgetized-area .tabs > .active a:after,

			.demo_store,
			.demo #logo:after,
			.demo #sticky-logo:after,
			.widget.tie-weather-widget,
			span.video-close-btn:hover,
			#go-to-top,
			.latest-tweets-widget .slider-links .button:not(:hover){
				background-color: $color;
				color: $bright;
			}

			.tie-weather-widget .widget-title .the-subtitle,
			.block-head-4.magazine2 #footer .tabs .active a:hover{
				color: $bright;
			}
		";

		 /*
		 * border-color
		 */
		$css_code .="
			pre,
			code,
			.pages-numbers li.current span,
			.theme-header .header-nav .comp-sub-menu a.button.guest-btn:hover,
			.multiple-post-pages > span,
			.post-content-slideshow .tie-slider-nav li span:hover,
			#tie-body .tie-slider-nav li > span:hover,
			.slider-arrow-nav a:not(.pagination-disabled):hover,
			.main-nav .mega-menu.mega-cat .cats-horizontal li a.is-active,
			.main-nav .mega-menu.mega-cat .cats-horizontal li a:hover,
			.main-menu .menu > li > .menu-sub-content{
				border-color: $color;
			}

			.main-menu .menu > li.tie-current-menu{
				border-bottom-color: $color;
			}


			.top-nav .menu li.tie-current-menu > a:before,
			.top-nav .menu li.menu-item-has-children:hover > a:before{
				border-top-color: $color;
			}

			.main-nav .main-menu .menu > li.tie-current-menu > a:before,
			.main-nav .main-menu .menu > li:hover > a:before{
				border-top-color: $bright;
			}

			header.main-nav-light .main-nav .menu-item-has-children li:hover > a:before,
			header.main-nav-light .main-nav .mega-menu li:hover > a:before{
				border-left-color: $color;
			}

			.rtl header.main-nav-light .main-nav .menu-item-has-children li:hover > a:before,
			.rtl header.main-nav-light .main-nav .mega-menu li:hover > a:before{
				border-right-color: $color;
				border-left-color: transparent;
			}

			.top-nav ul.menu li .menu-item-has-children:hover > a:before{
				border-top-color: transparent;
				border-left-color: $color;
			}

			.rtl .top-nav ul.menu li .menu-item-has-children:hover > a:before{
				border-left-color: transparent;
				border-right-color: $color;
			}
		";

		/**
		 * Footer Border Top
		 */
		if( tie_get_option( 'footer_border_top' ) ) {
			$css_code .="
				#footer-widgets-container{
					border-top: 8px solid $color;
					-webkit-box-shadow: 0 -5px 0 rgba(0,0,0,0.07);
					   -moz-box-shadow: 0 -8px 0 rgba(0,0,0,0.07);
								  box-shadow: 0 -8px 0 rgba(0,0,0,0.07);
				}
			";
		}

		/**
		 * Misc
		 */
		$css_code .="
			::-moz-selection{
				background-color: $color;
				color: $bright;
			}

			::selection{
				background-color: $color;
				color: $bright;
			}

			circle.circle_bar{
				stroke: $color;
			}

			#reading-position-indicator{
				box-shadow: 0 0 10px rgba( $rgb_color, 0.7);
			}
		";

		/**
		 * Dark Color
		 */
		$css_code .="
			#logo.text-logo a:hover,
			body .entry a:hover,
			.dark-skin body .entry a:hover,
			.comment-list .comment-content a:hover,
			.block-head-4.magazine2 .site-footer .tabs li a:hover,
			q a:hover,
			blockquote a:hover{
				color: $dark_color;
			}
		";

		/**
		 * Dark Background-color
		 */
		$css_code .="
			.button:hover,
			input[type='submit']:hover,
			.generic-button a:hover,
			.generic-button button:hover,

			a.post-cat:hover,
			.site-footer .button:hover,
			.site-footer [type='submit']:hover,
			.search-in-main-nav.autocomplete-suggestions a.button:hover,
			.search-in-top-nav.autocomplete-suggestions a.button:hover,
			.theme-header .header-nav .comp-sub-menu a.checkout-button:hover{
				background-color: $dark_color;
				color: $bright;
			}

			.theme-header .header-nav .comp-sub-menu a.checkout-button:not(:hover),
			body .entry a.button{
				color: $bright;
			}

			#story-index.is-compact .story-index-content{
				background-color: $color;
			}

			#story-index.is-compact .story-index-content a,
			#story-index.is-compact .story-index-content .is-current{
				color: $bright;
			}
		";


		/**
		 * BuddyPress
		 */
		if ( TIELABS_BUDDYPRESS_IS_ACTIVE ){
			$css_code .="
				@media screen and (min-width: 46.8em){
					.bp-dir-hori-nav:not(.bp-vertical-navs) .bp-navs.main-navs ul li a:hover,
					.bp-dir-hori-nav:not(.bp-vertical-navs) .bp-navs.main-navs ul li.selected a,
					.bp-dir-hori-nav:not(.bp-vertical-navs) .bp-navs.main-navs ul li.current a,
					.bp-single-vert-nav .item-body:not(#group-create-body) #subnav:not(.tabbed-links) li.current a,
					.bp-single-vert-nav .bp-navs.vertical li.selected a,
					.bp-dir-vert-nav .dir-navs ul li.selected a{
						color: $color;
					}
				}

				.buddypress-wrap .bp-subnavs li.selected a,
				.buddypress-wrap .bp-subnavs li.current a,
				.activity-list .activity-item .activity-meta.action .unfav:before,
				.buddypress-wrap .profile .profile-fields .label,
				.buddypress-wrap .profile.edit .button-nav li a:hover,
				.buddypress-wrap .profile.edit .button-nav li.current a,
				#message-threads li.selected .thread-subject .subject,
				.buddypress .buddypress-wrap .text-links-list a.button:focus,
				.buddypress .buddypress-wrap .text-links-list a.button:hover,
				.bp-dir-hori-nav:not(.bp-vertical-navs) .bp-navs.main-navs ul li a:hover,
				.bp-dir-hori-nav:not(.bp-vertical-navs) .bp-navs.main-navs ul li.selected a,
				.bp-dir-hori-nav:not(.bp-vertical-navs) .bp-navs.main-navs ul li.current a,
				#group-create-tabs:not(.tabbed-links) li.current a{
					color: $color;
				}

				#group-create-tabs:not(.tabbed-links) li.current a:hover{
					color: $dark_color;
				}

				.buddypress-wrap .profile .profile-fields .label:before,
				.buddypress-wrap .bp-pagination .bp-pagination-links .current{
					background: $color
				}

				.bp-navs ul li .count,
				.buddypress-wrap .activity-list .load-more a,
				.buddypress-wrap .activity-list .load-newest a,
				.buddypress-wrap #compose-personal-li a,
				.buddypress #buddypress.bp-dir-hori-nav .create-button a{
					background: $color;
					color: $bright;
				}

				buddypress-wrap #compose-personal-li a:hover,
				buddypress-wrap .activity-list .load-more a:hover,
				buddypress-wrap .activity-list .load-newest a:hover{
					background: $dark_color;
				}

				.widget.buddypress .item-options a.selected:not(.loading){
					background: $color;
					border-color: $color;
					color: $bright !important;
				}
			";
		}


		/**
		 * WooCommerce
		 */
		if ( TIELABS_WOOCOMMERCE_IS_ACTIVE ){
			$css_code .="
				.woocommerce div.product span.price,
				.woocommerce div.product p.price,
				.woocommerce div.product div.summary .product_meta > span,
				.woocommerce div.product div.summary .product_meta > span a:hover,
				.woocommerce ul.products li.product .price ins,
				.woocommerce .woocommerce-pagination ul.page-numbers li a.current,
				.woocommerce .woocommerce-pagination ul.page-numbers li a:hover,
				.woocommerce .woocommerce-pagination ul.page-numbers li span.current,
				.woocommerce .woocommerce-pagination ul.page-numbers li span:hover,
				.woocommerce .widget_rating_filter ul li.chosen a,
				.woocommerce-MyAccount-navigation ul li.is-active a{
					color: $color;
				}

				.woocommerce span.new,
				.woocommerce a.button.alt,
				.woocommerce button.button.alt,
				.woocommerce input.button.alt,
				.woocommerce a.button.alt.disabled,
				.woocommerce a.button.alt:disabled,
				.woocommerce a.button.alt:disabled[disabled],
				.woocommerce a.button.alt.disabled:hover,
				.woocommerce a.button.alt:disabled:hover,
				.woocommerce a.button.alt:disabled[disabled]:hover,
				.woocommerce button.button.alt.disabled,
				.woocommerce button.button.alt:disabled,
				.woocommerce button.button.alt:disabled[disabled],
				.woocommerce button.button.alt.disabled:hover,
				.woocommerce button.button.alt:disabled:hover,
				.woocommerce button.button.alt:disabled[disabled]:hover,
				.woocommerce input.button.alt.disabled,
				.woocommerce input.button.alt:disabled,
				.woocommerce input.button.alt:disabled[disabled],
				.woocommerce input.button.alt.disabled:hover,
				.woocommerce input.button.alt:disabled:hover,
				.woocommerce input.button.alt:disabled[disabled]:hover,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-range{
					background-color: $color;
					color: $bright;
				}

				.woocommerce div.product #product-images-slider-nav .tie-slick-slider .slide.slick-current img{
					border-color: $color;
				}

				.woocommerce a.button:hover,
				.woocommerce button.button:hover,
				.woocommerce input.button:hover,
				.woocommerce a.button.alt:hover,
				.woocommerce button.button.alt:hover,
				.woocommerce input.button.alt:hover{
					background-color: $dark_color;
				}
			";
		}

		return $css_code;
	}
}





/*
 * Check if the Main or Top Nav
 * have the same color of the Primary Menu
 * And add some color fixes
*/
if( ! function_exists( 'jannah_theme_color_fix_menus_colors' ) ) {

	add_filter( 'TieLabs/CSS/custom_theme_color', 'jannah_theme_color_fix_menus_colors', 7, 5 );
	function jannah_theme_color_fix_menus_colors( $css_code, $color, $dark_color, $bright, $rgb_color ){


		// Main Nav
		if( ( $color == tie_get_option( 'main_nav_background' ) ) && ! tie_get_option( 'main_nav_links_color' ) ){

			$hover_and_active = tie_get_option( 'main_nav_links_color_hover' );

			$css_code .="
				#main-nav ul.menu > li.tie-current-menu > a,
				#main-nav ul.menu > li:hover > a,
				#main-nav .spinner > div,
				.main-menu .mega-links-head:after{
					background-color: $hover_and_active !important;
				}

				#main-nav a,
				#main-nav .dropdown-social-icons li a span,
				.search-in-main-nav.autocomplete-suggestions a {
					color: $bright !important;
				}

				#main-nav .main-menu ul.menu > li.tie-current-menu,
				#theme-header nav .menu > li > .menu-sub-content{
					border-color: $hover_and_active;
				}

				#main-nav .spinner-circle:after{
					color: $hover_and_active !important;
				}

				.main-nav-light #main-nav .menu-item-has-children li:hover > a:before,
				.main-nav-light #main-nav .mega-menu li:hover > a:before{
					border-left-color: $bright !important;
				}

				.rtl .main-nav-light #main-nav .menu-item-has-children li:hover > a:before,
				.rtl .main-nav-light #main-nav .mega-menu li:hover > a:before{
					border-right-color: $bright !important;
					border-left-color: transparent !important;
				}
			";
		}

		// Top Nav
		if( ( $color == tie_get_option( 'secondry_nav_background' ) ) && ! tie_get_option( 'topbar_links_color' ) ){

			$css_code .="
				#top-nav a{
					color: $bright;
				}

				#top-nav .tie-current-menu > a:before,
				#top-nav .menu .menu-item-has-children:hover > a:before{
					border-top-color: $bright !important;
				}

				#top-nav .menu li .menu-item-has-children:hover > a:before{
					border-top-color: transparent !important;
					border-left-color: $bright !important;
				}

				.rtl #top-nav .menu li .menu-item-has-children:hover > a:before{
					border-left-color: transparent !important;
					border-right-color: $bright !important;
				}
			";
		}

		return $css_code;
	}
}



/*
 * Blocks Head Colors
 */
if( ! function_exists( 'tie_blocks_head' ) ) {

	add_filter( 'TieLabs/CSS/custom_theme_color', 'tie_blocks_head', 10, 5 );
	function tie_blocks_head( $css_code, $color, $dark_color, $bright, $rgb_color ){

		// Theme Blocks style
		$block_style = tie_get_option( 'blocks_style', 1 );

		//Style #1 / #2 / #3
		if( $block_style <= 3 ){
			$css_code .= "
				#tie-body .mag-box-title h3 a,
				#tie-body .block-more-button{
					color: $color;
				}

				#tie-body .mag-box-title h3 a:hover,
				#tie-body .block-more-button:hover{
					color: $dark_color;
				}
			";
		}

		// Style #1
		if( $block_style == 1 ){

			$css_code .= "
				#tie-body .mag-box-title{
					color: $color;
				}

				#tie-body .mag-box-title:before{
					border-top-color: $color;
				}

				#tie-body .mag-box-title:after,
				#tie-body #footer .widget-title:after{
					background-color: $color;
				}
			";
		}

		// Style #2
		elseif( $block_style == 2 ){

			$css_code .= "
				#tie-body .the-global-title,
				#tie-body .comment-reply-title,
				#tie-body .related.products > h2,
				#tie-body .up-sells > h2,
				#tie-body .cross-sells > h2,
				#tie-body .cart_totals > h2,
				#tie-body .bbp-form legend{
					border-color: $color;
					color: $color;
				}

				#tie-body #footer .widget-title:after{
					background-color: $color;
				}
			";
		}

		// Style #3
		elseif( $block_style == 3 ){

			$css_code .= "
				#tie-body .mag-box-title{
					color: $color;
				}

				#tie-body .mag-box-title:after,
				#tie-body #footer .widget-title:after{
					background-color: $color;
				}
			";
		}

		// Style #4 || #5 || #6
		elseif( $block_style <= 6 ){

			$css_code .= "
				#tie-body .has-block-head-4,
				#tie-body .mag-box-title h3,
				#tie-body .comment-reply-title,
				#tie-body .related.products > h2,
				#tie-body .up-sells > h2,
				#tie-body .cross-sells > h2,
				#tie-body .cart_totals > h2,
				#tie-body .bbp-form legend,
				#tie-body .mag-box-title h3 a,
				#tie-body .section-title-default a,
				#tie-body #cancel-comment-reply-link {
					color: $bright;
				}

				#tie-body .has-block-head-4:before,
				#tie-body .mag-box-title h3:before,
				#tie-body .comment-reply-title:before,
				#tie-body .related.products > h2:before,
				#tie-body .up-sells > h2:before,
				#tie-body .cross-sells > h2:before,
				#tie-body .cart_totals > h2:before,
				#tie-body .bbp-form legend:before {
					background-color: $color;
				}

				#tie-body .block-more-button{
					color: $color;
				}

				#tie-body .block-more-button:hover{
					color: $dark_color;
				}
			";

			if( $block_style == 6 ){
				$css_code .= "
					#tie-body .has-block-head-4:after,
					#tie-body .mag-box-title h3:after,
					#tie-body .comment-reply-title:after,
					#tie-body .related.products > h2:after,
					#tie-body .up-sells > h2:after,
					#tie-body .cross-sells > h2:after,
					#tie-body .cart_totals > h2:after,
					#tie-body .bbp-form legend:after{
						background-color: $color;
					}
				";
			}

			// Magazine 2
			if( tie_get_option( 'boxes_style' ) == 2 ){

				$css_code .= "
					#tie-body .tabs,
					#tie-body .tabs .flexMenu-popup{
						border-color: $color;
					}

					#tie-body .tabs li a{
						color: $color;
					}

					#tie-body .tabs li a:hover{
						color: $dark_color;
					}

					#tie-body .tabs li.active a{
						color: $bright;
						background-color: $color;
					}
				";

				if( $block_style == 5 || $block_style == 6 ){
					$css_code .="
						#tie-body .tabs > .active a:before,
						#tie-body .tabs > .active a:after{
							background-color: $color;
						}
					";
				}

			} // Magazine 2 if

		} // #4 || #5 || #6


		// Style #7
		elseif( $block_style == 7 ){

			// All heads except the widget-title head will be in the default black background.
			$css_code .= "
				#tie-body .section-title-default,
				#tie-body .mag-box-title,
				#tie-body #comments-title,
				#tie-body .review-box-header,
				#tie-body .comment-reply-title,
				#tie-body .comment-reply-title,
				#tie-body .related.products > h2,
				#tie-body .up-sells > h2,
				#tie-body .cross-sells > h2,
				#tie-body .cart_totals > h2,
				#tie-body .bbp-form legend{
					color: $bright;
					background-color: $color;
				}

				#tie-body .mag-box-filter-links > li > a,
				#tie-body .mag-box-title h3 a,
				#tie-body .block-more-button{
					color: $bright;
				}

				#tie-body .flexMenu-viewMore:hover > a{
					color: $color;
				}

				#tie-body .mag-box-filter-links > li > a:hover,
				#tie-body .mag-box-filter-links li > a.active{
					background-color: $bright;
					color: $color;
				}

				#tie-body .slider-arrow-nav a{
					border-color: rgba($bright ,0.2);
					color: $bright;
				}

				#tie-body .mag-box-title a.pagination-disabled,
				#tie-body .mag-box-title a.pagination-disabled:hover{
					color: $bright !important;
				}

				#tie-body .slider-arrow-nav a:not(.pagination-disabled):hover{
					background-color: $bright;
					border-color: $bright;
					color: $color;
				}
			";
		}

		// Style #8
		elseif( $block_style == 8 ){

			$css_code .="
				#tie-body .the-global-title:before,
				#tie-body .comment-reply-title:before,
				#tie-body .related.products > h2:before,
				#tie-body .up-sells > h2:before,
				#tie-body .cross-sells > h2:before,
				#tie-body .cart_totals > h2:before,
				#tie-body .bbp-form legend:before{
					background-color: $color;
				}
			";
		}

		// Style #10
		elseif( $block_style == 10 ){
			$css_code .= "
				#tie-body .has-block-head-4:after,
				#tie-body .mag-box-title h3:after,
				#tie-body .comment-reply-title:after,
				#tie-body .related.products > h2:after,
				#tie-body .up-sells > h2:after,
				#tie-body .cross-sells > h2:after,
				#tie-body .cart_totals > h2:after,
				#tie-body .bbp-form legend:after{
					background-color: $color;
				}
			";
		}

		// Style #11
		elseif( $block_style == 11 ){

			$direction = is_rtl() ? 'right' : 'left';

			$css_code .="
				#tie-body .has-block-head-4:after,
				#tie-body .mag-box-title h3:after,
				#tie-body .comment-reply-title:after,
				#tie-body .related.products > h2:after,
				#tie-body .up-sells > h2:after,
				#tie-body .cross-sells > h2:after,
				#tie-body .cart_totals > h2:after,
				#tie-body .bbp-form legend:after {
					border-$direction-color: $color;
				}
			";
		}

		return $css_code;
	}

}



/**
 * Set Sections Custom Styles
 */
if( ! function_exists( 'jannah_section_custom_styles' ) ) {

	add_filter( 'TieLabs/CSS/Builder/section_style', 'jannah_section_custom_styles', 10, 3 );
	function jannah_section_custom_styles( $section_css, $section_id, $section_settings ){

		// Section Head Styles
		if( ! empty( $section_settings['section_title'] ) && ! empty( $section_settings['title'] ) && ! empty( $section_settings['title_color'] ) ) {

			$block_style = tie_get_option( 'blocks_style', 1 );

			$color    = $section_settings['title_color'];
			$darker   = TIELABS_STYLES::color_brightness( $color );
			$bright   = TIELABS_STYLES::light_or_dark( $color );
			$selector = "#$section_id .section-title";

			// Centered Style
			if( ! empty( $section_settings['title_style'] ) && $section_settings['title_style'] == 'centered' ){

				$section_css .= "

					$selector,
					$selector a{
						color: $color;
					}

					$selector a:hover{
						color: $darker;
					}

					#$section_id .section-title-centered:before,
					#$section_id .section-title-centered:after{
						background-color: $color;
					}
				";
			}

			// Big Style
			elseif( ! empty( $section_settings['title_style'] ) && $section_settings['title_style'] == 'big' ){

				$section_css .= "

					$selector,
					$selector a{
						color: $color;
					}

					$selector a:hover{
						color: $darker;
					}
				";
			}

			// Default Style
			elseif( empty( $section_settings['title_style'] ) ){

				$selector = "#$section_id .section-title-default";

				/* Style #1 */
				if( $block_style == 1 ){

					$section_css .= "
						$selector,
						$selector a{
							color: $color;
						}

						$selector a:hover{
							color: $darker;
						}

						$selector:before{
							border-top-color: $color;
						}

						$selector:after{
							background-color: $color;
						}
					";
				}

				/* Style #2 */
				if( $block_style == 2 ){

					$section_css .= "
						$selector,
						$selector a{
							border-color: $color;
							color: $color;
						}

						$selector a:hover{
							color: $darker;
						}
					";
				}

				/* Style #3 */
				elseif( $block_style == 3 ){

					$section_css .= "
						$selector,
						$selector a{
							color: $color;
						}

						$selector a:hover{
							color: $darker;
						}

						$selector:after {
							background: $color;
						}
					";
				}

				/* Style #4 || #5 || #6 */
				elseif( $block_style == 4 || $block_style == 5 || $block_style == 6 ){

					$section_css .= "
						$selector,
						$selector a{
							color: $bright;
						}

						$selector:before{
							background-color: $color;
						}
					";

					/* Style #6 */
					if( $block_style == 6 ){

						$section_css .= "
							$selector:after{
								background-color: $color;
							}
						";
					}
				}

				/* Style #7 */
				elseif( $block_style == 7 ){

					$section_css .= "
						$selector{
							background-color: $color;
							color: $bright;
						}

						$selector a{
							color: $bright;
						}

						$selector:after{
							background-color: $bright;
						}
					";
				}

				/* Style #8 */
				elseif( $block_style == 8 ){

					$section_css .= "
						$selector:before{
							background-color: $color;
						}

						$selector a:hover{
							color: $color;
						}
					";
				}

			}
		}

		// Block 16 and 12 title section color
		if( tie_get_option( 'boxes_style' ) == 2 && ! empty( $section_settings['background_color'] ) ){

			$color  = $section_settings['background_color'];
			$bright = TIELABS_STYLES::light_or_dark( $color );

			$section_css .= "
				#$section_id .full-overlay-title li:not(.no-post-thumb) .block-title-overlay{
					background-color: $color;
				}

				#$section_id .full-overlay-title li:not(.no-post-thumb) .block-title-overlay .post-meta,
				#$section_id .full-overlay-title li:not(.no-post-thumb) .block-title-overlay a:not(:hover){
					color: $bright;
				}

				#$section_id .full-overlay-title li:not(.no-post-thumb) .block-title-overlay .post-meta{
					opacity: 0.80;
				}
			";
		}

		return $section_css;
	}
}


/*
 * Set Custom color for the blocks
 */
if( ! function_exists( 'jannah_block_custom_bg' ) ) {

	add_filter( 'TieLabs/CSS/Builder/block_bg', 'jannah_block_custom_bg', 10, 6 );
	function jannah_block_custom_bg( $block_css, $id_css, $block, $color, $bright, $darker ){

		if( $color == $darker ){
			$darker = TIELABS_STYLES::color_brightness( $color, 30 );
		}

		/*
		$id_css .trending-post.tie-icon-bolt{
			color: $bright;
		}
		*/

		// Default Blocks Head Style
		$block_style = tie_get_option( 'blocks_style', 1 );

		$block_css = "
			$id_css{
				color: $bright;
			}

			$id_css .container-wrapper,
			$id_css .flexMenu-popup,
			$id_css.full-overlay-title li:not(.no-post-thumb) .block-title-overlay{
				background-color: $color;
			}

			$id_css .slider-arrow-nav a:not(:hover),
			$id_css .pagination-disabled,
			$id_css .pagination-disabled:hover{
				color: $bright !important;
			}

			$id_css a:not(:hover):not(.button){
				color: $bright;
			}

			$id_css .entry,
			$id_css .post-excerpt,
			$id_css .post-meta,
			$id_css .day-month,
			$id_css .post-meta a:not(:hover){
				color: $bright !important;
				opacity: 0.9;
			}

			$id_css.first-post-gradient .posts-items li:first-child a:not(:hover),
			$id_css.first-post-gradient li:first-child .post-meta{
				color: #ffffff !important;
			}

			$id_css .slider-arrow-nav a,
			$id_css .pages-nav .pages-numbers a,
			$id_css .show-more-button{
				border-color: $darker;
			}

		";

		// Block Style 1
		if( $block_style == 1 ){
			$block_css .= "
				.block-head-1 $id_css .the-global-title{
					border-color: $darker;
				}
			";
		}


		// Tabs
		if( $block['style'] == 'tabs' ){
			$block_css .= "
				$id_css.tabs-box,
				$id_css.tabs-box .tabs .active > a{
					background-color: $color;
				}

				$id_css.tabs-box .tabs a{
					background-color: $darker;
				}

				$id_css.tabs-box .tabs{
					border-color: $darker;
				}

				$id_css.tabs-box .tabs a,
				$id_css.tabs-box .flexMenu-popup,
				$id_css.tabs-box .flexMenu-popup li a{
					border-color: rgba(0,0,0,0.1);
				}
			";

			if( tie_get_option( 'boxes_style' ) == 2 ){
				$block_css .= "
					$id_css .tab-content{
						padding: 0;
					}
				";
			}
		}

		/* Breaking */
		elseif( $block['style'] == 'breaking' ){
			$block_css .= "
				$id_css .breaking,
				$id_css .ticker-content,
				$id_css .ticker-swipe{
					background-color: $darker;
				}
			";
		}

		/* Timeline */
		elseif( $block['style'] == 'timeline' ){
			$block_css .= "
				$id_css.timeline-box .posts-items:last-of-type:after{
					background-image: linear-gradient(to bottom, $darker 0%, $color 80%);
				}

				$id_css .year-month,
				$id_css .day-month:before,
				$id_css.timeline-box .posts-items:before{
					background-color: $darker;
				}

				$id_css .year-month{
					color: $bright;
				}

				$id_css .day-month:before{
					border-color: $color;
				}
			";
		}

		/* Custom Contents */
		elseif( $block['style'] == 'code' || $block['style'] == 'code_50' ){
			$block_css .= "
				$id_css .tabs.tabs .active > a{
					background-color: $darker;
					border-color: rgba(0,0,0,0.1);
				}
			";
		}

		/* Scrolling */
		elseif( $block['style'] == 'scroll' || $block['style'] == 'scroll_2' ){
			$block_css .= "
				$id_css .tie-slick-dots li:not(.slick-active) button{
					background-color: $darker;
				}
			";
		}

		return $block_css;
	}
}


/*
 * Set Custom color for the blocks
 */
if( ! function_exists( 'jannah_block_custom_color' ) ) {

	add_filter( 'TieLabs/CSS/Builder/block_style', 'jannah_block_custom_color', 10, 6 );
	function jannah_block_custom_color( $block_css, $id_css, $block, $color, $bright, $darker ){

		// Default Blocks Head Style
		$block_style = tie_get_option( 'blocks_style', 1 );

		// General Custom block CSS code
		$block_css = "
			$id_css .mag-box-filter-links a.active,
			$id_css .mag-box-filter-links .flexMenu-viewMore:hover > a,
			$id_css .stars-rating-active,
			$id_css .tabs.tabs .active > a,
			$id_css .spinner-circle:after,
			$id_css .video-play-icon,
			$id_css .pages-nav li a:hover,
			$id_css .show-more-button:hover,
			$id_css .entry a,
			$id_css.woocommerce ins{
				color: $color;
			}

			$id_css a:hover,
			$id_css .entry a:hover{
				color: $darker;
			}

			$id_css .spinner > div,
			$id_css .tie-slick-dots li.slick-active button,
			$id_css li.current span,
			$id_css .tie-slick-dots li.slick-active button,
			$id_css .tie-slick-dots li button:hover{
				background-color: $color;
			}

			$id_css .digital-rating-static,
			$id_css .mag-box-filter-links a:hover,
			$id_css .slider-arrow-nav a:not(.pagination-disabled):hover,
			$id_css .playlist-title,
			$id_css .breaking-title:before,
			$id_css .breaking-news-nav li:hover,
			$id_css .post-cat,
			$id_css .tie-slider-nav li > span:hover,
			$id_css .button{
				background-color: $color;
				color: $bright;
			}

			$id_css a.post-cat:hover,
			$id_css .button:hover{
				background-color: $darker;
				color: $bright;
			}

			$id_css .entry a.button{
			  color: $bright;
			}

			$id_css .circle_bar{
			  stroke: $color;
			}

			$id_css .slider-arrow-nav a:not(.pagination-disabled):hover,
			$id_css li.current span,
			$id_css .breaking-news-nav li:hover{
				border-color: $color;
			}
		";

		/* Style #1 OR 2 Or 3 */
		if( $block_style <= 3 ){

			$block_css .= "
				$id_css .mag-box-title h3 a,
				$id_css .block-more-button{
					color: $color;
				}

				$id_css .mag-box-title h3 a:hover,
				$id_css .block-more-button:hover{
					color: $darker;
				}
			";

			if( $block_style == 1 ){

				$block_css .= "
					$id_css .mag-box-title{
						color: $color;
					}

					$id_css .mag-box-title:before {
						border-top-color: $color;
					}

					$id_css .mag-box-title:after{
						background-color: $color;
					}
				";
			}

			/* Style #2 */
			elseif( $block_style == 2 ){

				$block_css .= "
					$id_css .mag-box-title{
						border-color: $color;
						color: $color;
					}
				";
			}

			/* Style #3 */
			elseif( $block_style == 3 ){

				$block_css .= "
					$id_css .mag-box-title{
						color: $color;
					}

					$id_css .mag-box-title:after{
						background-color: $color;
					}
				";
			}
		}

		/* Style #4 || #5 || #6 */
		elseif( $block_style == 4 || $block_style == 5 || $block_style == 6 ){

			$block_css .= "
				$id_css .mag-box-title h3,
				$id_css .mag-box-title h3 a{
					color: $bright;
				}

				$id_css .mag-box-title h3:before{
					background-color: $color;
				}

				$id_css .block-more-button{
					color: $color;
				}

				$id_css .block-more-button:hover{
					color: $darker;
				}
			";

			/* Style #4 || #5 || #6 && Magazine 2 && Block Style == Tabs */
			if( tie_get_option( 'boxes_style' ) == 2 && ( ! empty( $block['style'] ) && $block['style'] == 'tabs' ) ) {

				$block_css .= "

					$id_css .tabs,
					$id_css .tabs .flexMenu-popup{
						border-color: $color;
					}

					$id_css .tabs li a{
						color: $color;
					}

					$id_css .tabs li a:hover{
						color: $darker;
					}

					$id_css .tabs.tabs li.active > a{
						color: $bright;
						background-color: $color;
					}
				";
			}

			/* Style #5 && Magazine 2 */
			if( ( $block_style == 5 || $block_style == 6 ) && tie_get_option( 'boxes_style' ) == 2 ){

				$block_css .= "
					$id_css .tabs > .active a:before,
					$id_css .tabs > .active a:after{
						background-color: $color;
					}
				";
			}

			/* Style #6 */
			if( $block_style == 6 ){
				$block_css .= "
					$id_css .mag-box-title h3:after{
						background-color: $color;
					}
				";
			} // #style 6

		} // #4 || #5 || #6


		/* Style #7 */
		elseif( $block_style == 7 ){

			$block_css .= "
				$id_css .mag-box-title{
					color: $bright;
					background-color: $color;
				}

				$id_css .mag-box-filter-links > li > a,
				$id_css .mag-box-title h3 a,
				$id_css .mag-box-title a.block-more-button{
					color: $bright;
				}

				$id_css .flexMenu-viewMore:hover > a{
					color: $color;
				}

				$id_css .mag-box-filter-links > li > a:hover,
				$id_css .mag-box-filter-links li > a.active{
					background-color: $bright;
					color: $color;
				}

				$id_css .slider-arrow-nav a{
					border-color: rgba($bright ,0.2);
					color: $bright;
				}

				$id_css .mag-box-title a.pagination-disabled,
				$id_css .mag-box-title a.pagination-disabled:hover{
					color: $bright !important;
				}

				$id_css .slider-arrow-nav a:not(.pagination-disabled):hover{
					background-color: $bright;
					border-color: $bright;
					color: $color;
				}
			";
		}

		/* Style #8 */
		elseif( $block_style == 8 ){
			$block_css .= "
				$id_css .mag-box-title:before{
					background-color: $color;
				}
			";
		}

		/* Style #10 */
		elseif( $block_style == 10 ) {
			$block_css .= "
				$id_css .mag-box-title h3:after{
					background-color: $color;
				}
			";
		}

		/* Style #11 */
		elseif( $block_style == 11 ) {
			$direction = is_rtl() ? 'right' : 'left';
			$block_css .= "
				$id_css .mag-box-title h3:after{
					border-$direction-color: $color;
				}
			";
		}

		return $block_css;
	}
}


/**
 * Default Theme fonts sections
 */
if( ! function_exists( 'jannah_fonts_sections' ) ) {

	add_filter( 'TieLabs/fonts_sections_array', 'jannah_fonts_sections' );
	function jannah_fonts_sections(){

		$fonts_sections = array(
			'body'         => 'body',
			'headings'     => '.logo-text, h1, h2, h3, h4, h5, h6, .the-subtitle',
			'menu'         => '#main-nav .main-menu > ul > li > a',
			'blockquote'   => 'blockquote p',
		);

		return apply_filters( 'Jannah/fonts_default_sections_array', $fonts_sections );
	}
}


/**
 * Default Theme Typography Elements
 */
if( ! function_exists( 'jannah_typography_elements' ) ) {

	add_filter( 'TieLabs/typography_elements', 'jannah_typography_elements' );
	function jannah_typography_elements(){

		# Custom size, line height, weight, captelization
		$text_sections = array(
			'body'                 => 'body',
			'site_title'           => '#logo.text-logo .logo-text',
			'top_menu'             => '#top-nav .top-menu > ul > li > a',
			'top_menu_sub'         => '#top-nav .top-menu > ul ul li a',
			'main_nav'             => '#main-nav .main-menu > ul > li > a',
			'main_nav_sub'         => '#main-nav .main-menu > ul ul li a',
			'mobile_menu'          => '#mobile-menu li a',
			'breaking_news'        => '.breaking .breaking-title',
			'breaking_news_posts'  => '.ticker-wrapper .ticker-content',
			'buttons'              => 'body .button,body [type="submit"]', // body > override Sari3
			'breadcrumbs'          => '#breadcrumb',
			'post_cat_label'       => '.post-cat',
			'single_post_title'    => '.entry-header h1.entry-title',
			'single_archive_title' => 'h1.page-title',
			'post_entry'           => '#the-post .entry-content, #the-post .entry-content p',
			'comment_text'         => '.comment-list .comment-body p',
			'blockquote'           => '#the-post .entry-content blockquote, #the-post .entry-content blockquote p',
			'boxes_title'          => '#tie-wrapper .mag-box-title h3',

			'page_404_main_title'  => array( 'min-width: 992px' => '.container-404 h2' ),
			'page_404_sec_title'   => array( 'min-width: 992px' => '.container-404 h3' ),
			'page_404_description' => array( 'min-width: 992px' => '.container-404 h4' ),

			'sections_title_default' => array(
				'min-width: 768px' => '.section-title.section-title-default, .section-title-centered',
			),
			'sections_title_big' => array(
				'min-width: 768px' => '.section-title-big',
			),

			'copyright'            => '#tie-wrapper .copyright-text',
			'footer_widgets_title' => '#footer .widget-title .the-subtitle',
			'post_heading_h1'      => '.entry h1',
			'post_heading_h2'      => '.entry h2',
			'post_heading_h3'      => '.entry h3',
			'post_heading_h4'      => '.entry h4',
			'post_heading_h5'      => '.entry h5',
			'post_heading_h6'      => '.entry h6',

			'widgets_title'        => '
				#tie-wrapper .widget-title .the-subtitle,
				#tie-wrapper #comments-title,
				#tie-wrapper .comment-reply-title,
				#tie-wrapper .woocommerce-tabs .panel h2,
				#tie-wrapper .related.products h2,
				#tie-wrapper #bbpress-forums #new-post > fieldset.bbp-form > legend,
				#tie-wrapper .entry-content .review-box-header',

			'widgets_post_title'   => '
				.post-widget-body .post-title,
				.timeline-widget ul li h3,
				.posts-list-half-posts li .post-title
			',

			// Blocks Typography Options
			'post_title_blocks' => '
				#tie-wrapper .media-page-layout .thumb-title,
				#tie-wrapper .mag-box.full-width-img-news-box .posts-items>li .post-title,
				#tie-wrapper .miscellaneous-box .posts-items>li:first-child .post-title,
				#tie-wrapper .big-thumb-left-box .posts-items li:first-child .post-title',
			'post_medium_title_blocks' => '
				#tie-wrapper .mag-box.wide-post-box .posts-items>li:nth-child(n) .post-title,
				#tie-wrapper .mag-box.big-post-left-box li:first-child .post-title,
				#tie-wrapper .mag-box.big-post-top-box li:first-child .post-title,
				#tie-wrapper .mag-box.half-box li:first-child .post-title,
				#tie-wrapper .mag-box.big-posts-box .posts-items>li:nth-child(n) .post-title,
				#tie-wrapper .mag-box.mini-posts-box .posts-items>li:nth-child(n) .post-title,
				#tie-wrapper .mag-box.latest-poroducts-box .products .product h2',
			'post_small_title_blocks' => '
				#tie-wrapper .mag-box.big-post-left-box li:not(:first-child) .post-title,
				#tie-wrapper .mag-box.big-post-top-box li:not(:first-child) .post-title,
				#tie-wrapper .mag-box.half-box li:not(:first-child) .post-title,
				#tie-wrapper .mag-box.big-thumb-left-box li:not(:first-child) .post-title,
				#tie-wrapper .mag-box.scrolling-box .slide .post-title,
				#tie-wrapper .mag-box.miscellaneous-box li:not(:first-child) .post-title',

			// Sliders Typography Options
			'post_title_sliders' => array(
				'min-width: 992px' => '
					.full-width .fullwidth-slider-wrapper .thumb-overlay .thumb-content .thumb-title,
					.full-width .wide-next-prev-slider-wrapper .thumb-overlay .thumb-content .thumb-title,
					.full-width .wide-slider-with-navfor-wrapper .thumb-overlay .thumb-content .thumb-title,
					.full-width .boxed-slider-wrapper .thumb-overlay .thumb-title',
			),
			'post_medium_title_sliders' => array(
				'min-width: 992px' => '
					.has-sidebar .fullwidth-slider-wrapper .thumb-overlay .thumb-content .thumb-title,
					.has-sidebar .wide-next-prev-slider-wrapper .thumb-overlay .thumb-content .thumb-title,
					.has-sidebar .wide-slider-with-navfor-wrapper .thumb-overlay .thumb-content .thumb-title,
					.has-sidebar .boxed-slider-wrapper .thumb-overlay .thumb-title',
				'min-width: 768px' => '
					#tie-wrapper .main-slider.grid-3-slides .slide .grid-item:nth-child(1) .thumb-title,
					#tie-wrapper .main-slider.grid-5-first-big .slide .grid-item:nth-child(1) .thumb-title,
					#tie-wrapper .main-slider.grid-5-big-centerd .slide .grid-item:nth-child(1) .thumb-title,
					#tie-wrapper .main-slider.grid-4-big-first-half-second .slide .grid-item:nth-child(1) .thumb-title,
					#tie-wrapper .main-slider.grid-2-big .thumb-overlay .thumb-title,
					#tie-wrapper .wide-slider-three-slids-wrapper .thumb-title',
			),
			'post_small_title_sliders' => array(
				'min-width: 768px' => '
					#tie-wrapper .boxed-slider-three-slides-wrapper .slide .thumb-title,
					#tie-wrapper .grid-3-slides .slide .grid-item:nth-child(n+2) .thumb-title,
					#tie-wrapper .grid-5-first-big .slide .grid-item:nth-child(n+2) .thumb-title,
					#tie-wrapper .grid-5-big-centerd .slide .grid-item:nth-child(n+2) .thumb-title,
					#tie-wrapper .grid-4-big-first-half-second .slide .grid-item:nth-child(n+2) .thumb-title,
					#tie-wrapper .grid-5-in-rows .grid-item:nth-child(n) .thumb-overlay .thumb-title,
					#tie-wrapper .main-slider.grid-4-slides .thumb-overlay .thumb-title,
					#tie-wrapper .grid-6-slides .thumb-overlay .thumb-title,
					#tie-wrapper .boxed-four-taller-slider .slide .thumb-title',
			),
		);

		return apply_filters( 'Jannah/typography_default_elements_array', $text_sections );
	}
}
