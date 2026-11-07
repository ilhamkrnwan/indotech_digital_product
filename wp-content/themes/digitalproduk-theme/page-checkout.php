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

// 2. Tentukan produk yang dipilih (hanya jika ada ?product_id=X atau ?id=X valid)
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

// User harus memilih sendiri jika membuka /checkout/ tanpa membawa parameter produk
$prod_id = $current_product ? $current_product->ID : 0;
$prod_title = $current_product ? $current_product->post_title : '';
$prod_price = $current_product ? ( get_post_meta( $prod_id, '_price', true ) ?: 199000 ) : 0;
$prod_sale_price = $current_product ? ( get_post_meta( $prod_id, '_sale_price', true ) ?: $prod_price ) : 0;
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
    $f_meta = get_post_meta( $p_id, '_features', true ) ?: '';
    $f_list = ! empty( $f_meta ) ? ( is_array( $f_meta ) ? $f_meta : explode( "\n", $f_meta ) ) : [
        'Akses download via Google Drive',
        'Lisensi komersial (bebas untuk proyek klien)',
        'Update versi gratis'
    ];
    $products_json_map[ $p_id ] = [
        'id'          => $p_id,
        'title'       => $p->post_title,
        'price_fmt'   => digitalproduk_price( $p_sale ),
        'orig_fmt'    => ( $p_price > $p_sale ) ? digitalproduk_price( $p_price ) : '',
        'cover'       => digitalproduk_get_product_cover( $p_id ),
        'permalink'   => get_permalink( $p_id ),
        'features'    => array_values( array_filter( array_map( 'trim', (array) $f_list ) ) ),
    ];
}
?>

<main class="site-main checkout-page-main" style="background: var(--bg-canvas); min-height: 85vh; padding: 32px 0 64px; position: relative; overflow: hidden;">
    <!-- Abstract Brush & Wireframe Canvas for Checkout -->
    <div class="checkout-art-canvas" aria-hidden="true">
        <!-- Top Right Cobalt Splash (Organic Curved & Tapered) -->
        <svg class="checkout-stroke-splash" viewBox="0 0 450 300" fill="none">
            <path d="M120 35 C 160 18, 210 28, 255 16 C 300 6, 350 12, 395 28 C 430 42, 445 68, 448 95 C 450 125, 435 155, 415 180 C 385 215, 345 245, 305 235 C 270 225, 250 195, 240 165 C 230 135, 235 105, 215 80 C 190 52, 150 48, 120 35 Z" fill="#152cab" opacity="0.88" />
            <path d="M170 32 C 215 18, 270 24, 315 14 C 360 8, 400 20, 435 40 C 445 55, 445 80, 435 105 C 415 140, 375 168, 335 180 C 305 188, 285 170, 288 150 C 292 125, 310 100, 300 78 C 285 55, 235 48, 170 32 Z" fill="#2563eb" opacity="0.35" />
            <path d="M220 35 C 270 24, 330 38, 380 26 C 410 18, 430 32, 440 28 C 435 48, 395 55, 350 50 C 290 45, 240 60, 210 45 C 195 38, 205 28, 220 35 Z" fill="#f7d801" />
            <circle cx="210" cy="85" r="4.5" fill="#152cab" />
            <circle cx="185" cy="115" r="3" fill="#152cab" />
            <circle cx="255" cy="135" r="3.5" fill="#152cab" />
            <circle cx="240" cy="65" r="3" fill="#f7d801" />
        </svg>

        <!-- Left Wireframe Triangle -->
        <svg class="checkout-geo-triangle" viewBox="0 0 32 32" fill="none">
            <polygon points="16,3 29,27 3,27" stroke="#152cab" stroke-width="2.5" />
        </svg>

        <!-- Plus Marks -->
        <div class="checkout-geo-plus" style="top: 80px; left: 40px; color: #152cab; opacity: 0.20;">+</div>
        <div class="checkout-geo-plus" style="top: 140px; right: 460px; color: #f59e0b; opacity: 0.24;">+</div>
    </div>

    <div class="container" style="max-width: 1040px; position: relative; z-index: 10;">

        <!-- Back Link & Header -->
        <div style="margin-bottom: 24px;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; margin-bottom: 1rem;">
                <?php echo digitalproduk_get_icon( 'arrow-left', '', 14 ); ?>
                <span>Kembali ke Katalog</span>
            </a>

            <div class="hero-badge-artisan" style="margin-bottom: 0.75rem;">
                <div class="badge-brush-backing"></div>
                <span class="badge-brush-text">&bull; AMAN &amp; TERVERIFIKASI MIDTRANS</span>
            </div>

            <h1 class="checkout-main-title" style="font-size: 2.25rem; font-weight: 900; color: var(--text-primary); margin-bottom: 0.5rem; letter-spacing: -0.03em;">
                Checkout 
                <span class="brush-highlight-dynamic">
                    <span class="word-text">Pembayaran.</span>
                    <svg class="brush-svg-multi" viewBox="0 0 300 24" fill="none" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M4 16 C55 10 130 18 205 12 C250 8 285 13 296 10 C285 18 230 21 170 20 C100 19 45 21 8 18 C3 17 2 16 4 16 Z" fill="#f59e0b" opacity="0.85" />
                        <path d="M14 10 C65 6 150 12 225 8 C270 5 292 9 298 7 C288 15 235 17 180 16 C120 15 55 17 18 14 C10 13 8 10 14 10 Z" fill="#f7d801" />
                        <circle cx="295" cy="15" r="1.8" fill="#f59e0b" />
                    </svg>
                </span>
            </h1>
            <p style="font-size: 0.95rem; color: var(--text-secondary); margin: 0;">
                Selesaikan pembayaran otomatis menggunakan QRIS atau Virtual Account bank pilihan Anda.
            </p>
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
                        <label for="checkoutProductSelector" class="form-label" style="display: flex; align-items: center; justify-content: space-between;">
                            <span>Pilih Produk Digital: <span style="color: #ef4444;">*</span></span>
                            <?php if ( ! $current_product ) : ?>
                                <span style="font-size: 0.75rem; color: var(--brand-cobalt); font-weight: 600;">Wajib dipilih</span>
                            <?php endif; ?>
                        </label>
                        <select id="checkoutProductSelector" class="form-select" style="font-weight: 500;">
                            <option value="" disabled <?php echo ! $current_product ? 'selected' : ''; ?>>
                                -- Pilih Produk Digital yang Ingin Dibeli --
                            </option>
                            <?php foreach ( $all_products as $p ) : 
                                $is_sel = ( $current_product && $p->ID === $prod_id );
                                $p_sale = get_post_meta( $p->ID, '_sale_price', true ) ?: get_post_meta( $p->ID, '_price', true );
                            ?>
                                <option value="<?php echo esc_attr( $p->ID ); ?>" <?php selected( $is_sel ); ?>>
                                    <?php echo esc_html( $p->post_title ); ?> — <?php echo digitalproduk_price( $p_sale ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Empty State Placeholder (Tampil jika belum ada produk dipilih) -->
                    <div id="productSummaryPlaceholder" style="<?php echo $current_product ? 'display: none;' : 'display: block;'; ?> background: var(--bg-canvas); border: 1.5px dashed var(--border-main); border-radius: var(--radius-sm); padding: 24px 16px; text-align: center; margin-bottom: 16px;">
                        <div style="color: var(--brand-cobalt); margin-bottom: 8px; display: inline-flex;">
                            <?php echo digitalproduk_get_icon( 'shopping-bag', '', 32 ); ?>
                        </div>
                        <h3 style="font-size: 0.975rem; font-weight: 700; color: var(--text-primary); margin: 0 0 4px;">
                            Belum Ada Produk Dipilih
                        </h3>
                        <p style="font-size: 0.85rem; color: var(--text-secondary); margin: 0; line-height: 1.5;">
                            Silakan pilih produk digital pada menu dropdown di atas untuk melihat rincian pesanan dan total pembayaran.
                        </p>
                    </div>

                    <!-- Selected Product Display -->
                    <div id="productSummaryCard" style="<?php echo $current_product ? 'display: flex;' : 'display: none;'; ?> gap: 14px; align-items: center; background: var(--bg-canvas); border: 1px solid var(--border-main); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 16px;">
                        <img id="summaryProductImg" src="<?php echo esc_url( $prod_cover ); ?>" alt="<?php echo esc_attr( $prod_title ); ?>" style="width: 70px; height: 70px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--border-main); background: #fff;" />
                        <div style="flex: 1;">
                            <h3 id="summaryProductTitle" style="font-size: 1rem; font-weight: 700; margin: 0 0 4px; color: var(--text-primary);">
                                <?php echo esc_html( $prod_title ); ?>
                            </h3>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div class="price-brush-tag">
                                    <svg class="price-brush-bg" viewBox="0 0 120 30" fill="none" preserveAspectRatio="none" aria-hidden="true">
                                        <path d="M2 18 C25 10 65 20 110 14 C118 13 119 18 116 22 C90 26 50 25 10 24 C4 23 1 20 2 18 Z" fill="#f7d801" />
                                        <path d="M8 12 C35 6 75 14 112 10" stroke="#fef08a" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    <span id="summaryProductSale" class="price-val-bold" style="font-size: 1.15rem;">
                                        <?php echo $current_product ? digitalproduk_price( $prod_sale_price ) : ''; ?>
                                    </span>
                                </div>
                                <span id="summaryProductOrig" style="<?php echo ( $current_product && $prod_price > $prod_sale_price ) ? 'display: inline;' : 'display: none;'; ?> font-size: 0.825rem; text-decoration: line-through; color: var(--text-muted);">
                                    <?php echo ( $current_product && $prod_price > $prod_sale_price ) ? digitalproduk_price( $prod_price ) : ''; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <ul id="summaryProductFeatures" style="list-style: none; padding: 0; margin: 0 0 16px; display: <?php echo $current_product ? 'grid' : 'none'; ?>; gap: 6px;">
                        <?php if ( $current_product ) : foreach ( $prod_features as $feat ) : ?>
                            <li style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--text-secondary);">
                                <span style="color: var(--brand-cobalt); display: inline-flex;"><?php echo digitalproduk_get_icon( 'check', '', 14 ); ?></span>
                                <span><?php echo esc_html( trim( $feat ) ); ?></span>
                            </li>
                        <?php endforeach; endif; ?>
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
                        <input type="hidden" id="checkoutHiddenProductId" name="product_id" value="<?php echo esc_attr( $prod_id ?: '' ); ?>" />

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

    const placeholderEl = document.getElementById('productSummaryPlaceholder');
    const cardEl = document.getElementById('productSummaryCard');
    const featuresEl = document.getElementById('summaryProductFeatures');

    if (selector) {
        selector.addEventListener('change', function() {
            const pId = this.value;
            const p = productsData[pId];
            if (p) {
                hiddenId.value = p.id;
                titleEl.textContent = p.title;
                saleEl.textContent = p.price_fmt;

                if (origEl) {
                    if (p.orig_fmt) {
                        origEl.textContent = p.orig_fmt;
                        origEl.style.display = 'inline';
                    } else {
                        origEl.textContent = '';
                        origEl.style.display = 'none';
                    }
                }

                imgEl.src = p.cover;
                imgEl.alt = p.title;

                // Update features list
                if (featuresEl) {
                    if (p.features && p.features.length > 0) {
                        featuresEl.innerHTML = p.features.map(function(feat) {
                            return '<li style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--text-secondary);">' +
                                '<span style="color: var(--brand-cobalt); display: inline-flex;">' +
                                '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>' +
                                '</span>' +
                                '<span>' + feat + '</span>' +
                                '</li>';
                        }).join('');
                        featuresEl.style.display = 'grid';
                    } else {
                        featuresEl.style.display = 'none';
                    }
                }

                if (placeholderEl) placeholderEl.style.display = 'none';
                if (cardEl) cardEl.style.display = 'flex';
                if (notice) notice.style.display = 'none';

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

            if (!productId) {
                notice.style.display = 'block';
                notice.style.background = '#fef2f2';
                notice.style.border = '1px solid #fecaca';
                notice.style.color = '#b91c1c';
                notice.textContent = 'Silakan pilih produk digital yang ingin Anda beli pada menu dropdown terlebih dahulu.';
                selector.focus();
                selector.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            if (!name || !email) {
                notice.style.display = 'block';
                notice.style.background = '#fef2f2';
                notice.style.border = '1px solid #fecaca';
                notice.style.color = '#b91c1c';
                notice.textContent = 'Harap lengkapi nama lengkap dan alamat email Anda.';
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
