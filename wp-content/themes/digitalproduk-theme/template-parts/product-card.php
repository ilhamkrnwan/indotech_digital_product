<?php
/**
 * Product Card Component Template
 * Indotech Technical Commerce Design System
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
$file_format = get_post_meta( get_the_ID(), '_file_format', true ) ?: 'Download Langsung (.zip)';
$badge = get_post_meta( get_the_ID(), '_badge', true );

$item_cats = get_the_terms( get_the_ID(), 'product_category' );
$cat_slug = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->slug : 'general';
$cat_name = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->name : 'Produk Digital';
$cat_link = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? get_term_link( $item_cats[0] ) : '#';

$cat_meta = digitalproduk_get_category_meta( $cat_slug );
$cat_icon = $cat_meta['icon'];

$cover_img = digitalproduk_get_product_cover( get_the_ID() );

// Tech tags (from meta or category sensible fallback)
$tech_stack = get_post_meta( get_the_ID(), '_tech_stack', true );
if ( ! empty( $tech_stack ) ) {
    $tech_pills = is_array( $tech_stack ) ? $tech_stack : array_map( 'trim', explode( ',', $tech_stack ) );
} else {
    $default_tags = [
        'source-code'     => [ 'Fullstack', 'Clean Code', 'TypeScript' ],
        'ui-ux-figma'     => [ 'Figma Tokens', 'Auto-Layout 5', 'WCAG AA' ],
        'template-notion' => [ 'Notion OS', 'Database Linked', 'Automation' ],
        'e-book'          => [ 'PDF Guide', 'Actionable Steps', 'Playbook' ],
        'saas-tools'      => [ 'Automasi', 'Script Mandiri', 'API Ready' ],
    ];
    $tech_pills = $default_tags[$cat_slug] ?? [ 'Aset Siap Pakai', 'Lisensi Bebas' ];
}
?>
<article class="product-card" data-category="<?php echo esc_attr( $cat_slug ); ?>">
    <div class="product-thumb-wrap">
        <?php if ( ! empty( $badge ) ) : ?>
            <span class="product-badge <?php echo in_array( strtoupper( $badge ), [ 'BARU', 'NEW' ], true ) ? 'badge-new' : ''; ?>">
                <?php echo esc_html( $badge ); ?>
            </span>
        <?php else : ?>
            <span class="product-badge">
                <?php echo esc_html( $cat_name ); ?>
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
        <div class="tech-tags-list" style="margin-bottom: 0.75rem; gap: 0.35rem;">
            <?php foreach ( array_slice( $tech_pills, 0, 3 ) as $pill ) : ?>
                <span class="tech-tag-pill"><?php echo esc_html( $pill ); ?></span>
            <?php endforeach; ?>
        </div>

        <h3 class="product-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <p class="product-excerpt"><?php echo wp_trim_words( get_the_excerpt() ?: get_the_content(), 12 ); ?></p>

        <div class="product-meta-specs">
            <div class="spec-item">
                <span class="spec-label">Lisensi</span>
                <span class="spec-value">Komersial Bebas</span>
            </div>
            <div class="spec-item">
                <span class="spec-label">Akses File</span>
                <span class="spec-value"><?php echo esc_html( $file_format ); ?></span>
            </div>
        </div>

        <div class="product-footer">
            <div class="price-wrap">
                <span class="price-original"><?php echo digitalproduk_price( $price ); ?></span>
                <span class="price-current"><?php echo digitalproduk_price( $sale_price ); ?></span>
            </div>
            <div class="card-action-btns">
                <a href="<?php the_permalink(); ?>" class="btn btn-secondary btn-sm" title="Lihat Spesifikasi &amp; Detail">
                    Detail
                </a>
                <a href="<?php echo esc_url( home_url( '/checkout/?product_id=' . get_the_ID() ) ); ?>" class="btn btn-primary btn-sm">
                    <span>Beli</span>
                    <?php echo digitalproduk_get_icon( 'arrow-right', 'btn-icon-sm', 13 ); ?>
                </a>
            </div>
        </div>
    </div>
</article>
