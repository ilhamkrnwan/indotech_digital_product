<?php
/**
 * Single Digital Product Template (Rich Product Showcase)
 *
 * @package DigitalProduk
 */

get_header();

while ( have_posts() ) :
    the_post();

    $product_id = get_the_ID();
    $price = get_post_meta( $product_id, '_price', true ) ?: 199000;
    $sale_price = get_post_meta( $product_id, '_sale_price', true ) ?: 99000;
    $rating = get_post_meta( $product_id, '_rating', true ) ?: '4.95';
    $sales_count = get_post_meta( $product_id, '_sales_count', true ) ?: '380';
    $file_format = get_post_meta( $product_id, '_file_format', true ) ?: 'Source Code / Aset Digital';
    $badge = get_post_meta( $product_id, '_badge', true ) ?: 'BEST SELLER';
    
    // Tech Stack / Tools Tags (misal: Laravel, Vue, Figma, React, AI)
    $tech_stack = get_post_meta( $product_id, '_tech_stack', true );
    $tech_tags = ! empty( $tech_stack ) ? ( is_array( $tech_stack ) ? $tech_stack : explode( ',', $tech_stack ) ) : [
        'Production Ready',
        'Commercial License',
        'Documentation Included',
        'Lifetime Updates'
    ];

    $features_meta = get_post_meta( $product_id, '_features', true );
    $features = ! empty( $features_meta ) ? ( is_array( $features_meta ) ? $features_meta : explode( "\n", $features_meta ) ) : [
        'Lisensi Komersial (Boleh untuk proyek klien & unlimited domain)',
        'Dokumentasi Instalasi & Panduan Konfigurasi Lengkap',
        'Update Gratis Selamanya ke Versi Berikutnya',
        'Source File Bersih Tanpa Obfuscation',
        'Dukungan Teknis Direct Chat'
    ];

    $item_cats = get_the_terms( $product_id, 'product_category' );
    $cat_name = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->name : 'Produk Digital';
    $cat_link = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? get_term_link( $item_cats[0] ) : '#';
    $cat_slug = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->slug : 'general';
    ?>

    <!-- Breadcrumb & Back Link -->
    <div class="product-breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb-inner">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span>/</span>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>">Semua Produk</a>
                <span>/</span>
                <a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_name ); ?></a>
                <span>/</span>
                <span class="current-crumb"><?php the_title(); ?></span>
            </div>
        </div>
    </div>

    <!-- Product Hero Overview Section -->
    <section class="section product-hero-section">
        <div class="container">
            <div class="single-product-grid">
                
                <!-- Left Column: Visual Showcase -->
                <div class="single-product-visual">
                    <div class="single-thumb-frame">
                        <?php if ( $badge ) : ?>
                            <span class="product-badge <?php echo $badge === 'BARU' ? 'badge-new' : ''; ?>">
                                <?php echo esc_html( $badge ); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'large', [ 'class' => 'single-product-img' ] ); ?>
                        <?php else : ?>
                            <div class="single-placeholder-banner">
                                <span class="placeholder-emoji">💎</span>
                                <h3 class="placeholder-title"><?php the_title(); ?></h3>
                                <p class="placeholder-sub"><?php echo esc_html( $file_format ); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="file-format-badge">
                            📦 Format: <strong><?php echo esc_html( $file_format ); ?></strong>
                        </div>
                    </div>

                    <!-- Trust Cards Under Image -->
                    <div class="trust-mini-grid">
                        <div class="trust-mini-item">
                            <span class="icon">⚡</span>
                            <div>
                                <strong>Instant Delivery</strong>
                                <p>File dikirim langsung setelah bayar</p>
                            </div>
                        </div>
                        <div class="trust-mini-item">
                            <span class="icon">🛡️</span>
                            <div>
                                <strong>Midtrans Verified</strong>
                                <p>QRIS, VA Bank & E-Wallet Aman</p>
                            </div>
                        </div>
                        <div class="trust-mini-item">
                            <span class="icon">🔄</span>
                            <div>
                                <strong>Free Updates</strong>
                                <p>Dapatkan revisi & versi terbaru gratis</p>
                            </div>
                        </div>
                        <div class="trust-mini-item">
                            <span class="icon">💼</span>
                            <div>
                                <strong>Commercial License</strong>
                                <p>Bebas pakai untuk proyek klien</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Detail, Pricing & Buy Card -->
                <div class="single-product-info">
                    <a href="<?php echo esc_url( $cat_link ); ?>" class="product-category-pill">
                        🏷️ <?php echo esc_html( $cat_name ); ?>
                    </a>

                    <h1 class="single-title"><?php the_title(); ?></h1>

                    <div class="single-rating-bar">
                        <span class="rating-stars">★★★★★</span>
                        <strong class="rating-num"><?php echo esc_html( $rating ); ?></strong>
                        <span class="rating-divider">•</span>
                        <span class="sales-text">🔥 <strong><?php echo esc_html( $sales_count ); ?>+</strong> Pembeli Puas</span>
                    </div>

                    <!-- Tech stack tags -->
                    <div class="tech-tags-list">
                        <?php foreach ( $tech_tags as $tag ) : ?>
                            <span class="tech-tag-item"><?php echo esc_html( trim( $tag ) ); ?></span>
                        <?php endforeach; ?>
                    </div>

                    <!-- Buy Box Card -->
                    <div class="buy-action-card">
                        <div class="price-header-row">
                            <div class="price-display">
                                <span class="current-price-big"><?php echo digitalproduk_price( $sale_price ); ?></span>
                                <span class="original-price-strike"><?php echo digitalproduk_price( $price ); ?></span>
                            </div>
                            <span class="discount-pill">Hemat <?php echo round( ( ( $price - $sale_price ) / $price ) * 100 ); ?>%</span>
                        </div>

                        <!-- Midtrans Snap Button -->
                        <button type="button" class="btn btn-primary btn-lg btn-block btn-buy-trigger"
                            data-id="<?php echo esc_attr( $product_id ); ?>"
                            data-title="<?php the_title_attribute(); ?>"
                            data-price="<?php echo esc_attr( digitalproduk_price( $sale_price ) ); ?>"
                            style="font-size: 1.15rem; padding: 1.15rem;">
                            Beli & Download Sekarang ⚡
                        </button>

                        <div class="buy-card-sublinks">
                            <a href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo Indotech DigitalProduk, saya ingin tanya detail produk: ' . get_the_title() ); ?>" target="_blank" rel="noopener">
                                💬 Tanya Admin via WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- What You Get Key Benefits -->
                    <div class="key-benefits-box">
                        <h3 class="box-title">🎁 Apa yang Anda Dapatkan di Paket Ini:</h3>
                        <ul class="benefits-checklist">
                            <?php foreach ( $features as $f ) : ?>
                                <li>
                                    <span class="check-circle">✓</span>
                                    <span><?php echo esc_html( trim( $f ) ); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- Product Detailed Description & Specs Tabs -->
    <section class="section product-content-section">
        <div class="container">
            <div class="content-spec-grid">
                
                <!-- Main Description -->
                <div class="main-content-column">
                    <div class="playful-box content-panel">
                        <h2 class="panel-heading">Deskripsi & Spesifikasi Lengkap</h2>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar FAQ & Guarantee -->
                <div class="sidebar-column">
                    <div class="playful-box sidebar-card card-yellow">
                        <h3>🛡️ Jaminan Kepuasan 100%</h3>
                        <p>File terverifikasi, bebas virus/malware, dan dipastikan berjalan sesuai panduan dokumentasi resmi.</p>
                    </div>

                    <div class="playful-box sidebar-card card-cyan">
                        <h3>💻 Cara Akses Produk</h3>
                        <ol style="margin-left: 1.25rem; font-size: 0.95rem; line-height: 1.6;">
                            <li>Klik tombol <strong>Beli & Download</strong>.</li>
                            <li>Lakukan pembayaran instan via Midtrans (QRIS/VA).</li>
                            <li>Link download Google Drive langsung aktif & dikirim ke email Anda.</li>
                        </ol>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Related Products in Category -->
    <?php
    $related_args = [
        'post_type'      => 'digital_product',
        'posts_per_page' => 3,
        'post__not_in'   => [ $product_id ],
    ];

    if ( ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ) {
        $related_args['tax_query'] = [
            [
                'taxonomy' => 'product_category',
                'field'    => 'term_id',
                'terms'    => $item_cats[0]->term_id,
            ]
        ];
    }

    $related_query = new WP_Query( $related_args );

    // Fallback jika belum ada produk lain dalam kategori sama
    if ( ! $related_query->have_posts() ) {
        $related_query = new WP_Query([
            'post_type'      => 'digital_product',
            'posts_per_page' => 3,
            'post__not_in'   => [ $product_id ],
        ]);
    }

    if ( $related_query->have_posts() ) :
        ?>
        <section class="section related-products-section">
            <div class="container">
                <div class="section-header">
                    <div class="playful-sticker">REKOMENDASI LAIN</div>
                    <h2 class="section-title">Produk Terkait Dalam Kategori Ini</h2>
                </div>
                <div class="products-grid">
                    <?php
                    while ( $related_query->have_posts() ) :
                        $related_query->the_post();
                        get_template_part( 'template-parts/product-card' );
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </section>
        <?php
    endif;
    ?>

    <!-- Checkout Modal Included -->
    <?php get_template_part( 'template-parts/checkout-modal' ); ?>

    <?php
endwhile;

get_footer();
