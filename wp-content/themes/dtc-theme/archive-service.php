<?php
get_header();

$store_url = get_post_type_archive_link('stores') ?: home_url('/store/');
$steps = [
    ['Pick a service', 'Choose what your car needs, or ask a partner store to check it for you.'],
    ['Visit a partner store', 'Find the store closest to you and drop by or call ahead.'],
    ['Drive away with confidence', 'Your car is checked, fixed and road tested before you leave.'],
];
?>

<div class="dtc-auto" id="maincontent">
    <section class="dtc-auto__hero">
        <div class="dtc-auto__container dtc-auto__hero-grid">
            <div>
                <p class="dtc-auto__eyebrow">DTC Auto Care</p>
                <h1 class="dtc-auto__title">Keep your car road ready</h1>
                <p class="dtc-auto__lead">From brakes to batteries, our partner stores look after the parts that keep you safe on the road.</p>
                <div class="dtc-auto__actions">
                    <a class="dtc-auto__btn dtc-auto__btn--primary" href="<?php echo esc_url($store_url); ?>">Find a store</a>
                    <a class="dtc-auto__btn dtc-auto__btn--ghost" href="#services">Browse services</a>
                </div>
            </div>
            <div class="dtc-auto__art" aria-hidden="true">
                <?php echo dtc_service_icon('tyre-fitting'); // phpcs:ignore WordPress.Security.EscapeOutput ?>
            </div>
        </div>
    </section>

    <section class="dtc-auto__section" id="services" aria-labelledby="dtc-auto-services">
        <div class="dtc-auto__container">
            <h2 class="dtc-auto__h2" id="dtc-auto-services">Our services</h2>
            <?php if (have_posts()) : ?>
                <div class="dtc-auto__grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <a class="dtc-auto__card" href="<?php the_permalink(); ?>">
                            <span class="dtc-auto__card-icon"><?php echo dtc_service_icon(get_post_field('post_name')); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                            <span class="dtc-auto__card-title"><?php the_title(); ?></span>
                            <span class="dtc-auto__card-text"><?php echo esc_html(get_field('summary')); ?></span>
                            <span class="dtc-auto__card-link">Learn more <span aria-hidden="true">&rarr;</span></span>
                        </a>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p class="dtc-auto__empty">Services are coming soon.</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="dtc-auto__section dtc-auto__section--soft" aria-labelledby="dtc-auto-steps">
        <div class="dtc-auto__container">
            <h2 class="dtc-auto__h2" id="dtc-auto-steps">How it works</h2>
            <ol class="dtc-auto__steps">
                <?php foreach ($steps as $index => [$title, $text]) : ?>
                    <li>
                        <span class="dtc-auto__step-no" aria-hidden="true"><?php echo (int) ($index + 1); ?></span>
                        <strong><?php echo esc_html($title); ?></strong>
                        <span><?php echo esc_html($text); ?></span>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <section class="dtc-auto__cta">
        <div class="dtc-auto__container">
            <h2>Ready when you are</h2>
            <p>Find a partner store near you and get your car checked.</p>
            <a class="dtc-auto__btn dtc-auto__btn--dark" href="<?php echo esc_url($store_url); ?>">Find a store</a>
        </div>
    </section>
</div>

<?php get_footer(); ?>
