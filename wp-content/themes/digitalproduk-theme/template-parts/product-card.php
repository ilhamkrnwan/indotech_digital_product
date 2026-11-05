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
$badge = get_post_meta( get_the_ID(), '_badge', true ) ?: 'POPULER';
$features_meta = get_post_meta( get_the_ID(), '_features', true );
$features = ! empty( $features_meta ) ? ( is_array( $features_meta ) ? $features_meta : explode( "\n", $features_meta ) ) : [
    'Lisensi Komersial Lengkap',
    'Panduan & Dokumentasi',
    'Update Gratis Selamanya'
];

$item_cats = get_the_terms( get_the_ID(), 'product_category' );
$cat_slug = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->slug : 'general';
$cat_name = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->name : 'Produk Digital';
$cat_link = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? get_term_link( $item_cats[0] ) : '#';

// Icon per category
$category_icons = [
    'source-code'     => '💻',
    'ui-ux-figma'     => '🎨',
    'template-notion' => '📋',
    'e-book'          => '📚',
    'saas-tools'      => '⚡',
];
$cat_icon = $category_icons[$cat_slug] ?? '📦';
?>
<div class="product-card" data-category="<?php echo esc_attr( $cat_slug ); ?>">
    <div class="product-thumb-wrap">
        <?php if ( $badge ) : ?>
            <span class="product-badge <?php echo $badge === 'BARU' ? 'badge-new' : ''; ?>">
                <?php echo esc_html( $badge ); ?>
            </span>
        <?php endif; ?>

        <a href="<?php the_permalink(); ?>" class="product-thumb-link" aria-label="<?php the_title_attribute(); ?>">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'large', [ 'class' => 'product-thumb' ] ); ?>
            <?php else : ?>
                <div class="product-thumb-placeholder">
                    <span class="placeholder-icon"><?php echo esc_html( $cat_icon ); ?></span>
                </div>
            <?php endif; ?>
        </a>

        <span class="product-format-tag"><?php echo esc_html( $file_format ); ?></span>
    </div>

    <div class="product-body">
        <div class="product-meta-header">
            <a href="<?php echo esc_url( $cat_link ); ?>" class="product-category">
                <?php echo esc_html( $cat_icon . ' ' . $cat_name ); ?>
            </a>
            <span class="product-rating">★ <?php echo esc_html( $rating ); ?> (<?php echo esc_html( $sales_count ); ?>)</span>
        </div>

        <h3 class="product-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <p class="product-excerpt"><?php echo wp_trim_words( get_the_excerpt() ?: get_the_content(), 14 ); ?></p>

        <ul class="product-features-list">
            <?php foreach ( array_slice( $features, 0, 3 ) as $feature ) : ?>
                <li><?php echo esc_html( trim( $feature ) ); ?></li>
            <?php endforeach; ?>
        </ul>

        <div class="product-footer">
            <div class="price-wrap">
                <span class="price-original"><?php echo digitalproduk_price( $price ); ?></span>
                <span class="price-current"><?php echo digitalproduk_price( $sale_price ); ?></span>
            </div>
            <div class="card-action-btns">
                <a href="<?php the_permalink(); ?>" class="btn btn-secondary btn-sm" title="Lihat Detail Produk">
                    Detail
                </a>
                <button type="button" class="btn btn-primary btn-sm btn-buy-trigger" 
                    data-id="<?php the_ID(); ?>"
                    data-title="<?php the_title_attribute(); ?>" 
                    data-price="<?php echo esc_attr( digitalproduk_price( $sale_price ) ); ?>">
                    Beli ⚡
                </button>
            </div>
        </div>
    </div>
</div>
