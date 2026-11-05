<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container header-container">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-indotech-landscape.avif' ); ?>" 
                 alt="Indotech Digital Produk" 
                 class="brand-logo-img" 
                 height="42" />
            <span class="brand-subtag">Digital Store</span>
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
                
                <!-- Category Dropdown Menu -->
                <li class="nav-item-dropdown">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="nav-dropdown-trigger" aria-haspopup="true">
                        <span>Produk Kami</span>
                        <span class="dropdown-caret">▾</span>
                    </a>
                    
                    <div class="nav-dropdown-panel">
                        <div class="dropdown-top-meta">
                            <span class="dropdown-badge">KATALOG KATEGORI</span>
                            <span class="dropdown-hint">Pilih kategori aset sesuai kebutuhan Anda</span>
                        </div>
                        <div class="dropdown-cats-list">
                            <?php if ( ! empty( $nav_categories ) && ! is_wp_error( $nav_categories ) ) : ?>
                                <?php foreach ( $nav_categories as $cat ) : 
                                    $cat_meta = digitalproduk_get_category_meta( $cat->slug );
                                ?>
                                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="dropdown-cat-item">
                                        <span class="cat-item-icon"><?php echo esc_html( $cat_meta['icon'] ); ?></span>
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
                                <span>Lihat Semua Produk & Filter Lengkap</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </li>

                <li><a href="<?php echo esc_url( home_url( '/#bonus-section' ) ); ?>">Bonus Praktis</a></li>
                <li><a href="<?php echo esc_url( home_url( '/#keunggulan' ) ); ?>">Keunggulan</a></li>
                <li><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>">FAQ</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-primary btn-sm">Katalog Lengkap ⚡</a>
        </div>
    </div>
</header>
<main id="primary" class="site-main">
