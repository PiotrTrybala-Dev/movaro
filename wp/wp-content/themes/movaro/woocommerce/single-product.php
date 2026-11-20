<?php

defined('ABSPATH') || exit;

get_header();

while (have_posts()) :
    the_post();

    $wc_product = wc_get_product(get_the_ID());
    if (! $wc_product) {
        continue;
    }

    $regular_price = (float) $wc_product->get_regular_price();
    $sale_price    = (float) $wc_product->get_sale_price();
    $is_on_sale    = $wc_product->is_on_sale() && $sale_price > 0 && $regular_price > 0;

    $discount_rate = $is_on_sale
        ? (($regular_price - $sale_price) / $regular_price)
        : 0;

    $image_id    = (int) $wc_product->get_image_id();
    $gallery_ids = $wc_product->get_gallery_image_ids();
    $height      = $wc_product->get_height();
    $width       = $wc_product->get_width();
    $description = wpautop($wc_product->get_description());
?>

    <article id="product-<?php the_ID(); ?>" <?php post_class('w-single-product'); ?>>
        <div class="container">
            <div class="w-single-product__grid">
                <div class="w-single-product__media">
                    <?php if ($is_on_sale && $discount_rate > 0) : ?>
                        <span class="b-shop__item-discount">
                            <?= esc_html__('Dziś', 'movaro') ?> -<?= number_format($discount_rate * 100, 0) ?>%
                        </span>
                    <?php endif; ?>

                    <div class="w-single-product__main-image">
                        <?php if ($image_id) : ?>
                            <?= wp_get_attachment_image($image_id, 'large') ?>
                        <?php else : ?>
                            <span><?= esc_html__('Thumbnail', 'movaro') ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if (! empty($gallery_ids)) : ?>
                        <div class="w-single-product__gallery">
                            <?php foreach ($gallery_ids as $gallery_id) : ?>
                                <?= wp_get_attachment_image((int) $gallery_id, 'thumbnail') ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="w-single-product__summary">
                    <h1 class="w-single-product__title"><?= esc_html($wc_product->get_name()) ?></h1>

                    <div class="b-shop__item-price">
                        <?php if ($is_on_sale) : ?>
                            <span class="b-shop__item-price-discount">
                                <span class="b-shop__item-price-discount main"><?= number_format($sale_price, 2, ',', '') ?><?= esc_html__('zł', 'movaro') ?></span>
                                <span class="b-shop__item-price-discount secondary"><?= number_format($regular_price, 2, ',', '') ?><?= esc_html__('zł', 'movaro') ?></span>
                            </span>
                        <?php else : ?>
                            <span class="b-shop__item-price-regular"><?= number_format($regular_price ?: (float) $wc_product->get_price(), 2, ',', '') ?><?= esc_html__('zł', 'movaro') ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if ($height || $width) : ?>
                        <div class="b-shop__item-dimensions">
                            <?php if ($height) : ?>
                                <div class="b-shop__item-dimensions-item">
                                    <h5><?= esc_html($height) ?><?= esc_html__('cm', 'movaro') ?></h5>
                                    <span><?= esc_html__('Wysokość', 'movaro') ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($width) : ?>
                                <div class="b-shop__item-dimensions-item">
                                    <h5><?= esc_html($width) ?><?= esc_html__('cm', 'movaro') ?></h5>
                                    <span><?= esc_html__('Szerokość', 'movaro') ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($description) : ?>
                        <div class="w-single-product__description">
                            <?= $description ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    woocommerce_template_single_add_to_cart();
                    ?>
                </div>
            </div>
        </div>
    </article>

<?php endwhile;

get_footer();
