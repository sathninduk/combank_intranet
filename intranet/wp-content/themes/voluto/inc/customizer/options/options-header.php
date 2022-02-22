<?php
/**
 * Header Customizer options
 *
 * @package Voluto
 */

$wp_customize->register_section_type( Voluto_Upsell::class );

$wp_customize->add_section(
	new Voluto_Upsell( $wp_customize, 'voluto_pro', [
		'title'       => esc_html__( 'Voluto Pro', 'voluto' ),
		'button_text' => esc_html__( 'See Pro Features', 'voluto' ),
		'button_url'  => 'https://elfwp.com/themes/voluto',
		'priority'      => 0,
	] )
);

$wp_customize->add_panel(
	'voluto_header_panel',
	array(
		'title'         => esc_html__( 'Header', 'voluto' ),
		'priority'      => 11,
	)
); 

//Logo size
$wp_customize->add_setting( 'logo_size_desktop', array(
	'default'   		=> 150,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'logo_size_tablet', array(
	'default'			=> 120,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'logo_size_mobile', array(
	'default'			=> 100,
	'transport'			=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'logo_size',
	array(
		'label' => esc_html__( 'Logo max. width', 'voluto' ),
		'section' => 'title_tagline',
		'settings'   => array (
			'logo_size_desktop',
			'logo_size_tablet',
			'logo_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
			'unit'	=> 'px'
		),		
		'priority' => 9
	)
) );

/**
 * Main header 
 */
$wp_customize->add_section(
	'voluto_main_header',
	array(
		'title'         => esc_html__( 'Main header', 'voluto' ),
		'priority'      => 11,
		'panel'			=> 'voluto_header_panel'
	)
);


$wp_customize->add_setting(
	'main_header_tabs',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Tabs( $wp_customize, 'main_header_tabs',
	array(
		'linked'			=> 'main_header_tabs',
		'label'    		=> esc_html__( 'Settings', 'voluto' ),
		'label2'    	=> esc_html__( 'Styling', 'voluto' ),
		'connected'		=> 'voluto_main_header',
		'connected2'	=> 'voluto_main_header_styling',
		'section'  		=> 'voluto_main_header',
	)
) );


//Layout
$wp_customize->add_setting(
	'main_header_layout',
	array(
		'default'           => 'adspace',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Voluto_Radio_Images(
		$wp_customize,
		'main_header_layout',
		array(
			'label'    => esc_html__( 'Layout', 'voluto' ),
			'section'  => 'voluto_main_header',
			'columns' => 1,
			'choices'  => array(
				'inline' => array(
					'label' => esc_html__( 'Inline', 'voluto' ),
					'url'   => '%s/assets/img/h1.svg'
				),
				'centered' => array(
					'label' => esc_html__( 'Centered', 'voluto' ),
					'url'   => '%s/assets/img/h2.svg'
				),
				'adspace' => array(
					'label' => esc_html__( 'With ad space', 'voluto' ),
					'url'   => '%s/assets/img/h3.svg'
				),				
			),
			'priority' 			=> 10,
		)
	)
); 

$wp_customize->add_setting( 'main_header_width',
	array(
		'default' 			=> 'container',
		'sanitize_callback' => 'voluto_sanitize_text'
	)
);
$wp_customize->add_control( new Voluto_Radio_Buttons( $wp_customize, 'main_header_width',
	array(
		'label'   => esc_html__( 'Section width', 'voluto' ),
		'section' => 'voluto_main_header',
		'columns' => 2,
		'choices' => array(
			'container' 		=> esc_html__( 'Contain', 'voluto' ),
			'container-fluid' 	=> esc_html__( 'Full', 'voluto' ),
		),
	)
) );

$wp_customize->add_setting(
	'main_header_settings_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'main_header_settings_title',
	array(
		'label'    			=> esc_html__( 'Settings', 'voluto' ),
		'section'  			=> 'voluto_main_header',
	)
) );

$wp_customize->add_setting(
	'enable_header_sticky',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'enable_header_sticky',
		array(
			'label'         	=> esc_html__( 'Enable sticky header', 'voluto' ),
			'section'       	=> 'voluto_main_header',
		)
	)
);



$wp_customize->add_setting(
	'main_header_search_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'main_header_search_title',
	array(
		'label'    			=> esc_html__( 'Search', 'voluto' ),
		'section'  			=> 'voluto_main_header',
	)
) );


$wp_customize->add_setting(
	'enable_header_search',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'enable_header_search',
		array(
			'label'         	=> esc_html__( 'Enable search', 'voluto' ),
			'section'       	=> 'voluto_main_header',
			'settings'      	=> 'enable_header_search',
		)
	)
);


$wp_customize->add_setting(
	'main_header_woocommerce_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'main_header_woocommerce_title',
	array(
		'label'    			=> esc_html__( 'WooCommerce icons', 'voluto' ),
		'section'  			=> 'voluto_main_header',
	)
) );

$wp_customize->add_setting(
	'enable_header_woocommerce',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'enable_header_woocommerce',
		array(
			'label'         	=> esc_html__( 'Enable WooCommerce icons', 'voluto' ),
			'section'       	=> 'voluto_main_header',
			'settings'      	=> 'enable_header_woocommerce',
		)
	)
);

$wp_customize->add_setting(
	'main_header_button_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'main_header_button_title',
	array(
		'label'    			=> esc_html__( 'Button', 'voluto' ),
		'section'  			=> 'voluto_main_header',
	)
) );
$wp_customize->add_setting(
	'enable_header_button',
	array(
		'default'           => 0,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'enable_header_button',
		array(
			'label'         	=> esc_html__( 'Enable button', 'voluto' ),
			'section'       	=> 'voluto_main_header',
			'settings'      	=> 'enable_header_button',
		)
	)
);

$wp_customize->add_setting(
	'header_button_text',
	array(
		'default'           => esc_html__( 'Click here', 'voluto' ),
		'sanitize_callback' => 'voluto_sanitize_text',
	)
);
$wp_customize->add_control(
	'header_button_text',
	array(
		'label' 			=> esc_html__( 'Button text', 'voluto' ),
		'section' 			=> 'voluto_main_header',
		'type' 				=> 'text',
		'active_callback' 	=> 'voluto_header_button_active_callback'
	)
);

$wp_customize->add_setting(
	'header_button_url',
	array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	'header_button_url',
	array(
		'label' 			=> esc_html__( 'Button link', 'voluto' ),
		'section' 			=> 'voluto_main_header',
		'type' 				=> 'text',
		'active_callback' 	=> 'voluto_header_button_active_callback'
	)
);


$wp_customize->add_setting(
	'main_header_ad_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'main_header_ad_title',
	array(
		'label'    			=> esc_html__( 'Ad', 'voluto' ),
		'section'  			=> 'voluto_main_header',
		'active_callback' 	=> 'voluto_header_ad_layout_callback'
	)
) );

$wp_customize->add_setting(
	'header_ad_image_src',
	array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'header_ad_image_src',
		array(
		   'label'          => esc_html__( 'Upload banner image', 'voluto' ),
		   'type'           => 'image',
		   'section'        => 'voluto_main_header',
		   'active_callback' 	=> 'voluto_header_ad_layout_callback'
		)
	)
);

$wp_customize->add_setting(
	'header_ad_link',
	array(
		'default'           => '',
		'sanitize_callback' => 'voluto_sanitize_text',
	)
);
$wp_customize->add_control(
	'header_ad_link',
	array(
		'label' 			=> esc_html__( 'Banner target link', 'voluto' ),
		'section' 			=> 'voluto_main_header',
		'type' 				=> 'text',
		'active_callback' 	=> 'voluto_header_ad_layout_callback'
	)
);

$wp_customize->add_setting(
	'header_ad_image_alt',
	array(
		'default'           => '',
		'sanitize_callback' => 'voluto_sanitize_text',
	)
);
$wp_customize->add_control(
	'header_ad_image_alt',
	array(
		'label' 			=> esc_html__( 'Banner image alt text', 'voluto' ),
		'section' 			=> 'voluto_main_header',
		'type' 				=> 'text',
		'active_callback' 	=> 'voluto_header_ad_layout_callback'
	)
);


/**
 * Styling
 */
$wp_customize->add_section(
	'voluto_main_header_styling',
	array(
		'title'         => esc_html__( 'Main header styling', 'voluto' ),
		'priority'      => 11,
		'panel'			=> 'voluto_header_panel'
	)
);
$wp_customize->add_setting(
	'main_header_tabs_styling',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Tabs( $wp_customize, 'main_header_tabs_styling',
	array(
		'linked'		=> 'main_header_tabs',
		'label'    		=> esc_html__( 'Settings', 'voluto' ),
		'label2'    	=> esc_html__( 'Styling', 'voluto' ),
		'connected'		=> 'voluto_main_header',
		'connected2'	=> 'voluto_main_header_styling',
		'section'  		=> 'voluto_main_header_styling',
		'priority'      => 10,
	)
) );

$wp_customize->add_setting(
	'main_header_top_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'main_header_top_title',
	array(
		'label'    			=> esc_html__( 'Top', 'voluto' ),
		'section'  			=> 'voluto_main_header_styling',
		'active_callback'	=> 'voluto_bottom_header_bar_callback',
		'priority'      => 10,
	)
) );

$wp_customize->add_setting(
	'top_header_background_color',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'top_header_background_color',
		array(
			'label'    => esc_html__( 'Background color', 'voluto' ),
			'section'  => 'voluto_main_header_styling',
			'priority'      => 10,
		)
	)
);

$wp_customize->add_setting(
	'top_header_color',
	array(
		'default'           => '#000',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'top_header_color',
		array(
			'label'    => esc_html__( 'Text color', 'voluto' ),
			'section'  => 'voluto_main_header_styling',
			'priority'      => 10,
		)
	)
);

$wp_customize->add_setting( 'top_header_padding_desktop', array(
	'default'   => 30,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'top_header_padding_tablet', array(
	'default'	=> 30,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'top_header_padding_mobile', array(
	'default'	=> 30,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'top_header_padding',
	array(
		'label' => esc_html__( 'Vertical spacing', 'voluto' ),
		'section' => 'voluto_main_header_styling',
		'settings'   => array (
			'top_header_padding_desktop',
			'top_header_padding_tablet',
			'top_header_padding_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
			'unit'	=> 'px'
		),		
		'priority'      => 10,
	)
) );



$wp_customize->add_setting(
	'main_header_bottom_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'main_header_bottom_title',
	array(
		'label'    			=> esc_html__( 'Bottom', 'voluto' ),
		'section'  			=> 'voluto_main_header_styling',
		'active_callback'	=> 'voluto_bottom_header_bar_callback',
		'priority'      	=> 20,
	)
) );

$wp_customize->add_setting(
	'bottom_header_background_color',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'bottom_header_background_color',
		array(
			'label'    => esc_html__( 'Background color', 'voluto' ),
			'section'  => 'voluto_main_header_styling',
			'active_callback'	=> 'voluto_bottom_header_bar_callback',
			'priority'      	=> 20,
		)
	)
);

$wp_customize->add_setting(
	'bottom_header_color',
	array(
		'default'           => '#000',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'bottom_header_color',
		array(
			'label'    			=> esc_html__( 'Text color', 'voluto' ),
			'section'  			=> 'voluto_main_header_styling',
			'active_callback'	=> 'voluto_bottom_header_bar_callback',
			'priority'      	=> 20,
		)
	)
);
$wp_customize->add_setting( 'bottom_header_padding_desktop', array(
	'default'   => 0,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'bottom_header_padding_tablet', array(
	'default'	=> 0,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'bottom_header_padding_mobile', array(
	'default'	=> 0,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'bottom_header_padding',
	array(
		'label' => esc_html__( 'Vertical spacing', 'voluto' ),
		'section' => 'voluto_main_header_styling',
		'settings'   => array (
			'bottom_header_padding_desktop',
			'bottom_header_padding_tablet',
			'bottom_header_padding_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
			'unit'	=> 'px'
		),		
		'active_callback'	=> 'voluto_bottom_header_bar_callback',
		'priority'      	=> 20,
	)
) );


$wp_customize->add_setting(
	'mobile_header_top_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'mobile_header_top_title',
	array(
		'label'    			=> esc_html__( 'Mobile header', 'voluto' ),
		'section'  			=> 'voluto_main_header_styling',
		'priority'      	=> 30,
	)
) );

$wp_customize->add_setting(
	'mobile_header_background_color',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'mobile_header_background_color',
		array(
			'label'    => esc_html__( 'Background color', 'voluto' ),
			'section'  => 'voluto_main_header_styling',
			'priority'      	=> 30,
		)
	)
);

$wp_customize->add_setting(
	'mobile_header_color',
	array(
		'default'           => '#000',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'mobile_header_color',
		array(
			'label'    => esc_html__( 'Text color', 'voluto' ),
			'section'  => 'voluto_main_header_styling',
			'priority'      	=> 30,
		)
	)
);


$wp_customize->add_setting(
	'offcanvas_menu_top_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'offcanvas_menu_top_title',
	array(
		'label'    			=> esc_html__( 'Offcanvas menu', 'voluto' ),
		'section'  			=> 'voluto_main_header_styling',
		'priority'      	=> 40,
	)
) );

$wp_customize->add_setting(
	'offcanvas_menu_background_color',
	array(
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'offcanvas_menu_background_color',
		array(
			'label'    => esc_html__( 'Background color', 'voluto' ),
			'section'  => 'voluto_main_header_styling',
			'priority'      	=> 40,
		)
	)
);

$wp_customize->add_setting(
	'offcanvas_menu_color',
	array(
		'default'           => '#000',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'offcanvas_menu_color',
		array(
			'label'    => esc_html__( 'Text color', 'voluto' ),
			'section'  => 'voluto_main_header_styling',
			'priority'      	=> 40,
		)
	)
);