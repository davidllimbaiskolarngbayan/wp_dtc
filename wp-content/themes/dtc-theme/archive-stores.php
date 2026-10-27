<?php
get_header();

$regions = get_terms(['taxonomy' => 'store-region', 'hide_empty' => true]);
$regions = is_wp_error($regions) ? [] : $regions;

$stores = [];
while (have_posts()) {
    the_post();
    $stores[] = dtc_store_data(get_the_ID());
}

// Province options are tied to their region so the filters can cascade.
$provinces = [];
$services  = [];
foreach ($stores as $store) {
    $region   = $store['region']['slug'] ?? '';
    $province = sanitize_title($store['province']);
    if ($province !== '') {
        $provinces[$province] = ['name' => $store['province'], 'region' => $region];
    }
    foreach ($store['services'] as $service) {
        $services[$service['slug']] = $service['name'];
    }
}
uasort($provinces, static fn ($a, $b) => strcmp($a['name'], $b['name']));
asort($services);
?>

<div class="dtc-stores" id="maincontent" data-dtc-stores>
    <section class="dtc-stores__head">
        <div class="dtc-stores__container">
            <p class="dtc-stores__eyebrow">Store locator</p>
            <h1 class="dtc-stores__title">Find a store near you</h1>
            <p class="dtc-stores__lead">Our partner stores across the Philippines fit your tyres and look after your car.</p>
        </div>
    </section>

    <section class="dtc-stores__toolbar" aria-label="Find stores">
        <div class="dtc-stores__toolbar-inner">
            <div class="dtc-stores__field">
                <label for="dtc-store-region">Region</label>
                <select id="dtc-store-region" data-store-region>
                    <option value="">All regions</option>
                    <?php foreach ($regions as $region) : ?>
                        <option value="<?php echo esc_attr($region->slug); ?>"><?php echo esc_html($region->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="dtc-stores__field">
                <label for="dtc-store-province">Province</label>
                <select id="dtc-store-province" data-store-province disabled>
                    <option value="">All provinces</option>
                    <?php foreach ($provinces as $slug => $province) : ?>
                        <option value="<?php echo esc_attr($slug); ?>" data-parent="<?php echo esc_attr($province['region']); ?>"><?php echo esc_html($province['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="button" class="dtc-stores__near" data-store-near>Locate me</button>
            <div class="dtc-stores__field dtc-stores__field--end">
                <label for="dtc-store-distance">Show results within</label>
                <select id="dtc-store-distance" data-store-distance>
                    <option value="">Any distance</option>
                    <option value="10">10 km</option>
                    <option value="25">25 km</option>
                    <option value="50">50 km</option>
                    <option value="100">100 km</option>
                </select>
            </div>
        </div>
    </section>

    <div class="dtc-stores__map" data-store-map role="region" aria-label="Map of stores"></div>

    <section class="dtc-stores__results">
        <aside class="dtc-stores__side" aria-label="Filter stores">
            <h2 class="dtc-stores__side-title">Filter by</h2>
            <div class="dtc-stores__field">
                <label for="dtc-store-search">Store name</label>
                <input type="search" id="dtc-store-search" maxlength="60" placeholder="Search" autocomplete="off" data-store-search>
            </div>
            <div class="dtc-stores__field">
                <label for="dtc-store-service">Service</label>
                <select id="dtc-store-service" data-store-service>
                    <option value="">All services</option>
                    <?php foreach ($services as $slug => $name) : ?>
                        <option value="<?php echo esc_attr($slug); ?>"><?php echo esc_html($name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="button" class="dtc-stores__reset" data-store-reset>Clear filters</button>
        </aside>

        <div class="dtc-stores__main">
            <div class="dtc-stores__meta">
                <p class="dtc-stores__count" data-store-count role="status" aria-live="polite"><?php echo (int) count($stores); ?> results found</p>
            </div>

            <ul class="dtc-stores__list" data-store-list>
                <?php foreach ($stores as $store) :
                    $blob = strtolower(implode(' ', [$store['name'], $store['city'], $store['address'], $store['province']]));
                ?>
                    <li class="dtc-store" data-store
                        data-name="<?php echo esc_attr($store['name']); ?>"
                        data-search="<?php echo esc_attr($blob); ?>"
                        data-region="<?php echo esc_attr($store['region']['slug'] ?? ''); ?>"
                        data-province="<?php echo esc_attr(sanitize_title($store['province'])); ?>"
                        data-services="<?php echo esc_attr(implode(' ', array_column($store['services'], 'slug'))); ?>"
                        data-lat="<?php echo esc_attr($store['lat'] ?? ''); ?>"
                        data-lng="<?php echo esc_attr($store['lng'] ?? ''); ?>"
                        data-url="<?php echo esc_url($store['url']); ?>">
                        <div class="dtc-store__body">
                            <h2 class="dtc-store__name"><a href="<?php echo esc_url($store['url']); ?>"><?php echo esc_html($store['name']); ?></a></h2>
                            <p class="dtc-store__distance" data-distance hidden></p>
                            <p class="dtc-store__address"><?php echo esc_html(trim($store['address'] . ', ' . $store['city'], ', ')); ?></p>
                            <?php if ($store['phone']) : ?>
                                <p class="dtc-store__line"><a href="tel:<?php echo esc_attr($store['tel']); ?>"><?php echo esc_html($store['phone']); ?></a></p>
                            <?php endif; ?>
                            <?php if ($store['hours']) : ?>
                                <p class="dtc-store__line dtc-store__hours"><?php echo esc_html($store['hours'][0]); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="dtc-store__side">
                            <?php if ($store['services']) : ?>
                                <span class="dtc-store__pill"><?php echo (int) count($store['services']); ?> services</span>
                            <?php endif; ?>
                            <div class="dtc-store__actions">
                                <?php if ($store['lat'] !== null) : ?>
                                    <button type="button" class="dtc-store__btn" data-store-focus>Show on map</button>
                                <?php endif; ?>
                                <a class="dtc-store__btn dtc-store__btn--primary" href="<?php echo esc_url($store['url']); ?>">View store</a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p class="dtc-stores__empty" data-store-empty hidden>No stores match your search. Try another filter.</p>
            <nav class="dtc-stores__pagination" data-store-pagination aria-label="Store results pages" hidden>
                <button type="button" class="dtc-store__btn" data-store-previous aria-label="Previous page">Previous</button>
                <span data-store-page role="status" aria-live="polite"></span>
                <button type="button" class="dtc-store__btn" data-store-next aria-label="Next page">Next</button>
            </nav>
        </div>
    </section>
</div>

<?php get_footer(); ?>
