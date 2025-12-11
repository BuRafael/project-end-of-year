/**
 * Fiche Série JavaScript
 * Gère les pistes, commentaires, séries similaires et interactions
 */

document.addEventListener('DOMContentLoaded', function() {

// === PISTES ===
const tracks = [
    { id: 1, title: "Main Theme", artist: "Kyle Dixon & Michael Stein", duration: "1:12" },
    { id: 2, title: "From Russia with Love", artist: "Kyle Dixon & Michael Stein", duration: "1:55" },
    { id: 3, title: "Lab Rat", artist: "Kyle Dixon & Michael Stein", duration: "2:28" },
    { id: 4, title: "Demogorgon", artist: "Kyle Dixon & Michael Stein", duration: "3:42" },
    { id: 5, title: "Barb", artist: "Kyle Dixon & Michael Stein", duration: "7:44" }
];

const tracksTable = document.getElementById("tracksTable");
const imagePath = typeof themeImagePath !== 'undefined' ? themeImagePath : 'assets/image/Fiche films/';

if (tracksTable) {
    tracks.forEach(t => {
        // Créer un lien cliquable si l'artiste est Hans Zimmer
        const artistHtml = t.artist === 'Hans Zimmer' 
            ? `<a href="${window.location.origin}/hans-zimmer" class="movie-track-artist" style="cursor: pointer;">${t.artist}</a>`
            : `<div class="movie-track-artist">${t.artist}</div>`;
        
        tracksTable.innerHTML += `
            <tr>
                <td>${t.id}</td>
                <td>
                    <div class="movie-track-info">
                        <img src="${imagePath}" class="movie-track-cover" alt="${t.title}">
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

    // Like/unlike tracks (event delegation so it works for appended rows too)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('track-like')) {
            e.target.classList.toggle('liked');
        }
    });
}

// === AFFICHER PLUS (PISTES) ===
const tracksMoreBtn = document.getElementById("tracksMoreBtn");
if (tracksMoreBtn) {
    tracksMoreBtn.addEventListener('click', function() {
        const rows = tracksTable.querySelectorAll('tr');
        rows.forEach(row => row.style.display = 'table-row');
        tracksMoreBtn.style.display = 'none';
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
if (similarMoviesContainer) {
    const similarSeries = [
        { title: "Breaking Bad", image: "Breaking Bad.jpg" },
        { title: "Euphoria", image: "Euphoria.jpg" },
        { title: "Wednesday", image: "Wednesday.jpg" },
        { title: "The Witcher", image: "The Witcher.jpg" }
    ];

    similarSeries.forEach(serie => {
        const card = document.createElement('div');
        card.className = 'col-12 col-sm-6 col-md-4 col-lg-3';
        card.innerHTML = `
            <div class="similar-card">
                <img src="${imagePath}${serie.image}" alt="${serie.title}" class="similar-card-img">
                <div class="similar-card-title">${serie.title}</div>
            </div>
        `;
        similarMoviesContainer.appendChild(card);
    });
}

// === BOUTONS CAROUSEL (Séries similaires) ===
const carouselArrows = document.querySelectorAll('.carousel-arrow');
carouselArrows.forEach(arrow => {
    arrow.addEventListener('click', function() {
        const isLeft = this.classList.contains('carousel-arrow.left');
        console.log(isLeft ? 'Scroll left' : 'Scroll right');
    });
});

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
