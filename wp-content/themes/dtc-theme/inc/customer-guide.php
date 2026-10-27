<?php
/**
 * Customer warranty and ownership guide.
 */

function dtc_customer_guide_shortcode(): string
{
    $registrationUrl = home_url('/register-your-tyres/');
    $checkUrl = home_url('/check-warranty/');
    $tyresUrl = get_post_type_archive_link('tyres') ?: home_url('/tyres/');
    $storesUrl = function_exists('dtc_store_url') ? dtc_store_url() : home_url('/store/');
    $qrUrl = function_exists('dtc_registration_qr_image_url')
        ? dtc_registration_qr_image_url($registrationUrl)
        : '';
    $faqs = get_posts([
        'post_type' => 'faq',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => ['menu_order' => 'ASC', 'title' => 'ASC'],
    ]);

    ob_start();
    ?>
    <main class="dtc-customer-guide">
        <header class="dtc-customer-guide__hero">
            <p class="dtc-customer-guide__eyebrow">DTC customer support</p>
            <h1>Tyre, warranty &amp; claim guide</h1>
            <p>Find DTC tyres, locate a partner store, register a purchase, or check the status of a claim.</p>
        </header>

        <section class="dtc-customer-guide__actions" aria-label="Customer services">
            <a class="dtc-customer-guide__card" href="<?php echo esc_url($tyresUrl); ?>">
                <span class="dtc-customer-guide__number" aria-hidden="true">01</span>
                <h2>Explore DTC tyres</h2>
                <p>Browse tyre models, available sizes, and product specifications.</p>
                <span class="dtc-customer-guide__link">Browse tyre catalogue <span aria-hidden="true">&rarr;</span></span>
            </a>
            <a class="dtc-customer-guide__card" href="<?php echo esc_url($storesUrl); ?>">
                <span class="dtc-customer-guide__number" aria-hidden="true">02</span>
                <h2>Find a partner store</h2>
                <p>Search stores by location or service and get directions.</p>
                <span class="dtc-customer-guide__link">Open store locator <span aria-hidden="true">&rarr;</span></span>
            </a>
            <a class="dtc-customer-guide__card" href="<?php echo esc_url($registrationUrl); ?>">
                <span class="dtc-customer-guide__number" aria-hidden="true">03</span>
                <h2>Register your tyres</h2>
                <p>Register a DTC tyre purchase to keep your warranty details available.</p>
                <span class="dtc-customer-guide__link">Start registration <span aria-hidden="true">&rarr;</span></span>
            </a>
            <a class="dtc-customer-guide__card" href="<?php echo esc_url($checkUrl); ?>">
                <span class="dtc-customer-guide__number" aria-hidden="true">04</span>
                <h2>Track warranty or claim</h2>
                <p>Use your DTC Code or registered plate number to check records, claim status, and history.</p>
                <span class="dtc-customer-guide__link">Check your status <span aria-hidden="true">&rarr;</span></span>
            </a>
        </section>

        <section class="dtc-customer-guide__warranty" aria-labelledby="dtc-warranty-guide-heading">
            <div>
                <p class="dtc-customer-guide__eyebrow">Warranty guide</p>
                <h2 id="dtc-warranty-guide-heading">What to prepare</h2>
                <ul>
                    <li>Keep your purchase receipt and the DTC Code used for registration.</li>
                    <li>When filing a claim, provide the date the issue happened. The claim check uses the incident date against the 12-month period from purchase.</li>
                    <li>If the purchase date or incident date is missing, or the issue date falls outside the period, the claim may need manual review.</li>
                    <li>Check your claim using the DTC Code and registered plate number. If more information is requested, reply from the claim shown in your records.</li>
                </ul>
                <p class="dtc-customer-guide__note">The status shown online is an eligibility check, not a guarantee that a claim will be approved. DTC will review the submitted information.</p>
            </div>
            <aside class="dtc-customer-guide__qr">
                <?php if ($qrUrl) : ?>
                    <img src="<?php echo esc_url($qrUrl); ?>" alt="QR code linking to the DTC tyre registration form" loading="lazy" referrerpolicy="no-referrer" width="220" height="220">
                <?php endif; ?>
                <h3>Scan to register</h3>
                <p>Open the registration form on your phone.</p>
                <a href="<?php echo esc_url($registrationUrl); ?>">Open registration form</a>
            </aside>
        </section>

        <section class="dtc-customer-guide__faqs" aria-labelledby="dtc-customer-faq-heading">
            <p class="dtc-customer-guide__eyebrow">Help centre</p>
            <h2 id="dtc-customer-faq-heading">Frequently asked questions</h2>
            <?php $hasQuestions = false; ?>
            <?php foreach ($faqs as $faq) :
                $questions = get_post_meta($faq->ID, 'list_q_a', true);
                if (! is_array($questions) || ! $questions) {
                    continue;
                }
                $validQuestions = array_filter($questions, static fn ($item) => is_array($item) && ! empty($item['title']));
                if (! $validQuestions) {
                    continue;
                }
                $hasQuestions = true;
                ?>
                <section class="dtc-customer-guide__faq-group">
                    <h3><?php echo esc_html(get_the_title($faq)); ?></h3>
                    <?php foreach ($validQuestions as $item) : ?>
                        <details>
                            <summary><?php echo esc_html((string) $item['title']); ?></summary>
                            <div class="dtc-customer-guide__answer"><?php echo wp_kses_post(wpautop((string) ($item['answer'] ?? ''))); ?></div>
                        </details>
                    <?php endforeach; ?>
                </section>
            <?php endforeach; ?>
            <?php if (! $hasQuestions) : ?>
                <p>For help with a warranty or claim, use <a href="<?php echo esc_url($checkUrl); ?>">Check Warranty</a> or <a href="<?php echo esc_url(home_url('/contact-us/')); ?>">contact DTC</a>.</p>
            <?php endif; ?>
        </section>
    </main>
    <?php
    return (string) ob_get_clean();
}

add_action('init', static function () {
    add_shortcode('dtc_customer_guide', 'dtc_customer_guide_shortcode');
}, 99);

add_action('init', static function () {
    $guide = get_page_by_path('warranty-guide');
    if ($guide) {
        if ($guide->post_type === 'page' && $guide->post_status === 'publish' && trim((string) $guide->post_content) === '') {
            wp_update_post([
                'ID' => $guide->ID,
                'post_content' => '[dtc_customer_guide]',
            ]);
        }
        return;
    }

    $pageId = wp_insert_post([
        'post_title' => 'Tyre, Warranty & Claim Guide',
        'post_name' => 'warranty-guide',
        'post_content' => '[dtc_customer_guide]',
        'post_status' => 'publish',
        'post_type' => 'page',
    ], true);

    if (is_wp_error($pageId)) {
        error_log('Unable to create the DTC warranty guide page: '.$pageId->get_error_message());
    }
}, 20);

add_filter('the_content', static function (string $content): string {
    if (is_page('warranty-guide') && ! has_shortcode($content, 'dtc_customer_guide')) {
        $content .= "\n[dtc_customer_guide]";
    }

    return $content;
}, 10);

add_filter('body_class', static function (array $classes): array {
    if (is_page('warranty-guide')) {
        $classes[] = 'dtc-warranty-guide-page';
    }

    return $classes;
});

add_action('wp_enqueue_scripts', static function () {
    if (! is_page('warranty-guide')) {
        return;
    }

    $dir = get_template_directory();
    wp_enqueue_style('dtc-customer-guide', get_template_directory_uri().'/css/dtc-customer-guide.css', [], filemtime($dir.'/css/dtc-customer-guide.css'));
});
