<?php
/**
 * The template for displaying Digital Product Archive (All Products)
 *
 * @package DigitalProduk
 */

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
        <div class="playful-sticker">⚡ KATALOG LENGKAP ASET & TEMPLATE</div>
        <h1 class="archive-main-title">Eksplorasi Semua Produk Digital</h1>
        <p class="archive-main-desc">
            Kumpulan source code web apps, Figma UI kit, starter stack, database schema, dan panduan praktis untuk mempercepat proyek Anda.
        </p>

        <!-- Search Bar -->
        <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="archive-search-form">
            <input type="text" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="Cari source code, template Figma, e-book..." class="archive-search-input" />
            <button type="submit" class="btn btn-primary">Cari Aset 🔍</button>
        </form>

        <!-- Category Pills -->
        <div class="archive-category-chips">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="chip-item <?php echo empty( $search_query ) ? 'active' : ''; ?>">
                ✨ Semua Kategori
            </a>
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="chip-item">
                        <?php echo esc_html( $cat->name ); ?> (<?php echo esc_html( $cat->count ); ?>)
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
                    'prev_text' => '← Sebelumnya',
                    'next_text' => 'Selanjutnya →',
                ]);
                ?>
            </div>
            <?php
        else :
            ?>
            <div class="empty-state-box">
                <div class="empty-icon">🔍</div>
                <h3>Tidak ada produk yang cocok</h3>
                <p>Coba kata kunci lain atau lihat semua koleksi yang tersedia.</p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-primary" style="margin-top: 1rem;">
                    Kembali ke Semua Produk
                </a>
            </div>
            <?php
        endif;
        ?>
    </div>
</section>

<!-- Checkout Modal -->
<?php get_template_part( 'template-parts/checkout-modal' ); ?>

<?php
get_footer();
