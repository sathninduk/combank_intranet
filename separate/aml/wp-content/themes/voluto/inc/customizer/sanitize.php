<?php
/**
 * Sanitize functions for the Customizer
 *
 * @package Voluto
 */

/**
 * Posts navigation
 * control type: select
 */
function voluto_sanitize_posts_navigation( $input ) {
    if ( in_array( $input, array( 'pagination', 'navigation' ), true ) ) {
        return $input;
    }
}

/**
 * Sanitize color control with alpha channel
 */
function voluto_hex_rgba_sanitize( $input, $setting ) {
    if ( empty( $input ) || is_array( $input ) ) {
        return $setting->default;
    }

    if ( false === strpos( $input, 'rgba' ) ) {
        // If string doesn't start with 'rgba' then santize as hex color
        $input = sanitize_hex_color( $input );
    } else {
        // Sanitize as RGBa color
        $input = str_replace( ' ', '', $input );
        sscanf( $input, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
        $input = 'rgba(' . voluto_number_in_range( $red, 0, 255 ) . ',' . voluto_number_in_range( $green, 0, 255 ) . ',' . voluto_number_in_range( $blue, 0, 255 ) . ',' . voluto_number_in_range( $alpha, 0, 1 ) . ')';
    }
    return $input;
}

function voluto_number_in_range( $input, $min, $max ){
    if ( $input < $min ) {
        $input = $min;
    }
    if ( $input > $max ) {
        $input = $max;
    }
    return $input;
}

/**
 * Fonts
 */
function voluto_google_fonts_sanitize( $input ) {
    $val =  json_decode( $input, true );
    if( is_array( $val ) ) {
        foreach ( $val as $key => $value ) {
            $val[$key] = sanitize_text_field( $value );
        }
        $input = json_encode( $val );
    }
    else {
        $input = json_encode( sanitize_text_field( $val ) );
    }
    return $input;
}

/**
 * Toggles
 */
function voluto_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

/**
 * Selects
 */
function voluto_sanitize_select( $input, $setting ){
          
    $input = sanitize_key($input);

    $choices = $setting->manager->get_control( $setting->id )->choices;
                      
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
      
}

/**
 * Selects
 */
function voluto_sanitize_range( $input, $setting ) {
    $attrs = $setting->manager->get_control( $setting->id )->input_attrs;

    $min = ( isset( $attrs['min'] ) ? $attrs['min'] : $input );
    $max = ( isset( $attrs['max'] ) ? $attrs['max'] : $input );
    $step = ( isset( $attrs['step'] ) ? $attrs['step'] : 1 );

    $number = ( $input / $attrs['step'] ) * $attrs['step'];

    return voluto_number_in_range( $number, $min, $max );
}

/**
 * Sanitize URLs
 */
function voluto_sanitize_urls( $input ) {
    if ( strpos( $input, ',' ) !== false) {
        $input = explode( ',', $input );
    }
    if ( is_array( $input ) ) {
        foreach ($input as $key => $value) {
            $input[$key] = esc_url_raw( $value );
        }
        $input = implode( ',', $input );
    }
    else {
        $input = esc_url_raw( $input );
    }
    return $input;
}

/**
 * Sanitize blog post elements
 */
function voluto_sanitize_blog_post_elements( $input ) {
    $input     = (array) $input;
    $sanitized = array();

    foreach ( $input as $sub_value ) {
        if ( in_array( $sub_value, array( 'loop_read_more','loop_image', 'loop_category', 'loop_post_title', 'loop_post_excerpt', 'loop_post_meta' ), true ) ) {
            $sanitized[] = $sub_value;
        }
    }
    return $sanitized;
}

/**
 * Sanitize text
 */
function voluto_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Sanitize post ids array
 */
function voluto_sanitize_post_array( $input ) {
    $input     = (array) $input;
    
    $sanitized = array_map( 'absint', $input );

    return $sanitized;
}

/**
 * Sanitize multiselect
 */
function voluto_sanitize_multiselect( $input ) {

	$multi_values = !is_array( $input ) ? explode( ',', $input ) : $input;

	return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}