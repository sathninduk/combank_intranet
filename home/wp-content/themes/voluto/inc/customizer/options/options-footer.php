<?php
/**
 * Footer Customizer options
 *
 * @package Voluto
 */

$wp_customize->add_panel(
	'voluto_footer_panel',
	array(
		'title'         => esc_html__( 'Footer', 'voluto' ),
		'priority'      => 29,
	)
); 

/**
 * Before footer
 */
$wp_customize->add_section(
	'voluto_before_footer',
	array(
		'title'         => esc_html__( 'Before footer', 'voluto' ),
		'panel'			=> 'voluto_footer_panel'
	)
);

$wp_customize->add_setting(
	'before_footer_type',
	array(
		'default'           => 'before_footer_cta',
		'sanitize_callback' => 'voluto_sanitize_select',
	)
);
$wp_customize->add_control(
	'before_footer_type',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Content type', 'voluto' ),
		'section'   		=> 'voluto_before_footer',
		'choices'   		=> array(
			'none'						=> esc_html__( 'Nothing', 'voluto' ),
			'before_footer_cta'			=> esc_html__( 'Call to action', 'voluto' ),
			'before_footer_social'		=> esc_html__( 'Social profile', 'voluto' ),
			'before_footer_html'		=> esc_html__( 'HTML', 'voluto' ),
			'before_footer_shortcode'	=> esc_html__( 'Shortcode', 'voluto' ),
		),
	)
);

$wp_customize->add_setting(
	'before_footer_cta_t_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'before_footer_cta_t_title',
	array(
		'label'    => esc_html__( 'Call to Action', 'voluto' ),
		'section'  => 'voluto_before_footer',
		'active_callback'   => 'voluto_before_footer_cta_callback'
	)
) );

$wp_customize->add_setting(
	'before_footer_cta_title',
	array(
		'sanitize_callback' => 'voluto_sanitize_text',
		'default'           => esc_html__( 'Have something on your mind?', 'voluto' ),
	)       
);
$wp_customize->add_control( 'before_footer_cta_title', array(
	'type'        => 'text',
	'section'     => 'voluto_before_footer',
	'label'       => esc_html__( 'CTA title', 'voluto' ),
	'active_callback'   => 'voluto_before_footer_cta_callback'
) );

$wp_customize->add_setting(
	'before_footer_cta_text',
	array(
		'sanitize_callback' => 'voluto_sanitize_text',
		'default'           => esc_html__( 'Say hello', 'voluto' ),
	)       
);
$wp_customize->add_control( 'before_footer_cta_text', array(
	'type'        => 'text',
	'section'     => 'voluto_before_footer',
	'label'       => esc_html__( 'CTA button text', 'voluto' ),
	'active_callback'   => 'voluto_before_footer_cta_callback'
) );

$wp_customize->add_setting(
	'before_footer_cta_link',
	array(
		'sanitize_callback' => 'esc_url_raw',
		'default'           => '#',
	)       
);
$wp_customize->add_control( 'before_footer_cta_link', array(
	'type'        => 'text',
	'section'     => 'voluto_before_footer',
	'label'       => esc_html__( 'CTA button link', 'voluto' ),
	'active_callback'   => 'voluto_before_footer_cta_callback'
) );

//Before footer social
$wp_customize->add_setting(
	'before_footer_social_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'before_footer_social_title',
	array(
		'label'    => esc_html__( 'Social profile', 'voluto' ),
		'section'  => 'voluto_before_footer',
		'active_callback'   => 'voluto_before_footer_social_callback'
	)
) );
$wp_customize->add_setting( 'before_footer_social',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'voluto_sanitize_urls'
	)
);
$wp_customize->add_control( new Voluto_Repeater_Control( $wp_customize, 'before_footer_social',
	array(
		'label' 		=> esc_html__( 'Social profile', 'voluto' ),
		'description' 	=> esc_html__( 'Add links to your social profiles here', 'voluto' ),
		'section' 		=> 'voluto_before_footer',
		'button_labels' => array(
			'add' => esc_html__( 'Add new link', 'voluto' ),
		),
		'active_callback'   => 'voluto_before_footer_social_callback'
	)
) );

//Before footer HTML
$wp_customize->add_setting(
	'before_footer_html_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'before_footer_html_title',
	array(
		'label'    => esc_html__( 'HTML', 'voluto' ),
		'section'  => 'voluto_before_footer',
		'active_callback'   => 'voluto_before_footer_html_callback'
	)
) );
$wp_customize->add_setting(
	'before_footer_html',
	array(
		'sanitize_callback' => 'voluto_sanitize_text',
		'default'           => ''
		)       
);
$wp_customize->add_control( 'before_footer_html', array(
	'label'       => esc_html__( 'HTML', 'voluto' ),
	'type'        => 'textarea',
	'section'     => 'voluto_before_footer',
	'active_callback'   => 'voluto_before_footer_html_callback'
) );

//Before footer shortcode
$wp_customize->add_setting(
	'before_footer_shortcode_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'before_footer_shortcode_title',
	array(
		'label'    => esc_html__( 'Shortcode', 'voluto' ),
		'section'  => 'voluto_before_footer',
		'active_callback'   => 'voluto_before_footer_shortcode_callback'
	)
) );
$wp_customize->add_setting(
	'before_footer_shortcode',
	array(
		'sanitize_callback' => 'voluto_sanitize_text',
		'default'           => ''
		)       
);
$wp_customize->add_control( 'before_footer_shortcode', array(
	'label'       => esc_html__( 'Add your shortcode', 'voluto' ),
	'type'        => 'text',
	'section'     => 'voluto_before_footer',
	'active_callback'   => 'voluto_before_footer_shortcode_callback'
) );

$wp_customize->add_setting(
	'before_footer_styling_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'before_footer_styling_title',
	array(
		'label'             => esc_html__( 'Styling', 'voluto' ),
		'section'           => 'voluto_before_footer',
        'active_callback'   => 'voluto_before_footer_active_callback'
	)
) );
$wp_customize->add_setting(
	'before_footer_background',
	array(
		'default'           => '#181a24',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'before_footer_background',
		array(
			'label'         => esc_html__( 'Background color', 'voluto' ),
			'section'       => 'voluto_before_footer',
            'active_callback'   => 'voluto_before_footer_active_callback'
		)
	)
);
$wp_customize->add_setting(
	'before_footer_color',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'before_footer_color',
		array(
			'label'         => esc_html__( 'Color', 'voluto' ),
			'section'       => 'voluto_before_footer',
            'active_callback'   => 'voluto_before_footer_active_callback'
		)
	)
);
$wp_customize->add_setting( 'before_footer_border_color',
	array(
		'default' 			=> 'rgba(255,255,255,0.15)',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'voluto_hex_rgba_sanitize'
	)
);
$wp_customize->add_control( new Voluto_Alpha_Color( $wp_customize, 'before_footer_border_color',
	array(
		'label' 	=> esc_html__( 'Border color', 'voluto' ),
		'section' 	=> 'voluto_before_footer',
        'active_callback'   => 'voluto_before_footer_active_callback'
	)
) );
$wp_customize->add_setting( 'before_footer_padding_desktop', array(
	'default'   => 90,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'before_footer_padding_tablet', array(
	'default'	=> 60,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'before_footer_padding_mobile', array(
	'default'	=> 30,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'before_footer_padding',
	array(
		'label' => esc_html__( 'Vertical spacing', 'voluto' ),
		'section' => 'voluto_before_footer',
		'settings'   => array (
			'before_footer_padding_desktop',
			'before_footer_padding_tablet',
			'before_footer_padding_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
			'unit'	=> 'px'
		),		
        'active_callback'   => 'voluto_before_footer_active_callback'
	)
) );

/**
 * Footer widgets
 */
$wp_customize->add_section(
	'voluto_footer_widgets',
	array(
		'title'         => esc_html__( 'Footer widgets', 'voluto' ),
		'panel'			=> 'voluto_footer_panel'
	)
);

$wp_customize->add_setting(
	'footer_widgets_layout',
	array(
		'default'           => 'columns3',
		'sanitize_callback' => 'voluto_sanitize_select',
	)
);
$wp_customize->add_control(
	'footer_widgets_layout',
	array(
		'type'      		=> 'select',
		'label'     		=> esc_html__( 'Footer widgets layout', 'voluto' ),
		'section'   		=> 'voluto_footer_widgets',
		'choices'   		=> array(
			'columns1'		=> esc_html__( '1 column', 'voluto' ),
			'columns2'		=> esc_html__( '2 columns', 'voluto' ),
			'columns3'		=> esc_html__( '3 columns', 'voluto' ),
			'columns4'		=> esc_html__( '4 columns', 'voluto' ),
		),
	)
);

$wp_customize->add_setting( 'footer_widgets_width',
	array(
		'default' 			=> 'container',
		'sanitize_callback' => 'voluto_sanitize_text'
	)
);
$wp_customize->add_control( new Voluto_Radio_Buttons( $wp_customize, 'footer_widgets_width',
	array(
		'label'   => esc_html__( 'Section width', 'voluto' ),
		'section' => 'voluto_footer_widgets',
		'columns' => 2,
		'choices' => array(
			'container' 		=> esc_html__( 'Contain', 'voluto' ),
			'container-fluid' 	=> esc_html__( 'Full', 'voluto' ),
		),
	)
) );

$wp_customize->add_setting(
	'footer_widgets_styling_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'footer_widgets_styling_title',
	array(
		'label'    => esc_html__( 'Styling', 'voluto' ),
		'section'  => 'voluto_footer_widgets',
	)
) );


$wp_customize->add_setting(
	'footer_widgets_background',
	array(
		'default'           => '#181a24',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_widgets_background',
		array(
			'label'         => esc_html__( 'Background color', 'voluto' ),
			'section'       => 'voluto_footer_widgets',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_title_color',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_widgets_title_color',
		array(
			'label'         => esc_html__( 'Widget titles color', 'voluto' ),
			'section'       => 'voluto_footer_widgets',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_color',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_widgets_color',
		array(
			'label'         => esc_html__( 'Content color', 'voluto' ),
			'section'       => 'voluto_footer_widgets',
		)
	)
);

$wp_customize->add_setting(
	'footer_widgets_links_color',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_widgets_links_color',
		array(
			'label'         => esc_html__( 'Links color', 'voluto' ),
			'section'       => 'voluto_footer_widgets',
		)
	)
);

$wp_customize->add_setting( 'footer_widgets_border_color',
	array(
		'default' 			=> 'rgba(255,255,255,0.15)',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'voluto_hex_rgba_sanitize'
	)
);
$wp_customize->add_control( new Voluto_Alpha_Color( $wp_customize, 'footer_widgets_border_color',
	array(
		'label' 	=> esc_html__( 'Border color', 'voluto' ),
		'section' 	=> 'voluto_footer_widgets',
	)
) );

$wp_customize->add_setting( 'footer_widgets_padding_desktop', array(
	'default'   => 90,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'footer_widgets_padding_tablet', array(
	'default'	=> 60,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'footer_widgets_padding_mobile', array(
	'default'	=> 30,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'footer_widgets_padding',
	array(
		'label' => esc_html__( 'Vertical spacing', 'voluto' ),
		'section' => 'voluto_footer_widgets',
		'settings'   => array (
			'footer_widgets_padding_desktop',
			'footer_widgets_padding_tablet',
			'footer_widgets_padding_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
			'unit'	=> 'px'
		),		
	)
) );

/**
 * Footer bar
 */
$wp_customize->add_section(
	'voluto_footer_bar',
	array(
		'title'         => esc_html__( 'Footer bar', 'voluto' ),
		'panel'			=> 'voluto_footer_panel'
	)
);
$wp_customize->add_setting(
	'footer_bar_settings_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'footer_bar_settings_title',
	array(
		'label'    => esc_html__( 'Settings', 'voluto' ),
		'section'  => 'voluto_footer_bar',
	)
) );
$wp_customize->add_setting(
	'footer_bar_layout',
	array(
		'default'           => 'separate',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Voluto_Radio_Images(
		$wp_customize,
		'footer_bar_layout',
		array(
			'label'    		=> esc_html__( 'Layout', 'voluto' ),
			'section'  => 'voluto_footer_bar',
			'columns'	=> 2,
			'choices'  => array(
				'inline' => array(
					'label' => esc_html__( 'Inline', 'voluto' ),
					'url'   => '%s/assets/img/fbar1.svg'
				),
				'separate' => array(
					'label' 	=> esc_html__( 'Separate', 'voluto' ),
					'url'   	=> '%s/assets/img/fbar2.svg'
				),			
			),
		)
	)
); 

$wp_customize->add_setting( 'footer_bar_width',
	array(
		'default' 			=> 'container',
		'sanitize_callback' => 'voluto_sanitize_text'
	)
);
$wp_customize->add_control( new Voluto_Radio_Buttons( $wp_customize, 'footer_bar_width',
	array(
		'label'   => esc_html__( 'Section width', 'voluto' ),
		'section' => 'voluto_footer_bar',
		'columns' => 2,
		'choices' => array(
			'container' 		=> esc_html__( 'Contain', 'voluto' ),
			'container-fluid' 	=> esc_html__( 'Full', 'voluto' ),
		),
	)
) );

$wp_customize->add_setting(
	'footer_credits',
	array(
		'sanitize_callback' => 'voluto_sanitize_text',
		'default'           => sprintf( esc_html__( 'Powered by the %1$1s WordPress theme', 'voluto' ), '<a rel="nofollow" href="https://elfwp.com/themes/voluto">Voluto</a>' ), // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
		)       
);
$wp_customize->add_control( 'footer_credits', array(
	'label'       => esc_html__( 'Footer credits', 'voluto' ),
	'type'        => 'textarea',
	'section'     => 'voluto_footer_bar',
) );

//Footer social
$wp_customize->add_setting( 'footer_social',
	array(
		'default' 			=> '',
		'sanitize_callback' => 'voluto_sanitize_urls'
	)
);
$wp_customize->add_control( new Voluto_Repeater_Control( $wp_customize, 'footer_social',
	array(
		'label' 		=> esc_html__( 'Social profile', 'voluto' ),
		'description' 	=> esc_html__( 'Add links to your social profiles here', 'voluto' ),
		'section' 		=> 'voluto_footer_bar',
		'button_labels' => array(
			'add' => esc_html__( 'Add new link', 'voluto' ),
		),
	)
) );

$wp_customize->add_setting(
	'footer_bar_styling_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'footer_bar_styling_title',
	array(
		'label'    => esc_html__( 'Styling', 'voluto' ),
		'section'  => 'voluto_footer_bar',
	)
) );

$wp_customize->add_setting(
	'footer_bar_bg_color',
	array(
		'default'           => '#181a24',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_bar_bg_color',
		array(
			'label'         => esc_html__( 'Background color', 'voluto' ),
			'section'       => 'voluto_footer_bar',
			'settings'      => 'footer_bar_bg_color',
		)
	)
);

$wp_customize->add_setting(
	'footer_bar_color',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'footer_bar_color',
		array(
			'label'         => esc_html__( 'Color', 'voluto' ),
			'section'       => 'voluto_footer_bar',
			'settings'      => 'footer_bar_color',
		)
	)
);

$wp_customize->add_setting( 'footer_bar_padding_desktop', array(
	'default'   => 30,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'footer_bar_padding_tablet', array(
	'default'	=> 30,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'footer_bar_padding_mobile', array(
	'default'	=> 30,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'footer_bar_padding',
	array(
		'label' => esc_html__( 'Top spacing', 'voluto' ),
		'section' => 'voluto_footer_bar',
		'settings'   => array (
			'footer_bar_padding_desktop',
			'footer_bar_padding_tablet',
			'footer_bar_padding_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
			'unit'	=> 'px'
		),		
	)
) );

$wp_customize->add_setting( 'footer_bar_bottom_padding_desktop', array(
	'default'   => 60,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'footer_bar_bottom_padding_tablet', array(
	'default'	=> 30,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'footer_bar_bottom_padding_mobile', array(
	'default'	=> 30,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'footer_bar_bottom_padding',
	array(
		'label' => esc_html__( 'Bottom spacing', 'voluto' ),
		'section' => 'voluto_footer_bar',
		'settings'   => array (
			'footer_bar_bottom_padding_desktop',
			'footer_bar_bottom_padding_tablet',
			'footer_bar_bottom_padding_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
			'unit'	=> 'px'
		),		
	)
) );