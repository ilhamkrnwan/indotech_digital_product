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

<!-- Category Header Banner (Modern Cyber) -->
<section class="section category-hero-section" style="padding: 3.75rem 0 2.25rem; background: var(--gradient-hero); color: #ffffff; border-bottom: 1px solid rgba(0, 210, 255, 0.25); position: relative; overflow: hidden;">
    <div class="tech-grid-matrix" aria-hidden="true"></div>
    <div class="cyber-glow-blob blob-cyan" style="top: -60px; right: 5%; width: 300px; height: 300px;" aria-hidden="true"></div>

    <div class="container text-center" style="position: relative; z-index: 10;">
        <div style="margin-bottom: 1.25rem;">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.25); color: #ffffff;">
                <?php echo digitalproduk_get_icon( 'arrow-left', 'back-arrow', 14 ); ?>
                <span>Kembali ke Semua Produk</span>
            </a>
        </div>

        <div class="hero-badge-tech" style="margin-bottom: 0.85rem;">
            <span class="badge-dot-live"></span>
            <span class="badge-text">KATEGORI TERVERIFIKASI</span>
        </div>

        <h1 class="hero-title" style="margin-bottom: 0.75rem; font-size: 2.75rem; font-weight: 900; letter-spacing: -0.03em; color: #ffffff;">
            <span class="hero-title-gradient"><?php echo esc_html( $cat_name ); ?></span>
        </h1>
        <?php if ( ! empty( $cat_desc ) ) : ?>
            <p class="hero-desc" style="margin: 0 auto 1.5rem; max-width: 580px; font-size: 1rem; color: #94a3b8;">
                <?php echo esc_html( $cat_desc ); ?>
            </p>
        <?php else : ?>
            <p class="hero-desc" style="margin: 0 auto 1.5rem; max-width: 580px; font-size: 1rem; color: #94a3b8;">
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
        <div class="section-tech-bar" aria-hidden="true"></div>

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
