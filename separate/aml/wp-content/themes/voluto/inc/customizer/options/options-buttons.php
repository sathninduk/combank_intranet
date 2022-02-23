<?php
/**
 * Buttons Customizer options
 *
 * @package Voluto
 */
/**
 * Buttons
 */
$wp_customize->add_section(
	'voluto_buttons',
	array(
		'title'         => esc_html__( 'Buttons', 'voluto' ),
		'panel'			=> 'voluto_general_panel'
	)
);
$wp_customize->add_setting(
	'global_button_background',
	array(
		'default'           => '#3861fc',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'global_button_background',
		array(
			'label'         	=> esc_html__( 'Button background color', 'voluto' ),
			'section'       	=> 'voluto_buttons',
			'settings'      	=> 'global_button_background',
		)
	)
);

$wp_customize->add_setting(
	'global_button_color',
	array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'global_button_color',
		array(
			'label'         	=> esc_html__( 'Button color', 'voluto' ),
			'section'       	=> 'voluto_buttons',
			'settings'      	=> 'global_button_color',
		)
	)
);

$wp_customize->add_setting(
	'global_button_background_hover',
	array(
		'default'           => '#1b3cb4',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'global_button_background_hover',
		array(
			'label'         	=> esc_html__( 'Button background color (hover)', 'voluto' ),
			'section'       	=> 'voluto_buttons',
			'settings'      	=> 'global_button_background_hover',
		)
	)
);

$wp_customize->add_setting(
	'global_button_color_hover',
	array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'global_button_color_hover',
		array(
			'label'         	=> esc_html__( 'Button color (hover)', 'voluto' ),
			'section'       	=> 'voluto_buttons',
			'settings'      	=> 'global_button_color_hover',
		)
	)
);

$wp_customize->add_setting( 'global_button_padding_tb_desktop', array(
	'default'   		=> 11,
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'global_button_padding_tb_tablet', array(
	'default'			=> 11,
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'global_button_padding_tb_mobile', array(
	'default'			=> 11,
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'global_button_padding_tb',
	array(
		'label' => esc_html__( 'Vertical padding', 'voluto' ),
		'section' => 'voluto_buttons',
		'settings'   => array (
			'global_button_padding_tb_desktop',
			'global_button_padding_tb_tablet',
			'global_button_padding_tb_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 50,
			'step'  => 1,
			'unit'	=> 'px'
		),		
	)
) );

$wp_customize->add_setting( 'global_button_padding_lr_desktop', array(
	'default'   		=> 24,
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'global_button_padding_lr_tablet', array(
	'default'			=> 24,
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'global_button_padding_lr_mobile', array(
	'default'			=> 24,
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'global_button_padding_lr',
	array(
		'label' => esc_html__( 'Horizontal padding', 'voluto' ),
		'section' => 'voluto_buttons',
		'settings'   => array (
			'global_button_padding_lr_desktop',
			'global_button_padding_lr_tablet',
			'global_button_padding_lr_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 50,
			'step'  => 1,
			'unit'	=> 'px'
		),		
	)
) );

$wp_customize->add_setting( 'global_button_border_radius',
	array(
		'default' 			=> 5,
		'sanitize_callback' => 'voluto_sanitize_range'
	)
);
$wp_customize->add_control( new Voluto_Slider_Control( $wp_customize, 'global_button_border_radius',
	array(
		'label' => esc_html__( 'Border radius', 'voluto' ),
		'section' 			=> 'voluto_buttons',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
			'unit' => 'px'
		),
	)
) );

$wp_customize->add_setting( 'global_button_font_size_desktop', array(
	'default'   		=> 16,
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'global_button_font_size_tablet', array(
	'default'			=> 16,
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'global_button_font_size_mobile', array(
	'default'			=> 16,
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'global_button_font_size',
	array(
		'label' => esc_html__( 'Font size', 'voluto' ),
		'section' => 'voluto_buttons',
		'settings'   => array (
			'global_button_font_size_desktop',
			'global_button_font_size_tablet',
			'global_button_font_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 50,
			'step'  => 1,
			'unit'	=> 'px'
		),		
	)
) );

$wp_customize->add_setting( 'global_button_transform',
	array(
		'default' 			=> 'none',
		'sanitize_callback' => 'voluto_sanitize_text',
	)
);
$wp_customize->add_control( new Voluto_Radio_Buttons( $wp_customize, 'global_button_transform',
	array(
		'label'   => esc_html__( 'Text transform', 'voluto' ),
		'section' => 'voluto_buttons',
		'columns' => 4,
		'choices' => array(
			'none' 			=> esc_html__( '-', 'voluto' ),
			'lowercase' 	=> esc_html__( 'aa', 'voluto' ),
			'capitalize' 	=> esc_html__( 'Aa', 'voluto' ),
			'uppercase' 	=> esc_html__( 'AA', 'voluto' ),
		),
	)
) );

//Letter spacing
$wp_customize->add_setting( 'global_button_letter_spacing',
	array(
		'default' 			=> 0,
		'sanitize_callback' => 'voluto_sanitize_range'
	)
);
$wp_customize->add_control( new Voluto_Slider_Control( $wp_customize, 'global_button_letter_spacing',
	array(
		'label' => esc_html__( 'Letter spacing', 'voluto' ),
		'section' => 'voluto_buttons',
		'input_attrs' => array(
			'min' => 0,
			'max' => 5,
			'step' => 0.5,
			'unit' => 'px'
		),
	)
) );