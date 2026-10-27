<?php
$tyre_name = (string) ($tyre ?? '');
$product_image = (string) ($product_image ?? '');
$tyre_url = (string) ($tyre_url ?? '');
?>
<section class="dtc-thankyou" aria-labelledby="dtc-thankyou-title">
    <div class="dtc-thankyou__confirmation">
        <span class="dtc-thankyou__check" aria-hidden="true">&#10003;</span>
        <div>
            <p class="dtc-thankyou__eyebrow"><?php esc_html_e('Registration complete', HATT_TEXTDOMAIN); ?></p>
            <h1 id="dtc-thankyou-title"><?php echo esc_html(sprintf(__('Thank you, %s!', HATT_TEXTDOMAIN), (string) ($first_name ?? ''))); ?></h1>
            <p><?php esc_html_e('Your tyre warranty registration has been submitted successfully.', HATT_TEXTDOMAIN); ?></p>
            <p><?php esc_html_e('Warranty and claim updates will be sent to the email address provided during registration.', HATT_TEXTDOMAIN); ?></p>
            <?php if (! empty($validpromo)) : ?>
                <p><?php esc_html_e('Your promotion entry and invoice were submitted for verification. Voucher eligibility is subject to review.', HATT_TEXTDOMAIN); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="dtc-thankyou__details">
        <div class="dtc-thankyou__product">
            <div class="dtc-thankyou__image">
                <?php if ($product_image !== '') : ?>
                    <img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($tyre_name); ?>" loading="lazy">
                <?php else : ?>
                    <span class="dtc-thankyou__image-placeholder" aria-hidden="true">&#9678;</span>
                <?php endif; ?>
            </div>
            <div class="dtc-thankyou__product-info">
                <p class="dtc-thankyou__eyebrow"><?php esc_html_e('Registered tyre', HATT_TEXTDOMAIN); ?></p>
                <h2><?php echo esc_html($tyre_name); ?></h2>
                <?php if ($tyre_url !== '') : ?>
                    <a class="dtc-thankyou__link" href="<?php echo esc_url($tyre_url); ?>" target="_blank" rel="noopener noreferrer">
                        <?php esc_html_e('View tyre details', HATT_TEXTDOMAIN); ?> <span aria-hidden="true">&rarr;</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <dl class="dtc-thankyou__summary">
            <div>
                <dt><?php esc_html_e('DTC Code', HATT_TEXTDOMAIN); ?></dt>
                <dd><?php echo esc_html((string) ($dtc_card_no ?? '')); ?></dd>
            </div>
            <div>
                <dt><?php esc_html_e('Date of purchase', HATT_TEXTDOMAIN); ?></dt>
                <dd><?php echo esc_html((string) ($date_of_purchase ?? '')); ?></dd>
            </div>
            <div>
                <dt><?php esc_html_e('Dealer', HATT_TEXTDOMAIN); ?></dt>
                <dd><?php echo esc_html((string) ($find_retailer ?? '')); ?></dd>
            </div>
        </dl>
    </div>
</section>

<script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        event: 'dtcRegister',
        virtualPageviewPath: '/worry-free-assurance/thank-you'
    });
</script>
