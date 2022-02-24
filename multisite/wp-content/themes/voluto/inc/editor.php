<?php
/**
 * Functionality for the editor
 *
 * @package Voluto
 */

/**
 * Enqueue assets
 */
function voluto_enqueue_gutenberg_assets() {

	wp_enqueue_style( 'voluto-block-editor-styles', get_template_directory_uri() . '/assets/css/editor.min.css', array(), VOLUTO_VERSION );

	wp_enqueue_style( 'voluto-fonts', voluto_generate_fonts_url(), array(), VOLUTO_VERSION );



	$css = '';

	$accent_color 		= get_theme_mod( 'accent_color' );
	$accent_color_dark 	= get_theme_mod( 'accent_color_dark' );

	$css .= ':root { --color-accent:' . esc_attr( $accent_color ) . '; --color-accent-dark:' . esc_attr( $accent_color_dark ) . ';}' . "\n";

	/**
	 * Background colors
	 */
	$background_colors = array(
		'global_button_background' => 'div.editor-styles-wrapper .wp-block-button__link,div.editor-styles-wrapper input[type=\"button\"],div.editor-styles-wrapper input[type=\"reset\"],div.editor-styles-wrapper input[type=\"submit\"]:not(.search-submit),div.editor-styles-wrapper .wpforms-form button[type=submit]',
		"global_button_background_hover" => "div.editor-styles-wrapper .is-style-outline .wp-block-button__link:hover, div.editor-styles-wrapper .wp-block-button__link:hover,div.editor-styles-wrapper input[type=\"button\"]:hover,div.editor-styles-wrapper input[type=\"reset\"]:hover,div.editor-styles-wrapper input[type=\"submit\"]:not(.search-submit):hover,div.editor-styles-wrapper .wpforms-form button[type=submit]:hover",
	);

	foreach ( $background_colors as $theme_mod => $selector ) {
		$css .= Voluto_Custom_CSS::generate_css( $selector, 'background-color', $theme_mod );
	}

	/**
	 * Colors
	 */
	$colors = array(
		'single_post_title_color' => 'div.editor-styles-wrapper .editor-post-title .editor-post-title__input', 
		'body_color' => 'div.editor-styles-wrapper',
		'content_link_color' => 'div.editor-styles-wrapper p a:not(.button)', 
		"content_link_color_hover" => "div.editor-styles-wrapper p a:not(.button):hover",
		'color_heading1' => 'div.editor-styles-wrapper h1',
		'color_heading2' => 'div.editor-styles-wrapper h2',
		'color_heading3' => 'div.editor-styles-wrapper h3',
		'color_heading4' => 'div.editor-styles-wrapper h4',
		'color_heading5' => 'div.editor-styles-wrapper h5',
		'color_heading6' => 'div.editor-styles-wrapper h6',
		'global_button_color' 		=> 'div.editor-styles-wrapper .wp-block-button__link,div.editor-styles-wrapper input[type=\"button\"],div.editor-styles-wrapper input[type=\"reset\"],div.editor-styles-wrapper input[type=\"submit\"]:not(.search-submit),div.editor-styles-wrapper .wpforms-form button[type=submit]',
		'global_button_color_hover' => 'div.editor-styles-wrapper .is-style-outline .wp-block-button__link:hover, div.editor-styles-wrapper .wp-block-button__link:hover,div.editor-styles-wrapper input[type=\"button\"]:hover,div.editor-styles-wrapper input[type=\"reset\"]:hover,div.editor-styles-wrapper input[type=\"submit\"]:not(.search-submit):hover,div.editor-styles-wrapper .wpforms-form button[type=submit]:hover',
	);

	foreach ( $colors as $theme_mod => $selector ) {
		$css .= Voluto_Custom_CSS::generate_css( $selector, 'color', $theme_mod );
	}

	/**
	 * Border Color
	 */
	$border_colors = array(
		'global_button_background_hover' => 'div.editor-styles-wrapper .is-style-outline .wp-block-button__link,div.editor-styles-wrapper .is-style-outline .wp-block-button__link:hover'
	);

	foreach ( $border_colors as $theme_mod => $selector ) {
		$css .= Voluto_Custom_CSS::generate_css( $selector, 'border-color', $theme_mod );
	}

	/**
	 * Border radius
	 */
	$border_radius = array(
		'global_button_border_radius' => 'div.editor-styles-wrapper .wp-block-button__link,div.editor-styles-wrapper input[type=\"button\"],div.editor-styles-wrapper input[type=\"reset\"],div.editor-styles-wrapper input[type=\"submit\"]:not(.search-submit),div.editor-styles-wrapper .wpforms-form button[type=submit]',
	);

	foreach ( $border_radius as $theme_mod => $selector ) {
		$css .= Voluto_Custom_CSS::generate_css( $selector, 'border-radius', $theme_mod, '', 'px' );
	}

	/**
	* Responsive font sizes
	*/
	$font_sizes = array(
		'single_post_title_size' => 'div.editor-styles-wrapper .editor-post-title .editor-post-title__input',
		'h1_heading_font_size' => 'div.editor-styles-wrapper h1',
		'h2_heading_font_size' => 'div.editor-styles-wrapper h2',
		'h3_heading_font_size' => 'div.editor-styles-wrapper h3',
		'h4_heading_font_size' => 'div.editor-styles-wrapper h4',
		'h5_heading_font_size' => 'div.editor-styles-wrapper h5',
		'h6_heading_font_size' => 'div.editor-styles-wrapper h6',
		'body_font_size' => 'div.editor-styles-wrapper',
		'global_button_font_size' => 'div.editor-styles-wrapper .wp-block-button__link,div.editor-styles-wrapper input[type=\"button\"],div.editor-styles-wrapper input[type=\"reset\"],div.editor-styles-wrapper input[type=\"submit\"]:not(.search-submit),div.editor-styles-wrapper .wpforms-form button[type=submit]',
	);
	foreach ( $font_sizes as $theme_mod => $selector ) {
		$css .= Voluto_Custom_CSS::generate_responsive_css( $selector, 'font-size', $theme_mod, '', 'px' );
	}			

	/**
	 * Responsive top/bottom paddings
	 */
	$paddings_tb = array(
		'global_button_padding_tb'  => 'div.editor-styles-wrapper .wp-block-button__link,div.editor-styles-wrapper input[type=\"button\"],div.editor-styles-wrapper input[type=\"reset\"],div.editor-styles-wrapper input[type=\"submit\"]:not(.search-submit),div.editor-styles-wrapper .wpforms-form button[type=submit]'
	);
	foreach ( $paddings_tb as $theme_mod => $selector ) {
		$css .= Voluto_Custom_CSS::generate_responsive_css( $selector, 'padding-top', $theme_mod, '', 'px' );
		$css .= Voluto_Custom_CSS::generate_responsive_css( $selector, 'padding-bottom', $theme_mod, '', 'px' );
	}	

	/**
	 * Responsive left/right paddings
	 */
	$paddings_lr = array(
		'global_button_padding_lr'  => 'div.editor-styles-wrapper .wp-block-button__link,div.editor-styles-wrapper input[type=\"button\"],div.editor-styles-wrapper input[type=\"reset\"],div.editor-styles-wrapper input[type=\"submit\"]:not(.search-submit),div.editor-styles-wrapper .wpforms-form button[type=submit]'
	);
	foreach ( $paddings_lr as $theme_mod => $selector ) {
		$css .= Voluto_Custom_CSS::generate_responsive_css( $selector, 'padding-left', $theme_mod, '', 'px' );
		$css .= Voluto_Custom_CSS::generate_responsive_css( $selector, 'padding-right', $theme_mod, '', 'px' );
	}			

	/**
	 * Text alignment
	 */
	$text_align = array(
		'single_post_header_align' => 'div.editor-styles-wrapper .editor-post-title .editor-post-title__input',
	);

	foreach ( $text_align as $theme_mod => $selector ) {
		$css .= Voluto_Custom_CSS::generate_css( $selector, 'text-align', $theme_mod );
	}	


	/**
	 * Text transform
	 */
	$text_transform = array(
		'single_post_title_transform' 	=> 'div.editor-styles-wrapper .editor-post-title .editor-post-title__input',
		'global_button_transform' 		=> 'div.editor-styles-wrapper .wp-block-button__link,div.editor-styles-wrapper input[type=\"button\"],div.editor-styles-wrapper input[type=\"reset\"],div.editor-styles-wrapper input[type=\"submit\"]:not(.search-submit),div.editor-styles-wrapper .wpforms-form button[type=submit]',
	);

	foreach ( $text_transform as $theme_mod => $selector ) {
		$css .= Voluto_Custom_CSS::generate_css( $selector, 'text-transform', $theme_mod );
	}	

	/**
	 * Letter spacing
	 */
	$letter_spacing = array(
		'global_button_letter_spacing' 		=> 'div.editor-styles-wrapper .wp-block-button__link,div.editor-styles-wrapper input[type=\"button\"],div.editor-styles-wrapper input[type=\"reset\"],div.editor-styles-wrapper input[type=\"submit\"]:not(.search-submit),div.editor-styles-wrapper .wpforms-form button[type=submit]',
		'body_letter_spacing'				=> 'div.editor-styles-wrapper',
		'headings_letter_spacing' 			=> '.editor-styles-wrapper .editor-post-title .editor-post-title__input, div.editor-styles-wrapper h1, div.editor-styles-wrapper h2,div.editor-styles-wrapper h3,div.editor-styles-wrapper h4,div.editor-styles-wrapper h5,div.editor-styles-wrapper h6'
	);

	foreach ( $letter_spacing as $theme_mod => $selector ) {
		$css .= Voluto_Custom_CSS::generate_css( $selector, 'letter-spacing', $theme_mod, '', 'px' );
	}	

	/**
	 * Line height
	 */
	$line_height = array(
		'headings_line_height' 	=>  '.editor-styles-wrapper .editor-post-title .editor-post-title__input, div.editor-styles-wrapper h1, div.editor-styles-wrapper h2,div.editor-styles-wrapper h3,div.editor-styles-wrapper h4,div.editor-styles-wrapper h5,div.editor-styles-wrapper h6',
		'body_line_height' 		=> 'div.editor-styles-wrapper',
	);

	foreach ( $line_height as $theme_mod => $selector ) {
		$css .= Voluto_Custom_CSS::generate_css( $selector, 'line-height', $theme_mod );
	}		

	/**
	 * Fonts
	 */
    if (get_theme_mod('voluto_body_font') != null) {
        $body_font		= get_theme_mod( 'voluto_body_font' );
        $body_font 		= json_decode( $body_font, true );
        if ( 'Inter' !== $body_font['font'] ) {
            $css .= 'div.editor-styles-wrapper { font-family:' . esc_attr( $body_font['font'] ) . ',' . esc_attr( $body_font['category'] ) . ';}' . "\n";
        }
    }

    if (get_theme_mod('voluto_headings_font') != null) {
        $headings_font = get_theme_mod('voluto_headings_font');
        $headings_font = json_decode($headings_font, true);
        if ('Inter' !== $headings_font['font']) {
            $css .= '.editor-styles-wrapper .editor-post-title .editor-post-title__input, div.editor-styles-wrapper h1, div.editor-styles-wrapper h2,div.editor-styles-wrapper h3,div.editor-styles-wrapper h4,div.editor-styles-wrapper h5,div.editor-styles-wrapper h6 { font-family:' . esc_attr($headings_font['font']) . ',' . esc_attr($headings_font['category']) . ';}' . "\n";
        }
    }

	wp_add_inline_style( 'voluto-block-editor-styles', $css );	

}
add_action( 'enqueue_block_editor_assets', 'voluto_enqueue_gutenberg_assets' );