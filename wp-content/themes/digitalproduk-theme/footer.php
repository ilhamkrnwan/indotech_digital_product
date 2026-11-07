</main><!-- #primary -->

<footer class="site-footer">
    <!-- Organic Paint Stroke Divider Line -->
    <svg class="brush-divider footer-brush-divider" viewBox="0 0 1100 12" fill="none" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0 6 C200 3 450 9 700 5 C900 2 1050 7 1100 5" stroke="#152cab" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="60 20 180 15 240 30" opacity="0.3" />
        <path d="M120 7 C350 4 600 10 850 6" stroke="#f7d801" stroke-width="3" stroke-linecap="round" stroke-dasharray="100 25 150 20" opacity="0.75" />
    </svg>

    <!-- Background Abstract Paint & Geometry Canvas -->
    <div class="footer-art-canvas" aria-hidden="true">
        <!-- Corner Paint Splash in footer -->
        <svg class="footer-stroke-splash" viewBox="0 0 320 220" fill="none">
            <path d="M60 220 C100 180 160 190 220 150 C270 115 290 60 320 0 V220 H60 Z" fill="#152cab" opacity="0.08" />
            <path d="M120 220 C160 195 210 200 250 170 C280 145 300 100 320 50 V220 H120 Z" fill="#f7d801" opacity="0.12" />
            <circle cx="180" cy="140" r="4" fill="#152cab" opacity="0.18" />
            <circle cx="230" cy="110" r="3" fill="#f7d801" opacity="0.25" />
        </svg>
        <svg class="footer-geo-triangle" viewBox="0 0 32 32" fill="none">
            <polygon points="16,3 29,27 3,27" stroke="#152cab" stroke-width="2" opacity="0.2" />
        </svg>
        <div class="footer-geo-plus" style="top: 35px; right: 120px;">+</div>
        <div class="footer-geo-plus" style="bottom: 25px; left: 80px;">+</div>
    </div>

    <div class="container footer-container">
        <div class="footer-grid">
            <div class="footer-col brand-col">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand" style="margin-bottom: 0.75rem;">
                    <span class="brand-title footer-brand-title">
                        Indotech
                        <span class="footer-brand-brush" aria-hidden="true"></span>
                    </span>
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
