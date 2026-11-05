<?php
/**
 * Plugin Name: Digital Produk Midtrans Gateway
 * Plugin URI: https://digitalproduk.test/
 * Description: Integrasi Midtrans Snap & Webhook Notifikasi untuk pembayaran instan produk digital.
 * Version: 1.0.0
 * Author: Antigravity
 * Author URI: https://digitalproduk.test/
 * Text Domain: digitalproduk-midtrans
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'DPM_VERSION', '1.0.0' );
define( 'DPM_PATH', plugin_dir_path( __FILE__ ) );
define( 'DPM_URL', plugin_dir_url( __FILE__ ) );

require_once DPM_PATH . 'includes/class-midtrans-client.php';
require_once DPM_PATH . 'includes/class-midtrans-orders.php';
require_once DPM_PATH . 'includes/class-midtrans-admin.php';
require_once DPM_PATH . 'includes/class-midtrans-webhook.php';

// Inisialisasi modul
add_action( 'plugins_loaded', function() {
    new DPM_Midtrans_Orders();
    new DPM_Midtrans_Admin();
    new DPM_Midtrans_Webhook();
});
