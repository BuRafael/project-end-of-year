<?php
/**
 * API pour créer les pages WordPress
 */

// Charger WordPress
define('WP_USE_THEMES', false);
require_once(__DIR__ . '/../../../../wp-load.php');

header('Content-Type: application/json');

$pages = array(
    // Films
    array('title' => 'La La Land', 'slug' => 'la-la-land', 'template' => 'template-fiche-film.php'),
    array('title' => 'Parasite', 'slug' => 'parasite', 'template' => 'template-fiche-film.php'),
    array('title' => 'Interstellar', 'slug' => 'interstellar', 'template' => 'template-fiche-film.php'),
    array('title' => 'Spider-Man', 'slug' => 'spider-man', 'template' => 'template-fiche-film.php'),
    array('title' => 'Wicked', 'slug' => 'wicked', 'template' => 'template-fiche-film.php'),
    
    // Séries
    array('title' => 'Stranger Things', 'slug' => 'stranger-things', 'template' => 'template-fiche-serie.php'),
    array('title' => 'Breaking Bad', 'slug' => 'breaking-bad', 'template' => 'template-fiche-serie.php'),
    array('title' => 'Euphoria', 'slug' => 'euphoria', 'template' => 'template-fiche-serie.php'),
    array('title' => 'Wednesday', 'slug' => 'wednesday', 'template' => 'template-fiche-serie.php'),
    array('title' => 'The Witcher', 'slug' => 'the-witcher', 'template' => 'template-fiche-serie.php'),
    
    // Animés
    array('title' => 'Your Name', 'slug' => 'your-name', 'template' => 'template-fiche-film.php'),
    array('title' => 'Le Voyage de Chihiro', 'slug' => 'chihiro', 'template' => 'template-fiche-film.php'),
    array('title' => 'L\'Attaque des Titans', 'slug' => 'attaque-des-titans', 'template' => 'template-fiche-film.php'),
    array('title' => 'Demon Slayer', 'slug' => 'demon-slayer', 'template' => 'template-fiche-film.php'),
    array('title' => 'Jujutsu Kaisen', 'slug' => 'jujutsu-kaisen', 'template' => 'template-fiche-film.php')
);

$results = array();

foreach ($pages as $page) {
    $exists = get_page_by_path($page['slug']);
    
    if (!$exists) {
        $id = wp_insert_post(array(
            'post_title' => $page['title'],
            'post_name' => $page['slug'],
            'post_status' => 'publish',
            'post_type' => 'page',
            'comment_status' => 'closed',
            'ping_status' => 'closed'
        ));
        
        if ($id) {
            update_post_meta($id, '_wp_page_template', $page['template']);
            $results[] = array(
                'success' => true,
                'message' => '✓ Créé: ' . $page['title'] . ' (ID: ' . $id . ')'
            );
        } else {
            $results[] = array(
                'success' => false,
                'message' => '✗ Erreur lors de la création de: ' . $page['title']
            );
        }
    } else {
        update_post_meta($exists->ID, '_wp_page_template', $page['template']);
        $results[] = array(
            'success' => true,
            'message' => '→ Existe déjà: ' . $page['title'] . ' (template mis à jour)'
        );
    }
}

echo json_encode($results);
?>
