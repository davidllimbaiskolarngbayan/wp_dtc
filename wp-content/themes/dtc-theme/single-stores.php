<?php
get_header();

while (have_posts()) :
    the_post();
    $store = dtc_store_data(get_the_ID());
    $registrationUrl = dtc_registration_url_for_store_slug(get_post_field('post_name', get_the_ID()));
    $registrationQrUrl = dtc_registration_qr_image_url($registrationUrl);
?>

<div class="dtc-stores dtc-stores--single" id="maincontent">
    <section class="dtc-stores__head">
        <div class="dtc-stores__container">
            <a class="dtc-stores__back" href="<?php echo esc_url(dtc_store_url()); ?>"><span aria-hidden="true">&larr;</span> All stores</a>
            <p class="dtc-stores__eyebrow"><?php echo esc_html($store['region']['name'] ?? 'DTC partner store'); ?></p>
            <h1 class="dtc-stores__title"><?php the_title(); ?></h1>
            <p class="dtc-stores__lead"><?php echo esc_html(trim($store['address'] . ', ' . $store['city'], ', ')); ?></p>
        </div>
    </section>

    <section class="dtc-stores__detail">
        <div class="dtc-stores__container dtc-stores__detail-grid">
            <div class="dtc-stores__card">
                <h2 class="dtc-stores__h2">Visit us</h2>
                <dl class="dtc-stores__info">
                    <div><dt>Address</dt><dd><?php echo esc_html(trim($store['address'] . ', ' . $store['city'], ', ')); ?></dd></div>
                    <?php if ($store['phone']) : ?>
                        <div><dt>Phone</dt><dd><a href="tel:<?php echo esc_attr($store['tel']); ?>"><?php echo esc_html($store['phone']); ?></a></dd></div>
                    <?php endif; ?>
                    <?php if ($store['hours']) : ?>
                        <div><dt>Opening hours</dt><dd><?php echo implode('<br>', array_map('esc_html', $store['hours'])); ?></dd></div>
                    <?php endif; ?>
                </dl>
                <a class="dtc-store__btn dtc-store__btn--primary dtc-stores__directions" href="<?php echo esc_url(dtc_store_directions_url($store)); ?>" target="_blank" rel="noopener noreferrer">Get directions</a>
                <div class="dtc-store__registration">
                    <img src="<?php echo esc_url($registrationQrUrl); ?>" alt="QR code linking to DTC tyre registration" loading="lazy" referrerpolicy="no-referrer" width="160" height="160">
                    <div>
                        <h3>Register your tyres</h3>
                        <p>Scan this code to open the warranty registration form. The store is preselected when available.</p>
                        <a href="<?php echo esc_url($registrationUrl); ?>">Open registration form</a>
                    </div>
                </div>
            </div>
            <?php if ($store['lat'] !== null) : ?>
                <div class="dtc-stores__map" data-store-map data-lat="<?php echo esc_attr($store['lat']); ?>" data-lng="<?php echo esc_attr($store['lng']); ?>" data-name="<?php echo esc_attr($store['name']); ?>" role="region" aria-label="Map of <?php echo esc_attr($store['name']); ?>"></div>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($store['services']) : ?>
        <section class="dtc-stores__services" aria-labelledby="dtc-store-services">
            <div class="dtc-stores__container">
                <h2 class="dtc-stores__h2" id="dtc-store-services">Services at this store</h2>
                <ul class="dtc-stores__chips">
                    <?php foreach ($store['services'] as $service) : ?>
                        <li><a href="<?php echo esc_url($service['url']); ?>"><?php echo esc_html($service['name']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
