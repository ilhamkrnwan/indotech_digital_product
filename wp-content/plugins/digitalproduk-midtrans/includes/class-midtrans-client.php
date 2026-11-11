<?php
/**
 * Midtrans HTTP Client Wrapper
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DPM_Midtrans_Client {

    public static function get_server_key() {
        if ( defined( 'MIDTRANS_SERVER_KEY' ) && ! empty( MIDTRANS_SERVER_KEY ) ) {
            return MIDTRANS_SERVER_KEY;
        }
        return get_option( 'dpm_server_key', '' );
    }

    public static function get_client_key() {
        if ( defined( 'MIDTRANS_CLIENT_KEY' ) && ! empty( MIDTRANS_CLIENT_KEY ) ) {
            return MIDTRANS_CLIENT_KEY;
        }
        return get_option( 'dpm_client_key', '' );
    }

    public static function is_production() {
        if ( defined( 'MIDTRANS_IS_PRODUCTION' ) ) {
            return (bool) MIDTRANS_IS_PRODUCTION;
        }

        // Auto-deteksi otomatis berdasarkan prefix standar Midtrans:
        // 'Mid-server-...' = Production
        // 'SB-Mid-server-...' = Sandbox
        $server_key = self::get_server_key();
        if ( ! empty( $server_key ) ) {
            if ( strpos( $server_key, 'SB-Mid-' ) === 0 ) {
                return false;
            } elseif ( strpos( $server_key, 'Mid-' ) === 0 ) {
                return true;
            }
        }

        return get_option( 'dpm_environment', 'sandbox' ) === 'production';
    }

    public static function get_snap_url() {
        return self::is_production() 
            ? 'https://app.midtrans.com/snap/v1/transactions' 
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    public static function get_api_base_url() {
        return self::is_production()
            ? 'https://api.midtrans.com/v2'
            : 'https://api.sandbox.midtrans.com/v2';
    }

    public static function get_snap_js_url() {
        return self::is_production()
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }

    /**
     * Server-to-Server GET Transaction Status API
     * Memverifikasi status riil pembayaran langsung ke server Midtrans
     */
    public static function get_transaction_status( $order_id ) {
        $server_key = self::get_server_key();
        if ( empty( $server_key ) ) {
            return new WP_Error( 'missing_key', 'Server Key belum dikonfigurasi.' );
        }

        $endpoint = self::get_api_base_url() . '/' . rawurlencode( $order_id ) . '/status';
        $auth = base64_encode( $server_key . ':' );

        $response = wp_remote_get( $endpoint, [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ' . $auth,
            ],
            'timeout' => 20,
        ]);

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $code = (int) wp_remote_retrieve_response_code( $response );
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        if ( $code === 200 && is_array( $data ) ) {
            return $data;
        }

        $err_msg = $data['status_message'] ?? ( 'Gagal memverifikasi status dari Midtrans (HTTP ' . $code . ').' );
        return new WP_Error( 'midtrans_status_error', $err_msg, $data );
    }

    /**
     * Request Snap Token dari Midtrans API
     */
    public static function create_snap_transaction( $params ) {
        $server_key = self::get_server_key();
        if ( empty( $server_key ) ) {
            return new WP_Error( 'missing_key', 'Kunci sistem pembayaran belum dikonfigurasi di dashboard admin.' );
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

        $code = (int) wp_remote_retrieve_response_code( $response );
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        if ( ! empty( $data['token'] ) ) {
            return $data;
        }

        if ( $code === 401 ) {
            $msg = 'Autentikasi pembayaran gagal (401): Kunci API tidak cocok dengan lingkungan Sandbox / Production.';
        } elseif ( ! empty( $data['error_messages'] ) && is_array( $data['error_messages'] ) ) {
            $msg = implode( ', ', $data['error_messages'] );
        } elseif ( ! empty( $data['error'] ) ) {
            $msg = 'Kendala pembayaran: ' . ( is_string( $data['error'] ) ? $data['error'] : wp_json_encode( $data['error'] ) );
        } else {
            $msg = 'Gagal menghubungi server pembayaran (HTTP ' . $code . ').';
        }

        return new WP_Error( 'midtrans_error', $msg, $data );
    }

    /**
     * Verifikasi Signature SHA512 dari Midtrans Webhook
     */
    public static function verify_signature( $order_id, $status_code, $gross_amount, $signature_key ) {
        $server_key = self::get_server_key();
        if ( empty( $server_key ) || empty( $signature_key ) ) {
            return false;
        }

        $input = $order_id . $status_code . $gross_amount . $server_key;
        $expected_signature = openssl_digest( $input, 'sha512' );

        return hash_equals( $expected_signature, $signature_key );
    }
}
