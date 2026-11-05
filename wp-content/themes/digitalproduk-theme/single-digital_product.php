<?php
/**
 * Single Digital Product Template
 *
 * @package DigitalProduk
 */

get_header();

while ( have_posts() ) :
    the_post();

    $price = get_post_meta( get_the_ID(), '_price', true ) ?: 199000;
    $sale_price = get_post_meta( get_the_ID(), '_sale_price', true ) ?: 99000;
    $rating = get_post_meta( get_the_ID(), '_rating', true ) ?: '4.9';
    $sales_count = get_post_meta( get_the_ID(), '_sales_count', true ) ?: '250';
    $file_format = get_post_meta( get_the_ID(), '_file_format', true ) ?: 'ZIP File + Dokumentasi';
    $badge = get_post_meta( get_the_ID(), '_badge', true ) ?: 'BEST SELLER';
    $features_meta = get_post_meta( get_the_ID(), '_features', true );
    $features = ! empty( $features_meta ) ? ( is_array( $features_meta ) ? $features_meta : explode( "\n", $features_meta ) ) : [
        'Lisensi Komersial Lengkap',
        'Dokumentasi Panduan Lengkap',
        'Update Gratis Selamanya'
    ];

    $item_cats = get_the_terms( get_the_ID(), 'product_category' );
    $cat_name = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->name : 'Produk Digital';
    ?>

    <div class="container section">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3.5rem; align-items: start;">
            <!-- Left Thumbnail -->
            <div>
                <div style="position: relative; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--border-color); background: var(--bg-card); min-height: 380px; display: flex; align-items: center; justify-content: center;">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'large', [ 'style' => 'width: 100%; height: auto;' ] ); ?>
                    <?php else : ?>
                        <div style="font-size: 5rem; padding: 4rem;">💎</div>
                    <?php endif; ?>
                    <span class="product-badge" style="top: 1.5rem; right: 1.5rem;"><?php echo esc_html( $badge ); ?></span>
                </div>
            </div>

            <!-- Right Detail -->
            <div>
                <span class="product-category" style="font-size: 0.9rem;"><?php echo esc_html( $cat_name ); ?></span>
                <h1 style="font-family: var(--font-heading); font-size: 2.5rem; margin: 0.5rem 0 1rem; line-height: 1.25;"><?php the_title(); ?></h1>
                
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; font-size: 0.95rem; color: var(--text-secondary);">
                    <span style="color: #facc15; font-weight: 700;">★ <?php echo esc_html( $rating ); ?></span>
                    <span>•</span>
                    <span><?php echo esc_html( $sales_count ); ?> Pembeli Puas</span>
                    <span>•</span>
                    <span style="background: rgba(255,255,255,0.08); padding: 0.2rem 0.65rem; border-radius: var(--radius-sm);"><?php echo esc_html( $file_format ); ?></span>
                </div>

                <div style="background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.5rem; margin-bottom: 2rem;">
                    <div style="display: flex; align-items: baseline; gap: 0.75rem; margin-bottom: 1.25rem;">
                        <span style="font-size: 2.25rem; font-family: var(--font-heading); font-weight: 800; color: #38bdf8;"><?php echo digitalproduk_price( $sale_price ); ?></span>
                        <span style="text-decoration: line-through; color: var(--text-muted); font-size: 1.1rem;"><?php echo digitalproduk_price( $price ); ?></span>
                    </div>

                    <a href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo, saya ingin order: ' . get_the_title() . ' (' . digitalproduk_price( $sale_price ) . ')' ); ?>" 
                        target="_blank" rel="noopener" 
                        class="btn btn-primary btn-lg btn-block" style="margin-bottom: 1rem;">
                        Beli & Download Sekarang ⚡
                    </a>

                    <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.85rem;">
                        <span>🔒 Checkout Aman • Garansi Akses Selamanya</span>
                    </div>
                </div>

                <h3 style="font-family: var(--font-heading); font-size: 1.2rem; margin-bottom: 0.75rem;">Apa yang Anda Dapatkan:</h3>
                <ul class="product-features-list" style="margin-bottom: 2rem;">
                    <?php foreach ( $features as $f ) : ?>
                        <li style="font-size: 0.95rem;"><?php echo esc_html( trim( $f ) ); ?></li>
                    <?php endforeach; ?>
                </ul>

                <h3 style="font-family: var(--font-heading); font-size: 1.2rem; margin-bottom: 0.75rem;">Deskripsi Produk:</h3>
                <div style="color: var(--text-secondary); line-height: 1.7; font-size: 1rem;">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>

    <?php
endwhile;

get_footer();
