/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {


	//Accents
	wp.customize( 'accent_color', function( value ) {
		value.bind( function( to ) {
			$( ':root' ).get(0).style.setProperty( '--color-accent', to );
		} );
	} );
	wp.customize( 'accent_color_dark', function( value ) {
		value.bind( function( to ) {
			$( ':root' ).get(0).style.setProperty( '--color-accent-dark', to );
		} );
	} );


	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
				$( '.site-title a, .site-description' ).css( {
					color: to,
				} );
			}
		} );
	} );

	//Devices
	var $devices 	= { "desktop": "(min-width: 992px)", "tablet": "(min-width: 576px) and (max-width: 991px)", "mobile": "(max-width: 575px)" };

	/**
	 * Background colors
	 */
	 var $bg_color_options = { 
		'global_button_background': 'button,.button,.wp-block-button__link,input[type=\'button\'],input[type=\'reset\'],input[type=\'submit\']:not(.search-submit),.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]',
		'footer_bar_bg_color':'.site-info',
		'footer_widgets_background': '.footer-widgets',
		'breadcrumbs_background':'.voluto-breadcrumb-trail',
		'footer_widgets_background':'.footer-widgets',
		'footer_bar_bg_color':'.footer-bar',
		'before_footer_background':'.before-footer',
		'footer_bar_bg_color': '.footer-bar',
		'top_bar_background_color': '.top-bar',
		'top_header_background_color':'.site-header',
		'bottom_header_background_color':'.menu-bar',
		'single_post_overlay_color' : '.page-banner.has-featured.overlay .banner-overlay',
		'mobile_header_background_color': '.mobile-header',
		'offcanvas_menu_background_color': '.main-navigation.toggled',
		'pro_footer_posts_background_color': '.footer-featured',
		'pro_reading_bar_background_color': '#voluto-progress-bar',
	};

	$.each( $bg_color_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
				$( selector ).css( 'background-color', to );
			} );
		} );
	});	

	//background hover
	var $bg_hover_options = { 
		"global_button_background_hover": "button:hover,.button:hover,.wp-block-button__link:hover,input[type=\"button\"]:hover,input[type=\"reset\"]:hover,input[type=\"submit\"]:not(.search-submit):hover,.wpforms-form button[type=submit]:hover,div.wpforms-container-full .wpforms-form button[type=submit]:hover,div.nf-form-content input[type=button]:hover",
		"loop_add_to_cart_bg_color_hover": ".woocommerce .products .button:hover",
	};

	$.each( $bg_hover_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
		
				$( 'head' ).find( '#voluto-preview-styles-' + option ).remove();
	
				var output = selector + ' { background-color:' + to + '!important; }';
	
				$( 'head' ).append( '<style id="voluto-preview-styles-' + option + '">' + output + '</style>' );
	
			} );
		} );
	});		

	/**
	 * Colors
	 */
	var $color_options = { 
		'footer_bar_color':'.site-info, .site-info a',
		'footer_widgets_links_color':'.footer-widgets a',
		'footer_widgets_color':'.footer-widgets',
		'footer_widgets_title_color':'.footer-widgets .widget .widget-title',
		'bottom_header_color':'.header-bottom,.header-bottom .main-navigation div > ul > li > a',
		'headings_color':'h1,h2,h3,h4,h5,h6', 
		'content_link_color':'.entry-content p a:not(.button)', 
		'body_color':'body', 
		'submenu_items_color':'.main-navigation ul ul a', 
		'menu_items_color':'.main-navigation > div > ul > li > a',
		'site_title_color':'.site-title a',
		'site_desc_color':'.site-description',
		'global_button_color': '.elementor-button-wrapper .elementor-button,button,.button,.widget .button,.wp-block-button__link,input[type=\'button\'],input[type=\'reset\'],input[type=\'submit\'],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]',
		'loop_product_price_color': 'ul.products li.product .price',
		'single_product_price_color': '.single-product-top .price',
		'single_product_title_color': '.single-product-top .entry-title', 
		'single_page_title_color': '.page .entry-header .entry-title', 
		'single_post_title_color': '.single-post .entry-title', 
		'mobile_menu_items_color': '#mobile-menu, #mobile-menu a',
		'footer_bottom_color': '.site-info, .site-info a',
		'breadcrumbs_links': '.voluto-breadcrumb-trail a:not(:hover)',
		'breadcrumbs_text': '.voluto-breadcrumb-trail',
		'before_footer_color': '.before-footer h2, .before-footer h3, .before-footer h4,.before-footer,.before-footer a:not(.button)',
		'footer_bar_color' : '.footer-bar, .footer-bar a',
		'top_bar_color' : '.top-bar, .top-bar a',
		'top_header_color':'.site-header, .site-description, .site-title a, .site-header .main-navigation > div > ul > li > a',
		'bottom_header_color':'.menu-bar,.menu-bar .main-navigation > div > ul > li > a',
		'single_post_meta_color': '.page-banner.has-featured.overlay .entry-meta a, .page-banner.has-featured.overlay .entry-meta, .single-post .entry-meta, .single-post .entry-meta a',
		'blog_archives_title_color':'.posts-loop .entry-title a',
		'blog_archives_meta_color': '.posts-loop .entry-meta, .posts-loop .entry-meta a',
		'color_heading1': 'h1',
		'color_heading2': 'h2',
		'color_heading3': 'h3',
		'color_heading4': 'h4',
		'color_heading5': 'h5',
		'color_heading6': 'h6',
		'mobile_header_color': '#mobile-header, #mobile-header a',
		'offcanvas_menu_color': '#mobile-header .main-navigation.toggled, #mobile-header .main-navigation.toggled a',
		'pro_footer_posts_title_color': '.footer-featured .footer-featured-title',
		'pro_footer_posts_titles_color': '.footer-featured .entry-title a',
		'pro_footer_posts_date_color': '.footer-featured .posted-on a',		
	};
	
	$.each( $color_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
				$( selector ).css( 'color', to );
			} );
		} );
	});	

	/**
	 * Fill
	 */
	var $fill_options = { 
		'breadcrumbs_links': '.voluto-breadcrumb-trail svg',
		'before_footer_color': '.before-footer-social svg',
		'footer_bar_color' : '.footer-bar svg',
		'top_bar_color' : '.top-bar svg',
		'top_header_color':'.site-header svg',
		'bottom_header_color':'.menu-bar svg',
		'mobile_header_color': '#mobile-header svg',
		'offcanvas_menu_color': '.main-navigation.toggled svg',
	};
	
	$.each( $fill_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
				$( selector ).css( 'fill', to );
			} );
		} );
	});	

	/**
	 * Border color
	 */
	 var $border_color_options = { 
		'footer_widgets_border_color': '.footer-widgets-inner',
		'before_footer_border_color': '.before-footer-inner',
		'single_post_borders_color': '.single-post .site-main>*:not(article)'
	};
	
	$.each( $border_color_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
				$( selector ).css( 'border-color', to );
			} );
		} );
	});		

	//Responsive font sizes
	var $fontSizes 	= { 
		"loop_product_price_size": "ul.products li.product .price",
		"loop_product_title_size": "ul.products li.product .woocommerce-loop-product__title",
		"single_product_price_size": ".single-product-top .price",
		"single_product_title_size": ".single-product-top .entry-title",
		"single_page_title_size": ".page .entry-header .entry-title",
		"single_post_title_size": ".single-post .entry-title",
		"single_post_meta_size": ".single-post .entry-meta, .single-post .entry-meta .posted-on",
		"h1_heading_font_size": "h1",
		"h2_heading_font_size": "h2",
		"h3_heading_font_size": "h3",
		"h4_heading_font_size": "h4",
		"h5_heading_font_size": "h5",
		"h6_heading_font_size": "h6",
		"body_font_size": "body",
		"blog_archives_title_size": ".posts-loop .entry-title",
		"blog_archives_meta_size": ".posts-loop .entry-meta, .posts-loop .entry-meta .posted-on",
		"menu_font_size": ".main-navigation a",
	};
	$.each( $fontSizes, function( option, selector ) {
		$.each( $devices, function( device, mediaSize ) {
			wp.customize( option + '_' + device, function( value ) {
				value.bind( function( to ) {
				
					$( 'head' ).find( '#voluto-preview-styles-' + option + '_' + device ).remove();
		
					var output = '@media ' + mediaSize + ' {' + selector + ' { font-size:' + to + 'px; } }';
		
					$( 'head' ).append( '<style id="voluto-preview-styles-' + option + '_' + device + '">' + output + '</style>' );
				} );
			} );
		} );	
	} );

	//color hover and pseudo
	var $color_hover_options = { 
		"global_button_color_hover": '.button.header-button:hover,input[type="submit"]:not(.search-submit):hover,.widget .button:hover,button:hover,.button:hover,.wp-block-button__link:hover,input[type=\"button\"]:hover,input[type=\"reset\"]:hover,input[type=\"submit\"]:not(.search-submit):hover,.wpforms-form button[type=submit]:hover,div.wpforms-container-full .wpforms-form button[type=submit]:hover,div.nf-form-content input[type=button]:hover',
		"loop_ratings_color": ".star-rating span::before",
		"loop_add_to_cart_color_hover": ".woocommerce .products .button:hover",
		"content_link_color_hover": ".entry-content p a:not(.button):hover",
	};

	$.each( $color_hover_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
		
				$( 'head' ).find( '#voluto-preview-styles-' + option ).remove();
	
				var output = selector + ' { color:' + to + '!important; }';
	
				$( 'head' ).append( '<style id="voluto-preview-styles-' + option + '">' + output + '</style>' );
	
			} );
		} );
	});	

	/**
	 * Responsive Paddings top/bottom
	 */
	var $paddings_tb_options = { 
		'breadcrumbs_padding': '.voluto-breadcrumb-trail',
		'footer_widgets_padding': '.footer-widgets-inner',
		'before_footer_padding': '.before-footer-inner',
		'topbar_padding': '.top-bar',
		'top_header_padding': '.site-branding',
		'bottom_header_padding': '.menu-bar',
		'global_button_padding_tb': 'button, .button, input[type="button"], input[type="reset"], input[type="submit"]'
	};
	$.each( $paddings_tb_options, function( option, selector ) {
		$.each( $devices, function( device, mediaSize ) {
			wp.customize( option + '_' + device, function( value ) {
				value.bind( function( to ) {
				
					$( 'head' ).find( '#voluto-preview-styles-' + option + '_' + device ).remove();
		
					var output = '@media ' + mediaSize + ' {' + selector + ' { padding-top:' + to + 'px;padding-bottom:' + to + 'px; } }';
		
					$( 'head' ).append( '<style id="voluto-preview-styles-' + option + '_' + device + '">' + output + '</style>' );
				} );
			} );
		});
	});	

	/**
	 * Responsive Paddings left/right
	 */
	 var $paddings_lr_options = { 
		'global_button_padding_lr': 'button, .button, input[type="button"], input[type="reset"], input[type="submit"]'
	};
	$.each( $paddings_lr_options, function( option, selector ) {
		$.each( $devices, function( device, mediaSize ) {
			wp.customize( option + '_' + device, function( value ) {
				value.bind( function( to ) {
				
					$( 'head' ).find( '#voluto-preview-styles-' + option + '_' + device ).remove();
		
					var output = '@media ' + mediaSize + ' {' + selector + ' { padding-left:' + to + 'px;padding-right:' + to + 'px; } }';
		
					$( 'head' ).append( '<style id="voluto-preview-styles-' + option + '_' + device + '">' + output + '</style>' );
				} );
			} );
		});
	});	


	/**
	 * Responsive top padding
	 */
	 var $paddings_top_options = { 
		'footer_bar_padding': '.site-info',
	};
	$.each( $paddings_top_options, function( option, selector ) {
		$.each( $devices, function( device, mediaSize ) {
			wp.customize( option + '_' + device, function( value ) {
				value.bind( function( to ) {
				
					$( 'head' ).find( '#voluto-preview-styles-' + option + '_' + device ).remove();
		
					var output = '@media ' + mediaSize + ' {' + selector + ' { padding-top:' + to + 'px; } }';
		
					$( 'head' ).append( '<style id="voluto-preview-styles-' + option + '_' + device + '">' + output + '</style>' );
				} );
			} );
		});
	});		

	/**
	 * Responsive bottom padding
	 */
	 var $paddings_top_options = { 
		'footer_bar_bottom_padding': '.site-info',
	};
	$.each( $paddings_top_options, function( option, selector ) {
		$.each( $devices, function( device, mediaSize ) {
			wp.customize( option + '_' + device, function( value ) {
				value.bind( function( to ) {
				
					$( 'head' ).find( '#voluto-preview-styles-' + option + '_' + device ).remove();
		
					var output = '@media ' + mediaSize + ' {' + selector + ' { padding-bottom:' + to + 'px; } }';
		
					$( 'head' ).append( '<style id="voluto-preview-styles-' + option + '_' + device + '">' + output + '</style>' );
				} );
			} );
		});
	});	

	/**
	 * Text alignment
	 */
	 var $align_options = { 
		'single_post_header_align': '.single-post .page-banner, .single-post .entry-header',
		'post_card_content_align': '.posts-loop article'
	};
	
	$.each( $align_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
				$( selector ).css( 'text-align', to );
			} );
		} );
	});	
	
	/**
	 * Vertical alignment
	 */
	var $align_options = { 
		'single_post_header_valign': '.single-post .page-banner.overlay',
	};
	
	$.each( $align_options, function( option, selector ) {
		wp.customize( option, function( value ) {
			value.bind( function( to ) {
				$( selector ).css( 'align-items', to );
			} );
		} );
	});	


	/**
	 * Responsive min. height
	 */
	var $resp_height = { 
		'post_header_height': '.single-post .page-banner',
	};
	$.each( $resp_height, function( option, selector ) {
		$.each( $devices, function( device, mediaSize ) {
			wp.customize( option + '_' + device, function( value ) {
				value.bind( function( to ) {
				
					$( 'head' ).find( '#voluto-preview-styles-' + option + '_' + device ).remove();
		
					var output = '@media ' + mediaSize + ' {' + selector + ' { min-height:' + to + 'px; } }';
		
					$( 'head' ).append( '<style id="voluto-preview-styles-' + option + '_' + device + '">' + output + '</style>' );
				} );
			} );
		});
	});	

	/**
	 * Responsive max. width
	 */
	 var $resp_width = { 
		'logo_size': '.custom-logo-link img',
	};
	$.each( $resp_width, function( option, selector ) {
		$.each( $devices, function( device, mediaSize ) {
			wp.customize( option + '_' + device, function( value ) {
				value.bind( function( to ) {
				
					$( 'head' ).find( '#voluto-preview-styles-' + option + '_' + device ).remove();
		
					var output = '@media ' + mediaSize + ' {' + selector + ' { max-width:' + to + 'px; } }';
		
					$( 'head' ).append( '<style id="voluto-preview-styles-' + option + '_' + device + '">' + output + '</style>' );
				} );
			} );
		});
	});		

	//Blog
	wp.customize( 'single_post_title_transform', function( value ) {
		value.bind( function( to ) {
			$( '.single-post .entry-title' ).css( 'text-transform', to );
		} );
	} );
	wp.customize( 'single_post_meta_transform', function( value ) {
		value.bind( function( to ) {
			$( '.single-post .entry-meta' ).css( 'text-transform', to );
		} );
	} );
	wp.customize( 'blog_archives_title_transform', function( value ) {
		value.bind( function( to ) {
			$( '.posts-loop .entry-title' ).css( 'text-transform', to );
		} );
	} );
	wp.customize( 'blog_archives_meta_transform', function( value ) {
		value.bind( function( to ) {
			$( '.posts-loop .entry-meta' ).css( 'text-transform', to );
		} );
	} );


	wp.customize( 'blog_image_radius', function( value ) {
		value.bind( function( to ) {
			$( '.post-thumbnail' ).css( 'border-radius', to + 'px' );
		} );
	} );
	wp.customize( 'post_card_element_spacing', function( value ) {
		value.bind( function( to ) {
			$( '.posts-loop .content-grid>*:not(:last-child), .posts-loop .content-list>*:not(:last-child)' ).css( 'margin-bottom', to + 'px' );
		} );
	} );

	wp.customize( 'headings_line_height', function( value ) {
		value.bind( function( to ) {
			$( 'h1,h2,h3,h4,h5,h6,.site-title' ).css( 'line-height', to );
		} );
	} );

	wp.customize( 'headings_letter_spacing', function( value ) {
		value.bind( function( to ) {
			$( 'h1,h2,h3,h4,h5,h6,.site-title' ).css( 'letter-spacing', to + 'px' );
		} );
	} );	
	
	wp.customize( 'body_line_height', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( 'line-height', to );
		} );
	} );

	wp.customize( 'body_letter_spacing', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( 'letter-spacing', to + 'px' );
		} );
	} );	
	

	wp.customize('voluto_body_font', function (value) {
		value.bind(function (to) {
		  $('head').find('#voluto-preview-google-fonts-body-css').remove();
		  $('head').append('<link id="voluto-preview-google-fonts-body-css" href="" rel="stylesheet">');
		  $('#voluto-preview-google-fonts-body-css').attr('href', 'https://fonts.googleapis.com/css?family=' + jQuery.parseJSON(to)['font'].replace(/ /g, '+') + ':' + jQuery.parseJSON(to)['regularweight'] + '&display=swap');
		  $('body').css('font-family', jQuery.parseJSON(to)['font']);
		  $('body').css('font-weight', jQuery.parseJSON(to)['regularweight']);
		});
	});
	wp.customize('voluto_headings_font', function (value) {
		value.bind(function (to) {
		  $('head').find('#voluto-preview-google-fonts-headings-css').remove();
		  $('head').append('<link id="voluto-preview-google-fonts-headings-css" href="" rel="stylesheet">');
		  $('#voluto-preview-google-fonts-headings-css').attr('href', 'https://fonts.googleapis.com/css?family=' + jQuery.parseJSON(to)['font'].replace(/ /g, '+') + ':' + jQuery.parseJSON(to)['regularweight'] + '&display=swap');
		  $('h1,h2,h3,h4,h5,h6,.site-title').css('font-family', jQuery.parseJSON(to)['font']);
		  $('h1,h2,h3,h4,h5,h6,.site-title').css('font-weight', jQuery.parseJSON(to)['regularweight']);
		});
	});	

	wp.customize('voluto_menu_font', function (value) {
		value.bind(function (to) {
		  $('head').find('#voluto-preview-google-fonts-menu-css').remove();
		  $('head').append('<link id="voluto-preview-google-fonts-menu-css" href="" rel="stylesheet">');
		  $('#voluto-preview-google-fonts-menu-css').attr('href', 'https://fonts.googleapis.com/css?family=' + jQuery.parseJSON(to)['font'].replace(/ /g, '+') + ':' + jQuery.parseJSON(to)['regularweight'] + '&display=swap');
		  $('.main-navigation a').css('font-family', jQuery.parseJSON(to)['font']);
		  $('.main-navigation a').css('font-weight', jQuery.parseJSON(to)['regularweight']);
		});
	});

	wp.customize( 'menu_text_transform', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation a' ).css( 'text-transform', to );
		} );
	} );	

}( jQuery ) );
