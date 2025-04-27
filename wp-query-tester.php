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

function wp_query_tester_menu() {
    add_menu_page(
        'WP_Query Tester',
        'WP_Query Tester',
        'manage_options',
        'wp-query-tester',
        'wp_query_tester_admin_page',
        'dashicons-database-view',
        100
    );
}
add_action('admin_menu', 'wp_query_tester_menu');

function wp_query_tester_admin_page() {
    echo '<div class="wrap">';
    echo '<h1>WP_Query Tester</h1>';

    ob_start();
    echo '<h2>WP_Query Tester Results</h2>';

    echo '<h3>Query 1: All Posts</h3>';
    $query1 = new WP_Query(array(
        'posts_per_page' => -1,
    ));
    display_query_results($query1);

    echo '<h3>Query 2: All Posts (Don\'t Ignore Sticky Posts)</h3>';
    $query2 = new WP_Query(array(
        'posts_per_page' => -1,
        'ignore_sticky_posts' => 0
    ));
    display_query_results($query2);

    echo '</div>';
}
?>
