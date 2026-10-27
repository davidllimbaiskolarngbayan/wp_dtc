<?php
/**
 * Auto Care: the `service` post type (archive at /services/, single at /services/<service>/),
 * its ACF fields and assets. Templates: archive-service.php and single-service.php.
 */

function dtc_is_autocare_page(): bool
{
    return is_post_type_archive('service') || is_singular('service');
}

function dtc_autocare_url(): string
{
    return get_post_type_archive_link('service') ?: home_url('/services/');
}

/** Lines of a textarea field as a clean list. */
function dtc_service_lines(string $value): array
{
    return array_values(array_filter(array_map('trim', preg_split('/\R/', $value) ?: [])));
}

/** Line icon for a service, drawn with currentColor strokes. */
function dtc_service_icon(string $slug): string
{
    $shapes = [
        'brakes'          => '<circle cx="32" cy="32" r="22"/><circle cx="32" cy="32" r="7"/><path d="M32 14v5M32 45v5M14 32h5M45 32h5M20 20l3.5 3.5M40.5 40.5L44 44M44 20l-3.5 3.5M23.5 40.5L20 44"/>',
        'wheel-alignment' => '<circle cx="32" cy="32" r="16"/><circle cx="32" cy="32" r="4"/><path d="M32 6v10M32 48v10M6 32h10M48 32h10"/>',
        'tyre-fitting'    => '<circle cx="32" cy="32" r="24"/><circle cx="32" cy="32" r="13"/><path d="M32 19v7M32 38v7M19 32h7M38 32h7"/>',
        'tyre-rotation'   => '<path d="M10 30a22 22 0 0 1 40-10"/><path d="M50 7v13H37"/><path d="M54 34a22 22 0 0 1-40 10"/><path d="M14 57V44h13"/>',
        'battery-check'   => '<rect x="6" y="20" width="52" height="30" rx="4"/><path d="M16 20v-6h9v6M39 20v-6h9v6"/><path d="M18 35h10M23 30v10M38 35h10"/>',
        'suspension-check' => '<path d="M32 5v9"/><path d="M22 14h20"/><path d="M22 18l20 6-20 6 20 6-20 6 20 6"/><path d="M22 52h20"/><path d="M32 52v7"/>',
        'oil-change'      => '<path d="M32 6C32 6 14 26 14 38a18 18 0 0 0 36 0C50 26 32 6 32 6z"/><path d="M24 40a8 8 0 0 0 8 8"/>',
        'aircon-service'  => '<path d="M32 6v52M10 19l44 26M10 45l44-26"/><path d="M26 10l6 6 6-6M26 54l6-6 6 6"/>',
        'coolant-service' => '<path d="M24 36V12a8 8 0 0 1 16 0v24a14 14 0 1 1-16 0z"/><circle cx="32" cy="46" r="5"/><path d="M32 20v22"/>',
        'car-inspection'  => '<rect x="14" y="10" width="36" height="46" rx="4"/><path d="M24 10V6h16v4"/><path d="M22 28l5 5 9-10M22 44h20"/>',
        'wipers-lights'   => '<path d="M8 46a28 28 0 0 1 48 0"/><path d="M32 46L22 20"/><path d="M12 55h40"/>',
        'transmission-service' => '<circle cx="32" cy="32" r="9"/><circle cx="32" cy="32" r="20"/><path d="M32 6v6M32 52v6M6 32h6M52 32h6M14 14l4 4M46 46l4 4M50 14l-4 4M18 46l-4 4"/>',
    ];
    $shape = $shapes[$slug] ?? '<path d="M44 8a12 12 0 0 0-11 16L10 47a5 5 0 0 0 7 7l23-23A12 12 0 0 0 56 20l-8 8-7-7 8-8a12 12 0 0 0-5-5z"/>';

    return '<svg class="dtc-auto__icon" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $shape . '</svg>';
}

add_action('pre_get_posts', function (WP_Query $query) {
    if (is_admin() || !$query->is_main_query() || !$query->is_post_type_archive('service')) {
        return;
    }
    $query->set('posts_per_page', 24);
    $query->set('orderby', ['menu_order' => 'ASC', 'title' => 'ASC']);
});

// The templates render their own heading, so skip the theme's title banner.
add_action('wp', function () {
    if (dtc_is_autocare_page()) {
        remove_action('ht_banner_before_content', 'ht_banner_before_content_func');
    }
});

add_action('wp_enqueue_scripts', function () {
    if (!dtc_is_autocare_page()) {
        return;
    }
    $dir = get_template_directory();
    $uri = get_template_directory_uri();
    wp_enqueue_style('dtc-autocare', $uri . '/css/dtc-autocare.css', [], filemtime($dir . '/css/dtc-autocare.css'));
});
