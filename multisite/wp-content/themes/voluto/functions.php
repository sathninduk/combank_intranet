<?php
/**
 * Voluto functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Voluto
 */

if ( ! defined( 'VOLUTO_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'VOLUTO_VERSION', '1.0.1' );
}

if ( ! function_exists( 'voluto_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function voluto_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Voluto, use a find and replace
		 * to change 'voluto' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'voluto', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'voluto-900x9999', 900, 9999 );
		add_image_size( 'voluto-500x9999', 500, 9999 );
		add_image_size( 'voluto-500x500', 500, 500, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary', 'voluto' ),
				'top-menu' => esc_html__( 'Top bar menu', 'voluto' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'voluto_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		/**
		 * Editor font sizes
		 */
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => esc_html__( 'Small', 'voluto' ),
					'shortName' => esc_html_x( 'S', 'Font size', 'voluto' ),
					'size'      => 'var(--font-size-sm)',
					'slug'      => 'small',
				),				
				array(
					'name'      => esc_html__( 'Normal', 'voluto' ),
					'shortName' => esc_html_x( 'N', 'Font size', 'voluto' ),
					'size'      => 'var(--font-size-md)',
					'slug'      => 'normal',
				),
				array(
					'name'      => esc_html__( 'Large', 'voluto' ),
					'shortName' => esc_html_x( 'L', 'Font size', 'voluto' ),
					'size'      => 'var(--font-size-lg)',
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html__( 'Larger', 'voluto' ),
					'shortName' => esc_html_x( 'XL', 'Font size', 'voluto' ),
					'size'      => 'var(--font-size-xl)',
					'slug'      => 'larger',
				),
				array(
					'name'      => esc_html__( 'Extra large', 'voluto' ),
					'shortName' => esc_html_x( 'XXL', 'Font size', 'voluto' ),
					'size'      => 'var(--font-size-2xl)',
					'slug'      => 'extra-large',
				),
				array(
					'name'      => esc_html__( 'Huge', 'voluto' ),
					'shortName' => esc_html_x( 'XXXL', 'Font size', 'voluto' ),
					'size'      => 'var(--font-size-3xl)',
					'slug'      => 'huge',
				),
				array(
					'name'      => esc_html__( 'Gigantic', 'voluto' ),
					'shortName' => esc_html_x( 'XXXXL', 'Font size', 'voluto' ),
					'size'      => 'var(--font-size-4xl)',
					'slug'      => 'gigantic',
				),
			)
		);

		/**
		 * Block templates
		 */
		add_theme_support( 'block-templates' );

		/**
		 * Wide alignments
		 */		
		add_theme_support( 'align-wide' );
	}
endif;
add_action( 'after_setup_theme', 'voluto_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function voluto_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'voluto_content_width', 1140 ); // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedVariableFound
}
add_action( 'after_setup_theme', 'voluto_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function voluto_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'voluto' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'voluto' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	$footer_widgets_layout = get_theme_mod( 'footer_widgets_layout', 'columns3' );

	switch ( $footer_widgets_layout ) {
		case 'columns3':
			$widget_areas = 3;
			break;
							
		case 'columns1':
			$widget_areas = 1;
			break;

		case 'columns2':
			$widget_areas = 2;
			break;

		case 'columns4':
			$widget_areas = 4;
			break;	

		default:
			return;
	}

	for ( $i = 1; $i <= $widget_areas; $i++ ) {
		register_sidebar(
			array(
				'name'          => /* translators: %s: footer area number */ sprintf( esc_html__( 'Footer area %s', 'voluto' ), $i ),
				'id'            => 'footer-' . $i,
				'description'   => esc_html__( 'Add widgets here.', 'voluto' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);	
	}		
}
add_action( 'widgets_init', 'voluto_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function voluto_scripts() {

	wp_enqueue_style( 'voluto-fonts', voluto_generate_fonts_url(), array(), VOLUTO_VERSION );

	wp_enqueue_style( 'voluto-style', get_stylesheet_uri(), array(), VOLUTO_VERSION );
	wp_style_add_data( 'voluto-style', 'rtl', 'replace' );
	
	wp_enqueue_style( 'voluto-style-min', get_template_directory_uri() . '/assets/css/styles.min.css', array(), VOLUTO_VERSION );

	wp_enqueue_script( 'voluto-custom', get_template_directory_uri() . '/assets/js/custom.min.js', array(), VOLUTO_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$layout = voluto_blog_layout();

	if ( 'masonry' === $layout ) {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-masonry');
	}
}
add_action( 'wp_enqueue_scripts', 'voluto_scripts' );

/**
 * Onboarding
 */
require get_template_directory() . '/inc/onboarding/class_voluto_install_plugins.php';
require get_template_directory() . '/inc/onboarding/class_voluto_theme_page.php';

/**
 * Admin notice
 */
require get_template_directory() . '/inc/onboarding/notices/persist-admin-notices-dismissal.php';

function voluto_welcome_admin_notice() {

	if ( ! Voluto_PAnD::is_admin_notice_active( 'voluto-welcome-forever' ) ) {
		return;
	}

	$theme = wp_get_theme();
	
	?>
	<div data-dismissible="voluto-welcome-forever" class="voluto-admin-notice notice notice-info is-dismissible">

		<h3><?php echo esc_html( /* translators: %s: theme name */ sprintf( __( 'Welcome to %s', 'voluto' ), $theme->name ) ); ?><span class="theme-version"><?php echo esc_html( $theme->version ); ?></span></h3>
		<p style="margin-bottom:20px;"><?php echo esc_html__( 'Click the button below to install our starter site plugin and import premade demos.', 'voluto' ); ?></p>
		<?php Voluto_Install_Plugins::instance()->do_plugin_install(); ?>
		<a class="button" href="<?php echo esc_url( admin_url( 'themes.php?page=voluto-theme.php' ) ); ?>"><?php esc_html_e( 'Theme Dashboard', 'voluto' ); ?></a>

	</div>
	<?php
}
add_action( 'admin_init', array( 'Voluto_PAnD', 'init' ) );
add_action( 'admin_notices', 'voluto_welcome_admin_notice' );

/**
 * Header class
 */
require_once get_template_directory() . '/inc/class-voluto-header.php';

/**
 * Footer class
 */
require_once get_template_directory() . '/inc/class-voluto-footer.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Page metabox
 */
require get_template_directory() . '/inc/class-voluto-page-metabox.php';

/**
 * Single posts and pages
 */
require get_template_directory() . '/inc/class-voluto-single-post-page.php';

/**
 * Posts loop
 */
require get_template_directory() . '/inc/class-voluto-loop-post.php';

/**
 * SVG icons
 */
require get_template_directory() . '/inc/class-voluto-svg-icons.php';

/**
 * Hero
 */
require get_template_directory() . '/inc/class-voluto-hero.php';

/**
 * Breadcrumbs
 */
require get_template_directory() . '/inc/class-voluto-breadcrumb-trail.php';

/**
 * Editor
 */
require get_template_directory() . '/inc/editor.php';
require get_template_directory() . '/inc/block-styles.php';

/**
 * Custom CSS
 */
require get_template_directory() . '/inc/custom-css.php';

/**
 * Autoloader
 */
require_once get_template_directory() . '/vendor/autoload.php';