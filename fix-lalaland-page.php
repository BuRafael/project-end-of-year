<?php
/**
 * Script pour forcer la recréation de la page La La Land
 * Accédez à ce fichier via : http://votre-site.local/wp-content/themes/project-end-of-year/fix-lalaland-page.php
 */

// Charger WordPress
require_once('../../../../../wp-load.php');

// Vérifier si la page existe déjà
$existing_page = get_page_by_path('la-la-land');

if ($existing_page) {
    echo "<h2>Page La La Land trouvée (ID: {$existing_page->ID})</h2>";
    
    // Supprimer définitivement l'ancienne page
    $deleted = wp_delete_post($existing_page->ID, true);
    
    if ($deleted) {
        echo "<p style='color: green;'>✓ Ancienne page supprimée avec succès</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Impossible de supprimer l'ancienne page, tentative de mise à jour...</p>";
    }
}

// Créer ou recréer la page
$page_data = array(
    'post_title'    => 'La La Land',
    'post_name'     => 'la-la-land',
    'post_status'   => 'publish',
    'post_type'     => 'page',
    'post_content'  => '', // Le contenu sera géré par le template
);

$page_id = wp_insert_post($page_data);

if ($page_id && !is_wp_error($page_id)) {
    echo "<h2 style='color: green;'>✓ Page La La Land créée avec succès !</h2>";
    echo "<p>ID de la page : {$page_id}</p>";
    echo "<p>Slug : la-la-land</p>";
    echo "<p>Template : page-la-la-land.php (automatique)</p>";
    
    // Afficher le lien vers la page
    $page_url = get_permalink($page_id);
    echo "<p><a href='{$page_url}' target='_blank' style='background: #0073aa; color: white; padding: 10px 20px; text-decoration: none; border-radius: 3px; display: inline-block; margin-top: 10px;'>→ Voir la page La La Land</a></p>";
    
    echo "<hr>";
    echo "<p><strong>La page est prête !</strong> Le template page-la-la-land.php sera utilisé automatiquement.</p>";
    
} else {
    echo "<h2 style='color: red;'>✗ Erreur lors de la création de la page</h2>";
    if (is_wp_error($page_id)) {
        echo "<p>Message d'erreur : " . $page_id->get_error_message() . "</p>";
    }
}

echo "<hr>";
echo "<p><a href='/wp-admin/edit.php?post_type=page'>← Retour aux pages WordPress</a></p>";
?>