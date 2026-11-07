<?php
/**
 * The template for displaying the Homepage Landing Page
 * Indotech Technical Commerce Design System
 *
 * @package DigitalProduk
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

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
    <div class="container">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="hero-pill">
                    <?php echo digitalproduk_get_icon( 'zap', '', 14 ); ?>
                    <span>PLATFORM ASET DIGITAL RESMI UNTUK DEVELOPER &amp; KREATOR</span>
                </div>
                <h1 class="hero-title">
                    Katalog Aset Digital Siap Pakai untuk <span>Developer dan Kreator</span>
                </h1>
                <p class="hero-desc">
                    Temukan source code web apps siap produksi, plugin native WordPress, sistem desain Figma, dan Notion workspace teruji. Akses unduh langsung aktif detik itu juga pasca verifikasi otomatis Midtrans (QRIS &amp; Virtual Account).
                </p>

                <!-- Store Quick Search -->
                <form action="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" method="get" class="hero-store-search">
                    <input type="text" name="s" placeholder="Cari source code, template Figma, Notion OS, e-book..." class="hero-search-input" />
                    <button type="submit" class="btn btn-primary">
                        <span>Cari Aset</span>
                        <?php echo digitalproduk_get_icon( 'search', 'btn-icon', 15 ); ?>
                    </button>
                </form>

                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-icon-wrap">
                            <?php echo digitalproduk_get_icon( 'download', '', 18 ); ?>
                        </span>
                        <div>
                            <h3>Akses Instan Otomatis</h3>
                            <p>Direct download link Google Drive aktif otomatis</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon-wrap">
                            <?php echo digitalproduk_get_icon( 'briefcase', '', 18 ); ?>
                        </span>
                        <div>
                            <h3>Lisensi Komersial</h3>
                            <p>Bebas dipakai untuk proyek klien tanpa royalti tambahan</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon-wrap">
                            <?php echo digitalproduk_get_icon( 'shield-check', '', 18 ); ?>
                        </span>
                        <div>
                            <h3>Midtrans Snap API</h3>
                            <p>QRIS &amp; Virtual Account terverifikasi realtime</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Right Visual: Technical Architecture Spec Card -->
            <div class="hero-technical-card">
                <div class="tech-card-header">
                    <span class="tech-card-badge">INDOTECH ARSITEKTUR</span>
                    <span class="tech-card-status">
                        <span class="status-dot"></span>
                        <span>Gateway Aktif</span>
                    </span>
                </div>
                <div style="margin-bottom: 1.25rem;">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.35rem;">
                        Spesifikasi Teknis &amp; Keamanan
                    </h3>
                    <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5;">
                        Standar aset digital yang dikurasi langsung oleh engineer profesional dengan arsitektur modular.
                    </p>
                </div>
                <div class="tech-spec-rows">
                    <div class="tech-spec-row">
                        <span class="tech-spec-label">Protokol Delivery</span>
                        <span class="tech-spec-val">Direct HTTPS Download</span>
                    </div>
                    <div class="tech-spec-row">
                        <span class="tech-spec-label">Payment Gateway</span>
                        <span class="tech-spec-val">Midtrans Snap Webhook</span>
                    </div>
                    <div class="tech-spec-row">
                        <span class="tech-spec-label">Format Source</span>
                        <span class="tech-spec-val">100% Unencrypted / Clean</span>
                    </div>
                    <div class="tech-spec-row">
                        <span class="tech-spec-label">Kompatibilitas</span>
                        <span class="tech-spec-val">PHP 8.2+ / Node 20+ / Figma 5</span>
                    </div>
                    <div class="tech-spec-row">
                        <span class="tech-spec-label">Lisensi</span>
                        <span class="tech-spec-val" style="color: var(--status-success);">Komersial Lengkap</span>
                    </div>
                </div>
                <div style="margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center;">
                    <a href="#katalog" class="btn btn-secondary btn-sm" style="flex: 1; text-align: center;">
                        Buka Katalog Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Katalog Showcase Section -->
<section id="katalog" class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">ASET PILIHAN SIAP AKSES</span>
            <h2 class="section-title">Katalog Produk Digital Terbaru</h2>
            <p class="section-desc">Pilih produk digital terverifikasi untuk mempercepat peluncuran proyek dan bisnis Anda tanpa memulai dari nol.</p>
        </div>

        <!-- Catalog Controls (Search & Filters) -->
        <div class="catalog-controls">
            <div class="category-filter-list" role="tablist" aria-label="Filter Kategori Produk">
                <button class="filter-btn active" data-filter="all" role="tab" aria-selected="true">
                    <?php echo digitalproduk_get_icon( 'layers', 'filter-icon-svg', 14 ); ?>
                    <span>Semua Kategori</span>
                </button>
                <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                    <?php foreach ( $categories as $cat ) : 
                        $cat_meta = digitalproduk_get_category_meta( $cat->slug );
                    ?>
                        <button class="filter-btn" data-filter="<?php echo esc_attr( $cat->slug ); ?>" role="tab" aria-selected="false">
                            <?php echo digitalproduk_get_icon( $cat_meta['icon'], 'filter-icon-svg', 14 ); ?>
                            <span><?php echo esc_html( $cat->name ); ?></span>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Grid Produk -->
        <div class="products-grid">
            <?php
            if ( $products_query->have_posts() ) :
                while ( $products_query->have_posts() ) :
                    $products_query->the_post();
                    get_template_part( 'template-parts/product-card' );
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p style="text-align: center; grid-column: 1 / -1; color: var(--text-secondary); padding: 3rem 0;">Belum ada produk digital yang ditambahkan.</p>
                <?php
            endif;
            ?>
        </div>
    </div>
</section>

<!-- 3. Alur Pembelian & Pengiriman Otomatis (Workflow) -->
<section id="cara-kerja" class="section" style="background: #ffffff; border-top: 1px solid var(--border-main); border-bottom: 1px solid var(--border-main);">
    <div class="container">
        <div class="workflow-header">
            <span class="section-eyebrow">INTEGRASI TRANSAKSI RESMI</span>
            <h2 class="section-title">Alur Pembelian &amp; Download Otomatis</h2>
            <p class="section-desc">Proses transaksi tanpa perantara manual. Server memverifikasi pembayaran dan merilis akses secara instan 24/7.</p>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <span class="step-number">LANGKAH 01</span>
                <h3>Pilih Aset &amp; Lisensi</h3>
                <p>Telusuri katalog source code web apps, plugin, atau sistem desain Figma yang sesuai dengan kebutuhan proyek klien Anda.</p>
            </div>
            <div class="step-card">
                <span class="step-number">LANGKAH 02</span>
                <h3>Bayar via Midtrans Snap</h3>
                <p>Scan QRIS atau transfer via Virtual Account semua bank. Sistem Midtrans memverifikasi transaksi otomatis dalam hitungan detik.</p>
            </div>
            <div class="step-card">
                <span class="step-number">LANGKAH 03</span>
                <h3>Download Langsung Aktif</h3>
                <p>Tautan direct download Google Drive langsung terbuka di halaman sukses dan terkirim otomatis ke email Anda tanpa antre.</p>
            </div>
        </div>
    </div>
</section>

<!-- 4. Categories Shelf Section (Multi-Category Portal) -->
<section id="kategori-section" class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">KLASIFIKASI TEKNOLOGI</span>
            <h2 class="section-title">Kategori Aset Terstruktur</h2>
            <p class="section-desc">Setiap aset dikurasi dengan arsitektur modular dan dokumentasi teknis lengkap agar langsung siap digunakan.</p>
        </div>

        <div class="categories-shelf-grid">
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : 
                    $meta = digitalproduk_get_category_meta( $cat->slug );
                ?>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="cat-shelf-card">
                        <div class="cat-shelf-header">
                            <span class="cat-shelf-icon-wrap">
                                <?php echo digitalproduk_get_icon( $meta['icon'], 'cat-svg-icon', 20 ); ?>
                            </span>
                            <span class="cat-shelf-badge"><?php echo esc_html( $meta['badge'] ); ?></span>
                        </div>
                        <h3 class="cat-shelf-title"><?php echo esc_html( $cat->name ); ?></h3>
                        <p class="cat-shelf-desc"><?php echo esc_html( $meta['desc'] ); ?></p>
                        <div class="cat-shelf-footer">
                            <span class="cat-shelf-count">
                                <?php echo digitalproduk_get_icon( 'package', 'count-icon', 13 ); ?>
                                <span><?php echo esc_html( $cat->count ); ?> Produk Siap Pakai</span>
                            </span>
                            <span class="cat-shelf-btn">
                                <span>Buka</span>
                                <?php echo digitalproduk_get_icon( 'arrow-right', 'btn-icon-xs', 13 ); ?>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- 5. Standar Kualitas Section -->
<section id="keunggulan" class="section" style="background: #ffffff; border-top: 1px solid var(--border-main); border-bottom: 1px solid var(--border-main);">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">STANDAR REKAYASA KAMI</span>
            <h2 class="section-title">Kenapa Memilih Aset Digital Indotech?</h2>
            <p class="section-desc">Kami memastikan setiap baris kode dan komponen antarmuka siap produksi untuk memangkas waktu pengerjaan proyek Anda.</p>
        </div>

        <div class="features-grid">
            <div class="feature-box">
                <div class="feature-icon-wrapper">
                    <?php echo digitalproduk_get_icon( 'zap', 'feature-svg', 22 ); ?>
                </div>
                <h3>Akses Instan &amp; Otomatis</h3>
                <p>Setelah pembayaran terkonfirmasi otomatis oleh Midtrans, link download Google Drive langsung aktif detik itu juga tanpa verifikasi manual.</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrapper">
                    <?php echo digitalproduk_get_icon( 'refresh-cw', 'feature-svg', 22 ); ?>
                </div>
                <h3>Pembaruan Versi Gratis</h3>
                <p>Dapatkan pembaruan rilis berkala, perbaikan bug, dan adaptasi dependensi versi terbaru tanpa biaya langganan bulanan.</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrapper">
                    <?php echo digitalproduk_get_icon( 'briefcase', 'feature-svg', 22 ); ?>
                </div>
                <h3>Lisensi Komersial Bebas</h3>
                <p>Bebas Anda modifikasi dan integrasikan ke proyek klien, startup mandiri, maupun portofolio profesional tanpa batasan royalti.</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrapper">
                    <?php echo digitalproduk_get_icon( 'shield-check', 'feature-svg', 22 ); ?>
                </div>
                <h3>Source Code 100% Bersih</h3>
                <p>Kode sumber rapi tanpa enkripsi ionCube atau obfuscation. Mudah diaudit, disesuaikan, dan diperluas sesuai kebutuhan bisnis.</p>
            </div>
        </div>
    </div>
</section>

<!-- 6. FAQ Section -->
<section id="faq" class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">INFORMASI UMUM</span>
            <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
            <p class="section-desc">Rangkuman jawaban seputar proses pembelian, lisensi penggunaan, dan pengiriman file digital.</p>
        </div>

        <div class="faq-grid">
            <div class="faq-card">
                <h3>
                    <?php echo digitalproduk_get_icon( 'help-circle', '', 18 ); ?>
                    <span>Bagaimana cara saya menerima file setelah membayar?</span>
                </h3>
                <p>Setelah pembayaran Midtrans (QRIS/VA) sukses, halaman akan otomatis memuat link unduh Google Drive langsung. Tautan tersebut juga dapat Anda simpan untuk diunduh kembali kapan saja.</p>
            </div>
            <div class="faq-card">
                <h3>
                    <?php echo digitalproduk_get_icon( 'help-circle', '', 18 ); ?>
                    <span>Apakah saya boleh menggunakan aset ini untuk klien?</span>
                </h3>
                <p>Ya. Seluruh produk kami menyertakan lisensi komersial bebas. Anda berhak menggunakannya untuk proyek pesanan klien tanpa perlu membayar biaya royalti tambahan.</p>
            </div>
            <div class="faq-card">
                <h3>
                    <?php echo digitalproduk_get_icon( 'help-circle', '', 18 ); ?>
                    <span>Metode pembayaran apa saja yang didukung?</span>
                </h3>
                <p>Kami menggunakan payment gateway resmi Midtrans yang mendukung QRIS (GoPay, OVO, ShopeePay, Dana, LinkAja, BCA Mobile) dan Virtual Account (BCA, Mandiri, BNI, BRI, Permata).</p>
            </div>
            <div class="faq-card">
                <h3>
                    <?php echo digitalproduk_get_icon( 'help-circle', '', 18 ); ?>
                    <span>Apakah saya mendapatkan update di masa mendatang?</span>
                </h3>
                <p>Ya, pembaruan versi (bug fix, kompatibilitas framework/WordPress versi baru) akan selalu diperbarui pada folder unduhan Google Drive yang sama secara gratis.</p>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
