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
            <span class="brand-badge">⚡</span>
            <span class="brand-text">Digital<strong>Produk</strong></span>
        </a>

        <nav class="main-navigation" id="site-navigation" aria-label="<?php esc_attr_e( 'Main Menu', 'digitalproduk' ); ?>">
            <ul class="nav-menu">
                <li><a href="#katalog">Katalog Produk</a></li>
                <li><a href="#keunggulan">Keunggulan</a></li>
                <li><a href="#testimoni">Testimoni</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            <a href="#katalog" class="btn btn-primary btn-sm">Jelajahi Produk</a>
        </div>
    </div>
</header>
<main id="primary" class="site-main">
