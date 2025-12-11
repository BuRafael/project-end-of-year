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
        tracksTable.innerHTML += `
            <tr>
                <td>${t.id}</td>
                <td>
                    <div class="movie-track-info">
                        <img src="${imagePath}" class="movie-track-cover" alt="${t.title}">
                        <div>
                            <div class="movie-track-title">${t.title}</div>
                            <div class="movie-track-artist">${t.artist}</div>
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
const commentInput = document.querySelector('.comment-input');
const commentsZone = document.getElementById('commentsZone');
const commentsMoreBtnWrapper = document.getElementById('commentsMoreBtnWrapper');
const commentsMoreBtn = document.getElementById('commentsMoreBtn');

if (commentInput && commentsZone) {
    commentInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && commentInput.value.trim()) {
            addComment(commentInput.value.trim(), commentInput.dataset.userName);
            commentInput.value = '';
        }
    });

    function addComment(text, userName) {
        const currentDate = new Date();
        const dateStr = currentDate.toLocaleDateString('fr-FR');
        
        const commentHTML = `
            <div class="col-12">
                <div class="comment-card">
                    <div class="comment-header">
                        <div class="comment-user-info">
                            <div class="comment-avatar rounded-circle overflow-hidden d-flex align-items-center justify-content-center">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <div class="comment-user-name">${userName}</div>
                                <div class="comment-date">${dateStr}</div>
                            </div>
                        </div>
                    </div>
                    <div class="comment-content">${text}</div>
                </div>
            </div>
        `;
        
        commentsZone.insertAdjacentHTML('afterbegin', commentHTML);
    }
}

// === FILMS SIMILAIRES (Afficher plus) ===
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
