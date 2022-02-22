<?php
/**
 * Class to handle single post/page content
 *
 * @package Voluto
 */


if ( !class_exists( 'Voluto_Footer' ) ) :

	/**
	 * Voluto_Footer 
	 */
	Class Voluto_Footer {

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
			add_action( 'voluto_footer_before', array( $this, 'sidebar_cart' ) );
			add_action( 'voluto_footer', array( $this, 'before_footer' ) );
			add_action( 'voluto_footer', array( $this, 'template' ) );
		}

		/**
		 * Sidebar cart
		 */
		public function sidebar_cart() {
			if ( class_exists( 'Woocommerce' ) ) : ?>
				<div id="sidebar-cart" class="sidebar-cart">
					<div tabindex="0" class="sidebar-cart-close"><?php voluto_get_svg_icon( 'icon-cancel', true ); ?></div>
					<span>
						<?php
						$instance = array(
							'title' => esc_html__( 'Your cart', 'voluto' ),
						);
			
						the_widget( 'WC_Widget_Cart', $instance );
						?>
					</span>
				</div>	
				<div class="cart-overlay"></div>
			<?php endif;	
		}		

		/**
		 * Before footer
		 */
		public function before_footer() {
			$container 		= get_theme_mod( 'before_footer_width', 'container' );
			$type 			= get_theme_mod( 'before_footer_type', 'before_footer_cta' );

			if ( 'none' === $type ) {
				return;
			}
			?>
			<div class="before-footer">
				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="before-footer-inner">
						<?php call_user_func( array( $this, $type ) ); ?>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Before footer: Call to action
		 */
		public function before_footer_cta() {
			$title 			= get_theme_mod( 'before_footer_cta_title', esc_html__( 'Have something on your mind?', 'voluto' ) );
			$button_link 	= get_theme_mod( 'before_footer_cta_link', '#' );
			$button_text 	= get_theme_mod( 'before_footer_cta_text', esc_html__( 'Say hello', 'voluto' ) );

			?>
			<div class="before-footer-cta">
				<div class="row v-align">
					<div class="col">
						<h2><?php echo esc_html( $title ); ?></h2>
					</div>
					<div class="col">
						<a href="<?php echo esc_url( $button_link ); ?>" title="<?php echo esc_attr( $button_text ); ?>" class="button"><?php echo esc_html( $button_text ); ?></a>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Before footer: social
		 */
		public function before_footer_social() {
		
			$socials = get_theme_mod( 'before_footer_social' );

			if ( !$socials ) {
				return;
			}

			$socials = explode( ',', $socials );
	
			$items = '<div class="before-footer-social">';
			foreach ( $socials as $social ) {
				$network = voluto_get_social_network( $social );
				if ( $network ) {
					$items .= '<a target="_blank" rel="noopener noreferrer nofollow" href="' . esc_url( $social ) . '">' . voluto_get_svg_icon( 'icon-' . esc_html( $network ), false ) . ucwords( esc_html( $network ) ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
			$items .= '</div>';

			echo $items; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Before footer: HTML
		 */
		public function before_footer_html() {
			$html = get_theme_mod( 'before_footer_html' );

			echo wp_kses_post( $html );
		}	
		
		/**
		 * Before footer: shortcode
		 */
		public function before_footer_shortcode() {
			$shortcode = get_theme_mod( 'before_footer_shortcode' );

			echo do_shortcode( wp_kses_post( $shortcode ) );
		}			

		/**
		 * Footer template
		 */
		public function template() {

			$container 		= get_theme_mod( 'footer_bar_width', 'container' );
			/* translators: theme credits link */
			$footer_credits = get_theme_mod( 'footer_credits', sprintf( esc_html__( 'Powered by the %1$1s WordPress theme', 'voluto' ), '<a rel="nofollow" href="https://elfwp.com/themes/voluto">Voluto</a>' ) );
			$footer_bar_layout = get_theme_mod( 'footer_bar_layout', 'separate' );
			?>

			<footer id="colophon" class="site-footer">
				<?php get_sidebar( 'footer' ); ?>
				
				<div class="footer-bar">
					<div class="<?php echo esc_attr( $container ); ?>">
						<div class="site-info fb-<?php echo esc_attr( $footer_bar_layout ); ?>">
							<div class="row">
								<div class="col">
									<?php echo wp_kses_post( $footer_credits ); ?>
								</div>
								<div class="col">
									<?php $this->footer_social(); ?>	
								</div>
							</div>
						</div><!-- .site-info -->
					</div>
				</div>
			</footer><!-- #colophon -->
			<?php
		}

		/**
		 * Social
		 */
		public function footer_social() {
		
			$socials = get_theme_mod( 'footer_social' );

			if ( !$socials ) {
				return;
			}

			$socials = explode( ',', $socials );
	
			$items = '<div class="footer-social">';
			foreach ( $socials as $social ) {
				$network = voluto_get_social_network( $social );
				if ( $network ) {
					$items .= '<a target="_blank" rel="noopener noreferrer nofollow" href="' . esc_url( $social ) . '">' . voluto_get_svg_icon( 'icon-' . esc_html( $network ), false ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
			$items .= '</div>';

			echo $items; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}		

	}

	/**
	 * Initialize class
	 */
	Voluto_Footer::get_instance();

endif;