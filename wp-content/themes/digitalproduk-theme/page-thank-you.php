<?php
/**
 * Template Name: Thank You / Akses Download Produk
 * Template Post Type: page
 * Indotech Technical Commerce Design System
 *
 * @package DigitalProduk
 */

get_header();

// Ambil Order ID dari parameter query URL (?order_id=DP-...)
$order_id = isset( $_GET['order_id'] ) ? sanitize_text_field( wp_unslash( $_GET['order_id'] ) ) : '';

$order_found = false;
$order_post_id = 0;
$product_id = 0;
$product_title = 'Produk Digital Premium';
$customer_name = 'Pelanggan';
$customer_email = '';
$payment_status = 'pending';
$amount = 0;
$download_url = '';
$file_format = 'ZIP Archive / Source Code';
$access_note = '';
$cover_img = '';

if ( ! empty( $order_id ) ) {
    $orders = get_posts([
        'post_type'      => 'product_order',
        'meta_key'       => '_order_id',
        'meta_value'     => $order_id,
        'posts_per_page' => 1,
        'post_status'    => 'any',
    ]);

    if ( ! empty( $orders ) ) {
        $order_found    = true;
        $order_post     = $orders[0];
        $order_post_id  = $order_post->ID;

        $product_id     = (int) get_post_meta( $order_post_id, '_product_id', true );
        $product_title  = get_post_meta( $order_post_id, '_product_title', true ) ?: ( $product_id ? get_the_title( $product_id ) : 'Produk Digital' );
        $customer_name  = get_post_meta( $order_post_id, '_customer_name', true ) ?: 'Pelanggan';
        $customer_email = get_post_meta( $order_post_id, '_customer_email', true );
        $payment_status = get_post_meta( $order_post_id, '_payment_status', true ) ?: 'pending';
        $amount         = (int) get_post_meta( $order_post_id, '_amount', true );

        if ( $product_id ) {
            $raw_download_url = get_post_meta( $product_id, '_download_url', true );
            $download_url     = function_exists( 'digitalproduk_format_download_url' )
                ? digitalproduk_format_download_url( $raw_download_url )
                : $raw_download_url;

            $file_format      = get_post_meta( $product_id, '_file_format', true ) ?: 'ZIP Archive / Source Code';
            $access_note      = get_post_meta( $product_id, '_access_note', true );
            $cover_img        = function_exists( 'digitalproduk_get_product_cover' )
                ? digitalproduk_get_product_cover( $product_id )
                : '';
        }
    }
}
?>

<main class="site-main thank-you-page" style="background: var(--bg-canvas); min-height: 85vh; padding: 48px 0 80px;">
    <div class="container" style="max-width: 820px; margin: 0 auto;">

        <?php if ( $order_found && $payment_status === 'success' ) : ?>
            <!-- STATUS 1: PEMBAYARAN SUKSES & AKSES SIAP DOWNLOAD -->
            <div class="thank-you-box">
                
                <div class="thank-you-badge">
                    <?php echo digitalproduk_get_icon( 'check-circle-2', '', 36 ); ?>
                </div>

                <div style="margin-bottom: 12px;">
                    <span style="font-family: var(--font-mono); font-size: 0.75rem; font-weight: 700; color: var(--status-success); background: var(--status-success-bg); border: 1px solid var(--status-success-border); padding: 3px 10px; border-radius: var(--radius-sm); text-transform: uppercase;">
                        Pembayaran Terverifikasi Midtrans
                    </span>
                </div>

                <h1 style="font-size: 1.85rem; font-weight: 800; color: var(--text-primary); margin-bottom: 8px; letter-spacing: -0.02em;">
                    Terima Kasih, <?php echo esc_html( $customer_name ); ?>!
                </h1>
                <p style="font-size: 0.95rem; color: var(--text-secondary); max-width: 580px; margin: 0 auto 24px; line-height: 1.6;">
                    Pesanan Anda dengan Order ID <strong>#<?php echo esc_html( $order_id ); ?></strong> telah sukses diverifikasi. Akses download file aset digital Anda siap diunduh sekarang.
                </p>

                <!-- DOWNLOAD ACTION CARD -->
                <div class="download-action-card">
                    <div style="display: flex; gap: 16px; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                        <div style="display: flex; gap: 16px; align-items: center; flex: 1; min-width: 260px;">
                            <?php if ( ! empty( $cover_img ) ) : ?>
                                <div style="width: 80px; height: 60px; border-radius: var(--radius-sm); border: 1px solid var(--border-main); overflow: hidden; flex-shrink: 0; background: #ffffff;">
                                    <img src="<?php echo esc_url( $cover_img ); ?>" alt="<?php echo esc_attr( $product_title ); ?>" style="width: 100%; height: 100%; object-fit: cover;" />
                                </div>
                            <?php endif; ?>
                            <div>
                                <span style="display: inline-block; font-family: var(--font-mono); font-size: 0.7rem; font-weight: 700; color: var(--brand-cobalt); background: var(--brand-cobalt-light); padding: 2px 6px; border-radius: 4px; text-transform: uppercase; margin-bottom: 4px;">
                                    <?php echo esc_html( $file_format ); ?>
                                </span>
                                <h3 style="font-size: 1.15rem; font-weight: 700; margin: 0 0 4px; color: var(--text-primary);">
                                    <?php echo esc_html( $product_title ); ?>
                                </h3>
                                <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">
                                    Total: <strong style="color: var(--text-primary);"><?php echo digitalproduk_price( $amount ); ?></strong> &bull; Lisensi Komersial Bebas
                                </p>
                            </div>
                        </div>

                        <div style="flex-shrink: 0;">
                            <?php if ( ! empty( $download_url ) ) : ?>
                                <!-- TOMBOL DOWNLOAD INSTAN -->
                                <a href="<?php echo esc_url( $download_url ); ?>" class="btn btn-primary btn-lg" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none;" download>
                                    <?php echo digitalproduk_get_icon( 'download', '', 18 ); ?>
                                    <span>Download File Sekarang</span>
                                </a>
                            <?php else : ?>
                                <a href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo Admin Indotech, saya telah membayar order #' . $order_id . ' (' . $product_title . '), mohon kirimkan link akses file saya.' ); ?>" target="_blank" rel="noopener" class="btn btn-primary btn-lg">
                                    <?php echo digitalproduk_get_icon( 'message-circle', '', 18 ); ?>
                                    <span>Klaim Akses via WhatsApp</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if ( ! empty( $access_note ) ) : ?>
                    <!-- PETUNJUK PENGGUNAAN -->
                    <div style="background: var(--bg-canvas); border: 1px solid var(--border-main); border-radius: var(--radius-sm); padding: 14px 18px; text-align: left; margin-top: 1rem;">
                        <h4 style="font-size: 0.875rem; font-weight: 700; color: var(--text-primary); margin: 0 0 4px; display: flex; align-items: center; gap: 6px;">
                            <?php echo digitalproduk_get_icon( 'file-text', '', 15 ); ?>
                            <span>Petunjuk Penggunaan &amp; Ekstrak File:</span>
                        </h4>
                        <p style="font-size: 0.85rem; color: var(--text-secondary); margin: 0; line-height: 1.5; white-space: pre-line;">
                            <?php echo esc_html( $access_note ); ?>
                        </p>
                    </div>
                <?php endif; ?>

            </div>

        <?php elseif ( $order_found && $payment_status === 'pending' ) : ?>
            <!-- STATUS 2: MENUNGGU PEMBAYARAN -->
            <div class="thank-you-box">
                <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--status-pending-bg); border: 1px solid var(--status-pending-border); color: var(--status-pending); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.25rem;">
                    <?php echo digitalproduk_get_icon( 'clock', '', 32 ); ?>
                </div>
                <h1 style="font-size: 1.6rem; font-weight: 800; color: var(--text-primary); margin-bottom: 8px;">
                    Menunggu Pembayaran
                </h1>
                <p style="font-size: 0.95rem; color: var(--text-secondary); max-width: 500px; margin: 0 auto 20px;">
                    Pesanan Anda <strong>#<?php echo esc_html( $order_id ); ?></strong> sedang menunggu penyelesaian pembayaran. Jika sudah membayar, klik tombol cek status di bawah.
                </p>

                <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
                    <a href="<?php echo esc_url( home_url( '/checkout/?product_id=' . $product_id ) ); ?>" class="btn btn-primary">
                        <span>Lanjutkan Pembayaran</span>
                    </a>
                    <button type="button" onclick="window.location.reload();" class="btn btn-secondary">
                        <span>Cek Status Terbaru</span>
                    </button>
                </div>
            </div>

        <?php else : ?>
            <!-- STATUS 3: PESANAN TIDAK DITEMUKAN -->
            <div class="thank-you-box">
                <h1 style="font-size: 1.6rem; font-weight: 800; color: var(--text-primary); margin-bottom: 8px;">
                    Konfirmasi Pesanan
                </h1>
                <p style="font-size: 0.95rem; color: var(--text-secondary); margin-bottom: 20px;">
                    Silakan lakukan pembelian produk digital terlebih dahulu melalui katalog kami untuk mendapatkan tautan download instan.
                </p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                    <span>Kembali ke Katalog Utama</span>
                </a>
            </div>
        <?php endif; ?>

        <!-- FOOTER HELP BOX -->
        <div style="margin-top: 24px; background: #ffffff; border: 1px solid var(--border-main); border-radius: var(--radius-md); padding: 18px 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
            <div>
                <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0 0 2px; color: var(--text-primary);">
                    Butuh Bantuan Teknis atau Panduan File?
                </h4>
                <p style="margin: 0; font-size: 0.825rem; color: var(--text-secondary);">
                    Tim dukungan teknis kami siap mendampingi proses setup &amp; integrasi produk Anda.
                </p>
            </div>
            <a href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo Admin Indotech, saya ingin bantuan teknis untuk order #' . $order_id ); ?>" target="_blank" rel="noopener" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
                <?php echo digitalproduk_get_icon( 'message-circle', '', 15 ); ?>
                <span>WhatsApp Support</span>
            </a>
        </div>

    </div>
</main>

<?php
get_footer();
