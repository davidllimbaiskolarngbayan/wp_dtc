<?php

// Bridge between this theme (copied from the original DTC site) and the DTC Laravel API.

if (! function_exists('dtc_theme_api_url')) {
    function dtc_theme_api_url(string $path): string
    {
        return rtrim(DTC_API_URL, '/') . '/' . ltrim($path, '/');
    }
}

if (! function_exists('dtc_wfa_market_locale')) {
    function dtc_wfa_market_locale(): string
    {
        return defined('DTC_WFA_LOCALE') ? sanitize_key(DTC_WFA_LOCALE) : 'ph';
    }
}

// Authenticate server-to-server requests to the DTC Laravel API.
add_filter('http_request_args', function ($args, $url) {
    if (defined('DTC_API_URL') && defined('DTC_API_KEY') && strpos($url, DTC_API_URL) === 0) {
        $args['headers'] = (array) ($args['headers'] ?? []);
        $args['headers']['X-DTC-Key'] = DTC_API_KEY;
        $args['headers']['Accept'] = 'application/json';

        if (defined('DTC_API_CA_CERT')) {
            $args['sslcertificates'] = DTC_API_CA_CERT;
        }
    }

    return $args;
}, 10, 2);

// Footer styles load last so they win over the inherited stylesheets.
add_action('wp_enqueue_scripts', function () {
    if (is_page('register-your-tyres')) {
        wp_enqueue_script('dtc-card-live', get_template_directory_uri() . '/js/ajax/dtc-card-live.js', ['jquery', 'dtc_form_script'], filemtime(get_template_directory() . '/js/ajax/dtc-card-live.js'), true);
        wp_enqueue_script('dtc-register-sizes', get_template_directory_uri() . '/js/dtc-register-sizes.js', ['jquery', 'dtc_form_script'], filemtime(get_template_directory() . '/js/dtc-register-sizes.js'), true);
        wp_enqueue_script('dtc-register-stores', get_template_directory_uri() . '/js/dtc-register-stores.js', [], filemtime(get_template_directory() . '/js/dtc-register-stores.js'), true);
    }
}, 99);
add_action('wp_enqueue_scripts', function () {
    if (is_page('contact-us') || is_page('contact')) {
        wp_enqueue_style('dtc-contact', get_template_directory_uri() . '/css/dtc-contact.css', [], filemtime(get_template_directory() . '/css/dtc-contact.css'));
        wp_enqueue_script('dtc-contact', get_template_directory_uri() . '/js/dtc-contact.js', [], filemtime(get_template_directory() . '/js/dtc-contact.js'), true);
    }
    wp_enqueue_style('dtc-footer', get_template_directory_uri() . '/css/dtc-footer.css', [], filemtime(get_template_directory() . '/css/dtc-footer.css'));
    wp_enqueue_script('dtc-menu', get_template_directory_uri() . '/js/dtc-menu.js', [], filemtime(get_template_directory() . '/js/dtc-menu.js'), true);
    wp_enqueue_style('dtc-menu', get_template_directory_uri() . '/css/dtc-menu.css', [], filemtime(get_template_directory() . '/css/dtc-menu.css'));
    wp_enqueue_style('dtc-header', get_template_directory_uri() . '/css/dtc-header.css', [], filemtime(get_template_directory() . '/css/dtc-header.css'));
}, 99);

// Registered late (init 99) so these win over any page builder element using the same shortcode names.
add_action('init', function () {
    add_shortcode('ht_dtc_register_form', function ($atts) {
        $atts = shortcode_atts(['ht_tyres_category' => '', 'ht_dtc_tyres' => ''], $atts);
        $storeSlug = isset($_GET['stores']) ? sanitize_title(wp_unslash($_GET['stores'])) : '';
        $storeSelection = $storeSlug !== '' ? dtc_registration_store_selection($storeSlug) : null;
        if (! $storeSelection) {
            $storeSlug = '';
        }

        wp_enqueue_style('dtc-register', get_template_directory_uri() . '/css/dtc-register.css', [], filemtime(get_template_directory() . '/css/dtc-register.css'));
        wp_enqueue_script('dtc-promo-registration', get_template_directory_uri() . '/js/dtc-promo-registration.js', [], filemtime(get_template_directory() . '/js/dtc-promo-registration.js'), true);
        wp_localize_script('dtc-promo-registration', 'dtcPromoRegistration', dtc_efuel_promo_settings());

        $models = [];
        foreach (get_posts(['post_type' => 'tyres', 'post_status' => ['publish', 'draft'], 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC']) as $tyre) {
            $models[$tyre->ID] = $tyre->post_title;
        }
        $atts['ht_dtc_tyres'] = implode(',', array_keys($models));

        return hatt()->load_template('dtc/register-form', 'element', [
            'data' => $atts,
            'content' => '',
            'store_slug' => ! empty($storeSelection['legacy']) ? $storeSlug : '',
            'dropdowns' => ['vehicle_options' => '', 'product_model' => $models, 'size_map' => dtc_tyre_size_map(array_keys($models)), 'store_map' => dtc_store_register_map(), 'registration_store' => $storeSelection],
        ]);
    });

    add_shortcode('ht_dtc_register_check_form', function () {
        wp_enqueue_style('dtc-check', get_template_directory_uri() . '/css/dtc-check.css', [], filemtime(get_template_directory() . '/css/dtc-check.css'));

        return hatt()->load_template('dtc/check-form', 'element', ['content' => '']);
    });
}, 99);

// Custom page headings replace the theme's standard breadcrumb banner.
add_action('wp', function () {
    if (is_page('check-warranty') || is_page('register-your-tyres') || is_page('warranty-guide') || is_page('contact-us') || is_page('contact') || is_page_template('page-legal.php')) {
        remove_action('ht_banner_before_content', 'ht_banner_before_content_func');
    }
});
add_filter('body_class', function (array $classes): array {
    if (is_page('contact-us') || is_page('contact')) {
        $classes[] = 'dtc-contact-page';
    }
    if (is_page('check-warranty')) {
        $classes[] = 'dtc-check-page';
    }
    if (is_page_template('page-legal.php')) {
        $classes[] = 'dtc-legal-page-view';
    }
    return $classes;
});

// Create missing legal pages without content; page copy is edited in the WordPress editor.
add_action('init', function () {
    $legacy_accessibility_pages = get_posts([
        'post_type' => 'page',
        'post_status' => ['publish', 'draft', 'pending', 'private'],
        'posts_per_page' => -1,
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-accessibility.php',
    ]);
    foreach ($legacy_accessibility_pages as $legacy_page) {
        update_post_meta($legacy_page->ID, '_wp_page_template', 'page-legal.php');
    }

    $legal_page_order = 1;
    foreach (dtc_legal_page_defaults() as $slug => $page_data) {
        $page = get_page_by_path($slug);
        if (!$page) {
            $page_id = wp_insert_post([
                'post_title' => $page_data['title'],
                'post_name' => $slug,
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'page',
                'menu_order' => $page_data['order'],
            ], true);

            if (is_wp_error($page_id)) {
                error_log('Unable to create the ' . $page_data['title'] . ' page: ' . $page_id->get_error_message());
                continue;
            }

            $page = get_post($page_id);
        }

        if ($page) {
            if (get_page_template_slug($page) !== 'page-legal.php') {
                update_post_meta($page->ID, '_wp_page_template', 'page-legal.php');
            }
            update_post_meta($page->ID, '_dtc_legal_sidebar_label', 'field_dtc_legal_sidebar_label');
            update_post_meta($page->ID, '_dtc_legal_sidebar_slug', 'field_dtc_legal_sidebar_slug');
            if ((int) $page->menu_order === 0) {
                wp_update_post([
                    'ID' => $page->ID,
                    'menu_order' => $page_data['order'],
                ]);
            }
        }
    }
});

// On first activation, create the two pages the DTC scripts are enqueued for, plus sample tyres to pick from.
add_action('after_switch_theme', function () {
    $pages = [
        'register-your-tyres' => ['Register Your Tyres', '[ht_dtc_register_form]'],
        'check-warranty' => ['Check Warranty', '[ht_dtc_register_check_form]'],
    ];
    foreach ($pages as $slug => [$title, $content]) {
        if (! get_page_by_path($slug)) {
            wp_insert_post(['post_title' => $title, 'post_name' => $slug, 'post_content' => $content, 'post_status' => 'publish', 'post_type' => 'page']);
        }
    }
    foreach (dtc_legal_page_defaults() as $slug => $page_data) {
        if (!get_page_by_path($slug)) {
            wp_insert_post([
                'post_title' => $page_data['title'],
                'post_name' => $slug,
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'page',
                'menu_order' => $page_data['order'],
                'meta_input' => [
                    '_wp_page_template' => 'page-legal.php',
                    '_dtc_legal_sidebar_label' => 'field_dtc_legal_sidebar_label',
                    '_dtc_legal_sidebar_slug' => 'field_dtc_legal_sidebar_slug',
                ],
            ]);
        }
    }

    if (! get_posts(['post_type' => 'tyres', 'post_status' => 'any', 'numberposts' => 1])) {
        foreach (['Sample Tyre A', 'Sample Tyre B', 'Sample Tyre C'] as $title) {
            wp_insert_post(['post_title' => $title, 'post_excerpt' => 'Sample product - replace under Tyres in the admin.', 'post_status' => 'publish', 'post_type' => 'tyres']);
        }
    }
});
