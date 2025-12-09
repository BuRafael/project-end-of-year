// Main JavaScript - CINEMUSIC Theme

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


if (nextBtn && prevBtn) {
  nextBtn.addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % slides.length;
    updateCarousel(currentIndex);
  });

  prevBtn.addEventListener("click", () => {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    updateCarousel(currentIndex);
  });

  dots.forEach((dot, i) => {
    dot.addEventListener("click", () => {
      currentIndex = i;
      updateCarousel(currentIndex);
    });
  });
}

// BOUTON RETOUR EN HAUT
const scrollBtn = document.querySelector(".scroll-to-top");

if (scrollBtn) {
  window.addEventListener("scroll", () => {
    if (window.scrollY > 400) {
      scrollBtn.style.display = "flex";
    } else {
      scrollBtn.style.display = "none";
    }
  });

  scrollBtn.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });

  // caché au départ
  scrollBtn.style.display = "none";
}

// Main JavaScript file

document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('.site-header');

    const handleHeaderShadow = () => {
        if (!header) return;
        if (window.scrollY > 10) {
            header.classList.add('is-scrolled');
        } else {
            header.classList.remove('is-scrolled');
        }
    };

    handleHeaderShadow();
    window.addEventListener('scroll', handleHeaderShadow, { passive: true });

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

    // Ripple effect on buttons / social icons / upload
    const rippleTargets = document.querySelectorAll('.btn-inscription, .social-icon, .btn-upload, .btn-ghost, .btn-register-primary');
    rippleTargets.forEach((el) => {
        el.style.position = el.style.position || 'relative';
        el.style.overflow = 'hidden';

        el.addEventListener('pointerdown', (e) => {
            const rect = el.getBoundingClientRect();
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            el.appendChild(ripple);
            setTimeout(() => ripple.remove(), 450);
        });
    });

    // Password visibility toggles
    const toggleButtons = document.querySelectorAll('[data-toggle-password]');
    toggleButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-toggle-password');
            const input = document.getElementById(targetId);
            if (!input) return;
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.classList.toggle('is-active', isHidden);
        });
    });

    // Avatar preview
    const avatarInput = document.getElementById('avatar_file');
    const avatarPlaceholder = document.getElementById('avatarPlaceholder');
    const avatarPreviewImg = document.getElementById('avatarPreviewImg');
    if (avatarInput) {
        avatarInput.addEventListener('change', (e) => {
            const file = e.target.files && e.target.files[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            if (avatarPreviewImg) {
                avatarPreviewImg.src = url;
                avatarPreviewImg.style.display = 'block';
            } else if (avatarPlaceholder) {
                const img = document.createElement('img');
                img.id = 'avatarPreviewImg';
                img.src = url;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                avatarPlaceholder.replaceWith(img);
            }
        });
    }
});

