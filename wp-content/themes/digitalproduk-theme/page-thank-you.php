<?php
/**
 * Template Name: Thank You / Akses Download Produk
 * Template Post Type: page
 * Clean, direct, utilitarian
 *
 * @package DigitalProduk
 */

get_header();

$order_id = isset( $_GET['order_id'] ) ? sanitize_text_field( wp_unslash( $_GET['order_id'] ) ) : '';

$order_found = false;
$order_post_id = 0;
$product_id = 0;
$product_title = 'Produk Digital';
$customer_name = 'Pelanggan';
$customer_email = '';
$payment_status = 'pending';
$amount = 0;
$download_url = '';
$file_format = 'ZIP / Google Drive';
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

            $file_format      = get_post_meta( $product_id, '_file_format', true ) ?: 'ZIP / Google Drive';
            $access_note      = get_post_meta( $product_id, '_access_note', true );
            $cover_img        = function_exists( 'digitalproduk_get_product_cover' )
                ? digitalproduk_get_product_cover( $product_id )
                : '';
        }
    }
}
?>

<main class="site-main thank-you-page" style="background: var(--bg-canvas); min-height: 85vh; padding: 48px 0 80px;">
    <div class="container" style="max-width: 720px; margin: 0 auto;">

        <?php if ( $order_found && $payment_status === 'success' ) : ?>
            <!-- STATUS 1: PEMBAYARAN SUKSES -->
            <div class="thank-you-box">
                <div class="thank-you-badge">
                    <?php echo digitalproduk_get_icon( 'check-circle-2', '', 32 ); ?>
                </div>

                <h1 style="font-size: 1.6rem; font-weight: 700; color: var(--text-primary); margin-bottom: 6px;">
                    Pembayaran Berhasil
                </h1>
                <p style="font-size: 0.95rem; color: var(--text-secondary); margin: 0 auto 20px;">
                    Terima kasih, <strong><?php echo esc_html( $customer_name ); ?></strong>. Order <strong>#<?php echo esc_html( $order_id ); ?></strong> telah terverifikasi.
                </p>

                <!-- DOWNLOAD ACTION CARD -->
                <div class="download-action-card">
                    <div style="display: flex; gap: 14px; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                        <div style="display: flex; gap: 14px; align-items: center; flex: 1; min-width: 240px;">
                            <?php if ( ! empty( $cover_img ) ) : ?>
                                <div style="width: 70px; height: 55px; border-radius: var(--radius-sm); border: 1px solid var(--border-main); overflow: hidden; flex-shrink: 0; background: #ffffff;">
                                    <img src="<?php echo esc_url( $cover_img ); ?>" alt="<?php echo esc_attr( $product_title ); ?>" style="width: 100%; height: 100%; object-fit: cover;" />
                                </div>
                            <?php endif; ?>
                            <div>
                                <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0 0 2px; color: var(--text-primary);">
                                    <?php echo esc_html( $product_title ); ?>
                                </h3>
                                <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">
                                    Format: <?php echo esc_html( $file_format ); ?> &bull; Total: <?php echo digitalproduk_price( $amount ); ?>
                                </p>
                            </div>
                        </div>

                        <div style="flex-shrink: 0;">
                            <?php if ( ! empty( $download_url ) ) : ?>
                                <a href="<?php echo esc_url( $download_url ); ?>" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; text-decoration: none;" download>
                                    <?php echo digitalproduk_get_icon( 'download', '', 16 ); ?>
                                    <span>Download File</span>
                                </a>
                            <?php else : ?>
                                <a href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo Admin, saya sudah bayar order #' . $order_id . ' (' . $product_title . '), mohon link download.' ); ?>" target="_blank" rel="noopener" class="btn btn-primary">
                                    <span>Minta Link via WhatsApp</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if ( ! empty( $access_note ) ) : ?>
                    <div style="background: var(--bg-canvas); border: 1px solid var(--border-main); border-radius: var(--radius-sm); padding: 12px 16px; text-align: left; margin-top: 1rem;">
                        <h4 style="font-size: 0.85rem; font-weight: 700; color: var(--text-primary); margin: 0 0 4px;">
                            Catatan Penggunaan:
                        </h4>
                        <p style="font-size: 0.825rem; color: var(--text-secondary); margin: 0; line-height: 1.5; white-space: pre-line;">
                            <?php echo esc_html( $access_note ); ?>
                        </p>
                    </div>
                <?php endif; ?>

            </div>

        <?php elseif ( $order_found && $payment_status === 'pending' ) : ?>
            <!-- STATUS 2: MENUNGGU PEMBAYARAN -->
            <div class="thank-you-box">
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 8px;">
                    Menunggu Pembayaran
                </h1>
                <p style="font-size: 0.95rem; color: var(--text-secondary); margin-bottom: 20px;">
                    Pesanan <strong>#<?php echo esc_html( $order_id ); ?></strong> sedang menunggu konfirmasi pembayaran.
                </p>

                <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
                    <a href="<?php echo esc_url( home_url( '/checkout/?product_id=' . $product_id ) ); ?>" class="btn btn-primary btn-sm">
                        <span>Lanjutkan Pembayaran</span>
                    </a>
                    <button type="button" onclick="window.location.reload();" class="btn btn-secondary btn-sm">
                        <span>Cek Status</span>
                    </button>
                </div>
            </div>

        <?php else : ?>
            <div class="thank-you-box">
                <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 8px;">
                    Pesanan Tidak Ditemukan
                </h1>
                <p style="font-size: 0.95rem; color: var(--text-secondary); margin-bottom: 20px;">
                    Silakan pilih produk terlebih dahulu melalui katalog kami.
                </p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-sm">
                    <span>Ke Katalog Produk</span>
                </a>
            </div>
        <?php endif; ?>

        <!-- HELP -->
        <div style="margin-top: 20px; text-align: center; font-size: 0.825rem; color: var(--text-muted);">
            Kendala download atau butuh bantuan? <a href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo Admin, butuh bantuan order #' . $order_id ); ?>" target="_blank" rel="noopener" style="color: var(--brand-cobalt); font-weight: 600;">Hubungi WhatsApp</a>
        </div>

    </div>
</main>

<?php
get_footer();
