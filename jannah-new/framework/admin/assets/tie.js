var $doc     = jQuery(document),
		$window  = jQuery(window);

$window.on( 'load', function() {

	jQuery('.widgets-chooser-sidebars').find('li').each(function(){
		var $thisElem = jQuery(this),
				thistext  = $thisElem.text();

		if( /^Page #\d+ - Section #\d+$/.test( thistext ) ){
			$thisElem.addClass('tie-chooser-section').hide();
		}
	});


	/* PAGE TEMPLATES OPTIONS
	------------------------------------------------------------------------------------------*/
	var $pageTemplateAttr = "select[name='page_template']";
	if( jQuery('body').hasClass('block-editor-page') ){
		$pageTemplateAttr = '.editor-page-attributes__template select';
	}

	console.log( 'Page Template Attr: '+ $pageTemplateAttr );

	var selected_item = jQuery( $pageTemplateAttr ).val();

	if ( selected_item == 'template-masonry.php' ){
		jQuery('#tie-page-template-categories').show();
	}
	else if ( selected_item == 'template-authors.php' ){
		jQuery('#tie-page-template-authors').show();
	}

	jQuery($pageTemplateAttr).change(function(){
		var selected_item = jQuery($pageTemplateAttr).val();
		jQuery('.tie-page-templates-options').hide();
		if ( selected_item == 'template-masonry.php' ){
			jQuery('#tie-page-template-categories').show();
		}
		else if ( selected_item == 'template-authors.php' ){
			jQuery('#tie-page-template-authors').show();
		}
	});


	jQuery('.option-item').find('.CodeMirror').each(function(i, el){
		el.CodeMirror.refresh();
	});

});



$doc.ready(function() {

	var $tieBody = jQuery('body');

	/* DASHBORED COLOR
	------------------------------------------------------------------------------------------ */
	var brandColor = '#d54e21';
	if( $tieBody.hasClass('admin-color-blue') ){
		brandColor = '#e1a948';
	}
	else if( $tieBody.hasClass('admin-color-coffee') ){
		brandColor = '#9ea476';
	}
	else if( $tieBody.hasClass('admin-color-ectoplasm') ){
		brandColor = '#d46f15';
	}
	else if( $tieBody.hasClass('admin-color-midnight') ){
		brandColor = '#69a8bb';
	}
	else if( $tieBody.hasClass('admin-color-ocean') ){
		brandColor = '#aa9d88';
	}
	else if( $tieBody.hasClass('admin-color-sunrise') ){
		brandColor = '#ccaf0b';
	}
	else if( $tieBody.hasClass('admin-color-bbp-evergreen') ){
		brandColor = '#56b274';
	}
	else if( $tieBody.hasClass('admin-color-bbp-mint') ){
		brandColor = '#4f6d59';
	}

	// ---
	jQuery('.tie-toggle-option').each(function(){
		var $thisElement = jQuery(this),
				elementType  = $thisElement.attr('type'),
				toggleItems  = $thisElement.data('tie-toggle');

		toggleItems  = jQuery(toggleItems).hide();

		if( elementType = 'checkbox' ){
			if($thisElement.is(':checked')){
				toggleItems.slideDown();
			};

			$thisElement.change(function(){
				toggleItems.slideToggle('fast');

				// CodeMirror
				toggleItems.find('.CodeMirror').each(function(i, el){
					el.CodeMirror.refresh();
				});

			});
		}
	});


	/**
	 * Back-end Dark Skin
	 */
	jQuery('#tiepanel-darkskin').change(function(){
		var $html    = jQuery('html'),
				switchTo = $html.hasClass('tie-darkskin') ? 'light' : 'dark';

		$html.toggleClass('tie-darkskin');

		if( 'undefined' != typeof localStorage ){
			localStorage.setItem( 'tie-backend-skin', switchTo );
		}
	});


	/* Revoke Theme License
	------------------------------------------------------------------------------------------ */
	jQuery('#revoke-tie-token').click(function(){

		var message = jQuery(this).data('message'),
				revoke  = confirm(message);

		if ( ! revoke ) {
			return false;
		}
	});



	/* Reset button message
	------------------------------------------------------------------------------------------ */
	jQuery('#tie-reset-settings').click(function(){
		var message = jQuery(this).data('message'),
				reset   = confirm(message);

		if ( ! reset ) {
			return false;
		}
	});



	/* Import theme options
	------------------------------------------------------------------------------------------ */
	jQuery('#tie-import-upload').click(function(){

		var importSettings = jQuery('#tie-import-file').val();
		if( importSettings.length > 0 ){
			return true;
		}

		return false;
	});



	/* Send Push Notifications
	------------------------------------------------------------------------------------------ */
	jQuery('#send-notification').click(function(){

		var $theParent   = jQuery( '#foxpush-create-campaign' ),
				$loadSpinner = $theParent.find('.spinner'),
				theTitle     = jQuery( '#tie_foxpush_title' ).val(),
				theMessage   = jQuery( '#tie_foxpush_msg' ).val(),
				theImage     = jQuery( '#tie_foxpush_icon' ).val(),
				thePostID    = jQuery( '#foxpush_post_id' ).val();


		// Check the requried data
		if( ! theTitle || ! theMessage ){
			alert( 'Complete all requried fields.' );
			return false;
		}
		else if( theTitle.length > 50 ){
			alert( 'Title should be max. 50 char.' );
			return false;
		}
		else if( theMessage.length > 80 ){
			alert( 'Title Messagec should be max. 50 char.' );
			return false;
		}


		// Run the Request
		jQuery.ajax({
			url : ajaxurl,
			type: 'post',
			data: {
				title  : theTitle,
				message: theMessage,
				image  : theImage,
				id     : thePostID,
				action : 'tie-foxpush-send-campaign',
			},

			beforeSend: function(data){

				// Hide the options
				jQuery( '#send-notification-options' ).hide();

				// Show the Spinner
				$loadSpinner.addClass('is-active');

			},

			success: function( data ){

				// Hide the Spinner
				$loadSpinner.removeClass('is-active');

				// Append the data
				$theParent.find('.inside').append( data );
			}
		});


		return false;
	});

	/* Send Push Notifications
	------------------------------------------------------------------------------------------ */
	jQuery('#update-campaign-status').click(function(){

		var $theParent   = jQuery( '#foxpush-get-campaigns' ),
				$loadSpinner = $theParent.find('.spinner'),
				thePostID    = jQuery( '#foxpush_post_id' ).val();

		// Run the Request
		jQuery.ajax({
			url : ajaxurl,
			type: 'post',
			data: {
				id     : thePostID,
				action : 'tie-foxpush-show-campaign',
			},

			beforeSend: function(data){

				// Hide the options
				$theParent.find('#campaigns-statistics-tables').hide();

				// Show the Spinner
				$loadSpinner.addClass('is-active');

			},

			success: function( data ){

				// Hide the Spinner
				$loadSpinner.removeClass('is-active');

				// Append the data
				$theParent.find('#campaigns-statistics-tables').html( data ).show();
			}
		});


		return false;
	});



	/* WIDGETS | CUSTOM SIDEBAR SECTIONS
	------------------------------------------------------------------------------------------ */
	if( jQuery('.widgets-php div[id*="tiepost-"]').length ){
		jQuery( '#tie-show-sections-sidebars-wrap' ).show();

		jQuery('.widgets-php div[id*="tiepost-"]').parent().addClass('tie-sidebar-section');
		jQuery('#tie-show-sections-sidebars').change(function(){
			jQuery('.tie-sidebar-section, .tie-chooser-section').toggle();
		});
	}



	/* THEME SEARCH
	------------------------------------------------------------------------------------------ */
	$searchTheme = jQuery('#theme-panel-search'),
	$searchList  = jQuery('#theme-search-list');

	$searchTheme.on('keyup', function(){
		var valThis = $searchTheme.val().toLowerCase();
		$searchList.html('');

		if( valThis == '' ){
			jQuery('.highlights-search').removeClass('highlights-search');
		}

		else{
			jQuery('.tie-label').each(function(){
				var $thisElem = jQuery(this),
						thistext  = $thisElem.text();

				if( thistext.toLowerCase().indexOf(valThis) >= 0 ){
					$thisElem.addClass('highlights-search');

					var thistextid       = $thisElem.closest('.option-item').attr('id'),
							$thisparent      = jQuery(this).closest('.tabs-wrap'),
							thistextparent   = $thisparent.find('.tie-tab-head h2').text(),
							thistextparentid = $thisparent.attr('id');

					$searchList.append( '<li><a href="#" data-section="'+ thistextid +'" data-url="'+ thistextparentid +'"><strong>' + thistextparent + '</strong> / ' + thistext + '</a></li>' );
				}
				else{
					$thisElem.removeClass('highlights-search');
				}
			});
		};
	});

	$searchList.on('click', 'a', function(){
		var $thisElem  = jQuery(this),
				tabId      = $thisElem.data('url'),
				tabsection = $thisElem.data('section');

		jQuery('.tie-panel-tabs ul li').removeClass('active');
		jQuery('.tie-panel-tabs').find('.' + tabId).addClass('active');
		jQuery('.tabs-wrap').hide();
		jQuery('#' + tabId).show();
		jQuery('html,body').unbind().animate({scrollTop: jQuery('#'+tabsection).offset().top-50},'slow');
		return false;
	});


	$doc.mouseup(function (e){
		var container = jQuery('#theme-options-search-wrap');

		if(!container.is(e.target) && container.has(e.target).length === 0){
			$searchList.html('');
			$searchTheme.val('');
			jQuery('.highlights-search').removeClass('highlights-search');
		}
	});



	/* LIVE HEADER PREVIEW
	------------------------------------------------------------------------------------------ */
	if( $tieBody.hasClass('toplevel_page_tie-theme-options') ){
		//Chnage the header layout
		var selected_val           = jQuery( "input[name='tie_options[header_layout]']:checked" ).val(),
				headerLayoutOptions    = jQuery( '#main_nav-item, .main-nav-related-options, .main-nav-components-wrapper, #header-preview .header-main-menu-wrap' ),
				headerLayout_1_Options = jQuery( '#main_nav-item, #main_nav_layout-item, #main_nav_position-item' ),
				$header_preview_area   = jQuery( '#header-preview' );
				$header_preview_wrap   = jQuery( '#header-preview-wrapper' );

		if( selected_val == 1 || selected_val == 4 ){
			headerLayoutOptions.show();
			headerLayout_1_Options.hide();
			jQuery('#full_logo-item, #header_background_color-item, #header_background_color_2-item, #header_background_img-item').hide();

			jQuery('#main_nav').attr('checked','checked');
			jQuery('#main_nav-item').find('.switchery').attr('style','border-color: rgb(0, 136, 255); box-shadow: rgb(0, 136, 255) 0px 0px 0px 13.5px inset; transition: border 0.4s, box-shadow 0.4s, background-color 1.2s; background-color: rgb(0, 136, 255);')
			jQuery('#main_nav-item').find('.switchery small').attr('style','left: 25px; transition: left 0.2s; background-color: rgb(255, 255, 255);')
			$header_preview_area.removeClass( 'main-nav-disabled' );
		}

		jQuery("input[name='tie_options[header_layout]']").change(function(){
			selected_val = jQuery( this ).val();
			if ( selected_val ) {
				$header_preview_area.removeClass( 'header-layout-1 header-layout-2 header-layout-3 header-layout-4' );
				$header_preview_area.addClass( 'header-layout-'+selected_val );

				if( selected_val == 4 ){
					$header_preview_area.addClass( 'header-layout-1' );
				}

			}

			if( selected_val == 1 || selected_val == 4 ){
				headerLayoutOptions.show();
				headerLayout_1_Options.hide();
				jQuery('#full_logo-item, #header_background_color-item, #header_background_color_2-item, #header_background_img-item').hide();

				jQuery('#main_nav').attr('checked','checked');
				jQuery('#main_nav-item').find('.switchery').attr('style','border-color: '+ brandColor +'; box-shadow: '+ brandColor +' 0px 0px 0px 0px inset; transition: border 0.4s, box-shadow 0.4s, background-color 1.2s; background-color:  '+ brandColor +';')
				jQuery('#main_nav-item').find('.switchery small').attr('style','left: 25px; transition: left 0.2s; background-color: rgb(255, 255, 255);')
				$header_preview_area.removeClass( 'main-nav-disabled' );
			}
			else{
				headerLayoutOptions.show();
				jQuery('#full_logo-item, #header_background_color-item, #header_background_color_2-item, #header_background_img-item').show();
			}

			if(! $header_preview_area.hasClass('sticky_area')){
				var preview_height = $header_preview_area.outerHeight();
				$header_preview_wrap.css({height: preview_height});
			}
		});


		jQuery("input[name='tie_options[top_nav]']").change(function(){
			$header_preview_area.toggleClass( 'top-nav-disabled' );
		});

		jQuery("input[name='tie_options[top_nav_position]']").change(function(){
			$header_preview_area.toggleClass( 'top-nav-below' );
		});

		jQuery("input[name='tie_options[top_nav_layout]']").change(function(){
			jQuery( '.top-bar-wrap' ).toggleClass( 'top-nav-full' );
		});

		jQuery("input[name='tie_options[top_nav_dark]']").change(function(){
			jQuery( '.top-bar-wrap' ).toggleClass( 'top-nav-dark-skin' );
		});


		if( jQuery("input[name='tie_options[top-nav-area-1]']").val() == 'components' || jQuery("input[name='tie_options[top-nav-area-1]']").val() == 'components' ){
			jQuery( '.top-nav-components-wrapper' ).show();
		}

		jQuery("input[name='tie_options[top-nav-area-2]']").change(function(){
			selected_val = jQuery( this ).val();
			if ( selected_val == 'components') {
				jQuery( "input[name='tie_options[top-nav-area-1]'][value='components']" ).removeAttr( 'checked' );
				jQuery( '#top-nav-components-1' ).hide();
			}else{
				if ( selected_val == 'menu') {
					jQuery( "input[name='tie_options[top-nav-area-1]'][value='menu']" ).removeAttr( 'checked' );
					jQuery( '#top-nav-menu-1' ).hide();
				}

				if( jQuery( "input[name='tie_options[top-nav-area-1]']:checked" ).val() != 'components' ){
					jQuery( '.top-nav-components-wrapper' ).hide();
				}
			}
		});

		jQuery("input[name='tie_options[top-nav-area-1]']").change(function(){
			selected_val = jQuery( this ).val();
			if ( selected_val == 'components') {
				jQuery( "input[name='tie_options[top-nav-area-2]'][value='components']" ).removeAttr( 'checked' );
				jQuery( '#top-nav-components-2' ).hide();
			}else{

				if ( selected_val == 'menu') {
					jQuery( "input[name='tie_options[top-nav-area-2]'][value='menu']" ).removeAttr( 'checked' );
					jQuery( '#top-nav-menu-2' ).hide();
				}

				if( jQuery( "input[name='tie_options[top-nav-area-2]']:checked" ).val() != 'components' ){
					jQuery( '.top-nav-components-wrapper' ).hide();
				}
			}
		});

		jQuery("input[name='tie_options[main_nav]']").change(function(){
			$header_preview_area.toggleClass( 'main-nav-disabled' );
		});

		jQuery("input[name='tie_options[main_nav_position]']").change(function(){
			$header_preview_area.toggleClass( 'main-nav-above' );
		});

		jQuery("input[name='tie_options[main_nav_layout]']").change(function(){
			jQuery( '.header-main-menu-wrap' ).toggleClass( 'main-nav-full' );
		});

		jQuery("input[name='tie_options[main_nav_dark]']").change(function(){
			jQuery( '.header-main-menu-wrap' ).toggleClass( 'main-nav-dark-skin' );
		});

		//Top and Main Nav settings
		$doc.on( 'click', '.header-settings-tabs a', function(){
			var targetedTab = jQuery( this ).attr( 'href' );
			jQuery( this ).parent().find( 'a' ).removeClass( 'active' );
			jQuery( this ).addClass( 'active' );
			jQuery( '.top-main-nav-settings' ).hide();
			jQuery( targetedTab ).fadeIn();
			return false;
		});


		/* Sticky options header */
		stickyNav = function(){
			if( jQuery( '#tie-options-tab-header' ).is( ':visible' ) ){

				var stickyNavTop   = $header_preview_wrap.offset().top,
						preview_height = $header_preview_area.outerHeight(),
						preview_width  = jQuery('#tie_form').width(),
						scrollTop      = $window.scrollTop();

				if ( scrollTop > stickyNavTop - 32) {
					$header_preview_area.addClass('sticky_area').css({width: preview_width});
					$header_preview_wrap.css({height: preview_height});
				}
				else{
					$header_preview_area.removeClass('sticky_area').removeAttr('style');
				}
			}
		};


		/* Stikcy Bottom Save Button */
		var lastScrollTop    = 0,
				$topSaveButton    = jQuery('.tie-panel-content'),
				$bottomSaveButton = jQuery('.tie-footer .tie-save-button');

		stickySaveButton = function(){
			var topSaveOffset = $topSaveButton.offset().top,
					scrollTop     = $window.scrollTop(),
					scrollBottom  = $doc.height() - scrollTop - $window.height(),
					st            = scrollTop;

			if ( scrollTop > topSaveOffset && scrollBottom > 105 - $bottomSaveButton.height()) {
				if(st > lastScrollTop){
					$bottomSaveButton.addClass('sticky-on-down').removeClass('sticky-on-up');

					if(scrollTop > topSaveOffset){
						$bottomSaveButton.addClass('sticky-on-down-appear').removeClass('sticky-on-up-disappear');
					}
				}
				else{
					$bottomSaveButton.addClass('sticky-on-up').removeClass('sticky-on-down');

					if (scrollTop < topSaveOffset){
						$bottomSaveButton.addClass('sticky-on-up-disappear').removeClass('sticky-on-up-appear');
					}
				}
			}
			else{
				$bottomSaveButton.removeClass('sticky-on-down sticky-on-up sticky-on-down-appear sticky-on-up-disappear');
			}

			lastScrollTop = st;
		}


		stickyNav();
		stickySaveButton();

		$window.scroll(function(){
			stickyNav();
			stickySaveButton();
		});
	}


	/* PAGE BUILDER
	------------------------------------------------------------------------------------------ */
	/* Assign a Class to the builder depending on the Image Style */
	$doc.on('click', '#tie-builder-wrapper .tie-options label', function(){
		var $thisBlock  = jQuery( this ),
				$thisImg    = $thisBlock.find( 'img' ),
				$thisParent = $thisBlock.closest( '.block-item' ),
				blockClass  = $thisImg.attr( 'class' ) + '-container';
				imgPath     = $thisImg.attr( 'src' ),
				postsNumber = $thisImg.data( 'number' );

		if( postsNumber ){
			$thisParent.find( '.block-number-item-options input' ).val( postsNumber );
		}

		$thisParent.attr( 'class', 'block-item parent-item ' + blockClass );
		$thisParent.find('.block-small-img').attr( 'src', imgPath );
	});

	/* Blocks Color Picker */
	var tieBlocksColorsOptions = {
		change: function(event, ui){
			var newColor = ui.color.toString();

			if( jQuery(this).closest( '.option-item' ).hasClass('block-color-item-options') ){
				jQuery(this).closest( '.block-item' ).find( '.tie-block-head' ).attr('style', 'background-color: '+newColor ).removeClass( 'block-head-light block-head-dark' ).addClass( 'block-head-'+getContrastColor( newColor ) );
			}
		},
		clear: function() {
			if( jQuery(this).closest( '.option-item' ).hasClass('block-color-item-options') ){
				jQuery(this).closest( '.block-item' ).find( '.tie-block-head' ).attr('style', '').removeClass( 'block-head-light block-head-dark' );
			}
		}
	};

	if( jQuery().wpColorPicker /*&& 'undefined' == typeof monsterinsights_admin_common*/ ){
		jQuery('.tieBlocksColor').wpColorPicker( tieBlocksColorsOptions );
	}


	/* Enable/Disable the Builder For the page */
	jQuery('#tie-page-builder-button').click( function() {

		$tieBody.toggleClass('builder-is-active');
		jQuery( '#tie-page-builder' ).attr( 'style', '' );

		var tabsHeight = jQuery('.tie-panel-tabs').outerHeight();
		jQuery('.tie-panel-content').css({minHeight: tabsHeight});

		var $pageBuilderButton = jQuery(this);

		if( $pageBuilderButton.hasClass( 'builder_active' ) ){
			$pageBuilderButton.addClass('button-primary').removeClass( 'builder_active button-secondary' ).html($pageBuilderButton.data('editor'));
			jQuery( '#tie_builder_active' ).val( '' );
			pagePosition = $tieBody.scrollTop();
			jQuery( 'html, body' ).scrollTop( pagePosition + 1 );
		}
		else{
			$pageBuilderButton.addClass( 'builder_active button-secondary' ).removeClass('button-primary').html($pageBuilderButton.data('builder'));

			jQuery( '#tie_builder_active' ).val( 'yes' );

			jQuery('.tabs-wrap').hide();
			jQuery('.tie-panel-tabs ul li').removeClass('active');

			jQuery('.tie-panel-tabs ul li:first').addClass('active').show();
			jQuery('.tabs-wrap:first').show();

			//Page templates
			//jQuery( '#page_template option:first-child' ).attr('selected','selected');
		}
		return false;
	});

	/* If Builder Active hide boxes */
	if ( jQuery('#tie_builder_active').val() == 'yes') {
		$tieBody.addClass('builder-is-active');
	}

	/* Add a new block button */
	$doc.on( 'click', '.tie-add-new-block', function(){

		var $thisButton  = jQuery(this),
				$loadSpinner = $thisButton.closest('.tie-builder-container').find( '.tie-loading-container' ).addClass( 'is-animated' ).show(),
				sectionID    = $thisButton.data('section'),
				blockID      = tie_block_id;
				uniqueID     = sectionID + '-' + blockID;

		jQuery.post(
			ajaxurl,
			{
				action:'tie_get_builder_blocks',
				block_id: blockID,
				section_id: sectionID,
			},
			function(data) {

				var content = jQuery( data );
				content.find('.tabs_cats').sortable({placeholder: 'tie-state-highlight'});

				content.appendTo( '#cat_sortable_'+sectionID );

				content.find('.tie-img-path').each(function(){
					tie_image_uploader_trigger( jQuery(this) );
				});

				tie_builder_dragdrop();

				// Disable the Sortable and Draggable if the PopUp is open
				jQuery( '#tie-builder-wrapper, .tie-builder-blocks-wrapper' ).sortable('disable');
				jQuery( '.block-item' ).draggable('disable');
				// ----

				var addedBlock = jQuery( '#listItem_'+ uniqueID );

				//addedBlock.hide().fadeIn();
				addedBlock.find( '.tie-builder-content-area, .toggle-close' ).show();
				addedBlock.find( '.toggle-open' ).hide();

				//if( 'undefined' == typeof monsterinsights_admin_common ){
					addedBlock.find( '.tieBlocksColor' ).wpColorPicker( tieBlocksColorsOptions );
				//}

				$tieBody.addClass('has-overlay');

				// Switch Button
				var $blockSwitches = addedBlock.find( '.tie-js-switch' );
				$blockSwitches.each(function(){

					new Switchery( this,{ color: brandColor } );

					var $thisElement = jQuery(this),
							elementType  = $thisElement.attr('type'),
							toggleItems  = $thisElement.data('tie-toggle');

					toggleItems = jQuery(toggleItems).hide();

					if( elementType = 'checkbox' ){
						if($thisElement.is(':checked')){
							toggleItems.slideDown();
						};

						$thisElement.change(function(){
							toggleItems.slideToggle('fast');
						});
					}

				});


				$thisButton.show();

				$loadSpinner.removeClass( 'is-animated' ).hide();

				// Classic Editor
				var defaultEditorID = 'content';
				// Gutenberg
				if (_.isUndefined(tinyMCEPreInit.qtInit['content'])) {
					defaultEditorID = 'tie_dummy_editor';
				}

				var wpEditorID = 'block-' + uniqueID +'-custom_content';

				delete window.tinyMCEPreInit.mceInit[wpEditorID];
				delete window.tinyMCEPreInit.qtInit[wpEditorID];

				window.tinyMCEPreInit.mceInit[wpEditorID] = _.extend({}, tinyMCEPreInit.mceInit[ defaultEditorID ], {resize: 'vertical', height: 400});

				if (_.isUndefined(tinyMCEPreInit.qtInit[wpEditorID])) {
					window.tinyMCEPreInit.qtInit[wpEditorID] = _.extend({}, tinyMCEPreInit.qtInit['replycontent'], {id: wpEditorID})
				}

				qt = quicktags(window.tinyMCEPreInit.qtInit[wpEditorID]);
				QTags._buttonsInit();
				window.switchEditors.go( wpEditorID, 'tmce' );
				tinymce.execCommand( 'mceRemoveEditor', true, wpEditorID );
				tinymce.execCommand( 'mceAddEditor', true, wpEditorID );

				tie_block_id++;

			}, 'html');


		return false;
	});


	/* Manage Widgets button */
	$widgetsCustomizer   = jQuery('#tie-sidebars-customize');
	$customWidgetsHolder = jQuery('#custom-widgtes-settings');

	$doc.on( 'click', '.tie-manage-widgets', function(){

		var $thisButton     = jQuery(this),
				sectionID       = $thisButton.data('widgets'),
				$sidebarOptions = jQuery('#' + sectionID + '-sidebar-options'),
				$widgetsToggle  = $sidebarOptions.find('.tie-toggle-option');

		// Hide
		$widgetsCustomizer.find('#widgets-right .widgets-holder-wrap, .sections-sidebars-options').hide();
		$customWidgetsHolder.hide()

		// Show
		$tieBody.addClass('has-overlay');
		$widgetsCustomizer.show();
		$sidebarOptions.show();
		jQuery('#wrap-' + sectionID).removeClass('closed').show();


		if( ! $widgetsToggle.is(':checked') ){
			$customWidgetsHolder.show();
		};

		return false;
	});

	$widgetsCustomizer.find('.tie-toggle-option').change(function(){
		$customWidgetsHolder.toggle();
	});



	/* Add a new section button */
	$doc.on( 'click', '.tie-add-new-section', function(){

		var $thisButton  = jQuery(this).hide(),
				sectionID    = $thisButton.data('sections'),
				postID       = $thisButton.data('post'),
				$loadSpinner = $thisButton.closest('.tie-add-new-section-wrapper').find( '.tie-loading-container' ).addClass( 'is-animated' ).show();


		jQuery.post(
			ajaxurl,
			{
				action:'tie_get_builder_section',
				section_id: sectionID,
				post_id: postID
			},
			function(data) {
				var sectionUnique = 'section-' + Math.floor(Math.random() * 10000),
						content = data.replace( /tiexyz20/g, sectionUnique );

				content = jQuery( content );
				content.appendTo( '#tie-builder-wrapper' );

				tie_builder_dragdrop();

				// Disable the Sortable and Draggable if the PopUp is open
				jQuery( '#tie-builder-wrapper, .tie-builder-blocks-wrapper' ).sortable('disable');
				jQuery( '.block-item' ).draggable('disable');
				// ----

				content.find('.tie-img-path').each(function(){
					tie_image_uploader_trigger( jQuery(this) );
				});

				$tieBody.addClass('has-overlay');

				content.find( '.tie-builder-content-area' ).show();

				var $blockSwitches = content.find( '.tie-js-switch' );
				$blockSwitches.each(function(){
					new Switchery( this,{ color: brandColor } );


					var $thisElement = jQuery(this),
							elementType  = $thisElement.attr('type'),
							toggleItems  = $thisElement.data('tie-toggle');

					toggleItems  = jQuery(toggleItems).hide();

					if( elementType = 'checkbox' ){
						if($thisElement.is(':checked')){
							toggleItems.slideDown();
						};

						$thisElement.change(function(){
							toggleItems.slideToggle('fast');
						});
					}
				});

				//if( 'undefined' == typeof monsterinsights_admin_common ){
					content.find( '.tieColorSelector' ).wpColorPicker( tieBlocksColorsOptions );
				//}

				content.find( '.sections-sidebars-options' ).appendTo('#section-sidebar-options').find('.tie-toggle-option').change(function(){
					jQuery('#custom-widgtes-settings').toggle();
				});

				content.find( '.sections-sidebars-options' ).remove();

				$thisButton.show();
				$loadSpinner.removeClass( 'is-animated' ).hide();

				jQuery('#widgets-right').append('\
					<div id="wrap-tiepost-'+ postID + '-' + sectionUnique +'"class="widgets-holder-wrap">\
						<div id="tiepost-'+ postID + '-' + sectionUnique +'" class="widgets-sortables">\
							<div class="sidebar-name">\
								<div class="sidebar-name-arrow"><br></div>\
								<h3>Section Widgets Area<span class="spinner"></span></h3>\
							</div>\
						</div>\
					</div>\
				');

				$thisButton.data( 'sections', sectionID+1 );

				wpPWidgets.refresh();

			}, 'html');

		return false;
	});



	/* Section Sidebar */
	$doc.on( 'click', '.tie-section-sidebar-options label', function(){

		var $thisElement = jQuery(this),
				$theSection  = $thisElement.closest('.tie-builder-container');
				$inputField  = $thisElement.closest('li').find('input');
				inputValue   = $inputField.val();

		$theSection.removeClass('sidebar-right sidebar-left sidebar-full');
		$theSection.addClass( 'sidebar-'+inputValue );
	});

	/* Close Options popup with esc  */
	$doc.keyup(function(event){
		if ( event.which == '27' && ( $tieBody.hasClass('builder-is-active') || $tieBody.hasClass('tietheme_page_tie-one-click-demo-import') ) ){

			if( $tieBody.hasClass( 'force-refresh' ) ){
				location.reload();
			}

			$tieBody.removeClass('has-overlay');
			jQuery('.tie-popup-window').hide();

			// Enable the Sortable and Draggable when the PopUp closed
			if ( $tieBody.hasClass('builder-is-active') ){
				jQuery( '#tie-builder-wrapper, .tie-builder-blocks-wrapper' ).sortable('enable');
				jQuery( '.block-item' ).draggable('enable');
			}
			// ----
		}
	});

	/* Edit Block Done Button */
	$doc.on( 'click', '.builder-is-active #tie-page-overlay, #tie-page-overlay.is-notice-dismissible, .tietheme_page_tie-one-click-demo-import #tie-page-overlay, .tie-popup-window .close, .tie-edit-block-done', function(){

		// Dismiss the notice
		if( jQuery( this ).hasClass( 'is-notice-dismissible' ) ){
			var noticeID = jQuery( this ).data('id');

			jQuery.ajax({
				url : ajaxurl,
				type: 'post',
				data: {
					pointer: noticeID,
					action : 'dismiss-wp-pointer',
				},
			});

			jQuery( this ).hide();
		}


		// Force Refresh
		if( $tieBody.hasClass( 'force-refresh' ) ){
			location.reload();
		}

		$tieBody.removeClass('has-overlay');
		jQuery('.tie-popup-window').hide();

		// Enable the Sortable and Draggable when the PopUp closed
		if ( $tieBody.hasClass('builder-is-active') ){
			jQuery( '#tie-builder-wrapper, .tie-builder-blocks-wrapper' ).sortable('enable');
			jQuery( '.block-item' ).draggable('enable');
		}
		// ----

		return false;
	});

	/* Toggle open/Close */
	$doc.on('click', '.toggle-section', function(){
		var $thisElement = jQuery(this).closest('.tie-builder-container');
		$thisElement.find('.tie-builder-section-inner').slideToggle('fast');
		$thisElement.toggleClass('tie-section-open');
		return false;
	});

	/* Chnage the Block Title */
	$doc.on( 'keyup', '.block-title-item-options input', function(){
		var NewTitleText = jQuery( this ).val();
		jQuery( this ).parents( '.block-item' ).find( '.block-preview-title' ).text( NewTitleText );
	});

	/* Edit Block/Section */
	$doc.on('click', '.edit-block-icon', function(){
		var $thisElement = jQuery(this).closest('.parent-item');
		$tieBody.addClass('has-overlay');
		$thisElement.find('> .tie-builder-content-area').fadeIn('fast');

		// Disable the Sortable and Draggable if the PopUp is open
		jQuery( '#tie-builder-wrapper, .tie-builder-blocks-wrapper' ).sortable('disable');
		jQuery( '.block-item' ).draggable('disable');
		// ----

		return false;
	});

	/* Block Settings */
	$doc.on( 'click', '.blocks-settings-tabs a', function(){
		var $thisButtonTab = jQuery(this),
				$blockContent  = $thisButtonTab.closest('.tie-builder-content-area'),
				targetTab      = $thisButtonTab.data('target');

		$thisButtonTab.parent().find('a').removeClass( 'active' );
		$thisButtonTab.addClass('active');

		$blockContent.find('.block-settings').hide();
		$blockContent.find('.'+ targetTab).show();

		return false;
	});

	/* Assign a Class to the slider depending on the Image Style */
	$doc.on('click', '#tie_featured_posts_style a', function(){
		var sliderClass = jQuery( this ).find( 'img' ).attr( 'class' ) + '-container';
		jQuery( '#main-slider-options' ).attr( 'class', sliderClass );
		return false;
	});

	/* Categories Tabs box */
	jQuery( '.tabs_cats input:checked' ).parent().addClass('selected');
	$doc.on( 'click', '.tabs_cats span', function( event ){
		var $thisTab = jQuery(this).parent();

		if( $thisTab.find(':checkbox').is(':checked') ){
			event.preventDefault();
			$thisTab.removeClass('selected');
			$thisTab.find(':checkbox').removeAttr('checked');
		}else{
			$thisTab.addClass('selected');
			$thisTab.find(':checkbox').attr('checked','checked');
		}
	});



	/* Misc
	------------------------------------------------------------------------------------------ */
	/* COLOR PICKER */
	if( jQuery().wpColorPicker ){
		tie_color_picker();
	}


	/* PAGE BUILDER SRAG AND DROP */
	tie_builder_dragdrop();


	/* IMAGE UPLOADER PREVIEW */
	jQuery('.tie-img-path').each(function(){
		tie_image_uploader_trigger( jQuery(this) );
	});


	/* Font Uploader */
	jQuery('.tie-font-path').each(function(){
		tie_set_font_uploader( jQuery(this) );
	});


	/* FONTS */
	jQuery( '.tie-select-font' ).fontselect();


	/* CHECKBOXES */
	var checkInputs = Array.prototype.slice.call(document.querySelectorAll('.tie-js-switch'));
	checkInputs.forEach(function(html) {
		new Switchery( html,{ color: brandColor });
	});


	/* MAIN MENU UPDATES NOTIFICATION */
	if( jQuery( 'li.menu-top.toplevel_page_tie-theme-options .tie-theme-update' ).length ){
		jQuery( 'li.menu-top.toplevel_page_tie-theme-options .wp-menu-name' ).append( ' <span class="update-plugins"><span class="update-count">'+tieLang.update+'</span></span>' );
	}



/* Widgets
	------------------------------------------------------------------------------------------ */
	if( $tieBody.hasClass('widgets-php') || $tieBody.hasClass('nav-menus-php') || $tieBody.hasClass('post-type-page') ){
		$doc.ajaxComplete(function() {
			//if( 'undefined' == typeof monsterinsights_admin_common ){
				jQuery('.tieColorSelector').wpColorPicker();
			//}
		});
	}

	/* Widget Tabs Sortable  */
	jQuery('.tab-sortable').each(function(){
		tie_sortable_tabs_trigger( jQuery(this) );
	});

	/* Widget Posts order option  */
	jQuery('.tie-posts-order-option').each(function(){
		tie_widget_posts_order( jQuery(this) );
	});

	/* Trigger when Widget Added */
	$doc.on( 'widget-added', function( event, widgetContainer ) {

		var $thisTabs = widgetContainer.find('.tab-sortable');
		tie_sortable_tabs_trigger( $thisTabs );

		// ------
		var $thisOption = widgetContainer.find('.tie-posts-order-option');
		tie_widget_posts_order( $thisOption );
	});

	/* Trigger when Widget Updated */
	$doc.on( 'widget-updated', function( event, widgetContainer ) {

		var $thisTabs = widgetContainer.find('.tab-sortable');
		tie_sortable_tabs_trigger( $thisTabs );

		// ------
		var $thisOption = widgetContainer.find('.tie-posts-order-option');
		tie_widget_posts_order( $thisOption );
	});



	/* DISMISS NOTICES
	------------------------------------------------------------------------------------------ */
	$doc.on('click', '.tie-notice .notice-dismiss', function(){

		jQuery( '#tie-page-overlay' ).hide();

		jQuery.ajax({
			url : ajaxurl,
			type: 'post',
			data: {
				pointer: jQuery(this).closest('.tie-notice').attr('id'),
				action : 'dismiss-wp-pointer',
			},
		});
	});



	/* SAVE THEME SETTINGS
	------------------------------------------------------------------------------------------ */
	var $saveAlert = jQuery( '#tie-saving-settings' );

	jQuery('#tie_form').submit(function() {

		// Check if the import field has a file
		var importSettings = jQuery('#tie-import-file').val();
		if( importSettings.length > 0 ){
			return true;
		}

		// Disable all blank fields to reduce the size of the data
		jQuery('form#tie_form input, form#tie_form textarea, form#tie_form select').each(function(){
			if( ! jQuery(this).val() ){
				jQuery(this).attr( 'disabled', true );
			}
		});

		// Do an action after saving settings
		var hasAction = false;
		if( jQuery('#tie-connect-instagram-link').length && jQuery('#tie-connect-instagram-link').val().length > 1 ){
			hasAction = jQuery('#tie-connect-instagram-link').val();
		}

		// Serialize the data array
		var data = jQuery(this).serialize().replace( /%3C/g, '%3Ctie-open-tag' ); //issue in saving any code with meta tag on some servers

		// Re-activate the disabled options
		jQuery('form#tie_form input:disabled, form#tie_form textarea:disabled, form#tie_form select:disabled').attr( 'disabled', false );

		// Add the Overlay layer and reset the saving spinner
		$tieBody.addClass('has-overlay');
		$saveAlert.removeClass('is-success is-failed');

		// Send the Saving Ajax request
		jQuery.ajax({
			url : ajaxurl,
			type: 'post',
			data: data,

			error: function( xhr, status, error ){
				if( 'undefined' != typeof xhr.status && xhr.status != 200 ){
					$saveAlert.addClass('is-failed').delay(900);
					$saveAlert.append('<div class="tie-error-message">It seems the saving process has been blocked by your server, try again, if this issue continued <a href="https://tielabs.com/go/jannah-save-error" target="_blank">check this article</a></div>');
				}
			},

			success: function( response ){

				if( hasAction ){
					window.location.replace( hasAction );
				}
				else{

					if( response == 1 ){
						$saveAlert.addClass('is-success').delay(900).fadeOut(700);
						setTimeout(function() { $tieBody.removeClass('has-overlay'); },1200);
					}
					else if( response == 2 ){
						location.reload();
					}
					else {
						$saveAlert.addClass('is-failed').delay(900).fadeOut(700);
						setTimeout(function() { $tieBody.removeClass('has-overlay'); },1200);
					}
				}

			}
		});

		/*
		jQuery.post(
			ajaxurl,
			data,
			function( response ){
				if( hasAction ){
					window.location.replace( hasAction );
				}
				else{
					if( response == 1 ){
						$saveAlert.addClass('is-success').delay(900).fadeOut(700);
						setTimeout(function() { $tieBody.removeClass('has-overlay'); },1200);
					}
					else if( response == 2 ){
						location.reload();
					}
					else {
						$saveAlert.addClass('is-failed').delay(900).fadeOut(700);
						setTimeout(function() { $tieBody.removeClass('has-overlay'); },1200);
					}
				}
			});
			*/

			return false;
	});


	/* SAVE SETTINGS ALERT */
	$saveAlert.fadeOut();
	jQuery('.tie-save-button').click( function() {
		if( ! jQuery(this).hasClass('tie-has-custom-action') ){
			$saveAlert.fadeIn();
		}
	});


	/* Instagram Connect */
	jQuery('#tie-connect-instagram').click( function() {
		jQuery('#tie-connect-instagram-link').val( jQuery(this).attr('href') );
		$saveAlert.fadeIn();
		jQuery('#tie_form').submit();
		return false;
	});


	/* THEME PANEL
	------------------------------------------------------------------------------------------ */
	jQuery('.tie-panel, .tie-notice').css({ 'opacity':1, 'visibility':'visible'});

	var tabsHeight = jQuery('.tie-panel-tabs').outerHeight();
	jQuery('.tabs-wrap').hide();
	jQuery('.tie-panel-tabs ul li:first').addClass('active').show();
	jQuery('.tabs-wrap:first').show();
	jQuery('.tie-panel-content').css({minHeight: tabsHeight});

	jQuery('li.tie-tabs:not(.tie-not-tab)').click(function() {
		jQuery('.tie-panel-tabs ul li').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.tabs-wrap').hide();
		var activeTab = jQuery(this).find('a').attr('href');
		jQuery(activeTab).show();
		document.location.hash = activeTab + '-target';

		//jQuery('html, body').animate({scrollTop: jQuery("#tie_form").offset().top - 50 }, 200);

		// CodeMirror
		jQuery(activeTab).find('.CodeMirror').each(function(i, el){
			el.CodeMirror.refresh();
		});

		return false;
	});

	/* GO TO THE OPENED TAB WITH LOAD */
	var currentTab = window.location.hash.replace( '-target', '' );
			currentTab = currentTab.replace( /\//g, '' ); // avoid issues when the URL contains something like #/campaign/0/contacts

	if( jQuery(currentTab).parent( '#tie_form' ).length ){
		var tabLinkClass = currentTab.replace( '#', '.' );
		jQuery('.tabs-wrap').hide();
		jQuery('.tie-panel-tabs ul li').removeClass('active');
		jQuery( currentTab ).show();
		jQuery( tabLinkClass ).addClass( 'active' );
	}



	/* DELETE SECTIONS
	------------------------------------------------------------------------------------------ */
	/* OPTION ITEM */
	$doc.on('click', '.del-item', function(){
		var $thisButton = jQuery(this);

		if( $thisButton.hasClass('del-custom-sidebar') ){
			var option = $thisButton.parent().find('input').val();
			jQuery('#custom-sidebars select').find('option[value="'+option+'"]').remove();
			jQuery('#sidebar_bbpress-item select').find('option[value="'+option+'"]').remove();
		}

		if( $thisButton.hasClass('del-section') ){
			var widgets = $thisButton.closest('.parent-item').find('.tie-manage-widgets').data('widgets');
			jQuery( '#wrap-' + widgets + ', #' + widgets + '-sidebar-options' ).remove();
		}

		$thisButton.closest('.parent-item').addClass('removed').fadeOut(function() {
			$thisButton.closest('.parent-item').remove();
		});

		return false;
	});

	/* DELETE PREVIEW IMAGE */
	$doc.on('click', '.del-img', function(){
		var $img = jQuery(this).parent();
		$img.fadeOut( 'fast',function() {
			$img.hide();
			$img.closest('.option-item').find('.tie-img-path').val('');
		});
	});

	/* DELETE PREVIEW IMAGE */
	$doc.on('click', '.del-img-all', function(){
		var $imgLi = jQuery(this).closest('li');
		$imgLi.fadeOut( 'fast', function() {
			$imgLi.remove();
		});
	});



	/* CUSTOM BREAKING NEWS TEXT
	------------------------------------------------------------------------------------------ */
	jQuery( '#breaking_news_button' ).click(function() {
		var customlink = jQuery('#custom_link').val(),
				customtext = tieHTMLspecialchars( jQuery('#custom_text').val() );

		if( customtext.length > 0 && customlink.length > 0  ){
			jQuery( '#breaking_custom_error-item' ).slideUp();
			jQuery( '#customList' ).append( '\
				<li class="parent-item">\
					<div class="tie-block-head">\
						<a href="'+customlink+'" target="_blank">'+customtext+'</a>\
						<input name="tie_options[breaking_custom]['+customnext+'][link]" type="hidden" value="'+customlink+'" />\
						<input name="tie_options[breaking_custom]['+customnext+'][text]" type="hidden" value="'+customtext+'" />\
						<a class="del-item dashicons dashicons-trash"></a>\
					</div>\
				</li>\
			');
		}
		else{
			jQuery( '#breaking_custom_error-item' ).fadeIn();
		}

		customnext ++;
		jQuery( '#custom_link, #custom_text' ).val('');
	});



	/* ADD HIGHLIGHTS
	------------------------------------------------------------------------------------------ */
	jQuery( '#add_highlights_button' ).click(function() {
		var customtext = tieHTMLspecialchars( jQuery( '#custom_text' ).val() );
		if( customtext.length > 0 ){
			jQuery( '#highlights_custom_error-item' ).slideUp();
			jQuery( '#customList' ).append( '\
				<li class="parent-item">\
					<div class="tie-block-head">\
						'+customtext+'\
						<input name="tie_highlights_text['+customnext+']" type="hidden" value="'+ customtext +'" />\
						<a class="del-item dashicons dashicons-trash"></a>\
					</div>\
				</li>\
			');
		}
		else{
			jQuery( '#highlights_custom_error-item' ).fadeIn();
		}

		customnext ++;
		jQuery( '#custom_text' ).val('');
	});



	/* ADD Sources
	------------------------------------------------------------------------------------------ */
	jQuery( '#add_source_button' ).click(function() {
		var source_name = tieHTMLspecialchars( jQuery('#source_name').val() ),
				source_link = jQuery('#source_link').val();

		if( source_name.length > 0 ){
			jQuery( '#add-source-error-item' ).slideUp();

			var source_code = '\
				<li class="parent-item">\
					<div class="tie-block-head">';

					if( source_link.length > 0 ){
						source_code += '\
							<a href="'+source_link+'" target="_blank">'+source_name+'</a>\
							<input name="tie_source['+source_next+'][url]" type="hidden" value="'+source_link+'" />\
						';
					}
					else{
						source_code += source_name;
					}

					source_code += '\
						<input name="tie_source['+source_next+'][text]" type="hidden" value="'+source_name+'" />\
						<a class="del-item dashicons dashicons-trash"></a>\
					</div>\
				</li>\
			';

			jQuery( '#sources-list' ).append( source_code );
		}
		else{
			jQuery( '#add-source-error-item' ).fadeIn();
		}

		source_next ++;
		jQuery( '#source_link, #source_name' ).val('');
	});



	/* ADD Via
	------------------------------------------------------------------------------------------ */
	jQuery( '#add_via_button' ).click(function() {
		var via_name = tieHTMLspecialchars( jQuery('#via_name').val() ),
				via_link = jQuery('#via_link').val();

		if( via_name.length > 0 ){

			jQuery( '#add-via-error-item' ).slideUp();

			var via_code = '\
				<li class="parent-item">\
					<div class="tie-block-head">';

					if( via_link.length > 0 ){
						via_code += '\
							<a href="'+via_link+'" target="_blank">'+via_name+'</a>\
							<input name="tie_via['+via_next+'][url]" type="hidden" value="'+via_link+'" />\
						';
					}
					else{
						via_code += via_name;
					}

					via_code += '\
						<input name="tie_via['+via_next+'][text]" type="hidden" value="'+via_name+'" />\
						<a class="del-item dashicons dashicons-trash"></a>\
					</div>\
				</li>\
			';

			jQuery( '#via-list' ).append( via_code );
		}
		else{
			jQuery( '#add-via-error-item' ).fadeIn();
		}

		via_next ++;
		jQuery( '#via_link, #via_name' ).val('');
	});



	/* CUSTOM SIDEBARS
	------------------------------------------------------------------------------------------ */
	jQuery( '#sidebarAdd' ).click(function() {
		var SidebarName = jQuery( '#sidebarName' ).val();

		if( SidebarName.length > 0 ){
			jQuery( '#custom_sidebar_error-item' ).slideUp();
			jQuery('#sidebarsList').append( '\
				<li class="parent-item">\
					<div class="tie-block-head">\
						'+SidebarName+'\
						<input id="tie_sidebars" name="tie_options[sidebars][]" type="hidden" value="'+SidebarName+'" />\
						<a class="del-custom-sidebar del-item dashicons dashicons-trash"></a>\
					</div>\
				</li>\
			');
			jQuery( '#custom-sidebars select' ).append('<option value="'+SidebarName+'">'+SidebarName+'</option>');
			jQuery( '#sidebar_bbpress-item select' ).append('<option value="'+SidebarName+'">'+SidebarName+'</option>');
		}else{
			jQuery( '#custom_sidebar_error-item' ).fadeIn();
		}

		jQuery( '#sidebarName' ).val('');
	});



	/* VISUAL OPTIONS
	------------------------------------------------------------------------------------------ */

	jQuery('ul.tie-options').each(function( index ) {
		jQuery(this).find('input:checked').closest('li').addClass('selected');
	});

	$doc.on('click', 'ul.tie-options label', function(){
		var $thisBlock = jQuery(this),
				blockID = $thisBlock.closest('ul.tie-options').attr('id');

		jQuery( '#' + blockID ).find( 'li' ).removeClass('selected');
		//jQuery( '#' + blockID ).find(':radio').removeAttr('checked');
		$thisBlock.parent().addClass('selected');
		//$thisBlock.parent().find(':radio').attr('checked','checked');
		//return false;
	});




	/* SLIDERS - Category Options
	------------------------------------------------------------------------------------------ */
	// Show/hide slider and video playlist options

	if( $tieBody.hasClass('taxonomy-category') ){

		var $featured_posts_options  = jQuery( '.featured-posts-options' ).hide(),
				$featured_videos_options = jQuery( '.featured-videos-options' ).hide();

		selected_val = jQuery( '.visual-option-videos_list' ).find( 'input:checked' ).val();

		if( selected_val == 'videos_list' ){
			$featured_videos_options.show();
		}else{
			$featured_posts_options.show();
		}

		$doc.on('click', '#tie_featured_posts_style a', function(){
			var selected_val = jQuery( this ).closest( 'li' ).find( 'input' ).val();

			if( selected_val == 'videos_list' ){
				$featured_posts_options.hide();
				$featured_videos_options.show();
			}else{
				$featured_videos_options.hide();
				$featured_posts_options.show();
			}
		});
	}



	/* PREDEFINED SKINS
	------------------------------------------------------------------------------------------ */
	jQuery('.predefined-skins-options select').change(function(){
		var skin = jQuery(this).val(),
				skin_colors = tie_skins[skin];

		jQuery( '#tie-options-tab-styling' ).find('.tieColorSelector').val('');
		jQuery( '#tie-options-tab-styling' ).find('.wp-color-result').attr( 'style', '' );

		for ( var key in skin_colors ) {
			if (skin_colors.hasOwnProperty(key)) {
				//if( 'undefined' == typeof monsterinsights_admin_common ){
					jQuery( '#'+key ).wpColorPicker( 'color', skin_colors[key] );
				//}
			}
		}
	});

});



/* Fire Sortable on the Widgets Tabs
------------------------------------------------------------------------------------------ */
function tie_sortable_tabs_trigger( $thisTabs ){

	$thisTabs.sortable({
		placeholder: 'tie-state-highlight',

		stop: function(event, ui){
			var data = '';

			$thisTabs.find('li').each(function(){
				var type = jQuery(this).data('tab');
				data += type + ',';
			});

			$thisTabs.parent().find('.stored-tabs-order').val( data.slice(0, -1) );
		}
	});
}



/* Fire Sortable on the Widgets Tabs
------------------------------------------------------------------------------------------ */
function tie_widget_posts_order( $thisElement ){

	$thisElement.change(function(){

		var $thisElement      = jQuery(this),
				jetPackOption     = $thisElement.closest('.widget-content').find('.tie-jetpack-posts-order-option'),
				relatedOption     = $thisElement.closest('.widget-content').find('.tie-related-posts-order-option'),
				NoneCustomOptions = $thisElement.closest('.widget-content').find('.tie-non-custom-posts-order-option'),
				theOptionsValue   = $thisElement.find('option:selected').val();

		if( theOptionsValue.indexOf('jetpack') >= 0 ){
			jetPackOption.show();

			NoneCustomOptions.hide();
			relatedOption.hide();
		}
		else if( theOptionsValue.indexOf('related') >= 0 ){
			relatedOption.show();

			NoneCustomOptions.hide();
			jetPackOption.hide();
		}
		else{
			NoneCustomOptions.show();

			jetPackOption.hide();
			relatedOption.hide();
		}
	});
}



/* IMAGE UPLOADER PREVIEW
------------------------------------------------------------------------------------------ */
function tie_image_uploader_trigger( $thisElement ){

	var thisElementID      = $thisElement.attr('id').replace('#',''),
			$thisElementParent = $thisElement.closest('.option-item'),
			$thisElementImage  = $thisElementParent.find('.img-preview'),
			uploaderTypeStyles = false;

	$thisElement.change(function(){
		$thisElementImage.show();
		$thisElementImage.find('img').attr('src', $thisElement.val());
	});

	if( $thisElement.hasClass('tie-background-path') ){
		thisElementID = thisElementID.replace('-img','');
		uploaderTypeStyles = true;
	}

	tie_set_uploader( thisElementID, uploaderTypeStyles );
}



/* IMAGE UPLOADER FUNCTIONS
------------------------------------------------------------------------------------------ */
function tie_builder_dragdrop() {

	jQuery( '#tie-builder-wrapper' ).sortable({
		placeholder: 'tie-state-highlight tie-state-sections',
		activate: function( event, ui ) {

			var $sortableWrap = ui.item,
					outerHeight   = $sortableWrap.outerHeight()+40;

			jQuery('.tie-state-sections').css( 'min-height', outerHeight );
		},
	});

	jQuery( '.tabs_cats' ).sortable({placeholder: 'tie-state-highlight'});

	jQuery( '.block-item' ).draggable({
		distance: 2,
		refreshPositions: true,
		containment: '#wpwrap',
		cursor: 'move',
		zIndex: 100,
		connectToSortable: '.tie-builder-blocks-wrapper',
		revert: true,
		revertDuration: 0,

		/*start: function( event, ui ) {
			ui.helper.css('width', ui.helper.width());
		},*/

		stop: function( event, ui ) {
			ui.helper.css('width','100%');
		}
	});

	jQuery( '.tie-builder-blocks-wrapper' ).sortable({
		placeholder: 'tie-state-highlight',
		items: '> .block-item',
		cursor: 'move',
		distance: 2,
		containment: '#wpwrap',
		tolerance: 'pointer',
		refreshPositions: true,

		receive: function( event, ui ) {
			var sectionID = jQuery(this).data('section-id');

			ui.item.find('[name^=tie_home_cats]').each(function(){
				var newName = jQuery(this).attr('name').replace(/tie_home_cats\[(\w+)\]/g, 'tie_home_cats\['+ sectionID +']' );
				jQuery(this).attr( 'name', newName );
			});
		},

		activate: function( event, ui ) {
			jQuery('.tie-builder-blocks-wrapper').css( 'min-height', '65px' );
			var $sortableWrap = ui.item.closest('.tie-builder-blocks-wrapper'),
					outerHeight   = ( $sortableWrap.outerHeight() > 0 ) ?  $sortableWrap.outerHeight()+40 : '65px';

			$sortableWrap.css( 'min-height', outerHeight );
			jQuery('.tie-builder-container').addClass( 'tie-block-hover' );
		},

		deactivate: function() {
			jQuery('.tie-builder-container').removeClass( 'tie-block-hover' );
			jQuery('.tie-builder-blocks-wrapper').css( 'min-height', '' );
		},
	}).sortable( 'option', 'connectWith', '.tie-builder-container' );

}


/* IMAGE UPLOADER FUNCTIONS
------------------------------------------------------------------------------------------ */
function tie_set_uploader( field, styling ) {
	var tie_bg_uploader;

	$doc.on('click', '#upload_'+field+'_button', function( event ){

		event.preventDefault();
		tie_bg_uploader = wp.media.frames.tie_bg_uploader = wp.media({
			title: 'Choose Image',
			library: {type: 'image' },
			button: {text: 'Select'},
			multiple: false
		});

		tie_bg_uploader.on( 'select', function() {
			var selection = tie_bg_uploader.state().get('selection');
			selection.map( function( attachment ) {

				attachment = attachment.toJSON();

				if( styling ){
					jQuery('#'+field+'-img').val(attachment.url);
				}

				else{
					jQuery('#'+field).val(attachment.url);
				}

				jQuery('#'+field+'-preview').show();
				jQuery('#'+field+'-preview img').attr('src', attachment.url );

				//Set the Retina Logo Width and Height
				if( field == 'logo' ){
					jQuery('#logo_retina_height').val(attachment.height);
					jQuery('#logo_retina_width').val(attachment.width);
				}
			});
		});

		tie_bg_uploader.open();
	});
}




/* Font UPLOADER FUNCTIONS
------------------------------------------------------------------------------------------ */
function tie_set_font_uploader( thisElement ) {

	var tie_font_uploader,
			field = thisElement.attr('id').replace('#','');

	$doc.on('click', '#upload_'+field+'_button', function( event ){

		event.preventDefault();
		tie_font_uploader = wp.media.frames.tie_font_uploader = wp.media({
			title: 'Choose Font',
			library: {type: [ 'image', 'application' ] },
			button: {text: 'Select'},
			multiple: false
		});

		tie_font_uploader.on( 'select', function() {
			var selection = tie_font_uploader.state().get('selection');
			selection.map( function( attachment ) {

				attachment = attachment.toJSON();
				jQuery('#'+field).val(attachment.url);
			});
		});

		tie_font_uploader.open();
	});
}




/* Custom Color Picker
------------------------------------------------------------------------------------------ */
function tie_color_picker(){

	//if( 'undefined' != typeof monsterinsights_admin_common ){ // Conflict with the MonsterInsights plugin
		//return;
	//}

	Color.prototype.toString = function(remove_alpha) {
		if (remove_alpha == 'no-alpha') {
			return this.toCSS('rgba', '1').replace(/\s+/g, '');
		}
		if (this._alpha < 1) {
			return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
		}
		var hex = parseInt(this._color, 10).toString(16);
		if (this.error) return '';
		if (hex.length < 6) {
			for (var i = 6 - hex.length - 1; i >= 0; i--) {
				hex = '0' + hex;
			}
		}
		return '#' + hex;
	};

	jQuery('.tieColorSelector').each(function() {

		var $control = jQuery(this),
				value    = $control.val().replace(/\s+/g, ''),
				palette_input = $control.attr('data-palette');

		if (palette_input == 'false' || palette_input == false) {
			var palette = false;
		}
		else if (palette_input == 'true' || palette_input == true) {
			var palette = true;
		}
		else {
			var palette = $control.attr('data-palette').split(",");
		}

		$control.wpColorPicker({ // change some things with the color picker
			clear: function(event, ui) {
			// TODO reset Alpha Slider to 100
			},
			change: function(event, ui) {
				var $transparency = $control.parents('.wp-picker-container:first').find('.transparency');
				$transparency.css('backgroundColor', ui.color.toString('no-alpha'));
			},
			palettes: palette
		});

		jQuery('<div class="tie-alpha-container"><div class="slider-alpha"></div><div class="transparency"></div></div>').appendTo($control.parents('.wp-picker-container'));
		var $alpha_slider = $control.parents('.wp-picker-container:first').find('.slider-alpha');
		if (value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)) {
			var alpha_val = parseFloat(value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)[1]) * 100;
			var alpha_val = parseInt(alpha_val);
		}
		else {
			var alpha_val = 100;
		}

		$alpha_slider.slider({
			slide: function(event, ui) {
				jQuery(this).find('.ui-slider-handle').text(ui.value); // show value on slider handle
			},
			create: function(event, ui) {
				var v = jQuery(this).slider('value');
				jQuery(this).find('.ui-slider-handle').text(v);
			},
			value: alpha_val,
			range: 'max',
			step: 1,
			min: 1,
			max: 100
		});

		$alpha_slider.slider().on('slidechange', function(event, ui) {
			var new_alpha_val = parseFloat(ui.value),
					iris = $control.data('a8cIris'),
					color_picker = $control.data('wpWpColorPicker');

			iris._color._alpha = new_alpha_val / 100.0;

			$control.val(iris._color.toString());
			color_picker.toggler.css({
				backgroundColor: $control.val()
			});

			var get_val = $control.val();
			jQuery($control).wpColorPicker('color', get_val);
		});
	});
}


/* htmlspecialchars in JS */
function tieHTMLspecialchars(text) {
	var map = {
		'&': '&amp;',
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
		"'": '&#039;'
	};

	return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}


/* Switcher: IOS Style Switch Button | http://abpetkov.github.io/switchery */
(function(){function require(name){var module=require.modules[name];if(!module)throw new Error('failed to require "'+name+'"');if(!("exports"in module)&&typeof module.definition==="function"){module.client=module.component=true;module.definition.call(this,module.exports={},module);delete module.definition}return module.exports}require.loader="component";require.helper={};require.helper.semVerSort=function(a,b){var aArray=a.version.split(".");var bArray=b.version.split(".");for(var i=0;i<aArray.length;++i){var aInt=parseInt(aArray[i],10);var bInt=parseInt(bArray[i],10);if(aInt===bInt){var aLex=aArray[i].substr((""+aInt).length);var bLex=bArray[i].substr((""+bInt).length);if(aLex===""&&bLex!=="")return 1;if(aLex!==""&&bLex==="")return-1;if(aLex!==""&&bLex!=="")return aLex>bLex?1:-1;continue}else if(aInt>bInt){return 1}else{return-1}}return 0};require.latest=function(name,returnPath){function showError(name){throw new Error('failed to find latest module of "'+name+'"')}var versionRegexp=/(.*)~(.*)@v?(\d+\.\d+\.\d+[^\/]*)$/;var remoteRegexp=/(.*)~(.*)/;if(!remoteRegexp.test(name))showError(name);var moduleNames=Object.keys(require.modules);var semVerCandidates=[];var otherCandidates=[];for(var i=0;i<moduleNames.length;i++){var moduleName=moduleNames[i];if(new RegExp(name+"@").test(moduleName)){var version=moduleName.substr(name.length+1);var semVerMatch=versionRegexp.exec(moduleName);if(semVerMatch!=null){semVerCandidates.push({version:version,name:moduleName})}else{otherCandidates.push({version:version,name:moduleName})}}}if(semVerCandidates.concat(otherCandidates).length===0){showError(name)}if(semVerCandidates.length>0){var module=semVerCandidates.sort(require.helper.semVerSort).pop().name;if(returnPath===true){return module}return require(module)}var module=otherCandidates.pop().name;if(returnPath===true){return module}return require(module)};require.modules={};require.register=function(name,definition){require.modules[name]={definition:definition}};require.define=function(name,exports){require.modules[name]={exports:exports}};require.register("abpetkov~transitionize@0.0.3",function(exports,module){module.exports=Transitionize;function Transitionize(element,props){if(!(this instanceof Transitionize))return new Transitionize(element,props);this.element=element;this.props=props||{};this.init()}Transitionize.prototype.isSafari=function(){return/Safari/.test(navigator.userAgent)&&/Apple Computer/.test(navigator.vendor)};Transitionize.prototype.init=function(){var transitions=[];for(var key in this.props){transitions.push(key+" "+this.props[key])}this.element.style.transition=transitions.join(", ");if(this.isSafari())this.element.style.webkitTransition=transitions.join(", ")}});require.register("ftlabs~fastclick@v0.6.11",function(exports,module){function FastClick(layer){"use strict";var oldOnClick,self=this;this.trackingClick=false;this.trackingClickStart=0;this.targetElement=null;this.touchStartX=0;this.touchStartY=0;this.lastTouchIdentifier=0;this.touchBoundary=10;this.layer=layer;if(!layer||!layer.nodeType){throw new TypeError("Layer must be a document node")}this.onClick=function(){return FastClick.prototype.onClick.apply(self,arguments)};this.onMouse=function(){return FastClick.prototype.onMouse.apply(self,arguments)};this.onTouchStart=function(){return FastClick.prototype.onTouchStart.apply(self,arguments)};this.onTouchMove=function(){return FastClick.prototype.onTouchMove.apply(self,arguments)};this.onTouchEnd=function(){return FastClick.prototype.onTouchEnd.apply(self,arguments)};this.onTouchCancel=function(){return FastClick.prototype.onTouchCancel.apply(self,arguments)};if(FastClick.notNeeded(layer)){return}if(this.deviceIsAndroid){layer.addEventListener("mouseover",this.onMouse,true);layer.addEventListener("mousedown",this.onMouse,true);layer.addEventListener("mouseup",this.onMouse,true)}layer.addEventListener("click",this.onClick,true);layer.addEventListener("touchstart",this.onTouchStart,false);layer.addEventListener("touchmove",this.onTouchMove,false);layer.addEventListener("touchend",this.onTouchEnd,false);layer.addEventListener("touchcancel",this.onTouchCancel,false);if(!Event.prototype.stopImmediatePropagation){layer.removeEventListener=function(type,callback,capture){var rmv=Node.prototype.removeEventListener;if(type==="click"){rmv.call(layer,type,callback.hijacked||callback,capture)}else{rmv.call(layer,type,callback,capture)}};layer.addEventListener=function(type,callback,capture){var adv=Node.prototype.addEventListener;if(type==="click"){adv.call(layer,type,callback.hijacked||(callback.hijacked=function(event){if(!event.propagationStopped){callback(event)}}),capture)}else{adv.call(layer,type,callback,capture)}}}if(typeof layer.onclick==="function"){oldOnClick=layer.onclick;layer.addEventListener("click",function(event){oldOnClick(event)},false);layer.onclick=null}}FastClick.prototype.deviceIsAndroid=navigator.userAgent.indexOf("Android")>0;FastClick.prototype.deviceIsIOS=/iP(ad|hone|od)/.test(navigator.userAgent);FastClick.prototype.deviceIsIOS4=FastClick.prototype.deviceIsIOS&&/OS 4_\d(_\d)?/.test(navigator.userAgent);FastClick.prototype.deviceIsIOSWithBadTarget=FastClick.prototype.deviceIsIOS&&/OS ([6-9]|\d{2})_\d/.test(navigator.userAgent);FastClick.prototype.needsClick=function(target){"use strict";switch(target.nodeName.toLowerCase()){case"button":case"select":case"textarea":if(target.disabled){return true}break;case"input":if(this.deviceIsIOS&&target.type==="file"||target.disabled){return true}break;case"label":case"video":return true}return/\bneedsclick\b/.test(target.className)};FastClick.prototype.needsFocus=function(target){"use strict";switch(target.nodeName.toLowerCase()){case"textarea":return true;case"select":return!this.deviceIsAndroid;case"input":switch(target.type){case"button":case"checkbox":case"file":case"image":case"radio":case"submit":return false}return!target.disabled&&!target.readOnly;default:return/\bneedsfocus\b/.test(target.className)}};FastClick.prototype.sendClick=function(targetElement,event){"use strict";var clickEvent,touch;if(document.activeElement&&document.activeElement!==targetElement){document.activeElement.blur()}touch=event.changedTouches[0];clickEvent=document.createEvent("MouseEvents");clickEvent.initMouseEvent(this.determineEventType(targetElement),true,true,window,1,touch.screenX,touch.screenY,touch.clientX,touch.clientY,false,false,false,false,0,null);clickEvent.forwardedTouchEvent=true;targetElement.dispatchEvent(clickEvent)};FastClick.prototype.determineEventType=function(targetElement){"use strict";if(this.deviceIsAndroid&&targetElement.tagName.toLowerCase()==="select"){return"mousedown"}return"click"};FastClick.prototype.focus=function(targetElement){"use strict";var length;if(this.deviceIsIOS&&targetElement.setSelectionRange&&targetElement.type.indexOf("date")!==0&&targetElement.type!=="time"){length=targetElement.value.length;targetElement.setSelectionRange(length,length)}else{targetElement.focus()}};FastClick.prototype.updateScrollParent=function(targetElement){"use strict";var scrollParent,parentElement;scrollParent=targetElement.fastClickScrollParent;if(!scrollParent||!scrollParent.contains(targetElement)){parentElement=targetElement;do{if(parentElement.scrollHeight>parentElement.offsetHeight){scrollParent=parentElement;targetElement.fastClickScrollParent=parentElement;break}parentElement=parentElement.parentElement}while(parentElement)}if(scrollParent){scrollParent.fastClickLastScrollTop=scrollParent.scrollTop}};FastClick.prototype.getTargetElementFromEventTarget=function(eventTarget){"use strict";if(eventTarget.nodeType===Node.TEXT_NODE){return eventTarget.parentNode}return eventTarget};FastClick.prototype.onTouchStart=function(event){"use strict";var targetElement,touch,selection;if(event.targetTouches.length>1){return true}targetElement=this.getTargetElementFromEventTarget(event.target);touch=event.targetTouches[0];if(this.deviceIsIOS){selection=window.getSelection();if(selection.rangeCount&&!selection.isCollapsed){return true}if(!this.deviceIsIOS4){if(touch.identifier===this.lastTouchIdentifier){event.preventDefault();return false}this.lastTouchIdentifier=touch.identifier;this.updateScrollParent(targetElement)}}this.trackingClick=true;this.trackingClickStart=event.timeStamp;this.targetElement=targetElement;this.touchStartX=touch.pageX;this.touchStartY=touch.pageY;if(event.timeStamp-this.lastClickTime<200){event.preventDefault()}return true};FastClick.prototype.touchHasMoved=function(event){"use strict";var touch=event.changedTouches[0],boundary=this.touchBoundary;if(Math.abs(touch.pageX-this.touchStartX)>boundary||Math.abs(touch.pageY-this.touchStartY)>boundary){return true}return false};FastClick.prototype.onTouchMove=function(event){"use strict";if(!this.trackingClick){return true}if(this.targetElement!==this.getTargetElementFromEventTarget(event.target)||this.touchHasMoved(event)){this.trackingClick=false;this.targetElement=null}return true};FastClick.prototype.findControl=function(labelElement){"use strict";if(labelElement.control!==undefined){return labelElement.control}if(labelElement.htmlFor){return document.getElementById(labelElement.htmlFor)}return labelElement.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")};FastClick.prototype.onTouchEnd=function(event){"use strict";var forElement,trackingClickStart,targetTagName,scrollParent,touch,targetElement=this.targetElement;if(!this.trackingClick){return true}if(event.timeStamp-this.lastClickTime<200){this.cancelNextClick=true;return true}this.cancelNextClick=false;this.lastClickTime=event.timeStamp;trackingClickStart=this.trackingClickStart;this.trackingClick=false;this.trackingClickStart=0;if(this.deviceIsIOSWithBadTarget){touch=event.changedTouches[0];targetElement=document.elementFromPoint(touch.pageX-window.pageXOffset,touch.pageY-window.pageYOffset)||targetElement;targetElement.fastClickScrollParent=this.targetElement.fastClickScrollParent}targetTagName=targetElement.tagName.toLowerCase();if(targetTagName==="label"){forElement=this.findControl(targetElement);if(forElement){this.focus(targetElement);if(this.deviceIsAndroid){return false}targetElement=forElement}}else if(this.needsFocus(targetElement)){if(event.timeStamp-trackingClickStart>100||this.deviceIsIOS&&window.top!==window&&targetTagName==="input"){this.targetElement=null;return false}this.focus(targetElement);if(!this.deviceIsIOS4||targetTagName!=="select"){this.targetElement=null;event.preventDefault()}return false}if(this.deviceIsIOS&&!this.deviceIsIOS4){scrollParent=targetElement.fastClickScrollParent;if(scrollParent&&scrollParent.fastClickLastScrollTop!==scrollParent.scrollTop){return true}}if(!this.needsClick(targetElement)){event.preventDefault();this.sendClick(targetElement,event)}return false};FastClick.prototype.onTouchCancel=function(){"use strict";this.trackingClick=false;this.targetElement=null};FastClick.prototype.onMouse=function(event){"use strict";if(!this.targetElement){return true}if(event.forwardedTouchEvent){return true}if(!event.cancelable){return true}if(!this.needsClick(this.targetElement)||this.cancelNextClick){if(event.stopImmediatePropagation){event.stopImmediatePropagation()}else{event.propagationStopped=true}event.stopPropagation();event.preventDefault();return false}return true};FastClick.prototype.onClick=function(event){"use strict";var permitted;if(this.trackingClick){this.targetElement=null;this.trackingClick=false;return true}if(event.target.type==="submit"&&event.detail===0){return true}permitted=this.onMouse(event);if(!permitted){this.targetElement=null}return permitted};FastClick.prototype.destroy=function(){"use strict";var layer=this.layer;if(this.deviceIsAndroid){layer.removeEventListener("mouseover",this.onMouse,true);layer.removeEventListener("mousedown",this.onMouse,true);layer.removeEventListener("mouseup",this.onMouse,true)}layer.removeEventListener("click",this.onClick,true);layer.removeEventListener("touchstart",this.onTouchStart,false);layer.removeEventListener("touchmove",this.onTouchMove,false);layer.removeEventListener("touchend",this.onTouchEnd,false);layer.removeEventListener("touchcancel",this.onTouchCancel,false)};FastClick.notNeeded=function(layer){"use strict";var metaViewport;var chromeVersion;if(typeof window.ontouchstart==="undefined"){return true}chromeVersion=+(/Chrome\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1];if(chromeVersion){if(FastClick.prototype.deviceIsAndroid){metaViewport=document.querySelector("meta[name=viewport]");if(metaViewport){if(metaViewport.content.indexOf("user-scalable=no")!==-1){return true}if(chromeVersion>31&&window.innerWidth<=window.screen.width){return true}}}else{return true}}if(layer.style.msTouchAction==="none"){return true}return false};FastClick.attach=function(layer){"use strict";return new FastClick(layer)};if(typeof define!=="undefined"&&define.amd){define(function(){"use strict";return FastClick})}else if(typeof module!=="undefined"&&module.exports){module.exports=FastClick.attach;module.exports.FastClick=FastClick}else{window.FastClick=FastClick}});require.register("component~indexof@0.0.3",function(exports,module){module.exports=function(arr,obj){if(arr.indexOf)return arr.indexOf(obj);for(var i=0;i<arr.length;++i){if(arr[i]===obj)return i}return-1}});require.register("component~classes@1.2.1",function(exports,module){var index=require("component~indexof@0.0.3");var re=/\s+/;var toString=Object.prototype.toString;module.exports=function(el){return new ClassList(el)};function ClassList(el){if(!el)throw new Error("A DOM element reference is required");this.el=el;this.list=el.classList}ClassList.prototype.add=function(name){if(this.list){this.list.add(name);return this}var arr=this.array();var i=index(arr,name);if(!~i)arr.push(name);this.el.className=arr.join(" ");return this};ClassList.prototype.remove=function(name){if("[object RegExp]"==toString.call(name)){return this.removeMatching(name)}if(this.list){this.list.remove(name);return this}var arr=this.array();var i=index(arr,name);if(~i)arr.splice(i,1);this.el.className=arr.join(" ");return this};ClassList.prototype.removeMatching=function(re){var arr=this.array();for(var i=0;i<arr.length;i++){if(re.test(arr[i])){this.remove(arr[i])}}return this};ClassList.prototype.toggle=function(name,force){if(this.list){if("undefined"!==typeof force){if(force!==this.list.toggle(name,force)){this.list.toggle(name)}}else{this.list.toggle(name)}return this}if("undefined"!==typeof force){if(!force){this.remove(name)}else{this.add(name)}}else{if(this.has(name)){this.remove(name)}else{this.add(name)}}return this};ClassList.prototype.array=function(){var str=this.el.className.replace(/^\s+|\s+$/g,"");var arr=str.split(re);if(""===arr[0])arr.shift();return arr};ClassList.prototype.has=ClassList.prototype.contains=function(name){return this.list?this.list.contains(name):!!~index(this.array(),name)}});require.register("switchery",function(exports,module){var transitionize=require("abpetkov~transitionize@0.0.3"),fastclick=require("ftlabs~fastclick@v0.6.11"),classes=require("component~classes@1.2.1");module.exports=Switchery;var defaults={color:"#64bd63",secondaryColor:"#dfdfdf",jackColor:"#fff",className:"switchery",disabled:false,disabledOpacity:.5,speed:"0.4s",size:"default"};function Switchery(element,options){if(!(this instanceof Switchery))return new Switchery(element,options);this.element=element;this.options=options||{};for(var i in defaults){if(this.options[i]==null){this.options[i]=defaults[i]}}if(this.element!=null&&this.element.type=="checkbox")this.init()}Switchery.prototype.hide=function(){this.element.style.display="none"};Switchery.prototype.show=function(){var switcher=this.create();this.insertAfter(this.element,switcher)};Switchery.prototype.create=function(){this.switcher=document.createElement("span");this.jack=document.createElement("small");this.switcher.appendChild(this.jack);this.switcher.className=this.options.className;return this.switcher};Switchery.prototype.insertAfter=function(reference,target){reference.parentNode.insertBefore(target,reference.nextSibling)};Switchery.prototype.isChecked=function(){return this.element.checked};Switchery.prototype.isDisabled=function(){return this.options.disabled||this.element.disabled||this.element.readOnly};Switchery.prototype.setPosition=function(clicked){var checked=this.isChecked(),switcher=this.switcher,jack=this.jack;if(clicked&&checked)checked=false;else if(clicked&&!checked)checked=true;if(checked===true){this.element.checked=true;if(window.getComputedStyle)jack.style.left=parseInt(window.getComputedStyle(switcher).width)-parseInt(window.getComputedStyle(jack).width)+"px";else jack.style.left=parseInt(switcher.currentStyle["width"])-parseInt(jack.currentStyle["width"])+"px";if(this.options.color)this.colorize();this.setSpeed()}else{jack.style.left=0;this.element.checked=false;this.switcher.style.boxShadow="inset 0 0 0 0 "+this.options.secondaryColor;this.switcher.style.borderColor=this.options.secondaryColor;this.switcher.style.backgroundColor=this.options.secondaryColor!==defaults.secondaryColor?this.options.secondaryColor:"#fff";this.jack.style.backgroundColor=this.options.jackColor;this.setSpeed()}};Switchery.prototype.setSpeed=function(){var switcherProp={},jackProp={left:this.options.speed.replace(/[a-z]/,"")/2+"s"};if(this.isChecked()){switcherProp={border:this.options.speed,"box-shadow":this.options.speed,"background-color":this.options.speed.replace(/[a-z]/,"")*3+"s"}}else{switcherProp={border:this.options.speed,"box-shadow":this.options.speed}}transitionize(this.switcher,switcherProp);transitionize(this.jack,jackProp)};Switchery.prototype.setSize=function(){var small="switchery-small",normal="switchery-default",large="switchery-large";switch(this.options.size){case"small":classes(this.switcher).add(small);break;case"large":classes(this.switcher).add(large);break;default:classes(this.switcher).add(normal);break}};Switchery.prototype.colorize=function(){var switcherHeight=this.switcher.offsetHeight/2;this.switcher.style.backgroundColor=this.options.color;this.switcher.style.borderColor=this.options.color;this.switcher.style.boxShadow="inset 0 0 0 "+switcherHeight+"px "+this.options.color;this.jack.style.backgroundColor=this.options.jackColor};Switchery.prototype.handleOnchange=function(state){if(document.dispatchEvent){var event=document.createEvent("HTMLEvents");event.initEvent("change",true,true);this.element.dispatchEvent(event)}else{this.element.fireEvent("onchange")}};Switchery.prototype.handleChange=function(){var self=this,el=this.element;if(el.addEventListener){el.addEventListener("change",function(){self.setPosition()})}else{el.attachEvent("onchange",function(){self.setPosition()})}};Switchery.prototype.handleClick=function(){var self=this,switcher=this.switcher,parent=self.element.parentNode.tagName.toLowerCase(),labelParent=parent==="label"?false:true;if(this.isDisabled()===false){fastclick(switcher);if(switcher.addEventListener){switcher.addEventListener("click",function(e){self.setPosition(labelParent);self.handleOnchange(self.element.checked)})}else{switcher.attachEvent("onclick",function(){self.setPosition(labelParent);self.handleOnchange(self.element.checked)})}}else{this.element.disabled=true;this.switcher.style.opacity=this.options.disabledOpacity}};Switchery.prototype.markAsSwitched=function(){this.element.setAttribute("data-switchery",true)};Switchery.prototype.markedAsSwitched=function(){return this.element.getAttribute("data-switchery")};Switchery.prototype.init=function(){this.hide();this.show();this.setSize();this.setPosition();this.markAsSwitched();this.handleChange();this.handleClick()}});if(typeof exports=="object"){module.exports=require("switchery")}else if(typeof define=="function"&&define.amd){define("Switchery",[],function(){return require("switchery")})}else{(this||window)["Switchery"]=require("switchery")}})();


/*
 * jQuery.fontselect - A font selector for the Google Web Fonts api
 * Tom Moor, http://tommoor.com
 * Copyright (c) 2011 Tom Moor
 * MIT Licensed
 * @version 0.1
*/

(function($){
	$.fn.fontselect = function(options) {
		var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

		var standardFonts = [
			"safefont#Arial, Helvetica, sans-serif",
			"safefont#'Arial Black', Gadget, sans-serif",
			"safefont#'Bookman Old Style', serif",
			"safefont#'Comic Sans MS', cursive",
			"safefont#Courier, monospace",
			"safefont#Garamond, serif",
			"safefont#Georgia, serif",
			"safefont#Impact, Charcoal, sans-serif",
			"safefont#'Lucida Console', Monaco, monospace",
			"safefont#'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"safefont#'MS Sans Serif', Geneva, sans-serif",
			"safefont#'MS Serif', 'New York', sans-serif",
			"safefont#'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			"safefont#Tahoma, Geneva, sans-serif",
			"safefont#'Times New Roman', Times, serif",
			"safefont#'Trebuchet MS', Helvetica, sans-serif",
			"safefont#Verdana, Geneva, sans-serif",
		];

		var fonts = [
			'ABeeZee',
			'Abel',
			'Abhaya+Libre',
			'Abril+Fatface',
			'Aclonica',
			'Acme',
			'Actor',
			'Adamina',
			'Advent+Pro',
			'Aguafina+Script',
			'Akronim',
			'Aladin',
			'Alata',
			'Alatsi',
			'Aldrich',
			'Alef',
			'Alegreya',
			'Alegreya+SC',
			'Alegreya+Sans',
			'Alegreya+Sans+SC',
			'Aleo',
			'Alex+Brush',
			'Alfa+Slab+One',
			'Alice',
			'Alike',
			'Alike+Angular',
			'Allan',
			'Allerta',
			'Allerta+Stencil',
			'Allura',
			'Almarai',
			'Almendra',
			'Almendra+Display',
			'Almendra+SC',
			'Amarante',
			'Amaranth',
			'Amatic+SC',
			'Amethysta',
			'Amiko',
			'Amiri',
			'Amita',
			'Anaheim',
			'Andada',
			'Andika',
			'Andika+New+Basic',
			'Angkor',
			'Annie+Use+Your+Telescope',
			'Anonymous+Pro',
			'Antic',
			'Antic+Didone',
			'Antic+Slab',
			'Anton',
			'Arapey',
			'Arbutus',
			'Arbutus+Slab',
			'Architects+Daughter',
			'Archivo',
			'Archivo+Black',
			'Archivo+Narrow',
			'Aref+Ruqaa',
			'Arima+Madurai',
			'Arimo',
			'Arizonia',
			'Armata',
			'Arsenal',
			'Artifika',
			'Arvo',
			'Arya',
			'Asap',
			'Asap+Condensed',
			'Asar',
			'Asset',
			'Assistant',
			'Astloch',
			'Asul',
			'Athiti',
			'Atma',
			'Atomic+Age',
			'Aubrey',
			'Audiowide',
			'Autour+One',
			'Average',
			'Average+Sans',
			'Averia+Gruesa+Libre',
			'Averia+Libre',
			'Averia+Sans+Libre',
			'Averia+Serif+Libre',
			'B612',
			'B612+Mono',
			'Bad+Script',
			'Bahiana',
			'Bahianita',
			'Bai+Jamjuree',
			'Baloo+2',
			'Baloo+Bhai+2',
			'Baloo+Bhaina+2',
			'Baloo+Chettan+2',
			'Baloo+Da+2',
			'Baloo+Paaji+2',
			'Baloo+Tamma+2',
			'Baloo+Tammudu+2',
			'Baloo+Thambi+2',
			'Balsamiq+Sans',
			'Balthazar',
			'Bangers',
			'Barlow',
			'Barlow+Condensed',
			'Barlow+Semi+Condensed',
			'Barriecito',
			'Barrio',
			'Basic',
			'Baskervville',
			'Battambang',
			'Baumans',
			'Bayon',
			'Be+Vietnam',
			'Bebas+Neue',
			'Belgrano',
			'Bellefair',
			'Belleza',
			'Bellota',
			'Bellota+Text',
			'BenchNine',
			'Bentham',
			'Berkshire+Swash',
			'Beth+Ellen',
			'Bevan',
			'Big+Shoulders+Display',
			'Big+Shoulders+Inline+Display',
			'Big+Shoulders+Inline+Text',
			'Big+Shoulders+Stencil+Display',
			'Big+Shoulders+Stencil+Text',
			'Big+Shoulders+Text',
			'Bigelow+Rules',
			'Bigshot+One',
			'Bilbo',
			'Bilbo+Swash+Caps',
			'BioRhyme',
			'BioRhyme+Expanded',
			'Biryani',
			'Bitter',
			'Black+And+White+Picture',
			'Black+Han+Sans',
			'Black+Ops+One',
			'Blinker',
			'Bodoni+Moda',
			'Bokor',
			'Bonbon',
			'Boogaloo',
			'Bowlby+One',
			'Bowlby+One+SC',
			'Brawler',
			'Bree+Serif',
			'Bubblegum+Sans',
			'Bubbler+One',
			'Buda',
			'Buenard',
			'Bungee',
			'Bungee+Hairline',
			'Bungee+Inline',
			'Bungee+Outline',
			'Bungee+Shade',
			'Butcherman',
			'Butterfly+Kids',
			'Cabin',
			'Cabin+Condensed',
			'Cabin+Sketch',
			'Caesar+Dressing',
			'Cagliostro',
			'Cairo',
			'Caladea',
			'Calistoga',
			'Calligraffitti',
			'Cambay',
			'Cambo',
			'Candal',
			'Cantarell',
			'Cantata+One',
			'Cantora+One',
			'Capriola',
			'Cardo',
			'Carme',
			'Carrois+Gothic',
			'Carrois+Gothic+SC',
			'Carter+One',
			'Castoro',
			'Catamaran',
			'Caudex',
			'Caveat',
			'Caveat+Brush',
			'Cedarville+Cursive',
			'Ceviche+One',
			'Chakra+Petch',
			'Changa',
			'Changa+One',
			'Chango',
			'Charm',
			'Charmonman',
			'Chathura',
			'Chau+Philomene+One',
			'Chela+One',
			'Chelsea+Market',
			'Chenla',
			'Cherry+Cream+Soda',
			'Cherry+Swash',
			'Chewy',
			'Chicle',
			'Chilanka',
			'Chivo',
			'Chonburi',
			'Cinzel',
			'Cinzel+Decorative',
			'Clicker+Script',
			'Coda',
			'Coda+Caption',
			'Codystar',
			'Coiny',
			'Combo',
			'Comfortaa',
			'Comic+Neue',
			'Coming+Soon',
			'Commissioner',
			'Concert+One',
			'Condiment',
			'Content',
			'Contrail+One',
			'Convergence',
			'Cookie',
			'Copse',
			'Corben',
			'Cormorant',
			'Cormorant+Garamond',
			'Cormorant+Infant',
			'Cormorant+SC',
			'Cormorant+Unicase',
			'Cormorant+Upright',
			'Courgette',
			'Courier+Prime',
			'Cousine',
			'Coustard',
			'Covered+By+Your+Grace',
			'Crafty+Girls',
			'Creepster',
			'Crete+Round',
			'Crimson+Pro',
			'Crimson+Text',
			'Croissant+One',
			'Crushed',
			'Cuprum',
			'Cute+Font',
			'Cutive',
			'Cutive+Mono',
			'DM+Mono',
			'DM+Sans',
			'DM+Serif+Display',
			'DM+Serif+Text',
			'Damion',
			'Dancing+Script',
			'Dangrek',
			'Darker+Grotesque',
			'David+Libre',
			'Dawning+of+a+New+Day',
			'Days+One',
			'Dekko',
			'Delius',
			'Delius+Swash+Caps',
			'Delius+Unicase',
			'Della+Respira',
			'Denk+One',
			'Devonshire',
			'Dhurjati',
			'Didact+Gothic',
			'Diplomata',
			'Diplomata+SC',
			'Do+Hyeon',
			'Dokdo',
			'Domine',
			'Donegal+One',
			'Doppio+One',
			'Dorsa',
			'Dosis',
			'Dr+Sugiyama',
			'Duru+Sans',
			'Dynalight',
			'EB+Garamond',
			'Eagle+Lake',
			'East+Sea+Dokdo',
			'Eater',
			'Economica',
			'Eczar',
			'El+Messiri',
			'Electrolize',
			'Elsie',
			'Elsie+Swash+Caps',
			'Emblema+One',
			'Emilys+Candy',
			'Encode+Sans',
			'Encode+Sans+Condensed',
			'Encode+Sans+Expanded',
			'Encode+Sans+Semi+Condensed',
			'Encode+Sans+Semi+Expanded',
			'Engagement',
			'Englebert',
			'Enriqueta',
			'Epilogue',
			'Erica+One',
			'Esteban',
			'Euphoria+Script',
			'Ewert',
			'Exo',
			'Exo+2',
			'Expletus+Sans',
			'Fahkwang',
			'Fanwood+Text',
			'Farro',
			'Farsan',
			'Fascinate',
			'Fascinate+Inline',
			'Faster+One',
			'Fasthand',
			'Fauna+One',
			'Faustina',
			'Federant',
			'Federo',
			'Felipa',
			'Fenix',
			'Finger+Paint',
			'Fira+Code',
			'Fira+Mono',
			'Fira+Sans',
			'Fira+Sans+Condensed',
			'Fira+Sans+Extra+Condensed',
			'Fjalla+One',
			'Fjord+One',
			'Flamenco',
			'Flavors',
			'Fondamento',
			'Fontdiner+Swanky',
			'Forum',
			'Francois+One',
			'Frank+Ruhl+Libre',
			'Fraunces',
			'Freckle+Face',
			'Fredericka+the+Great',
			'Fredoka+One',
			'Freehand',
			'Fresca',
			'Frijole',
			'Fruktur',
			'Fugaz+One',
			'GFS+Didot',
			'GFS+Neohellenic',
			'Gabriela',
			'Gaegu',
			'Gafata',
			'Galada',
			'Galdeano',
			'Galindo',
			'Gamja+Flower',
			'Gayathri',
			'Gelasio',
			'Gentium+Basic',
			'Gentium+Book+Basic',
			'Geo',
			'Geostar',
			'Geostar+Fill',
			'Germania+One',
			'Gidugu',
			'Gilda+Display',
			'Girassol',
			'Give+You+Glory',
			'Glass+Antiqua',
			'Glegoo',
			'Gloria+Hallelujah',
			'Goblin+One',
			'Gochi+Hand',
			'Goldman',
			'Gorditas',
			'Gothic+A1',
			'Gotu',
			'Goudy+Bookletter+1911',
			'Graduate',
			'Grand+Hotel',
			'Grandstander',
			'Gravitas+One',
			'Great+Vibes',
			'Grenze',
			'Grenze+Gotisch',
			'Griffy',
			'Gruppo',
			'Gudea',
			'Gugi',
			'Gupter',
			'Gurajada',
			'Habibi',
			'Hachi+Maru+Pop',
			'Halant',
			'Hammersmith+One',
			'Hanalei',
			'Hanalei+Fill',
			'Handlee',
			'Hanuman',
			'Happy+Monkey',
			'Harmattan',
			'Headland+One',
			'Heebo',
			'Henny+Penny',
			'Hepta+Slab',
			'Herr+Von+Muellerhoff',
			'Hi+Melody',
			'Hind',
			'Hind+Guntur',
			'Hind+Madurai',
			'Hind+Siliguri',
			'Hind+Vadodara',
			'Holtwood+One+SC',
			'Homemade+Apple',
			'Homenaje',
			'IBM+Plex+Mono',
			'IBM+Plex+Sans',
			'IBM+Plex+Sans+Condensed',
			'IBM+Plex+Serif',
			'IM+Fell+DW+Pica',
			'IM+Fell+DW+Pica+SC',
			'IM+Fell+Double+Pica',
			'IM+Fell+Double+Pica+SC',
			'IM+Fell+English',
			'IM+Fell+English+SC',
			'IM+Fell+French+Canon',
			'IM+Fell+French+Canon+SC',
			'IM+Fell+Great+Primer',
			'IM+Fell+Great+Primer+SC',
			'Ibarra+Real+Nova',
			'Iceberg',
			'Iceland',
			'Imbue',
			'Imprima',
			'Inconsolata',
			'Inder',
			'Indie+Flower',
			'Inika',
			'Inknut+Antiqua',
			'Inria+Sans',
			'Inria+Serif',
			'Inter',
			'Irish+Grover',
			'Istok+Web',
			'Italiana',
			'Italianno',
			'Itim',
			'Jacques+Francois',
			'Jacques+Francois+Shadow',
			'Jaldi',
			'JetBrains+Mono',
			'Jim+Nightshade',
			'Jockey+One',
			'Jolly+Lodger',
			'Jomhuria',
			'Jomolhari',
			'Josefin+Sans',
			'Josefin+Slab',
			'Jost',
			'Joti+One',
			'Jua',
			'Judson',
			'Julee',
			'Julius+Sans+One',
			'Junge',
			'Jura',
			'Just+Another+Hand',
			'Just+Me+Again+Down+Here',
			'K2D',
			'Kadwa',
			'Kalam',
			'Kameron',
			'Kanit',
			'Kantumruy',
			'Karla',
			'Karma',
			'Katibeh',
			'Kaushan+Script',
			'Kavivanar',
			'Kavoon',
			'Kdam+Thmor',
			'Keania+One',
			'Kelly+Slab',
			'Kenia',
			'Khand',
			'Khmer',
			'Khula',
			'Kirang+Haerang',
			'Kite+One',
			'Knewave',
			'KoHo',
			'Kodchasan',
			'Kosugi',
			'Kosugi+Maru',
			'Kotta+One',
			'Koulen',
			'Kranky',
			'Kreon',
			'Kristi',
			'Krona+One',
			'Krub',
			'Kufam',
			'Kulim+Park',
			'Kumar+One',
			'Kumar+One+Outline',
			'Kumbh+Sans',
			'Kurale',
			'La+Belle+Aurore',
			'Lacquer',
			'Laila',
			'Lakki+Reddy',
			'Lalezar',
			'Lancelot',
			'Langar',
			'Lateef',
			'Lato',
			'League+Script',
			'Leckerli+One',
			'Ledger',
			'Lekton',
			'Lemon',
			'Lemonada',
			'Lexend+Deca',
			'Lexend+Exa',
			'Lexend+Giga',
			'Lexend+Mega',
			'Lexend+Peta',
			'Lexend+Tera',
			'Lexend+Zetta',
			'Libre+Barcode+128',
			'Libre+Barcode+128+Text',
			'Libre+Barcode+39',
			'Libre+Barcode+39+Extended',
			'Libre+Barcode+39+Extended+Text',
			'Libre+Barcode+39+Text',
			'Libre+Barcode+EAN13+Text',
			'Libre+Baskerville',
			'Libre+Caslon+Display',
			'Libre+Caslon+Text',
			'Libre+Franklin',
			'Life+Savers',
			'Lilita+One',
			'Lily+Script+One',
			'Limelight',
			'Linden+Hill',
			'Literata',
			'Liu+Jian+Mao+Cao',
			'Livvic',
			'Lobster',
			'Lobster+Two',
			'Londrina+Outline',
			'Londrina+Shadow',
			'Londrina+Sketch',
			'Londrina+Solid',
			'Long+Cang',
			'Lora',
			'Love+Ya+Like+A+Sister',
			'Loved+by+the+King',
			'Lovers+Quarrel',
			'Luckiest+Guy',
			'Lusitana',
			'Lustria',
			'M+PLUS+1p',
			'M+PLUS+Rounded+1c',
			'Ma+Shan+Zheng',
			'Macondo',
			'Macondo+Swash+Caps',
			'Mada',
			'Magra',
			'Maiden+Orange',
			'Maitree',
			'Major+Mono+Display',
			'Mako',
			'Mali',
			'Mallanna',
			'Mandali',
			'Manjari',
			'Manrope',
			'Mansalva',
			'Manuale',
			'Marcellus',
			'Marcellus+SC',
			'Marck+Script',
			'Margarine',
			'Markazi+Text',
			'Marko+One',
			'Marmelad',
			'Martel',
			'Martel+Sans',
			'Marvel',
			'Mate',
			'Mate+SC',
			'Maven+Pro',
			'McLaren',
			'Meddon',
			'MedievalSharp',
			'Medula+One',
			'Meera+Inimai',
			'Megrim',
			'Meie+Script',
			'Merienda',
			'Merienda+One',
			'Merriweather',
			'Merriweather+Sans',
			'Metal',
			'Metal+Mania',
			'Metamorphous',
			'Metrophobic',
			'Michroma',
			'Milonga',
			'Miltonian',
			'Miltonian+Tattoo',
			'Mina',
			'Miniver',
			'Miriam+Libre',
			'Mirza',
			'Miss+Fajardose',
			'Mitr',
			'Modak',
			'Modern+Antiqua',
			'Mogra',
			'Molengo',
			'Molle',
			'Monda',
			'Monofett',
			'Monoton',
			'Monsieur+La+Doulaise',
			'Montaga',
			'Montez',
			'Montserrat',
			'Montserrat+Alternates',
			'Montserrat+Subrayada',
			'Moul',
			'Moulpali',
			'Mountains+of+Christmas',
			'Mouse+Memoirs',
			'Mr+Bedfort',
			'Mr+Dafoe',
			'Mr+De+Haviland',
			'Mrs+Saint+Delafield',
			'Mrs+Sheppards',
			'Mukta',
			'Mukta+Mahee',
			'Mukta+Malar',
			'Mukta+Vaani',
			'Mulish',
			'MuseoModerno',
			'Mystery+Quest',
			'NTR',
			'Nanum+Brush+Script',
			'Nanum+Gothic',
			'Nanum+Gothic+Coding',
			'Nanum+Myeongjo',
			'Nanum+Pen+Script',
			'Nerko+One',
			'Neucha',
			'Neuton',
			'New+Rocker',
			'News+Cycle',
			'Niconne',
			'Niramit',
			'Nixie+One',
			'Nobile',
			'Nokora',
			'Norican',
			'Nosifer',
			'Notable',
			'Nothing+You+Could+Do',
			'Noticia+Text',
			'Noto+Sans',
			'Noto+Sans+HK',
			'Noto+Sans+JP',
			'Noto+Sans+KR',
			'Noto+Sans+SC',
			'Noto+Sans+TC',
			'Noto+Serif',
			'Noto+Serif+JP',
			'Noto+Serif+KR',
			'Noto+Serif+SC',
			'Noto+Serif+TC',
			'Nova+Cut',
			'Nova+Flat',
			'Nova+Mono',
			'Nova+Oval',
			'Nova+Round',
			'Nova+Script',
			'Nova+Slim',
			'Nova+Square',
			'Numans',
			'Nunito',
			'Nunito+Sans',
			'Odibee+Sans',
			'Odor+Mean+Chey',
			'Offside',
			'Old+Standard+TT',
			'Oldenburg',
			'Oleo+Script',
			'Oleo+Script+Swash+Caps',
			'Open+Sans',
			'Open+Sans+Condensed',
			'Oranienbaum',
			'Orbitron',
			'Oregano',
			'Orienta',
			'Original+Surfer',
			'Oswald',
			'Over+the+Rainbow',
			'Overlock',
			'Overlock+SC',
			'Overpass',
			'Overpass+Mono',
			'Ovo',
			'Oxanium',
			'Oxygen',
			'Oxygen+Mono',
			'PT+Mono',
			'PT+Sans',
			'PT+Sans+Caption',
			'PT+Sans+Narrow',
			'PT+Serif',
			'PT+Serif+Caption',
			'Pacifico',
			'Padauk',
			'Palanquin',
			'Palanquin+Dark',
			'Pangolin',
			'Paprika',
			'Parisienne',
			'Passero+One',
			'Passion+One',
			'Pathway+Gothic+One',
			'Patrick+Hand',
			'Patrick+Hand+SC',
			'Pattaya',
			'Patua+One',
			'Pavanam',
			'Paytone+One',
			'Peddana',
			'Peralta',
			'Permanent+Marker',
			'Petit+Formal+Script',
			'Petrona',
			'Philosopher',
			'Piazzolla',
			'Piedra',
			'Pinyon+Script',
			'Pirata+One',
			'Plaster',
			'Play',
			'Playball',
			'Playfair+Display',
			'Playfair+Display+SC',
			'Podkova',
			'Poiret+One',
			'Poller+One',
			'Poly',
			'Pompiere',
			'Pontano+Sans',
			'Poor+Story',
			'Poppins',
			'Port+Lligat+Sans',
			'Port+Lligat+Slab',
			'Potta+One',
			'Pragati+Narrow',
			'Prata',
			'Preahvihear',
			'Press+Start+2P',
			'Pridi',
			'Princess+Sofia',
			'Prociono',
			'Prompt',
			'Prosto+One',
			'Proza+Libre',
			'Public+Sans',
			'Puritan',
			'Purple+Purse',
			'Quando',
			'Quantico',
			'Quattrocento',
			'Quattrocento+Sans',
			'Questrial',
			'Quicksand',
			'Quintessential',
			'Qwigley',
			'Racing+Sans+One',
			'Radley',
			'Rajdhani',
			'Rakkas',
			'Raleway',
			'Raleway+Dots',
			'Ramabhadra',
			'Ramaraja',
			'Rambla',
			'Rammetto+One',
			'Ranchers',
			'Rancho',
			'Ranga',
			'Rasa',
			'Rationale',
			'Ravi+Prakash',
			'Recursive',
			'Red+Hat+Display',
			'Red+Hat+Text',
			'Red+Rose',
			'Redressed',
			'Reem+Kufi',
			'Reenie+Beanie',
			'Revalia',
			'Rhodium+Libre',
			'Ribeye',
			'Ribeye+Marrow',
			'Righteous',
			'Risque',
			'Roboto',
			'Roboto+Condensed',
			'Roboto+Mono',
			'Roboto+Slab',
			'Rochester',
			'Rock+Salt',
			'Rokkitt',
			'Romanesco',
			'Ropa+Sans',
			'Rosario',
			'Rosarivo',
			'Rouge+Script',
			'Rowdies',
			'Rozha+One',
			'Rubik',
			'Rubik+Mono+One',
			'Ruda',
			'Rufina',
			'Ruge+Boogie',
			'Ruluko',
			'Rum+Raisin',
			'Ruslan+Display',
			'Russo+One',
			'Ruthie',
			'Rye',
			'Sacramento',
			'Sahitya',
			'Sail',
			'Saira',
			'Saira+Condensed',
			'Saira+Extra+Condensed',
			'Saira+Semi+Condensed',
			'Saira+Stencil+One',
			'Salsa',
			'Sanchez',
			'Sancreek',
			'Sansita',
			'Sansita+Swashed',
			'Sarabun',
			'Sarala',
			'Sarina',
			'Sarpanch',
			'Satisfy',
			'Sawarabi+Gothic',
			'Sawarabi+Mincho',
			'Scada',
			'Scheherazade',
			'Schoolbell',
			'Scope+One',
			'Seaweed+Script',
			'Secular+One',
			'Sedgwick+Ave',
			'Sedgwick+Ave+Display',
			'Sen',
			'Sevillana',
			'Seymour+One',
			'Shadows+Into+Light',
			'Shadows+Into+Light+Two',
			'Shanti',
			'Share',
			'Share+Tech',
			'Share+Tech+Mono',
			'Shojumaru',
			'Short+Stack',
			'Shrikhand',
			'Siemreap',
			'Sigmar+One',
			'Signika',
			'Signika+Negative',
			'Simonetta',
			'Single+Day',
			'Sintony',
			'Sirin+Stencil',
			'Six+Caps',
			'Skranji',
			'Slabo+13px',
			'Slabo+27px',
			'Slackey',
			'Smokum',
			'Smythe',
			'Sniglet',
			'Snippet',
			'Snowburst+One',
			'Sofadi+One',
			'Sofia',
			'Solway',
			'Song+Myung',
			'Sonsie+One',
			'Sora',
			'Sorts+Mill+Goudy',
			'Source+Code+Pro',
			'Source+Sans+Pro',
			'Source+Serif+Pro',
			'Space+Grotesk',
			'Space+Mono',
			'Spartan',
			'Special+Elite',
			'Spectral',
			'Spectral+SC',
			'Spicy+Rice',
			'Spinnaker',
			'Spirax',
			'Squada+One',
			'Sree+Krushnadevaraya',
			'Sriracha',
			'Srisakdi',
			'Staatliches',
			'Stalemate',
			'Stalinist+One',
			'Stardos+Stencil',
			'Stint+Ultra+Condensed',
			'Stint+Ultra+Expanded',
			'Stoke',
			'Strait',
			'Stylish',
			'Sue+Ellen+Francisco',
			'Suez+One',
			'Sulphur+Point',
			'Sumana',
			'Sunflower',
			'Sunshiney',
			'Supermercado+One',
			'Sura',
			'Suranna',
			'Suravaram',
			'Suwannaphum',
			'Swanky+and+Moo+Moo',
			'Syncopate',
			'Syne',
			'Syne+Mono',
			'Syne+Tactile',
			'Tajawal',
			'Tangerine',
			'Taprom',
			'Tauri',
			'Taviraj',
			'Teko',
			'Telex',
			'Tenali+Ramakrishna',
			'Tenor+Sans',
			'Text+Me+One',
			'Texturina',
			'Thasadith',
			'The+Girl+Next+Door',
			'Tienne',
			'Tillana',
			'Timmana',
			'Tinos',
			'Titan+One',
			'Titillium+Web',
			'Tomorrow',
			'Trade+Winds',
			'Trirong',
			'Trispace',
			'Trocchi',
			'Trochut',
			'Trykker',
			'Tulpen+One',
			'Turret+Road',
			'Ubuntu',
			'Ubuntu+Condensed',
			'Ubuntu+Mono',
			'Ultra',
			'Uncial+Antiqua',
			'Underdog',
			'Unica+One',
			'UnifrakturCook',
			'UnifrakturMaguntia',
			'Unkempt',
			'Unlock',
			'Unna',
			'VT323',
			'Vampiro+One',
			'Varela',
			'Varela+Round',
			'Varta',
			'Vast+Shadow',
			'Vesper+Libre',
			'Viaoda+Libre',
			'Vibes',
			'Vibur',
			'Vidaloka',
			'Viga',
			'Voces',
			'Volkhov',
			'Vollkorn',
			'Vollkorn+SC',
			'Voltaire',
			'Waiting+for+the+Sunrise',
			'Wallpoet',
			'Walter+Turncoat',
			'Warnes',
			'Wellfleet',
			'Wendy+One',
			'Wire+One',
			'Work+Sans',
			'Xanh+Mono',
			'Yanone+Kaffeesatz',
			'Yantramanav',
			'Yatra+One',
			'Yellowtail',
			'Yeon+Sung',
			'Yeseva+One',
			'Yesteryear',
			'Yrsa',
			'Yusei+Magic',
			'ZCOOL+KuaiLe',
			'ZCOOL+QingKe+HuangYou',
			'ZCOOL+XiaoWei',
			'Zeyada',
			'Zhi+Mang+Xing',
			'Zilla+Slab',
			'Zilla+Slab+Highlight',
		];

	 //Early Access Google Web fonts
		var earlyaccessFonts = {
			earlyaccess: [

				//Arabic Fonts
				{ fontName: 'Cairo',        text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Amiri',        text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Lateef',       text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Scheherazade', text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Changa',       text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Lemonada',     text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Lalezar',      text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Mirza',        text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Rakkas',       text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Mada',         text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Katibeh',      text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Jomhuria',     text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Harmattan',    text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'El Messiri',   text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Reem Kufi',    text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},
				{ fontName: 'Aref Ruqaa',   text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ'},

				{ fontName: 'early#Droid Arabic Kufi',  text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Droid Arabic Naskh', text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Noto Kufi Arabic',   text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Noto Naskh Arabic',  text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Noto Nastaliq Urdu', text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Thabit',             text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Noto Nastaliq Urdu Draft', text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },
				{ fontName: 'early#Noto Sans Kufi Arabic',    text: 'أبجد هوز حطي كلمن سعفص قرشت ثخذ ضظغ' },

				//Lao Fonts
				{ fontName: 'early#Dhyana',         text: 'ຂອບໃຈຫຼາຍໆເດີ້' },
				{ fontName: 'early#Lao Muang Don',  text: 'ຂອບໃຈຫຼາຍໆເດີ້' },
				{ fontName: 'early#Lao Sans Pro',   text: 'ຂອບໃຈຫຼາຍໆເດີ້' },
				{ fontName: 'early#Noto Sans Lao',  text: 'ຂອບໃຈຫຼາຍໆເດີ້' },
				{ fontName: 'early#Noto Serif Lao', text: 'ຂອບໃຈຫຼາຍໆເດີ້' },
				{ fontName: 'early#Phetsarath',     text: 'ຂອບໃຈຫຼາຍໆເດີ້' },
				{ fontName: 'early#Souliyo',        text: 'ຂອບໃຈຫຼາຍໆເດີ້' },

				//Tamil Fonts
				{ fontName: 'early#Droid Sans Tamil', text:'வாருங்கள்'},
				{ fontName: 'early#Karla Tamil Inclined', text:'வாருங்கள்'},
				{ fontName: 'early#Karla Tamil Upright', text:'வாருங்கள்'},
				{ fontName: 'early#Lohit Tamil', text:'வாருங்கள்'},
				{ fontName: 'early#Noto Sans Tamil', text:'வாருங்கள்'},

				//Thai
				{ fontName: 'early#Droid Sans Thai', text:'ยินดีต้อนรับ'},
				{ fontName: 'early#Droid Serif Thai', text:'ยินดีต้อนรับ'},
				{ fontName: 'early#Noto Sans Thai', text:'ยินดีต้อนรับ'},

				//Bengali
				{ fontName: 'early#Noto Sans Bengali', text:'স্বাগতম'},
				{ fontName: 'early#Lohit Bengali', text:'স্বাগতম'},

				//Devanagari
				{ fontName: 'early#Noto Sans Devanagari', text:'नमस्कार'},
				{ fontName: 'early#Lohit Devanagari', text:'नमस्कार'},

				//Korean
				{ fontName: 'early#Hanna', text:'환영합니다'},
				{ fontName: 'early#Jeju Gothic', text:'환영합니다'},
				{ fontName: 'early#Jeju Hallasan', text:'환영합니다'},
				{ fontName: 'early#Jeju Myeongjo', text:'환영합니다'},
				{ fontName: 'early#KoPub Batang', text:'환영합니다'},
				{ fontName: 'early#Nanum Brush Script', text:'환영합니다'},
				{ fontName: 'early#Nanum Gothic', text:'환영합니다'},
				{ fontName: 'early#Nanum Myeongjo', text:'환영합니다'},
				{ fontName: 'early#Nanum Pen Script', text:'환영합니다'},
				{ fontName: 'early#Nanum Gothic Coding', text:'환영합니다'},
				{ fontName: 'early#Noto Sans KR', text:'환영합니다'},

				//Balinese
				{ fontName: 'early#Noto Sans Balinese', text:'환영합니다'},

				//Georgian
				{ fontName: 'early#Noto Serif Georgian', text:'გამარჯობა'},
				{ fontName: 'early#Noto Sans Georgian', text:'გამარჯობა'},

				//Georgian
				{ fontName: 'early#Noto Serif Georgian', text:'გამარჯობა'},
				{ fontName: 'early#Noto Sans Georgian', text:'გამარჯობა'},

				//Chinese
				{ fontName: 'early#Noto Sans SC', text:'谢谢'}, //Simplified
				{ fontName: 'early#Noto Sans TC', text:'謝謝'}, //Traditional
				{ fontName: 'early#cwTeXFangSong', text:'謝謝'}, //Traditional
				{ fontName: 'early#cwTeXHei', text:'謝謝'}, //Traditional
				{ fontName: 'early#cwTeXMing', text:'謝謝'}, //Traditional
				{ fontName: 'early#cwTeXKai', text:'謝謝'}, //Traditional

			],
		};

		//FontFace.me Fonts || http://fontface.me/font/all
		var fontfaceME = '[{"name":"\u062c\u0630\u0648\u0631 \u0645\u0633\u0637\u062d","permalink":"flat-jooza"},{"name":"\u0628\u0627\u0633\u0645 \u0645\u0631\u062d","permalink":"basim-marah"},{"name":"\u062d\u0645\u0627\u062f\u0647 \u062e\u0641\u064a\u0641","permalink":"hamada"},{"name":"\u062f\u064a\u0643\u0648 \u062b\u0644\u062b","permalink":"decotype-thuluth"},{"name":"\u0643\u0645\u0628\u0648\u0633\u064a\u062a","permalink":"b-compset"},{"name":"\u0643\u0648\u0641\u064a \u0645\u0632\u062e\u0631\u0641","permalink":"old-antic-decorative"},{"name":"Al Gemah Alhoda","permalink":"al-gemah-alhoda"},{"name":"\u062d\u0627\u0645\u062f","permalink":"b-hamid"},{"name":"\u0645\u062d\u0631\u0645","permalink":"ah-moharram-bold"},{"name":"\u062f\u064a\u0648\u0627\u0646\u064a \u0628\u064a\u0646\u062a","permalink":"diwani-bent"},{"name":"\u0641\u0627\u0631\u0633\u064a \u0628\u0633\u064a\u0637","permalink":"farsi-simple-bold"},{"name":"\u0643\u0648\u0641\u064a \u0639\u0631\u064a\u0636","permalink":"Old-Antic-Bold"},{"name":"\u0627\u0644\u0623\u0645\u064a\u0631\u064a","permalink":"amiri"},{"name":"\u0627\u0644\u0623\u0645\u064a\u0631\u064a \u0639\u0631\u064a\u0636","permalink":"amiri-bold"},{"name":"\u0627\u0644\u0623\u0645\u064a\u0631\u064a \u0645\u0627\u0626\u0644","permalink":"amiri-slanted"},{"name":"\u0627\u0644\u0623\u0645\u064a\u0631\u064a \u0642\u0631\u0622\u0646","permalink":"amiri-quran"},{"name":"\u062f\u0631\u0648\u064a\u062f \u0643\u0648\u0641\u064a","permalink":"DroidKufi-Regular"},{"name":"\u062d\u0645\u0627\u0647","permalink":"hama"},{"name":"\u062c\u0630\u0648\u0631","permalink":"jooza"},{"name":"\u0627\u0644\u0643\u0648\u0641\u064a","permalink":"kufi"},{"name":"\u0641\u0646\u064a","permalink":"fanni"},{"name":"\u0637\u0647\u0631\u0627\u0646","permalink":"btehran"},{"name":"\u0623\u0631\u0627\u0628\u064a\u0643\u0633","permalink":"barabics"},{"name":"\u0627\u0644\u062f\u064a\u0648\u0627\u0646\u064a","permalink":"diwanltr"},{"name":"STC","permalink":"stc"},{"name":"\u0628\u0637\u0631\u0633","permalink":"boutros-ads"},{"name":"Sepideh","permalink":"b-sepideh"},{"name":"\u062b\u0627\u0628\u062a","permalink":"Thabit"},{"name":"\u0646\u0648\u062a\u0648 \u0623\u0648\u0631\u062f\u0648","permalink":"Noto-Urdu"},{"name":"\u0644\u0637\u064a\u0641","permalink":"lateef"},{"name":"\u062f\u0631\u0648\u064a\u062f \u0633\u0627\u0646\u0632","permalink":"droid-sans"},{"name":"\u0627\u0644\u062c\u0632\u064a\u0631\u0629","permalink":"jazeera"},{"name":"\u0631\u0627\u0648\u064a","permalink":"rawi"},{"name":"\u0631\u0627\u0648\u064a \u0633\u062a\u0631\u0627\u064a\u0643","permalink":"strick"},{"name":"\u0645\u064a\u0643\u0633 \u0639\u0631\u0628\u064a","permalink":"themixarab"},{"name":"\u0646\u0648\u0631 \u0647\u062f\u0649","permalink":"noorehuda"},{"name":"\u0627\u0644\u062c\u0632\u0627\u0626\u0631","permalink":"algeria"},{"name":"\u0628\u063a\u062f\u0627\u062f","permalink":"baghdad"},{"name":"\u0623\u0633\u0627\u0645\u0629","permalink":"osama"},{"name":"\u0647\u0627\u0644\u0629","permalink":"hala"},{"name":"\u0627\u0644\u0628\u064a\u0627\u0646","permalink":"albayan"},{"name":"\u0639\u0633\u0627\u0641","permalink":"assaf"},{"name":"\u062a\u0642\u0646\u064a\u0629","permalink":"taqniya"},{"name":"\u0623\u0633\u0645\u0627\u0621","permalink":"asmaa"},{"name":"\u0628\u064f\u0646","permalink":"bon"},{"name":"\u0627\u0644\u0642\u0635\u064a\u0631","permalink":"alqusair"},{"name":"\u0627\u0644\u0634\u0647\u062f\u0627\u0621","permalink":"alshohadaa"},{"name":"\u0639\u0642\u064a\u0642","permalink":"aqeeq"},{"name":"\u062f\u064a\u0627\u0646\u0627","permalink":"diana-light"},{"name":"\u062f\u064a\u0627\u0646\u0627 \u0639\u0631\u064a\u0636","permalink":"diana-regular"},{"name":"\u062c\u0646\u0627\u062a","permalink":"jannat"},{"name":"\u0645\u064a\u062f\u0627\u0646","permalink":"maidan"},{"name":"\u0646\u0648\u0627\u0631","permalink":"nawar"},{"name":"\u0645\u063a\u0631\u0628\u064a","permalink":"maghrebi"},{"name":"\u0627\u0644\u0623\u0648\u0631\u0627\u0633","permalink":"aures"},{"name":"\u064a\u0631\u0627\u0639 \u0631\u0641\u064a\u0639","permalink":"yaraa"},{"name":"\u064a\u0631\u0627\u0639","permalink":"yaraa-regular"},{"name":"\u0644\u0645\u0627\u0631","permalink":"lamar"},{"name":"\u0627\u0644\u062d\u0631","permalink":"alhorr"},{"name":"\u0645\u0633\u0644\u0645\u0629","permalink":"muslimah"},{"name":"\u062d\u064a\u0627\u0647","permalink":"hayah"},{"name":"\u0631\u0648\u062d \u0627\u0644\u062f\u0648\u062d\u0629","permalink":"spirit-of-doha"},{"name":"\u0637\u064a\u0648\u0631 \u0627\u0644\u062c\u0646\u0629","permalink":"toyor-aljanah"},{"name":"\u0634\u0631\u0648\u0642","permalink":"shorooq"},{"name":"\u0627\u0628\u062a\u0633\u0627\u0645","permalink":"Ibtisam"},{"name":"Davat","permalink":"bdavat"},{"name":"\u0641\u0627\u0646\u062a\u0627\u0632\u064a","permalink":"fantezy"},{"name":"\u0627\u0635\u0641\u0647\u0627\u0646","permalink":"esfahan"},{"name":"\u0643\u0648\u0641\u064a \u062b\u0627\u0628\u062a","permalink":"fixed-kufi"},{"name":"\u0627\u0646\u0633\u0627\u0646","permalink":"insan"},{"name":"\u0645\u062a\u0642\u0646","permalink":"motken"},{"name":"kacst \u0641\u0627\u0631\u0633\u064a","permalink":"kacst-farsi"},{"name":"\u0627\u0644\u0645\u0648\u062f\u0647","permalink":"almawadah"},{"name":"\u0634\u0643\u0627\u0631\u064a","permalink":"shekari"},{"name":"\u0627\u0644\u0645\u062c\u062f","permalink":"al-majd"},{"name":"kamran","permalink":"kamran"},{"name":"\u063a\u0644\u0627","permalink":"ghala"},{"name":"\u063a\u0644\u0627 \u0639\u0631\u064a\u0636","permalink":"ghala-bold"},{"name":"\u0628\u0627\u0631\u0627\u0646","permalink":"baran"},{"name":"\u062f\u0631\u0648\u064a\u062f \u0646\u0633\u062e","permalink":"droid-naskh"},{"name":"\u0639\u062b\u0645\u0627\u0646","permalink":"taha-naskh"},{"name":"\u0643\u0648\u0643\u0628","permalink":"kawkab"},{"name":"BEIN \u0628\u064a \u0625\u0646 \u0639\u0631\u064a\u0636","permalink":"bein"},{"name":"\u0628\u064a \u0627\u0646 BEIN","permalink":"bein-normal"},{"name":"\u064a\u0627\u0633\u064a\u0646","permalink":"yassin"},{"name":"\u0627\u0644\u0623\u0631\u062f\u0646","permalink":"jordan"},{"name":"\u0645\u064a\u0644\u0627\u0646\u0648","permalink":"milano"},{"name":"\u062b\u0645\u064a\u0646","permalink":"thameen"},{"name":"MBC","permalink":"mbc"},{"name":"\u0625\u0634\u0631\u0627\u0642","permalink":"ishraq"},{"name":"\u0627\u0644\u0633\u0639\u0648\u062f\u064a\u0629","permalink":"saudi"},{"name":"\u0633\u0628\u0623","permalink":"sheba"},{"name":"\u062a\u0646\u0633\u064a\u0642","permalink":"tanseek"},{"name":"\u0628\u062f\u0627\u064a\u0629 ","permalink":"bedayah"},{"name":"\u0646\u064a\u0643\u0627\u0631","permalink":"neckar"},{"name":"\u0645\u0637\u064a\u0631\u0629","permalink":"motairah"},{"name":"\u0645\u0637\u064a\u0631\u0629 \u062e\u0641\u064a\u0641","permalink":"motairah-light"},{"name":"\u0628\u0647\u064a\u062c","permalink":"bahij"},{"name":"\u0628\u0643\u0631\u0647","permalink":"bokra"},{"name":"\u0633\u0643\u0631","permalink":"sukar"},{"name":"\u0633\u0643\u0631 \u0639\u0631\u064a\u0636","permalink":"sukar-bold"},{"name":"\u0633\u0643\u0631 \u0627\u0633\u0648\u062f","permalink":"sukar-black"},{"name":"\u0625\u0635\u0631\u0627\u0631 \u0633\u0648\u0631\u064a\u0627","permalink":"israr-syria"},{"name":"\u062a\u0634\u0643\u064a\u0644\u064a","permalink":"tachkili"},{"name":"\u0623\u0631\u0648\u0649","permalink":"arwa"},{"name":"\u0627\u0644\u0633\u0645\u0627\u0621","permalink":"sky"},{"name":"\u0639\u0645\u0631","permalink":"omar"},{"name":"\u0634\u064a\u0631\u0627\u0632","permalink":"shiraz"},{"name":"\u0633\u062a\u0627\u0631\u0647","permalink":"setareh"},{"name":"\u062d\u0645\u0627","permalink":"homa"},{"name":"\u0647\u0644\u0627\u0644","permalink":"helal"},{"name":"\u062a\u0635\u0645\u064a\u0645","permalink":"tasmeem-med"},{"name":"\u0631\u0643\u0627\u0633","permalink":"rakkas"},{"name":"\u062c\u0645\u0647\u0648\u0631\u064a\u0629","permalink":"jomhuria"},{"name":"\u0647\u0631\u0645\u062a\u0627\u0646","permalink":"harmattan"},{"name":"\u0643\u062a\u064a\u0628\u0629","permalink":"katibeh"},{"name":"\u0631\u064a\u0645 \u0643\u0648\u0641\u064a","permalink":"reem-kufi"},{"name":"\u0627\u0644\u062c\u0632\u064a\u0631\u0629 \u062e\u0641\u064a\u0641","permalink":"jazeera-light"},{"name":"\u0639\u0627\u0631\u0641 \u0631\u0642\u0639\u0647","permalink":"aref-ruqaa"},{"name":"\u0627\u0644\u0642\u0627\u0647\u0631\u0629","permalink":"cairo"},{"name":"\u0627\u0644\u0642\u0627\u0647\u0631\u0629 \u062e\u0641\u064a\u0641","permalink":"cairo-light"},{"name":"\u0627\u0644\u0642\u0627\u0647\u0631\u0629 \u062e\u0641\u064a\u0641 \u062c\u062f\u0627","permalink":"cairo-extra-light"},{"name":"\u0627\u0644\u0642\u0627\u0647\u0631\u0629 \u062b\u0642\u064a\u0644","permalink":"cairo-bold"},{"name":"\u0627\u0644\u0645\u0633\u064a\u0631\u064a","permalink":"elmessiri"},{"name":"\u0627\u0644\u0645\u0633\u064a\u0631\u064a \u062b\u0642\u064a\u0644","permalink":"elmessiri-bold"},{"name":"\u0627\u0644\u0645\u0633\u064a\u0631\u064a \u062e\u0641\u064a\u0641","permalink":"elmessiri-light"},{"name":"\u0644\u064a\u0645\u0648\u0646\u0627\u062f\u0629","permalink":"lemonada"},{"name":"\u0644\u064a\u0645\u0648\u0646\u0627\u062f\u0629 \u062b\u0642\u064a\u0644","permalink":"lemonada-bold"},{"name":"\u0644\u064a\u0645\u0648\u0646\u0627\u062f\u0629 \u062e\u0641\u064a\u0641","permalink":"lemonada-light"},{"name":"\u0645\u062f\u0649","permalink":"mada"},{"name":"\u0645\u062f\u0649 \u062b\u0642\u064a\u0644","permalink":"mada-bold"},{"name":"\u0645\u062f\u0649 \u062e\u0641\u064a\u0641","permalink":"mada-light"},{"name":"\u0645\u064a\u0631\u0632\u0627","permalink":"mirza"},{"name":"\u0645\u064a\u0631\u0632\u0627 \u062b\u0642\u064a\u0644","permalink":"mirza-bold"},{"name":"\u0645\u064a\u0631\u0632\u0627 \u0645\u062a\u0648\u0633\u0637","permalink":"mirza-medium"},{"name":"\u062a\u064a\u0645 \u062e\u0641\u064a\u0641","permalink":"vip-tim-light"},{"name":"\u062a\u064a\u0645","permalink":"vip-tim"},{"name":"\u062a\u064a\u0645 \u062b\u0642\u064a\u0644","permalink":"vip-tim-bold"},{"name":"\u062a\u064a\u0645 \u0627\u0633\u0648\u062f","permalink":"vip-tim-black"},{"name":"\u0633\u0637\u0648\u0631","permalink":"stoor"},{"name":"\u062b\u0644\u062b \u0645\u0632\u062e\u0631\u0641","permalink":"thuluth-decorated"},{"name":"\u0627\u0644\u0645\u0635\u062d\u0641","permalink":"almushaf"},{"name":"\u0634\u0645\u0633","permalink":"shams"},{"name":"\u0633\u0639\u062f\u064a\u0647","permalink":"sadiyah"},{"name":"\u0632\u0647\u0631\u0629","permalink":"zahra"},{"name":"\u0632\u0647\u0631\u0629 \u062b\u0642\u064a\u0644","permalink":"zahra-bold"},{"name":"\u0633\u0645\u0627\u0631\u062a \u0645\u0627\u0646","permalink":"smartman"},{"name":"\u062d\u0627\u0643\u0645","permalink":"vip-hakm"},{"name":"\u062d\u0627\u0643\u0645 \u062e\u0641\u064a\u0641","permalink":"vip-hakm-thin"},{"name":"\u062d\u0627\u0643\u0645 \u062b\u0642\u064a\u0644","permalink":"vip-hakm-bold"},{"name":"\u0635\u0628\u063a\u0647","permalink":"sabgha"},{"name":"\u0646\u0642\u0627\u0621","permalink":"alnaqaa"},{"name":"\u0631\u0627\u0648\u064a \u062e\u0641\u064a\u0641","permalink":"rawy-thin"},{"name":"\u0631\u0627\u0648\u064a \u062b\u0642\u064a\u0644","permalink":"rawy-bold"},{"name":"\u0627\u0644\u062d\u0631\u0647","permalink":"alhurra"},{"name":"\u0634\u0647\u062f","permalink":"shahd"},{"name":"\u0634\u0647\u062f \u0639\u0631\u064a\u0636","permalink":"shahd-bold"},{"name":"\u0646\u064a\u0643\u0627\u0631","permalink":"neckar"},{"name":" \u0646\u064a\u0643\u0627\u0631 \u062b\u0642\u064a\u0644","permalink":"neckar-bold"},{"name":"\u0633\u0627\u0631\u0647","permalink":"sara"},{"name":"\u0627\u0644\u0633\u0645\u0627\u0621 \u062b\u0642\u064a\u0644","permalink":"sky-bold"},{"name":"\u0631\u0628\u0627\u0637","permalink":"rabat"},{"name":"\u0639\u0631\u0628 \u0648\u064a\u0644","permalink":"arabswell-1"},{"name":"\u0631\u0633\u0627\u064a\u0644 \u062e\u0641\u064a\u0641","permalink":"rsail-light"},{"name":"\u0631\u0633\u0627\u064a\u0644 \u062b\u0642\u064a\u0644","permalink":"rsail-bold"},{"name":"\u0631\u0633\u0627\u064a\u0644","permalink":"rsail"},{"name":"\u062f\u0628\u064a \u062b\u0642\u064a\u0644","permalink":"dubai-bold"},{"name":"\u062f\u0628\u064a \u0645\u062a\u0648\u0633\u0637","permalink":"dubai-medium"},{"name":"\u062f\u0628\u064a \u062e\u0641\u064a\u0641","permalink":"dubai-light"},{"name":"\u062f\u0628\u064a","permalink":"dubai"},{"name":"\u062c\u064a\u0632\u0627 \u0628\u0631\u0648","permalink":"geeza-pro"},{"name":"\u062c\u064a\u0632\u0627 \u0628\u0631\u0648 \u062b\u0642\u064a\u0644","permalink":"geeza-pro-bold"},{"name":"\u0627\u0644\u0639\u0647\u062f","permalink":"alahed"}]';


		var fontFaceFonts = JSON.parse( fontfaceME );

		var settings = {
			style: 'font-select',
			placeholder: 'Select a font',
			lookahead: 2,
			api: '//fonts.googleapis.com/css?family=',
			api_early: '//fonts.googleapis.com/earlyaccess/',
			fontfaceApi: '//www.fontstatic.com/f='
		};


		var Fontselect = (function(){

			function Fontselect(original, o){
				this.$original = $(original);
				this.options = o;
				//this.active = false;
				this.setupHtml();
				this.getVisibleFonts();
				this.bindEvents();

				var font = this.$original.val();
				if(font) {
					this.updateSelected();
					this.addFontLink(font);
				}
			}

			Fontselect.prototype.bindEvents = function(){
				$('li', this.$results)
				.click(__bind(this.selectFont, this))
				.mouseenter(__bind(this.activateFont, this))
				.mouseleave(__bind(this.deactivateFont, this));

				$('span', this.$select).click(__bind(this.toggleDrop, this));

				this.$arrow.click(__bind(this.toggleDrop, this));

				$(document).mouseup(function (e){
					if (!$('.font-select').is(e.target) && $('.font-select').has(e.target).length === 0){
						$( '.font-select' ).removeClass('font-select-active');
						$( '.fs-drop' ).hide();
					}
				});

			};

			Fontselect.prototype.toggleDrop = function(ev){

				if(this.$element.hasClass('font-select-active')){
					this.$element.removeClass('font-select-active');
					this.$drop.hide();
					clearInterval(this.visibleInterval);
				}
				else{
					$( '.font-select' ).removeClass('font-select-active');
					$( '.fs-drop' ).hide();

					this.$element.addClass('font-select-active');
					this.$drop.show();
					this.moveToSelected();
					this.visibleInterval = setInterval(__bind(this.getVisibleFonts, this), 500);
				}

				//this.active = !this.active;
			};

			Fontselect.prototype.selectFont = function(){
				var font = $('li.active', this.$results).data('value');
				this.$original.val(font).change();
				this.updateSelected();
				this.toggleDrop();
			};


			Fontselect.prototype.moveToSelected = function(){

				var $li, font = this.$original.val();

				if (font){
					$li = $('li[data-value="'+ font +'"]', this.$results);
				}
				else {
					$li = $("li", this.$results).first();
				}

				if( $li.length ){
					this.$results.scrollTop(0).scrollTop($li.addClass('active').position().top);
				}

			};

			Fontselect.prototype.activateFont = function(ev){
				$('li.active', this.$results).removeClass('active');
				$(ev.currentTarget).addClass('active');
			};

			Fontselect.prototype.deactivateFont = function(ev){
				$(ev.currentTarget).removeClass('active');
			};

			Fontselect.prototype.updateSelected = function(){
				var font = this.$original.val();

				if( font.indexOf( 'early#' ) >= 0 ){
					var earlyaccess = earlyaccessFonts['earlyaccess'];
					l = earlyaccess.length;
					for(var i=0; i<l; i++){
						var fontName =  earlyaccess[i]['fontName'];
						if ( fontName.indexOf( font ) >= 0 ){
							var fontText = earlyaccess[i]['fontName'].replace( 'early#', '');
							//var fontText = earlyaccess[i]['text'];
							break;
						}
					}
				}
				else{
					var fontText = this.toReadable(font);
				}

				$('span', this.$element).text(fontText).css(this.toStyle(font));
			};

			Fontselect.prototype.setupHtml = function(){
				this.$original.empty().hide();
				this.$element = $('<div>', {'class': this.options.style});
				this.$arrow = $('<div><b></b></div>');
				this.$select = $('<a><span>'+ this.options.placeholder +'</span></a>');
				this.$drop = $('<div>', {'class': 'fs-drop'});
				this.$results = $('<ul>', {'class': 'fs-results'});
				this.$original.after(this.$element.append(this.$select.append(this.$arrow)).append(this.$drop));
				this.$drop.append(this.$results.append(this.fontsAsHtml())).hide();
			};

			Fontselect.prototype.fontsAsHtml = function(){

				var r, s, f, h = ' ';

				var l = standardFonts.length;


				if( this.$original.attr( 'id' ).indexOf( 'standard_font' ) >= 0 ){

					//Standard Fonts
					for(var i=0; i<l; i++){
						r = this.toReadable(standardFonts[i]);
						s = this.toStyle(standardFonts[i]);

						h += '<li data-value="'+ standardFonts[i] +'" style="font-family: '+s['font-family'] +'; font-weight: '+s['font-weight'] +'">'+ r +'</li>';
					}

				}

				else if( this.$original.attr( 'id' ).indexOf( '_fontfaceme' ) >= 0 ){

					l = fontFaceFonts.length;

					fontFaceFontName = '';

					for(var i=0; i<l; i++){
						fontFaceFontName = fontFaceFonts[i]['name'];
						fontFaceFontid   = fontFaceFonts[i]['permalink'];

						h += '<li data-value="faceme#'+ fontFaceFontid +'" style="font-size: 20px; font-family: \''+ fontFaceFontid +'\';">'+ fontFaceFontName +'</li>';
					}

				}

				else{
					//Google Fonts
					var l = fonts.length;
					for(var i=0; i<l; i++){
						r = this.toReadable(fonts[i]);
						s = this.toStyle(fonts[i]);

						h += '<li data-value="'+ fonts[i] +'" style="font-family: '+s['font-family'] +'; font-weight: '+s['font-weight'] +'">'+ r +'</li>';
					}

					//Early Access fonts
					var earlyaccess = earlyaccessFonts['earlyaccess'],
					earlyFontName = '';
					l = earlyaccess.length;

					for(var i=0; i<l; i++){
						earlyFontName = earlyaccess[i]['fontName'];
						earlyFontStyle = earlyFontName.replace( 'early#', '');
						r = earlyaccess[i]['text'];
						s = this.toStyle( earlyFontStyle );
						h += '<li data-value="'+ earlyFontName +'" style="font-family: \''+s['font-family'] +'\'; font-weight: '+s['font-weight'] +'">'+ r +'</li>';
					}

				};

				return h;
			};

			Fontselect.prototype.toReadable = function(font){
				if ( font.indexOf( 'safefont#' ) >= 0 ){
					font = font.replace( 'safefont#', '');
				}

				else if ( font.indexOf( 'early#' ) >= 0 ){
					font = font.replace( 'early#', '');
				}

				else if( font.indexOf( 'faceme#' ) >= 0 ){
					font = font.replace( 'faceme#', '');
				}

				return font.replace(/[\+|:]/g, ' ').replace( /\'/g, '');
			};

			Fontselect.prototype.toStyle = function(font){

				if( font.indexOf( 'safefont#' ) >= 0 ){
					font = font.replace( 'safefont#', '');
				}

				else if( font.indexOf( 'early#' ) >= 0 ){
					font = font.replace( 'early#', '');
				}

				else if( font.indexOf( 'faceme#' ) >= 0 ){
					font = font.replace( 'faceme#', '');
				}

				var t = font.split(':');
				return {'font-family': this.toReadable(t[0]), 'font-weight': (t[1] || 400)};

			};

			Fontselect.prototype.getVisibleFonts = function(){

				if(this.$results.is(':hidden')) return;

				var fs = this;
				var top = this.$results.scrollTop();
				var bottom = top + this.$results.height();

				if(this.options.lookahead){
					var li = $('li', this.$results).first().height();
					bottom += li*this.options.lookahead;
				}

				$('li', this.$results).each(function(){

					var ft = $(this).position().top+top;
					var fb = ft + $(this).height();

					if ((fb >= top) && (ft <= bottom)){
						var font = $(this).data('value');
						fs.addFontLink(font);
					}

				});
			};

			Fontselect.prototype.addFontLink = function(font){

				if ( font.indexOf( 'safefont#' ) >= 0 ){
					return;
				}
				else if ( font.indexOf( 'faceme#' ) >= 0 ){
					font = font.replace( 'faceme#', '').replace( / /g, '' ).toLowerCase();
					var link = this.options.fontfaceApi + font;
				}
				else if ( font.indexOf( 'early#' ) >= 0 ){
					font = font.replace( 'early#', '').replace( / /g, '' ).toLowerCase();
					var link = this.options.api_early + font + '.css';
				}
				else{
					var link = this.options.api + font;
				}

				if ($("link[href*='" + font + "']").length === 0){
					$('link:last').after('<link href="' + link + '" rel="stylesheet" type="text/css">');
				}

			};

			return Fontselect;
		})();

		return this.each(function(options) {
			// If options exist, lets merge them
			if (options) $.extend( settings, options );

			return new Fontselect(this, settings);
		});

	};

})(jQuery);



/* Icon Picker */
(function($) {

	$.fn.iconPicker = function( ) {

		var $list = jQuery('');
		var icons = [
			'blank',
			'fab fa-500px',
			'fab fa-accessible-icon',
			'fab fa-accusoft',
			'fab fa-acquisitions-incorporated',
			'fas fa-ad',
			'fas fa-address-book',
			'far fa-address-book',
			'fas fa-address-card',
			'far fa-address-card',
			'fas fa-adjust',
			'fab fa-adn',
			'fab fa-adobe',
			'fab fa-adversal',
			'fab fa-affiliatetheme',
			'fas fa-air-freshener',
			'fab fa-airbnb',
			'fab fa-algolia',
			'fas fa-align-center',
			'fas fa-align-justify',
			'fas fa-align-left',
			'fas fa-align-right',
			'fab fa-alipay',
			'fas fa-allergies',
			'fab fa-amazon',
			'fab fa-amazon-pay',
			'fas fa-ambulance',
			'fas fa-american-sign-language-interpreting',
			'fab fa-amilia',
			'fas fa-anchor',
			'fab fa-android',
			'fab fa-angellist',
			'fas fa-angle-double-down',
			'fas fa-angle-double-left',
			'fas fa-angle-double-right',
			'fas fa-angle-double-up',
			'fas fa-angle-down',
			'fas fa-angle-left',
			'fas fa-angle-right',
			'fas fa-angle-up',
			'fas fa-angry',
			'far fa-angry',
			'fab fa-angrycreative',
			'fab fa-angular',
			'fas fa-ankh',
			'fab fa-app-store',
			'fab fa-app-store-ios',
			'fab fa-apper',
			'fab fa-apple',
			'fas fa-apple-alt',
			'fab fa-apple-pay',
			'fas fa-archive',
			'fas fa-archway',
			'fas fa-arrow-alt-circle-down',
			'far fa-arrow-alt-circle-down',
			'fas fa-arrow-alt-circle-left',
			'far fa-arrow-alt-circle-left',
			'fas fa-arrow-alt-circle-right',
			'far fa-arrow-alt-circle-right',
			'fas fa-arrow-alt-circle-up',
			'far fa-arrow-alt-circle-up',
			'fas fa-arrow-circle-down',
			'fas fa-arrow-circle-left',
			'fas fa-arrow-circle-right',
			'fas fa-arrow-circle-up',
			'fas fa-arrow-down',
			'fas fa-arrow-left',
			'fas fa-arrow-right',
			'fas fa-arrow-up',
			'fas fa-arrows-alt',
			'fas fa-arrows-alt-h',
			'fas fa-arrows-alt-v',
			'fab fa-artstation',
			'fas fa-assistive-listening-systems',
			'fas fa-asterisk',
			'fab fa-asymmetrik',
			'fas fa-at',
			'fas fa-atlas',
			'fab fa-atlassian',
			'fas fa-atom',
			'fab fa-audible',
			'fas fa-audio-description',
			'fab fa-autoprefixer',
			'fab fa-avianex',
			'fab fa-aviato',
			'fas fa-award',
			'fab fa-aws',
			'fas fa-baby',
			'fas fa-baby-carriage',
			'fas fa-backspace',
			'fas fa-backward',
			'fas fa-bacon',
			'fas fa-bahai',
			'fas fa-balance-scale',
			'fas fa-balance-scale-left',
			'fas fa-balance-scale-right',
			'fas fa-ban',
			'fas fa-band-aid',
			'fab fa-bandcamp',
			'fas fa-barcode',
			'fas fa-bars',
			'fas fa-baseball-ball',
			'fas fa-basketball-ball',
			'fas fa-bath',
			'fas fa-battery-empty',
			'fas fa-battery-full',
			'fas fa-battery-half',
			'fas fa-battery-quarter',
			'fas fa-battery-three-quarters',
			'fab fa-battle-net',
			'fas fa-bed',
			'fas fa-beer',
			'fab fa-behance',
			'fab fa-behance-square',
			'fas fa-bell',
			'far fa-bell',
			'fas fa-bell-slash',
			'far fa-bell-slash',
			'fas fa-bezier-curve',
			'fas fa-bible',
			'fas fa-bicycle',
			'fas fa-biking',
			'fab fa-bimobject',
			'fas fa-binoculars',
			'fas fa-biohazard',
			'fas fa-birthday-cake',
			'fab fa-bitbucket',
			'fab fa-bitcoin',
			'fab fa-bity',
			'fab fa-black-tie',
			'fab fa-blackberry',
			'fas fa-blender',
			'fas fa-blender-phone',
			'fas fa-blind',
			'fas fa-blog',
			'fab fa-blogger',
			'fab fa-blogger-b',
			'fab fa-bluetooth',
			'fab fa-bluetooth-b',
			'fas fa-bold',
			'fas fa-bolt',
			'fas fa-bomb',
			'fas fa-bone',
			'fas fa-bong',
			'fas fa-book',
			'fas fa-book-dead',
			'fas fa-book-medical',
			'fas fa-book-open',
			'fas fa-book-reader',
			'fas fa-bookmark',
			'far fa-bookmark',
			'fab fa-bootstrap',
			'fas fa-border-all',
			'fas fa-border-none',
			'fas fa-border-style',
			'fas fa-bowling-ball',
			'fas fa-box',
			'fas fa-box-open',
			'fas fa-box-tissue',
			'fas fa-boxes',
			'fas fa-braille',
			'fas fa-brain',
			'fas fa-bread-slice',
			'fas fa-briefcase',
			'fas fa-briefcase-medical',
			'fas fa-broadcast-tower',
			'fas fa-broom',
			'fas fa-brush',
			'fab fa-btc',
			'fab fa-buffer',
			'fas fa-bug',
			'fas fa-building',
			'far fa-building',
			'fas fa-bullhorn',
			'fas fa-bullseye',
			'fas fa-burn',
			'fab fa-buromobelexperte',
			'fas fa-bus',
			'fas fa-bus-alt',
			'fas fa-business-time',
			'fab fa-buy-n-large',
			'fab fa-buysellads',
			'fas fa-calculator',
			'fas fa-calendar',
			'far fa-calendar',
			'fas fa-calendar-alt',
			'far fa-calendar-alt',
			'fas fa-calendar-check',
			'far fa-calendar-check',
			'fas fa-calendar-day',
			'fas fa-calendar-minus',
			'far fa-calendar-minus',
			'fas fa-calendar-plus',
			'far fa-calendar-plus',
			'fas fa-calendar-times',
			'far fa-calendar-times',
			'fas fa-calendar-week',
			'fas fa-camera',
			'fas fa-camera-retro',
			'fas fa-campground',
			'fab fa-canadian-maple-leaf',
			'fas fa-candy-cane',
			'fas fa-cannabis',
			'fas fa-capsules',
			'fas fa-car',
			'fas fa-car-alt',
			'fas fa-car-battery',
			'fas fa-car-crash',
			'fas fa-car-side',
			'fas fa-caravan',
			'fas fa-caret-down',
			'fas fa-caret-left',
			'fas fa-caret-right',
			'fas fa-caret-square-down',
			'far fa-caret-square-down',
			'fas fa-caret-square-left',
			'far fa-caret-square-left',
			'fas fa-caret-square-right',
			'far fa-caret-square-right',
			'fas fa-caret-square-up',
			'far fa-caret-square-up',
			'fas fa-caret-up',
			'fas fa-carrot',
			'fas fa-cart-arrow-down',
			'fas fa-cart-plus',
			'fas fa-cash-register',
			'fas fa-cat',
			'fab fa-cc-amazon-pay',
			'fab fa-cc-amex',
			'fab fa-cc-apple-pay',
			'fab fa-cc-diners-club',
			'fab fa-cc-discover',
			'fab fa-cc-jcb',
			'fab fa-cc-mastercard',
			'fab fa-cc-paypal',
			'fab fa-cc-stripe',
			'fab fa-cc-visa',
			'fab fa-centercode',
			'fab fa-centos',
			'fas fa-certificate',
			'fas fa-chair',
			'fas fa-chalkboard',
			'fas fa-chalkboard-teacher',
			'fas fa-charging-station',
			'fas fa-chart-area',
			'fas fa-chart-bar',
			'far fa-chart-bar',
			'fas fa-chart-line',
			'fas fa-chart-pie',
			'fas fa-check',
			'fas fa-check-circle',
			'far fa-check-circle',
			'fas fa-check-double',
			'fas fa-check-square',
			'far fa-check-square',
			'fas fa-cheese',
			'fas fa-chess',
			'fas fa-chess-bishop',
			'fas fa-chess-board',
			'fas fa-chess-king',
			'fas fa-chess-knight',
			'fas fa-chess-pawn',
			'fas fa-chess-queen',
			'fas fa-chess-rook',
			'fas fa-chevron-circle-down',
			'fas fa-chevron-circle-left',
			'fas fa-chevron-circle-right',
			'fas fa-chevron-circle-up',
			'fas fa-chevron-down',
			'fas fa-chevron-left',
			'fas fa-chevron-right',
			'fas fa-chevron-up',
			'fas fa-child',
			'fab fa-chrome',
			'fab fa-chromecast',
			'fas fa-church',
			'fas fa-circle',
			'far fa-circle',
			'fas fa-circle-notch',
			'fas fa-city',
			'fas fa-clinic-medical',
			'fas fa-clipboard',
			'far fa-clipboard',
			'fas fa-clipboard-check',
			'fas fa-clipboard-list',
			'fas fa-clock',
			'far fa-clock',
			'fas fa-clone',
			'far fa-clone',
			'fas fa-closed-captioning',
			'far fa-closed-captioning',
			'fas fa-cloud',
			'fas fa-cloud-download-alt',
			'fas fa-cloud-meatball',
			'fas fa-cloud-moon',
			'fas fa-cloud-moon-rain',
			'fas fa-cloud-rain',
			'fas fa-cloud-showers-heavy',
			'fas fa-cloud-sun',
			'fas fa-cloud-sun-rain',
			'fas fa-cloud-upload-alt',
			'fab fa-cloudscale',
			'fab fa-cloudsmith',
			'fab fa-cloudversify',
			'fas fa-cocktail',
			'fas fa-code',
			'fas fa-code-branch',
			'fab fa-codepen',
			'fab fa-codiepie',
			'fas fa-coffee',
			'fas fa-cog',
			'fas fa-cogs',
			'fas fa-coins',
			'fas fa-columns',
			'fas fa-comment',
			'far fa-comment',
			'fas fa-comment-alt',
			'far fa-comment-alt',
			'fas fa-comment-dollar',
			'fas fa-comment-dots',
			'far fa-comment-dots',
			'fas fa-comment-medical',
			'fas fa-comment-slash',
			'fas fa-comments',
			'far fa-comments',
			'fas fa-comments-dollar',
			'fas fa-compact-disc',
			'fas fa-compass',
			'far fa-compass',
			'fas fa-compress',
			'fas fa-compress-alt',
			'fas fa-compress-arrows-alt',
			'fas fa-concierge-bell',
			'fab fa-confluence',
			'fab fa-connectdevelop',
			'fab fa-contao',
			'fas fa-cookie',
			'fas fa-cookie-bite',
			'fas fa-copy',
			'far fa-copy',
			'fas fa-copyright',
			'far fa-copyright',
			'fab fa-cotton-bureau',
			'fas fa-couch',
			'fab fa-cpanel',
			'fab fa-creative-commons',
			'fab fa-creative-commons-by',
			'fab fa-creative-commons-nc',
			'fab fa-creative-commons-nc-eu',
			'fab fa-creative-commons-nc-jp',
			'fab fa-creative-commons-nd',
			'fab fa-creative-commons-pd',
			'fab fa-creative-commons-pd-alt',
			'fab fa-creative-commons-remix',
			'fab fa-creative-commons-sa',
			'fab fa-creative-commons-sampling',
			'fab fa-creative-commons-sampling-plus',
			'fab fa-creative-commons-share',
			'fab fa-creative-commons-zero',
			'fas fa-credit-card',
			'far fa-credit-card',
			'fab fa-critical-role',
			'fas fa-crop',
			'fas fa-crop-alt',
			'fas fa-cross',
			'fas fa-crosshairs',
			'fas fa-crow',
			'fas fa-crown',
			'fas fa-crutch',
			'fab fa-css3',
			'fab fa-css3-alt',
			'fas fa-cube',
			'fas fa-cubes',
			'fas fa-cut',
			'fab fa-cuttlefish',
			'fab fa-d-and-d',
			'fab fa-d-and-d-beyond',
			'fab fa-dailymotion',
			'fab fa-dashcube',
			'fas fa-database',
			'fas fa-deaf',
			'fab fa-delicious',
			'fas fa-democrat',
			'fab fa-deploydog',
			'fab fa-deskpro',
			'fas fa-desktop',
			'fab fa-dev',
			'fab fa-deviantart',
			'fas fa-dharmachakra',
			'fab fa-dhl',
			'fas fa-diagnoses',
			'fab fa-diaspora',
			'fas fa-dice',
			'fas fa-dice-d20',
			'fas fa-dice-d6',
			'fas fa-dice-five',
			'fas fa-dice-four',
			'fas fa-dice-one',
			'fas fa-dice-six',
			'fas fa-dice-three',
			'fas fa-dice-two',
			'fab fa-digg',
			'fab fa-digital-ocean',
			'fas fa-digital-tachograph',
			'fas fa-directions',
			'fab fa-discord',
			'fab fa-discourse',
			'fas fa-disease',
			'fas fa-divide',
			'fas fa-dizzy',
			'far fa-dizzy',
			'fas fa-dna',
			'fab fa-dochub',
			'fab fa-docker',
			'fas fa-dog',
			'fas fa-dollar-sign',
			'fas fa-dolly',
			'fas fa-dolly-flatbed',
			'fas fa-donate',
			'fas fa-door-closed',
			'fas fa-door-open',
			'fas fa-dot-circle',
			'far fa-dot-circle',
			'fas fa-dove',
			'fas fa-download',
			'fab fa-draft2digital',
			'fas fa-drafting-compass',
			'fas fa-dragon',
			'fas fa-draw-polygon',
			'fab fa-dribbble',
			'fab fa-dribbble-square',
			'fab fa-dropbox',
			'fas fa-drum',
			'fas fa-drum-steelpan',
			'fas fa-drumstick-bite',
			'fab fa-drupal',
			'fas fa-dumbbell',
			'fas fa-dumpster',
			'fas fa-dumpster-fire',
			'fas fa-dungeon',
			'fab fa-dyalog',
			'fab fa-earlybirds',
			'fab fa-ebay',
			'fab fa-edge',
			'fas fa-edit',
			'far fa-edit',
			'fas fa-egg',
			'fas fa-eject',
			'fab fa-elementor',
			'fas fa-ellipsis-h',
			'fas fa-ellipsis-v',
			'fab fa-ello',
			'fab fa-ember',
			'fab fa-empire',
			'fas fa-envelope',
			'far fa-envelope',
			'fas fa-envelope-open',
			'far fa-envelope-open',
			'fas fa-envelope-open-text',
			'fas fa-envelope-square',
			'fab fa-envira',
			'fas fa-equals',
			'fas fa-eraser',
			'fab fa-erlang',
			'fab fa-ethereum',
			'fas fa-ethernet',
			'fab fa-etsy',
			'fas fa-euro-sign',
			'fab fa-evernote',
			'fas fa-exchange-alt',
			'fas fa-exclamation',
			'fas fa-exclamation-circle',
			'fas fa-exclamation-triangle',
			'fas fa-expand',
			'fas fa-expand-alt',
			'fas fa-expand-arrows-alt',
			'fab fa-expeditedssl',
			'fas fa-external-link-alt',
			'fas fa-external-link-square-alt',
			'fas fa-eye',
			'far fa-eye',
			'fas fa-eye-dropper',
			'fas fa-eye-slash',
			'far fa-eye-slash',
			'fab fa-facebook',
			'fab fa-facebook-f',
			'fab fa-facebook-messenger',
			'fab fa-facebook-square',
			'fas fa-fan',
			'fab fa-fantasy-flight-games',
			'fas fa-fast-backward',
			'fas fa-fast-forward',
			'fas fa-faucet',
			'fas fa-fax',
			'fas fa-feather',
			'fas fa-feather-alt',
			'fab fa-fedex',
			'fab fa-fedora',
			'fas fa-female',
			'fas fa-fighter-jet',
			'fab fa-figma',
			'fas fa-file',
			'far fa-file',
			'fas fa-file-alt',
			'far fa-file-alt',
			'fas fa-file-archive',
			'far fa-file-archive',
			'fas fa-file-audio',
			'far fa-file-audio',
			'fas fa-file-code',
			'far fa-file-code',
			'fas fa-file-contract',
			'fas fa-file-csv',
			'fas fa-file-download',
			'fas fa-file-excel',
			'far fa-file-excel',
			'fas fa-file-export',
			'fas fa-file-image',
			'far fa-file-image',
			'fas fa-file-import',
			'fas fa-file-invoice',
			'fas fa-file-invoice-dollar',
			'fas fa-file-medical',
			'fas fa-file-medical-alt',
			'fas fa-file-pdf',
			'far fa-file-pdf',
			'fas fa-file-powerpoint',
			'far fa-file-powerpoint',
			'fas fa-file-prescription',
			'fas fa-file-signature',
			'fas fa-file-upload',
			'fas fa-file-video',
			'far fa-file-video',
			'fas fa-file-word',
			'far fa-file-word',
			'fas fa-fill',
			'fas fa-fill-drip',
			'fas fa-film',
			'fas fa-filter',
			'fas fa-fingerprint',
			'fas fa-fire',
			'fas fa-fire-alt',
			'fas fa-fire-extinguisher',
			'fab fa-firefox',
			'fab fa-firefox-browser',
			'fas fa-first-aid',
			'fab fa-first-order',
			'fab fa-first-order-alt',
			'fab fa-firstdraft',
			'fas fa-fish',
			'fas fa-fist-raised',
			'fas fa-flag',
			'far fa-flag',
			'fas fa-flag-checkered',
			'fas fa-flag-usa',
			'fas fa-flask',
			'fab fa-flickr',
			'fab fa-flipboard',
			'fas fa-flushed',
			'far fa-flushed',
			'fab fa-fly',
			'fas fa-folder',
			'far fa-folder',
			'fas fa-folder-minus',
			'fas fa-folder-open',
			'far fa-folder-open',
			'fas fa-folder-plus',
			'fas fa-font',
			'fab fa-font-awesome',
			'fab fa-font-awesome-alt',
			'fab fa-font-awesome-flag',
			'fab fa-fonticons',
			'fab fa-fonticons-fi',
			'fas fa-football-ball',
			'fab fa-fort-awesome',
			'fab fa-fort-awesome-alt',
			'fab fa-forumbee',
			'fas fa-forward',
			'fab fa-foursquare',
			'fab fa-free-code-camp',
			'fab fa-freebsd',
			'fas fa-frog',
			'fas fa-frown',
			'far fa-frown',
			'fas fa-frown-open',
			'far fa-frown-open',
			'fab fa-fulcrum',
			'fas fa-funnel-dollar',
			'fas fa-futbol',
			'far fa-futbol',
			'fab fa-galactic-republic',
			'fab fa-galactic-senate',
			'fas fa-gamepad',
			'fas fa-gas-pump',
			'fas fa-gavel',
			'fas fa-gem',
			'far fa-gem',
			'fas fa-genderless',
			'fab fa-get-pocket',
			'fab fa-gg',
			'fab fa-gg-circle',
			'fas fa-ghost',
			'fas fa-gift',
			'fas fa-gifts',
			'fab fa-git',
			'fab fa-git-alt',
			'fab fa-git-square',
			'fab fa-github',
			'fab fa-github-alt',
			'fab fa-github-square',
			'fab fa-gitkraken',
			'fab fa-gitlab',
			'fab fa-gitter',
			'fas fa-glass-cheers',
			'fas fa-glass-martini',
			'fas fa-glass-martini-alt',
			'fas fa-glass-whiskey',
			'fas fa-glasses',
			'fab fa-glide',
			'fab fa-glide-g',
			'fas fa-globe',
			'fas fa-globe-africa',
			'fas fa-globe-americas',
			'fas fa-globe-asia',
			'fas fa-globe-europe',
			'fab fa-gofore',
			'fas fa-golf-ball',
			'fab fa-goodreads',
			'fab fa-goodreads-g',
			'fab fa-google',
			'fab fa-google-drive',
			'fab fa-google-play',
			'fab fa-google-plus',
			'fab fa-google-plus-g',
			'fab fa-google-plus-square',
			'fab fa-google-wallet',
			'fas fa-gopuram',
			'fas fa-graduation-cap',
			'fab fa-gratipay',
			'fab fa-grav',
			'fas fa-greater-than',
			'fas fa-greater-than-equal',
			'fas fa-grimace',
			'far fa-grimace',
			'fas fa-grin',
			'far fa-grin',
			'fas fa-grin-alt',
			'far fa-grin-alt',
			'fas fa-grin-beam',
			'far fa-grin-beam',
			'fas fa-grin-beam-sweat',
			'far fa-grin-beam-sweat',
			'fas fa-grin-hearts',
			'far fa-grin-hearts',
			'fas fa-grin-squint',
			'far fa-grin-squint',
			'fas fa-grin-squint-tears',
			'far fa-grin-squint-tears',
			'fas fa-grin-stars',
			'far fa-grin-stars',
			'fas fa-grin-tears',
			'far fa-grin-tears',
			'fas fa-grin-tongue',
			'far fa-grin-tongue',
			'fas fa-grin-tongue-squint',
			'far fa-grin-tongue-squint',
			'fas fa-grin-tongue-wink',
			'far fa-grin-tongue-wink',
			'fas fa-grin-wink',
			'far fa-grin-wink',
			'fas fa-grip-horizontal',
			'fas fa-grip-lines',
			'fas fa-grip-lines-vertical',
			'fas fa-grip-vertical',
			'fab fa-gripfire',
			'fab fa-grunt',
			'fas fa-guitar',
			'fab fa-gulp',
			'fas fa-h-square',
			'fab fa-hacker-news',
			'fab fa-hacker-news-square',
			'fab fa-hackerrank',
			'fas fa-hamburger',
			'fas fa-hammer',
			'fas fa-hamsa',
			'fas fa-hand-holding',
			'fas fa-hand-holding-heart',
			'fas fa-hand-holding-medical',
			'fas fa-hand-holding-usd',
			'fas fa-hand-holding-water',
			'fas fa-hand-lizard',
			'far fa-hand-lizard',
			'fas fa-hand-middle-finger',
			'fas fa-hand-paper',
			'far fa-hand-paper',
			'fas fa-hand-peace',
			'far fa-hand-peace',
			'fas fa-hand-point-down',
			'far fa-hand-point-down',
			'fas fa-hand-point-left',
			'far fa-hand-point-left',
			'fas fa-hand-point-right',
			'far fa-hand-point-right',
			'fas fa-hand-point-up',
			'far fa-hand-point-up',
			'fas fa-hand-pointer',
			'far fa-hand-pointer',
			'fas fa-hand-rock',
			'far fa-hand-rock',
			'fas fa-hand-scissors',
			'far fa-hand-scissors',
			'fas fa-hand-sparkles',
			'fas fa-hand-spock',
			'far fa-hand-spock',
			'fas fa-hands',
			'fas fa-hands-helping',
			'fas fa-hands-wash',
			'fas fa-handshake',
			'far fa-handshake',
			'fas fa-handshake-alt-slash',
			'fas fa-handshake-slash',
			'fas fa-hanukiah',
			'fas fa-hard-hat',
			'fas fa-hashtag',
			'fas fa-hat-cowboy',
			'fas fa-hat-cowboy-side',
			'fas fa-hat-wizard',
			'fas fa-hdd',
			'far fa-hdd',
			'fas fa-head-side-cough',
			'fas fa-head-side-cough-slash',
			'fas fa-head-side-mask',
			'fas fa-head-side-virus',
			'fas fa-heading',
			'fas fa-headphones',
			'fas fa-headphones-alt',
			'fas fa-headset',
			'fas fa-heart',
			'far fa-heart',
			'fas fa-heart-broken',
			'fas fa-heartbeat',
			'fas fa-helicopter',
			'fas fa-highlighter',
			'fas fa-hiking',
			'fas fa-hippo',
			'fab fa-hips',
			'fab fa-hire-a-helper',
			'fas fa-history',
			'fas fa-hockey-puck',
			'fas fa-holly-berry',
			'fas fa-home',
			'fab fa-hooli',
			'fab fa-hornbill',
			'fas fa-horse',
			'fas fa-horse-head',
			'fas fa-hospital',
			'far fa-hospital',
			'fas fa-hospital-alt',
			'fas fa-hospital-symbol',
			'fas fa-hospital-user',
			'fas fa-hot-tub',
			'fas fa-hotdog',
			'fas fa-hotel',
			'fab fa-hotjar',
			'fas fa-hourglass',
			'far fa-hourglass',
			'fas fa-hourglass-end',
			'fas fa-hourglass-half',
			'fas fa-hourglass-start',
			'fas fa-house-damage',
			'fas fa-house-user',
			'fab fa-houzz',
			'fas fa-hryvnia',
			'fab fa-html5',
			'fab fa-hubspot',
			'fas fa-i-cursor',
			'fas fa-ice-cream',
			'fas fa-icicles',
			'fas fa-icons',
			'fas fa-id-badge',
			'far fa-id-badge',
			'fas fa-id-card',
			'far fa-id-card',
			'fas fa-id-card-alt',
			'fab fa-ideal',
			'fas fa-igloo',
			'fas fa-image',
			'far fa-image',
			'fas fa-images',
			'far fa-images',
			'fab fa-imdb',
			'fas fa-inbox',
			'fas fa-indent',
			'fas fa-industry',
			'fas fa-infinity',
			'fas fa-info',
			'fas fa-info-circle',
			'fab fa-instagram',
			'fab fa-instagram-square',
			'fab fa-intercom',
			'fab fa-internet-explorer',
			'fab fa-invision',
			'fab fa-ioxhost',
			'fas fa-italic',
			'fab fa-itch-io',
			'fab fa-itunes',
			'fab fa-itunes-note',
			'fab fa-java',
			'fas fa-jedi',
			'fab fa-jedi-order',
			'fab fa-jenkins',
			'fab fa-jira',
			'fab fa-joget',
			'fas fa-joint',
			'fab fa-joomla',
			'fas fa-journal-whills',
			'fab fa-js',
			'fab fa-js-square',
			'fab fa-jsfiddle',
			'fas fa-kaaba',
			'fab fa-kaggle',
			'fas fa-key',
			'fab fa-keybase',
			'fas fa-keyboard',
			'far fa-keyboard',
			'fab fa-keycdn',
			'fas fa-khanda',
			'fab fa-kickstarter',
			'fab fa-kickstarter-k',
			'fas fa-kiss',
			'far fa-kiss',
			'fas fa-kiss-beam',
			'far fa-kiss-beam',
			'fas fa-kiss-wink-heart',
			'far fa-kiss-wink-heart',
			'fas fa-kiwi-bird',
			'fab fa-korvue',
			'fas fa-landmark',
			'fas fa-language',
			'fas fa-laptop',
			'fas fa-laptop-code',
			'fas fa-laptop-house',
			'fas fa-laptop-medical',
			'fab fa-laravel',
			'fab fa-lastfm',
			'fab fa-lastfm-square',
			'fas fa-laugh',
			'far fa-laugh',
			'fas fa-laugh-beam',
			'far fa-laugh-beam',
			'fas fa-laugh-squint',
			'far fa-laugh-squint',
			'fas fa-laugh-wink',
			'far fa-laugh-wink',
			'fas fa-layer-group',
			'fas fa-leaf',
			'fab fa-leanpub',
			'fas fa-lemon',
			'far fa-lemon',
			'fab fa-less',
			'fas fa-less-than',
			'fas fa-less-than-equal',
			'fas fa-level-down-alt',
			'fas fa-level-up-alt',
			'fas fa-life-ring',
			'far fa-life-ring',
			'fas fa-lightbulb',
			'far fa-lightbulb',
			'fab fa-line',
			'fas fa-link',
			'fab fa-linkedin',
			'fab fa-linkedin-in',
			'fab fa-linode',
			'fab fa-linux',
			'fas fa-lira-sign',
			'fas fa-list',
			'fas fa-list-alt',
			'far fa-list-alt',
			'fas fa-list-ol',
			'fas fa-list-ul',
			'fas fa-location-arrow',
			'fas fa-lock',
			'fas fa-lock-open',
			'fas fa-long-arrow-alt-down',
			'fas fa-long-arrow-alt-left',
			'fas fa-long-arrow-alt-right',
			'fas fa-long-arrow-alt-up',
			'fas fa-low-vision',
			'fas fa-luggage-cart',
			'fas fa-lungs',
			'fas fa-lungs-virus',
			'fab fa-lyft',
			'fab fa-magento',
			'fas fa-magic',
			'fas fa-magnet',
			'fas fa-mail-bulk',
			'fab fa-mailchimp',
			'fas fa-male',
			'fab fa-mandalorian',
			'fas fa-map',
			'far fa-map',
			'fas fa-map-marked',
			'fas fa-map-marked-alt',
			'fas fa-map-marker',
			'fas fa-map-marker-alt',
			'fas fa-map-pin',
			'fas fa-map-signs',
			'fab fa-markdown',
			'fas fa-marker',
			'fas fa-mars',
			'fas fa-mars-double',
			'fas fa-mars-stroke',
			'fas fa-mars-stroke-h',
			'fas fa-mars-stroke-v',
			'fas fa-mask',
			'fab fa-mastodon',
			'fab fa-maxcdn',
			'fab fa-mdb',
			'fas fa-medal',
			'fab fa-medapps',
			'fab fa-medium',
			'fab fa-medium-m',
			'fas fa-medkit',
			'fab fa-medrt',
			'fab fa-meetup',
			'fab fa-megaport',
			'fas fa-meh',
			'far fa-meh',
			'fas fa-meh-blank',
			'far fa-meh-blank',
			'fas fa-meh-rolling-eyes',
			'far fa-meh-rolling-eyes',
			'fas fa-memory',
			'fab fa-mendeley',
			'fas fa-menorah',
			'fas fa-mercury',
			'fas fa-meteor',
			'fab fa-microblog',
			'fas fa-microchip',
			'fas fa-microphone',
			'fas fa-microphone-alt',
			'fas fa-microphone-alt-slash',
			'fas fa-microphone-slash',
			'fas fa-microscope',
			'fab fa-microsoft',
			'fas fa-minus',
			'fas fa-minus-circle',
			'fas fa-minus-square',
			'far fa-minus-square',
			'fas fa-mitten',
			'fab fa-mix',
			'fab fa-mixcloud',
			'fab fa-mixer',
			'fab fa-mizuni',
			'fas fa-mobile',
			'fas fa-mobile-alt',
			'fab fa-modx',
			'fab fa-monero',
			'fas fa-money-bill',
			'fas fa-money-bill-alt',
			'far fa-money-bill-alt',
			'fas fa-money-bill-wave',
			'fas fa-money-bill-wave-alt',
			'fas fa-money-check',
			'fas fa-money-check-alt',
			'fas fa-monument',
			'fas fa-moon',
			'far fa-moon',
			'fas fa-mortar-pestle',
			'fas fa-mosque',
			'fas fa-motorcycle',
			'fas fa-mountain',
			'fas fa-mouse',
			'fas fa-mouse-pointer',
			'fas fa-mug-hot',
			'fas fa-music',
			'fab fa-napster',
			'fab fa-neos',
			'fas fa-network-wired',
			'fas fa-neuter',
			'fas fa-newspaper',
			'far fa-newspaper',
			'fab fa-nimblr',
			'fab fa-node',
			'fab fa-node-js',
			'fas fa-not-equal',
			'fas fa-notes-medical',
			'fab fa-npm',
			'fab fa-ns8',
			'fab fa-nutritionix',
			'fas fa-object-group',
			'far fa-object-group',
			'fas fa-object-ungroup',
			'far fa-object-ungroup',
			'fab fa-odnoklassniki',
			'fab fa-odnoklassniki-square',
			'fas fa-oil-can',
			'fab fa-old-republic',
			'fas fa-om',
			'fab fa-opencart',
			'fab fa-openid',
			'fab fa-opera',
			'fab fa-optin-monster',
			'fab fa-orcid',
			'fab fa-osi',
			'fas fa-otter',
			'fas fa-outdent',
			'fab fa-page4',
			'fab fa-pagelines',
			'fas fa-pager',
			'fas fa-paint-brush',
			'fas fa-paint-roller',
			'fas fa-palette',
			'fab fa-palfed',
			'fas fa-pallet',
			'fas fa-paper-plane',
			'far fa-paper-plane',
			'fas fa-paperclip',
			'fas fa-parachute-box',
			'fas fa-paragraph',
			'fas fa-parking',
			'fas fa-passport',
			'fas fa-pastafarianism',
			'fas fa-paste',
			'fab fa-patreon',
			'fas fa-pause',
			'fas fa-pause-circle',
			'far fa-pause-circle',
			'fas fa-paw',
			'fab fa-paypal',
			'fas fa-peace',
			'fas fa-pen',
			'fas fa-pen-alt',
			'fas fa-pen-fancy',
			'fas fa-pen-nib',
			'fas fa-pen-square',
			'fas fa-pencil-alt',
			'fas fa-pencil-ruler',
			'fab fa-penny-arcade',
			'fas fa-people-arrows',
			'fas fa-people-carry',
			'fas fa-pepper-hot',
			'fas fa-percent',
			'fas fa-percentage',
			'fab fa-periscope',
			'fas fa-person-booth',
			'fab fa-phabricator',
			'fab fa-phoenix-framework',
			'fab fa-phoenix-squadron',
			'fas fa-phone',
			'fas fa-phone-alt',
			'fas fa-phone-slash',
			'fas fa-phone-square',
			'fas fa-phone-square-alt',
			'fas fa-phone-volume',
			'fas fa-photo-video',
			'fab fa-php',
			'fab fa-pied-piper',
			'fab fa-pied-piper-alt',
			'fab fa-pied-piper-hat',
			'fab fa-pied-piper-pp',
			'fab fa-pied-piper-square',
			'fas fa-piggy-bank',
			'fas fa-pills',
			'fab fa-pinterest',
			'fab fa-pinterest-p',
			'fab fa-pinterest-square',
			'fas fa-pizza-slice',
			'fas fa-place-of-worship',
			'fas fa-plane',
			'fas fa-plane-arrival',
			'fas fa-plane-departure',
			'fas fa-plane-slash',
			'fas fa-play',
			'fas fa-play-circle',
			'far fa-play-circle',
			'fab fa-playstation',
			'fas fa-plug',
			'fas fa-plus',
			'fas fa-plus-circle',
			'fas fa-plus-square',
			'far fa-plus-square',
			'fas fa-podcast',
			'fas fa-poll',
			'fas fa-poll-h',
			'fas fa-poo',
			'fas fa-poo-storm',
			'fas fa-poop',
			'fas fa-portrait',
			'fas fa-pound-sign',
			'fas fa-power-off',
			'fas fa-pray',
			'fas fa-praying-hands',
			'fas fa-prescription',
			'fas fa-prescription-bottle',
			'fas fa-prescription-bottle-alt',
			'fas fa-print',
			'fas fa-procedures',
			'fab fa-product-hunt',
			'fas fa-project-diagram',
			'fas fa-pump-medical',
			'fas fa-pump-soap',
			'fab fa-pushed',
			'fas fa-puzzle-piece',
			'fab fa-python',
			'fab fa-qq',
			'fas fa-qrcode',
			'fas fa-question',
			'fas fa-question-circle',
			'far fa-question-circle',
			'fas fa-quidditch',
			'fab fa-quinscape',
			'fab fa-quora',
			'fas fa-quote-left',
			'fas fa-quote-right',
			'fas fa-quran',
			'fab fa-r-project',
			'fas fa-radiation',
			'fas fa-radiation-alt',
			'fas fa-rainbow',
			'fas fa-random',
			'fab fa-raspberry-pi',
			'fab fa-ravelry',
			'fab fa-react',
			'fab fa-reacteurope',
			'fab fa-readme',
			'fab fa-rebel',
			'fas fa-receipt',
			'fas fa-record-vinyl',
			'fas fa-recycle',
			'fab fa-red-river',
			'fab fa-reddit',
			'fab fa-reddit-alien',
			'fab fa-reddit-square',
			'fab fa-redhat',
			'fas fa-redo',
			'fas fa-redo-alt',
			'fas fa-registered',
			'far fa-registered',
			'fas fa-remove-format',
			'fab fa-renren',
			'fas fa-reply',
			'fas fa-reply-all',
			'fab fa-replyd',
			'fas fa-republican',
			'fab fa-researchgate',
			'fab fa-resolving',
			'fas fa-restroom',
			'fas fa-retweet',
			'fab fa-rev',
			'fas fa-ribbon',
			'fas fa-ring',
			'fas fa-road',
			'fas fa-robot',
			'fas fa-rocket',
			'fab fa-rocketchat',
			'fab fa-rockrms',
			'fas fa-route',
			'fas fa-rss',
			'fas fa-rss-square',
			'fas fa-ruble-sign',
			'fas fa-ruler',
			'fas fa-ruler-combined',
			'fas fa-ruler-horizontal',
			'fas fa-ruler-vertical',
			'fas fa-running',
			'fas fa-rupee-sign',
			'fas fa-sad-cry',
			'far fa-sad-cry',
			'fas fa-sad-tear',
			'far fa-sad-tear',
			'fab fa-safari',
			'fab fa-salesforce',
			'fab fa-sass',
			'fas fa-satellite',
			'fas fa-satellite-dish',
			'fas fa-save',
			'far fa-save',
			'fab fa-schlix',
			'fas fa-school',
			'fas fa-screwdriver',
			'fab fa-scribd',
			'fas fa-scroll',
			'fas fa-sd-card',
			'fas fa-search',
			'fas fa-search-dollar',
			'fas fa-search-location',
			'fas fa-search-minus',
			'fas fa-search-plus',
			'fab fa-searchengin',
			'fas fa-seedling',
			'fab fa-sellcast',
			'fab fa-sellsy',
			'fas fa-server',
			'fab fa-servicestack',
			'fas fa-shapes',
			'fas fa-share',
			'fas fa-share-alt',
			'fas fa-share-alt-square',
			'fas fa-share-square',
			'far fa-share-square',
			'fas fa-shekel-sign',
			'fas fa-shield-alt',
			'fas fa-shield-virus',
			'fas fa-ship',
			'fas fa-shipping-fast',
			'fab fa-shirtsinbulk',
			'fas fa-shoe-prints',
			'fab fa-shopify',
			'fas fa-shopping-bag',
			'fas fa-shopping-basket',
			'fas fa-shopping-cart',
			'fab fa-shopware',
			'fas fa-shower',
			'fas fa-shuttle-van',
			'fas fa-sign',
			'fas fa-sign-in-alt',
			'fas fa-sign-language',
			'fas fa-sign-out-alt',
			'fas fa-signal',
			'fas fa-signature',
			'fas fa-sim-card',
			'fab fa-simplybuilt',
			'fab fa-sistrix',
			'fas fa-sitemap',
			'fab fa-sith',
			'fas fa-skating',
			'fab fa-sketch',
			'fas fa-skiing',
			'fas fa-skiing-nordic',
			'fas fa-skull',
			'fas fa-skull-crossbones',
			'fab fa-skyatlas',
			'fab fa-skype',
			'fab fa-slack',
			'fab fa-slack-hash',
			'fas fa-slash',
			'fas fa-sleigh',
			'fas fa-sliders-h',
			'fab fa-slideshare',
			'fas fa-smile',
			'far fa-smile',
			'fas fa-smile-beam',
			'far fa-smile-beam',
			'fas fa-smile-wink',
			'far fa-smile-wink',
			'fas fa-smog',
			'fas fa-smoking',
			'fas fa-smoking-ban',
			'fas fa-sms',
			'fab fa-snapchat',
			'fab fa-snapchat-ghost',
			'fab fa-snapchat-square',
			'fas fa-snowboarding',
			'fas fa-snowflake',
			'far fa-snowflake',
			'fas fa-snowman',
			'fas fa-snowplow',
			'fas fa-soap',
			'fas fa-socks',
			'fas fa-solar-panel',
			'fas fa-sort',
			'fas fa-sort-alpha-down',
			'fas fa-sort-alpha-down-alt',
			'fas fa-sort-alpha-up',
			'fas fa-sort-alpha-up-alt',
			'fas fa-sort-amount-down',
			'fas fa-sort-amount-down-alt',
			'fas fa-sort-amount-up',
			'fas fa-sort-amount-up-alt',
			'fas fa-sort-down',
			'fas fa-sort-numeric-down',
			'fas fa-sort-numeric-down-alt',
			'fas fa-sort-numeric-up',
			'fas fa-sort-numeric-up-alt',
			'fas fa-sort-up',
			'fab fa-soundcloud',
			'fab fa-sourcetree',
			'fas fa-spa',
			'fas fa-space-shuttle',
			'fab fa-speakap',
			'fab fa-speaker-deck',
			'fas fa-spell-check',
			'fas fa-spider',
			'fas fa-spinner',
			'fas fa-splotch',
			'fab fa-spotify',
			'fas fa-spray-can',
			'fas fa-square',
			'far fa-square',
			'fas fa-square-full',
			'fas fa-square-root-alt',
			'fab fa-squarespace',
			'fab fa-stack-exchange',
			'fab fa-stack-overflow',
			'fab fa-stackpath',
			'fas fa-stamp',
			'fas fa-star',
			'far fa-star',
			'fas fa-star-and-crescent',
			'fas fa-star-half',
			'far fa-star-half',
			'fas fa-star-half-alt',
			'fas fa-star-of-david',
			'fas fa-star-of-life',
			'fab fa-staylinked',
			'fab fa-steam',
			'fab fa-steam-square',
			'fab fa-steam-symbol',
			'fas fa-step-backward',
			'fas fa-step-forward',
			'fas fa-stethoscope',
			'fab fa-sticker-mule',
			'fas fa-sticky-note',
			'far fa-sticky-note',
			'fas fa-stop',
			'fas fa-stop-circle',
			'far fa-stop-circle',
			'fas fa-stopwatch',
			'fas fa-stopwatch-20',
			'fas fa-store',
			'fas fa-store-alt',
			'fas fa-store-alt-slash',
			'fas fa-store-slash',
			'fab fa-strava',
			'fas fa-stream',
			'fas fa-street-view',
			'fas fa-strikethrough',
			'fab fa-stripe',
			'fab fa-stripe-s',
			'fas fa-stroopwafel',
			'fab fa-studiovinari',
			'fab fa-stumbleupon',
			'fab fa-stumbleupon-circle',
			'fas fa-subscript',
			'fas fa-subway',
			'fas fa-suitcase',
			'fas fa-suitcase-rolling',
			'fas fa-sun',
			'far fa-sun',
			'fab fa-superpowers',
			'fas fa-superscript',
			'fab fa-supple',
			'fas fa-surprise',
			'far fa-surprise',
			'fab fa-suse',
			'fas fa-swatchbook',
			'fab fa-swift',
			'fas fa-swimmer',
			'fas fa-swimming-pool',
			'fab fa-symfony',
			'fas fa-synagogue',
			'fas fa-sync',
			'fas fa-sync-alt',
			'fas fa-syringe',
			'fas fa-table',
			'fas fa-table-tennis',
			'fas fa-tablet',
			'fas fa-tablet-alt',
			'fas fa-tablets',
			'fas fa-tachometer-alt',
			'fas fa-tag',
			'fas fa-tags',
			'fas fa-tape',
			'fas fa-tasks',
			'fas fa-taxi',
			'fab fa-teamspeak',
			'fas fa-teeth',
			'fas fa-teeth-open',
			'fab fa-telegram',
			'fab fa-telegram-plane',
			'fas fa-temperature-high',
			'fas fa-temperature-low',
			'fab fa-tencent-weibo',
			'fas fa-tenge',
			'fas fa-terminal',
			'fas fa-text-height',
			'fas fa-text-width',
			'fas fa-th',
			'fas fa-th-large',
			'fas fa-th-list',
			'fab fa-the-red-yeti',
			'fas fa-theater-masks',
			'fab fa-themeco',
			'fab fa-themeisle',
			'fas fa-thermometer',
			'fas fa-thermometer-empty',
			'fas fa-thermometer-full',
			'fas fa-thermometer-half',
			'fas fa-thermometer-quarter',
			'fas fa-thermometer-three-quarters',
			'fab fa-think-peaks',
			'fas fa-thumbs-down',
			'far fa-thumbs-down',
			'fas fa-thumbs-up',
			'far fa-thumbs-up',
			'fas fa-thumbtack',
			'fas fa-ticket-alt',
			'fas fa-times',
			'fas fa-times-circle',
			'far fa-times-circle',
			'fas fa-tint',
			'fas fa-tint-slash',
			'fas fa-tired',
			'far fa-tired',
			'fas fa-toggle-off',
			'fas fa-toggle-on',
			'fas fa-toilet',
			'fas fa-toilet-paper',
			'fas fa-toilet-paper-slash',
			'fas fa-toolbox',
			'fas fa-tools',
			'fas fa-tooth',
			'fas fa-torah',
			'fas fa-torii-gate',
			'fas fa-tractor',
			'fab fa-trade-federation',
			'fas fa-trademark',
			'fas fa-traffic-light',
			'fas fa-trailer',
			'fas fa-train',
			'fas fa-tram',
			'fas fa-transgender',
			'fas fa-transgender-alt',
			'fas fa-trash',
			'fas fa-trash-alt',
			'far fa-trash-alt',
			'fas fa-trash-restore',
			'fas fa-trash-restore-alt',
			'fas fa-tree',
			'fab fa-trello',
			'fab fa-tripadvisor',
			'fas fa-trophy',
			'fas fa-truck',
			'fas fa-truck-loading',
			'fas fa-truck-monster',
			'fas fa-truck-moving',
			'fas fa-truck-pickup',
			'fas fa-tshirt',
			'fas fa-tty',
			'fab fa-tumblr',
			'fab fa-tumblr-square',
			'fas fa-tv',
			'fab fa-twitch',
			'fab fa-twitter',
			'fab fa-twitter-square',
			'fab fa-typo3',
			'fab fa-uber',
			'fab fa-ubuntu',
			'fab fa-uikit',
			'fab fa-umbraco',
			'fas fa-umbrella',
			'fas fa-umbrella-beach',
			'fas fa-underline',
			'fas fa-undo',
			'fas fa-undo-alt',
			'fab fa-uniregistry',
			'fab fa-unity',
			'fas fa-universal-access',
			'fas fa-university',
			'fas fa-unlink',
			'fas fa-unlock',
			'fas fa-unlock-alt',
			'fab fa-untappd',
			'fas fa-upload',
			'fab fa-ups',
			'fab fa-usb',
			'fas fa-user',
			'far fa-user',
			'fas fa-user-alt',
			'fas fa-user-alt-slash',
			'fas fa-user-astronaut',
			'fas fa-user-check',
			'fas fa-user-circle',
			'far fa-user-circle',
			'fas fa-user-clock',
			'fas fa-user-cog',
			'fas fa-user-edit',
			'fas fa-user-friends',
			'fas fa-user-graduate',
			'fas fa-user-injured',
			'fas fa-user-lock',
			'fas fa-user-md',
			'fas fa-user-minus',
			'fas fa-user-ninja',
			'fas fa-user-nurse',
			'fas fa-user-plus',
			'fas fa-user-secret',
			'fas fa-user-shield',
			'fas fa-user-slash',
			'fas fa-user-tag',
			'fas fa-user-tie',
			'fas fa-user-times',
			'fas fa-users',
			'fas fa-users-cog',
			'fab fa-usps',
			'fab fa-ussunnah',
			'fas fa-utensil-spoon',
			'fas fa-utensils',
			'fab fa-vaadin',
			'fas fa-vector-square',
			'fas fa-venus',
			'fas fa-venus-double',
			'fas fa-venus-mars',
			'fab fa-viacoin',
			'fab fa-viadeo',
			'fab fa-viadeo-square',
			'fas fa-vial',
			'fas fa-vials',
			'fab fa-viber',
			'fas fa-video',
			'fas fa-video-slash',
			'fas fa-vihara',
			'fab fa-vimeo',
			'fab fa-vimeo-square',
			'fab fa-vimeo-v',
			'fab fa-vine',
			'fas fa-virus',
			'fas fa-virus-slash',
			'fas fa-viruses',
			'fab fa-vk',
			'fab fa-vnv',
			'fas fa-voicemail',
			'fas fa-volleyball-ball',
			'fas fa-volume-down',
			'fas fa-volume-mute',
			'fas fa-volume-off',
			'fas fa-volume-up',
			'fas fa-vote-yea',
			'fas fa-vr-cardboard',
			'fab fa-vuejs',
			'fas fa-walking',
			'fas fa-wallet',
			'fas fa-warehouse',
			'fas fa-water',
			'fas fa-wave-square',
			'fab fa-waze',
			'fab fa-weebly',
			'fab fa-weibo',
			'fas fa-weight',
			'fas fa-weight-hanging',
			'fab fa-weixin',
			'fab fa-whatsapp',
			'fab fa-whatsapp-square',
			'fas fa-wheelchair',
			'fab fa-whmcs',
			'fas fa-wifi',
			'fab fa-wikipedia-w',
			'fas fa-wind',
			'fas fa-window-close',
			'far fa-window-close',
			'fas fa-window-maximize',
			'far fa-window-maximize',
			'fas fa-window-minimize',
			'far fa-window-minimize',
			'fas fa-window-restore',
			'far fa-window-restore',
			'fab fa-windows',
			'fas fa-wine-bottle',
			'fas fa-wine-glass',
			'fas fa-wine-glass-alt',
			'fab fa-wix',
			'fab fa-wizards-of-the-coast',
			'fab fa-wolf-pack-battalion',
			'fas fa-won-sign',
			'fab fa-wordpress',
			'fab fa-wordpress-simple',
			'fab fa-wpbeginner',
			'fab fa-wpexplorer',
			'fab fa-wpforms',
			'fab fa-wpressr',
			'fas fa-wrench',
			'fas fa-x-ray',
			'fab fa-xbox',
			'fab fa-xing',
			'fab fa-xing-square',
			'fab fa-y-combinator',
			'fab fa-yahoo',
			'fab fa-yammer',
			'fab fa-yandex',
			'fab fa-yandex-international',
			'fab fa-yarn',
			'fab fa-yelp',
			'fas fa-yen-sign',
			'fas fa-yin-yang',
			'fab fa-yoast',
			'fab fa-youtube',
			'fab fa-youtube-square',
			'fab fa-zhihu',
		];

	function build_list($popup, $button, clear) {

		$list = $popup.find('.icon-picker-list');

		for (var i in icons) {
			$list.append('<li data-icon="' + icons[i] + '"><a href="#" title="' + icons[i] + '"><span class="' + icons[i] + '"></span></a></li>');
		};

		$('a', $list).click(function(e) {
			e.preventDefault();
			var title = $(this).attr("title");
			if (title == 'blank') {
				$target.closest('.menu-item').find('.preview-menu-item-icon').attr('class', 'preview-menu-item-icon');
				$target.val('');
			}
			else {
				$target.val( title );
				$target.closest('.menu-item').find('.preview-menu-item-icon').attr('class', 'preview-menu-item-icon ' + title );
			}

			$button.removeClass().addClass("button icon-picker " + title);
			removePopup();
		});
	};

	function removePopup() {
		$(".icon-picker-container").remove();
	}

	/*
	$button = $('.icon-picker');
	$button.each(function() {
		$(this).on('click.iconPicker', function() {
			createPopup($(this));
		});
	});
	*/

	$(document).on("click", ".icon-picker", function() {
		createPopup($(this));
	});

	function createPopup($button) {
		$target = $($button.data('target'));
		$popup = $('<div class="icon-picker-container"> \
			<div class="icon-picker-control"></div> \
			<div class="icon-picker-list-wrap"> \
				<ul class="icon-picker-list"></ul> \
			</div>\
		</div>');

		build_list( $popup, $button, 0);

		var $control = $popup.find('.icon-picker-control');
		$control.html('<input type="text" class="" placeholder="' + tieLang.search + '" />');
		$popup.appendTo( $button.parent() ).show();

		$('input', $control).on('keyup', function(e) {
			var search = $(this).val();
			if (search === '') {
				//show all again
				$('li', $list).show();
			} else {
				$('li', $list).each(function() {
					if ($(this).data('icon').toString().toLowerCase().indexOf(search.toLowerCase()) !== -1) {
						$(this).show();
					} else {
						$(this).hide();
					}
				});
			}
		});

		$(document).mouseup(function(e) {
			if (!$popup.is(e.target) && $popup.has(e.target).length === 0) {
				removePopup();
			}
		});
	}
}

	$(function() {
		$('.icon-picker').iconPicker();
	});

}(jQuery));


/* Get Color Brightes */
function getContrastColor(hexcolor){
	hexcolor = hexcolor.replace( '#', '' );
	var r = parseInt(hexcolor.substr(0,2),16);
	var g = parseInt(hexcolor.substr(2,2),16);
	var b = parseInt(hexcolor.substr(4,2),16);
	var yiq = ((r*299)+(g*587)+(b*114))/1000;
	return (yiq >= 128) ? 'dark' : 'light';
}
