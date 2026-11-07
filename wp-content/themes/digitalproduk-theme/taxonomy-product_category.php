<?php
/**
 * The template for displaying Product Category Archives
 * Clean, direct, utilitarian
 *
 * @package DigitalProduk
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$current_cat = get_queried_object();
$cat_name = $current_cat->name ?? 'Kategori Produk';
$cat_desc = $current_cat->description ?: '';

// Semua kategori produk untuk switcher
$categories = get_terms([
    'taxonomy'   => 'product_category',
    'hide_empty' => false,
]);
?>

<!-- Category Header Banner (Option B: Dynamic Brush Art & Wireframes) -->
<section class="section category-hero-section" style="padding: 3.5rem 0 2rem; background: #ffffff; border-bottom: 1px solid var(--border-main); position: relative; overflow: hidden;">
    <!-- Abstract Brush & Wireframe Canvas for Category Page -->
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
        <div class="category-geo-plus" style="top: 70px; left: 60px; color: #152cab; opacity: 0.20;">+</div>
        <div class="category-geo-plus" style="top: 130px; right: 480px; color: #f59e0b; opacity: 0.24;">+</div>
    </div>

    <div class="container text-center" style="position: relative; z-index: 10;">
        <div style="margin-bottom: 1.25rem;">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
                <?php echo digitalproduk_get_icon( 'arrow-left', 'back-arrow', 14 ); ?>
                <span>Kembali ke Semua Produk</span>
            </a>
        </div>

        <div class="hero-badge-artisan" style="margin-bottom: 0.75rem;">
            <div class="badge-brush-backing"></div>
            <span class="badge-brush-text">&bull; KATEGORI TERVERIFIKASI</span>
        </div>

        <h1 class="hero-title" style="margin-bottom: 0.75rem; font-size: 2.75rem; font-weight: 900; letter-spacing: -0.03em;">
            <span class="brush-highlight-dynamic">
                <span class="word-text"><?php echo esc_html( $cat_name ); ?></span>
                <svg class="brush-svg-multi" viewBox="0 0 300 24" fill="none" preserveAspectRatio="none" aria-hidden="true">
                    <path d="M4 16 C55 10 130 18 205 12 C250 8 285 13 296 10 C285 18 230 21 170 20 C100 19 45 21 8 18 C3 17 2 16 4 16 Z" fill="#f59e0b" opacity="0.85" />
                    <path d="M14 10 C65 6 150 12 225 8 C270 5 292 9 298 7 C288 15 235 17 180 16 C120 15 55 17 18 14 C10 13 8 10 14 10 Z" fill="#f7d801" />
                    <circle cx="295" cy="15" r="1.8" fill="#f59e0b" />
                </svg>
            </span>
        </h1>
        <?php if ( ! empty( $cat_desc ) ) : ?>
            <p class="hero-desc" style="margin: 0 auto 1.5rem; max-width: 580px; font-size: 1rem;">
                <?php echo esc_html( $cat_desc ); ?>
            </p>
        <?php else : ?>
            <p class="hero-desc" style="margin: 0 auto 1.5rem; max-width: 580px; font-size: 1rem;">
                Koleksi <?php echo esc_html( strtolower( $cat_name ) ); ?> pilihan siap pakai dengan lisensi komersial dan download instan.
            </p>
        <?php endif; ?>

        <!-- Category Nav Switcher -->
        <div class="category-filter-list" style="justify-content: center; margin-top: 1rem;">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="filter-btn">
                Semua
            </a>
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" 
                       class="filter-btn <?php echo $cat->term_id === $current_cat->term_id ? 'active' : ''; ?>">
                        <span><?php echo esc_html( $cat->name ); ?></span>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">(<?php echo esc_html( $cat->count ); ?>)</span>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Products In Category -->
<section class="section">
    <div class="container">
        <!-- Organic Paint Stroke Divider Line -->
        <svg class="brush-divider" viewBox="0 0 1100 12" fill="none" preserveAspectRatio="none" aria-hidden="true" style="margin-bottom: 2.25rem;">
            <path d="M0 6 C200 3 450 9 700 5 C900 2 1050 7 1100 5" stroke="#152cab" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="60 20 180 15 240 30" opacity="0.3" />
            <path d="M120 7 C350 4 600 10 850 6" stroke="#f7d801" stroke-width="3" stroke-linecap="round" stroke-dasharray="100 25 150 20" opacity="0.75" />
        </svg>

        <?php if ( have_posts() ) : ?>
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
        <?php else : ?>
            <div style="text-align: center; padding: 3rem 1.5rem; background: #ffffff; border: 1px solid var(--border-main); border-radius: var(--radius-md); max-width: 500px; margin: 0 auto;">
                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Belum Ada Produk di Kategori Ini</h3>
                <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1.25rem;">
                    Produk baru untuk kategori ini sedang disiapkan.
                </p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-primary btn-sm">
                    <span>Lihat Produk Lain</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();
