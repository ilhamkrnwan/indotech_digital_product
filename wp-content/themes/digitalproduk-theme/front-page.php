<?php
/**
 * The template for displaying the Homepage Landing Page
 * Clean, direct, utilitarian
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

<!-- 1. Hero Section (Modern Cyber Fusion) -->
<section class="hero-section">
    <!-- Brand Ambient Gradient Canvas -->
    <div class="hero-brand-backdrop" aria-hidden="true">
        <div class="brand-radial-glow"></div>
        <div class="brand-circuit-line"></div>
    </div>

    <div class="container hero-container">
        <div class="hero-content">
            <h1 class="hero-title">
                Koleksi Source Code, Plugin, dan Template <span class="hero-title-gradient">Terverifikasi.</span>
            </h1>
            <p class="hero-desc">
                Starter kit web app, plugin WordPress, dan template desain siap pakai untuk mempercepat pengerjaan proyek Anda. Sekali bayar, langsung unduh via Google Drive dengan lisensi komersial bebas royalti.
            </p>

            <!-- Store Command Search Bar -->
            <form action="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" method="get" class="hero-command-search" role="search">
                <span class="search-command-icon" aria-hidden="true">
                    <?php echo digitalproduk_get_icon( 'search', '', 18 ); ?>
                </span>
                <input type="text" name="s" placeholder="Cari: Laravel, Next.js, Figma, WordPress..." class="hero-search-input" aria-label="Cari produk digital" />
                <button type="submit" class="btn btn-primary hero-search-btn">
                    <span>Cari</span>
                    <kbd class="kbd-hint">&#8629;</kbd>
                </button>
            </form>

            <div class="hero-trust-row">
                <div class="trust-item"><span class="trust-icon">&#10003;</span> Download instan Google Drive</div>
                <div class="trust-item"><span class="trust-icon">&#10003;</span> Lisensi komersial bebas</div>
                <div class="trust-item"><span class="trust-icon">&#10003;</span> Otomatis Midtrans QRIS &amp; VA</div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Katalog Section -->
<section id="katalog" class="section">
    <div class="container">
        <div class="section-tech-bar" aria-hidden="true"></div>
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: flex-end; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
            <div>
                <h2 class="section-title">Katalog Produk</h2>
                <p class="section-desc">Pilih produk sesuai kebutuhan proyek Anda.</p>
            </div>

            <!-- Category Filters -->
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <div class="category-filter-list" role="group" aria-label="Filter Kategori">
                    <button class="filter-btn active" data-filter="all" type="button" aria-pressed="true">
                        Semua
                    </button>
                    <?php foreach ( $categories as $cat ) : ?>
                        <button class="filter-btn" data-filter="<?php echo esc_attr( $cat->slug ); ?>" type="button" aria-pressed="false">
                            <?php echo esc_html( $cat->name ); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
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
                <p style="text-align: center; grid-column: 1 / -1; color: var(--text-secondary); padding: 3rem 0;">Belum ada produk digital.</p>
                <?php
            endif;
            ?>
        </div>
    </div>
</section>

<!-- 3. Cara Pembelian (Clean Workflow) -->
<section id="cara-kerja" class="section" style="background: #ffffff; border-top: 1px solid var(--border-main); border-bottom: 1px solid var(--border-main);">
    <div class="container">
        <div class="section-header" style="margin-bottom: 2rem;">
            <h2 class="section-title">Cara Pembelian</h2>
            <p class="section-desc">Proses otomatis tanpa menunggu konfirmasi manual.</p>
        </div>

        <div class="steps-flow">
            <div class="step-card">
                <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: 700; color: var(--brand-cobalt); margin-bottom: 0.5rem; display: block;">01</span>
                <h3>Pilih Produk</h3>
                <p>Pilih source code atau template yang Anda butuhkan, lalu klik Beli.</p>
            </div>
            <span class="step-flow-arrow" aria-hidden="true"><?php echo digitalproduk_get_icon( 'arrow-right', '', 22 ); ?></span>
            <div class="step-card">
                <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: 700; color: var(--brand-cobalt); margin-bottom: 0.5rem; display: block;">02</span>
                <h3>Bayar Otomatis</h3>
                <p>Scan QRIS atau transfer lewat Virtual Account. Pembayaran dicek otomatis dalam beberapa detik.</p>
            </div>
            <span class="step-flow-arrow" aria-hidden="true"><?php echo digitalproduk_get_icon( 'arrow-right', '', 22 ); ?></span>
            <div class="step-card">
                <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: 700; color: var(--brand-cobalt); margin-bottom: 0.5rem; display: block;">03</span>
                <h3>Unduh File</h3>
                <p>Tautan Google Drive langsung terbuka di layar dan dikirim ke email Anda.</p>
            </div>
        </div>
    </div>
</section>

<!-- 4. FAQ Section -->
<section id="faq" class="section">
    <div class="container">
        <div class="section-header" style="margin-bottom: 2rem;">
            <h2 class="section-title">Pertanyaan Umum</h2>
            <p class="section-desc">Hal-hal yang sering ditanyakan seputar pembelian dan file.</p>
        </div>

        <div class="faq-list">
            <details class="faq-item">
                <summary>Bagaimana cara mengunduh file setelah bayar? <?php echo digitalproduk_get_icon( 'chevron-down', 'faq-caret', 20 ); ?></summary>
                <p>Setelah pembayaran terkonfirmasi, halaman akan langsung menampilkan tombol download Google Drive. Link juga dikirim ke email Anda.</p>
            </details>
            <details class="faq-item">
                <summary>Boleh dipakai untuk proyek klien? <?php echo digitalproduk_get_icon( 'chevron-down', 'faq-caret', 20 ); ?></summary>
                <p>Boleh. Anda bebas menggunakannya untuk proyek pesanan klien tanpa biaya royalti tambahan.</p>
            </details>
            <details class="faq-item">
                <summary>Metode pembayaran apa saja yang tersedia? <?php echo digitalproduk_get_icon( 'chevron-down', 'faq-caret', 20 ); ?></summary>
                <p>Mendukung QRIS (GoPay, OVO, ShopeePay, BCA) dan Virtual Account (BCA, Mandiri, BNI, BRI).</p>
            </details>
            <details class="faq-item">
                <summary>Apakah ada update file? <?php echo digitalproduk_get_icon( 'chevron-down', 'faq-caret', 20 ); ?></summary>
                <p>Jika ada perbaikan bug atau pembaruan versi, file pada folder Google Drive akan diperbarui tanpa pungutan biaya lagi.</p>
            </details>
        </div>
    </div>
</section>

<?php
get_footer();
