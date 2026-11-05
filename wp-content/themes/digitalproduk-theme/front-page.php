<?php
/**
 * The template for displaying the Homepage Landing Page
 *
 * @package DigitalProduk
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Query Digital Products
$products_query = new WP_Query([
    'post_type'      => 'digital_product',
    'posts_per_page' => 12,
    'post_status'    => 'publish',
]);

// Query Categories
$categories = get_terms([
    'taxonomy'   => 'product_category',
    'hide_empty' => false,
]);
?>

<!-- 1. Hero Section -->
<section class="hero-section">
    <div class="hero-glow"></div>
    <div class="container hero-container">
        <div class="hero-content">
            <div class="hero-pill">
                <span class="pill-icon-wrap"><?php echo digitalproduk_get_icon( 'sparkles', 'pill-sparkle', 14 ); ?></span>
                <span>PLATFORM ASET DIGITAL RESMI UNTUK DEVELOPER &amp; KREATOR</span>
            </div>
            <h1 class="hero-title">
                Bangun Proyek Digital &amp; Klien 10x Lebih Cepat <span class="highlight-playful">Tanpa Mulai Dari Nol</span>
            </h1>
            <p class="hero-desc">
                Hemat ratusan jam kerja dengan koleksi source code web apps, UI/UX template Figma, Notion workspace, dan blueprint bisnis teruji. Siap pakai, berlisensi komersial bebas, dengan akses instan pasca bayar.
            </p>

            <!-- Store Quick Search -->
            <form action="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" method="get" class="hero-store-search">
                <input type="text" name="s" placeholder="Cari source code, template Figma, Notion OS, e-book..." class="hero-search-input" />
                <button type="submit" class="btn btn-primary">
                    <span>Temukan Aset</span>
                    <?php echo digitalproduk_get_icon( 'search', 'btn-icon', 16 ); ?>
                </button>
            </form>

            <div class="hero-cta">
                <a href="#katalog" class="btn btn-primary btn-lg">
                    <span>Jelajahi Semua Produk</span>
                    <?php echo digitalproduk_get_icon( 'arrow-right', 'btn-icon-right', 18 ); ?>
                </a>
                <a href="#kategori-section" class="btn btn-secondary btn-lg">
                    <span>Pilih Kategori Aset</span>
                    <?php echo digitalproduk_get_icon( 'layers', 'btn-icon-right', 18 ); ?>
                </a>
            </div>

            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-icon-wrap stat-cyan">
                        <?php echo digitalproduk_get_icon( 'download', '', 20 ); ?>
                    </span>
                    <div>
                        <h3>Akses Instan 24 Jam</h3>
                        <p>Link folder Google Drive aktif otomatis</p>
                    </div>
                </div>
                <div class="stat-item">
                    <span class="stat-icon-wrap stat-purple">
                        <?php echo digitalproduk_get_icon( 'briefcase', '', 20 ); ?>
                    </span>
                    <div>
                        <h3>Lisensi Komersial</h3>
                        <p>Bebas dipakai untuk proyek klien tanpa royalti</p>
                    </div>
                </div>
                <div class="stat-item">
                    <span class="stat-icon-wrap stat-green">
                        <?php echo digitalproduk_get_icon( 'shield-check', '', 20 ); ?>
                    </span>
                    <div>
                        <h3>Midtrans Resmi</h3>
                        <p>QRIS, Bank Transfer, &amp; E-Wallet 100% aman</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-card-stack">
                <!-- Playful Decorative Sunburst & Rays -->
                <div class="hero-sunburst"></div>

                <!-- Floating Badges with Lucide Icons -->
                <div class="floating-badge badge-top-left float-anim-1">
                    <span class="floating-badge-inner">
                        <?php echo digitalproduk_get_icon( 'zap', 'badge-icon', 14 ); ?>
                        <span>Akses Instan 24 Jam</span>
                    </span>
                </div>
                <div class="floating-badge badge-bottom-right float-anim-2">
                    <span class="floating-badge-inner">
                        <?php echo digitalproduk_get_icon( 'sparkles', 'badge-icon', 14 ); ?>
                        <span>6 Bonus Aset Gratis</span>
                    </span>
                </div>
                <div class="floating-mini-sticker sticker-umkm float-anim-3">
                    <span class="floating-badge-inner">
                        <?php echo digitalproduk_get_icon( 'package', 'badge-icon', 14 ); ?>
                        <span>Katalog Siap Pakai</span>
                    </span>
                </div>

                <div class="hero-image-frame tilt-card">
                    <div class="frame-pin-top"></div>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-bundle.png' ); ?>" 
                         alt="Indotech Digital Store Showcase Bundle" 
                         class="hero-bundle-img" />
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 1.2 Categories Shelves Section (Multi-Category Portal) -->
<section id="kategori-section" class="section categories-shelf-section">
    <div class="container">
        <div class="section-header">
            <div class="playful-sticker">
                <?php echo digitalproduk_get_icon( 'layers', '', 14 ); ?>
                <span>KLASIFIKASI ASET TERSTRUKTUR</span>
            </div>
            <h2 class="section-title">Pilih Kategori Sesuai Kebutuhan Proyek Anda</h2>
            <p class="section-desc">Setiap aset dikurasi dengan standar industri, arsitektur modular, dan dokumentasi lengkap agar langsung siap Anda manfaatkan.</p>
        </div>

        <div class="categories-shelf-grid">
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $idx => $cat ) : 
                    $meta = digitalproduk_get_category_meta( $cat->slug );
                    $tilt_class = ( $idx % 2 === 0 ) ? 'tilt-left' : 'tilt-right';
                ?>
                    <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="cat-shelf-card <?php echo esc_attr( $meta['color_class'] . ' ' . $tilt_class ); ?>">
                        <div class="card-tape"></div>
                        <div class="cat-shelf-header">
                            <span class="cat-shelf-icon-wrap">
                                <?php echo digitalproduk_get_icon( $meta['icon'], 'cat-svg-icon', 22 ); ?>
                            </span>
                            <span class="cat-shelf-badge"><?php echo esc_html( $meta['badge'] ); ?></span>
                        </div>
                        <h3 class="cat-shelf-title"><?php echo esc_html( $cat->name ); ?></h3>
                        <p class="cat-shelf-desc"><?php echo esc_html( $meta['desc'] ); ?></p>
                        <div class="cat-shelf-footer">
                            <span class="cat-shelf-count">
                                <?php echo digitalproduk_get_icon( 'package', 'count-icon', 13 ); ?>
                                <span><?php echo esc_html( $cat->count ); ?> Produk Siap Pakai</span>
                            </span>
                            <span class="cat-shelf-btn">
                                <span>Buka Kategori</span>
                                <?php echo digitalproduk_get_icon( 'arrow-right', 'btn-icon-xs', 13 ); ?>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- 1.5 Playful Bonus Showcase Section -->
<section id="bonus-section" class="section bonus-section">
    <div class="container">
        <div class="section-header">
            <div class="playful-sticker">
                <?php echo digitalproduk_get_icon( 'sparkles', '', 14 ); ?>
                <span>PAKET BUNDLE EKSKLUSIF</span>
            </div>
            <h2 class="section-title">6 Bonus Aset Senilai Total Rp 1.500.000 Gratis</h2>
            <p class="section-desc">Dapatkan paket amunisi akselerasi digital tambahan tanpa biaya ekstra untuk setiap pembelian paket produk kami hari ini:</p>
        </div>

        <div class="bonus-grid">
            <div class="bonus-card card-cyan tilt-left">
                <div class="card-tape"></div>
                <div class="bonus-header-flex">
                    <span class="bonus-tag">BONUS 01</span>
                    <span class="bonus-icon-wrap bg-cyan-soft">
                        <?php echo digitalproduk_get_icon( 'bot', 'bonus-svg', 20 ); ?>
                    </span>
                </div>
                <h3>100+ Prompt AI Copywriting</h3>
                <p>Formula prompt ChatGPT &amp; Claude teruji untuk membuat promosi produk, copywriting landing page, dan ide konten harian dengan cepat.</p>
                <div class="mini-worksheet-preview preview-cyan">
                    <div class="mockup-row"><span class="mockup-line long"></span><span class="mockup-check"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span></div>
                    <div class="mockup-row"><span class="mockup-line med"></span><span class="mockup-check"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span></div>
                    <div class="mockup-row"><span class="mockup-line short"></span><span class="mockup-check"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span></div>
                </div>
            </div>

            <div class="bonus-card card-pink tilt-right">
                <div class="card-tape"></div>
                <div class="bonus-header-flex">
                    <span class="bonus-tag">BONUS 02</span>
                    <span class="bonus-icon-wrap bg-pink-soft">
                        <?php echo digitalproduk_get_icon( 'target', 'bonus-svg', 20 ); ?>
                    </span>
                </div>
                <h3>100 Hook Viral Media Sosial</h3>
                <p>Formula kalimat pembuka video Reels dan TikTok dengan conversion rate terbukti untuk menjaring ribuan calon pembeli potensial.</p>
                <div class="mini-worksheet-preview preview-pink">
                    <div class="mockup-row"><span class="mockup-line long"></span><span class="mockup-check"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span></div>
                    <div class="mockup-row"><span class="mockup-line med"></span><span class="mockup-check"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span></div>
                    <div class="mockup-row"><span class="mockup-line short"></span><span class="mockup-check"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span></div>
                </div>
            </div>

            <div class="bonus-card card-yellow tilt-left">
                <div class="card-tape"></div>
                <div class="bonus-header-flex">
                    <span class="bonus-tag">BONUS 03</span>
                    <span class="bonus-icon-wrap bg-yellow-soft">
                        <?php echo digitalproduk_get_icon( 'message-circle', 'bonus-svg', 20 ); ?>
                    </span>
                </div>
                <h3>50 Formula CTA Konversi Tinggi</h3>
                <p>Koleksi copywriting tombol dan penutup penawaran landing page yang memicu aksi beli secara spontan tanpa kesan memaksa.</p>
                <div class="mini-worksheet-preview preview-yellow">
                    <div class="mockup-row"><span class="mockup-line long"></span><span class="mockup-check"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span></div>
                    <div class="mockup-row"><span class="mockup-line med"></span><span class="mockup-check"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span></div>
                    <div class="mockup-row"><span class="mockup-line short"></span><span class="mockup-check"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span></div>
                </div>
            </div>

            <div class="bonus-card card-purple tilt-right">
                <div class="card-tape"></div>
                <div class="bonus-header-flex">
                    <span class="bonus-tag">BONUS 04</span>
                    <span class="bonus-icon-wrap bg-purple-soft">
                        <?php echo digitalproduk_get_icon( 'calendar', 'bonus-svg', 20 ); ?>
                    </span>
                </div>
                <h3>Kalender Konten 30 Hari Eksekusi</h3>
                <p>Panduan distribusi konten 30 hari penuh agar brand Anda tetap konsisten hadir di depan audiens tanpa pusing mencari ide.</p>
                <div class="mini-worksheet-preview preview-purple">
                    <div class="mockup-calendar-grid">
                        <span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                        <span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                    </div>
                </div>
            </div>

            <div class="bonus-card card-teal tilt-left">
                <div class="card-tape"></div>
                <div class="bonus-header-flex">
                    <span class="bonus-tag">BONUS 05</span>
                    <span class="bonus-icon-wrap bg-teal-soft">
                        <?php echo digitalproduk_get_icon( 'smartphone', 'bonus-svg', 20 ); ?>
                    </span>
                </div>
                <h3>30 Skrip WhatsApp Closing</h3>
                <p>Alur percakapan taktis customer service untuk menjawab pertanyaan ragu pembeli, menangani komparasi harga, dan follow up.</p>
                <div class="mini-worksheet-preview preview-teal">
                    <div class="mockup-row"><span class="mockup-line long"></span><span class="mockup-check"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span></div>
                    <div class="mockup-row"><span class="mockup-line med"></span><span class="mockup-check"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span></div>
                    <div class="mockup-row"><span class="mockup-line short"></span><span class="mockup-check"><?php echo digitalproduk_get_icon( 'check', '', 12 ); ?></span></div>
                </div>
            </div>

            <div class="bonus-card card-blue tilt-right">
                <div class="card-tape"></div>
                <div class="bonus-header-flex">
                    <span class="bonus-tag">BONUS 06</span>
                    <span class="bonus-icon-wrap bg-blue-soft">
                        <?php echo digitalproduk_get_icon( 'settings', 'bonus-svg', 20 ); ?>
                    </span>
                </div>
                <h3>Cheatsheet Integrasi Otomasi AI</h3>
                <p>Diagram alur kerja praktis mengawinkan tools AI ke proses operasional harian untuk memangkas jam kerja berulang hingga 80%.</p>
                <div class="mini-worksheet-preview preview-blue">
                    <div class="mockup-flow-chart">
                        <span class="flow-box">RISET</span>
                        <span class="flow-arrow">&rarr;</span>
                        <span class="flow-box">AI TOOLS</span>
                        <span class="flow-arrow">&rarr;</span>
                        <span class="flow-box">HASIL</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Katalog Showcase Section -->
<section id="katalog" class="section">
    <div class="container">
        <div class="section-header">
            <div class="playful-sticker">
                <?php echo digitalproduk_get_icon( 'package', '', 14 ); ?>
                <span>ASET TERBAIK SIAP AKSES</span>
            </div>
            <h2 class="section-title">Katalog Produk Pilihan</h2>
            <p class="section-desc">Pilih produk digital berkualitas tinggi untuk mempercepat peluncuran proyek dan bisnis Anda.</p>
        </div>

        <!-- Filter Kategori -->
        <div class="catalog-filters">
            <button class="filter-btn active" data-filter="all">
                <?php echo digitalproduk_get_icon( 'layers', 'filter-icon-svg', 14 ); ?>
                <span>Semua Kategori</span>
            </button>
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : 
                    $cat_meta = digitalproduk_get_category_meta( $cat->slug );
                ?>
                    <button class="filter-btn" data-filter="<?php echo esc_attr( $cat->slug ); ?>">
                        <?php echo digitalproduk_get_icon( $cat_meta['icon'], 'filter-icon-svg', 14 ); ?>
                        <span><?php echo esc_html( $cat->name ); ?></span>
                    </button>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Grid Produk -->
        <div class="products-grid">
            <?php
            if ( $products_query->have_posts() ) :
                while ( $products_query->have_posts() ) :
                    $products_query->the_post();
                    get_template_part( 'template-parts/product-card' );
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p style="text-align: center; grid-column: 1 / -1; color: var(--color-body-text);">Belum ada produk digital yang ditambahkan.</p>
                <?php
            endif;
            ?>
        </div>
    </div>
</section>

<!-- 3. Keunggulan Section -->
<section id="keunggulan" class="section" style="background: var(--color-surface-white);">
    <div class="container">
        <div class="section-header">
            <div class="playful-sticker">
                <?php echo digitalproduk_get_icon( 'shield-check', '', 14 ); ?>
                <span>STANDAR KUALITAS KAMI</span>
            </div>
            <h2 class="section-title">Kenapa Memilih Aset Digital Kami?</h2>
            <p class="section-desc">Kami memastikan setiap rupiah yang Anda investasikan memberikan efisiensi waktu dan hasil terbaik untuk karier maupun bisnis Anda.</p>
        </div>

        <div class="features-grid">
            <div class="feature-box">
                <div class="feature-icon-wrapper bg-yellow">
                    <?php echo digitalproduk_get_icon( 'zap', 'feature-svg', 26 ); ?>
                </div>
                <h3>Akses Instan &amp; Otomatis</h3>
                <p>Setelah pembayaran terkonfirmasi oleh sistem Midtrans, link download Google Drive langsung aktif detik itu juga ke email Anda tanpa antre.</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrapper bg-cyan">
                    <?php echo digitalproduk_get_icon( 'refresh-cw', 'feature-svg', 26 ); ?>
                </div>
                <h3>Pembaruan Versi Gratis Selamanya</h3>
                <p>Dapatkan update versi terbaru, penambahan fitur anyar, serta perbaikan berkala seumur hidup tanpa pungutan biaya langganan bulanan.</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrapper bg-pink">
                    <?php echo digitalproduk_get_icon( 'briefcase', 'feature-svg', 26 ); ?>
                </div>
                <h3>Lisensi Komersial Lengkap</h3>
                <p>Bebas Anda modifikasi dan gunakan untuk proyek pribadi, startup mandiri, maupun pekerjaan klien komersial tanpa batas royalti.</p>
            </div>
        </div>
    </div>
</section>

<!-- 4. Testimoni Pelanggan -->
<section id="testimoni" class="section">
    <div class="container">
        <div class="section-header">
            <div class="playful-sticker">
                <?php echo digitalproduk_get_icon( 'star', '', 14 ); ?>
                <span>ULASAN PEMBELI</span>
            </div>
            <h2 class="section-title">Cerita Sukses Dari Pengguna Nyata</h2>
            <p class="section-desc">Pengembang aplikasi, desainer produk, dan praktisi digital telah membuktikan efisiensi kerja mereka bersama kami.</p>
        </div>

        <div class="testimonials-grid">
            <div class="testi-card">
                <div>
                    <div class="testi-rating-stars">
                        <?php for ( $s = 0; $s < 5; $s++ ) : ?>
                            <?php echo digitalproduk_get_icon( 'star', 'star-gold', 15 ); ?>
                        <?php endfor; ?>
                    </div>
                    <p class="testi-text">&ldquo;Source code dan UI kit-nya benar-benar rapi dan modular. Struktur kodenya terstruktur dengan baik sehingga memangkas waktu pengerjaan proyek klien hingga 2 minggu penuh.&rdquo;</p>
                </div>
                <div class="testi-author">
                    <div class="author-avatar bg-cyan">RD</div>
                    <div class="author-info">
                        <h4>Rian Darmawan</h4>
                        <p>Senior Fullstack Developer</p>
                    </div>
                </div>
            </div>

            <div class="testi-card">
                <div>
                    <div class="testi-rating-stars">
                        <?php for ( $s = 0; $s < 5; $s++ ) : ?>
                            <?php echo digitalproduk_get_icon( 'star', 'star-gold', 15 ); ?>
                        <?php endfor; ?>
                    </div>
                    <p class="testi-text">&ldquo;E-book dan blueprint Notion-nya sangat aplikatif, tanpa banyak teori kosong. Langsung bisa dipraktikkan untuk merapikan alur kerja proyek freelance saya.&rdquo;</p>
                </div>
                <div class="testi-author">
                    <div class="author-avatar bg-pink">SN</div>
                    <div class="author-info">
                        <h4>Siti Nurhaliza</h4>
                        <p>Digital Creator &amp; UI Consultant</p>
                    </div>
                </div>
            </div>

            <div class="testi-card">
                <div>
                    <div class="testi-rating-stars">
                        <?php for ( $s = 0; $s < 5; $s++ ) : ?>
                            <?php echo digitalproduk_get_icon( 'star', 'star-gold', 15 ); ?>
                        <?php endfor; ?>
                    </div>
                    <p class="testi-text">&ldquo;Tim bantuan sangat responsif saat saya menanyakan dokumentasi setup environment. Dokumentasi jelas dan file langsung siap digunakan seketika.&rdquo;</p>
                </div>
                <div class="testi-author">
                    <div class="author-avatar bg-yellow">BP</div>
                    <div class="author-info">
                        <h4>Budi Pratama</h4>
                        <p>Agency Web Developer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. FAQ Section -->
<section id="faq" class="section" style="background: var(--color-surface-white);">
    <div class="container">
        <div class="section-header">
            <div class="playful-sticker">
                <?php echo digitalproduk_get_icon( 'help-circle', '', 14 ); ?>
                <span>INFORMASI LENGKAP</span>
            </div>
            <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
            <p class="section-desc">Jawaban transparan seputar lisensi, cara pengiriman file, dan metode pembayaran aman kami.</p>
        </div>

        <div class="faq-wrap">
            <div class="faq-item active">
                <button type="button" class="faq-question">
                    <span>Bagaimana cara menerima file setelah menyelesaikan pembayaran?</span>
                    <span class="faq-icon-wrap">
                        <?php echo digitalproduk_get_icon( 'chevron-down', 'faq-chevron', 18 ); ?>
                    </span>
                </button>
                <div class="faq-answer">
                    Setelah pembayaran Anda terverifikasi oleh gateway Midtrans secara otomatis, sistem akan langsung menampilkan link folder Google Drive dan mengirimkannya ke alamat email Anda. Akses ini aktif selamanya dan dapat Anda unduh kapan saja.
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>Apakah saya boleh menggunakan aset ini untuk pekerjaan klien komersial?</span>
                    <span class="faq-icon-wrap">
                        <?php echo digitalproduk_get_icon( 'chevron-down', 'faq-chevron', 18 ); ?>
                    </span>
                </button>
                <div class="faq-answer">
                    Tentu saja. Semua produk digital kami hadir dengan lisensi komersial bebas royalti. Anda diperbolehkan menggunakan kode, template, atau sistem ini untuk proyek pribadi, startup, maupun diserahkan langsung kepada klien bisnis Anda.
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>Metode pembayaran apa saja yang disediakan?</span>
                    <span class="faq-icon-wrap">
                        <?php echo digitalproduk_get_icon( 'chevron-down', 'faq-chevron', 18 ); ?>
                    </span>
                </button>
                <div class="faq-answer">
                    Kami terintegrasi resmi dengan Midtrans Snap Payment Gateway, mendukung QRIS (BCA, GoPay, OVO, Dana, ShopeePay), transfer bank virtual account (BCA, Mandiri, BRI, BNI), serta konfirmasi manual via admin WhatsApp.
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>Bagaimana jika saya memerlukan pembaruan versi di masa depan?</span>
                    <span class="faq-icon-wrap">
                        <?php echo digitalproduk_get_icon( 'chevron-down', 'faq-chevron', 18 ); ?>
                    </span>
                </button>
                <div class="faq-answer">
                    Semua pembeli mendapatkan hak akses pembaruan seumur hidup tanpa biaya tambahan. Ketika kami memperbarui versi kode, UI kit, atau materi e-book, link Google Drive Anda akan otomatis memuat file terbaru.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. Call to Action Banner -->
<section class="section">
    <div class="container">
        <div class="cta-banner">
            <div class="playful-sticker" style="display: inline-flex; margin-bottom: 1rem;">
                <?php echo digitalproduk_get_icon( 'sparkles', '', 14 ); ?>
                <span>AKSELERASI PROYEK ANDA</span>
            </div>
            <h2>Mulai Bangun &amp; Luncurkan Proyek Digital Anda Hari Ini</h2>
            <p>Dapatkan akses instan ke seluruh file aset berkualitas tinggi dengan harga promo spesial dan lisensi komersial penuh.</p>
            <a href="#katalog" class="btn btn-primary btn-lg">
                <span>Pilih Produk &amp; Akses Sekarang</span>
                <?php echo digitalproduk_get_icon( 'arrow-right', 'btn-icon-right', 18 ); ?>
            </a>
        </div>
    </div>
</section>

<!-- 7. Checkout Modal -->
<?php get_template_part( 'template-parts/checkout-modal' ); ?>

<?php
get_footer();
