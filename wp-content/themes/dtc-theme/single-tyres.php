<?php
get_header();

while (have_posts()) : the_post();
    $id      = get_the_ID();
    $tag     = get_field('tyre_tag');
    $gallery = get_field('photo_gallery');
    $types   = get_the_terms($id, 'tyre-type');
    $family  = get_the_terms($id, 'tyre-family');
    $feats   = get_the_terms($id, 'tyre-feature');
    $feats   = ($feats && !is_wp_error($feats)) ? $feats : [];
    $video   = get_field('featured_video');

    $images = [];
    $thumb_id = get_post_thumbnail_id($id);
    if ($thumb_id) {
        $images[] = (int) $thumb_id;
    }
    foreach (['angled', 'tread', 'rim'] as $key) {
        if (!empty($gallery[$key])) {
            $images[] = (int) $gallery[$key];
        }
    }
    $images = array_values(array_unique($images));

    $feature_blocks = [];
    for ($i = 1; $i <= 3 && !get_field('hide_tyre_features'); $i++) {
        $block = get_field('feature_' . $i);
        if (!empty($block['feature_label'])) {
            $feature_blocks[] = $block;
        }
    }

    $show_warranty = !get_field('hide_tyre_warranty');
    $warranty_text = get_field('warranties');

    $specs = get_field('hide_tyre_specs') ? [] : get_posts([
        'post_type'   => 'tyre-spec',
        'numberposts' => 100,
        'meta_key'    => 'related_tyre',
        'meta_value'  => $id,
        'orderby'     => 'title',
        'order'       => 'ASC',
    ]);

    $yes_no    = static fn ($value): string => $value ? 'Yes' : 'No';
    $spec_data = [];
    $rims      = [];
    foreach ($specs as $spec) {
        $w = get_field('width', $spec->ID);
        $a = get_field('aspect_ratio', $spec->ID);
        $d = (string) get_field('diameter', $spec->ID);
        $load = get_field('load_index', $spec->ID);
        $speed = get_field('speed', $spec->ID);
        $rows = array_filter([
            'Tyre size'        => "{$w}/{$a}R{$d}",
            'Load index'       => (string) $load,
            'Speed rating'     => (string) $speed,
            'Load / speed'     => $load . $speed,
            'OE fitment'       => (string) get_field('oe_fitment', $spec->ID),
            'Run on flat'      => $yes_no(get_field('rof', $spec->ID)),
            'Snow rated (3PMSF)' => $yes_no(get_field('three_pmsf', $spec->ID)),
            'Noise mitigation' => $yes_no(get_field('noise_mitigation', $spec->ID)),
            'Ply rating'       => (string) get_field('ply_rating', $spec->ID),
            'Construction'     => (string) get_field('construction', $spec->ID),
            'Tread depth (mm)' => (string) get_field('tread_depth', $spec->ID),
            'Application'      => (string) get_field('application', $spec->ID),
            'Segment'          => (string) get_field('segment', $spec->ID),
            'SKU'              => (string) get_field('sku', $spec->ID),
        ], static fn ($value): bool => $value !== '');
        $spec_data[] = ['id' => $spec->ID, 'rim' => $d, 'size' => "{$w}/{$a}R{$d}", 'rows' => $rows];
        $rims[$d] = true;
    }
    ksort($rims, SORT_NUMERIC);
?>

<div class="dtc-tyres dtc-single" id="maincontent">
    <div class="dtc-tyres-container">
        <nav class="dtc-breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(get_post_type_archive_link('tyres')); ?>" class="dtc-back">&larr; Back to tyres</a>
        </nav>

        <div class="dtc-top">
            <div class="dtc-gallery" data-dtc-gallery>
                <?php if ($tag) : ?>
                    <div class="dtc-badge dtc-badge--<?php echo esc_attr($tag['value']); ?>"><?php echo esc_html($tag['label']); ?></div>
                <?php endif; ?>
                <div class="dtc-gallery__stage">
                    <?php if ($images) : ?>
                        <img src="<?php echo esc_url(wp_get_attachment_image_url($images[0], 'large')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" data-gallery-main>
                    <?php endif; ?>
                    <?php if ($video) : ?>
                        <video controls hidden data-gallery-video><source src="<?php echo esc_url($video); ?>" type="video/mp4"></video>
                    <?php endif; ?>
                    <?php if (count($images) + ($video ? 1 : 0) > 1) : ?>
                        <button type="button" class="dtc-round dtc-round--prev" aria-label="Previous image" data-gallery-prev>&#8249;</button>
                        <button type="button" class="dtc-round dtc-round--next" aria-label="Next image" data-gallery-next>&#8250;</button>
                    <?php endif; ?>
                </div>
                <?php if (count($images) + ($video ? 1 : 0) > 1) : ?>
                    <div class="dtc-gallery__thumbs">
                        <?php foreach ($images as $index => $image_id) : ?>
                            <button type="button" class="<?php echo $index === 0 ? 'is-active' : ''; ?>" data-gallery-thumb="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'large')); ?>" aria-label="Show image <?php echo (int) ($index + 1); ?>">
                                <img src="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'thumbnail')); ?>" alt="">
                            </button>
                        <?php endforeach; ?>
                        <?php if ($video) : ?>
                            <button type="button" data-gallery-video-thumb aria-label="Play video">&#9654;</button>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="dtc-details">
                <div class="dtc-brandrow">
                    <p class="dtc-brand">DTC</p>
                </div>
                <h1 class="dtc-product-name"><?php the_title(); ?></h1>

                <ul class="dtc-type-tags">
                    <?php if (get_field('run_on_flat')) : ?>
                        <li><?php echo dtc_icon_check(); // phpcs:ignore WordPress.Security.EscapeOutput ?><span>Run on Flat</span></li>
                    <?php endif; ?>
                    <?php foreach ($feats as $feat) : ?>
                        <li><?php echo dtc_icon_check(); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html($feat->name); ?></span></li>
                    <?php endforeach; ?>
                </ul>

                <?php if ($headline = get_field('headline')) : ?>
                    <p class="dtc-headline"><?php echo esc_html($headline); ?></p>
                <?php endif; ?>

                <div class="dtc-description"><?php the_content(); ?></div>

                <?php if ($family && !is_wp_error($family)) : ?>
                    <p class="dtc-family">Family: <a href="<?php echo esc_url(get_term_link($family[0])); ?>"><?php echo esc_html($family[0]->name); ?></a></p>
                <?php endif; ?>

                <div class="dtc-cta">
                    <?php if ($spec_data) : ?>
                        <a class="dtc-pbtn dtc-pbtn--primary" href="#full-specs">Check available sizes</a>
                    <?php endif; ?>
                    <a class="dtc-pbtn dtc-pbtn--secondary" href="<?php echo esc_url(home_url('/register-your-tyres/')); ?>">Register your tyres</a>
                </div>
            </div>
        </div>
    </div>

    <?php if ($feature_blocks || $show_warranty || $spec_data) : ?>
        <div class="dtc-pdp-nav" role="navigation" aria-label="Product detail" data-pdp-nav>
            <ul class="dtc-tyres-container">
                <?php if ($feature_blocks) : ?><li><a href="#tyre-features">Tyre Features</a></li><?php endif; ?>
                <?php if ($show_warranty) : ?><li><a href="#warranties-and-guarantees">Warranties</a></li><?php endif; ?>
                <?php if ($spec_data) : ?><li><a href="#full-specs">Tyre Specifications</a></li><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="dtc-tyres-container dtc-sections">
        <?php if ($feature_blocks) : ?>
            <section id="tyre-features" class="dtc-section">
                <h2 class="dtc-h3">Tyre Features</h2>
                <div class="dtc-feature-grid">
                    <?php foreach ($feature_blocks as $block) : ?>
                        <div class="dtc-feature">
                            <span class="dtc-feature__label"><?php echo esc_html($block['feature_label']); ?></span>
                            <?php echo wp_kses_post(wpautop(esc_html($block['feature_description']))); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($show_warranty) : ?>
            <section id="warranties-and-guarantees" class="dtc-section">
                <h2 class="dtc-h3">Warranties</h2>
                <?php if ($warranty_text) : ?>
                    <div class="dtc-warranty"><?php echo wp_kses_post($warranty_text); ?></div>
                <?php else : ?>
                    <div class="dtc-warranty">
                        <p>DTC tyres are covered against defects in materials and workmanship. Register your tyres after purchase to activate your warranty, and keep your receipt for any claim.</p>
                        <p><a class="dtc-pbtn dtc-pbtn--secondary" href="<?php echo esc_url(home_url('/check-warranty/')); ?>">Check your warranty</a></p>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php if ($spec_data) : ?>
            <section id="full-specs" class="dtc-section" data-dtc-specs>
                <p class="dtc-eyebrow">Tyre Specifications</p>
                <h2 class="dtc-h3">Full Specs</h2>

                <fieldset class="dtc-pills" data-specs-rims>
                    <legend>Rim Diameter</legend>
                    <?php foreach (array_keys($rims) as $rim) : ?>
                        <label class="dtc-pill"><input type="radio" name="rimDiameter" value="<?php echo esc_attr($rim); ?>"><span><?php echo esc_html($rim); ?>&Prime;</span></label>
                    <?php endforeach; ?>
                </fieldset>

                <fieldset class="dtc-pills" data-specs-sizes>
                    <legend>Tyre Size</legend>
                    <?php foreach ($spec_data as $row) : ?>
                        <label class="dtc-pill" data-rim="<?php echo esc_attr($row['rim']); ?>"><input type="radio" name="tireSizeCode" value="<?php echo (int) $row['id']; ?>"><span><?php echo esc_html($row['size']); ?></span></label>
                    <?php endforeach; ?>
                </fieldset>

                <p class="dtc-specs-hint" data-specs-hint>Select a rim diameter and tyre size to see the full specifications.</p>
                <ul class="dtc-features-table" data-specs-table hidden></ul>
                <script type="application/json" id="dtc-spec-data"><?php echo wp_json_encode($spec_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
            </section>
        <?php endif; ?>

        <?php
        $related = new WP_Query([
            'post_type'           => 'tyres',
            'posts_per_page'      => 9,
            'post__not_in'        => [$id],
            'ignore_sticky_posts' => true,
            'orderby'             => 'title',
            'order'               => 'ASC',
        ]);
        if ($related->have_posts()) :
        ?>
            <section class="dtc-section dtc-range" data-dtc-range aria-labelledby="dtc-range-title">
                <p class="dtc-eyebrow">Tyre Range</p>
                <h2 class="dtc-h3" id="dtc-range-title">More Tyres To Choose From</h2>
                <div class="dtc-range__wrap">
                    <button type="button" class="dtc-round dtc-round--prev" aria-label="Previous tyres" data-range-prev>&#8249;</button>
                    <div class="dtc-range__track" data-range-track>
                        <?php while ($related->have_posts()) : $related->the_post();
                            get_template_part('template-parts/tyres/card');
                        endwhile; wp_reset_postdata(); ?>
                    </div>
                    <button type="button" class="dtc-round dtc-round--next" aria-label="Next tyres" data-range-next>&#8250;</button>
                </div>
            </section>
        <?php endif; ?>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
