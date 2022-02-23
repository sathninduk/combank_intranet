<?php
/**
 * Hero Customizer options
 *
 * @package Voluto
 */


/**
 * Hero
 */
$wp_customize->add_section(
	'voluto_header_hero',
	array(
		'title'         => esc_html__( 'Hero', 'voluto' ),
		'priority'      => 11,
		'panel'			=> 'voluto_header_panel'
	)
);

$wp_customize->add_setting( 'voluto_hero_type', array(
	'sanitize_callback' => 'voluto_sanitize_select',
	'default' 			=> 'post_grid',
) );

$wp_customize->add_control( 'voluto_hero_type', array(
	'type' => 'select',
	'section' => 'voluto_header_hero',
	'label' => esc_html__( 'Hero type', 'voluto' ),
	'choices' => array(
		'disabled' 		=> esc_html__( 'Disabled', 'voluto' ),
		'header_image' 	=> esc_html__( 'Static Image', 'voluto' ),
		'post_grid' 	=> esc_html__( 'Post grid', 'voluto' ),
	),
	'priority' => 9
) );

//Get header image control
$wp_customize->add_setting(
	'hero_header_image_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'hero_header_image_title',
	array(
		'label'    			=> esc_html__( 'Image', 'voluto' ),
		'section'  			=> 'voluto_header_hero',
		'active_callback'	=> 'voluto_hero_header_image_active_callback',
		'priority' => 9
	)
) );

$wp_customize->get_control( 'header_image' )->section 			= 'voluto_header_hero';
$wp_customize->get_control( 'header_image' )->priority 			= 10;
$wp_customize->get_control( 'header_image' )->active_callback 	= 'voluto_hero_header_image_active_callback';


//Layout
$wp_customize->add_setting(
	'hero_layout_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'hero_layout_title',
	array(
		'label'    			=> esc_html__( 'Layout', 'voluto' ),
		'section'  			=> 'voluto_header_hero',
		'active_callback'	=> 'voluto_hero_layout_callback'
	)
) );

$wp_customize->add_setting( 'header_hero_width',
	array(
		'default' 			=> 'container-wide',
		'sanitize_callback' => 'voluto_sanitize_text'
	)
);
$wp_customize->add_control( new Voluto_Radio_Buttons( $wp_customize, 'header_hero_width',
	array(
		'label'   => esc_html__( 'Section width', 'voluto' ),
		'section' => 'voluto_header_hero',
		'columns' => 3,
		'choices' => array(
			'container' 		=> esc_html__( 'Contain', 'voluto' ),
			'container-wide' 	=> esc_html__( 'Wide', 'voluto' ),
			'nocontainer' 		=> esc_html__( 'Full', 'voluto' ),
		),
		'active_callback'	=> 'voluto_hero_layout_callback'
	)
) );

$wp_customize->add_setting(
	'post_grid_layout',
	array(
		'default'           => 'default',
		'sanitize_callback' => 'sanitize_key',
	)
);
$wp_customize->add_control(
	new Voluto_Radio_Images(
		$wp_customize,
		'post_grid_layout',
		array(
			'label'    		=> esc_html__( 'Post grid layout', 'voluto' ),
			'section'  => 'voluto_header_hero',
			'columns'	=> 2,
			'choices'  => array(
				'default' => array(
					'label' => esc_html__( '3-Post Grid', 'voluto' ),
					'url'   => '%s/assets/img/hero1.svg'
				),
				'grid5' => array(
					'label' => esc_html__( '5-Post Grid', 'voluto' ),
					'url'   => '%s/assets/img/hero2.svg'
				),
				'columns4' => array(
					'label' => esc_html__( '4 columns', 'voluto' ),
					'url'   => '%s/assets/img/hero3.svg'
				),
				'mixed' => array(
					'label' => esc_html__( 'Mixed', 'voluto' ),
					'url'   => '%s/assets/img/hero4.svg'
				),				
			),
			'priority' 			=> 10,
			'active_callback'	=> 'voluto_hero_post_grid_active_callback'
		)
	)
); 

/**
 * Source
 */
$wp_customize->add_setting(
	'post_grid_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'post_grid_title',
	array(
		'label'    => esc_html__( 'Post settings', 'voluto' ),
		'section'  => 'voluto_header_hero',
		'active_callback'	=> 'voluto_hero_post_grid_active_callback'
	)
) );


$wp_customize->add_setting( 'post_grid_source', array(
	'sanitize_callback' => 'voluto_sanitize_select',
	'default' 			=> 'post',
) );

$wp_customize->add_control( 'post_grid_source', array(
	'type' 		=> 'select',
	'section' 	=> 'voluto_header_hero',
	'label' 	=> esc_html__( 'Post type', 'voluto' ),
	'choices' 	=> voluto_post_types_helper(),
	'active_callback'	=> 'voluto_hero_post_grid_active_callback'
) );


$wp_customize->add_setting( 'post_grid_ids',
	array(
		'default' => '',
		'sanitize_callback' => 'voluto_sanitize_post_array'
	)
);
$wp_customize->add_control( new Voluto_Posts_Dropdown( $wp_customize, 'post_grid_ids',
	array(
		'label' => esc_html__( 'Select your posts', 'voluto' ),
		'section' => 'voluto_header_hero',
		'input_attrs' => array(
			'posts_per_page' 	=> -1, // phpcs:ignore WPThemeReview.CoreFunctionality.PostsPerPage.posts_per_page_posts_per_page
			'orderby' 			=> 'name',
			'order' 			=> 'ASC',
			'post_type' 		=> 'post'
		),
		'active_callback'	=> 'voluto_hero_post_grid_posts_callback'
	)
) );

$wp_customize->add_setting( 'pages_grid_ids',
	array(
		'default' => '',
		'sanitize_callback' => 'voluto_sanitize_post_array'
	)
);
$wp_customize->add_control( new Voluto_Posts_Dropdown( $wp_customize, 'pages_grid_ids',
	array(
		'label' => esc_html__( 'Select your pages', 'voluto' ),
		'section' => 'voluto_header_hero',
		'input_attrs' => array(
			'posts_per_page' 	=> -1, // phpcs:ignore WPThemeReview.CoreFunctionality.PostsPerPage.posts_per_page_posts_per_page
			'orderby' 			=> 'name',
			'order' 			=> 'ASC',
			'post_type' 		=> 'page'
		),
		'active_callback'	=> 'voluto_hero_post_grid_pages_callback'
	)
) );

/**
 * Display
 */
$wp_customize->add_setting(
	'hero_display_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'hero_display_title',
	array(
		'label'    			=> esc_html__( 'Display', 'voluto' ),
		'section'  			=> 'voluto_header_hero',
		'active_callback'	=> 'voluto_hero_layout_callback'
	)
) );

$wp_customize->add_setting(
	'hero_front_page',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'hero_front_page',
		array(
			'label'         	=> esc_html__( 'Display the hero on your static homepage', 'voluto' ),
			'section'       	=> 'voluto_header_hero',
			'active_callback'	=> 'voluto_hero_layout_callback'
		)
	)
);

$wp_customize->add_setting(
	'hero_blog_page',
	array(
		'default'           => 0,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'hero_blog_page',
		array(
			'label'         	=> esc_html__( 'Display the hero on your blog page', 'voluto' ),
			'section'       	=> 'voluto_header_hero',
			'active_callback'	=> 'voluto_hero_layout_callback'
		)
	)
);

/**
 * Elements
 */
$wp_customize->add_setting(
	'hero_elements_title',
	array(
		'sanitize_callback' => 'esc_html',
	)
);
$wp_customize->add_control( new Voluto_Title( $wp_customize, 'hero_elements_title',
	array(
		'label'    			=> esc_html__( 'Elements', 'voluto' ),
		'section'  			=> 'voluto_header_hero',
		'active_callback'	=> 'voluto_hero_post_grid_active_callback'
	)
) );

$wp_customize->add_setting(
	'hero_show_cats',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'hero_show_cats',
		array(
			'label'         	=> esc_html__( 'Show categories', 'voluto' ),
			'section'       	=> 'voluto_header_hero',
			'active_callback'	=> 'voluto_hero_post_grid_active_callback'
		)
	)
);

$wp_customize->add_setting(
	'hero_show_author',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'hero_show_author',
		array(
			'label'         	=> esc_html__( 'Show author', 'voluto' ),
			'section'       	=> 'voluto_header_hero',
			'active_callback'	=> 'voluto_hero_post_grid_active_callback'
		)
	)
);

$wp_customize->add_setting(
	'hero_show_date',
	array(
		'default'           => 1,
		'sanitize_callback' => 'voluto_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new Voluto_Toggle_Control(
		$wp_customize,
		'hero_show_date',
		array(
			'label'         	=> esc_html__( 'Show date', 'voluto' ),
			'section'       	=> 'voluto_header_hero',
			'active_callback'	=> 'voluto_hero_post_grid_active_callback'
		)
	)
);