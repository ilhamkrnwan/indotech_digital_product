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

<main class="site-main checkout-page-main">
    <div class="container checkout-container">

        <!-- Top Breadcrumb Navigation -->
        <div class="checkout-breadcrumb-bar">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="checkout-back-link">
                <?php echo digitalproduk_get_icon( 'arrow-left', '', 14 ); ?>
                <span>Kembali ke Katalog</span>
            </a>
        </div>

        <!-- Checkout Header -->
        <div class="checkout-header-block">
            <div class="checkout-badge-pill">
                <?php echo digitalproduk_get_icon( 'shield-check', '', 14 ); ?>
                <span class="badge-text">PEMBAYARAN RESMI &bull; MIDTRANS SNAP AUTOMATION</span>
            </div>

            <h1 class="checkout-main-title">
                Checkout <span class="hero-title-gradient">Pembayaran</span>
            </h1>
            <p class="checkout-subtitle">
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
                                <span style="font-size: 0.75rem; color: var(--brand-blue); font-weight: 600;">Wajib dipilih</span>
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
                                    <?php echo esc_html( $p->post_title ); ?>: <?php echo digitalproduk_price( $p_sale ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Empty State Placeholder (Tampil jika belum ada produk dipilih) -->
                    <div id="productSummaryPlaceholder" style="<?php echo $current_product ? 'display: none;' : 'display: block;'; ?> background: var(--bg-canvas); border: 1.5px dashed var(--border-main); border-radius: var(--radius-sm); padding: 24px 16px; text-align: center; margin-bottom: 16px;">
                        <div style="color: var(--brand-blue); margin-bottom: 8px; display: inline-flex;">
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
                            <div style="display: flex; align-items: baseline; gap: 8px;">
                                <span id="summaryProductSale" class="price-val-bold" style="font-size: 1.25rem; color: var(--brand-navy);">
                                    <?php echo $current_product ? digitalproduk_price( $prod_sale_price ) : ''; ?>
                                </span>
                                <span id="summaryProductOrig" style="<?php echo ( $current_product && $prod_price > $prod_sale_price ) ? 'display: inline;' : 'display: none;'; ?> font-size: 0.825rem; text-decoration: line-through; color: var(--text-muted);">
                                    <?php echo ( $current_product && $prod_price > $prod_sale_price ) ? digitalproduk_price( $prod_price ) : ''; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Transparent Price Breakdown Box -->
                    <div id="summaryPriceBreakdown" style="<?php echo $current_product ? 'display: block;' : 'display: none;'; ?> background: #f8fafc; border: 1px solid var(--border-main); border-radius: var(--radius-sm); padding: 12px 14px; margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 6px;">
                            <span>Harga Produk:</span>
                            <span id="breakdownSubtotal" style="font-weight: 600; color: var(--text-primary);"><?php echo $current_product ? digitalproduk_price( $prod_sale_price ) : 'Rp 0'; ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px;">
                            <span>Biaya Gateway Midtrans:</span>
                            <span style="font-weight: 600; color: var(--brand-lime);">Rp 0 (Gratis)</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.95rem; font-weight: 800; color: var(--brand-navy); border-top: 1px dashed var(--border-main); padding-top: 8px;">
                            <span>Total Tagihan:</span>
                            <span id="breakdownTotal" style="color: var(--brand-blue); font-size: 1.1rem;"><?php echo $current_product ? digitalproduk_price( $prod_sale_price ) : 'Rp 0'; ?></span>
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
                        <button type="submit" id="btnPagePay" class="btn btn-primary btn-lg btn-block" style="margin-top: 6px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <?php echo digitalproduk_get_icon( 'lock', '', 16 ); ?>
                            <span>Lanjut ke Pembayaran Otomatis</span>
                        </button>

                        <div class="checkout-gateways-strip" style="display: flex; align-items: center; justify-content: center; gap: 8px; flex-wrap: wrap; margin-top: 12px; padding: 10px; background: #f8fafc; border: 1px solid var(--border-main); border-radius: var(--radius-sm);">
                            <span style="font-size: 0.72rem; color: var(--text-muted); font-weight: 600;">METODE PEMBAYARAN:</span>
                            <span class="badge-item" style="font-size: 0.68rem; padding: 2px 6px; background: #fff; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: 700;">QRIS</span>
                            <span class="badge-item" style="font-size: 0.68rem; padding: 2px 6px; background: #fff; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: 700;">BCA VA</span>
                            <span class="badge-item" style="font-size: 0.68rem; padding: 2px 6px; background: #fff; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: 700;">Mandiri</span>
                            <span class="badge-item" style="font-size: 0.68rem; padding: 2px 6px; background: #fff; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: 700;">BNI</span>
                            <span class="badge-item" style="font-size: 0.68rem; padding: 2px 6px; background: #fff; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: 700;">BRI</span>
                        </div>

                        <a id="btnFallbackRedirect" href="#" target="_blank" class="btn btn-primary btn-block" style="display: none; text-align: center;">
                            Buka Pembayaran &rarr;
                        </a>

                        <div style="text-align: center; margin-top: 8px;">
                            <a id="btnPageWhatsApp" href="https://wa.me/6281234567890?text=<?php echo urlencode( 'Halo indotechnology, saya ingin pesan: ' . $prod_title ); ?>" 
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
    const breakdownBox = document.getElementById('summaryPriceBreakdown');
    const breakdownSub = document.getElementById('breakdownSubtotal');
    const breakdownTot = document.getElementById('breakdownTotal');

    if (selector) {
        selector.addEventListener('change', function() {
            const pId = this.value;
            const p = productsData[pId];
            if (p) {
                hiddenId.value = p.id;
                titleEl.textContent = p.title;
                saleEl.textContent = p.price_fmt;

                if (breakdownSub) breakdownSub.textContent = p.price_fmt;
                if (breakdownTot) breakdownTot.textContent = p.price_fmt;
                if (breakdownBox) breakdownBox.style.display = 'block';

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
                        featuresEl.replaceChildren();
                        p.features.forEach(function(feat) {
                            const item = document.createElement('li');
                            const iconWrap = document.createElement('span');
                            const icon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                            const path = document.createElementNS('http://www.w3.org/2000/svg', 'polyline');
                            const label = document.createElement('span');

                            item.style.cssText = 'display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--text-secondary);';
                            iconWrap.style.cssText = 'color: var(--brand-cobalt); display: inline-flex;';
                            icon.setAttribute('width', '14');
                            icon.setAttribute('height', '14');
                            icon.setAttribute('viewBox', '0 0 24 24');
                            icon.setAttribute('fill', 'none');
                            icon.setAttribute('stroke', 'currentColor');
                            icon.setAttribute('stroke-width', '2');
                            icon.setAttribute('stroke-linecap', 'round');
                            icon.setAttribute('stroke-linejoin', 'round');
                            icon.setAttribute('aria-hidden', 'true');
                            path.setAttribute('points', '20 6 9 17 4 12');
                            label.textContent = feat;

                            icon.appendChild(path);
                            iconWrap.appendChild(icon);
                            item.append(iconWrap, label);
                            featuresEl.appendChild(item);
                        });
                        featuresEl.style.display = 'grid';
                    } else {
                        featuresEl.style.display = 'none';
                    }
                }

                if (placeholderEl) placeholderEl.style.display = 'none';
                if (cardEl) cardEl.style.display = 'flex';
                if (notice) notice.style.display = 'none';

                const waPhone = '6281234567890';
                const msg = encodeURIComponent(`Halo indotechnology, saya ingin pesan:\nProduk: ${p.title}\nHarga: ${p.price_fmt}`);
                waBtn.href = `https://wa.me/${waPhone}?text=${msg}`;
            }
        });
    }

    const form = document.getElementById('dedicatedCheckoutForm');
    const btnPay = document.getElementById('btnPagePay');
    const notice = document.getElementById('pageCheckoutNotice');
    const fallbackBtn = document.getElementById('btnFallbackRedirect');

    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            if (typeof dpm_vars === 'undefined') {
                alert('Sistem pembayaran belum aktif.');
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
                    notice.textContent = res.data?.message || 'Gagal memproses pesanan. Silakan coba kembali.';
                    btnPay.disabled = false;
                    btnPay.innerHTML = '<span>Bayar Sekarang</span>';
                    return;
                }

                const snapToken = res.data.snap_token;
                const redirectUrl = res.data.redirect;
                const createdOrderId = res.data.order_id;
                const downloadToken = res.data.download_token || '';

                if (typeof window.snap !== 'undefined') {
                    window.snap.pay(snapToken, {
                        onSuccess: async function(result) {
                            notice.style.display = 'block';
                            notice.style.background = '#f0fdf4';
                            notice.style.color = '#15803d';
                            notice.textContent = 'Pembayaran terdeteksi! Memverifikasi status ke gateway...';
                            btnPay.disabled = true;

                            try {
                                const confirmData = new URLSearchParams();
                                confirmData.append('action', 'dpm_confirm_payment');
                                confirmData.append('nonce', dpm_vars.nonce);
                                confirmData.append('order_id', createdOrderId);
                                confirmData.append('token', downloadToken);

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

                            window.location.href = '<?php echo esc_url( home_url( '/thank-you/' ) ); ?>?order_id=' + encodeURIComponent(createdOrderId) + '&token=' + encodeURIComponent(downloadToken);
                        },
                        onPending: function(result) {
                            notice.style.display = 'block';
                            notice.style.background = '#fffbeb';
                            notice.style.color = '#b45309';
                            notice.textContent = 'Menunggu pembayaran. Mengalihkan ke ringkasan pesanan...';
                            btnPay.disabled = true;
                            setTimeout(() => {
                                window.location.href = '<?php echo esc_url( home_url( '/thank-you/' ) ); ?>?order_id=' + encodeURIComponent(createdOrderId) + '&token=' + encodeURIComponent(downloadToken);
                            }, 1200);
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
                            btnPay.innerHTML = '<span>Bayar Sekarang</span>';
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
                    notice.textContent = 'Popup pembayaran tidak dapat dimuat. Gunakan WhatsApp untuk bantuan.';
                    btnPay.disabled = false;
                    btnPay.innerHTML = '<span>Bayar Sekarang</span>';
                }

            } catch (err) {
                notice.style.display = 'block';
                notice.style.background = '#fef2f2';
                notice.style.color = '#b91c1c';
                notice.textContent = 'Terjadi kesalahan jaringan. Silakan coba kembali.';
                btnPay.disabled = false;
                btnPay.innerHTML = '<span>Bayar Sekarang</span>';
            }
        });
    }
});
</script>

<?php
get_footer();
