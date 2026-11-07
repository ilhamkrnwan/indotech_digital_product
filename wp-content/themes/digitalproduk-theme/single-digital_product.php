<?php
/**
 * Single Digital Product Template
 * Clean, direct, focused
 *
 * @package DigitalProduk
 */

get_header();

while ( have_posts() ) :
    the_post();

    $product_id = get_the_ID();
    $price = get_post_meta( $product_id, '_price', true ) ?: 199000;
    $sale_price = get_post_meta( $product_id, '_sale_price', true ) ?: $price;
    $file_format = get_post_meta( $product_id, '_file_format', true ) ?: 'ZIP / Google Drive';
    
    $features_meta = get_post_meta( $product_id, '_features', true );
    $features = ! empty( $features_meta ) ? ( is_array( $features_meta ) ? $features_meta : explode( "\n", $features_meta ) ) : [
        'Akses file langsung via Google Drive',
        'Lisensi komersial (bebas untuk proyek klien)',
        'Update versi gratis selamanya'
    ];

    $item_cats = get_the_terms( $product_id, 'product_category' );
    $cat_name = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? $item_cats[0]->name : 'Produk Digital';
    $cat_link = ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ? get_term_link( $item_cats[0] ) : '#';
    ?>

    <!-- Breadcrumb -->
    <div class="product-breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb-inner">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
                <span>/</span>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>">Semua Produk</a>
                <span>/</span>
                <a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_name ); ?></a>
                <span>/</span>
                <span class="current-crumb"><?php the_title(); ?></span>
            </div>
        </div>
    </div>

    <!-- Product Detail Section -->
    <section class="section" style="padding-top: 2.5rem; padding-bottom: 3.5rem;">
        <div class="container">
            <div class="single-product-grid">
                
                <!-- Left: Gallery -->
                <div class="single-product-visual">
                    <?php $slides = digitalproduk_get_product_slides( $product_id ); ?>
                    
                    <div class="single-gallery-card">
                        <div class="gallery-main-frame" style="position: relative; overflow: hidden;">
                            <!-- Mini Corner Paint Splash -->
                            <svg class="thumb-paint-accent" viewBox="0 0 65 65" fill="none" aria-hidden="true">
                                <path d="M10 0 C25 10 40 5 55 18 C62 25 65 45 65 45 V0 H10 Z" fill="#152cab" opacity="0.85" />
                                <path d="M30 0 C45 8 55 12 65 15 V0 H30 Z" fill="#f7d801" />
                                <circle cx="35" cy="28" r="2.5" fill="#152cab" />
                            </svg>

                            <img id="mainProductPreview" 
                                 src="<?php echo esc_url( $slides[0]['url'] ); ?>" 
                                 alt="<?php the_title_attribute(); ?>" 
                                 class="main-preview-img" />
                        </div>

                        <?php if ( count( $slides ) > 1 ) : ?>
                            <div class="gallery-thumbs-grid">
                                <?php foreach ( $slides as $i => $slide ) : ?>
                                    <button type="button" 
                                            class="gallery-thumb-item <?php echo $i === 0 ? 'active' : ''; ?>"
                                            data-preview="<?php echo esc_url( $slide['url'] ); ?>"
                                            data-title="<?php echo esc_attr( $slide['title'] ); ?>">
                                        <img src="<?php echo esc_url( $slide['url'] ); ?>" alt="Slide <?php echo $i + 1; ?>" />
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right: Buy Card & Meta -->
                <div class="single-product-details">
                    <div class="product-buy-card">
                        <div style="margin-bottom: 0.5rem;">
                            <a href="<?php echo esc_url( $cat_link ); ?>" class="product-category">
                                <?php echo esc_html( $cat_name ); ?>
                            </a>
                        </div>

                        <h1 class="single-title"><?php the_title(); ?></h1>

                        <!-- Price Block -->
                        <div class="single-price-block" style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem;">
                            <div class="price-brush-tag">
                                <svg class="price-brush-bg" viewBox="0 0 120 30" fill="none" preserveAspectRatio="none" aria-hidden="true">
                                    <path d="M2 18 C25 10 65 20 110 14 C118 13 119 18 116 22 C90 26 50 25 10 24 C4 23 1 20 2 18 Z" fill="#f7d801" />
                                    <path d="M8 12 C35 6 75 14 112 10" stroke="#fef08a" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                <span class="single-sale-price price-val-bold" style="font-size: 1.4rem;">
                                    <?php echo digitalproduk_price( $sale_price ); ?>
                                </span>
                            </div>
                            <?php if ( $price > $sale_price ) : ?>
                                <span class="single-orig-price"><?php echo digitalproduk_price( $price ); ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- CTA Button -->
                        <a href="<?php echo esc_url( home_url( '/checkout/?product_id=' . $product_id ) ); ?>" class="btn btn-primary btn-lg btn-block" style="margin-bottom: 0.75rem;">
                            <span>Beli Sekarang</span>
                            <?php echo digitalproduk_get_icon( 'arrow-right', 'btn-icon-right', 16 ); ?>
                        </a>

                        <div style="text-align: center; margin-bottom: 1.25rem;">
                            <a href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo Indotech, saya ingin tanya produk: ' . get_the_title() ); ?>" target="_blank" rel="noopener" style="font-size: 0.825rem; color: var(--text-muted); display: inline-flex; align-items: center; gap: 0.4rem;">
                                <?php echo digitalproduk_get_icon( 'message-circle', '', 14 ); ?>
                                <span>Tanya via WhatsApp</span>
                            </a>
                        </div>

                        <!-- Benefits Checklist -->
                        <div style="border-top: 1px solid var(--border-subtle); padding-top: 1rem;">
                            <ul class="feature-check-list">
                                <li class="feature-check-item">
                                    <span class="check-icon"><?php echo digitalproduk_get_icon( 'check', '', 14 ); ?></span>
                                    <span>Format: <strong><?php echo esc_html( $file_format ); ?></strong></span>
                                </li>
                                <?php foreach ( $features as $f ) : ?>
                                    <li class="feature-check-item">
                                        <span class="check-icon"><?php echo digitalproduk_get_icon( 'check', '', 14 ); ?></span>
                                        <span><?php echo esc_html( trim( $f ) ); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Product Description -->
    <section class="section" style="background: #ffffff; border-top: 1px solid var(--border-main);">
        <div class="container" style="max-width: 820px;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">
                Deskripsi Produk
            </h2>
            <div style="font-size: 0.95rem; color: var(--text-secondary); line-height: 1.7;">
                <?php the_content(); ?>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <?php
    $related_args = [
        'post_type'      => 'digital_product',
        'posts_per_page' => 3,
        'post__not_in'   => [ $product_id ],
    ];

    if ( ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ) {
        $related_args['tax_query'] = [
            [
                'taxonomy' => 'product_category',
                'field'    => 'term_id',
                'terms'    => $item_cats[0]->term_id,
            ]
        ];
    }

    $related_query = new WP_Query( $related_args );

    if ( $related_query->have_posts() ) :
        ?>
        <section class="section" style="border-top: 1px solid var(--border-main);">
            <div class="container">
                <div class="section-header" style="margin-bottom: 1.5rem;">
                    <h2 class="section-title">Produk Terkait</h2>
                </div>
                <div class="products-grid">
                    <?php
                    while ( $related_query->have_posts() ) :
                        $related_query->the_post();
                        get_template_part( 'template-parts/product-card' );
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </section>
        <?php
    endif;
    ?>

<?php
endwhile;

get_footer();
