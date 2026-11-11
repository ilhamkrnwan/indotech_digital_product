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

<!-- Category Header -->
<section class="catalog-page-hero">
    <?php get_template_part( 'template-parts/nebula-field' ); ?>
    <div class="catalog-hero-particles" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="container catalog-page-hero-content">
        <div class="catalog-page-hero-back-wrap">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-secondary btn-sm catalog-page-hero-back">
                <?php echo digitalproduk_get_icon( 'arrow-left', 'back-arrow', 14 ); ?>
                <span>Kembali ke Semua Produk</span>
            </a>
        </div>

        <h1 class="catalog-page-hero-title">
            <span class="hero-title-gradient"><?php echo esc_html( $cat_name ); ?></span>
        </h1>
        <?php if ( ! empty( $cat_desc ) ) : ?>
            <p class="catalog-page-hero-desc">
                <?php echo esc_html( $cat_desc ); ?>
            </p>
        <?php else : ?>
            <p class="catalog-page-hero-desc">
                Produk <?php echo esc_html( strtolower( $cat_name ) ); ?> yang tersedia saat ini.
            </p>
        <?php endif; ?>

        <div class="category-filter-list catalog-page-filters">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="filter-btn">
                Semua
            </a>
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" 
                       class="filter-btn <?php echo $cat->term_id === $current_cat->term_id ? 'active' : ''; ?>">
                        <span><?php echo esc_html( $cat->name ); ?></span>
                        <span class="catalog-category-count">(<?php echo esc_html( $cat->count ); ?>)</span>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Products In Category -->
<section class="section">
    <div class="container">
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
