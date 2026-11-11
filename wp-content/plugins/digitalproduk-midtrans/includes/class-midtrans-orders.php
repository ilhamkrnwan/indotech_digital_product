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

        // Secure Download Handler
        add_action( 'template_redirect', [ $this, 'handle_secure_download' ] );
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

        // Format Order ID: Kriptografis acak tinggi (DP-YYYYMMDD-XXXXXXXX)
        $order_id = 'DP-' . gmdate( 'Ymd' ) . '-' . strtoupper( wp_generate_password( 8, false, false ) );
        // Token Akses Rahasia Unik (High-Entropy Token) untuk melindungi akses download
        $download_token = wp_generate_password( 32, false, false );

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
        update_post_meta( $order_post_id, '_download_token', $download_token );
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
            'order_id'       => $order_id,
            'download_token' => $download_token,
            'snap_token'     => $snap_token,
            'redirect'       => $snap_result['redirect_url'] ?? '',
        ]);
    }

    /**
     * AJAX endpoint: Konfirmasi pembayaran dengan VERIFIKASI SERVER-TO-SERVER KE MIDTRANS
     * (Menghilangkan celah client-side bypass!)
     */
    public function ajax_confirm_payment() {
        check_ajax_referer( 'dpm_checkout_nonce', 'nonce' );

        $order_id = isset( $_POST['order_id'] ) ? sanitize_text_field( wp_unslash( $_POST['order_id'] ) ) : '';
        $token = isset( $_POST['token'] ) ? sanitize_text_field( wp_unslash( $_POST['token'] ) ) : '';

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
        $saved_token = get_post_meta( $order_post_id, '_download_token', true );

        // 1. Validasi Token Akses (hanya pembuat pesanan yang berhak memicu verifikasi)
        if ( ! empty( $saved_token ) && ! empty( $token ) && ! hash_equals( $saved_token, $token ) ) {
            wp_send_json_error( [ 'message' => 'Akses otorisasi tidak valid.' ] );
        }

        // 2. Jika sudah sukses sebelumnya (misal sudah diupdate webhook), langsung arahkan
        $current_status = get_post_meta( $order_post_id, '_payment_status', true );
        if ( $current_status === 'success' ) {
            wp_send_json_success([
                'message'      => 'Pembayaran telah terverifikasi.',
                'redirect_url' => home_url( '/thank-you/?order_id=' . rawurlencode( $order_id ) . '&token=' . rawurlencode( $saved_token ) ),
            ]);
        }

        // 3. VERIFIKASI LANGSUNG KE API SERVER MIDTRANS (Server-to-Server Verification)
        $status_data = DPM_Midtrans_Client::get_transaction_status( $order_id );

        if ( is_wp_error( $status_data ) ) {
            wp_send_json_error( [ 'message' => 'Menunggu konfirmasi gateway: ' . $status_data->get_error_message() ] );
        }

        $transaction_status = $status_data['transaction_status'] ?? '';
        $fraud_status = $status_data['fraud_status'] ?? '';
        $gross_amount = (int) round( (float) ( $status_data['gross_amount'] ?? 0 ) );
        $stored_amount = (int) get_post_meta( $order_post_id, '_amount', true );

        // 4. Validasi Nominal Rekonsiliasi (Gross Amount Validation)
        if ( $stored_amount <= 0 || $gross_amount !== $stored_amount ) {
            wp_send_json_error( [ 'message' => 'Nominal transaksi tidak cocok dengan database.' ] );
        }

        // 5. Cek apakah benar-benar lunas menurut Midtrans
        $is_settled = ( $transaction_status === 'settlement' ) || ( $transaction_status === 'capture' && $fraud_status === 'accept' );

        if ( $is_settled ) {
            update_post_meta( $order_post_id, '_payment_status', 'success' );
            update_post_meta( $order_post_id, '_midtrans_response', wp_json_encode( $status_data ) );
            if ( ! get_post_meta( $order_post_id, '_paid_at', true ) ) {
                update_post_meta( $order_post_id, '_paid_at', current_time( 'mysql' ) );
            }

            wp_send_json_success([
                'message'      => 'Pembayaran sukses terverifikasi.',
                'redirect_url' => home_url( '/thank-you/?order_id=' . rawurlencode( $order_id ) . '&token=' . rawurlencode( $saved_token ) ),
            ]);
        } elseif ( $transaction_status === 'pending' ) {
            wp_send_json_error( [ 'message' => 'Pembayaran Anda belum selesai di gateway. Silakan selesaikan pembayaran.' ] );
        } else {
            update_post_meta( $order_post_id, '_payment_status', 'failed' );
            wp_send_json_error( [ 'message' => 'Pembayaran tidak berhasil (status: ' . esc_html( $transaction_status ) . ').' ] );
        }
    }

    /**
     * Endpoint Handler Akses Download Aman & Anti-Leak
     * Mengamankan link download langsung (Google Drive/file) dari pembajakan URL
     */
    public function handle_secure_download() {
        if ( ! isset( $_GET['action'] ) || $_GET['action'] !== 'dpm_download' ) {
            return;
        }

        $order_id = isset( $_GET['order_id'] ) ? sanitize_text_field( wp_unslash( $_GET['order_id'] ) ) : '';
        $token = isset( $_GET['token'] ) ? sanitize_text_field( wp_unslash( $_GET['token'] ) ) : '';

        if ( empty( $order_id ) || empty( $token ) ) {
            wp_die( 'Akses Ditolak: Parameter pesanan tidak lengkap.', 'Akses Ditolak', [ 'response' => 403 ] );
        }

        $orders = get_posts([
            'post_type'      => 'product_order',
            'meta_key'       => '_order_id',
            'meta_value'     => $order_id,
            'posts_per_page' => 1,
            'post_status'    => 'any',
        ]);

        if ( empty( $orders ) ) {
            wp_die( 'Pesanan tidak ditemukan.', 'Tidak Ditemukan', [ 'response' => 404 ] );
        }

        $order_post = $orders[0];
        $order_post_id = $order_post->ID;
        $saved_token = get_post_meta( $order_post_id, '_download_token', true );

        // 1. Verifikasi Cryptographic Token
        if ( empty( $saved_token ) || ! hash_equals( $saved_token, $token ) ) {
            wp_die( 'Akses Ditolak: Token autentikasi download tidak valid.', 'Akses Ditolak', [ 'response' => 403 ] );
        }

        // 2. Verifikasi Status Pembayaran Lunas
        $status = get_post_meta( $order_post_id, '_payment_status', true );
        if ( $status !== 'success' ) {
            wp_die( 'Pesanan ini belum menyelesaikan pembayaran resmi.', 'Belum Lunas', [ 'response' => 402 ] );
        }

        // 3. Verifikasi Link Produk
        $product_id = (int) get_post_meta( $order_post_id, '_product_id', true );
        $raw_url = get_post_meta( $product_id, '_download_url', true );

        if ( empty( $raw_url ) ) {
            wp_die( 'File produk digital belum dikonfigurasi oleh admin.', 'File Belum Siap', [ 'response' => 404 ] );
        }

        // 4. Catat Audit Log Download
        $download_count = (int) get_post_meta( $order_post_id, '_download_count', true );
        update_post_meta( $order_post_id, '_download_count', $download_count + 1 );
        update_post_meta( $order_post_id, '_last_download_at', current_time( 'mysql' ) );
        update_post_meta( $order_post_id, '_last_download_ip', sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' ) );

        // 5. Header Proteksi & Redirect Aman ke Resource File
        nocache_headers();
        $target_url = function_exists( 'digitalproduk_format_download_url' )
            ? digitalproduk_format_download_url( $raw_url )
            : $raw_url;

        wp_redirect( $target_url );
        exit;
    }
}
