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

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const motionTargets = document.querySelectorAll('.motion-reveal, .product-card');

    if (!reducedMotion && motionTargets.length) {
        document.body.classList.add('motion-ready');
        motionTargets.forEach((target) => target.classList.add('motion-reveal'));

        if ('IntersectionObserver' in window) {
            const motionObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                });
            }, { threshold: 0.14 });

            motionTargets.forEach((target) => motionObserver.observe(target));
        } else {
            motionTargets.forEach((target) => target.classList.add('is-visible'));
        }
    } else {
        motionTargets.forEach((target) => target.classList.add('is-visible'));
    }

    const heroStage = document.querySelector('.hero-parallax-stage');
    const heroSection = document.querySelector('.hero-section');
    const heroContainer = document.querySelector('.hero-container');

    if (!reducedMotion && heroStage && heroSection && heroContainer) {
        let animationFrame;

        const updateHeroParallax = () => {
            animationFrame = undefined;
            const stageBounds = heroStage.getBoundingClientRect();
            const travel = Math.max(heroStage.offsetHeight - heroSection.offsetHeight, 1);
            const progress = Math.min(Math.max(-stageBounds.top / travel, 0), 1);

            heroSection.style.setProperty('--hero-parallax-y', `${progress * -64}px`);
            heroSection.style.setProperty('--hero-nebula-scale', `${1 + progress * 0.075}`);
            heroContainer.style.setProperty('--hero-content-parallax-y', `${progress * 34}px`);
        };

        const requestParallaxUpdate = () => {
            if (!animationFrame) {
                animationFrame = window.requestAnimationFrame(updateHeroParallax);
            }
        };

        updateHeroParallax();
        window.addEventListener('scroll', requestParallaxUpdate, { passive: true });
        window.addEventListener('resize', requestParallaxUpdate);
    }
});
