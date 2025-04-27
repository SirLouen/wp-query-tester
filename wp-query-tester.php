<?php
/*
Plugin Name: WP_Query Tester
Description: A plugin to test different WP_Query parameters and display results.
Version: 1.0.0
Author: SirLouen <sir.louen@gmail.com>
License: GPL-2.0+
Text Domain: wp-query-tester
*/

function display_query_results($query) {
    if ($query->have_posts()) {
        echo '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<li>' . get_the_ID() . ' => ' . get_the_title() . ' => ' . get_the_author() . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No posts found for this query.</p>';
    }
    wp_reset_postdata();
}

function wp_query_tester_shortcode() {
    ob_start();
    echo '<div class="wrap">';
    echo '<h1>WP_Query Tester</h1>';   
    echo '<h2>WP_Query Tester Results</h2>';

    echo '<h3>Query 1: All Posts</h3>';
    $query1 = new WP_Query(array(
        'posts_per_page' => -1,
    ));
    display_query_results($query1);

    echo '<h3>Query 2: All Posts (Ignore Sticky Posts)</h3>';
    $query2 = new WP_Query(array(
        'posts_per_page' => -1,
        'ignore_sticky_posts' => 1
    ));
    display_query_results($query2);

    echo '<h3>Query 3: Author 1</h3>';
    $query3 = new WP_Query(array(
        'posts_per_page' => -1,
        'author__in' => array(1)
    ));
    display_query_results($query3);

    echo '<h3>Query 4: Slug</h3>';
    $query4 = new WP_Query(array(
        'posts_per_page' => -1,
        'post_name__in'=> array ('not-sticky-1'),
    ));
    display_query_results($query4);

    echo '</div>';
    return ob_get_clean();

}

add_shortcode('wp_query_tester', 'wp_query_tester_shortcode');

