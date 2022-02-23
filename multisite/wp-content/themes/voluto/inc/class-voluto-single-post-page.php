<?php
/**
 * Class to handle single post/page content
 *
 * @package Voluto
 */


if ( !class_exists( 'Voluto_Single_Post_Page' ) ) :

	/**
	 * Voluto_Single_Post_Page 
	 */
	Class Voluto_Single_Post_Page {

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
			add_action( 'voluto_single_item_content', array( $this, 'entry_header' ) );
			add_action( 'voluto_single_item_content', array( $this, 'post_thumbnail' ) );
			add_action( 'voluto_single_item_content', array( $this, 'entry_content' ) );
			add_action( 'voluto_single_item_content', array( $this, 'entry_footer' ) );
			add_action( 'voluto_single_item_content', array( $this, 'sharing' ) );
			add_action( 'voluto_after_header', array( $this, 'post_banner' ), 20 );
			add_action( 'voluto_post_content_after', array( $this, 'post_navigation' ) );
			add_action( 'voluto_post_content_after', array( $this, 'author_bio' ), 20 );
			add_action( 'voluto_post_content_after', array( $this, 'related_posts' ), 30 );
			add_action( 'voluto_post_content_after', array( $this, 'post_comments' ), 40 );
		}

		/**
		 * Entry header
		 */
		public function entry_header( $align = 'left' ) {

			if ( apply_filters( 'voluto_disable_single_header', false ) ) {
				return;
			}
			
			$hide = get_post_meta( get_the_ID(), '_voluto_hide_title', true );
			if ( $hide || !is_singular() ) {
				return;
			}

			$cats = get_theme_mod( 'single_post_cats', 1 );		

			?>

			<header class="entry-header">
				<?php if ( 'post' === get_post_type() && $cats ) : ?>
				<div class="post-cats">
					<?php voluto_entry_categories(); ?>
				</div>
				<?php endif ;?>			
				<?php the_title( '<h1 class="entry-title">', '</h1>' );

				if ( 'post' === get_post_type() ) :
					$display_meta = get_theme_mod( 'single_post_meta', 1 );
					if ( $display_meta ) :
					?>
					<div class="entry-meta">
						<?php voluto_post_date_author(); ?>
					</div><!-- .entry-meta -->
					<?php endif; ?>
				<?php endif; ?>
			</header><!-- .entry-header -->			
			<?php
		}

		/**
		 * Page thumbnail
		 */
		public function post_thumbnail() {

			if ( apply_filters( 'voluto_disable_single_thumb', false ) ) {
				return;
			}			

			$hide = get_post_meta( get_the_ID(), '_voluto_hide_featured_image', true );

			if ( $hide ) {
				return;
			}

			$post_featured = get_theme_mod( 'single_post_featured', true );

			if ( ( is_single() && $post_featured ) || is_page() ) :
				if ( has_post_thumbnail() ) : ?>
				<div class="post-thumbnail">
					<?php
					the_post_thumbnail( 'voluto-900x9999', array(
						'alt' => the_title_attribute( array(
							'echo' => false,
						) ),
					) );
					?>
				</div>
				<?php endif; ?>
			<?php endif;

		}

		/**
		 * Entry content
		 */
		public function entry_content( $is_page ) {
			if ( $is_page ) : ?>
			<div class="entry-content">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'voluto' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->
			<?php else : ?>
			<div class="entry-content">
				<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'voluto' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'voluto' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->
			<?php endif;			
		}

		/**
		 * Entry footer
		 */
		public function entry_footer( $is_page ) {

			if ( $is_page ) {
				return;
			}

			$post_cats_tags = get_theme_mod( 'single_post_tags', 1 );

			if ( $post_cats_tags ) :
			?>
			<footer class="entry-footer">
				<?php voluto_entry_footer(); ?>
			</footer><!-- .entry-footer -->
			<?php
			endif;
		}

		/**
		 * Post/page banner
		 */
		public function post_banner() {

			if ( is_home() ) {
				return;
			}
			
			if ( !is_singular( 'post' ) && !is_page() ) {
				return;
			}

			$hide = get_post_meta( get_the_ID(), '_voluto_hide_title', true );

			if ( $hide ) {
				return;
			}

			$post_banner 		= get_theme_mod( 'single_post_header_layout', 'standard' );
			$page_banner 		= get_theme_mod( 'single_page_header_layout', 'standard' );
			$post_container 	= get_theme_mod( 'single_post_header_container', 'nocontainer' );
			$page_container 	= get_theme_mod( 'single_page_header_container', 'nocontainer' );

			if ( is_single() ) {
				$banner = $post_banner;
				$container = $post_container;
			} elseif ( is_page() ) {
				$banner = $page_banner;
				$container = $page_container;
			} else {
				$banner = '';
				$container = '';
			}

			$use_featured = get_theme_mod( 'single_post_header_featured', 1 );

			if ( 'standard' !== $banner ):

			//Remove the default header
			remove_action( 'voluto_single_item_content', array( $this, 'entry_header' ) );
			//Remove the thumb from the content
			if ( $use_featured ) {
				remove_action( 'voluto_single_item_content', array( $this, 'post_thumbnail' ) );
			}

			//Add the page banner instead ?>
			<div class="page-banner-container <?php echo esc_attr( $container ); ?>">
				<?php if ( $use_featured ) : ?>
				<div class="page-banner has-featured <?php echo esc_attr( $banner ); ?>">
					<?php
						the_post_thumbnail( 'full', array(
							'alt' => the_title_attribute( array(
								'echo' => false,
							) ),
						) );
					?>
					<div class="banner-overlay"></div>
					<?php else : ?>
				<div class="page-banner">		
					<?php endif; ?>		
					<div class="container">
						<?php $this->entry_header(); ?>
					</div>
				</div>
			</div>
			<?php
			endif;
		}

		/**
		 * Post navigation
		 */		
		public function post_navigation() {
			$enable = get_theme_mod( 'single_post_nav', 1 );
		
			if ( !$enable ) {
				return;
			}
		
			voluto_post_navigation();
		}	
		
		/**
		 * Post comments
		 */		
		public function post_comments() {
			$enable = get_theme_mod( 'single_post_comments', 1 );
		
			if ( !$enable ) {
				return;
			}			
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;			
		}

		/**
		 * Author bio
		 */
		public function author_bio() {
			$enable = get_theme_mod( 'single_post_author_box', 1 );
		
			if ( !$enable ) {
				return;
			}		
			?>
			<div class="voluto-author-bio">
				<div class="row">
					<div class="col-2">
						<div class="author-avatar vcard">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 96 ); ?>
						</div>
					</div>
					<div class="col-10">
						<span class="author-about"><?php echo esc_html__( 'About the author', 'voluto' ); ?></span>
						<h3 class="author-name">
							<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php echo esc_html( get_the_author() ); ?>
							</a>
						</h3>
						<div class="author-description">
							<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
						</div><!-- .author-description -->						
					</div>
				</div>	
			</div><!-- .author-bio -->
			<?php
		}

		/**
		 * Post sharing
		 */
		public function sharing() {
			if ( !is_single() ) {
				return;
			}

			voluto_post_sharing_links();
		}

		/**
		 * Related posts
		 */
		public function related_posts() {
			$enable = get_theme_mod( 'single_post_related_box', 1 );
		
			if ( !$enable ) {
				return;
			}	
			
			$cols 	= get_theme_mod( 'related_posts_columns', 'col-md-4' );
			$number = get_theme_mod( 'related_posts_number', 3 );

			$author 	= get_theme_mod( 'related_posts_show_author', 0 );
			$date 		= get_theme_mod( 'related_posts_show_date', 0 );
			$excerpt 	= get_theme_mod( 'related_posts_show_excerpt', 0 );
			$title 		= get_theme_mod( 'related_posts_title', esc_html__( 'Related posts', 'voluto' ) );

			$id 		= get_the_ID();
			$cat_ids 	= array();
			$cats 		= get_the_category( $id );

			if(	!empty( $cats ) && !is_wp_error( $cats ) ):
				foreach ( $cats as $cat ):
					$cat_ids[] = $cat->term_id;
				endforeach;
			endif;

			$args = array( 
				'category__in'   	=> $cat_ids,
				'post__not_in'    	=> array( $id ),
				'posts_per_page'  	=> $number,
			 );
		
			$related = new WP_Query( $args );		
			
			if ( !$related->have_posts() ) {
				return;
			}
			?>
			<div class="voluto-related">
				<h3><?php echo esc_html( $title ); ?></h3>
				<div class="voluto-related-inner">
					<div class="row">
					<?php while( $related->have_posts() ): $related->the_post(); ?>
						<div class="related-post <?php echo esc_attr( $cols ); ?>">
							<div class="row v-align">
								<?php if ( has_post_thumbnail() ) : ?>
									<a class="post-thumbnail col-4 col-md-12" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
										<?php
											the_post_thumbnail( 'voluto-500x500', array(
												'alt' => the_title_attribute( array(
													'echo' => false,
												) ),
											) );					
										?>		
									</a>			
								<?php endif; ?>		
								<div class="col-8 col-md-12">		
									<?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>

									<?php if ( $author || $date ) : ?>
									<div class="entry-meta">
										<?php voluto_post_date_author( $author, $date ); ?>
									</div>
									<?php endif; ?>

									<?php if ( $excerpt ) : ?>
									<div class="entry-summary">
										<?php the_excerpt(); ?>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
					</div>
				</div>
			</div>
			<?php
			wp_reset_postdata();
		}
	}

	/**
	 * Initialize class
	 */
	Voluto_Single_Post_Page::get_instance();

endif;