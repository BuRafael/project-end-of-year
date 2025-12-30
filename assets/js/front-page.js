/**
 * Front Page JavaScript
 * Handles carousel, scroll-to-top, hearts (likes), and form interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    initCarousel();
    // Suppression du scroll-to-top sur la front page
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
function getUserFavorites(type, callback) {
  fetch(window.cinemusicAjax.ajaxurl, {
    method: 'POST',
    credentials: 'same-origin',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'action=get_user_favorites'
  })
    .then(r => r.json())
    .then(data => {
      if (data.success && data.data && data.data[type]) {
        callback(data.data[type]);
      } else {
        callback([]);
      }
    });
}

function updateFavorite(action, type, item, callback) {
  const form = new FormData();
  form.append('action', action);
  form.append('type', type);
  if (action === 'add_user_favorite') {
    form.append('item', JSON.stringify(item));
  } else {
    form.append('id', item.id);
  }
  fetch(window.cinemusicAjax.ajaxurl, {
    method: 'POST',
    credentials: 'same-origin',
    body: form
  })
    .then(r => r.json())
    .then(data => callback(data));
}

function normalizeType(type) {
  if (type === 'film') return 'films';
  if (type === 'serie') return 'series';
  return type;
}

function initHearts() {
  const likeButtons = document.querySelectorAll('.like-btn');
  // On charge les favoris de l'utilisateur connecté
  getUserFavorites('films', favFilms => {
    getUserFavorites('series', favSeries => {
      likeButtons.forEach(button => {
        const mediaCard = button.closest('.media-card, .film-card, .serie-card, li, .track-row');
        const mediaTypeRaw = button.dataset.type || 'films';
        const mediaType = normalizeType(mediaTypeRaw);
        let mediaId = '', mediaTitle = '', mediaImage = '', mediaLink = '', item = {};
        if (mediaType === 'musiques') {
          // Cas piste/musique (ex: top 5 musiques)
          mediaId = button.dataset.trackId || mediaCard?.dataset.trackId || '';
          mediaTitle = button.dataset.trackTitle || mediaCard?.dataset.trackTitle || '';
          mediaImage = button.dataset.trackCover || mediaCard?.dataset.trackCover || '';
          const artist = button.dataset.trackArtist || mediaCard?.dataset.trackArtist || '';
          const duration = button.dataset.trackDuration || mediaCard?.dataset.trackDuration || '';
          const source = button.dataset.trackSource || mediaCard?.dataset.trackSource || '';
          mediaLink = button.dataset.trackUrl || mediaCard?.dataset.trackUrl || '';
          item = { id: mediaId, title: mediaTitle, artist, duration, cover: mediaImage, source, url: mediaLink };
        } else {
          // Cas film/série
          mediaTitle = mediaCard?.querySelector('.media-title, .film-title, .serie-title, .top-title-link')?.textContent || '';
          mediaLink = mediaCard?.querySelector('a')?.href || '';
          mediaId = mediaLink.split('/').filter(Boolean).pop() || '';
          mediaImage = button.dataset.poster || mediaCard?.querySelector('img')?.src || '';
          item = { id: mediaId, title: mediaTitle, image: mediaImage, url: mediaLink };
        }
        // Vérifier si déjà favori
        let isFav = false;
        if (mediaType === 'films') isFav = favFilms.some(f => f.id === mediaId);
        else if (mediaType === 'series') isFav = favSeries.some(s => s.id === mediaId);
        // TODO: charger favMusiques si besoin
        if (isFav) {
          button.setAttribute('data-liked', 'true');
          button.textContent = '♥';
          button.style.color = '#700118';
        } else {
          button.setAttribute('data-liked', 'false');
          button.textContent = '♡';
          button.style.color = '#ffffff';
        }
        button.addEventListener('click', function(e) {
          e.preventDefault();
          const isLiked = this.getAttribute('data-liked') === 'true';
          if (isLiked) {
            updateFavorite('remove_user_favorite', mediaType, item, () => {
              this.setAttribute('data-liked', 'false');
              this.textContent = '♡';
              this.style.color = '#ffffff';
            });
          } else {
            updateFavorite('add_user_favorite', mediaType, item, () => {
              this.setAttribute('data-liked', 'true');
              this.textContent = '♥';
              this.style.color = '#700118';
            });
          }
        });
      });
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
