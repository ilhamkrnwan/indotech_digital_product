</main><!-- #primary -->

<footer class="site-footer">
    <div class="container footer-container">
        <div class="footer-grid">
            <div class="footer-col brand-col">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand" style="margin-bottom: 1rem;">
                    <div class="brand-badge">IT</div>
                    <div class="brand-text-block">
                        <span class="brand-title">Indotech</span>
                        <span class="brand-subtag">Katalog Aset Digital</span>
                    </div>
                </a>
                <p class="footer-desc">
                    Marketplace &amp; katalog aset digital terverifikasi untuk developer dan kreator Indonesia. Menyediakan source code aplikasi web siap produksi, plugin native WordPress, dan sistem desain Figma dengan akses download instan otomatis.
                </p>
                <div style="display: inline-flex; align-items: center; gap: 8px; background: var(--bg-canvas); border: 1px solid var(--border-main); padding: 6px 12px; border-radius: var(--radius-sm); font-size: 0.8rem; color: var(--text-secondary);">
                    <span style="color: var(--brand-cobalt);"><?php echo digitalproduk_get_icon( 'shield-check', 'footer-shield-icon', 16 ); ?></span>
                    <span>Lisensi Komersial Bebas &amp; Akses Selamanya</span>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Navigasi Utama</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda Katalog</a></li>
                    <li><a href="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>">Semua Produk Digital</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/#cara-kerja' ) ); ?>">Alur Pembelian &amp; Download</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/#keunggulan' ) ); ?>">Standar Kualitas Teknis</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>">Tanya Jawab (FAQ)</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/checkout/' ) ); ?>">Halaman Checkout</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Kategori Aset</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/source-code/' ) ); ?>">Source Code &amp; Web Apps</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/ui-ux-figma/' ) ); ?>">UI/UX &amp; Figma Kit</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/template-notion/' ) ); ?>">Template &amp; Notion OS</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/e-book/' ) ); ?>">E-Book &amp; Blueprint Bisnis</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/kategori-produk/saas-tools/' ) ); ?>">SaaS &amp; Otomasi Tools</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Pembayaran Midtrans</h4>
                <p class="footer-desc" style="margin-top: 0; font-size: 0.825rem;">
                    Transaksi terenkripsi aman secara otomatis melalui gateway resmi Midtrans Snap API.
                </p>
                <div class="payment-badges">
                    <span class="badge-item">QRIS</span>
                    <span class="badge-item">BCA VA</span>
                    <span class="badge-item">Mandiri</span>
                    <span class="badge-item">BNI</span>
                    <span class="badge-item">BRI</span>
                    <span class="badge-item">GoPay</span>
                    <span class="badge-item">ShopeePay</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date( 'Y' ); ?> Indotech Digital Store. Hak Cipta Dilindungi Undang-Undang.</p>
            <p style="font-family: var(--font-mono); font-size: 0.775rem;">Utilitarian Technical Commerce System • Dial: E2/R2/M1</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
