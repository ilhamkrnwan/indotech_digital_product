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

    // 3. Interactive Product Image Gallery (Thumbnail Switcher)
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
