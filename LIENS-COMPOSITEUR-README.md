# 🔗 Liens vers Fiche Compositeur

## Fonctionnalité implémentée

Tous les noms "Hans Zimmer" dans les pistes des films et séries sont maintenant **cliquables** et redirigent vers sa page compositeur.

## 📍 Où trouver les liens ?

### Page Inception (Film)
- URL : `http://votre-site.local/inception`
- Toutes les 10 pistes ont "Hans Zimmer" comme artiste
- Cliquer sur n'importe quel "Hans Zimmer" → Redirige vers `/hans-zimmer`

### Page Stranger Things (Série)
- URL : `http://votre-site.local/stranger-things`
- Si vous ajoutez des pistes de Hans Zimmer, les liens fonctionneront automatiquement

### Autres pages de films/séries
- Le système est **automatique** : tout artiste nommé "Hans Zimmer" sera cliquable

## 🎨 Style des liens

- **Couleur** : Gris (#999) par défaut
- **Hover** : Rouge bordeaux (#700118)
- **Decoration** : Souligné
- **Cursor** : Pointeur (main)

## 🔧 Comment ça marche ?

### JavaScript (logique)
Les fichiers `Fiche-film.js` et `Fiche-serie.js` détectent automatiquement si l'artiste est "Hans Zimmer" :

```javascript
const artistHtml = t.artist === 'Hans Zimmer' 
    ? `<a href="${window.location.origin}/hans-zimmer" class="movie-track-artist">${t.artist}</a>`
    : `<div class="movie-track-artist">${t.artist}</div>`;
```

### CSS (style)
Le fichier `Fiche film.css` contient les styles pour les liens :

```css
a.movie-track-artist {
    color: #999;
    text-decoration: underline;
}

a.movie-track-artist:hover {
    color: rgba(112, 1, 24, 1);
}
```

## 🚀 Pour ajouter d'autres compositeurs

Si vous voulez créer des liens vers d'autres compositeurs :

1. **Créer la page du compositeur** (comme `template-fiche-compositeur.php`)
2. **Modifier le JavaScript** pour détecter le nom :

```javascript
// Exemple pour plusieurs compositeurs
let artistHtml;
if (t.artist === 'Hans Zimmer') {
    artistHtml = `<a href="${window.location.origin}/hans-zimmer" class="movie-track-artist">${t.artist}</a>`;
} else if (t.artist === 'John Williams') {
    artistHtml = `<a href="${window.location.origin}/john-williams" class="movie-track-artist">${t.artist}</a>`;
} else {
    artistHtml = `<div class="movie-track-artist">${t.artist}</div>`;
}
```

Ou utiliser un objet de mapping :

```javascript
const composerLinks = {
    'Hans Zimmer': '/hans-zimmer',
    'John Williams': '/john-williams',
    'Ennio Morricone': '/ennio-morricone'
};

const artistHtml = composerLinks[t.artist]
    ? `<a href="${window.location.origin}${composerLinks[t.artist]}" class="movie-track-artist">${t.artist}</a>`
    : `<div class="movie-track-artist">${t.artist}</div>`;
```

## ✅ Test

1. Ouvrir `http://votre-site.local/inception`
2. Scroller jusqu'à la section "Pistes"
3. Cliquer sur n'importe quel "Hans Zimmer"
4. Vous devriez être redirigé vers `http://votre-site.local/hans-zimmer`

## 📝 Fichiers modifiés

- ✅ `assets/js/Fiche-film.js` - Liens dans les pistes initiales et fonction appendTracks
- ✅ `assets/js/Fiche-serie.js` - Liens dans les pistes de séries
- ✅ `assets/css/Fiche film.css` - Styles pour les liens cliquables
- ✅ `assets/css/Fiche serie.css` - Importe déjà les styles du film

## 🎯 Navigation complète

```
Page Inception → Clic "Hans Zimmer" → Page Hans Zimmer
Page Stranger Things → Clic "Hans Zimmer" (si présent) → Page Hans Zimmer
Toute autre page → Clic "Hans Zimmer" → Page Hans Zimmer
```

Tout est automatique et fonctionne sur WordPress ! 🎉
