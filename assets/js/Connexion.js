// Connexion Page JavaScript

document.addEventListener('DOMContentLoaded', () => {
    // Password visibility toggle
    const toggleButtons = document.querySelectorAll('[data-toggle-password]');
    toggleButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            // Debug : log pour vérifier l'exécution
            console.log('Bouton oeil cliqué');
            const inputId = btn.getAttribute('data-toggle-password');
            const input = document.getElementById(inputId);
            if (!input) {
                console.warn('Champ mot de passe non trouvé pour id', inputId);
                return;
            }
            console.log('Champ trouvé, type avant:', input.type);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            console.log('Type après:', input.type);
            btn.classList.toggle('is-active', isHidden);
            // Switch icon
            let icon = btn.querySelector('.toggle-icon img');
            // Si l'icône a disparu, on la recrée
            if (!icon) {
                const span = btn.querySelector('.toggle-icon');
                icon = document.createElement('img');
                // Utilise le chemin du thème WordPress (injecté dans la page PHP)
                let themeBase = window.themeBasePath || '';
                if (!themeBase) {
                    // Fallback : tente de le déduire depuis l'URL de la page
                    const scripts = document.querySelectorAll('script');
                    for (let s of scripts) {
                        if (s.src && s.src.includes('/assets/js/Connexion.js')) {
                            themeBase = s.src.split('/assets/js/Connexion.js')[0];
                            break;
                        }
                    }
                }
                icon.src = themeBase + '/assets/image/Icones et Logo/eye.svg';
                icon.alt = 'Afficher le mot de passe';
                icon.style.width = '22px';
                icon.style.height = '22px';
                icon.style.verticalAlign = 'middle';
                icon.style.filter = 'invert(0)';
                span.appendChild(icon);
            }
            // Met à jour l'icône selon l'état
            let themeBase = window.themeBasePath || '';
            if (!themeBase) {
                // Fallback : tente de le déduire depuis l'URL de l'icône
                themeBase = icon.src.split('/assets/image/Icones et Logo/')[0];
            }
            if (isHidden) {
                icon.src = themeBase + '/assets/image/Icones et Logo/eye off.svg';
                icon.alt = 'Masquer le mot de passe';
            } else {
                icon.src = themeBase + '/assets/image/Icones et Logo/eye.svg';
                icon.alt = 'Afficher le mot de passe';
            }
        });
    });
});
