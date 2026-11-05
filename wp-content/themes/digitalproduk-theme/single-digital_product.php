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
    
    // Value & Feature Highlights Tags
    $tech_stack = get_post_meta( $product_id, '_tech_stack', true );
    $tech_tags = ! empty( $tech_stack ) ? ( is_array( $tech_stack ) ? $tech_stack : explode( ',', $tech_stack ) ) : [
        'Siap Pakai Langsung',
        'File Terstruktur & Rapi',
        'Lisensi Komersial Penuh',
        'Update Versi Gratis'
    ];

    $features_meta = get_post_meta( $product_id, '_features', true );
    $features = ! empty( $features_meta ) ? ( is_array( $features_meta ) ? $features_meta : explode( "\n", $features_meta ) ) : [
        'Lisensi Komersial Penuh (Bebas untuk proyek pribadi, klien, & bisnis)',
        'Panduan Instalasi & Tutorial Lengkap Langkah demi Langkah',
        'Update Versi Terbaru Gratis Selamanya Tanpa Biaya Tambahan',
        'File Mentah Lengkap, Rapi, & Mudah Dikustomisasi',
        'Dukungan Tanya Jawab & Bantuan Langsung via WhatsApp'
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
                
                <!-- Left Column: Visual Showcase (Multi-Image Gallery) -->
                <div class="single-product-visual">
                    <?php $slides = digitalproduk_get_product_slides( $product_id ); ?>
                    
                    <div class="single-gallery-card tilt-left">
                        <!-- Playful Washi Tape (Never Clipped) -->
                        <div class="card-tape"></div>

                        <?php if ( $badge ) : ?>
                            <span class="product-badge <?php echo $badge === 'BARU' ? 'badge-new' : ''; ?>">
                                <?php echo esc_html( $badge ); ?>
                            </span>
                        <?php endif; ?>

                        <!-- Main Gallery Viewport -->
                        <div class="gallery-main-frame">
                            <img id="mainProductPreview" 
                                 src="<?php echo esc_url( $slides[0]['url'] ); ?>" 
                                 alt="<?php the_title_attribute(); ?>" 
                                 class="main-preview-img" />
                            
                            <div class="file-format-badge">
                                <?php echo digitalproduk_get_icon( 'file-text', 'mini-tag-icon', 13 ); ?>
                                <span>Format: <strong><?php echo esc_html( $file_format ); ?></strong></span>
                            </div>
                        </div>

                        <!-- Thumbnails Strip (Multiple Images Showcase) -->
                        <div class="gallery-thumbs-grid">
                            <?php foreach ( $slides as $i => $slide ) : ?>
                                <button type="button" 
                                        class="gallery-thumb-item <?php echo $i === 0 ? 'active' : ''; ?>"
                                        data-preview="<?php echo esc_url( $slide['url'] ); ?>"
                                        data-title="<?php echo esc_attr( $slide['title'] ); ?>"
                                        title="<?php echo esc_attr( $slide['title'] ); ?>">
                                    <img src="<?php echo esc_url( $slide['url'] ); ?>" alt="Slide <?php echo $i + 1; ?>" />
                                    <span class="thumb-badge"><?php echo esc_html( $slide['tag'] ); ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Trust Cards Under Image (Friendly Commercial Store Vibe) -->
                    <div class="trust-mini-grid">
                        <div class="trust-mini-item">
                            <div class="trust-icon-box bg-yellow">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                </svg>
                            </div>
                            <div>
                                <strong>Akses Instan 24 Jam</strong>
                                <p>File &amp; link Google Drive terkirim otomatis</p>
                            </div>
                        </div>
                        <div class="trust-mini-item">
                            <div class="trust-icon-box bg-cyan">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    <path d="M9 12l2 2 4-4"></path>
                                </svg>
                            </div>
                            <div>
                                <strong>Midtrans Resmi</strong>
                                <p>QRIS, VA Bank &amp; E-Wallet 100% aman</p>
                            </div>
                        </div>
                        <div class="trust-mini-item">
                            <div class="trust-icon-box bg-pink">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"></path>
                                </svg>
                            </div>
                            <div>
                                <strong>Update Gratis Selamanya</strong>
                                <p>Dapatkan pembaruan versi baru tanpa biaya</p>
                            </div>
                        </div>
                        <div class="trust-mini-item">
                            <div class="trust-icon-box bg-green">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                            </div>
                            <div>
                                <strong>Lisensi Komersial</strong>
                                <p>Bebas untuk proyek pribadi &amp; klien bisnis</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Detail, Pricing & Buy Card -->
                <div class="single-product-info">
                    <a href="<?php echo esc_url( $cat_link ); ?>" class="product-category-pill">
                        <?php echo digitalproduk_get_icon( 'tag', 'pill-tag-icon', 13 ); ?>
                        <span><?php echo esc_html( $cat_name ); ?></span>
                    </a>

                    <h1 class="single-title"><?php the_title(); ?></h1>

                    <div class="single-rating-bar">
                        <span class="rating-stars">
                            <?php for ( $s = 0; $s < 5; $s++ ) : ?>
                                <?php echo digitalproduk_get_icon( 'star', 'star-gold', 14 ); ?>
                            <?php endfor; ?>
                        </span>
                        <strong class="rating-num"><?php echo esc_html( $rating ); ?></strong>
                        <span class="rating-divider">&bull;</span>
                        <span class="sales-text">
                            <?php echo digitalproduk_get_icon( 'check-circle-2', 'text-cyan', 14 ); ?>
                            <strong><?php echo esc_html( $sales_count ); ?>+</strong> Pembeli Puas
                        </span>
                    </div>

                    <!-- Tech stack tags -->
                    <div class="tech-tags-list">
                        <?php foreach ( $tech_tags as $tag ) : ?>
                            <span class="tech-tag-item"><?php echo esc_html( trim( $tag ) ); ?></span>
                        <?php endforeach; ?>
                    </div>

                    <!-- Buy Box Card -->
                    <div class="buy-action-card tilt-right">
                        <div class="card-tape"></div>
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
                            <span>Beli &amp; Akses Sekarang</span>
                            <?php echo digitalproduk_get_icon( 'shopping-bag', 'btn-icon-right', 18 ); ?>
                        </button>

                        <a href="<?php echo esc_url( home_url( '/checkout/?product_id=' . $product_id ) ); ?>" class="btn btn-secondary btn-block" style="margin-top: 8px; font-weight: 700; font-size: 0.95rem; text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <?php echo digitalproduk_get_icon( 'credit-card', '', 16 ); ?>
                            <span>Halaman Checkout Mandiri</span>
                        </a>

                        <div class="buy-card-sublinks">
                            <a href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo Indotech DigitalProduk, saya ingin tanya detail produk: ' . get_the_title() ); ?>" target="_blank" rel="noopener">
                                <?php echo digitalproduk_get_icon( 'message-circle', '', 15 ); ?>
                                <span>Konsultasi Pra-Beli via WhatsApp</span>
                            </a>
                        </div>
                    </div>

                    <!-- What You Get Key Benefits -->
                    <div class="key-benefits-box">
                        <h3 class="box-title">
                            <?php echo digitalproduk_get_icon( 'gift', 'gift-title-icon', 18 ); ?>
                            <span>Keuntungan Eksklusif Paket Ini:</span>
                        </h3>
                        <ul class="benefits-checklist">
                            <?php foreach ( $features as $f ) : ?>
                                <li>
                                    <span class="check-circle"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span>
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
                        <h2 class="panel-heading">Deskripsi &amp; Spesifikasi Lengkap</h2>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar FAQ & Guarantee -->
                <div class="sidebar-column">
                    <div class="playful-box sidebar-card card-yellow">
                        <h3 style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <?php echo digitalproduk_get_icon( 'shield-check', '', 20 ); ?>
                            <span>Jaminan Kepuasan 100%</span>
                        </h3>
                        <p>File terverifikasi, bebas virus/malware, dan dipastikan berjalan sesuai panduan dokumentasi resmi.</p>
                    </div>

                    <div class="playful-box sidebar-card card-cyan">
                        <h3 style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <?php echo digitalproduk_get_icon( 'zap', '', 20 ); ?>
                            <span>Cara Akses Produk</span>
                        </h3>
                        <ol style="margin-left: 1.25rem; font-size: 0.95rem; line-height: 1.6;">
                            <li>Klik tombol <strong>Beli &amp; Akses Sekarang</strong>.</li>
                            <li>Lakukan pembayaran instan via Midtrans (QRIS/VA).</li>
                            <li>Link download Google Drive langsung aktif &amp; dikirim ke email Anda.</li>
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
                    <div class="playful-sticker">
                        <?php echo digitalproduk_get_icon( 'sparkles', '', 14 ); ?>
                        <span>REKOMENDASI PILIHAN</span>
                    </div>
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
