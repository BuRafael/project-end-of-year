/**
 * Fiche Compositeur JavaScript
 * Gère les pistes, commentaires, filmographie et interactions
 */

document.addEventListener('DOMContentLoaded', function() {

// === PISTES CELEBRES ===
const tracks = [
    { id: 1, title: "Time", film: "Inception", duration: "4:35", image: "inception affiche film.jpg" },
    { id: 2, title: "Now We Are Free", film: "Gladiator", duration: "4:15", image: "joker.JPG" },
    { id: 3, title: "Cornfield Chase", film: "Interstellar", duration: "2:06", image: "Interstellar.jpg" },
    { id: 4, title: "Why So Serious?", film: "The Dark Knight", duration: "9:14", image: "get out.jpg" },
    { id: 5, title: "No Time for Caution", film: "Interstellar", duration: "4:06", image: "Interstellar.jpg" },
    { id: 6, title: "He's a Pirate", film: "Pirates of the Caribbean", duration: "3:38", image: "gravity.jpg" },
    { id: 7, title: "Mountains", film: "Interstellar", duration: "3:39", image: "Interstellar.jpg" },
    { id: 8, title: "Dream Is Collapsing", film: "Inception", duration: "2:28", image: "inception affiche film.jpg" },
    { id: 9, title: "Tennessee", film: "Pearl Harbor", duration: "4:04", image: "Arrival.webp" },
    { id: 10, title: "Earth", film: "Gladiator", duration: "3:54", image: "shutter island affiche similaire.jpg" },
    { id: 11, title: "S.T.A.Y.", film: "Interstellar", duration: "6:52", image: "Interstellar.jpg" },
    { id: 12, title: "Like a Dog Chasing Cars", film: "The Dark Knight", duration: "5:03", image: "get out.jpg" },
    { id: 13, title: "Flight", film: "Man of Steel", duration: "5:46", image: "Arrival.webp" },
    { id: 14, title: "What Are You Going to Do?", film: "Man of Steel", duration: "6:11", image: "Arrival.webp" },
    { id: 15, title: "Mombasa", film: "Inception", duration: "4:54", image: "inception affiche film.jpg" },
    { id: 16, title: "Roll Tide", film: "Crimson Tide", duration: "4:23", image: "shutter island affiche similaire.jpg" },
    { id: 17, title: "Introduce a Little Anarchy", film: "The Dark Knight", duration: "5:25", image: "get out.jpg" },
    { id: 18, title: "Journey to the Line", film: "The Thin Red Line", duration: "8:31", image: "Arrival.webp" },
    { id: 19, title: "Chevaliers de Sangreal", film: "The Da Vinci Code", duration: "4:07", image: "shutter island affiche similaire.jpg" },
    { id: 20, title: "This Land", film: "The Lion King", duration: "2:55", image: "joker.JPG" },
    { id: 21, title: "Beautiful Lie", film: "Batman v Superman", duration: "4:17", image: "get out.jpg" },
    { id: 22, title: "Epilogue", film: "Dunkirk", duration: "7:16", image: "Arrival.webp" },
    { id: 23, title: "Drink Up Me Hearties", film: "Pirates of the Caribbean", duration: "4:31", image: "gravity.jpg" },
    { id: 24, title: "My Enemy", film: "The Last Samurai", duration: "5:25", image: "shutter island affiche similaire.jpg" },
    { id: 25, title: "Elysium", film: "Gladiator", duration: "2:48", image: "joker.JPG" }
];

const tracksTable = document.getElementById("tracksTable");
const tracksMoreBtn = document.getElementById('tracksMoreBtn');
const composerImgPath = typeof composerImagePath !== 'undefined' ? composerImagePath : '/wp-content/themes/project-end-of-year/assets/image/Fiche Compositeur/';
const filmImagePath = composerImgPath.replace('Fiche Compositeur', 'Fiche films');

const TRACKS_MIN = 5;
let tracksLimit = TRACKS_MIN;

function renderTracks(limit = tracksLimit) {
    if (!tracksTable) return;
    tracksLimit = limit;
    tracksTable.innerHTML = '';
    const slice = tracks.slice(0, tracksLimit);
    slice.forEach(t => {
        const coverSrc = filmImagePath + t.image;
        const trackId = `hanszimmer-${t.id}`;
        tracksTable.innerHTML += `
            <tr data-id="${trackId}">
                <td>${t.id}</td>
                <td>
                    <div class="composer-track-info">
                        <img src="${coverSrc}" class="composer-track-cover" alt="${t.title}">
                        <div>
                            <div class="composer-track-title">${t.title}</div>
                            <div class="composer-track-film">${t.film}</div>
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
    renderTracks(TRACKS_MIN);

    if (tracksMoreBtn) {
        tracksMoreBtn.addEventListener('click', () => {
            if (tracksLimit >= tracks.length) {
                renderTracks(TRACKS_MIN);
            } else {
                renderTracks(tracks.length);
            }
        });
    }

    tracksTable.addEventListener('click', function (e) {
        const target = e.target;
        if (!target.classList.contains('track-like')) return;

        const liked = target.classList.toggle('liked');
        target.classList.toggle('bi-heart', !liked);
        target.classList.toggle('bi-heart-fill', liked);
    });
}

// === CARROUSEL : COMPOSITEURS SIMILAIRES ===
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
    { name: "John Powell", specialty: "How to Train Your Dragon, Shrek", image: "John Powell.webp" },
    { name: "John Williams", specialty: "Star Wars, Jurassic Park", image: "Ramin Djawadi.jpg" },
    { name: "Alexandre Desplat", specialty: "The Shape of Water, The Grand Budapest Hotel", image: "James Newton Howard.jpg" },
    { name: "Thomas Newman", specialty: "Skyfall, American Beauty", image: "Cliff Martinez.jpg" },
    { name: "Michael Giacchino", specialty: "Up, Rogue One", image: "Steve Jablonsky.jpg" },
    { name: "Howard Shore", specialty: "The Lord of the Rings", image: "Harry Gregson-Williams.jpg" },
    { name: "Danny Elfman", specialty: "Batman, Edward Scissorhands", image: "Henry jackman.jpg" },
    { name: "Ennio Morricone", specialty: "The Good, the Bad and the Ugly", image: "Benjamin Wallfisch.jpg" },
    { name: "Alan Silvestri", specialty: "Avengers, Back to the Future", image: "John Powell.webp" },
    { name: "Carter Burwell", specialty: "No Country for Old Men", image: "Ludwig Göransson.jpg" },
    { name: "Marco Beltrami", specialty: "A Quiet Place, Scream", image: "Junkie XL (Tom Holkenborg).jpg" }
];

const similarComposersRow = document.getElementById("similarComposers");
if (similarComposersRow) {
    similarComposersRow.innerHTML = '';
    allComposers.forEach(composer => {
        const col = document.createElement('div');
        col.className = 'col-6 col-md-3 mb-3';
        col.innerHTML = `
            <div class="similar-card">
                <img src="${composerImgPath}${composer.image}" alt="${composer.name}">
                <div class="similar-card-title">${composer.name}</div>
            </div>
        `;
        similarComposersRow.appendChild(col);
    });

    // ScrollBy identique à movies-series.js
    const carousel = document.querySelector('.composer-carousel');
    if (carousel) {
        const leftArrow = carousel.querySelector('.carousel-arrow.left');
        const rightArrow = carousel.querySelector('.carousel-arrow.right');
        const row = carousel.querySelector('.row');
        if (leftArrow && rightArrow && row) {
            let card = row.querySelector('.col-6, .col-md-3');
            let cardWidth = card ? card.offsetWidth : 250;
            let gap = 8;
            let scrollAmount = cardWidth + gap;
            let cardsPerScroll = 4; // Nombre de cartes à défiler
            let totalScrollAmount = scrollAmount * cardsPerScroll;
            
            leftArrow.addEventListener('click', function() {
                let currentScroll = row.scrollLeft;
                let targetScroll = Math.max(0, Math.round(currentScroll / scrollAmount) * scrollAmount - totalScrollAmount);
                row.scrollTo({ left: targetScroll, behavior: 'smooth' });
            });
            
            rightArrow.addEventListener('click', function() {
                let currentScroll = row.scrollLeft;
                let targetScroll = Math.round(currentScroll / scrollAmount) * scrollAmount + totalScrollAmount;
                row.scrollTo({ left: targetScroll, behavior: 'smooth' });
            });
        }
    }
}

// === COMMENTAIRES ===
// Afficher un commentaire
function renderComment(commentData) {
    const col = document.createElement('div');
    col.className = 'col-12 col-md-3';
    col.dataset.commentId = commentData.id;
    const menuHtml = `
        <div class="comment-menu">
            <button class="comment-menu-btn" aria-label="Options">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <div class="comment-menu-dropdown">
                <button class="comment-edit-btn"${!commentData.is_author ? ' disabled style="opacity:0.5;cursor:not-allowed;"' : ''}>Modifier</button>
                <button class="comment-delete-btn"${!commentData.is_author ? ' disabled style="opacity:0.5;cursor:not-allowed;"' : ''}>Supprimer</button>
            </div>
        </div>`;
    
    let dateHtml = '';
    if (commentData.created_at) {
        const date = new Date(commentData.created_at);
        const now = new Date();
        const diffMs = now - date;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMs / 3600000);
        const diffDays = Math.floor(diffMs / 86400000);
        let timeAgo;
        if (diffMins < 1) timeAgo = "à l'instant";
        else if (diffMins < 60) timeAgo = `il y a ${diffMins} min`;
        else if (diffHours < 24) timeAgo = `il y a ${diffHours}h`;
        else if (diffDays < 7) timeAgo = `il y a ${diffDays}j`;
        else timeAgo = date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' });
        dateHtml = `<div class="comment-date">${timeAgo}</div>`;
    }
    
    let initialLikeCount = (typeof commentData.like_count === 'number' && !isNaN(commentData.like_count)) ? commentData.like_count : 0;
    col.innerHTML = `
        <div class="comment-card">
            ${menuHtml}
            <div class="comment-user">
                <span class="comment-user-avatar-wrapper">
                    ${commentData.avatar ? `<img src="${commentData.avatar}" alt="${commentData.user_name}" class="comment-user-avatar">` : '<i class="bi bi-person comment-user-icon"></i>'}
                </span>
                <span class="comment-user-name">${commentData.user_name}</span>
                <span class="comment-date">${dateHtml.replace('<div class=\"comment-date\">','').replace('</div>','')}</span>
            </div>
            <div class="comment-text">${commentData.comment_text}</div>
        </div>
    `;
    
    return col;
}

// Publier un commentaire
const commentsZone = document.getElementById('commentsZone');
const commentInput = document.querySelector('.comment-input');

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
            .then(response => response.json())
            .then(data => {
                if (data.success && commentsZone) {
                    const emptyMsg = commentsZone.querySelector('.text-center');
                    if (emptyMsg) {
                        emptyMsg.parentElement.remove();
                    }
                    const newComment = renderComment({
                        id: data.data.comment_id,
                        user_name: data.data.user_name,
                        avatar: data.data.avatar,
                        comment_text: data.data.comment_text,
                        is_author: true,
                        created_at: data.data.created_at,
                        like_count: 0
                    });
                    commentsZone.insertBefore(newComment, commentsZone.firstChild);
                    this.value = '';
                }
            })
            .catch(error => {
                console.error('Erreur lors de l\'ajout du commentaire:', error);
            });
        }
    });
}

// Fin DOMContentLoaded
});


