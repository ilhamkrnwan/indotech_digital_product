# Indotech Digital Product Showcase & Midtrans Gateway

Platform e-commerce katalog produk digital berbasis WordPress dengan tema kustom bergaya neo-brutalisme ceria, integrasi gateway pembayaran **Midtrans Snap**, serta modul pengamanan sistem tingkat lanjut.

---

## 🚀 Fitur Utama

- **Custom Digital Product CPT & Taxonomy**: Manajemen produk digital, kategori aset, badge, harga diskon, rating, dan checklist fitur.
- **Neo-Brutalist Custom Theme (`digitalproduk-theme`)**: Tampilan visual ceria, washi tape, ikon Lucide SVG terintegrasi, galeri multi-preview, dan responsif mobile.
- **Midtrans Snap Payment Integration (`digitalproduk-midtrans`)**:
  - Modal checkout instan & Halaman checkout mandiri ([`/checkout/`](http://127.0.0.1/digitalproduk/checkout/)).
  - Mendukung QRIS, GoPay, ShopeePay, Virtual Account Bank (BCA, Mandiri, BNI, BRI, Permata), dan Kartu Kredit.
  - Webhook notifikasi otomatis dengan verifikasi kriptografi SHA-512 (`hash_equals`).
  - Rekonsiliasi nominal pembayaran (*Gross Amount Validation*) & proteksi *state immutability*.
  - Rate limiting checkout per IP via WordPress Transients.
- **Core Security Hardening (`wp-content/mu-plugins/security-hardening.php`)**:
  - Eliminasi total XML-RPC & header X-Pingback.
  - Blokir user & author enumeration (`/?author=X` dan REST endpoint `/wp/v2/users`).
  - Penyamaran pesan kesalahan login untuk mencegah username harvesting.
  - Injeksi HTTP Security Headers (X-Content-Type-Options, X-Frame-Options, X-XSS-Protection, Referrer-Policy).
  - Isolasi folder upload dari eksekusi file script/PHP.
  - `DISALLOW_FILE_EDIT` diaktifkan di `wp-config.php`.

---

## 🛠️ Instalasi & Setup Lokal (Laragon)

1. Clone repositori ini ke direktori root web server (contoh: `C:\laragon\www\digitalproduk`).
2. Buat database MySQL dengan nama `digitalproduk` di phpMyAdmin.
3. Sesuaikan koneksi database di file `wp-config.php`.
4. Buka dashboard WP-Admin di `http://127.0.0.1/digitalproduk/wp-login.php`.
5. Masuk ke menu **Produk Digital > Pengaturan Midtrans** dan masukkan **Server Key** & **Client Key** Midtrans Anda.
6. Halaman checkout mandiri dapat diakses di `http://127.0.0.1/digitalproduk/checkout/`.

---

## 📄 Lisensi
Hak Cipta © 2026 Indotech Digital. Seluruh hak cipta dilindungi.

