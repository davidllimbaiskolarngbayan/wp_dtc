<?php
/**
 * Tyre spec import/export (Tyres > Import Specs). One CSV row = one tyre size, same columns as the AU brandsite file.
 */

const DTC_SPEC_COLUMNS = [
    'tyre_slug', 'width', 'aspect_ratio', 'rim', 'load', 'speed', 'oe_fitment', 'rof', '3pmsf', 'noise_mitigation',
    'ply_rating', 'construction', 'tread_depth', 'application', 'segment', 'sku_full_desc',
];
const DTC_SPEC_IMPORT_ONLY = ['treadpattern', 'website_category'];
const DTC_SPEC_MAX_BYTES = 2097152;
const DTC_SPEC_MAX_ROWS = 5000;

add_action('admin_menu', function () {
    add_submenu_page('edit.php?post_type=tyres', 'Import Tyre Specs', 'Import Specs', 'manage_options', 'dtc-import-specs', 'dtc_render_import_page');
});

function dtc_render_import_page(): void
{
    if (!current_user_can('manage_options')) {
        return;
    }
    $report = get_transient('dtc_import_report_' . get_current_user_id());
    delete_transient('dtc_import_report_' . get_current_user_id());
    ?>
    <div class="wrap">
        <h1>Import Tyre Specs</h1>

        <?php if ($report) : ?>
            <div class="notice notice-<?php echo $report['errors'] ? 'warning' : 'success'; ?>">
                <p><strong><?php echo (int) $report['tyres']; ?></strong> tyres created, <strong><?php echo (int) $report['created']; ?></strong> sizes added, <strong><?php echo (int) $report['updated']; ?></strong> updated, <strong><?php echo (int) $report['skipped']; ?></strong> skipped.</p>
                <?php if ($report['errors']) : ?>
                    <ul style="list-style:disc;margin-left:20px">
                        <?php foreach (array_slice($report['errors'], 0, 25) as $error) : ?>
                            <li><?php echo esc_html($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <p>Upload a CSV with one row per tyre size. Each row is matched to a tyre by <code>tyre_slug</code> (the tyre's URL slug, e.g. <code>dtc-comfort-plus</code>). Tyres that do not exist yet can be created from the same file.</p>
        <p>Required columns: <code>tyre_slug</code>, <code>width</code>, <code>aspect_ratio</code>, <code>rim</code>. For new tyres: <code>Treadpattern</code> (the tyre name) and <code>segment</code> or <code>website_category</code> (the tyre type). Optional: <code>load</code>, <code>speed</code>, <code>oe_fitment</code>, <code>rof</code>, <code>3pmsf</code>, <code>noise_mitigation</code>, <code>ply_rating</code>, <code>construction</code>, <code>tread_depth</code>, <code>application</code>, <code>sku_full_desc</code>. Other columns (Brand, oe_display, pbu...) are ignored.</p>

        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data">
            <input type="hidden" name="action" value="dtc_import_specs">
            <?php wp_nonce_field('dtc_import_specs'); ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="dtc-csv">CSV file</label></th>
                    <td><input type="file" id="dtc-csv" name="csv" accept=".csv,text/csv" required> <span class="description">Max 2 MB, <?php echo (int) DTC_SPEC_MAX_ROWS; ?> rows.</span></td>
                </tr>
                <tr>
                    <th scope="row">New tyres</th>
                    <td>
                        <label><input type="checkbox" name="create" value="1" checked> Create tyres that do not exist yet</label><br>
                        <label><input type="checkbox" name="publish" value="1"> Publish new tyres right away (otherwise they are saved as drafts)</label>
                        <p class="description">New tyres have no photo, headline or features yet. Add them in Tyres afterwards.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Mode</th>
                    <td>
                        <label><input type="checkbox" name="replace" value="1"> Replace: delete the existing sizes of every tyre listed in the file first</label>
                        <p class="description">Without this, matching sizes are updated and new sizes are added.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button('Import'); ?>
        </form>

        <h2>Export</h2>
        <p>Download the current sizes in the same format. Use it as a template for your own file.</p>
        <p><a class="button" href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=dtc_export_specs'), 'dtc_export_specs')); ?>">Download CSV</a></p>
    </div>
    <?php
}

function dtc_spec_truthy($value): int
{
    return in_array(strtolower(trim((string) $value)), ['1', 'y', 'yes', 'true', 'x'], true) ? 1 : 0;
}

/** Applies one validated row; returns 'created' or 'updated'. */
function dtc_import_spec_row(int $tyre_id, array $row, string $tyre_title): string
{
    $w = (int) $row['width'];
    $a = (int) $row['aspect_ratio'];
    $r = (int) $row['rim'];
    $load = $row['load'] !== '' ? (int) $row['load'] : '';
    $speed = strtoupper(substr($row['speed'], 0, 3));

    $existing = get_posts([
        'post_type'   => 'tyre-spec',
        'numberposts' => 1,
        'fields'      => 'ids',
        'meta_query'  => [
            'relation' => 'AND',
            ['key' => 'related_tyre', 'value' => $tyre_id],
            ['key' => 'width', 'value' => $w],
            ['key' => 'aspect_ratio', 'value' => $a],
            ['key' => 'diameter', 'value' => $r],
            ['key' => 'load_index', 'value' => (string) $load],
            ['key' => 'speed', 'value' => $speed],
        ],
    ]);

    $title = trim("{$w}/{$a}R{$r} {$load}{$speed} {$tyre_title}");
    if ($existing) {
        $spec_id = (int) $existing[0];
        wp_update_post(['ID' => $spec_id, 'post_title' => $title]);
        $result = 'updated';
    } else {
        $spec_id = (int) wp_insert_post(['post_type' => 'tyre-spec', 'post_status' => 'publish', 'post_title' => $title]);
        $result = 'created';
    }

    $values = [
        'related_tyre'     => $tyre_id,
        'width'            => $w,
        'aspect_ratio'     => $a,
        'diameter'         => $r,
        'load_index'       => $load,
        'speed'            => $speed,
        'oe_fitment'       => $row['oe_fitment'],
        'rof'              => dtc_spec_truthy($row['rof']),
        'three_pmsf'       => dtc_spec_truthy($row['3pmsf']),
        'noise_mitigation' => dtc_spec_truthy($row['noise_mitigation']),
        'ply_rating'       => $row['ply_rating'],
        'construction'     => $row['construction'],
        'tread_depth'      => $row['tread_depth'],
        'application'      => $row['application'],
        'segment'          => $row['segment'],
        'sku'              => $row['sku_full_desc'],
    ];
    foreach ($values as $name => $value) {
        update_field('field_dtc_tyre_' . $name, $value, $spec_id);
    }
    return $result;
}

/** Makes sure the width > ratio > rim terms exist and returns the rim (leaf) term ID. */
function dtc_ensure_size_term(int $w, int $a, int $r): int
{
    $ensure = static function (string $name, string $slug, int $parent): int {
        $term = get_term_by('slug', $slug, 'tyre_size');
        if ($term) {
            return (int) $term->term_id;
        }
        $created = wp_insert_term($name, 'tyre_size', ['slug' => $slug, 'parent' => $parent]);
        return is_wp_error($created) ? 0 : (int) $created['term_id'];
    };
    $width = $ensure((string) $w, (string) $w, 0);
    $ratio = $ensure((string) $a, "$w-$a", $width);
    return $ensure((string) $r, "$w-$a-$r", $ratio);
}

add_action('admin_post_dtc_import_specs', function () {
    if (!current_user_can('manage_options')) {
        wp_die('Not allowed.', 403);
    }
    check_admin_referer('dtc_import_specs');

    $report = ['tyres' => 0, 'created' => 0, 'updated' => 0, 'skipped' => 0, 'errors' => []];
    $file = $_FILES['csv'] ?? null;

    if (!$file || $file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
        $report['errors'][] = 'No file was uploaded.';
    } elseif ($file['size'] > DTC_SPEC_MAX_BYTES) {
        $report['errors'][] = 'The file is larger than 2 MB.';
    } elseif (strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) !== 'csv') {
        $report['errors'][] = 'Only .csv files are accepted.';
    } else {
        $handle = fopen($file['tmp_name'], 'rb');
        $header = $handle ? fgetcsv($handle) : false;
        if (!$header) {
            $report['errors'][] = 'The file is empty.';
        } else {
            $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', (string) $header[0]);
            $columns = array_map(static fn ($h) => strtolower(trim((string) $h)), $header);
            $missing = array_diff(['tyre_slug', 'width', 'aspect_ratio', 'rim'], $columns);
            if ($missing) {
                $report['errors'][] = 'Missing required column(s): ' . implode(', ', $missing);
            } else {
                dtc_run_import($handle, $columns, [
                    'replace' => !empty($_POST['replace']),
                    'create'  => !empty($_POST['create']),
                    'publish' => !empty($_POST['publish']),
                ], $report);
            }
        }
        if ($handle) {
            fclose($handle);
        }
    }

    set_transient('dtc_import_report_' . get_current_user_id(), $report, 300);
    wp_safe_redirect(admin_url('edit.php?post_type=tyres&page=dtc-import-specs'));
    exit;
});

/** Creates a tyre from an import row; the tyre type comes from segment or website_category. */
function dtc_create_tyre(string $slug, array $row, bool $publish): ?WP_Post
{
    $title = $row['treadpattern'] !== '' ? $row['treadpattern'] : ucwords(str_replace('-', ' ', $slug));
    $post_id = wp_insert_post([
        'post_type'   => 'tyres',
        'post_status' => $publish ? 'publish' : 'draft',
        'post_title'  => $title,
        'post_name'   => $slug,
    ], true);
    if (is_wp_error($post_id)) {
        return null;
    }

    $type_name = $row['website_category'] !== '' ? $row['website_category'] : $row['segment'];
    if ($type_name !== '') {
        $term = get_term_by('name', $type_name, 'tyre-type');
        $term_id = $term ? (int) $term->term_id : 0;
        if (!$term_id) {
            $created = wp_insert_term(ucwords(strtolower($type_name)), 'tyre-type');
            $term_id = is_wp_error($created) ? 0 : (int) $created['term_id'];
        }
        if ($term_id) {
            wp_set_object_terms($post_id, [$term_id], 'tyre-type');
        }
    }
    return get_post($post_id);
}

function dtc_run_import($handle, array $columns, array $options, array &$report): void
{
    $replace = $options['replace'];
    $rows = [];
    $line = 1;
    while (($cells = fgetcsv($handle)) !== false) {
        $line++;
        if ($line - 1 > DTC_SPEC_MAX_ROWS) {
            $report['errors'][] = 'Stopped at ' . DTC_SPEC_MAX_ROWS . ' rows.';
            break;
        }
        if ($cells === [null] || !array_filter($cells, static fn ($c) => trim((string) $c) !== '')) {
            continue;
        }
        $row = array_fill_keys(array_merge(DTC_SPEC_COLUMNS, DTC_SPEC_IMPORT_ONLY), '');
        foreach ($columns as $i => $name) {
            if (isset($row[$name])) {
                $row[$name] = sanitize_text_field((string) ($cells[$i] ?? ''));
            }
        }
        $rows[] = [$line, $row];
    }

    $tyres = [];
    $replaced = [];
    $sizes_by_tyre = [];
    foreach ($rows as [$line, $row]) {
        $slug = sanitize_title($row['tyre_slug']);
        $tyre = $tyres[$slug] ?? ($tyres[$slug] = get_page_by_path($slug, OBJECT, 'tyres'));
        if (!$tyre && $options['create'] && $slug !== '') {
            $tyre = $tyres[$slug] = dtc_create_tyre($slug, $row, $options['publish']);
            if ($tyre) {
                $report['tyres']++;
            }
        }
        if (!$tyre) {
            $report['skipped']++;
            $report['errors'][] = "Row $line: no tyre with slug '{$slug}'.";
            continue;
        }
        $w = (int) $row['width'];
        $a = (int) $row['aspect_ratio'];
        $r = (int) $row['rim'];
        if ($w < 100 || $w > 500 || $a < 20 || $a > 100 || $r < 10 || $r > 30) {
            $report['skipped']++;
            $report['errors'][] = "Row $line: invalid size {$row['width']}/{$row['aspect_ratio']}R{$row['rim']}.";
            continue;
        }

        if ($replace && empty($replaced[$tyre->ID])) {
            foreach (get_posts(['post_type' => 'tyre-spec', 'numberposts' => -1, 'fields' => 'ids', 'meta_key' => 'related_tyre', 'meta_value' => $tyre->ID]) as $old) {
                wp_delete_post($old, true);
            }
            $replaced[$tyre->ID] = true;
        }

        $result = dtc_import_spec_row($tyre->ID, $row, $tyre->post_title);
        $report[$result]++;
        $sizes_by_tyre[$tyre->ID][] = dtc_ensure_size_term($w, $a, $r);
    }

    foreach ($sizes_by_tyre as $tyre_id => $term_ids) {
        wp_set_object_terms($tyre_id, array_values(array_unique(array_filter($term_ids))), 'tyre_size', !$replace);
    }
}

add_action('admin_post_dtc_export_specs', function () {
    if (!current_user_can('manage_options')) {
        wp_die('Not allowed.', 403);
    }
    check_admin_referer('dtc_export_specs');

    nocache_headers();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="tyre-specs-' . gmdate('Ymd') . '.csv"');
    $out = fopen('php://output', 'wb');
    fputcsv($out, DTC_SPEC_COLUMNS);

    // Prefix formula characters so spreadsheet apps do not execute cell content.
    $safe = static fn ($v): string => preg_match('/^[=+\-@\t\r]/', (string) $v) ? "'" . $v : (string) $v;

    foreach (get_posts(['post_type' => 'tyre-spec', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC']) as $spec) {
        $tyre = get_post((int) get_post_meta($spec->ID, 'related_tyre', true));
        if (!$tyre) {
            continue;
        }
        $meta = static fn (string $key) => get_post_meta($spec->ID, $key, true);
        fputcsv($out, array_map($safe, [
            $tyre->post_name, $meta('width'), $meta('aspect_ratio'), $meta('diameter'), $meta('load_index'), $meta('speed'),
            $meta('oe_fitment'), $meta('rof') ? 'Y' : '', $meta('three_pmsf') ? 'Y' : '', $meta('noise_mitigation') ? 'Y' : '',
            $meta('ply_rating'), $meta('construction'), $meta('tread_depth'), $meta('application'), $meta('segment'), $meta('sku'),
        ]));
    }
    fclose($out);
    exit;
});
