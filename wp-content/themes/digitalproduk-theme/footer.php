</main><!-- #primary -->

<footer class="site-footer">
    <div class="container footer-container">
        <div class="footer-grid">
            <div class="footer-col brand-col">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand" style="margin-bottom: 0.75rem;">
                    <span class="brand-title">Indotech</span>
                </a>
                <p class="footer-desc">
                    Source code web apps, plugin WordPress, dan template desain siap pakai. Akses download langsung aktif setelah pembayaran via Midtrans.
                </p>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Navigasi</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a></li>
                    <li><a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>">Semua Produk</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/#cara-kerja' ) ); ?>">Cara Beli</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>">FAQ</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/checkout/' ) ); ?>">Checkout</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Kategori</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/source-code/' ) ); ?>">Source Code</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/ui-ux-figma/' ) ); ?>">UI/UX &amp; Figma</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/template-notion/' ) ); ?>">Notion Template</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/e-book/' ) ); ?>">E-Book &amp; Panduan</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Pembayaran</h4>
                <p class="footer-desc" style="margin-top: 0; font-size: 0.825rem;">
                    Mendukung QRIS (GoPay, OVO, ShopeePay) dan Virtual Account (BCA, Mandiri, BNI, BRI) via Midtrans.
                </p>
                <div class="payment-badges">
                    <span class="badge-item">QRIS</span>
                    <span class="badge-item">BCA</span>
                    <span class="badge-item">Mandiri</span>
                    <span class="badge-item">BNI</span>
                    <span class="badge-item">BRI</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date( 'Y' ); ?> Indotech. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
