<?php
/**
 * Store locator: the `stores` post type (archive at /store/, single at /store/<store>/), a region taxonomy,
 * ACF fields and assets. Templates: archive-stores.php and single-stores.php.
 */

function dtc_is_stores_page(): bool
{
    return is_post_type_archive('stores') || is_singular('stores');
}

function dtc_store_url(): string
{
    return get_post_type_archive_link('stores') ?: home_url('/store/');
}

/** One store as a plain array; coordinates are null when missing or out of range. */
function dtc_store_data(int $post_id): array
{
    $lat = get_field('latitude', $post_id);
    $lng = get_field('longitude', $post_id);
    $valid = is_numeric($lat) && is_numeric($lng) && abs((float) $lat) <= 90 && abs((float) $lng) <= 180;
    $regions = get_the_terms($post_id, 'store-region');
    $region = ($regions && !is_wp_error($regions)) ? $regions[0] : null;

    $services = [];
    foreach ((array) get_field('services', $post_id) as $service_id) {
        $service = get_post((int) $service_id);
        if ($service && $service->post_status === 'publish') {
            $services[] = ['slug' => $service->post_name, 'name' => $service->post_title, 'url' => get_permalink($service)];
        }
    }

    $phone = (string) get_field('phone', $post_id);
    return [
        'id'       => $post_id,
        'name'     => get_the_title($post_id),
        'url'      => get_permalink($post_id),
        'address'  => (string) get_field('address', $post_id),
        'city'     => (string) get_field('city', $post_id),
        'province' => (string) get_field('province', $post_id),
        'phone'    => $phone,
        'tel'      => preg_replace('/[^0-9+]/', '', $phone),
        'hours'    => dtc_service_lines((string) get_field('hours', $post_id)),
        'lat'      => $valid ? (float) $lat : null,
        'lng'      => $valid ? (float) $lng : null,
        'region'   => $region ? ['slug' => $region->slug, 'name' => $region->name] : null,
        'services' => $services,
    ];
}

function dtc_store_directions_url(array $store): string
{
    if ($store['lat'] === null) {
        return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode(trim($store['address'] . ' ' . $store['city']));
    }
    return 'https://www.google.com/maps/dir/?api=1&destination=' . $store['lat'] . ',' . $store['lng'];
}

function dtc_registration_store_selection(string $slug): ?array
{
    $slug = sanitize_title($slug);
    if ($slug === '') {
        return null;
    }

    $store = get_posts([
        'name' => $slug,
        'post_type' => 'stores',
        'post_status' => 'publish',
        'numberposts' => 1,
    ]);

    if ($store) {
        $province = trim((string) get_field('province', $store[0]->ID));
        return $province !== '' ? ['province' => $province, 'name' => $store[0]->post_title, 'legacy' => false] : null;
    }

    $legacyStore = get_posts([
        'name' => $slug,
        'post_type' => 'store',
        'post_status' => 'publish',
        'numberposts' => 1,
        'tax_query' => [[
            'taxonomy' => 'store_visib',
            'field' => 'slug',
            'terms' => sanitize_title('DTC'),
        ]],
    ]);
    if (! $legacyStore) {
        return null;
    }

    $province = trim((string) get_post_meta($legacyStore[0]->ID, 'ht_store_state', true));
    return $province !== '' ? ['province' => $province, 'name' => $legacyStore[0]->post_title, 'legacy' => true] : null;
}

function dtc_registration_url_for_store_slug(string $slug = ''): string
{
    $url = home_url('/register-your-tyres/');
    $slug = sanitize_title($slug);
    return dtc_is_registration_store_slug($slug) ? add_query_arg('stores', $slug, $url) : $url;
}

function dtc_registration_qr_image_url(string $registrationUrl, int $size = 220): string
{
    $size = max(100, min(600, $size));
    return 'https://api.qrserver.com/v1/create-qr-code/?size='.$size.'x'.$size.'&data='.rawurlencode($registrationUrl);
}

/** Provinces with their store names for the registration form: [province => [store name, ...]]. */
function dtc_store_register_map(): array
{
    $map = [];
    $stores = get_posts(['post_type' => 'stores', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC']);
    foreach ($stores as $store) {
        $province = trim((string) get_field('province', $store->ID));
        if ($province !== '') {
            $map[$province][] = $store->post_title;
        }
    }
    ksort($map);
    return $map;
}

add_action('pre_get_posts', function (WP_Query $query) {
    if (is_admin() || !$query->is_main_query() || !$query->is_post_type_archive('stores')) {
        return;
    }
    $query->set('posts_per_page', 100);
    $query->set('orderby', ['menu_order' => 'ASC', 'title' => 'ASC']);
});

// The templates render their own heading, so skip the theme's title banner.
add_action('wp', function () {
    if (dtc_is_stores_page()) {
        remove_action('ht_banner_before_content', 'ht_banner_before_content_func');
    }
});

add_action('wp_enqueue_scripts', function () {
    if (!dtc_is_stores_page()) {
        return;
    }
    $dir = get_template_directory();
    $uri = get_template_directory_uri();
    wp_enqueue_style('leaflet', $uri . '/css/vendor/leaflet.css', [], '1.9.4');
    wp_enqueue_style('dtc-stores', $uri . '/css/dtc-stores.css', ['leaflet'], filemtime($dir . '/css/dtc-stores.css'));
    wp_enqueue_script('leaflet', $uri . '/js/vendor/leaflet/leaflet.js', [], '1.9.4', true);
    wp_enqueue_script('dtc-stores', $uri . '/js/dtc-stores.js', ['leaflet'], filemtime($dir . '/js/dtc-stores.js'), true);
});
