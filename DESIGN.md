# DESIGN.md - Indotechnology Modern Cyber Fusion Design System

## 1. Brand Identity & Character
* **Brand**: Indotechnology (`BUILD • INNOVATE • GROW`)
* **Purpose**: Marketplace & katalog aset digital teknik tingkat lanjut (source code web apps, plugin WordPress mandiri, template UI/UX Figma, dan workspace Notion) dengan download instan pasca pembayaran terverifikasi otomatis Midtrans (QRIS & Virtual Account).
* **Archetype**: Modern Cyber Fusion (Enterprise Tech Authority + High-Energy Futuristic Precision).
* **Tone**: Presisi, inovatif, kredibel, performa tinggi, dan berorientasi engineer/builder.
* **Dial**: ENERGY 3 / RHYTHM 3 / MOTION 2

---

## 2. Color System (Strict Palette: Logo-Derived)
Diadaptasi secara presisi dari logo resmi Indotechnology:
* Monogram: Pita dinamis gradasi Electric Blue & Cyan ke Growth Lime dengan digital pixel blocks.
* Tipografi: "indo" Deep Tech Navy, "technology" Electric Blue, tagline dengan pemisah titik Lime Green.

### Core Brand Tokens
* **Brand Deep Navy**: `#0b1727` (Fondasi teks, header brand dark, dan kontras tertinggi - 15.2:1 AAA)
* **Brand Midnight Dark**: `#070c14` (Dasar hero canvas, background terminal aksen)
* **Brand Electric Blue**: `#0066ff` (Core primary action, link interaktif, brand lead)
  * Blue Hover: `#0052cc`
  * Blue Subtle / Tint: `#eff6ff` (10% tint untuk tag & status aktif)
  * Blue Border: `#bfdbfe`
* **Brand Cyber Cyan**: `#00d2ff` (Aksen digital, gradien highlight, cyber glow)
  * Cyan Subtle: `#e0f2fe`
* **Brand Growth Lime**: `#10b981` (Sinyal download instan, verifikasi sukses, tagline bullet)
  * Lime Hover: `#059669`
  * Lime Subtle: `#ecfdf5`
  * Lime Border: `#a7f3d0`

### Surface & Neutral Palette
* **Base Canvas**: `#f8fafc` (Cool Slate 50)
* **Surface White**: `#ffffff` (Card, Navigation, Modals, Forms)
* **Border Standard**: `#e2e8f0` (1px solid Slate 200)
* **Border Subtle**: `#f1f5f9` (Slate 100)
* **Border Tech Glowing**: `rgba(0, 210, 255, 0.25)`

### Typography & Contrast (WCAG AA & AAA Compliant)
* **Text Primary**: `#0b1727` (Deep Navy - 15.2:1 terhadap `#f8fafc`)
* **Text Inverted**: `#f8fafc` / `#ffffff` (terhadap Dark Navy Hero)
* **Text Secondary**: `#475569` (Slate 600 - 5.8:1)
* **Text Muted**: `#64748b` (Slate 500 - 4.6:1)

### Gradient Presets
* **Gradient Brand Tech**: `linear-gradient(90deg, #00d2ff 0%, #10b981 100%)`
* **Gradient Hero Fusion**: `linear-gradient(135deg, #0b1727 0%, #0d213f 50%, #064e3b 100%)`
* **Gradient Primary Button**: `linear-gradient(90deg, #0066ff 0%, #0284c7 100%)`
* **Gradient Button Hover**: `linear-gradient(90deg, #0052cc 0%, #0369a1 100%)`

---

## 3. Typography Rules
* **Primary Interface Font**: `Plus Jakarta Sans`, sans-serif.
  * Weights: 400 (Regular), 500 (Medium), 600 (Semi-bold), 700 (Bold), 800 (Extra-bold).
* **Technical Monospace**: `JetBrains Mono`, monospace.
  * Digunakan untuk nomor versi, format file (.zip, .fig), kode SKU, perintah CLI / clone.
* **Heading Scale**:
  * Hero H1: 2.5rem (40px) / Line height 1.2 / Letter-spacing -0.025em / Semi-bold + Tech Gradient keyword
  * Section H2: 1.75rem (28px) / Line height 1.3 / Letter-spacing -0.02em / Bold Navy `#0b1727`
  * Card H3: 1.15rem (18.5px) / Line height 1.4 / Weight 700
  * Body: 0.95rem - 1rem / Line height 1.6 / Color `#475569`

---

## 4. Spacing, Elevation & Radii
* **Radius Scale**:
  * `pill`: 9999px (Status badges, pill tags, category filters)
  * `sm`: 6px (Micro badges, inputs, terminal tags)
  * `md`: 8px (Buttons, search inputs, dropdown items)
  * `lg`: 12px (Product cards, feature boxes)
  * `xl`: 16px (Hero container, checkout summary card)
* **Elevation**:
  * Flat base with 1px border `#e2e8f0`.
  * Card hover: `box-shadow: 0 10px 25px -5px rgba(11, 23, 39, 0.08), 0 4px 10px -2px rgba(11, 23, 39, 0.03);`
  * Button active/focus: `box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.35);`

---

## 5. Component Standards
* **Site Header**:
  * Logo asli Indotechnology dengan ratio terukur (tinggi 34px desktop, 26px mobile).
  * Navigasi clean text dengan border underline elektrik dan dropdown terstruktur.
* **Hero Section (Modern Cyber Fusion)**:
  * Latar Dark Navy Gradient dengan subtle tech dot grid pattern.
  * Badge Tagline: `BUILD • INNOVATE • GROW` dalam cyber glow pill.
  * Search bar terintegrasi dengan tombol cari gradasi biru elektrik.
  * Trust proof row dengan centang Lime `#10b981`.
* **Product Card**:
  * Preview cover 16:10 dengan rasio tajam.
  * Badge status download instan berwarna Lime Green `#10b981`.
  * Tag teknologi fungsional (Figma, Source Code, Notion).
  * Tombol beli primer bergradasi biru dengan elevasi modern.
* **Zero AI-Slop & Craft Floor**:
  * Tanpa elemen goresan cat kuas akrilik atau cipratan cat kuning acak.
  * Tanpa ikon panah seragam `→` tanpa arti.
  * Border presisi 1px, whitespace seimbang, visual hierarchy tegas.
