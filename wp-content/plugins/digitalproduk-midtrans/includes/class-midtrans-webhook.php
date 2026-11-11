<?php
/**
 * Midtrans Webhook / HTTP Notification Handler
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DPM_Midtrans_Webhook {

    public function __construct() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public function register_routes() {
        register_rest_route( 'digitalproduk/v1', '/midtrans-notification', [
            'methods'             => 'POST',
            'callback'            => [ $this, 'handle_notification' ],
            'permission_callback' => '__return_true',
        ]);
    }

    public function handle_notification( WP_REST_Request $request ) {
        $body = $request->get_json_params();

        // Logging untuk audit & troubleshooting webhook
        $log_file = WP_CONTENT_DIR . '/midtrans_webhook.log';
        $log_entry = sprintf(
            "[%s] Midtrans Notification Received: %s\n",
            current_time( 'mysql' ),
            wp_json_encode( $body )
        );
        @file_put_contents( $log_file, $log_entry, FILE_APPEND );

        if ( empty( $body ) ) {
            return new WP_REST_Response( [ 'status' => 'error', 'message' => 'Empty payload' ], 400 );
        }

        $order_id = $body['order_id'] ?? '';
        $status_code = $body['status_code'] ?? '';
        $gross_amount = $body['gross_amount'] ?? '';
        $signature_key = $body['signature_key'] ?? '';
        $transaction_status = $body['transaction_status'] ?? '';
        $fraud_status = $body['fraud_status'] ?? '';

        // Deteksi Test Notification Ping dari Dashboard Midtrans ("Test notification URL")
        // Midtrans mengirimkan dummy order_id atau payload test untuk memeriksa endpoint
        $is_test_payload = (
            ( ! empty( $order_id ) && stripos( $order_id, 'test' ) !== false ) ||
            ( isset( $body['payment_type'] ) && stripos( $body['payment_type'], 'test' ) !== false ) ||
            empty( $signature_key )
        );

        if ( $is_test_payload ) {
            return new WP_REST_Response( [
                'status'  => 'ok',
                'message' => 'Test notification acknowledged successfully',
            ], 200 );
        }

        // 1. Validasi Signature
        $is_valid = DPM_Midtrans_Client::verify_signature( $order_id, $status_code, $gross_amount, $signature_key );
        if ( ! $is_valid ) {
            @file_put_contents( $log_file, sprintf( "[%s] Signature verification failed for order %s\n", current_time( 'mysql' ), $order_id ), FILE_APPEND );
            return new WP_REST_Response( [ 'status' => 'error', 'message' => 'Invalid signature' ], 403 );
        }

        // 2. Cari Order di WordPress
        $orders = get_posts([
            'post_type'      => 'product_order',
            'meta_key'       => '_order_id',
            'meta_value'     => $order_id,
            'posts_per_page' => 1,
            'post_status'    => 'any',
        ]);

        if ( empty( $orders ) ) {
            // Berikan status 200 agar Midtrans menganggap notifikasi diterima dan tidak melakukan retry loop tak berujung
            return new WP_REST_Response( [ 'status' => 'ok', 'message' => 'Order not found in database (acknowledged)' ], 200 );
        }

        $order_post = $orders[0];
        $order_post_id = $order_post->ID;

        // 3. Validasi Nominal Pembayaran (Mencegah Manipulasi/Tampering Harga)
        $stored_amount = (int) get_post_meta( $order_post_id, '_amount', true );
        $received_amount = (int) round( (float) $gross_amount );

        if ( $stored_amount <= 0 || $received_amount !== $stored_amount ) {
            return new WP_REST_Response( [ 'status' => 'error', 'message' => 'Gross amount mismatch' ], 400 );
        }

        // 4. Update Status Pembayaran
        $new_status = 'pending';

        if ( $transaction_status === 'capture' ) {
            $new_status = ( $fraud_status === 'accept' ) ? 'success' : 'challenge';
        } elseif ( $transaction_status === 'settlement' ) {
            $new_status = 'success';
        } elseif ( in_array( $transaction_status, [ 'cancel', 'deny', 'expire' ], true ) ) {
            $new_status = 'failed';
        } elseif ( $transaction_status === 'pending' ) {
            $new_status = 'pending';
        }

        // Cegah downgrade status jika order sudah berstatus success
        $current_status = get_post_meta( $order_post_id, '_payment_status', true );
        if ( $current_status === 'success' && $new_status !== 'success' ) {
            return new WP_REST_Response( [ 'status' => 'ok', 'message' => 'Order already settled' ], 200 );
        }

        update_post_meta( $order_post_id, '_payment_status', $new_status );
        update_post_meta( $order_post_id, '_midtrans_response', wp_json_encode( $body ) );

        // Jika status sukses
        if ( $new_status === 'success' ) {
            update_post_meta( $order_post_id, '_paid_at', current_time( 'mysql' ) );
        }

        return new WP_REST_Response( [ 'status' => 'ok', 'order_status' => $new_status ], 200 );
    }
}
