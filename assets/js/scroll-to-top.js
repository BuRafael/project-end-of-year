// Bouton pour remonter en haut de page
(function() {
  const btn = document.createElement('button');
  btn.className = 'scroll-to-top';
  btn.innerHTML = '<i class="bi bi-chevron-up"></i>';
  btn.style.display = 'none';
  document.body.appendChild(btn);

  window.addEventListener('scroll', function() {
    btn.style.display = window.scrollY > 200 ? 'flex' : 'none';
  });

  btn.addEventListener('click', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
})();
