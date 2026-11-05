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
    const modalProductTitle = document.getElementById('modalProductTitle');
    const modalProductPrice = document.getElementById('modalProductPrice');
    const modalBuyBtn = document.getElementById('modalBuyBtn');

    const buyButtons = document.querySelectorAll('.btn-buy-trigger');
    buyButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const title = btn.getAttribute('data-title');
            const price = btn.getAttribute('data-price');
            
            if (modalProductTitle) modalProductTitle.textContent = title;
            if (modalProductPrice) modalProductPrice.textContent = price;

            // WhatsApp direct link generator
            if (modalBuyBtn) {
                const waPhone = '6281234567890'; // Phone number
                const message = encodeURIComponent(`Halo DigitalProduk, saya ingin memesan:\nProduk: ${title}\nHarga: ${price}\nMohon info instruksi pembayarannya.`);
                modalBuyBtn.href = `https://wa.me/${waPhone}?text=${message}`;
            }

            if (modal) modal.classList.add('active');
        });
    });

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
});
