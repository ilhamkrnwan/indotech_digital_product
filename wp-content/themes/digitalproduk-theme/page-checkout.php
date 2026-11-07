<?php
/**
 * Template Name: Checkout Pembayaran Khusus
 * Template Post Type: page
 * Indotech Technical Commerce Design System
 *
 * @package DigitalProduk
 */

get_header();

// 1. Ambil semua produk digital aktif
$all_products = get_posts([
    'post_type'      => 'digital_product',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

// 2. Tentukan produk yang dipilih (dari ?product_id=X atau default produk pertama)
$selected_id = isset( $_GET['product_id'] ) ? absint( $_GET['product_id'] ) : ( isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0 );
$current_product = null;

if ( $selected_id > 0 ) {
    foreach ( $all_products as $p ) {
        if ( $p->ID === $selected_id ) {
            $current_product = $p;
            break;
        }
    }
}

if ( ! $current_product && ! empty( $all_products ) ) {
    $current_product = $all_products[0];
    $selected_id = $current_product->ID;
}

$prod_id = $current_product ? $current_product->ID : 0;
$prod_title = $current_product ? $current_product->post_title : 'Produk Digital';
$prod_price = $current_product ? ( get_post_meta( $prod_id, '_price', true ) ?: 199000 ) : 199000;
$prod_sale_price = $current_product ? ( get_post_meta( $prod_id, '_sale_price', true ) ?: $prod_price ) : $prod_price;
$prod_cover = $current_product ? digitalproduk_get_product_cover( $prod_id ) : '';
$prod_badge = $current_product ? get_post_meta( $prod_id, '_badge', true ) : 'REKOMENDASI';

$features_meta = $current_product ? get_post_meta( $prod_id, '_features', true ) : '';
$prod_features = ! empty( $features_meta ) ? ( is_array( $features_meta ) ? $features_meta : explode( "\n", $features_meta ) ) : [
    'Akses Download Langsung & Lifetime',
    'Lisensi Komersial Lengkap (Royalti 0)',
    'Update Versi Terbaru Gratis Selamanya',
    'Dukungan Tanya Jawab & Bantuan Teknis'
];

// Siapkan data JSON untuk dynamic switch produk jika user mengganti pilihan di dropdown
$products_json_map = [];
foreach ( $all_products as $p ) {
    $p_id = $p->ID;
    $p_price = get_post_meta( $p_id, '_price', true ) ?: 199000;
    $p_sale = get_post_meta( $p_id, '_sale_price', true ) ?: $p_price;
    $products_json_map[ $p_id ] = [
        'id'          => $p_id,
        'title'       => $p->post_title,
        'price_fmt'   => digitalproduk_price( $p_sale ),
        'orig_fmt'    => digitalproduk_price( $p_price ),
        'cover'       => digitalproduk_get_product_cover( $p_id ),
        'permalink'   => get_permalink( $p_id ),
    ];
}
?>

<main class="site-main checkout-page-main" style="background: var(--bg-canvas); min-height: 85vh; padding: 40px 0 80px;">
    <div class="container">

        <!-- Top Breadcrumb / Back Link -->
        <div style="margin-bottom: 24px;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 8px;">
                <?php echo digitalproduk_get_icon( 'arrow-left', '', 14 ); ?>
                <span>Kembali ke Katalog Produk</span>
            </a>
        </div>

        <div class="checkout-grid">

            <!-- LEFT COLUMN: Rincian Produk & Garansi -->
            <div class="checkout-left-col">
                <div class="checkout-card">
                    
                    <div class="checkout-card-header">
                        <div>
                            <span style="font-family: var(--font-mono); font-size: 0.75rem; font-weight: 700; color: var(--brand-cobalt); background: var(--brand-cobalt-light); border: 1px solid var(--brand-cobalt-border); padding: 3px 8px; border-radius: var(--radius-sm); text-transform: uppercase;">
                                Ringkasan Pesanan
                            </span>
                            <h1 style="font-size: 1.5rem; font-weight: 800; margin: 10px 0 0; color: var(--text-primary); letter-spacing: -0.02em;">Selesaikan Pembelian</h1>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 0.75rem; color: var(--text-muted); font-family: var(--font-mono);">STATUS:</span>
                            <div style="display: flex; align-items: center; gap: 6px; color: var(--status-success); font-weight: 700; font-size: 0.85rem; font-family: var(--font-mono);">
                                <span style="width: 7px; height: 7px; border-radius: 50%; background: var(--status-success); display: inline-block;"></span>
                                Ready Instant
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Pilih Produk (Bisa Ganti Tanpa Reload) -->
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="checkoutProductSelector" class="form-label">
                            Pilihan Produk Digital:
                        </label>
                        <select id="checkoutProductSelector" class="form-select">
                            <?php foreach ( $all_products as $p ) : 
                                $is_sel = ( $p->ID === $prod_id );
                                $p_sale = get_post_meta( $p->ID, '_sale_price', true ) ?: get_post_meta( $p->ID, '_price', true );
                            ?>
                                <option value="<?php echo esc_attr( $p->ID ); ?>" <?php selected( $is_sel ); ?>>
                                    <?php echo esc_html( $p->post_title ); ?> — <?php echo digitalproduk_price( $p_sale ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Selected Product Display Card -->
                    <div id="productSummaryCard" style="display: flex; gap: 16px; align-items: center; background: var(--bg-canvas); border: 1px solid var(--border-main); border-radius: var(--radius-md); padding: 14px; margin-bottom: 20px;">
                        <img id="summaryProductImg" src="<?php echo esc_url( $prod_cover ); ?>" alt="<?php echo esc_attr( $prod_title ); ?>" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid var(--border-main); border-radius: var(--radius-sm); background: #fff;" />
                        <div style="flex: 1;">
                            <h3 id="summaryProductTitle" style="font-size: 1.05rem; font-weight: 700; margin: 0 0 4px; color: var(--text-primary); line-height: 1.3;">
                                <?php echo esc_html( $prod_title ); ?>
                            </h3>
                            <div style="display: flex; align-items: baseline; gap: 8px;">
                                <span id="summaryProductSale" style="font-size: 1.3rem; font-weight: 800; color: var(--brand-cobalt); letter-spacing: -0.02em;">
                                    <?php echo digitalproduk_price( $prod_sale_price ); ?>
                                </span>
                                <span id="summaryProductOrig" style="font-size: 0.85rem; text-decoration: line-through; color: var(--text-muted); font-weight: 500;">
                                    <?php echo digitalproduk_price( $prod_price ); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Benefits Included -->
                    <div style="margin-bottom: 20px;">
                        <h4 style="font-size: 0.875rem; font-weight: 700; margin: 0 0 10px; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                            <?php echo digitalproduk_get_icon( 'check-circle-2', '', 16 ); ?>
                            <span>Yang Anda Dapatkan Dalam Paket Ini:</span>
                        </h4>
                        <ul style="list-style: none; padding: 0; margin: 0; display: grid; gap: 8px;">
                            <?php foreach ( $prod_features as $feat ) : ?>
                                <li style="display: flex; align-items: center; gap: 8px; font-size: 0.875rem; color: var(--text-secondary);">
                                    <span style="color: var(--status-success); display: inline-flex;"><?php echo digitalproduk_get_icon( 'check', '', 14 ); ?></span>
                                    <span><?php echo esc_html( trim( $feat ) ); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Trust Bar -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; background: var(--bg-canvas); padding: 12px; border-radius: var(--radius-sm); border: 1px solid var(--border-subtle);">
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 0.825rem; font-weight: 600; color: var(--text-secondary);">
                            <?php echo digitalproduk_get_icon( 'shield-check', '', 18 ); ?>
                            <span>Enkripsi 256-bit SSL</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 0.825rem; font-weight: 600; color: var(--text-secondary);">
                            <?php echo digitalproduk_get_icon( 'zap', '', 18 ); ?>
                            <span>Pengiriman Otomatis</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- RIGHT COLUMN: Form Checkout & Pembayaran Midtrans -->
            <div class="checkout-right-col">
                <div class="checkout-card">
                    
                    <div style="margin-bottom: 20px;">
                        <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.75rem; font-weight: 700; font-family: var(--font-mono); background: var(--brand-cobalt-light); color: var(--brand-cobalt); border: 1px solid var(--brand-cobalt-border); padding: 3px 8px; border-radius: var(--radius-sm); margin-bottom: 8px;">
                            <?php echo digitalproduk_get_icon( 'lock', '', 12 ); ?>
                            PEMBAYARAN RESMI MIDTRANS
                        </span>
                        <h2 style="font-size: 1.35rem; font-weight: 800; margin: 0; color: var(--text-primary); letter-spacing: -0.02em;">Informasi Pengiriman</h2>
                        <p style="margin: 4px 0 0; font-size: 0.85rem; color: var(--text-secondary);">
                            File dan akses digital akan dikirimkan otomatis ke email ini setelah pembayaran berhasil.
                        </p>
                    </div>

                    <form id="dedicatedCheckoutForm" method="post" style="display: grid; gap: 14px;">
                        
                        <input type="hidden" id="checkoutHiddenProductId" name="product_id" value="<?php echo esc_attr( $prod_id ); ?>" />

                        <div>
                            <label for="pageBuyerName" class="form-label">
                                Nama Lengkap <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" id="pageBuyerName" name="name" required placeholder="Contoh: Budi Santoso" class="form-input" />
                        </div>

                        <div>
                            <label for="pageBuyerEmail" class="form-label">
                                Alamat Email Aktif <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="email" id="pageBuyerEmail" name="email" required placeholder="email.anda@gmail.com" class="form-input" />
                            <small style="font-size: 0.775rem; color: var(--text-muted); margin-top: 4px; display: block;">Pastikan email benar &amp; aktif untuk menerima tautan file.</small>
                        </div>

                        <div>
                            <label for="pageBuyerPhone" class="form-label">
                                Nomor WhatsApp <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-muted);">(Disarankan)</span>
                            </label>
                            <input type="tel" id="pageBuyerPhone" name="phone" placeholder="08xxxxxxxxxx" class="form-input" />
                        </div>

                        <!-- Midtrans Accepted Methods Banner -->
                        <div style="background: var(--bg-canvas); border: 1px solid var(--border-main); border-radius: var(--radius-sm); padding: 12px; margin-top: 4px;">
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--text-muted); display: block; margin-bottom: 6px; font-family: var(--font-mono); text-transform: uppercase;">Metode Pembayaran Yang Didukung:</span>
                            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                <span class="badge-item">QRIS</span>
                                <span class="badge-item">GoPay</span>
                                <span class="badge-item">ShopeePay</span>
                                <span class="badge-item">BCA / Mandiri / BNI / BRI VA</span>
                                <span class="badge-item">Kartu Kredit</span>
                            </div>
                        </div>

                        <!-- Notice Container -->
                        <div id="pageCheckoutNotice" style="display: none; padding: 12px; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.85rem; border: 1px solid currentColor; margin-top: 4px;"></div>

                        <!-- Tombol Bayar Midtrans Utama -->
                        <button type="submit" id="btnPagePayMidtrans" class="btn btn-primary btn-lg btn-block" style="margin-top: 4px;">
                            <span>Bayar Sekarang (Midtrans Snap)</span>
                            <?php echo digitalproduk_get_icon( 'arrow-right', '', 18 ); ?>
                        </button>

                        <!-- Fallback Direct Payment Button (Jika Popup Terblokir) -->
                        <a id="btnFallbackRedirect" href="#" target="_blank" class="btn btn-primary btn-block" style="display: none; text-align: center;">
                            Buka Halaman Pembayaran Midtrans &rarr;
                        </a>

                        <div style="text-align: center; margin: 10px 0 0; position: relative;">
                            <span style="background: #ffffff; padding: 0 10px; color: var(--text-muted); font-size: 0.775rem; font-weight: 600; font-family: var(--font-mono);">ATAU KONSULTASI ADMIN</span>
                            <div style="position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: var(--border-main); z-index: -1;"></div>
                        </div>

                        <!-- Fallback WhatsApp Direct -->
                        <a id="btnPageWhatsApp" href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo Indotech, saya ingin memesan: ' . $prod_title . ' seharga ' . digitalproduk_price( $prod_sale_price ) ); ?>" 
                           target="_blank" rel="noopener" class="btn btn-secondary btn-block">
                            <?php echo digitalproduk_get_icon( 'message-circle', '', 16 ); ?>
                            <span>Pesan via WhatsApp Admin</span>
                        </a>

                    </form>

                </div>
            </div>

        </div>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productsData = <?php echo wp_json_encode( $products_json_map ); ?>;
    const selector = document.getElementById('checkoutProductSelector');
    const hiddenId = document.getElementById('checkoutHiddenProductId');
    const titleEl = document.getElementById('summaryProductTitle');
    const saleEl = document.getElementById('summaryProductSale');
    const origEl = document.getElementById('summaryProductOrig');
    const imgEl = document.getElementById('summaryProductImg');
    const waBtn = document.getElementById('btnPageWhatsApp');

    // 1. Handle pergantian produk di dropdown
    if (selector) {
        selector.addEventListener('change', function() {
            const pId = this.value;
            const p = productsData[pId];
            if (p) {
                hiddenId.value = p.id;
                titleEl.textContent = p.title;
                saleEl.textContent = p.price_fmt;
                origEl.textContent = p.orig_fmt;
                imgEl.src = p.cover;
                imgEl.alt = p.title;

                const waPhone = '6281234567890';
                const msg = encodeURIComponent(`Halo Indotech, saya ingin memesan:\nProduk: ${p.title}\nHarga: ${p.price_fmt}\nMohon info pembayaran.`);
                waBtn.href = `https://wa.me/${waPhone}?text=${msg}`;
            }
        });
    }

    // 2. Handle form submit & Midtrans Snap
    const form = document.getElementById('dedicatedCheckoutForm');
    const btnPay = document.getElementById('btnPagePayMidtrans');
    const notice = document.getElementById('pageCheckoutNotice');
    const fallbackBtn = document.getElementById('btnFallbackRedirect');

    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            if (typeof dpm_vars === 'undefined') {
                alert('Midtrans Gateway plugin belum aktif.');
                return;
            }

            const productId = hiddenId.value;
            const name = document.getElementById('pageBuyerName').value.trim();
            const email = document.getElementById('pageBuyerEmail').value.trim();
            const phone = document.getElementById('pageBuyerPhone').value.trim();

            if (!productId || !name || !email) {
                alert('Harap lengkapi nama dan email Anda.');
                return;
            }

            btnPay.disabled = true;
            btnPay.innerHTML = '<span>Menyiapkan Pembayaran...</span>';
            notice.style.display = 'none';
            fallbackBtn.style.display = 'none';

            try {
                const formData = new URLSearchParams();
                formData.append('action', 'dpm_create_order');
                formData.append('nonce', dpm_vars.nonce);
                formData.append('product_id', productId);
                formData.append('name', name);
                formData.append('email', email);
                formData.append('phone', phone);

                const response = await fetch(dpm_vars.ajax_url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: formData.toString()
                });

                const res = await response.json();

                if (!res.success) {
                    notice.style.display = 'block';
                    notice.style.background = '#fef2f2';
                    notice.style.color = '#b91c1c';
                    notice.textContent = res.data?.message || 'Gagal memproses pesanan. Periksa konfigurasi Midtrans.';
                    btnPay.disabled = false;
                    btnPay.innerHTML = '<span>Bayar Sekarang (Midtrans Snap)</span>';
                    return;
                }

                const snapToken = res.data.snap_token;
                const redirectUrl = res.data.redirect;
                const createdOrderId = res.data.order_id;

                if (typeof window.snap !== 'undefined') {
                    window.snap.pay(snapToken, {
                        onSuccess: async function(result) {
                            notice.style.display = 'block';
                            notice.style.background = '#f0fdf4';
                            notice.style.color = '#15803d';
                            notice.textContent = 'Pembayaran berhasil! Mengalihkan ke halaman download file Anda...';
                            btnPay.disabled = true;
                            btnPay.innerHTML = '<span>Menyiapkan Akses Download...</span>';

                            // Konfirmasi ke server WordPress untuk update status & kirim email otomatis
                            try {
                                const confirmData = new URLSearchParams();
                                confirmData.append('action', 'dpm_confirm_payment');
                                confirmData.append('nonce', dpm_vars.nonce);
                                confirmData.append('order_id', createdOrderId);

                                const confRes = await fetch(dpm_vars.ajax_url, {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                    body: confirmData.toString()
                                });
                                const confJson = await confRes.json();
                                if (confJson.success && confJson.data?.redirect_url) {
                                    window.location.href = confJson.data.redirect_url;
                                    return;
                                }
                            } catch (e) {
                                console.error('Konfirmasi error:', e);
                            }

                            // Fallback direct redirect
                            window.location.href = '<?php echo esc_url( home_url( '/thank-you/' ) ); ?>?order_id=' + encodeURIComponent(createdOrderId);
                        },
                        onPending: function(result) {
                            notice.style.display = 'block';
                            notice.style.background = '#fffbeb';
                            notice.style.color = '#b45309';
                            notice.textContent = 'Menunggu pembayaran. Silakan selesaikan tagihan Anda sesuai instruksi Midtrans.';
                            btnPay.disabled = false;
                            btnPay.innerHTML = '<span>Cek Status Tagihan</span>';
                        },
                        onError: function(result) {
                            notice.style.display = 'block';
                            notice.style.background = '#fef2f2';
                            notice.style.color = '#b91c1c';
                            notice.textContent = 'Pembayaran dibatalkan atau terjadi kesalahan.';
                            btnPay.disabled = false;
                            btnPay.innerHTML = '<span>Coba Bayar Lagi</span>';
                        },
                        onClose: function() {
                            btnPay.disabled = false;
                            btnPay.innerHTML = '<span>Bayar Sekarang (Midtrans Snap)</span>';
                            if (redirectUrl) {
                                fallbackBtn.href = redirectUrl;
                                fallbackBtn.style.display = 'block';
                            }
                        }
                    });
                } else if (redirectUrl) {
                    window.location.href = redirectUrl;
                } else {
                    notice.style.display = 'block';
                    notice.style.background = '#fef2f2';
                    notice.style.color = '#b91c1c';
                    notice.textContent = 'Midtrans Snap library tidak dapat dimuat. Silakan gunakan opsi WhatsApp.';
                    btnPay.disabled = false;
                    btnPay.innerHTML = '<span>Bayar Sekarang (Midtrans Snap)</span>';
                }

            } catch (err) {
                notice.style.display = 'block';
                notice.style.background = '#fef2f2';
                notice.style.color = '#b91c1c';
                notice.textContent = 'Terjadi kesalahan jaringan. Silakan coba kembali.';
                btnPay.disabled = false;
                btnPay.innerHTML = '<span>Bayar Sekarang (Midtrans Snap)</span>';
            }
        });
    }
});
</script>

<?php
get_footer();
