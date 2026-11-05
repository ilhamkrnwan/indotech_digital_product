<?php
/**
 * The template for displaying the Homepage Landing Page
 *
 * @package DigitalProduk
 */

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
                <span class="pill-dot">●</span>
                <span>PAKET LENGKAP DIGITAL & AI 2026</span>
            </div>
            <h1 class="hero-title">
                Siap Jualan & Naik Kelas dengan <span class="highlight-playful">Aset Digital Praktis</span>
            </h1>
            <p class="hero-desc">
                Solusi lengkap source code, template bisnis, prompt marketing, dan tools otomatisasi untuk UMKM & digital creator tanpa ribet.
            </p>
            <div class="hero-cta">
                <a href="#katalog" class="btn btn-primary btn-lg">Pilih Produk Sekarang ⚡</a>
                <a href="#bonus-section" class="btn btn-secondary btn-lg">Lihat 6 Bonus Praktis 🎁</a>
            </div>

            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-emoji">🚀</span>
                    <div>
                        <h3>Instan</h3>
                        <p>Akses Download Langsung</p>
                    </div>
                </div>
                <div class="stat-item">
                    <span class="stat-emoji">💎</span>
                    <div>
                        <h3>100%</h3>
                        <p>Lisensi & Update Selamanya</p>
                    </div>
                </div>
                <div class="stat-item">
                    <span class="stat-emoji">🛡️</span>
                    <div>
                        <h3>Midtrans</h3>
                        <p>Pembayaran Otomatis & Aman</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-card-stack">
                <div class="floating-badge badge-top-left">
                    <span>⚡ Akses Instan</span>
                </div>
                <div class="floating-badge badge-bottom-right">
                    <span>🎉 6 Bonus Praktis</span>
                </div>
                <div class="hero-image-frame">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-bundle.png' ); ?>" 
                         alt="AI Business Growth Kit & 6 Bonus Praktis" 
                         class="hero-bundle-img" />
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 1.5 Playful Bonus Showcase Section (Based on Reference Design) -->
<section id="bonus-section" class="section bonus-section">
    <div class="container">
        <div class="section-header">
            <div class="playful-sticker">🎁 SPECIAL BONUS</div>
            <h2 class="section-title">6 Bonus Praktis Tambahan</h2>
            <p class="section-desc">Setiap pembelian paket produk digital kami menyertakan bundle bonus siap pakai berikut:</p>
        </div>

        <div class="bonus-grid">
            <div class="bonus-card card-cyan">
                <div class="bonus-tag">BONUS 01</div>
                <div class="bonus-icon">🤖</div>
                <h3>100 Marketing Prompts</h3>
                <p>Kumpulan prompt ChatGPT & Claude siap copy-paste untuk copywriting promosi, caption sosmed, dan ide konten.</p>
            </div>

            <div class="bonus-card card-pink">
                <div class="bonus-tag">BONUS 02</div>
                <div class="bonus-icon">🎯</div>
                <h3>100 Hooks Viral</h3>
                <p>Formula pembuka video Reels, TikTok, dan thread Twitter/X dengan conversion rate tinggi untuk menarik perhatian pembeli.</p>
            </div>

            <div class="bonus-card card-yellow">
                <div class="bonus-tag">BONUS 03</div>
                <div class="bonus-icon">💬</div>
                <h3>50 Call-To-Action (CTA)</h3>
                <p>Template penutup pesan penjualan dan tombol landing page yang memicu aksi beli secara psikologis.</p>
            </div>

            <div class="bonus-card card-purple">
                <div class="bonus-tag">BONUS 04</div>
                <div class="bonus-icon">📅</div>
                <h3>30-Day Content Calendar</h3>
                <p>Jadwal dan panduan konten sebulan penuh untuk menjaga konsistensi posting tanpa pusing memikirkan ide harian.</p>
            </div>

            <div class="bonus-card card-teal">
                <div class="bonus-tag">BONUS 05</div>
                <div class="bonus-icon">📱</div>
                <h3>30 WhatsApp Sales Scripts</h3>
                <p>Script obrolan closing untuk customer service dan admin penjualan guna mengatasi keberatan pelanggan.</p>
            </div>

            <div class="bonus-card card-blue">
                <div class="bonus-tag">BONUS 06</div>
                <div class="bonus-icon">⚙️</div>
                <h3>AI Workflow Cheatsheet</h3>
                <p>Diagram alur kerja praktis mengintegrasikan kecerdasan buatan ke proses operasional harian bisnis Anda.</p>
            </div>
        </div>
    </div>
</section>

<!-- 2. Katalog Showcase Section -->
<section id="katalog" class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Katalog Produk Pilihan</h2>
            <p class="section-desc">Pilih produk digital berkualitas tinggi untuk mempercepat peluncuran proyek dan bisnis Anda.</p>
        </div>

        <!-- Filter Kategori -->
        <div class="catalog-filters">
            <button class="filter-btn active" data-filter="all">Semua Kategori</button>
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : ?>
                    <button class="filter-btn" data-filter="<?php echo esc_attr( $cat->slug ); ?>">
                        <?php echo esc_html( $cat->name ); ?>
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
                <p style="text-align: center; grid-column: 1 / -1; color: var(--text-muted);">Belum ada produk digital yang ditambahkan.</p>
                <?php
            endif;
            ?>
        </div>
    </div>
</section>

<!-- 3. Keunggulan Section -->
<section id="keunggulan" class="section" style="background: var(--bg-surface);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Mengapa Memilih Kami?</h2>
            <p class="section-desc">Kualitas dan kepuasan pelanggan adalah prioritas utama setiap produk yang kami rilis.</p>
        </div>

        <div class="features-grid">
            <div class="feature-box">
                <div class="feature-icon-wrapper">⚡</div>
                <h3>Download Instan & Otomatis</h3>
                <p>Setelah konfirmasi pembayaran, link unduhan dan lisensi produk langsung aktif tanpa harus menunggu berjam-jam.</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrapper">🛡️</div>
                <h3>Garansi Update Selamanya</h3>
                <p>Dapatkan pembaruan versi terbaru, penambahan fitur baru, serta bug fix gratis tanpa biaya langganan berulang.</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrapper">💬</div>
                <h3>Dukungan Teknis Siap Bantu</h3>
                <p>Mengalami kendala saat konfigurasi atau pemasangan? Tim teknis kami siap mendampingi Anda via WhatsApp & Email.</p>
            </div>
        </div>
    </div>
</section>

<!-- 4. Testimoni Pelanggan -->
<section id="testimoni" class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Apa Kata Mereka?</h2>
            <p class="section-desc">Ribuan pengembang, desainer, dan wirausahawan digital telah mempercayakan aset proyek mereka.</p>
        </div>

        <div class="testimonials-grid">
            <div class="testi-card">
                <div>
                    <div class="testi-rating">★★★★★</div>
                    <p class="testi-text">"Source code dan UI kit-nya bener-bener rapi dan modular. Hemat waktu development klien hingga 2 minggu penuh!"</p>
                </div>
                <div class="testi-author">
                    <div class="author-avatar">RD</div>
                    <div class="author-info">
                        <h4>Rian Darmawan</h4>
                        <p>Senior Fullstack Developer</p>
                    </div>
                </div>
            </div>

            <div class="testi-card">
                <div>
                    <div class="testi-rating">★★★★★</div>
                    <p class="testi-text">"E-book dan panduannya sangat daging, tidak bertele-tele. Langsung bisa saya praktikkan untuk optimasi funnel penjualan saya."</p>
                </div>
                <div class="testi-author">
                    <div class="author-avatar">SN</div>
                    <div class="author-info">
                        <h4>Siti Nurhaliza</h4>
                        <p>Digital Creator & Marketer</p>
                    </div>
                </div>
            </div>

            <div class="testi-card">
                <div>
                    <div class="testi-rating">★★★★★</div>
                    <p class="testi-text">"Customer support responsif banget waktu saya tanya cara setting env. Sangat recommended buat yang butuh aset profesional!"</p>
                </div>
                <div class="testi-author">
                    <div class="author-avatar">BP</div>
                    <div class="author-info">
                        <h4>Budi Pratama</h4>
                        <p>Freelance Web Designer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. FAQ Section -->
<section id="faq" class="section" style="background: var(--bg-surface);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Pertanyaan Sering Diajukan</h2>
            <p class="section-desc">Punya pertanyaan seputar pembelian atau produk? Temukan jawabannya di sini.</p>
        </div>

        <div class="faq-wrap">
            <div class="faq-item active">
                <button type="button" class="faq-question">
                    <span>Bagaimana cara menerima produk setelah bayar?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Setelah pembayaran berhasil terkonfirmasi, Anda akan otomatis mendapatkan link akses download file Google Drive / Cloud Storage yang aktif selamanya.
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>Apakah saya boleh menggunakan produk ini untuk klien?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Ya! Semua produk digital yang dijual di sini menyertakan Commercial License standar, yang memperbolehkan Anda memakainya untuk proyek pribadi maupun pekerjaan klien komersial.
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span>Metode pembayaran apa saja yang didukung?</span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Kami mendukung pembayaran mudah via QRIS (BCA, GoPay, OVO, Dana, ShopeePay), transfer bank virtual account (BCA, Mandiri, BRI, BNI), dan transfer manual.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. Call to Action Banner -->
<section class="section">
    <div class="container">
        <div class="cta-banner">
            <h2>Mulai Akselerasi Proyek Digital Anda Hari Ini</h2>
            <p>Dapatkan penawaran harga promo khusus sebelum masa diskon berakhir. Semua file siap didownload dalam hitungan detik.</p>
            <a href="#katalog" class="btn btn-primary btn-lg">Pilih Produk Sekarang ⚡</a>
        </div>
    </div>
</section>

<!-- 7. Checkout Modal -->
<?php get_template_part( 'template-parts/checkout-modal' ); ?>

<?php
get_footer();
