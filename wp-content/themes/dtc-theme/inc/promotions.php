<?php
/**
 * DTC promotions landing page.
 */

function dtc_efuel_promo_settings(): array
{
    return [
        'start_date' => '2026-08-01',
        'end_date' => '2026-10-31',
        'minimum_rim' => 17,
        'required_quantity' => 4,
        'voucher_amount' => 1000,
        'campaigns' => [
            [
                'name' => 'eFuel Voucher',
                'title' => 'Get a ₱1,000 eFuel voucher',
                'start_date' => '2026-08-01',
                'end_date' => '2026-10-31',
            ],
        ],
    ];
}

function dtc_registration_promo_campaign(string $purchaseDate): ?array
{
    $settings = dtc_efuel_promo_settings();

    foreach ($settings['campaigns'] as $campaign) {
        if ($purchaseDate >= $campaign['start_date'] && $purchaseDate <= $campaign['end_date']) {
            return $campaign;
        }
    }

    return null;
}

function dtc_promotions_shortcode(): string
{
    $registrationUrl = home_url('/register-your-tyres/');
    $storesUrl = function_exists('dtc_store_url') ? dtc_store_url() : home_url('/store/');
    $promo = dtc_efuel_promo_settings();

    ob_start();
    ?>
    <main class="dtc-promotions">
        <header class="dtc-promotions__hero">
            <div class="dtc-promotions__hero-copy">
                <p class="dtc-promotions__eyebrow">DTC tyre promotion</p>
                <h1>Make your next tyre change count.</h1>
                <p>Get a <strong>&#8369;<?php echo number_format_i18n($promo['voucher_amount']); ?> eFuel voucher</strong> when you buy four qualifying tyres for rim size 17 inches and above, from <?php echo esc_html(mysql2date('F j', $promo['start_date'])); ?> to <?php echo esc_html(mysql2date('F j, Y', $promo['end_date'])); ?>.</p>
                <a class="dtc-promotions__hero-cta" href="<?php echo esc_url($registrationUrl); ?>">Register your tyres <span aria-hidden="true">&rarr;</span></a>
            </div>
            <div class="dtc-promotions__reward" aria-label="Buy four qualifying tyres, get a 1,000 peso eFuel voucher">
                <span class="dtc-promotions__reward-label">BUY 4 QUALIFYING TYRES</span>
                <span class="dtc-promotions__reward-value">&#8369;<?php echo number_format_i18n($promo['voucher_amount']); ?></span>
                <span class="dtc-promotions__reward-caption">eFuel voucher</span>
                <span class="dtc-promotions__reward-rim">Buy 4 · Rim 17 inches and above</span>
            </div>
        </header>

        <section class="dtc-promotions__details" aria-labelledby="dtc-promotions-heading">
            <div class="dtc-promotions__section-heading">
                <p class="dtc-promotions__eyebrow">Your next drive, with extra value</p>
                <h2 id="dtc-promotions-heading">Here’s how to claim your voucher</h2>
            </div>

            <div class="dtc-promotions__steps">
                <article class="dtc-promotions__step">
                    <span class="dtc-promotions__step-number">01</span>
                    <h3>Choose four tyres</h3>
                    <p>Select four qualifying DTC tyres that fit a rim size of <?php echo (int) $promo['minimum_rim']; ?> inches or above.</p>
                </article>
                <article class="dtc-promotions__step">
                    <span class="dtc-promotions__step-number">02</span>
                    <h3>Visit a partner store</h3>
                    <p>Have the store confirm fitment and that your chosen tyres qualify for this promotion.</p>
                </article>
                <article class="dtc-promotions__step">
                    <span class="dtc-promotions__step-number">03</span>
                    <h3>Ask about your voucher</h3>
                    <p>Confirm voucher issuance and redemption details with the participating store before purchase.</p>
                </article>
            </div>

            <section class="dtc-promotions__cta" aria-labelledby="dtc-promotions-cta-heading">
                <div>
                    <p class="dtc-promotions__eyebrow">Find your nearest DTC partner</p>
                    <h2 id="dtc-promotions-cta-heading">Bought your qualifying tyres?</h2>
                    <p>Register your tyre purchase using the DTC form. Confirm voucher eligibility and redemption details with your participating store.</p>
                </div>
                <div class="dtc-promotions__actions">
                    <a class="dtc-promotions__button dtc-promotions__button--primary" href="<?php echo esc_url($registrationUrl); ?>">Go to tyre registration <span aria-hidden="true">&rarr;</span></a>
                    <a class="dtc-promotions__button dtc-promotions__button--secondary" href="<?php echo esc_url($storesUrl); ?>">Find a DTC store</a>
                </div>
            </section>

            <aside class="dtc-promotions__terms" aria-labelledby="dtc-promotions-terms-heading">
                <h2 id="dtc-promotions-terms-heading">Promotion details</h2>
                <p>Buy four qualifying tyres with a rim size of <?php echo (int) $promo['minimum_rim']; ?> inches or above between <?php echo esc_html(mysql2date('F j, Y', $promo['start_date'])); ?> and <?php echo esc_html(mysql2date('F j, Y', $promo['end_date'])); ?> to be considered for a &#8369;<?php echo number_format_i18n($promo['voucher_amount']); ?> eFuel voucher. Eligible tyre models, participating stores, voucher issuance and redemption rules, and other exclusions must be confirmed with a DTC partner store. Purchase registration and invoice are subject to review. Availability may vary.</p>
            </aside>
        </section>
    </main>
    <?php

    return (string) ob_get_clean();
}

add_action('init', static function () {
    add_shortcode('dtc_promotions', 'dtc_promotions_shortcode');
}, 99);

add_action('init', static function () {
    $page = get_page_by_path('promotions');
    if ($page) {
        return;
    }

    $pageId = wp_insert_post([
        'post_title' => 'Promotions',
        'post_name' => 'promotions',
        'post_content' => '[dtc_promotions]',
        'post_status' => 'publish',
        'post_type' => 'page',
    ], true);

    if (is_wp_error($pageId)) {
        error_log('Unable to create the DTC Promotions page: '.$pageId->get_error_message());
    }
}, 20);

add_filter('the_content', static function (string $content): string {
    if (is_page('promotions') && ! has_shortcode($content, 'dtc_promotions')) {
        $content .= "\n[dtc_promotions]";
    }

    return $content;
}, 10);

add_action('wp', static function () {
    if (is_page('promotions') || is_post_type_archive('offer')) {
        remove_action('ht_banner_before_content', 'ht_banner_before_content_func');
    }
});

add_filter('body_class', static function (array $classes): array {
    if (is_page('promotions') || is_post_type_archive('offer')) {
        $classes[] = 'dtc-promotions-page';
    }

    return $classes;
});

add_action('wp_enqueue_scripts', static function () {
    if (! is_page('promotions') && ! is_post_type_archive('offer')) {
        return;
    }

    $dir = get_template_directory();
    wp_enqueue_style('dtc-promotions', get_template_directory_uri().'/css/dtc-promotions.css', [], filemtime($dir.'/css/dtc-promotions.css'));
});