/**
 * Movies & Series Pages JavaScript
 * Gère les carrousels et interactions
 */

document.addEventListener('DOMContentLoaded', function() {

// === CARROUSELS ===
const carousels = document.querySelectorAll('.movies-carousel');

carousels.forEach(carousel => {
    const track = carousel.querySelector('.carousel-track');
    const leftBtn = carousel.querySelector('.carousel-arrow.left');
    const rightBtn = carousel.querySelector('.carousel-arrow.right');
    
    let currentIndex = 0;
    
    function updateCarousel() {
        const cardWidth = track.querySelector('.carousel-card') ? track.querySelector('.carousel-card').offsetWidth : 200;
        const gap = 16;
        const offset = -(currentIndex * (cardWidth + gap));
        track.style.transform = `translateX(${offset}px)`;
    }

    function animateCarousel(delta) {
        const viewport = carousel.querySelector('.carousel-viewport');
        const cardCount = track.querySelectorAll('.carousel-card').length;
        const cardsPerView = Math.max(1, Math.floor((viewport ? viewport.offsetWidth : 0) / 220));
        const maxIndex = Math.max(0, cardCount - cardsPerView);

        const nextIndex = Math.min(Math.max(currentIndex + delta, 0), maxIndex);
        if (nextIndex === currentIndex) return;

        track.classList.add('is-transitioning');
        setTimeout(() => {
            currentIndex = nextIndex;
            updateCarousel();
            track.classList.remove('is-transitioning');
        }, 140);
    }

    if (leftBtn) {
        leftBtn.addEventListener('click', () => animateCarousel(-1));
    }
    
    if (rightBtn) {
        rightBtn.addEventListener('click', () => animateCarousel(1));
    }
    
    // Mettre à jour au redimensionnement
    window.addEventListener('resize', updateCarousel);
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
