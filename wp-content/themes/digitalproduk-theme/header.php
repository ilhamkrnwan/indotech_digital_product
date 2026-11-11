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
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand" aria-label="Indotechnology Home">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-indotechnology-2026.png' ); ?>"
                 alt="Indotechnology - BUILD • INNOVATE • GROW"
                 class="brand-logo-img"
                 width="193"
                 height="40"
                 fetchpriority="high" />
        </a>

        <?php
        $nav_categories = get_terms([
            'taxonomy'   => 'product_category',
            'hide_empty' => false,
        ]);
        ?>

        <button class="menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false">
            <span class="screen-reader-text"><?php esc_html_e( 'Buka menu utama', 'digitalproduk' ); ?></span>
            <span class="menu-toggle-line" aria-hidden="true"></span>
            <span class="menu-toggle-line" aria-hidden="true"></span>
            <span class="menu-toggle-line" aria-hidden="true"></span>
        </button>

        <nav class="main-navigation" id="site-navigation" aria-label="<?php esc_attr_e( 'Main Menu', 'digitalproduk' ); ?>">
            <ul class="nav-menu">
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a></li>
                <li><a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>">Semua Produk</a></li>
                
                <?php if ( ! empty( $nav_categories ) && ! is_wp_error( $nav_categories ) ) : ?>
                    <li class="nav-item-dropdown">
                        <button type="button" class="nav-dropdown-trigger" aria-expanded="false" aria-controls="category-navigation">
                            <span>Kategori</span>
                            <span class="dropdown-caret"><?php echo digitalproduk_get_icon( 'chevron-down', 'caret-icon', 14 ); ?></span>
                        </button>
                        <div class="nav-dropdown-panel" id="category-navigation">
                            <div class="dropdown-cats-list">
                                <?php foreach ( $nav_categories as $cat ) : ?>
                                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="dropdown-cat-item">
                                        <div class="cat-item-text">
                                            <strong><?php echo esc_html( $cat->name ); ?></strong>
                                        </div>
                                        <span class="cat-item-count"><?php echo esc_html( $cat->count ); ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>

                <li><a href="<?php echo esc_url( home_url( '/#cara-kerja' ) ); ?>">Cara Beli</a></li>
                <li><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>">FAQ</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            <a href="<?php echo esc_url( home_url( '/checkout/' ) ); ?>" class="btn btn-secondary btn-sm">
                <span>Checkout</span>
            </a>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="btn btn-primary btn-sm">
                <span>Katalog Produk</span>
            </a>
        </div>
    </div>
</header>
<main id="primary" class="site-main">
