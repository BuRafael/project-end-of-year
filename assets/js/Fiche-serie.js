

/**
 * Fiche Série JavaScript
 * Gère les pistes, commentaires, séries similaires et interactions
 */

document.addEventListener('DOMContentLoaded', function() {


// === PISTES PAR SAISON ET ÉPISODE ===
const TRACKS_DISPLAY_COUNT = 5; // Nombre de pistes à afficher par défaut
const allTracks = window.allTracks || {};
const tracksTable = document.getElementById("tracksTable");
const imagePath = typeof themeImagePath !== 'undefined' ? themeImagePath : 'assets/image/Piste séries/';
const seasonSelect = document.getElementById("seasonSelect");
const episodeSelect = document.getElementById("episodeSelect");
let currentTracks = [];
let tracksPage = 1;

function renderSeasonEpisodeSelects() {
    if (!seasonSelect || !episodeSelect) return;
    seasonSelect.innerHTML = '<option value="" disabled selected hidden>Saison</option>';
    episodeSelect.innerHTML = '<option value="" disabled selected hidden>Épisode</option>';
    const serieSlug = window.currentSerieSlug || '';
    // Cas particulier pour Euphoria : 2 saisons, 8 épisodes chacune
    if (serieSlug === 'euphoria') {
        for (let s = 1; s <= 2; s++) {
            const opt = document.createElement('option');
            opt.value = s;
            opt.textContent = 'Saison ' + s;
            seasonSelect.appendChild(opt);
        }
        // Par défaut, afficher 8 épisodes
        for (let e = 1; e <= 8; e++) {
            const opt = document.createElement('option');
            opt.value = e;
            opt.textContent = 'Épisode ' + e;
            episodeSelect.appendChild(opt);
        }
        seasonSelect.value = 1;
        episodeSelect.value = 1;
        displayTracks(1, 1);
    } else if (serieSlug === 'wednesday') {
        // Cas particulier pour Wednesday : 1 saison, 8 épisodes
        const opt = document.createElement('option');
        opt.value = 1;
        opt.textContent = 'Saison 1';
        seasonSelect.appendChild(opt);
        for (let e = 1; e <= 8; e++) {
            const epOpt = document.createElement('option');
            epOpt.value = e;
            epOpt.textContent = 'Épisode ' + e;
            episodeSelect.appendChild(epOpt);
        }
        seasonSelect.value = 1;
        episodeSelect.value = 1;
        displayTracks(1, 1);
    } else {
        // Générique : basé sur la structure allTracks
        Object.keys(allTracks).forEach(seasonNum => {
            const opt = document.createElement('option');
            opt.value = seasonNum;
            opt.textContent = 'Saison ' + seasonNum;
            seasonSelect.appendChild(opt);
        });
        const firstSeason = Object.keys(allTracks)[0];
        if (allTracks[firstSeason]) {
            const episodeNums = Object.keys(allTracks[firstSeason]);
            episodeNums.forEach(epNum => {
                const opt = document.createElement('option');
                opt.value = epNum;
                opt.textContent = 'Épisode ' + epNum;
                episodeSelect.appendChild(opt);
            });
            seasonSelect.value = firstSeason;
            episodeSelect.value = episodeNums[0];
            displayTracks(parseInt(firstSeason), parseInt(episodeNums[0]));
        }
    }
}

if (seasonSelect && episodeSelect && tracksTable) {
    renderSeasonEpisodeSelects();
    seasonSelect.addEventListener('change', function() {
        episodeSelect.innerHTML = '<option value="" disabled selected hidden>Épisode</option>';
        const serieSlug = window.currentSerieSlug || '';
        if (serieSlug === 'euphoria') {
            for (let e = 1; e <= 8; e++) {
                const opt = document.createElement('option');
                opt.value = e;
                opt.textContent = 'Épisode ' + e;
                episodeSelect.appendChild(opt);
            }
            episodeSelect.value = 1;
            displayTracks(parseInt(this.value), 1);
        } else if (serieSlug === 'wednesday') {
            for (let e = 1; e <= 8; e++) {
                const opt = document.createElement('option');
                opt.value = e;
                opt.textContent = 'Épisode ' + e;
                episodeSelect.appendChild(opt);
            }
            episodeSelect.value = 1;
            displayTracks(1, 1);
        } else {
            const season = this.value;
            if (allTracks[season]) {
                const episodeNums = Object.keys(allTracks[season]);
                episodeNums.forEach(epNum => {
                    const opt = document.createElement('option');
                    opt.value = epNum;
                    opt.textContent = 'Épisode ' + epNum;
                    episodeSelect.appendChild(opt);
                });
                const firstEp = episodeNums[0];
                episodeSelect.value = firstEp;
                displayTracks(parseInt(season), parseInt(firstEp));
            } else {
                episodeSelect.innerHTML = '<option value="" disabled selected hidden>Épisode</option>';
                tracksTable.innerHTML = `<tr><td colspan=\"5\" style=\"text-align:center; color: #888; font-style: italic;\">Rien à écouter pour le moment...</td></tr>`;
                updateTracksMoreBtn(0);
            }
        }
    });
    episodeSelect.addEventListener('change', function() {
        displayTracks(parseInt(seasonSelect.value), parseInt(this.value));
    });
}


// Fonction pour afficher les pistes
function displayTracks(season, episode) {
    if (!tracksTable) return;
    const tracks = (allTracks[season] && allTracks[season][episode]) ? allTracks[season][episode] : [];
    currentTracks = tracks;
    tracksPage = 1;
    renderTracksPage();
    updateTracksMoreBtn(tracks.length);
}

function renderTracksPage() {
    tracksTable.innerHTML = '';
    const start = 0;
    const end = tracksPage * TRACKS_DISPLAY_COUNT;
    if (!currentTracks || currentTracks.length === 0) {
        tracksTable.innerHTML = `<tr><td colspan="5" style="text-align:center; color: #888; font-style: italic;">Rien à écouter pour le moment...</td></tr>`;
        return;
    }
    currentTracks.slice(0, end).forEach((t, index) => {
        const artistHtml = t.artist === 'Hans Zimmer' 
            ? `<a href="${window.location.origin}/hans-zimmer" class="movie-track-artist" style="cursor: pointer;">${t.artist}</a>`
            : `<div class="movie-track-artist">${t.artist}</div>`;
        const trackImage = t.image ? imagePath + t.image : imagePath;
        const isFirstTrack = index === 0 ? 'first-track-image' : '';
        tracksTable.innerHTML += `
            <tr>
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


// Like/unlike tracks (event delegation so it works for appended rows too)
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('track-like')) {
        const row = e.target.closest('tr');
        const trackTitle = row.querySelector('.movie-track-title')?.textContent || '';
        const trackArtist = row.querySelector('.movie-track-artist')?.textContent || '';
        const trackDuration = row.querySelector('.col-duration')?.textContent || '';
        const trackCover = row.querySelector('.movie-track-cover')?.src || '';
        const trackNumber = row.querySelector('td:first-child')?.textContent || '';
        
        e.target.classList.toggle('liked');
        const liked = e.target.classList.contains('liked');
        
        if (liked) {
            e.target.classList.remove('bi-heart');
            e.target.classList.add('bi-heart-fill');
        } else {
            e.target.classList.remove('bi-heart-fill');
            e.target.classList.add('bi-heart');
        }
        
        // Gérer les favoris de pistes
        let favoriteTracks = JSON.parse(localStorage.getItem('favoriteTracks') || '[]');
        const trackId = `${window.currentMovieSlug}-${trackNumber}`;
        
        if (liked) {
            // Ajouter aux favoris
            const trackData = {
                id: trackId,
                title: trackTitle,
                artist: trackArtist,
                duration: trackDuration,
                cover: trackCover,
                source: document.querySelector('.movie-header h1')?.textContent || ''
            };
            
            // Vérifier si pas déjà présent
            if (!favoriteTracks.some(track => track.id === trackId)) {
                favoriteTracks.push(trackData);
                localStorage.setItem('favoriteTracks', JSON.stringify(favoriteTracks));
            }
        } else {
            // Retirer des favoris
            favoriteTracks = favoriteTracks.filter(track => track.id !== trackId);
            localStorage.setItem('favoriteTracks', JSON.stringify(favoriteTracks));
        }
    }
});

// === AFFICHER PLUS / AFFICHER MOINS (PISTES) ===
const tracksMoreBtn = document.getElementById("tracksMoreBtn");
if (tracksMoreBtn) {
    tracksMoreBtn.addEventListener('click', function() {
        const totalTracks = currentTracks.length;
        const maxPages = Math.ceil(totalTracks / TRACKS_DISPLAY_COUNT);
        if (tracksPage < maxPages) {
            tracksPage++;
            renderTracksPage();
            if (tracksPage === maxPages) {
                this.textContent = 'Afficher moins…';
                this.classList.add('show-less');
            }
        } else {
            tracksPage = 1;
            renderTracksPage();
            this.textContent = 'Afficher plus…';
            this.classList.remove('show-less');
        }
    });
}

// === COMMENTAIRES ===
const commentsZone = document.getElementById("commentsZone");
const commentInput = document.querySelector('.comment-input');

// Charger les commentaires au démarrage
loadComments();
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
                } else {
                    console.error('Erreur:', data);
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


// === SÉRIES SIMILAIRES ===
const serieImagePath = imagePath.replace('Piste séries/', 'Fiche série/');
// Récupérer le slug de la série courante depuis le body ou une variable globale injectée par PHP
let currentSerieSlug = document.body.dataset.serieSlug || window.currentSerieSlug || '';
if (!currentSerieSlug && typeof page_slug !== 'undefined') currentSerieSlug = page_slug;

const similarSeriesMap = {
                        'jujutsu-kaisen': [
                            { title: "My Hero Academia", image: serieImagePath + "my hero academia.jpg" },
                            { title: "Demon Slayer (Kimetsu no Yaiba)", image: serieImagePath + "demon slayer.jpg" },
                            { title: "Tokyo Ghoul", image: serieImagePath + "tokyo ghoul.jpg" },
                            { title: "Attack on Titan", image: serieImagePath + "attack on titan.jpg" },
                            { title: "Blue Exorcist", image: serieImagePath + "blue exorcist.webp" },
                            { title: "Noragami", image: serieImagePath + "noragami.jpg" },
                            { title: "Mob Psycho 100", image: serieImagePath + "mob psycho 100.jpg" },
                            { title: "Hunter x Hunter", image: serieImagePath + "hunter x hunter.jpg" },
                            { title: "Black Clover", image: serieImagePath + "black clover.jpg" },
                            { title: "Dorohedoro", image: serieImagePath + "dorohedoro.jpg" }
                        ],
                    'demon-slayer': [
                        { title: "Jujutsu Kaisen", image: serieImagePath + "jujutsu kaisen.jpg" },
                        { title: "Blue Exorcist", image: serieImagePath + "blue exorcist.webp" },
                        { title: "Noragami", image: serieImagePath + "noragami.jpg" },
                        { title: "Seraph of the End", image: serieImagePath + "seraph of the end.jpg" },
                        { title: "Fire Force", image: serieImagePath + "fire force.jpg" },
                        { title: "Black Clover", image: serieImagePath + "black clover.jpg" },
                        { title: "Attack on Titan", image: serieImagePath + "attack on titan.jpg" },
                        { title: "Tokyo Ghoul", image: serieImagePath + "tokyo ghoul.jpg" },
                        { title: "My Hero Academia", image: serieImagePath + "my hero academia.jpg" },
                        { title: "Claymore", image: serieImagePath + "claymore.jpg" }
                    ],
                'attack-on-titan': [
                    { title: "Fullmetal Alchemist: Brotherhood", image: serieImagePath + "fullmetal alchemist brotherhood.jpg" },
                    { title: "Vinland Saga", image: serieImagePath + "vinland saga.jpg" },
                    { title: "Tokyo Ghoul", image: serieImagePath + "tokyo ghoul.jpg" },
                    { title: "Neon Genesis Evangelion", image: serieImagePath + "neon genesis evangelion.jpg" },
                    { title: "Akame ga Kill!", image: serieImagePath + "akame ga kill!.webp" },
                    { title: "Claymore", image: serieImagePath + "claymore.jpg" },
                    { title: "Berserk (1997)", image: serieImagePath + "berserk.jpg" },
                    { title: "86 Eighty-Six", image: serieImagePath + "86 eighty-six.jpg" },
                    { title: "Kabaneri of the Iron Fortress", image: serieImagePath + "kabaneri of the iron fortress.jpg" },
                    { title: "Devilman Crybaby", image: serieImagePath + "devilman crybaby.jpg" }
                ],
            'the-witcher': [
                { title: "Game of Thrones", image: serieImagePath + "game of thrones.jpg" },
                { title: "House of the Dragon", image: serieImagePath + "house of the dragon.jpg" },
                { title: "Vikings", image: serieImagePath + "vikings.jpg" },
                { title: "Vikings: Valhalla", image: serieImagePath + "vikings valhalla.jpg" },
                { title: "The Last Kingdom", image: serieImagePath + "the last kingdom.jpg" },
                { title: "Wheel of Time", image: serieImagePath + "wheel of time.jpg" },
                { title: "Shadow and Bone", image: serieImagePath + "shadow and bone.jpg" },
                { title: "His Dark Materials", image: serieImagePath + "his dark materials.jpg" },
                { title: "Carnival Row", image: serieImagePath + "carnival row.webp" },
                { title: "Merlin", image: serieImagePath + "merlin.jpg" }
            ],
        'wednesday': [
            { title: "Chilling Adventures of Sabrina", image: serieImagePath + "the chilling adventures of sabrina.jpg" },
            { title: "The Umbrella Academy", image: serieImagePath + "the umbrella academy.webp" },
            { title: "Locke & Key", image: serieImagePath + "locke and key.jpg" },
            { title: "A Series of Unfortunate Events", image: serieImagePath + "a series of unfortunate events.jpg" },
            { title: "Riverdale", image: serieImagePath + "riverdale.jpg" },
            { title: "Shadow and Bone", image: serieImagePath + "shadow and bone.jpg" },
            { title: "The Sandman", image: serieImagePath + "the sandman.webp" },
            { title: "Deadly Class", image: serieImagePath + "deadly class.webp" },
            { title: "Fate: The Winx Saga", image: serieImagePath + "fate the winx saga.jpg" },
            { title: "Chilling Adventures of Sabrina", image: serieImagePath + "the chilling adventures of sabrina.jpg" }
        ],
    'breaking-bad': [
        { title: "Better Call Saul",        image: serieImagePath + "better call saul.jpg" },
        { title: "Ozark",                   image: serieImagePath + "ozark.webp" },
        { title: "Narcos",                  image: serieImagePath + "narcos.jpg" },
        { title: "The Wire",                image: serieImagePath + "the wire.jpg" },
        { title: "Fargo",                   image: serieImagePath + "fargo.webp" },
        { title: "Peaky Blinders",          image: serieImagePath + "peaky blinders.jpg" },
        { title: "The Sopranos",            image: serieImagePath + "the sopranos.webp" },
        { title: "Boardwalk Empire",        image: serieImagePath + "boardwalk empire.jpg" },
        { title: "Power",                   image: serieImagePath + "power.jpg" },
        { title: "Snowfall",                image: serieImagePath + "snowfall.JPG" }
    ],
    'stranger-things': [
        { title: "Dark",                    image: serieImagePath + "dark.jpg" },
        { title: "The OA",                  image: serieImagePath + "The OA.webp" },
        { title: "Sense8",                  image: serieImagePath + "sense8.jpg" },
        { title: "Twin Peaks",              image: serieImagePath + "twin peaks.jpg" },
        { title: "The X-Files",             image: serieImagePath + "the x-files.jpg" },
        { title: "Fringe",                  image: serieImagePath + "fringe.jpg" },
        { title: "Wayward Pines",           image: serieImagePath + "wayward pines.jpg" },
        { title: "The Leftovers",           image: serieImagePath + "the leftovers.jpg" },
        { title: "Locke & Key",             image: serieImagePath + "locke and key.jpg" },
        { title: "1899",                    image: serieImagePath + "1899.jpg" }
    ]
    ,
    'euphoria': [
        { title: "Skins", image: serieImagePath + "Skins.jpg" },
        { title: "Sex Education", image: serieImagePath + "Sex Education.jpg" },
        { title: "13 Reasons Why", image: serieImagePath + "13 Reasons Why.jpg" },
        { title: "The End of the F***ing World", image: serieImagePath + "The End of the Fing World.webp" },
        { title: "Elite", image: serieImagePath + "Elite.webp" },
        { title: "We Are Who We Are", image: serieImagePath + "We Are Who We Are.jpg" },
        { title: "Gossip Girl (2021)", image: serieImagePath + "Gossip Girl (2021).jpg" },
        { title: "Generation", image: serieImagePath + "Generation.jpg" },
        { title: "Trinkets", image: serieImagePath + "Trinkets.jpg" },
        { title: "Skam", image: serieImagePath + "Skam.jpg" }
    ]
    // Ajoute d'autres slugs ici si besoin
};
const allSimilarSeries = similarSeriesMap[currentSerieSlug] || similarSeriesMap['breaking-bad'];
initGenericCarousel({
    containerId: 'similarMovies',
    items: allSimilarSeries,
    getCardHtml: (serie) => `
        <div class="col-6 col-md-3">
            <div class="similar-card">
                <img src="${serie.image}" alt="${serie.title}" class="similar-card-img" onerror="this.onerror=null;this.src='${serieImagePath}placeholder.jpg';">
                <div class="similar-card-title">${serie.title}</div>
            </div>
        </div>
    `
});

// === LIKE BUTTON (SERIE) ===
const movieLikeBtn = document.getElementById('movieLikeBtn');
if (movieLikeBtn) {
    // Récupérer les infos de la série depuis les attributs data
    const serieTitle = movieLikeBtn.dataset.serieTitle || document.querySelector('.movie-header h1')?.textContent || '';
    const serieYear = movieLikeBtn.dataset.serieYear || document.querySelector('.movie-sub')?.textContent?.match(/\d{4}/)?.[0] || '';
    const seriePoster = movieLikeBtn.dataset.serieImage || document.getElementById('moviePosterImg')?.src || '';
    const serieSlug = movieLikeBtn.dataset.serieSlug || window.currentMovieSlug || '';
    
    // Vérifier si déjà en favoris
    const favoriteSeries = JSON.parse(localStorage.getItem('favoriteSeries') || '[]');
    const isAlreadyFavorite = favoriteSeries.some(serie => serie.id === serieSlug);
    
    if (isAlreadyFavorite) {
        movieLikeBtn.classList.add('liked');
        const icon = movieLikeBtn.querySelector('i');
        if (icon) {
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
        }
    }
    
    movieLikeBtn.addEventListener('click', function() {
        this.classList.toggle('liked');
        const icon = this.querySelector('i');
        const liked = this.classList.contains('liked');
        
        if (liked) {
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
        } else {
            icon.classList.remove('bi-heart-fill');
            icon.classList.add('bi-heart');
        }
        this.setAttribute('aria-pressed', liked);
        
        // Gérer les favoris
        let favoriteSeries = JSON.parse(localStorage.getItem('favoriteSeries') || '[]');
        
        if (liked) {
            // Ajouter aux favoris
            const serieData = {
                id: serieSlug,
                title: serieTitle,
                year: serieYear,
                image: seriePoster,
                url: window.location.href
            };
            
            // Vérifier si pas déjà présent
            if (!favoriteSeries.some(serie => serie.id === serieSlug)) {
                favoriteSeries.push(serieData);
                localStorage.setItem('favoriteSeries', JSON.stringify(favoriteSeries));
            }
        } else {
            // Retirer des favoris
            favoriteSeries = favoriteSeries.filter(serie => serie.id !== serieSlug);
            localStorage.setItem('favoriteSeries', JSON.stringify(favoriteSeries));
        }
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
