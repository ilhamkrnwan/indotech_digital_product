<?php
/**
 * Template Name: Checkout Pembayaran Khusus
 * Template Post Type: page
 * Clean, direct, utilitarian
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

$features_meta = $current_product ? get_post_meta( $prod_id, '_features', true ) : '';
$prod_features = ! empty( $features_meta ) ? ( is_array( $features_meta ) ? $features_meta : explode( "\n", $features_meta ) ) : [
    'Akses download via Google Drive',
    'Lisensi komersial (bebas untuk proyek klien)',
    'Update versi gratis'
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

<main class="site-main checkout-page-main" style="background: var(--bg-canvas); min-height: 85vh; padding: 32px 0 64px;">
    <div class="container" style="max-width: 1040px;">

        <!-- Back Link -->
        <div style="margin-bottom: 20px;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
                <?php echo digitalproduk_get_icon( 'arrow-left', '', 14 ); ?>
                <span>Kembali ke Katalog</span>
            </a>
        </div>

        <div class="checkout-grid">

            <!-- LEFT COLUMN: Rincian Produk -->
            <div class="checkout-left-col">
                <div class="checkout-card">
                    <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">
                        Ringkasan Pesanan
                    </h2>

                    <!-- Dropdown Pilih Produk -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label for="checkoutProductSelector" class="form-label">
                            Produk:
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

                    <!-- Selected Product Display -->
                    <div id="productSummaryCard" style="display: flex; gap: 14px; align-items: center; background: var(--bg-canvas); border: 1px solid var(--border-main); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 16px;">
                        <img id="summaryProductImg" src="<?php echo esc_url( $prod_cover ); ?>" alt="<?php echo esc_attr( $prod_title ); ?>" style="width: 70px; height: 70px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--border-main); background: #fff;" />
                        <div style="flex: 1;">
                            <h3 id="summaryProductTitle" style="font-size: 1rem; font-weight: 700; margin: 0 0 4px; color: var(--text-primary);">
                                <?php echo esc_html( $prod_title ); ?>
                            </h3>
                            <div style="display: flex; align-items: baseline; gap: 8px;">
                                <span id="summaryProductSale" style="font-size: 1.2rem; font-weight: 800; color: var(--text-primary);">
                                    <?php echo digitalproduk_price( $prod_sale_price ); ?>
                                </span>
                                <?php if ( $prod_price > $prod_sale_price ) : ?>
                                    <span id="summaryProductOrig" style="font-size: 0.825rem; text-decoration: line-through; color: var(--text-muted);">
                                        <?php echo digitalproduk_price( $prod_price ); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <ul style="list-style: none; padding: 0; margin: 0 0 16px; display: grid; gap: 6px;">
                        <?php foreach ( $prod_features as $feat ) : ?>
                            <li style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--text-secondary);">
                                <span style="color: var(--brand-cobalt); display: inline-flex;"><?php echo digitalproduk_get_icon( 'check', '', 14 ); ?></span>
                                <span><?php echo esc_html( trim( $feat ) ); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">
                        Setelah pembayaran berhasil, link unduh langsung aktif di browser dan salinannya dikirim ke email Anda.
                    </p>
                </div>
            </div>

            <!-- RIGHT COLUMN: Form Data Pembeli -->
            <div class="checkout-right-col">
                <div class="checkout-card">
                    <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Data Pembeli
                    </h2>
                    <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 1.25rem;">
                        File digital akan dikirim ke alamat email di bawah.
                    </p>

                    <form id="dedicatedCheckoutForm" method="post" style="display: grid; gap: 12px;">
                        <input type="hidden" id="checkoutHiddenProductId" name="product_id" value="<?php echo esc_attr( $prod_id ); ?>" />

                        <div>
                            <label for="pageBuyerName" class="form-label">
                                Nama Lengkap <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" id="pageBuyerName" name="name" required placeholder="Nama Anda" class="form-input" />
                        </div>

                        <div>
                            <label for="pageBuyerEmail" class="form-label">
                                Alamat Email <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="email" id="pageBuyerEmail" name="email" required placeholder="email@domain.com" class="form-input" />
                        </div>

                        <div>
                            <label for="pageBuyerPhone" class="form-label">
                                Nomor WhatsApp
                            </label>
                            <input type="tel" id="pageBuyerPhone" name="phone" placeholder="08xxxxxxxxxx" class="form-input" />
                        </div>

                        <!-- Notice Container -->
                        <div id="pageCheckoutNotice" style="display: none; padding: 10px; border-radius: var(--radius-sm); font-size: 0.85rem; margin-top: 4px;"></div>

                        <!-- Tombol Bayar -->
                        <button type="submit" id="btnPagePayMidtrans" class="btn btn-primary btn-lg btn-block" style="margin-top: 6px;">
                            <span>Bayar Sekarang (Midtrans)</span>
                        </button>

                        <a id="btnFallbackRedirect" href="#" target="_blank" class="btn btn-primary btn-block" style="display: none; text-align: center;">
                            Buka Pembayaran Midtrans &rarr;
                        </a>

                        <div style="text-align: center; margin-top: 8px;">
                            <a id="btnPageWhatsApp" href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo Indotech, saya ingin pesan: ' . $prod_title ); ?>" 
                               target="_blank" rel="noopener" style="font-size: 0.825rem; color: var(--text-muted); display: inline-flex; align-items: center; gap: 4px;">
                                <?php echo digitalproduk_get_icon( 'message-circle', '', 14 ); ?>
                                <span>Bantuan / Pesan Manual via WhatsApp</span>
                            </a>
                        </div>
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

    if (selector) {
        selector.addEventListener('change', function() {
            const pId = this.value;
            const p = productsData[pId];
            if (p) {
                hiddenId.value = p.id;
                titleEl.textContent = p.title;
                saleEl.textContent = p.price_fmt;
                if (origEl) origEl.textContent = p.orig_fmt;
                imgEl.src = p.cover;
                imgEl.alt = p.title;

                const waPhone = '6281234567890';
                const msg = encodeURIComponent(`Halo Indotech, saya ingin pesan:\nProduk: ${p.title}\nHarga: ${p.price_fmt}`);
                waBtn.href = `https://wa.me/${waPhone}?text=${msg}`;
            }
        });
    }

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
                    btnPay.innerHTML = '<span>Bayar Sekarang (Midtrans)</span>';
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
                            notice.textContent = 'Pembayaran berhasil! Mengalihkan ke halaman download...';
                            btnPay.disabled = true;

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

                            window.location.href = '<?php echo esc_url( home_url( '/thank-you/' ) ); ?>?order_id=' + encodeURIComponent(createdOrderId);
                        },
                        onPending: function(result) {
                            notice.style.display = 'block';
                            notice.style.background = '#fffbeb';
                            notice.style.color = '#b45309';
                            notice.textContent = 'Menunggu pembayaran. Silakan selesaikan tagihan Anda.';
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
                            btnPay.innerHTML = '<span>Bayar Sekarang (Midtrans)</span>';
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
                    notice.textContent = 'Midtrans Snap tidak dapat dimuat. Gunakan WhatsApp untuk bantuan.';
                    btnPay.disabled = false;
                    btnPay.innerHTML = '<span>Bayar Sekarang (Midtrans)</span>';
                }

            } catch (err) {
                notice.style.display = 'block';
                notice.style.background = '#fef2f2';
                notice.style.color = '#b91c1c';
                notice.textContent = 'Terjadi kesalahan jaringan. Silakan coba kembali.';
                btnPay.disabled = false;
                btnPay.innerHTML = '<span>Bayar Sekarang (Midtrans)</span>';
            }
        });
    }
});
</script>

<?php
get_footer();
