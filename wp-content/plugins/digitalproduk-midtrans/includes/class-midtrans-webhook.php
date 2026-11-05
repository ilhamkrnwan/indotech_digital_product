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

        if ( empty( $body ) ) {
            return new WP_REST_Response( [ 'status' => 'error', 'message' => 'Empty payload' ], 400 );
        }

        $order_id = $body['order_id'] ?? '';
        $status_code = $body['status_code'] ?? '';
        $gross_amount = $body['gross_amount'] ?? '';
        $signature_key = $body['signature_key'] ?? '';
        $transaction_status = $body['transaction_status'] ?? '';
        $fraud_status = $body['fraud_status'] ?? '';

        // 1. Validasi Signature
        $is_valid = DPM_Midtrans_Client::verify_signature( $order_id, $status_code, $gross_amount, $signature_key );
        if ( ! $is_valid ) {
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
            return new WP_REST_Response( [ 'status' => 'error', 'message' => 'Order not found' ], 404 );
        }

        $order_post = $orders[0];
        $order_post_id = $order_post->ID;

        // 3. Update Status Pembayaran
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

        update_post_meta( $order_post_id, '_payment_status', $new_status );
        update_post_meta( $order_post_id, '_midtrans_response', wp_json_encode( $body ) );

        // Jika status sukses, bisa kirim link download via email atau WhatsApp
        if ( $new_status === 'success' ) {
            update_post_meta( $order_post_id, '_paid_at', current_time( 'mysql' ) );
        }

        return new WP_REST_Response( [ 'status' => 'ok', 'order_status' => $new_status ], 200 );
    }
}
