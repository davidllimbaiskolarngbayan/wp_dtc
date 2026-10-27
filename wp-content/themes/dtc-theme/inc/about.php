<?php
/**
 * About Us page: ACF fields for the page using template-about.php, plus its assets.
 */

function dtc_is_about_page(): bool
{
    return is_page_template('template-about.php');
}

add_action('wp', function () {
    if (dtc_is_about_page()) {
        remove_action('ht_banner_before_content', 'ht_banner_before_content_func');
    }
});

add_action('wp_enqueue_scripts', function () {
    if (!dtc_is_about_page()) {
        return;
    }
    $dir = get_template_directory();
    wp_enqueue_style('dtc-about', get_template_directory_uri() . '/css/dtc-about.css', [], filemtime($dir . '/css/dtc-about.css'));
});

