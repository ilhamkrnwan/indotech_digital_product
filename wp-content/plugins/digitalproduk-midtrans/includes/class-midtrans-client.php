<?php
/**
 * Midtrans HTTP Client Wrapper
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DPM_Midtrans_Client {

    public static function get_server_key() {
        return get_option( 'dpm_server_key', '' );
    }

    public static function get_client_key() {
        return get_option( 'dpm_client_key', '' );
    }

    public static function is_production() {
        return get_option( 'dpm_environment', 'sandbox' ) === 'production';
    }

    public static function get_snap_url() {
        return self::is_production() 
            ? 'https://app.midtrans.com/snap/v1/transactions' 
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    public static function get_snap_js_url() {
        return self::is_production()
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }

    /**
     * Request Snap Token dari Midtrans API
     */
    public static function create_snap_transaction( $params ) {
        $server_key = self::get_server_key();
        if ( empty( $server_key ) ) {
            return new WP_Error( 'missing_key', 'Server Key Midtrans belum dikonfigurasi di dashboard admin.' );
        }

        $auth = base64_encode( $server_key . ':' );
        $endpoint = self::get_snap_url();

        $response = wp_remote_post( $endpoint, [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ' . $auth,
            ],
            'body'    => wp_json_encode( $params ),
            'timeout' => 30,
        ]);

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        if ( ! empty( $data['token'] ) ) {
            return $data;
        }

        $msg = ! empty( $data['error_messages'] ) ? implode( ', ', $data['error_messages'] ) : 'Gagal menghubungi Midtrans Snap API.';
        return new WP_Error( 'midtrans_error', $msg, $data );
    }

    /**
     * Verifikasi Signature SHA512 dari Midtrans Webhook
     */
    public static function verify_signature( $order_id, $status_code, $gross_amount, $signature_key ) {
        $server_key = self::get_server_key();
        $input = $order_id . $status_code . $gross_amount . $server_key;
        $expected_signature = openssl_digest( $input, 'sha512' );

        return hash_equals( $expected_signature, $signature_key );
    }
}
