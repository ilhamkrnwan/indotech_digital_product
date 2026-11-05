<?php
/**
 * Plugin Name: Digital Produk Core Security Hardening
 * Description: Modul keamanan esensial WordPress (Must-Use Plugin). Mencegah enumerasi user, menonaktifkan XML-RPC, membatasi REST API users, menyamarkan pesan error login, dan menginjeksi header keamanan HTTP.
 * Version: 1.0.0
 * Author: Antigravity Security
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================
// 1. NONAKTIFKAN XML-RPC & PINGBACK (Cegah Serangan Brute Force & DDoS)
// ============================================================
add_filter( 'xmlrpc_enabled', '__return_false' );

add_filter( 'wp_headers', function( $headers ) {
    if ( isset( $headers['X-Pingback'] ) ) {
        unset( $headers['X-Pingback'] );
    }
    return $headers;
});

add_filter( 'xmlrpc_methods', function( $methods ) {
    return [];
});

// ============================================================
// 2. SAMARKAN INFORMASI & FOOTPRINT WORDPRESS
// ============================================================
// Hapus meta generator versi WordPress dari <head>
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

// Hapus endpoint discovery usang
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// Hapus query string ?ver= dari asset CSS & JS publik
function dp_security_remove_asset_version( $src ) {
    if ( strpos( $src, 'ver=' ) !== false ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
add_filter( 'style_loader_src', 'dp_security_remove_asset_version', 9999 );
add_filter( 'script_loader_src', 'dp_security_remove_asset_version', 9999 );

// ============================================================
// 3. BLOKIR USER / AUTHOR ENUMERATION (Cegah Pengintaian Username)
// ============================================================
// Blokir author query parameter (/?author=1) pada frontend
add_action( 'template_redirect', function() {
    if ( ! is_admin() && isset( $_GET['author'] ) ) {
        wp_safe_redirect( home_url(), 301 );
        exit;
    }
});

// Batasi REST API endpoint /wp/v2/users hanya untuk user yang terautentikasi
add_filter( 'rest_endpoints', function( $endpoints ) {
    if ( ! is_user_logged_in() ) {
        if ( isset( $endpoints['/wp/v2/users'] ) ) {
            unset( $endpoints['/wp/v2/users'] );
        }
        if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
            unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
        }
    }
    return $endpoints;
});

// ============================================================
// 4. SAMARKAN PESAN KESALAHAN LOGIN (Cegah Username Harvesting)
// ============================================================
add_filter( 'login_errors', function() {
    return '<strong>Pemberitahuan Keamanan:</strong> Kredensial login (username/email/password) tidak cocok.';
});

// ============================================================
// 5. INJEKSI HTTP SECURITY HEADERS (Defense-in-depth)
// ============================================================
add_action( 'send_headers', function() {
    if ( ! headers_sent() ) {
        header( 'X-Content-Type-Options: nosniff' );
        header( 'X-Frame-Options: SAMEORIGIN' );
        header( 'X-XSS-Protection: 1; mode=block' );
        header( 'Referrer-Policy: strict-origin-when-cross-origin' );
        header( 'Permissions-Policy: camera=(), microphone=(), geolocation=()' );
    }
});

// ============================================================
// 6. MATIKAN APPLICATION PASSWORDS JIKA TIDAK DIGUNAKAN
// ============================================================
add_filter( 'wp_is_application_passwords_available', '__return_false' );

