<?php
/**
 * The template for displaying Digital Product Archive (All Products)
 * Clean, direct, utilitarian
 *
 * @package DigitalProduk
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Semua kategori produk
$categories = get_terms([
    'taxonomy'   => 'product_category',
    'hide_empty' => false,
]);

// Search query
$search_query = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : ( isset( $_GET['q'] ) ? sanitize_text_field( $_GET['q'] ) : '' );
?>

<!-- Header Katalog (Option B: Dynamic Brush Art & Wireframes) -->
<section class="section category-hero-section" style="padding: 3.5rem 0 2rem; background: #ffffff; border-bottom: 1px solid var(--border-main); position: relative; overflow: hidden;">
    <!-- Abstract Brush & Wireframe Canvas for Archive Page -->
    <div class="category-art-canvas" aria-hidden="true">
        <!-- Top Right Cobalt Splash (Organic Curved & Tapered) -->
        <svg class="category-stroke-splash" viewBox="0 0 450 300" fill="none">
            <path d="M120 35 C 160 18, 210 28, 255 16 C 300 6, 350 12, 395 28 C 430 42, 445 68, 448 95 C 450 125, 435 155, 415 180 C 385 215, 345 245, 305 235 C 270 225, 250 195, 240 165 C 230 135, 235 105, 215 80 C 190 52, 150 48, 120 35 Z" fill="#152cab" opacity="0.9" />
            <path d="M170 32 C 215 18, 270 24, 315 14 C 360 8, 400 20, 435 40 C 445 55, 445 80, 435 105 C 415 140, 375 168, 335 180 C 305 188, 285 170, 288 150 C 292 125, 310 100, 300 78 C 285 55, 235 48, 170 32 Z" fill="#2563eb" opacity="0.35" />
            <path d="M220 35 C 270 24, 330 38, 380 26 C 410 18, 430 32, 440 28 C 435 48, 395 55, 350 50 C 290 45, 240 60, 210 45 C 195 38, 205 28, 220 35 Z" fill="#f7d801" />
            <circle cx="210" cy="85" r="4.5" fill="#152cab" />
            <circle cx="185" cy="115" r="3" fill="#152cab" />
            <circle cx="255" cy="135" r="3.5" fill="#152cab" />
            <circle cx="240" cy="65" r="3" fill="#f7d801" />
        </svg>

        <!-- Wireframe Triangle Left -->
        <svg class="category-geo-triangle" viewBox="0 0 32 32" fill="none">
            <polygon points="16,3 29,27 3,27" stroke="#152cab" stroke-width="2.5" />
        </svg>

        <!-- Plus Marks -->
        <div class="category-geo-plus" style="top: 70px; left: 60px; color: #152cab; opacity: 0.7;">+</div>
        <div class="category-geo-plus" style="top: 130px; right: 480px; color: #f59e0b; opacity: 0.85;">+</div>
    </div>

    <div class="container text-center" style="position: relative; z-index: 10;">
        <div class="hero-badge-artisan" style="margin-bottom: 0.75rem;">
            <div class="badge-brush-backing"></div>
            <span class="badge-brush-text">&bull; VERIFIED ASSETS CATALOG</span>
        </div>

        <h1 class="hero-title" style="margin-bottom: 0.75rem; font-size: 2.75rem; font-weight: 900; letter-spacing: -0.03em;">
            Semua 
            <span class="brush-highlight-dynamic">
                <span class="word-text">Produk.</span>
                <svg class="brush-svg-multi" viewBox="0 0 300 24" fill="none" preserveAspectRatio="none" aria-hidden="true">
                    <path d="M4 16 C55 10 130 18 205 12 C250 8 285 13 296 10 C285 18 230 21 170 20 C100 19 45 21 8 18 C3 17 2 16 4 16 Z" fill="#f59e0b" opacity="0.85" />
                    <path d="M14 10 C65 6 150 12 225 8 C270 5 292 9 298 7 C288 15 235 17 180 16 C120 15 55 17 18 14 C10 13 8 10 14 10 Z" fill="#f7d801" />
                    <circle cx="295" cy="15" r="1.8" fill="#f59e0b" />
                </svg>
            </span>
        </h1>
        <p class="hero-desc" style="margin: 0 auto 1.5rem; max-width: 580px; font-size: 1rem;">
            Temukan source code web apps, plugin WordPress, dan template desain siap pakai.
        </p>

        <!-- Search Bar -->
        <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="hero-store-search" style="margin: 0 auto 1.25rem; max-width: 500px;">
            <input type="text" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="Cari nama produk atau framework..." class="hero-search-input" />
            <button type="submit" class="btn btn-primary btn-sm">
                <span>Cari</span>
            </button>
        </form>

        <!-- Category Filter Pills -->
        <div class="category-filter-list" style="justify-content: center;">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="filter-btn <?php echo empty( $search_query ) ? 'active' : ''; ?>">
                Semua
            </a>
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="filter-btn">
                        <span><?php echo esc_html( $cat->name ); ?></span>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">(<?php echo esc_html( $cat->count ); ?>)</span>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Grid Katalog Produk -->
<section class="section">
    <div class="container">
        <!-- Organic Paint Stroke Divider Line -->
        <svg class="brush-divider" viewBox="0 0 1100 12" fill="none" preserveAspectRatio="none" aria-hidden="true" style="margin-bottom: 2.25rem;">
            <path d="M0 6 C200 3 450 9 700 5 C900 2 1050 7 1100 5" stroke="#152cab" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="60 20 180 15 240 30" opacity="0.3" />
            <path d="M120 7 C350 4 600 10 850 6" stroke="#f7d801" stroke-width="3" stroke-linecap="round" stroke-dasharray="100 25 150 20" opacity="0.75" />
        </svg>

        <?php
        if ( ! empty( $search_query ) ) {
            echo '<p style="margin-bottom: 1.5rem; font-size: 0.95rem; color: var(--text-secondary);">Hasil pencarian untuk: "<strong>' . esc_html( $search_query ) . '</strong>"</p>';
        }

        if ( have_posts() ) :
            ?>
            <div class="products-grid">
                <?php
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/product-card' );
                endwhile;
                ?>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 3rem; text-align: center;">
                <?php
                the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => '&larr; Sebelumnya',
                    'next_text' => 'Selanjutnya &rarr;',
                ]);
                ?>
            </div>
            <?php
        else :
            ?>
            <div style="text-align: center; padding: 3rem 1.5rem; background: #ffffff; border: 1px solid var(--border-main); border-radius: var(--radius-md); max-width: 500px; margin: 0 auto;">
                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Tidak Ada Produk yang Cocok</h3>
                <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1.25rem;">
                    Silakan gunakan kata kunci lain atau kembali ke seluruh katalog produk.
                </p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-primary btn-sm">
                    <span>Lihat Semua Produk</span>
                </a>
            </div>
            <?php
        endif;
        ?>
    </div>
</section>

<?php
get_footer();
