<?php
/**
 * Breadcrumbs Customizer options
 *
 * @package Voluto
 */

$voluto_colors = voluto_theme_colors();

/**
 * Hero
 */
$wp_customize->add_section(
	'voluto_breadcrumbs',
	array(
		'title'         => esc_html__( 'Breadcrumbs', 'voluto' ),
		'panel'			=> 'voluto_general_panel',
		'priority'      => 11,
	)
);

$wp_customize->add_setting(
	'voluto_breadcrumbs_display',
	array(
		'default'           => array( 'is_home', 'is_single', 'is_page', 'is_archive', 'is_search' ),
		'sanitize_callback' => 'voluto_sanitize_multiselect'
	)
);

$wp_customize->add_control(
	new Voluto_Multiselect_Control(
		$wp_customize,
		'voluto_breadcrumbs_display',
		array(
			'section' => 'voluto_breadcrumbs',
			'label'   => esc_html__( 'Display breadcrumbs on:', 'voluto' ),
			'choices' => array(
				'is_home'    	=> esc_html__( 'Blog home', 'voluto' ),
				'is_single'  	=> esc_html__( 'Single posts', 'voluto' ),
				'is_page'    	=> esc_html__( 'Single pages', 'voluto' ),
				'is_archive' 	=> esc_html__( 'Archives', 'voluto' ),
				'is_search' 	=> esc_html__( 'Search', 'voluto' )
			)
		)
	)
);

$wp_customize->add_setting( 'breadcrumbs_separator',
	array(
		'default' 			=> 'icon-angle-right',
		'sanitize_callback' => 'voluto_sanitize_text'
	)
);
$wp_customize->add_control( new Voluto_Radio_Buttons( $wp_customize, 'breadcrumbs_separator',
	array(
		'label'   => esc_html__( 'Separator', 'voluto' ),
		'section' => 'voluto_breadcrumbs',
		'columns' => 3,
		'choices' => array(
			'icon-angle-right' 			=> '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 20 20"><path d="M7.7,20c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1.1,0-1.5l8.1-8.1L6.7,1.8c-0.4-0.4-0.4-1.1,0-1.5c0.4-0.4,1.1-0.4,1.5,0l9.1,9.1c0.4,0.4,0.4,1.1,0,1.5l-8.8,8.9C8.2,19.9,7.9,20,7.7,20z"/></svg>',
			'icon-double-angle-right' 	=> '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 448 512"><path d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34zm192-34l-136-136c-9.4-9.4-24.6-9.4-33.9 0l-22.6 22.6c-9.4 9.4-9.4 24.6 0 33.9l96.4 96.4-96.4 96.4c-9.4 9.4-9.4 24.6 0 33.9l22.6 22.6c9.4 9.4 24.6 9.4 33.9 0l136-136c9.4-9.2 9.4-24.4 0-33.8z"/></svg>',
			'icon-slash' 				=> '<svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path transform="rotate(20)" d="M594.53 508.63L6.18 53.9c-6.97-5.42-8.23-15.47-2.81-22.45L23.01 6.18C28.43-.8 38.49-2.06 45.47 3.37L633.82 458.1c6.97 5.42 8.23 15.47 2.81 22.45l-19.64 25.27c-5.42 6.98-15.48 8.23-22.46 2.81z"/></svg>',
		),
	)
) );

//Styling
$wp_customize->add_setting(
	'breadcrumbs_styling_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'breadcrumbs_styling_title',
	array(
		'label'    			=> esc_html__( 'Styling', 'voluto' ),
		'section'  			=> 'voluto_breadcrumbs',
	)
) );

$wp_customize->add_setting( 'breadcrumbs_background',
	array(
		'default' 			=> '#fff',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'voluto_hex_rgba_sanitize'
	)
);
$wp_customize->add_control( new Voluto_Alpha_Color( $wp_customize, 'breadcrumbs_background',
	array(
		'label' 	=> esc_html__( 'Background color', 'voluto' ),
		'section' 	=> 'voluto_breadcrumbs',
	)
) );

$wp_customize->add_setting( 'breadcrumbs_links',
	array(
		'default' 			=> $voluto_colors['color-gray'],
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'voluto_hex_rgba_sanitize'
	)
);
$wp_customize->add_control( new Voluto_Alpha_Color( $wp_customize, 'breadcrumbs_links',
	array(
		'label' 	=> esc_html__( 'Links color', 'voluto' ),
		'section' 	=> 'voluto_breadcrumbs',
	)
) );

$wp_customize->add_setting( 'breadcrumbs_text',
	array(
		'default' 			=> $voluto_colors['color-text'],
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'voluto_hex_rgba_sanitize'
	)
);
$wp_customize->add_control( new Voluto_Alpha_Color( $wp_customize, 'breadcrumbs_text',
	array(
		'label' 	=> esc_html__( 'Text color', 'voluto' ),
		'section' 	=> 'voluto_breadcrumbs',
	)
) );

//Padding
$wp_customize->add_setting( 'breadcrumbs_padding_desktop', array(
	'default'   		=> 15,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'breadcrumbs_padding_tablet', array(
	'default'			=> 15,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'breadcrumbs_padding_mobile', array(
	'default'			=> 15,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'breadcrumbs_padding',
	array(
		'label' => esc_html__( 'Padding', 'voluto' ),
		'section' => 'voluto_breadcrumbs',
		'settings'   => array (
			'breadcrumbs_padding_desktop',
			'breadcrumbs_padding_tablet',
			'breadcrumbs_padding_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 50,
			'step'  => 1,
			'unit'	=> 'px'
		),		
	)
) );