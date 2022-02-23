<?php
/**
 * Class to handle the header elements
 *
 * @package Voluto
 */


if ( !class_exists( 'Voluto_Header' ) ) :

	/**
	 * Voluto_Header 
	 */
	Class Voluto_Header {

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
			add_action( 'voluto_header', array( $this, 'header_markup' ) );
		}

		/**
		 * Markup for the header bars
		 */
		public function header_markup() {

			if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' ) ) {
				return;
			}
			
			global $post;

			if ( isset( $post ) ) {
				$disable_header	= get_post_meta( $post->ID, '_voluto_hide_header', true );	
				if ( $disable_header ) {
					return;
				}
			}

			//Top bar
			$enable_top_bar = get_theme_mod( 'enable_top_bar', 0 );
			if ( $enable_top_bar ) {
				$this->top_bar();
			}

			//Main header
			$header_layout	= get_theme_mod( 'main_header_layout', 'adspace' );
			call_user_func( array( $this, 'header_layout_' . $header_layout ) );

			//Mobile header
			$this->header_layout_mobile();
		}

		/**
		 * Header layout inline
		 */
		public function header_layout_inline() {
			$container 	= get_theme_mod( 'main_header_width', 'container' );
			?>

			<header id="masthead" class="site-header header-layout-inline">
				<?php do_action( 'voluto_menu_bar_inside' ); ?>
				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="row">
						<div class="col-md-3 col-8 v-align">
							<div class="site-branding">
								<?php
								the_custom_logo();
								if ( is_front_page() && is_home() ) :
									?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								else :
									?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
									<?php
								endif;
								$voluto_description = get_bloginfo( 'description', 'display' );
								if ( $voluto_description || is_customize_preview() ) :
									?>
									<p class="site-description"><?php echo $voluto_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
								<?php endif; ?>
							</div><!-- .site-branding -->
						</div>

						<div class="col-md-9 col-4 v-align">
							<?php $this->main_navigation(); ?>
							<div class="header-elements v-align align-right">
								<?php $this->header_search(); ?>
								<?php $this->header_woocommerce(); ?>
								<?php $this->header_button(); ?>
							</div>									
						</div>			
					</div>
				</div>
			</header><!-- #masthead -->
			<?php
		}

		/**
		 * Header layout centered
		 */
		public function header_layout_centered() {
			$container 		= get_theme_mod( 'main_header_width', 'container' );
			?>

			<header id="masthead" class="site-header header-layout-centered">
				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="row">
						<div class="col-md-12">
							<div class="site-branding">
								<?php
								the_custom_logo();
								if ( is_front_page() && is_home() ) :
									?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								else :
									?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
									<?php
								endif;
								$voluto_description = get_bloginfo( 'description', 'display' );
								if ( $voluto_description || is_customize_preview() ) :
									?>
									<p class="site-description"><?php echo $voluto_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
								<?php endif; ?>
							</div><!-- .site-branding -->
						</div>
					</div>
				</div>
			</header><!-- #masthead -->
			<div class="menu-bar">
				<?php do_action( 'voluto_menu_bar_inside' ); ?>
				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="row">
						<div class="col-md-12 v-align">
							<?php $this->main_navigation(); ?>
							<div class="header-elements v-align">
								<?php $this->header_search(); ?>
								<?php $this->header_woocommerce(); ?>
								<?php $this->header_button(); ?>
							</div>									
						</div>
					</div>	
				</div>			
			</div>			
			<?php
		}			

		/**
		 * Header layout width ad space
		 */
		public function header_layout_adspace() {
			$container 		= get_theme_mod( 'main_header_width', 'container' );
			$ad_target_url 	= get_theme_mod( 'header_ad_link' );
			$ad_image_src	= get_theme_mod( 'header_ad_image_src' );
			$ad_image_alt	= get_theme_mod( 'header_ad_image_alt' );
			?>

			<header id="masthead" class="site-header header-layout-adspace">
				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="row">
						<div class="col-md-4 col-8 v-align">
							<div class="site-branding">
								<?php
								the_custom_logo();
								if ( is_front_page() && is_home() ) :
									?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								else :
									?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
									<?php
								endif;
								$voluto_description = get_bloginfo( 'description', 'display' );
								if ( $voluto_description || is_customize_preview() ) :
									?>
									<p class="site-description"><?php echo $voluto_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
								<?php endif; ?>
							</div><!-- .site-branding -->
						</div>
						<div class="col-md-8">
							<?php if ( $ad_image_src ) : ?>
							<div class="header-ad">
								<a rel="nofollow" target="_blank" href="<?php echo esc_url( $ad_target_url ); ?>">
									<img alt="<?php echo esc_attr( $ad_image_alt ); ?>" src="<?php echo esc_url( $ad_image_src ); ?>"/>
								</a>
							</div>
							<?php endif; ?>	
						</div>
					</div>
				</div>
			</header><!-- #masthead -->
			<div class="menu-bar">
				<?php do_action( 'voluto_menu_bar_inside' ); ?>
				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="row">
						<div class="col-md-12 v-align">
							<?php $this->main_navigation(); ?>
							<div class="header-elements v-align align-right">
								<?php $this->header_search(); ?>
								<?php $this->header_woocommerce(); ?>
								<?php $this->header_button(); ?>
							</div>									
						</div>
					</div>	
				</div>			
			</div>			
			<?php
		}		

		/**
		 * Header layout mobile
		 */
		public function header_layout_mobile() {
			$container 		= get_theme_mod( 'main_header_width', 'container' );
			$mobile_label 	= get_theme_mod( 'mobile_menu_label' );

			?>

			<header id="mobile-header" class="mobile-header header-layout-mobile">
				<?php do_action( 'voluto_menu_bar_inside' ); ?>
				<div class="search-overlay-wrapper">
					<?php get_search_form(); ?>
				</div>
				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="row">
						<div class="col-4 v-align">
							<div class="site-branding">
								<?php
								the_custom_logo();
								if ( is_front_page() && is_home() ) :
									?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								else :
									?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
									<?php
								endif;
								$voluto_description = get_bloginfo( 'description', 'display' );
								if ( $voluto_description || is_customize_preview() ) :
									?>
									<p class="site-description"><?php echo $voluto_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
								<?php endif; ?>
							</div><!-- .site-branding -->
						</div>

						<div class="col-8 v-align">
							<?php $this->main_navigation( $mobile = true ); ?>
							<div class="header-elements v-align align-right">
								<?php $this->header_search( $mobile = true ); ?>
								<?php $this->header_woocommerce(); ?>
								<?php $this->header_button(); ?>
								<button class="menu-toggle" aria-controls="primary-menu" aria-label="<?php echo esc_attr__( 'Toggle mobile menu', 'voluto' ); ?>" aria-expanded="false" <?php echo wp_kses_post( apply_filters( 'voluto_nav_toggle_data_attrs', '' ) ); ?>><?php voluto_get_svg_icon( 'icon-bars', true ); ?><span class="menu-label"><?php echo esc_html( $mobile_label ); ?></span></button>	
							</div>									
						</div>			
					</div>
				</div>
			</header><!-- #masthead -->
			<?php
		}

		/**
		 * Top bar
		 */
		public function top_bar() {
			$container 		= get_theme_mod( 'topbar_width', 'container' );
			$top_bar_left	= get_theme_mod( 'top_bar_left', 'contact' );
			$top_bar_right	= get_theme_mod( 'top_bar_right', 'text' );
			
			?>
			<div class="top-bar">
				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="row v-align">
						<div class="col-md-6">
							<?php 
								if ( 'none' !== $top_bar_left ) {
									call_user_func( array( $this, 'topbar_' . $top_bar_left ) );
								}
							?>
						</div>
						<div class="col-md-6 column-right">
							<?php 
								if ( 'none' !== $top_bar_right ) {
									call_user_func( array( $this, 'topbar_' . $top_bar_right ) );
								}
							?>
						</div>						
					</div>	
				</div>
			</div>
			<?php
		}
		
		/**
		 * Header text
		 */
		public function topbar_text() {
			$text = get_theme_mod( 'top_bar_text', esc_html__( 'Your custom text', 'voluto' ) );

			if ( '' === $text ) {
				return;
			}

			echo '<div class="header-text">' . wp_kses_post( $text ) . '</div>';
		}

		/**
		 * Main navigation
		 */	
		public function main_navigation( $mobile = false ) {

			if ( $mobile ) {
				$nav_id = 'mobile-navigation';
			} else {
				$nav_id = 'site-navigation';
			}
			?>

			<?php if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled( 'primary-menu' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'primary-menu') ); ?>
			<?php else: ?>	
				<nav id="<?php echo esc_attr( $nav_id ); ?>" class="main-navigation" <?php echo wp_kses_post( apply_filters( 'voluto_nav_data_attrs', '' ) ); ?>>
					<div class="mobile-menu-close" tabindex="0"><?php voluto_get_svg_icon( 'icon-cancel', true ); ?></div>
					<?php
					wp_nav_menu( array(
						'theme_location' 	=> 'primary-menu',
						'menu_id'        	=> 'primary-menu',
					) );
					?>					
				</nav><!-- #site-navigation -->
			<?php endif; ?>
			<?php 
		}

		/**
		 * Top navigation
		 */	
		public function topbar_navigation() {
			?>
			<?php if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled( 'top-menu' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'top-menu') ); ?>
			<?php else: ?>				
			<nav id="top-navigation" class="top-navigation">
				<?php
				wp_nav_menu( array(
					'theme_location'=> 'top-menu',
					'menu_id'       => 'top-menu',
					'fallback_cb'	=> false,
					'depth'			=> 1
				) );
				?>
			</nav><!-- #top-navigation -->
			<?php endif; ?>
			<?php 
		}

		/**
		 * Header button
		 */
		public function header_button() {

			$enable = get_theme_mod( 'enable_header_button', 0 );

			if ( !$enable ) {
				return;
			}

			$text 	= get_theme_mod( 'header_button_text', esc_html__( 'Click here', 'voluto' ) );
			$url 	= get_theme_mod( 'header_button_url', '#' );

			echo '<a class="button header-button" href="' . esc_url( $url ) . '">' . esc_html( $text ) . '</a>';
		}

		/**
		 * WooCommerce icons
		 */		
		public function header_woocommerce() {

			if ( !class_exists( 'WooCommerce' ) ) {
				return;
			}

			$enable = get_theme_mod( 'enable_header_woocommerce', 1 );

			if ( !$enable ) {
				return;
			}			
	
			?>
			<?php echo voluto_woocommerce_header_cart(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php
		}

		/**
		 * Header social
		 */
		public function topbar_social() {
		
			$socials = get_theme_mod( 'top_bar_social' );

			if ( !$socials ) {
				return;
			}

			$socials = explode( ',', $socials );
	
			$items = '<div class="top-bar-social">';
			foreach ( $socials as $social ) {
				$network = voluto_get_social_network( $social );
				if ( $network ) {
					$items .= '<a target="_blank" rel="noopener noreferrer nofollow" href="' . esc_url( $social ) . '">' . voluto_get_svg_icon( 'icon-' . esc_html( $network ), false ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
			$items .= '</div>';

			echo $items; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Header search
		 */
		public function header_search( $mobile = false ) {
			$enable = get_theme_mod( 'enable_header_search', 1 );

			if ( !$enable ) {
				return;
			}

			if ( !$mobile ) {
			echo '<div class="search-overlay-wrapper">';
				get_search_form();
			echo '</div>';
			}

			echo '<div class="header-search-controls">';
			echo 	'<span tabindex="0" class="header-search-toggle">' . voluto_get_svg_icon( 'icon-search', false ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo 	'<span tabindex="0" class="header-search-cancel hide">' . voluto_get_svg_icon( 'icon-cancel', false ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</div>';
		}


		/**
		 * Header contact
		 */
		public function topbar_contact() {

			$phone 	= get_theme_mod( 'top_bar_contact_phone', esc_html__( '+999.999.999', 'voluto' ) );
			$email 	= get_theme_mod( 'top_bar_contact_email', esc_html__( 'office@example.org', 'voluto' ) );
			?>

			<div class="top-bar-contact">
				<?php if ( $email ) : ?>
					<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php voluto_get_svg_icon( 'icon-mail', true ); ?><?php echo esc_html( antispambot( $email ) ); ?></a>
				<?php endif; ?>
				<?php if ( $phone ) : ?>
					<a href="tel:<?php echo esc_attr( $phone ); ?>"><?php voluto_get_svg_icon( 'icon-phone', true ); ?><?php echo esc_html( $phone ); ?></a>
				<?php endif; ?>					
			</div>			

			<?php
		}

	}

	/**
	 * Initialize class
	 */
	Voluto_Header::get_instance();

endif;