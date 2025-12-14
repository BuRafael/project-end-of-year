/**
 * ========== GENERIC CAROUSEL ========== 
 * Reusable carousel logic for similar items (movies/series)
 * Usage: initGenericCarousel({
 *   containerId: 'similarMovies',
 *   items: [...],
 *   getCardHtml: (item) => `<div>...</div>`
 * })
 */
function initGenericCarousel({ containerId, items, getCardHtml, itemsPerPage = 4, leftArrowSelector = '.carousel-arrow.left', rightArrowSelector = '.carousel-arrow.right', transitionClass = 'is-transitioning' }) {
    const container = document.getElementById(containerId);
    const leftArrow = document.querySelector(leftArrowSelector);
    const rightArrow = document.querySelector(rightArrowSelector);
    let carouselIndex = 0;
    let lastDirection = 1;
    function render(direction = 1) {
        if (!container) return;
        container.innerHTML = '';
        for (let i = 0; i < itemsPerPage; i++) {
            const index = (carouselIndex + i) % items.length;
            container.innerHTML += getCardHtml(items[index]);
        }
        container.classList.remove('slide-left', 'slide-right');
        if (direction === -1) container.classList.add('slide-left');
        if (direction === 1) container.classList.add('slide-right');
        setTimeout(() => {
            container.classList.remove('slide-left', 'slide-right');
        }, 400);
    }
    function animate(delta) {
        if (!container) return;
        lastDirection = delta;
        carouselIndex = (carouselIndex + delta + items.length) % items.length;
        render(delta);
    }
    if (leftArrow) leftArrow.addEventListener('click', () => animate(-1));
    if (rightArrow) rightArrow.addEventListener('click', () => animate(1));
    render();
}
// Main JavaScript - Global site-wide helpers

document.addEventListener('DOMContentLoaded', () => {
    // Smooth scroll for in-page anchors
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (e) => {
            const targetId = anchor.getAttribute('href');
            if (!targetId || targetId === '#') return;
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Scroll to top button
    initScrollToTop();
});

/**
 * ========== SCROLL TO TOP ==========
 * Shows/hides button and scrolls to top smoothly
 */
function initScrollToTop() {
    const scrollBtn = document.getElementById('scrollToTop');
    if (!scrollBtn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            scrollBtn.style.display = 'flex';
        } else {
            scrollBtn.style.display = 'none';
        }
    });

    scrollBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

