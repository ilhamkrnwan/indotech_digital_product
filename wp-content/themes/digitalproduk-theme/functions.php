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
    wp_enqueue_style( 'digitalproduk-fonts', 'https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap', [], null );
    wp_enqueue_style( 'digitalproduk-main', get_template_directory_uri() . '/assets/css/main.css', [], time() );
    
    // Lucide Icon Library (CDN)
    wp_enqueue_script( 'lucide-icons', 'https://unpkg.com/lucide@latest/dist/umd/lucide.js', [], '0.344.0', true );
    wp_enqueue_script( 'digitalproduk-main', get_template_directory_uri() . '/assets/js/main.js', [ 'lucide-icons' ], time(), true );
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
 * Lucide Icon Library SVG Helper
 * Renders instant inline SVG with Lucide icon spec (24x24 viewBox, 2px stroke)
 * Zero layout shift, no delay, perfect vector rendering.
 */
function digitalproduk_get_icon( $name, $class = '', $size = 20, $attrs = [] ) {
    $class_attr = $class ? ' class="lucide-icon lucide-' . esc_attr( $name ) . ' ' . esc_attr( $class ) . '"' : ' class="lucide-icon lucide-' . esc_attr( $name ) . '"';
    $size_val   = (int) $size ?: 20;

    $icons = [
        'code-2' => '<path d="m18 16 4-4-4-4"/><path d="m6 8-4 4 4 4"/><path d="m14.5 4-5 16"/>',
        'layout' => '<rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/>',
        'clipboard-list' => '<rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/>',
        'book-open' => '<path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>',
        'cpu' => '<rect width="16" height="16" x="4" y="4" rx="2"/><rect width="6" height="6" x="9" y="9" rx="1"/><path d="M15 2v2"/><path d="M15 20v2"/><path d="M2 15h2"/><path d="M2 9h2"/><path d="M20 15h2"/><path d="M20 9h2"/><path d="M9 2v2"/><path d="M9 20v2"/>',
        'package' => '<path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>',
        'zap' => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
        'search' => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
        'shopping-bag' => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>',
        'shield-check' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/>',
        'refresh-cw' => '<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/>',
        'briefcase' => '<rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
        'download' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/>',
        'message-circle' => '<path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>',
        'star' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
        'check' => '<polyline points="20 6 9 17 4 12"/>',
        'check-circle-2' => '<path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/>',
        'arrow-right' => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
        'arrow-left' => '<path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
        'images' => '<path d="M18 22H4a2 2 0 0 1-2-2V6"/><rect width="16" height="16" x="6" y="2" rx="2"/><circle cx="12" cy="8" r="2"/><path d="m22 14-4-4-7 7"/>',
        'layers' => '<path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"/><path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"/><path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"/>',
        'sparkles' => '<path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/><path d="M5 3v4"/><path d="M19 17v4"/><path d="M3 5h4"/><path d="M17 19h4"/>',
        'sliders-horizontal' => '<line x1="21" x2="14" y1="4" y2="4"/><line x1="10" x2="3" y1="4" y2="4"/><line x1="21" x2="12" y1="12" y2="12"/><line x1="8" x2="3" y1="12" y2="12"/><line x1="21" x2="16" y1="20" y2="20"/><line x1="12" x2="3" y1="20" y2="20"/><line x1="14" x2="14" y1="2" y2="6"/><line x1="8" x2="8" y1="10" y2="14"/><line x1="16" x2="16" y1="18" y2="22"/>',
        'help-circle' => '<circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>',
        'credit-card' => '<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>',
        'file-text' => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
        'clock' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'user' => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'tag' => '<path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/>',
        'target' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
        'bot' => '<path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/>',
        'calendar' => '<rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/>',
        'smartphone' => '<rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><line x1="12" x2="12.01" y1="18" y2="18"/>',
        'settings' => '<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>',
        'external-link' => '<path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>',
        'x' => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
        'lock' => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        'gift' => '<rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13"/><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>',
        'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'filter' => '<polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>',
        'alert-circle' => '<circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>',
    ];

    $inner = $icons[$name] ?? $icons['package'];
    return sprintf(
        '<svg%s width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%s</svg>',
        $class_attr,
        $size_val,
        $size_val,
        $inner
    );
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
 * Friendly Category Meta Helper (icons using Lucide name, descriptions, colors)
 */
function digitalproduk_get_category_meta( $slug ) {
    $meta = [
        'source-code' => [
            'icon'        => 'code-2',
            'title'       => 'Source Code & Web Apps',
            'desc'        => 'Aplikasi fullstack, starter kit SaaS, dan script siap rilis',
            'badge'       => 'KODE BERSIH',
            'color_class' => 'cat-cyan',
        ],
        'ui-ux-figma' => [
            'icon'        => 'layout',
            'title'       => 'UI/UX & Figma Template',
            'desc'        => 'Design system modular, UI kit dashboard, dan wireframe',
            'badge'       => 'PIXEL PERFECT',
            'color_class' => 'cat-purple',
        ],
        'template-notion' => [
            'icon'        => 'clipboard-list',
            'title'       => 'Template & Notion OS',
            'desc'        => 'Sistem manajemen freelance, CRM proyek, dan tracker terpadu',
            'badge'       => 'ONE-CLICK SETUP',
            'color_class' => 'cat-blue',
        ],
        'e-book' => [
            'icon'        => 'book-open',
            'title'       => 'E-Book & Panduan Digital',
            'desc'        => 'Playbook bisnis praktis, strategi AI, dan funnel penjualan',
            'badge'       => 'STRATEGI PRAKTIS',
            'color_class' => 'cat-yellow',
        ],
        'saas-tools' => [
            'icon'        => 'cpu',
            'title'       => 'SaaS & Otomasi Tools',
            'desc'        => 'Script automasi, prompt vault, dan bot pendukung bisnis',
            'badge'       => 'HEMAT WAKTU',
            'color_class' => 'cat-teal',
        ],
    ];

    return $meta[$slug] ?? [
        'icon'        => 'package',
        'title'       => 'Produk Digital',
        'desc'        => 'Aset digital berkualitas siap pakai',
        'badge'       => 'TERVERIFIKASI',
        'color_class' => 'cat-pink',
    ];
}

/**
 * Helper: Convert any Google Drive view/share link into an instant direct download URL
 */
function digitalproduk_format_download_url( $raw_url ) {
    $raw_url = trim( (string) $raw_url );
    if ( empty( $raw_url ) ) {
        return '';
    }

    // Cek jika Google Drive URL
    if ( preg_match( '/drive\.google\.com\/(?:file\/d\/|open\?id=|uc\?id=)([a-zA-Z0-9_-]+)/', $raw_url, $matches ) ) {
        $file_id = $matches[1];
        // Format direct download Google Drive
        return 'https://drive.google.com/uc?export=download&id=' . $file_id;
    }

    return $raw_url;
}

/**
 * Add Meta Box for Digital Product File Delivery Settings
 */
function digitalproduk_add_delivery_meta_box() {
    add_meta_box(
        'digitalproduk_delivery_box',
        '📦 Pengiriman File Digital (Akses Download)',
        'digitalproduk_render_delivery_meta_box',
        'digitalproduk',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'digitalproduk_add_delivery_meta_box' );

function digitalproduk_render_delivery_meta_box( $post ) {
    wp_nonce_field( 'digitalproduk_delivery_nonce_action', 'digitalproduk_delivery_nonce' );
    $download_url = get_post_meta( $post->ID, '_download_url', true );
    $file_format  = get_post_meta( $post->ID, '_file_format', true ) ?: 'ZIP Archive / Source Code';
    $access_note  = get_post_meta( $post->ID, '_access_note', true );
    ?>
    <div style="padding: 12px 4px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <table class="form-table" style="margin-top: 0;">
            <tr>
                <th scope="row" style="width: 220px; font-weight: 700;">
                    <label for="digitalproduk_download_url">Link File Download (.zip / Google Drive)</label>
                </th>
                <td>
                    <input type="text" name="_download_url" id="digitalproduk_download_url" value="<?php echo esc_attr( $download_url ); ?>" class="large-text" placeholder="https://drive.google.com/file/d/... atau https://domain.com/file.zip" style="padding: 8px 12px; font-size: 14px;" />
                    <p class="description" style="margin-top: 6px; color: #475569;">
                        💡 <strong>Trik Google Drive:</strong> Cukup paste link share Google Drive biasa (pastikan hak akses <em>"Siapa saja yang memiliki link"</em>). Sistem akan otomatis mengonversinya menjadi <strong>Direct Download Link</strong> agar saat diklik di web pembeli langsung mendownload file tanpa membuka Google Drive!
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row" style="font-weight: 700;">
                    <label for="digitalproduk_file_format">Format / Tipe File</label>
                </th>
                <td>
                    <input type="text" name="_file_format" id="digitalproduk_file_format" value="<?php echo esc_attr( $file_format ); ?>" class="regular-text" placeholder="ZIP Archive / NPM Module / Notion Link" style="padding: 8px 12px;" />
                    <p class="description">Contoh: <code>ZIP (Source Code & Assets)</code>, <code>Notion Template Link</code>, <code>PDF & Video HD</code></p>
                </td>
            </tr>
            <tr>
                <th scope="row" style="font-weight: 700;">
                    <label for="digitalproduk_access_note">Catatan Tambahan untuk Pembeli (Opsional)</label>
                </th>
                <td>
                    <textarea name="_access_note" id="digitalproduk_access_note" rows="3" class="large-text" placeholder="Contoh: Password ekstrak file zip: indotechnology2026 atau ekstrak menggunakan WinRAR / 7-Zip terbaru." style="padding: 8px 12px;"><?php echo esc_textarea( $access_note ); ?></textarea>
                    <p class="description">Catatan ini akan tampil di Halaman Sukses dan di email pembeli.</p>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

function digitalproduk_save_delivery_meta_box( $post_id ) {
    if ( ! isset( $_POST['digitalproduk_delivery_nonce'] ) || ! wp_verify_nonce( $_POST['digitalproduk_delivery_nonce'], 'digitalproduk_delivery_nonce_action' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['_download_url'] ) ) {
        update_post_meta( $post_id, '_download_url', esc_url_raw( trim( $_POST['_download_url'] ) ) );
    }
    if ( isset( $_POST['_file_format'] ) ) {
        update_post_meta( $post_id, '_file_format', sanitize_text_field( $_POST['_file_format'] ) );
    }
    if ( isset( $_POST['_access_note'] ) ) {
        update_post_meta( $post_id, '_access_note', sanitize_textarea_field( $_POST['_access_note'] ) );
    }
}
add_action( 'save_post_digital_product', 'digitalproduk_save_delivery_meta_box' );

