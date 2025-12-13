/**
 * Front Page JavaScript
 * Handles carousel, scroll-to-top, hearts (likes), and form interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    initCarousel();
    initScrollToTop();
    initHearts();
    initCtaButton();
});

/**
 * ========== CAROUSEL ==========
 * Manages the image carousel with arrow and dot navigation
 */
function initCarousel() {
    const track = document.querySelector('.carousel-track');
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const arrowLeft = document.querySelector('.carousel-arrow.left');
    const arrowRight = document.querySelector('.carousel-arrow.right');

    if (!track || slides.length === 0) return;

    let currentIndex = 0;
    const slideWidth = 100; // 100% width per slide

    function updateCarousel() {
        track.style.transform = `translateX(-${currentIndex * slideWidth}%)`;
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
    }

    // Arrow navigation
    if (arrowLeft) {
        arrowLeft.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateCarousel();
        });
    }

    if (arrowRight) {
        arrowRight.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % slides.length;
            updateCarousel();
        });
    }
    updateCarousel();
}

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

/**
 * ========== HEARTS (Like Buttons) ==========
 * Toggle heart icons for films/series/anime
 */
function initHearts() {
    const likeButtons = document.querySelectorAll('.like-btn');

    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const isLiked = this.getAttribute('data-liked') === 'true';
            
            if (isLiked) {
                this.setAttribute('data-liked', 'false');
                this.textContent = '♡'; // empty heart
                this.style.color = '#ffffff';
            } else {
                this.setAttribute('data-liked', 'true');
                this.textContent = '♥'; // filled heart
                this.style.color = '#700118'; // red color
            }
        });
    });
}

/**
 * ========== CTA BUTTON ==========
 * Handle registration button click
 */
function initCtaButton() {
    // Scope to CTA section to avoid hijacking header buttons
    const ctaSection = document.querySelector('.cta-section');
    const ctaBtn = ctaSection ? ctaSection.querySelector('.cta-btn') : null;
    if (!ctaBtn) return;

    ctaBtn.addEventListener('click', function(e) {
        e.preventDefault();
        // Redirect to the actual inscription page
        window.location.href = '/inscription';
    });
}
// ========== PASSWORD TOGGLE (for login template) ==========
function initTogglePassword() {
    const toggle = document.getElementById('togglePassword');
    const pwd = document.getElementById('passwordField');
    if (!toggle || !pwd) return;

    toggle.addEventListener('click', () => {
        const type = pwd.getAttribute('type') === 'password' ? 'text' : 'password';
        pwd.setAttribute('type', type);
        toggle.textContent = type === 'password' ? '👁️' : '🙈';
    });
}
