<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Voluto
 */

if ( ! function_exists( 'voluto_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function voluto_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'voluto_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function voluto_posted_by() {
		$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'voluto_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function voluto_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', '' );
			if ( $tags_list ) {
				echo '<span class="tags-links">' . $tags_list . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'voluto' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'voluto_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function voluto_post_thumbnail( $size ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>
			<?php $hover = get_theme_mod( 'blog_image_hover', 'none' ); ?>

			<a class="post-thumbnail effect-<?php echo esc_attr( $hover ); ?>" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail( $size, array(
						'alt' => the_title_attribute( array(
							'echo' => false,
						) ),
					) );
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	// phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedFunctionFound
	function wp_body_open() {
		do_action( 'wp_body_open' ); // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedHooknameFound
	}
endif;

if ( ! function_exists( 'voluto_entry_categories' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function voluto_entry_categories() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			global $post;
			$post_categories 	= wp_get_post_categories( $post->ID );
			$post_cats_style 	= get_theme_mod( 'post_cats_style', 'solid' );

			echo '<span class="cat-links">';
			foreach ( $post_categories as $c ) {
				$color 	= get_term_meta( $c, '_voluto_pro_category_color', true );
				$cat 	= get_category( $c );
				
				$custom_color = '';

				if ( '' !== $color ) {
					if ( 'link' === $post_cats_style ) {
						$custom_color = 'class="has-cat-color has-link-cat"';
					} else {
						$custom_color = 'class="has-cat-color"';
					}
					$custom_color .= 'style="--cat-color:#' . $color . ';" ';
				}

				echo '<a ' . $custom_color . 'href="' . esc_url( get_category_link( $c ) ) . '" rel="category tag">' . esc_html( $cat->name ) . '</a>';
			}
			echo '</span>';

		}
	}
endif;

if ( ! function_exists( 'voluto_post_date_author' ) ) :
	function voluto_post_date_author( $author = true, $date = true ) {
		global $post;

		$has_author = 'has-author';

		if ( 'post' === get_post_type() ) {
			$author_id = $post->post_author;

			$byline = '<span class="author vcard">' . '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author_id ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name', $author_id ) ) . '</a></span>';
			
			if ( $author ) {
				echo 	get_avatar( get_the_author_meta( 'email', $author_id ) , 22 );
			} else {
				$has_author = 'author-hidden';
			}
			echo 	'<div class="post-data-text ' . esc_attr( $has_author ) . '">';
						do_action( 'voluto_entry_meta_inner_start' );
						if ( $author ) {
			echo 			'<div class="byline"> ' . $byline . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						if ( $date ) {
							voluto_posted_on();
						}
						do_action( 'voluto_entry_meta_inner_end' );
			echo 	'</div>';
		}
	}
endif;

if ( ! function_exists( 'voluto_posts_navigation' ) ) :
	/**
	 * Posts navigation
	 */
	function voluto_posts_navigation() {

		$type = get_theme_mod( 'posts_navigation', 'pagination' );

		if ( 'pagination' === $type || 'button' === $type ) {
			the_posts_pagination( 
				array( 
					'mid_size' => 1,
					'prev_text' => '&lt;',
					'next_text' => '&gt;', 
				)
			);
		} elseif ( 'navigation' === $type ) {
			the_posts_navigation();
		}
	}
endif;

if ( ! function_exists( 'voluto_entry_comments' ) ) :
	/**
	 * Meta information for comments
	 */
	function voluto_entry_comments() {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( voluto_get_svg_icon( 'icon-comment', false ) . esc_html__( '0', 'voluto' ), voluto_get_svg_icon( 'icon-comment', false ) . esc_html__( '1', 'voluto' ), voluto_get_svg_icon( 'icon-comment', false ) . esc_html__( '%', 'voluto' ) );
			echo '</span>';
		}		
	}
endif;

if ( ! function_exists( 'voluto_post_cats' ) ) :
	/**
	 * Prints HTML with meta information for the categories
	 */
	function voluto_post_cats() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( ' ' );
			if ( $categories_list ) {
				echo '<span class="cat-links">' . $categories_list . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif;

if ( ! function_exists( 'voluto_post_navigation' ) ) {
	function voluto_post_navigation() {
		//Get previous and next posts and their respective thumbnails
		$voluto_previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$voluto_next     = get_adjacent_post( false, '', false );

		if ( ! $voluto_next && ! $voluto_previous ) {
			return;
		}

		$voluto_prev_post = get_previous_post();
		if ( $voluto_prev_post ) {
			$voluto_prev_thumbnail = get_the_post_thumbnail( $voluto_prev_post->ID, 'thumbnail' );
		} else {
			$voluto_prev_thumbnail = '';
		}
		$voluto_next_post = get_next_post();
		if ( $voluto_next_post ) {
			$voluto_next_thumbnail = get_the_post_thumbnail( $voluto_next_post->ID, 'thumbnail' );
		} else {
			$voluto_next_thumbnail ='';
		}
		if ( $voluto_prev_thumbnail ) {
			$voluto_has_prev_thumb = 'has-thumb';
		} else {
			$voluto_has_prev_thumb = '';
		}
		if ( $voluto_next_thumbnail ) {
			$voluto_has_next_thmb = 'has-thumb';
		} else {
			$voluto_has_next_thmb = '';
		}
	?>

	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'voluto' ); ?></h2>
		<div class="nav-links row">
			<?php	
				if ( get_previous_post() ) {
					echo '<div class="col-12 col-md-6 nav-previous ' . esc_attr( $voluto_has_prev_thumb ) . '">';
						echo '<div class="row v-align">';
							if ( $voluto_prev_thumbnail ) {
								echo '<div class="col-3">' . $voluto_prev_thumbnail . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							}
							echo '<div class="col-9">';
								echo '<div class="post-nav-label">' . esc_html__( 'Previous article', 'voluto' ) . '</div>';
								previous_post_link( '%link', '<h4>%title</h4>' );
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
				if ( get_next_post() ) {
					echo '<div class="col-12 col-md-6 nav-next ' . esc_attr( $voluto_has_next_thmb ) . '">';
						echo '<div class="row v-align">';
						echo '<div class="col-9">';
							echo '<div class="post-nav-label">' . esc_html__( 'Next article', 'voluto' ) . '</div>';
							next_post_link( '%link', '<h4>%title</h4>' );
						echo '</div>';
						if ( $voluto_next_thumbnail ) {
							echo '<div class="col-3">' . $voluto_next_thumbnail . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						echo '</div>';
					echo '</div>';
				}
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
	}
}