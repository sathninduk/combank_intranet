jQuery( document ).ready(function($) {
	"use strict";

	$( '.izo-devices-preview' ).find( 'button' ).on( 'click', function( event ) {

		$( this ).parent().addClass( 'active' );
		$( this ).parent().siblings().removeClass( 'active' );

		var device = $(this).attr('data-device');
		if( 'desktop' == device ) {
			device = 'desktop';
			var deviceControl = $( this ).parents( '.customize-control-responsive_number' ).find('.izo-responsive-wrapper' ).find( 'div' );

			

			deviceControl.each(function( index ) {
				if ( $(this).hasClass( 'izo-preview-' + device ) ) {
					$(this).addClass( 'active' );
				} else {
					$(this).removeClass( 'active' );
				}
			});

		} else if( 'tablet' == device ) {
			device = 'tablet';
			var deviceControl = $( this ).parents( '.customize-control-responsive_number' ).find('.izo-responsive-wrapper' ).find( 'div' );

			deviceControl.each(function( index ) {
				if ( $(this).hasClass( 'izo-preview-' + device ) ) {
					$(this).addClass( 'active' );
				} else {
					$(this).removeClass( 'active' );
				}
			});
		} else {
			device = 'mobile';
			var deviceControl = $( this ).parents( '.customize-control-responsive_number' ).find('.izo-responsive-wrapper' ).find( 'div' );

			deviceControl.each(function( index ) {
				if ( $(this).hasClass( 'izo-preview-' + device ) ) {
					$(this).addClass( 'active' );
				} else {
					$(this).removeClass( 'active' );
				}
			});
		}

		$( '.wp-full-overlay-footer .devices button[data-device="' + device + '"]' ).trigger( 'click' );
	});

	$(' .wp-full-overlay-footer .devices button ').on('click', function() {

		var device = $(this).attr('data-device');
		
		$( '.izo-devices-preview li' ).removeClass( 'active' );
		$( '.izo-devices-preview .' + device ).addClass( 'active' );

		$( '.izo-responsive-wrapper div' ).removeClass( 'active' );
		$( '.izo-responsive-wrapper div.izo-preview-' + device ).addClass( 'active' );
	});	

});