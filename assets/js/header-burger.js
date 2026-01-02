// Affiche le menu burger sur mobile et toggle la navigation
(function() {
  document.addEventListener('DOMContentLoaded', function() {
    var burger = document.getElementById('header-burger');
    var nav = document.querySelector('.header-nav');
    if (burger && nav) {
      burger.addEventListener('click', function() {
        nav.classList.toggle('open');
      });
      burger.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          nav.classList.toggle('open');
        }
      });
    }
  });
})();
