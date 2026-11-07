<?php
/**
 * The template for displaying Digital Product Archive (All Products)
 * Indotech Technical Commerce Design System
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
<section class="section" style="padding: 3.5rem 0 2rem; background: var(--bg-canvas); border-bottom: 1px solid var(--border-main);">
    <div class="container text-center">
        <div class="hero-pill" style="margin: 0 auto 1.25rem;">
            <?php echo digitalproduk_get_icon( 'layers', '', 14 ); ?>
            <span>KATALOG LENGKAP ASET DIGITAL</span>
        </div>
        <h1 class="hero-title" style="margin-bottom: 0.75rem;">Eksplorasi Semua Produk Siap Pakai</h1>
        <p class="hero-desc" style="margin: 0 auto 2rem; max-width: 650px;">
            Kumpulan source code web apps, plugin WordPress mandiri, Figma UI kit, dan Notion OS untuk mempercepat rilis proyek Anda.
        </p>

        <!-- Search Bar -->
        <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="hero-store-search" style="margin: 0 auto 1.5rem; max-width: 600px;">
            <input type="text" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="Cari nama produk, framework (Next.js, PHP), atau lisensi..." class="hero-search-input" />
            <button type="submit" class="btn btn-primary">
                <span>Cari Aset</span>
                <?php echo digitalproduk_get_icon( 'search', 'btn-icon', 15 ); ?>
            </button>
        </form>

        <!-- Category Filter Pills -->
        <div class="category-filter-list" style="justify-content: center;">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="filter-btn <?php echo empty( $search_query ) ? 'active' : ''; ?>">
                <?php echo digitalproduk_get_icon( 'layers', '', 14 ); ?>
                <span>Semua Kategori</span>
            </a>
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="filter-btn">
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

<!-- Grid Katalog Produk -->
<section class="section">
    <div class="container">
        <?php
        if ( ! empty( $search_query ) ) {
            echo '<p style="margin-bottom: 2rem; font-weight: 600; color: var(--text-secondary); font-size: 0.95rem;">Menampilkan hasil pencarian untuk: "<strong>' . esc_html( $search_query ) . '</strong>"</p>';
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
            <div style="text-align: center; padding: 4rem 1.5rem; background: #ffffff; border: 1px solid var(--border-main); border-radius: var(--radius-lg); max-width: 550px; margin: 0 auto;">
                <div style="width: 54px; height: 54px; border-radius: 50%; background: var(--bg-canvas); color: var(--text-muted); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <?php echo digitalproduk_get_icon( 'search', 'empty-svg', 26 ); ?>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Tidak Ada Produk yang Cocok</h3>
                <p style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 1.5rem;">
                    Coba gunakan kata kunci pencarian yang lebih umum atau kembali ke seluruh katalog produk.
                </p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-primary">
                    <span>Lihat Semua Produk</span>
                    <?php echo digitalproduk_get_icon( 'arrow-right', 'btn-icon-right', 15 ); ?>
                </a>
            </div>
            <?php
        endif;
        ?>
    </div>
</section>

<?php
get_footer();
