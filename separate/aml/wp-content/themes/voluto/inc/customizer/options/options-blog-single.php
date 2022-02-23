<?php
/**
 * Blog Customizer options
 *
 * @package Voluto
 */
/**
 * Singles
 */
$wp_customize->add_section(
	'voluto_section_blog_singles',
	array(
		'title'         => esc_html__( 'Single posts', 'voluto'),
		'priority'      => 11,
		'panel'         => 'voluto_panel_blog',
	)
);

$wp_customize->add_setting(
	'blog_single_tabs',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Tabs( $wp_customize, 'blog_single_tabs',
	array(
		'linked'			=> 'blog_single_tabs',
		'label'    		=> esc_html__( 'Settings', 'voluto' ),
		'label2'    	=> esc_html__( 'Styling', 'voluto' ),
		'connected'		=> 'voluto_section_blog_singles',
		'connected2'	=> 'voluto_section_blog_singles_styling',
		'section'  		=> 'voluto_section_blog_singles',
	)
) );

$wp_customize->add_setting(
	'single_post_layout',
	array(
		'default'           => 'sidebar-right',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Voluto_Radio_Images(
		$wp_customize,
		'single_post_layout',
		array(
			'label'    		=> esc_html__( 'Post layout', 'voluto' ),
			'section'  => 'voluto_section_blog_singles',
			'columns'	=> 3,
			'choices'  => array(
				'no-sidebar' => array(
					'label' => esc_html__( 'No sidebar', 'voluto' ),
					'url'   => '%s/assets/img/sidnonesingle.svg'
				),
				'sidebar-left' => array(
					'label' => esc_html__( 'Sidebar Left', 'voluto' ),
					'url'   => '%s/assets/img/sidleftsingle.svg'
				),	
				'sidebar-right' => array(
					'label' => esc_html__( 'Sidebar Right', 'voluto' ),
					'url'   => '%s/assets/img/sidrightsingle.svg'
				),												
			),
		)
	)
); 

$wp_customize->add_setting(
	'single_post_header_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'single_post_header_title',
	array(
		'label'    			=> esc_html__( 'Post header', 'voluto' ),
		'section'  			=> 'voluto_section_blog_singles',
	)
) );

$wp_customize->add_setting(
	'single_post_header_layout',
	array(
		'default'           => 'standard',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Voluto_Radio_Images(
		$wp_customize,
		'single_post_header_layout',
		array(
			'label'    		=> esc_html__( 'Layout', 'voluto' ),
			'section'  => 'voluto_section_blog_singles',
			'columns'	=> 3,
			'choices'  => array(
				'standard' => array(
					'label' => esc_html__( 'Standard', 'voluto' ),
					'url'   => '%s/assets/img/postheaderstandard.svg'
				),
				'overlay' => array(
					'label' => esc_html__( 'Overlay', 'voluto' ),
					'url'   => '%s/assets/img/postheaderbanner.svg'
				),	
				'overlap' => array(
					'label' => esc_html__( 'Overlap', 'voluto' ),
					'url'   => '%s/assets/img/postheaderoverlap.svg'
				),												
			),
		)
	)
); 


$wp_customize->add_setting( 'single_post_header_align',
	array(
		'default' 			=> 'left',
		'sanitize_callback' => 'voluto_sanitize_text',
		'transport'			=> 'postMessage',
	)
);
$wp_customize->add_control( new Voluto_Radio_Buttons( $wp_customize, 'single_post_header_align',
	array(
		'label'   => esc_html__( 'Alignment', 'voluto' ),
		'section' => 'voluto_section_blog_singles',
		'columns' => 3,
		'choices' => array(
			'left' 		=> '<svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M12.83 352h262.34A12.82 12.82 0 00288 339.17v-38.34A12.82 12.82 0 00275.17 288H12.83A12.82 12.82 0 000 300.83v38.34A12.82 12.82 0 0012.83 352zm0-256h262.34A12.82 12.82 0 00288 83.17V44.83A12.82 12.82 0 00275.17 32H12.83A12.82 12.82 0 000 44.83v38.34A12.82 12.82 0 0012.83 96zM432 160H16a16 16 0 00-16 16v32a16 16 0 0016 16h416a16 16 0 0016-16v-32a16 16 0 00-16-16zm0 256H16a16 16 0 00-16 16v32a16 16 0 0016 16h416a16 16 0 0016-16v-32a16 16 0 00-16-16z"/></svg>',
			'center' 	=> '<svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M432 160H16a16 16 0 00-16 16v32a16 16 0 0016 16h416a16 16 0 0016-16v-32a16 16 0 00-16-16zm0 256H16a16 16 0 00-16 16v32a16 16 0 0016 16h416a16 16 0 0016-16v-32a16 16 0 00-16-16zM108.1 96h231.81A12.09 12.09 0 00352 83.9V44.09A12.09 12.09 0 00339.91 32H108.1A12.09 12.09 0 0096 44.09V83.9A12.1 12.1 0 00108.1 96zm231.81 256A12.09 12.09 0 00352 339.9v-39.81A12.09 12.09 0 00339.91 288H108.1A12.09 12.09 0 0096 300.09v39.81a12.1 12.1 0 0012.1 12.1z"/></svg>',
			'right' 	=> '<svg width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M16 224h416a16 16 0 0016-16v-32a16 16 0 00-16-16H16a16 16 0 00-16 16v32a16 16 0 0016 16zm416 192H16a16 16 0 00-16 16v32a16 16 0 0016 16h416a16 16 0 0016-16v-32a16 16 0 00-16-16zm3.17-384H172.83A12.82 12.82 0 00160 44.83v38.34A12.82 12.82 0 00172.83 96h262.34A12.82 12.82 0 00448 83.17V44.83A12.82 12.82 0 00435.17 32zm0 256H172.83A12.82 12.82 0 00160 300.83v38.34A12.82 12.82 0 00172.83 352h262.34A12.82 12.82 0 00448 339.17v-38.34A12.82 12.82 0 00435.17 288z"/></svg>',
		),
	)
) );

$wp_customize->add_setting( 'single_post_header_valign',
	array(
		'default' 			=> 'flex-end',
		'sanitize_callback' => 'voluto_sanitize_text',
		'transport' 		=> 'postMessage'
	)
);
$wp_customize->add_control( new Voluto_Radio_Buttons( $wp_customize, 'single_post_header_valign',
	array(
		'section' => 'voluto_section_blog_singles',
		'columns' => 3,
		'choices' => array(
			'flex-start' 	=> '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><rect width="5" height="13" transform="translate(2 3)"/><rect width="5" height="7" transform="translate(9 3)"/><rect width="16" height="2"/></svg>',
			'center' 		=> '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><rect width="5" height="16" transform="translate(2)"/><rect width="5" height="10" transform="translate(9 3)"/><rect width="16" height="2" transform="translate(0 7)"/></svg>',
			'flex-end' 		=> '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><rect width="5" height="13" transform="translate(2)"/><rect width="5" height="7" transform="translate(9 6)"/><rect width="16" height="2" transform="translate(0 14)"/></svg>',
		),
		'active_callback'	=> 'voluto_blog_post_header_overlay_container_callback'
	)
) );

$wp_customize->add_setting( 'single_post_header_container',
	array(
		'default' 			=> 'nocontainer',
		'sanitize_callback' => 'voluto_sanitize_text'
	)
);
$wp_customize->add_control( new Voluto_Radio_Buttons( $wp_customize, 'single_post_header_container',
	array(
		'label'   => esc_html__( 'Container type', 'voluto' ),
		'section' => 'voluto_section_blog_singles',
		'columns' => 3,
		'choices' => array(
			'container' 		=> esc_html__( 'Contain', 'voluto' ),
			'container-wide' 	=> esc_html__( 'Wide', 'voluto' ),
			'nocontainer' 		=> esc_html__( 'Full', 'voluto' ),
		),
		'active_callback'	=> 'voluto_blog_post_header_container_callback'
	)
) );

$wp_customize->add_setting(
	'single_post_header_featured',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'single_post_header_featured',
		array(
			'label'         	=> esc_html__( 'Use featured image for header background', 'voluto' ),
			'section'       	=> 'voluto_section_blog_singles',
			'active_callback'	=> 'voluto_blog_post_header_container_callback'
		)
	)
);

$wp_customize->add_setting( 'post_header_height_desktop', array(
	'default'   => 400,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'post_header_height_tablet', array(
	'default'	=> 400,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'post_header_height_mobile', array(
	'default'	=> 400,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'post_header_height',
	array(
		'label' => esc_html__( 'Height', 'voluto' ),
		'section' => 'voluto_section_blog_singles',
		'settings'   => array (
			'post_header_height_desktop',
			'post_header_height_tablet',
			'post_header_height_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 800,
			'step'  => 5,
			'unit'	=> 'px'
		),	
		'active_callback'	=> 'voluto_blog_post_header_container_callback'	
	)
) );

$wp_customize->add_setting(
	'single_post_elements_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'single_post_elements_title',
	array(
		'label'    			=> esc_html__( 'Elements', 'voluto' ),
		'section'  			=> 'voluto_section_blog_singles',
	)
) );

$wp_customize->add_setting(
	'single_post_featured',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'single_post_featured',
		array(
			'label'         	=> esc_html__( 'Featured image', 'voluto' ),
			'section'       	=> 'voluto_section_blog_singles',
		)
	)
);

$wp_customize->add_setting(
	'single_post_meta',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'single_post_meta',
		array(
			'label'         	=> esc_html__( 'Author & post date', 'voluto' ),
			'section'       	=> 'voluto_section_blog_singles',
		)
	)
);

$wp_customize->add_setting(
	'single_post_cats',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'single_post_cats',
		array(
			'label'         	=> esc_html__( 'Post categories', 'voluto' ),
			'section'       	=> 'voluto_section_blog_singles',
		)
	)
);

$wp_customize->add_setting(
	'single_post_tags',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'single_post_tags',
		array(
			'label'         	=> esc_html__( 'Post tags', 'voluto' ),
			'section'       	=> 'voluto_section_blog_singles',
		)
	)
);

$wp_customize->add_setting(
	'single_post_sharing',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'single_post_sharing',
		array(
			'label'         	=> esc_html__( 'Post sharing', 'voluto' ),
			'section'       	=> 'voluto_section_blog_singles',
			'forward'	=> array(
				'slug'		=> 'voluto_section_single_sharing',
				'type'		=> 'section'
			)
		)
	)
);

$wp_customize->add_setting(
	'single_post_nav',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'single_post_nav',
		array(
			'label'         	=> esc_html__( 'Post navigation', 'voluto' ),
			'section'       	=> 'voluto_section_blog_singles',
		)
	)
);

$wp_customize->add_setting(
	'single_post_author_box',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'single_post_author_box',
		array(
			'label'         	=> esc_html__( 'Author box', 'voluto' ),
			'section'       	=> 'voluto_section_blog_singles',
		)
	)
);

$wp_customize->add_setting(
	'single_post_related_box',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'single_post_related_box',
		array(
			'label'         	=> esc_html__( 'Related posts', 'voluto' ),
			'section'       	=> 'voluto_section_blog_singles',
		)
	)
);

$wp_customize->add_setting(
	'single_post_comments',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'single_post_comments',
		array(
			'label'         	=> esc_html__( 'Comments', 'voluto' ),
			'section'       	=> 'voluto_section_blog_singles',
		)
	)
);

/**
 * Styling
 */
$wp_customize->add_section(
	'voluto_section_blog_singles_styling',
	array(
		'title'         => esc_html__( 'Single posts styling', 'voluto'),
		'priority'      => 11,
		'panel'         => 'voluto_panel_blog',
	)
);

$wp_customize->add_setting(
	'blog_single_tabs_styling',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Tabs( $wp_customize, 'blog_single_tabs_styling',
	array(
		'linked'		=> 'blog_single_tabs',
		'label'    		=> esc_html__( 'Settings', 'voluto' ),
		'label2'    	=> esc_html__( 'Styling', 'voluto' ),
		'connected'		=> 'voluto_section_blog_singles',
		'connected2'	=> 'voluto_section_blog_singles_styling',
		'section'  		=> 'voluto_section_blog_singles_styling',
	)
) );

$wp_customize->add_setting( 'single_post_borders_color',
	array(
		'default'           => '#e4e6ea',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'voluto_hex_rgba_sanitize'
	)
);
$wp_customize->add_control( new Voluto_Alpha_Color( $wp_customize, 'single_post_borders_color',
	array(
		'label' 			=> esc_html__( 'Separators', 'voluto' ),
		'section'  			=> 'voluto_section_blog_singles_styling',
	)
) );

$wp_customize->add_setting( 'single_post_overlay_color',
	array(
		'default' 			=> 'rgba(0,0,0,0.4)',
		'transport'			=> 'postMessage',
		'sanitize_callback' => 'voluto_hex_rgba_sanitize'
	)
);
$wp_customize->add_control( new Voluto_Alpha_Color( $wp_customize, 'single_post_overlay_color',
	array(
		'label' 			=> esc_html__( 'Banner overlay', 'voluto' ),
		'section'  			=> 'voluto_section_blog_singles_styling',
		'active_callback' 	=> 'voluto_blog_post_header_overlay_container_callback'
	)
) );

//Post title
$wp_customize->add_setting(
	'blog_single_post_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'blog_single_post_title',
	array(
		'label'    			=> esc_html__( 'Post title', 'voluto' ),
		'section'  			=> 'voluto_section_blog_singles_styling',
	)
) );

$wp_customize->add_setting(
	'single_post_title_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'single_post_title_color',
		array(
			'label'    => esc_html__( 'Color', 'voluto' ),
			'section'  => 'voluto_section_blog_singles_styling',
		)
	)
);

$wp_customize->add_setting( 'single_post_title_size_desktop', array(
	'default'   => 48,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'single_post_title_size_tablet', array(
	'default'	=> 38,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'single_post_title_size_mobile', array(
	'default'	=> 32,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'single_post_title_size',
	array(
		'label' => esc_html__( 'Font size', 'voluto' ),
		'section' => 'voluto_section_blog_singles_styling',
		'settings'   => array (
			'single_post_title_size_desktop',
			'single_post_title_size_tablet',
			'single_post_title_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
			'unit'	=> 'px'
		),		
	)
) );

$wp_customize->add_setting( 'single_post_title_transform',
	array(
		'default' 			=> 'none',
		'sanitize_callback' => 'voluto_sanitize_text',
		'transport'	=> 'postMessage',
	)
);
$wp_customize->add_control( new Voluto_Radio_Buttons( $wp_customize, 'single_post_title_transform',
	array(
		'label'   => esc_html__( 'Text transform', 'voluto' ),
		'section' => 'voluto_section_blog_singles_styling',
		'columns' => 4,
		'choices' => array(
			'none' 			=> esc_html__( '-', 'voluto' ),
			'lowercase' 	=> esc_html__( 'aa', 'voluto' ),
			'capitalize' 	=> esc_html__( 'Aa', 'voluto' ),
			'uppercase' 	=> esc_html__( 'AA', 'voluto' ),
		),
	)
) );

//Meta
$wp_customize->add_setting(
	'blog_single_post_meta',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'blog_single_post_meta',
	array(
		'label'    			=> esc_html__( 'Meta', 'voluto' ),
		'section'  			=> 'voluto_section_blog_singles_styling',
	)
) );

$wp_customize->add_setting(
	'single_post_meta_color',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	)
);
$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'single_post_meta_color',
		array(
			'label'    => esc_html__( 'Color', 'voluto' ),
			'section'  => 'voluto_section_blog_singles_styling',
		)
	)
);

$wp_customize->add_setting( 'single_post_meta_size_desktop', array(
	'default'   => 13,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'single_post_meta_size_tablet', array(
	'default'	=> 13,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_setting( 'single_post_meta_size_mobile', array(
	'default'	=> 13,
	'transport'	=> 'postMessage',
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new Voluto_Responsive_Number( $wp_customize, 'single_post_meta_size',
	array(
		'label' => esc_html__( 'Font size', 'voluto' ),
		'section' => 'voluto_section_blog_singles_styling',
		'settings'   => array (
			'single_post_meta_size_desktop',
			'single_post_meta_size_tablet',
			'single_post_meta_size_mobile'
		),
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 250,
			'step'  => 1,
			'unit'	=> 'px'
		),		
	)
) );

$wp_customize->add_setting( 'single_post_meta_transform',
	array(
		'default' 			=> 'none',
		'sanitize_callback' => 'voluto_sanitize_text',
		'transport'	=> 'postMessage',
	)
);
$wp_customize->add_control( new Voluto_Radio_Buttons( $wp_customize, 'single_post_meta_transform',
	array(
		'label'   => esc_html__( 'Text transform', 'voluto' ),
		'section' => 'voluto_section_blog_singles_styling',
		'columns' => 4,
		'choices' => array(
			'none' 			=> esc_html__( '-', 'voluto' ),
			'lowercase' 	=> esc_html__( 'aa', 'voluto' ),
			'capitalize' 	=> esc_html__( 'Aa', 'voluto' ),
			'uppercase' 	=> esc_html__( 'AA', 'voluto' ),
		),
	)
) );