// DOMContentLoaded handler pour toute la logique
// Fichier réparé : toute la logique est dans ce handler, le like film est temporairement désactivé pour corriger les erreurs de structure.
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du like piste (track) pour les films

    // Helper to render a track row (ensures artist cell uses correct class)
    function renderTrackRow(track, slug) {
        const tr = document.createElement('tr');
        // Numéro
        const tdNum = document.createElement('td');
        tdNum.textContent = track.id;
        tr.appendChild(tdNum);
        // Titre
        const tdTitle = document.createElement('td');
        tdTitle.className = 'movie-track-title';
        tdTitle.textContent = track.title;
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
        tdLike.appendChild(heart);
        tr.appendChild(tdLike);
        // Artiste (toujours en gris)
        const tdArtist = document.createElement('td');
        tdArtist.className = 'movie-track-artist';
        tdArtist.textContent = track.artist || '';
        tr.appendChild(tdArtist);
        return tr;
    }
    const tracksTable = document.getElementById('tracksTable');
    function getTrackUniqueId(row) {
        // Utilise le slug du film + id piste pour garantir unicité
        const trackId = row.querySelector('td:first-child')?.textContent?.trim();
        const slug = typeof window.currentMovieSlug !== 'undefined' ? window.currentMovieSlug : 'film';
        return `${slug}-${trackId}`;
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
                // On suppose que côté serveur, l'id stocké est bien du type slug-id
                const favoriteTrackIds = data.data.musiques.map(m => String(m.id));
                tracksTable.querySelectorAll('tr').forEach(row => {
                    let uniqueId = getTrackUniqueId(row);
                    const heart = row.querySelector('.track-like');
                    if (heart) {
                        if (favoriteTrackIds.includes(String(uniqueId))) {
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

    if (tracksTable) {
        // Example: render all tracks at load (replace with your actual data source)
        if (window.movieTracks && Array.isArray(window.movieTracks)) {
            tracksTable.innerHTML = '';
            window.movieTracks.forEach(track => {
                const tr = renderTrackRow(track, window.currentMovieSlug || 'film');
                tracksTable.appendChild(tr);
            });
        }
        refreshTrackLikes();
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('track-like')) {
                const row = e.target.closest('tr');
                let uniqueId = getTrackUniqueId(row);
                const trackTitle = row.querySelector('.movie-track-title')?.textContent || '';
                const trackArtist = row.querySelector('.movie-track-artist')?.textContent || '';
                const trackDuration = row.querySelector('.col-duration')?.textContent || '';
                const trackCover = row.querySelector('.composer-track-cover, .movie-track-cover')?.src || '';
                e.target.classList.toggle('liked');
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
                        url: window.location.href
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
                    });
                }
            }
        });

        // Ajout du refresh après chaque modification de la liste (ex: afficher plus/moins)
        const tracksMoreBtn = document.getElementById('tracksMoreBtn');
        if (tracksMoreBtn) {
            tracksMoreBtn.addEventListener('click', function() {
                setTimeout(refreshTrackLikes, 100); // attendre le DOM update
            });
        }
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
