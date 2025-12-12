/**
 * Fiche Série JavaScript
 * Gère les pistes, commentaires, séries similaires et interactions
 */

document.addEventListener('DOMContentLoaded', function() {

// === PISTES PAR SAISON ET ÉPISODE ===
const allTracks = {
    1: { // Saison 1
        1: [ // Épisode 1
            { id: 1, title: "Kids", artist: "Kyle Dixon & Michael Stein", duration: "1:23", image: "Main theme Stranger Things.png" },
            { id: 2, title: "The Upside Down", artist: "Kyle Dixon & Michael Stein", duration: "2:15", image: "Main theme Stranger Things.png" },
            { id: 3, title: "Stranger Things (Main Theme)", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" },
            { id: 4, title: "Coffee & Contemplation", artist: "Kyle Dixon & Michael Stein", duration: "1:58", image: "Main theme Stranger Things.png" },
            { id: 5, title: "Biking to School", artist: "Kyle Dixon & Michael Stein", duration: "1:41", image: "Main theme Stranger Things.png" },
            { id: 6, title: "Nancy & Barb", artist: "Kyle Dixon & Michael Stein", duration: "2:04", image: "Main theme Stranger Things.png" },
            { id: 7, title: "Agents", artist: "Kyle Dixon & Michael Stein", duration: "1:47", image: "Main theme Stranger Things.png" },
            { id: 8, title: "Talking to Australia", artist: "Kyle Dixon & Michael Stein", duration: "2:32", image: "Main theme Stranger Things.png" },
            { id: 9, title: "Friendship", artist: "Kyle Dixon & Michael Stein", duration: "1:56", image: "Main theme Stranger Things.png" },
            { id: 10, title: "Hawkins", artist: "Kyle Dixon & Michael Stein", duration: "3:12", image: "Main theme Stranger Things.png" },
            { id: 11, title: "Are You Sure?", artist: "Kyle Dixon & Michael Stein", duration: "2:18", image: "Main theme Stranger Things.png" },
            { id: 12, title: "In Pursuit", artist: "Kyle Dixon & Michael Stein", duration: "2:45", image: "Main theme Stranger Things.png" },
            { id: 13, title: "Over", artist: "Kyle Dixon & Michael Stein", duration: "1:53", image: "Main theme Stranger Things.png" }
        ],
        2: [ // Épisode 2
            { id: 1, title: "Eleven", artist: "Kyle Dixon & Michael Stein", duration: "2:08", image: "Main theme Stranger Things.png" },
            { id: 2, title: "Photos In The Woods", artist: "Kyle Dixon & Michael Stein", duration: "1:45", image: "Main theme Stranger Things.png" },
            { id: 3, title: "Lay-Z-Boy", artist: "Kyle Dixon & Michael Stein", duration: "2:22", image: "Main theme Stranger Things.png" },
            { id: 4, title: "This Isn't You", artist: "Kyle Dixon & Michael Stein", duration: "3:01", image: "Main theme Stranger Things.png" }
        ],
        3: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        4: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        5: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        6: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        7: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        8: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        9: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ]
    },
    2: { // Saison 2
        1: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        2: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        3: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        4: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        5: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        6: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        7: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        8: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        9: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ]
    },
    3: { // Saison 3
        1: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        2: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        3: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        4: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        5: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        6: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        7: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        8: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        9: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ]
    },
    4: { // Saison 4
        1: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        2: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        3: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        4: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        5: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        6: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        7: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        8: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ],
        9: [
            { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12", image: "Main theme Stranger Things.png" }
        ]
    }
};

const tracksTable = document.getElementById("tracksTable");
const imagePath = typeof themeImagePath !== 'undefined' ? themeImagePath : 'assets/image/Piste séries/';
const seasonSelect = document.getElementById("seasonSelect");
const episodeSelect = document.getElementById("episodeSelect");

const TRACKS_DISPLAY_COUNT = 5; // Nombre de pistes à afficher par défaut

// Fonction pour afficher les pistes
function displayTracks(season, episode) {
    if (!tracksTable) return;
    
    const tracks = (allTracks[season] && allTracks[season][episode]) ? allTracks[season][episode] : [];
    tracksTable.innerHTML = '';
    
    tracks.forEach((t, index) => {
        // Créer un lien cliquable si l'artiste est Hans Zimmer
        const artistHtml = t.artist === 'Hans Zimmer' 
            ? `<a href="${window.location.origin}/hans-zimmer" class="movie-track-artist" style="cursor: pointer;">${t.artist}</a>`
            : `<div class="movie-track-artist">${t.artist}</div>`;
        
        // Utiliser l'image spécifique de la piste si elle existe, sinon utiliser le chemin par défaut
        const trackImage = t.image ? imagePath + t.image : imagePath;
        
        // Ajouter une classe spéciale pour la première piste (index 0)
        const isFirstTrack = index === 0 ? 'first-track-image' : '';
        
        // Masquer les pistes au-delà du nombre d'affichage
        const displayStyle = index < TRACKS_DISPLAY_COUNT ? '' : 'display: none;';
        
        tracksTable.innerHTML += `
            <tr style="${displayStyle}">
                <td>${t.id}</td>
                <td>
                    <div class="movie-track-info">
                        <img src="${trackImage}" class="movie-track-cover ${isFirstTrack}" alt="${t.title}">
                        <div>
                            <div class="movie-track-title">${t.title}</div>
                            ${artistHtml}
                        </div>
                    </div>
                </td>
                <td class="col-links">
                    <span class="track-icons">
                        <i class="bi bi-spotify" aria-label="Spotify"></i>
                        <i class="bi bi-amazon" aria-label="Amazon Music"></i>
                        <i class="bi bi-youtube" aria-label="YouTube Music"></i>
                        <i class="bi bi-apple" aria-label="Apple Music"></i>
                    </span>
                </td>
                <td class="col-duration text-center">${t.duration}</td>
                <td class="col-like text-end">
                    <i class="bi bi-heart track-like"></i>
                </td>
            </tr>
        `;
    });
    
    // Gérer l'affichage du bouton "Afficher plus"
    updateTracksMoreBtn(tracks.length);
}

// Fonction pour mettre à jour le bouton "Afficher plus"
function updateTracksMoreBtn(totalTracks) {
    const tracksMoreBtn = document.getElementById("tracksMoreBtn");
    if (!tracksMoreBtn) return;
    
    if (totalTracks > TRACKS_DISPLAY_COUNT) {
        tracksMoreBtn.style.display = 'block';
        tracksMoreBtn.textContent = 'Afficher plus…';
        tracksMoreBtn.classList.remove('show-less');
    } else {
        tracksMoreBtn.style.display = 'none';
    }
}

// Afficher les pistes de la saison 1 épisode 1 par défaut
displayTracks(1, 1);

// Gestion des changements de saison et épisode
if (seasonSelect && episodeSelect) {
    seasonSelect.addEventListener('change', function() {
        displayTracks(parseInt(this.value), parseInt(episodeSelect.value));
    });
    
    episodeSelect.addEventListener('change', function() {
        displayTracks(parseInt(seasonSelect.value), parseInt(this.value));
    });
}

// Like/unlike tracks (event delegation so it works for appended rows too)
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('track-like')) {
        e.target.classList.toggle('liked');
    }
});

// === AFFICHER PLUS / AFFICHER MOINS (PISTES) ===
const tracksMoreBtn = document.getElementById("tracksMoreBtn");
if (tracksMoreBtn) {
    tracksMoreBtn.addEventListener('click', function() {
        const rows = tracksTable.querySelectorAll('tr');
        const isExpanded = this.classList.contains('show-less');
        
        if (isExpanded) {
            // Masquer les pistes au-delà du compte
            rows.forEach((row, index) => {
                row.style.display = index < TRACKS_DISPLAY_COUNT ? 'table-row' : 'none';
            });
            this.textContent = 'Afficher plus…';
            this.classList.remove('show-less');
        } else {
            // Afficher toutes les pistes
            rows.forEach(row => row.style.display = 'table-row');
            this.textContent = 'Afficher moins…';
            this.classList.add('show-less');
        }
    });
}

// === COMMENTAIRES ===
const commentsZone = document.getElementById("commentsZone");
const commentInput = document.querySelector('.comment-input');

// Vérifier que movieComments est défini
if (typeof movieComments === 'undefined') {
    console.error('movieComments n\'est pas défini');
}

// Charger les commentaires existants
function loadComments() {
    if (!commentsZone || typeof movieComments === 'undefined') return;
    
    fetch(movieComments.ajax_url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'get_movie_comments',
            movie_id: movieComments.movie_id
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data.comments.length > 0) {
            commentsZone.innerHTML = '';
            data.data.comments.forEach(c => {
                renderComment(c);
            });
            
            // Afficher le bouton "Afficher plus" si plus de 8 commentaires
            const moreBtnWrapper = document.getElementById('commentsMoreBtnWrapper');
            if (moreBtnWrapper && data.data.comments.length > 8) {
                moreBtnWrapper.style.display = 'block';
            }
        } else {
            commentsZone.innerHTML = '<div class="col-12"><p class="text-center" style="color: rgba(244, 239, 236, 1); font-style: italic; opacity: 0.7;">C\'est silencieux ici...</p></div>';
        }
    });
}

// Afficher un commentaire
function renderComment(commentData) {
    const col = document.createElement('div');
    col.className = 'col-12 col-md-3';
    col.dataset.commentId = commentData.id;
    
    const menuHtml = commentData.is_author ? `
        <div class="comment-menu">
            <button class="comment-menu-btn" aria-label="Options">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <div class="comment-menu-dropdown">
                <button class="comment-edit-btn">Modifier</button>
                <button class="comment-delete-btn">Supprimer</button>
            </div>
        </div>
    ` : '';
    
    // Formater la date
    let dateHtml = '';
    if (commentData.created_at) {
        const date = new Date(commentData.created_at);
        const now = new Date();
        const diffMs = now - date;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMs / 3600000);
        const diffDays = Math.floor(diffMs / 86400000);
        
        let timeAgo;
        if (diffMins < 1) timeAgo = 'à l\'instant';
        else if (diffMins < 60) timeAgo = `il y a ${diffMins} min`;
        else if (diffHours < 24) timeAgo = `il y a ${diffHours}h`;
        else if (diffDays < 7) timeAgo = `il y a ${diffDays}j`;
        else timeAgo = date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' });
        
        dateHtml = `<div class="comment-date">${timeAgo}</div>`;
    }
    
    col.innerHTML = `
        <div class="comment-card">
            ${menuHtml}
            <div class="comment-user">
                ${commentData.avatar ? `<img src="${commentData.avatar}" alt="${commentData.user_name}" class="comment-user-avatar">` : '<i class="bi bi-person comment-user-icon"></i>'}
                <span class="comment-user-name">${commentData.user_name}</span>
            </div>
            ${dateHtml}
            <div class="comment-text">${commentData.comment_text}</div>
        </div>
    `;
    
    commentsZone.insertBefore(col, commentsZone.firstChild);
    
    // Gestion du menu
    if (commentData.is_author) {
        const menuBtn = col.querySelector('.comment-menu-btn');
        const menuDropdown = col.querySelector('.comment-menu-dropdown');
        
        menuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            menuDropdown.classList.toggle('show');
        });
        
        // Modifier
        col.querySelector('.comment-edit-btn').addEventListener('click', () => {
            const textEl = col.querySelector('.comment-text');
            const currentText = textEl.textContent;
            textEl.innerHTML = `<input type="text" class="comment-edit-input" value="${currentText}">`;
            const input = textEl.querySelector('.comment-edit-input');
            input.focus();
            
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    editComment(commentData.id, input.value, textEl);
                }
            });
            
            menuDropdown.classList.remove('show');
        });
        
        // Supprimer
        col.querySelector('.comment-delete-btn').addEventListener('click', () => {
            if (confirm('Supprimer ce commentaire ?')) {
                deleteComment(commentData.id, col);
            }
        });
    }
    
    // Fermer le menu si on clique ailleurs
    document.addEventListener('click', () => {
        document.querySelectorAll('.comment-menu-dropdown.show').forEach(d => d.classList.remove('show'));
    });
}

// Publier un commentaire
if (commentInput && !commentInput.disabled && typeof movieComments !== 'undefined') {
    console.log('Event listener ajouté pour les commentaires');
    commentInput.addEventListener('keypress', function(e) {
        console.log('Touche pressée:', e.key);
        if (e.key === 'Enter' && this.value.trim()) {
            const commentText = this.value.trim();
            console.log('Envoi du commentaire:', commentText);
            
            fetch(movieComments.ajax_url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'add_movie_comment',
                    nonce: movieComments.nonce,
                    movie_id: movieComments.movie_id,
                    comment_text: commentText
                })
            })
            .then(response => {
                console.log('Réponse reçue:', response);
                return response.json();
            })
            .then(data => {
                console.log('Données:', data);
                if (data.success) {
                    // Supprimer le message vide
                    const emptyMsg = commentsZone.querySelector('.text-center');
                    if (emptyMsg) {
                        emptyMsg.parentElement.remove();
                    }
                    
                    renderComment({
                        id: data.data.comment_id,
                        user_name: data.data.user_name,
                        avatar: data.data.avatar,
                        comment_text: data.data.comment_text,
                        is_author: true,
                        created_at: data.data.created_at
                    });
                    
                    this.value = '';
                } else {
                    console.error('Erreur:', data);
                }
            })
            .catch(error => {
                console.error('Erreur fetch:', error);
            });
        }
    });
} else {
    console.log('Conditions non remplies:', {
        commentInput: !!commentInput,
        disabled: commentInput?.disabled,
        movieComments: typeof movieComments
    });
}

// Modifier un commentaire
function editComment(commentId, newText, textElement) {
    fetch(movieComments.ajax_url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'edit_movie_comment',
            nonce: movieComments.nonce,
            comment_id: commentId,
            comment_text: newText
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            textElement.textContent = newText;
        }
    });
}

// Supprimer un commentaire
function deleteComment(commentId, element) {
    fetch(movieComments.ajax_url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'delete_movie_comment',
            nonce: movieComments.nonce,
            comment_id: commentId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            element.remove();
            
            // Réafficher le message vide si plus de commentaires
            if (commentsZone.children.length === 0) {
                commentsZone.innerHTML = '<div class="col-12"><p class="text-center" style="color: rgba(244, 239, 236, 1); font-style: italic; opacity: 0.7;">C\'est silencieux ici...</p></div>';
            }
        }
    });
}

// Charger les commentaires au démarrage
loadComments();

// === SÉRIES SIMILAIRES ===
const similarMoviesContainer = document.getElementById('similarMovies');
const carouselArrows = document.querySelectorAll('.carousel-arrow');
const leftArrow = carouselArrows[0];
const rightArrow = carouselArrows[1];

const allSimilarSeries = [
    { title: "Dark",                         image: imagePath + "Dark city.jpg" },
    { title: "The OA",                       image: imagePath + "shutter island affiche similaire.jpg" },
    { title: "Supernatural",                 image: imagePath + "matrix affiche similaire.jpg" },
    { title: "The X-Files",                  image: imagePath + "arrival affiche similaire.jpg" },
    { title: "Twin Peaks",                   image: imagePath + "Tenet.jpg" },
    { title: "It (1990)",                    image: imagePath + "interstellar affiche similaire.jpg" },
    { title: "Locke & Key",                  image: imagePath + "the-prestige-md-web.jpg" },
    { title: "The Society",                  image: imagePath + "inception_2010_advance_original_film_art_f4801a23-edb3-4db0-b382-1e2aec1dc927_5000x.jpg" },
    { title: "I Am Not Okay With This",      image: imagePath + "interstellar affiche similaire.jpg" },
    { title: "Wayward Pines",                image: imagePath + "Dark city.jpg" }
];

let carouselIndex = 0;
const itemsPerPage = 4;

function renderSimilarCarousel() {
    if (!similarMoviesContainer) return;
    similarMoviesContainer.innerHTML = '';
    for (let i = 0; i < itemsPerPage; i++) {
        const index = (carouselIndex + i) % allSimilarSeries.length;
        const serie = allSimilarSeries[index];
        const card = document.createElement('div');
        card.className = 'col-6 col-md-3';
        card.innerHTML = `
            <div class="similar-card">
                <img src="${serie.image}" alt="${serie.title}" class="similar-card-img">
                <div class="similar-card-title">${serie.title}</div>
            </div>
        `;
        similarMoviesContainer.appendChild(card);
    }
}

function animateSimilar(delta) {
    if (!similarMoviesContainer) return;
    similarMoviesContainer.classList.add('is-transitioning');
    setTimeout(() => {
        carouselIndex = (carouselIndex + delta + allSimilarSeries.length) % allSimilarSeries.length;
        renderSimilarCarousel();
        similarMoviesContainer.classList.remove('is-transitioning');
    }, 140);
}

if (leftArrow) {
    leftArrow.addEventListener('click', () => animateSimilar(-1));
}
if (rightArrow) {
    rightArrow.addEventListener('click', () => animateSimilar(1));
}

renderSimilarCarousel();

// === LIKE BUTTON (SERIE) ===
const movieLikeBtn = document.getElementById('movieLikeBtn');
if (movieLikeBtn) {
    movieLikeBtn.addEventListener('click', function() {
        this.classList.toggle('liked');
        this.setAttribute('aria-pressed', this.classList.contains('liked'));
    });
}

// === PASSWORD TOGGLE ===
document.querySelectorAll('.password-toggle').forEach(btn => {
    btn.addEventListener('click', function() {
        const inputId = this.dataset.togglePassword;
        const input = document.getElementById(inputId);
        if (input) {
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    });
});

});
