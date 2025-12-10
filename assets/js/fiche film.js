/**
 * Fiche Film JavaScript
 * Gère les pistes, commentaires, films similaires et interactions
 */

document.addEventListener('DOMContentLoaded', function() {

// === PISTES ===
const tracks = [
    { id: 1, title: "Half Remembered Dream", artist: "Hans Zimmer", duration: "1:12" },
    { id: 2, title: "We Built Our Own World", artist: "Hans Zimmer", duration: "1:55" },
    { id: 3, title: "Dream Is Collapsing", artist: "Hans Zimmer", duration: "2:28" },
    { id: 4, title: "Radical Notion", artist: "Hans Zimmer", duration: "3:42" },
    { id: 5, title: "Old Souls", artist: "Hans Zimmer", duration: "7:44" }
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
                        <img src="${imagePath}inception affiche film.jpg" class="movie-track-cover" alt="${t.title}">
                        <div>
                            <div class="movie-track-title">${t.title}</div>
                            <div class="movie-track-artist">${t.artist}</div>
                        </div>
                    </div>
                </td>
                <td class="col-links">
                    <span class="track-icons">
                        <i class="bi bi-spotify"></i>
                        <i class="bi bi-apple"></i>
                        <i class="bi bi-play-fill"></i>
                    </span>
                </td>
                <td class="col-duration text-center">${t.duration}</td>
                <td class="col-like text-end">
                    <i class="bi bi-heart track-like"></i>
                </td>
            </tr>
        `;
    });
}

// === COMMENTAIRES ===
const comments = [
    { user: "Kaori",  text: "Incroyable ce film !!!" },
    { user: "Rafael", text: "Bof." },
    { user: "Jim",    text: "Je pense qu’ils devraient faire mieux." },
    { user: "Joe",    text: "J’aime que les musiques du film." }
];

const commentsZone = document.getElementById("commentsZone");

if (commentsZone) {
    comments.forEach(c => {
        commentsZone.innerHTML += `
            <div class="col-12 col-md-3">
                <div class="comment-card">
                    <div class="comment-user">
                        <i class="bi bi-person"></i>${c.user}
                    </div>
                    <div class="comment-text">${c.text}</div>
                </div>
            </div>
        `;
    });
}

// === CARROUSEL : FILMS SIMILAIRES DYNAMIQUE ===
const allSimilarMovies = [
    { title: "Interstellar",    img: imagePath + "interstellar affiche similaire.jpg" },
    { title: "Shutter Island",  img: imagePath + "shutter island affiche similaire.jpg" },
    { title: "Matrix",          img: imagePath + "matrix affiche similaire.jpg" },
    { title: "Arrival",         img: imagePath + "arrival affiche similaire.jpg" },
    { title: "Inception",       img: imagePath + "inception_2010_advance_original_film_art_f4801a23-edb3-4db0-b382-1e2aec1dc927_5000x.jpg" },
    { title: "Tenet",           img: imagePath + "Tenet.jpg" },
    { title: "Dark City",       img: imagePath + "Dark city.jpg" },
    { title: "The Prestige",    img: imagePath + "the-prestige-md-web.jpg" }
];

let carouselIndex = 0;
const itemsPerPage = 4;
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

if (leftArrow) {
    leftArrow.addEventListener('click', function () {
        carouselIndex = (carouselIndex - 1 + allSimilarMovies.length) % allSimilarMovies.length;
        renderCarousel();
    });
}

if (rightArrow) {
    rightArrow.addEventListener('click', function () {
        carouselIndex = (carouselIndex + 1) % allSimilarMovies.length;
        renderCarousel();
    });
}

// render initial
renderCarousel();

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

// === AFFICHER PLUS : PISTES & COMMENTAIRES ===
const tracksMoreBtn = document.getElementById('tracksMoreBtn');
const commentsMoreBtn = document.getElementById('commentsMoreBtn');

// données supplémentaires (exemples) — peuvent être adaptées
const moreTracks = [
    { id: 6, title: "Mombasa", artist: "Hans Zimmer", duration: "4:00" },
    { id: 7, title: "One Simple Idea", artist: "Hans Zimmer", duration: "2:15" },
    { id: 8, title: "Stay", artist: "Hans Zimmer", duration: "5:30" },
    { id: 9, title: "Dream Within a Dream", artist: "Hans Zimmer", duration: "3:05" },
    { id: 10, title: "Time (Instrumental)", artist: "Hans Zimmer", duration: "6:20" }
];

const moreComments = [
    { user: "Lina", text: "La bande-son me donne des frissons." },
    { user: "Marc", text: "Une claque visuelle et sonore." },
    { user: "Ana", text: "Musique parfaite pour travailler." },
    { user: "Paul", text: "Toujours un plaisir de réécouter." }
];

function appendTracks(list, markAppended = false) {
    if (!tracksTable) return;
    list.forEach(t => {
        const tr = document.createElement('tr');
        if (markAppended) tr.classList.add('appended-track');
        tr.innerHTML = `
            <td>${t.id}</td>
            <td>
                <div class="movie-track-info">
                    <img src="${imagePath}inception affiche film.jpg" class="movie-track-cover" alt="${t.title}">
                    <div>
                        <div class="movie-track-title">${t.title}</div>
                        <div class="movie-track-artist">${t.artist}</div>
                    </div>
                </div>
            </td>
            <td class="col-links">
                <span class="track-icons">
                    <i class="bi bi-spotify"></i>
                    <i class="bi bi-apple"></i>
                    <i class="bi bi-play-fill"></i>
                </span>
            </td>
            <td class="col-duration text-center">${t.duration}</td>
            <td class="col-like text-end">
                <i class="bi bi-heart track-like"></i>
            </td>
        `;
        tracksTable.appendChild(tr);
    });
}

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

let tracksExpanded = false;
if (tracksMoreBtn) {
    tracksMoreBtn.addEventListener('click', function () {
        if (!tracksExpanded) {
            appendTracks(moreTracks, true);
            this.innerText = 'Afficher moins';
            tracksExpanded = true;
        } else {
            document.querySelectorAll('#tracksTable tr.appended-track').forEach(r => r.remove());
            this.innerText = 'Afficher plus…';
            tracksExpanded = false;
        }
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

}); // Fin DOMContentLoaded
