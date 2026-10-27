<?php
/**
 * Front page. Content is edited through ACF fields (see inc/home-page.php).
 */
get_header();

$tyres_url = get_post_type_archive_link('tyres') ?: home_url('/tyres/');
$intro     = get_field('home_section_1');
$vehicle_heading = (string) get_field('vehicle_section_heading');
$vehicle_heading = str_replace('David Tyre Company', 'David Tyres Company', $vehicle_heading);
$vehicle_heading = preg_replace('/\s+Tyres$/i', '', $vehicle_heading);

$cards = [];
for ($i = 1; $i <= 6; $i++) {
    $card = get_field('card_' . $i);
    if (!empty($card['card_title'])) {
        $cards[] = $card;
    }
}

$banners = [];
for ($i = 1; $i <= 5; $i++) {
    $banner = get_field('banner_' . $i);
    if (!empty($banner['web_banner'])) {
        $banners[] = $banner;
    }
}
?>

<div class="dtc-home">

    <?php if ($banners) : ?>
        <section class="dtc-slider dtc-hero" data-dtc-slider data-autoplay="6000" aria-roledescription="carousel" aria-label="Featured banners">
            <div class="dtc-slider__track">
                <?php foreach ($banners as $banner) :
                    $web    = $banner['web_banner'];
                    $mobile = $banner['mobile_banner'] ?: $web;
                    $alt    = $banner['alt_image_web'];
                    $link   = $banner['banner_link'];
                ?>
                    <div class="dtc-slider__slide">
                        <?php if ($link) : ?><a href="<?php echo esc_url($link); ?>"><?php endif; ?>
                        <picture>
                            <source srcset="<?php echo esc_url($web); ?>" media="(min-width:768px)">
                            <img src="<?php echo esc_url($mobile); ?>" alt="<?php echo esc_attr($alt); ?>">
                        </picture>
                        <?php if ($link) : ?></a><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="dtc-slider__btn dtc-slider__btn--prev" aria-label="Previous slide">&#8249;</button>
            <button type="button" class="dtc-slider__btn dtc-slider__btn--next" aria-label="Next slide">&#8250;</button>
        </section>
    <?php endif; ?>

    <?php if ($intro) : ?>
        <div class="dtc-intro"><?php echo wp_kses_post($intro); ?></div>
    <?php endif; ?>

    <section class="dtc-vehicle">
        <div class="dtc-vehicle__text">
            <h2 class="dtc-eyebrow"><?php echo esc_html(get_field('vehicle_section_eyebrow')); ?></h2>
            <h3 class="dtc-display"><?php echo esc_html($vehicle_heading); ?></h3>
            <div class="dtc-actions">
                <a class="dtc-btn dtc-btn--primary" href="<?php echo esc_url(get_field('vehicle_button_link') ?: dtc_find_tyres_url()); ?>"><?php echo esc_html(get_field('vehicle_button_text') ?: 'Find tyres'); ?></a>
                <a class="dtc-link" href="<?php echo esc_url(get_field('vehicle_link_url') ?: $tyres_url); ?>"><?php echo esc_html(get_field('vehicle_link_text') ?: 'View all tyres'); ?> <span aria-hidden="true">&rarr;</span></a>
            </div>
        </div>

        <div class="dtc-vehicle__cards dtc-slider dtc-cards" data-dtc-slider aria-roledescription="carousel" aria-label="Tyre types">
            <div class="dtc-slider__track">
                <?php if ($cards) :
                    foreach ($cards as $card) :
                        $card_link = $card['card_link'] ?: $tyres_url;
                ?>
                    <div class="dtc-slider__slide">
                        <a class="dtc-card" href="<?php echo esc_url($card_link); ?>">
                            <span class="dtc-card__photo">
                                <?php if ($card['card_background']) : ?>
                                    <img class="dtc-card__bg" src="<?php echo esc_url($card['card_background']); ?>" alt="">
                                <?php endif; ?>
                            </span>
                            <?php if ($card['card_tyre']) : ?>
                                <img class="dtc-card__tyre" src="<?php echo esc_url($card['card_tyre']); ?>" alt="">
                            <?php endif; ?>
                            <span class="dtc-card__caption">
                                <span class="dtc-card__name"><?php echo esc_html($card['card_title']); ?></span>
                                <span class="dtc-card__cta">View Tyre Range <span aria-hidden="true">&rarr;</span></span>
                            </span>
                        </a>
                    </div>
                <?php endforeach; else : ?>
                    <p class="dtc-empty">No cards yet. Add them in Pages &rarr; Home.</p>
                <?php endif; ?>
            </div>
            <div class="dtc-slider__controls">
                <div class="dtc-slider__progress" aria-hidden="true"><span class="dtc-slider__thumb"></span></div>
                <button type="button" class="dtc-slider__btn dtc-slider__btn--prev" aria-label="Previous slide">&#8249;</button>
                <button type="button" class="dtc-slider__btn dtc-slider__btn--next" aria-label="Next slide">&#8250;</button>
            </div>
        </div>
    </section>

    <section class="dtc-banner dtc-banner--accent">
        <div class="dtc-banner__image">
            <?php if ($img = get_field('autocare_image_field')) : ?>
                <img src="<?php echo esc_url($img); ?>" alt="">
            <?php endif; ?>
        </div>
        <div class="dtc-banner__content">
            <h2 class="dtc-eyebrow"><?php echo esc_html(get_field('autocare_section_title')); ?></h2>
            <h3 class="dtc-display"><?php echo esc_html(get_field('autocare_section_heading')); ?></h3>
            <p><?php echo esc_html(get_field('autocare_section_description')); ?></p>
            <?php if ($link = get_field('autocare_section_link')) : ?>
                <a class="dtc-btn dtc-btn--dark" href="<?php echo esc_url($link); ?>"><?php echo esc_html(get_field('autocare_button_text')); ?></a>
            <?php endif; ?>
        </div>
    </section>

    <section class="dtc-banner dtc-banner--reverse">
        <div class="dtc-banner__image">
            <?php if ($img = get_field('home_page_image_field_1')) : ?>
                <img src="<?php echo esc_url($img); ?>" alt="">
            <?php endif; ?>
        </div>
        <div class="dtc-banner__content">
            <h2 class="dtc-eyebrow"><?php echo esc_html(get_field('section_title')); ?></h2>
            <h3 class="dtc-display"><?php echo esc_html(get_field('section_heading')); ?></h3>
            <p><?php echo esc_html(get_field('section_description')); ?></p>
            <?php if ($link = get_field('section_link')) : ?>
                <a class="dtc-btn dtc-btn--primary" href="<?php echo esc_url($link); ?>"><?php echo esc_html(get_field('section_button_text') ?: 'Learn more'); ?></a>
            <?php endif; ?>
        </div>
    </section>

    <section class="dtc-continue">
        <p class="dtc-eyebrow">Let's continue</p>
        <a class="dtc-continue__link" href="<?php echo esc_url(dtc_find_tyres_url()); ?>">Find Tyres <span aria-hidden="true">&rarr;</span></a>
    </section>

</div>

<?php get_footer(); ?>
