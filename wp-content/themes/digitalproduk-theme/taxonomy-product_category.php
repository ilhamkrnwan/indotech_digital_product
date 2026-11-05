<?php
/**
 * The template for displaying Product Category Archives
 *
 * @package DigitalProduk
 */

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

// Map visual badge per category
$badge_colors = [
    'source-code'     => 'card-cyan',
    'ui-ux-figma'     => 'card-pink',
    'template-notion' => 'card-purple',
    'e-book'          => 'card-yellow',
    'saas-tools'      => 'card-teal',
];
$active_color = $badge_colors[$cat_slug] ?? 'card-yellow';
?>

<!-- Category Header Banner -->
<section class="category-header-section <?php echo esc_attr( $active_color ); ?>">
    <div class="container text-center">
        <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="back-link">
            ← Kembali ke Semua Katalog
        </a>
        <div class="playful-sticker" style="margin-top: 1rem;">KATEGORI PRODUK</div>
        <h1 class="archive-main-title"><?php echo esc_html( $cat_name ); ?></h1>
        <p class="archive-main-desc">
            <?php echo esc_html( $cat_desc ); ?>
        </p>

        <!-- Category Nav Switcher -->
        <div class="archive-category-chips">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="chip-item">
                ✨ Semua Kategori
            </a>
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : ?>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" 
                       class="chip-item <?php echo $cat->term_id === $current_cat->term_id ? 'active' : ''; ?>">
                        <?php echo esc_html( $cat->name ); ?> (<?php echo esc_html( $cat->count ); ?>)
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
            <div class="archive-pagination">
                <?php
                the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => '← Sebelumnya',
                    'next_text' => 'Selanjutnya →',
                ]);
                ?>
            </div>
        <?php else : ?>
            <div class="empty-state-box">
                <div class="empty-icon">📦</div>
                <h3>Belum ada produk di kategori ini</h3>
                <p>Produk baru untuk kategori ini sedang disiapkan oleh tim developer & desainer kami.</p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-primary" style="margin-top: 1rem;">
                    Jelajahi Produk Lain
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Checkout Modal -->
<?php get_template_part( 'template-parts/checkout-modal' ); ?>

<?php
get_footer();
