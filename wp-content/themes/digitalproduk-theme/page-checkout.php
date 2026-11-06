<?php
/**
 * Template Name: Checkout Pembayaran Khusus
 * Template Post Type: page
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
    'Lisensi Komersial Lengkap',
    'Update Gratis Versi Mendatang',
    'Dukungan Bantuan Teknis'
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

<main class="site-main checkout-page-main" style="background: #fdfbf7; min-height: 85vh; padding: 40px 0 80px;">
    <div class="container">

        <!-- Top Breadcrumb / Back Link -->
        <div style="margin-bottom: 24px;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 8px;">
                <?php echo digitalproduk_get_icon( 'arrow-left', '', 16 ); ?>
                <span>Kembali ke Katalog Produk</span>
            </a>
        </div>

        <div class="checkout-grid" style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 32px; align-items: start;">

            <!-- LEFT COLUMN: Rincian Produk & Garansi -->
            <div class="checkout-left-col">
                <div class="card neo-card" style="background: #fff; border: 3px solid #1e293b; border-radius: 16px; padding: 28px; box-shadow: 6px 6px 0 #1e293b; margin-bottom: 24px;">
                    
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border-bottom: 2px dashed #cbd5e1; padding-bottom: 16px;">
                        <div>
                            <span style="font-size: 0.85rem; font-weight: 800; background: #fef08a; border: 2px solid #1e293b; padding: 4px 10px; border-radius: 999px; text-transform: uppercase;">
                                Ringkasan Pesanan
                            </span>
                            <h1 style="font-size: 1.6rem; font-weight: 800; margin: 10px 0 0; color: #0f172a;">Selesaikan Pembelian</h1>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 0.8rem; color: #64748b; font-weight: 600;">Status:</span>
                            <div style="display: flex; align-items: center; gap: 6px; color: #16a34a; font-weight: 800; font-size: 0.9rem;">
                                <span style="width: 8px; height: 8px; border-radius: 50%; background: #16a34a; display: inline-block;"></span>
                                Ready Instant
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Pilih Produk (Bisa Ganti Tanpa Reload) -->
                    <div style="margin-bottom: 24px;">
                        <label for="checkoutProductSelector" style="display: block; font-weight: 700; font-size: 0.9rem; margin-bottom: 8px; color: #334155;">
                            Pilihan Produk Digital:
                        </label>
                        <select id="checkoutProductSelector" style="width: 100%; padding: 12px 14px; font-size: 0.95rem; font-weight: 700; border: 2px solid #1e293b; border-radius: 10px; background: #f8fafc; cursor: pointer;">
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
                    <div id="productSummaryCard" style="display: flex; gap: 20px; align-items: center; background: #fffbeb; border: 2.5px solid #1e293b; border-radius: 12px; padding: 16px; margin-bottom: 24px;">
                        <img id="summaryProductImg" src="<?php echo esc_url( $prod_cover ); ?>" alt="<?php echo esc_attr( $prod_title ); ?>" style="width: 90px; height: 90px; object-fit: cover; border: 2px solid #1e293b; border-radius: 8px; background: #fff;" />
                        <div style="flex: 1;">
                            <h3 id="summaryProductTitle" style="font-size: 1.15rem; font-weight: 800; margin: 0 0 6px; color: #0f172a; line-height: 1.3;">
                                <?php echo esc_html( $prod_title ); ?>
                            </h3>
                            <div style="display: flex; align-items: baseline; gap: 10px;">
                                <span id="summaryProductSale" style="font-size: 1.4rem; font-weight: 900; color: #0284c7;">
                                    <?php echo digitalproduk_price( $prod_sale_price ); ?>
                                </span>
                                <span id="summaryProductOrig" style="font-size: 0.95rem; text-decoration: line-through; color: #94a3b8; font-weight: 600;">
                                    <?php echo digitalproduk_price( $prod_price ); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Benefits Included -->
                    <div style="margin-bottom: 24px;">
                        <h4 style="font-size: 0.95rem; font-weight: 800; margin: 0 0 12px; color: #334155; display: flex; align-items: center; gap: 8px;">
                            <?php echo digitalproduk_get_icon( 'check-circle-2', '', 18 ); ?>
                            <span>Yang Anda Dapatkan Dalam Paket Ini:</span>
                        </h4>
                        <ul style="list-style: none; padding: 0; margin: 0; display: grid; gap: 8px;">
                            <?php foreach ( $prod_features as $feat ) : ?>
                                <li style="display: flex; align-items: center; gap: 10px; font-size: 0.92rem; font-weight: 600; color: #334155;">
                                    <span style="color: #16a34a; display: inline-flex;"><?php echo digitalproduk_get_icon( 'check', '', 16 ); ?></span>
                                    <span><?php echo esc_html( trim( $feat ) ); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Trust Bar -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; background: #f1f5f9; padding: 14px; border-radius: 10px; border: 1.5px solid #cbd5e1;">
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #1e293b;">
                            <?php echo digitalproduk_get_icon( 'shield-check', '', 20 ); ?>
                            <span>Enkripsi 256-bit SSL</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: #1e293b;">
                            <?php echo digitalproduk_get_icon( 'zap', '', 20 ); ?>
                            <span>Pengiriman Otomatis</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- RIGHT COLUMN: Form Checkout & Pembayaran Midtrans -->
            <div class="checkout-right-col">
                <div class="card neo-card" style="background: #fff; border: 3px solid #1e293b; border-radius: 16px; padding: 28px; box-shadow: 6px 6px 0 #1e293b;">
                    
                    <div style="margin-bottom: 20px;">
                        <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem; font-weight: 800; background: #e0f2fe; color: #0284c7; border: 2px solid #1e293b; padding: 3px 10px; border-radius: 999px; margin-bottom: 8px;">
                            <?php echo digitalproduk_get_icon( 'lock', '', 12 ); ?>
                            PEMBAYARAN RESMI MIDTRANS
                        </span>
                        <h2 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: #0f172a;">Informasi Pengiriman</h2>
                        <p style="margin: 4px 0 0; font-size: 0.88rem; color: #64748b;">
                            File dan akses digital akan dikirimkan otomatis ke email ini setelah pembayaran berhasil.
                        </p>
                    </div>

                    <form id="dedicatedCheckoutForm" method="post" style="display: grid; gap: 16px;">
                        
                        <input type="hidden" id="checkoutHiddenProductId" name="product_id" value="<?php echo esc_attr( $prod_id ); ?>" />

                        <div>
                            <label for="pageBuyerName" style="display: block; font-weight: 700; font-size: 0.9rem; margin-bottom: 6px; color: #1e293b;">
                                Nama Lengkap <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" id="pageBuyerName" name="name" required placeholder="Contoh: Budi Santoso" 
                                style="width: 100%; padding: 12px 14px; font-size: 0.95rem; font-weight: 600; border: 2px solid #1e293b; border-radius: 10px; outline: none; background: #fff;" />
                        </div>

                        <div>
                            <label for="pageBuyerEmail" style="display: block; font-weight: 700; font-size: 0.9rem; margin-bottom: 6px; color: #1e293b;">
                                Alamat Email Aktif <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="email" id="pageBuyerEmail" name="email" required placeholder="email.anda@gmail.com" 
                                style="width: 100%; padding: 12px 14px; font-size: 0.95rem; font-weight: 600; border: 2px solid #1e293b; border-radius: 10px; outline: none; background: #fff;" />
                            <small style="font-size: 0.78rem; color: #64748b; margin-top: 4px; display: block;">Pastikan email benar &amp; aktif untuk menerima file/link.</small>
                        </div>

                        <div>
                            <label for="pageBuyerPhone" style="display: block; font-weight: 700; font-size: 0.9rem; margin-bottom: 6px; color: #1e293b;">
                                Nomor WhatsApp <span style="font-size: 0.8rem; font-weight: normal; color: #64748b;">(Disarankan)</span>
                            </label>
                            <input type="tel" id="pageBuyerPhone" name="phone" placeholder="08xxxxxxxxxx" 
                                style="width: 100%; padding: 12px 14px; font-size: 0.95rem; font-weight: 600; border: 2px solid #1e293b; border-radius: 10px; outline: none; background: #fff;" />
                        </div>

                        <!-- Midtrans Accepted Methods Banner -->
                        <div style="background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 10px; padding: 12px; margin-top: 4px;">
                            <span style="font-size: 0.78rem; font-weight: 700; color: #475569; display: block; margin-bottom: 6px; text-transform: uppercase;">Metode Pembayaran Yang Didukung:</span>
                            <div style="font-size: 0.85rem; font-weight: 700; color: #1e293b; display: flex; flex-wrap: wrap; gap: 8px;">
                                <span style="background: #e2e8f0; padding: 3px 8px; border-radius: 6px;">QRIS (All E-Wallet)</span>
                                <span style="background: #e2e8f0; padding: 3px 8px; border-radius: 6px;">GoPay</span>
                                <span style="background: #e2e8f0; padding: 3px 8px; border-radius: 6px;">ShopeePay</span>
                                <span style="background: #e2e8f0; padding: 3px 8px; border-radius: 6px;">BCA / Mandiri / BNI / BRI VA</span>
                                <span style="background: #e2e8f0; padding: 3px 8px; border-radius: 6px;">Kartu Kredit</span>
                            </div>
                        </div>

                        <!-- Notice Container -->
                        <div id="pageCheckoutNotice" style="display: none; padding: 12px; border-radius: 8px; font-weight: 700; font-size: 0.9rem; border: 2px solid currentColor; margin-top: 4px;"></div>

                        <!-- Tombol Bayar Midtrans Utama -->
                        <button type="submit" id="btnPagePayMidtrans" class="btn btn-primary" style="width: 100%; padding: 16px; font-size: 1.15rem; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; border-radius: 12px;">
                            <span>Bayar Sekarang (Midtrans Snap)</span>
                            <?php echo digitalproduk_get_icon( 'arrow-right', '', 20 ); ?>
                        </button>

                        <!-- Fallback Direct Payment Button (Jika Popup Terblokir) -->
                        <a id="btnFallbackRedirect" href="#" target="_blank" style="display: none; text-align: center; padding: 12px; background: #0284c7; color: #fff; font-weight: 800; border-radius: 10px; text-decoration: none; border: 2px solid #1e293b;">
                            Buka Halaman Pembayaran Midtrans &rarr;
                        </a>

                        <div style="text-align: center; margin: 10px 0 0; position: relative;">
                            <span style="background: #fff; padding: 0 10px; color: #94a3b8; font-size: 0.8rem; font-weight: 700;">ATAU PESAN MANUAL</span>
                            <div style="position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #e2e8f0; z-index: -1;"></div>
                        </div>

                        <!-- Fallback WhatsApp Direct -->
                        <a id="btnPageWhatsApp" href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo DigitalProduk, saya ingin memesan: ' . $prod_title . ' seharga ' . digitalproduk_price( $prod_sale_price ) ); ?>" 
                           target="_blank" rel="noopener" class="btn btn-secondary" style="width: 100%; padding: 12px; font-size: 0.95rem; font-weight: 700; text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; border-radius: 10px;">
                            <?php echo digitalproduk_get_icon( 'message-circle', '', 18 ); ?>
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
                const msg = encodeURIComponent(`Halo DigitalProduk, saya ingin memesan:\nProduk: ${p.title}\nHarga: ${p.price_fmt}\nMohon info pembayaran.`);
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
                    // Jika script snap.js terhalang blocker/adblock, redirect langsung ke Midtrans Hosted Payment page
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

