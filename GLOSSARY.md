# Indotech Digital Product E-Commerce

Platform e-commerce katalog dan penjualan aset digital berbasis WordPress dengan integrasi pembayaran Midtrans Snap otomatis.

## Language

### E-Commerce & Catalog

**Digital Product**:
Entitas aset digital yang dijual ke pengguna (berupa template kode, file desain, atau plugin) yang dikelola melalui custom post type `digital_product`.
_Avoid_: Item, barang, listing

**Asset Category**:
Taksonomi klasifikasi produk (`asset_category`) untuk mengelompokkan jenis produk digital berdasarkan formatnya.
_Avoid_: Tag, grup barang

**Product Order**:
Catatan transaksi pesanan (`product_order`) yang mencakup status verifikasi pembayaran Midtrans, rincian pembeli, dan nominal transaksi.
_Avoid_: Invoice, tagihan, bill

### Payment & Gateway

**Snap Token**:
Token sesi pembayaran sementara berumur pendek yang diperoleh dari API Midtrans Snap untuk membuka modal pop-up checkout.
_Avoid_: Payment code, session key

**Payment Notification Webhook**:
Endpoint REST API (`/wp-json/digitalproduk/v1/midtrans-notification`) yang menerima payload status transaksi terverifikasi dari Midtrans.
_Avoid_: Callback URL, return URL

**Gross Amount Validation**:
Proses rekonsiliasi yang memverifikasi bahwa nilai mata uang yang dibayarkan pelanggan di gateway sama persis dengan harga produk di database.
_Avoid_: Price matching, amount check

### Infrastructure & Deployment

**VHost Target**:
Direktori virtual host OpenLiteSpeed pada server VPS (`/home/indotechnology.co.id/public_html`) yang menjadi rumah publik bagi instalasi WordPress ini.
_Avoid_: Web root, public dir

**Investasi Archive**:
Cadangan snapshot file dan dump database lengkap dari situs investasi lama yang diarsipkan di luar direktori publik server.
_Avoid_: Legacy backup, zip lama
