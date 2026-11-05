<?php
/**
 * Reusable Checkout Modal Template Part
 *
 * @package DigitalProduk
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!-- Checkout Modal (Midtrans Snap & Direct Order) -->
<div class="modal-overlay" id="checkoutModal">
    <div class="modal-content">
        <button type="button" class="modal-close" id="modalClose" aria-label="Tutup">
            <?php echo digitalproduk_get_icon( 'x', '', 18 ); ?>
        </button>
        <div class="modal-header-sticker">
            <?php echo digitalproduk_get_icon( 'lock', '', 13 ); ?>
            <span>PEMBAYARAN RESMI &amp; AMAN</span>
        </div>
        <h3 style="font-family: var(--font-heading); margin-bottom: 0.5rem; font-size: 1.4rem;">Checkout Produk Digital</h3>
        <p style="color: var(--color-body-text); margin-bottom: 1.25rem; font-size: 0.925rem;">
            Pembayaran instan via Midtrans (QRIS, VA Bank, E-Wallet) dengan link download otomatis seketika.
        </p>
        
        <div style="background: var(--color-cream-bg); border: 2px solid var(--border-playful); border-radius: var(--radius-sm); padding: 1.15rem; margin-bottom: 1.35rem; box-shadow: 2px 2px 0px var(--border-playful);">
            <div style="font-size: 0.8rem; color: var(--color-text-muted); margin-bottom: 0.2rem;">Produk Dipilih:</div>
            <div id="modalProductTitle" style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.65rem; color: var(--color-dark-headline);">-</div>
            
            <div style="font-size: 0.8rem; color: var(--color-text-muted); margin-bottom: 0.2rem;">Total Investasi:</div>
            <div id="modalProductPrice" style="font-weight: 800; font-size: 1.4rem; color: var(--brand-blue-deep);">-</div>
        </div>

        <form id="midtransCheckoutForm" style="display: flex; flex-direction: column; gap: 0.85rem; margin-bottom: 1rem;">
            <input type="hidden" id="modalProductId" name="product_id" value="" />
            
            <div>
                <label for="buyerName" style="display: block; font-size: 0.825rem; color: var(--color-dark-headline); margin-bottom: 0.35rem; font-weight: 700;">Nama Lengkap</label>
                <input type="text" id="buyerName" name="name" required placeholder="Contoh: Budi Santoso" 
                    style="width: 100%; padding: 0.75rem 1rem; background: #fff; border: 2px solid var(--border-playful); border-radius: var(--radius-sm); color: #000; font-size: 0.95rem; font-family: inherit;" />
            </div>

            <div>
                <label for="buyerEmail" style="display: block; font-size: 0.825rem; color: var(--color-dark-headline); margin-bottom: 0.35rem; font-weight: 700;">Alamat Email (Pengiriman Link Download File)</label>
                <input type="email" id="buyerEmail" name="email" required placeholder="nama@email.com" 
                    style="width: 100%; padding: 0.75rem 1rem; background: #fff; border: 2px solid var(--border-playful); border-radius: var(--radius-sm); color: #000; font-size: 0.95rem; font-family: inherit;" />
            </div>

            <div>
                <label for="buyerPhone" style="display: block; font-size: 0.825rem; color: var(--color-dark-headline); margin-bottom: 0.35rem; font-weight: 700;">Nomor WhatsApp</label>
                <input type="tel" id="buyerPhone" name="phone" placeholder="08xxxxxxxxxx" 
                    style="width: 100%; padding: 0.75rem 1rem; background: #fff; border: 2px solid var(--border-playful); border-radius: var(--radius-sm); color: #000; font-size: 0.95rem; font-family: inherit;" />
            </div>

            <button type="submit" id="btnPayMidtrans" class="btn btn-primary btn-lg btn-block" style="margin-top: 0.5rem;">
                <span>Bayar Otomatis (Midtrans Snap)</span>
                <?php echo digitalproduk_get_icon( 'credit-card', 'btn-icon-right', 18 ); ?>
            </button>
        </form>

        <div style="text-align: center; margin: 0.75rem 0; font-size: 0.85rem; color: var(--color-text-muted);">
            <span>atau pesan konfirmasi manual</span>
        </div>

        <a id="modalBuyBtn" href="#" target="_blank" rel="noopener" class="btn btn-secondary btn-block" style="font-size: 0.9rem;">
            <?php echo digitalproduk_get_icon( 'message-circle', '', 16 ); ?>
            <span>Order via WhatsApp Admin</span>
        </a>
        
        <div id="checkoutNotice" style="margin-top: 0.75rem; font-size: 0.85rem; text-align: center; display: none;"></div>

        <div style="text-align: center; margin-top: 0.85rem;">
            <a id="modalFullPageCheckoutLink" href="<?php echo esc_url( home_url( '/checkout/' ) ); ?>" style="font-size: 0.85rem; font-weight: 800; color: #0284c7; text-decoration: underline;">
                Atau Buka Halaman Checkout Penuh &rarr;
            </a>
        </div>
    </div>
</div>
