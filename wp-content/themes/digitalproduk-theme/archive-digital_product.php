<?php
/**
 * The template for displaying Digital Product Archive (All Products)
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
<section class="archive-header-section">
    <div class="container text-center">
        <div class="playful-sticker">
            <?php echo digitalproduk_get_icon( 'sparkles', '', 14 ); ?>
            <span>KATALOG PILIHAN DEVELOPER &amp; KREATOR</span>
        </div>
        <h1 class="archive-main-title">Eksplorasi Semua Aset Digital Siap Pakai</h1>
        <p class="archive-main-desc">
            Kumpulan source code web apps, Figma UI kit, starter stack, blueprint sistem, dan panduan praktis untuk meluncurkan proyek Anda 10x lebih cepat.
        </p>

        <!-- Search Bar -->
        <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="archive-search-form">
            <input type="text" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="Cari source code, template Figma, e-book..." class="archive-search-input" />
            <button type="submit" class="btn btn-primary">
                <span>Cari Aset</span>
                <?php echo digitalproduk_get_icon( 'search', 'btn-icon-right', 16 ); ?>
            </button>
        </form>

        <!-- Category Pills -->
        <div class="archive-category-chips">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="chip-item <?php echo empty( $search_query ) ? 'active' : ''; ?>">
                <?php echo digitalproduk_get_icon( 'layers', '', 14 ); ?>
                <span>Semua Kategori</span>
            </a>
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="chip-item">
                        <span><?php echo esc_html( $cat->name ); ?></span>
                        <span class="chip-count"><?php echo esc_html( $cat->count ); ?></span>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Grid Katalog Produk -->
<section class="section" style="padding-top: 2rem;">
    <div class="container">
        <?php
        // Filter search jika ada query
        if ( ! empty( $search_query ) ) {
            global $wp_query;
            $args = array_merge( $wp_query->query_vars, [ 's' => $search_query ] );
            query_posts( $args );
            echo '<p style="margin-bottom: 2rem; font-weight: 700; color: var(--color-body-text);">Hasil pencarian untuk: "<em>' . esc_html( $search_query ) . '</em>"</p>';
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
            <div class="archive-pagination">
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
            <div class="empty-state-box">
                <div class="empty-icon">
                    <?php echo digitalproduk_get_icon( 'search', 'empty-svg', 40 ); ?>
                </div>
                <h3>Tidak ada produk yang cocok</h3>
                <p>Coba gunakan kata kunci lain atau jelajahi koleksi lengkap yang tersedia di katalog utama kami.</p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-primary" style="margin-top: 1rem;">
                    <span>Lihat Semua Produk</span>
                    <?php echo digitalproduk_get_icon( 'arrow-right', 'btn-icon-right', 16 ); ?>
                </a>
            </div>
            <?php
        endif;
        ?>
    </div>
</section>

<?php
get_footer();
