<?php
/**
 * Template Name: Find Tyres
 */
get_header();

$sizes     = dtc_find_tyres_sizes();
$selection = dtc_find_tyres_selection($sizes);
$page_url  = dtc_find_tyres_url();
$searched  = $selection['rim'] > 0;
$label     = $searched ? $selection['width'] . '/' . $selection['ratio'] . ' R' . $selection['rim'] : '';

$results = null;
if ($searched) {
    $results = new WP_Query([
        'post_type'      => 'tyres',
        'post_status'    => 'publish',
        'posts_per_page' => 24,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'no_found_rows'  => true,
        'tax_query'      => [[
            'taxonomy' => 'tyre_size',
            'field'    => 'slug',
            'terms'    => implode('-', [$selection['width'], $selection['ratio'], $selection['rim']]),
        ]],
    ]);
}

$ratio_options = $selection['width'] ? array_keys($sizes[$selection['width']]) : [];
$rim_options   = ($selection['width'] && $selection['ratio']) ? $sizes[$selection['width']][$selection['ratio']] : [];

$steps = [
    ['name' => 'width', 'label' => 'Width', 'unit' => 'mm', 'options' => array_keys($sizes), 'enabled' => true],
    ['name' => 'ratio', 'label' => 'Profile', 'unit' => '%', 'options' => $ratio_options, 'enabled' => (bool) $selection['width']],
    ['name' => 'rim', 'label' => 'Rim size', 'unit' => 'inch', 'options' => $rim_options, 'enabled' => (bool) $selection['ratio']],
];
?>

<div class="dtc-tyres dtc-find" id="maincontent">
    <section class="dtc-find__hero">
        <div class="dtc-tyres-container dtc-find__grid">
            <div class="dtc-find__main">
                <p class="dtc-eyebrow">Tyre finder</p>
                <h1 class="dtc-find__title">What size are your tyres?</h1>
                <p class="dtc-find__lead">Look for the code printed on your tyre's sidewall, such as 205/55 R16, then pick each part of it below.</p>

                <form id="dtc-find-form" class="dtc-find__form" method="get" action="<?php echo esc_url($page_url); ?>" autocomplete="off" data-dtc-find>
                    <?php foreach ($steps as $index => $step) : ?>
                        <label class="dtc-find__field">
                            <span class="dtc-find__label"><b aria-hidden="true"><?php echo (int) ($index + 1); ?></b> <?php echo esc_html($step['label']); ?> <small>(<?php echo esc_html($step['unit']); ?>)</small></span>
                            <select name="<?php echo esc_attr($step['name']); ?>" data-find-select="<?php echo esc_attr($step['name']); ?>" <?php disabled(!$step['enabled']); ?>>
                                <option value="">Select</option>
                                <?php foreach ($step['options'] as $option) : ?>
                                    <option value="<?php echo (int) $option; ?>" <?php selected($selection[$step['name']], $option); ?>><?php echo (int) $option; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    <?php endforeach; ?>
                    <button type="submit" class="dtc-find__submit"><span class="dtc-find__spinner" aria-hidden="true"></span><span data-find-label>Show matching tyres</span></button>
                </form>
            </div>

            <figure class="dtc-find__figure">
                <?php echo dtc_tyre_illustration_svg(); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                <figcaption>
                    <ol class="dtc-find__legend">
                        <li><b>1</b> Width in millimetres</li>
                        <li><b>2</b> Profile: height as a % of the width</li>
                        <li><b>3</b> Rim diameter in inches</li>
                    </ol>
                </figcaption>
            </figure>
        </div>
    </section>

    <script type="application/json" id="dtc-find-data"><?php echo wp_json_encode($sizes, JSON_HEX_TAG | JSON_HEX_AMP); ?></script>

    <?php if ($searched) : ?>
        <section class="dtc-find__results" id="dtc-find-results" aria-labelledby="dtc-find-results-title">
            <div class="dtc-tyres-container">
                <h2 class="dtc-find__results-title" id="dtc-find-results-title">Tyres for <?php echo esc_html($label); ?></h2>
                <p class="dtc-find__chip">
                    <span>Size <strong><?php echo esc_html($label); ?></strong></span>
                    <a href="#dtc-find-form" data-find-change>Change size</a>
                </p>

                <?php if ($results->have_posts()) : ?>
                    <div class="dtc-pgrid">
                        <?php while ($results->have_posts()) : $results->the_post();
                            get_template_part('template-parts/tyres/card');
                        endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php else : ?>
                    <p class="dtc-empty-state">No tyres found for this size.</p>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
