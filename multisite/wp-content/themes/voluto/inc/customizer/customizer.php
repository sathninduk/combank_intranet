<?php
/**
 * Voluto Theme Customizer
 *
 * @package Voluto
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function voluto_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_section( 'title_tagline' )->panel 		= 'voluto_header_panel';
	$wp_customize->get_section( 'title_tagline' )->priority 	= 1;
	$wp_customize->remove_control( 'header_textcolor' );
	$wp_customize->get_section( 'background_image' )->panel 	= 'voluto_general_panel';
	
	/**
	 * Controls
	 */
	// @codingStandardsIgnoreStart WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
	require get_template_directory() . '/inc/customizer/custom-controls/repeater/class_voluto_repeater.php';
	require get_template_directory() . '/inc/customizer/custom-controls/responsive-number/class_voluto_responsive_number.php';
	require get_template_directory() . '/inc/customizer/custom-controls/class_voluto_tabs.php';
	require get_template_directory() . '/inc/customizer/custom-controls/class_voluto_toggle.php';
	require get_template_directory() . '/inc/customizer/custom-controls/class_voluto_radio_images.php';
	require get_template_directory() . '/inc/customizer/custom-controls/class_voluto_info.php';
	require get_template_directory() . '/inc/customizer/custom-controls/typography/class_voluto_typography.php';
	require get_template_directory() . '/inc/customizer/custom-controls/slider/class_voluto_slider.php';
	require get_template_directory() . '/inc/customizer/custom-controls/class_voluto_title.php';
	require get_template_directory() . '/inc/customizer/custom-controls/class_voluto_posts.php';
	require get_template_directory() . '/inc/customizer/custom-controls/class_voluto_radio_buttons.php';
	require get_template_directory() . '/inc/customizer/custom-controls/class_voluto_multiselect.php';
	require get_template_directory() . '/inc/customizer/custom-controls/alpha-color/class_voluto_alpha_color.php';
	require get_template_directory() . '/inc/customizer/custom-controls/class_voluto_upsell.php';
	// @codingStandardsIgnoreEnd WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

	$wp_customize->register_control_type( '\Kirki\Control\sortable' );



	// @codingStandardsIgnoreStart WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
	/**
	 * Sanitize
	 */
	require get_template_directory() . '/inc/customizer/sanitize.php';

	/**
	 * Options
	 */
	require get_template_directory() . '/inc/customizer/options/options-top-bar.php';
	require get_template_directory() . '/inc/customizer/options/options-header.php';
	require get_template_directory() . '/inc/customizer/options/options-hero.php';
	require get_template_directory() . '/inc/customizer/options/options-typography.php';
	require get_template_directory() . '/inc/customizer/options/options-breadcrumbs.php';
	require get_template_directory() . '/inc/customizer/options/options-blog.php';
	require get_template_directory() . '/inc/customizer/options/options-blog-single.php';
	require get_template_directory() . '/inc/customizer/options/options-sharing.php';
	require get_template_directory() . '/inc/customizer/options/options-footer.php';
	require get_template_directory() . '/inc/customizer/options/options-colors.php';
	require get_template_directory() . '/inc/customizer/options/options-buttons.php';

	/**
	 * Callbacks
	 */
	require get_template_directory() . '/inc/customizer/callbacks.php';	
	// @codingStandardsIgnoreEnd WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound			


	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'voluto_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'voluto_customize_partial_blogdescription',
			)
		);
	}

	/**
	 * Register general panel
	 */
	$wp_customize->add_panel(
		'voluto_general_panel',
		array(
			'title'         => esc_html__( 'General', 'voluto' ),
			'priority'      => 1,
		)
	);
}
add_action( 'customize_register', 'voluto_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function voluto_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function voluto_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function voluto_customize_preview_js() {
	wp_enqueue_script( 'voluto-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), VOLUTO_VERSION, true );
}
add_action( 'customize_preview_init', 'voluto_customize_preview_js' );

function voluto_customizer_scripts() {
	wp_enqueue_script( 'voluto-customizer-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery', 'jquery-ui-core' ), '20201211', true );

	wp_enqueue_style( 'voluto-customizer-styles', get_template_directory_uri() . '/assets/css/customizer.min.css' );
}
add_action( 'customize_controls_print_footer_scripts', 'voluto_customizer_scripts' );