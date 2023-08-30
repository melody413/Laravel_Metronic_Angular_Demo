jQuery( function ( $ ) {
	'use strict';

	$('.tie-demo-importer .theme-screenshot').on( 'click', function () {

		var $this = $(this),
		    title = $this.closest('.theme').find('.theme-name').html(),
		    demo  = $this.closest('.theme').find('.tie-live-demo').attr('href'),
		    desc  = $this.find('.demo-desc').html(),
		    img   = $this.find('img').attr('src');

		    //console.log( img );

		$('#tie-install-demo').attr( 'data-value', $this.data( 'value' ) );

		$('body').addClass('has-overlay');
		$('#theme-description').html('').append( desc );
		$('#tie-import-data-notes').find('.theme-name').html( title );
		$('#tie-import-data-notes').find('.screenshot > img').attr( 'src', img );
		$('#tie-view-demo' ).attr( 'href', demo );
		$('#tie-import-data-notes').show();

		/*
		$('#tie-import-data-notes').fadeIn();
		$('html, body').animate({
			scrollTop: $('#tie-import-data-notes').offset().top
    }, 300);
    */

	});


	$('#tie-install-demo').on( 'click', function () {

		// Prepare data for the AJAX call
		var data = new FormData();
		data.append( 'action', 'ocdi_import_demo_data' );
		data.append( 'security', ocdi.ajax_nonce );
		data.append( 'selected', $(this).data( 'value' ) );

		// Reset response div content.
		$('#tie-import-data-notes .theme-actions, #tie-import-data-notes .theme-header').hide();
		$('#tie-import-data-notes .theme-about').slideUp( function() {

    	// AJAX call to import everything (content, widgets, before/after setup)
			ajaxCall( data );
  	});

		return false;
	});

	var $saveAlert = $('#tie-saving-settings');

	function ajaxCall( data ) {
		$.ajax({
			method:     'POST',
			url:        ajaxurl,
			data:       data,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$('.js-tie-ajax-response').slideDown('fast');
			}
		})
		.done( function( response ) {
			if ( 'undefined' !== typeof response.status && 'newAJAX' === response.status ) {
				ajaxCall( data );
			}
			else if ( 'undefined' !== typeof response.message ) {
				$('.js-tie-ajax-response').append( '<p>' + response.message + '</p>' );
				$saveAlert.addClass('is-success');

				$('body').addClass('force-refresh');

				$('.tie-loading-wrapper, #tie-import-data-notes .theme-actions .import-button').hide();
				$('#tie-import-data-notes .theme-header, #tie-import-data-notes .theme-actions, .imported-buttons').show();
			}
			else {
				$('.js-tie-ajax-response').append( '<div class="tie-message-hint tie-message-error"><p>' + response + '</p></div>' );
				$saveAlert.addClass('is-failed');
				$('.tie-loading-wrapper').hide();

				$('body').addClass('force-refresh');
				$('#tie-import-data-notes .theme-header').show();
			}
		})
		.fail( function( error ) {
			$('.js-tie-ajax-response').append( '<div class="tie-message-hint tie-message-error"> Error: ' + error.statusText + ' (' + error.status + ')' + '</div>' );
			$saveAlert.addClass('is-failed');
			$('.tie-loading-wrapper').hide();


			$('body').addClass('force-refresh');
			$('#tie-import-data-notes .theme-header').show();
		});
	}
});
