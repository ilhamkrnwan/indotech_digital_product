# Panduan Konfigurasi Midtrans & Checklist Pengujian

Dokumen ini berisi panduan langkah-langkah yang perlu Anda lakukan di **Midtrans Dashboard** dan **WordPress** agar integrasi pembayaran berjalan 100% lancar, valid, dan aman.

---

## 1. Status Konfigurasi Saat Ini (WordPress)

| Parameter | Status Saat Ini | Catatan |
|---|---|---|
| **Mode Environment** | `Production` | Aktif (menggunakan kredensial live) |
| **Server Key** | Terkonfigurasi (`Mid-server-...`) | Tersimpan aman di database |
| **Client Key** | Terkonfigurasi (`Mid-client-...`) | Dipakai oleh script `snap.js` |
| **Status API Snap** | **Berhasil Terhubung (HTTP 201)** | Token Snap sudah berhasil digenerate |
| **Halaman Checkout** | [http://127.0.0.1/digitalproduk/checkout/](http://127.0.0.1/digitalproduk/checkout/) | Halaman checkout mandiri siap pakai |

---

## 2. Yang Perlu Anda Lakukan di Dashboard Midtrans

Buka [dashboard.midtrans.com](https://dashboard.midtrans.com/) dan pastikan toggle di pojok kiri atas berada pada **Production** (karena kunci yang digunakan saat ini adalah kunci Production).

### Langkah 1: Atur Notification URL (Webhook)
Webhook ini bertugas menerima konfirmasi otomatis saat pembeli menyelesaikan pembayaran (QRIS, VA Bank, dsb), lalu otomatis mengubah status pesanan dari `pending` menjadi `success`.

1. Di Midtrans Dashboard, buka menu **Settings** &rarr; **Configuration**.
2. Cari kolom **Payment Notification URL**.
3. Masukkan URL notifikasi Anda:
   * **Jika sudah di Hosting / Domain Publik**:
     ```text
     https://nama-domain-anda.com/wp-json/digitalproduk/v1/midtrans-notification
     ```
   * **Jika masih di Komputer Lokal (Laragon)**:
     Server Midtrans tidak bisa mengirim sinyal ke `http://127.0.0.1` atau `.test`. Anda perlu menggunakan tunnel publik sementara (lihat Bagian 3 di bawah).
4. Klik **Save Changes**.

---

### Langkah 2: Atur Finish & Unfinish Redirect URL
Agar setelah pembeli membayar di popup Snap mereka diarahkan kembali ke website Anda:

1. Masih di menu **Settings** &rarr; **Configuration**.
2. Masukkan URL berikut:
   * **Finish Redirect URL**:
     ```text
     http://127.0.0.1/digitalproduk/checkout/?status=finish
     ```
   * **Unfinish Redirect URL**:
     ```text
     http://127.0.0.1/digitalproduk/checkout/?status=unfinish
     ```
   * **Error Redirect URL**:
     ```text
     http://127.0.0.1/digitalproduk/checkout/?status=error
     ```
3. Klik **Save Changes**.

---

### Langkah 3: Aktifkan Metode Pembayaran (Payment Channels)
1. Buka menu **Settings** &rarr; **Snap Preferences** &rarr; **Payment Channels**.
2. Centang metode pembayaran yang ingin Anda sediakan:
   * **E-Wallet**: QRIS (Gopay, OVO, Dana, LinkAja, ShopeePay).
   * **Virtual Account Bank**: BCA, Mandiri, BNI, BRI, Permata.
   * **Kartu Kredit/Debit** (jika sudah di-approve oleh Midtrans).
3. Klik **Save**.

---

## 3. Cara Menguji Webhook Notifikasi di Lingkungan Lokal (Laragon)

Karena Midtrans berada di cloud publik dan website Anda di `127.0.0.1`, ada 2 opsi pengujian:

### Opsi A: Menggunakan Cloudflare Tunnel (Gratis, Tanpa Daftar)
Buka terminal PowerShell baru dan jalankan:
```powershell
winget install --id Cloudflare.cloudflared
cloudflared tunnel --url http://127.0.0.1:80
```
Anda akan mendapatkan URL publik sementara (contoh: `https://contoh-random.trycloudflare.com`).
Tempelkan ke Midtrans Notification URL:
```text
https://contoh-random.trycloudflare.com/digitalproduk/wp-json/digitalproduk/v1/midtrans-notification
```

### Opsi B: Menggunakan Ngrok
```powershell
ngrok http 80
```
Tempelkan URL ngrok yang didapat:
```text
https://xxxx-xx-xx.ngrok-free.app/digitalproduk/wp-json/digitalproduk/v1/midtrans-notification
```

---

## 4. Keamanan yang Sudah Diterapkan Otomatis

Website ini sudah diproteksi dengan standar keamanan finansial tinggi:
1. **Verifikasi Signature SHA-512**: Setiap request webhook dicocokkan dengan Server Key via `hash_equals()`. Webhook tanpa signature valid akan ditolak (403 Forbidden).
2. **Gross Amount Protection**: Nominal yang dibayar di Midtrans wajib sama persis dengan harga produk di database (mencegah manipulasi harga/tampering).
3. **State Immutability**: Order yang sudah berstatus `success` tidak bisa diturunkan menjadi `failed` atau `pending` oleh request susulan.
4. **Rate Limiting Checkout**: Permintaan pemesanan dibatasi maksimal 10 kali per 5 menit per alamat IP guna mencegah serangan bot flooding.
5. **No PHP in Uploads**: Folder upload dikunci oleh `.htaccess` agar tidak bisa mengeksekusi file berbahaya.
6. **XML-RPC Dinonaktifkan**: Menutup celah brute force login dan DDoS pingback.

---

## 5. Ringkasan Link Penting

* **Halaman Checkout Langsung**: [http://127.0.0.1/digitalproduk/checkout/](http://127.0.0.1/digitalproduk/checkout/)
* **Pengaturan Midtrans di WP-Admin**: [http://127.0.0.1/digitalproduk/wp-admin/edit.php?post_type=digital_product&page=midtrans-settings](http://127.0.0.1/digitalproduk/wp-admin/edit.php?post_type=digital_product&page=midtrans-settings)
* **Daftar Pesanan / Orders Masuk**: [http://127.0.0.1/digitalproduk/wp-admin/edit.php?post_type=product_order](http://127.0.0.1/digitalproduk/wp-admin/edit.php?post_type=product_order)
* **Midtrans Merchant Dashboard**: [https://dashboard.midtrans.com/](https://dashboard.midtrans.com/)

