<?php
/**
 * Product Card Component Template
 *
 * @package DigitalProduk
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$price = get_post_meta( get_the_ID(), '_price', true ) ?: 199000;
$sale_price = get_post_meta( get_the_ID(), '_sale_price', true ) ?: 99000;
$rating = get_post_meta( get_the_ID(), '_rating', true ) ?: '4.9';
$sales_count = get_post_meta( get_the_ID(), '_sales_count', true ) ?: '250';
$file_format = get_post_meta( get_the_ID(), '_file_format', true ) ?: 'Aset Siap Pakai';
$badge = get_post_meta( get_the_ID(), '_badge', true );

$item_cats = get_the_terms( get_the_ID(), 'product_category' );
$cat_slug = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->slug : 'general';
$cat_name = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->name : 'Produk Digital';
$cat_link = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? get_term_link( $item_cats[0] ) : '#';

$cat_meta = digitalproduk_get_category_meta( $cat_slug );
$cat_icon = $cat_meta['icon'];

$cover_img = digitalproduk_get_product_cover( get_the_ID() );
?>
<div class="product-card" data-category="<?php echo esc_attr( $cat_slug ); ?>">
    <div class="product-thumb-wrap">
        <?php if ( ! empty( $badge ) && in_array( strtoupper( $badge ), [ 'BEST SELLER', 'PROMO', 'DISKON' ], true ) ) : ?>
            <span class="product-badge <?php echo $badge === 'BARU' ? 'badge-new' : ''; ?>">
                <?php echo esc_html( $badge ); ?>
            </span>
        <?php endif; ?>

        <a href="<?php the_permalink(); ?>" class="product-thumb-link" aria-label="<?php the_title_attribute(); ?>">
            <?php if ( ! empty( $cover_img ) ) : ?>
                <img src="<?php echo esc_url( $cover_img ); ?>" 
                     alt="<?php the_title_attribute(); ?>" 
                     class="product-thumb-img" 
                     loading="lazy" />
            <?php else : ?>
                <div class="product-thumb-placeholder">
                    <span class="placeholder-icon">
                        <?php echo digitalproduk_get_icon( $cat_icon, 'placeholder-svg', 40 ); ?>
                    </span>
                </div>
            <?php endif; ?>
        </a>
    </div>

    <div class="product-body">
        <div class="product-meta-header">
            <a href="<?php echo esc_url( $cat_link ); ?>" class="product-category">
                <span class="product-cat-icon-wrap">
                    <?php echo digitalproduk_get_icon( $cat_icon, 'cat-mini-icon', 14 ); ?>
                </span>
                <span><?php echo esc_html( $cat_name ); ?></span>
            </a>
            <span class="product-rating">
                <?php echo digitalproduk_get_icon( 'star', 'star-gold', 13 ); ?>
                <span><?php echo esc_html( $rating ); ?></span>
                <span class="sales-muted">(<?php echo esc_html( $sales_count ); ?>)</span>
            </span>
        </div>

        <h3 class="product-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <p class="product-excerpt"><?php echo wp_trim_words( get_the_excerpt() ?: get_the_content(), 10 ); ?></p>

        <div class="product-footer">
            <div class="price-wrap">
                <span class="price-original"><?php echo digitalproduk_price( $price ); ?></span>
                <span class="price-current"><?php echo digitalproduk_price( $sale_price ); ?></span>
            </div>
            <div class="card-action-btns">
                <a href="<?php the_permalink(); ?>" class="btn btn-secondary btn-sm" title="Lihat Detail Produk">
                    Detail
                </a>
                <a href="<?php echo esc_url( home_url( '/checkout/?product_id=' . get_the_ID() ) ); ?>" class="btn btn-primary btn-sm">
                    <span>Beli</span>
                    <?php echo digitalproduk_get_icon( 'shopping-bag', 'btn-icon-sm', 14 ); ?>
                </a>
            </div>
        </div>
    </div>
</div>
