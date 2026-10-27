<?php
// Site header: logo left, menu beside it, find-store / find-tyres buttons and search on the right.
$tyres_url = get_post_type_archive_link('tyres') ?: home_url('/tyres/');
$store_url = get_post_type_archive_link('stores') ?: home_url('/store/');
$contact_page = get_page_by_path('contact-us') ?: get_page_by_path('contact');
$contact_url = $contact_page ? get_permalink($contact_page) : home_url('/contact-us/');
$promotions_page = get_page_by_path('promotions');
$promotions_url = $promotions_page ? get_permalink($promotions_page) : home_url('/promotions/');
?>
<header class="dtc-header" data-dtc-header>
    <div class="dtc-header__utility">
        <div class="dtc-header__utility-inner">
            <a class="dtc-header__promo-link" href="<?php echo esc_url($promotions_url); ?>">Promos</a>
            <a href="<?php echo esc_url($contact_url); ?>">Contact Us</a>
        </div>
    </div>
    <div class="dtc-header__bar">
        <div class="dtc-header__inner">
            <a class="dtc-header__logo" href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/dtc-logo.svg'); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="176" height="45">
            </a>

            <nav id="dtc-nav" class="dtc-header__nav" aria-label="Primary">
                <div class="dtc-header__panel-top">
                    <div class="dtc-header__actions">
                        <a class="dtc-header__btn" href="<?php echo esc_url($store_url); ?>">
                            <img src="<?php echo esc_url(home_url('/wp-content/uploads/2026/10/find_my_store_dtc_color.png')); ?>" alt="Find My Store">
                        </a>
                        <a class="dtc-header__btn" href="<?php echo esc_url(dtc_find_tyres_url()); ?>">
                            <img src="<?php echo esc_url(home_url('/wp-content/uploads/2026/10/find_my_tyres_dtc_color.png')); ?>" alt="Find My Tyres">
                        </a>
                    </div>
                    <button type="button" class="dtc-header__close" data-dtc-close>
                        <span class="screen-reader-text">Close menu</span>
                        <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M5 5l14 14M19 5L5 19" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/></svg>
                    </button>
                </div>
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'nav navbar-nav nav-destop',
                    'walker'         => new HT_walker_nav_menu(),
                    'fallback_cb'    => false,
                ]);
                ?>
            </nav>

            <button type="button" class="dtc-header__icon" data-dtc-search-toggle aria-expanded="false" aria-controls="dtc-search">
                <span class="screen-reader-text">Search</span>
                <svg width="22" height="22" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="10" cy="10" r="6.5" fill="none" stroke="currentColor" stroke-width="2.4"/><line x1="15" y1="15" x2="21" y2="21" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
            </button>
            <button type="button" class="dtc-header__icon dtc-header__burger" data-dtc-burger aria-expanded="false" aria-controls="dtc-nav">
                <span class="screen-reader-text">Menu</span>
                <svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M3 6h18M3 12h18M3 18h18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
            </button>
        </div>
        <form id="dtc-search" class="dtc-header__search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" hidden>
            <div class="dtc-header__inner">
                <label class="screen-reader-text" for="dtc-search-input">Search</label>
                <input id="dtc-search-input" type="search" name="s" placeholder="Search tyres, pages..." maxlength="80">
                <button type="submit">Search</button>
            </div>
        </form>
    </div>
</header>
