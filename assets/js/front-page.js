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
  let ajaxUrl = '';
  if (window.cinemusicAjax && window.cinemusicAjax.ajaxurl) {
    ajaxUrl = window.cinemusicAjax.ajaxurl;
  } else if (window.ajaxurl) {
    ajaxUrl = window.ajaxurl;
    console.warn('[LikeBtn] cinemusicAjax non défini, fallback sur window.ajaxurl');
  } else {
    console.error('[LikeBtn] ERREUR: Aucune URL AJAX trouvée (ni window.cinemusicAjax.ajaxurl ni window.ajaxurl)');
    return;
  }
  fetch(ajaxUrl, {
    method: 'POST',
    credentials: 'same-origin',
    body: form
  })
    .then(r => r.json())
    .then(data => callback(data));
}

function normalizeType(type) {
  if (type === 'film') return 'films';
  if (type === 'serie' || type === 'anime') return 'series';
  return type;
}

function initHearts() {
  const likeButtons = document.querySelectorAll('.like-btn');
  console.log('[DEBUG INITHEARTS] Appel initHearts, nombre de boutons .like-btn:', likeButtons.length);
  // On charge les favoris de l'utilisateur connecté
  let favFilms = [];
  let favSeries = [];
  // Fonction pour mettre à jour l'état des boutons (utilisée après chaque modif)
  function updateButtons() {
    // Collecte tous les boutons séries pour analyse croisée
    const allSeriesBtns = Array.from(likeButtons).filter(b => normalizeType(b.dataset.type) === 'series');
    // Regroupe par data-id
    const seriesById = {};
    allSeriesBtns.forEach(b => {
      const id = b.dataset.id;
      if (!seriesById[id]) seriesById[id] = [];
      seriesById[id].push(b);
    });
    // Log comparatif : si plusieurs boutons pour le même id mais data-type différents, warning
    Object.entries(seriesById).forEach(([id, btns]) => {
      const types = btns.map(b => b.dataset.type);
      const uniqueTypes = Array.from(new Set(types));
      if (uniqueTypes.length > 1) {
        console.warn('%c[SERIE][INCOHERENCE] Plusieurs data-type pour le même data-id:', 'background: #f00; color: #fff; font-size: 16px', id, uniqueTypes, btns);
      } else {
        console.log('%c[SERIE][OK] data-id:', 'background: #0f0; color: #111; font-size: 14px', id, 'data-type:', uniqueTypes[0], btns);
      }
    });
    likeButtons.forEach(button => {
      // LOG ULTRA-VISIBLE pour debug séries/animés UNIQUEMENT
      if (normalizeType(button.dataset.type) === 'series') {
        console.log('%c[SERIE/ANIME][LikeBtn] data-id:', 'background: #ff0; color: #b00; font-size: 16px', button.dataset.id, 'data-type:', button.dataset.type, button);
      }
        const mediaCard = button.closest('.media-card, .film-card, .serie-card, li, .track-row');
        let mediaTypeRaw = button.dataset.type || 'films';
        let mediaType = normalizeType(mediaTypeRaw);
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
          item = { id: String(mediaId), title: mediaTitle, artist, duration, cover: mediaImage, source, url: mediaLink };
        } else {
          // Cas film : utiliser l'ID WordPress, cas série/anime : utiliser le slug
          if (mediaType === 'films') {
            mediaId = button.dataset.id || '';
          } else {
            // Pour séries/animes, utiliser le slug comme id
            mediaId = button.dataset.id || '';
          }
          mediaId = String(mediaId); // Force string pour la comparaison
          mediaTitle = mediaCard?.querySelector('.media-title, .film-title, .serie-title, .top-title-link')?.textContent || '';
          mediaLink = mediaCard?.querySelector('a')?.href || '';
          mediaImage = button.dataset.poster || mediaCard?.querySelector('img')?.src || '';
          item = { id: mediaId, title: mediaTitle, image: mediaImage, url: mediaLink };
        }
        // Pour les animes, essayer les deux types
        // Normalisation forte : tous les IDs en string pour la comparaison
        let isFav = false;
        // On force tous les IDs de favFilms et favSeries en string pour la comparaison
        const favFilmsIds = favFilms.map(f => String(f.id ?? f));
        const favSeriesIds = favSeries.map(s => String(s.id ?? s));
        if (mediaType === 'films') {
          isFav = favFilmsIds.includes(mediaId);
        } else if (mediaType === 'series') {
          isFav = favSeriesIds.includes(mediaId);
        }
        // Debug log for anime/series/films
        if (mediaTypeRaw === 'anime' || mediaType === 'series' || mediaType === 'films') {
          console.log('[LikeBtn]', {
            type: mediaTypeRaw,
            normalizedType: mediaType,
            id: mediaId,
            isFav,
            favFilms,
            favSeries,
            item
          });
        }
        if (isFav) {
          button.setAttribute('data-liked', 'true');
          button.classList.add('liked');
          // Si SVG cœur, pas de changement de texte/couleur
          if (!button.querySelector('svg')) {
            button.textContent = '♥';
            button.style.color = '#700118';
          }
        } else {
          button.setAttribute('data-liked', 'false');
          button.classList.remove('liked');
          if (!button.querySelector('svg')) {
            button.textContent = '♡';
            button.style.color = '#ffffff';
          }
        }
        button.onclick = function(e) {
          e.preventDefault();
          const btn = this;
          let mediaTypeRaw = btn.dataset.type || 'films';
          let mediaType = normalizeType(mediaTypeRaw);
          let mediaId = btn.dataset.id || '';
          mediaId = String(mediaId);
          const isLiked = btn.getAttribute('data-liked') === 'true';
          let clickType = mediaType;
          // Utilise le type normalisé pour la sélection (évite les bugs entre 'series' et 'serie')
          let allBtns = document.querySelectorAll('.like-btn[data-id="' + mediaId + '"][data-type]');
          allBtns = Array.from(allBtns).filter(b => normalizeType(b.dataset.type) === mediaType);
          // Préparer l'objet favori pour Favoris.js
          let mediaCard = btn.closest('.media-card, .film-card, .serie-card, li, .track-row');
          let mediaTitle = mediaCard?.querySelector('.media-title, .film-title, .serie-title, .top-title-link')?.textContent || '';
          let mediaLink = mediaCard?.querySelector('a')?.href || '';
          let mediaImage = btn.dataset.poster || mediaCard?.querySelector('img')?.src || '';
          let favItem = { id: mediaId, title: mediaTitle, image: mediaImage, url: mediaLink };
          if (isLiked) {
            // MAJ visuelle instantanée (optimiste)
            allBtns.forEach(b => {
              b.setAttribute('data-liked', 'false');
              b.classList.remove('liked');
              const path = b.querySelector('svg .svg-heart-shape');
              if (path) {
                path.setAttribute('fill', 'none');
                path.setAttribute('stroke', '#888888');
              }
              if (!b.querySelector('svg')) {
                b.textContent = '♡';
                b.style.color = '#ffffff';
              }
            });
            updateFavorite('remove_user_favorite', clickType, {id: mediaId}, (data) => {
              if (window.FavorisPage) window.FavorisPage.removeFavorite && window.FavorisPage.removeFavorite(clickType, mediaId);
              if (clickType === 'films') {
                favFilms = favFilms.filter(f => String(f.id ?? f) !== mediaId);
              } else if (clickType === 'series') {
                favSeries = favSeries.filter(s => String(s.id ?? s) !== mediaId);
              }
              updateButtons();
            });
          } else {
            // MAJ visuelle instantanée (optimiste)
            allBtns.forEach(b => {
              b.setAttribute('data-liked', 'true');
              b.classList.add('liked');
              const path = b.querySelector('svg .svg-heart-shape');
              if (path) {
                path.setAttribute('fill', '#700118');
                path.setAttribute('stroke', '#700118');
              }
              if (!b.querySelector('svg')) {
                b.textContent = '♥';
                b.style.color = '#700118';
              }
            });
            updateFavorite('add_user_favorite', clickType, {id: mediaId}, (data) => {
              // Ajoute localement à favFilms/favSeries
              if (typeof window.addFavorite === 'function') {
                window.addFavorite(clickType === 'films' ? 'film' : 'serie', favItem);
              }
              if (clickType === 'films') {
                favFilms.push({id: mediaId});
              } else if (clickType === 'series') {
                favSeries.push({id: mediaId});
              }
              updateButtons();
            });
          }
        };
      });
  }
  // Initialisation : charge les favoris puis met à jour les boutons
  getUserFavorites('films', films => {
    favFilms = films;
    getUserFavorites('series', series => {
      favSeries = series;
      updateButtons();
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
