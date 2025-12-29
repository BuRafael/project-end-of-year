/**
 * Front Page JavaScript
 * Handles carousel, scroll-to-top, hearts (likes), and form interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    initCarousel();
    if (typeof initScrollToTop === 'function') initScrollToTop();
    initHearts();
    initCtaButton();
    animateCountersOnScroll();
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
 * ========== HEARTS (Like Buttons) ==========
 * Toggle heart icons for films/series/anime
 */
function initHearts() {
    const likeButtons = document.querySelectorAll('.like-btn');

    likeButtons.forEach(button => {
        // Récupérer l'ID du média (film/série)
        const mediaCard = button.closest('.media-card, .film-card, .serie-card, li');
        const mediaTitle = mediaCard?.querySelector('.media-title, .film-title, .serie-title, .top-title-link')?.textContent || '';
        const mediaLink = mediaCard?.querySelector('a')?.href || '';
        const mediaId = mediaLink.split('/').filter(Boolean).pop() || '';
        const mediaType = button.dataset.type || 'film'; // 'film' ou 'serie'
        
        // Utiliser data-poster si disponible (grandes affiches), sinon fallback sur l'image affichée
        const mediaImage = button.dataset.poster || mediaCard?.querySelector('img')?.src || '';
        
        // Vérifier si déjà en favoris
        const storageKey = mediaType === 'serie' ? 'favoriteSeries' : 'favoriteFilms';
        const favorites = JSON.parse(localStorage.getItem(storageKey) || '[]');
        const isAlreadyFavorite = favorites.some(item => item.id === mediaId);
        
        if (isAlreadyFavorite) {
            button.setAttribute('data-liked', 'true');
            button.textContent = '♥';
            button.style.color = '#700118';
        }
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const isLiked = this.getAttribute('data-liked') === 'true';
            
            if (isLiked) {
                this.setAttribute('data-liked', 'false');
                this.textContent = '♡'; // empty heart
                this.style.color = '#ffffff';
                
                // Retirer des favoris
                let favorites = JSON.parse(localStorage.getItem(storageKey) || '[]');
                favorites = favorites.filter(item => item.id !== mediaId);
                localStorage.setItem(storageKey, JSON.stringify(favorites));
            } else {
                this.setAttribute('data-liked', 'true');
                this.textContent = '♥'; // filled heart
                this.style.color = '#700118'; // red color
                
                // Ajouter aux favoris
                let favorites = JSON.parse(localStorage.getItem(storageKey) || '[]');
                const mediaData = {
                    id: mediaId,
                    title: mediaTitle,
                    image: mediaImage,
                    url: mediaLink,
                    year: new Date().getFullYear().toString() // À améliorer si l'année est disponible
                };
                
                if (!favorites.some(item => item.id === mediaId)) {
                    favorites.push(mediaData);
                    localStorage.setItem(storageKey, JSON.stringify(favorites));
                }
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

// ========== COMPTEUR ANIMÉ AU SCROLL ========== 
function animateCountersOnScroll() {
  const counters = document.querySelectorAll('.front-stats__number');

  function animateCounter(counter) {
    const target = +counter.getAttribute('data-animate-number');
    const duration = 1200;
    const start = 0;
    let startTimestamp = null;

    function step(timestamp) {
      if (!startTimestamp) startTimestamp = timestamp;
      const progress = Math.min((timestamp - startTimestamp) / duration, 1);
      counter.textContent = '+' + Math.floor(progress * (target - start) + start);
      if (progress < 1) {
        window.requestAnimationFrame(step);
      } else {
        counter.textContent = '+' + target;
      }
    }
    window.requestAnimationFrame(step);
  }

  function onScroll() {
    const statsSection = document.querySelector('.front-stats');
    if (!statsSection) return;
    const rect = statsSection.getBoundingClientRect();
    if (rect.top < window.innerHeight && rect.bottom > 0) {
      counters.forEach(counter => {
        animateCounter(counter);
      });
    }
  }
  window.addEventListener('scroll', onScroll);
  // Relance aussi à chaque focus de la fenêtre
  window.addEventListener('focus', onScroll);
}

document.addEventListener('DOMContentLoaded', function() {
  initCarousel();
  if (typeof initScrollToTop === 'function') initScrollToTop();
  initHearts();
  initCtaButton();
  animateCountersOnScroll();
});
