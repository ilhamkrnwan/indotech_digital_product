/**
 * Interactive Script for Digital Produk Showcase
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. FAQ Accordion Toggle
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const questionBtn = item.querySelector('.faq-question');
        if (questionBtn) {
            questionBtn.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                // Close all other items
                faqItems.forEach(i => i.classList.remove('active'));
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        }
    });

    // 2. Category Filter
    const filterBtns = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filterValue = btn.getAttribute('data-filter');

            productCards.forEach(card => {
                if (filterValue === 'all') {
                    card.style.display = 'flex';
                } else {
                    const cardCategory = card.getAttribute('data-category');
                    if (cardCategory === filterValue) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        });
    });

    // 3. Modal Instant Checkout Trigger
    const modal = document.getElementById('checkoutModal');
    const modalClose = document.getElementById('modalClose');
    const modalProductId = document.getElementById('modalProductId');
    const modalProductTitle = document.getElementById('modalProductTitle');
    const modalProductPrice = document.getElementById('modalProductPrice');
    const modalBuyBtn = document.getElementById('modalBuyBtn');
    const checkoutForm = document.getElementById('midtransCheckoutForm');
    const checkoutNotice = document.getElementById('checkoutNotice');
    const btnPayMidtrans = document.getElementById('btnPayMidtrans');

    const buyButtons = document.querySelectorAll('.btn-buy-trigger');
    buyButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const id = btn.getAttribute('data-id') || '';
            const title = btn.getAttribute('data-title') || '';
            const price = btn.getAttribute('data-price') || '';
            
            if (modalProductId) modalProductId.value = id;
            if (modalProductTitle) modalProductTitle.textContent = title;
            if (modalProductPrice) modalProductPrice.textContent = price;
            if (checkoutNotice) {
                checkoutNotice.style.display = 'none';
                checkoutNotice.textContent = '';
            }

            // WhatsApp direct link fallback generator
            if (modalBuyBtn) {
                const waPhone = '6281234567890';
                const message = encodeURIComponent(`Halo DigitalProduk, saya ingin memesan:\nProduk: ${title}\nHarga: ${price}\nMohon info pembayaran.`);
                modalBuyBtn.href = `https://wa.me/${waPhone}?text=${message}`;
            }

            const fullPageLink = document.getElementById('modalFullPageCheckoutLink');
            if (fullPageLink && id) {
                fullPageLink.href = `${window.location.origin}/digitalproduk/checkout/?product_id=${encodeURIComponent(id)}`;
            }

            if (modal) modal.classList.add('active');
        });
    });

    // 4. Midtrans Checkout Form Submit
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (typeof dpm_vars === 'undefined') {
                alert('Midtrans Gateway plugin belum aktif.');
                return;
            }

            const productId = modalProductId.value;
            const buyerName = document.getElementById('buyerName').value.trim();
            const buyerEmail = document.getElementById('buyerEmail').value.trim();
            const buyerPhone = document.getElementById('buyerPhone').value.trim();

            if (!productId || !buyerName || !buyerEmail) {
                alert('Silakan lengkapi nama dan email Anda.');
                return;
            }

            btnPayMidtrans.disabled = true;
            btnPayMidtrans.textContent = 'Menyiapkan Pembayaran...';

            try {
                const formData = new URLSearchParams();
                formData.append('action', 'dpm_create_order');
                formData.append('nonce', dpm_vars.nonce);
                formData.append('product_id', productId);
                formData.append('name', buyerName);
                formData.append('email', buyerEmail);
                formData.append('phone', buyerPhone);

                const response = await fetch(dpm_vars.ajax_url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: formData.toString()
                });

                const res = await response.json();

                if (!res.success) {
                    checkoutNotice.style.display = 'block';
                    checkoutNotice.style.color = '#ef4444';
                    checkoutNotice.textContent = res.data?.message || 'Gagal memproses pesanan. Periksa Server Key Midtrans di Dashboard.';
                    btnPayMidtrans.disabled = false;
                    btnPayMidtrans.innerHTML = '<span>Bayar Otomatis (Midtrans Snap)</span>';
                    return;
                }

                const snapToken = res.data.snap_token;

                if (typeof window.snap !== 'undefined') {
                    window.snap.pay(snapToken, {
                        onSuccess: function(result) {
                            checkoutNotice.style.display = 'block';
                            checkoutNotice.style.color = '#10b981';
                            checkoutNotice.textContent = 'Pembayaran berhasil dikonfirmasi! Terima kasih.';
                            setTimeout(() => { window.location.reload(); }, 2500);
                        },
                        onPending: function(result) {
                            checkoutNotice.style.display = 'block';
                            checkoutNotice.style.color = '#f59e0b';
                            checkoutNotice.textContent = 'Menunggu pembayaran. Silakan selesaikan tagihan Anda.';
                        },
                        onError: function(result) {
                            checkoutNotice.style.display = 'block';
                            checkoutNotice.style.color = '#ef4444';
                            checkoutNotice.textContent = 'Pembayaran gagal atau dibatalkan.';
                        },
                        onClose: function() {
                            btnPayMidtrans.disabled = false;
                            btnPayMidtrans.innerHTML = '<span>Bayar Otomatis (Midtrans Snap)</span>';
                        }
                    });
                } else if (res.data.redirect) {
                    window.location.href = res.data.redirect;
                } else {
                    alert('Snap SDK belum termuat atau Client Key belum diisi di Admin.');
                    btnPayMidtrans.disabled = false;
                    btnPayMidtrans.innerHTML = '<span>Bayar Otomatis (Midtrans Snap)</span>';
                }

            } catch (err) {
                console.error(err);
                checkoutNotice.style.display = 'block';
                checkoutNotice.style.color = '#ef4444';
                checkoutNotice.textContent = 'Terjadi kesalahan koneksi ke server.';
                btnPayMidtrans.disabled = false;
                btnPayMidtrans.innerHTML = '<span>Bayar Otomatis (Midtrans Snap)</span>';
            }
        });
    }

    if (modalClose) {
        modalClose.addEventListener('click', () => {
            if (modal) modal.classList.remove('active');
        });
    }

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });

    // 5. Interactive Product Image Gallery (Thumbnail Switcher)
    const galleryThumbs = document.querySelectorAll('.gallery-thumb-item');
    const mainPreviewImg = document.getElementById('mainProductPreview');

    if (galleryThumbs.length && mainPreviewImg) {
        galleryThumbs.forEach(thumb => {
            thumb.addEventListener('click', () => {
                const newSrc = thumb.getAttribute('data-preview');
                const newTitle = thumb.getAttribute('data-title');
                if (!newSrc) return;

                galleryThumbs.forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');

                // Smooth fade effect
                mainPreviewImg.style.opacity = '0.3';
                mainPreviewImg.style.transform = 'scale(0.98)';
                
                setTimeout(() => {
                    mainPreviewImg.src = newSrc;
                    if (newTitle) mainPreviewImg.alt = newTitle;
                    mainPreviewImg.style.opacity = '1';
                    mainPreviewImg.style.transform = 'scale(1)';
                }, 120);
            });
        });
    }

    // 6. Navigation Category Dropdown Mobile / Tap Toggle
    const dropdownTrigger = document.querySelector('.nav-dropdown-trigger');
    const dropdownItem = document.querySelector('.nav-item-dropdown');

    if (dropdownTrigger && dropdownItem) {
        dropdownTrigger.addEventListener('click', (e) => {
            // If on touch device, toggle dropdown
            if (window.innerWidth <= 992) {
                e.preventDefault();
                dropdownItem.classList.toggle('open');
            }
        });
    }
});
