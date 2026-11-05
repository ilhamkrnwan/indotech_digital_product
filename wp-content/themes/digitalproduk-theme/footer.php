</main><!-- #primary -->

<footer class="site-footer">
    <div class="container footer-container">
        <div class="footer-grid">
            <div class="footer-col brand-col">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand" style="margin-bottom: 1rem;">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-indotech-landscape.avif' ); ?>" 
                         alt="Indotech Digital Produk" 
                         class="brand-logo-img" 
                         height="38" />
                </a>
                <p class="footer-desc">
                    Pusat aset, template, e-book, dan source code premium terkurasi untuk mempercepat alur kerja kreatif & digital developer Indonesia.
                </p>
                <div class="guarantee-badge">
                    <span class="icon"><?php echo digitalproduk_get_icon( 'shield-check', 'footer-shield-icon', 18 ); ?></span>
                    <span>Garansi Update Gratis &amp; Akses Selamanya</span>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Navigasi Toko</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda Toko</a></li>
                    <li><a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>">Semua Produk (Katalog)</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/#bonus-section' ) ); ?>">Bonus Tambahan</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/#keunggulan' ) ); ?>">Keunggulan Toko</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>">Tanya Jawab (FAQ)</a></li>
                    <li><a href="https://wa.me/6281234567890" target="_blank" rel="noopener">Bantuan CS (WhatsApp)</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Kategori Produk</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/source-code/' ) ); ?>">Source Code &amp; Web Apps</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/ui-ux-figma/' ) ); ?>">UI/UX &amp; Figma Template</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/template-notion/' ) ); ?>">Template &amp; Notion OS</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/e-book/' ) ); ?>">E-Book &amp; Panduan Bisnis</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/saas-tools/' ) ); ?>">SaaS &amp; Otomasi Tools</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Pembayaran Aman</h4>
                <p class="footer-subtext">Mendukung QRIS, Bank Transfer (BCA, Mandiri, BRI, BNI), & E-Wallet.</p>
                <div class="payment-badges">
                    <span class="badge-item">QRIS</span>
                    <span class="badge-item">BCA</span>
                    <span class="badge-item">Mandiri</span>
                    <span class="badge-item">GoPay</span>
                    <span class="badge-item">OVO</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date( 'Y' ); ?> DigitalProduk. Hak Cipta Dilindungi Undang-Undang.</p>
            <p class="footer-note">Dibuat dengan dedikasi untuk kreator & developer Indonesia.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
