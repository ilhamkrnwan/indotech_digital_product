<?php
/**
 * Template Name: Thank You / Akses Download Produk
 * Template Post Type: page
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

<main class="site-main thank-you-page" style="background: #fdfbf7; min-height: 85vh; padding: 48px 0 80px;">
    <div class="container" style="max-width: 860px; margin: 0 auto;">

        <?php if ( $order_found && $payment_status === 'success' ) : ?>
            <!-- STATUS 1: PEMBAYARAN SUKSES & AKSES SIAP DOWNLOAD -->
            <div class="card neo-card" style="background: #ffffff; border: 3px solid #1e293b; border-radius: 20px; padding: 36px; box-shadow: 8px 8px 0 #1e293b; margin-bottom: 28px; text-align: center;">
                
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 72px; height: 72px; background: #dcfce7; border: 3px solid #16a34a; border-radius: 50%; color: #16a34a; margin-bottom: 18px; box-shadow: 3px 3px 0 #16a34a;">
                    <?php echo digitalproduk_get_icon( 'check-circle-2', '', 40 ); ?>
                </div>

                <div style="display: inline-block; background: #fef08a; border: 2px solid #1e293b; padding: 4px 14px; border-radius: 999px; font-weight: 800; font-size: 0.8rem; text-transform: uppercase; margin-bottom: 12px;">
                    ⚡ Pembayaran Terverifikasi Instan
                </div>

                <h1 style="font-family: var(--font-heading); font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-bottom: 10px;">
                    Terima Kasih, <?php echo esc_html( $customer_name ); ?>!
                </h1>
                <p style="font-size: 1.05rem; color: #475569; max-width: 600px; margin: 0 auto 28px; line-height: 1.6;">
                    Pesanan Anda dengan Order ID <strong>#<?php echo esc_html( $order_id ); ?></strong> telah sukses dibayar. Aset digital Anda siap untuk langsung diunduh sekarang.
                </p>

                <!-- DOWNLOAD HERO BOX -->
                <div style="background: #f8fafc; border: 2.5px solid #1e293b; border-radius: 16px; padding: 24px; margin-bottom: 24px; text-align: left; display: flex; gap: 24px; align-items: center; justify-content: space-between;">
                    <div style="display: flex; gap: 18px; align-items: center; flex: 1; min-width: 0;">
                        <?php if ( ! empty( $cover_img ) ) : ?>
                            <div style="width: 100px; height: 75px; border-radius: 10px; border: 2px solid #1e293b; overflow: hidden; flex-shrink: 0; background: #e2e8f0;">
                                <img src="<?php echo esc_url( $cover_img ); ?>" alt="<?php echo esc_attr( $product_title ); ?>" style="width: 100%; height: 100%; object-fit: cover;" />
                            </div>
                        <?php endif; ?>
                        <div style="min-width: 0;">
                            <span style="display: inline-block; font-size: 0.72rem; font-weight: 800; color: #0284c7; background: #e0f2fe; padding: 3px 8px; border-radius: 6px; border: 1.5px solid #0284c7; text-transform: uppercase; margin-bottom: 4px;">
                                <?php echo esc_html( $file_format ); ?>
                            </span>
                            <h3 style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 800; margin: 0 0 6px; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?php echo esc_html( $product_title ); ?>
                            </h3>
                            <p style="font-size: 0.85rem; color: #64748b; margin: 0;">
                                Total Bayar: <strong style="color: #0f172a;"><?php echo digitalproduk_price( $amount ); ?></strong> &bull; Lisensi Komersial Aktif
                            </p>
                        </div>
                    </div>

                    <div style="flex-shrink: 0;">
                        <?php if ( ! empty( $download_url ) ) : ?>
                            <!-- TOMBOL DOWNLOAD INSTAN (DIRECT DRIVE / FILE) -->
                            <a href="<?php echo esc_url( $download_url ); ?>" class="btn btn-primary" style="display: inline-flex; align-items: center; justify-content: center; gap: 10px; padding: 14px 28px; font-size: 1.05rem; font-weight: 800; text-decoration: none; white-space: nowrap;" download>
                                <?php echo digitalproduk_get_icon( 'download', '', 20 ); ?>
                                <span>Download File Sekarang</span>
                            </a>
                        <?php else : ?>
                            <a href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo Admin, saya telah membayar order #' . $order_id . ' (' . $product_title . '), mohon kirimkan link akses file saya.' ); ?>" target="_blank" rel="noopener" class="btn btn-primary" style="display: inline-flex; align-items: center; justify-content: center; gap: 10px; padding: 14px 28px; font-size: 1rem; font-weight: 800; white-space: nowrap;">
                                <?php echo digitalproduk_get_icon( 'message-circle', '', 18 ); ?>
                                <span>Klaim Akses via CS</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ( ! empty( $access_note ) ) : ?>
                    <!-- CATATAN PENGGUNAAN / PASSWORD EKSTRAK ZIP -->
                    <div style="background: #fffbeb; border: 2px dashed #f59e0b; border-radius: 12px; padding: 16px 20px; text-align: left;">
                        <h4 style="font-size: 0.95rem; font-weight: 800; color: #b45309; margin: 0 0 6px; display: flex; align-items: center; gap: 6px;">
                            <?php echo digitalproduk_get_icon( 'sparkles', '', 16 ); ?>
                            <span>Petunjuk Akses &amp; Ekstrak File:</span>
                        </h4>
                        <p style="font-size: 0.9rem; color: #78350f; margin: 0; line-height: 1.5; white-space: pre-line;">
                            <?php echo esc_html( $access_note ); ?>
                        </p>
                    </div>
                <?php endif; ?>

            </div>

        <?php elseif ( $order_found && $payment_status === 'pending' ) : ?>
            <!-- STATUS 2: MENUNGGU PEMBAYARAN -->
            <div class="card neo-card" style="background: #ffffff; border: 3px solid #1e293b; border-radius: 20px; padding: 36px; box-shadow: 8px 8px 0 #1e293b; margin-bottom: 28px; text-align: center;">
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 68px; height: 68px; background: #fef3c7; border: 3px solid #d97706; border-radius: 50%; color: #d97706; margin-bottom: 16px;">
                    <?php echo digitalproduk_get_icon( 'clock', '', 36 ); ?>
                </div>
                <h1 style="font-family: var(--font-heading); font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 8px;">
                    Menunggu Pembayaran
                </h1>
                <p style="font-size: 1rem; color: #475569; max-width: 520px; margin: 0 auto 24px;">
                    Pesanan Anda <strong>#<?php echo esc_html( $order_id ); ?></strong> sedang menunggu penyelesaian pembayaran. Jika sudah membayar, klik tombol verifikasi di bawah.
                </p>

                <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                    <a href="<?php echo esc_url( home_url( '/checkout/?product_id=' . $product_id ) ); ?>" class="btn btn-primary">
                        <span>Lanjutkan Pembayaran</span>
                    </a>
                    <button type="button" onclick="window.location.reload();" class="btn btn-secondary">
                        <span>Cek Status Terbaru</span>
                    </button>
                </div>
            </div>

        <?php else : ?>
            <!-- STATUS 3: PESANAN TIDAK DITEMUKAN / DIRECT BROWSE -->
            <div class="card neo-card" style="background: #ffffff; border: 3px solid #1e293b; border-radius: 20px; padding: 36px; box-shadow: 8px 8px 0 #1e293b; margin-bottom: 28px; text-align: center;">
                <h1 style="font-family: var(--font-heading); font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 8px;">
                    Halaman Konfirmasi Pesanan
                </h1>
                <p style="font-size: 1rem; color: #475569; margin-bottom: 24px;">
                    Silakan lakukan pembelian produk digital terlebih dahulu melalui katalog kami untuk mendapatkan link download instan.
                </p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                    <span>Kembali ke Katalog Utama</span>
                </a>
            </div>
        <?php endif; ?>

        <!-- FOOTER HELP BOX -->
        <div style="background: #ffffff; border: 2.5px solid #1e293b; border-radius: 14px; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
            <div>
                <h4 style="font-family: var(--font-heading); font-size: 1.05rem; font-weight: 800; margin: 0 0 4px; color: #0f172a;">
                    Mengalami Kendala Saat Download File?
                </h4>
                <p style="font-size: 0.85rem; color: #64748b; margin: 0;">
                    Tim Customer Support Indotech siap membantu 24/7 jika ada kendala ekstrak file zip atau akses Google Drive.
                </p>
            </div>
            <a href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo Tim Indotech, saya ingin bantuan seputar download pesanan #' . $order_id ); ?>" target="_blank" rel="noopener" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
                <?php echo digitalproduk_get_icon( 'message-circle', '', 16 ); ?>
                <span>Chat Admin WhatsApp</span>
            </a>
        </div>

    </div>
</main>

<?php
get_footer();
