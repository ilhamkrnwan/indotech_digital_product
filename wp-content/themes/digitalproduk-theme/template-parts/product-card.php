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
        <!-- Mini Paint Splash di Sudut Gambar -->
        <svg class="thumb-paint-accent" viewBox="0 0 65 65" fill="none" aria-hidden="true">
            <path d="M10 0 C25 10 40 5 55 18 C62 25 65 45 65 45 V0 H10 Z" fill="#152cab" opacity="0.85" />
            <path d="M30 0 C45 8 55 12 65 15 V0 H30 Z" fill="#f7d801" />
            <circle cx="35" cy="28" r="2.5" fill="#152cab" />
        </svg>

        <a href="<?php the_permalink(); ?>" class="product-thumb-link" aria-label="<?php the_title_attribute(); ?>">
            <?php if ( ! empty( $cover_img ) ) : ?>
                <img src="<?php echo esc_url( $cover_img ); ?>" 
                     alt="<?php the_title_attribute(); ?>" 
                     class="product-thumb-img" 
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
                <!-- Sapuan Kuas Asli di Belakang Label Harga -->
                <div class="price-brush-tag">
                    <svg class="price-brush-bg" viewBox="0 0 120 30" fill="none" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M2 18 C25 10 65 20 110 14 C118 13 119 18 116 22 C90 26 50 25 10 24 C4 23 1 20 2 18 Z" fill="#f7d801" />
                        <path d="M8 12 C35 6 75 14 112 10" stroke="#fef08a" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <span class="price-current price-val-bold"><?php echo digitalproduk_price( $sale_price ); ?></span>
                </div>
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
