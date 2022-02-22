<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Voluto
 */

get_header();
?>

	<?php do_action( 'voluto_single_before' ); ?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			do_action( 'voluto_post_content_before' );

			get_template_part( 'template-parts/content', 'single' );

			do_action( 'voluto_post_content_after' );

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

	<?php do_action( 'voluto_single_after' ); ?>

<?php
do_action( 'voluto_sidebar' );
get_footer();
