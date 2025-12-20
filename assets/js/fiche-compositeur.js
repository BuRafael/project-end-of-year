
}); // Fin DOMContentLoaded

// Fonction pour afficher une piste dans le tableau
function appendTrack(track) {
    if (!tracksTable) return;
    const tr = document.createElement('tr');
    const trackImage = track.image.includes('Hans Zimmer') ? imagePath + track.image : filmImagePath + track.image;
    tr.innerHTML = `
        <td>${track.id}</td>
        <td>
            <div class="composer-track-info">
                <img src="${trackImage}" class="composer-track-cover" alt="${track.title}">
                <div>
                    <div class="composer-track-title">${track.title}</div>
                    <div class="composer-track-film">${track.film}</div>
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
        <td class="col-duration text-center">${track.duration}</td>
        <td class="col-like text-end">
            <i class="bi bi-heart track-like"></i>
        </td>
    `;
    tracksTable.appendChild(tr);
}
/**
 * Fiche Compositeur JavaScript
 * Gère les pistes, commentaires, filmographie et interactions
 */

document.addEventListener('DOMContentLoaded', function() {

// === PISTES CELEBRES ===
const tracks = [
    { id: 1, title: "Time", film: "Inception", duration: "4:35", image: "inception affiche film.jpg" },
    { id: 2, title: "Now We Are Free", film: "Gladiator", duration: "4:15", image: "matrix affiche similaire.jpg" },
    { id: 3, title: "Cornfield Chase", film: "Interstellar", duration: "2:06", image: "interstellar affiche similaire.jpg" },
    { id: 4, title: "Why So Serious?", film: "The Dark Knight", duration: "9:14", image: "Dark city.jpg" },
    { id: 5, title: "No Time for Caution", film: "Interstellar", duration: "4:06", image: "interstellar affiche similaire.jpg" },
    { id: 6, title: "He's a Pirate", film: "Pirates of the Caribbean", duration: "3:38", image: "the-prestige-md-web.jpg" },
    { id: 7, title: "Mountains", film: "Interstellar", duration: "3:39", image: "interstellar affiche similaire.jpg" },
    { id: 8, title: "Dream Is Collapsing", film: "Inception", duration: "2:28", image: "inception affiche film.jpg" },
    { id: 9, title: "Tennessee", film: "Pearl Harbor", duration: "4:04", image: "arrival affiche similaire.jpg" },
    { id: 10, title: "Earth", film: "Gladiator", duration: "3:54", image: "shutter island affiche similaire.jpg" }
];

const tracksTable = document.getElementById("tracksTable");
const imagePath = typeof composerImagePath !== 'undefined' ? composerImagePath : 'assets/image/Fiche Compositeur/';
const filmImagePath = imagePath.replace('Fiche Compositeur', 'Fiche films');

if (tracksTable) {
    // Afficher les 5 premières pistes
    const initialTracks = tracks.slice(0, 5);
    initialTracks.forEach(t => {
        appendTrack(t);
    });

    // Bouton "Afficher plus"
    const tracksMoreBtn = document.getElementById('tracksMoreBtn');
    let showingAll = false;
    
    if (tracksMoreBtn) {
        tracksMoreBtn.addEventListener('click', function() {
            if (!showingAll) {
                // Afficher toutes les pistes restantes
                const remainingTracks = tracks.slice(5);
                remainingTracks.forEach(t => {
                    appendTrack(t);
                });
                this.textContent = 'Afficher moins…';
                showingAll = true;
            } // <-- FIN du else (bouton pistes)
        }); // <-- FIN eventListener bouton pistes
    }
}

// === CARROUSEL : COMPOSITEURS SIMILAIRES (STRICTEMENT IDENTIQUE À FILMS SIMILAIRES) ===
const allComposers = [
    { name: "Ramin Djawadi", specialty: "Game of Thrones, Westworld", image: "Ramin Djawadi.jpg" },
    { name: "James Newton Howard", specialty: "The Dark Knight, Hunger Games", image: "James Newton Howard.jpg" },
    { name: "Junkie XL (Tom Holkenborg)", specialty: "Mad Max: Fury Road, Deadpool", image: "Junkie XL (Tom Holkenborg).jpg" },
    { name: "Ludwig Göransson", specialty: "Black Panther, Tenet", image: "Ludwig Göransson.jpg" },
    { name: "Cliff Martinez", specialty: "Drive, Solaris", image: "Cliff Martinez.jpg" },
    { name: "Steve Jablonsky", specialty: "Transformers, The Island", image: "Steve Jablonsky.jpg" },
    { name: "Henry Jackman", specialty: "Kingsman, Captain America", image: "Henry jackman.jpg" },
    { name: "Benjamin Wallfisch", specialty: "Blade Runner 2049, It", image: "Benjamin Wallfisch.jpg" },
    { name: "Harry Gregson-Williams", specialty: "Shrek, The Martian", image: "Harry Gregson-Williams.jpg" },
    { name: "John Powell", specialty: "How to Train Your Dragon, Shrek", image: "John Powell.webp" }
];

const similarComposersRow = document.getElementById("similarComposers");
if (similarComposersRow) {
    // Générer toutes les cartes compositeur strictement comme les films similaires
    similarComposersRow.innerHTML = '';
    allComposers.forEach(composer => {
        const col = document.createElement('div');
        col.className = 'col-6 col-md-3 mb-3';
        col.innerHTML = `
            <div class="carousel-card movie-card d-flex flex-column align-items-center p-0">
                <img src="/wp-content/themes/project-end-of-year/assets/image/Fiche Compositeur/${composer.image}" alt="${composer.name}" class="movie-card-img">
                <div class="similar-card-title w-100 text-center py-3 px-2">${composer.name}</div>
            </div>
        `;
        similarComposersRow.appendChild(col);
    });

    // ScrollBy identique à movies-series.js
    const carousel = document.querySelector('.composer-carousel');
    const leftArrow = carousel.querySelector('.carousel-arrow.left');
    const rightArrow = carousel.querySelector('.carousel-arrow.right');
    const row = carousel.querySelector('.row');
    if (leftArrow && rightArrow && row) {
        let card = row.querySelector('.col-6, .col-md-3, .col-12');
        let cardWidth = card ? card.offsetWidth : 250;
        let gap = 24;
        let scrollAmount = cardWidth + gap;
        leftArrow.addEventListener('click', function() {
            row.scrollBy({ left: -(scrollAmount), behavior: 'smooth' });
        });
        rightArrow.addEventListener('click', function() {
            row.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });
    }
}

// Charger les commentaires existants
function loadComments() {
    if (!commentsZone || typeof composerComments === 'undefined') return;
    
    fetch(composerComments.ajax_url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'get_composer_comments',
            composer_id: composerComments.composer_id
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
if (commentInput && !commentInput.disabled && typeof composerComments !== 'undefined') {
    commentInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && this.value.trim()) {
            const commentText = this.value.trim();
            
            fetch(composerComments.ajax_url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'add_composer_comment',
                    nonce: composerComments.nonce,
                    composer_id: composerComments.composer_id,
                    comment_text: commentText
                })
            })
            .then(response => {
                return response.json();
            })
            .then(data => {
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
        commentInput: !!commentInput,
        disabled: commentInput?.disabled,
        composerComments: typeof composerComments
    });
}

// Modifier un commentaire
function editComment(commentId, newText, textElement) {
    fetch(composerComments.ajax_url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'edit_composer_comment',
            nonce: composerComments.nonce,
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
    fetch(composerComments.ajax_url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'delete_composer_comment',
            nonce: composerComments.nonce,
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

loadComments();

// === CARROUSEL : COMPOSITEURS SIMILAIRES ===
// ...existing code...



}); // Fin DOMContentLoaded