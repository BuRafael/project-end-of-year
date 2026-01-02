// Mobile search toggle
document.addEventListener('DOMContentLoaded', function() {
    const searchBtn = document.querySelector('.header-search-mobile');
    const searchForm = document.getElementById('header-search-form');
    const searchBg = document.getElementById('header-search-mobile-bg');
    function closeMobileSearch() {
        if (searchForm) searchForm.classList.remove('header-search-mobile-active');
        if (searchBg) searchBg.classList.remove('active');
    }
    if (searchBtn && searchForm && searchBg) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            searchForm.classList.add('header-search-mobile-active');
            searchBg.classList.add('active');
            const input = searchForm.querySelector('input[type="search"]');
            if (input) input.focus();
        });
        searchBg.addEventListener('click', closeMobileSearch);
    }
});
// Header JavaScript
document.addEventListener('DOMContentLoaded', function() {
    var burger = document.getElementById('header-burger');
    var nav = document.querySelector('.header-nav');
    var overlay = document.getElementById('menu-overlay');
    function closeMenu() {
        nav.classList.remove('open');
        if (overlay) overlay.classList.remove('active');
    }
    if (burger && nav && overlay) {
        burger.addEventListener('click', function() {
            var isOpen = nav.classList.toggle('open');
            if (isOpen) {
                overlay.classList.add('active');
            } else {
                overlay.classList.remove('active');
            }
        });
        overlay.addEventListener('click', closeMenu);
        // Optionally close menu on resize/orientationchange
        window.addEventListener('resize', closeMenu);
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
