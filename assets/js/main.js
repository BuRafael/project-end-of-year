// Fonction pour initialiser le bouton scroll-to-top sur toutes les pages longues
function initScrollToTop() {
    if (document.getElementById('scrollToTop')) return;
    const btn = document.createElement('button');
    btn.className = 'scroll-to-top';
    btn.id = 'scrollToTop';
    btn.type = 'button';
    btn.setAttribute('aria-label', 'Remonter en haut');
    btn.style.display = 'none';
    btn.innerHTML = `
        <svg width="40" height="40" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <polyline class="scroll-arrow" points="7,17 14,10 21,17" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
        </svg>
    `;
    document.body.appendChild(btn);
    function checkScroll() {
        if (window.innerHeight + 100 < document.body.scrollHeight) {
            btn.style.display = window.scrollY > 200 ? 'flex' : 'none';
        } else {
            btn.style.display = 'none';
        }
    }
    window.addEventListener('scroll', checkScroll);
    window.addEventListener('resize', checkScroll);
    checkScroll();
    btn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}
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
    // Scroll to top button (disable on fiche film page)
    if (!document.body.classList.contains('page-template-template-fiche-film')) {
        initScrollToTop();
    }
});



