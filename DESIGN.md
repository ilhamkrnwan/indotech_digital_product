# DESIGN.md - Indotech Technical Commerce Design System

## 1. Brand Identity & Character
* **Brand**: Indotech Digital Store
* **Purpose**: Marketplace dan katalog aset digital (source code web apps, plugin WordPress mandiri, template UI/UX Figma, dan workspace Notion) dengan akses download instan pasca pembayaran otomatis Midtrans (QRIS & Virtual Account).
* **Tone**: Utilitarian, presisi, kredibel, transparan, dan berorientasi teknis.
* **Dial**: ENERGY 2 / RHYTHM 2 / MOTION 1

---

## 2. Color System (Strict Palette: 3 Core + 1 Accent)
* **Base Canvas**: `#f8fafc` (Cool Slate 50)
* **Surface White**: `#ffffff` (Card, Navigation, Modals)
* **Border Standard**: `#e2e8f0` (1px solid, Slate 200)
* **Border Subtle**: `#f1f5f9` (Slate 100)

### Typography & Text Hierarchy
* **Text Primary**: `#0f172a` (Slate 900 - Kontras 14.5:1 terhadap background)
* **Text Secondary**: `#475569` (Slate 600 - Kontras 5.8:1 terhadap background)
* **Text Muted**: `#64748b` (Slate 500 - Kontras 4.6:1 terhadap background)

### Single Deliberate Accent
* **Brand Primary / Focal Action**: `#1d4ed8` (Royal Cobalt Blue - WCAG AA compliant pada putih)
* **Primary Hover**: `#1e40af` (Deep Cobalt)
* **Primary Active**: `#172554`

### Status Indicators (Data Faktual Riil)
* **Status Success (Paid / Verified)**: `#15803d` (Green 700) / bg `#f0fdf4`
* **Status Pending (Waiting Midtrans)**: `#b45309` (Amber 700) / bg `#fffbeb`

---

## 3. Typography Rules
* **Interface & Body Font**: `Plus Jakarta Sans`, sans-serif.
  * Weights: 400 (Regular), 500 (Medium), 600 (Semi-bold), 700 (Bold), 800 (Extra-bold).
* **Technical Monospace**: `JetBrains Mono`, monospace.
  * Hanya digunakan untuk metadata teknis riil: nomor versi, format file (.zip), tipe lisensi, arsitektur kode.
* **Heading Scale**:
  * H1: 2.5rem (40px) / Line height 1.2 / Letter-spacing -0.025em
  * H2: 1.75rem (28px) / Line height 1.3 / Letter-spacing -0.02em
  * H3: 1.25rem (20px) / Line height 1.4 / Letter-spacing -0.01em
  * Body: 1rem (16px) / Line height 1.6

---

## 4. Spacing, Elevation & Radii
* **Radius Scale**:
  * `sm`: 6px (Badges, tags, inputs)
  * `md`: 10px (Buttons, small cards)
  * `lg`: 14px (Product cards, containers)
* **Elevation**:
  * Flat base with 1px border `#e2e8f0`.
  * Elevasi hover: `box-shadow: 0 4px 12px -2px rgba(15, 23, 42, 0.08)`.
  * Tidak menggunakan hard pop shadow atau glow menyebar.

---

## 5. Component Standards
* **Button**:
  * Action Primer: background Cobalt `#1d4ed8`, teks putih, padding `0.65rem 1.25rem`, radius `8px`.
  * Secondary / Action Sekunder: background `#ffffff`, border `1px solid #e2e8f0`, teks `#0f172a`.
  * Tanpa panah dekoratif `→` seragam.
* **Product Card**:
  * Menampilkan preview visual nyata dengan rasio 16:10.
  * Tag teknologi fungsional (misal: "Next.js 15", "WordPress CPT", "Figma Tokens").
  * Menampilkan harga Rupiah yang jelas dan informasi lisensi komersial.
