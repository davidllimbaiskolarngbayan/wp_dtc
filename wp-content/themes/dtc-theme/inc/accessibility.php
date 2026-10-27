<?php
/**
 * Legal-page ACF fields and shared sidebar links.
 */

function dtc_legal_page_defaults(): array
{
    return [
        'accessibility' => ['title' => 'Accessibility', 'order' => 1],
        'privacy-policy' => ['title' => 'Privacy Policy', 'order' => 2],
        'intellectual-property' => ['title' => 'Intellectual Property', 'order' => 3],
        'terms-and-conditions' => ['title' => 'Terms & Conditions', 'order' => 4],
    ];
}

function dtc_legal_sidebar_links(int $current_page_id): array
{
    $pages = get_posts([
        'post_type' => 'page',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-legal.php',
        'orderby' => [
            'menu_order' => 'ASC',
            'ID' => 'ASC',
        ],
    ]);

    $links = [];
    foreach ($pages as $page) {
        $label = function_exists('get_field') ? get_field('dtc_legal_sidebar_label', $page->ID) : '';
        $slug = function_exists('get_field') ? get_field('dtc_legal_sidebar_slug', $page->ID) : '';
        if (!is_string($label) || trim($label) === '' || !is_string($slug) || trim($slug) === '') {
            continue;
        }

        $slug = sanitize_title($slug);
        if ($slug === '') {
            continue;
        }

        $target_page = get_page_by_path($slug);
        if (!$target_page || $target_page->post_type !== 'page' || $target_page->post_status !== 'publish') {
            continue;
        }

        $links[] = [
            'url' => get_permalink($target_page),
            'title' => trim($label),
            'current' => (int) $target_page->ID === $current_page_id,
        ];
    }

    return $links;
}

add_action('acf/include_fields', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_dtc_legal_page_sidebar',
        'title' => 'Legal Page Sidebar (Label and Link)',
        'fields' => [
            [
                'key' => 'field_dtc_legal_sidebar_label',
                'label' => 'Sidebar Label',
                'name' => 'dtc_legal_sidebar_label',
                'type' => 'text',
                'instructions' => 'Enter the short label to show in the left sidebar. The link stays hidden until this and the slug are filled.',
                'required' => 0,
                'default_value' => '',
                'placeholder' => '',
            ],
            [
                'key' => 'field_dtc_legal_sidebar_slug',
                'label' => 'Sidebar Link Slug',
                'name' => 'dtc_legal_sidebar_slug',
                'type' => 'text',
                'instructions' => 'Enter the slug of the page this label should open. The link stays hidden until this and the label are filled.',
                'required' => 0,
                'default_value' => '',
                'placeholder' => '',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-legal.php',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);
});

add_action('init', function () {
    $pages = get_posts([
        'post_type' => 'page',
        'post_status' => ['publish', 'draft', 'pending', 'private'],
        'posts_per_page' => -1,
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-legal.php',
        'orderby' => [
            'menu_order' => 'ASC',
            'ID' => 'ASC',
        ],
    ]);

    foreach ($pages as $page) {
        update_post_meta($page->ID, '_dtc_legal_sidebar_label', 'field_dtc_legal_sidebar_label');
        update_post_meta($page->ID, '_dtc_legal_sidebar_slug', 'field_dtc_legal_sidebar_slug');
    }
});

add_action('save_post_page', function ($page_id, $page) {
    if (
        wp_is_post_revision($page_id)
        || wp_is_post_autosave($page_id)
        || get_page_template_slug($page) !== 'page-legal.php'
        || (int) $page->menu_order > 0
    ) {
        return;
    }

    $pages = get_posts([
        'post_type' => 'page',
        'post_status' => ['publish', 'draft', 'pending', 'private'],
        'posts_per_page' => -1,
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-legal.php',
        'fields' => 'ids',
    ]);

    $last_order = 0;
    foreach ($pages as $existing_page_id) {
        if ((int) $existing_page_id !== (int) $page_id) {
            $last_order = max($last_order, (int) get_post_field('menu_order', $existing_page_id));
        }
    }

    wp_update_post([
        'ID' => $page_id,
        'menu_order' => $last_order + 1,
    ]);
}, 10, 2);

add_filter('wp_nav_menu_objects', function ($items, $args) {
    if (($args->theme_location ?? '') !== 'footer') {
        return $items;
    }

    return array_values(array_filter($items, static function ($item) {
        $title = strtolower(trim(wp_strip_all_tags($item->title)));
        $url_path = (string) parse_url($item->url, PHP_URL_PATH);
        $page_slug = $item->object === 'page' && $item->object_id
            ? get_post_field('post_name', (int) $item->object_id)
            : '';

        return !in_array($title, ['site map', 'sitemap', 'accessibility'], true)
            && stripos($url_path, 'sitemap') === false
            && $page_slug !== 'accessibility';
    }));
}, 10, 2);

add_action('init', function () {
    $locations = get_theme_mod('nav_menu_locations', []);
    $locations = is_array($locations) ? $locations : [];
    $header_menu_ids = array_filter([
        (int) ($locations['primary'] ?? 0),
        (int) ($locations['primary_mobile'] ?? 0),
    ]);
    $footer_menu_id = (int) ($locations['footer'] ?? 0);

    if (!$footer_menu_id || in_array($footer_menu_id, $header_menu_ids, true)) {
        $footer_menu_id = 0;
        foreach (wp_get_nav_menus() as $menu) {
            if ($menu->name === 'Footer Menu' && !in_array((int) $menu->term_id, $header_menu_ids, true)) {
                $footer_menu_id = (int) $menu->term_id;
                break;
            }
        }
    }

    if (!$footer_menu_id) {
        $footer_menu_id = wp_create_nav_menu('Footer Menu');
        if (is_wp_error($footer_menu_id)) {
            error_log('Unable to create the separate Footer Menu: ' . $footer_menu_id->get_error_message());
            return;
        }
    }

    if (!get_option('dtc_footer_menu_structure_v1')) {
        foreach (wp_get_nav_menu_items($footer_menu_id) ?: [] as $menu_item) {
            wp_delete_post($menu_item->ID, true);
        }

        $has_errors = false;
        $add_item = static function (array $item, int $parent_id = 0) use ($footer_menu_id, &$has_errors): int {
            $item['menu-item-status'] = 'publish';
            $item['menu-item-parent-id'] = $parent_id;
            $item_id = wp_update_nav_menu_item($footer_menu_id, 0, $item);
            if (is_wp_error($item_id)) {
                error_log('Unable to build the Footer Menu: ' . $item_id->get_error_message());
                $has_errors = true;
                return 0;
            }
            return (int) $item_id;
        };
        $add_page_item = static function (string $title, string $slug, string $fallback_url, int $parent_id) use ($add_item): void {
            $page = get_page_by_path($slug);
            if ($page && $page->post_status === 'publish') {
                $add_item([
                    'menu-item-title' => $title,
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $page->ID,
                    'menu-item-type' => 'post_type',
                ], $parent_id);
                return;
            }

            $add_item([
                'menu-item-title' => $title,
                'menu-item-url' => $fallback_url,
                'menu-item-type' => 'custom',
            ], $parent_id);
        };

        $company = $add_item(['menu-item-title' => 'Company', 'menu-item-url' => '#', 'menu-item-type' => 'custom']);
        $add_page_item('About us', 'about-us', home_url('/about-us/'), $company);

        $customers = $add_item(['menu-item-title' => 'For Customers', 'menu-item-url' => '#', 'menu-item-type' => 'custom']);
        $add_page_item('Check warranty', 'check-warranty', home_url('/check-warranty/'), $customers);
        $add_page_item('Register your tyres', 'register-your-tyres', home_url('/register-your-tyres/'), $customers);

        $dealers = $add_item(['menu-item-title' => 'For Dealers', 'menu-item-url' => '#', 'menu-item-type' => 'custom']);
        $contact_page = get_page_by_path('contact-us') ?: get_page_by_path('contact');
        $contact_url = $contact_page ? get_permalink($contact_page) : home_url('/contact-us/');
        $add_item([
            'menu-item-title' => 'Become a dealer',
            'menu-item-url' => $contact_url,
            'menu-item-type' => 'custom',
        ], $dealers);

        $support = $add_item(['menu-item-title' => 'Support', 'menu-item-url' => '#', 'menu-item-type' => 'custom']);
        $add_item([
            'menu-item-title' => 'Contact us',
            'menu-item-url' => $contact_url,
            'menu-item-type' => 'custom',
        ], $support);
        $stores_url = get_post_type_archive_link('stores') ?: home_url('/store/');
        $add_item([
            'menu-item-title' => 'Find a store',
            'menu-item-url' => $stores_url,
            'menu-item-type' => 'custom',
        ], $support);

        if (!$has_errors) {
            update_option('dtc_footer_menu_structure_v1', 1);
        }
    }

    $locations['footer'] = (int) $footer_menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}, 20);
