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
                <span>INDOTECH DIGITAL STORE • PUSAT ASET &amp; PRODUK DIGITAL</span>
            </div>
            <h1 class="hero-title">
                Koleksi Aset &amp; Produk Digital untuk <span class="highlight-playful">Bisnis &amp; Kreator</span>
            </h1>
            <p class="hero-desc">
                Temukan source code web apps, UI/UX Figma template, Notion workspace, dan e-book strategi bisnis teruji dengan akses instan &amp; pembayaran aman Midtrans.
            </p>

            <!-- Store Quick Search -->
            <form action="<?php echo esc_url( get_post_type_archive_link( 'digital_product' ) ); ?>" method="get" class="hero-store-search">
                <input type="text" name="s" placeholder="Cari source code, template Figma, Notion OS, e-book..." class="hero-search-input" />
                <button type="submit" class="btn btn-primary">Cari Aset 🔍</button>
            </form>

            <div class="hero-cta">
                <a href="#katalog" class="btn btn-primary btn-lg">Jelajahi Semua Produk ⚡</a>
                <a href="#kategori-section" class="btn btn-secondary btn-lg">Pilih Kategori 🗂️</a>
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
                        <p>Lisensi &amp; Update Selamanya</p>
                    </div>
                </div>
                <div class="stat-item">
                    <span class="stat-emoji">🛡️</span>
                    <div>
                        <h3>Midtrans</h3>
                        <p>Pembayaran Otomatis &amp; Aman</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-card-stack">
                <!-- Playful Decorative Sunburst & Rays -->
                <div class="hero-sunburst"></div>
                <div class="spark-doodle spark-1">✨</div>
                <div class="spark-doodle spark-2">⚡</div>
                <div class="spark-doodle spark-3">💫</div>
                <div class="spark-doodle spark-4">⭐</div>

                <!-- Floating Badges with Wobble Animation -->
                <div class="floating-badge badge-top-left float-anim-1">
                    <span>⚡ Akses Instan 24 Jam</span>
                </div>
                <div class="floating-badge badge-bottom-right float-anim-2">
                    <span>🎉 6 Bonus Praktis</span>
                </div>
                <div class="floating-mini-sticker sticker-umkm float-anim-3">
                    <span>🔥 Katalog Lengkap</span>
                </div>

                <div class="hero-image-frame tilt-card">
                    <div class="frame-pin-top"></div>
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-bundle.png' ); ?>" 
                         alt="Indotech Digital Store Products" 
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
            <div class="playful-sticker">🗂️ JELAJAHI KOLEKSI</div>
            <h2 class="section-title">Pilih Kategori Produk</h2>
            <p class="section-desc">Pilih kategori aset digital yang sesuai dengan skala proyek dan kebutuhan bisnis Anda.</p>
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
                            <span class="cat-shelf-icon"><?php echo esc_html( $meta['icon'] ); ?></span>
                            <span class="cat-shelf-badge"><?php echo esc_html( $meta['badge'] ); ?></span>
                        </div>
                        <h3 class="cat-shelf-title"><?php echo esc_html( $cat->name ); ?></h3>
                        <p class="cat-shelf-desc"><?php echo esc_html( $meta['desc'] ); ?></p>
                        <div class="cat-shelf-footer">
                            <span class="cat-shelf-count"><?php echo esc_html( $cat->count ); ?> Produk Tersedia</span>
                            <span class="cat-shelf-btn">Buka Kategori &rarr;</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
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
            <div class="bonus-card card-cyan tilt-left">
                <div class="card-tape"></div>
                <div class="bonus-header-flex">
                    <span class="bonus-tag">BONUS 01</span>
                    <span class="bonus-icon">🤖</span>
                </div>
                <h3>100 Marketing Prompts</h3>
                <p>Formula prompt ChatGPT & Claude siap pakai untuk promosi, copywriting, & ide konten harian.</p>
                <div class="mini-worksheet-preview preview-cyan">
                    <div class="mockup-row"><span class="mockup-line long"></span><span class="mockup-check">✓</span></div>
                    <div class="mockup-row"><span class="mockup-line med"></span><span class="mockup-check">✓</span></div>
                    <div class="mockup-row"><span class="mockup-line short"></span><span class="mockup-check">✓</span></div>
                </div>
            </div>

            <div class="bonus-card card-pink tilt-right">
                <div class="card-tape"></div>
                <div class="bonus-header-flex">
                    <span class="bonus-tag">BONUS 02</span>
                    <span class="bonus-icon">🎯</span>
                </div>
                <h3>100 Hooks Viral</h3>
                <p>Formula kalimat pembuka video Reels & TikTok dengan conversion rate tinggi untuk UMKM.</p>
                <div class="mini-worksheet-preview preview-pink">
                    <div class="mockup-row"><span class="mockup-line long"></span><span class="mockup-check">✓</span></div>
                    <div class="mockup-row"><span class="mockup-line med"></span><span class="mockup-check">✓</span></div>
                    <div class="mockup-row"><span class="mockup-line short"></span><span class="mockup-check">✓</span></div>
                </div>
            </div>

            <div class="bonus-card card-yellow tilt-left">
                <div class="card-tape"></div>
                <div class="bonus-header-flex">
                    <span class="bonus-tag">BONUS 03</span>
                    <span class="bonus-icon">💬</span>
                </div>
                <h3>50 Call-To-Action (CTA)</h3>
                <p>Template penutup penawaran dan tombol landing page yang memicu aksi beli spontan.</p>
                <div class="mini-worksheet-preview preview-yellow">
                    <div class="mockup-row"><span class="mockup-line long"></span><span class="mockup-check">✓</span></div>
                    <div class="mockup-row"><span class="mockup-line med"></span><span class="mockup-check">✓</span></div>
                    <div class="mockup-row"><span class="mockup-line short"></span><span class="mockup-check">✓</span></div>
                </div>
            </div>

            <div class="bonus-card card-purple tilt-right">
                <div class="card-tape"></div>
                <div class="bonus-header-flex">
                    <span class="bonus-tag">BONUS 04</span>
                    <span class="bonus-icon">📅</span>
                </div>
                <h3>30-Day Content Calendar</h3>
                <p>Jadwal dan panduan konten 30 hari penuh agar konsisten posting tanpa pusing ide.</p>
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
                    <span class="bonus-icon">📱</span>
                </div>
                <h3>30 WhatsApp Sales Scripts</h3>
                <p>Script obrolan closing untuk customer service mengatasi ragu pembeli & follow up.</p>
                <div class="mini-worksheet-preview preview-teal">
                    <div class="mockup-row"><span class="mockup-line long"></span><span class="mockup-check">✓</span></div>
                    <div class="mockup-row"><span class="mockup-line med"></span><span class="mockup-check">✓</span></div>
                    <div class="mockup-row"><span class="mockup-line short"></span><span class="mockup-check">✓</span></div>
                </div>
            </div>

            <div class="bonus-card card-blue tilt-right">
                <div class="card-tape"></div>
                <div class="bonus-header-flex">
                    <span class="bonus-tag">BONUS 06</span>
                    <span class="bonus-icon">⚙️</span>
                </div>
                <h3>AI Workflow Cheatsheet</h3>
                <p>Diagram alur kerja praktis mengintegrasikan AI ke operasional harian bisnis Anda.</p>
                <div class="mini-worksheet-preview preview-blue">
                    <div class="mockup-flow-chart">
                        <span class="flow-box">IDE</span> → <span class="flow-box">AI</span> → <span class="flow-box">HASIL</span>
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
