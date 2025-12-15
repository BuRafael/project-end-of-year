/**
 * Fiche Film JavaScript
 * Gère les pistes, commentaires, films similaires et interactions
 */

document.addEventListener('DOMContentLoaded', function() {

// === PISTES ===
const imagePath = typeof themeImagePath !== 'undefined' ? themeImagePath : 'assets/image/Fiche films/';
const trackImagePath = typeof themeTrackImagePath !== 'undefined' ? themeTrackImagePath : 'assets/image/Pistes film/';
const currentMovieSlug = window.currentMovieSlug || 'inception';

function getTracks(slug) {
            if (slug === 'parasite') {
                const cover = 'Parasite piste.png';
                return [
                    { id: 1, title: "Opening", artist: "Jung Jaeil", duration: "1:31", cover },
                    { id: 2, title: "Conciliation", artist: "Jung Jaeil", duration: "2:36", cover },
                    { id: 3, title: "On the Way to Rich House", artist: "Jung Jaeil", duration: "1:38", cover },
                    { id: 4, title: "The Frontal Lobe", artist: "Jung Jaeil", duration: "2:17", cover },
                    { id: 5, title: "Zappaguri", artist: "Jung Jaeil", duration: "2:51", cover },
                    { id: 6, title: "Camping", artist: "Jung Jaeil", duration: "2:21", cover },
                    { id: 7, title: "The Belt of Faith", artist: "Jung Jaeil", duration: "3:23", cover },
                    { id: 8, title: "Water, Ocean", artist: "Jung Jaeil", duration: "2:40", cover },
                    { id: 9, title: "Wish", artist: "Jung Jaeil", duration: "1:38", cover },
                    { id: 10, title: "End Credits", artist: "Jung Jaeil", duration: "3:36", cover }
                ];
            }
        if (slug === 'your-name') {
            return [
                { id: 1, title: 'Dream Lantern', artist: 'RADWIMPS', duration: '2:09', cover: 'your name piste.png' },
                { id: 2, title: 'School Road', artist: 'RADWIMPS', duration: '1:11', cover: 'your name piste.png' },
                { id: 3, title: 'Itomori High School', artist: 'RADWIMPS', duration: '1:37', cover: 'your name piste.png' },
                { id: 4, title: 'First View of Tokyo', artist: 'RADWIMPS', duration: '1:43', cover: 'your name piste.png' },
                { id: 5, title: 'Cafe at Last', artist: 'RADWIMPS', duration: '1:57', cover: 'your name piste.png' },
                { id: 6, title: 'Theme of Mitsuha', artist: 'RADWIMPS', duration: '2:28', cover: 'your name piste.png' },
                { id: 7, title: 'Unusual Changes of Two', artist: 'RADWIMPS', duration: '1:42', cover: 'your name piste.png' },
                { id: 8, title: 'Zenzenzense (movie ver.)', artist: 'RADWIMPS', duration: '4:46', cover: 'your name piste.png' },
                { id: 9, title: 'Goshintai', artist: 'RADWIMPS', duration: '2:01', cover: 'your name piste.png' },
                { id: 10, title: 'Date', artist: 'RADWIMPS', duration: '2:18', cover: 'your name piste.png' },
                { id: 11, title: 'Autumn Festival', artist: 'RADWIMPS', duration: '1:45', cover: 'your name piste.png' },
                { id: 12, title: 'Memories of Time', artist: 'RADWIMPS', duration: '1:47', cover: 'your name piste.png' },
                { id: 13, title: 'Visit to Hida', artist: 'RADWIMPS', duration: '2:11', cover: 'your name piste.png' },
                { id: 14, title: 'Disappeared Town', artist: 'RADWIMPS', duration: '2:50', cover: 'your name piste.png' },
                { id: 15, title: 'Library', artist: 'RADWIMPS', duration: '2:01', cover: 'your name piste.png' },
                { id: 16, title: 'Two People', artist: 'RADWIMPS', duration: '2:17', cover: 'your name piste.png' },
                { id: 17, title: 'Katawaredoki', artist: 'RADWIMPS', duration: '2:47', cover: 'your name piste.png' },
                { id: 18, title: 'Sparkle (movie ver.)', artist: 'RADWIMPS', duration: '8:54', cover: 'your name piste.png' },
                { id: 19, title: 'Date 2', artist: 'RADWIMPS', duration: '2:18', cover: 'your name piste.png' },
                { id: 20, title: 'Nandemonaiya (movie ver.)', artist: 'RADWIMPS', duration: '5:45', cover: 'your name piste.png' },
                { id: 21, title: 'Dreams of Tomorrow', artist: 'RADWIMPS', duration: '1:55', cover: 'your name piste.png' },
                { id: 22, title: 'Reunion', artist: 'RADWIMPS', duration: '1:26', cover: 'your name piste.png' },
                { id: 23, title: 'Epilogue', artist: 'RADWIMPS', duration: '2:21', cover: 'your name piste.png' }
            ];
        }
    if (slug === 'interstellar') {
        const interstellarCover = 'interstellar piste.png';
        return [
            { id: 1, title: "Dreaming of the Crash", artist: "Hans Zimmer", duration: "3:55", cover: interstellarCover },
            { id: 2, title: "Cornfield Chase", artist: "Hans Zimmer", duration: "2:06", cover: interstellarCover },
            { id: 3, title: "Dust", artist: "Hans Zimmer", duration: "5:41", cover: interstellarCover },
            { id: 4, title: "Day One", artist: "Hans Zimmer", duration: "3:19", cover: interstellarCover },
            { id: 5, title: "Message from Home", artist: "Hans Zimmer", duration: "1:40", cover: interstellarCover },
            { id: 6, title: "The Wormhole", artist: "Hans Zimmer", duration: "1:30", cover: interstellarCover },
            { id: 7, title: "Mountains", artist: "Hans Zimmer", duration: "4:12", cover: interstellarCover },
            { id: 8, title: "Afraid of Time", artist: "Hans Zimmer", duration: "2:32", cover: interstellarCover },
            { id: 9, title: "Detach", artist: "Hans Zimmer", duration: "6:23", cover: interstellarCover },
            { id: 10, title: "Running Out", artist: "Hans Zimmer", duration: "1:57", cover: interstellarCover },
            { id: 11, title: "Tick-Tock", artist: "Hans Zimmer", duration: "1:48", cover: interstellarCover },
            { id: 12, title: "Where We're Going", artist: "Hans Zimmer", duration: "7:32", cover: interstellarCover },
            { id: 13, title: "Do Not Go Gentle", artist: "Hans Zimmer", duration: "4:06", cover: interstellarCover },
            { id: 14, title: "No Time for Caution", artist: "Hans Zimmer", duration: "4:06", cover: interstellarCover },
            { id: 15, title: "Murph", artist: "Hans Zimmer", duration: "6:17", cover: interstellarCover },
            { id: 16, title: "Stay", artist: "Hans Zimmer", duration: "6:52", cover: interstellarCover }
        ];
    }
        // ...

    if (slug === 'arrival') {
        const cover = 'arrival piste.png';
        return [
            { id: 1, title: "On the Nature of Daylight", artist: "Max Richter", duration: "6:25", cover: cover },
            { id: 2, title: "Arrival", artist: "Jóhann Jóhannsson", duration: "2:08", cover: cover },
            { id: 3, title: "Heptapod B", artist: "Jóhann Jóhannsson", duration: "3:47", cover: cover },
            { id: 4, title: "Sapir-Whorf", artist: "Jóhann Jóhannsson", duration: "1:59", cover: cover },
            { id: 5, title: "Transmutation at a Distance", artist: "Jóhann Jóhannsson", duration: "1:41", cover: cover },
            { id: 6, title: "Logograms", artist: "Jóhann Jóhannsson", duration: "3:15", cover: cover },
            { id: 7, title: "Decyphering", artist: "Jóhann Jóhannsson", duration: "2:01", cover: cover },
            { id: 8, title: "Kangaru", artist: "Jóhann Jóhannsson", duration: "2:12", cover: cover },
            { id: 9, title: "Hydraulic Lift", artist: "Jóhann Jóhannsson", duration: "1:30", cover: cover },
            { id: 10, title: "First Encounter", artist: "Jóhann Jóhannsson", duration: "3:20", cover: cover },
            { id: 11, title: "Strange Atmosphere", artist: "Jóhann Jóhannsson", duration: "2:11", cover: cover },
            { id: 12, title: "Ultimatum", artist: "Jóhann Jóhannsson", duration: "1:42", cover: cover },
            { id: 13, title: "Hitting the Egg", artist: "Jóhann Jóhannsson", duration: "2:36", cover: cover },
            { id: 14, title: "The Casio", artist: "Jóhann Jóhannsson", duration: "1:33", cover: cover },
            { id: 15, title: "One of Twelve", artist: "Jóhann Jóhannsson", duration: "3:11", cover: cover },
            { id: 16, title: "Rise", artist: "Jóhann Jóhannsson", duration: "1:58", cover: cover },
            { id: 17, title: "Extreme Hectopods", artist: "Jóhann Jóhannsson", duration: "2:44", cover: cover },
            { id: 18, title: "This Is Not a Dream", artist: "Jóhann Jóhannsson", duration: "3:07", cover: cover },
            { id: 19, title: "War", artist: "Jóhann Jóhannsson", duration: "2:22", cover: cover },
            { id: 20, title: "Birth", artist: "Jóhann Jóhannsson", duration: "3:10", cover: cover }
        ];
    }
    if (slug === 'la-la-land') {
        const cover = 'La la land piste.png';
        return [
            { id: 1, title: "Another Day of Sun", artist: "La La Land Cast", duration: "3:48", cover },
            { id: 2, title: "Someone in the Crowd", artist: "Emma Stone, Callie Hernandez, Sonoya Mizuno, Jessica Rothe", duration: "4:19", cover },
            { id: 3, title: "Mia & Sebastian's Theme", artist: "Justin Hurwitz", duration: "1:37", cover },
            { id: 4, title: "A Lovely Night", artist: "Ryan Gosling, Emma Stone", duration: "3:56", cover },
            { id: 5, title: "Herman's Habit", artist: "Justin Hurwitz", duration: "1:51", cover },
            { id: 6, title: "City of Stars", artist: "Ryan Gosling, Emma Stone", duration: "2:29", cover },
            { id: 7, title: "Planetarium", artist: "Justin Hurwitz", duration: "4:18", cover },
            { id: 8, title: "Summer Montage / Madeline", artist: "Justin Hurwitz", duration: "2:05", cover },
            { id: 9, title: "Start a Fire", artist: "John Legend", duration: "3:12", cover },
            { id: 10, title: "Engagement Party", artist: "Justin Hurwitz", duration: "1:28", cover },
            { id: 11, title: "Audition (The Fools Who Dream)", artist: "Emma Stone", duration: "3:48", cover },
            { id: 12, title: "Epilogue", artist: "Justin Hurwitz", duration: "7:40", cover },
            { id: 13, title: "The End", artist: "Justin Hurwitz", duration: "0:44", cover },
            { id: 14, title: "City of Stars (Humming)", artist: "Emma Stone", duration: "2:44", cover }
        ];
    }
    if (slug === 'spirited-away') {
        return [
            { id: 1, title: "One Summer’s Day", artist: "Joe Hisaishi", duration: "2:25", cover: "spirited away piste.png" },
            { id: 2, title: "A Road to Somewhere", artist: "Joe Hisaishi", duration: "3:46", cover: "spirited away piste.png" },
            { id: 3, title: "The Empty Restaurant", artist: "Joe Hisaishi", duration: "3:27", cover: "spirited away piste.png" },
            { id: 4, title: "Nighttime Coming", artist: "Joe Hisaishi", duration: "2:20", cover: "spirited away piste.png" },
            { id: 5, title: "Dragon Boy", artist: "Joe Hisaishi", duration: "1:55", cover: "spirited away piste.png" },
            { id: 6, title: "Sootballs", artist: "Joe Hisaishi", duration: "2:57", cover: "spirited away piste.png" },
            { id: 7, title: "Procession of the Gods", artist: "Joe Hisaishi", duration: "3:00", cover: "spirited away piste.png" },
            { id: 8, title: "Yubaba", artist: "Joe Hisaishi", duration: "2:38", cover: "spirited away piste.png" },
            { id: 9, title: "Bathhouse Morning", artist: "Joe Hisaishi", duration: "2:42", cover: "spirited away piste.png" },
            { id: 10, title: "Day of the River", artist: "Joe Hisaishi", duration: "3:05", cover: "spirited away piste.png" },
            { id: 11, title: "It’s Hard Work", artist: "Joe Hisaishi", duration: "2:30", cover: "spirited away piste.png" },
            { id: 12, title: "The Stink Spirit", artist: "Joe Hisaishi", duration: "3:20", cover: "spirited away piste.png" },
            { id: 13, title: "Sen’s Courage", artist: "Joe Hisaishi", duration: "3:23", cover: "spirited away piste.png" },
            { id: 14, title: "The Sixth Station", artist: "Joe Hisaishi", duration: "3:57", cover: "spirited away piste.png" },
            { id: 15, title: "Yubaba’s Panic", artist: "Joe Hisaishi", duration: "1:48", cover: "spirited away piste.png" },
            { id: 16, title: "The House at Swamp Bottom", artist: "Joe Hisaishi", duration: "2:50", cover: "spirited away piste.png" },
            { id: 17, title: "Reprise", artist: "Joe Hisaishi", duration: "2:35", cover: "spirited away piste.png" },
            { id: 18, title: "The Return", artist: "Joe Hisaishi", duration: "3:30", cover: "spirited away piste.png" },
            { id: 19, title: "Always with Me", artist: "Joe Hisaishi", duration: "3:35", cover: "spirited away piste.png" }
        ];
    }
    // Default Inception tracks (12 pistes officielles OST)
    return [
        { id: 1, title: "Half Remembered Dream", artist: "Hans Zimmer", duration: "1:12", cover: "inception affiche film.jpg" },
        { id: 2, title: "We Built Our Own World", artist: "Hans Zimmer", duration: "1:56", cover: "inception affiche film.jpg" },
        { id: 3, title: "Dream Is Collapsing", artist: "Hans Zimmer", duration: "2:28", cover: "inception affiche film.jpg" },
        { id: 4, title: "Radical Notion", artist: "Hans Zimmer", duration: "3:43", cover: "inception affiche film.jpg" },
        { id: 5, title: "Old Souls", artist: "Hans Zimmer", duration: "7:44", cover: "inception affiche film.jpg" },
        { id: 6, title: "528491", artist: "Hans Zimmer", duration: "2:23", cover: "inception affiche film.jpg" },
        { id: 7, title: "Mombasa", artist: "Hans Zimmer", duration: "4:54", cover: "inception affiche film.jpg" },
        { id: 8, title: "One Simple Idea", artist: "Hans Zimmer", duration: "2:28", cover: "inception affiche film.jpg" },
        { id: 9, title: "Dream Within a Dream", artist: "Hans Zimmer", duration: "5:04", cover: "inception affiche film.jpg" },
        { id: 10, title: "Waiting for a Train", artist: "Hans Zimmer", duration: "9:30", cover: "inception affiche film.jpg" },
        { id: 11, title: "Paradox", artist: "Hans Zimmer", duration: "3:25", cover: "inception affiche film.jpg" },
        { id: 12, title: "Time", artist: "Hans Zimmer", duration: "4:36", cover: "inception affiche film.jpg" }
    ];
}

const tracks = getTracks(currentMovieSlug);
const tracksTable = document.getElementById("tracksTable");
const tracksMoreBtn = document.getElementById('tracksMoreBtn');
const TRACKS_MIN = 5;
const TRACKS_STEP = 5;
// Pour Inception, afficher d'emblée toutes les pistes, mais permettre "Afficher moins" à 5
let tracksLimit = currentMovieSlug === 'inception' ? tracks.length : TRACKS_MIN;

function renderTracks(limit = tracksLimit) {
    if (!tracksTable) return;
    tracksLimit = limit;
    tracksTable.innerHTML = '';
    const slice = tracks.slice(0, tracksLimit);
    slice.forEach(t => {
        const artistHtml = t.artist === 'Hans Zimmer'
            ? `<a href="${window.location.origin}/hans-zimmer" class="movie-track-artist" style="cursor: pointer;">${t.artist}</a>`
            : `<div class="movie-track-artist">${t.artist}</div>`;

        // Déterminer le chemin correct selon si c'est une image de piste ou d'affiche
        let coverPath = imagePath;
        if (t.cover && t.cover.includes('piste')) {
            coverPath = trackImagePath;
        }
        const coverSrc = coverPath + (t.cover || 'inception affiche film.jpg');
        
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
                renderTracks(TRACKS_MIN);
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
        // Nettoyer le wrapper
        commentsZone.innerHTML = '';
        const moreBtnWrapper = document.getElementById('commentsMoreBtnWrapper');
        if (moreBtnWrapper) moreBtnWrapper.style.display = 'none';
        if (data.success && Array.isArray(data.data.comments) && data.data.comments.length > 0) {
            data.data.comments.forEach(c => {
                renderComment(c);
            });
            // Afficher le bouton "Afficher plus" si plus de 8 commentaires
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
    commentInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && this.value.trim()) {
            const commentText = this.value.trim();
            
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
                }
            })
            .catch(error => {
            });
        }
    });
} else {
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
            // On vérifie s'il reste des commentaires visibles (hors éléments vides)
            const hasRealComments = Array.from(commentsZone.children).some(child => child.dataset && child.dataset.commentId);
            if (!hasRealComments) {
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
    if (slug === 'spirited-away') {
        return [
            { title: "Princess Mononoke", img: imagePath + "princess mononoke.jpg" },
            { title: "My Neighbor Totoro", img: imagePath + "my neighbor totoro.jpeg" },
            { title: "Howl’s Moving Castle", img: imagePath + "howl's moving castle.webp" },
            { title: "Ponyo", img: imagePath + "ponyo.webp" },
            { title: "Nausicaä of the Valley of the Wind", img: imagePath + "nausicä of the valley of the wind.webp" },
            { title: "Castle in the Sky", img: imagePath + "castle in the sky.jpg" },
            { title: "The Tale of the Princess Kaguya", img: imagePath + "the tale of the princess kaguya.avif" },
            { title: "When Marnie Was There", img: imagePath + "when marnie was there.webp" },
            { title: "Paprika", img: imagePath + "Paprika.webp" },
            { title: "The Boy and the Beast", img: imagePath + "the boy and the beast.jpg" }
        ];
    }
    if (slug === 'your-name') {
        return [
            { title: "A Silent Voice", img: imagePath + "a silent voice.jpg" },
            { title: "Weathering With You", img: imagePath + "weathering with you.webp" },
            { title: "Suzume", img: imagePath + "suzume.jpg" },
            { title: "5 Centimeters per Second", img: imagePath + "5 centimeters per second.jpg" },
            { title: "The Garden of Words", img: imagePath + "the garden of words.jpg" },
            { title: "The Girl Who Leapt Through Time", img: imagePath + "the girl who leapt through time.jpg" },
            { title: "I Want to Eat Your Pancreas", img: imagePath + "i want to eat your pancreas.jpg" },
            { title: "Wolf Children", img: imagePath + "wolf children.jpg" },
            { title: "Ride Your Wave", img: imagePath + "ride your wave.webp" },
            { title: "Josee, the Tiger and the Fish", img: imagePath + "josee the tiger and the fish.jpg" }
        ];
    }
    if (slug === 'interstellar') {
        return [
            { title: "Inception", img: imagePath + "inception affiche film.jpg" },
            { title: "Gravity", img: imagePath + "gravity.jpg" },
            { title: "Arrival", img: imagePath + "Arrival.webp" },
            { title: "2001: A Space Odyssey", img: imagePath + "2001 a space odyssey.jpg" },
            { title: "Ad Astra", img: imagePath + "ad astra.jpg" },
            { title: "Contact", img: imagePath + "contact.webp" },
            { title: "Solaris", img: imagePath + "solaris.jpg" },
            { title: "The Martian", img: imagePath + "the martian.jpg" },
            { title: "Sunshine", img: imagePath + "sunshine.jpg" },
            { title: "Annihilation", img: imagePath + "annihilation.jpg" }
        ];
    }
    if (slug === 'arrival') {
        return [
            { title: "The Day the Earth Stood Still", img: imagePath + "the day the earth stood still.jpg" },
            { title: "Under the Skin", img: imagePath + "under the skin.jpg" },
            { title: "District 9", img: imagePath + "district 9.jpg" },
            { title: "Ex Machina", img: imagePath + "Ex machina.jpg" },
            { title: "2001: A Space Odyssey", img: imagePath + "2001 a space odyssey.jpg" }
        ];
    }
    if (slug === 'la-la-land') {
        return [
            { title: "Singin' in the Rain", img: imagePath + "singin in the rain.jpg" },
            { title: "A Star Is Born", img: imagePath + "a star is born.jpg" },
            { title: "Tick, Tick… Boom!", img: imagePath + "tick tick boom.jpg" },
            { title: "Once", img: imagePath + "once.jpg" },
            { title: "Moulin Rouge!", img: imagePath + "moulin rouge.jpg" },
            { title: "Sing Street", img: imagePath + "Sing street.jpg" },
            { title: "Begin Again", img: imagePath + "begin again.jpg" },
            { title: "The Umbrellas of Cherbourg", img: imagePath + "the umbrellas of cherbourg.jpg" },
            { title: "Whiplash", img: imagePath + "whiplash.jpg" },
            { title: "Your Name", img: imagePath + "your name.jpg" }
        ];
    }
    if (slug === 'parasite') {
        return [
            { title: "Burning", img: imagePath + "burning.jpg" },
            { title: "Mother", img: imagePath + "mother.webp" },
            { title: "Shoplifters", img: imagePath + "shoplifters.jpg" },
            { title: "Snowpiercer", img: imagePath + "snowpiercer.jpg" },
            // Correction ici : image fallback car 'memories of murder.jpg' n'existe pas
            { title: "Memories of Murder", img: imagePath + "memories of murder.jpg" },
            { title: "The Handmaiden", img: imagePath + "the handmaiden.jpg" },
            { title: "Triangle of Sadness", img: imagePath + "triangle of sadness.jpg" },
            { title: "Get Out", img: imagePath + "get out.jpg" },
            { title: "High Rise", img: imagePath + "high rise.jpg" },
            { title: "The Platform", img: imagePath + "the platform.jpg" }
        ];
    }
    // Fallback générique
    return [
        { title: "Interstellar", img: imagePath + "interstellar affiche similaire.jpg" },
        { title: "Tenet", img: imagePath + "tenet2.jpg" },
        { title: "The Prestige", img: imagePath + "The Prestige.webp" },
        { title: "Memento", img: imagePath + "momento.jpg" },
        { title: "Shutter Island", img: imagePath + "shutter island affiche similaire.jpg" },
        { title: "Paprika", img: imagePath + "paprika.webp" },
        { title: "Coherence", img: imagePath + "coherence.webp" },
        { title: "Dark City", img: imagePath + "Dark city.jpg" },
        { title: "Source Code", img: imagePath + "Source code.jpg" },
        { title: "Ex Machina", img: imagePath + "Ex machina.jpg" },
        { title: "Edge of Tomorrow", img: imagePath + "Edge of Tomorrow.jpg" },
        { title: "Minority Report", img: imagePath + "Minority report.jpg" }
    ];
}


// Initialiser le carrousel une fois le DOM chargé
const slug = window.currentMovieSlug || 'inception';
const allSimilarMovies = getSimilarMovies(slug);
initGenericCarousel({
    containerId: 'similarMovies',
    items: allSimilarMovies,
    getCardHtml: (m) => `
        <div class="col-6 col-md-3">
            <div class="similar-card">
                <img src="${m.img}" alt="${m.title}">
                <div class="similar-card-title">${m.title}</div>
            </div>
        </div>
    `
});

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

// Toujours tenter de charger les commentaires au démarrage
loadComments();

}); // Fin DOMContentLoaded
