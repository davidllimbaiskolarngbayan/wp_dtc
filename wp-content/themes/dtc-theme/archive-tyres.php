<?php
get_header();

global $wp_query;

$is_tax   = is_tax(['tyre-type', 'tyre-family', 'tyre-feature', 'tyre_size']);
$term     = $is_tax ? get_queried_object() : null;
$base_url = $term ? get_term_link($term) : get_post_type_archive_link('tyres');
$types    = dtc_ordered_terms('tyre-type');
$families = dtc_ordered_terms('tyre-family');

$q_value      = isset($_GET['q']) ? sanitize_text_field(wp_unslash($_GET['q'])) : '';
$size_value   = isset($_GET['fit']) ? sanitize_text_field(wp_unslash($_GET['fit'])) : '';
$family_value = isset($_GET['family']) ? sanitize_title(wp_unslash($_GET['family'])) : '';
$filtered     = $q_value !== '' || $size_value !== '' || $family_value !== '';

$banner_image = $banner_tyre = $banner_heading = $banner_description = '';
if ($term && in_array($term->taxonomy, ['tyre-type', 'tyre-family'], true)) {
    $banner_image       = get_field('banner_image', $term);
    $banner_tyre        = get_field('banner_tyre', $term);
    $banner_heading     = get_field('banner_heading', $term) ?: $term->name;
    $banner_description = get_field('banner_description', $term) ?: $term->description;
}
$next_link = ((int) $wp_query->max_num_pages > max(1, (int) get_query_var('paged'))) ? get_next_posts_page_link() : '';
?>

<div class="dtc-tyres dtc-archive" id="maincontent">

    <?php if ($banner_heading) : ?>
        <section class="dtc-banner-tyre<?php echo $banner_image ? ' has-media' : ''; ?>">
            <div class="dtc-tyres-container dtc-banner-tyre__inner">
                <?php if ($banner_image) : ?>
                    <div class="dtc-banner-tyre__media">
                        <img class="dtc-banner-tyre__photo" src="<?php echo esc_url($banner_image); ?>" alt="">
                        <?php if ($banner_tyre) : ?>
                            <img class="dtc-banner-tyre__tyre" src="<?php echo esc_url($banner_tyre); ?>" alt="">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="dtc-banner-tyre__text">
                    <p class="dtc-eyebrow">DTC</p>
                    <h1><?php echo esc_html($banner_heading); ?></h1>
                    <?php if ($banner_description) : ?>
                        <p><?php echo esc_html($banner_description); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <div class="dtc-tyres-container">
        <nav class="dtc-breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span aria-hidden="true">/</span>
            <?php if ($term) : ?>
                <a href="<?php echo esc_url(get_post_type_archive_link('tyres')); ?>">All Tyres</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page"><?php echo esc_html($term->name); ?></span>
            <?php else : ?>
                <span aria-current="page">All Tyres</span>
            <?php endif; ?>
        </nav>

        <?php if (!$banner_heading) : ?>
            <h1 class="dtc-category-title">Tyres</h1>
        <?php endif; ?>

        <form class="dtc-fit-bar" id="dtc-fit" method="get" action="<?php echo esc_url($base_url); ?>" role="search">
            <label>
                <span>Tyre size</span>
                <input type="text" name="fit" value="<?php echo esc_attr($size_value); ?>" maxlength="12" placeholder="e.g. 205/55R16" pattern="[0-9]{3}([\/\-][0-9]{2}([Rr\/\-]+[0-9]{2})?)?" title="For example 205, 205/55 or 205/55R16">
            </label>
            <?php if ($families) : ?>
                <label>
                    <span>Family</span>
                    <select name="family">
                        <option value="">All families</option>
                        <?php foreach ($families as $family) : ?>
                            <option value="<?php echo esc_attr($family->slug); ?>" <?php selected($family_value, $family->slug); ?>><?php echo esc_html($family->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            <?php endif; ?>
            <label>
                <span>Search</span>
                <input type="search" name="q" value="<?php echo esc_attr($q_value); ?>" maxlength="60" placeholder="Tyre name">
            </label>
            <div class="dtc-fit-bar__actions">
                <button type="submit" class="dtc-pbtn dtc-pbtn--primary">Find tyres</button>
                <?php if ($filtered) : ?>
                    <a class="dtc-fit-bar__clear" href="<?php echo esc_url($base_url); ?>">Clear</a>
                <?php endif; ?>
            </div>
        </form>

        <?php if ($types) : ?>
            <div class="dtc-subnav">
                <button type="button" class="dtc-subnav__arrow dtc-subnav__arrow--prev" aria-label="Previous" data-subnav-prev>&#8249;</button>
                <button type="button" class="dtc-subnav__arrow dtc-subnav__arrow--next" aria-label="Next" data-subnav-next>&#8250;</button>
                <nav class="dtc-subnav__track" aria-label="All Tyres" data-subnav>
                    <a href="<?php echo esc_url(get_post_type_archive_link('tyres')); ?>" class="<?php echo $term ? '' : 'is-active'; ?>">All Tyres</a>
                    <?php foreach ($types as $type) : ?>
                        <a href="<?php echo esc_url(get_term_link($type)); ?>" class="<?php echo ($term && $term->term_id === $type->term_id) ? 'is-active' : ''; ?>"><?php echo esc_html($type->name); ?></a>
                    <?php endforeach; ?>
                </nav>
            </div>
        <?php endif; ?>

        <h2 class="dtc-sr-only">Tyres listing</h2>
        <?php if (have_posts()) : ?>
            <p class="dtc-result-count"><?php echo (int) $wp_query->found_posts; ?> <?php echo $wp_query->found_posts === 1 ? 'tyre' : 'tyres'; ?></p>
            <div class="dtc-pgrid" data-dtc-grid>
                <?php while (have_posts()) : the_post();
                    get_template_part('template-parts/tyres/card');
                endwhile; ?>
            </div>
            <?php if ($next_link) : ?>
                <div class="dtc-loadmore">
                    <a class="dtc-pbtn dtc-pbtn--secondary" href="<?php echo esc_url($next_link); ?>" data-dtc-loadmore>Load More</a>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <p class="dtc-empty-state">No tyres match your search.</p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
