// Mobile search toggle
document.addEventListener('DOMContentLoaded', function() {
    const searchBtn = document.querySelector('.header-search-mobile');
    const searchForm = document.getElementById('header-search-form');
    const searchBg = document.getElementById('header-search-mobile-bg');
    const header = document.querySelector('.site-header');
    const closeBtn = document.querySelector('.header-close-search');
    function closeMobileSearch() {
        if (searchForm) searchForm.classList.remove('header-search-mobile-active');
        if (searchBg) searchBg.classList.remove('active');
        if (header) header.classList.remove('header-search-open');
        if (closeBtn) closeBtn.style.display = 'none';
    }
    if (searchBtn && searchForm && searchBg && header && closeBtn) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            searchForm.classList.add('header-search-mobile-active');
            searchBg.classList.add('active');
            header.classList.add('header-search-open');
            closeBtn.style.display = 'flex';
            const input = searchForm.querySelector('input[type="search"]');
            if (input) input.focus();
        });
        searchBg.addEventListener('click', closeMobileSearch);
        closeBtn.addEventListener('click', closeMobileSearch);
    }
});
// Header JavaScript
document.addEventListener('DOMContentLoaded', function() {
    var burger = document.getElementById('header-burger');
    var nav = document.querySelector('.header-nav');
    var overlay = document.getElementById('menu-overlay');
    var header = document.querySelector('.site-header');
    function closeMenu() {
        nav.classList.remove('open');
        if (overlay) overlay.classList.remove('active');
        if (header) header.classList.remove('header-menu-open');
    }
    if (burger && nav && overlay && header) {
        burger.addEventListener('click', function() {
            var isOpen = nav.classList.toggle('open');
            if (isOpen) {
                overlay.classList.add('active');
                header.classList.add('header-menu-open');
            } else {
                overlay.classList.remove('active');
                header.classList.remove('header-menu-open');
            }
        });
        overlay.addEventListener('click', closeMenu);
        window.addEventListener('resize', closeMenu);
        // Accessibilité : ouvrir/fermer avec Entrée ou Espace
        burger.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                var isOpen = nav.classList.toggle('open');
                if (isOpen) {
                    overlay.classList.add('active');
                    header.classList.add('header-menu-open');
                } else {
                    overlay.classList.remove('active');
                    header.classList.remove('header-menu-open');
                }
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('.site-header');

    const handleHeaderShadow = () => {
        if (!header) return;
        if (window.scrollY > 10) {
            header.classList.add('is-scrolled');
        } else {
            header.classList.remove('is-scrolled');
        }
    };

    handleHeaderShadow();
    window.addEventListener('scroll', handleHeaderShadow, { passive: true });
});
