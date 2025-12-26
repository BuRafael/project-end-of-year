// Carrousel séries : active le scroll horizontal sur les carrousels de la page séries

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.movies-carousel').forEach(function(carousel) {
        const leftArrow = carousel.querySelector('.carousel-arrow.left');
        const rightArrow = carousel.querySelector('.carousel-arrow.right');
        const row = carousel.querySelector('.row');
        if (!leftArrow || !rightArrow || !row) return;
        let card = row.querySelector('.col-6, .col-md-3, .col-12');
        let cardWidth = card ? card.offsetWidth : 250;
        let gap = 24;
        let scrollAmount = cardWidth + gap;
        leftArrow.addEventListener('click', function() {
            row.scrollBy({ left: -(scrollAmount), behavior: 'smooth' });
        });
        rightArrow.addEventListener('click', function() {
            row.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });
    });
});
