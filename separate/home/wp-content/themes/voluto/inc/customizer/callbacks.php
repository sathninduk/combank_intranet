<?php
/**
 * Customizer callbacks
 *
 * @package Voluto
 */

 /**
 * Post grid
 */
function voluto_hero_post_grid_active_callback() {
    $hero_type = get_theme_mod( 'voluto_hero_type', 'post_grid' );

	if ( 'post_grid' === $hero_type ) {
		return true;
	} else {
		return false;
	}    
}

function voluto_hero_header_image_active_callback() {
    $hero_type = get_theme_mod( 'voluto_hero_type', 'post_grid' );

	if ( 'header_image' === $hero_type ) {
		return true;
	} else {
		return false;
	}    
}

function voluto_hero_post_grid_posts_callback() {
	$hero_type 			= get_theme_mod( 'voluto_hero_type', 'post_grid' );
	$post_grid_source 	= get_theme_mod( 'post_grid_source', 'post' );

	if ( 'post_grid' !== $hero_type ) {
		return false;
	}

	if ( 'post' === $post_grid_source ) {
		return true;
	} else {
		return false;
	} 	
}

function voluto_hero_post_grid_pages_callback() {
	$hero_type 			= get_theme_mod( 'voluto_hero_type', 'post_grid' );
	$post_grid_source 	= get_theme_mod( 'post_grid_source', 'post' );

	if ( 'post_grid' !== $hero_type ) {
		return false;
	}

	if ( 'page' === $post_grid_source ) {
		return true;
	} else {
		return false;
	} 	
}

function voluto_hero_layout_callback() {
	$hero_type 	= get_theme_mod( 'voluto_hero_type', 'post_grid' );

	if ( 'disabled' !== $hero_type ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Top bar active
 */
function voluto_top_bar_active_callback() {
    $enable_top_bar = get_theme_mod( 'enable_top_bar' );

	if ( $enable_top_bar ) {
		return true;
	} else {
		return false;
	}    
}

/**
 * Header button
 */
function voluto_header_button_active_callback() {
    $enable = get_theme_mod( 'enable_header_button', 1 );

	if ( $enable ) {
		return true;
	} else {
		return false;
	}    
}

/**
 * Header contact
 */
function voluto_header_contact_active_callback() {
    $enable = get_theme_mod( 'enable_header_contact', 0 );

	if ( $enable ) {
		return true;
	} else {
		return false;
	}    
}

/**
 * Header bottom bar
 */
function voluto_bottom_header_bar_callback() {
	$layout = get_theme_mod( 'main_header_layout', 'default' );

	if ( 'inline' !== $layout ) {
		return true;
	} else {
		return false;
	}
}


/**
 * Blog card style
 */
function voluto_blog_card_boxed_callback() {
	$layout = get_theme_mod( 'post_card_style', 'regular' );

	if ( 'boxed' === $layout && voluto_blog_featured_image_callback() ) {
		return true;
	} else {
		return false;
	}	
}

/**
 * Post elements callbacks
 */
function voluto_blog_post_meta_callback() {
	$elements = get_theme_mod( 'post_item_elements', array( 'loop_image', 'loop_category', 'loop_post_title', 'loop_post_excerpt', 'loop_post_meta' ) );

	if ( in_array( 'loop_post_meta', $elements ) ) {
		return true;
	} else {
		return false;
	}
}

function voluto_blog_read_more_callback() {
	$elements = get_theme_mod( 'post_item_elements', array( 'loop_image', 'loop_category', 'loop_post_title', 'loop_post_excerpt', 'loop_post_meta' ) );

	if ( in_array( 'loop_read_more', $elements ) ) {
		return true;
	} else {
		return false;
	}
}

function voluto_blog_excerpt_callback() {
	$elements = get_theme_mod( 'post_item_elements', array( 'loop_image', 'loop_category', 'loop_post_title', 'loop_post_excerpt', 'loop_post_meta' ) );

	if ( in_array( 'loop_post_excerpt', $elements ) ) {
		return true;
	} else {
		return false;
	}
}

function voluto_blog_featured_image_callback() {
	$elements = get_theme_mod( 'post_item_elements', array( 'loop_image', 'loop_category', 'loop_post_title', 'loop_post_excerpt', 'loop_post_meta' ) );

	if ( in_array( 'loop_image', $elements ) ) {
		return true;
	} else {
		return false;
	}
}

function voluto_blog_cats_callback() {
	$elements = get_theme_mod( 'post_item_elements', array( 'loop_image', 'loop_category', 'loop_post_title', 'loop_post_excerpt', 'loop_post_meta' ) );

	if ( in_array( 'loop_category', $elements ) ) {
		return true;
	} else {
		return false;
	}
}

function voluto_blog_post_header_container_callback() {
	$layout = get_theme_mod( 'single_post_header_layout', 'standard' );

	if ( 'standard' !== $layout ) {
		return true;
	} else {
		return false;
	}	
}

function voluto_blog_post_header_overlay_container_callback() {
	$layout = get_theme_mod( 'single_post_header_layout', 'standard' );

	if ( 'overlay' === $layout ) {
		return true;
	} else {
		return false;
	}	
}

function voluto_social_top_bar_callback() {
	$top_bar_active = voluto_top_bar_active_callback();

	$top_bar_left 	= get_theme_mod( 'top_bar_left', 'contact' );
	$top_bar_right 	= get_theme_mod( 'top_bar_right', 'text' );

	if ( $top_bar_active && ( 'social' === $top_bar_left || 'social' === $top_bar_right ) ) {
		return true;
 	} else {
		 return false;
	}
}

function voluto_text_top_bar_callback() {
	$top_bar_active = voluto_top_bar_active_callback();

	$top_bar_left 	= get_theme_mod( 'top_bar_left', 'contact' );
	$top_bar_right 	= get_theme_mod( 'top_bar_right', 'text' );

	if ( $top_bar_active && ( 'text' === $top_bar_left || 'text' === $top_bar_right ) ) {
		return true;
 	} else {
		 return false;
	}
}

function voluto_contact_top_bar_callback() {
	$top_bar_active = voluto_top_bar_active_callback();

	$top_bar_left 	= get_theme_mod( 'top_bar_left', 'contact' );
	$top_bar_right 	= get_theme_mod( 'top_bar_right', 'text' );

	if ( $top_bar_active && ( 'contact' === $top_bar_left || 'contact' === $top_bar_right ) ) {
		return true;
 	} else {
		return false;
	}
}

function voluto_nav_top_bar_callback() {
	$top_bar_active = voluto_top_bar_active_callback();

	$top_bar_left 	= get_theme_mod( 'top_bar_left', 'contact' );
	$top_bar_right 	= get_theme_mod( 'top_bar_right', 'text' );

	if ( $top_bar_active && ( 'navigation' === $top_bar_left || 'navigation' === $top_bar_right ) ) {
		return true;
 	} else {
		return false;
	}
}

function voluto_blog_grid_callback() {
	$layout = get_theme_mod( 'blog_layout', 'list' );

	if ( 'grid' === $layout || 'masonry' === $layout ) {
		return true;
	} else {
		return false;
	}	
}

function voluto_before_footer_cta_callback() {
	$layout = get_theme_mod( 'before_footer_type', 'none' );

	if ( 'before_footer_cta' === $layout ) {
		return true;
	} else {
		return false;
	}		
}

function voluto_before_footer_social_callback() {
	$layout = get_theme_mod( 'before_footer_type', 'none' );

	if ( 'before_footer_social' === $layout ) {
		return true;
	} else {
		return false;
	}		
}

function voluto_before_footer_html_callback() {
	$layout = get_theme_mod( 'before_footer_type', 'none' );

	if ( 'before_footer_html' === $layout ) {
		return true;
	} else {
		return false;
	}		
}

function voluto_before_footer_shortcode_callback() {
	$layout = get_theme_mod( 'before_footer_type', 'none' );

	if ( 'before_footer_shortcode' === $layout ) {
		return true;
	} else {
		return false;
	}		
}

function voluto_before_footer_active_callback() {
	$layout = get_theme_mod( 'before_footer_type', 'none' );

	if ( 'none' !== $layout ) {
		return true;
	} else {
		return false;
	}		
}

function voluto_main_header_background_callback() {

	$layout = get_theme_mod( 'main_header_layout', 'default' );
	$type 	= get_theme_mod( 'main_header_background_type', 'gradient' );

	if ( 'color' === $type && 'inline' !== $layout ) {
		return true;
	} else {
		return false;
	}
}

function voluto_main_header_gradient_callback() {
	
	$layout = get_theme_mod( 'main_header_layout', 'default' );
	$type = get_theme_mod( 'main_header_background_type', 'gradient' );

	if ( 'gradient' === $type && 'inline' !== $layout ) {
		return true;
	} else {
		return false;
	}
}

function voluto_header_ad_layout_callback() {
	$main_header_layout = get_theme_mod( 'main_header_header', 'adspace' );

	if ( 'adspace' === $main_header_layout ) {
		return true;
	} else {
		return false;
	}
}