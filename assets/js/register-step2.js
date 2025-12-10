// Register Step 2 JavaScript

document.addEventListener('DOMContentLoaded', () => {
    // Avatar preview
    const avatarInput = document.getElementById('avatar_file');
    if (avatarInput) {
        avatarInput.addEventListener('change', (e) => {
            const file = e.target.files && e.target.files[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            
            const avatarCircle = document.querySelector('.avatar-circle');
            if (!avatarCircle) return;
            
            // Vérifier si une image existe déjà
            const existingImg = avatarCircle.querySelector('img');
            if (existingImg) {
                // Remplacer l'image existante
                existingImg.src = url;
            } else {
                // Créer une nouvelle image et remplacer le contenu
                const img = document.createElement('img');
                img.src = url;
                img.alt = 'Aperçu';
                img.id = 'avatarPreviewImg';
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                
                avatarCircle.innerHTML = '';
                avatarCircle.appendChild(img);
            }
        });
    }

    // Ripple effect on buttons (but not on upload button to avoid sizing issues)
    const rippleTargets = document.querySelectorAll('.btn-ghost');
    rippleTargets.forEach((el) => {
        el.style.position = el.style.position || 'relative';
        el.style.overflow = 'hidden';

        el.addEventListener('pointerdown', (e) => {
            const rect = el.getBoundingClientRect();
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            el.appendChild(ripple);
            setTimeout(() => ripple.remove(), 450);
        });
    });
});
