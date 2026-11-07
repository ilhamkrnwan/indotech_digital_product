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
            <span class="brand-title"><span class="brand-part-lead">indo</span><span class="brand-part-tech">technology</span><span class="brand-dot">.</span></span>
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
                <li><a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>">Semua Produk</a></li>
                
                <?php if ( ! empty( $nav_categories ) && ! is_wp_error( $nav_categories ) ) : ?>
                    <li class="nav-item-dropdown">
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" class="nav-dropdown-trigger" aria-haspopup="true">
                            <span>Kategori</span>
                            <span class="dropdown-caret"><?php echo digitalproduk_get_icon( 'chevron-down', 'caret-icon', 14 ); ?></span>
                        </a>
                        <div class="nav-dropdown-panel">
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
