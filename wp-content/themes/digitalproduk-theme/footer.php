</main><!-- #primary -->

<footer class="site-footer">
    <div class="footer-tech-divider" aria-hidden="true"></div>

    <div class="container footer-container">
        <div class="footer-grid">
            <div class="footer-col brand-col">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand footer-brand-link" style="margin-bottom: 0.85rem;" aria-label="Indotechnology Home">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-indotechnology-2026.png' ); ?>"
                         alt="Indotechnology - BUILD • INNOVATE • GROW"
                         class="footer-brand-logo"
                         width="193"
                         height="40"
                         loading="lazy" />
                </a>
                <p class="footer-desc">
                    Katalog source code, plugin WordPress, template Figma, dan workspace Notion untuk proyek yang sedang Anda kerjakan.
                </p>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Jelajahi</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a></li>
                    <li><a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>">Semua Produk</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/#cara-kerja' ) ); ?>">Cara Beli</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>">FAQ</a></li>
                    <li class="footer-link-label">Kategori</li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/source-code/' ) ); ?>">Source Code</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/ui-ux-figma/' ) ); ?>">UI/UX &amp; Figma</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/template-notion/' ) ); ?>">Notion Template</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/e-book/' ) ); ?>">E-Book &amp; Panduan</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Pembayaran</h4>
                <p class="footer-desc" style="margin-top: 0; font-size: 0.825rem;">
                    Mendukung QRIS (GoPay, OVO, ShopeePay) dan Virtual Account (BCA, Mandiri, BNI, BRI).
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
            <p>&copy; <?php echo date( 'Y' ); ?> indotechnology. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
