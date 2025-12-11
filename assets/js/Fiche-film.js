/**
 * Fiche Film JavaScript
 * Gère les pistes, commentaires, films similaires et interactions
 */

document.addEventListener('DOMContentLoaded', function() {

// === PISTES ===
const imagePath = typeof themeImagePath !== 'undefined' ? themeImagePath : 'assets/image/Fiche films/';
const currentMovieSlug = window.currentMovieSlug || 'inception';

function getTracks(slug) {
    if (slug === 'la-la-land') {
        return [
            { id: 1, title: "Another Day of Sun", artist: "La La Land Cast", duration: "3:48", cover: "La La Land.jpg" },
            { id: 2, title: "Someone in the Crowd", artist: "Emma Stone, Callie Hernandez, Sonoya Mizuno, Jessica Rothe", duration: "4:19", cover: "La La Land.jpg" },
            { id: 3, title: "Mia & Sebastian's Theme", artist: "Justin Hurwitz", duration: "1:37", cover: "La La Land.jpg" },
            { id: 4, title: "A Lovely Night", artist: "Ryan Gosling, Emma Stone", duration: "3:56", cover: "La La Land.jpg" },
            { id: 5, title: "Herman's Habit", artist: "Justin Hurwitz", duration: "1:51", cover: "La La Land.jpg" },
            { id: 6, title: "City of Stars (Pier)", artist: "Ryan Gosling", duration: "1:51", cover: "La La Land.jpg" },
            { id: 7, title: "Planetarium", artist: "Justin Hurwitz", duration: "4:18", cover: "La La Land.jpg" },
            { id: 8, title: "Summer Montage / Madeline", artist: "Justin Hurwitz", duration: "2:05", cover: "La La Land.jpg" },
            { id: 9, title: "City of Stars (Duet)", artist: "Ryan Gosling, Emma Stone", duration: "2:29", cover: "La La Land.jpg" },
            { id: 10, title: "Start a Fire", artist: "John Legend", duration: "3:18", cover: "La La Land.jpg" },
            { id: 11, title: "Engagement Party", artist: "Justin Hurwitz", duration: "1:01", cover: "La La Land.jpg" },
            { id: 12, title: "Audition (The Fools Who Dream)", artist: "Emma Stone", duration: "3:48", cover: "La La Land.jpg" },
            { id: 13, title: "Epilogue", artist: "Justin Hurwitz", duration: "7:40", cover: "La La Land.jpg" },
            { id: 14, title: "The End", artist: "Justin Hurwitz", duration: "1:52", cover: "La La Land.jpg" },
            { id: 15, title: "City of Stars (Humming)", artist: "Emma Stone", duration: "2:43", cover: "La La Land.jpg" }
        ];
    }

    // Default Inception tracks (COMPLET)
    return [
        { id: 1, title: "Half Remembered Dream", artist: "Hans Zimmer", duration: "1:12", cover: "inception affiche film.jpg" },
        { id: 2, title: "We Built Our Own World", artist: "Hans Zimmer", duration: "1:55", cover: "inception affiche film.jpg" },
        { id: 3, title: "Dream Is Collapsing", artist: "Hans Zimmer", duration: "2:28", cover: "inception affiche film.jpg" },
        { id: 4, title: "Radical Notion", artist: "Hans Zimmer", duration: "3:42", cover: "inception affiche film.jpg" },
        { id: 5, title: "Old Souls", artist: "Hans Zimmer", duration: "7:44", cover: "inception affiche film.jpg" },
        { id: 6, title: "Mombasa", artist: "Hans Zimmer", duration: "4:00", cover: "inception affiche film.jpg" },
        { id: 7, title: "One Simple Idea", artist: "Hans Zimmer", duration: "2:15", cover: "inception affiche film.jpg" },
        { id: 8, title: "Stay", artist: "Hans Zimmer", duration: "5:30", cover: "inception affiche film.jpg" },
        { id: 9, title: "Dream Within a Dream", artist: "Hans Zimmer", duration: "3:05", cover: "inception affiche film.jpg" },
        { id: 10, title: "Time (Instrumental)", artist: "Hans Zimmer", duration: "6:20", cover: "inception affiche film.jpg" },
        { id: 11, title: "The Comet - Hans Zimmer", artist: "Hans Zimmer", duration: "3:25", cover: "inception affiche film.jpg" },
        { id: 12, title: "Waiting for a Train", artist: "Hans Zimmer", duration: "2:40", cover: "inception affiche film.jpg" },
        { id: 13, title: "Hallway Fight", artist: "Hans Zimmer", duration: "1:30", cover: "inception affiche film.jpg" },
        { id: 14, title: "We Are Not Going Back", artist: "Hans Zimmer", duration: "3:15", cover: "inception affiche film.jpg" },
        { id: 15, title: "Rotating Hallway", artist: "Hans Zimmer", duration: "2:10", cover: "inception affiche film.jpg" }
    ];
}

const tracks = getTracks(currentMovieSlug);
const tracksTable = document.getElementById("tracksTable");
const tracksMoreBtn = document.getElementById('tracksMoreBtn');
let tracksLimit = 5;
const TRACKS_STEP = 5;

function renderTracks(limit = tracksLimit) {
    if (!tracksTable) return;
    tracksLimit = limit;
    tracksTable.innerHTML = '';
    const slice = tracks.slice(0, tracksLimit);
    slice.forEach(t => {
        const artistHtml = t.artist === 'Hans Zimmer'
            ? `<a href="${window.location.origin}/hans-zimmer" class="movie-track-artist" style="cursor: pointer;">${t.artist}</a>`
            : `<div class="movie-track-artist">${t.artist}</div>`;

        const coverSrc = imagePath + (t.cover || 'inception affiche film.jpg');
        
        tracksTable.innerHTML += `
            <tr>
                <td>${t.id}</td>
                <td>
                    <div class="movie-track-info">
                        <img src="${coverSrc}" class="movie-track-cover" alt="${t.title}">
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
    if (tracksMoreBtn) {
        if (tracksLimit >= tracks.length) {
            tracksMoreBtn.style.display = 'inline-block';
            tracksMoreBtn.innerText = 'Afficher moins';
        } else {
            tracksMoreBtn.style.display = 'inline-block';
            tracksMoreBtn.innerText = 'Afficher plus…';
        }
    }
}

if (tracksTable) {
    renderTracks(TRACKS_STEP);

    if (tracksMoreBtn) {
        tracksMoreBtn.addEventListener('click', () => {
            if (tracksLimit >= tracks.length) {
                renderTracks(TRACKS_STEP);
            } else {
                const nextLimit = Math.min(tracksLimit + TRACKS_STEP, tracks.length);
                renderTracks(nextLimit);
            }
        });
    }

    tracksTable.addEventListener('click', function (e) {
        const target = e.target;
        if (!target.classList.contains('track-like')) return;
        const liked = target.classList.toggle('liked');
        target.classList.toggle('bi-heart', !liked);
        target.classList.toggle('bi-heart-fill', liked);
        target.setAttribute('aria-pressed', liked ? 'true' : 'false');
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

// === CARROUSEL : FILMS SIMILAIRES DYNAMIQUE ===
const defaultCover = imagePath + 'inception affiche film.jpg';

function getSimilarMovies(slug) {
    if (slug === 'interstellar') {
        return [
            { title: "Interstellar",    img: imagePath + "interstellar affiche similaire.jpg" },
            { title: "Tenet",           img: imagePath + "Tenet.jpg" },
            { title: "Shutter Island",  img: imagePath + "shutter island affiche similaire.jpg" },
            { title: "The Matrix",      img: imagePath + "matrix affiche similaire.jpg" },
            { title: "Memento",         img: imagePath + "the-prestige-md-web.jpg" },
            { title: "The Prestige",    img: imagePath + "the-prestige-md-web.jpg" },
            { title: "Predestination",  img: imagePath + "arrival affiche similaire.jpg" },
            { title: "Arrival",         img: imagePath + "arrival affiche similaire.jpg" },
            { title: "Coherence",       img: imagePath + "interstellar affiche similaire.jpg" },
            { title: "Paprika",         img: defaultCover }
        ];
    }

    return [
        { title: "Interstellar",    img: imagePath + "interstellar affiche similaire.jpg" },
        { title: "Shutter Island",  img: imagePath + "shutter island affiche similaire.jpg" },
        { title: "Matrix",          img: imagePath + "matrix affiche similaire.jpg" },
        { title: "Arrival",         img: imagePath + "arrival affiche similaire.jpg" },
        { title: "Inception",       img: imagePath + "inception_2010_advance_original_film_art_f4801a23-edb3-4db0-b382-1e2aec1dc927_5000x.jpg" },
        { title: "Tenet",           img: imagePath + "Tenet.jpg" },
        { title: "Dark City",       img: imagePath + "Dark city.jpg" },
        { title: "The Prestige",    img: imagePath + "the-prestige-md-web.jpg" }
    ];
}

// === CARROUSEL : FILMS SIMILAIRES (initialisation différée) ===
let carouselIndex = 0;
const itemsPerPage = 4;

function initCarousel() {
    const slug = window.currentMovieSlug || 'inception';
    const allSimilarMovies = getSimilarMovies(slug);
    const similarMovies = document.getElementById("similarMovies");
    const carouselArrows = document.querySelectorAll('.carousel-arrow');
    const leftArrow = carouselArrows[0];
    const rightArrow = carouselArrows[1];

    function renderCarousel() {
        if (!similarMovies) return;
        similarMovies.innerHTML = '';
        for (let i = 0; i < itemsPerPage; i++) {
            const index = (carouselIndex + i) % allSimilarMovies.length;
            const m = allSimilarMovies[index];
            similarMovies.innerHTML += `
                <div class="col-6 col-md-3">
                    <div class="similar-card">
                        <img src="${m.img}" alt="${m.title}">
                        <div class="similar-card-title">${m.title}</div>
                    </div>
                </div>
            `;
        }
    }

    function animateCarousel(delta) {
        if (!similarMovies) return;
        similarMovies.classList.add('is-transitioning');
        setTimeout(() => {
            carouselIndex = (carouselIndex + delta + allSimilarMovies.length) % allSimilarMovies.length;
            renderCarousel();
            similarMovies.classList.remove('is-transitioning');
        }, 140);
    }

    if (leftArrow) {
        leftArrow.addEventListener('click', function () {
            animateCarousel(-1);
        });
    }

    if (rightArrow) {
        rightArrow.addEventListener('click', function () {
            animateCarousel(1);
        });
    }

    renderCarousel();
}

// Initialiser le carrousel une fois le DOM chargé
initCarousel();

// ===== BOUTON LIKE AFFICHE =====
const likeBtn = document.getElementById('movieLikeBtn');
if (likeBtn) {
    likeBtn.addEventListener('click', function (e) {
        const icon = this.querySelector('i');
        const liked = this.classList.toggle('liked');
        this.setAttribute('aria-pressed', liked ? 'true' : 'false');
        if (icon) {
            icon.classList.toggle('bi-heart', !liked);
            icon.classList.toggle('bi-heart-fill', liked);
        }
    });
}

// === AFFICHER PLUS : COMMENTAIRES ===
const commentsMoreBtn = document.getElementById('commentsMoreBtn');
const moreComments = [];

function appendComments(list, markAppended = false) {
    if (!commentsZone) return;
    list.forEach(c => {
        const col = document.createElement('div');
        col.className = 'col-12 col-md-3';
        if (markAppended) col.classList.add('appended-comment');
        col.innerHTML = `
            <div class="comment-card">
                <div class="comment-user">
                    <i class="bi bi-person"></i>${c.user}
                </div>
                <div class="comment-text">${c.text}</div>
            </div>
        `;
        commentsZone.appendChild(col);
    });
}

let commentsExpanded = false;
if (commentsMoreBtn) {
    commentsMoreBtn.addEventListener('click', function () {
        if (!commentsExpanded) {
            appendComments(moreComments, true);
            this.innerText = 'Afficher moins';
            commentsExpanded = true;
        } else {
            document.querySelectorAll('#commentsZone .appended-comment').forEach(c => c.remove());
            this.innerText = 'Afficher plus…';
            commentsExpanded = false;
        }
    });
}

// Charger les commentaires au démarrage
if (typeof movieComments !== 'undefined') {
    loadComments();
}

}); // Fin DOMContentLoaded
