// Afficher un commentaire (doit être défini avant loadComments)
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
        if (diffMins < 1) timeAgo = "à l'instant";
        else if (diffMins < 60) timeAgo = `il y a ${diffMins} min`;
        else if (diffHours < 24) timeAgo = `il y a ${diffHours}h`;
        else if (diffDays < 7) timeAgo = `il y a ${diffDays}j`;
        else timeAgo = date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' });
        dateHtml = `<div class="comment-date">${timeAgo}</div>`;
    }
    // Affiche le vrai nombre de likes
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
            <div class="comment-like-row d-flex align-items-center gap-2 mt-2">
                <button class="comment-like-btn${commentData.liked_by_user ? ' liked' : ''}" aria-label="J'aime ce commentaire" data-comment-id="${commentData.id}">
                    <svg class="svg-thumb-up" viewBox="0 -0.5 21 21" width="22" height="22" style="display:inline-block;vertical-align:middle;">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Dribbble-Light-Preview" transform="translate(-219.000000, -760.000000)" fill="#000000">
                                <g id="icons" transform="translate(56.000000, 160.000000)">
                                    <path d="M163,610.021159 L163,618.021159 C163,619.126159 163.93975,620.000159 165.1,620.000159 L167.199999,620.000159 L167.199999,608.000159 L165.1,608.000159 C163.93975,608.000159 163,608.916159 163,610.021159 M183.925446,611.355159 L182.100546,617.890159 C181.800246,619.131159 180.639996,620.000159 179.302297,620.000159 L169.299999,620.000159 L169.299999,608.021159 L171.104948,601.826159 C171.318098,600.509159 172.754498,599.625159 174.209798,600.157159 C175.080247,600.476159 175.599997,601.339159 175.599997,602.228159 L175.599997,607.021159 C175.599997,607.573159 176.070397,608.000159 176.649997,608.000159 L181.127196,608.000159 C182.974146,608.000159 184.340196,609.642159 183.925446,611.355159"/>
                                </g>
                            </g>
                        </g>
                    </svg>
                </button>
                <span class="like-count" style="color:#000 !important; font-weight:500;">${initialLikeCount}</span>
            </div>
        </div>
    `;
    // Like button logic: toggle .liked and update like count visually
    const likeBtn = col.querySelector('.comment-like-btn');
    const likeCountSpan = col.querySelector('.like-count');
    // Force couleur du pouce dès l'affichage si déjà liké
    if (likeBtn && commentData.liked_by_user) {
        const thumbSvg = likeBtn.querySelector('.svg-thumb-up');
        if (thumbSvg) {
            const thumbPath = thumbSvg.querySelector('path');
            thumbSvg.style.fill = '#700118';
            thumbSvg.style.color = '#700118';
            if (thumbPath) thumbPath.setAttribute('fill', '#700118');
        }
    }
    if (likeBtn && likeCountSpan) {
        likeBtn.addEventListener('click', function () {
            // Vérifier connexion utilisateur
            var isUserLoggedIn = false;
            try {
                isUserLoggedIn = !!JSON.parse(document.body.getAttribute('data-user-logged-in'));
            } catch (e) {}
            if (!isUserLoggedIn) {
                window.location.href = '/inscription';
                return;
            }
            const isLiked = this.classList.contains('liked');
            let count = parseInt(likeCountSpan.textContent, 10) || 0;
            // Optimistic UI
            this.classList.toggle('liked');
            if (isLiked) {
                count = Math.max(0, count-1);
                this.querySelector('.svg-thumb-up').style.fill = '#1A1A1A';
                this.querySelector('.svg-thumb-up').style.color = '#1A1A1A';
                this.querySelector('.svg-thumb-up path').setAttribute('fill', '#1A1A1A');
            } else {
                count++;
                this.querySelector('.svg-thumb-up').style.fill = '#700118';
                this.querySelector('.svg-thumb-up').style.color = '#700118';
                this.querySelector('.svg-thumb-up path').setAttribute('fill', '#700118');
            }
            likeCountSpan.textContent = count;
            // AJAX
            fetch(movieComments.ajax_url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: isLiked ? 'unlike_comment' : 'like_comment',
                    nonce: movieComments.nonce,
                    comment_id: commentData.id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // Rollback UI
                    this.classList.toggle('liked');
                    if (isLiked) {
                        likeCountSpan.textContent = count+1;
                        this.querySelector('.svg-thumb-up').style.fill = '#700118';
                        this.querySelector('.svg-thumb-up').style.color = '#700118';
                        this.querySelector('.svg-thumb-up path').setAttribute('fill', '#700118');
                    } else {
                        likeCountSpan.textContent = Math.max(0, count-1);
                        this.querySelector('.svg-thumb-up').style.fill = '#1A1A1A';
                        this.querySelector('.svg-thumb-up').style.color = '#1A1A1A';
                        this.querySelector('.svg-thumb-up path').setAttribute('fill', '#1A1A1A');
                    }
                    alert('Erreur lors du like.');
                }
            })
            .catch((err) => {
                // Rollback UI
                this.classList.toggle('liked');
                if (isLiked) {
                    likeCountSpan.textContent = count+1;
                    this.querySelector('.svg-thumb-up').style.fill = '#700118';
                    this.querySelector('.svg-thumb-up').style.color = '#700118';
                    this.querySelector('.svg-thumb-up path').setAttribute('fill', '#700118');
                } else {
                    likeCountSpan.textContent = Math.max(0, count-1);
                    this.querySelector('.svg-thumb-up').style.fill = '#1A1A1A';
                    this.querySelector('.svg-thumb-up').style.color = '#1A1A1A';
                    this.querySelector('.svg-thumb-up path').setAttribute('fill', '#1A1A1A');
                }
                alert('Erreur réseau lors du like.');
            });
        });
    }
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

// Charger les commentaires depuis l'API
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
/**
 * Fiche Film JavaScript
 * Gère les pistes, commentaires, films similaires et interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    // === LIKE BUTTON (FICHE FILM) ===
    const movieLikeBtn = document.getElementById('movieLikeBtn');
    if (movieLikeBtn) {
        // Utilise la logique front-page.js pour le coeur des top 5 films
        function normalizeMovieId(id, title) {
            if (!id) return id;
            const slug = String(id).toLowerCase();
            if (slug === 'your-name' || slug === 'spirited-away') return slug;
            if (title && (title.toLowerCase().includes('your name') || title.toLowerCase().includes('spirited away'))) {
                if (title.toLowerCase().includes('your name')) return 'your-name';
                if (title.toLowerCase().includes('spirited away')) return 'spirited-away';
            }
            return id;
        }
        const movieIdRaw = movieLikeBtn.getAttribute('data-movie-id');
        const movieTitle = movieLikeBtn.getAttribute('data-movie-title');
        const movieImage = movieLikeBtn.getAttribute('data-movie-image');
        // Fonctionnement identique à Inception pour Wicked
        // Utilise le même coeur, logique et AJAX
        // 1. Charger l'état du like depuis le serveur
        fetch(window.ajaxurl || (window.wp_data && window.wp_data.ajax_url), {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action: 'get_user_favorites' })
        })
        .then(r => r.json())
        .then(data => {
            let isFav = false;
            if (data && data.success && data.data && Array.isArray(data.data.films)) {
                isFav = data.data.films.some(f => {
                    if (typeof f === 'string') {
                        return String(f) === String(movieIdRaw);
                    } else if (f && typeof f === 'object' && f.id) {
                        return String(f.id) === String(movieIdRaw);
                    }
                    return false;
                });
            }
            const heartPath = movieLikeBtn.querySelector('svg .svg-heart-shape');
            if (isFav) {
                movieLikeBtn.classList.add('liked');
                movieLikeBtn.setAttribute('data-liked', 'true');
                movieLikeBtn.setAttribute('aria-pressed', 'true');
                if (heartPath) heartPath.setAttribute('fill', '#700118');
            } else {
                movieLikeBtn.classList.remove('liked');
                movieLikeBtn.setAttribute('data-liked', 'false');
                movieLikeBtn.setAttribute('aria-pressed', 'false');
                if (heartPath) heartPath.setAttribute('fill', '#F4EFEC');
            }
        });
        // 2. Gérer le clic sur le bouton
        movieLikeBtn.onclick = function(e) {
            e.preventDefault();
            var isUserLoggedIn = false;
            try {
                isUserLoggedIn = !!JSON.parse(document.body.getAttribute('data-user-logged-in'));
            } catch (e) {}
            if (!isUserLoggedIn) {
                window.location.href = '/inscription';
                return;
            }
            const isLiked = movieLikeBtn.getAttribute('data-liked') === 'true';
            let posterUrl = document.getElementById('moviePosterImg')?.src || '';
            const favItem = { id: movieIdRaw, title: movieTitle, image: posterUrl };
            // Sélectionne le path du coeur
            const heartPath = movieLikeBtn.querySelector('svg .svg-heart-shape');
            if (isLiked) {
                movieLikeBtn.setAttribute('data-liked', 'false');
                movieLikeBtn.classList.remove('liked');
                movieLikeBtn.setAttribute('aria-pressed', 'false');
                if (heartPath) heartPath.setAttribute('fill', '#F4EFEC');
                fetch(window.ajaxurl || (window.wp_data && window.wp_data.ajax_url), {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'remove_user_favorite',
                        type: 'films',
                        id: movieIdRaw
                    })
                });
            } else {
                movieLikeBtn.setAttribute('data-liked', 'true');
                movieLikeBtn.classList.add('liked');
                movieLikeBtn.setAttribute('aria-pressed', 'true');
                if (heartPath) heartPath.setAttribute('fill', '#700118');
                fetch(window.ajaxurl || (window.wp_data && window.wp_data.ajax_url), {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'add_user_favorite',
                        type: 'films',
                        item: JSON.stringify(favItem)
                    })
                });
            }
        };
    }

    // ...déplacement du bloc plus bas...

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
        if (slug === 'wicked') {
            const cover = 'wicked piste.png';
            return [
                { id: 1, title: "Defying Gravity", artist: "Stephen Schwartz", duration: "5:53", cover },
                { id: 2, title: "Popular", artist: "Stephen Schwartz", duration: "3:43", cover },
                { id: 3, title: "For Good", artist: "Stephen Schwartz", duration: "5:09", cover },
                { id: 4, title: "The Wizard and I", artist: "Stephen Schwartz", duration: "5:11", cover },
                { id: 5, title: "Dancing Through Life", artist: "Stephen Schwartz", duration: "7:35", cover },
                { id: 6, title: "I'm Not That Girl", artist: "Stephen Schwartz", duration: "3:00", cover },
                { id: 7, title: "One Short Day", artist: "Stephen Schwartz", duration: "3:40", cover },
                { id: 8, title: "No Good Deed", artist: "Stephen Schwartz", duration: "4:05", cover },
                { id: 9, title: "As Long As You're Mine", artist: "Stephen Schwartz", duration: "3:46", cover },
                { id: 10, title: "Finale", artist: "Stephen Schwartz", duration: "6:32", cover }
            ];
        }

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
    const inceptionCover = "Inception piste.png";
    return [
        { id: 1, title: "Half Remembered Dream", artist: "Hans Zimmer", duration: "1:12", cover: inceptionCover },
        { id: 2, title: "We Built Our Own World", artist: "Hans Zimmer", duration: "1:56", cover: inceptionCover },
        { id: 3, title: "Dream Is Collapsing", artist: "Hans Zimmer", duration: "2:28", cover: inceptionCover },
        { id: 4, title: "Radical Notion", artist: "Hans Zimmer", duration: "3:43", cover: inceptionCover },
        { id: 5, title: "Old Souls", artist: "Hans Zimmer", duration: "7:44", cover: inceptionCover },
        { id: 6, title: "528491", artist: "Hans Zimmer", duration: "2:23", cover: inceptionCover },
        { id: 7, title: "Mombasa", artist: "Hans Zimmer", duration: "4:54", cover: inceptionCover },
        { id: 8, title: "One Simple Idea", artist: "Hans Zimmer", duration: "2:28", cover: inceptionCover },
        { id: 9, title: "Dream Within a Dream", artist: "Hans Zimmer", duration: "5:04", cover: inceptionCover },
        { id: 10, title: "Waiting for a Train", artist: "Hans Zimmer", duration: "9:30", cover: inceptionCover },
        { id: 11, title: "Paradox", artist: "Hans Zimmer", duration: "3:25", cover: inceptionCover },
        { id: 12, title: "Time", artist: "Hans Zimmer", duration: "4:36", cover: inceptionCover }
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
    // ...existing code...
    // ...existing code...

    if (!tracksTable) return;
    tracksLimit = limit;
    tracksTable.innerHTML = '';
    const slice = tracks.slice(0, tracksLimit);
    slice.forEach((t, idx) => {
        const artistHtml = t.artist === 'Hans Zimmer'
            ? `<a href="${window.location.origin}/hans-zimmer" class="movie-track-artist" style="cursor: pointer;">${t.artist}</a>`
            : `<div class="movie-track-artist">${t.artist}</div>`;

        let coverPath = trackImagePath;
        if (t.cover && !t.cover.toLowerCase().includes('piste')) {
            coverPath = imagePath;
        }
        const coverSrc = coverPath + (t.cover || 'Inception piste.png');
        const trackId = `${window.currentMovieSlug || ''}-${t.id}`;
        let spotifyIcon = `<i class="bi bi-spotify" aria-label="Spotify"></i>`;
        let amazonIcon = `<i class="bi bi-amazon" aria-label="Amazon Music"></i>`;
        let youtubeIcon = `<i class=\"bi bi-youtube" aria-label=\"YouTube Music"></i>`;
        let appleIcon = `<i class=\"bi bi-apple" aria-label="Apple Music"></i>`;
        // Liens streaming pour Parasite piste 4 (The Frontal Lobe of Ki Taek)
        if (window.currentMovieSlug === 'parasite' && t.id === 4 && t.title === "The Frontal Lobe of Ki Taek") {
            spotifyIcon = `<a href="https://open.spotify.com/track/3MXeAlonSYccaVnVDZWtFg" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-spotify" aria-label="Spotify"></i></a>`;
            amazonIcon = `<a href="https://music.amazon.com/albums/B07YVHQ929" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-amazon" aria-label="Amazon Music"></i></a>`;
            appleIcon = `<a href="https://music.apple.com/us/album/parasite-original-motion-picture-soundtrack/1482778417" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-apple" aria-label="Apple Music"></i></a>`;
            youtubeIcon = `<a href="https://www.youtube.com/results?search_query=The+Frontal+Lobe+of+Ki+Taek+Parasite+OST" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-youtube" aria-label="YouTube Music"></i></a>`;
        }
        // Liens streaming pour Parasite piste 1 (Opening)
        if (window.currentMovieSlug === 'parasite' && t.id === 1) {
            spotifyIcon = `<a href="https://open.spotify.com/track/7gJmuTmwIc7d71ZrOfFv9P" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-spotify" aria-label="Spotify"></i></a>`;
            amazonIcon = `<a href="https://open.spotify.com/album/32wOhLTLnq6kis3xkRN2ei" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-amazon" aria-label="Amazon Music"></i></a>`;
            appleIcon = `<a href="https://music.apple.com/us/album/parasite-original-motion-picture-soundtrack/1482778417" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-apple" aria-label="Apple Music"></i></a>`;
            youtubeIcon = `<a href="https://www.youtube.com/watch?v=ttKyPsVeBxs" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-youtube" aria-label="YouTube Music"></i></a>`;
        }
        // Liens streaming pour Parasite piste 3 (On the Way to Rich House)
        if (window.currentMovieSlug === 'parasite' && t.id === 3 && t.title === "On the Way to Rich House") {
            spotifyIcon = `<a href="https://open.spotify.com/track/3HKVmoMyFn3R0tvXV1oSZK" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-spotify" aria-label="Spotify"></i></a>`;
            amazonIcon = `<a href="https://music.amazon.com/albums/B07YVHQ929" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-amazon" aria-label="Amazon Music"></i></a>`;
            appleIcon = `<a href="https://music.apple.com/us/album/parasite-original-motion-picture-soundtrack/1482778417" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-apple" aria-label="Apple Music"></i></a>`;
            youtubeIcon = `<a href="https://www.youtube.com/playlist?list=PLfzW_wEeYxk77oftmx-rKnJJZaxNF466v" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-youtube" aria-label="YouTube Music"></i></a>`;
        }
                                        // Liens streaming pour La La Land piste 4
                                        if (window.currentMovieSlug === 'la-la-land' && t.id === 4) {
                                            spotifyIcon = `<a href=\"https://open.spotify.com/track/4r9hiElqKWMPT4Z3vN2exq\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-spotify" aria-label="Spotify"></i></a>`;
                                            amazonIcon = `<a href=\"https://music.amazon.com/tracks/B07QPK52XM\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-amazon" aria-label="Amazon Music"></i></a>`;
                                            appleIcon = `<a href=\"https://music.apple.com/us/song/a-lovely-night/1440863825\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-apple" aria-label="Apple Music"></i></a>`;
                                            youtubeIcon = `<a href=\"https://www.youtube.com/watch?v=trrH4sVZ0dQ\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-youtube" aria-label="YouTube Music"></i></a>`;
                                        }
                                            // Liens streaming pour La La Land piste 5
                                            if (window.currentMovieSlug === 'la-la-land' && t.id === 5) {
                                                spotifyIcon = `<a href=\"https://open.spotify.com/track/3hJJC9owUiFLe1jGrndHYw\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-spotify" aria-label="Spotify"></i></a>`;
                                                amazonIcon = `<a href=\"https://music.amazon.com/tracks/B073T4N4RZ\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-amazon" aria-label="Amazon Music"></i></a>`;
                                                appleIcon = `<a href=\"https://music.apple.com/us/song/1440864013\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-apple" aria-label="Apple Music"></i></a>`;
                                                youtubeIcon = `<a href=\"https://www.youtube.com/watch?v=1V5l_LbmWlQ\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-youtube" aria-label="YouTube Music"></i></a>`;
                                            }
                                // Liens streaming pour La La Land piste 3
                                if (window.currentMovieSlug === 'la-la-land' && t.id === 3) {
                                    spotifyIcon = `<a href=\"https://open.spotify.com/track/0srCPlgs0vbIG8Q3zdtmOw\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-spotify" aria-label="Spotify"></i></a>`;
                                    amazonIcon = `<a href=\"https://music.amazon.com/tracks/B06X3QKZ5G\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-amazon" aria-label="Amazon Music"></i></a>`;
                                    appleIcon = `<a href=\"https://music.apple.com/us/song/mia-sebastians-theme/1440863816\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-apple" aria-label="Apple Music"></i></a>`;
                                    youtubeIcon = `<a href=\"https://www.youtube.com/watch?v=D3ovuBdbUqk\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-youtube" aria-label="YouTube Music"></i></a>`;
                                }
                        // Liens streaming pour La La Land piste 2
                        if (window.currentMovieSlug === 'la-la-land' && t.id === 2) {
                            spotifyIcon = `<a href=\"https://open.spotify.com/track/2bxo7P09q1qF0fetdjMhXg\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-spotify" aria-label="Spotify"></i></a>`;
                            amazonIcon = `<a href=\"https://music.amazon.com/albums/B01N1EO7WD\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-amazon" aria-label="Amazon Music"></i></a>`;
                            appleIcon = `<a href=\"https://music.apple.com/jp/song/someone-in-the-crowd-from-la-la-land-soundtrack/1440895887\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-apple" aria-label="Apple Music"></i></a>`;
                            youtubeIcon = `<a href=\"https://www.youtube.com/watch?v=-62YbRZqxjs\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-youtube" aria-label="YouTube Music"></i></a>`;
                        }
                // Liens streaming pour La La Land piste 1
                if (window.currentMovieSlug === 'la-la-land' && t.id === 1) {
                    spotifyIcon = `<a href=\"https://open.spotify.com/track/5kRBzRZmZTXVg8okC7SJFZ\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-spotify" aria-label="Spotify"></i></a>`;
                    amazonIcon = `<a href=\"https://music.amazon.com/tracks/B01N1EO7WD\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-amazon" aria-label="Amazon Music"></i></a>`;
                    appleIcon = `<a href=\"https://music.apple.com/fr/song/1440894905\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-apple" aria-label="Apple Music"></i></a>`;
                    youtubeIcon = `<a href=\"https://www.youtube.com/watch?v=CWnYIb2lqpo\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-youtube" aria-label="YouTube Music"></i></a>`;
                }
        if (window.currentMovieSlug === 'inception' && t.id === 1) {
            spotifyIcon = `<a href="https://open.spotify.com/intl-fr/track/7DU7DNVDZouvJ34tPcPxBj" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-spotify" aria-label="Spotify"></i></a>`;
            amazonIcon = `<a href="https://music.amazon.com/albums/B003U9TDII?referrer=https%3A%2F%2Fmusic.amazon.com%2F" target="_blank" rel="noopener" style="color:inherit;"><i class="bi bi-amazon" aria-label="Amazon Music"></i></a>`;
            youtubeIcon = `<a href=\"https://www.youtube.com/watch?v=BC1LcJ7DIS0\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-youtube" aria-label="YouTube Music"></i></a>`;
            appleIcon = `<a href=\"https://music.apple.com/gb/song/half-remembered-dream/380350107\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-apple" aria-label="Apple Music"></i></a>`;
        } else if (window.currentMovieSlug === 'inception' && t.id === 2) {
            spotifyIcon = `<a href=\"https://open.spotify.com/track/1VCBfWtJOGPV3mtGw8mSlW\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-spotify" aria-label="Spotify"></i></a>`;
            amazonIcon = `<a href=\"https://music.amazon.com/tracks/B003U9Q1B0\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-amazon" aria-label="Amazon Music"></i></a>`;
            appleIcon = `<a href=\"https://music.apple.com/us/song/we-built-our-own-world/380350131\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-apple" aria-label="Apple Music"></i></a>`;
            youtubeIcon = `<a href=\"https://www.youtube.com/watch?v=NPGvvfPbW20\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-youtube" aria-label="YouTube Music"></i></a>`;
        } else if (window.currentMovieSlug === 'inception' && t.id === 3) {
            spotifyIcon = `<a href=\"https://open.spotify.com/track/5xKVYMxOHB2XRLCUafFrz6\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-spotify" aria-label="Spotify"></i></a>`;
            amazonIcon = `<a href=\"https://music.amazon.com/tracks/B003U9RQWI\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-amazon" aria-label="Amazon Music"></i></a>`;
            appleIcon = `<a href=\"https://music.apple.com/be/song/380350137\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-apple" aria-label="Apple Music"></i></a>`;
            youtubeIcon = `<a href=\"https://www.youtube.com/watch?v=OzLhXesNkCI\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-youtube" aria-label="YouTube Music"></i></a>`;
        } else if (window.currentMovieSlug === 'inception' && t.id === 4) {
            spotifyIcon = `<a href=\"https://open.spotify.com/track/7G799Mcsbvfn5TSWZ7u7gI\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-spotify" aria-label="Spotify"></i></a>`;
            amazonIcon = `<a href=\"https://music.amazon.com/albums/B003U9TDII\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-amazon" aria-label="Amazon Music"></i></a>`;
            appleIcon = `<a href=\"https://music.apple.com/gb/album/inception-music-from-the-motion-picture/380349905\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-apple" aria-label="Apple Music"></i></a>`;
            youtubeIcon = `<a href=\"https://www.youtube.com/watch?v=ZEpYcwmUkzg\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-youtube" aria-label="YouTube Music"></i></a>`;
        } else if (window.currentMovieSlug === 'inception' && t.id === 5) {
            spotifyIcon = `<a href=\"https://open.spotify.com/track/3maMYEbpgp1ttMONc8Wjyr\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-spotify" aria-label="Spotify"></i></a>`;
            amazonIcon = `<a href=\"https://music.amazon.com/tracks/B003U9TDQK\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-amazon" aria-label="Amazon Music"></i></a>`;
            appleIcon = `<a href=\"https://music.apple.com/us/song/old-souls/380350146\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-apple" aria-label="Apple Music"></i></a>`;
            youtubeIcon = `<a href=\"https://www.youtube.com/watch?v=9V1cO9LFULw\" target=\"_blank\" rel=\"noopener\" style=\"color:inherit;\"><i class=\"bi bi-youtube" aria-label="YouTube Music"></i></a>`;
        }
        tracksTable.innerHTML += `
            <tr data-id="${trackId}">
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
                        ${spotifyIcon}
                        ${amazonIcon}
                        ${youtubeIcon}
                        ${appleIcon}
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
    // Refresh track like state after rendering (movie/series heart logic)
    var ajaxUrl = window.ajaxurl || (window.wp_data && window.wp_data.ajax_url);
    fetch(ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ action: 'get_user_favorites', type: 'tracks' })
    })
    .then(async r => {
        const text = await r.text();
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('Réponse AJAX non JSON:', text);
            throw e;
        }
    })
    .then(data => {
        // Normalize favorite track IDs to string for comparison
        let favoriteTrackIds = [];
        if (data.success && data.data && Array.isArray(data.data.musiques)) {
            favoriteTrackIds = data.data.musiques.map(m => String(typeof m === 'string' ? m : m.id));
        } else if (data.data && data.data.debug_favorites_raw && Array.isArray(data.data.debug_favorites_raw.musiques)) {
            favoriteTrackIds = data.data.debug_favorites_raw.musiques.map(String);
        }
        tracksTable.querySelectorAll('tr').forEach(row => {
            const trackId = String(row.dataset.id);
            const heart = row.querySelector('.track-like');
            if (heart) {
                if (favoriteTrackIds.includes(trackId)) {
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
    })
    .catch(e => {
        console.error('Erreur AJAX favoris pistes:', e);
    });
}

if (tracksTable) {
    renderTracks(TRACKS_STEP);
    // Charger les favoris de l'utilisateur après le rendu des pistes
    setTimeout(refreshTrackLikes, 100);

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

        // Check user login status
        let isUserLoggedIn = false;
        try {
            isUserLoggedIn = !!JSON.parse(document.body.getAttribute('data-user-logged-in'));
        } catch (err) {}
        if (!isUserLoggedIn) {
            window.location.href = '/inscription';
            return;
        }

        const row = target.closest('tr');
        const trackId = row.dataset.id;
        const trackTitle = row.querySelector('.movie-track-title')?.textContent || '';
        const trackArtist = row.querySelector('.movie-track-artist')?.textContent || '';
        const trackDuration = row.querySelector('.col-duration')?.textContent || '';
        const trackCover = row.querySelector('.movie-track-cover')?.src || '';
        // Extraire juste le nom du fichier de l'image
        const coverFileName = trackCover ? trackCover.split('/').pop() : '';

        const liked = target.classList.toggle('liked');
        target.classList.toggle('bi-heart', !liked);
        target.classList.toggle('bi-heart-fill', liked);
        target.setAttribute('aria-pressed', liked ? 'true' : 'false');

        // Favoris pistes : AJAX serveur (catégorie musiques)
        if (liked) {
            // Récupérer le slug de la page depuis l'URL
            const pageSlug = window.location.pathname.split('/').filter(p => p).pop() || 'film';
            // Créer l'ID composite au format slug-trackId
            const compositeId = pageSlug + '-' + trackId;
            const trackData = {
                id: compositeId,
                slug: pageSlug,
                title: trackTitle,
                artist: trackArtist,
                duration: trackDuration,
                cover: coverFileName,
                source: document.querySelector('.movie-header h1')?.textContent || '',
                url: window.location.href
            };
            const form = new URLSearchParams();
            form.append('action', 'add_user_favorite');
            form.append('type', 'musiques');
            form.append('item', JSON.stringify(trackData));
            console.log('[DEBUG add_user_favorite] form:', Object.fromEntries(form));
            fetch(window.ajaxurl || window.wp_data?.ajax_url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: form.toString()
            })
            .then(async r => {
                const text = await r.text();
                try {
                    const json = JSON.parse(text);
                    console.log('[DEBUG add_user_favorite response]', json);
                    return json;
                } catch (e) {
                    console.error('[DEBUG add_user_favorite response NON JSON]', text);
                }
            });
        } else {
            // Récupérer le slug de la page pour créer l'ID composite
            const pageSlug = window.location.pathname.split('/').filter(p => p).pop() || 'film';
            const compositeId = pageSlug + '-' + trackId;
            const form = new URLSearchParams();
            form.append('action', 'remove_user_favorite');
            form.append('type', 'musiques');
            form.append('id', compositeId);
            fetch(window.ajaxurl || window.wp_data?.ajax_url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: form.toString()
            });
        }
    });

}

// Gestion du like du film (coeur sous l'affiche) - version synchronisée avec le compte utilisateur
if (movieLikeBtn) {
    // Vérifier l'état de connexion utilisateur
    let isUserLoggedIn = false;
    try {
        isUserLoggedIn = !!JSON.parse(document.body.getAttribute('data-user-logged-in'));
    } catch (e) {}

    // Désactiver le bouton si déconnecté
    if (!isUserLoggedIn) {
        movieLikeBtn.classList.remove('liked');
        movieLikeBtn.setAttribute('aria-pressed', 'false');
        const icon = movieLikeBtn.querySelector('.svg-heart-shape');
        if (icon) {
            icon.setAttribute('fill', 'none');
            icon.setAttribute('stroke', '#888888');
        }
        movieLikeBtn.disabled = true;
    } else {
        // Charger l'état du like depuis la base (favoris utilisateur)
        var ajaxUrl = window.ajaxurl || (window.wp_data && window.wp_data.ajax_url);
        fetch(ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action: 'get_user_favorites' })
        })
        .then(async r => {
            const text = await r.text();
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Réponse AJAX non JSON:', text);
                throw e;
            }
        })
        .then(data => {
            // DEBUG: Afficher la réponse AJAX et l'ID comparé
            const movieId = movieLikeBtn.dataset.movieId || '';
            console.log('[DEBUG] Favoris films AJAX:', data);
            console.log('[DEBUG] movieId bouton:', movieId);
            if (data.success && data.data && Array.isArray(data.data.films)) {
                // Les IDs dans la DB sont numériques, donc on force la comparaison en string
                const isFavorite = data.data.films.some(film => String(film.id) === String(movieId));
                const path = movieLikeBtn.querySelector('path.svg-heart-shape');
                if (isFavorite) {
                    movieLikeBtn.classList.add('liked');
                    movieLikeBtn.setAttribute('aria-pressed', 'true');
                    if (path) {
                        path.setAttribute('fill', '#700118');
                        path.setAttribute('stroke', '#700118');
                    }
                } else {
                    movieLikeBtn.classList.remove('liked');
                    movieLikeBtn.setAttribute('aria-pressed', 'false');
                    if (path) {
                        path.setAttribute('fill', 'none');
                        path.setAttribute('stroke', '#888888');
                    }
                }
            }
        })
        .catch(e => {
            console.error('Erreur AJAX favoris:', e);
        });

        // Gestion du clic
        movieLikeBtn.addEventListener('click', function () {
            const path = this.querySelector('path.svg-heart-shape');
            const liked = this.classList.toggle('liked');
            this.setAttribute('aria-pressed', liked ? 'true' : 'false');
            if (path) {
                if (liked) {
                    path.setAttribute('fill', '#700118');
                    path.setAttribute('stroke', '#700118');
                } else {
                    path.setAttribute('fill', 'none');
                    path.setAttribute('stroke', '#888888');
                }
            }
            // Ajouter ou retirer des favoris via AJAX
            const movieId = this.dataset.movieId || '';
            const movieTitle = this.dataset.movieTitle || document.querySelector('.movie-header h1')?.textContent || '';
            const movieYear = this.dataset.movieYear || document.querySelector('.movie-sub')?.textContent?.match(/\d{4}/)?.[0] || '';
            let moviePoster = this.dataset.movieImage || document.getElementById('moviePosterImg')?.src || '';
            // Si moviePoster ne commence pas par http, construire l'URL complète
            if (moviePoster && !moviePoster.startsWith('http')) {
                moviePoster = window.themeUrl + '/assets/image/Fiche films/' + moviePoster;
            }
            let ajaxPromise;
            if (liked) {
                // Ajouter aux favoris
                const filmData = {
                    id: movieId,
                    title: movieTitle,
                    year: movieYear,
                    image: moviePoster,
                    url: window.location.href
                };
                const form = new URLSearchParams();
                form.append('action', 'add_user_favorite');
                form.append('type', 'tracks');
                form.append('item', JSON.stringify(filmData));
                ajaxPromise = fetch(ajaxUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: form.toString()
                });
            } else {
                // Retirer des favoris
                const form = new URLSearchParams();
                form.append('action', 'remove_user_favorite');
                form.append('type', 'tracks');
                form.append('id', movieId);
                ajaxPromise = fetch(ajaxUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: form.toString()
                });
            }
            // Après l'AJAX, rafraîchir l'état du bouton depuis la base
            ajaxPromise.then(() => {
                fetch(ajaxUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ action: 'get_user_favorites' })
                })
                .then(async r => {
                    const text = await r.text();
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw e;
                    }
                })
                .then(data => {
                    if (data.success && data.data && Array.isArray(data.data.films)) {
                        const isFavorite = data.data.films.some(film => String(film.id) === String(movieId));
                        if (isFavorite) {
                            movieLikeBtn.classList.add('liked');
                            movieLikeBtn.setAttribute('aria-pressed', 'true');
                            if (path) {
                                path.setAttribute('fill', '#700118');
                                path.setAttribute('stroke', '#700118');
                            }
                        } else {
                            movieLikeBtn.classList.remove('liked');
                            movieLikeBtn.setAttribute('aria-pressed', 'false');
                            if (path) {
                                path.setAttribute('fill', 'none');
                                path.setAttribute('stroke', '#888888');
                            }
                        }
                    }
                });
            });
        });
    }
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
            // Trier les commentaires par nombre de likes décroissant
            data.data.comments.sort((a, b) => (b.like_count || 0) - (a.like_count || 0));
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
        if (diffMins < 1) timeAgo = "à l'instant";
        else if (diffMins < 60) timeAgo = `il y a ${diffMins} min`;
        else if (diffHours < 24) timeAgo = `il y a ${diffHours}h`;
        else if (diffDays < 7) timeAgo = `il y a ${diffDays}j`;
        else timeAgo = date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' });
        dateHtml = `<div class="comment-date">${timeAgo}</div>`;
    }
    // Affiche le vrai nombre de likes
    let initialLikeCount = (typeof commentData.like_count === 'number' && !isNaN(commentData.like_count)) ? commentData.like_count : 0;
        col.innerHTML = `
            <div class="comment-card">
                ${menuHtml}
                <div class="comment-user">
                    <span class="comment-user-avatar-wrapper">
                        ${commentData.avatar ? `<img src="${commentData.avatar}" alt="${commentData.user_name}" class="comment-user-avatar">` : '<i class="bi bi-person comment-user-icon"></i>'}
                    </span>
                    <span class="comment-user-name">${commentData.user_name || ''}</span>
                    ${dateHtml}
                </div>
                <div class="comment-text">${commentData.comment_text}</div>
                <div class="comment-like-row d-flex align-items-center gap-2 mt-2">
                    <button class="comment-like-btn${commentData.liked_by_user ? ' liked' : ''}" aria-label="J'aime ce commentaire" data-comment-id="${commentData.id}">
                        <svg class="svg-thumb-up" viewBox="0 -0.5 21 21" width="22" height="22" style="display:inline-block;vertical-align:middle;">
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Dribbble-Light-Preview" transform="translate(-219.000000, -760.000000)" fill="#000000">
                                    <g id="icons" transform="translate(56.000000, 160.000000)">
                                        <path d="M163,610.021159 L163,618.021159 C163,619.126159 163.93975,620.000159 165.1,620.000159 L167.199999,620.000159 L167.199999,608.000159 L165.1,608.000159 C163.93975,608.000159 163,608.916159 163,610.021159 M183.925446,611.355159 L182.100546,617.890159 C181.800246,619.131159 180.639996,620.000159 179.302297,620.000159 L169.299999,620.000159 L169.299999,608.021159 L171.104948,601.826159 C171.318098,600.509159 172.754498,599.625159 174.209798,600.157159 C175.080247,600.476159 175.599997,601.339159 175.599997,602.228159 L175.599997,607.021159 C175.599997,607.573159 176.070397,608.000159 176.649997,608.000159 L181.127196,608.000159 C182.974146,608.000159 184.340196,609.642159 183.925446,611.355159"/>
                                    </g>
                                </g>
                            </g>
                        </svg>
                                        </button>
                    <span class="like-count" style="color:#000 !important; font-weight:500;">${initialLikeCount}</span>
                </div>
            </div>
        `;
        // Like button logic: toggle .liked and update like count visually, toujours 0 si pas liké
        const likeBtn = col.querySelector('.comment-like-btn');
        const likeCountSpan = col.querySelector('.like-count');
        // Force couleur du pouce dès l'affichage si déjà liké
        if (likeBtn && commentData.liked_by_user) {
            const thumbSvg = likeBtn.querySelector('.svg-thumb-up');
            if (thumbSvg) {
                const thumbPath = thumbSvg.querySelector('path');
                thumbSvg.style.fill = '#700118';
                thumbSvg.style.color = '#700118';
                if (thumbPath) thumbPath.setAttribute('fill', '#700118');
            }
        }
        if (likeBtn && likeCountSpan) {
            likeBtn.addEventListener('click', function () {
                console.log('[DEBUG] Like button clicked for comment', commentData.id);
                // Vérifier connexion utilisateur
                var isUserLoggedIn = false;
                try {
                    isUserLoggedIn = !!JSON.parse(document.body.getAttribute('data-user-logged-in'));
                } catch (e) { console.warn('[DEBUG] Error parsing user login state', e); }
                if (!isUserLoggedIn) {
                    console.log('[DEBUG] User not logged in, redirecting');
                    window.location.href = '/inscription';
                    return;
                }
                const isLiked = likeBtn.classList.toggle('liked');
                let count = parseInt(likeCountSpan.textContent, 10);
                if (isNaN(count)) count = 0;
                // Update counter immediately for instant feedback
                if (isLiked) {
                    likeCountSpan.textContent = count + 1;
                } else {
                    likeCountSpan.textContent = Math.max(0, count - 1);
                }
                // Force SVG thumb color for reliability
                const thumbSvg = likeBtn.querySelector('.svg-thumb-up');
                if (thumbSvg) {
                    // Also update the <path> fill directly
                    const thumbPath = thumbSvg.querySelector('path');
                    if (isLiked) {
                        thumbSvg.style.fill = '#700118';
                        thumbSvg.style.color = '#700118';
                        if (thumbPath) thumbPath.setAttribute('fill', '#700118');
                    } else {
                        thumbSvg.style.fill = '#1A1A1A';
                        thumbSvg.style.color = '#1A1A1A';
                        if (thumbPath) thumbPath.setAttribute('fill', '#1A1A1A');
                    }
                }
                console.log('[DEBUG] isLiked:', isLiked, 'Current count:', count);
                // AJAX pour enregistrer le like/dislike
                if (!window.ajaxurl) {
                    console.error('[DEBUG] window.ajaxurl is not defined!');
                }
                fetch(window.ajaxurl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: isLiked ? 'like_comment' : 'unlike_comment',
                        comment_id: commentData.id
                    })
                })
                .then(r => {
                    console.log('[DEBUG] AJAX response for like:', r);
                    return r.json();
                })
                .then(data => {
                    console.log('[DEBUG] AJAX JSON data:', data);
                    if (data.success) {
                        console.log('[DEBUG] Backend like_count:', data.data.like_count);
                        likeCountSpan.textContent = data.data.like_count;
                    } else {
                        // rollback UI si erreur
                        likeBtn.classList.toggle('liked');
                        if (thumbSvg) {
                            const thumbPath = thumbSvg.querySelector('path');
                            // Rollback thumb color
                            if (isLiked) {
                                thumbSvg.style.fill = '#1A1A1A';
                                thumbSvg.style.color = '#1A1A1A';
                                if (thumbPath) thumbPath.setAttribute('fill', '#1A1A1A');
                            } else {
                                thumbSvg.style.fill = '#700118';
                                thumbSvg.style.color = '#700118';
                                if (thumbPath) thumbPath.setAttribute('fill', '#700118');
                            }
                        }
                        likeCountSpan.textContent = isLiked ? count : Math.max(0, count-1);
                        alert('Erreur lors de la mise à jour du like.');
                    }
                })
                .catch((err) => {
                    console.error('[DEBUG] AJAX error:', err);
                    likeBtn.classList.toggle('liked');
                    if (thumbSvg) {
                        const thumbPath = thumbSvg.querySelector('path');
                        // Rollback thumb color
                        if (isLiked) {
                            thumbSvg.style.fill = '#1A1A1A';
                            thumbSvg.style.color = '#1A1A1A';
                            if (thumbPath) thumbPath.setAttribute('fill', '#1A1A1A');
                        } else {
                            thumbSvg.style.fill = '#700118';
                            thumbSvg.style.color = '#700118';
                            if (thumbPath) thumbPath.setAttribute('fill', '#700118');
                        }
                    }
                    likeCountSpan.textContent = isLiked ? count : Math.max(0, count-1);
                    alert('Erreur réseau lors du like.');
                });
            });
        }
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
const commentInput = document.querySelector('.comment-input');
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

// --- PERSISTENCE DES LIKES DE PISTES (TRACKS) ---
function refreshTrackLikes() {
    if (!tracksTable) return;
    var ajaxUrl = window.ajaxurl || (window.wp_data && window.wp_data.ajax_url);
    fetch(ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ action: 'get_user_favorites' })
    })
    .then(async r => {
        const text = await r.text();
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('Réponse AJAX non JSON:', text);
            throw e;
        }
    })
    .then(data => {
        let favoriteTrackIds = [];
        // On récupère les pistes likées dans la catégorie 'tracks' (pour films ET séries)
        if (data.success && data.data && Array.isArray(data.data.tracks) && data.data.tracks.length > 0) {
            favoriteTrackIds = data.data.tracks.map(m => typeof m === 'string' ? m : m.id);
        } else if (data.data && data.data.debug_favorites_raw && Array.isArray(data.data.debug_favorites_raw.tracks)) {
            favoriteTrackIds = data.data.debug_favorites_raw.tracks;
        }
        tracksTable.querySelectorAll('tr').forEach(row => {
            const trackId = row.dataset.id;
            const heart = row.querySelector('.track-like');
            if (heart) {
                if (favoriteTrackIds.includes(trackId)) {
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
    })
    .catch(e => {
        console.error('Erreur AJAX favoris pistes:', e);
    });
}
// Call refreshTrackLikes after every renderTracks
const originalRenderTracks = renderTracks;
renderTracks = function() {
    originalRenderTracks.apply(this, arguments);
    setTimeout(refreshTrackLikes, 100);
};


// === CARROUSEL : FILMS SIMILAIRES DYNAMIQUE ===
const defaultCover = imagePath + 'Interstellar.jpg';

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
            { title: "Wolf Children", img: imagePath + "wolf children.jpg" },
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
            { title: "Parasite", img: imagePath + "Parasite.jpg" },
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
            { title: "Interstellar", img: imagePath + "Interstellar.jpg" },
            { title: "2001: A Space Odyssey", img: imagePath + "2001 a space odyssey.jpg" },
            { title: "Contact", img: imagePath + "contact.webp" },
            { title: "Ad Astra", img: imagePath + "ad astra.jpg" },
            { title: "Gravity", img: imagePath + "gravity.jpg" }
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
    // Fallback générique (Inception)
    return [
        { title: "Interstellar", img: imagePath + "Interstellar.jpg" },
        { title: "Arrival", img: imagePath + "Arrival.webp" },
        { title: "Shutter Island", img: imagePath + "shutter island affiche similaire.jpg" },
        { title: "Parasite", img: imagePath + "Parasite.jpg" },
        { title: "Gravity", img: imagePath + "gravity.jpg" },
        { title: "The Martian", img: imagePath + "the martian.jpg" },
        { title: "Get Out", img: imagePath + "get out.jpg" },
        { title: "Annihilation", img: imagePath + "annihilation.jpg" },
        { title: "2001: A Space Odyssey", img: imagePath + "2001 a space odyssey.jpg" },
        { title: "Contact", img: imagePath + "contact.webp" },
        { title: "Ad Astra", img: imagePath + "ad astra.jpg" },
        { title: "District 9", img: imagePath + "district 9.jpg" }
    ];
}


// Initialiser le carrousel une fois le DOM chargé
const slug = window.currentMovieSlug || 'inception';
const allSimilarMovies = getSimilarMovies(slug);
    initGenericCarousel({
        containerId: 'similarMovies',
        items: allSimilarMovies,
        getCardHtml: (m) => {
                        if (m.title.toLowerCase() === 'shutter island') {
                            return `
                            <div class="col-6 mb-3 col-md-3">
                                <a href="/film/shutter-island/" class="similar-card-link">
                                    <div class="similar-card">
                                        <img src="${m.img}" alt="${m.title}">
                                        <div class="similar-card-title">${m.title}</div>
                                    </div>
                                </a>
                            </div>
                            `;
                        }
            if (m.title.toLowerCase() === 'interstellar') {
                return `
                <div class="col-6 mb-3 col-md-3">
                    <a href="/film/interstellar/" class="similar-card-link">
                        <div class="similar-card">
                            <img src="${m.img}" alt="${m.title}">
                            <div class="similar-card-title">${m.title}</div>
                        </div>
                    </a>
                </div>
                `;
            }
            if (m.title.toLowerCase() === 'arrival') {
                return `
                <div class="col-6 mb-3 col-md-3">
                    <a href="/film/arrival/" class="similar-card-link">
                        <div class="similar-card">
                            <img src="${m.img}" alt="${m.title}">
                            <div class="similar-card-title">${m.title}</div>
                        </div>
                    </a>
                </div>
                `;
            }
            if (m.title.toLowerCase() === 'parasite') {
                return `
                <div class="col-6 mb-3 col-md-3">
                    <a href="/film/parasite/" class="similar-card-link">
                        <div class="similar-card">
                            <img src="${m.img}" alt="${m.title}">
                            <div class="similar-card-title">${m.title}</div>
                        </div>
                    </a>
                </div>
                `;
            }
            return `
                <div class="col-6 mb-3 col-md-3">
                    <div class="similar-card">
                        <img src="${m.img}" alt="${m.title}">
                        <div class="similar-card-title">${m.title}</div>
                    </div>
                </div>
            `;
        }
    });


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

// Fin DOMContentLoaded
});

// Ajout du refresh et re-render après chaque modification de la liste (ex: afficher plus/moins)
document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'tracksMoreBtn') {
        if (window.movieTracks && Array.isArray(window.movieTracks)) {
            if (typeof renderAllTracksAndRefresh === 'function') {
                renderAllTracksAndRefresh(window.movieTracks);
            }
            setTimeout(() => {
                console.log('refreshTrackLikes called (afficher plus)');
                if (typeof refreshTrackLikes === 'function') {
                    refreshTrackLikes();
                }
            }, 400);
        }
    }
});
