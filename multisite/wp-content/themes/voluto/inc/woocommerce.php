<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Voluto
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function voluto_woocommerce_setup() {

	$single_layout = get_theme_mod( 'single_product_layout', 'default' );

	if ( 'default' === $single_layout ) {
		$gallery_size = 170;
	} else {
		$gallery_size = 800;
	}

	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 350,
			'single_image_width'    => 800,
			'gallery_thumbnail_image_width' => $gallery_size,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 4,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'voluto_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function voluto_woocommerce_scripts() {
	wp_enqueue_style( 'voluto-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.min.css', array(), VOLUTO_VERSION );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'voluto-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'voluto_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function voluto_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'voluto_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function voluto_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'voluto_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'voluto_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function voluto_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'voluto_woocommerce_wrapper_before' );

if ( ! function_exists( 'voluto_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function voluto_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'voluto_woocommerce_wrapper_after' );

/**
 * Remove sidebar, remove single product elements
 */
function voluto_woocommerce_actions() {

	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals' );
	add_action( 'woocommerce_before_cart_collaterals', 'woocommerce_cart_totals' );

	if ( is_checkout() || is_cart() || is_account_page() ) {
		add_filter( 'voluto_enable_sidebar', '__return_false' );
	}

	//Shop title
	$enable_catalog_title = get_theme_mod( 'enable_catalog_title', 1 );

	if ( !$enable_catalog_title ) {
		add_filter( 'woocommerce_show_page_title', '__return_false' );
	}

	//Results count
	$enable_catalog_results_no = get_theme_mod( 'enable_catalog_results_no', 1 );
	if ( !$enable_catalog_results_no ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	}

	//Sorting
	$enable_catalog_sorting = get_theme_mod( 'enable_catalog_sorting', 1 );
	if ( !$enable_catalog_sorting ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	}

	//Loop product price
	$enable_catalog_price = get_theme_mod( 'enable_catalog_price', 1 );
	if ( !$enable_catalog_price ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
	}

	//Loop product add to cart
	$enable_catalog_add_cart = get_theme_mod( 'enable_catalog_add_cart', 1 );
	if ( !$enable_catalog_add_cart ) {
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
	}	

	//Ratings
	$enable_catalog_ratings = get_theme_mod( 'enable_catalog_ratings', 1 );
	if ( !$enable_catalog_ratings ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	}

	//Product archives sidebar
	$shop_archive_layout = get_theme_mod( 'shop_archive_layout', 'no-sidebar' );

	if ( 'no-sidebar' == $shop_archive_layout ) {
		if ( is_shop() || is_product_category() || is_product_tag()	) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			add_filter( 'voluto_enable_sidebar', '__return_false' );
		}		
	}

	//Single products remove sidebar
	if ( is_product() ) {
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		add_filter( 'voluto_enable_sidebar', '__return_false' );
	}

	//Loop add to cart position 
	$add_to_cart_position = get_theme_mod( 'loop_add_to_cart_position', 'default' );

	if ( 'default' === $add_to_cart_position ) {
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
	}

	//Check if we need to disable breadcrumbs, related and upsell products, sku, cats
	if ( is_product() ) {
		$disable_single_product_breadcrumbs = get_theme_mod( 'disable_single_product_breadcrumbs' );
		$disable_single_product_related 	= get_theme_mod( 'disable_single_product_related' );
		$disable_single_product_upsells 	= get_theme_mod( 'disable_single_product_upsells' );
		$disable_single_product_meta 		= get_theme_mod( 'disable_single_product_meta' );
		$disable_single_product_rating 		= get_theme_mod( 'disable_single_product_rating' );

		if ( $disable_single_product_breadcrumbs ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',20 );
		}

		if ( $disable_single_product_related ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}

		if ( $disable_single_product_upsells ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		}
		
		if ( $disable_single_product_meta ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		}
		
		if ( $disable_single_product_rating ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		}		
	}

	$single_layout = get_theme_mod( 'single_product_layout', 'default' );

	if ( 'expanded' === $single_layout ) {
		remove_theme_support( 'wc-product-gallery-slider' );
		remove_theme_support( 'wc-product-gallery-zoom' );
	}	
}
add_action( 'wp', 'voluto_woocommerce_actions' );

/**
 * Wrap products results and ordering before
 */
function voluto_wrap_products_results_ordering_before() {

	echo '<div class="woocommerce-results-wrapper">';
	echo '<div class="row">';
	echo '<div class="col-12 col-sm-6">';

}
add_action( 'woocommerce_before_shop_loop', 'voluto_wrap_products_results_ordering_before', 19 );

/**
 * Add a button to toggle filters on shop archives
 */
function voluto_add_filters_button() {
	?>

	</div>
	<div class="col-12 col-sm-6 align-right">

	<?php	
}
add_action( 'woocommerce_before_shop_loop', 'voluto_add_filters_button', 22 );

/**
 * Wrap products results and ordering after
 */
function voluto_wrap_products_results_ordering_after() {

	echo '</div>';
	echo '</div>';
	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'voluto_wrap_products_results_ordering_after', 31 );

/**
 * Wrap single product gallery and summary before
 */
function voluto_single_product_wrap_before() {
	echo '<div class="single-product-top clear">';
}
add_action( 'woocommerce_before_single_product_summary', 'voluto_single_product_wrap_before', -99 );

/**
 * Wrap single product gallery and summary after
 */
function voluto_single_product_wrap_after() {
	echo '</div>';
}
add_action( 'woocommerce_after_single_product_summary', 'voluto_single_product_wrap_after', 9 );

/**
 * Wrap order review before
 */
function voluto_wrap_order_review_before() {
	echo '<div class="order-review-wrapper">';
}
add_action( 'woocommerce_checkout_before_order_review_heading', 'voluto_wrap_order_review_before', 5 );

/**
 * Wrap order review after
 */
function voluto_wrap_order_review_after() {
	echo '</div">';
}
add_action( 'woocommerce_checkout_after_order_review', 'voluto_wrap_order_review_after', 15 );

/**
 * Disable titles from Woocommerce tabs
 */
add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );
add_filter( 'woocommerce_product_description_heading', '__return_false' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'voluto_woocommerce_header_cart' ) ) {
			voluto_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'voluto_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function voluto_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		voluto_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'voluto_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'voluto_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function voluto_woocommerce_cart_link() {
		$link = '<span tabindex="0" class="cart-contents" title="' . esc_attr__( 'View your shopping cart', 'voluto' ) . '">';
		$link .= '<span class="cart-count">' . voluto_get_svg_icon( 'icon-cart', false ) . '<span class="count-number">' . esc_html( WC()->cart->get_cart_contents_count() ) . '</span></span>';
		$link .= '</span>';

		return $link;
	}
}

if ( ! function_exists( 'voluto_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function voluto_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<?php ob_start(); ?>
		<?php echo '<a class="wc-account-link d-md-none d-lg-inline-block" href="' . esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) . '" title="' . esc_html__( 'Your account', 'voluto' ) . '">' . voluto_get_svg_icon( 'icon-user', false ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		<?php if ( defined( 'YITH_WCWL' ) ) : ?>
			<a class="d-md-none d-lg-inline-block" href="<?php echo esc_url( get_permalink( get_option('yith_wcwl_wishlist_page_id') ) ); ?>"><?php voluto_get_svg_icon( 'icon-heart', true ); ?></a>
		<?php elseif ( defined( 'TINVWL_URL' ) && function_exists( 'tinv_url_wishlist_default' ) ) : ?>
			<a class="d-md-none d-lg-inline-block" href="<?php echo esc_url( tinv_url_wishlist_default() ); ?>"><?php voluto_get_svg_icon( 'icon-heart', true ); ?></a>
		<?php endif; ?>

		<div id="site-header-cart" class="site-header-cart">
			<?php echo voluto_woocommerce_cart_link();  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php
		return ob_get_clean();
	}
}


/**
 * Loop product thumbnails wrapper before
 */
function voluto_loop_thumb_wrapper_before() {
	echo '<div class="loop-thumb-wrapper">';
	echo '<div class="product-placeholder"></div>';
	woocommerce_template_loop_product_link_open(); //open product link
}
add_action( 'woocommerce_before_shop_loop_item', 'voluto_loop_thumb_wrapper_before', 11 );

/**
 * Loop product thumbnails wrapper after
 */
function voluto_loop_thumb_wrapper_after() {

	woocommerce_template_loop_product_link_close(); //close product link

	$add_to_cart_position = get_theme_mod( 'loop_add_to_cart_position', 'default' );

	if ( 'default' === $add_to_cart_position ) {
		echo '<div class="button-wrapper">';
			woocommerce_template_loop_add_to_cart();
		echo '</div>';
	}

	echo '</div>'; //close .loop-thumb-wrapper
}
add_action( 'woocommerce_before_shop_loop_item_title', 'voluto_loop_thumb_wrapper_after', 11 );

/**
 * Remove loop product actions
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

/**
 * Wrap loop product title in link before
 */
function voluto_loop_title_wrapper_before() {
	woocommerce_template_loop_product_link_open(); //open product link
}
add_action( 'woocommerce_shop_loop_item_title', 'voluto_loop_title_wrapper_before', 9 );

/**
 * Wrap loop product title in link after
 */
function voluto_loop_title_wrapper_after() {
	woocommerce_template_loop_product_link_close(); //open product link
}
add_action( 'woocommerce_shop_loop_item_title', 'voluto_loop_title_wrapper_after', 11 );

/**
 * Add product categories to product loop
 */
function voluto_loop_product_categories() {

	$enable_catalog_categories = get_theme_mod( 'enable_catalog_categories', 1 );

	if ( !$enable_catalog_categories ) {
		return;
	}

	echo '<div class="loop-product-cats">' . wc_get_product_category_list( get_the_id() ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'woocommerce_before_shop_loop_item_title', 'voluto_loop_product_categories', 15 );

/**
 * YITH quickview
 */
function voluto_filter_yith_wcqv_button() {

    global $product;
    
    $product_id = $product->get_id();

    $button = '<a href="#" class="yith-wcqv-button" data-product_id="' . esc_attr( $product_id ) . '">' . voluto_get_svg_icon( 'icon-expand', false ) . '</a>';
    return $button;
}
add_filter( 'yith_add_quick_view_button_html', 'voluto_filter_yith_wcqv_button' );