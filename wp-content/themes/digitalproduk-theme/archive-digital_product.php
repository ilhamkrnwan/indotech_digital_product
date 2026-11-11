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

<!-- Header Katalog -->
<section class="catalog-page-hero">
    <?php get_template_part( 'template-parts/nebula-field' ); ?>
    <div class="catalog-hero-particles" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="container catalog-page-hero-content">
        <h1 class="catalog-page-hero-title">
            Semua <span class="hero-title-gradient">Produk</span>
        </h1>
        <p class="catalog-page-hero-desc">
            Source code web app, plugin WordPress, dan template desain dalam satu katalog.
        </p>

        <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="catalog-page-search">
            <input type="text" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="Cari nama produk atau framework..." class="hero-search-input" aria-label="Cari produk" />
            <button type="submit" class="btn btn-primary btn-sm">
                <span>Cari</span>
            </button>
        </form>

        <div class="category-filter-list catalog-page-filters">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="filter-btn <?php echo empty( $search_query ) ? 'active' : ''; ?>">
                Semua
            </a>
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="filter-btn">
                        <span><?php echo esc_html( $cat->name ); ?></span>
                        <span class="catalog-category-count">(<?php echo esc_html( $cat->count ); ?>)</span>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Grid Katalog Produk -->
<section class="section">
    <div class="container">
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
