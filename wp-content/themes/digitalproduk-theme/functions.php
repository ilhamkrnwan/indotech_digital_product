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
    wp_enqueue_style( 'digitalproduk-fonts', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap', [], null );
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
