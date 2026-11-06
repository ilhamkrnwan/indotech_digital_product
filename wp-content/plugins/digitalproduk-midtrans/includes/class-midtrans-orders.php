<?php
/**
 * Midtrans Order Management & Checkout AJAX
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DPM_Midtrans_Orders {

    public function __construct() {
        add_action( 'init', [ $this, 'register_order_cpt' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_snap_scripts' ], 20 );

        // AJAX Checkout Handlers
        add_action( 'wp_ajax_dpm_create_order', [ $this, 'ajax_create_order' ] );
        add_action( 'wp_ajax_nopriv_dpm_create_order', [ $this, 'ajax_create_order' ] );
        add_action( 'wp_ajax_dpm_confirm_payment', [ $this, 'ajax_confirm_payment' ] );
        add_action( 'wp_ajax_nopriv_dpm_confirm_payment', [ $this, 'ajax_confirm_payment' ] );
    }

    public function register_order_cpt() {
        register_post_type( 'product_order', [
            'labels' => [
                'name'               => 'Pesanan (Orders)',
                'singular_name'      => 'Pesanan',
                'menu_name'          => 'Pesanan',
                'all_items'          => 'Semua Pesanan',
                'view_item'          => 'Lihat Pesanan',
            ],
            'public'          => false,
            'show_ui'         => true,
            'show_in_menu'    => 'edit.php?post_type=digital_product',
            'capability_type' => 'post',
            'capabilities'    => [ 'create_posts' => false ], // Hanya dibuat sistem
            'map_meta_cap'    => true,
            'supports'        => [ 'title', 'custom-fields' ],
            'menu_icon'       => 'dashicons-clipboard',
        ]);
    }

    public function enqueue_snap_scripts() {
        $client_key = DPM_Midtrans_Client::get_client_key();
        $snap_js = DPM_Midtrans_Client::get_snap_js_url();

        if ( ! empty( $client_key ) ) {
            wp_enqueue_script( 'midtrans-snap', $snap_js, [], null, true );
            wp_script_add_data( 'midtrans-snap', 'data-client-key', $client_key );
        }

        wp_localize_script( 'digitalproduk-main', 'dpm_vars', [
            'ajax_url'     => admin_url( 'admin-ajax.php' ),
            'nonce'        => wp_create_nonce( 'dpm_checkout_nonce' ),
            'has_midtrans' => ! empty( $client_key ),
        ]);
    }

    /**
     * AJAX endpoint: Buat order & dapatkan Snap Token
     */
    public function ajax_create_order() {
        check_ajax_referer( 'dpm_checkout_nonce', 'nonce' );

        // Proteksi Rate Limiting per IP (maksimum 10 request checkout per 5 menit)
        $ip_address = sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1' );
        $transient_key = 'dpm_order_rate_' . md5( $ip_address );
        $attempts = (int) get_transient( $transient_key );
        if ( $attempts >= 10 ) {
            wp_send_json_error( [ 'message' => 'Terlalu banyak permintaan pemesanan. Silakan tunggu 5 menit sebelum mencoba kembali.' ] );
        }
        set_transient( $transient_key, $attempts + 1, 5 * MINUTE_IN_SECONDS );

        $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
        $customer_name = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
        $customer_email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
        $raw_phone = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
        $customer_phone = preg_replace( '/[^0-9+\-\s]/', '', $raw_phone );

        if ( ! $product_id || empty( $customer_name ) || empty( $customer_email ) ) {
            wp_send_json_error( [ 'message' => 'Lengkapi nama dan email Anda.' ] );
        }

        if ( ! is_email( $customer_email ) ) {
            wp_send_json_error( [ 'message' => 'Format alamat email tidak valid.' ] );
        }

        $product = get_post( $product_id );
        if ( ! $product || $product->post_type !== 'digital_product' ) {
            wp_send_json_error( [ 'message' => 'Produk tidak ditemukan.' ] );
        }

        $sale_price = get_post_meta( $product_id, '_sale_price', true );
        $price = $sale_price ?: get_post_meta( $product_id, '_price', true );
        $price = (int) $price;

        if ( $price <= 0 ) {
            wp_send_json_error( [ 'message' => 'Harga produk tidak valid.' ] );
        }

        // Format Order ID: DP-UNIXTIME-RAND
        $order_id = 'DP-' . time() . '-' . wp_rand( 100, 999 );

        // 1. Simpan Order ke CPT
        $order_post_id = wp_insert_post([
            'post_type'   => 'product_order',
            'post_title'  => $order_id . ' - ' . $customer_name,
            'post_status' => 'publish',
        ]);

        if ( is_wp_error( $order_post_id ) ) {
            wp_send_json_error( [ 'message' => 'Gagal membuat pesanan di database.' ] );
        }

        update_post_meta( $order_post_id, '_order_id', $order_id );
        update_post_meta( $order_post_id, '_product_id', $product_id );
        update_post_meta( $order_post_id, '_product_title', $product->post_title );
        update_post_meta( $order_post_id, '_amount', $price );
        update_post_meta( $order_post_id, '_customer_name', $customer_name );
        update_post_meta( $order_post_id, '_customer_email', $customer_email );
        update_post_meta( $order_post_id, '_customer_phone', $customer_phone );
        update_post_meta( $order_post_id, '_payment_status', 'pending' );

        // 2. Siapkan Payload Snap Midtrans
        $params = [
            'transaction_details' => [
                'order_id'     => $order_id,
                'gross_amount' => $price,
            ],
            'item_details' => [
                [
                    'id'       => (string) $product_id,
                    'price'    => $price,
                    'quantity' => 1,
                    'name'     => mb_strimwidth( $product->post_title, 0, 45, '...' ),
                ]
            ],
            'customer_details' => [
                'first_name' => $customer_name,
                'email'      => $customer_email,
                'phone'      => $customer_phone,
            ],
        ];

        // 3. Request Snap Token
        $snap_result = DPM_Midtrans_Client::create_snap_transaction( $params );

        if ( is_wp_error( $snap_result ) ) {
            update_post_meta( $order_post_id, '_payment_status', 'error' );
            update_post_meta( $order_post_id, '_error_log', $snap_result->get_error_message() );
            wp_send_json_error( [ 'message' => $snap_result->get_error_message() ] );
        }

        $snap_token = $snap_result['token'];
        update_post_meta( $order_post_id, '_snap_token', $snap_token );

        wp_send_json_success([
            'order_id'   => $order_id,
            'snap_token' => $snap_token,
            'redirect'   => $snap_result['redirect_url'] ?? '',
        ]);
    }

    /**
     * AJAX endpoint: Konfirmasi pembayaran dari Snap onSuccess (terutama untuk localhost / direct redirect)
     */
    public function ajax_confirm_payment() {
        check_ajax_referer( 'dpm_checkout_nonce', 'nonce' );

        $order_id = isset( $_POST['order_id'] ) ? sanitize_text_field( wp_unslash( $_POST['order_id'] ) ) : '';
        if ( empty( $order_id ) ) {
            wp_send_json_error( [ 'message' => 'Order ID tidak valid.' ] );
        }

        $orders = get_posts([
            'post_type'      => 'product_order',
            'meta_key'       => '_order_id',
            'meta_value'     => $order_id,
            'posts_per_page' => 1,
            'post_status'    => 'any',
        ]);

        if ( empty( $orders ) ) {
            wp_send_json_error( [ 'message' => 'Pesanan tidak ditemukan.' ] );
        }

        $order_post = $orders[0];
        $order_post_id = $order_post->ID;

        // Tandai sukses
        update_post_meta( $order_post_id, '_payment_status', 'success' );
        if ( ! get_post_meta( $order_post_id, '_paid_at', true ) ) {
            update_post_meta( $order_post_id, '_paid_at', current_time( 'mysql' ) );
        }

        wp_send_json_success([
            'message'      => 'Pembayaran berhasil dikonfirmasi.',
            'redirect_url' => home_url( '/thank-you/?order_id=' . rawurlencode( $order_id ) ),
        ]);
    }
}
