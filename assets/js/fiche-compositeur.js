/**
 * Fiche Compositeur JavaScript
 * Gère les pistes, commentaires, filmographie et interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour afficher une piste dans le tableau (fusion des deux versions)
    function appendTrack(track) {
        if (!tracksTable) return;
        const tr = document.createElement('tr');
        const trackImage = filmImagePath + track.image;
        let spotifyIcon = `<i class="bi bi-spotify" aria-label="Spotify"></i>`;
        let amazonIcon = `<i class="bi bi-amazon" aria-label="Amazon Music"></i>`;
        let youtubeIcon = `<i class="bi bi-youtube" aria-label="YouTube Music"></i>`;
        let appleIcon = `<i class="bi bi-apple" aria-label="Apple Music"></i>`;
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
                    ${spotifyIcon}
                    ${amazonIcon}
                    ${youtubeIcon}
                    ${appleIcon}
                </span>
            </td>
            <td class="col-duration text-center">${track.duration}</td>
            <td class="col-like text-end">
                <i class="bi bi-heart track-like"></i>
            </td>
        `;
        tr.querySelectorAll('.track-icons i').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                const service = this.getAttribute('aria-label');
                let url = '';
                switch (service) {
                    case 'Spotify':
                        url = `https://open.spotify.com/search/${encodeURIComponent(track.title)}`;
                        break;
                    case 'Amazon Music':
                        url = `https://music.amazon.fr/search/${encodeURIComponent(track.title)}`;
                        break;
                    case 'YouTube Music':
                        url = `https://music.youtube.com/search?q=${encodeURIComponent(track.title)}`;
                        break;
                    case 'Apple Music':
                        url = `https://music.apple.com/search/${encodeURIComponent(track.title)}`;
                        break;
                }
                if (url) {
                    window.open(url, '_blank');
                }
            });
        });

        const heart = tr.querySelector('.track-like');
        const compositeId = `hanszimmer-${track.id}`;
        heart.setAttribute('data-id', compositeId);
        let isLiked = false;
        heart.addEventListener('click', function(e) {
            e.stopPropagation();
            isLiked = !isLiked;
            if (isLiked) {
                heart.classList.add('liked');
                heart.classList.remove('bi-heart');
                heart.classList.add('bi-heart-fill');
                const trackData = {
                    id: compositeId,
                    title: track.title,
                    artist: track.artist || '',
                    duration: track.duration || '',
                    cover: track.image || '',
                    source: 'Hans Zimmer',
                    url: window.location.href,
                    slug: 'hanszimmer'
                };
                const form = new URLSearchParams();
                form.append('action', 'add_user_favorite');
                form.append('type', 'musiques');
                form.append('item', JSON.stringify(trackData));
                fetch(window.ajaxurl || window.wp_data?.ajax_url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: form.toString()
                }).then(r => r.json()).then(() => {
                    // Optionnel: refreshTrackLikes();
                });
            } else {
                heart.classList.remove('liked');
                heart.classList.remove('bi-heart-fill');
                heart.classList.add('bi-heart');
                const form = new URLSearchParams();
                form.append('action', 'remove_user_favorite');
                form.append('type', 'musiques');
                form.append('id', compositeId);
                fetch(window.ajaxurl || window.wp_data?.ajax_url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: form.toString()
                }).then(r => r.json()).then(() => {
                    // Optionnel: refreshTrackLikes();
                });
            }
        });
        tracksTable.appendChild(tr);
    }

let tracksLimit = 5;

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
// Carrousel de compositeurs similaires harmonisé (markup, fallback, scroll)
const similarComposers = [
    { name: 'James Newton Howard', image: window.composerImagePath + 'James Newton Howard.jpg' },
    { name: 'Ludwig Göransson', image: window.composerImagePath + 'Ludwig Göransson.jpg' },
    { name: 'John Powell', image: window.composerImagePath + 'John Powell.webp' },
    { name: 'Ramin Djawadi', image: window.composerImagePath + 'Ramin Djawadi.jpg' },
    { name: 'Steve Jablonsky', image: window.composerImagePath + 'Steve Jablonsky.jpg' },
    { name: 'Benjamin Wallfisch', image: window.composerImagePath + 'Benjamin Wallfisch.jpg' },
    { name: 'Junkie XL (Tom Holkenborg)', image: window.composerImagePath + 'Junkie XL (Tom Holkenborg).jpg' },
    { name: 'Cliff Martinez', image: window.composerImagePath + 'Cliff Martinez.jpg' },
    { name: 'Harry Gregson-Williams', image: window.composerImagePath + 'Harry Gregson-Williams.jpg' },
    { name: 'Henry jackman', image: window.composerImagePath + 'Henry jackman.jpg' },
    { name: 'Danny Elfman', image: window.composerImagePath + 'Danny Elfman.jpeg' }
];
const carousel = document.getElementById('similarComposers');
const fallbackImg = window.composerImagePath + 'default-compositeur.jpg';
if (carousel) {
    similarComposers.forEach(c => {
        const col = document.createElement('div');
        col.className = 'col-6 col-md-3';
        col.innerHTML = `
            <div class="carousel-card similar-card">
                <img src="${c.image}" class="w-100 mb-2" alt="${c.name}" onerror="this.onerror=null;this.src='${fallbackImg}'">
                <div class="similar-card-title">${c.name}</div>
            </div>
        `;
        carousel.appendChild(col);
    });

    // Flèches scroll horizontal (comme carrousel films/séries)
    const leftArrow = document.querySelector('.composer-carousel .carousel-arrow.left');
    const rightArrow = document.querySelector('.composer-carousel .carousel-arrow.right');
    const row = carousel;
    if (leftArrow && rightArrow && row) {
        leftArrow.addEventListener('click', function() {
            row.scrollBy({ left: -row.offsetWidth * 0.8, behavior: 'smooth' });
        });
        rightArrow.addEventListener('click', function() {
            row.scrollBy({ left: row.offsetWidth * 0.8, behavior: 'smooth' });
        });
    }
}

function renderTracks(limit = tracksLimit) {
    if (!tracksTable) return;
    tracksLimit = limit;
    tracksTable.innerHTML = '';
    const slice = tracks.slice(0, tracksLimit);
    slice.forEach(t => {
        // Génère le slug du film pour l'URL (remplace espaces/accents)
        const slug = t.film
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
        const filmUrl = `/fiche-film/${slug}`;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${t.id}</td>
            <td>
                <div class="movie-track-info">
                    <img src="${filmImagePath + t.image}" class="movie-track-cover" alt="${t.title}">
                    <div>
                        <div class="movie-track-title">${t.title}</div>
                        <div>
                            <a href="${filmUrl}" class="movie-track-artist" style="text-decoration:underline;">${t.film}</a>
                        </div>
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
            <td class="col-like text-end"><i class="bi bi-heart track-like"></i></td>
        `;
        tracksTable.appendChild(tr);
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
    // Charger les favoris utilisateur et mettre à jour les coeurs
    fetch(window.ajaxurl || window.wp_data?.ajax_url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ action: 'get_user_favorites' }).toString()
    })
    .then(r => r.json())
    .then(data => {
        if (data.success && data.data && Array.isArray(data.data.musiques)) {
            const favoriteTrackIds = data.data.musiques.map(m => String(m.id));
            tracksTable.querySelectorAll('tr').forEach(row => {
                let trackId = row.querySelector('td:first-child')?.textContent?.trim();
                const heart = row.querySelector('.track-like');
                if (heart) {
                    if (favoriteTrackIds.includes(String(trackId))) {
                        heart.classList.add('liked');
                        heart.classList.remove('bi-heart');
                        heart.classList.add('bi-heart-fill');
                    } else {
                        heart.classList.remove('liked');
                        heart.classList.remove('bi-heart-fill');
                        heart.classList.add('bi-heart');
                    }
                }
            });
        }
    });
    renderTracks(5);

    if (tracksMoreBtn) {
        tracksMoreBtn.addEventListener('click', () => {
            if (tracksLimit >= tracks.length) {
                renderTracks(5);
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
    tracksTable.querySelectorAll('tr').forEach(row => {
        const heart = row.querySelector('.track-like');
        let isLiked = false;
        heart.addEventListener('click', function(e) {
            e.stopPropagation();
            isLiked = !isLiked;
            fetch(window.ajaxurl || window.wp_data?.ajax_url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: isLiked ? 'add_favorite' : 'remove_favorite',
                    track_id: row.querySelector('td:first-child').textContent.trim()
                }).toString()
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    heart.classList.toggle('liked', isLiked);
                    heart.classList.toggle('bi-heart-fill', isLiked);
                    heart.classList.toggle('bi-heart', !isLiked);
                }
            });
        });
    });
}

// Commentaires
const commentsZone = document.getElementById('commentsZone');
const commentInput = document.querySelector('.comment-input');

function renderComment(commentData) {
    const col = document.createElement('div');
    col.className = 'col-12 col-md-3';
    col.dataset.commentId = commentData.id;

    let menuHtml = "<div class='comment-menu'>";
    menuHtml += "<button class='comment-menu-btn' aria-label='Options'><i class='bi bi-three-dots-vertical'></i></button>";
    menuHtml += "<div class='comment-menu-dropdown'>";
    menuHtml += `<button class='comment-edit-btn'${!commentData.is_author ? " disabled style='opacity:0.5;cursor:not-allowed;'" : ''}>Modifier</button>`;
    menuHtml += `<button class='comment-delete-btn'${!commentData.is_author ? " disabled style='opacity:0.5;cursor:not-allowed;'" : ''}>Supprimer</button>`;
    menuHtml += "</div></div>";

    let dateHtml = '';
    if (commentData.created_at) {
        const date = new Date(commentData.created_at);
        const now = new Date();
        const diffMs = now - date;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMs / 3600000);
        const diffDays = Math.floor(diffMs / 86400000);
        let timeAgo = '';
        if (diffMins < 1) {
            timeAgo = "à l'instant";
        } else if (diffMins < 60) {
            timeAgo = `il y a ${diffMins} min`;
        } else if (diffHours < 24) {
            timeAgo = `il y a ${diffHours}h`;
        } else if (diffDays < 7) {
            timeAgo = `il y a ${diffDays}j`;
        } else {
            timeAgo = date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' });
        }
        dateHtml = timeAgo;
    }

    // Ajout du bouton like (pouce en l'air) avec SVG et structure identique fiche film
    const likeCount = commentData.like_count || 0;
    const isLiked = commentData.is_liked || false;
    const likeBtn = `
        <div class="comment-like-row d-flex align-items-center gap-2 mt-2">
            <button class="comment-like-btn${isLiked ? ' liked' : ''}" aria-label="J'aime ce commentaire" data-comment-id="${commentData.id}">
                <svg class="svg-thumb-up" viewBox="0 -0.5 21 21" width="22" height="22" style="display:inline-block;vertical-align:middle;">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Dribbble-Light-Preview" transform="translate(-219.000000, -760.000000)" fill="#700118">
                            <g id="icons" transform="translate(56.000000, 160.000000)">
                                <path d="M163,610.021159 L163,618.021159 C163,619.126159 163.93975,620.000159 165.1,620.000159 L167.199999,620.000159 L167.199999,608.000159 L165.1,608.000159 C163.93975,608.000159 163,608.916159 163,610.021159 M183.925446,611.355159 L182.100546,617.890159 C181.800246,619.131159 180.639996,620.000159 179.302297,620.000159 L169.299999,620.000159 L169.299999,608.021159 L171.104948,601.826159 C171.318098,600.509159 172.754498,599.625159 174.209798,600.157159 C175.080247,600.476159 175.599997,601.339159 175.599997,602.228159 L175.599997,607.021159 C175.599997,607.573159 176.070397,608.000159 176.649997,608.000159 L181.127196,608.000159 C182.974146,608.000159 184.340196,609.642159 183.925446,611.355159"/>
                            </g>
                        </g>
                    </g>
                </svg>
                <span class="comment-like-count">${likeCount}</span>
            </button>
        </div>
    `;

    col.innerHTML = `
        <div class='comment-card'>
            ${menuHtml}
            <div class='comment-user'>
                <span class='comment-user-avatar-wrapper'>
                    ${commentData.avatar ? `<img src='${commentData.avatar}' alt='${commentData.user_name}' class='comment-user-avatar'>` : "<i class='bi bi-person comment-user-icon'></i>"}
                </span>
                <span class='comment-user-name'>${commentData.user_name}</span>
                <span class='comment-date'>${dateHtml}</span>
            </div>
            <div class='comment-text'>${commentData.comment_text}</div>
            ${likeBtn}
        </div>
    `;

    // Ajout de l'event pour le bouton like
    const btn = col.querySelector('.comment-like-btn');
    if (btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            fetch(window.composerComments.ajax_url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'like_composer_comment',
                    comment_id: commentData.id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const countSpan = col.querySelector('.comment-like-count');
                    const thumbSvg = col.querySelector('.svg-thumb-up');
                    if (countSpan) countSpan.textContent = data.data.like_count;
                    if (thumbSvg) thumbSvg.querySelector('path').setAttribute('fill', '#700118');
                    btn.classList.add('liked');
                }
            });
        });
    }
    return col;
}

// Charger les commentaires existants (exemple AJAX, à adapter selon backend)
if (commentsZone) {
    fetch(window.composerComments.ajax_url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'get_composer_comments',
            composer_id: window.composerComments.composer_id
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && Array.isArray(data.data)) {
            if (data.data.length === 0) {
                commentsZone.innerHTML = '<div class="text-center text-muted" style="font-style:italic;opacity:0.8;">c\'est silencieux ici...</div>';
            } else {
                data.data.forEach(comment => {
                    commentsZone.appendChild(renderComment(comment));
                });
            }
        }
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
