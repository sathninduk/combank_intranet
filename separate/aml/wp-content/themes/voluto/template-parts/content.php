<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Voluto
 */

$voluto_layout = voluto_blog_layout();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-content-inner">
		<?php do_action( 'voluto_post_item_before' ); ?>

		<?php if ( 'list' !== $voluto_layout && 'zigzag' !== $voluto_layout ) : ?>
			<div class="content-grid">
				<?php do_action( 'voluto_post_item_content', $voluto_layout_type = 'is-grid' ); ?>
			</div>
		<?php else : ?>
			<div class="row v-align">
				<?php if ( has_post_thumbnail() ) : ?>
				<div class="col-md-5 col-sm-5 col-12 post-thumbnail-wrapper">
					<?php $voluto_post_cats_position = get_theme_mod( 'post_cats_position', 'default' ); ?>
					<?php if ( 'absolute' === $voluto_post_cats_position ) : ?>
						<div class="post-cats"><?php voluto_entry_categories(); ?></div>
					<?php endif; ?>
					<?php voluto_post_thumbnail( 'voluto-500x500' ); ?>
				</div>	
				<div class="col-md-7 col-sm-7 col-12">
				<?php else : ?>
				<div class="col-12">
				<?php endif; ?>
					<div class="content-list">
						<?php do_action( 'voluto_post_item_content', $voluto_layout_type = 'is-list' ); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php do_action( 'voluto_post_item_after' ); ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->