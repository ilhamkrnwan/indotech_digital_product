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
<div class="hero-parallax-stage">
    <section class="hero-section">
        <?php get_template_part( 'template-parts/nebula-field' ); ?>
        <div class="hero-particles" aria-hidden="true">
            <span class="hero-particle"></span>
            <span class="hero-particle"></span>
            <span class="hero-particle"></span>
            <span class="hero-particle"></span>
            <span class="hero-particle"></span>
            <span class="hero-particle"></span>
            <span class="hero-particle"></span>
            <span class="hero-particle"></span>
        </div>
        <div class="container hero-container">
            <div class="hero-content">
                <h1 class="hero-title">
                    Temukan aset yang <span class="hero-title-gradient">masuk akal</span> untuk proyek Anda.
                </h1>
                <p class="hero-desc">
                    Source code web app, plugin WordPress, template Figma, dan workspace Notion. Buka detail produknya, cek isi yang Anda butuhkan, lalu lanjutkan pembelian.
                </p>

                <form action="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" method="get" class="hero-command-search" role="search">
                    <span class="search-command-icon" aria-hidden="true">
                        <?php echo digitalproduk_get_icon( 'search', '', 18 ); ?>
                    </span>
                    <input type="text" name="s" placeholder="Cari produk atau teknologi" class="hero-search-input" aria-label="Cari produk digital" />
                    <button type="submit" class="btn btn-primary hero-search-btn">
                        <span>Cari katalog</span>
                    </button>
                </form>

                <div class="hero-scope" aria-label="Jenis produk">
                    <span>Source code</span>
                    <span>Plugin WordPress</span>
                    <span>Figma &amp; Notion</span>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- 2. Katalog Section -->
<section id="katalog" class="section">
    <div class="container">
        <div class="section-header catalog-header motion-reveal">
            <div>
                <h2 class="section-title">Katalog Produk</h2>
                <p class="section-desc">Gunakan filter untuk mempersempit pilihan berdasarkan jenis aset.</p>
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

<!-- 3. Cara Pembelian -->
<section id="cara-kerja" class="section purchase-path-section">
    <div class="container">
        <div class="section-header purchase-path-header">
            <h2 class="section-title">Dari katalog sampai file</h2>
            <p class="section-desc">Tiga tahap yang dilewati sebelum Anda mulai memakai asetnya.</p>
        </div>

        <div class="steps-flow">
            <div class="step-card step-card-select motion-reveal">
                <span class="step-index">01</span>
                <h3>Pilih Produk</h3>
                <p>Buka detail produk dan periksa format file sebelum membeli.</p>
            </div>
            <span class="step-flow-arrow" aria-hidden="true"><?php echo digitalproduk_get_icon( 'arrow-right', '', 22 ); ?></span>
            <div class="step-card step-card-pay motion-reveal">
                <span class="step-index">02</span>
                <h3>Bayar Otomatis</h3>
                <p>Pilih QRIS atau Virtual Account di halaman pembayaran.</p>
            </div>
            <span class="step-flow-arrow" aria-hidden="true"><?php echo digitalproduk_get_icon( 'arrow-right', '', 22 ); ?></span>
            <div class="step-card step-card-download motion-reveal">
                <span class="step-index">03</span>
                <h3>Unduh File</h3>
                <p>Setelah pembayaran dikonfirmasi, halaman pesanan menampilkan tautan file.</p>
            </div>
        </div>
    </div>
</section>

<!-- 4. FAQ Section -->
<section id="faq" class="section">
    <div class="container">
        <div class="section-header faq-header motion-reveal">
            <h2 class="section-title">Sebelum membeli</h2>
            <p class="section-desc">Jawaban ringkas tentang file, lisensi, dan metode bayar.</p>
        </div>

        <div class="faq-list">
            <details class="faq-item motion-reveal">
                <summary>Di mana saya menemukan file setelah pembayaran? <?php echo digitalproduk_get_icon( 'chevron-down', 'faq-caret', 20 ); ?></summary>
                <p>Setelah pembayaran terkonfirmasi, halaman pesanan menampilkan tombol untuk membuka tautan unduhan.</p>
            </details>
            <details class="faq-item motion-reveal">
                <summary>Boleh dipakai untuk proyek klien? <?php echo digitalproduk_get_icon( 'chevron-down', 'faq-caret', 20 ); ?></summary>
                <p>Boleh. Anda bebas menggunakannya untuk proyek pesanan klien tanpa biaya royalti tambahan.</p>
            </details>
            <details class="faq-item motion-reveal">
                <summary>Metode pembayaran apa saja yang tersedia? <?php echo digitalproduk_get_icon( 'chevron-down', 'faq-caret', 20 ); ?></summary>
                <p>Mendukung QRIS (GoPay, OVO, ShopeePay, BCA) dan Virtual Account (BCA, Mandiri, BNI, BRI).</p>
            </details>
            <details class="faq-item motion-reveal">
                <summary>Apakah file bisa mendapat pembaruan? <?php echo digitalproduk_get_icon( 'chevron-down', 'faq-caret', 20 ); ?></summary>
                <p>Jika pembaruan disediakan untuk produk tersebut, versi terbaru tersedia pada tautan file yang sama.</p>
            </details>
        </div>
    </div>
</section>

<!-- 5. Compact Catalog CTA -->
<section class="compact-cta-section motion-reveal">
    <div class="container">
        <div class="compact-cta-shell">
            <?php get_template_part( 'template-parts/nebula-field' ); ?>
            <div>
                <h2>Butuh aset yang berbeda?</h2>
                <p>Lihat seluruh katalog dan pilih sesuai kebutuhan proyek Anda.</p>
            </div>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-primary btn-lg">Buka semua produk</a>
        </div>
    </div>
</section>

<?php
get_footer();
