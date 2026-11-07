<?php
/**
 * Single Digital Product Template (Indotech Technical Commerce)
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
    $badge = get_post_meta( $product_id, '_badge', true ) ?: 'VERIFIED ASSET';
    
    // Value & Feature Highlights Tags
    $tech_stack = get_post_meta( $product_id, '_tech_stack', true );
    $tech_tags = ! empty( $tech_stack ) ? ( is_array( $tech_stack ) ? $tech_stack : explode( ',', $tech_stack ) ) : [
        'Aset Siap Produksi',
        'Struktur File Rapi',
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
                <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>">Semua Aset</a>
                <span>/</span>
                <a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_name ); ?></a>
                <span>/</span>
                <span class="current-crumb"><?php the_title(); ?></span>
            </div>
        </div>
    </div>

    <!-- Product Hero Overview Section -->
    <section class="section" style="padding-top: 2.5rem; padding-bottom: 3.5rem;">
        <div class="container">
            <div class="single-product-grid">
                
                <!-- Left Column: Visual Showcase (Multi-Image Gallery) -->
                <div class="single-product-visual">
                    <?php $slides = digitalproduk_get_product_slides( $product_id ); ?>
                    
                    <div class="single-gallery-card">
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

                        <!-- Thumbnails Strip -->
                        <div class="gallery-thumbs-grid">
                            <?php foreach ( $slides as $i => $slide ) : ?>
                                <button type="button" 
                                        class="gallery-thumb-item <?php echo $i === 0 ? 'active' : ''; ?>"
                                        data-preview="<?php echo esc_url( $slide['url'] ); ?>"
                                        data-title="<?php echo esc_attr( $slide['title'] ); ?>"
                                        title="<?php echo esc_attr( $slide['title'] ); ?>">
                                    <img src="<?php echo esc_url( $slide['url'] ); ?>" alt="Slide <?php echo $i + 1; ?>" />
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Technical Meta Specs Block -->
                    <div style="margin-top: 1.5rem; background: #ffffff; border: 1px solid var(--border-main); border-radius: var(--radius-md); padding: 1.25rem;">
                        <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.4rem;">
                            <?php echo digitalproduk_get_icon( 'sliders-horizontal', '', 15 ); ?>
                            <span>Spesifikasi Teknis Aset</span>
                        </h4>
                        <div class="product-meta-specs" style="margin-bottom: 0;">
                            <div class="spec-item">
                                <span class="spec-label">Lisensi</span>
                                <span class="spec-value">Komersial Bebas (Royalti 0)</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Distribusi File</span>
                                <span class="spec-value">Direct Download Google Drive</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Enkripsi Kode</span>
                                <span class="spec-value">100% Unencrypted / Source Clean</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Dukungan Update</span>
                                <span class="spec-value">Seumur Hidup Gratis</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Detail, Pricing & Buy Card -->
                <div class="single-product-details">
                    <div class="product-buy-card">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                            <a href="<?php echo esc_url( $cat_link ); ?>" class="product-category" style="font-size: 0.8rem;">
                                <?php echo digitalproduk_get_icon( 'tag', '', 13 ); ?>
                                <span><?php echo esc_html( $cat_name ); ?></span>
                            </a>
                            <span class="product-rating">
                                <?php echo digitalproduk_get_icon( 'star', 'star-gold', 14 ); ?>
                                <span><?php echo esc_html( $rating ); ?></span>
                                <span class="sales-muted">(<?php echo esc_html( $sales_count ); ?> ulasan)</span>
                            </span>
                        </div>

                        <h1 class="single-title"><?php the_title(); ?></h1>

                        <!-- Tech tags -->
                        <div class="tech-tags-list" style="margin-bottom: 1rem;">
                            <?php foreach ( $tech_tags as $tag ) : ?>
                                <span class="tech-tag-pill"><?php echo esc_html( trim( $tag ) ); ?></span>
                            <?php endforeach; ?>
                        </div>

                        <!-- Price Block -->
                        <div class="single-price-block">
                            <span class="single-sale-price"><?php echo digitalproduk_price( $sale_price ); ?></span>
                            <span class="single-orig-price"><?php echo digitalproduk_price( $price ); ?></span>
                            <span style="font-family: var(--font-mono); font-size: 0.75rem; font-weight: 700; color: var(--status-success); background: var(--status-success-bg); border: 1px solid var(--status-success-border); padding: 2px 7px; border-radius: 4px;">
                                Hemat <?php echo round( ( ( $price - $sale_price ) / $price ) * 100 ); ?>%
                            </span>
                        </div>

                        <!-- CTA Button -->
                        <a href="<?php echo esc_url( home_url( '/checkout/?product_id=' . $product_id ) ); ?>" class="btn btn-primary btn-lg btn-block" style="margin-bottom: 0.85rem;">
                            <span>Beli &amp; Akses Download Sekarang</span>
                            <?php echo digitalproduk_get_icon( 'arrow-right', 'btn-icon-right', 16 ); ?>
                        </a>

                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <a href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo Indotech, saya ingin tanya teknis seputar produk: ' . get_the_title() ); ?>" target="_blank" rel="noopener" style="font-size: 0.825rem; color: var(--text-muted); display: inline-flex; align-items: center; gap: 0.4rem;">
                                <?php echo digitalproduk_get_icon( 'message-circle', '', 14 ); ?>
                                <span>Tanya Tim Engineer via WhatsApp</span>
                            </a>
                        </div>

                        <!-- Benefits Checklist -->
                        <div style="border-top: 1px solid var(--border-subtle); padding-top: 1.25rem;">
                            <h4 style="font-size: 0.875rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.75rem;">
                                Hak Akses &amp; Benefit Pembeli:
                            </h4>
                            <ul class="feature-check-list">
                                <?php foreach ( $features as $f ) : ?>
                                    <li class="feature-check-item">
                                        <span class="check-icon"><?php echo digitalproduk_get_icon( 'check', '', 14 ); ?></span>
                                        <span><?php echo esc_html( trim( $f ) ); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Product Detailed Description & Specs Tabs -->
    <section class="section" style="background: #ffffff; border-top: 1px solid var(--border-main);">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 3rem; align-items: start;">
                
                <!-- Main Description -->
                <div>
                    <h2 style="font-size: 1.4rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1.25rem; letter-spacing: -0.02em;">
                        Dokumentasi &amp; Deskripsi Lengkap
                    </h2>
                    <div style="font-size: 0.95rem; color: var(--text-secondary); line-height: 1.7;">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Sidebar Guarantee & Flow -->
                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <div style="background: var(--bg-canvas); border: 1px solid var(--border-main); border-radius: var(--radius-md); padding: 1.5rem;">
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <?php echo digitalproduk_get_icon( 'shield-check', '', 18 ); ?>
                            <span>Jaminan Keamanan &amp; Verifikasi</span>
                        </h3>
                        <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.55;">
                            File terverifikasi, bebas backdoor/malware, dan dipastikan berjalan sesuai spesifikasi dokumentasi resmi.
                        </p>
                    </div>

                    <div style="background: var(--bg-canvas); border: 1px solid var(--border-main); border-radius: var(--radius-md); padding: 1.5rem;">
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <?php echo digitalproduk_get_icon( 'zap', '', 18 ); ?>
                            <span>Alur Pengiriman Instan</span>
                        </h3>
                        <ol style="margin-left: 1.15rem; font-size: 0.85rem; color: var(--text-secondary); line-height: 1.6;">
                            <li>Klik tombol <strong>Beli &amp; Akses Download Sekarang</strong>.</li>
                            <li>Lakukan pembayaran instan via Midtrans (QRIS atau VA).</li>
                            <li>Tautan direct download Google Drive langsung terbuka di browser Anda.</li>
                        </ol>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Related Products -->
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

    if ( ! $related_query->have_posts() ) {
        $related_query = new WP_Query([
            'post_type'      => 'digital_product',
            'posts_per_page' => 3,
            'post__not_in'   => [ $product_id ],
        ]);
    }

    if ( $related_query->have_posts() ) :
        ?>
        <section class="section" style="border-top: 1px solid var(--border-main);">
            <div class="container">
                <div class="section-header">
                    <span class="section-eyebrow">REKOMENDASI TERKAIT</span>
                    <h2 class="section-title">Aset Lain dalam Kategori Ini</h2>
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

    <?php
endwhile;

get_footer();
