<?php
/**
 * Class to handle post items on all types of archives
 *
 * @package Voluto
 */


if ( !class_exists( 'Voluto_Loop_Post' ) ) :

	/**
	 * Voluto_Loop_Post 
	 */
	Class Voluto_Loop_Post {

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
			add_action( 'voluto_post_item_content', array( $this, 'render_post_elements' ) );
			add_filter( 'voluto_posts_layout', array( $this, 'blog_layout' ) );
		}

		/**
		 * Build post item
		 */
		public function render_post_elements( $layout_type ) {

			$elements 			= get_theme_mod( 'post_item_elements', $this->get_default_elements() );
			$post_cats_position = get_theme_mod( 'post_cats_position', 'default' );

			if ( 'is-list' === $layout_type ) {
				$elements = array_diff( $elements, array( 'loop_image' ) );
			}

			if ( 'absolute' === $post_cats_position ) {
				$elements = array_diff( $elements, array( 'loop_category' ) );
			}			

			foreach( $elements as $element ) {
				call_user_func( array( $this, $element ), $layout_type );
			}
		}

		/**
		 * Default elements for the post item
		 */
		public function get_default_elements() {
			return array( 'loop_image', 'loop_category', 'loop_post_title', 'loop_post_excerpt', 'loop_post_meta' );
		}

		/**
		 * Post element: image
		 */
		public function loop_image() {

			if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
				return;
			}
			
			$hover 				= get_theme_mod( 'blog_image_hover', 'none' );
			$post_cats_position = get_theme_mod( 'post_cats_position', 'default' );

			$blog_layout = $this->blog_layout();

			if ( 'classic' === $blog_layout ) {
				$image_size = 'voluto-900x9999';
			} else {
				$image_size = 'voluto-500x9999';
			}

			?>
			<div class="post-thumbnail-wrapper">
				<?php if ( 'absolute' === $post_cats_position ) {
					$this->loop_category();
				}
				?>
				<a class="post-thumbnail effect-<?php echo esc_attr( $hover ); ?>" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">

					<?php
						the_post_thumbnail( $image_size, array(
							'alt' => the_title_attribute( array(
								'echo' => false,
							) ),
						) );					
					?>
				</a>
			</div>
			<?php
		}

		/**
		 * Post elements: read more link
		 */
		public function loop_read_more() {
			$read_more_text = get_theme_mod( 'read_more_text', esc_html__( 'Read more', 'voluto' ) );
			?>
			<a class="read-more-link" href="<?php the_permalink(); ?>"><?php echo esc_html( $read_more_text ); ?></a>
			<?php
		}

		/**
		 * Post element: title
		 */
		public function loop_post_title() {
			?>
			<header class="entry-header post-header">
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->
			<?php
		}	
		
		/**
		 * Post element: first category
		 */
		public function loop_category() {
			?>
			<div class="post-cats"><?php voluto_entry_categories(); ?></div>
			<?php
		}	
		
		/**
		 * Post element: meta
		 */
		public function loop_post_meta() {
			if ( 'post' === get_post_type() ) :

				$author = get_theme_mod( 'blog_elements_show_author', 1 );
				$date 	= get_theme_mod( 'blog_elements_show_date', 1 );
				?>
				<div class="entry-meta">
					<?php voluto_post_date_author( $author, $date ); ?>
				</div><!-- .entry-meta -->
			<?php endif;
		}	
		
		/**
		 * Post element: excerpt
		 */
		public function loop_post_excerpt( $layout_type ) {

			?>
			<div class="entry-summary">
				<?php

				the_excerpt(); 
	
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'voluto' ),
					'after'  => '</div>',
				) );
				?>
			</div><!-- .entry-content -->
			<?php
		}

		/**
		 * Blog layout
		 */
		public function blog_layout() {
			$blog_layout = get_theme_mod( 'blog_layout', 'list' );

			return $blog_layout;
		}
	}

	/**
	 * Initialize class
	 */
	Voluto_Loop_Post::get_instance();

endif;