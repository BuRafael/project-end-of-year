/**
 * Movies & Series Pages JavaScript
 * Gère les carrousels et interactions
 */

document.addEventListener('DOMContentLoaded', function() {

    // Indicateur visuel/debug pour vérifier l'exécution du JS sur la page Films
    if (document.body && document.body.classList.contains('page-template-template-films')) {
        console.log('[DEBUG] JS carrousel chargé sur la page Films');
        const debugBanner = document.createElement('div');
        debugBanner.textContent = 'JS carrousel actif (page Films)';
        debugBanner.style.position = 'fixed';
        debugBanner.style.top = '0';
        debugBanner.style.left = '0';
        debugBanner.style.zIndex = '9999';
        debugBanner.style.background = '#a0022c';
        debugBanner.style.color = '#fff';
        debugBanner.style.fontWeight = 'bold';
        debugBanner.style.padding = '6px 18px';
        debugBanner.style.fontSize = '1.1rem';
        debugBanner.style.boxShadow = '0 2px 8px #0008';
        document.body.appendChild(debugBanner);
        setTimeout(() => debugBanner.remove(), 4000);
    }

// === CARROUSELS PAR GENRE (nouvelle version harmonisée) ===
const genreList = ['Action', 'Comédie', 'Horreur', 'Romance', 'Science-Fiction'];
const mediaType = document.body.dataset.mediaType || 'film';
// Remplacer par vos données dynamiques si besoin
const genreMovies = {
    'Action': [
        { title: 'Action 1', img: '/assets/image/Fiche films/wicked.jpg' },
        { title: 'Action 2', img: '/assets/image/Fiche films/ne zha 2.jpg' },
        { title: 'Action 3', img: '/assets/image/Fiche films/minecraft - the movie.webp' },
        { title: 'Action 4', img: '/assets/image/Fiche films/mission impossible the final reckoning.webp' },
        { title: 'Action 5', img: '/assets/image/Fiche films/f1 (2025).png' }
    ],
    'Comédie': [
        { title: 'Comédie 1', img: '/assets/image/Fiche films/lilo & stitch (2025).jpeg' },
        { title: 'Comédie 2', img: '/assets/image/Fiche films/the ice tower.jpg' },
        { title: 'Comédie 3', img: '/assets/image/Fiche films/sinners.avif' },
        { title: 'Comédie 4', img: '/assets/image/Fiche films/one battle after another.jpg' },
        { title: 'Comédie 5', img: '/assets/image/Fiche films/the naked gun.webp' }
    ],
    'Horreur': [
        { title: 'Horreur 1', img: '/assets/image/Fiche films/blue moon.jpg' },
        { title: 'Horreur 2', img: '/assets/image/Fiche films/wicked.jpg' },
        { title: 'Horreur 3', img: '/assets/image/Fiche films/ne zha 2.jpg' },
        { title: 'Horreur 4', img: '/assets/image/Fiche films/minecraft - the movie.webp' },
        { title: 'Horreur 5', img: '/assets/image/Fiche films/mission impossible the final reckoning.webp' }
    ],
    'Romance': [
        { title: 'Romance 1', img: '/assets/image/Fiche films/lilo & stitch (2025).jpeg' },
        { title: 'Romance 2', img: '/assets/image/Fiche films/the ice tower.jpg' },
        { title: 'Romance 3', img: '/assets/image/Fiche films/sinners.avif' },
        { title: 'Romance 4', img: '/assets/image/Fiche films/one battle after another.jpg' },
        { title: 'Romance 5', img: '/assets/image/Fiche films/the naked gun.webp' }
    ],
    'Science-Fiction': [
        { title: 'SF 1', img: '/assets/image/Fiche films/blue moon.jpg' },
        { title: 'SF 2', img: '/assets/image/Fiche films/wicked.jpg' },
        { title: 'SF 3', img: '/assets/image/Fiche films/ne zha 2.jpg' },
        { title: 'SF 4', img: '/assets/image/Fiche films/minecraft - the movie.webp' },
        { title: 'SF 5', img: '/assets/image/Fiche films/mission impossible the final reckoning.webp' }
    ]
};

genreList.forEach(genre => {
    const containerId = `carousel-${mediaType}-${genre.toLowerCase().replace(/-/g, '')}`;
    const items = genreMovies[genre] || [];
    if (!document.getElementById(containerId)) return;
    initGenericCarousel({
        containerId,
        items,
        getCardHtml: (item) => `
            <div class="col-6 col-md-3">
                <div class="similar-card">
                    <img src="${item.img}" alt="${item.title}" />
                    <div class="similar-card-title">${item.title}</div>
                </div>
            </div>
        `,
        itemsPerPage: 4,
        leftArrowSelector: `#${containerId}`.replace('carousel-', '.movie-section .carousel-arrow.left'),
        rightArrowSelector: `#${containerId}`.replace('carousel-', '.movie-section .carousel-arrow.right')
    });
});

// === RECHERCHE AUTOCOMPLETE ===
const searchInput = document.querySelector('.header-search input');
if (searchInput) {
    let searchDropdown = null;
    
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Supprimer le dropdown précédent
        if (searchDropdown) {
            searchDropdown.remove();
        }
        
        if (query.length < 2) return;
        
        // Créer le dropdown
        searchDropdown = document.createElement('div');
        searchDropdown.className = 'search-dropdown';
        
        // Récupérer les résultats
        fetch(`/wp-admin/admin-ajax.php?action=search_movies&q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(results => {
                if (results.length === 0) {
                    searchDropdown.innerHTML = '<div class="search-result-empty">Aucun résultat</div>';
                } else {
                    results.forEach(movie => {
                        const resultItem = document.createElement('div');
                        resultItem.className = 'search-result-item';
                        resultItem.innerHTML = `
                            <div class="search-result-title">${movie.title}</div>
                            <div class="search-result-meta">${movie.type} • ${movie.genre}</div>
                        `;
                        resultItem.addEventListener('click', () => {
                            // Naviger vers la page du film/série
                            window.location.href = `/film/${movie.id}/`;
                        });
                        searchDropdown.appendChild(resultItem);
                    });
                }
                
                const searchForm = document.querySelector('.header-search');
                searchForm.appendChild(searchDropdown);
            })
            .catch(err => console.error('Erreur recherche:', err));
    });
    
    // Fermer le dropdown au clic externe
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.header-search') && searchDropdown) {
            searchDropdown.remove();
            searchDropdown = null;
        }
    });
}

});
