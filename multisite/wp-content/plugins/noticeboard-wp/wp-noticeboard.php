<?php
/*
Plugin Name: Noticeboard WP
Description: WordPress Noticeboard
Version: 0.1.1
Author: Astranix Technologies Pvt. Ltd.
Author URI: https://astranix.com
License: GPLv2 or later
Text Domain: noticeboard-wp
*/

include('wp-noticeboard-widget.php');

function wp_noticeboard_register_post_type()
{

    $labels = array(
        'name' => _x('Notices', 'post type general name', 'noticeboard-wp'),
        'singular_name' => _x('Notice', 'noticeboard-wp'),
        'add_new' => __('New Notice', 'post type singular name', 'noticeboard-wp'),
        'add_new_item' => __('Add New Notice', 'noticeboard-wp'),
        'edit_item' => __('Edit Notice', 'noticeboard-wp'),
        'new_item' => __('New Notice', 'noticeboard-wp'),
        'view_item' => __('View Notice', 'noticeboard-wp'),
        'search_items' => __('Search Notices', 'noticeboard-wp'),
        'not_found' => __('No Notices Found', 'noticeboard-wp'),
        'not_found_in_trash' => __('No Notices Found in Trash', 'noticeboard-wp'),
        'menu_name' => __('Notice Board','noticeboard-wp'),
        'archives' => __('Notice Archives', 'noticeboard-wp'),
    );

    $supports = array(
        'title',
        'editor',
        'excerpt',
        'custom-fields',
        'thumbnail',
        'comments',
        'revisions',
        'post-formats',
        'thumbnail',
        'author',
    );

    $args =  array(
        'labels' => $labels,
        'public' => true,
        'hierarchical' => true,
        'supports' => $supports,
        'show_ui' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'rewrite'           => ['slug' => 'notice'],
    );
    register_post_type('notice', $args);
}

function wp_noticeboard_taxonomies_notice()
{
    $labels = array(
        'name'              => _x('Notice Categories', 'taxonomy general name', 'noticeboard-wp'),
        'singular_name'     => _x('Notice Category', 'taxonomy singular name', 'noticeboard-wp'),
        'search_items'      => __('Search Notice Categories', 'noticeboard-wp'),
        'all_items'         => __('All Notice Categories', 'noticeboard-wp'),
        'parent_item'       => __('Parent Notice Category', 'noticeboard-wp'),
        'parent_item_colon' => __('Parent Notice Category:', 'noticeboard-wp'),
        'edit_item'         => __('Edit Notice Category', 'noticeboard-wp'),
        'update_item'       => __('Update Notice Category', 'noticeboard-wp'),
        'add_new_item'      => __('Add New Notice Category', 'noticeboard-wp'),
        'new_item_name'     => __('New Notice Category', 'noticeboard-wp'),
        'menu_name'         => __('Categories', 'noticeboard-wp'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'has_archive' => true,
    );
    register_taxonomy('wp_notice_category', 'notice', $args);
}


add_action('init', 'wp_noticeboard_register_post_type');
add_action('init', 'wp_noticeboard_taxonomies_notice', 0);


function wp_noticeboard_shortcode()
{

    $args = array(
        'post_type' => 'notice',
        'orderby'    => 'ID',
        'post_status' => 'publish',
        'order'    => 'DESC',
        'posts_per_page' => 5
    );
    $result = new WP_Query($args);
    if ($result->have_posts()) :
        echo '<ul>';
        while ($result->have_posts()) : $result->the_post();
?>      <li>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
        <?php
        endwhile;
        wp_reset_postdata();
    else : ?>
        <p><?php _e('Noticeboard is empty.', 'noticeboard-wp'); ?></p>
    <?php endif; ?>
<?php
}


add_shortcode('noticeboard', 'wp_noticeboard_shortcode');

function wp_noticeboard_register_widget()
{
    register_widget('WPNoticeboard_Widget');
}

add_action('widgets_init', 'wp_noticeboard_register_widget');


function wp_noticeboard_flush_rewrites()
{
    wp_noticeboard_register_post_type();
    flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
register_activation_hook(__FILE__, 'wp_noticeboard_flush_rewrites');
