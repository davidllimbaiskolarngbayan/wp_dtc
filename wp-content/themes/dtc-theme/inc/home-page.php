<?php
/**
 * Home page support: ACF field groups and front-page assets.
 */

add_action('wp_enqueue_scripts', function () {
    if (!is_front_page()) {
        return;
    }
    $dir = get_template_directory();
    $uri = get_template_directory_uri();
    wp_enqueue_style('dtc-home', $uri . '/css/dtc-home.css', [], filemtime($dir . '/css/dtc-home.css'));
    wp_enqueue_script('dtc-home', $uri . '/js/dtc-home.js', [], filemtime($dir . '/js/dtc-home.js'), true);
});

