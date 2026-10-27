<?php
/**
 * Template Name: About Us Page
 */
get_header();

$store_url   = get_post_type_archive_link('stores') ?: home_url('/store/');
$service_url = get_post_type_archive_link('service') ?: home_url('/services/');
$copy        = get_field('copy') ?: [];

$regions = get_terms(['taxonomy' => 'store-region', 'hide_empty' => true, 'fields' => 'ids']);
$stats = [
    [(int) (wp_count_posts('stores')->publish ?? 0), $copy['stat_partner_stores'] ?? ''],
    [is_wp_error($regions) ? 0 : count($regions), $copy['stat_regions_covered'] ?? ''],
    [(int) (wp_count_posts('service')->publish ?? 0), $copy['stat_services'] ?? ''],
    [(int) (wp_count_posts('tyres')->publish ?? 0), $copy['stat_tyre_models'] ?? ''],
];

$headline = get_field('headline') ?: '';
$intro    = get_field('intro') ?: '';
$story_text = str_replace(['\\r\\n', '\\n', '\\r'], ["\r\n", "\n", "\r"], (string) (get_field('story') ?: ''));
$story      = preg_split('/\R{2,}/', trim($story_text));
$story_image = get_field('story_image') ?: null;

$values = [];
for ($i = 1; $i <= 4; $i++) {
    $group = get_field('value_' . $i) ?: [];
    $values[] = [$group['title'] ?? '', $group['text'] ?? ''];
}
$steps = [];
for ($i = 1; $i <= 5; $i++) {
    $group = get_field('step_' . $i) ?: [];
    $steps[] = [$group['label'] ?? '', $group['title'] ?? '', $group['text'] ?? ''];
}

$icons = [
    '<path d="M32 6l20 8v16c0 14-9 24-20 28C21 54 12 44 12 30V14z"/><path d="M23 32l7 7 12-14"/>',
    '<path d="M10 14h44v28H30l-12 10V42h-8z"/><path d="M22 26h20M22 34h12"/>',
    '<circle cx="32" cy="26" r="16"/><path d="M24 40l-4 18 12-7 12 7-4-18"/>',
    '<path d="M32 58C20 44 14 36 14 26a18 18 0 0 1 36 0c0 10-6 18-18 32z"/><circle cx="32" cy="26" r="6"/>',
];
?>

<div class="dtc-about" id="maincontent">
    <section class="dtc-about__hero">
        <div class="dtc-about__container">
            <p class="dtc-about__eyebrow"><?php echo esc_html($copy['eyebrow'] ?? ''); ?></p>
            <h1 class="dtc-about__title"><?php echo esc_html($headline); ?></h1>
            <p class="dtc-about__lead"><?php echo esc_html($intro); ?></p>
        </div>
    </section>

    <div class="dtc-about__container">
        <ul class="dtc-about__stats">
            <?php foreach ($stats as [$number, $label]) : ?>
                <li><strong><?php echo (int) $number; ?></strong><span><?php echo esc_html($label); ?></span></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <nav class="dtc-about__nav" aria-label="<?php echo esc_attr($copy['nav_aria_label'] ?? ''); ?>">
        <div class="dtc-about__container">
            <ul>
                <li><a href="#story"><?php echo esc_html($copy['nav_story'] ?? ''); ?></a></li>
                <li><a href="#values"><?php echo esc_html($copy['nav_values'] ?? ''); ?></a></li>
                <li><a href="#journey"><?php echo esc_html($copy['nav_journey'] ?? ''); ?></a></li>
                <li><a href="#network"><?php echo esc_html($copy['nav_network'] ?? ''); ?></a></li>
            </ul>
        </div>
    </nav>

    <section class="dtc-about__section" id="story" aria-labelledby="dtc-about-story">
        <div class="dtc-about__container dtc-about__story">
            <h2 class="dtc-about__h2" id="dtc-about-story"><?php echo esc_html($copy['story_heading'] ?? ''); ?></h2>
            <div class="dtc-about__story-content<?php echo $story_image ? ' dtc-about__story-content--with-image' : ''; ?>">
                <?php if ($story_image) : ?>
                    <img class="dtc-about__story-image" src="<?php echo esc_url($story_image['url']); ?>" alt="<?php echo esc_attr($story_image['alt'] ?: $headline); ?>" loading="lazy">
                <?php endif; ?>
                <div class="dtc-about__prose">
                    <?php foreach ($story as $paragraph) : ?>
                        <p><?php echo esc_html($paragraph); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="dtc-about__section dtc-about__section--soft" id="values" aria-labelledby="dtc-about-values">
        <div class="dtc-about__container">
            <h2 class="dtc-about__h2" id="dtc-about-values"><?php echo esc_html($copy['values_heading'] ?? ''); ?></h2>
            <div class="dtc-about__values">
                <?php foreach ($values as $i => [$title, $text]) : ?>
                    <article class="dtc-about__value">
                        <span class="dtc-about__icon" aria-hidden="true"><svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" focusable="false"><?php echo $icons[$i % 4]; // phpcs:ignore WordPress.Security.EscapeOutput ?></svg></span>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($text); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="dtc-about__section" id="journey" aria-labelledby="dtc-about-journey">
        <div class="dtc-about__container">
            <h2 class="dtc-about__h2" id="dtc-about-journey"><?php echo esc_html($copy['journey_heading'] ?? ''); ?></h2>
            <ol class="dtc-about__timeline">
                <?php foreach ($steps as [$label, $title, $text]) : ?>
                    <li>
                        <span class="dtc-about__step-label"><?php echo esc_html($label); ?></span>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($text); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <section class="dtc-about__cta" id="network" aria-labelledby="dtc-about-network">
        <div class="dtc-about__container">
            <h2 id="dtc-about-network"><?php echo esc_html($copy['network_heading'] ?? ''); ?></h2>
            <p><?php echo esc_html($copy['network_description'] ?? ''); ?></p>
            <div class="dtc-about__actions">
                <a class="dtc-about__btn dtc-about__btn--dark" href="<?php echo esc_url($store_url); ?>"><?php echo esc_html($copy['network_store_button'] ?? ''); ?></a>
                <a class="dtc-about__btn dtc-about__btn--ghost" href="<?php echo esc_url($service_url); ?>"><?php echo esc_html($copy['network_services_button'] ?? ''); ?></a>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
