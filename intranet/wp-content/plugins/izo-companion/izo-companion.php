<?php

/**
 *
 * @link              https://elfwp.com
 * @since             1.0.0
 *
 * Plugin Name:       elfWP Companion
 * Description:       Demo content configuration for elfwp.com themes
 * Version:           1.0.8
 * Author:            elfWP
 * Author URI:        https://elfwp.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       izo-companion
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Set constants
 */
define( 'IZO_COMP_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );    
define( 'IZO_COMP_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * Main class
 */
if ( !class_exists( 'Izo_Companion' ) ) :
Class Izo_Companion {

    /**
     * Instance
     */		
    private static $instance;

    /**
     * Initiator
     */
    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    public function __construct() {	
		
		$theme = wp_get_theme()->get( 'Name' );

		if ( wp_get_theme()->parent() ) {
			$theme = wp_get_theme()->parent()->get( 'Name' );
		}	

		if ( $theme === 'Shopix' ) {
			add_filter( 'advanced_import_demo_lists', array( $this, 'demo_list_shopix' ) );	
		} else if ( $theme === 'Voluto' ) {
			add_filter( 'advanced_import_demo_lists', array( $this, 'demo_list_voluto' ) );	
		} elseif ( $theme == 'Izo' ) {
			add_filter( 'advanced_import_demo_lists', array( $this, 'demo_list_izo' ) );
		} else {
			return;
		}
		add_action( 'wp_head', array( $this, 'dyncss' ), 99 ); //Todo: remove
	}

	/**
	 * Demo list
	 */
	public function demo_list_shopix() {
	
		
		$demo_lists = array(
			'fashion' => array(
				'title' 	=> esc_html__( 'Fashion', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'shop', 'woocommerce', 'fashion', 'store' ),
				'categories' => array( 'ecommerce' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/shopix/fashion/content.json',
						'options' => IZO_COMP_URI . 'demo-content/shopix/fashion/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/shopix/fashion/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/shopix/fashion/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/shopix-fashion/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
					array(
						'name'      => esc_html__( 'WooCommerce', 'izo' ),
						'slug'      => 'woocommerce',
					),					
				)
			),
			'electronics' => array(
				'title' 	=> esc_html__( 'Electronics', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'shop', 'woocommerce', 'electronics', 'store' ),
				'categories' => array( 'ecommerce' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/shopix/electronics/content.json',
						'options' => IZO_COMP_URI . 'demo-content/shopix/electronics/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/shopix/electronics/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/shopix/electronics/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/shopix-electronics/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
					array(
						'name'      => esc_html__( 'WooCommerce', 'izo' ),
						'slug'      => 'woocommerce',
					),					
				)
			),			
		);	
		
		return $demo_lists;
	}

	public function demo_list_voluto() {
	
		
		$demo_lists = array(
			'default' => array(
				'title' 	=> esc_html__( 'Default', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> '',
				'keywords' 	=> array( 'blog', 'magazine' ),
				'categories' => array( 'blog' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/voluto/default/content.json',
						'options' => IZO_COMP_URI . 'demo-content/voluto/default/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/voluto/default/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/voluto/default/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/voluto/',
			),
			'politics' => array(
				'title' 	=> esc_html__( 'Politics', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> '',
				'keywords' 	=> array( 'blog', 'magazine', 'politics' ),
				'categories' => array( 'blog' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/voluto/politics/content.json',
						'options' => IZO_COMP_URI . 'demo-content/voluto/politics/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/voluto/politics/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/voluto/politics/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/voluto-politics/',
			),			
		);	
		
		return $demo_lists;
	}	

	/**
	 * Demo list
	 */
	public function demo_list_izo() {

		$demo_lists = array(
			'agency' => array(
				'title' 	=> esc_html__( 'Agency', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'multipurpose', 'agency' ),
				'categories' => array( 'multipurpose' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/agency/content.json',
						'options' => IZO_COMP_URI . 'demo-content/agency/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/agency/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/agency/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-agency/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),

			'digital-agency' => array(
				'title' 	=> esc_html__( 'Digital Agency', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'multipurpose', 'agency' ),
				'categories' => array( 'multipurpose' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/digital-agency/content.json',
						'options' => IZO_COMP_URI . 'demo-content/digital-agency/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/digital-agency/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/digital-agency/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-agency-2/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),

			'restaurant' => array(
				'title' 	=> esc_html__( 'Restaurant', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'restaurant', 'cafe' ),
				'categories' => array( 'business' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/restaurant/content.json',
						'options' => IZO_COMP_URI . 'demo-content/restaurant/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/restaurant/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/restaurant/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-restaurant/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),				

			'accounting' => array(
				'title' 	=> esc_html__( 'Accounting', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'finance', 'business', 'corporate' ),
				'categories' => array( 'business' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/accounting/content.json',
						'options' => IZO_COMP_URI . 'demo-content/accounting/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/accounting/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/accounting/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-accounting/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),

			'finance' => array(
				'title' 	=> esc_html__( 'Finance', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'finance', 'business', 'corporate' ),
				'categories' => array( 'business' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/finance/content.json',
						'options' => IZO_COMP_URI . 'demo-content/finance/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/finance/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/finance/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-finance/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),	

			'saas' => array(
				'title' 	=> esc_html__( 'SAAS', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'business', 'saas' ),
				'categories' => array( 'business' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/saas/content.json',
						'options' => IZO_COMP_URI . 'demo-content/saas/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/saas/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/saas/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-saas/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),	
			
			'saas2' => array(
				'title' 	=> esc_html__( 'SAAS 2', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'business', 'saas' ),
				'categories' => array( 'business' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/saas2/content.json',
						'options' => IZO_COMP_URI . 'demo-content/saas2/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/saas2/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/saas2/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-saas-2/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),				
			
			'gym' => array(
				'title' 	=> esc_html__( 'Gym', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'fitness', 'gym' ),
				'categories' => array( 'health' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/gym/content.json',
						'options' => IZO_COMP_URI . 'demo-content/gym/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/gym/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/gym/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-gym/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),		
			
			'electronics-shop' => array(
				'title' 	=> esc_html__( 'Electronics shop', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'shop', 'woocommerce', 'ecommerce', 'electronics' ),
				'categories' => array( 'shop' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/electronics-shop/content.json',
						'options' => IZO_COMP_URI . 'demo-content/electronics-shop/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/electronics-shop/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/electronics-shop/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-electronics-shop/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),			

			'law-firm' => array(
				'title' 	=> esc_html__( 'Law firm', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'business', 'corporate', 'law', 'law firm', 'lawyer' ),
				'categories' => array( 'business' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/law-firm/content.json',
						'options' => IZO_COMP_URI . 'demo-content/law-firm/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/law-firm/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/law-firm/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-law-firm/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),

			'industry' => array(
				'title' 	=> esc_html__( 'Industry', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'business', 'corporate', 'industry', 'industrial' ),
				'categories' => array( 'business' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/industry/content.json',
						'options' => IZO_COMP_URI . 'demo-content/industry/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/industry/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/industry/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-industry/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),

			'movers' => array(
				'title' 	=> esc_html__( 'Movers', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'moving', 'movers', 'logistics' ),
				'categories' => array( 'business' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/movers/content.json',
						'options' => IZO_COMP_URI . 'demo-content/movers/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/movers/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/movers/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-movers/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),
			
			'spa' => array(
				'title' 	=> esc_html__( 'Spa', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'spa', 'salon' ),
				'categories' => array( 'business' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/spa/content.json',
						'options' => IZO_COMP_URI . 'demo-content/spa/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/spa/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/spa/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-spa/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),					

			'medical' => array(
				'title' 	=> esc_html__( 'Medical', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'medic', 'doctor' ),
				'categories' => array( 'health' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/spa/content.json',
						'options' => IZO_COMP_URI . 'demo-content/spa/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/spa/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/medical/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-medical/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),	

			'barbershop' => array(
				'title' 	=> esc_html__( 'Barbershop', 'izo' ),
				'is_pro' 	=> false,
				'type' 		=> 'elementor',
				'keywords' 	=> array( 'barber', 'barbershop', 'salon' ),
				'categories' => array( 'business' ),
					'template_url' => array(
						'content' => IZO_COMP_URI . 'demo-content/barbershop/content.json',
						'options' => IZO_COMP_URI . 'demo-content/barbershop/options.json',
						'widgets' => IZO_COMP_URI . 'demo-content/barbershop/widgets.json'
					),
				'screenshot_url' 	=> IZO_COMP_URI . 'demo-content/barbershop/screenshot.jpg',
				'demo_url' 			=> 'https://demo.elfwp.com/izo-barber/',
				'plugins' 			=> array(
					array(
						'name'      => esc_html__( 'Elementor', 'izo' ),
						'slug'      => 'elementor',
					),
				)
			),

		);
 
		return $demo_lists;
	}

	//Todo: remove
	public function dyncss() {
		echo '<style type="text/css">.layout-stretched.page article {margin-bottom:0;}</style>';
	}

}

/**
 * Initialize class
 */
Izo_Companion::get_instance();

endif;