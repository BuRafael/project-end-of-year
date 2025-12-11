/**
 * Fiche Compositeur JavaScript
 * Gère les pistes, commentaires, filmographie et interactions
 */

document.addEventListener('DOMContentLoaded', function() {

// === PISTES CELEBRES ===
const tracks = [
    { id: 1, title: "Time", film: "Inception", duration: "4:35", image: "inception affiche film.jpg" },
    { id: 2, title: "Now We Are Free", film: "Gladiator", duration: "4:15", image: "Hans Zimmer.jpg" },
    { id: 3, title: "Cornfield Chase", film: "Interstellar", duration: "2:06", image: "interstellar affiche similaire.jpg" },
    { id: 4, title: "Why So Serious?", film: "The Dark Knight", duration: "9:14", image: "Dark city.jpg" },
    { id: 5, title: "No Time for Caution", film: "Interstellar", duration: "4:06", image: "interstellar affiche similaire.jpg" },
    { id: 6, title: "He's a Pirate", film: "Pirates of the Caribbean", duration: "3:38", image: "Hans Zimmer.jpg" },
    { id: 7, title: "Mountains", film: "Interstellar", duration: "3:39", image: "interstellar affiche similaire.jpg" },
    { id: 8, title: "Dream Is Collapsing", film: "Inception", duration: "2:28", image: "inception affiche film.jpg" },
    { id: 9, title: "Tennessee", film: "Pearl Harbor", duration: "4:04", image: "Hans Zimmer.jpg" },
    { id: 10, title: "Earth", film: "Gladiator", duration: "3:54", image: "Hans Zimmer.jpg" }
];

const tracksTable = document.getElementById("tracksTable");
const imagePath = typeof composerImagePath !== 'undefined' ? composerImagePath : 'assets/image/Fiche Compositeur/';
const filmImagePath = imagePath.replace('Fiche Compositeur', 'Fiche films');

if (tracksTable) {
    // Afficher les 5 premières pistes
    const initialTracks = tracks.slice(0, 5);
    initialTracks.forEach(t => {
        appendTrack(t);
    });

    // Bouton "Afficher plus"
    const tracksMoreBtn = document.getElementById('tracksMoreBtn');
    let showingAll = false;
    
    if (tracksMoreBtn) {
        tracksMoreBtn.addEventListener('click', function() {
            if (!showingAll) {
                // Afficher toutes les pistes restantes
                const remainingTracks = tracks.slice(5);
                remainingTracks.forEach(t => {
                    appendTrack(t);
                });
                this.textContent = 'Afficher moins…';
                showingAll = true;
            } else {
                // Masquer les pistes supplémentaires
                const rows = tracksTable.querySelectorAll('tr');
                for (let i = rows.length - 1; i >= 5; i--) {
                    rows[i].remove();
                }
                this.textContent = 'Afficher plus…';
                showingAll = false;
            }
        });
    }

    // Like/unlike tracks (event delegation)
    tracksTable.addEventListener('click', function (e) {
        const target = e.target;
        if (!target.classList.contains('track-like')) return;
        const liked = target.classList.toggle('liked');
        target.classList.toggle('bi-heart', !liked);
        target.classList.toggle('bi-heart-fill', liked);
        target.setAttribute('aria-pressed', liked ? 'true' : 'false');
    });
}

function appendTrack(track) {
    if (!tracksTable) return;
    
    const tr = document.createElement('tr');
    const trackImage = track.image.includes('Hans Zimmer') ? imagePath + track.image : filmImagePath + track.image;
    
    tr.innerHTML = `
        <td>${track.id}</td>
        <td>
            <div class="composer-track-info">
                <img src="${trackImage}" class="composer-track-cover" alt="${track.title}">
                <div>
                    <div class="composer-track-title">${track.title}</div>
                    <div class="composer-track-film">${track.film}</div>
                </div>
            </div>
        </td>
        <td class="col-links">
            <span class="track-icons">
                <i class="bi bi-spotify" aria-label="Spotify"></i>
                <i class="bi bi-amazon" aria-label="Amazon Music"></i>
                <i class="bi bi-youtube" aria-label="YouTube Music"></i>
                <i class="bi bi-apple" aria-label="Apple Music"></i>
            </span>
        </td>
        <td class="col-duration text-center">${track.duration}</td>
        <td class="col-like text-end">
            <i class="bi bi-heart track-like"></i>
        </td>
    `;
    tracksTable.appendChild(tr);
}

// === COMMENTAIRES ===
const commentsZone = document.getElementById("commentsZone");
const commentInput = document.querySelector('.comment-input');

// Vérifier que composerComments est défini
if (typeof composerComments === 'undefined') {
    console.log('composerComments n\'est pas défini - mode démo');
    
    // Mode démo avec commentaires statiques
    const demoComments = [
        { user: "Sophie Martin", text: "Hans Zimmer est un génie absolu ! Ses compositions donnent vie aux films.", time: "il y a 2h" },
        { user: "Lucas Bernard", text: "Time d'Inception me donne des frissons à chaque écoute. Chef-d'œuvre !", time: "il y a 5h" },
        { user: "Emma Dubois", text: "La BO d'Interstellar est probablement la plus belle chose que j'ai jamais entendue.", time: "il y a 1j" }
    ];
    
    if (commentsZone) {
        commentsZone.innerHTML = '';
        demoComments.forEach(c => {
            const col = document.createElement('div');
            col.className = 'col-12 col-md-3';
            col.innerHTML = `
                <div class="comment-card">
                    <div class="comment-user">
                        <i class="bi bi-person comment-user-icon"></i>
                        <span class="comment-user-name">${c.user}</span>
                    </div>
                    <div class="comment-date">${c.time}</div>
                    <div class="comment-text">${c.text}</div>
                </div>
            `;
            commentsZone.appendChild(col);
        });
    }
} else {
    // Mode avec base de données
    // Charger les commentaires existants
    function loadComments() {
        if (!commentsZone) return;
        
        fetch(composerComments.ajax_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'get_composer_comments',
                composer_id: composerComments.composer_id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data.comments.length > 0) {
                commentsZone.innerHTML = '';
                data.data.comments.forEach(c => {
                    renderComment(c);
                });
            } else {
                commentsZone.innerHTML = '<div class="col-12"><p class="text-center" style="color: rgba(244, 239, 236, 1); font-style: italic; opacity: 0.7;">C\'est silencieux ici...</p></div>';
            }
        });
    }

    // Afficher un commentaire
    function renderComment(commentData) {
        const col = document.createElement('div');
        col.className = 'col-12 col-md-3';
        col.dataset.commentId = commentData.id;
        
        const menuHtml = commentData.is_author ? `
            <div class="comment-menu">
                <button class="comment-menu-btn" aria-label="Options">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <div class="comment-menu-dropdown">
                    <button class="comment-edit-btn">Modifier</button>
                    <button class="comment-delete-btn">Supprimer</button>
                </div>
            </div>
        ` : '';
        
        let dateHtml = '';
        if (commentData.created_at) {
            const date = new Date(commentData.created_at);
            const now = new Date();
            const diffMs = now - date;
            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMs / 3600000);
            const diffDays = Math.floor(diffMs / 86400000);
            
            let timeAgo;
            if (diffMins < 1) timeAgo = 'à l\'instant';
            else if (diffMins < 60) timeAgo = `il y a ${diffMins} min`;
            else if (diffHours < 24) timeAgo = `il y a ${diffHours}h`;
            else if (diffDays < 7) timeAgo = `il y a ${diffDays}j`;
            else timeAgo = date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' });
            
            dateHtml = `<div class="comment-date">${timeAgo}</div>`;
        }
        
        col.innerHTML = `
            <div class="comment-card">
                ${menuHtml}
                <div class="comment-user">
                    ${commentData.avatar ? `<img src="${commentData.avatar}" alt="${commentData.user_name}" class="comment-user-avatar">` : '<i class="bi bi-person comment-user-icon"></i>'}
                    <span class="comment-user-name">${commentData.user_name}</span>
                </div>
                ${dateHtml}
                <div class="comment-text">${commentData.comment_text}</div>
            </div>
        `;
        
        commentsZone.insertBefore(col, commentsZone.firstChild);
        
        if (commentData.is_author) {
            const menuBtn = col.querySelector('.comment-menu-btn');
            const menuDropdown = col.querySelector('.comment-menu-dropdown');
            
            menuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                menuDropdown.classList.toggle('show');
            });
            
            col.querySelector('.comment-edit-btn').addEventListener('click', () => {
                const textEl = col.querySelector('.comment-text');
                const currentText = textEl.textContent;
                textEl.innerHTML = `<input type="text" class="comment-edit-input" value="${currentText}">`;
                const input = textEl.querySelector('.comment-edit-input');
                input.focus();
                
                input.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        editComment(commentData.id, input.value, textEl);
                    }
                });
                
                menuDropdown.classList.remove('show');
            });
            
            col.querySelector('.comment-delete-btn').addEventListener('click', () => {
                if (confirm('Supprimer ce commentaire ?')) {
                    deleteComment(commentData.id, col);
                }
            });
        }
    }

    // Publier un commentaire
    if (commentInput && !commentInput.disabled) {
        commentInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && this.value.trim()) {
                const commentText = this.value.trim();
                
                fetch(composerComments.ajax_url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'add_composer_comment',
                        nonce: composerComments.nonce,
                        composer_id: composerComments.composer_id,
                        comment_text: commentText
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const emptyMsg = commentsZone.querySelector('.text-center');
                        if (emptyMsg) {
                            emptyMsg.parentElement.remove();
                        }
                        
                        renderComment({
                            id: data.data.comment_id,
                            user_name: data.data.user_name,
                            avatar: data.data.avatar,
                            comment_text: data.data.comment_text,
                            is_author: true,
                            created_at: data.data.created_at
                        });
                        
                        this.value = '';
                    }
                });
            }
        });
    }

    // Modifier un commentaire
    function editComment(commentId, newText, textElement) {
        fetch(composerComments.ajax_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'edit_composer_comment',
                nonce: composerComments.nonce,
                comment_id: commentId,
                comment_text: newText
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                textElement.textContent = newText;
            }
        });
    }

    // Supprimer un commentaire
    function deleteComment(commentId, element) {
        fetch(composerComments.ajax_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'delete_composer_comment',
                nonce: composerComments.nonce,
                comment_id: commentId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                element.remove();
                
                if (commentsZone.children.length === 0) {
                    commentsZone.innerHTML = '<div class="col-12"><p class="text-center" style="color: rgba(244, 239, 236, 1); font-style: italic; opacity: 0.7;">C\'est silencieux ici...</p></div>';
                }
            }
        });
    }

    loadComments();
}

// === CARROUSEL : COMPOSITEURS SIMILAIRES ===
const similarComposers = document.getElementById("similarComposers");

if (similarComposers) {
    const composers = [
        { name: "John Williams", specialty: "Star Wars, Indiana Jones", image: "John Williams.jpg" },
        { name: "Ennio Morricone", specialty: "The Good, the Bad and the Ugly", image: "Ennio Morricone.jpg" },
        { name: "Howard Shore", specialty: "The Lord of the Rings", image: "Howard Shore.jpg" },
        { name: "Danny Elfman", specialty: "Batman, Edward Scissorhands", image: "Danny Elfman.jpg" },
        { name: "Alexandre Desplat", specialty: "The Grand Budapest Hotel", image: "Alexandre Desplat.jpg" },
        { name: "Michael Giacchino", specialty: "Up, Star Trek", image: "Michael Giacchino.jpg" },
        { name: "Thomas Newman", specialty: "American Beauty, Skyfall", image: "Thomas Newman.jpg" },
        { name: "Ludwig Göransson", specialty: "Black Panther, Tenet", image: "Ludwig Goransson.jpg" }
    ];

    let currentIndex = 0;

    function renderComposers() {
        if (!similarComposers) return;
        
        similarComposers.innerHTML = '';
        const visibleComposers = composers.slice(currentIndex, currentIndex + 4);
        
        visibleComposers.forEach(composer => {
            const col = document.createElement('div');
            col.className = 'col-3';
            col.innerHTML = `
                <div class="similar-composer-card">
                    <img src="${imagePath}${composer.image}" alt="${composer.name}" onerror="this.src='${imagePath}Hans Zimmer.jpg'">
                    <div class="similar-composer-overlay">
                        <div class="similar-composer-name">${composer.name}</div>
                        <div class="similar-composer-specialty">${composer.specialty}</div>
                    </div>
                </div>
            `;
            similarComposers.appendChild(col);
        });
    }

    renderComposers();

    // Flèches de navigation
    const arrows = document.querySelectorAll('.carousel-arrow');
    if (arrows.length >= 2) {
        arrows[0].addEventListener('click', () => {
            currentIndex = Math.max(0, currentIndex - 1);
            renderComposers();
        });

        arrows[1].addEventListener('click', () => {
            currentIndex = Math.min(composers.length - 4, currentIndex + 1);
            renderComposers();
        });
    }
}

}); // Fin DOMContentLoaded
