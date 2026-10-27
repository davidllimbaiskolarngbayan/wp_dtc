<?php
// Product card (AU brandsite layout): overlapping tyre image, badge and feature tags, brand, name, excerpt, buttons.
$image = dtc_tyre_image_url(get_the_ID(), 'medium_large');
$tag   = get_field('tyre_tag');
$feats = get_the_terms(get_the_ID(), 'tyre-feature');
$feats = ($feats && !is_wp_error($feats)) ? $feats : [];
?>
<div class="dtc-pcard-cell">
    <div class="dtc-pcard">
        <div class="dtc-pcard__header">
            <div class="dtc-pcard__image">
                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                    <?php if ($image) : ?>
                        <img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                    <?php endif; ?>
                </a>
            </div>
            <div class="dtc-pcard__tags">
                <?php if ($tag) : ?>
                    <div class="dtc-feature-tag dtc-feature-tag--<?php echo esc_attr($tag['value']); ?>"><?php echo esc_html($tag['label']); ?></div>
                <?php endif; ?>
                <ul class="dtc-ptags">
                    <?php if (get_field('run_on_flat')) : ?>
                        <li><?php echo dtc_icon_check(); // phpcs:ignore WordPress.Security.EscapeOutput ?><span>Run on Flat</span></li>
                    <?php endif; ?>
                    <?php foreach (array_slice($feats, 0, 3) as $feat) : ?>
                        <li><?php echo dtc_icon_check(); // phpcs:ignore WordPress.Security.EscapeOutput ?><span><?php echo esc_html($feat->name); ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="dtc-pcard__body">
            <div class="dtc-pcard__brand">DTC</div>
            <h4 class="dtc-pcard__name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <p class="dtc-pcard__excerpt"><?php echo esc_html(get_field('short_description')); ?></p>
        </div>
        <div class="dtc-pcard__footer">
            <a class="dtc-pbtn dtc-pbtn--primary" href="<?php echo esc_url(home_url('/register-your-tyres/')); ?>">Register Tyres</a>
            <a class="dtc-pbtn dtc-pbtn--secondary" href="<?php the_permalink(); ?>">View Details</a>
        </div>
    </div>
</div>
