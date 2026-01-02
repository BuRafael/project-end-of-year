/**
 * Favoris Page JavaScript
 * Gère l'affichage et les interactions de la page favoris
 */


document.addEventListener('DOMContentLoaded', function() {
                        // Bloquer tout comportement par défaut sur les clics dans le <main> Favoris
                        var mainFavoris = document.querySelector('main.favoris-page');
                        if (mainFavoris) {
                            mainFavoris.addEventListener('click', function(e) {
                                e.preventDefault();
                            }, true);
                        }
                    // Log tous les clics pour traquer l'élément déclencheur
                    document.addEventListener('click', function(e) {
                        console.log('[FAVORIS DEBUG] Clic sur:', e.target, 'type:', e.target.type, 'class:', e.target.className, 'parent:', e.target.parentElement?.className);
                    }, true);
                // Bloquer tout submit sur la page et logger l'origine
                document.addEventListener('submit', function(e) {
                    console.warn('[FAVORIS DEBUG] Submit bloqué !', e.target);
                    e.preventDefault();
                    return false;
                }, true);
            // Bloquer tout submit de formulaire sur la page Favoris (sécurité anti bug)
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    return false;
                });
            });
        // Déterminer l'URL AJAX WordPress (fallback si besoin)
        // Correction : si ajaxUrl est un objet (ex: {url: ...}), on prend la propriété url
        var ajaxUrl = window.ajaxurl;
        if (ajaxUrl && typeof ajaxUrl === 'object' && ajaxUrl.url) {
            ajaxUrl = ajaxUrl.url;
        }
        if (!ajaxUrl || typeof ajaxUrl !== 'string') {
            ajaxUrl = '/wp-admin/admin-ajax.php';
        }
        console.log('[FAVORIS DEBUG] ajaxUrl utilisé:', ajaxUrl);
    // Contrôle PHP pour savoir si l'utilisateur est connecté
    var isUserLoggedIn = false;
    try {
        isUserLoggedIn = !!JSON.parse(document.body.getAttribute('data-user-logged-in'));
    } catch (e) {}
    // Si l'utilisateur n'est pas connecté, ne rien afficher côté JS
    if (!isUserLoggedIn) {
        // Optionnel : vider les grilles si jamais du JS s'exécute
        var grids = ['filmsGrid', 'seriesGrid', 'musiquesList'];
        grids.forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.innerHTML = '';
        });
        return;
    }

    // Récupération des éléments
    const tabs = document.querySelectorAll('.favoris-tab');
    const contents = document.querySelectorAll('.favoris-content');
    
    const filmsGrid = document.getElementById('filmsGrid');
    const seriesGrid = document.getElementById('seriesGrid');
    const musiquesList = document.getElementById('musiquesList');
    
    const filmsEmpty = document.getElementById('filmsEmpty');
    const seriesEmpty = document.getElementById('seriesEmpty');
    const musiquesEmpty = document.getElementById('musiquesEmpty');

    // Gestion des tabs
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Retirer la classe active de tous les tabs
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
            
            // Ajouter la classe active au tab cliqué
            this.classList.add('active');
            document.getElementById(targetTab + 'Content').classList.add('active');
        });
    });


    // Charger les favoris depuis la base de données WordPress (AJAX)
    function loadFavorites(callback) {
        fetch(ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=get_user_favorites'
        })
        .then(async r => {
            const text = await r.text();
            try {
                const data = JSON.parse(text);
                console.log('[FAVORIS DEBUG] Réponse AJAX:', data);
                if (data.success && data.data) {
                    callback(data.data);
                } else {
                    callback({ films: [], series: [], musiques: [] });
                }
            } catch (e) {
                console.error('[FAVORIS DEBUG] Erreur JSON:', e, '\nRéponse brute:', text);
                callback({ films: [], series: [], musiques: [] });
            }
        })
        .catch((e) => { console.error('[FAVORIS DEBUG] Erreur AJAX:', e); callback({ films: [], series: [], musiques: [] }); });
    }

    // Afficher les films favoris
    function renderFilms(films) {
        if (!filmsGrid || !filmsEmpty) return;
        
        if (films.length === 0) {
            filmsGrid.style.display = 'none';
            filmsEmpty.style.display = 'flex';
            return;
        }

        filmsGrid.style.display = 'grid';
        filmsEmpty.style.display = 'none';
        
        const defaultPoster = '/wp-content/themes/project-end-of-year/assets/image/Films/default-poster.jpg';
        filmsGrid.innerHTML = films.map(film => `
            <div class="favoris-card" data-id="${film.id}">
                <button type="button" class="favoris-remove" data-type="film" data-id="${film.id}" aria-label="Retirer des favoris">
                    <i class="bi bi-x-lg"></i>
                </button>
                <a href="${film.url}" class="favoris-card-link">
                    <div class="favoris-card-image">
                        <img src="${film.image ? film.image : defaultPoster}" alt="${film.title}">
                    </div>
                    <div class="favoris-card-content">
                        <h3 class="favoris-card-title">${film.title}</h3>
                    </div>
                </a>
            </div>
        `).join('');

        attachRemoveListeners();
    }

    // Afficher les séries favorites
    function renderSeries(series) {
        if (!seriesGrid || !seriesEmpty) return;
        
        if (series.length === 0) {
            seriesGrid.style.display = 'none';
            seriesEmpty.style.display = 'flex';
            return;
        }

        seriesGrid.style.display = 'grid';
        seriesEmpty.style.display = 'none';
        
        const defaultPoster = '/wp-content/themes/project-end-of-year/assets/image/Films/default-poster.jpg';
        seriesGrid.innerHTML = series.map(serie => `
            <div class="favoris-card" data-id="${serie.id}">
                <button type="button" class="favoris-remove" data-type="serie" data-id="${serie.id}" aria-label="Retirer des favoris">
                    <i class="bi bi-x-lg"></i>
                </button>
                <a href="${serie.url}" class="favoris-card-link">
                    <div class="favoris-card-image">
                        <img src="${serie.image ? serie.image : defaultPoster}" alt="${serie.title}">
                    </div>
                    <div class="favoris-card-content">
                        <h3 class="favoris-card-title">${serie.title}</h3>
                    </div>
                </a>
            </div>
        `).join('');

        attachRemoveListeners();
    }

    // Afficher les musiques favorites
    function renderMusiques(musiques) {
        if (!musiquesList || !musiquesEmpty) return;
        
        if (musiques.length === 0) {
            musiquesList.style.display = 'none';
            musiquesEmpty.style.display = 'flex';
            return;
        }

        musiquesList.style.display = 'block';
        musiquesEmpty.style.display = 'none';
        
        musiquesList.innerHTML = musiques.map((track, index) => `
            <div class="favoris-track" data-id="${track.id}">
                <div class="favoris-track-number">${index + 1}</div>
                <div class="favoris-track-info">
                    <img src="${track.cover}" alt="${track.title}" class="favoris-track-cover">
                    <div class="favoris-track-details">
                        <div class="favoris-track-title">${track.title}</div>
                        <div class="favoris-track-artist">${track.artist || 'Artiste inconnu'}</div>
                    </div>
                </div>
                <div class="favoris-track-source">${track.source || ''}</div>
                <div class="favoris-track-duration">${track.duration || ''}</div>
                <button type="button" class="favoris-remove-track" data-type="musique" data-id="${track.id}" aria-label="Retirer des favoris">
                    <i class="bi bi-heart-fill"></i>
                </button>
            </div>
        `).join('');

        attachRemoveListeners();
    }

    // Attacher les événements de suppression
    function attachRemoveListeners() {
        document.querySelectorAll('.favoris-remove, .favoris-remove-track').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const type = this.dataset.type;
                const id = this.dataset.id;
                
                removeFavorite(type, id);
            });
        });
    }

    // Supprimer un favori

    function removeFavorite(type, id) {
        let wpType = '';
        if (type === 'film') wpType = 'films';
        else if (type === 'serie') wpType = 'series';
        else if (type === 'musique') wpType = 'musiques';
        if (!wpType) return;
        const form = new URLSearchParams();
        form.append('action', 'remove_user_favorite');
        form.append('type', wpType);
        form.append('id', id);
        fetch(ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: form.toString()
        })
        .then(() => init());
    }


    // Ajouter un favori (à appeler dans ton code d'ajout)
    window.addFavorite = function(type, item) {
        let wpType = '';
        if (type === 'film') wpType = 'films';
        else if (type === 'serie') wpType = 'series';
        else if (type === 'musique') wpType = 'musiques';
        if (!wpType) return;
        const form = new URLSearchParams();
        form.append('action', 'add_user_favorite');
        form.append('type', wpType);
        form.append('item', JSON.stringify(item));
        fetch(ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: form.toString()
        })
        .then(() => init());
    }

    // Initialiser l'affichage
    function init() {
        loadFavorites(function(favorites) {
            renderFilms(favorites.films);
            renderSeries(favorites.series);
            renderMusiques(favorites.musiques);
        });
    }

    // Lancer l'initialisation
    init();

});
