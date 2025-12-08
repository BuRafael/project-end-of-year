// Main JavaScript file

document.addEventListener('DOMContentLoaded', function() {
    initScrollTop();
    initCarousel();
    initTogglePassword();
});

// Scroll top button
function initScrollTop() {
    const scrollBtn = document.getElementById("scrollTopBtn");
    if (!scrollBtn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            scrollBtn.classList.add('show');
        } else {
            scrollBtn.classList.remove('show');
        }
    });

    scrollBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// Carousel functionality
function initCarousel() {
    const carousel = document.querySelector('.carousel-image-wrapper');
    const images = document.querySelectorAll('.carousel-image');
    const dots = document.querySelectorAll('.dot');
    const arrowLeft = document.querySelector('.carousel-arrow.left');
    const arrowRight = document.querySelector('.carousel-arrow.right');

    if (!carousel || images.length === 0) return;

    let currentIndex = 0;

    function showImage(index) {
        images.forEach((img, i) => {
            img.style.display = i === index ? 'block' : 'none';
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
    }

    if (arrowRight) {
        arrowRight.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % images.length;
            showImage(currentIndex);
        });
    }

    if (arrowLeft) {
        arrowLeft.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            showImage(currentIndex);
        });
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentIndex = index;
            showImage(currentIndex);
        });
    });
}

// Toggle password visibility for login template
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
