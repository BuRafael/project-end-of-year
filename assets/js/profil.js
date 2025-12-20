// Profil Page JavaScript

document.addEventListener('DOMContentLoaded', () => {
    // Gestion du changement de photo de profil
    const changeAvatarBtn = document.getElementById('changeAvatarBtn');
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarDefault = document.getElementById('avatarDefault');
    
    if (changeAvatarBtn && avatarInput) {
        // Quand on clique sur le bouton, ouvrir l'explorateur de fichiers
        changeAvatarBtn.addEventListener('click', function() {
            avatarInput.click();
        });
        
        // Quand un fichier est sélectionné, afficher la preview
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                // Vérifier la taille du fichier (max 5MB)
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (this.files[0].size > maxSize) {
                    console.warn('Le fichier est trop volumineux. Taille maximale: 5MB');
                    this.value = '';
                    return;
                }
                
                // Afficher la preview de l'image
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (avatarPreview) {
                        avatarPreview.src = e.target.result;
                        avatarPreview.style.display = 'block';
                        
                        // Masquer le SVG par défaut si présent
                        if (avatarDefault) {
                            avatarDefault.style.display = 'none';
                        }
                    }
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
