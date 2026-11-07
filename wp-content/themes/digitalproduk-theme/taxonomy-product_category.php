<?php
/**
 * The template for displaying Product Category Archives
 * Indotech Technical Commerce Design System
 *
 * @package DigitalProduk
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$current_cat = get_queried_object();
$cat_slug = $current_cat->slug ?? '';
$cat_name = $current_cat->name ?? 'Kategori Produk';
$cat_desc = $current_cat->description ?: 'Koleksi aset, template, dan source code premium dalam kategori ini.';

// Semua kategori produk untuk switcher
$categories = get_terms([
    'taxonomy'   => 'product_category',
    'hide_empty' => false,
]);
?>

<!-- Category Header Banner -->
<section class="section" style="padding: 3.5rem 0 2rem; background: var(--bg-canvas); border-bottom: 1px solid var(--border-main);">
    <div class="container text-center">
        <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-secondary btn-sm" style="margin-bottom: 1.25rem;">
            <?php echo digitalproduk_get_icon( 'arrow-left', 'back-arrow', 14 ); ?>
            <span>Kembali ke Semua Katalog</span>
        </a>

        <div class="hero-pill" style="margin: 0 auto 1.25rem;">
            <?php echo digitalproduk_get_icon( 'tag', '', 14 ); ?>
            <span>KATEGORI ASET</span>
        </div>

        <h1 class="hero-title" style="margin-bottom: 0.75rem;"><?php echo esc_html( $cat_name ); ?></h1>
        <p class="hero-desc" style="margin: 0 auto 2rem; max-width: 650px;">
            <?php echo esc_html( $cat_desc ); ?>
        </p>

        <!-- Category Nav Switcher -->
        <div class="category-filter-list" style="justify-content: center;">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="filter-btn">
                <?php echo digitalproduk_get_icon( 'layers', '', 14 ); ?>
                <span>Semua Kategori</span>
            </a>
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" 
                       class="filter-btn <?php echo $cat->term_id === $current_cat->term_id ? 'active' : ''; ?>">
                        <span><?php echo esc_html( $cat->name ); ?></span>
                        <span style="font-family: var(--font-mono); font-size: 0.725rem; background: var(--border-subtle); padding: 1px 5px; border-radius: 3px; color: var(--text-muted);">
                            <?php echo esc_html( $cat->count ); ?>
                        </span>
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
            <div style="text-align: center; padding: 4rem 1.5rem; background: #ffffff; border: 1px solid var(--border-main); border-radius: var(--radius-lg); max-width: 550px; margin: 0 auto;">
                <div style="width: 54px; height: 54px; border-radius: 50%; background: var(--bg-canvas); color: var(--text-muted); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <?php echo digitalproduk_get_icon( 'package', 'empty-svg', 26 ); ?>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Belum Ada Produk di Kategori Ini</h3>
                <p style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 1.5rem;">
                    Aset baru untuk kategori ini sedang disiapkan oleh tim developer dan desainer kami.
                </p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-primary">
                    <span>Jelajahi Produk Lain</span>
                    <?php echo digitalproduk_get_icon( 'arrow-right', 'btn-icon-right', 15 ); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();
