<?php
/**
 * The template for displaying the Homepage Landing Page
 *
 * @package DigitalProduk
 */

get_header();

// Query Digital Products
$products_query = new WP_Query([
    'post_type'      => 'digital_product',
    'posts_per_page' => 12,
    'post_status'    => 'publish',
]);

// Query Categories
$categories = get_terms([
    'taxonomy'   => 'product_category',
    'hide_empty' => false,
]);
?>

<!-- 1. Hero Section -->
<section class="hero-section">
    <div class="hero-glow"></div>
    <div class="container hero-content">
        <div class="hero-pill">
            <span>✨ Koleksi Produk Digital Pilihan 2026</span>
        </div>
        <h1 class="hero-title">
            Tingkatkan Skill & Bisnis Digital Anda Lebih Cepat dengan <span class="highlight">Aset Siap Pakai</span>
        </h1>
        <p class="hero-desc">
            Temukan source code web apps, UI/UX figma design kits, panduan e-book, dan template produktivitas terkurasi dengan standar industri profesional.
        </p>
        <div class="hero-cta">
            <a href="#katalog" class="btn btn-primary btn-lg">Eksplorasi Katalog</a>
            <a href="#keunggulan" class="btn btn-secondary btn-lg">Pelajari Keunggulan</a>
        </div>

        <div class="hero-stats">
            <div class="stat-item">
                <h3>5.000+</h3>
                <p>Digital Kreator & Dev Puas</p>
            </div>
            <div class="stat-item">
                <h3>100%</h3>
                <p>Akses Selamanya & Update</p>
            </div>
            <div class="stat-item">
                <h3>Instan</h3>
                <p>Akses Download Langsung</p>
            </div>
        </div>
    </div>
</section>

<!-- 2. Katalog Showcase Section -->
<section id="katalog" class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Katalog Produk Pilihan</h2>
            <p class="section-desc">Pilih produk digital berkualitas tinggi untuk mempercepat peluncuran proyek dan bisnis Anda.</p>
        </div>

        <!-- Filter Kategori -->
        <div class="catalog-filters">
            <button class="filter-btn active" data-filter="all">Semua Kategori</button>
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : ?>
                    <button class="filter-btn" data-filter="<?php echo esc_attr( $cat->slug ); ?>">
                        <?php echo esc_html( $cat->name ); ?>
                    </button>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Grid Produk -->
        <div class="products-grid">
            <?php
            if ( $products_query->have_posts() ) :
                while ( $products_query->have_posts() ) :
                    $products_query->the_post();
                    
                    $price = get_post_meta( get_the_ID(), '_price', true ) ?: 199000;
                    $sale_price = get_post_meta( get_the_ID(), '_sale_price', true ) ?: 99000;
                    $rating = get_post_meta( get_the_ID(), '_rating', true ) ?: '4.9';
                    $sales_count = get_post_meta( get_the_ID(), '_sales_count', true ) ?: '250';
                    $file_format = get_post_meta( get_the_ID(), '_file_format', true ) ?: 'ZIP + Dokumentasi';
                    $badge = get_post_meta( get_the_ID(), '_badge', true ) ?: 'BEST SELLER';
                    $features_meta = get_post_meta( get_the_ID(), '_features', true );
                    $features = ! empty( $features_meta ) ? ( is_array( $features_meta ) ? $features_meta : explode( "\n", $features_meta ) ) : [
                        'Lisensi Komersial Lengkap',
                        'Dokumentasi Panduan Instalasi',
                        'Update Gratis Selamanya'
                    ];

                    $item_cats = get_the_terms( get_the_ID(), 'product_category' );
                    $cat_slug = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->slug : 'general';
                    $cat_name = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->name : 'Produk';
                    ?>
                    <div class="product-card" data-category="<?php echo esc_attr( $cat_slug ); ?>">
                        <div class="product-thumb-wrap">
                            <?php if ( $badge ) : ?>
                                <span class="product-badge <?php echo $badge === 'BARU' ? 'badge-new' : ''; ?>">
                                    <?php echo esc_html( $badge ); ?>
                                </span>
                            <?php endif; ?>

                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'large', [ 'class' => 'product-thumb' ] ); ?>
                            <?php else : ?>
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1e293b, #0f172a); font-size: 3rem;">
                                    💎
                                </div>
                            <?php endif; ?>

                            <span class="product-format-tag"><?php echo esc_html( $file_format ); ?></span>
                        </div>

                        <div class="product-body">
                            <div class="product-meta-header">
                                <span class="product-category"><?php echo esc_html( $cat_name ); ?></span>
                                <span class="product-rating">★ <?php echo esc_html( $rating ); ?> (<?php echo esc_html( $sales_count ); ?> terjual)</span>
                            </div>

                            <h3 class="product-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <p class="product-excerpt"><?php echo wp_trim_words( get_the_excerpt() ?: get_the_content(), 15 ); ?></p>

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
                                <button type="button" class="btn btn-primary btn-sm btn-buy-trigger" 
                                    data-title="<?php the_title_attribute(); ?>" 
                                    data-price="<?php echo esc_attr( digitalproduk_price( $sale_price ) ); ?>">
                                    Beli Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p style="text-align: center; grid-column: 1 / -1; color: var(--text-muted);">Belum ada produk digital yang ditambahkan.</p>
                <?php
            endif;
            ?>
        </div>
    </div>
</section>

<!-- 3. Keunggulan Section -->
<section id="keunggulan" class="section" style="background: var(--bg-surface);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Mengapa Memilih Kami?</h2>
            <p class="section-desc">Kualitas dan kepuasan pelanggan adalah prioritas utama setiap produk yang kami rilis.</p>
        </div>

        <div class="features-grid">
            <div class="feature-box">
                <div class="feature-icon-wrapper">⚡</div>
                <h3>Download Instan & Otomatis</h3>
                <p>Setelah konfirmasi pembayaran, link unduhan dan lisensi produk langsung aktif tanpa harus menunggu berjam-jam.</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrapper">🛡️</div>
                <h3>Garansi Update Selamanya</h3>
                <p>Dapatkan pembaruan versi terbaru, penambahan fitur baru, serta bug fix gratis tanpa biaya langganan berulang.</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrapper">💬</div>
                <h3>Dukungan Teknis Siap Bantu</h3>
                <p>Mengalami kendala saat konfigurasi atau pemasangan? Tim teknis kami siap mendampingi Anda via WhatsApp & Email.</p>
            </div>
        </div>
    </div>
</section>

<!-- 4. Testimoni Pelanggan -->
<section id="testimoni" class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Apa Kata Mereka?</h2>
            <p class="section-desc">Ribuan pengembang, desainer, dan wirausahawan digital telah mempercayakan aset proyek mereka.</p>
        </div>

        <div class="testimonials-grid">
            <div class="testi-card">
                <div>
                    <div class="testi-rating">★★★★★</div>
                    <p class="testi-text">"Source code dan UI kit-nya bener-bener rapi dan modular. Hemat waktu development klien hingga 2 minggu penuh!"</p>
                </div>
                <div class="testi-author">
                    <div class="author-avatar">RD</div>
                    <div class="author-info">
                        <h4>Rian Darmawan</h4>
                        <p>Senior Fullstack Developer</p>
                    </div>
                </div>
            </div>

            <div class="testi-card">
                <div>
                    <div class="testi-rating">★★★★★</div>
                    <p class="testi-text">"E-book dan panduannya sangat daging, tidak bertele-tele. Langsung bisa saya praktikkan untuk optimasi funnel penjualan saya."</p>
                </div>
                <div class="testi-author">
                    <div class="author-avatar">SN</div>
                    <div class="author-info">
                        <h4>Siti Nurhaliza</h4>
                        <p>Digital Creator & Marketer</p>
                    </div>
                </div>
            </div>

            <div class="testi-card">
                <div>
                    <div class="testi-rating">★★★★★</div>
                    <p class="testi-text">"Customer support responsif banget waktu saya tanya cara setting env. Sangat recommended buat yang butuh aset profesional!"</p>
                </div>
                <div class="testi-author">
                    <div class="author-avatar">BP</div>
                    <div class="author-info">
                        <h4>Budi Pratama</h4>
                        <p>Freelance Web Designer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. FAQ Section -->
<section id="faq" class="section" style="background: var(--bg-surface);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Pertanyaan Sering Diajukan</h2>
            <p class="section-desc">Punya pertanyaan seputar pembelian atau produk? Temukan jawabannya di sini.</p>
        </div>

        <div class="faq-wrap">
            <div class="faq-item active">
                <button type="button" class="faq-question">
                    <span>Bagaimana cara menerima produk setelah bayar?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Setelah pembayaran berhasil terkonfirmasi, Anda akan otomatis mendapatkan link akses download file Google Drive / Cloud Storage yang aktif selamanya.
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>Apakah saya boleh menggunakan produk ini untuk klien?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Ya! Semua produk digital yang dijual di sini menyertakan Commercial License standar, yang memperbolehkan Anda memakainya untuk proyek pribadi maupun pekerjaan klien komersial.
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>Metode pembayaran apa saja yang didukung?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Kami mendukung pembayaran mudah via QRIS (BCA, GoPay, OVO, Dana, ShopeePay), transfer bank virtual account (BCA, Mandiri, BRI, BNI), dan transfer manual.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. Call to Action Banner -->
<section class="section">
    <div class="container">
        <div class="cta-banner">
            <h2>Mulai Akselerasi Proyek Digital Anda Hari Ini</h2>
            <p>Dapatkan penawaran harga promo khusus sebelum masa diskon berakhir. Semua file siap didownload dalam hitungan detik.</p>
            <a href="#katalog" class="btn btn-primary btn-lg">Pilih Produk Sekarang ⚡</a>
        </div>
    </div>
</section>

<!-- 7. Quick Order Modal (Checkout Instant) -->
<div class="modal-overlay" id="checkoutModal">
    <div class="modal-content">
        <button type="button" class="modal-close" id="modalClose">&times;</button>
        <h3 style="font-family: var(--font-heading); margin-bottom: 0.5rem; font-size: 1.5rem;">Pemesanan Produk</h3>
        <p style="color: var(--text-secondary); margin-bottom: 1.5rem; font-size: 0.95rem;">Lanjutkan transaksi cepat melalui WhatsApp resmi kami.</p>
        
        <div style="background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 1.25rem; margin-bottom: 1.5rem;">
            <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">Nama Produk:</div>
            <div id="modalProductTitle" style="font-weight: 700; font-size: 1.15rem; margin-bottom: 0.75rem;">-</div>
            
            <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">Total Harga Promo:</div>
            <div id="modalProductPrice" style="font-weight: 800; font-size: 1.35rem; color: #38bdf8;">-</div>
        </div>

        <a id="modalBuyBtn" href="#" target="_blank" rel="noopener" class="btn btn-success btn-lg btn-block">
            Lanjut ke WhatsApp Admin 💬
        </a>
    </div>
</div>

<?php
get_footer();
