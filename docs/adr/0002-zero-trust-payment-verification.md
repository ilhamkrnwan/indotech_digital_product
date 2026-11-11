# Zero-Trust Payment Verification & Secure Download Token Architecture

Untuk mencegah eksploitasi bypass pembayaran via client-side AJAX (`ajax_confirm_payment`) dan serangan IDOR pada file digital di halaman thank-you, seluruh otorisasi pembayaran diubah menjadi model *zero-trust*. Backend server kini memverifikasi status pembayaran langsung ke API resmi Midtrans (`GET /v2/{order_id}/status`) dengan Server Key rahasia sebelum mengubah status menjadi sukses, serta mewajibkan token kriptografis acak 32-karakter (`_download_token`) untuk mengakses halaman pesanan dan rute pengunduhan berkas terlindung (`?action=dpm_download`).

