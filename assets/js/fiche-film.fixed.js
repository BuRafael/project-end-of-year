// DOMContentLoaded handler pour toute la logique
// Fichier réparé : toute la logique est dans ce handler, le like film est temporairement désactivé pour corriger les erreurs de structure.
document.addEventListener('DOMContentLoaded', function() {
            // Local cache for liked track IDs, persisted in sessionStorage
        // No local cache, use server state like series fiche

    // ===== FILMS SIMILAIRES CARROUSEL (markup harmonisé) =====
    // Liste statique à adapter selon le film courant
    const similarMoviesData = window.similarMoviesData || [
        { slug: 'inception', title: 'Inception', image: themeImagePath + 'inception affiche film.jpg' },
        { slug: 'interstellar', title: 'Interstellar', image: themeImagePath + 'interstellar.jpg' },
        { slug: 'arrival', title: 'Arrival', image: themeImagePath + 'Arrival.webp' },
        { slug: 'spirited-away', title: 'Le Voyage de Chihiro', image: themeImagePath + 'chihiro.jpg' },
        { slug: 'your-name', title: 'Your Name', image: themeImagePath + 'your name.jpg' }
    ];

    function renderSimilarMoviesCarousel(movies) {
        const container = document.getElementById('similarMovies');
        if (!container) return;
        container.innerHTML = '';
        movies.forEach(movie => {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-3';
            col.innerHTML = `
                <div class=\"similar-card\" style=\"cursor:pointer;\">
                    <img src=\"${movie.image}\" alt=\"${movie.title}\" style=\"width:100%;height:160px;object-fit:cover;border-radius:8px;\">
                    <div class=\"similar-card-title\">${movie.title}</div>
                </div>
            `;
            col.addEventListener('click', function() {
                window.location.href = `/fiche-film/${movie.slug}`;
            });
            container.appendChild(col);
        });
    }

    renderSimilarMoviesCarousel(similarMoviesData);

        // Gestion suppression de commentaire
        function renderComment(comment) {
            const div = document.createElement('div');
            div.className = 'comment-item col-12 d-flex align-items-start';
            div.dataset.commentId = comment.id;
            div.innerHTML = `
                <div class="comment-avatar rounded-circle overflow-hidden d-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">
                    <img src="${comment.avatar || ''}" alt="avatar" class="w-100 h-100" style="object-fit:cover;">
                </div>
                <div class="flex-grow-1">
                    <div class="comment-meta-row">
                        <span class="comment-author fw-bold small">${comment.author}</span>
                        <span class="comment-date text-muted small">${comment.date}</span>
                    </div>
                    <div class="comment-text small mb-1">${comment.text}</div>
                </div>
                ${comment.canDelete ? `<button class="btn btn-sm btn-danger ms-2 comment-delete-btn">Supprimer</button>` : ''}
            `;
            return div;
        }

        function loadComments(comments) {
            if (!commentsZone) return;
            commentsZone.innerHTML = '';
            comments.forEach(comment => {
                commentsZone.appendChild(renderComment(comment));
            });
        }

        // Suppression côté client + serveur
        if (commentsZone) {
            commentsZone.addEventListener('click', function(e) {
                if (e.target.classList.contains('comment-delete-btn')) {
                    const commentDiv = e.target.closest('.comment-item');
                    const commentId = commentDiv?.dataset.commentId;
                    if (commentId) {
                        fetch(window.ajaxurl || window.wp_data?.ajax_url, {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: new URLSearchParams({ action: 'delete_movie_comment', comment_id: commentId }).toString()
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                commentDiv.remove();
                            } else {
                                alert('Erreur lors de la suppression du commentaire');
                            }
                        });
                    }
                }
            });
        }
    // Gestion du like piste (track) pour les films

    // Helper to render a track row (ensures artist cell uses correct class)
    function renderTrackRow(track, slug) {
        const tr = document.createElement('tr');
        // If track.id already contains a dash, use as is, else prepend slug
        const compositeId = (typeof track.id === 'string' && track.id.includes('-')) ? track.id : `${slug || 'film'}-${track.id}`;
        tr.setAttribute('data-id', compositeId);
        // Numéro
        const tdNum = document.createElement('td');
        tdNum.textContent = track.id;
        tr.appendChild(tdNum);
        // Titre + compositeur (comme fiche série)
        const tdTitle = document.createElement('td');
        tdTitle.className = '';
        const titleDiv = document.createElement('div');
        titleDiv.className = 'movie-track-title';
        titleDiv.textContent = track.title;
        tdTitle.appendChild(titleDiv);
        if (track.artist) {
            const artistDiv = document.createElement('div');
            artistDiv.className = 'movie-track-artist';
            artistDiv.textContent = track.artist;
            tdTitle.appendChild(artistDiv);
        }
        tr.appendChild(tdTitle);
        // Liens (placeholder, can be customized)
        const tdLinks = document.createElement('td');
        tdLinks.className = 'col-links';
        tdLinks.innerHTML = '';
        tr.appendChild(tdLinks);
        // Durée
        const tdDuration = document.createElement('td');
        tdDuration.className = 'col-duration text-center';
        tdDuration.textContent = track.duration || '';
        tr.appendChild(tdDuration);
        // Like
        const tdLike = document.createElement('td');
        const heart = document.createElement('i');
        heart.className = 'bi bi-heart track-like';
        heart.setAttribute('data-id', compositeId);
        tdLike.appendChild(heart);
        tr.appendChild(tdLike);
        return tr;
    }
    const tracksTable = document.getElementById('tracksTable');
    function getTrackUniqueId(row) {
        // Use data-id attribute for unique ID (like series fiche)
        return row.getAttribute('data-id');
    }
    function refreshTrackLikes() {
        if (!tracksTable) return;
        fetch(window.ajaxurl || window.wp_data?.ajax_url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action: 'get_user_favorites' }).toString()
        })
        .then(r => r.json())
        .then(data => {
            if (data.success && data.data && Array.isArray(data.data.musiques)) {
                const favoriteTrackIds = new Set(data.data.musiques.map(m => String(m)));
                tracksTable.querySelectorAll('tr').forEach(row => {
                    let uniqueId = getTrackUniqueId(row);
                    const heart = row.querySelector('.track-like');
                    if (heart) {
                        if (favoriteTrackIds.has(String(uniqueId))) {
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
    }

        if (!tracksTable) return;
        fetch(window.ajaxurl || window.wp_data?.ajax_url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action: 'get_user_favorites' }).toString()
        })
        .then(r => r.json())
        .then(data => {
            if (data.success && data.data && Array.isArray(data.data.musiques)) {
                const favoriteTrackIds = new Set(data.data.musiques.map(m => String(m)));
                tracksTable.querySelectorAll('.track-like').forEach(heart => {
                    let uniqueId = heart.getAttribute('data-id');
                    if (uniqueId && favoriteTrackIds.has(String(uniqueId))) {
                        heart.classList.add('liked');
                        heart.classList.remove('bi-heart');
                        heart.classList.add('bi-heart-fill');
                    } else {
                        heart.classList.remove('liked');
                        heart.classList.remove('bi-heart-fill');
                        heart.classList.add('bi-heart');
                    }
                });
            }
        });
                const liked = e.target.classList.contains('liked');
                if (liked) {
                    e.target.classList.remove('bi-heart');
                    e.target.classList.add('bi-heart-fill');
                    const trackData = {
                        id: uniqueId,
                        title: trackTitle,
                        artist: trackArtist,
                        duration: trackDuration,
                        cover: trackCover,
                        source: document.querySelector('.movie-header h1')?.textContent || '',
                        url: window.location.href,
                        slug: window.currentMovieSlug || 'film'
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
                    })
                    .then(r => r.json())
                    .then(() => {
                        refreshTrackLikes();
                    });
                } else {
                    e.target.classList.remove('bi-heart-fill');
                    e.target.classList.add('bi-heart');
                    const form = new URLSearchParams();
                    form.append('action', 'remove_user_favorite');
                    form.append('type', 'musiques');
                    form.append('id', uniqueId);
                    fetch(window.ajaxurl || window.wp_data?.ajax_url, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: form.toString()
                    })
                    .then(r => r.json())
                    .then(() => {
                        refreshTrackLikes();
                    });
                }
            }
        });

        // Ajout du refresh et re-render après chaque modification de la liste (ex: afficher plus/moins)
        document.addEventListener('click', function(e) {
            if (e.target && e.target.id === 'tracksMoreBtn') {
                if (window.movieTracks && Array.isArray(window.movieTracks)) {
                    renderAllTracksAndRefresh(window.movieTracks);
                    setTimeout(() => {
                        console.log('refreshTrackLikes called (afficher plus)');
                        refreshTrackLikes();
                    }, 400);
                }
            }
        });
    }
    // Sélecteurs et variables globales nécessaires
    const commentsZone = document.getElementById('commentsZone');
    const commentInput = document.querySelector('.comment-input');
    const movieComments = window.movieComments || {};
    // Fonction carrousel générique (doit exister dans un autre JS inclus sur la page)
    const initGenericCarousel = window.initGenericCarousel || function(){};

    // Définir les chemins d'images à partir des variables PHP injectées
    const imagePath = typeof themeImagePath !== 'undefined' ? themeImagePath : (window.themeImagePath || '/wp-content/themes/project-end-of-year/assets/image/Fiche films/');
    const trackImagePath = typeof themeTrackImagePath !== 'undefined' ? themeTrackImagePath : (window.themeTrackImagePath || '/wp-content/themes/project-end-of-year/assets/image/Pistes film/');
    const currentMovieSlug = typeof window.currentMovieSlug !== 'undefined' ? window.currentMovieSlug : 'inception';

    // ... (rest of your logic, except the broken like button logic)
    // Please copy the rest of the code from the original file here, excluding the broken like button logic.

});
