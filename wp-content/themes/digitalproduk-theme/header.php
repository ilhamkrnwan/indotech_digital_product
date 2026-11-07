<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Minimalist Announcement Banner -->
<div class="spec-banner" style="background: #ffffff; border-bottom: 1px solid var(--border-main); padding: 0.45rem 0; font-size: 0.8rem;">
    <div class="container" style="display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 0.6rem;">
            <span style="font-family: var(--font-mono); font-size: 0.725rem; font-weight: 700; color: var(--brand-cobalt); background: var(--brand-cobalt-light); border: 1px solid var(--brand-cobalt-border); padding: 2px 7px; border-radius: var(--radius-sm);">INDOTECH DIGITAL STORE</span>
            <span style="color: var(--text-secondary); font-size: 0.8rem;">Akses download instan otomatis pasca verifikasi Midtrans (QRIS &amp; Virtual Account).</span>
        </div>
        <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--status-success); display: flex; align-items: center; gap: 5px; font-weight: 600;">
            <span style="width: 7px; height: 7px; border-radius: 50%; background: var(--status-success); display: inline-block;"></span>
            <span>Midtrans API Verified</span>
        </div>
    </div>
</div>

<header class="site-header">
    <div class="container header-container">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand">
            <div class="brand-badge">IT</div>
            <div class="brand-text-block">
                <span class="brand-title">Indotech</span>
                <span class="brand-subtag">Katalog Aset Digital</span>
            </div>
        </a>

        <?php
        $nav_categories = get_terms([
            'taxonomy'   => 'product_category',
            'hide_empty' => false,
        ]);
        ?>

        <nav class="main-navigation" id="site-navigation" aria-label="<?php esc_attr_e( 'Main Menu', 'digitalproduk' ); ?>">
            <ul class="nav-menu">
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a></li>
                <li><a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>">Semua Aset</a></li>
                
                <!-- Category Dropdown Menu -->
                <li class="nav-item-dropdown">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="nav-dropdown-trigger" aria-haspopup="true">
                        <span>Kategori</span>
                        <span class="dropdown-caret"><?php echo digitalproduk_get_icon( 'chevron-down', 'caret-icon', 14 ); ?></span>
                    </a>
                    
                    <div class="nav-dropdown-panel">
                        <div class="dropdown-top-meta">
                            <span class="dropdown-badge"><?php echo digitalproduk_get_icon( 'layers', '', 14 ); ?> KATALOG TERSTRUKTUR</span>
                            <span class="dropdown-hint">Pilih aset digital sesuai spesifikasi teknologi</span>
                        </div>
                        <div class="dropdown-cats-list">
                            <?php if ( ! empty( $nav_categories ) && ! is_wp_error( $nav_categories ) ) : ?>
                                <?php foreach ( $nav_categories as $cat ) : 
                                    $cat_meta = digitalproduk_get_category_meta( $cat->slug );
                                ?>
                                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="dropdown-cat-item">
                                        <span class="cat-item-icon-wrap">
                                            <?php echo digitalproduk_get_icon( $cat_meta['icon'], 'cat-svg-icon', 16 ); ?>
                                        </span>
                                        <div class="cat-item-text">
                                            <strong><?php echo esc_html( $cat->name ); ?></strong>
                                            <p><?php echo esc_html( $cat_meta['desc'] ); ?></p>
                                        </div>
                                        <span class="cat-item-count"><?php echo esc_html( $cat->count ); ?></span>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="dropdown-bottom-cta">
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>">
                                <span>Lihat Semua Produk &amp; Filter Lengkap</span>
                                <?php echo digitalproduk_get_icon( 'arrow-right', 'cta-arrow', 14 ); ?>
                            </a>
                        </div>
                    </div>
                </li>

                <li><a href="<?php echo esc_url( home_url( '/#cara-kerja' ) ); ?>">Alur Pembelian</a></li>
                <li><a href="<?php echo esc_url( home_url( '/#keunggulan' ) ); ?>">Standar Kualitas</a></li>
                <li><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>">Tanya Jawab</a></li>
            </ul>
        </nav>

        <div class="header-actions" style="display: flex; align-items: center; gap: 0.75rem;">
            <a href="<?php echo esc_url( home_url( '/checkout/' ) ); ?>" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
                <?php echo digitalproduk_get_icon( 'shopping-bag', '', 14 ); ?>
                <span>Checkout</span>
            </a>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-primary btn-sm">
                <span>Katalog Produk</span>
                <?php echo digitalproduk_get_icon( 'arrow-right', 'btn-icon-right', 14 ); ?>
            </a>
        </div>
    </div>
</header>
<main id="primary" class="site-main">
