<?php
/**
 * Midtrans Settings & Admin Page
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class DPM_Midtrans_Admin {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_menu' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
    }

    public function add_menu() {
        add_submenu_page(
            'edit.php?post_type=digital_product',
            'Pengaturan Midtrans',
            'Pengaturan Midtrans',
            'manage_options',
            'midtrans-settings',
            [ $this, 'render_settings_page' ]
        );
    }

    public function register_settings() {
        register_setting( 'dpm_settings_group', 'dpm_environment' );
        register_setting( 'dpm_settings_group', 'dpm_server_key' );
        register_setting( 'dpm_settings_group', 'dpm_client_key' );
        register_setting( 'dpm_settings_group', 'dpm_merchant_id' );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap" style="max-width: 800px;">
            <h1>Pengaturan Midtrans Payment Gateway</h1>
            <p>Masukkan kredensial API Midtrans Anda dari <a href="https://dashboard.midtrans.com/" target="_blank">Midtrans Dashboard</a>.</p>

            <form method="post" action="options.php" style="background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #ccd0d4; margin-top: 20px;">
                <?php
                settings_fields( 'dpm_settings_group' );
                do_settings_sections( 'dpm_settings_group' );
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="dpm_environment">Mode Environment</label></th>
                        <td>
                            <select name="dpm_environment" id="dpm_environment">
                                <option value="sandbox" <?php selected( get_option( 'dpm_environment', 'sandbox' ), 'sandbox' ); ?>>Sandbox (Testing Mode)</option>
                                <option value="production" <?php selected( get_option( 'dpm_environment' ), 'production' ); ?>>Production (Live Transaksi Nyata)</option>
                            </select>
                            <p class="description">Gunakan Sandbox untuk simulasi pembayaran sebelum beralih ke Production.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="dpm_client_key">Client Key</label></th>
                        <td>
                            <input type="text" name="dpm_client_key" id="dpm_client_key" value="<?php echo esc_attr( get_option( 'dpm_client_key' ) ); ?>" class="regular-text" placeholder="SB-Mid-client-..." />
                            <p class="description">Didapat dari Menu: Access Keys &gt; Client Key.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="dpm_server_key">Server Key</label></th>
                        <td>
                            <input type="password" name="dpm_server_key" id="dpm_server_key" value="<?php echo esc_attr( get_option( 'dpm_server_key' ) ); ?>" class="regular-text" placeholder="SB-Mid-server-..." />
                            <p class="description">Didapat dari Menu: Access Keys &gt; Server Key (Jaga kerahasiaan kunci ini).</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="dpm_merchant_id">Merchant ID (Opsional)</label></th>
                        <td>
                            <input type="text" name="dpm_merchant_id" id="dpm_merchant_id" value="<?php echo esc_attr( get_option( 'dpm_merchant_id' ) ); ?>" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Webhook URL (Notification URL)</th>
                        <td>
                            <code style="display: inline-block; padding: 6px 12px; background: #f0f0f1; font-weight: bold;">
                                <?php echo esc_url( home_url( '/wp-json/digitalproduk/v1/midtrans-notification' ) ); ?>
                            </code>
                            <p class="description">Salin URL ini dan tempelkan ke Midtrans Dashboard &gt; Settings &gt; Configuration &gt; Payment Notification URL.</p>
                        </td>
                    </tr>
                </table>

                <?php submit_button( 'Simpan Pengaturan Midtrans' ); ?>
            </form>
        </div>
        <?php
    }
}
