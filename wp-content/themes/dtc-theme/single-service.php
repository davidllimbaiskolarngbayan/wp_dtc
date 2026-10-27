<?php
get_header();

$store_url = get_post_type_archive_link('stores') ?: home_url('/store/');

while (have_posts()) :
    the_post();
    $slug     = get_post_field('post_name');
    $included = dtc_service_lines((string) get_field('included'));
    $signs    = dtc_service_lines((string) get_field('signs'));
    $duration = (string) get_field('duration');
    $others   = new WP_Query([
        'post_type'      => 'service',
        'post__not_in'   => [get_the_ID()],
        'posts_per_page' => 3,
        'orderby'        => 'rand',
        'no_found_rows'  => true,
    ]);
?>

<div class="dtc-auto" id="maincontent">
    <section class="dtc-auto__hero dtc-auto__hero--single">
        <div class="dtc-auto__container dtc-auto__hero-grid">
            <div>
                <p class="dtc-auto__eyebrow">DTC Auto Care</p>
                <h1 class="dtc-auto__title"><?php the_title(); ?></h1>
                <p class="dtc-auto__lead"><?php echo esc_html(get_field('summary')); ?></p>
                <?php if ($duration) : ?>
                    <p class="dtc-auto__fact"><strong>Typical time</strong> <?php echo esc_html($duration); ?></p>
                <?php endif; ?>
                <div class="dtc-auto__actions">
                    <a class="dtc-auto__btn dtc-auto__btn--primary" href="<?php echo esc_url($store_url); ?>">Find a store</a>
                    <a class="dtc-auto__btn dtc-auto__btn--ghost" href="<?php echo esc_url(dtc_autocare_url()); ?>">All services</a>
                </div>
            </div>
            <div class="dtc-auto__art" aria-hidden="true">
                <?php echo dtc_service_icon($slug); // phpcs:ignore WordPress.Security.EscapeOutput ?>
            </div>
        </div>
    </section>

    <?php if ($included || $signs) : ?>
        <section class="dtc-auto__section">
            <div class="dtc-auto__container dtc-auto__lists">
                <?php if ($included) : ?>
                    <div class="dtc-auto__panel">
                        <h2 class="dtc-auto__h3">What's included</h2>
                        <ul class="dtc-auto__checks">
                            <?php foreach ($included as $item) : ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if ($signs) : ?>
                    <div class="dtc-auto__panel dtc-auto__panel--alt">
                        <h2 class="dtc-auto__h3">Signs you may need it</h2>
                        <ul class="dtc-auto__signs">
                            <?php foreach ($signs as $item) : ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($others->have_posts()) : ?>
        <section class="dtc-auto__section dtc-auto__section--soft" aria-labelledby="dtc-auto-more">
            <div class="dtc-auto__container">
                <h2 class="dtc-auto__h2" id="dtc-auto-more">More services</h2>
                <div class="dtc-auto__grid">
                    <?php while ($others->have_posts()) : $others->the_post(); ?>
                        <a class="dtc-auto__card" href="<?php the_permalink(); ?>">
                            <span class="dtc-auto__card-icon"><?php echo dtc_service_icon(get_post_field('post_name')); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
                            <span class="dtc-auto__card-title"><?php the_title(); ?></span>
                            <span class="dtc-auto__card-text"><?php echo esc_html(get_field('summary')); ?></span>
                            <span class="dtc-auto__card-link">Learn more <span aria-hidden="true">&rarr;</span></span>
                        </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="dtc-auto__cta">
        <div class="dtc-auto__container">
            <h2>Book it at a partner store</h2>
            <p>Find the store nearest to you and get your car checked.</p>
            <a class="dtc-auto__btn dtc-auto__btn--dark" href="<?php echo esc_url($store_url); ?>">Find a store</a>
        </div>
    </section>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
