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
    <!-- Dynamic Abstract Brush Art Canvas (Option B) -->
    <div class="hero-art-canvas" aria-hidden="true">
        <!-- 1. Big Cobalt Paint Splash (Organic Tapered, Seamless into Canvas) -->
        <svg class="art-stroke stroke-cobalt-blast" viewBox="0 0 580 420" fill="none">
            <!-- Organic Main Body - soft curved top, zero straight lines -->
            <path d="M150 45 C 210 22, 275 32, 335 18 C 395 5, 460 12, 515 28 C 555 42, 575 70, 578 110 C 582 150, 565 190, 545 228 C 515 280, 480 330, 435 370 C 395 405, 350 408, 315 375 C 285 345, 275 300, 260 255 C 245 205, 210 160, 170 120 C 145 95, 125 65, 150 45 Z" fill="#152cab" />
            <!-- Deep Cobalt Inner Shading -->
            <path d="M230 40 C 290 25, 360 28, 420 18 C 470 10, 520 22, 555 45 C 572 65, 575 95, 565 128 C 550 170, 510 210, 465 250 C 420 290, 365 315, 325 295 C 300 278, 310 240, 325 205 C 340 170, 345 130, 310 100 C 275 75, 220 58, 230 40 Z" fill="#2563eb" opacity="0.45" />
            <!-- Feathery Brush Bristles -->
            <path d="M165 62 C 220 48, 280 55, 330 44 C 280 58, 225 64, 165 62 Z" fill="#152cab" opacity="0.75" />
            <path d="M330 175 C 395 215, 445 265, 480 320 C 440 268, 385 220, 330 175 Z" fill="#152cab" opacity="0.65" />
            <path d="M460 90 C 505 120, 535 160, 550 205 C 540 165, 510 130, 460 90 Z" fill="#2563eb" opacity="0.5" />
            <!-- Paint Splatter Accents along stroke edge -->
            <circle cx="560" cy="85" r="4" fill="#152cab" />
            <circle cx="572" cy="135" r="3" fill="#152cab" />
            <circle cx="535" cy="270" r="3.5" fill="#152cab" />
            <circle cx="495" cy="350" r="2.5" fill="#152cab" />
        </svg>

        <!-- 2. Expressive Yellow Acrylic Scribble Sweep (Gaya Referensi) -->
        <svg class="art-stroke stroke-yellow-scribble" viewBox="0 0 320 180" fill="none">
            <path d="M20 50 C70 15 140 65 210 30 C250 10 290 40 310 25 C295 60 240 70 180 55 C120 40 60 85 20 50 Z" fill="#f7d801" />
            <path d="M60 40 C110 20 170 55 230 35" stroke="#f59e0b" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M130 65 C180 45 230 75 280 50" stroke="#f7d801" stroke-width="4" stroke-linecap="round" />
            <path d="M40 70 C80 55 120 80 160 65" stroke="#fef08a" stroke-width="3" stroke-linecap="round" />
            <circle cx="295" cy="18" r="4" fill="#f7d801" />
            <circle cx="312" cy="38" r="2.5" fill="#f7d801" />
            <circle cx="260" cy="85" r="3" fill="#f59e0b" />
            <circle cx="190" cy="88" r="2" fill="#f7d801" />
        </svg>

        <!-- 3. Dry Brush Diagonal Slashes (Kanan Bawah) -->
        <svg class="art-stroke stroke-dry-diagonal" viewBox="0 0 260 120" fill="none">
            <path d="M10 90 L240 20" stroke="#152cab" stroke-width="3" stroke-linecap="round" stroke-dasharray="25 15 60 10 30 8" opacity="0.6" />
            <path d="M30 105 L250 35" stroke="#f7d801" stroke-width="4" stroke-linecap="round" stroke-dasharray="40 20 80 15" opacity="0.8" />
            <path d="M5 80 L180 25" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-dasharray="15 10 40 8" opacity="0.5" />
        </svg>

        <!-- 4. Goresan Kuas Aksen Sisi Kiri (Tapered Natural Ends) -->
        <svg class="art-stroke stroke-left-accent" viewBox="0 0 180 90" fill="none">
            <path d="M12 40 C 45 22, 95 34, 140 20 C 165 12, 175 22, 172 30 C 160 42, 125 50, 85 52 C 45 54, 18 50, 12 40 Z" fill="#f7d801" opacity="0.75" />
            <path d="M22 52 C 60 38, 105 52, 150 36" stroke="#152cab" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="18 12 30 8" opacity="0.35" />
        </svg>

        <!-- 5. Paint Splatters (Tetesan Cat Alami) -->
        <svg class="splatter-cluster splatter-pos-1" viewBox="0 0 90 90" fill="none">
            <circle cx="45" cy="45" r="6" fill="#152cab" />
            <circle cx="68" cy="32" r="3.5" fill="#152cab" />
            <circle cx="28" cy="62" r="3" fill="#152cab" />
            <circle cx="62" cy="68" r="2.5" fill="#152cab" />
            <circle cx="22" cy="30" r="2" fill="#152cab" />
            <circle cx="78" cy="52" r="2.2" fill="#f7d801" />
        </svg>

        <svg class="splatter-cluster splatter-pos-2" viewBox="0 0 80 80" fill="none">
            <circle cx="40" cy="40" r="5" fill="#f7d801" />
            <circle cx="60" cy="28" r="3" fill="#f7d801" />
            <circle cx="24" cy="52" r="2.5" fill="#f59e0b" />
            <circle cx="55" cy="58" r="2" fill="#f7d801" />
        </svg>

        <!-- 6. Geometric Wireframe Accents -->
        <svg class="geo-shape geo-triangle-bold" viewBox="0 0 32 32">
            <polygon points="16,3 29,27 3,27" />
        </svg>

        <div class="geo-shape geo-concentric-circle">
            <svg viewBox="0 0 58 58" width="100%" height="100%" fill="none">
                <circle cx="29" cy="29" r="26" stroke="#64748b" stroke-width="1.8" />
                <circle cx="29" cy="29" r="18" stroke="#f59e0b" stroke-width="2.2" stroke-dasharray="4,4" />
                <circle cx="29" cy="29" r="4" fill="#152cab" />
            </svg>
        </div>

        <div class="geo-shape geo-square-tilted"></div>

        <div class="geo-shape geo-plus-mark" style="top: 110px; left: 16px; color: #152cab; opacity: 0.20;">+</div>
        <div class="geo-shape geo-plus-mark" style="bottom: 35px; right: 280px; color: #f59e0b; opacity: 0.24;">+</div>
        <div class="geo-shape geo-plus-mark" style="top: 25px; right: 540px; color: #64748b; opacity: 0.18;">+</div>
    </div>

    <div class="container">
        <div class="hero-content">
            <div class="hero-badge-artisan">
                <div class="badge-brush-backing"></div>
                <span class="badge-brush-text">&bull; VERIFIED SOURCE ASSETS &amp; TEMPLATES</span>
            </div>

            <h1 class="hero-title">
                Source code, template, dan aset digital 
                <span class="brush-highlight-dynamic">
                    <span class="word-text">siap pakai.</span>
                    <svg class="brush-svg-multi" viewBox="0 0 300 24" fill="none" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M4 16 C55 10 130 18 205 12 C250 8 285 13 296 10 C285 18 230 21 170 20 C100 19 45 21 8 18 C3 17 2 16 4 16 Z" fill="#f59e0b" opacity="0.85" />
                        <path d="M14 10 C65 6 150 12 225 8 C270 5 292 9 298 7 C288 15 235 17 180 16 C120 15 55 17 18 14 C10 13 8 10 14 10 Z" fill="#f7d801" />
                        <path d="M25 6 C90 3 180 8 260 5" stroke="#fef08a" stroke-width="2" stroke-linecap="round" />
                        <circle cx="295" cy="15" r="1.8" fill="#f59e0b" />
                        <circle cx="288" cy="19" r="1.2" fill="#f7d801" />
                    </svg>
                </span>
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
                <span><strong style="color: var(--brand-cobalt);">&#10003;</strong> Download instan via Google Drive</span>
                <span><strong style="color: var(--brand-cobalt);">&#10003;</strong> Lisensi komersial bebas</span>
                <span><strong style="color: var(--brand-cobalt);">&#10003;</strong> Bayar otomatis via Midtrans (QRIS &amp; VA)</span>
            </div>
        </div>
    </div>
</section>

<!-- 2. Katalog Section -->
<section id="katalog" class="section">
    <div class="container">
        <!-- Organic Paint Stroke Divider Line -->
        <svg class="brush-divider" viewBox="0 0 1100 12" fill="none" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0 6 C200 3 450 9 700 5 C900 2 1050 7 1100 5" stroke="#152cab" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="60 20 180 15 240 30" opacity="0.3" />
            <path d="M120 7 C350 4 600 10 850 6" stroke="#f7d801" stroke-width="3" stroke-linecap="round" stroke-dasharray="100 25 150 20" opacity="0.75" />
        </svg>
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
