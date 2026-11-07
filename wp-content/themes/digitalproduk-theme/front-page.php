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

<!-- 1. Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content" style="max-width: 760px;">
            <h1 class="hero-title">
                Source code, template, dan aset digital siap pakai.
            </h1>
            <p class="hero-desc">
                Koleksi web app starter, plugin WordPress, dan template desain untuk mempercepat pengerjaan proyek Anda. Beli sekali, langsung unduh via Google Drive, dan bebas digunakan untuk proyek pribadi maupun klien.
            </p>

            <!-- Store Quick Search -->
            <form action="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" method="get" class="hero-store-search">
                <input type="text" name="s" placeholder="Cari source code, template Figma, Notion..." class="hero-search-input" />
                <button type="submit" class="btn btn-primary">
                    <span>Cari</span>
                    <?php echo digitalproduk_get_icon( 'search', 'btn-icon', 15 ); ?>
                </button>
            </form>

            <div class="hero-trust-row" style="display: flex; gap: 1.5rem; flex-wrap: wrap; font-size: 0.85rem; color: var(--text-secondary);">
                <span>✓ Download instan via Google Drive</span>
                <span>✓ Lisensi komersial bebas</span>
                <span>✓ Bayar otomatis via Midtrans (QRIS &amp; VA)</span>
            </div>
        </div>
    </div>
</section>

<!-- 2. Katalog Section -->
<section id="katalog" class="section">
    <div class="container">
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: flex-end; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
            <div>
                <h2 class="section-title">Katalog Produk</h2>
                <p class="section-desc">Pilih produk sesuai kebutuhan proyek Anda.</p>
            </div>

            <!-- Category Filters -->
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <div class="category-filter-list" role="tablist" aria-label="Filter Kategori">
                    <button class="filter-btn active" data-filter="all" role="tab" aria-selected="true">
                        Semua
                    </button>
                    <?php foreach ( $categories as $cat ) : ?>
                        <button class="filter-btn" data-filter="<?php echo esc_attr( $cat->slug ); ?>" role="tab" aria-selected="false">
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

        <div class="steps-grid">
            <div class="step-card">
                <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: 700; color: var(--brand-cobalt); margin-bottom: 0.5rem; display: block;">01</span>
                <h3>Pilih Produk</h3>
                <p>Pilih source code atau template yang Anda butuhkan, lalu klik Beli.</p>
            </div>
            <div class="step-card">
                <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: 700; color: var(--brand-cobalt); margin-bottom: 0.5rem; display: block;">02</span>
                <h3>Bayar via Midtrans</h3>
                <p>Scan QRIS atau transfer lewat Virtual Account. Pembayaran dicek otomatis dalam beberapa detik.</p>
            </div>
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

        <div class="faq-grid">
            <div class="faq-card">
                <h3>Bagaimana cara mengunduh file setelah bayar?</h3>
                <p>Setelah pembayaran terkonfirmasi di popup Midtrans, halaman akan langsung menampilkan tombol download Google Drive. Link juga dikirim ke email Anda.</p>
            </div>
            <div class="faq-card">
                <h3>Boleh dipakai untuk proyek klien?</h3>
                <p>Boleh. Anda bebas menggunakannya untuk proyek pesanan klien tanpa biaya royalti tambahan.</p>
            </div>
            <div class="faq-card">
                <h3>Metode pembayaran apa saja yang tersedia?</h3>
                <p>Mendukung QRIS (GoPay, OVO, ShopeePay, BCA) dan Virtual Account (BCA, Mandiri, BNI, BRI).</p>
            </div>
            <div class="faq-card">
                <h3>Apakah ada update file?</h3>
                <p>Jika ada perbaikan bug atau pembaruan versi, file pada folder Google Drive akan diperbarui tanpa pungutan biaya lagi.</p>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
