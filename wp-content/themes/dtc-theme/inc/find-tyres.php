<?php
/**
 * "Find Tyres" page: choose width / aspect ratio / rim from the sizes that have tyres,
 * then list the matching tyres below the form. Template: template-find-tyres.php.
 */

function dtc_find_tyres_url(): string
{
    $page = get_page_by_path('find-tyres');
    return $page ? get_permalink($page) : home_url('/find-tyres/');
}

function dtc_is_find_tyres_page(): bool
{
    return is_page_template('template-find-tyres.php');
}

/** Sizes that have at least one tyre, as [width => [ratio => [rim, ...]]], sorted ascending. */
function dtc_find_tyres_sizes(): array
{
    $slugs = get_terms(['taxonomy' => 'tyre_size', 'hide_empty' => true, 'fields' => 'slugs']);
    if (is_wp_error($slugs)) {
        return [];
    }
    $sizes = [];
    foreach ($slugs as $slug) {
        if (preg_match('/^(\d{3})-(\d{2})-(\d{2})$/', $slug, $m)) {
            $sizes[(int) $m[1]][(int) $m[2]][] = (int) $m[3];
        }
    }
    ksort($sizes);
    foreach ($sizes as &$ratios) {
        ksort($ratios);
        foreach ($ratios as &$rims) {
            sort($rims);
        }
        unset($rims);
    }
    unset($ratios);
    return $sizes;
}

/** Reads width/ratio/rim from the query string; a value is 0 unless it exists in $sizes. */
function dtc_find_tyres_selection(array $sizes): array
{
    $read = static fn (string $key): int => isset($_GET[$key]) ? absint(wp_unslash($_GET[$key])) : 0;
    $width = $read('width');
    $ratio = $read('ratio');
    $rim   = $read('rim');

    if (!isset($sizes[$width])) {
        return ['width' => 0, 'ratio' => 0, 'rim' => 0];
    }
    if (!isset($sizes[$width][$ratio])) {
        return ['width' => $width, 'ratio' => 0, 'rim' => 0];
    }
    if (!in_array($rim, $sizes[$width][$ratio], true)) {
        return ['width' => $width, 'ratio' => $ratio, 'rim' => 0];
    }
    return ['width' => $width, 'ratio' => $ratio, 'rim' => $rim];
}

/**
 * Sizes per tyre for the registration form, as [tyre_id => ['205/55' => [16, 17]]].
 * A tyre with no sizes yet falls back to every catalogue size so it can still be registered.
 */
function dtc_tyre_size_map(array $tyre_ids): array
{
    $map = array_fill_keys($tyre_ids, []);
    if (!$tyre_ids) {
        return $map;
    }

    $add = static function (array &$sizes, string $slug): void {
        if (preg_match('/^(\d{3})-(\d{2})-(\d{2})$/', $slug, $m)) {
            $sizes["{$m[1]}/{$m[2]}"][] = (int) $m[3];
        }
    };

    $terms = wp_get_object_terms($tyre_ids, 'tyre_size', ['fields' => 'all_with_object_id']);
    foreach (is_wp_error($terms) ? [] : $terms as $term) {
        $add($map[(int) $term->object_id], $term->slug);
    }

    $all = [];
    foreach (dtc_find_tyres_sizes() as $width => $ratios) {
        foreach ($ratios as $ratio => $rims) {
            $all["$width/$ratio"] = $rims;
        }
    }

    foreach ($map as $id => $sizes) {
        $map[$id] = $sizes ?: $all;
        ksort($map[$id], SORT_NATURAL);
        foreach ($map[$id] as &$rims) {
            $rims = array_values(array_unique($rims));
            sort($rims);
        }
        unset($rims);
    }
    return $map;
}

/** Round tyre illustration with the size code (205/55 R16) laid along the sidewall and numbered callouts. */
function dtc_tyre_illustration_svg(): string
{
    $c = 240;
    $radius = 134;
    $gap = 7;
    // [text, width, fill, callout number]
    $parts = [['205', 62, '#fbbd00', 1], ['/', 18, '#ffffff', 0], ['55', 44, '#ffffff', 2], ['R', 24, '#ffffff', 0], ['16', 44, '#ffffff', 3]];

    $offset = -(array_sum(array_column($parts, 1)) + $gap * (count($parts) - 1)) / 2;
    $text = '';
    $callouts = '';
    foreach ($parts as [$label, $width, $fill, $number]) {
        $theta = ($offset + $width / 2) / $radius;
        $text .= sprintf(
            '<text transform="translate(%.1f %.1f) rotate(%.2f)" text-anchor="middle" textLength="%d" lengthAdjust="spacingAndGlyphs" font-size="30" fill="%s">%s</text>',
            $c + $radius * sin($theta), $c - $radius * cos($theta), rad2deg($theta), $width, $fill, esc_html($label)
        );
        if ($number) {
            $callouts .= sprintf(
                '<line x1="%.1f" y1="%.1f" x2="%.1f" y2="%.1f" stroke="#0b2a63" stroke-width="2"/><g transform="translate(%.1f %.1f)"><circle r="14" fill="#0b2a63"/><text y="5" text-anchor="middle" font-size="15" font-weight="700" fill="#fff" font-family="Arial, Helvetica, sans-serif">%d</text></g>',
                $c + 156 * sin($theta), $c - 156 * cos($theta), $c + 204 * sin($theta), $c - 204 * cos($theta),
                $c + 218 * sin($theta), $c - 218 * cos($theta), $number
            );
        }
        $offset += $width + $gap;
    }

    $blocks = '';
    for ($i = 0; $i < 36; $i++) {
        $blocks .= sprintf('<rect x="-8" y="-190" width="16" height="26" rx="3" transform="translate(%d %d) rotate(%d)"/>', $c, $c, $i * 10);
    }
    $spokes = '';
    for ($i = 0; $i < 5; $i++) {
        $spokes .= sprintf('<circle cx="0" cy="-62" r="17" transform="translate(%d %d) rotate(%d)"/>', $c, $c, $i * 72);
    }

    return '<svg class="dtc-find__tyre" viewBox="0 0 480 480" role="img" aria-label="A tyre with the size code 205/55 R16 on its sidewall" xmlns="http://www.w3.org/2000/svg">'
        . '<defs><radialGradient id="dtc-rim" cx=".4" cy=".35" r=".8"><stop offset="0" stop-color="#f4f6fa"/><stop offset="1" stop-color="#8f99ab"/></radialGradient></defs>'
        . '<circle cx="240" cy="240" r="192" fill="#151821"/><g fill="#0b0d13">' . $blocks . '</g>'
        . '<circle cx="240" cy="240" r="160" fill="#262b38"/><circle cx="240" cy="240" r="148" fill="none" stroke="#323849" stroke-width="2"/>'
        . '<circle cx="240" cy="240" r="108" fill="none" stroke="#323849" stroke-width="2"/>'
        . '<circle cx="240" cy="240" r="102" fill="url(#dtc-rim)"/><circle cx="240" cy="240" r="104" fill="none" stroke="#fbbd00" stroke-width="3"/>'
        . '<g fill="#262b38">' . $spokes . '</g><circle cx="240" cy="240" r="24" fill="#cfd5df"/><circle cx="240" cy="240" r="9" fill="#8f99ab"/>'
        . '<g font-family="&quot;Arial Black&quot;, Impact, Arial, Helvetica, sans-serif" font-weight="900" font-style="italic">' . $text . '</g>'
        . $callouts . '</svg>';
}

add_action('wp_enqueue_scripts', function () {
    if (!dtc_is_find_tyres_page()) {
        return;
    }
    // Same catalogue assets as the tyre pages (cards, buttons, form styles).
    $dir = get_template_directory();
    $uri = get_template_directory_uri();
    wp_enqueue_style('dtc-tyres', $uri . '/css/dtc-tyres.css', [], filemtime($dir . '/css/dtc-tyres.css'));
    wp_enqueue_script('dtc-tyres', $uri . '/js/dtc-tyres.js', [], filemtime($dir . '/js/dtc-tyres.js'), true);
});

// The page renders its own heading, so skip the theme's title banner.
add_action('wp', function () {
    if (dtc_is_find_tyres_page()) {
        remove_action('ht_banner_before_content', 'ht_banner_before_content_func');
    }
});
