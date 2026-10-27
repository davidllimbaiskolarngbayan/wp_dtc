<?php
/**
 * Site footer.
 */
$contact_page = get_page_by_path('contact-us') ?: get_page_by_path('contact');
$contact_url  = $contact_page ? get_permalink($contact_page) : home_url('/contact-us/');
$stores_url   = get_post_type_archive_link('stores') ?: home_url('/store/');
$tyres_url    = get_post_type_archive_link('tyres') ?: home_url('/tyres/');
$about_page   = get_page_by_path('about-us') ?: get_page_by_path('about');
$footer_legal_links = [
    ['slug' => 'accessibility', 'label' => 'Accessibility'],
    ['slug' => 'privacy-policy', 'label' => 'Privacy Policy'],
    ['slug' => 'intellectual-property', 'label' => 'Intellectual Property'],
    ['slug' => 'terms-and-conditions', 'label' => 'Terms & Conditions of Trade'],
];
?>
</div>
<footer class="dtc-footer">
    <div class="dtc-footer__container">
        <div class="dtc-footer__grid">
            <div class="dtc-footer__brand">
                <img class="dtc-footer__logo" src="<?php echo esc_url(get_template_directory_uri() . '/images/dtc-logo.svg'); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                <h2>Have questions?</h2>
                <p>We're here to help. Reach out anytime.</p>
                <a class="dtc-footer__button" href="<?php echo esc_url($contact_url); ?>">Contact us</a>
                <p><a href="<?php echo esc_url(home_url('/warranty-guide/')); ?>">Warranty &amp; claim guide</a></p>
            </div>

            <nav class="dtc-footer__navigation" aria-label="Footer">
                <?php if (has_nav_menu('footer')) : ?>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container' => false,
                        'menu_class' => 'dtc-footer__menu',
                        'depth' => 2,
                        'fallback_cb' => false,
                    ]);
                    ?>
                <?php else : ?>
                    <ul class="dtc-footer__menu">
                        <li class="menu-item-has-children">
                            <a href="#">Company</a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo esc_url($about_page ? get_permalink($about_page) : home_url('/')); ?>">About us</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">For Customers</a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo esc_url(home_url('/check-warranty/')); ?>">Check warranty</a></li>
                                <li><a href="<?php echo esc_url(home_url('/warranty-guide/')); ?>">Warranty &amp; claim guide</a></li>
                                <li><a href="<?php echo esc_url(home_url('/register-your-tyres/')); ?>">Register your tyres</a></li>
                                <li><a href="<?php echo esc_url($tyres_url); ?>">Explore tyres</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">For Dealers</a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo esc_url($contact_url); ?>">Become a dealer</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Support</a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo esc_url($contact_url); ?>">Contact us</a></li>
                                <li><a href="<?php echo esc_url($stores_url); ?>">Find a store</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>
            </nav>
        </div>

        <div class="dtc-footer__bottom">
            <p class="dtc-footer__copy">&copy; <?php echo esc_html(wp_date('Y')); ?> <?php echo esc_html(get_bloginfo('name')); ?>. All rights reserved.</p>
            <nav class="dtc-footer__legal-links" aria-label="Legal information">
                <?php foreach ($footer_legal_links as $legal_link) : ?>
                    <?php
                    $legal_page = get_page_by_path($legal_link['slug']);
                    if (!$legal_page || $legal_page->post_status !== 'publish') {
                        continue;
                    }
                    ?>
                    <a href="<?php echo esc_url(get_permalink($legal_page)); ?>"><?php echo esc_html($legal_link['label']); ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
