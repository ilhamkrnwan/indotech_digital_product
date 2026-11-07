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

<main class="site-main thank-you-page" style="background: var(--bg-canvas); min-height: 85vh; padding: 48px 0 80px; position: relative; overflow: hidden;">
    <!-- Abstract Brush & Wireframe Canvas for Download / Thank You Page -->
    <div class="thankyou-art-canvas" aria-hidden="true">
        <!-- Top Right Celebratory Cobalt Splash (Organic Curved & Tapered) -->
        <svg class="thankyou-stroke-splash" viewBox="0 0 420 280" fill="none">
            <path d="M100 35 C 145 18, 195 26, 240 14 C 285 5, 335 12, 375 28 C 405 40, 418 65, 418 95 C 418 125, 400 155, 380 178 C 350 210, 310 235, 275 225 C 245 215, 230 185, 222 155 C 215 125, 218 95, 198 72 C 172 45, 130 46, 100 35 Z" fill="#152cab" opacity="0.85" />
            <path d="M150 30 C 195 16, 250 22, 295 12 C 340 6, 375 18, 405 38 C 415 52, 415 75, 405 98 C 385 130, 350 155, 310 165 C 285 172, 265 155, 268 138 C 272 115, 288 92, 278 72 C 265 50, 215 45, 150 30 Z" fill="#2563eb" opacity="0.35" />
            <path d="M200 35 C 250 24, 300 38, 350 26 C 380 18, 400 30, 410 26 C 405 44, 370 50, 330 46 C 270 42, 220 54, 190 40 Z" fill="#f7d801" />
            <circle cx="190" cy="75" r="4" fill="#152cab" />
            <circle cx="230" cy="120" r="3" fill="#152cab" />
            <circle cx="215" cy="55" r="2.5" fill="#f7d801" />
        </svg>

        <!-- Wireframe Triangle -->
        <svg class="thankyou-geo-triangle" viewBox="0 0 32 32" fill="none">
            <polygon points="16,3 29,27 3,27" stroke="#152cab" stroke-width="2.5" />
        </svg>

        <!-- Plus Marks -->
        <div class="thankyou-geo-plus" style="top: 60px; left: 45px; color: #152cab; opacity: 0.20;">+</div>
        <div class="thankyou-geo-plus" style="bottom: 70px; right: 80px; color: #f59e0b; opacity: 0.24;">+</div>
    </div>

    <div class="container" style="max-width: 720px; margin: 0 auto; position: relative; z-index: 10;">

        <?php if ( $order_found && $payment_status === 'success' ) : ?>
            <!-- STATUS 1: PEMBAYARAN SUKSES -->
            <div class="thank-you-box" style="position: relative;">
                <div class="thank-you-badge">
                    <?php echo digitalproduk_get_icon( 'check-circle-2', '', 32 ); ?>
                </div>

                <h1 style="font-size: 1.85rem; font-weight: 900; color: var(--text-primary); margin-bottom: 8px; letter-spacing: -0.025em;">
                    Pembayaran 
                    <span class="brush-highlight-dynamic">
                        <span class="word-text">Berhasil!</span>
                        <svg class="brush-svg-multi" viewBox="0 0 300 24" fill="none" preserveAspectRatio="none" aria-hidden="true">
                            <path d="M4 16 C55 10 130 18 205 12 C250 8 285 13 296 10 C285 18 230 21 170 20 C100 19 45 21 8 18 C3 17 2 16 4 16 Z" fill="#f59e0b" opacity="0.85" />
                            <path d="M14 10 C65 6 150 12 225 8 C270 5 292 9 298 7 C288 15 235 17 180 16 C120 15 55 17 18 14 C10 13 8 10 14 10 Z" fill="#f7d801" />
                            <circle cx="295" cy="15" r="1.8" fill="#f59e0b" />
                        </svg>
                    </span>
                </h1>
                <p style="font-size: 0.95rem; color: var(--text-secondary); margin: 0 auto 24px;">
                    Terima kasih, <strong><?php echo esc_html( $customer_name ); ?></strong>. Order <strong>#<?php echo esc_html( $order_id ); ?></strong> telah terverifikasi otomatis.
                </p>

                <!-- DOWNLOAD ACTION CARD -->
                <div class="download-action-card" style="position: relative; overflow: hidden;">
                    <!-- Mini Corner Paint Splash -->
                    <svg class="thumb-paint-accent" viewBox="0 0 65 65" fill="none" aria-hidden="true">
                        <path d="M10 0 C25 10 40 5 55 18 C62 25 65 45 65 45 V0 H10 Z" fill="#152cab" opacity="0.85" />
                        <path d="M30 0 C45 8 55 12 65 15 V0 H30 Z" fill="#f7d801" />
                        <circle cx="35" cy="28" r="2.5" fill="#152cab" />
                    </svg>

                    <div style="display: flex; gap: 14px; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                        <div style="display: flex; gap: 14px; align-items: center; flex: 1; min-width: 240px;">
                            <?php if ( ! empty( $cover_img ) ) : ?>
                                <div style="width: 70px; height: 55px; border-radius: var(--radius-sm); border: 1px solid var(--border-main); overflow: hidden; flex-shrink: 0; background: #ffffff;">
                                    <img src="<?php echo esc_url( $cover_img ); ?>" alt="<?php echo esc_attr( $product_title ); ?>" style="width: 100%; height: 100%; object-fit: cover;" />
                                </div>
                            <?php endif; ?>
                            <div>
                                <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0 0 4px; color: var(--text-primary);">
                                    <?php echo esc_html( $product_title ); ?>
                                </h3>
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <span style="font-size: 0.8rem; color: var(--text-muted);">
                                        Format: <strong><?php echo esc_html( $file_format ); ?></strong>
                                    </span>
                                    <div class="price-brush-tag">
                                        <svg class="price-brush-bg" viewBox="0 0 120 30" fill="none" preserveAspectRatio="none" aria-hidden="true">
                                            <path d="M2 18 C25 10 65 20 110 14 C118 13 119 18 116 22 C90 26 50 25 10 24 C4 23 1 20 2 18 Z" fill="#f7d801" />
                                            <path d="M8 12 C35 6 75 14 112 10" stroke="#fef08a" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        <span class="price-val-bold" style="font-size: 0.95rem;">
                                            <?php echo digitalproduk_price( $amount ); ?>
                                        </span>
                                    </div>
                                </div>
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
                <h1 style="font-size: 1.65rem; font-weight: 900; color: var(--text-primary); margin-bottom: 12px; letter-spacing: -0.025em;">
                    Menunggu 
                    <span class="brush-highlight-dynamic">
                        <span class="word-text">Pembayaran.</span>
                        <svg class="brush-svg-multi" viewBox="0 0 300 24" fill="none" preserveAspectRatio="none" aria-hidden="true">
                            <path d="M4 16 C55 10 130 18 205 12 C250 8 285 13 296 10 C285 18 230 21 170 20 C100 19 45 21 8 18 C3 17 2 16 4 16 Z" fill="#f59e0b" opacity="0.85" />
                            <path d="M14 10 C65 6 150 12 225 8 C270 5 292 9 298 7 C288 15 235 17 180 16 C120 15 55 17 18 14 C10 13 8 10 14 10 Z" fill="#f7d801" />
                            <circle cx="295" cy="15" r="1.8" fill="#f59e0b" />
                        </svg>
                    </span>
                </h1>
                <p style="font-size: 0.95rem; color: var(--text-secondary); margin-bottom: 20px;">
                    Pesanan <strong>#<?php echo esc_html( $order_id ); ?></strong> sedang menunggu konfirmasi pembayaran otomatis via Midtrans.
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
                <h1 style="font-size: 1.65rem; font-weight: 900; color: var(--text-primary); margin-bottom: 12px; letter-spacing: -0.025em;">
                    Akses 
                    <span class="brush-highlight-dynamic">
                        <span class="word-text">Download Produk.</span>
                        <svg class="brush-svg-multi" viewBox="0 0 300 24" fill="none" preserveAspectRatio="none" aria-hidden="true">
                            <path d="M4 16 C55 10 130 18 205 12 C250 8 285 13 296 10 C285 18 230 21 170 20 C100 19 45 21 8 18 C3 17 2 16 4 16 Z" fill="#f59e0b" opacity="0.85" />
                            <path d="M14 10 C65 6 150 12 225 8 C270 5 292 9 298 7 C288 15 235 17 180 16 C120 15 55 17 18 14 C10 13 8 10 14 10 Z" fill="#f7d801" />
                            <circle cx="295" cy="15" r="1.8" fill="#f59e0b" />
                        </svg>
                    </span>
                </h1>
                <p style="font-size: 0.95rem; color: var(--text-secondary); margin-bottom: 20px;">
                    Silakan masukkan Order ID atau pilih produk terlebih dahulu melalui katalog kami.
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
