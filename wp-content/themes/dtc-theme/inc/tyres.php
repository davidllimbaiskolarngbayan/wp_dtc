<?php
/**
 * Tyre catalogue (modelled on the AU brandsite): taxonomies, spec post type, ACF fields,
 * archive filtering and assets. Products use the existing `tyres` post type.
 */

/** Terms ordered by their ACF display_order, then name. */
function dtc_ordered_terms(string $taxonomy): array
{
    $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);
    if (is_wp_error($terms)) {
        return [];
    }
    $order = static fn ($term): int => (int) get_term_meta($term->term_id, 'display_order', true) ?: 999;
    usort($terms, static fn ($a, $b): int => [$order($a), $a->name] <=> [$order($b), $b->name]);
    return $terms;
}

/** Turns "205/55R16", "205-55" or "205" into the matching tyre_size term slug. */
function dtc_tyre_size_slug(string $raw): string
{
    $raw = strtoupper(preg_replace('/\s+/', '', $raw));
    if (!preg_match('/^(\d{3})(?:[\/-](\d{2})(?:[R\/-]+(\d{2}))?)?$/', $raw, $m)) {
        return '';
    }
    return implode('-', array_slice($m, 1));
}

function dtc_tyre_image_url(int $post_id, string $size = 'large'): string
{
    $thumb = get_the_post_thumbnail_url($post_id, $size);
    if ($thumb) {
        return $thumb;
    }
    $gallery = get_field('photo_gallery', $post_id);
    foreach (['angled', 'tread', 'rim'] as $key) {
        if (!empty($gallery[$key])) {
            $url = wp_get_attachment_image_url($gallery[$key], $size);
            if ($url) {
                return $url;
            }
        }
    }
    return '';
}

function dtc_is_tyre_page(): bool
{
    return is_post_type_archive('tyres') || is_singular('tyres')
        || is_tax(['tyre-type', 'tyre-family', 'tyre-feature', 'tyre_size']);
}

// The tyre templates render their own heading, so skip the theme's title banner.
add_action('wp', function () {
    if (dtc_is_tyre_page()) {
        remove_action('ht_banner_before_content', 'ht_banner_before_content_func');
    }
});

add_action('pre_get_posts', function (WP_Query $query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }
    if (!$query->is_post_type_archive('tyres') && !$query->is_tax(['tyre-type', 'tyre-family', 'tyre-feature', 'tyre_size'])) {
        return;
    }

    $query->set('posts_per_page', 12);

    $sorts = ['az' => ['title', 'ASC'], 'za' => ['title', 'DESC'], 'new' => ['date', 'DESC']];
    $sort = isset($_GET['sort']) ? sanitize_key(wp_unslash($_GET['sort'])) : 'az';
    [$orderby, $order] = $sorts[$sort] ?? $sorts['az'];
    $query->set('orderby', $orderby);
    $query->set('order', $order);

    $tax_query = (array) $query->get('tax_query');
    $features = isset($_GET['feature']) ? array_map('sanitize_title', (array) wp_unslash($_GET['feature'])) : [];
    foreach (array_filter($features) as $feature) {
        $tax_query[] = ['taxonomy' => 'tyre-feature', 'field' => 'slug', 'terms' => $feature];
    }
    $family = isset($_GET['family']) ? sanitize_title(wp_unslash($_GET['family'])) : '';
    if ($family) {
        $tax_query[] = ['taxonomy' => 'tyre-family', 'field' => 'slug', 'terms' => $family];
    }
    $size = isset($_GET['fit']) ? dtc_tyre_size_slug(sanitize_text_field(wp_unslash($_GET['fit']))) : '';
    if ($size) {
        $tax_query[] = ['taxonomy' => 'tyre_size', 'field' => 'slug', 'terms' => $size];
    }
    if ($tax_query) {
        $query->set('tax_query', $tax_query);
    }

    $search = isset($_GET['q']) ? sanitize_text_field(wp_unslash($_GET['q'])) : '';
    if ($search !== '') {
        $query->set('s', $search);
    }
});

add_action('wp_enqueue_scripts', function () {
    if (!dtc_is_tyre_page()) {
        return;
    }
    $dir = get_template_directory();
    $uri = get_template_directory_uri();
    wp_enqueue_style('dtc-tyres', $uri . '/css/dtc-tyres.css', [], filemtime($dir . '/css/dtc-tyres.css'));
    wp_enqueue_script('dtc-tyres', $uri . '/js/dtc-tyres.js', [], filemtime($dir . '/js/dtc-tyres.js'), true);
});

