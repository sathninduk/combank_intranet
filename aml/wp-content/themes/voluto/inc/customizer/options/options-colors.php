<?php
/**
 * Colors Customizer options
 *
 * @package Voluto
 */

$wp_customize->add_setting(
	'colors_general_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'colors_general_title',
	array(
		'label'    			=> esc_html__( 'General', 'voluto' ),
		'section'       	=> 'colors',
		'priority' => 0
		)
) ); 

$wp_customize->add_setting(
	'accent_color',
	array(
		'default'           => '#3861fc',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'accent_color',
		array(
			'label'         	=> esc_html__( 'Accent color', 'voluto' ),
			'section'       	=> 'colors',
		)
	)
);

$wp_customize->add_setting(
	'accent_color_dark',
	array(
		'default'           => '#1b3cb4',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'accent_color_dark',
		array(
			'label'         	=> esc_html__( 'Accent color dark', 'voluto' ),
			'section'       	=> 'colors',
		)
	)
);

$wp_customize->add_setting(
	'body_color',
	array(
		'default'           => '#404040',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'body_color',
		array(
			'label'         	=> esc_html__( 'Body text color', 'voluto' ),
			'section'       	=> 'colors',
		)
	)
);
$wp_customize->add_setting(
	'content_link_color',
	array(
		'default'           => '#3861fc',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'content_link_color',
		array(
			'label'         	=> esc_html__( 'Content link color', 'voluto' ),
			'section'       	=> 'colors',
		)
	)
);
$wp_customize->add_setting(
	'content_link_color_hover',
	array(
		'default'           => '#1b3cb4',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'content_link_color_hover',
		array(
			'label'         	=> esc_html__( 'Content link color (hover)', 'voluto' ),
			'section'       	=> 'colors',
		)
	)
);

$wp_customize->add_setting(
	'colors_general_headings',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'colors_general_headings',
	array(
		'label'    			=> esc_html__( 'Headings', 'voluto' ),
		'section'       	=> 'colors',
		)
) );

$wp_customize->add_setting(
	'color_heading1',
	array(
		'default'           => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'color_heading1',
		array(
			'label'         	=> esc_html__( 'Heading 1', 'voluto' ),
			'section'       	=> 'colors',
		)
	)
);

$wp_customize->add_setting(
	'color_heading2',
	array(
		'default'           => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'color_heading2',
		array(
			'label'         	=> esc_html__( 'Heading 2', 'voluto' ),
			'section'       	=> 'colors',
		)
	)
);
$wp_customize->add_setting(
	'color_heading3',
	array(
		'default'           => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'color_heading3',
		array(
			'label'         	=> esc_html__( 'Heading 3', 'voluto' ),
			'section'       	=> 'colors',
		)
	)
);
$wp_customize->add_setting(
	'color_heading4',
	array(
		'default'           => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'color_heading4',
		array(
			'label'         	=> esc_html__( 'Heading 4', 'voluto' ),
			'section'       	=> 'colors',
		)
	)
);
$wp_customize->add_setting(
	'color_heading5',
	array(
		'default'           => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'color_heading5',
		array(
			'label'         	=> esc_html__( 'Heading 5', 'voluto' ),
			'section'       	=> 'colors',
		)
	)
);
$wp_customize->add_setting(
	'color_heading6',
	array(
		'default'           => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'color_heading6',
		array(
			'label'         	=> esc_html__( 'Heading 6', 'voluto' ),
			'section'       	=> 'colors',
		)
	)
);