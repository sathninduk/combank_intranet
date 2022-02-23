<?php
/**
 * Class for dynamic CSS output
 *
 * @package Voluto
 */


if ( !class_exists( 'Voluto_Custom_CSS' ) ) :

	/**
	 * Voluto_Custom_CSS 
	 */
	Class Voluto_Custom_CSS {

		/**
		 * Instance
		 */		
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {		
			add_action( 'wp_enqueue_scripts', array( $this, 'output_css' ), 11 );
		}

		/**
		 * Output all custom CSS
		 */
		public function output_css() {
			global $post;

			$css = '';

			$accent_color 		= get_theme_mod( 'accent_color' );
			$accent_color_dark 	= get_theme_mod( 'accent_color_dark' );

			$css .= ':root { --color-accent:' . esc_attr( $accent_color ) . '; --color-accent-dark:' . esc_attr( $accent_color_dark ) . ';}' . "\n";

			/**
			 * Background colors
			 */
			$background_colors = array(
				'breadcrumbs_background' => '.voluto-breadcrumb-trail',
				'footer_widgets_background' => '.footer-widgets',
				'footer_bar_bg_color' => '.footer-bar',
				'before_footer_background' => '.before-footer',
				'footer_bar_bg_color' => '.footer-bar',
				'top_bar_background_color' => '.top-bar',
				'top_header_background_color' => '.site-header',
				'bottom_header_background_color' => '.menu-bar',
				'single_post_overlay_color' => '.page-banner.has-featured.overlay .banner-overlay',
				'global_button_background' => 'button,.button,.wp-block-button__link,input[type=\'button\'],input[type=\'reset\'],input[type=\'submit\']:not(.search-submit),.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]',
				"global_button_background_hover" => ".is-style-outline .wp-block-button__link:hover,button:hover,.button:hover,.wp-block-button__link:hover,input[type=\"button\"]:hover,input[type=\"reset\"]:hover,input[type=\"submit\"]:not(.search-submit):hover,.wpforms-form button[type=submit]:hover,div.wpforms-container-full .wpforms-form button[type=submit]:hover,div.nf-form-content input[type=button]:hover",
				'mobile_header_background_color' => '.mobile-header',
				'offcanvas_menu_background_color' => '.main-navigation.toggled',	
			);

			foreach ( $background_colors as $theme_mod => $selector ) {
				$css .= $this->generate_css( $selector, 'background-color', $theme_mod );
			}

			/**
			 * Colors
			 */
			$colors = array(
				'breadcrumbs_links' => '.voluto-breadcrumb-trail a',
				'breadcrumbs_text' 	=> '.voluto-breadcrumb-trail',
				'footer_bar_color' 	=> '.site-info, .site-info a',
				'footer_widgets_links_color' => '.footer-widgets a',
				'footer_widgets_color' => '.footer-widgets',
				'footer_widgets_title_color' => '.footer-widgets .widget .widget-title',	
				'before_footer_color' => '.before-footer h2, .before-footer h3, .before-footer h4,.before-footer,.before-footer a:not(.button)',
				'footer_bar_color' => '.footer-bar, .footer-bar a',
				'top_bar_color' => '.top-bar, .top-bar a',
				'top_header_color' 		=> '.site-header, .site-description, .site-title a, .site-header .main-navigation > div > ul > li > a',
				'bottom_header_color' => '.menu-bar,.menu-bar .main-navigation > div > ul > li > a',
				'single_post_title_color' => '.page-banner.has-featured.overlay .entry-title,.single-post .entry-title', 
				'single_post_meta_color' => '.page-banner.has-featured.overlay .entry-meta a, .page-banner.has-featured.overlay .entry-meta, .single-post .entry-meta, .single-post .entry-meta a',
				'blog_archives_title_color' => '.posts-loop .entry-title a',
				'blog_archives_meta_color' => '.posts-loop .entry-meta, .posts-loop .entry-meta a',
				'body_color' => 'body',
				'content_link_color' => '.entry-content p a:not(.button)', 
				"content_link_color_hover" => ".entry-content p a:not(.button):hover",
				'color_heading1' => 'h1',
				'color_heading2' => 'h2',
				'color_heading3' => 'h3',
				'color_heading4' => 'h4',
				'color_heading5' => 'h5',
				'color_heading6' => 'h6',
				'global_button_color' => '.elementor-button-wrapper .elementor-button,button,.widget .button,.button,.wp-block-button__link,input[type=\'button\'],input[type=\'reset\'],input[type=\'submit\'],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]',
				'global_button_color_hover' => '.widget .button:hover,.is-style-outline .wp-block-button__link:hover,.button.header-button:hover,input[type="submit"]:not(.search-submit):hover,button:hover,.button:hover,.wp-block-button__link:hover,input[type=\"button\"]:hover,input[type=\"reset\"]:hover,input[type=\"submit\"]:not(.search-submit):hover,.wpforms-form button[type=submit]:hover,div.wpforms-container-full .wpforms-form button[type=submit]:hover,div.nf-form-content input[type=button]:hover',
				'mobile_header_color' =>'#mobile-header, #mobile-header a',
				'offcanvas_menu_color' => '#mobile-header .main-navigation.toggled, #mobile-header .main-navigation.toggled a',
			);

			foreach ( $colors as $theme_mod => $selector ) {
				$css .= $this->generate_css( $selector, 'color', $theme_mod );
			}
			
			/**
			 * Border Color
			 */
			$border_colors = array(
				'footer_widgets_border_color' => '.footer-widgets-inner',	
				'before_footer_border_color' => '.before-footer-inner',
				'single_post_borders_color' => '.single-post .site-main>*:not(article)',
				'global_button_background_hover' => '.is-style-outline .wp-block-button__link,.is-style-outline .wp-block-button__link:hover'
			);

			foreach ( $border_colors as $theme_mod => $selector ) {
				$css .= $this->generate_css( $selector, 'border-color', $theme_mod );
			}	

			/**
			 * Border radius
			 */
			$border_radius = array(
				'blog_image_radius' => '.post-thumbnail',	
				'global_button_border_radius' => '.elementor-button-wrapper .elementor-button,button,.button,.wp-block-button__link,input[type=\'button\'],input[type=\'reset\'],input[type=\'submit\'],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]',
			);

			foreach ( $border_radius as $theme_mod => $selector ) {
				$css .= $this->generate_css( $selector, 'border-radius', $theme_mod, '', 'px' );
			}				
			
			/**
			 * Fill
			 */
			$fill_colors = array(
				'breadcrumbs_links' => '.voluto-breadcrumb-trail svg',
				'before_footer_color' => '.before-footer-social svg',
				'footer_bar_color' => '.footer-bar svg',
				'top_bar_color' => '.top-bar svg',
				'top_header_color' => '.site-header svg',
				'bottom_header_color' => '.menu-bar svg',
				'mobile_header_color' => '#mobile-header svg',
				'offcanvas_menu_color' => '#mobile-header .main-navigation.toggled svg',
			);

			foreach ( $fill_colors as $theme_mod => $selector ) {
				$css .= $this->generate_css( $selector, 'fill', $theme_mod );
			}	
			
			/**
			* Responsive font sizes
			 */
			$font_sizes = array(
				'loop_product_price_size' => 'ul.products li.product .price',
				'loop_product_title_size' => 'ul.products li.product .woocommerce-loop-product__title',
				'single_product_price_size' => '.single-product-top .price',
				'single_product_title_size' => '.single-product-top .entry-title',
				'single_page_title_size' => '.page .entry-header .entry-title',
				'single_post_title_size' => '.single-post .entry-title',
				'single_post_meta_size' => '.single-post .entry-meta, .single-post .entry-meta .posted-on',
				'h1_heading_font_size' => 'h1',
				'h2_heading_font_size' => 'h2',
				'h3_heading_font_size' => 'h3',
				'h4_heading_font_size' => 'h4',
				'h5_heading_font_size' => 'h5',
				'h6_heading_font_size' => 'h6',
				'body_font_size' => 'body',
				'blog_archives_title_size' => '.posts-loop .entry-title',
				'blog_archives_meta_size' => '.posts-loop .entry-meta, .posts-loop .entry-meta .posted-on',
				'global_button_font_size' => '.elementor-button-wrapper .elementor-button,button,.button,.wp-block-button__link,input[type=\'button\'],input[type=\'reset\'],input[type=\'submit\'],.wpforms-form button[type=submit],div.wpforms-container-full .wpforms-form button[type=submit],div.nf-form-content input[type=button]',
			);
			foreach ( $font_sizes as $theme_mod => $selector ) {
				$css .= $this->generate_responsive_css( $selector, 'font-size', $theme_mod, '', 'px' );
			}			
			
			/**
			 * Responsive top/bottom paddings
			 */
			$paddings_tb = array(
				'breadcrumbs_padding' 		=> '.voluto-breadcrumb-trail',
				'footer_widgets_padding' 	=> '.footer-widgets-inner',
				'before_footer_padding' 	=> '.before-footer-inner',
				'topbar_padding'			=> '.top-bar',
				'top_header_padding' 		=> '.site-branding',
				'bottom_header_padding'		=> '.menu-bar',
				'global_button_padding_tb'  => 'button, .button, input[type="button"], input[type="reset"], input[type="submit"], .wp-block-button__link'
			);
			foreach ( $paddings_tb as $theme_mod => $selector ) {
				$css .= $this->generate_responsive_css( $selector, 'padding-top', $theme_mod, '', 'px' );
				$css .= $this->generate_responsive_css( $selector, 'padding-bottom', $theme_mod, '', 'px' );
			}	

			/**
			 * Responsive left/right paddings
			 */
			$paddings_lr = array(
				'global_button_padding_lr'  => 'button, .button, input[type="button"], input[type="reset"], input[type="submit"], .wp-block-button__link'
			);
			foreach ( $paddings_lr as $theme_mod => $selector ) {
				$css .= $this->generate_responsive_css( $selector, 'padding-left', $theme_mod, '', 'px' );
				$css .= $this->generate_responsive_css( $selector, 'padding-right', $theme_mod, '', 'px' );
			}				

			/**
			 * Responsive top paddings
			 */
			$paddings_top = array(
				'footer_bar_padding' 	=> '.site-info',
			);
			foreach ( $paddings_top as $theme_mod => $selector ) {
				$css .= $this->generate_responsive_css( $selector, 'padding-top', $theme_mod, '', 'px' );
			}		
			
			/**
			 * Responsive bottom paddings
			 */
			$paddings_bottom = array(
				'footer_bar_bottom_padding' => '.site-info',

			);
			foreach ( $paddings_bottom as $theme_mod => $selector ) {
				$css .= $this->generate_responsive_css( $selector, 'padding-bottom', $theme_mod, '', 'px' );
			}				

			/**
			 * Responsive min.height
			 */
			$resp_height = array(
				'post_header_height' => '.single-post .page-banner',

			);
			foreach ( $resp_height as $theme_mod => $selector ) {
				$css .= $this->generate_responsive_css( $selector, 'min-height', $theme_mod, '', 'px' );
			}				
			
			/**
			 * Responsive max. width
			 */
			$resp_width = array(
				'logo_size' => '.custom-logo-link img',

			);
			foreach ( $resp_width as $theme_mod => $selector ) {
				$css .= $this->generate_responsive_css( $selector, 'max-width', $theme_mod, '', 'px' );
			}					

			/**
			 * Text alignment
			 */
			$text_align = array(
				'single_post_header_align' => '.single-post .page-banner, .single-post .entry-header',
				'post_card_content_align' => '.posts-loop article'
			);

			foreach ( $text_align as $theme_mod => $selector ) {
				$css .= $this->generate_css( $selector, 'text-align', $theme_mod );
			}	
			
			/**
			 * Vertical alignment
			 */
			$text_align = array(
				'single_post_header_valign' => '.single-post .page-banner.overlay',
			);

			foreach ( $text_align as $theme_mod => $selector ) {
				$css .= $this->generate_css( $selector, 'align-items', $theme_mod );
			}	

			/**
			 * Text transform
			 */
			$text_transform = array(
				'single_post_title_transform' 	=> '.single-post .entry-title',
				'single_post_meta_transform' 	=> '.single-post .entry-meta',
				'blog_archives_title_transform' => '.posts-loop .entry-title',
				'blog_archives_meta_transform'	=> '.posts-loop .entry-meta',
				'global_button_transform' 		=> 'button, .button, input[type="button"], input[type="reset"], input[type="submit"], .wp-block-button__link',
			);

			foreach ( $text_transform as $theme_mod => $selector ) {
				$css .= $this->generate_css( $selector, 'text-transform', $theme_mod );
			}	

			/**
			 * Letter spacing
			 */
			$letter_spacing = array(
				'global_button_letter_spacing' 		=> 'button, .button, input[type="button"], input[type="reset"], input[type="submit"], .wp-block-button__link',
				'body_letter_spacing'				=> 'body',
				'headings_letter_spacing' 			=> 'h1,h2,h3,h4,h5,h6,.site-title'
			);

			foreach ( $letter_spacing as $theme_mod => $selector ) {
				$css .= $this->generate_css( $selector, 'letter-spacing', $theme_mod, '', 'px' );
			}	
			
			/**
			 * Line height
			 */
			$line_height = array(
				'headings_line_height' 	=> 'h1,h2,h3,h4,h5,h6,.site-title',
				'body_line_height' 		=> 'body',
			);

			foreach ( $line_height as $theme_mod => $selector ) {
				$css .= $this->generate_css( $selector, 'line-height', $theme_mod );
			}		
			
			/**
			 * Fonts
			 */
			$body_font		= get_theme_mod( 'voluto_body_font' );
			$headings_font 	= get_theme_mod( 'voluto_headings_font' );
		
			$body_font 		= json_decode( $body_font, true );
			$headings_font 	= json_decode( $headings_font, true );
			
			if ( is_array( $body_font ) && 'Inter' !== $body_font['font'] ) {
				$css .= 'body { font-family:' . esc_attr( $body_font['font'] ) . ',' . esc_attr( $body_font['category'] ) . ';}' . "\n";	
			}
			
			if ( is_array( $headings_font ) && 'Inter' !== $headings_font['font'] ) {
				$css .= 'h1,h2,h3,h4,h5,h6,.site-title { font-family:' . esc_attr( $headings_font['font'] ) . ',' . esc_attr( $headings_font['category'] ) . ';}' . "\n";
			}			

			/**
			 * Margin bottom
			 */
			$margin_bottom = array(
				'post_card_element_spacing' 	=> '.posts-loop .content-grid>*:not(:last-child), .posts-loop .content-list>*:not(:last-child)',
			);

			foreach ( $margin_bottom as $theme_mod => $selector ) {
				$css .= $this->generate_css( $selector, 'margin-bottom', $theme_mod, '', 'px' );
			}				

			/* Blog images */
			$blog_image_stretch = get_theme_mod( 'blog_image_stretch', 1 );
			
			if ( $blog_image_stretch ) {
				$css .= '.card-style-boxed .post-content-inner .post-thumbnail { margin-left:-30px;margin-right:-30px;}' . "\n";
			}

			/* Menu bar */
			$main_header_background_type = get_theme_mod( 'main_header_background_type', 'gradient' );

			if ( 'color' === $main_header_background_type ) {
				$css .= '.menu-bar {background-image:none;}' . "\n";
			}

			$post_cats_style = get_theme_mod( 'post_cats_style', 'solid' );

			if ( 'link' === $post_cats_style ) {
				$css .= '.post-cats a {color:var(--color-accent);background:transparent;padding:0;}' . "\n";
				$css .= '.post-cats a:hover {color:var(--color-accent-dark);background:transparent;}' . "\n";
			}
			

			$css = apply_filters( 'voluto_custom_css_output', $css );

			wp_add_inline_style( 'voluto-style-min', $css );	
		}

        /**
         * Generate CSS
         */
        public static function generate_css( $selector, $style, $mod_name, $prefix ='', $postfix = '' ) {
            $return = '';
            $mod = get_theme_mod( $mod_name );
            if ( ! empty( $mod ) ) {
               $return = sprintf('%s { %s:%s; }',
                    $selector,
                    $style,
                    $prefix.$mod.$postfix
               );
            }
            return $return;
        }

        /**
         * Generate Responsive CSS
         */
        public static function generate_responsive_css( $selector, $style, $mod_name, $prefix ='', $postfix = '' ) {
            $return = '';
            $mod = get_theme_mod( $mod_name );

			$devices 	= array( 
				'desktop' 	=> '@media (min-width:  ' . ( self::get_tablet_breakpoint() + 1 ) . 'px)',
				'tablet'	=> '@media (min-width:  ' . ( self::get_mobile_breakpoint() + 1 ) . 'px) and (max-width:  '. self::get_tablet_breakpoint() . 'px)',
				'mobile'	=> '@media (max-width:  ' . self::get_mobile_breakpoint() . 'px)'
			);

			foreach ( $devices as $device => $media ) {
				$mod = get_theme_mod( $mod_name . '_' . $device );
				if ( ! empty( $mod ) || 0 === $mod ) {
					$return .= sprintf(  $media . ' { ' . '%s { %s:%s; } }',$selector, $style, $prefix.$mod.$postfix );
				}
			}
			return $return;
        }		

		/**
		 * Tablet breakpoint
		 */
		public static function get_tablet_breakpoint() {
			$breakpoint = '991';
			return apply_filters( 'voluto_tablet_breakpoint', $breakpoint );
		}

		/**
		 * Mobile breakpoint
		 */
		public static function get_mobile_breakpoint() {
			$breakpoint = '575';
			return apply_filters( 'voluto_mobile_breakpoint', $breakpoint );
		}			


	}

	/**
	 * Initialize class
	 */
	Voluto_Custom_CSS::get_instance();

endif;