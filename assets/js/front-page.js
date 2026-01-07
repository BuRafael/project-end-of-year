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
  console.log('[updateFavorite] Début:', { action, type, item });
  const form = new URLSearchParams();
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
  console.log('[updateFavorite] URL AJAX:', ajaxUrl);
  console.log('[updateFavorite] Données envoyées:', form.toString());
  fetch(ajaxUrl, {
    method: 'POST',
    credentials: 'same-origin',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: form.toString()
  })
    .then(r => {
      console.log('[updateFavorite] Réponse brute:', r);
      return r.json();
    })
    .then(data => {
      console.log('[updateFavorite] Réponse JSON:', data);
      if (callback) callback(data);
    })
    .catch(err => {
      console.error('[updateFavorite] ERREUR:', err);
    });
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
          // Correction : extraire uniquement le nom de fichier pour cover
          let coverUrl = button.dataset.trackCover || mediaCard?.dataset.trackCover || '';
          let cover = '';
          if (coverUrl) {
            // Si c'est une URL, extraire le nom de fichier
            const parts = coverUrl.split('/');
            cover = parts[parts.length - 1];
          }
          const artist = button.dataset.trackArtist || mediaCard?.dataset.trackArtist || '';
          const duration = button.dataset.trackDuration || mediaCard?.dataset.trackDuration || '';
          const source = button.dataset.trackSource || mediaCard?.dataset.trackSource || '';
          mediaLink = button.dataset.trackUrl || mediaCard?.dataset.trackUrl || '';
          item = { id: String(mediaId), title: mediaTitle, artist, duration, cover, source, url: mediaLink };
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
          // Préparer l'objet favori pour Favoris.js
          let mediaCard = btn.closest('.media-card, .film-card, .serie-card, li, .track-row');
          console.log('[DEBUG] mediaCard:', mediaCard);
          
          let titleElement = mediaCard?.querySelector('.media-title, .film-title, .serie-title, .top-title-link');
          let mediaTitle = titleElement?.textContent?.trim() || 'Titre inconnu';
          console.log('[DEBUG] titleElement:', titleElement, 'mediaTitle:', mediaTitle);
          
          let linkElement = mediaCard?.querySelector('a');
          let mediaLink = linkElement?.href || '';
          console.log('[DEBUG] linkElement:', linkElement, 'mediaLink:', mediaLink);
          
          let imgElement = mediaCard?.querySelector('img');
          let mediaImage = btn.dataset.poster || imgElement?.src || '';
          console.log('[DEBUG] imgElement:', imgElement, 'mediaImage:', mediaImage);
          
          let favItem = { id: mediaId, title: mediaTitle, image: mediaImage, url: mediaLink };
          console.log('[LikeBtn Click] Type:', clickType, 'ID:', mediaId, 'Item:', favItem);
          if (isLiked) {
            // MAJ visuelle instantanée (optimiste) - seulement le bouton cliqué
            btn.setAttribute('data-liked', 'false');
            btn.classList.remove('liked');
            const path = btn.querySelector('svg .svg-heart-shape');
            if (path) {
              path.setAttribute('fill', 'none');
              path.setAttribute('stroke', '#888888');
            }
            if (!btn.querySelector('svg')) {
              btn.textContent = '♡';
              btn.style.color = '#ffffff';
            }
            // Supprimer des favoris avec AJAX
            updateFavorite('remove_user_favorite', clickType, {id: mediaId}, (data) => {
              console.log('[LikeBtn] Réponse AJAX remove_user_favorite:', data);
              if (data && data.success) {
                if (clickType === 'films') {
                  favFilms = favFilms.filter(f => String(f.id ?? f) !== mediaId);
                } else if (clickType === 'series') {
                  favSeries = favSeries.filter(s => String(s.id ?? s) !== mediaId);
                }
                // Mettre à jour la page favoris si elle est chargée
                if (window.FavorisPage && window.FavorisPage.init) {
                  window.FavorisPage.init();
                }
              } else {
                console.error('[LikeBtn] Échec de la suppression des favoris:', data);
                // Rollback UI si échec
                btn.setAttribute('data-liked', 'true');
                btn.classList.add('liked');
                const path = btn.querySelector('svg .svg-heart-shape');
                if (path) {
                  path.setAttribute('fill', '#700118');
                  path.setAttribute('stroke', '#700118');
                }
                if (!btn.querySelector('svg')) {
                  btn.textContent = '♥';
                  btn.style.color = '#700118';
                }
              }
            });
          } else {
            // MAJ visuelle instantanée (optimiste) - seulement le bouton cliqué
            btn.setAttribute('data-liked', 'true');
            btn.classList.add('liked');
            const path = btn.querySelector('svg .svg-heart-shape');
            if (path) {
              path.setAttribute('fill', '#700118');
              path.setAttribute('stroke', '#700118');
            }
            if (!btn.querySelector('svg')) {
              btn.textContent = '♥';
              btn.style.color = '#700118';
            }
            // Ajouter aux favoris avec AJAX
            updateFavorite('add_user_favorite', clickType, favItem, (data) => {
              console.log('[LikeBttn] Réponse AJAX add_user_favorite:', data);
              if (data && data.success) {
                if (clickType === 'films') {
                  favFilms.push({id: mediaId});
                } else if (clickType === 'series') {
                  favSeries.push({id: mediaId});
                }
                // Mettre à jour la page favoris si elle est chargée
                if (window.FavorisPage && window.FavorisPage.init) {
                  window.FavorisPage.init();
                }
              } else {
                console.error('[LikeBtn] Échec de l\'ajout aux favoris:', data);
                // Rollback UI si échec
                btn.setAttribute('data-liked', 'false');
                btn.classList.remove('liked');
                const path = btn.querySelector('svg .svg-heart-shape');
                if (path) {
                  path.setAttribute('fill', 'none');
                  path.setAttribute('stroke', '#888888');
                }
                if (!btn.querySelector('svg')) {
                  btn.textContent = '♡';
                  btn.style.color = '#ffffff';
                }
              }
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
