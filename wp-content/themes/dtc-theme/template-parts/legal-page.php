<?php
get_header();

$sidebar_links = dtc_legal_sidebar_links((int) get_queried_object_id());
?>
<main id="maincontent" class="dtc-legal-page">
    <div class="dtc-legal-page__layout">
        <nav class="dtc-legal-page__nav" aria-label="Legal information">
            <ul>
                <?php foreach ($sidebar_links as $link) : ?>
                    <li<?php echo $link['current'] ? ' class="is-current"' : ''; ?>>
                        <a href="<?php echo esc_url($link['url']); ?>"<?php echo $link['current'] ? ' aria-current="page"' : ''; ?>><?php echo esc_html($link['title']); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <article class="dtc-legal-page__content">
            <?php while (have_posts()) : the_post(); ?>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            <?php endwhile; ?>
        </article>
    </div>
</main>
<?php get_footer(); ?>
