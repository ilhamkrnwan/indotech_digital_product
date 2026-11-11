/**
 * Interactive Script for Digital Produk Showcase
 */

document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.querySelector('.menu-toggle');
    const navigation = document.querySelector('.main-navigation');

    if (menuToggle && navigation) {
        const closeNavigation = () => {
            menuToggle.setAttribute('aria-expanded', 'false');
            navigation.classList.remove('is-open');
        };

        menuToggle.addEventListener('click', () => {
            const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', String(!expanded));
            navigation.classList.toggle('is-open', !expanded);
        });

        navigation.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 860) {
                    closeNavigation();
                }
            });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && navigation.classList.contains('is-open')) {
                closeNavigation();
                menuToggle.focus();
            }
        });
    }

    // Category Filter
    const filterBtns = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterBtns.forEach(b => b.setAttribute('aria-pressed', 'false'));
            btn.setAttribute('aria-pressed', 'true');

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

    // 6. Navigation Category Dropdown
    const dropdownTrigger = document.querySelector('.nav-dropdown-trigger');
    const dropdownItem = document.querySelector('.nav-item-dropdown');

    if (dropdownTrigger && dropdownItem) {
        const closeCategoryDropdown = () => {
            dropdownItem.classList.remove('open');
            dropdownTrigger.setAttribute('aria-expanded', 'false');
        };

        dropdownTrigger.addEventListener('click', () => {
            const expanded = dropdownTrigger.getAttribute('aria-expanded') === 'true';
            dropdownItem.classList.toggle('open', !expanded);
            dropdownTrigger.setAttribute('aria-expanded', String(!expanded));
        });

        document.addEventListener('click', (event) => {
            if (!dropdownItem.contains(event.target)) {
                closeCategoryDropdown();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeCategoryDropdown();
            }
        });
    }
});
