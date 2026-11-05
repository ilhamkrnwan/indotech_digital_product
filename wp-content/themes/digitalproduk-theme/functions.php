<?php
/**
 * Theme functions and definitions
 *
 * @package DigitalProduk
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'DIGITALPRODUK_VERSION', '1.0.0' );

/**
 * Setup Theme Defaults
 */
function digitalproduk_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
    add_theme_support( 'responsive-embeds' );
    
    register_nav_menus([
        'primary' => __( 'Primary Menu', 'digitalproduk' ),
        'footer'  => __( 'Footer Menu', 'digitalproduk' ),
    ]);
}
add_action( 'after_setup_theme', 'digitalproduk_setup' );

/**
 * Enqueue scripts and styles
 */
function digitalproduk_scripts() {
    wp_enqueue_style( 'digitalproduk-fonts', 'https://fonts.googleapis.com/css2?family=Fredoka:wght@600;700&family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap', [], null );
    wp_enqueue_style( 'digitalproduk-main', get_template_directory_uri() . '/assets/css/main.css', [], DIGITALPRODUK_VERSION );
    wp_enqueue_script( 'digitalproduk-main', get_template_directory_uri() . '/assets/js/main.js', [], DIGITALPRODUK_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'digitalproduk_scripts' );

/**
 * Register Custom Post Type: Digital Product
 */
function digitalproduk_register_cpt() {
    $labels = [
        'name'               => _x( 'Produk Digital', 'post type general name', 'digitalproduk' ),
        'singular_name'      => _x( 'Produk Digital', 'post type singular name', 'digitalproduk' ),
        'menu_name'          => _x( 'Produk Digital', 'admin menu', 'digitalproduk' ),
        'add_new'            => _x( 'Tambah Produk Baru', 'digital_product', 'digitalproduk' ),
        'add_new_item'       => __( 'Tambah Produk Digital Baru', 'digitalproduk' ),
        'edit_item'          => __( 'Edit Produk Digital', 'digitalproduk' ),
        'new_item'           => __( 'Produk Digital Baru', 'digitalproduk' ),
        'all_items'          => __( 'Semua Produk Digital', 'digitalproduk' ),
        'view_item'          => __( 'Lihat Produk Digital', 'digitalproduk' ),
        'search_items'       => __( 'Cari Produk Digital', 'digitalproduk' ),
        'not_found'          => __( 'Tidak ada produk ditemukan', 'digitalproduk' ),
        'not_found_in_trash' => __( 'Tidak ada produk di tong sampah', 'digitalproduk' ),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => [ 'slug' => 'produk' ],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-cart',
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'show_in_rest'       => true,
    ];

    register_post_type( 'digital_product', $args );

    // Category Taxonomy
    $tax_labels = [
        'name'              => _x( 'Kategori Produk', 'taxonomy general name', 'digitalproduk' ),
        'singular_name'     => _x( 'Kategori Produk', 'taxonomy singular name', 'digitalproduk' ),
        'search_items'      => __( 'Cari Kategori', 'digitalproduk' ),
        'all_items'         => __( 'Semua Kategori', 'digitalproduk' ),
        'edit_item'         => __( 'Edit Kategori', 'digitalproduk' ),
        'update_item'       => __( 'Update Kategori', 'digitalproduk' ),
        'add_new_item'      => __( 'Tambah Kategori Baru', 'digitalproduk' ),
        'new_item_name'     => __( 'Nama Kategori Baru', 'digitalproduk' ),
        'menu_name'         => __( 'Kategori', 'digitalproduk' ),
    ];

    register_taxonomy( 'product_category', [ 'digital_product' ], [
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => [ 'slug' => 'kategori-produk' ],
        'show_in_rest'      => true,
    ]);
}
add_action( 'init', 'digitalproduk_register_cpt' );

/**
 * Format IDR Currency Helper
 */
function digitalproduk_price( $amount ) {
    return 'Rp ' . number_format( (float) $amount, 0, ',', '.' );
}

/**
 * Retrieve all preview slides/images for a product
 */
function digitalproduk_get_product_slides( $product_id ) {
    $slides = [];
    $slug = get_post_field( 'post_name', $product_id );

    // Check if theme SVG mockup slides exist in assets/images/products/{slug}/
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();
    $prod_dir  = $theme_dir . '/assets/images/products/' . $slug;

    if ( is_dir( $prod_dir ) ) {
        $labels = [
            1 => [ 'title' => 'Tampilan Utama & Storefront Mockup', 'tag' => 'Cover' ],
            2 => [ 'title' => 'Dashboard & Realtime Metrics', 'tag' => 'Dashboard' ],
            3 => [ 'title' => 'Arsitektur, Komponen & Struktur File', 'tag' => 'Fitur' ],
            4 => [ 'title' => 'Bonus, Dokumentasi & Panduan', 'tag' => 'Bonus' ],
        ];

        for ( $i = 1; $i <= 4; $i++ ) {
            $file = $prod_dir . '/slide-' . $i . '.svg';
            if ( file_exists( $file ) ) {
                $slides[] = [
                    'url'   => $theme_uri . '/assets/images/products/' . $slug . '/slide-' . $i . '.svg',
                    'title' => $labels[$i]['title'] ?? ( 'Preview ' . $i ),
                    'tag'   => $labels[$i]['tag'] ?? ( 'Slide ' . $i ),
                ];
            }
        }
    }

    // If featured image exists, prepend it
    if ( has_post_thumbnail( $product_id ) ) {
        $thumb_url = get_the_post_thumbnail_url( $product_id, 'large' );
        array_unshift( $slides, [
            'url'   => $thumb_url,
            'title' => get_the_title( $product_id ),
            'tag'   => 'Featured',
        ]);
    }

    // Fallback if no images found
    if ( empty( $slides ) ) {
        $slides[] = [
            'url'   => $theme_uri . '/assets/images/hero-bundle.png',
            'title' => get_the_title( $product_id ),
            'tag'   => 'Mockup',
        ];
    }

    return $slides;
}

/**
 * Get primary cover image URL for a product
 */
function digitalproduk_get_product_cover( $product_id ) {
    if ( has_post_thumbnail( $product_id ) ) {
        return get_the_post_thumbnail_url( $product_id, 'large' );
    }
    $slides = digitalproduk_get_product_slides( $product_id );
    return ! empty( $slides ) ? $slides[0]['url'] : '';
}

/**
 * Friendly Category Meta Helper (icons, descriptions, colors)
 */
function digitalproduk_get_category_meta( $slug ) {
    $meta = [
        'source-code' => [
            'icon'        => '💻',
            'title'       => 'Source Code & Web Apps',
            'desc'        => 'Aplikasi fullstack, starter kit SaaS, dan script siap rilis',
            'badge'       => 'KODE BERSIH',
            'color_class' => 'cat-cyan',
        ],
        'ui-ux-figma' => [
            'icon'        => '🎨',
            'title'       => 'UI/UX & Figma Template',
            'desc'        => 'Design system modular, UI kit dashboard, dan wireframe',
            'badge'       => 'PIXEL PERFECT',
            'color_class' => 'cat-purple',
        ],
        'template-notion' => [
            'icon'        => '📋',
            'title'       => 'Template & Notion OS',
            'desc'        => 'Sistem manajemen freelance, CRM proyek, dan tracker',
            'badge'       => 'ONE-CLICK DUPLICATE',
            'color_class' => 'cat-blue',
        ],
        'e-book' => [
            'icon'        => '📚',
            'title'       => 'E-Book & Panduan Digital',
            'desc'        => 'Playbook bisnis praktis, strategi AI, dan funnel penjualan',
            'badge'       => 'PRAKTIK NYATA',
            'color_class' => 'cat-yellow',
        ],
        'saas-tools' => [
            'icon'        => '⚡',
            'title'       => 'SaaS & Otomasi Tools',
            'desc'        => 'Script automasi, prompt vault, dan bot pendukung bisnis',
            'badge'       => 'HEMAT WAKTU',
            'color_class' => 'cat-teal',
        ],
    ];

    return $meta[$slug] ?? [
        'icon'        => '📦',
        'title'       => 'Produk Digital',
        'desc'        => 'Aset digital berkualitas siap pakai',
        'badge'       => 'TERVERIFIKASI',
        'color_class' => 'cat-pink',
    ];
}
