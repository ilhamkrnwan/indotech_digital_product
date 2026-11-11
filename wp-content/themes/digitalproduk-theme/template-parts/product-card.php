<?php
/**
 * Product Card Component Template
 * Clean, focused, anti-slop
 *
 * @package DigitalProduk
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$price = get_post_meta( get_the_ID(), '_price', true ) ?: 199000;
$sale_price = get_post_meta( get_the_ID(), '_sale_price', true ) ?: $price;

$item_cats = get_the_terms( get_the_ID(), 'product_category' );
$cat_slug = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->slug : 'general';
$cat_name = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->name : 'Produk Digital';
$cat_link = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? get_term_link( $item_cats[0] ) : '#';

$cover_img = digitalproduk_get_product_cover( get_the_ID() );
?>
<article class="product-card" data-category="<?php echo esc_attr( $cat_slug ); ?>">
    <div class="product-thumb-wrap">
        <a href="<?php the_permalink(); ?>" class="product-thumb-link" aria-label="<?php the_title_attribute(); ?>">
            <?php if ( ! empty( $cover_img ) ) : ?>
                <img src="<?php echo esc_url( $cover_img ); ?>" 
                     alt="<?php the_title_attribute(); ?>" 
                     class="product-thumb-img" 
                     width="1600"
                     height="1000"
                     loading="lazy" />
            <?php else : ?>
                <div class="product-thumb-placeholder">
                    <span><?php echo esc_html( $cat_name ); ?></span>
                </div>
            <?php endif; ?>
        </a>
    </div>

    <div class="product-body">
        <div class="product-meta-header">
            <a href="<?php echo esc_url( $cat_link ); ?>" class="product-category">
                <?php echo esc_html( $cat_name ); ?>
            </a>
        </div>

        <h3 class="product-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <p class="product-excerpt"><?php echo wp_trim_words( get_the_excerpt() ?: get_the_content(), 14 ); ?></p>

        <div class="product-footer">
            <div class="price-wrap">
                <?php if ( $price > $sale_price ) : ?>
                    <span class="price-original"><?php echo digitalproduk_price( $price ); ?></span>
                <?php endif; ?>
                <span class="price-current price-val-bold"><?php echo digitalproduk_price( $sale_price ); ?></span>
            </div>
            <div class="card-action-btns">
                <a href="<?php the_permalink(); ?>" class="btn btn-secondary btn-sm">
                    Detail
                </a>
                <a href="<?php echo esc_url( home_url( '/checkout/?product_id=' . get_the_ID() ) ); ?>" class="btn btn-primary btn-sm">
                    Beli
                </a>
            </div>
        </div>
    </div>
</article>
