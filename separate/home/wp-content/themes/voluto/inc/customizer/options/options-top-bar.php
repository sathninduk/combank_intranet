<?php
/**
 * Top bar Customizer options
 *
 * @package Voluto
 */

/**
 * Top
 */
$wp_customize->add_section(
	'voluto_header_top_bar',
	array(
		'title'         => esc_html__( 'Top bar', 'voluto' ),
		'priority'      => 11,
		'panel'			=> 'voluto_header_panel'
	)
);

$wp_customize->add_setting(
	'top_bar_tabs',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Tabs( $wp_customize, 'top_bar_tabs',
	array(
		'linked'		=> 'top_bar_tabs',
		'label'    		=> esc_html__( 'Settings', 'voluto' ),
		'label2'    	=> esc_html__( 'Styling', 'voluto' ),
		'connected'		=> 'voluto_header_top_bar',
		'connected2'	=> 'voluto_header_top_bar_styling',
		'section'  		=> 'voluto_header_top_bar',
	)
) );


$wp_customize->add_setting(
	'enable_top_bar',
	array(
		'default'           => 0,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'enable_top_bar',
		array(
			'label'         	=> esc_html__( 'Enable top bar', 'voluto' ),
			'section'       	=> 'voluto_header_top_bar',
			'settings'      	=> 'enable_top_bar',
		)
	)
);

$wp_customize->add_setting( 'topbar_width',
	array(
		'default' 			=> 'container',
		'sanitize_callback' => 'voluto_sanitize_text'
	)
);
$wp_customize->add_control( new Voluto_Radio_Buttons( $wp_customize, 'topbar_width',
	array(
		'label'   => esc_html__( 'Section width', 'voluto' ),
		'section' => 'voluto_header_top_bar',
		'columns' => 2,
		'choices' => array(
			'container' 		=> esc_html__( 'Contain', 'voluto' ),
			'container-fluid' 	=> esc_html__( 'Full', 'voluto' ),
		),
		'active_callback' 	=> 'voluto_top_bar_active_callback',
	)
) );

$voluto_tb_elements = array(
	'none' 			=> esc_html__( 'None', 'voluto' ),
	'social' 		=> esc_html__( 'Social profile', 'voluto' ),
	'navigation' 	=> esc_html__( 'Secondary menu', 'voluto' ),
	'text' 			=> esc_html__( 'Text / HTML', 'voluto' ),
	'contact' 		=> esc_html__( 'Contact', 'voluto' ),
);

/**
 * Left
 */
$wp_customize->add_setting(
	'top_bar_left_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'top_bar_left_title',
	array(
		'label'    			=> esc_html__( 'Left side', 'voluto' ),
		'section'  			=> 'voluto_header_top_bar',
		'active_callback' 	=> 'voluto_top_bar_active_callback',
		'priority'      	=> 20
	)
) );

$wp_customize->add_setting(
	'top_bar_left',
	array(
		'default'           => 'contact',
		'sanitize_callback' => 'voluto_sanitize_select',
	)
);
$wp_customize->add_control(
	'top_bar_left',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Select element', 'voluto' ),
		'section'   		=> 'voluto_header_top_bar',
		'choices'   		=> $voluto_tb_elements,
		'active_callback' 	=> 'voluto_top_bar_active_callback',
		'priority'      	=> 20
	)
);

$wp_customize->add_setting(
	'top_bar_right_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'top_bar_right_title',
	array(
		'label'    			=> esc_html__( 'Right side', 'voluto' ),
		'section'  			=> 'voluto_header_top_bar',
		'active_callback' 	=> 'voluto_top_bar_active_callback',
		'priority'      	=> 30
	)
) );

$wp_customize->add_setting(
	'top_bar_right',
	array(
		'default'           => 'text',
		'sanitize_callback' => 'voluto_sanitize_select',
	)
);
$wp_customize->add_control(
	'top_bar_right',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Select element', 'voluto' ),
		'section'   		=> 'voluto_header_top_bar',
		'choices'   		=> $voluto_tb_elements,
		'active_callback' 	=> 'voluto_top_bar_active_callback',
		'priority'      	=> 30
	)
);

/**
 * Elements
 */
//Header social
$wp_customize->add_setting( 'top_bar_social',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'voluto_sanitize_urls'
	)
);
$wp_customize->add_control( new Voluto_Repeater_Control( $wp_customize, 'top_bar_social',
	array(
		'label' 		=> esc_html__( 'Social profile', 'voluto' ),
		'description' 	=> esc_html__( 'Add links to your social profiles here', 'voluto' ),
		'section' 		=> 'voluto_header_top_bar',
		'button_labels' => array(
			'add' => esc_html__( 'Add new link', 'voluto' ),
		),
		'active_callback' 	=> 'voluto_social_top_bar_callback'
	)
) );


//Header custom text
$wp_customize->add_setting(
	'top_bar_text',
	array(
		'default'           => esc_html__( 'Your custom text', 'voluto' ),
		'sanitize_callback' => 'voluto_sanitize_text',
	)
);
$wp_customize->add_control(
	'top_bar_text',
	array(
		'label' 			=> esc_html__( 'Custom text', 'voluto' ),
		'section' 			=> 'voluto_header_top_bar',
		'type' 				=> 'text',
		'active_callback' 	=> 'voluto_text_top_bar_callback'
	)
);

//Header contact
$wp_customize->add_setting(
	'top_bar_contact_phone',
	array(
		'default'           => esc_html__( '+999.999.999', 'voluto' ),
		'sanitize_callback' => 'voluto_sanitize_text',
	)
);
$wp_customize->add_control(
	'top_bar_contact_phone',
	array(
		'label' 			=> esc_html__( 'Phone number', 'voluto' ),
		'section' 			=> 'voluto_header_top_bar',
		'type' 				=> 'text',
		'active_callback' 	=> 'voluto_contact_top_bar_callback'
	)
);

$wp_customize->add_setting(
	'top_bar_contact_email',
	array(
		'default'           => esc_html__( 'office@example.org', 'voluto' ),
		'sanitize_callback' => 'voluto_sanitize_text',
	)
);
$wp_customize->add_control(
	'top_bar_contact_email',
	array(
		'label' 			=> esc_html__( 'Email address', 'voluto' ),
		'section' 			=> 'voluto_header_top_bar',
		'type' 				=> 'text',
		'active_callback' 	=> 'voluto_contact_top_bar_callback'
	)
);

$wp_customize->add_setting( 'top_bar_navigation',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'esc_attr'
	)
);

$wp_customize->add_control( new Voluto_Info( $wp_customize, 'top_bar_navigation',
		array(
			'label' 			=> '<a href="javascript:wp.customize.panel( \'nav_menus\' ).focus();">' . esc_html__( 'Click here to configure your menu', 'voluto' ),
			'section' 			=> 'voluto_header_top_bar',
			'attr'				=> 1,
			'active_callback' 	=> 'voluto_nav_top_bar_callback'
		)
	)
);


/**
 * Styling
 */
$wp_customize->add_section(
	'voluto_header_top_bar_styling',
	array(
		'title'         => esc_html__( 'Top bar styling', 'voluto' ),
		'priority'      => 11,
		'panel'			=> 'voluto_header_panel'
	)
);

$wp_customize->add_setting(
	'top_bar_tabs_styling',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Tabs( $wp_customize, 'top_bar_tabs_styling',
	array(
		'linked'			=> 'top_bar_tabs',
		'label'    		=> esc_html__( 'Settings', 'voluto' ),
		'label2'    	=> esc_html__( 'Styling', 'voluto' ),
		'connected'		=> 'voluto_header_top_bar',
		'connected2'	=> 'voluto_header_top_bar_styling',
		'section'  		=> 'voluto_header_top_bar_styling',
	)
) );

$wp_customize->add_setting(
	'top_bar_background_color',
	array(
		'default'           => '#181a24',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'top_bar_background_color',
		array(
			'label'    => esc_html__( 'Background color', 'voluto' ),
			'section'  => 'voluto_header_top_bar_styling',
		)
	)
);

$wp_customize->add_setting(
	'top_bar_color',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'top_bar_color',
		array(
			'label'    => esc_html__( 'Color', 'voluto' ),
			'section'  => 'voluto_header_top_bar_styling',
		)
	)
);

$wp_customize->add_setting( 'topbar_padding_desktop', array(
	'default'   => 8,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'topbar_padding_tablet', array(
	'default'	=> 8,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'topbar_padding_mobile', array(
	'default'	=> 8,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'topbar_padding',
	array(
		'label' => esc_html__( 'Vertical spacing', 'voluto' ),
		'section' => 'voluto_header_top_bar_styling',
		'settings'   => array (
			'topbar_padding_desktop',
			'topbar_padding_tablet',
			'topbar_padding_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
			'unit'	=> 'px'
		),		
	)
) );