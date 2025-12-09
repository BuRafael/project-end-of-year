// Front page JavaScript (carousel, scroll-to-top, hearts)
document.addEventListener('DOMContentLoaded', function() {
    initCarousel();
    initScrollToTop();
    initHearts();
    initTogglePassword();
});

// ========== CAROUSEL ==========
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

    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentIndex = index;
            updateCarousel();
        });
    });

    updateCarousel();
}

// ========== SCROLL TO TOP ==========
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

// ========== HEARTS (Like buttons) ==========
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
